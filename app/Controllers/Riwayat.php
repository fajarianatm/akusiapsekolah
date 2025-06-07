<?php

namespace App\Controllers;

use App\Models\anakModel;
use App\Models\riwayatModel;
use App\Models\UserModel;
use DateTime;
use Mpdf\Mpdf;
use TCPDF;

class Riwayat extends BaseController
{
    protected $anakModel;

    public function __construct()
    {
        $this->anakModel = new anakModel();
        $this->riwayatModel = new riwayatModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $sekarang = new DateTime();
        $data = [
            'validation' => \Config\Services::validation(),
            'sekarang' => $sekarang,
            'css' => '../css/styledatanak.css',
            'riwayat' => $this->riwayatModel->where('id_anak', session()->get('idAnak'))->findAll()
        ];
        return view('riwayat', $data);
    }

    public  function pilihRiwayat($id)
    {
        $idUser = session()->get('id');
        if ($this->anakModel->where('id_users', $idUser)->where('id', $id)->first()) {
            if (session()->get('idAnak')) {
                session()->remove('idAnak');
            }
            session()->set('idAnak', $id);
            return redirect()->to('riwayat');;
        } else {
            echo 'data tidak ditemukan';
            return redirect()->to('profil');
        }
    }

    public function kirimHasil($id, $hit)
    {
        $email = session()->get('email');
        $data = $this->print($id, $hit, 'yes');
        $isi = '
        <p>Halo, ' . $data['namaAkun'] . '
        </p>
        <p>
            Anda telah menyelesaikan tes yang disediakan AkuSiapSekolah, terima kasih! Hasilnya telah dihitung, dan sesuai dengan janji kami, berikut hasil tes yang anda dapatkan.
            Perlu diketahui hasil tes ini terdiri atas interpretasi kami atas jawaban yang anda berikan, dilengkapi juga dengan aktivitas dan tindak lanjut yang kami sediakan. 
            Kami harap anda selalu menemani anak saat bermain dan melakukan aktivitas yang kami rekomendasikan bersama-sama untuk menghindari hal-hal yang tidak kita inginkan karena kurangnya perhatian yang mereka dapatkan. 
        </p>
        <br>
        <p>Berharap untuk selalu dapat membantu anda dan anak anda</p>
        <p>Salam <br> Fajariana Tri Mulia</p>
        ';
        $this->sendEmail($email, $data['title'], $isi, $data['attachment']);
        unlink(FCPATH . 'uploads/' . $data['attachment']);


        // return $confirm;
        return redirect()->to('profil');
    }

    public function print($id, $hit, $email = 'no')
    {
        $data = [];
        $data = $this->process_data($id);
        $data['html'] = $this->isi_html($data['id_test'], $data['area1'], $data['area2'], $data['area3'], $data['area4'], $data['panggilan']);
        if ($data['mingguKehamilan'] <= 37) {
            $data['mingguKehamilan'] = 'tidak';
        } else {
            //prematur
        }
        // print_r($data);
        // return view('page/invoice2', $data);
        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
        $mpdf->showImageErrors = true;
        $mpdf->allow_charset_conversion = true;
        $mpdf->useActiveForms = true;
        $mpdf->DefHTMLHeaderByName(
            'defaultHeader',
            '<section id="atas">
                    <table class="row">
                        <tr>
                            <td class="mx-auto my-auto" style="width:30%">
                                <img src="..\img\pdflogo.png" alt="" class="mx-auto" style="height: 250px;">
                            </td>
                            <td class="my-auto kanan text-center" style="width:70%">
                                <h3 style="font-weight: 700;letter-spacing:10px;font-size: 70px;font-family: "Crimson Text", serif;">Hasil Tes</h3>
                                <p class="judul2" style="font-size: 30px;">KESIAPAN SEKOLAH</p>
                                <p class="judul3" style="font-size: 20px;"> <img src="..\img\logotulisan.png" style="heigh: 50px;">REPORT</p>
                            </td>
                        </tr>
                    </table>
                    <hr>
                </section>',
        );

        $mpdf->DefHTMLFooterByName(
            'defaultFooter',
            '<section id="footer ">
                <div class="footer ">
                <table style="width:100%;">
                <tr>
                    <td style="width: 40%; padding-top: 20px;position: relative;bottom: 0px;margin-top: 50px;padding-bottom: 20px;font-family: "Alegreya", serif; ">
                        <p class="footer1" style="margin: 2px; letter-spacing: 2px; font-weight: 600;">DIKIRIMKAN UNTUK</p>
                        <p style="margin: 2px;">' . $data['namaOrtu'] . '</p>
                        <p style="margin: 2px;">Orang Tua dari ' . $data['namaAnak'] . '</p>
                        <p style="margin: 2px;">' . $data['emailOrtu'] . '</p>
                    </td>
                    <td style="width: 60%; text-align: right">
                        <img src="..\img\logotulisan.png" style="opacity: 0.5"><img src="..\img\pdflogo.png" alt="" class="mx-auto" style="height: 150px; opacity: 0.5">
                    </td>
                </tr>
                </table>
                    <div class="row text-center rowbottom">
                        <p><i class="fa-solid fa-globe"></i>www.akusiapsekolah.com</p>
                    </div>
                </div>
                </section>'
        );
        $html = view('page/invoice1', $data);
        $mpdf->WriteHTML($html);

        $mpdf->AddPage();
        $html = view('page/invoice2', $data);
        $mpdf->WriteHTML($html);
        if (isset($data['html']['isi_html_3'])) {
            $mpdf->AddPage();
            $html = view('page/invoice3', $data);
            $mpdf->WriteHTML($html);
        }
        if (isset($data['html']['isi_html_4'])) {
            $mpdf->AddPage();
            $html = view('page/invoice4', $data);
            $mpdf->WriteHTML($html);
        }
        if ($email == 'yes') {
            $back = [
                'title' => 'hasil Tes ' . $data['namaAnak'] . ' ke ' . $hit,
                'attachment' => 'hasil Tes ' . $data['namaAnak'] . ' ke ' . $hit . '.pdf',
                'namaAkun' => $data['namaOrtu'],
            ];
            $mpdf->Output('uploads/hasil Tes ' . $data['namaAnak'] . ' ke ' . $hit . '.pdf', 'F');
            return $back;
        } else {
            $this->response->setContentType('application/pdf');
            $mpdf->Output('hasil Tes ' . $data['namaAnak'] . ' ke ' . $hit . '.pdf', 'I');
        }
    }

    private function sendEmail($to, $title, $message, $attachment)
    {
        $email = service('email');
        $email->setFrom('service.akusiapsekolah@gmail.com', 'akusiapsekolah@gmail.com');
        $email->setTo($to);
        $email->setSubject($title);
        $email->setMessage($message);
        $email->attach('uploads/' . $attachment);

        if ($email->send()) {
            return "email berhasil dikirim";
        } else {
            $data = $email->printDebugger(['Headers']);
            return print_r($data);
        }
    }

