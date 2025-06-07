<?= $this->include('layout/header'); ?>
<?= $this->include('layout/navbar'); ?>
<!-- Biodata edit -->
<div class="daftarlay1 w-100">
    <div class="row  justify-content-center align-items-center" style="padding-top: 100px;">
        <div class="col-8">

            <h1 class="judul text-center">EDIT PROFIL ANAK </h1>
            <p class="tagline">Halo Ayah Ibu, silahkan Edit data anak ya! </p>
            <!-- <div class="row">
                    <div class="col">
                        <div class="female">
                            <div class="circle-icon positian-relative ">
                                <i class="fa-solid fa-mars"></i>
                            </div>
                            <p>Perempuan</p>
                        </div>

                    </div>
                    <div class="col">

                        <div class="male">
                            <div class="circle-icon positian-relative mx-auto">
                                <i class="fa-solid fa-mars"></i>
                            </div>
                            <p>Laki-laki</p>
                        </div>
                    </div>
                </div> -->
            <!-- <div class="gender text-center">
                </div> -->
            <form class="form-signin" action="/update" method="POST">
                <input type="hidden" name="idAnak" id="idAnak" value="<?= $data['id'] ?>">
                <div class="row justify-content-center text-center">

                    <div class="col-5">
                        <div class="card">
                            <input type="radio" class="jenisKelamin" name="jenisKelamin" value="Perempuan" <?php echo ($data['jenisKelamin'] == 'Perempuan') ? 'checked' : '' ?> />
                            <img class="gambarbocil" src="..\img\female.png">
                            <p>Perempuan </p>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="card">
                            <input type="radio" class="jenisKelamin" name="jenisKelamin" value="Laki-laki" <?php echo ($data['jenisKelamin'] == 'Laki-laki') ? 'checked' : '' ?> />
                            <img class="gambarbocil" src="..\img\male.png">
                            <p>Laki-Laki </p>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-10">
                        <div class="login-form mt-3 datatas">
                            <label for="teks1" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control ms-0" id="teks1" placeholder="Fajariana Tri Mulia" name="nama" value="<?= set_value('nama', $data['nama']); ?>">

                            <label for="teks1" class="form-label">Nama Panggilan Anak</label>
                            <input type="text" class="form-control" id="teks1" placeholder="Ana" name="panggilan" value="<?= set_value('panggilan', $data['panggilan']); ?>">

                            <label for="teks1" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="teks1" name="tglLahir" value="<?= set_value('tglLahir', $data['tglLahir']) ?>">

                            <label for="teks1" class="form-label">Minggu Kehamilan Anak Saat Lahir</label>
                            <input type="range" name="mingguHamil" id="mingguHamil" value="<?= $data['mingguHamil']; ?>" min="20" max="42"> <span id="hasil"></span>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">

                    <div class="col-5">
                        <p class="tagbawah1">Data Anak Saat Lahir (Optional)</p>
                        <div class="login-form mt-3">
                            <label for="teks1" class="form-label">Panjang Badan Lahir (cm)</label>
                            <input type="text" class="form-control" id="teks1" placeholder="54" name="dsl_tinggi" value="<?= set_value('dsl_tinggi', $data['dsl_tinggi']); ?>">

                            <label for="teks1" class="form-label">Berat Badan Lahir (kg) </label>
                            <input type="text" class="form-control" id="teks1" placeholder="3,4" name="dsl_berat" value="<?= set_value('dsl_berat', $data['dsl_berat']); ?>">

                            <label for="teks1" class="form-label">Lingkar Kepala Lahir (cm)</label>
                            <input type="text" class="form-control" id="teks1" placeholder="60" name="dsl_kepala" value="<?= set_value('dsl_kepala', $data['dsl_kepala']); ?>">


                        </div>
                    </div>
                    <div class="col-5">
                        <p class="tagbawah2">Pertumbuhan Anak Saat Ini</p>
                        <div class="login-form mt-3">
                            <label for="teks1" class="form-label">Panjang Badan Lahir (cm)</label>
                            <input type="text" class="form-control" id="teks1" placeholder="122" name="dsi_tinggi" value="<?= set_value('dsi_tinggi', $data['dsi_tinggi']); ?>">

                            <label for="teks1" class="form-label">Berat Badan Lahir (kg)</label>
                            <input type="text" class="form-control" id="teks1" placeholder="52" name="dsi_berat" value="<?= set_value('dsi_berat', $data['dsi_berat']); ?>">

                            <label for="teks1" class="form-label">Lingkar Kepala Lahir (cm)</label>
                            <input type="text" class="form-control" id="teks1" placeholder="230" name="dsi_kepala" value="<?= set_value('dsi_kepala', $data['dsi_kepala']); ?>">
                        </div>
                    </div>
                </div>
                < -->
                    <?php if (isset($validation)) : ?>
                        <div class="col-12">
                            <div class="alert alert-danger" role="alert">
                                <strong><?php echo ($validation->listErrors()); ?></strong>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="text-center align-items-center">
                        <button type="submit" class="btn  col-10 btnsubmit text-center">
                            <a class="text-decoration-none">SUBMIT</a>
                        </button>
                    </div>
            </form>
        </div>
    </div>
</div>

<?= $this->include('layout/script'); ?>
<script>
    var slider = document.getElementById("mingguHamil");
    var output = document.getElementById("hasil");
    output.innerHTML = slider.value; // Display the default slider value

    // Update the current slider value (each time you drag the slider handle)
    slider.oninput = function() {
        output.innerHTML = this.value;
    }
</script>
<?= $this->include('layout/footer'); ?>