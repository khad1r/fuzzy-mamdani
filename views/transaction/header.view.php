<div class="container">
    <strong>
        <ul class="nav nav-pills border-bottom pb-3 mb-3 border-info d-flex justify-content-center justify-content-lg-start" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="<?= BASEURL ?>/" class="nav-link text-success">Kembali</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="<?= BASEURL . '/Transaction/index/' ?>" class="nav-link" id="transaksi-tab">Transaksi</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="<?= BASEURL . '/Transaction/sales/' ?>" class="nav-link" id="penjualan-tab">Penjualan</a>
            </li>
            <?php if (App::CheckUser('admin')) { ?>

                <li class="nav-item" role="presentation">
                    <a href="<?= BASEURL . '/Transaction/record/' ?>" class="nav-link" id="record-tab">Catat Transaksi</a>
                </li>
            <?php } ?>
        </ul>
    </strong>
</div>