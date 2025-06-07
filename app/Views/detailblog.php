<?= $this->include('layout/header'); ?>
<?= $this->include('layout/navbar'); ?>
<!-- isi -->
<br><br><br>
<div class="container">
    <div class="row pt-5">
        <div class="col-9">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="card h-100">
                    <div class="box-image">
                        <div class="image-cover">
                            <img src="..\thumbnail\<?= $data['foto']; ?>" class="card-img-top cardimage attachment-medium-size-medium wp-post-image" alt="...">
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $data['judul']; ?></h5>
                        <p class="card-text"><?= $data['isi_teks']; ?></p>
                    </div>
                </div>
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