<?php

namespace App\Controllers\Pimpinan;

use App\Controllers\BaseController;
use App\Models\BerkasPdmModels;
use App\Models\PdmModels;

class Pdm extends BaseController {
    protected $pdmModel, $bpm;
    public function __construct() {
        $this->pdmModel = new PdmModels();
        $this->bpm = new BerkasPdmModels();
    }

    public function index() {
        // Cek role pengguna dari session atau autentikasi
        $userRole = session()->get('level'); // Asumsikan role disimpan di sesi saat login

        // Ambil data berdasarkan role
        if ($userRole == 'pimpinan') {
            // Ambil semua data dari getPdmWithBerkas dan filter dengan status 'Verifikasi Berkas'
            $allPdm = $this->pdmModel->getPdmWithBerkasAndJenis();
            $data['pdm'] = array_filter($allPdm, function ($item) {
                // Menggunakan notasi objek
                $statusFilter = ['Verifikasi Pimpinan', 'Proses Pengajuan Dikti'];
                return in_array($item->status_pengajuan, $statusFilter);
            });
        } else {
            // Untuk role lain, ambil semua data
            $data['pdm'] = $this->pdmModel->getPdmWithBerkasAndJenis();
        }

        return view('pimpinan/pdm/index', $data);
    }

    public function detail($id_pdm) {
        $pdm = $this->pdmModel->getPdmWithBerkas($id_pdm);
        $berkas = $this->bpm->getBerkasByPdm($id_pdm);
        $jenis = $this->pdmModel->getPdmWithBerkasAndJenis($id_pdm);

        if ($pdm) {
            // Jenis surat yang ingin ditampilkan di awal
            $jenisSuratDiAwal = 'Surat';

            // Mengurutkan array berkas agar jenis surat yang diinginkan muncul di awal
            usort($berkas, function ($a, $b) use ($jenisSuratDiAwal) {
                if ($a['jenis'] === $jenisSuratDiAwal) {
                    return -1;
                } elseif ($b['jenis'] === $jenisSuratDiAwal) {
                    return 1;
                }
                return 0;
            });

            $data = [
                'title' => 'Lihat Berkas',
                'pdm' => $pdm,
                'bpm' => $berkas, // Berkas sudah diurutkan
                'jenis' => $jenis,
            ];

            return view('pimpinan/pdm/berkas', $data);
        } else {
            return redirect()->to('/pimpinan/pdm')->with('error', 'Transaksi tidak ditemukan.');
        }
    }

    public function acc_pimpinan($id_pdm) {
        $pdm = $this->pdmModel->data_pdm($id_pdm);

        if ($pdm && $pdm['status_pengajuan'] == 'Verifikasi Pimpinan') {
            $surat = $this->bpm->getSuratByPdm($id_pdm);
            if ($surat) {
                $oldFilePath = WRITEPATH . 'uploads/pdm/' . $surat['file'];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $capPath = FCPATH . 'uploads/kop_surat/kop.png';
            $ttdPath = FCPATH . 'uploads/kop_surat/ttd.png';

            if (!file_exists($capPath) || !file_exists($ttdPath)) {
                session()->setFlashdata('error', 'File cap atau tanda tangan tidak ditemukan.');
                return redirect()->to('/pimpinan/pdm');
            }

            $capType = pathinfo($capPath, PATHINFO_EXTENSION);
            $ttdType = pathinfo($ttdPath, PATHINFO_EXTENSION);
            $base64Cap = 'data:image/' . $capType . ';base64,' . base64_encode(file_get_contents($capPath));
            $base64Ttd = 'data:image/' . $ttdType . ';base64,' . base64_encode(file_get_contents($ttdPath));

            $data = [
                'kop' => $base64Cap,
                'ttd' => $base64Ttd,
                'srt' => $this->pdmModel->getJenisByPdm($id_pdm),
            ];

            $html = view('pimpinan/pdm/surat_jadi', $data);

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $pdfFileName = 'pdm_' . $pdm['npm'] . '_Surat_' . time() . '.pdf';
            $pdfPath = WRITEPATH . 'uploads/pdm/' . $pdfFileName;
            file_put_contents($pdfPath, $dompdf->output());

            $this->bpm->updateBerkas($surat['id_berkas_pdm'], ['file' => $pdfFileName, 'jenis' => 'Surat']);
            $this->pdmModel->update_data([
                'status_pengajuan' => 'Proses Pengajuan Dikti',
                'terakhir_update' => date('Y-m-d H:i:s'),
                'keterangan' => 'Pengajuan Telah Di Acc Oleh Pimpinan dan Akan diajukan Ke DIKTI',
            ], $id_pdm);

            session()->setFlashdata('message', 'Pengajuan telah disetujui, surat telah digenerate ulang dengan cap dan tanda tangan.');
        } else {
            session()->setFlashdata('error', 'Pengajuan tidak dapat diproses.');
        }

        return redirect()->to('/pimpinan/pdm');
    }

    public function tolakPimpinan($id_pdm) {
        // Ambil data PDM berdasarkan ID
        $pdm = $this->pdmModel->data_pdm($id_pdm);

        // Pastikan data PDM ada dan status pengajuan masih di tahap yang tepat (misal: Verifikasi Berkas)
        if ($pdm && $pdm['status_pengajuan'] == 'Verifikasi Pimpinan') {
            // Ambil keterangan penolakan dari form
            $keterangan = $this->request->getPost('keterangan');

            // Validasi bahwa keterangan penolakan tidak kosong
            if (!$this->validate([
                'keterangan' => 'required',
            ])) {
                // Jika validasi gagal, kembalikan halaman dengan error
                session()->setFlashdata('error', 'Keterangan penolakan wajib diisi.');
                return redirect()->back()->withInput();
            }

            // Siapkan data yang akan diupdate
            $data = [
                'status_pengajuan' => 'Ditolak', // Ubah status menjadi Ditolak
                'terakhir_update' => date('Y-m-d H:i:s'), // Set waktu sekarang
                'keterangan' => $keterangan, // Simpan keterangan penolakan
            ];

            // Update data
            $this->pdmModel->update_data($data, $id_pdm);

            // Berikan pesan sukses
            session()->setFlashdata('message', 'Pengajuan berhasil ditolak.');
        } else {
            // Jika data tidak ditemukan atau status tidak sesuai
            session()->setFlashdata('error', 'Pengajuan tidak dapat diproses.');
        }

        return redirect()->to('/pimpinan/pdm');
    }
}