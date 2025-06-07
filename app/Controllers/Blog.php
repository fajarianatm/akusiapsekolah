<?php

namespace App\Controllers;

use App\Models\blogModel;

class Blog extends BaseController
{
    protected $blogModel;

    public function __construct()
    {
        $this->blogModel = new blogModel();
    }

    public function index()
    {
        $dataBlog = $this->blogModel->table('blog')->findAll();

        $data = [
            'css' => '../css/styleblog.css',
            'data' => $dataBlog,
        ];

        return view('blog', $data);
    }

    public function detail($slug)
    {
        $data = [
            'css' => '../css/styleblog.css',
            'data' => $this->blogModel->table('blog')->getBlog($slug),
        ];

        // jika bake tidak ada pada tabel
        if (empty($data['data'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('cant find' . $slug);
        }

        return view('detailblog', $data);
    }
}
