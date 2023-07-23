<?php

$now = (new DateTime())->format('Y-m-d\TH:i');
?>
<div class="container-fluid" style="max-width:32rem">
    <div class="row">
        <form id="form-transaksi" method="post" action="<?= BASEURL ?>/Fuel/stokUpdate">
            <div class="form-group">
                <label>Pengisian</label>
                <div class="input-group">
                    <input type="datetime-local" id="datepicker" name="timestamp" value="<?= $now ?>" class="form-control" required>
                </div>
                <?php App::InputValidator('timestamp') ?>

            </div>
            <div class="form-group center-input">
                <label>Bahan Bakar</label>
                <select class="form-control" id="jenis_bbm" name="jenis_bbm" required>
                    <option class="hide" value="" readonly="true">JENIS BAHAN BAKAR</option>
                    <?php
                    foreach (FUELTYPE as $fuel) {
                    ?>
                        <option value="<?= $fuel ?>"><?= $fuel ?></option>
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
                <label>Jumlah Pembelian</label>
                <div class="input-group">
                    <input type="number" class="form-control" inputmode="numeric" step="0.00001" name="stok" required>
                    <span class="input-group-text"> L</span>
                </div>
                <?php App::InputValidator('stok') ?>

            </div>
            <div class="form-group">
                <label>Harga</label>
                <div class="input-group">
                    <span class="input-group-text">Rp.</span>
                    <input type="text" class="form-control" name="harga" step="0.00001" inputmode="numeric" id="uang" required>
                </div>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <textarea class="form-control" name="keterangan" id="keterangan" rows="5"></textarea>
            </div>
            <div class="form-group" id="sumary">
                <input type="submit" class="btn w-100" value="Catat Stok" name="record">
            </div>
        </form>
    </div>
</div>
<script>
    // instanceSelect.required = true;
    // let harga, total;
    const fuels = <?= json_encode($data['fuels']) ?>;

    const formattedNumber = new Intl.NumberFormat('id-ID', {
        style: 'decimal',
        minimumFractionDigits: 5,
        maximumFractionDigits: 5,
        useGrouping: true
    })
    document.querySelector('#uang').addEventListener('keyup', function(e) {
        e.currentTarget.value = Number(e.currentTarget.value.replace(/\./g, "")).toLocaleString('id');
    });
    document.querySelector('#jenis_bbm').addEventListener('change', (e) => {
        document.querySelector('#stokBBM').textContent = 'Stok ' + e.target.value;
        document.querySelector('#stok').textContent = formattedNumber.format(fuels[e.target.value]['stok']) + ' L';
    })

    const input = document.getElementById("datepicker");
    input.addEventListener("click", function() {
        input.focus(); // Set focus to the input field
        input.showPicker(); // Trigger a click event on the input field to show the picker
    });
    input.addEventListener("focus", function() {
        input.showPicker() // Trigger a click event on the input field to show the picker
    });

    document.querySelector('#form-transaksi').addEventListener('submit', function(e) {
        e.preventDefault;
        document.querySelector('#uang').value = document.querySelector('#uang').value.replace(/\./g, "");
        e.currentTarget.submit();
    });

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector("#stock-up-tab").classList.add("active");
    });
</script>
<?php
if (isset($_SESSION['InputError'])) unset($_SESSION['InputError']);
