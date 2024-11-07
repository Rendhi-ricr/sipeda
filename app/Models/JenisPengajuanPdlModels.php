<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisPengajuanPdlModels extends Model
{
    protected $table = 't_jenis_pengajuan_pdl';
    protected $primaryKey = 'id_jenis_pengajuan_pdl';
    protected $allowedFields = ['id_pdl', 'jenis_pengajuan', 'data_awal', 'data_diusulkan'];

    public function getJenisByPdl($id_pdl)
    {
        return $this->where('id_pdl', $id_pdl)->findAll();
    }
}
