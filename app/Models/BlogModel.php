<?php

namespace App\Models;

use CodeIgniter\Model;


class blogModel extends Model
{

    protected $table = 'blog';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'judul', 'slug', 'foto', 'isi_teks'
    ];
    protected $primarykey = 'id';

    public function getBlog($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}
