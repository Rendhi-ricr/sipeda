<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisPengajuanPdmModels extends Model
{
    protected $table = 't_jenis_pengajuan_pdm';
    protected $primaryKey = 'id_jenis_pengajuan_pdm';
    protected $allowedFields = ['id_pdm', 'jenis_pengajuan', 'data_awal', 'data_diusulkan'];

    public function getJenisByPdm($id_pdm)
    {
        return $this->where('id_pdm', $id_pdm)->findAll();
    }
}
