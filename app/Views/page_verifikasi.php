<form class="form-signin" action="verifikasi" method="POST">
    <h1>tolong verifikasi</h1>
    <hr>
    <div>
        <input type="hidden" name="email" value="<?= $email; ?>">
        <input type="tel" name="aktivasiKode" id="aktivasiKode" value="<?= set_value('aktivasiKode'); ?>" maxlength="6">
        <label for="aktivasiKode">nomor verifikasi</label>
    </div>
    <?php if (isset($validation)) : ?>
        <div class="col-12">
            <div class="alert alert-danger" role="alert">
                <strong><?php echo ($validation->listErrors()); ?></strong>
            </div>
        </div>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary">cek</button>
    <a href="/">kembali ke halaman awal </a>
    <hr>
</form>