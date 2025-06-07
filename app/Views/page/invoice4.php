<body>
    <div class="main-page">
        <div class="sub-page">

            <section>
                <div class="card">
                    <?php $number = 1;
                    foreach ($html['isi_html_4'] as $d) : ?>
                        <div><?= $number++; ?>. <?= $d; ?></div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
    </div>



    <script src="js\script.js"></script>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>