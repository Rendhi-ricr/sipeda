<?php

namespace App\Models;

use CodeIgniter\Model;

class BerkasPdmModels extends Model
{
    protected $table = 't_berkas_pdm';
    protected $primaryKey = 'id_berkas_pdm';
    protected $allowedFields = ['id_pdm', 'file', 'jenis', 'status'];

    public function getBerkasByPdm($id_pdm)
    {
        return $this->where('id_pdm', $id_pdm)->findAll();
    }

    public function getBerkasByJenis($id_pdm, $jenis)
    {
        return $this->where(['id_pdm' => $id_pdm, 'jenis' => $jenis])->first();
    }

    public function updateBerkas($id_berkas_pdm, $data)
    {
        return $this->update($id_berkas_pdm, $data); // pastikan $data adalah array
    }

    public function getSuratByPdm($id_pdm)
    {
        return $this->where('id_pdm', $id_pdm)
            ->where('jenis', 'Surat')
            ->first();
    }
}
