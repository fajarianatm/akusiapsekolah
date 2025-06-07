<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;


class anakModel extends Model
{

    protected $table = 'data_anak';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_users', 'nama', 'panggilan', 'jenisKelamin', 'tglLahir', 'mingguHamil',
        'dsl_tinggi', 'dsl_berat', 'dsl_kepala',
        'dsi_tinggi', 'dsi_berat', 'dsi_kepala'
    ];
    protected $primarykey = 'id';
}
