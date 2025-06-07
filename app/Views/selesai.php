<?= $this->include('layout/header'); ?>
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

<section id="isi">

    <div class="container my-auto">

        <div class="row mt-5 mb-5 my-auto justify-content-center align-items-center">
            <div class="col-8 ">
                <div class="text-center">
                    <h3 class="tagjudul">TES SELESAI</h3>

                    <p class="deskripsi"> Terima kasih sudah memilih <img class="logonav" src="..\img\logotulisan.png"> sebagai sarana guna melihat kesiapan anak kita dalam mengikuti pendidikan sekolah. Tentunya kami mengaharapkan agar orang tua senantiasa mendukung tumbuh kembang anak. </p>
                </div>

                <div class="text-justify bawah">

                    <h3 class="tagline">PERHATIAN :</h3>
                    <ul class="list">
                        <li>Silahkan cek email untuk melihat hasil tes atau tekan tombol "Lihat Hasil Tes" dibawah.</li>
                        <li>Hasil dari tes juga dapat diakses melalui halaman profil</li>
                    </ul>
                </div>
                <div class="text-center align-items-center">
                    <button type="button" class="btn  col-8 btnmulai text-center">
                        <a class="text-decoration-none" href="/pilihRiwayat/<?= session()->get('anakTes'); ?>">Lihat Hasil Tes</a>
                    </button>
                </div>


            </div>
        </div>
    </div>

</section>

<?= $this->include('layout/script'); ?>

<!-- footer -->

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
<script src="js\script.js"></script>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</html>