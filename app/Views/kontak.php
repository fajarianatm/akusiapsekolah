<?= $this->include('layout/header'); ?>
<?= $this->include('layout/navbar'); ?>
<section id="isi">

    <div class="daftarlay1 w-100 h-100">
        <div class="container">

            <div class="row h-100 w-100 justify-content-center align-items-center">
                <div class="col-6">
                    <p class="tagkontak" style="line-height: 1.2;">Kami Menunggu Masukan Anda</p>
                    <p class="parkontak">Untuk informasi lebih lanjut tentang <img class="logonav" src="<?= base_url('../img/logotulisan.png') ?>"> atau program pengembangan anak lainnya, silahkan hubungi kami dengan mengisi formulir</p>
                </div>

                <div class="col-6">
                    <div class="card">
                        <form action="/kirimkeDev" method="POST">
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Nama Pengguna</label>
                                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="jacksonwang123" disabled value=<?= session()->get('namaLengkap'); ?>>
                                </div>
                                <label for="exampleFormControlInput1" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" disabled value=<?= session()->get('email'); ?>>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Pesan</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="pesan"></textarea>
                            </div>
                            <button type="submit" class=" btn btnmasuk text-decoration-none">Kirim</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>




</section>
<?= $this->include('layout/script'); ?>
<?= $this->include('layout/footer'); ?>