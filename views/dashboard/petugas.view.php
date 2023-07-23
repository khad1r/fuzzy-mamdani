<div class="container-fluid" style="max-width:32rem">
    <div class="row">
        <div class="col-md-12 px-4 mt-2 mb-2 border-primary">
            <?php
            require_once './views/components/fuel_desc.php';
            foreach ($data['fuels'] as $fuel) {
            ?>
                <?php renderHomeDesc($fuel) ?>
                <hr class="my-1">
            <?php
            }
            ?>
        </div>
        <div class="col-md-12 px-4 mt-2">
            <a href="<?= BASEURL ?>/Transaction/record/" class="card-home">
                <div class="card" style="background-color: #69F0AE;">
                    <div class="card-body row align-items-center">
                        <div class="col-3">
                            <?= file_get_contents("./assets/img/edit.svg"); ?>
                        </div>
                        <div class="col-9">
                            <h3 class="card-title"><strong>Catat Transaksi</strong></h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-12 px-4 mt-2">
            <a href="<?= BASEURL ?>/Fuel/record/" class="card-home">
                <div class="card" style="background-color: #00bcd4;">
                    <div class="card-body row align-items-center">
                        <div class="col-3">
                            <?= file_get_contents("./assets/img/tank.svg"); ?>
                        </div>
                        <div class="col-9">
                            <h3 class="card-title"><strong>Pengukuran Stok</strong></h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-12 px-4 mt-2">
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
        <!-- <div class="col-md-12 px-4 mt-2">
            <a href="<?= BASEURL ?>/Fuel/conversion" class="card-home">
                <div class="card" style="background-color: #c0ca33;">
                    <div class="card-body row align-items-center">
                        <div class="col-3">
                            <?= file_get_contents("./assets/img/conversion.svg"); ?>
                        </div>
                        <div class="col-9">
                            <h3 class="card-title"><strong>Konversi Tangki</strong></h3>
                        </div>
                    </div>
                </div>
            </a>
        </div> -->

        <div class="col-md-12 px-4 mt-2">
            <a href="<?= BASEURL ?>/Logout/" class="card-home">
                <div class="card" style="background-color: #fd5a48;">
                    <div class="card-body row align-items-center">
                        <div class="col-3">
                            <?= file_get_contents("./assets/img/outbox.svg"); ?>
                        </div>
                        <div class="col-9 ">
                            <h3 class="card-title"><strong>Logout</strong></h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>