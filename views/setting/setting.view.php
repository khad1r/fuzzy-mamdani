<div class="container">
    <div class="row">
        <?php require_once './views/components/info_card.php' ?>
        <div class="col-lg-9">
            <div class="col-sm me-auto">
                <h2><strong>Pengaturan</strong></h2>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <div class="card px-5 pb-5 pt-3">
                        <div class="card-header bg-transparent">
                            <ul class="nav nav-pills d-flex justify-content-center justify-content-lg-start" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a href="<?= BASEURL . '/Setting/' ?>" class="nav-link" id="instansi-tab"><strong>Instansi</strong></a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="<?= BASEURL . '/Setting/paying/' ?>" class="nav-link" id="pembayaran-tab"><Strong>Pembayaran</Strong></a>
                                </li>
                                <?php if (App::CheckUser('admin')) { ?>
                                    <li class="nav-item" role="presentation">
                                        <a href="<?= BASEURL . '/Setting/user/' ?>" class="nav-link" id="pengguna-tab"><Strong>Pengguna</Strong></a>
                                    </li>
                                    <li class="nav-item " role="presentation">
                                        <a href="<?= BASEURL . '/Setting/refresh/' ?>" class="nav-link text-warning" id="refresh-tab"><Strong>Refresh Data</Strong></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="card-content mt-3">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane show active" role="tabpanel">
                                    <?= $data['page'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>