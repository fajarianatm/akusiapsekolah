<?= $this->include('layout/header'); ?>
<?= $this->include('layout/navbar'); ?>
<!-- Bagian Home -->
<section id="home">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-md-6 my-auto home-tagline">
                <div class="col1">
                    <h1 style=" font-weight: 700; color: #0B7588; font-size: 70px;">Apakah anak Kita siap untuk bersekolah?</h1>
                    <p class="listatas" style="font-size: 22px;"><img class="logonav" style="height: 40px; width:auto;" src="..\img\logotulisan.png"> dapat membantu anda</p>

                    <ul class="list" style="font-size: 20px;">
                        <li>Skrining Kemampuan Anak</li>
                        <li>Merekomendasikan aktivitas untuk Anak</li>
                        <li>Mudah, Gratis, Kapan saja</li>
                    </ul>
                    <button type="button" class=" btnmulai btn d-grid gap-2 col-6  " style=" margin-top: 40px;">
                        <a class="text-decoration-none" href="/test">Mulai</a>
                    </button>
                </div>
            </div>
        </div>
        <img class="foto position-absolute end-0 bottom-0" src="..\img\beranda.png" title="diverse group of preschoolers playing">
    </div>
</section>

<!-- Bagian Layanan -->
<section id="layanan">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 style=" font-weight: 700; margin-top: -10px; ">Aku Siap Sekolah</h2>
            </div>
        </div>

        <!-- card -->
        <div class="row mt-3">
            <div class="col-md-4 text-center">
                <div class="card">

                    <img src="..\img\akses.png" alt="" class="mx-auto" style="height: 50px;">

                    <h3 class="mt-4">Kemudahan Aksebilitas</h3>
                    <p class="mt-3"><img class="logonav" src="..\img\logotulisan.png"> dapat diakses kapan saja, online, tanpa persiapan, dan dimana saja.</p>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="card">

                    <img src="..\img\terjangkau.png" alt="" class="mx-auto" style="height: 50px;">

                    <h3 class="mt-4">Terjangkau</h3>
                    <p class="mt-3"><img class="logonav" src="..\img\logotulisan.png"> menyediakan rekomendasi kegiatan dan serangkaian parameter secara gratis. </p>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="card">

                    <img src="..\img\berkualitas.png" alt="" class="mx-auto" style="height: 50px;">
                    <h3 class="mt-4">Berkualitas</h3>
                    <p class="mt-3"><img class="logonav" src="..\img\logotulisan.png"> tetap mengedepankan Evidence Based Practice dalam memberikan pelayanan kepada anak dan orang tua. </p>


                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->include('layout/script'); ?>
<?= $this->include('layout/footer'); ?>