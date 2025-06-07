<?php

namespace App\Controllers;

use App\Models\anakModel;
use App\Models\riwayatModel;
use DateTime;
use TCPDF;

class Anak extends BaseController
{
    protected $anakModel;

    public function __construct()
    {
        $this->anakModel = new anakModel();
        $this->riwayat = new riwayatModel();
    }

    public function index()
    {
        $sekarang = new DateTime();
        $idUser = session()->get('id');
        $data = [
            'validation' => \Config\Services::validation(),
            'data' => $this->anakModel->table('data_anak')->where('id_users', $idUser)->findAll(),
            'sekarang' => $sekarang,
            'css' => '../css/styleprofil.css'
        ];
        return view('profil', $data);
    }

    public function detail($slug)
    {
    }

    public function tambah()
    {
        $data = [
            'css' => '../css/stylebiodata.css'
        ];
        return view('biodata', $data);
    }
    public function save()
    {
        // validasi input
        if (!$this->validate([
            'nama' => [
                'rules' => 'required|is_unique[data_anak.nama]',
                'errors' => [
                    'required' => '{field}  must be filled',
                    'is_unique' => '{field} have been registered'
                ]
            ],
            'panggilan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} must be filled',
                ]
            ],
            'tglLahir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} must be filled',
                ]
            ],
            'mingguHamil' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} must be filled',
                ]
            ],
            'dsl_tinggi' => [
                'rules' => 'permit_empty|numeric',
                'errors' => [
                    'numeric' => 'number only'
                ]
            ],
            'dsl_berat' => [
                'rules' => 'permit_empty|numeric',
                'errors' => [
                    'numeric' => 'number only'
                ]
            ],
            'dsl_kepala' => [
                'rules' => 'permit_empty|numeric',
                'errors' => [
                    'numeric' => 'number only'
                ]
            ],
            'dsi_tinggi' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field}  must be filled',
                    'numeric' => 'number only'
                ]
            ],
            'dsi_berat' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field}  must be filled',
                    'numeric' => 'number only'
                ]
            ],
            'dsi_kepala' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field}  must be filled',
                    'numeric' => 'number only'
                ]
            ],
        ])) {
            return redirect()->to('biodata')->withInput();
        }

        $idUser = session()->get('id');

        $this->anakModel->save([
            'id_users' => $idUser,
            'nama' => $this->request->getVar('nama'),
            'panggilan' => $this->request->getVar('panggilan'),
            'jenisKelamin' => $this->request->getVar('jenisKelamin'),
            'tglLahir' => $this->request->getVar('tglLahir'),
            'mingguHamil' => $this->request->getVar('mingguHamil'),
            'dsl_tinggi' => $this->request->getVar('dsl_tinggi'),
            'dsl_berat' => $this->request->getVar('dsl_berat'),
            'dsl_kepala' => $this->request->getVar('dsl_kepala'),
            'dsi_tinggi' => $this->request->getVar('dsi_tinggi'),
            'dsi_berat' => $this->request->getVar('dsi_berat'),
            'dsi_kepala' => $this->request->getVar('dsi_kepala'),
        ]);
        return redirect()->to('/profil');
    }
    public function delete($id)
    {
        $this->anakModel->delete($id);
        session()->setFlashdata('pesan', 'Data anak sudah berhasil terhapus');
        return redirect()->to('/profil');
    }

    public function edit($id)
    {
        $idUser = session()->get('id');
        $data = [
            'data' => $this->anakModel->table('data_anak')->where('id_users', $idUser)->where('id', $id)->first(),
            'css' => '../css/stylebiodata.css'
        ];
        if ($data['data']) {
            return view('biodata_edit', $data);
        } else {
            echo 'cannot find the data you looking for';
        }
    }

    public function update()
    {
        $check = $this->anakModel->where('id', $this->request->getVar('idAnak'))->first();
        if ($check['nama'] == $this->request->getVar('nama')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[data_anak.nama]';
        }
        // validasi input
        if (!$this->validate([
            'nama' => [
                'rules' => $rule_name,
                'errors' => [
                    'required' => '{field}  must be filled',
                    'is_unique' => '{field} have been registered'
                ]
            ],
            'panggilan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} must be filled',
                ]

            ],
            'jenisKelamin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} must be filled',
                ]

            ],
            'tglLahir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} must be filled',
                ]
            ],
            'mingguHamil' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} must be filled',
                ]
            ],
            'dsl_tinggi' => [
                'rules' => 'permit_empty|numeric',
                'errors' => [
                    'numeric' => 'number only'
                ]
            ],
            'dsl_berat' => [
                'rules' => 'permit_empty|numeric',
                'errors' => [
                    'numeric' => 'number only'
                ]
            ],
            'dsl_kepala' => [
                'rules' => 'permit_empty|numeric',
                'errors' => [
                    'numeric' => 'number only'
                ]
            ],
            'dsi_tinggi' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field}  must be filled',
                    'numeric' => 'number only'
                ]
            ],
            'dsi_berat' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field}  must be filled',
                    'numeric' => 'number only'
                ]
            ],
            'dsi_kepala' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field}  must be filled',
                    'numeric' => 'number only'
                ]
            ],
        ])) {
            $id =  $this->request->getVar('idAnak');
            return redirect()->to("edit/" . $id)->withInput();
        }

        $this->anakModel->save([
            'id' => $this->request->getVar('idAnak'),
            'nama' => $this->request->getVar('nama'),
            'panggilan' => $this->request->getVar('panggilan'),
            'jenisKelamin' => $this->request->getVar('jenisKelamin'),
            'tglLahir' => $this->request->getVar('tglLahir'),
            'mingguHamil' => $this->request->getVar('mingguHamil'),
            'dsl_tinggi' => $this->request->getVar('dsl_tinggi'),
            'dsl_berat' => $this->request->getVar('dsl_berat'),
            'dsl_kepala' => $this->request->getVar('dsl_kepala'),
            'dsi_tinggi' => $this->request->getVar('dsi_tinggi'),
            'dsi_berat' => $this->request->getVar('dsi_berat'),
            'dsi_kepala' => $this->request->getVar('dsi_kepala'),
        ]);
        return redirect()->to('/profil');
    }
    public function print($id)
    {

        $data = [
            'riwayat' => $this->riwayat->where('id_anak', $id)->findAll()
        ];
        $html1 =  view('invoice1', $data);
        //bagian pdfnyo
        // $html2 = view('invoice2', $data);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Akusiapsekoalh.com');
        $pdf->SetTitle('Hasil Test Anak');
        $pdf->SetSubject('Test Anak');
        $pdf->SetKeywords('Data, Anak');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetMargins(10, PDF_MARGIN_TOP, 10);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');

        $pdf->AddPage('P', 'A4');
        $pdf->writeHTML($html1, true, false, true, false, '');
        // $pdf->AddPage();
        // $pdf->writeHTML($html2);

        // backward stuff ??
        $pdf->setPage(1, true);
        $pdf->SetY(50);
        $pdf->Cell(0, 0, 'A4 test', 1, 1, 'C');


        $this->response->setContentType('application/pdf');
        $pdf->Output('TestAnak.pdf', 'I');
    }

    public function kirimHasil($id)
    {
        $email = session()->get('email');
        $data = [
            'riwayat' => $this->riwayat->where('id_anak', $id)->findAll(),

        ];

        $html1 =  view('invoice1', $data);
        $html2 = view('invoice2', $data);
        $this->sendEmail($email, 'hasil test', $html1 . $html2);
        return view('profil');
    }

    private function sendEmail($to, $title, $message)
    {
        $email = service('email');
        $email->setFrom('service.akusiapsekolah@gmail.com', 'akusiapsekolah@gmail.com');
        $email->setTo($to);
        $email->setSubject($title);
        $email->setMessage($message);

        if ($email->send()) {
            echo "email berhasil dikirim";
        } else {
            $data = $email->printDebugger(['Headers']);
            print_r($data);
        }
    }
}
