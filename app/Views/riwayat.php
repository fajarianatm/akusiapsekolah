<?= $this->include('layout/header'); ?>
<?= $this->include('layout/navbar'); ?>
<!-- card -->
<section id="layanan">
    <div class="container">

        <!-- card -->




        <div class="row mt-3 " style="padding-top: 20px;">

            <h1 class="text-center tagriwayat" style="margin-bottom: 0px; padding-bottom:15px;">Riwayat Tes Kesiapan Anak</h1>
            <hr style="margin-bottom: 0px; padding-bottom:15px;">
            <div hidden><?= $hit = 1; ?></div>
            <?php foreach ($riwayat as $r) : ?>
                <div class="col-md-3 text-center">
                    <div class="card">
                        <div class=" position-relative">
                            <i class="fa-solid fa-user fa-6x" class="position-absolute top-50 start-50 translate-middle"></i>
                        </div>

                        <h3 style="margin-top: 8px;">Tes #<?= $hit; ?></h3>
                        <div hidden><?= $date = strtotime($r['created_at']); ?></div>
                        <p>Tanggal Tes :<?= date('d/M/Y', $date); ?></p>

                        <div class="row">
                            <button class="btn btn-riwayat" type="button" style="margin-bottom: 10px;">
                                <a href="/print/<?= $r['id']; ?>/<?= $hit; ?>" target="_blank" style="text-decoration: none;">lihat hasil</a>
                            </button>
                        </div>
                        <div class="row">

                            <button class="btn btn-riwayat" type="button">
                                <a href="/kirimHasil/<?= $r['id']; ?>/<?= $hit++; ?>" target="_blank" style="text-decoration: none;">kirim hasil ke email</a>
                            </button>
                        </div>
                    </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

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
<?= $this->include('layout/script'); ?>

<?= $this->include('layout/modal'); ?>