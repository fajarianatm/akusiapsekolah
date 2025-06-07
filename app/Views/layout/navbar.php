    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-tranparent position-fixed w-100">
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
                            <li><a class="dropdown-item" href="/profil">Hasil Tes</a></li>
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