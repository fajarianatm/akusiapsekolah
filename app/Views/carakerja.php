<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="..\css\styletentang.css">
    <link rel="stylesheet" type="text/css" href="..\css\resposive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/694e4c1198.js" crossorigin="anonymous"></script>
</head>

<body>

    <!-- Navbar -->
    <header>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-tranparent w-100">
            <div class="container-fluid">
                <a class="navbar-brand ms-3" href="#"><img class="logonav" src="<?= base_url('../img/logotulisan.png') ?>"></a>

                <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto my-0 py-0 mb-lg-0">
                        <li class="nav-item mx-0">
                            <a class="nav-link navmenu" aria-current="page" href="/">Beranda</a>
                        </li>
                        <li class="nav-item mx-1 dropdown">
                            <a class="nav-link dropdown-toggle navmenu" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Tes
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/test">Tes Kesiapan Anak</a></li>
                                <li><a class="dropdown-item" href="/datanak">Hasil Tes</a></li>
                            </ul>
                        </li>
                        <li class="nav-item mx-1 dropdown">
                            <a class="nav-link dropdown-toggle navmenu" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Tentang Kami
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/visi">Visi</a></li>
                                <li><a class="dropdown-item" href="/misi">Misi</a></li>
                                <li><a class="dropdown-item" href="/carakerja">Cara Kerja</a></li>
                            </ul>
                        </li>
                        <li class="nav-item mx-0">
                            <a class="nav-link navmenu" href="/tanyahli">Tanya Ahli</a>
                        </li>
                        <li class="nav-item mx-0">
                            <a class="nav-link navmenu" href="/kontak">Kontak</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-8 me-5">
                        <?php if (session()->get('isLoggedIn')) : ?>
                            <li class="nav-item mx-1 dropdown">
                                <a class="nav-link dropdown-toggle btnmasuk" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-user-circle" aria-hidden="true" style="margin-right: 10px;"></i><?php echo (session()->get('namaLengkap')); ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="/profil">Profil</a></li>
                                    <li><a class="dropdown-item" href="/keluar">Keluar</a></li>
                                </ul>
                            </li>
                        <?php else : ?>
                            <button type="button" class="btn btnmasuk"><a class="text-decoration-none" href="/masuk">Masuk</a>
                            </button>
                        <?php endif; ?>

                    </ul>
                </div>
            </div>
        </nav>

    </header>



    <!-- isi -->


    <div class="container my-auto">

        <div class="row mt-5 mb-5 my-auto">
            <div class="col my-auto">
                <h1 class=" tagcarakerja">Bagaimana <img class="logonav" src="..\img\logotulisan.png" style="height: 65px; width: auto;"> Dapat Membantu Anda?</h1>

                <ul style="padding-right: 100px; text-align: justify;">
                    <li style="margin-bottom: 5px;" class="isicarakerja">Menyediakan kuisioner untuk orang tua menilai kemampuan anak</li>
                    <li style="margin-bottom: 5px;" class="isicarakerja">Memberikan interpretasi hasil pengisian kuisioner yang dapat terus diakses </li>
                    <li style="margin-bottom: 5px;" class="isicarakerja">Merekomendasikan upaya tindak lanjut yang dapat dilakukan oleh orang tua terkait
                        persiapan anak prasekolah</li>
                </ul>

            </div>
            <div class="col">
                <div class="row mt-3">
                    <div class="col-md-6 ">
                        <div class="card">
                            <div class="card-header w-100" style="background-color: #0B7588; color: white;">
                                Kuisioner terbagi menjadi 2 bagian
                            </div>

                            <p class="mt-3" style="text-align: justify;"></p>
                            <p> Bagian A: berisi 3 area yaitu motorik kasar, motorik halus, dan personal sosial.
                            </p>
                            <p>

                                Bagian B: berisi area pemeriksaan awal ADHD untuk skrining perilaku impulsif dan
                                hiperaktif.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="card">



                            <p class="mt-3" style="text-align: justify; ">Orang tua perlu mengisi kuisioner dengan tepat dan teliti, tidak ada waktu maksimal dan minimal untuk mengisi kuisioner. Jawaban orang tua akan berpengaruh dengan interpretasi hasil dan rekomendasi tindak lanjut yang AkuSiapSekolah berikan sehingga diperlukan jawaban yang sebenarnya saat mengisi.</p>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
    <section id="footer" style="position: fixed;">
        <footer>
            <div class="container text-center">

                <div class="row">
                    <div class="col">
                        <img class="logonav" src="..\img\logotulisan.png"></a>
                        <p class="tulfooter">Tahun 2022</p>
                    </div>
                </div>
            </div>
        </footer>
    </section>




    <!-- footer -->



    <script src="js\script.js"></script>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</html>