    private function process_data($id)
    {
        $idUser = session()->get('id');
        $idAnak = session()->get('idAnak');
        $idRiwayat = $id;
        //check dlu
        if ($this->riwayatModel->joinall($idUser, $idAnak, $idRiwayat)->first()) {
        } else {
            redirect()->to('profile');
        }
        //data Anak dulu
        $dataAnak = $this->anakModel->where('id_users', $idUser)->where('id', $idAnak)->first();
        $sekarang = new DateTime();
        //data Ortu sekarang
        $dataOrtu = $this->userModel->where('id', $idUser)->first();
        //data riwayat sekarang
        $dataRiwayat = $this->riwayatModel->where('id_anak', $idAnak)->where('id', $idRiwayat)->first();
        //memulai pernilaian
        $dataseluruhArea = explode(";", $dataRiwayat['list_jawaban']);
        $dataAreaA = $dataseluruhArea['0'];
        $dataAreaB = $dataseluruhArea['1'];
        //kita explode lagi
        $dataAreaAA = explode(",", $dataAreaA);
        $dataAreaBB = explode(",", $dataAreaB);
        //jumlahkan per area
        $dsementara1 = [];
        for ($g = 0; $g <= 5; $g++) {
            $dsementara1[$g] = $dataAreaAA[$g];
        }
        $dsementara2 = [];
        for ($g = 6; $g <= 11; $g++) {
            $dsementara2[$g] = $dataAreaAA[$g];
        }
        $dsementara3 = [];
        for ($g = 12; $g <= 17; $g++) {
            $dsementara3[$g] = $dataAreaAA[$g];
        }
        $dsementara4 = [];
        for ($g = 0; $g <= 17; $g++) {
            $dsementara4[$g] = $dataAreaBB[$g];
        }
        $area1 = array_sum($dsementara1) * 5;
        $area2 = array_sum($dsementara2) * 5;
        $area3 = array_sum($dsementara3) * 5;
        $area4 = array_sum($dsementara4);
        //menentukan area anak umur berapa dlu(untuk Area A be)
        if ($dataRiwayat['id_test'] = 1) {
            if ($area1 <= 32.78) {
                $area1 = 'hitam';
            } else if (32.78 < $area1 && $area1 <= 43) {
                $area1 = 'abu-abu';
            } else {
                $area1 = 'putih';
            };

            if ($area2 <= 15.81) {
                $area2 = 'hitam';
            } else if (15.81 < $area2 && $area2 <= 30.8) {
                $area2 = 'abu-abu';
            } else {
                $area2 = 'putih';
            };

            if ($area3 <= 26.60) {
                $area3 = 'hitam';
            } else if (26.6 < $area3 && $area3 <= 38) {
                $area3 = 'abu-abu';
            } else {
                $area3 = 'putih';
            };
        } else if ($dataRiwayat['id_test'] = 2) {
            if ($area1 <= 35.18) {
                $area1 = 'hitam';
            } else if (35.18 < $area1 && $area1 <= 44) {
                $area1 = 'abu-abu';
            } else {
                $area1 = 'putih';
            };

            if ($area2 <= 17.32) {
                $area2 = 'hitam';
            } else if (17.32 < $area2 && $area2 <= 31) {
                $area2 = 'abu-abu';
            } else {
                $area2 = 'putih';
            };

            if ($area3 <= 32.33) {
                $area3 = 'hitam';
            } else if (32.78 < $area3 && $area3 <= 42) {
                $area3 = 'abu-abu';
            } else {
                $area3 = 'putih';
            };
        } else if ($dataRiwayat['id_test'] =  3) {
            if ($area1 <= 31.28) {
                $area1 = 'hitam';
            } else if (31.28 < $area1 && $area1 <= 41) {
                $area1 = 'abu-abu';
            } else {
                $area1 = 'putih';
            };
            if ($area2 <= 26.54) {
                $area2 = 'hitam';
            } else if (26.54 < $area2 && $area2 <= 39) {
                $area2 = 'abu-abu';
            } else {
                $area2 = 'putih';
            };
            if ($area3 <= 39.07) {
                $area3 = 'hitam';
            } else if (39.07 < $area3 && $area3 <= 46) {
                $area3 = 'abu-abu';
            } else {
                $area3 = 'putih';
            };
        } else {
            echo 'data is error betch try again';
        }
        //Area B mudah tinggal masukkan be ke rumus keknyo
        if ($area4 <= 50.22) {
            $area4 = 'putih';
        } else {
            $area4 = 'hitam';
        };



        $data = [
            'namaAnak' => $dataAnak['nama'],
            'panggilan' => $dataAnak['panggilan'],
            'tanggalLahir' => $dataAnak['tglLahir'],
            'gender' => $dataAnak['jenisKelamin'],
            'usiaAnak' => $sekarang->diff(new DateTime($dataAnak['tglLahir'])),
            'mingguKehamilan' => $dataAnak['mingguHamil'],
            'relasiAnak' => 'Ayah/Ibu',
            'namaOrtu' => $dataOrtu['namaLengkap'],
            'emailOrtu' => $dataOrtu['email'],
            'tanggalTes' => $dataRiwayat['created_at'],
            'id_test' => $dataRiwayat['id_test'],
            'area1' => $area1,
            'area2' => $area2,
            'area3' => $area3,
            'area4' => $area4,
        ];
        return $data;
    }

