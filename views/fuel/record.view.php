<div class="container-fluid" style="max-width:32rem">
    <div class="container">
        <div class="d-flex justify-content-between">
            <h5><strong>Pengukuran Stok</strong></h5>
            <?php if (!App::CheckUser('admin')) { ?>
                <a href="<?= BASEURL ?>/Fuel/stick" class="text-decoration-none h5 pe-auto">Catatan</a>
            <?php } ?>
            <a href="<?= BASEURL ?>/Home" class="text-decoration-none h5 pe-auto">Kembali</a>
        </div>
        <hr>
    </div>
    <div class="row">
        <form id="form-transaksi" method="post" autocomplete="off" action="<?= BASEURL ?>/Fuel/recordStick">
            <div class="form-group center-input">
                <label>Bahan Bakar</label>
                <select class="form-control" id="jenis_bbm" name="jenis_bbm" required>
                    <option class="hide" value="" readonly="true">JENIS BAHAN BAKAR</option>
                    <?php
                    foreach ($data['fuels'] as $fuel) {
                    ?>
                        <option value="<?= $fuel['jenis_bbm'] ?>"><?= $fuel['jenis_bbm'] ?></option>
                    <?php
                    }
                    ?>
                </select>
                <?php App::InputValidator('jenis_bbm') ?>
                <hr>
                <div class="d-flex justify-content-between font-weight-bold">
                    <span id="stokBBM"></span>
                    <span id="stok"></span>
                </div>
            </div>
            <div class="form-group">
                <label>Waktu Transaksi</label>
                <input type="datetime-local" id="timestamp" name="timestamp" value="<?= date('Y-m-d\TH:i') ?>" class="form-control" required>
                <?php App::InputValidator('time') ?>
            </div>
            <div class="form-group">
                <label>Pengukuran</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="cm" inputmode="numeric" step="0.01" min="1" max="160" name="cm" required>
                    <span class="input-group-text"> CM</span>
                </div>
                <?php App::InputValidator('cm') ?>
            </div>
            <div class="form-group">
                <label>Konversi</label>
                <div class="input-group">
                    <input type="text" class="form-control" inputmode="numeric" step="0.00001" id="converted" name="stock" readonly required>
                    <span class="input-group-text"> L</span>
                </div>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <textarea class="form-control" name="keterangan" id="keterangan" rows="5"></textarea>
            </div>
            <div class="form-group" id="sumary">
                <input type="button" class="btn w-100" value="Catat Stok" name="record" onclick="submit();">
            </div>
        </form>
    </div>
</div>
<script>
    const submit = () => {
        JSAlert.confirm("Input Tidak Akan Bisa Diubah Kembali <br>Ingin Melanjutkan?").then(function(result) {
            if (!result) return;
            document.querySelector('#form-transaksi').submit();
        });
    }
    // instanceSelect.required = true;
    // let harga, total;
    const fuels = <?= json_encode($data['fuels']) ?>;

    const formattedNumber = new Intl.NumberFormat('id-ID', {
        style: 'decimal',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
        useGrouping: true
    })
    document.querySelector('#jenis_bbm').addEventListener('change', (e) => {
        document.querySelector('#stokBBM').textContent = 'Stok ' + e.target.value;
        document.querySelector('#stok').textContent = formattedNumber.format(fuels[e.target.value]['stok']) + ' L';
    })
    var tableConversion = [0,
        21, 42, 63, 84, 105, 125, 146, 167, 188, 209, 230, 251, 272, 293, 314, 335, 356, 376, 397,
        418, 439, 460, 481, 502, 523, 544, 565, 586, 607, 627, 648, 669, 690, 711, 732, 753, 774, 795,
        816, 837, 858, 878, 899, 920, 941, 962, 983, 1004, 1025, 1046, 1067, 1088, 1109, 1129, 1150, 1171,
        1192, 1213, 1234, 1255, 1276, 1297, 1318, 1339, 1360, 1380, 1401, 1422, 1443, 1464, 1485, 1506, 1527,
        1548, 1569, 1590, 1610, 1631, 1652, 1673, 1694, 1715, 1736, 1757, 1778, 1799, 1820, 1841, 1861, 1882,
        1903, 1924, 1945, 1966, 1987, 2008, 2029, 2050, 2071, 2092, 2112, 2133, 2154, 2175, 2196, 2217, 2238,
        2259, 2280, 2301, 2322, 2343, 2363, 2384, 2405, 2426, 2447, 2468, 2489, 2510, 2531, 2552, 2573, 2594,
        2614, 2635, 2656, 2677, 2698, 2719, 2740, 2761, 2782, 2803, 2824, 2845, 2865, 2886, 2907, 2928, 2949,
        2970, 2991, 3012, 3033, 3054, 3075, 3096, 3116, 3137, 3158, 3179, 3200, 3221, 3242, 3263, 3284, 3305,
        3326, 3346
    ]
    document.querySelector('#cm').addEventListener('keyup', function(e) {
        if (e.currentTarget.value > 160 || e.currentTarget.value < 0) e.currentTarget.value = 0
        var floatValue = +e.currentTarget.value || 0; // if nothing entered make it 0
        var decimalValue = parseInt(floatValue);
        var litterValue =
            (floatValue == 160) ?
            tableConversion[decimalValue] :
            tableConversion[decimalValue] +
            (
                ((tableConversion[decimalValue + 1] - tableConversion[decimalValue]) / 10) *
                ((floatValue - decimalValue).toFixed(2) * 10)
            )
        document.querySelector("#converted").value = formattedNumber.format(litterValue);
    });
    <?php if (App::CheckUser('admin')) { ?>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector("#record-tab")?.classList.add("active");
        });
    <?php } ?>
</script>
<?php
if (isset($_SESSION['InputError'])) unset($_SESSION['InputError']);
?>