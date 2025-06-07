<?= $this->include('layout/header'); ?>
<?= $this->include('layout/navbar'); ?>
<!-- Isi -->

<!-- Bagian Home -->
<!-- <section id="">
        <div class="container h-100">

        </div>
    </section> -->

<section id="Flyer">
    <div class="container">
        <div class="row text-center h-100">
            <div class="col-12 my-auto">
                <div class="teks">

                    <h4 class="sapa">Halo <?php echo (session()->get('namaLengkap')); ?>,</h4>
                    <p class="parsapa">Terima kasih sudah bergabung di Aku Siap Sekolah</p>
                    <p class="lihsapa">Lihat Selengkapnya > </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="infoakun">
    <div>
        <div class="container">
            <div class="row info-akun" style="padding-top: 15px;">
                <div class="col">
                    <p> <i class="fa-solid fa-envelope"></i> <?php echo (session()->get('namaLengkap'));  ?></p>
                </div>
                <div class="col">
                    <p class="text-end">User</p>
                </div>
            </div>
            <div class="row info-akun bawah">
                <div class="col ">
                    <p><i class="fa-solid fa-user-large"></i> <?php echo (session()->get('email')); ?></p>
                </div>
                <div class="col">
                    <p class="text-end">Email</p>
                </div>
            </div>
        </div>
    </div>
</section>



<section id="layanan">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="ms-1">Profil</h3>
                <hr>
            </div>
        </div>

        <!-- card -->
        <div class="row mt-3">
            <?php foreach ($data as $d) : ?>
                <div class="col-md-3 text-center">
                    <div class="card">
                        <div class=" position-relative">
                            <i class="fa-solid fa-user fa-6x" class="position-absolute top-50 start-50 translate-middle"></i>
                        </div>
                        <h3 class="mt-3"><?= $d['nama']; ?></h3>
                        <p><?= $d['jenisKelamin']; ?>/ <?= $sekarang->diff(new DateTime($d['tglLahir']))->y; ?> Tahun</p>


                        <div class="row">
                            <div class="col">
                                <button class="btn" type="button" style="background-color: #FFBD59;
  font-weight: 500;
  border-color: #FFBD59;
  border-radius: 5px;
  width:100%;">
                                    <a style="text-decoration: none; color: white;" href="/edit/<?= $d['id']; ?>">Edit</a>
                                </button>
                            </div>
                            <div class="col">

                                <form action="/hapus/<?= $d['id']; ?>" method="post" class="d-inline">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-link" onclick="return confirm('Anda yakin ingin menghapus data?')" style="background-color: #FFBD59;
  font-weight: 500;
  border-color: #FFBD59;
  border-radius: 5px;
  width:100%;
  color:white;
  text-decoration: none;">Hapus</button>
                                </form>

                            </div>
                        </div>
                        <div class="row">
                            <button type="button" class=" btn " style="background-color: #FFBD59;
  font-weight: 500;
  border-color: #FFBD59;
  border-radius: 5px;
  width:100%;
  margin-top: 10px;
  ">
                                <a style="text-decoration: none; color: white;" href="/pilihRiwayat/<?= $d['id']; ?>" target="__blank">Riwayat Tes</a>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>




            <div class="col-md-3 text-center">
                <div class="card">
                    <div class=" positian-relative mx-auto my-auto">
                        <i class="fa-solid fa-plus fa-8x" class="position-absolute top-50 start-50 translate-middle"></i>
                        <h3 class="mt-4"><a href="/biodata">Tambah baru</a></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('layout/script'); ?>
<script src="https://kit.fontawesome.com/694e4c1198.js" crossorigin="anonymous"></script>
<?= $this->include('layout/footer'); ?>