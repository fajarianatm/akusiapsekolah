<body>
    <div class="main-page">
        <div class="sub-page">
            <section>
                <div class="card">
                    <div class="atas">
                        <table class="table table-bordered">
                            <tr>
                                <th scope="row">Area yang unggul:</th>
                            </tr>
                            <tr>
                                <td scope="row"><?= $panggilan; ?> <?= $html['isi_html_2']['putih'] ? 'unggul pada area ' . $html['isi_html_2']['putih'] . '' : 'tidak unggul di area manapun'; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="tengah">
                        <table class="table table-bordered">
                            <tr>
                                <th scope="row">Area yang menjadi perhatian:
                                </th>

                            </tr>
                            <tr>
                                <td scope="row"><?= $panggilan; ?> <?= $html['isi_html_2']['hitam'] ? 'mendapatkan skor rendah pada penilaian area  ' . $html['isi_html_2']['hitam'] . '' : 'tidak mendapatkan skor rendah pada penilaian area manapun'; ?>
                                </td>

                            </tr>
                        </table>
                    </div>
                    <div class="bawah">
                        <p>Tindakan yang dapat diambil : </p>
                        <table class="table table-bordered">
                            <tr>
                                <th scope="row">
                                    <br>
                                    <?= $html['isi_html_2']['centang1']['konfirm'] == 'yes' ? '<input type="checkbox" name="QLY" value="ON0" checked="checked" style="padding: 50px;" /> &nbsp; &nbsp;' : '&nbsp; &nbsp;'; ?>
                                </th>
                                <td style="padding-top: 10px;">Mencoba aktivitas yang sediakan dan lakukan kembali tes dalam 1
                                    bulan. Tidak ada tindakan lebih lanjut yang diperlukan saat ini.
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <br>
                                    <?= $html['isi_html_2']['centang2']['konfirm'] == 'yes' ? '<input type="checkbox" name="QLY" value="ON0" checked="checked" style="padding: 50px;" /> &nbsp; &nbsp;' : '&nbsp; &nbsp;'; ?>
                                </th>
                                <td style="padding-top: 10px;">Kami merekomendasikan agar <?= $panggilan; ?> dirujuk untuk pemeriksaan
                                    <div>
                                        <?= $html['isi_html_2']['centang2']['pendengaran'] == 'yes' ?  '<span style="font-family:helvetica">&#10003;</span>' : '&nbsp; &nbsp; '; ?>Pendengaran
                                        <?= $html['isi_html_2']['centang2']['penglihatan'] == 'yes' ? '<span style="font-family:helvetica">&#10003;</span>' : '&nbsp; &nbsp;'; ?>Penglihatan
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <br>
                                    <?= $html['isi_html_2']['centang3']['konfirm'] == 'yes' ? '<input type="checkbox" name="QLY" value="ON0" checked="checked" style="padding: 50px;" /> &nbsp; &nbsp;' : '&nbsp; &nbsp;'; ?>
                                </th>
                                <td style="padding-top: 10px;">Kami merekomendasikan agar Panggilan dirujuk ke fisioterapi anak, terapi wicara, okupasi terapi, dan juga psikolog anak karena mungkin Panggilan mengalami permasalahan serius pada
                                    <?= $html['isi_html_2']['centang3']['konfirm'] == 'yes' ? 'Kemampuan ' . $html['isi_html_2']['centang3']['isi'] . '' : ' Kemampuannya'; ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <br>
                                    <?= $html['isi_html_2']['centang4']['konfirm'] == 'yes' ? '<input type="checkbox" name="QLY" value="ON0" checked="checked" style="padding: 50px;" /> &nbsp; &nbsp;' : '&nbsp; &nbsp;'; ?>
                                </th>
                                <td style="padding-top: 10px;">Tidak ada tindakan lebih lanjut yang diperlukan saat ini.

                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
        </div>
        </section>
    </div>
</body>