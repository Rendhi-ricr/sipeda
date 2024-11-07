<?php

namespace App\Controllers\Pimpinan\Pdl;

use App\Controllers\BaseController;
use App\Models\PdlModels;
use App\Models\BerkasPdlModels;
use App\Models\JenisPengajuanPdlModels;

class Pddsk extends BaseController
{
    protected $pdl, $bpm, $jppm;
    public function __construct()
    {
        $this->pdl = new PdlModels();
        $this->bpm = new BerkasPdlModels();
        $this->jppm = new JenisPengajuanPdlModels();
    }

    public function index()
    {
        // Cek role pengguna dari session atau autentikasi
        $userRole = session()->get('level'); // Asumsikan role disimpan di sesi saat login

        // Ambil data berdasarkan role
        if ($userRole == 'pimpinan') {
            // Ambil semua data dari getPdmWithBerkas dan filter dengan status 'Verifikasi Berkas'
            $allPdl = $this->pdl->getPdlWithBerkasAndJenis();
            $data['pdl'] = array_filter($allPdl, function ($item) {
                // Menggunakan notasi objek
                $statusFilter = ['Verifikasi Pimpinan', 'Proses Pengajuan Dikti'];
                return in_array($item->status_pengajuan, $statusFilter);
            });
        } else {
            // Untuk role lain, ambil semua data
            $data['pdl'] = $this->pdl->getPdlWithBerkasAndJenis();
        }

        return view('pimpinan/pdl/pddsk/index', $data);
    }

    public function detail($id_pdl)
    {
        $pdl = $this->pdl->getPdlWithBerkas($id_pdl);
        $berkas = $this->bpm->getBerkasByPdl($id_pdl);
        $jenis = $this->pdl->getPdlWithBerkasAndJenis($id_pdl);

        if ($pdl) {
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
                'pdl' => $pdl,
                'bpm' => $berkas,  // Berkas sudah diurutkan
                'jenis' => $jenis
            ];

            return view('pimpinan/pdl/pddsk/berkas', $data);
        } else {
            return redirect()->to('/pimpinan/pdl/pddsk')->with('error', 'Transaksi tidak ditemukan.');
        }
    }

    public function acc_pimpinan($id_pdl)
    {
        // Ambil data PDL berdasarkan ID
        $pdl = $this->pdl->data_pdl($id_pdl);

        if ($pdl && $pdl['status_pengajuan'] == 'Verifikasi Pimpinan') {
            // Ambil surat lama dan cek keberadaannya
            $surat = $this->bpm->getSuratByPdl($id_pdl);
            if ($surat) {
                $oldFilePath = WRITEPATH . 'uploads/pdl/pddsk/' . $surat['file'];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath); // Hapus file lama jika ada
                }
            }

            // Path gambar cap dan tanda tangan
            $capPath = FCPATH . 'uploads/kop_surat/kop.png';
            $ttdPath = FCPATH . 'uploads/kop_surat/ttd.png';

            // Pastikan file cap dan tanda tangan ada
            if (!file_exists($capPath) || !file_exists($ttdPath)) {
                session()->setFlashdata('error', 'File cap atau tanda tangan tidak ditemukan.');
                return redirect()->to('/pimpinan/pdl/pddsk');
            }

            // Konversi gambar ke Base64
            $capType = pathinfo($capPath, PATHINFO_EXTENSION);
            $ttdType = pathinfo($ttdPath, PATHINFO_EXTENSION);

            $capImage = file_get_contents($capPath);
            $ttdImage = file_get_contents($ttdPath);

            $base64Cap = 'data:image/' . $capType . ';base64,' . base64_encode($capImage);
            $base64Ttd = 'data:image/' . $ttdType . ';base64,' . base64_encode($ttdImage);

            // Kirimkan base64 cap dan ttd ke view
            $data['kop'] = $base64Cap;
            $data['ttd'] = $base64Ttd;
            $data['srt'] = $this->pdl->getJenisByPdl($id_pdl);

            // Load the view as a string
            $html = view('pimpinan/pdl/pddsk/surat_jadi', $data);

            // Generate PDF (misalnya dengan Dompdf)
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Buat nama file untuk surat yang sudah di-ACC
            $pdfFileName = 'pdl_' . $pdl['npm'] . '_Surat_' . time() . '.pdf';

            // Simpan PDF baru ke folder
            $pdfPath = WRITEPATH . 'uploads/pdl/pddsk/' . $pdfFileName;
            file_put_contents($pdfPath, $dompdf->output());

            // Update referensi surat PDF di database dengan surat yang sudah di-ACC
            $this->bpm->updateBerkas($surat['id_berkas_pdl'], [
                'file' => $pdfFileName,
                'jenis' => 'Surat'
            ]);

            // Update status pengajuan ke 'Proses Pengajuan Dikti' dan set terakhir_update
            $updateData = [
                'status_pengajuan' => 'Proses Pengajuan Dikti',
                'terakhir_update' => date('Y-m-d H:i:s'),
                'keterangan' => 'Pengajuan Telah Di Acc Oleh Pimpinan dan Akan diajukan Ke DIKTI'
            ];

            // Update data PDL
            $this->pdl->update_data($updateData, $id_pdl);

            // Berikan pesan sukses
            session()->setFlashdata('message', 'Pengajuan telah disetujui, surat telah digenerate ulang dengan cap dan tanda tangan.');
        } else {
            session()->setFlashdata('error', 'Pengajuan tidak dapat diproses.');
        }

        return redirect()->to('/pimpinan/pdl/pddsk');
    }



    public function tolakPimpinan($id_pdl)
    {
        // Ambil data pdl berdasarkan ID
        $pdl = $this->pdl->data_pdl($id_pdl);

        // Pastikan data PDM ada dan status pengajuan masih di tahap yang tepat (misal: Verifikasi Berkas)
        if ($pdl && $pdl['status_pengajuan'] == 'Verifikasi Pimpinan') {
            // Ambil keterangan penolakan dari form
            $keterangan = $this->request->getPost('keterangan');

            // Validasi bahwa keterangan penolakan tidak kosong
            if (!$this->validate([
                'keterangan' => 'required'
            ])) {
                // Jika validasi gagal, kembalikan halaman dengan error
                session()->setFlashdata('error', 'Keterangan penolakan wajib diisi.');
                return redirect()->back()->withInput();
            }

            // Siapkan data yang akan diupdate
            $data = [
                'status_pengajuan' => 'Ditolak', // Ubah status menjadi Ditolak
                'terakhir_update' => date('Y-m-d H:i:s'), // Set waktu sekarang
                'keterangan' => $keterangan // Simpan keterangan penolakan
            ];

            // Update data
            $this->pdl->update_data($data, $id_pdl);

            // Berikan pesan sukses
            session()->setFlashdata('message', 'Pengajuan berhasil ditolak.');
        } else {
            // Jika data tidak ditemukan atau status tidak sesuai
            session()->setFlashdata('error', 'Pengajuan tidak dapat diproses.');
        }

        return redirect()->to('/pimpinan/pdl/pddsk');
    }
}
