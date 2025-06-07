<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\blogModel;

class Products extends BaseController
{
    protected $blogModel;

    public function __construct()
    {
        $this->blogModel = new blogModel();
    }

    public function index()
    {
        $data = [
            // 'bake' => $this->blogModel->getblog(),
            'data' => $this->blogModel->paginate(4, 'blog'),
            'pager' => $this->blogModel->pager,
            'session' => $this->session,
            'currentAdminSubMenu' => 'product',
            'currentAdminMenu' => 'catalogue',
        ];

        // $blogModel = new \App\Models\blogModel()
        // $blogModel = new blogModel();
        return view('admin/products/index', $data);
    }

    public function create()
    {
        // session();
        $data = [
            'validation' => \Config\Services::validation(),
            'session' => $this->session,
            'currentAdminSubMenu' => 'product',
            'currentAdminMenu' => 'catalogue',
        ];
        return view('admin/products/create', $data);
    }

    public function save()
    {

        // validasi input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[blog.judul]',
                'errors' => [
                    'required' => '{field}  harus diisi',
                    'is_unique' => '{field} harus unik'
                ]
            ],
            'isi_teks' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'isi blog harus diisi',
                ]
            ],
            'foto' => [
                'rules' => 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'size foto terlalu besar',
                    'is_image' => 'ini bukan foto',
                    'mime_in' => 'ini bukan foto'
                ]
            ],

        ])) {
            // $validation = \Config\Services::validation();
            // return redirect()->to('/bake/create')->withInput()->with('validation', $validation);
            return redirect()->to('admin/products/create')->withInput();
        }

        // ambil gambar
        $filepicture = $this->request->getFile('foto');
        // apakah tidak ada gambar yang diupload
        if ($filepicture->getError() == 4) {
            $namepicture = 'default.jpg';
        } else {
            // generate nama picture random
            $namepicture = $filepicture->getRandomName();
            // pindahkan file ke folder img
            $filepicture->move('thumbnail', $namepicture);
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);

        $this->blogModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'isi_teks' => $this->request->getVar('isi_teks'),
            'foto' => $namepicture,
        ]);

        session()->setFlashdata('success', 'Blog berhasil diupload !');

        return redirect()->to('admin/products');
    }

    public function delete($id)
    {
        // cari gambar berdasarkan id
        $bake = $this->blogModel->table('blog')->find($id);

        // cek jika file gambarnya default
        if ($bake['foto'] != 'default.jpg') {
            // hapus gambar
            unlink('thumbnail/' . $bake['foto']);
        }

        $this->blogModel->delete($id);
        session()->setFlashdata('success', 'blog dihapus');
        return redirect()->to('admin/products');
    }

    public function edit($slug)
    {
        $data = [
            'validation' => \Config\Services::validation(),
            'session' => $this->session,
            'currentAdminSubMenu' => 'product',
            'currentAdminMenu' => 'catalogue',
            'data' => $this->blogModel->getblog($slug),
        ];

        return view('admin/products/edit', $data);
    }

    public function update($id)
    {
        // cek name
        $bakeLama = $this->blogModel->getblog($this->request->getVar('slug'));
        if ($bakeLama['judul'] == $this->request->getVar('judul')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[bake.name]';
        }

        if (!$this->validate([
            'judul' => [
                'rules' => $rule_name,
                'errors' => [
                    'required' => 'judul harus diisi',
                    'is_unique' => 'judul sudah terdaftar'
                ]
            ],
            'isi_teks' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'isi blog harus diisi',
                ]
            ],
            'foto' => [
                'rules' => 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'size foto terlalu besar',
                    'is_image' => 'ini bukan foto',
                    'mime_in' => 'ini bukan foto'
                ]
            ],

        ])) {
            return redirect()->to('admin/products/' . $this->request->getVar('slug'))->withInput();
        }

        $filepicture = $this->request->getFile('foto');

        // cek gambar, apakah tetap gambar lama
        if ($filepicture->getError() == 4) {
            $namepicture = $this->request->getVar('fotoLama');
        } else {
            //generate nama file random
            $namepicture = $filepicture->getRandomName();
            // pindahkan gambar
            $filepicture->move('thumbnail', $namepicture);
            // hapus file yang lama
            $bake = $this->blogModel->find($id);
            if ($bake['foto'] = 'default.jpg') {
            } else {
                unlink('img/' . $this->request->getVar('fotoLama'));
            }
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->blogModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'isi_teks' => $this->request->getVar('isi_teks'),
            'foto' => $namepicture,
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');

        return redirect()->to('admin/products');
    }

    public function uploadImages()
    {
        $validated = $this->validate([
            'upload' => [
                'uploaded[upload]',
                'mime_in[upload,image/jpg,image/jpeg,image/png]',
                'max_size[upload,1024]',
            ],
        ]);

        if ($validated) {
            $file = $this->request->getFile('upload');
            $fileName = $file->getRandomName();
            $writePath = '../gambar';
            $file->move($writePath, $fileName);
            $data = [
                "uploaded" => true,
                "url" => base_url('gambar/' . $fileName),
            ];
        } else {
            $data = [
                "uploaded" => false,
                "error" => [
                    "messsages" => $file
                ],
            ];
        }

        return $this->response->setJSON($data);
    }
}
