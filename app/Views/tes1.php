<?= $this->include('layout/header'); ?>
<?= $this->include('layout/navbar'); ?>
<section class="daftar">
    <form action="/collectTest" method="POST">

        <div class="daftarlay1 w-100  " style="padding-top: 50px;">
            <div class="row  w-100 justify-content-center align-items-center">
                <?php if (session()->getFlashData('danger')) : ?>
                    <div class="col-12" style="margin-top: 20px;">
                        <div class="alert alert-danger" role="alert" style="padding-bottom: 4px;">
                            <p><?= session()->getFlashData('danger') ?></p>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-10">
                    <div class="card">
                        <?php $No = 0 ?>

                        <div id="slide1">
                            <H1 class="text-center" style="font-size: 40px;font-weight: 700;color: #FFBD59;">PERHATIAN</H1>

                            <div class="row justify-content-center align-items-center">
                                <div class="col-9">

                                    <table class="table table-bordered" style="background-color: white; border-radius: 15px; border: 3px solid; margin-bottom:20px;">
                                        <tr>
                                            <th scope="row">0</th>
                                            <td>Anda yakin anak tidak melakukan tindakan/ciri tersebut. (anda menilai anak belum dapat melakukannya)</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">5</th>
                                            <td>Anda berpendapat anak terkadang melakukan tindakan tersebut (orang lain juga melihatnya dan memberi tahu anda) </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">10
                                            </th>
                                            <td>Anda yakin anak sering menunjukkan tindakan ini (anda melihat anak sering melakukan tindakan tersebut)</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>



                            <?php $i = 0; ?>
                            <?php foreach ($bag1 as $b) : ?>
                                <div hidden> <?php $No++ ?> </div>
                                <div class="inisoal">
                                    <div hidden><?= $i++; ?> </div>
                                    <div class="card-header">
                                        <p class="my-auto" style="  color: #0B7588;">Soal <?= $No; ?></p>
                                    </div>
                                    <p class="soal"><?= $b['pertanyaan']; ?></p>
                                    <div class="option">
                                        <?php for ($x = 0; $x <= $b['banyak_opsi']; $x++) : ?>
                                            <label>
                                                <input type="radio" class="check1" name="soal1<?= $i; ?>" value=<?= $x ?> <?= set_value('soal1' . $i) ? (set_value('soal1' . $i) == $x ? 'checked' : '') : '' ?> />
                                                <span><?= $x * 5; ?></span>
                                            </label>
                                        <?php endfor; ?>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div id="slide2">
                            <H1 class="text-center" style="font-size: 40px;font-weight: 700;color: #FFBD59;">PERHATIAN</H1>
                            <p class="" style="text-align: justify; font-size: 15px;padding: 20px;">Berikut ini tolong pikirkan tentang keterampilan anak Anda dalam memperhatikan dan berperilaku. ADHD (Attention Deficit Hyperactivity Disorder) adalah kondisi dimana anak sulit memusatkan perhatian, serta memiliki perilaku impulsif dan hiperaktif. Kuisioner ini hanya bersifat sebagai skrining/ filter awal bagi orang tua. Kurangnya perhatian di antara anak-anak prasekolah tidak selalu menunjukkan ADHD, dan dapat mewakili berbagai kondisi alternatif lainnya termasuk gangguan bahasa, gangguan pendengaran, fungsi intelektual yang rendah, atau bentuk psikopatologi lainnya.</p>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-9">

                                    <table class="table table-bordered" style="background-color: white; border-radius: 15px; border: 3px solid; margin-bottom:20px;">
                                        <tr>
                                            <th scope="row">0</th>
                                            <td>Anda yakin anak tidak melakukan tindakan/ciri tersebut. (anda menilai anda belum pernah melihatnya, orang lain juga tidak ada yang melaporkan hal yang sama)</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Anda berpendapat anak terkadang melakukan tindakan tersebut (orang lain juga melihatnya dan memberi tahu anda) </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2
                                            </th>
                                            <td>Anda yakin anak sering menunjukkan tindakan ini (anda melihat anak sering melakukan tindakan tersebut tetapi tidak setiap hari)</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3
                                            </th>
                                            <td>Anda yakin anak sangat sering menunjukkan tindakan ini (repetisi tindakan selalu ada setiap harinya, banyak orang yang menilai hal sama)</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <?php $j = 0; ?>
                            <?php foreach ($bag2 as $b) : ?>
                                <div hidden><?= $No++; ?> </div>
                                <div class="inisoal">
                                    <div hidden><?= $j++; ?> </div>
                                    <div class="card-header">
                                        <p class="my-auto" style="  color: #0B7588;">Soal <?= $No; ?></p>
                                    </div>
                                    <p class="soal"><?= $b['pertanyaan']; ?></p>
                                    <div class="option">
                                        <?php for ($x = 0; $x <= $b['banyak_opsi']; $x++) : ?>
                                            <label>
                                                <input type="radio" class="check2" name="soal2<?= $j; ?>" value=<?= $x; ?> />
                                                <span><?= $x; ?></span>
                                            </label>
                                        <?php endfor; ?>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>



                        <nav aria-label="...">
                            <ul class="pagination justify-content-end">
                                <li class="page-item">
                                    <a class="page-link" href="#" onclick="next()" id="next">Next</a>
                                </li>
                            </ul>
                            <ul class="pagination justify-content-between">
                                <!-- <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">2</span>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li> -->
                                <li class="page-item">
                                    <a class="page-link" href="#" onclick="back()" id="back">Back</a>
                                </li>
                                <li class="page-item ">
                                    <input type="hidden" name="id_test" value=<?= $id_test; ?>>
                                    <button type="submit" name="submit" id="submit" class="btn btnmasuk text-decoration-none">submit</button>

                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </form>
</section>

<?= $this->include('layout/script'); ?>
<script>
    // function handleClick() {
    //     var xhttp = new XMLHttpRequest();
    //     var chk = document.querySelectorAll(".check1:checked");
    //     var total = 0;
    //     if (!chk.length) {
    //         alert("You didn't select an answer for all questions")
    //     } else {
    //         chk.forEach(function(el) {
    //             total += parseInt(el.getAttribute('value'));
    //         });
    //         alert("Your total is: " + total);
    //     }
    // };
    var slide = 1;
    update()

    function next() {
        slide++;
        return update();
    }

    function back() {
        slide--;
        return update();
    }

    function update() {
        if (slide == 1) {
            document.querySelector('#slide1').style.display = 'block';
            document.querySelector('#slide2').style.display = 'none';
            document.querySelector('#next').style.display = 'inline';
            document.querySelector('#back').style.display = 'none';
            document.querySelector('#submit').style.display = 'none';

        } else if (slide == 2) {
            document.querySelector('#slide1').style.display = 'none';
            document.querySelector('#slide2').style.display = 'block';
            document.querySelector('#next').style.display = 'none';
            document.querySelector('#back').style.display = 'inline';
            document.querySelector('#submit').style.display = 'inline';
        }
    }
</script>
<?= $this->include('layout/footer'); ?>