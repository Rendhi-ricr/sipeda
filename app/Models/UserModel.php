<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 't_user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['email', 'prodi', 'password', 'level'];

    // Fungsi untuk mendapatkan data user berdasarkan email
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
}
