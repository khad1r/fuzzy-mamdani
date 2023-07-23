<div class="container">
    <div class="d-flex justify-content-center justify-content-lg-between flex-column flex-lg-row mb-3">
        <span>
            <h2 class="text-center"><strong>Laporan Persediaan</strong></h2>
        </span>

        <div class="d-flex flex-row justify-content-center align-items-center">
            <?php require_once './views/components/month_picker.php' ?>
            <?php if (App::CheckUser('admin', 'bag. keuangan')) { ?>
                <button type="button" class="btn btn-outline-success btn-xl" id="btnExport">
                    Unduh Mutasi
                </button>
            <?php } ?>
        </div>
    </div>
    <hr class="d-lg-none">
    <div>
        <strong>
            <ul class="nav nav-pills d-flex justify-content-center justify-content-lg-start" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="<?= BASEURL ?>/" class="nav-link text-success">Kembali</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="<?= BASEURL . '/Fuel/status/' . ((isset($data["month"])) ? 'month/' . $data["month"] : '') ?>" class="nav-link" id="status-tab">Status Stok</a>
                </li>
                <?php if (App::CheckUser('admin', 'bag. keuangan')) { ?>

                    <li class="nav-item" role="presentation">
                        <a href="<?= BASEURL ?>/Fuel/stock_up" class="nav-link" id="stock-up-tab">Pembelian</a>
                    </li>
                <?php } ?>

                <?php if (App::CheckUser('admin', 'bag. keuangan', 'bag. teknik')) { ?>

                    <li class="nav-item" role="presentation">
                        <a href="<?= BASEURL ?>/Fuel/price" class="nav-link" id="price-tab">Harga Jual</a>
                    </li>
                <?php } ?>
                <li class="nav-item" role="presentation">
                    <a href="<?= BASEURL . '/Fuel/stick/' . ((isset($data["month"])) ? 'month/' . $data["month"] : '') ?>" class="nav-link" id="stick-tab">Pengukuran Stok</a>
                </li>
                <?php if (App::CheckUser('admin')) { ?>
                    <li class="nav-item" role="presentation">
                        <a href="<?= BASEURL . '/Fuel/record/' ?>" class="nav-link" id="record-tab">Catat Pengukuran Stok</a>
                    </li>
                <?php } ?>
            </ul>
        </strong>
    </div>
    <hr>
</div>
<?php if (App::CheckUser('admin', 'bag. keuangan')) { ?>
    <form id="invisible_form_export" action="<?= BASEURL ?>/Fuel/getRecap/" method="post">
        <input id="hiddenMonth" name="month" type="hidden">
    </form>
    <script>
        document.querySelector('#btnExport').addEventListener('click', (e) => {
            loadingPage.style.display = "";
            document.querySelector('#hiddenMonth').value = monthPicker.value;
            document.querySelector('#invisible_form_export').submit();
            waitCoocke('DownloadCookie', 'Mutasi-Stok', () => {
                loadingPage.style.display = "none";
            }, 600)
        })
    </script>
<?php } ?>