<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'css' => '../css/style.css'
        ];
        return view('home', $data);
    }

    // public function masuk()
    // {
    //     return view('masuk');
    // }
    public function tentang()
    {
        $data = [
            'css' => '../css/styletentang.css'
        ];
        return view('tentang', $data);
    }
    public function kontak()
    {
        $data = [
            'css' => '../css/stylekontak.css'
        ];
        return view('kontak', $data);
    }
    // public function daftar()
    // {
    //     return view('daftar');
    // }

    // public function tes1()
    // {
    //     return view('tes1');
    // }

    // public function tes2()
    // {
    //     return view('tes2');
    // }
    // public function profil()
    // {
    //     return view('profil');
    // }
    // public function hasil()
    // {
    //     return view('hasil');
    // }
    // public function biodata()
    // {
    //     return view('biodata');
    // }
    // public function datanak()
    // {
    //     return view('datanak');
    // }
    // public function cardatanak()
    // {
    //     return view('cardatanak');
    // }
    public function tanyahli()
    {
        $data = [
            'css' => '../css/styletanyahli.css'
        ];
        return view('tanyahli', $data);
    }
    public function terimakasih()
    {
        $data = [
            'css' => '../css/terimakasih.css'
        ];
        return view('terimakasih', $data);
    }
    public function invoice1()
    {
        $data = [];
        return view('inpoice', $data);
    }
    public function visi()
    {
        $data = [
            'css' => '../css/styletentang.css'
        ];
        return view('visi', $data);
    }
    public function misi()
    {
        $data = [
            'css' => '../css/styletentang.css'
        ];
        return view('misi', $data);
    }
    public function carakerja()
    {
        $data = [
            'css' => '../css/styletentang.css'
        ];
        return view('carakerja', $data);
    }
    public function kirimkeDev()
    {
        $email = session()->get('email');
        $nama = session()->get('namaLengkap');
        $pesan = $this->request->getVar('pesan');

        $this->sendEmail($email, $nama, $pesan);
        return redirect()->to('kontak');
    }

    private function sendEmail($dari, $nama, $pesan)
    {
        $email = service('email');
        $email->setFrom($dari);
        $email->setTo('service.akusiapsekolah@gmail.com');
        $email->setSubject('Pesan dari ' . $nama);
        $email->setMessage($pesan);

        if ($email->send()) {
            return "email berhasil dikirim";
        } else {
            $email->printDebugger(['Headers']);
            return "error";
        }
    }

    public function test()
    {
        return view('html/index.html');
    }
}
