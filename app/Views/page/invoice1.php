<head>
    <link rel="stylesheet" type="text/css" href="<?= base_url('../bootstrap/css/bootstrap.min.css') ?> ">
    <link rel="stylesheet" type="text/css" href="<?= base_url('../css/invoice1.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('../css/page.css') ?>">
</head>

<body>
    <div class="main-page">
        <div class="sub-page">

            <table style="width: 100%; text-align:left; vertical-align:top;">
                <tr>
                    <td style="color: #006E7F;font-weight: 700; text-align:left; vertical-align:top;" class="">
                        <p>Nama Anak</p>
                    </td>
                    <td>
                        <p>: <?= $namaAnak; ?></p>
                    </td>
                    <td style="color: #006E7F;font-weight: 700;">
                        <p>Tanggal Tes</p>
                    </td>
                    <td>
                        <p>: <?= $tanggalTes; ?></p>
                    </td>
                </tr>
                <tr>
                    <td style="color: #006E7F;font-weight: 700;">
                        <p>Tanggal Lahir</p>
                    </td>
                    <td>
                        <p>: <?= $tanggalLahir; ?></p>
                    </td>
                    <td style="color: #006E7F;font-weight: 700;">
                        <p>Relasi Dengan Anak</p>
                    </td>
                    <td>
                        <p>: Ibu/Ayah</p>
                    </td>
                </tr>
                <tr>
                    <td style="color: #006E7F;font-weight: 700;">
                        <p>Usia Anak</p>
                    </td>
                    <td>
                        <p>: <?= $usiaAnak->y; ?> Tahun <?= $usiaAnak->m; ?> Bulan <?= $usiaAnak->d; ?> Hari</p>
                    </td>
                    <td style="color: #006E7F;font-weight: 700;">
                        <p>Gender Anak</p>
                    </td>
                    <td>
                        <p>: <?= $gender; ?></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="color: #006E7F;font-weight: 700;"> Apakah anak terlahir prematur ?</td>
                    <td colspan="2"> <?= $mingguKehamilan == 'tidak' ? 'Tidak' : 'Ya, saat ' . $mingguKehamilan . ' minggu kehamilan'; ?></td>
                </tr>
            </table>
            <br>


            <section>
                <div class="card">
                    <?= $html['isi_html_1']; ?>
                </div>
            </section>
        </div>
    </div>



    <script src="js\script.js"></script>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>