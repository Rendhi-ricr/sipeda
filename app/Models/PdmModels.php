<?php

namespace App\Models;

use CodeIgniter\Model;

class PdmModels extends Model
{
    protected $table = 't_pdm';
    protected $primaryKey = 'id_pdm';
    protected $allowedFields = ['npm', 'nama', 'prodi', 'terakhir_update', 'status_pengajuan', 'keterangan'];

    // public function getAll()
    // {
    //     $builder = $this->db->table($this->table);
    //     $builder->join('tbl_user', 'tbl_user.id_user = tbl_transaksi.id_user') // Bergabung dengan tabel user
    //         ->join('tbl_denda', 'tbl_denda.id_denda = tbl_transaksi.id_denda');
    //     $query = $builder->get();
    //     return $query->getResult();
    // }

    public function data_pdm($id_pdm)
    {
        return $this->find($id_pdm);
    }

    public function update_data($data, $id_pdm)
    {
        return $this->update($id_pdm, $data);
    }

    public function delete_data($id_pdm)
    {
        return $this->delete($id_pdm);
    }

    public function getPdmWithBerkasAndJenis($id_pdm = null, $prodi = null)
    {
        $builder = $this->db->table('t_pdm');
        $builder->select('t_pdm.*, GROUP_CONCAT(t_jenis_pengajuan_pdm.jenis_pengajuan) as jenis_pengajuan')
            ->join('t_jenis_pengajuan_pdm', 't_jenis_pengajuan_pdm.id_pdm = t_pdm.id_pdm', 'left') // Menggabungkan dengan t_jenis_pengajuan_pdm
            ->groupBy('t_pdm.id_pdm');

        // Filter berdasarkan id_pdm jika diberikan
        if ($id_pdm !== null) {
            $builder->where('t_pdm.id_pdm', $id_pdm);
        }

        // Filter berdasarkan prodi jika diberikan
        if ($prodi !== null) {
            $builder->where('t_pdm.prodi', $prodi);
        }

        $query = $builder->get();
        return $id_pdm ? $query->getRow() : $query->getResult();
    }



    public function getPdmWithBerkas($id_pdm = null)
    {
        $builder = $this->db->table('t_pdm');
        $builder->select('t_pdm.*') // Menggunakan kolom nama_lengkap dari tabel user
            ->groupBy('t_pdm.id_pdm');

        if ($id_pdm !== null) {
            $builder->where('t_pdm.id_pdm', $id_pdm);
        }

        $query = $builder->get();
        return $id_pdm ? $query->getRow() : $query->getResult();
    }

    public function getBerkasByPdm($id_pdm)
    {
        return $this->db->table('t_berkas_pdm')
            ->select('t_berkas_pdm.*')
            ->join('t_pdm', 't_pdm.id_pdm = t_berkas_pdm.id_pdm')
            ->where('t_berkas_pdm.id_pdm', $id_pdm)
            ->get()
            ->getResult();
    }
    public function getJenisByPdm($id_pdm)
    {
        return $this->db->table('t_jenis_pengajuan_pdm')
            ->select("
            GROUP_CONCAT(t_jenis_pengajuan_pdm.jenis_pengajuan ORDER BY t_jenis_pengajuan_pdm.id_jenis_pengajuan_pdm SEPARATOR ' / ') AS jenis_pengajuan,
            GROUP_CONCAT(t_jenis_pengajuan_pdm.data_awal ORDER BY t_jenis_pengajuan_pdm.id_jenis_pengajuan_pdm SEPARATOR ' / ') AS data_awal,
            GROUP_CONCAT(t_jenis_pengajuan_pdm.data_diusulkan ORDER BY t_jenis_pengajuan_pdm.id_jenis_pengajuan_pdm SEPARATOR ' / ') AS data_diusulkan,
            t_pdm.nama, t_pdm.npm, t_pdm.terakhir_update")
            ->join('t_pdm', 't_pdm.id_pdm = t_jenis_pengajuan_pdm.id_pdm')
            ->where('t_jenis_pengajuan_pdm.id_pdm', $id_pdm)
            ->get()
            ->getResult();


        // return $this->db->table('t_jenis_pengajuan_pdm')
        //     ->select('t_jenis_pengajuan_pdm.*', 't_pdm.*')
        //     ->join('t_pdm', 't_pdm.id_pdm = t_jenis_pengajuan_pdm.id_pdm')
        //     ->where('t_jenis_pengajuan_pdm.id_pdm', $id_pdm)
        //     ->get()
        //     ->getResult();
    }

    public function BulanRomawi($id_pdm)
    {
        return $this->db->table('t_jenis_pengajuan_pdm')
            ->select("
            GROUP_CONCAT(t_jenis_pengajuan_pdm.jenis_pengajuan ORDER BY t_jenis_pengajuan_pdm.id_jenis_pengajuan_pdm SEPARATOR ' / ') AS jenis_pengajuan,
            GROUP_CONCAT(t_jenis_pengajuan_pdm.data_awal ORDER BY t_jenis_pengajuan_pdm.id_jenis_pengajuan_pdm SEPARATOR ' / ') AS data_awal,
            GROUP_CONCAT(t_jenis_pengajuan_pdm.data_diusulkan ORDER BY t_jenis_pengajuan_pdm.id_jenis_pengajuan_pdm SEPARATOR ' / ') AS data_diusulkan,
            t_pdm.nama, t_pdm.npm, t_pdm.terakhir_update")
            ->join('t_pdm', 't_pdm.id_pdm = t_jenis_pengajuan_pdm.id_pdm')
            ->where('t_jenis_pengajuan_pdm.id_pdm', $id_pdm)
            ->get()
            ->getRow();
    }
}
