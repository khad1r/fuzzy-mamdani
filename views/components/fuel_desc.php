<?php

function renderHomeDesc($fuel)
{
    setlocale(LC_ALL, 'id-ID', 'id_ID');
?>
    <div class="container-fuel-desc" id="<?= $fuel['jenis_bbm'] ?>">
        <div class="d-flex justify-content-between">
            <h4 class="text-center"><strong><?= $fuel['jenis_bbm'] ?></strong></h4>
            <span><strong><?= 'Rp. ' . number_format($fuel['harga'], 0, ",", ".") . ",-/ltr" ?></strong></span>
        </div>
        <div class="d-flex justify-content-between">
            <span class="text-center">Stok </span>
            <span><?= ($fuel['stok'] <= 0) ? "<span class='text-danger'>0,00 L</span>" : number_format($fuel['stok'], 2, ",", ".") . " L" ?></span>
        </div>
        <?php
        if (!empty($fuel['lastUpdateStok'])) {
        ?>
            <div class="d-flex justify-content-between">
                <span class="text-center">Pengisian Terakhir</span>
                <span><?= strftime("%d %B %Y", strtotime($fuel['lastUpdateStok']['waktu_pembelian'])) ?></span>
            </div>
        <?php
        }
        ?>
    </div>
<?php
}
function renderStickDesc($fuel)
{
    setlocale(LC_ALL, 'id-ID', 'id_ID');

?>
    <div class="container-fuel-desc">
        <div class="d-flex justify-content-between">
            <h4 class="text-center"><strong><?= $fuel['jenis_bbm'] ?></strong></h4>
        </div>
        <div class="d-flex justify-content-between">
            <span class="text-center">Pengukuran Terakhir</span>
            <span>
                <?php echo number_format($fuel['stick']['tinggi_cm'], 0, ",", ".") . " CM" ?>
                &nbsp;⇔&nbsp;
                <strong>
                    <?php echo  number_format($fuel['stick']['liter'], 2, ",", ".") . " L" ?>
                </strong>
            </span>
            <span><?= strftime("%d %B %Y", strtotime($fuel['stick']['timestamp'])) ?></span>
        </div>
        <hr class="my-1">
    </div>
<?php
}
function renderDashboardDesc()
{
    setlocale(LC_ALL, 'id-ID', 'id_ID');
?>
    <div class="container-fuel-desc">
        <div class="d-flex flex-sm-row flex-column justify-content-between">
            <div class="flex-wrap align-content-center flex-row flex-md-column d-flex justify-content-md-start justify-content-between">
                <strong class="font-weight-bold h3 mb-0" id="FuelName">Pertamax</strong>
                <strong id="FuelPrice">Rp. 14.250,-/ltr</strong>
            </div>
            <div class="col-md-5">
                <div class="d-flex justify-content-between">
                    <span class="text-center font-weight-bold">Stok Akhir</span>
                    <span id="FuelStock"></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-center font-weight-bold">Pengisian Terakhir</span>
                    <span id="LastRefill"></span>
                </div>
            </div>
        </div>
        <hr class="my-1">
    </div>
<?php
}
