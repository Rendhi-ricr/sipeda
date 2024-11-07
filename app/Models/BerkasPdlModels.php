<?php

namespace App\Models;

use CodeIgniter\Model;

class BerkasPdlModels extends Model
{
    protected $table = 't_berkas_pdl';
    protected $primaryKey = 'id_berkas_pdl';
    protected $allowedFields = ['id_pdl', 'file', 'jenis'];

    // Ambil semua berkas berdasarkan ID PDL
    public function getBerkasByPdl($id_pdl)
    {
        return $this->where('id_pdl', $id_pdl)->findAll();
    }

    // Ambil satu berkas berdasarkan jenis
    public function getBerkasByJenis($id_pdl, $jenis)
    {
        return $this->where(['id_pdl' => $id_pdl, 'jenis' => $jenis])->first();
    }

    // Update data berkas
    public function updateBerkas($id_berkas_pdl, $data)
    {
        return $this->update($id_berkas_pdl, $data); // pastikan $data adalah array
    }

    // Ambil surat berdasarkan ID PDL dan jenisnya
    public function getSuratByPdl($id_pdl)
    {
        return $this->where('id_pdl', $id_pdl)
            ->where('jenis', 'Surat')
            ->first();
    }
}
