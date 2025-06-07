<body>
    <div class="main-page">
        <div class="sub-page">

            <section>
                <div class="card">
                    <?php foreach ($html['isi_html_3'] as $d) : ?>
                        <?= $this->include('page/intervensi/' . $d); ?>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
    </div>



    <script src="js\script.js"></script>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>