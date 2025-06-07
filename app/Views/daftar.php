<?= $this->include('layout/header'); ?>
<!-- daftar  -->
<section class="daftar">

    <div class="daftarlay1 w-100 h-100">
        <div class="row h-100 w-100 justify-content-center align-items-center">
            <div class="col-8">
                <div class="card">
                    <div class="row">
                        <div class="col">
                            <img class="daftarimg" src="..\img\daftar.png"></a>
                        </div>
                        <div class="col cardleft">
                            <div class="header">
                                <h1 class="text-center" style="color: #FFBD59;">Daftar</h1>
                            </div>
                            <div class="login-form">
                                <form class="form-signin" action="daftar" method="POST">
                                    <label for="#" class="form-label">Nama Lengkap</label>
                                    <input class="form-control" type="text" placeholder="Fajariana Tri Mulia" aria-label="default input example" name="namaLengkap" value="<?= set_value('namaLengkap'); ?>">

                                    <!-- <label for="#" class="form-label">Nama Pengguna</label>
                                    <input class="form-control" type="text" placeholder="Fajariana03" aria-label="default input example" name="email"> -->

                                    <label for="#" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="abc123@gmail.com" name="email" value="<?= set_value('email'); ?>">

                                    <label for="exampleInputPassword1" class="form-label">Kata Sandi</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Masukkan Kata Sandi" name="password">

                                    <label for="password_confirm" class="form-label">Konfirmasi kata Sandi</label>
                                    <input type="password" name="password_confirm" id="password_confirm" value="" class="form-control" placeholder="Masukkan Lagi Kata Sandi">
                                    <?php if (isset($validation)) : ?>
                                        <div class="col-12">
                                            <div class="alert alert-danger" role="alert">
                                                <strong><?php echo ($validation->listErrors()); ?></strong>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <button class="btnmasuk text-decoration-none" type="submit">Buat Akun</button>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

</section>
<?= $this->include('layout/script'); ?>
<?= $this->include('layout/footer'); ?>