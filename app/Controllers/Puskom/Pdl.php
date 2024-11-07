<?php

namespace App\Controllers\Puskom;

use App\Controllers\BaseController;
use App\Models\BerkasPdlModels;
use App\Models\PdlModels;

// use App\Models\JenisPengajuanPdlModels;

class Pdl extends BaseController {
    protected $pdl, $bpm;
    public function __construct() {
        $this->pdl = new PdlModels();
        $this->bpm = new BerkasPdlModels();
    }

    public function index() {
        // Cek role pengguna dari session atau autentikasi
        $userRole = session()->get('level'); // Asumsikan role disimpan di sesi saat login

        // Ambil data berdasarkan role
        if ($userRole == 'puskom') {
            // Ambil semua data dari getPdmWithBerkas dan filter dengan status 'Verifikasi Berkas'
            $allPdl = $this->pdl->getPdlWithBerkasAndJenis();
            $data['pdl'] = array_filter($allPdl, function ($item) {
                // Menggunakan notasi objek
                $statusFilter = ['Verifikasi Berkas', 'Verifikasi Pimpinan', 'Proses Pengajuan Dikti'];
                return in_array($item->status_pengajuan, $statusFilter);
            });
        } else {
            // Untuk role lain, ambil semua data
            $data['pdl'] = $this->pdl->getPdlWithBerkasAndJenis();
        }

        return view('puskom/pdl/index', $data);
    }

    public function detail($id_pdl) {
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
                'bpm' => $berkas, // Berkas sudah diurutkan
                'jenis' => $jenis,
            ];

            return view('puskom/pdl/berkas', $data);
        } else {
            return redirect()->to('/puskom/pdl')->with('error', 'Transaksi tidak ditemukan.');
        }
    }

    public function acc($id_pdl) {
        // Ambil data pdl berdasarkan ID
        $pdl = $this->pdl->data_pdl($id_pdl);

        if ($pdl && $pdl['status_pengajuan'] == 'Verifikasi Berkas') {
            // Ubah status menjadi Verifikasi Berkas dan set terakhir_update
            $data = [
                'status_pengajuan' => 'Verifikasi Pimpinan',
                'terakhir_update' => date('Y-m-d H:i:s'), // Set waktu sekarang
                'keterangan' => 'Pengajuan Telah Di Acc Oleh Puskom', // Set waktu sekarang
            ];

            // Update data
            $this->pdl->update_data($data, $id_pdl);

            // Berikan pesan sukses
            session()->setFlashdata('message', 'Pengajuan berhasil dikirim untuk verifikasi berkas.');
        } else {
            session()->setFlashdata('error', 'Pengajuan tidak dapat diproses.');
        }

        return redirect()->to('/puskom/pdl');
    }

    public function tolak($id_pdl) {
        // Ambil data pdl berdasarkan ID
        $pdl = $this->pdl->data_pdl($id_pdl);

        // Pastikan data PDM ada dan status pengajuan masih di tahap yang tepat (misal: Verifikasi Berkas)
        if ($pdl && $pdl['status_pengajuan'] == 'Verifikasi Berkas') {
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
            $this->pdl->update_data($data, $id_pdl);

            // Berikan pesan sukses
            session()->setFlashdata('message', 'Pengajuan berhasil ditolak.');
        } else {
            // Jika data tidak ditemukan atau status tidak sesuai
            session()->setFlashdata('error', 'Pengajuan tidak dapat diproses.');
        }

        return redirect()->to('/puskom/pdl');
    }

    public function download() {
        $pdl_ids = $this->request->getPost('pdl_ids');

        foreach ($pdl_ids as $id_pdl) {
            // Ambil data PDM berdasarkan ID
            $data_pdl = $this->pdl->where('id_pdl', $id_pdl)->first();

            // Only add files if the status is 'Proses Pengajuan Dikti'
            if ($data_pdl['status_pengajuan'] == 'Proses Pengajuan Dikti') {

                // Get files associated with each id_pdl
                $files = $this->bpm->where('id_pdl', $id_pdl)->where('jenis', 'Ijazah dan Transkrip')->first();

                // Check if file exists
                if (file_exists(WRITEPATH . 'uploads/pdl/' . $files['file'])) {
                    // Download file
                    return $this->response->download(WRITEPATH . 'uploads/pdl/' . $files['file'], null)->setFileName($files['file']);
                } else {
                    // Log error if file not found
                    log_message('error', 'File not found: ' . WRITEPATH . 'uploads/pdl/' . $files['file']);
                }

            }
        }
        // set header for nothing to download
        return redirect()->to('/puskom/pdl');
    }
}