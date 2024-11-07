<?php

namespace App\Models;

use CodeIgniter\Model;

class PdlModels extends Model
{
    protected $table = 't_pdl';
    protected $primaryKey = 'id_pdl';
    protected $allowedFields = ['npm', 'nama', 'prodi', 'terakhir_update', 'status_pengajuan', 'keterangan'];

    // public function getAll()
    // {
    //     $builder = $this->db->table($this->table);
    //     $builder->join('tbl_user', 'tbl_user.id_user = tbl_transaksi.id_user') // Bergabung dengan tabel user
    //         ->join('tbl_denda', 'tbl_denda.id_denda = tbl_transaksi.id_denda');
    //     $query = $builder->get();
    //     return $query->getResult();
    // }

    public function data_pdl($id_pdl)
    {
        return $this->find($id_pdl);
    }

    public function update_data($data, $id_pdl)
    {
        return $this->update($id_pdl, $data);
    }

    public function delete_data($id_pdl)
    {
        return $this->delete($id_pdl);
    }

    public function getPdlWithBerkasAndJenis($jenis_pengajuan = null, $prodi = null)
    {
        $builder = $this->db->table('t_pdl');
        $builder->select('t_pdl.*, GROUP_CONCAT(t_jenis_pengajuan_pdl.jenis_pengajuan) as jenis_pengajuan')
            ->join('t_jenis_pengajuan_pdl', 't_jenis_pengajuan_pdl.id_pdl = t_pdl.id_pdl', 'left')
            ->groupBy('t_pdl.id_pdl');

        // Filter berdasarkan jenis_pengajuan jika diberikan
        if ($jenis_pengajuan !== null) {
            // Pastikan jenis_pengajuan adalah array
            if (is_array($jenis_pengajuan)) {
                $builder->whereIn('t_jenis_pengajuan_pdl.jenis_pengajuan', $jenis_pengajuan);
            } else {
                $builder->where('t_jenis_pengajuan_pdl.jenis_pengajuan', $jenis_pengajuan);
            }
        }

        // Filter berdasarkan prodi jika diberikan
        if ($prodi !== null) {
            $builder->where('t_pdl.prodi', $prodi);
        }

        $query = $builder->get();
        return $query->getResult();
    }





    public function getPdlWithBerkas($id_pdl = null)
    {
        $builder = $this->db->table('t_pdl');
        $builder->select('t_pdl.*') // Menggunakan kolom nama_lengkap dari tabel user
            ->groupBy('t_pdl.id_pdl');

        if ($id_pdl !== null) {
            $builder->where('t_pdl.id_pdl', $id_pdl);
        }

        $query = $builder->get();
        return $id_pdl ? $query->getRow() : $query->getResult();
    }

    public function getBerkasByPdl($id_pdl)
    {
        return $this->db->table('t_berkas_pdl')
            ->select('t_berkas_pdl.*')
            ->join('t_pdl', 't_pdl.id_pdl = t_berkas_pdl.id_pdl')
            ->where('t_berkas_pdl.id_pdl', $id_pdl)
            ->get()
            ->getResult();
    }
    public function getJenisByPdl($id_pdl)
    {
        return $this->db->table('t_jenis_pengajuan_pdl')
            ->select('t_jenis_pengajuan_pdl.jenis_pengajuan, t_jenis_pengajuan_pdl.data_awal, t_jenis_pengajuan_pdl.data_diusulkan, t_pdl.nama, t_pdl.prodi')
            ->join('t_pdl', 't_pdl.id_pdl = t_jenis_pengajuan_pdl.id_pdl')
            ->where('t_jenis_pengajuan_pdl.id_pdl', $id_pdl)
            ->get()
            ->getResult();
        // return $this->db->table('t_jenis_pengajuan_pdm')
        //     ->select('t_jenis_pengajuan_pdm.*', 't_pdm.*')
        //     ->join('t_pdm', 't_pdm.id_pdm = t_jenis_pengajuan_pdm.id_pdm')
        //     ->where('t_jenis_pengajuan_pdm.id_pdm', $id_pdm)
        //     ->get()
        //     ->getResult();
    }
}
