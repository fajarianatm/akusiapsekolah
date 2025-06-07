<?php

namespace App\Models;

use CodeIgniter\Model;


class soalModel extends Model
{

    protected $table      = 'soal';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_test', 'pertanyaan', 'tipe_opsi', 'banyak_opsi'];
    protected $primarykey = 'id';

    public function ambilSoal($id, $type)
    {
        return $this->table('soal')
            ->join('test', 'soal.id_test = test.id')
            ->where('tipe_opsi', $type)
            ->where('id_test', $id)
            ->orderBy('Nomor', 'ASC');
    }
    public function all($id)
    {
        return $this->table('soal')
            ->join('test', 'soal.id_test = test.id')
            ->where('id_test', $id);
    }
}
