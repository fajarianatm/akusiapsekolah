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

    <div class="container">
        <h1 class="text-center tagvisi" style="margin-bottom: 20px;">Apa Saja Misi Kami?</h1>
        <p class="isimisi text-center" style="margin-bottom: 50px; margin-left: 10%; margin-right: 10%">Ada banyak anak yang tidak memiliki kesempatan mendapatkan stimulus motorik dan sensorik yang baik sehingga mengalami keterlambatan perkembangan, ketidakmampuan belajar, dan gangguan hiperaktif. Memiliki akses untuk memahami dan melatih potensi anak dalam tumbuh kembangnya sangat penting bagi orang tua. Untuk itu, AkuSiapSekolah memiliki misi :</p>

        <div class="row mt-3">
            <div class="col-md-4 text-center">
                <div class="card">

                    <img src="..\img\akses.png" alt="" class="mx-auto" style="height: 50px;">

                    <h3 class="mt-4">Kemudahan Aksebilitas</h3>
                    <p class="mt-3 my-auto" style="text-align: justify; font-size: 16px;"> Orang tua dapat mengerjakan tes dengan memaksimalkan efisiensi dan manajemen waktu mereka. <img class="logonav" src="..\img\logotulisan.png"> dapat diakses kapan saja, online, tanpa persiapan, dan dimana saja.</p>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="card">

                    <img src="..\img\terjangkau.png" alt="" class="mx-auto" style="height: 50px;">

                    <h3 class="mt-4">Terjangkau</h3>
                    <p class="mt-3" style="text-align: justify; font-size: 16px;"><img class="logonav" src="..\img\logotulisan.png">menyediakan rekomendasi kegiatan dan serangkaian parameter secara gratis. Kami ingin memastikan bahwa setiap anak mendapatkan kesempatan untuk memaksimalkan potensi emas mereka tanpa masalah keterbatasan biaya</p>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="card">

                    <img src="..\img\berkualitas.png" alt="" class="mx-auto" style="height: 50px;">
                    <h3 class="mt-4">Berkualitas</h3>
                    <p class="mt-3" style="text-align: justify; font-size: 16px;"><img class="logonav" src="..\img\logotulisan.png">mengedepankan Evidence Based Practice dalam memberikan pelayanan kepada anak dan orang tua. Dengan harapan, dapat memberikan bantuan secara efektif untuk meningkatkan kemampuan motorik dan atensi anak prasekolah.</p>


                </div>
            </div>
        </div>

    </div>


    <!-- footer -->

    <section id="footer" style="margin-top: 30px;">
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


    <script src="js\script.js"></script>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</html>