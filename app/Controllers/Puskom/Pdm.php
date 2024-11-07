<?php

namespace App\Controllers\Puskom;

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
        if ($userRole == 'puskom') {
            // Ambil semua data dari getPdmWithBerkas dan filter dengan status 'Verifikasi Berkas'
            $allPdm = $this->pdmModel->getPdmWithBerkasAndJenis();
            $data['pdm'] = array_filter($allPdm, function ($item) {
                // Menggunakan notasi objek
                $statusFilter = ['Verifikasi Berkas', 'Verifikasi Pimpinan', 'Proses Pengajuan Dikti'];
                return in_array($item->status_pengajuan, $statusFilter);
            });
        } else {
            // Untuk role lain, ambil semua data
            $data['pdm'] = $this->pdmModel->getPdmWithBerkasAndJenis();
        }

        return view('puskom/pdm/index', $data);
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

            return view('puskom/pdm/berkas', $data);
        } else {
            return redirect()->to('/puskom/pdm')->with('error', 'Transaksi tidak ditemukan.');
        }
    }

    public function acc($id_pdm) {
        // Ambil data PDM berdasarkan ID
        $pdm = $this->pdmModel->data_pdm($id_pdm);

        if ($pdm && $pdm['status_pengajuan'] == 'Verifikasi Berkas') {
            // Ubah status menjadi Verifikasi Berkas dan set terakhir_update
            $data = [
                'status_pengajuan' => 'Verifikasi Pimpinan',
                'terakhir_update' => date('Y-m-d H:i:s'), // Set waktu sekarang
                'keterangan' => 'Pengajuan Telah Di Acc Oleh Puskom', // Set waktu sekarang
            ];

            // Update data
            $this->pdmModel->update_data($data, $id_pdm);

            // Berikan pesan sukses
            session()->setFlashdata('message', 'Pengajuan berhasil dikirim untuk verifikasi berkas.');
        } else {
            session()->setFlashdata('error', 'Pengajuan tidak dapat diproses.');
        }

        return redirect()->to('/puskom/pdm');
    }

    public function tolak($id_pdm) {
        // Ambil data PDM berdasarkan ID
        $pdm = $this->pdmModel->data_pdm($id_pdm);

        // Pastikan data PDM ada dan status pengajuan masih di tahap yang tepat (misal: Verifikasi Berkas)
        if ($pdm && $pdm['status_pengajuan'] == 'Verifikasi Berkas') {
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

        return redirect()->to('/puskom/pdm');
    }

    public function downloadMultiple() {
        $pdm_ids = $this->request->getPost('pdm_ids');

        foreach ($pdm_ids as $id_pdm) {
            // Ambil data PDM berdasarkan ID
            $data_pdm = $this->pdmModel->where('id_pdm', $id_pdm)->first();

            // Only add files if the status is 'Proses Pengajuan Dikti'
            if ($data_pdm['status_pengajuan'] == 'Proses Pengajuan Dikti') {

                // Create a ZIP file for each selected ID
                $zip = new \ZipArchive();
                $zipFileName = 'berkas_pdm_' . time() . '.zip';
                $zipFilePath = WRITEPATH . 'uploads/pdm/' . $zipFileName;

                if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
                    session()->setFlashdata('error', 'Gagal membuat file ZIP.');
                    return redirect()->to('/puskom/pdm');
                }

                // Get files associated with each id_pdm
                $files = $this->bpm->where('id_pdm', $id_pdm)->findAll();

                foreach ($files as $file) {
                    $filePath = WRITEPATH . 'uploads/pdm/' . $file['file'];
                    if (file_exists($filePath)) {
                        $zip->addFile($filePath, basename($filePath));
                    } else {
                        log_message('error', 'File not found: ' . $filePath);
                    }
                }
                $zip->close();
                // Set header untuk download file ZIP
                return $this->response->download($zipFilePath, null)->setFileName($zipFileName);
            }
        }
        // set header for nothing to download
        return redirect()->to('/puskom/pdm');

    }
}