<?php

namespace App\Models;

use CodeIgniter\Model;


class riwayatModel extends Model
{

    protected $table      = 'riwayat';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_anak', 'id_test', 'list_jawaban', 'hasil'];
    protected $primarykey = 'id';

    public function joinall($id1, $id2, $id3)
    {
        return $this->table('riwayat')
            ->join('data_anak', 'riwayat.id_anak = data_anak.id')
            ->join('users', 'data_anak.id_users = users.id')
            ->where('users.id', $id1)
            ->where('data_anak.id', $id2)
            ->where('riwayat.id', $id3);
    }
}