    private function isi_html($id, $a1, $a2, $a3, $a4, $panggilan)
    {
        $narea = [
            'area1' => 'Motorik Kasar',
            'area2' => 'Motorik Halus',
            'area3' => 'Personal Sosial',
            'area4' => 'ADHD'
        ];
        $nfile = [
            'area1' => 'motorikkasar',
            'area2' => 'motorikhalus',
            'area3' => 'personalsosial',
            'area4' => 'ADHD'
        ];
        $point = [
            '4thn' => [
                'area1' => [
                    'hitam' => [
                        'hijau' => "Yang mana ini berarti bahwa {$panggilan} mungkin merasa kesulitan dalam mengontrol gerakannya sendiri, mengarahkan, mendapatkan mainan, dan bergerak di lingkungan sekitar. {$panggilan} mengalami kesulitan menjaga keseimbangan tubuhnya dan tidak dapat mengoptimalkan kemampuan kaki dan tangannya dengan baik sehingga ketika bermain bola, melompat, dan bermain perosotan terasa sulit bagi {$panggilan}.",
                        'biru' => "motorik yang buruk kurang tertarik untuk bermain dan lebih menarik diri dari sosial dibandingkan anak dengan kemampuan motorik rata-rata. Anak dengan kemampuan motorik yang rendah berisiko sulit bersosialisasi dengan teman seusianya karena dianggap tidak mampu untuk bermain bersama"
                    ],
                    'abu-abu' => [
                        'hijau' => "Yang mana ini berarti bahwa {$panggilan} mungkin belum dapat mengontrol gerakannya sendiri, mengarahkan, mendapatkan mainan, dan bergerak di lingkungan sekitar secara optimal. {$panggilan} terkadang mengalami kesulitan menjaga keseimbangan tubuhnya dan kesulitan menggunakan kemampuan kaki dan tangannya dengan baik sehingga ketika bermain bola, melompat, dan bermain perosotan menjadi hal yang cukup menantang bagi {$panggilan}.",
                        'biru' => "motorik yang buruk kurang tertarik untuk bermain dan lebih menarik diri dari sosial dibandingkan anak dengan kemampuan motorik rata-rata. Anak dengan kemampuan motorik yang rendah berisiko sulit bersosialisasi dengan teman seusianya karena dianggap tidak mampu untuk bermain bersama"
                    ],
                ],
                'area2' => [
                    'hitam' =>  [
                        'hijau' => "Yang mana ini berarti bahwa {$panggilan} mungkin merasa kesulitan dalam meraih, menggenggam, mengarahkan, dan menggambar. {$panggilan} mengalami kesulitan untuk memanipulasi benda kecil di sekitar dan mengoordinasikan tangannya sehingga menyusun puzzle, menggunting, menggambar, atau bahkan urusan mengenai kancing baju terasa sulit bagi {$panggilan}",
                        'biru' => "motorik yang buruk kurang tertarik untuk bermain dan lebih menarik diri dari sosial dibandingkan anak dengan kemampuan motorik rata-rata. Anak dengan kemampuan motorik yang rendah berisiko dapat dikucilkan dari teman sebayanya karena dianggap tidak mampu untuk bermain bersama"
                    ],
                    'abu-abu' =>  [
                        'hijau' => "Yang mana ini berarti bahwa {$panggilan} mungkin terkadang merasa kesulitan dalam meraih, menggenggam, mengarahkan, dan menggambar secara optimal. {$panggilan} terkadang mengalami kesulitan untuk memanipulasi benda kecil di sekitar dan mengoordinasikan tangannya sehingga menyusun puzzle, menggunting, menggambar, atau bahkan urusan mengenai kancing baju menjadi hal yang cukup menantang bagi {$panggilan}",
                        'biru' => "motorik yang buruk kurang tertarik untuk bermain dan lebih menarik diri dari sosial dibandingkan anak dengan kemampuan motorik rata-rata. Anak dengan kemampuan motorik yang rendah berisiko sulit bersosialisasi dengan teman seusianya karena dianggap tidak mampu untuk bermain bersama"
                    ],
                ],
                'area3' => [
                    'hitam' =>  [
                        'hijau' => "Yang mana ini berarti bahwa {$panggilan} mungkin merasa kesulitan dalam mengendalikan diri, memiliki motivasi dan ketekunan selama beraktivitas, berinteraksi dengan orang lain dan menyelesaikan tugas pribadi yang diberikan kepadanya . {$panggilan} mungkin mengalami kesulitan untuk berkomunikasi dengan anda, menyikat gigi, mencuci tangan, dan melepas pakaiannya sendiri",
                        'biru' => "personal-sosial yang buruk berisiko memiliki hubungan yang sulit dikembangkan dan dipertahankan dengan teman sebaya, masalah perilaku, prestasi akademik yang rendah atau rentan terkena masalah kesehatan fisik dan mental"
                    ],
                    'abu-abu' =>  [
                        'hijau' => "Yang mana ini berarti bahwa {$panggilan} mungkin terkadang kesulitan dalam mengendalikan diri, memiliki motivasi dan ketekunan selama beraktivitas, berinteraksi dengan orang lain dan menyelesaikan tugas pribadi yang diberikan kepadanya . mungkin mengalami kesulitan untuk berkomunikasi dengan anda, menyikat gigi, mencuci tangan, dan melepas pakaiannya sendiri",
                        'biru' => "personal-sosial yang buruk berisiko memiliki hubungan yang sulit dikembangkan dan dipertahankan dengan teman sebaya, masalah perilaku, prestasi akademik yang rendah atau rentan terkena masalah kesehatan fisik dan mental"
                    ],
                ],
                'area4' => [
                    'hitam' =>  [
                        'hijau' => "Yang mana berarti {$panggilan} merasa dan/atau terlihat “bingung” tentang apa yang diharapkan orang lain atau orang tua darinya. {$panggilan} mengalami kesulitan mengikuti petunjuk untuk menyelesaikan tugas. Tugas mungkin dibiarkan setengah selesai dan tampaknya {$panggilan} \"menyerah\" dengan mudah. {$panggilan} merasa sulit untuk memulai suatu tugas; membutuhkan bantuan untuk menyelesaikan tugas dan membutuhkan waktu lebih lama daripada anak lainnya. Sepertinya {$panggilan} tidak mendengarkan instruksi dan {$panggilan} mungkin terlihat “nakal”",
                        'biru' => "konsenterasi dan pemusatan perhatian yang buruk tidak dapat mengikuti teman sebaya dan mengalami kesulitan membentuk hubungan dan membaca isyarat sosial. {$panggilan} mungkin gelisah atau mengusik orang lain, karena {$panggilan} tidak fokus pada tugas. {$panggilan} dapat mengalami tingkat kecemasan dan frustrasi yang lebih tinggi, menyebabkan kehancuran atau tantrum"
                    ]
                ],
            ],
            '4,5thn' => [
                'area1' => [
                    'hitam' =>  [
                        'hijau' => "Yang mana ini berarti bahwa {$panggilan} mungkin merasa kesulitan dalam mengontrol gerakannya sendiri, mengarahkan, mendapatkan mainan, dan bergerak di lingkungan sekitar. {$panggilan} mengalami kesulitan menjaga keseimbangan tubuhnya dan tidak dapat mengoptimalkan kemampuan kaki dan tangannya dengan baik sehingga bermain bola, melompat, atau bahkan menjaga keseimbangan saat berjinjit terasa sulit bagi {$panggilan}",
                        'biru' => "motorik yang buruk kurang tertarik untuk bermain dan lebih menarik diri dari sosial dibandingkan anak dengan kemampuan motorik rata-rata. Anak dengan kemampuan motorik yang rendah berisiko sulit bersosialisasi dengan teman seusianya karena dianggap tidak mampu untuk bermain bersama"
                    ],
                    'abu-abu' =>  [
                        'hijau' => "Yang mana ini berarti bahwa {$panggilan} mungkin terkadang tidak dapat mengontrol gerakannya sendiri, mengarahkan, mendapatkan mainan, dan bergerak di lingkungan sekitar secara optimal. {$panggilan} terkadang mengalami kesulitan menjaga keseimbangan tubuhnya dan kesulitan menggunakan kemampuan kaki dan tangannya dengan baik sehingga bermain bola, melompat, atau bahkan menjaga keseimbangan saat berjinjit menjadi hal yang cukup menantang bagi {$panggilan}.",
                        'biru' => "motorik yang buruk kurang tertarik untuk bermain dan lebih menarik diri dari sosial dibandingkan anak dengan kemampuan motorik rata-rata. Anak dengan kemampuan motorik yang rendah berisiko sulit bersosialisasi dengan teman seusianya karena dianggap tidak mampu untuk bermain bersama"
                    ],
                ],
                'area2' => [
                    'hitam' =>  [
                        'hijau' => "Yang mana ini berarti bahwa {$panggilan} mungkin merasa kesulitan dalam meraih, menggenggam, mengarahkan, dan menggambar. {$panggilan} mengalami kesulitan untuk memanipulasi benda kecil di sekitar dan mengoordinasikan tangannya sehingga menggunting, menggambar, atau bahkan urusan mengenai kancing baju terasa sulit bagi {$panggilan}",
                        'biru' => "motorik yang buruk kurang tertarik untuk bermain dan lebih menarik diri dari sosial dibandingkan anak dengan kemampuan motorik rata-rata. Anak dengan kemampuan motorik yang rendah berisiko sulit bersosialisasi dengan teman seusianya karena dianggap tidak mampu untuk bermain bersama"
                    ],
                    'abu-abu' =>  [
                        'hijau' => "Yang mana ini berarti bahwa {$panggilan} mungkin terkadang merasa kesulitan dalam meraih, menggenggam, mengarahkan, dan menggambar secara optimal. {$panggilan} terkadang mengalami kesulitan untuk memanipulasi benda kecil di sekitar dan mengoordinasikan tangannya sehingga menggunting, menggambar, atau bahkan urusan mengenai kancing baju menjadi hal yang cukup menantang bagi {$panggilan}",
                        'biru' => "motorik yang buruk kurang tertarik untuk bermain dan lebih menarik diri dari sosial dibandingkan anak dengan kemampuan motorik rata-rata. Anak dengan kemampuan motorik yang rendah berisiko sulit bersosialisasi dengan teman seusianya karena dianggap tidak mampu untuk bermain bersama"
                    ],
                ],
                'area3' => [
                    'hitam' =>  [
                        'hijau' => "Yang mana ini berarti bahwa {$panggilan} mungkin merasa kesulitan dalam mengendalikan diri, memiliki motivasi dan ketekunan selama beraktivitas, berinteraksi dengan orang lain dan menyelesaikan tugas pribadi yang diberikan kepadanya . {$panggilan} mungkin mengalami kesulitan untuk berkomunikasi dengan anda, menyikat gigi, mencuci tangan, dan melepas pakaiannya sendiri",
                        'biru' => "personal-sosial yang buruk berisiko memiliki hubungan yang buruk dengan teman sebaya, masalah perilaku, prestasi akademik yang rendah atau rentan terkena masalah kesehatan fisik dan mental"
                    ],
                    'abu-abu' =>  [
                        'hijau' => "Yang mana ini berarti bahwa {$panggilan} mungkin terkadang kesulitan dalam mengendalikan diri, memiliki motivasi dan ketekunan selama beraktivitas, berinteraksi dengan orang lain dan menyelesaikan tugas pribadi yang diberikan kepadanya . mungkin mengalami kesulitan untuk berkomunikasi dengan anda, menyikat gigi, mencuci tangan, dan melepas pakaiannya sendiri",
                        'biru' => "personal-sosial yang buruk berisiko memiliki hubungan yang sulit dikembangkan dan dipertahankan dengan teman sebaya, masalah perilaku, prestasi akademik yang rendah atau rentan terkena masalah kesehatan fisik dan mental"
                    ],
                ],
                'area4' => [
                    'hitam' =>  [
                        'hijau' => "Yang mana berarti {$panggilan} merasa dan/atau terlihat “bingung” tentang apa yang diharapkan orang lain atau orang tua darinya. {$panggilan} mengalami kesulitan mengikuti petunjuk untuk menyelesaikan tugas. Tugas mungkin dibiarkan setengah selesai dan tampaknya {$panggilan} \"menyerah\" dengan mudah. {$panggilan} merasa sulit untuk memulai suatu tugas; membutuhkan bantuan untuk menyelesaikan tugas dan membutuhkan waktu lebih lama daripada anak lainnya. Sepertinya {$panggilan} tidak mendengarkan instruksi dan {$panggilan} mungkin terlihat “nakal”",
                        'biru' => "konsenterasi dan pemusatan perhatian yang buruk tidak dapat mengikuti teman sebaya dan mengalami kesulitan membentuk hubungan dan membaca isyarat sosial. {$panggilan} mungkin gelisah atau mengusik orang lain, karena {$panggilan} tidak fokus pada tugas. {$panggilan} dapat mengalami tingkat kecemasan dan frustrasi yang lebih tinggi, menyebabkan kehancuran atau tantrum"
                    ]
                ],
            ],
            '5thn' => [
                'area1' => [
                    'hitam' =>  [
                        'hijau' => "Yang mana ini berarti bahwa {$panggilan} mungkin merasa kesulitan dalam mengontrol gerakannya sendiri, mengarahkan, mendapatkan mainan, dan bergerak di lingkungan sekitar. {$panggilan} mengalami kesulitan menjaga keseimbangan tubuhnya dan tidak dapat mengoptimalkan kemampuan kaki dan tangannya dengan baik sehingga bermain bola, melompat, atau bahkan menjaga keseimbangan saat berjinjit terasa sulit bagi {$panggilan}",
                        'biru' => "motorik yang buruk kurang tertarik untuk bermain dan lebih menarik diri dari sosial dibandingkan anak dengan kemampuan motorik rata-rata. Anak dengan kemampuan motorik yang rendah berisiko sulit bersosialisasi dengan teman seusianya karena dianggap tidak mampu untuk bermain bersama"
                    ],
                    'abu-abu' =>  [
                        'hijau' => "Yang mana ini berarti bahwa {$panggilan} mungkin terkadang tidak dapat mengontrol gerakannya sendiri, mengarahkan, mendapatkan mainan, dan bergerak di lingkungan sekitar secara optimal. {$panggilan} terkadang mengalami kesulitan menjaga keseimbangan tubuhnya dan kesulitan menggunakan kemampuan kaki dan tangannya dengan baik sehingga bermain bola, melompat, atau bahkan menjaga keseimbangan saat berjinjit menjadi hal yang cukup menantang bagi {$panggilan}",
                        'biru' => "motorik yang buruk kurang tertarik untuk bermain dan lebih menarik diri dari sosial dibandingkan anak dengan kemampuan motorik rata-rata. Anak dengan kemampuan motorik yang rendah berisiko sulit bersosialisasi dengan teman seusianya karena dianggap tidak mampu untuk bermain bersama"
                    ],
                ],
                'area2' => [
                    'hitam' =>  [
                        'hijau' => "Yang mana ini berarti bahwa {$panggilan} mungkin merasa kesulitan dalam meraih, menggenggam, mengarahkan, dan menggambar. {$panggilan} mengalami kesulitan untuk memanipulasi benda kecil di sekitar dan mengoordinasikan tangannya sehingga menggunting, menggambar, menulis atau bahkan urusan mengenai kancing baju terasa sulit bagi {$panggilan}",
                        'biru' => "motorik yang buruk kurang tertarik untuk bermain dan lebih menarik diri dari sosial dibandingkan anak dengan kemampuan motorik rata-rata. Anak dengan kemampuan motorik yang rendah berisiko sulit bersosialisasi dengan teman seusianya karena dianggap tidak mampu untuk bermain bersama"
                    ],
                    'abu-abu' =>  [
                        'hijau' => "Yang mana ini berarti bahwa {$panggilan} mungkin terkadang merasa kesulitan dalam meraih, menggenggam, mengarahkan, dan menggambar secara optimal. {$panggilan} terkadang mengalami kesulitan untuk memanipulasi benda kecil di sekitar dan mengoordinasikan tangannya sehingga menggunting, menggambar, menulis atau bahkan urusan mengenai kancing baju menjadi hal yang cukup menantang bagi {$panggilan}",
                        'biru' => "motorik yang buruk kurang tertarik untuk bermain dan lebih menarik diri dari sosial dibandingkan anak dengan kemampuan motorik rata-rata. Anak dengan kemampuan motorik yang rendah berisiko sulit bersosialisasi dengan teman seusianya karena dianggap tidak mampu untuk bermain bersama"
                    ],
                ],
                'area3' => [
                    'hitam' =>  [
                        'hijau' => "Yang mana ini berarti bahwa {$panggilan} mungkin merasa kesulitan dalam mengendalikan diri, memiliki motivasi dan ketekunan selama beraktivitas, berinteraksi dengan orang lain dan menyelesaikan tugas pribadi yang diberikan kepadanya. {$panggilan} mungkin mengalami kesulitan untuk berkomunikasi dengan anda, menyikat gigi, mencuci tangan, menggunakan toilet, dan melepas pakaiannya sendiri",
                        'biru' => "personal-sosial yang buruk berisiko memiliki hubungan yang sulit dikembangkan dan dipertahankan dengan teman sebaya, masalah perilaku, prestasi akademik yang rendah atau rentan terkena masalah kesehatan fisik dan mental"
                    ],
                    'abu-abu' =>  [
                        'hijau' => "Yang mana ini berarti bahwa {$panggilan} mungkin terkadang kesulitan dalam mengendalikan diri, memiliki motivasi dan ketekunan selama beraktivitas, berinteraksi dengan orang lain dan menyelesaikan tugas pribadi yang diberikan kepadanya . mungkin mengalami kesulitan untuk berkomunikasi dengan anda, menyikat gigi, mencuci tangan, menggunakan toilet, dan melepas pakaiannya sendiri",
                        'biru' => "personal-sosial yang buruk berisiko memiliki hubungan yang sulit dikembangkan dan dipertahankan dengan teman sebaya, masalah perilaku, prestasi akademik yang rendah atau rentan terkena masalah kesehatan fisik dan mental"
                    ],
                ],
                'area4' => [
                    'hitam' =>  [
                        'hijau' => "Yang mana berarti {$panggilan} merasa dan/atau terlihat “bingung” tentang apa yang diharapkan orang lain atau orang tua darinya. {$panggilan} mengalami kesulitan mengikuti petunjuk untuk menyelesaikan tugas. Tugas mungkin dibiarkan setengah selesai dan tampaknya {$panggilan} \"menyerah\" dengan mudah. {$panggilan} merasa sulit untuk memulai suatu tugas; membutuhkan bantuan untuk menyelesaikan tugas dan membutuhkan waktu lebih lama daripada anak lainnya. Sepertinya {$panggilan} tidak mendengarkan instruksi dan {$panggilan} mungkin terlihat “nakal”",
                        'biru' => "konsenterasi dan pemusatan perhatian yang buruk tidak dapat mengikuti teman sebaya dan mengalami kesulitan membentuk hubungan dan membaca isyarat sosial. {$panggilan} mungkin gelisah atau mengusik orang lain, karena {$panggilan} tidak fokus pada tugas. {$panggilan} dapat mengalami tingkat kecemasan dan frustrasi yang lebih tinggi, menyebabkan kehancuran atau tantrum"
                    ]
                ],
            ],
            'special' => [
                'allwhite' => " <p> AkuSiapSekolah mengucapkan selamat kepada Ibu/ayah {$panggilan}! Sepertinya {$panggilan} tumbuh dengan kemampuan motorik dan atensi yang sesuai umurnya. {$panggilan} dapat dengan mudah mengontrol gerakannya sendiri, mengoordinasikan tangan dan bermain sesuai tahapan usianya. {$panggilan} juga dapat berinteraksi dengan orang lain dan sepertinya {$panggilan} juga dapat berkonsenterasi dengan baik. </p> 
                <p>Kemampuan motorik dan atensi yang dimiliki oleh {$panggilan} ini sangatlah membantu {$panggilan} di kehidupan sosialnya. Perlu dipahami bahwa kemampuan motorik dan atensi yang baik berpengaruh dengan kualitas hidup {$panggilan} . Oleh karena itu, orang tua {$panggilan} perlu memonitor secara terus-menerus perkembangan kemampuan motorik dan atensi {$panggilan}. AkuSiapSekolah menyediakan banyak aktivitas dan artikel yang dapat orang tua {$panggilan} gunakan untuk kebutuhan {$panggilan} dalam kemampuan motorik dan atensinya.</p>",
                'allblack' => "<p> Orang tua {$panggilan}, dari hasil tes, diperkirakan bahwa {$panggilan} mendapatkan skor yang rendah pada area motorik kasar, motorik halus, personal-sosial, dan atensi. Sepertinya {$panggilan} tumbuh dengan kemampuan motorik dan atensi  tidak sesuai umurnya. {$panggilan} merasa sulit mengontrol gerakannya sendiri, mengoordinasikan tangan dan bermain sesuai tahapan usianya. {$panggilan} juga kesulitan dengan orang lain dan sepertinya {$panggilan} juga tidak dapat berkonsenterasi dengan baik.</p>
                <p> Kemampuan motorik dan atensi sangatlah diperlukan oleh {$panggilan} untuk membantu {$panggilan} di kehidupan sosialnya. Perlu dipahami bahwa kemampuan motorik dan atensi yang baik berpengaruh dengan kualitas hidup {$panggilan}. Oleh karena itu, orang tua {$panggilan} perlu memonitor secara terus-menerus perkembangan kemampuan motorik dan atensi {$panggilan}. AkuSiapSekolah menyarankan orang tua dan {$panggilan} untuk berkonsultasi dengan fisioterapi anak, terapi wicara, okupasi terapi, dan psikolog anak. AkuSiapSekolah juga menyediakan banyak aktivitas dan artikel yang dapat orang tua {$panggilan} gunakan untuk kebutuhan {$panggilan} dalam kemampuan motorik dan atensinya.</p>",
                'allgray' => "<p> Orang tua {$panggilan}, dari hasil tes, diperkirakan bahwa {$panggilan} mendapatkan skor yang menyebabkan orang tua perlu memperhatikan pada area motorik kasar, motorik halus, personal-sosial, dan atensi. Sepertinya {$panggilan} membutuhkan bantuan untuk mengoptimalkan kemampuan motorik dan atensi agar sesuai umurnya. {$panggilan} mungkin terkadang sulit mengontrol gerakannya sendiri, mengoordinasikan tangan dan bermain sesuai tahapan usianya. {$panggilan} juga kadang kesulitan berinteraksi dengan orang lain dan sepertinya {$panggilan} juga tidak dapat berkonsenterasi dengan baik.</p>
                <p>Kemampuan motorik dan atensi sangatlah diperlukan oleh {$panggilan} untuk membantu {$panggilan} di kehidupan sosialnya. Perlu dipahami bahwa kemampuan motorik dan atensi yang baik berpengaruh dengan kualitas hidup {$panggilan}. Oleh karena itu, orang tua {$panggilan} perlu memonitor secara terus-menerus perkembangan kemampuan motorik dan atensi {$panggilan}. AkuSiapSekolah menyediakan banyak aktivitas dan artikel yang dapat orang tua {$panggilan} gunakan untuk kebutuhan {$panggilan} dalam kemampuan motorik dan atensinya.</p>"

            ],
            'solusi' => [
                'hitam' => "perlu berkonsultasi dengan perlu berkonsultasi dengan fisioterapi anak, terapi wicara, okupasi terapi, dan juga psikolog anak.",
                'abu-abu' => "dapat melakukan aktivitas-aktivitas yang AkuSiapSekolah rekomendasikan.",
            ],
            'referensi' => [
                'dafpus1' => 'Øksendal E, Brandlistuen RE, Holte A, Wang MV. Associations between poor gross and fine motor skills in pre-school and peer victimization concurrently and longitudinally with follow-up in school age - results from a population-based study. Br J Educ Psychol. 2022;92(2):557-75.',
                'dafpus2' => 'Alp B, Top E. Investigation of the Relation between the Level of Motor Skills and the Quality of Life in Turkish Children. JTRM Kinesiol [Internet]. 2020;15-21. Available from: http://search.ebscohost.com/login.aspx?direct=true&db=eric&AN=EJ1269647&site=ehost-live',
                'dafpus3' => 'Shala M. The Impact of Preschool Social-Emotional Development on Academic Success of Elementary School Students. Psychology. 2013;04(11):787-91',
                'dafpus4' => 'Im GW, Jiar YK, Talib RB. Development of preschool social emotional inventory for preschoolers: A preliminary study. Int J Eval Res Educ. 2019;8(1):158-64',
                'dafpusmotorik1' => 'Wilkes-Gillan S, Bundy A, Cordier R, Lincoln M, Chen YW. A randomised controlled trial of a play-based intervention to improve the social play skills of children with attention deficit hyperactivity disorder (ADHD). PLoS One. 2016;11(8):1-22.',
                'dafpusmotorik2' => 'Ghanbari BA. The Effectiveness of Flortime Play Therapy on Improving the Attitude and Adaptive Behavior of Children with Attention Deficit / Hyperactivity Disorder ( ADHD ). 2021;3(9):12-23.',
                'dafpuspersonal1' => 'Opstoel K, Chapelle L, Prins FJ, De Meester A, Haerens L, van Tartwijk J, et al. Personal and social development in physical education and sports: A review study. Eur Phys Educ Rev. 2020;26(4):797-813.',
                'dafpuspersonal2' => 'Paulus FW, Ohmann S, Popow C. Practitioner Review: School-based interventions in child mental health. J Child Psychol Psychiatry Allied Discip. 2016;57(12):1337-59.',
                'dafpusadhd1' => 'Wilkes-Gillan S, Bundy A, Cordier R, Lincoln M, Chen YW. A randomised controlled trial of a play-based intervention to improve the social play skills of children with attention deficit hyperactivity disorder (ADHD). PLoS One. 2016;11(8):1-22.',
                'dafpusadhd2' => 'Ghanbari BA. The Effectiveness of Flortime Play Therapy on Improving the Attitude and Adaptive Behavior of Children with Attention Deficit / Hyperactivity Disorder ( ADHD ). 2021;3(9):12-23.'
            ]
        ];
        $data = [];
        $kun = '';
        $kun2 = '';
        $kun3 = '';
        $kun4 = '';
        $hij = '';
        $hij2 = '';
        $hij3 = '';
        $hij4 = '';
        $bir = '';
        $bir2 = '';
        $bir3 = '';
        $bir4 = '';
        $ung = '';
        $ung2 = '';
        $ung3 = '';
        $ung4 = '';
        $type = '';
        $type2 = '';
        $type3 = '';
        $type4 = '';
        $tamb1 = '';
        $tamb2 = '';
        $tamb3 = '';
        $hit = 1;
        $count = [
            'area1' => $a1,
            'area2' => $a2,
            'area3' => $a3,
            'area4' => $a4
        ];

        if ($id == 1) {
            $umur = '4thn';
        } else if ($id == 2) {
            $umur = '4,5thn';
        } else if ($id == 3) {
            $umur = '5thn';
        }
        $count_hitam = 0;
        $count_abu = 0;
        for ($z = 1; $z <= 4; $z++) {
            if ($count['area' . $z] == 'hitam') {
                $count_hitam++;
            } else if ($count['area' . $z] == 'abu-abu') {
                $count_abu++;
            } else {
            }
        }
        //template setiap kejadian
        if ($count_hitam + $count_abu == 0 || ($a1 == 'abu-abu' && $a2 == 'abu-abu' && $a3 == 'abu-abu' && $a4 == 'hitam') || $count_hitam == 4) {
            //untuk 0 variasi dan beberapa yang special
            $data['isi_html_1'] = '';
            if ($count_hitam + $count_abu == 0) {
                $data['isi_html_1'] .= $point['special']['allwhite'];
            } else if ($a1 == 'abu-abu' && $a2 == 'abu-abu' && $a3 == 'abu-abu' && $a4 == 'hitam') {
                $data['isi_html_1'] .= $point['special']['allgray'];
            } else if ($count_hitam == 4) {
                $data['isi_html_1'] .= $point['special']['allblack'];
            } else {
                $data = 'coming soon';
            }
        } else if ($count_hitam + $count_abu == 1) {
            //untuk 1 variasi
            for ($z = 1; $z <= 4; $z++) {
                if ($count['area' . $z] == 'hitam') {
                    $type = 'hitam';
                    $kun = $narea['area' . $z];
                    $hij = $point[$umur]['area' . $z]['hitam']['hijau'];
                    $bir = $point[$umur]['area' . $z]['hitam']['biru'];
                    $ung = $point['solusi']['hitam'];
                }
            }
            for ($z = 1; $z <= 4; $z++) {
                if ($count['area' . $z] == 'abu-abu') {
                    $type = 'abu-abu';
                    $kun = $narea['area' . $z];
                    $hij = $point[$umur]['area' . $z]['abu-abu']['hijau'];
                    $bir = $point[$umur]['area' . $z]['abu-abu']['biru'];
                    $ung = $point['solusi']['abu-abu'];
                }
            }
            //embel embel tambahannya
            if ($type == 'hitam') {
                $tamb1 = " {$panggilan} mungkin mengalami permasalahan serius pada kemampuan";
            } else if ($type == 'abu-abu') {
                $tamb1 = " {$panggilan} mungkin memerlukan peningkatan dalam kemampuan";
            }

            $data['isi_html_1'] = "<p>{$tamb1} {$kun}.{$hij}</p>";
            $data['isi_html_1'] .= "<p>
                    Hal ini dapat memengaruhi kehidupan sosial  {$panggilan}. Telah ditemukan bahwa anak-anak dengan kemampuan {$bir}. 
                    Oleh karena itu, kemampuan {$kun}  {$panggilan} perlu dioptimalkan sehingga  {$panggilan} dapat berinteraksi bersama orang sekitarnya dengan nyaman. 
                    Melihat hasil yang  {$panggilan} dapatkan,  {$panggilan} dan orang tua {$ung}
                    Setelah itu, orang tua perlu mengerjakan tes kembali setelah 1 bulan untuk mengetahui perkembangan {$kun}  {$panggilan}.
                    </p>";
        } else if ($count_hitam + $count_abu == 2) {
            //untuk 2 variasi
            for ($z = 1; $z <= 4; $z++) {
                if ($count['area' . $z] == 'hitam' && $hit == 1) {
                    $type = 'hitam';
                    $kun = $narea['area' . $z];
                    $hij = $point[$umur]['area' . $z]['hitam']['hijau'];
                    $bir = $point[$umur]['area' . $z]['hitam']['biru'];
                    $ung = $point['solusi']['hitam'];
                    $hit++;
                } else if ($count['area' . $z] == 'hitam' && $hit == 2) {
                    $type2 = 'hitam';
                    $kun2 = $narea['area' . $z];
                    $hij2 = $point[$umur]['area' . $z]['hitam']['hijau'];
                    $bir2 = $point[$umur]['area' . $z]['hitam']['biru'];
                    $ung2 = $point['solusi']['hitam'];
                }
            }
            for ($z = 1; $z <= 4; $z++) {
                if ($count['area' . $z] == 'abu-abu' && $hit == 1) {
                    $type = 'abu-abu';
                    $kun = $narea['area' . $z];
                    $hij = $point[$umur]['area' . $z]['abu-abu']['hijau'];
                    $bir = $point[$umur]['area' . $z]['abu-abu']['biru'];
                    $ung = $point['solusi']['abu-abu'];
                    $hit++;
                } else if ($count['area' . $z] == 'abu-abu' && $hit == 2) {
                    $type2 = 'abu-abu';
                    $kun2 = $narea['area' . $z];
                    $hij2 = $point[$umur]['area' . $z]['abu-abu']['hijau'];
                    $bir2 = $point[$umur]['area' . $z]['abu-abu']['biru'];
                    $ung2 = $point['solusi']['abu-abu'];
                }
            }
            //embel embel tambahannya
            if ($type == 'hitam') {
                $tamb1 = " {$panggilan} mungkin mengalami permasalahan serius pada kemampuan";
            } else if ($type == 'abu-abu') {
                $tamb1 = " {$panggilan} mungkin memerlukan peningkatan dalam kemampuan";
            }
            if ($type2 == 'hitam') {
                $tamb2 = " {$panggilan} juga mengalami permasalahan serius dalam kemampuan ";
            } else if ($type2 == 'abu-abu') {
                $tamb2 = " {$panggilan} juga mungkin memerlukan peningkatan dalam kemampuan";
            }
            if ($ung == $ung2) {
                $tambsol = "Melihat hasil yang  {$panggilan} dapatkan, {$panggilan} dan orang tua {$ung}";
            } else {
                $tambsol = "Melihat hasil yang  {$panggilan} dapatkan, {$panggilan} dan orang tua {$ung}. Orang tua dan {$panggilan} juga {$ung2} ";
            }

            $data['isi_html_1'] = "<p>{$tamb1} {$kun}.{$hij}</p>";
            $data['isi_html_1'] .= "<p>Selain permasalahan pada {$kun}, {$tamb2} {$kun2}nya. {$hij2}.</p>";
            $data['isi_html_1'] .= "<p>
                    Hal ini dapat memengaruhi kehidupan sosial {$panggilan}.
                    Telah ditemukan bahwa anak-anak dengan kemampuan {$bir}.
                    Selain itu anak anak dengan kemampuan {$bir2}. 
                    Oleh karena itu, kemampuan {$kun} dan {$kun2} {$panggilan} perlu dioptimalkan sehingga  {$panggilan} dapat berinteraksi bersama orang sekitarnya dengan nyaman. 
                    {$tambsol}.
                    Setelah itu, orang tua dapat mengerjakan kembali tes setelah 1 bulan ke depan untuk melihat perkembangan {$kun} dan {$kun2}  {$panggilan}.
                    </p>";
        } else if ($count_hitam + $count_abu == 3) {
            // untuk 3 variasi 
            for ($z = 1; $z <= 4; $z++) {
                if ($count['area' . $z] == 'hitam' && $hit == 1) {
                    $type = 'hitam';
                    $kun = $narea['area' . $z];
                    $hij = $point[$umur]['area' . $z]['hitam']['hijau'];
                    $bir = $point[$umur]['area' . $z]['hitam']['biru'];
                    $ung = $point['solusi']['hitam'];
                    $hit++;
                } else if ($count['area' . $z] == 'hitam' && $hit == 2) {
                    $type2 = 'hitam';
                    $kun2 = $narea['area' . $z];
                    $hij2 = $point[$umur]['area' . $z]['hitam']['hijau'];
                    $bir2 = $point[$umur]['area' . $z]['hitam']['biru'];
                    $ung2 = $point['solusi']['hitam'];
                    $hit++;
                } else if ($count['area' . $z] == 'hitam' && $hit == 3) {
                    $type3 = 'hitam';
                    $kun3 = $narea['area' . $z];
                    $hij3 = $point[$umur]['area' . $z]['hitam']['hijau'];
                    $bir3 = $point[$umur]['area' . $z]['hitam']['biru'];
                    $ung3 = $point['solusi']['hitam'];
                }
            }
            for ($z = 1; $z <= 4; $z++) {
                if ($count['area' . $z] == 'abu-abu' && $hit == 1) {
                    $type = 'abu-abu';
                    $kun = $narea['area' . $z];
                    $hij = $point[$umur]['area' . $z]['abu-abu']['hijau'];
                    $bir = $point[$umur]['area' . $z]['abu-abu']['biru'];
                    $ung = $point['solusi']['abu-abu'];
                    $hit++;
                } else if ($count['area' . $z] == 'abu-abu' && $hit == 2) {
                    $type2 = 'abu-abu';
                    $kun2 = $narea['area' . $z];
                    $hij2 = $point[$umur]['area' . $z]['abu-abu']['hijau'];
                    $bir2 = $point[$umur]['area' . $z]['abu-abu']['biru'];
                    $ung2 = $point['solusi']['abu-abu'];
                    $hit++;
                } else if ($count['area' . $z] == 'abu-abu' && $hit == 3) {
                    $type3 = 'abu-abu';
                    $kun3 = $narea['area' . $z];
                    $hij3 = $point[$umur]['area' . $z]['abu-abu']['hijau'];
                    $bir3 = $point[$umur]['area' . $z]['abu-abu']['biru'];
                    $ung3 = $point['solusi']['abu-abu'];
                }
            }
            //embel embel tambahannya
            if ($type == 'hitam') {
                $tamb1 = " {$panggilan} mungkin mengalami permasalahan serius pada kemampuan";
            } else if ($type == 'abu-abu') {
                $tamb1 = " {$panggilan} mungkin memerlukan peningkatan dalam kemampuan";
            }
            if ($type2 == 'hitam') {
                $tamb2 = " {$panggilan} juga mengalami permasalahan serius dalam kemampuan ";
            } else if ($type2 == 'abu-abu') {
                $tamb2 = " {$panggilan} juga mungkin memerlukan peningkatan dalam kemampuan";
            }
            if ($type3 == 'hitam') {
                $tamb3 = "Kemampuan {$kun3}  {$panggilan} juga mendapatkan skor yang rendah";
            } else if ($type3 == 'abu-abu') {
                $tamb3 = "Kemampuan {$kun3}  {$panggilan} juga mungkin memerlukan peningkatan";
            }

            if ($ung == $ung3) {
                $tambsol = "Melihat hasil yang  {$panggilan} dapatkan,  {$panggilan} dan orang tua {$ung}";
            } else {
                $tambsol = "Melihat hasil yang  {$panggilan} dapatkan,  {$panggilan} dan orang tua {$ung} Orang tua dan  {$panggilan} juga {$ung3} ";
            }

            $data['isi_html_1'] = "<p>{$tamb1} {$kun}.{$hij}</p>";
            $data['isi_html_1'] .= "<p>Selain permasalahan pada {$kun}, {$tamb2} {$kun2}nya. {$hij2}.</p>";
            $data['isi_html_1'] .= "<p>{$tamb3}. {$hij3}.</p>";
            $data['isi_html_1'] .= "<p>
                    Hal ini dapat memengaruhi kehidupan sosial  {$panggilan}. 
                    Telah ditemukan bahwa anak-anak dengan kemampuan {$bir}. 
                    Selain itu anak anak dengan kemampuan {$bir2}.  
                    Diketahui juga, anak-anak dengan kemampuan {$bir3}.
                    Oleh karena itu, kemampuan {$kun},{$kun2} dan {$kun3} {$panggilan} perlu dioptimalkan sehingga  {$panggilan} dapat berinteraksi bersama orang sekitarnya dengan nyaman. 
                    {$tambsol}
                    Setelah itu, orang tua dapat mengerjakan kembali tes setelah 1 bulan ke depan untuk melihat perkembangan {$kun},{$kun2},{$kun3} {$panggilan}.
                    </p>";
        } else if ($count_hitam + $count_abu == 4) {
            //untuk 4 variasi
            for ($z = 1; $z <= 4; $z++) {
                if ($count['area' . $z] == 'hitam' && $hit == 1) {
                    $type = 'hitam';
                    $kun = $narea['area' . $z];
                    $hij = $point[$umur]['area' . $z]['hitam']['hijau'];
                    $bir = $point[$umur]['area' . $z]['hitam']['biru'];
                    $ung = $point['solusi']['hitam'];
                    $hit++;
                } else if ($count['area' . $z] == 'hitam' && $hit == 2) {
                    $type2 = 'hitam';
                    $kun2 = $narea['area' . $z];
                    $hij2 = $point[$umur]['area' . $z]['hitam']['hijau'];
                    $bir2 = $point[$umur]['area' . $z]['hitam']['biru'];
                    $ung2 = $point['solusi']['hitam'];
                    $hit++;
                } else if ($count['area' . $z] == 'hitam' && $hit == 3) {
                    $type3 = 'hitam';
                    $kun3 = $narea['area' . $z];
                    $hij3 = $point[$umur]['area' . $z]['hitam']['hijau'];
                    $bir3 = $point[$umur]['area' . $z]['hitam']['biru'];
                    $ung3 = $point['solusi']['hitam'];
                    $hit++;
                } else if ($count['area' . $z] == 'hitam' && $hit == 4) {
                    $type4 = 'hitam';
                    $kun4 = $narea['area' . $z];
                    $hij4 = $point[$umur]['area' . $z]['hitam']['hijau'];
                    $bir4 = $point[$umur]['area' . $z]['hitam']['biru'];
                    $ung4 = $point['solusi']['hitam'];
                }
            }
            for ($z = 1; $z <= 4; $z++) {
                if ($count['area' . $z] == 'abu-abu' && $hit == 1) {
                    $type = 'abu-abu';
                    $kun = $narea['area' . $z];
                    $hij = $point[$umur]['area' . $z]['abu-abu']['hijau'];
                    $bir = $point[$umur]['area' . $z]['abu-abu']['biru'];
                    $ung = $point['solusi']['abu-abu'];
                    $hit++;
                } else if ($count['area' . $z] == 'abu-abu' && $hit == 2) {
                    $type2 = 'abu-abu';
                    $kun2 = $narea['area' . $z];
                    $hij2 = $point[$umur]['area' . $z]['abu-abu']['hijau'];
                    $bir2 = $point[$umur]['area' . $z]['abu-abu']['biru'];
                    $ung2 = $point['solusi']['abu-abu'];
                    $hit++;
                } else if ($count['area' . $z] == 'abu-abu' && $hit == 3) {
                    $type3 = 'abu-abu';
                    $kun3 = $narea['area' . $z];
                    $hij3 = $point[$umur]['area' . $z]['abu-abu']['hijau'];
                    $bir3 = $point[$umur]['area' . $z]['abu-abu']['biru'];
                    $ung3 = $point['solusi']['abu-abu'];
                    $hit++;
                } else if ($count['area' . $z] == 'abu-abu' && $hit == 4) {
                    $type4 = 'abu-abu';
                    $kun4 = $narea['area' . $z];
                    $hij4 = $point[$umur]['area' . $z]['abu-abu']['hijau'];
                    $bir4 = $point[$umur]['area' . $z]['abu-abu']['biru'];
                    $ung4 = $point['solusi']['abu-abu'];
                }
            }
            //embel embel tambahannya
            if ($type == 'hitam') {
                $tamb1 = " {$panggilan} mungkin mengalami permasalahan serius pada kemampuan";
            } else if ($type == 'abu-abu') {
                $tamb1 = " {$panggilan} mungkin memerlukan peningkatan dalam kemampuan";
            }
            if ($type2 == 'hitam') {
                $tamb2 = " {$panggilan} juga mengalami permasalahan serius dalam kemampuan ";
            } else if ($type2 == 'abu-abu') {
                $tamb2 = " {$panggilan} juga mungkin memerlukan peningkatan dalam kemampuan";
            }
            if ($type3 == 'hitam') {
                $tamb3 = "Kemampuan {$kun3}  {$panggilan} juga mendapatkan skor yang rendah";
            } else if ($type3 == 'abu-abu') {
                $tamb3 = "Kemampuan {$kun3}  {$panggilan} juga mungkin memerlukan peningkatan";
            }
            if ($type4 == 'abu-abu') {
                if ($type == 'hitam' && $type2 == 'hitam' && $type3 == 'hitam') {
                    $tamb3 = "Selain mungkin mengalami permasalahan serius pada kemampuan {$kun} dan {$kun2}, {$kun3} juga mendapatkan skor yang cukup rendah";
                    $tamb4 = "Kemampuan {$kun4} panggilan juga mungkin memerlukan peningkatan";
                } else if ($type == 'hitam' && $type2 == 'hitam' && $type3 == 'abu-abu') {
                    $tamb4 = "Selain mungkin memerlukan peningkatan pada kemampuan {$kun3}, {$kun4} juga mendapatkan skor yang cukup rendah";
                } else if ($type == 'hitam' && $type2 == 'abu-abu' && $type3 == 'abu-abu') {
                    $tamb4 = "Selain mungkin mengalami permasalahan pada kemampuan {$kun2} dan {$kun3}, {$kun4} juga mendapatkan skor yang cukup rendah";
                }
            } else {
                $tamb4 = "coming soon";
            }

            if ($ung == $ung4) {
                $tambsol = "Melihat hasil yang  {$panggilan} dapatkan,  {$panggilan} dan orang tua {$ung}";
            } else {
                $tambsol = "Melihat hasil yang  {$panggilan} dapatkan,  {$panggilan} dan orang tua {$ung} Orang tua dan  {$panggilan} juga {$ung4} ";
            }

            $data['isi_html_1'] = "<p>{$tamb1} {$kun}.{$hij}</p>";
            $data['isi_html_1'] .= "<p>Selain permasalahan pada {$kun}, {$tamb2} {$kun2}nya. {$hij2}.</p>";
            $data['isi_html_1'] .= "<p>{$tamb3}. {$hij3}.</p>";
            $data['isi_html_1'] .= "<p>{$tamb4}. {$hij4}.</p>";
            $data['isi_html_1'] .= "<p>
                    Hal ini dapat memengaruhi kehidupan sosial  {$panggilan}. 
                    Telah ditemukan bahwa anak-anak dengan kemampuan {$bir}. 
                    Selain itu anak anak dengan kemampuan {$bir2}.  
                    Diketahui juga, anak-anak dengan kemampuan {$bir3}.
                    Terakhir, anak-anak dengan kemampuan {$bir4}.
                    Oleh karena itu, kemampuan {$kun} ,{$kun2} ,{$kun3} ,{$kun4} {$panggilan} perlu dioptimalkan sehingga  {$panggilan} dapat berinteraksi bersama orang sekitarnya dengan nyaman. 
                    {$tambsol}
                    Setelah itu, orang tua dapat mengerjakan kembali tes setelah 1 bulan ke depan untuk melihat perkembangan {$kun} ,{$kun2} ,{$kun3} ,{$kun4} {$panggilan}.
                    </p>";
        }
        //tambahi dafpus dlu
        $clickdafpus = 1;
        if ($count['area1'] == 'abu-abu' || $count['area1'] == 'hitam') {
            if (($count['area2'] == 'abu-abu' || $count['area2'] == 'hitam')) {
                $data['isi_html_4'][$clickdafpus] = $point['referensi']['dafpus1'];
                $clickdafpus++;
            } else {
                $data['isi_html_4'][$clickdafpus] = $point['referensi']['dafpus1'];
                $clickdafpus++;
            }
        } else if ($count['area2'] == 'abu-abu' || $count['area2'] == 'hitam') {
            $data['isi_html_4'][$clickdafpus] = $point['referensi']['dafpus1'];
            $clickdafpus++;
        }
        if ($count_hitam + $count_abu == 0) {
            $data['isi_html_4'][$clickdafpus] = $point['referensi']['dafpus2'];
            $clickdafpus++;
        }
        if ($count['area3'] == 'abu-abu' || $count['area3'] == 'hitam') {
            $data['isi_html_4'][$clickdafpus] = $point['referensi']['dafpus3'];
            $clickdafpus++;
            $data['isi_html_4'][$clickdafpus] = $point['referensi']['dafpus4'];
            $clickdafpus++;
        }
        //halaman 2
        if ($count_abu > 0) {
            $data['isi_html_2']['centang1']['konfirm'] = 'yes';
        } else {
            $data['isi_html_2']['centang1']['konfirm'] = 'no';
        }

        if ($count['area1'] != 'putih' || $count['area2'] != 'putih') {
            $data['isi_html_2']['centang2']['konfirm'] = 'yes';
            if ($count['area1'] != 'putih') {
                $data['isi_html_2']['centang2']['pendengaran'] = 'yes';
            } else {
                $data['isi_html_2']['centang2']['pendengaran'] = 'no';
            }

            if ($count['area2'] != 'putih') {
                $data['isi_html_2']['centang2']['penglihatan'] = 'yes';
            } else {
                $data['isi_html_2']['centang2']['penglihatan'] = 'no';
            }
        } else {
            $data['isi_html_2']['centang2']['konfirm'] = 'no';
            $data['isi_html_2']['centang2']['pendengaran'] = 'no';
            $data['isi_html_2']['centang2']['penglihatan'] = 'no';
        }

        if ($count_hitam > 0) {
            $data['isi_html_2']['centang3']['konfirm'] = 'yes';
            $temp = [];
            $real = '';
            $click = 1;
            for ($g = 1; $g <= 4; $g++) {
                if ($count['area' . $g] == 'hitam') {
                    $temp[$click] = $narea['area' . $g];
                    $click++;
                }
            }
            $real .= implode(",", $temp);
            $data['isi_html_2']['centang3']['isi'] = '';
            $data['isi_html_2']['centang3']['isi'] .= $real;
        } else {
            $data['isi_html_2']['centang3']['konfirm'] = 'no';
        }

        if ($count_hitam + $count_abu == 0) {
            $data['isi_html_2']['centang4']['konfirm'] = 'yes';
        } else {
            $data['isi_html_2']['centang4']['konfirm'] = 'no';
        }

        // untuk data di tabel yang diatas itu na
        $tempputih = [];
        $realputih = '';
        $data['isi_html_2']['putih'] = '';
        $clickputih = 1;
        for ($g = 1; $g <= 4; $g++) {
            if ($count['area' . $g] == 'putih') {
                $tempputih[$clickputih] = $narea['area' . $g];
                $clickputih++;
            }
        }
        $realputih .= implode(",", $tempputih);
        $data['isi_html_2']['putih'] .= $realputih;

        // samo be
        $temphitam = [];
        $realhitam = '';
        $data['isi_html_2']['hitam'] = '';
        $clickhitam = 1;
        for ($g = 1; $g <= 4; $g++) {
            if ($count['area' . $g] == 'hitam' || $count['area' . $g] == 'abu-abu') {
                $temphitam[$clickhitam] = $narea['area' . $g];
                $clickhitam++;
            }
        }
        $realhitam .= implode(",", $temphitam);
        $data['isi_html_2']['hitam'] .= $realhitam;

        // halaman 3
        $clickinter = 1;
        for ($g = 1; $g <= 4; $g++) {
            if ($count['area' . $g] == 'abu-abu' || ($g == 4 && $count['area' . $g] == 'hitam')) {
                $data['isi_html_3'][$clickinter] = $nfile['area' . $g];
                $clickinter++;
            }
        }

        //dafpus yang untuk intervensi
        if ($count['area1'] == 'abu-abu') {
            if (($count['area2'] == 'abu-abu')) {
                $data['isi_html_4'][$clickdafpus] = $point['referensi']['dafpusmotorik1'];
                $clickdafpus++;
                $data['isi_html_4'][$clickdafpus] = $point['referensi']['dafpusmotorik2'];
                $clickdafpus++;
            } else {
                $data['isi_html_4'][$clickdafpus] = $point['referensi']['dafpusmotorik1'];
                $clickdafpus++;
                $data['isi_html_4'][$clickdafpus] = $point['referensi']['dafpusmotorik2'];
                $clickdafpus++;
            }
        } else if ($count['area2'] == 'abu-abu') {
            $data['isi_html_4'][$clickdafpus] = $point['referensi']['dafpusmotorik1'];
            $clickdafpus++;
            $data['isi_html_4'][$clickdafpus] = $point['referensi']['dafpusmotorik2'];
            $clickdafpus++;
        }

        if ($count['area3'] == 'abu-abu') {
            $data['isi_html_4'][$clickdafpus] = $point['referensi']['dafpuspersonal1'];
            $clickdafpus++;
            $data['isi_html_4'][$clickdafpus] = $point['referensi']['dafpuspersonal2'];
            $clickdafpus++;
        }
        if ($count['area4'] == 'hitam') {
            $data['isi_html_4'][$clickdafpus] = $point['referensi']['dafpusadhd1'];
            $clickdafpus++;
            $data['isi_html_4'][$clickdafpus] = $point['referensi']['dafpusadhd2'];
            $clickdafpus++;
        }

        return $data;
    }
}
