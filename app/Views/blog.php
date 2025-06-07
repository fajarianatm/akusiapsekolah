<?= $this->include('layout/header'); ?>
<?= $this->include('layout/navbar'); ?>
<!-- isi -->
<br><br><br>
<div class="container">
    <div class="row pt-5">
        <div class="col-9">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach ($data as $d) : ?>
                    <div hidden><?php $datatemp = strip_tags($d['isi_teks']);
                                if (strlen($datatemp) > 50) {
                                    // truncate string
                                    $stringCut = substr($datatemp, 0, 50);
                                    $endPoint = strrpos($stringCut, ' ');
                                    //if the string doesn't contain any space then it will cut without word basis.
                                    $datacut = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                    $datacut .= '... <a href="/this/story">Read More</a>';
                                    $d['isi_teks'] = $datacut;
                                } ?></div>
                    <div class="col">
                        <a href="detailblog/<?= $d['slug']; ?>" style="color: inherit; text-decoration: none;">
                            <div class="card h-100">
                                <div class="box-image">
                                    <div class="image-cover">
                                        <img width="300" height="200" src="..\thumbnail\<?= $d['foto']; ?>" class="card-img-top cardimage attachment-medium-size-medium wp-post-image" alt="...">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $d['judul']; ?></h5>
                                    <p class="card-text"><?= $d['isi_teks']; ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>



        </div>


        <div class="col-3 pt-3 kanan">
            <span class="tag-list">Artikel Lainya</span>
            <div class="is-divider small"></div>
            <ul class="list-group list-group-flush" style="padding: 20px">
                <li class="list-group-item">An item</li>
                <li class="list-group-item">A second item</li>
                <li class="list-group-item">A third item</li>
                <li class="list-group-item">A fourth item</li>
                <li class="list-group-item">And a fifth one</li>
                <li class="list-group-item">An item</li>
                <li class="list-group-item">A second item</li>
                <li class="list-group-item">A third item</li>
                <li class="list-group-item">A fourth item</li>
                <li class="list-group-item">And a fifth one</li>
                <li class="list-group-item">An item</li>
                <li class="list-group-item">A second item</li>
                <li class="list-group-item">A third item</li>
                <li class="list-group-item">A fourth item</li>
                <li class="list-group-item">And a fifth one</li>
            </ul>
        </div>
    </div>
</div>

<?= $this->include('layout/script'); ?>
<?= $this->include('layout/footer'); ?>