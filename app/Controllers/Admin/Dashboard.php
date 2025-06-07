<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\blogModel;

class Dashboard extends BaseController
{
    protected $blogModel;

    public function __construct()
    {
        $this->blogModel = new blogModel();
    }

    function index()
    {
        $this->data['pageTitle'] = 'Dashboard Pages';
        $this->data['currentAdminMenu'] = 'dashboard';
        $this->data['currentAdminSubMenu'] = 'dashboard';
        $this->data['countBlog'] = $this->blogModel->countAll();

        return view('admin/dashboard/index', $this->data);
    }
}
