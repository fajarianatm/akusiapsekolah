<?php

namespace App\Controllers;

use App\Models\anakModel;
use App\Models\riwayatModel;
use App\Models\soalModel;
use CodeIgniter\I18n\Time;
use DateTime;

class Test extends BaseController
{
    protected $testModel;

    public function __construct()
    {
        $this->soalModel = new soalModel();
        $this->riwayat = new riwayatModel();
        $this->anak =  new anakModel();
        $this->time = new Time();
    }

    public function index()
    {
        $sekarang = new DateTime();
        $idUser = session()->get('id');
        $data = [
            'validation' => \Config\Services::validation(),
            'data' => $this->anak->table('data_anak')->where('id_users', $idUser)->findAll(),
            'sekarang' => $sekarang,
            'css' => '../css/styledatanak.css'
        ];
        if (!$idUser) {
            return redirect()->to('masuk');
        } else if ($this->anak->where('id_users', $idUser)->first()) {
            return view('datanak', $data);
        } else {
            echo 'belom punya data, isila disini njir';
            return redirect()->to('profil');
        }
    }
    public function pilihAnak($id)
    {
        $idUser = session()->get('id');
        if ($this->anak->where('id_users', $idUser)->where('id', $id)->first()) {
            if (session()->get('anakTes', $id)) {
                session()->remove('anakTes');
            }
            session()->set('anakTes', $id);
            return redirect()->to('awalTest');
        } else {
            echo 'data tidak ditemukan';
            return redirect()->to('profil');
        }
    }

    public function awalTest()
    {
        $data = [
            'css' => '../css/stylecardatanak.css'
        ];
        return view('cardatanak', $data);
    }

    public function startTest()
    {
        $idUser = session()->get('id');
        $Anak = $this->anak->where('id_users', $idUser)->where('id', session()->get('anakTes'))->first();
        if ($Anak) {
            $umur = new DateTime($Anak['tglLahir']);
            $sekarang = new DateTime();
            $usia = $sekarang->diff($umur);
            $diff = (($usia->y) * 12) + ($usia->m);
            if ($diff > 45 && $diff <= 51) {
                $idtest = 1;
                $soalA = $this->soalModel->ambilSoal('1', 'A');
            } else if ($diff > 51 && $diff <= 56) {
                $idtest = 2;
                $soalA = $this->soalModel->ambilSoal('2', 'A');
            } else if ($diff > 56) {
                $idtest = 3;
                $soalA = $this->soalModel->ambilSoal('3', 'A');
            } else {
                $idtest = 1;
                $soalA = $this->soalModel->ambilSoal('1', 'A');
            }

            $data = [
                'bag1' => $soalA->findAll(),
                'bag2' => $this->soalModel->ambilSoal('4', 'B')->findAll(),
                'id_test' => $idtest,
                'css' => '../css/tes1.css',
                'diff' => $diff
            ];
            return view('tes1', $data);
        } else {
            echo 'belom punya data anak';
            return redirect()->to('profil');
        }
    }
    public function collectTest()
    {
        if (count($_POST)) {
        }
        if (isset($_POST["submit"])) {
            $jawabanSoalA = [];
            $listjawabanA = '';
            for ($g = 1; $g <= 18; $g++) {
                if (isset($_POST["soal1" . $g])) {
                    $jawabanSoalA[$g] = $_POST["soal1" . $g];
                } else {
                    session()->setFlashData('danger', 'anda belum mengisi soal nomor ' . $g . ' bagian A');
                    return redirect()->to('startTest')->withInput();
                }
            }
            $hasilPenjumlahanA = array_sum($jawabanSoalA);
            $listjawabanA .= implode(",", $jawabanSoalA);

            $jawabanSoalB = [];
            $listjawabanB = '';
            for ($g = 1; $g <= 18; $g++) {
                if (isset($_POST["soal2" . $g])) {
                    $jawabanSoalB[$g] = $_POST["soal2" . $g];
                } else {
                    session()->setFlashData('danger', 'anda belum mengisi soal nomor ' . $g . ' bagian B');
                    return redirect()->to('startTest')->withInput();
                }
            }
            $hasilPenjumlahanB = array_sum($jawabanSoalB);
            $listjawabanB .= implode(",", $jawabanSoalB);

            $listJawabanSemua = $listjawabanA . ';' . $listjawabanB;
            $hasilPenjumlahanSemua = $hasilPenjumlahanA . ';' . $hasilPenjumlahanB;
        }

        $idanak = session()->get('anakTes');
        $this->riwayat->save([
            'id_anak' => $idanak,
            'id_test' => $this->request->getvar('id_test'),
            'list_jawaban' => $listJawabanSemua,
            'hasil' => $hasilPenjumlahanSemua,
        ]);
        return redirect()->to('selesai');
    }
    public function selesai()
    {
        $data = [
            'css' => '../css/selesai.css'
        ];
        return view('selesai', $data);
    }
}
