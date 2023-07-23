<div class="container">
    <div class="col-sm me-auto">
        <h2><strong><?= $data['title'] ?></strong></h2>
    </div>
    <div class="row">
        <div class="col">
            <ul class="nav nav-pills d-flex justify-content-center justify-content-lg-start" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="<?= BASEURL . '/Main/' ?>" class="nav-link" id="Kuisioner"><strong>Kuisioner</strong></a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="<?= BASEURL . '/Main/ringkasan/' ?>" class="nav-link" id="Ringkasan"><Strong>Ringkasan</Strong></a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="<?= BASEURL . '/Main/analisis/' ?>" class="nav-link" id="Analisis"><Strong>Analisis</Strong></a>
                </li>
            </ul>
        </div>
    </div>
    <hr>
</div>