<?= $this->include('layout/header'); ?>
<!-- masuk -->
<section class="daftar">

    <div class="daftarlay1 w-100 h-100">
        <div class="row h-100 w-100 justify-content-center align-items-center">
            <div class="col-8">
                <div class="card">
                    <div class="row">
                        <div class="col cardright my-auto">
                            <?php if (isset($validation)) : ?>
                                <div class="col-12" style="margin-top: 20px;">
                                    <div class="alert alert-danger" role="alert" style="padding-bottom: 4px;">
                                        <strong><?php echo ($validation->listErrors()); ?></strong>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="header">
                                <h1 class="text-center" style="color: #FFBD59;">Masuk</h1>
                            </div>
                            <div class="login-form my-auto">
                                <form class="form-signin" action="masuk" method="POST">
                                    <label for="exampleInputEmail1" class="form-label">Email Pengguna</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Masukkan Email" name="email" value="<?= set_value('email'); ?>">

                                    <label for="exampleInputPassword1" class="form-label">Kata Sandi</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Masukkan Kata Sandi" name="password">

                                    <!-- <a href="#" class="text-decoration-none lupa"> Lupa Kata Sandi</a> -->

                                    <button type="submit" class=" btn btnmasuk text-decoration-none">Masuk</button>
                                </form>

                                <p class="blmakun">Belum Punya Akun? <a href="/daftar"> Daftar disini </a></p>

                            </div>
                        </div>
                        <div class="col">
                            <img class="daftarimg" src="..\img\masuk.png" title="https://www.freepik.com/photos/kids-boy"></a>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>





    <?= $this->include('layout/script'); ?>
    <?= $this->include('layout/footer'); ?>