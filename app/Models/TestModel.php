<?php

namespace App\Models;

use CodeIgniter\Model;


class testModel extends Model
{

    protected $table      = 'test';
    protected $useTimestamps = true;
    protected $allowedFields = ['judul_soal', 'banyak_soal', 'keterangan'];
    protected $primarykey = 'id';
}
