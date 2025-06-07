<?= $this->include('layout/header'); ?>
<?= $this->include('layout/navbar'); ?>
<!-- card -->
<section id="layanan">
    <div class="container">

        <!-- card -->

        <div class="row mt-3 " style="padding-top: 20px;">
            <h1 style="color: #0B7588; text-align: center; font-weight: 700; margin-bottom: 5px;">Profil Anak</h1>
            <p style="font-size: 18px; font-weight:500px; color: #0B7588; text-align: center; margin-bottom : 50px;">Silahkan pilih nama anak yang akan dilakukan tes</p>
            <?php foreach ($data as $d) : ?>
                <div class="col-md-3 text-center">
                    <a data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $d['id']; ?>" id="set_dtl" data-nama="<?= $d['nama']; ?>" data-panggilan="<?= $d['panggilan']; ?>" data-tanggal="<?= $d['tglLahir']; ?>">
                        <div class="card">
                            <div class=" positian-relative mx-auto my-auto">
                                <i class="fa-solid fa-user fa-6x" class="position-absolute top-50 start-50 translate-middle"></i>
                            </div>
                            <h3 class="mt-5"><?= $d['nama']; ?></h3>
                            <p><?= $d['jenisKelamin']; ?>/ <?= ($sekarang->diff(new DateTime($d['tglLahir']))->y) ?> Tahun <?= $sekarang->diff(new DateTime($d['tglLahir']))->m; ?> Bulan</p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>

            <div class="col-md-3 text-center">
                <div class="card">
                    <div class=" positian-relative mx-auto my-auto">
                        <i class="fa-solid fa-plus fa-8x" class="position-absolute top-50 start-50 translate-middle"></i>
                        <h3 class="mt-4"><a href="/biodata" style="text-decoration: none;  color: #0B7588;" class="tagtambahdata">Tambah baru</a></h3>
                    </div>
                </div>
            </div>
        </div>



    </div>
</section>

<?= $this->include('layout/script'); ?>
<script>
    $(document).ready(function() {
        $(document).on('click', '#set_dtl', function() {
            var nama = $(this).data('nama');
            var panggilan = $(this).data('panggilan');
            var table = $(this).data('id');
            var tanggal = $(this).data('tanggal');
            $('#nama').text(nama);
            $('#panggilan').text(panggilan);
            $('#tanggal').text(getAge(tanggal));
            $('#siaptes').attr("href", "/pilihAnak/" + table);
        })

        function getAge(dateString) {
            var today = new Date();
            var birthDate = new Date(dateString);
            var diff = new Date(today - birthDate);
            return diff.getFullYear() - 1970 + " Tahun " + diff.getMonth() + " Bulan " + diff.getDate() + " Hari ";
        }
    })
</script>

<?= $this->include('layout/modal'); ?>