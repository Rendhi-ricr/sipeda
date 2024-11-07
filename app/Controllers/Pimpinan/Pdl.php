<?php

namespace App\Controllers\Pimpinan;

use App\Controllers\BaseController;
use App\Models\PdlModels;
use App\Models\BerkasPdlModels;

class Pdm extends BaseController
{
    protected $pdl, $bpm;
    public function __construct()
    {
        $this->pdl = new PdlModels();
        $this->bpm = new BerkasPdlModels();
    }

    public function index()
    {
        // Cek role pengguna dari session atau autentikasi
        $userRole = session()->get('level'); // Asumsikan role disimpan di sesi saat login

        // Ambil data berdasarkan role
        if ($userRole == 'pimpinan') {
            // Ambil semua data dari getPdmWithBerkas dan filter dengan status 'Verifikasi Berkas'
            $allPdm = $this->pdmModel->getPdmWithBerkasAndJenis();
            $data['pdl'] = array_filter($allPdm, function ($item) {
                // Menggunakan notasi objek
                $statusFilter = ['Verifikasi Pimpinan', 'Proses Pengajuan Dikti'];
                return in_array($item->status_pengajuan, $statusFilter);
            });
        } else {
            // Untuk role lain, ambil semua data
            $data['pdl'] = $this->pdmModel->getPdmWithBerkasAndJenis();
        }

        return view('pimpinan/pdl/index', $data);
    }
}
