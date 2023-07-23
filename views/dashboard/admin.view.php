<div class="container">
    <div class="row">
        <?php require_once './views/components/info_card.php' ?>
        <div class="col-lg-9">
            <div class="col-sm me-auto">
                <h2 class="text-center text-lg-start"><strong>Menu</strong></h2>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6 col-lg-6  px-4 mt-2">
                    <a href="<?= BASEURL ?>/" class="card-home">
                        <div class="card" style="background-color: #f9a825;">
                            <div class="card-body row align-items-center">
                                <div class="col-3">
                                    <?= file_get_contents("./assets/img/dashboard.svg"); ?>
                                </div>
                                <div class="col-9">
                                    <h3 class="card-title"><strong>Dashboard</strong></h3>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-lg-6  px-4 mt-2">
                    <a href="<?= BASEURL ?>/Transaction" class="card-home">
                        <div class="card" style="background-color: #69F0AE;">
                            <div class="card-body row align-items-center">
                                <div class="col-3">
                                    <?= file_get_contents("./assets/img/nozzle.svg") ?>
                                </div>
                                <div class="col-9">
                                    <h3 class="card-title"><strong>Transaksi</strong></h3>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-6  px-4 mt-2">
                    <a href="<?= BASEURL ?>/Fuel" class="card-home">
                        <div class="card" style="background-color: #00bcd4;">
                            <div class="card-body row align-items-center">
                                <div class="col-3">
                                    <?= file_get_contents("./assets/img/tank.svg") ?>
                                </div>
                                <div class="col-9">
                                    <h3 class="card-title"><strong>Persediaan</strong></h3>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <?php if (App::CheckUser('admin', 'bag. teknik')) { ?>

                    <div class="col-md-6 col-lg-6  px-4 mt-2">
                        <a href="<?= BASEURL ?>/Setting/" class="card-home">
                            <div class="card" style="background-color: #fd5a48;">
                                <div class="card-body row align-items-center">
                                    <div class="col-3">
                                        <?= file_get_contents("./assets/img/settings.svg"); ?>
                                    </div>
                                    <div class="col-9">
                                        <h3 class="card-title"><strong>Pengaturan</strong></h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>



            </div>
            <?php if (App::CheckUser('admin', 'bag. teknik', 'bag. keuangan')) { ?>
                <div class="col-sm mt-3">
                    <h2 class="text-center text-lg-start"><strong>Aksi</strong></h2>
                </div>
                <hr>
                <div class="row">


                    <div class="col-md-6 col-lg-6  px-4 mt-2">
                        <a href="#" class="card-home" id="downloadMonthlyRecap">
                            <div class="card" style="background-color: #f9a825;">
                                <div class="card-body d-flex justify-content-between align-items-center">

                                    <h5 class="card-title">
                                        <strong>Unduh Rekap Tagihan</strong>
                                    </h5>
                                    <?php require_once './views/components/month_picker.php' ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-6  px-4 mt-2">
                        <a href="#" class="card-home" id="downloadDailyRecap">
                            <div class="card" style="background-color: #69F0AE;">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">
                                        <strong>Unduh Rekap Harian</strong>
                                    </h5>
                                    <?php require_once './views/components/date_picker.php' ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
                <?php if (App::CheckUser('admin', 'bag. keuangan')) { ?>
                    <div class="col-md-6 col-lg-6  px-4 mt-2">
                        <a href="#" class="card-home" id="downloadFuelRecap">
                            <div class="card" style="background-color: #00bcd4;">
                                <div class="card-body align-items-center">
                                    <h5 class="card-title">
                                        <strong>Unduh Mutasi Persediaan</strong>
                                    </h5>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php if (App::CheckUser('admin', 'bag. teknik', 'bag. keuangan')) { ?>

    <form id="invisible_form" action="<?= BASEURL ?>/Transaction/getBills/" method="post">
        <!-- Judul Print Agenda Print -->
        <input id="hiddenMonth" name="month" type="hidden" value="">
    </form>
    <form id="invisible_form2" action="<?= BASEURL ?>/Transaction/getDaily/" method="post">
        <!-- Judul Print Agenda Print -->
        <input id="hiddenDate" name="date" type="hidden" value="">
    </form>
<?php } ?>
<?php if (App::CheckUser('admin', 'bag. keuangan')) { ?>
    <form id="invisible_form_export" action="<?= BASEURL ?>/Fuel/getRecap/" method="post">
        <input id="hiddenMonth2" name="month" type="hidden">
    </form>
<?php } ?>


<script>
    <?php if (App::CheckUser('admin', 'bag. teknik', 'bag. keuangan')) { ?>

        document.querySelector('#downloadMonthlyRecap').addEventListener('click', (e) => {

            if (e.target === labelMonth || e.target === monthPicker) return;
            loadingPage.style.display = "";
            document.querySelector('#hiddenMonth').value = monthPicker.value;
            document.querySelector('#invisible_form').submit();
            waitCoocke('DownloadCookie', 'RekapBulanan', () => {
                loadingPage.style.display = "none";
            })


        })

        document.querySelector('#downloadDailyRecap').addEventListener('click', (e) => {
            if (e.target === labelDate || e.target === datePicker) return;
            loadingPage.style.display = "";
            document.querySelector('#hiddenDate').value = datePicker.value;
            document.querySelector('#invisible_form2').submit();
            waitCoocke('DownloadCookie', 'RekapHarian', () => {
                loadingPage.style.display = "none";
            })
        })
    <?php } ?>
    <?php if (App::CheckUser('admin', 'bag. keuangan')) { ?>
        document.querySelector('#downloadFuelRecap').addEventListener('click', (e) => {
            loadingPage.style.display = "";
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0'); // add leading zero if needed
            document.querySelector('#hiddenMonth2').value = `${year}-${month}`;
            document.querySelector('#invisible_form_export').submit();
            waitCoocke('DownloadCookie', 'Mutasi-Stok', () => {
                loadingPage.style.display = "none";
            })
        })
    <?php } ?>
</script>