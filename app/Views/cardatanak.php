<?= $this->include('layout/header'); ?>
<?= $this->include('layout/navbar'); ?>

<!-- card data anak  -->
<section id="isi">

    <div class="daftarlay1 w-100 h-100">
        <div class="row h-100 w-100 justify-content-center align-items-center">
            <div class="col-8">
                <div class="text-center">
                    <h3 class="tagjudul">TES KESIAPAN ANAK</h3>

                    <p class="deskripsi"> Pada tes ini anda akan diberikan suatu pernyataan yang menyatakan deskripsi dari setiap perilaku, harap untuk tunjukkan seberapa yakin Anda terkait kesesuaian pernyataan tersebut dengan perilaku anak Anda. Silakan menilai kepastian Anda dengan memilih salah satu angka pada opsi jawaban</p>
                </div>

                <div class="text-justify bawah">

                    <h3 class="tagline">PERHATIAN :</h3>
                    <ul class="list">
                        <li>Silakan pilih jawaban yang merepresentasikan kebiasaan anak.</li>
                        <li>Harus menjawab soal terlebih dahulu, agar soal selanjutnya hanya akan bisa diakses.</li>
                        <li>Hasil dari tes pertama dan tes kedua dapat diakses melalui halaman profil.</li>
                    </ul>
                </div>
                <div class="text-center align-items-center">
                    <button type="button" class="btn  col-8 btnmulai text-center">
                        <a class="text-decoration-none" href="/startTest">Mulai Tes</a>
                    </button>
                </div>


            </div>
        </div>
    </div>
</section>

<?= $this->include('layout/script'); ?>
<?= $this->include('layout/footer'); ?>