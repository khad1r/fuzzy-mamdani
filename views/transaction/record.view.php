<div class="container-fluid" style="max-width:32rem">
    <?php if (App::CheckUser('petugas')) { ?>
        <div class="container">
            <div class="d-flex justify-content-between">
                <h5><strong>Catat Transaksi</strong></h5>
                <a href="<?= BASEURL ?>/Home" class="text-decoration-none h5 pe-auto">Kembali</a>
            </div>
            <hr>
        </div>
    <?php } ?>
    <div class="row">
        <form id="form-transaksi" method="post" autocomplete="off" action="<?= BASEURL ?>/Transaction/submit">
            <div class="form-group center-input">
                <label>Pilih Instansi</label>
                <?php include './views/components/instance_select.php' ?>
                <?php App::InputValidator('instansi') ?>
                <?php App::InputValidator('id_instansi') ?>
            </div>
            <div class="form-group">
                <label>No. Nota</label>
                <input type="number" class="form-control" name="nota" autocomplete="off" required>
                <?php App::InputValidator('nota') ?>
            </div>
            <div class="form-group">
                <label>Waktu Transaksi</label>
                <?php if (App::CheckUser('petugas')) { ?>
                    <input type="time" class="form-control" name="time" min="06:00" max="20:00" value="<?= date('H:i'); ?>" required>
                <?php } else { ?>
                    <input type="datetime-local" id="timestamp" name="timestamp" value="<?= date('Y-m-d\TH:i') ?>" min="<?= date('Y-m-d\TH:i', strtotime(FIRST_DATE)) ?>" max="<?= date('Y-m-d\TH:i') ?>" class="form-control" required>
                <?php } ?>
                <?php App::InputValidator('time') ?>
            </div>
            <div class="form-group center-input">
                <label>Bahan Bakar</label>
                <select class="form-control" id="jenis_bbm" name="jenis_bbm">
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
                    <span id="stokBBM2"></span>
                    <span id="stok2"></span>
                </div>
            </div>
            <div class="form-group">
                <label>Total Transaksi</label>
                <div class="input-group">
                    <span class="input-group-text">Rp.</span>
                    <input type="text" class="form-control" inputmode="numeric" id="uang" required>
                </div>
                <?php App::InputValidator('total') ?>
            </div>
            <div class="form-group center-input">
                <label>Nomor Plat Kendaraan</label>
                <input type="text" class="form-control" autocomplete="off" required name="plat_nomor">
                <?php App::InputValidator('plat_nomor') ?>
            </div>
            <div class="form-group center-input" id="metode_pembayaran" style="display: none">
                <label>Metode Pembayaran</label>
                <select class="form-control" name="metode_pembayaran" required>
                    <?php
                    foreach ($data['payings'] as $paying) {
                        if ($paying['metode_pembayaran'] == 'Kupon') continue;
                    ?>
                        <option value="<?= $paying['id'] ?>"><?= $paying['metode_pembayaran'] ?></option>
                    <?php
                    }
                    ?>
                </select>
                <?php App::InputValidator('metode_pembayaran') ?>
            </div>
            <div class="form-group" id="sumary" style="display: none">
                <div class="d-flex justify-content-between">
                    <span id="stokBBM">Stok </span>
                    <span id="stok"></span>
                </div>
                <hr>
                <?php App::InputValidator('stok') ?>
                <div class="d-flex justify-content-between">
                    <span>Harga Perliter</span>
                    <span id="harga"></span>
                    <input type="hidden" name="harga">
                </div>
                <?php App::InputValidator('harga') ?>

                <div class="d-flex justify-content-between">
                    <?php App::InputValidator('qty') ?>
                    <span>Liter Keluar</span>
                    <span id="qty"></span>
                    <input type="hidden" name="qty">
                </div>
                <?php App::InputValidator('qty') ?>
                <div class="d-flex justify-content-between">
                    <span>Total Transaksi</span>
                    <span id="total"></span>
                    <input type="hidden" name="total">
                </div>
                <hr>
                <textarea name="keterangan" class="form-control" autocomplete="off" placeholder="Keterangan" rows="3"></textarea>
                <hr>
                <input type="submit" class="btn w-100" value="Catat Transaksi" name="record">
            </div>
        </form>
    </div>
</div>
<script>
    const fuels = <?= json_encode($data['fuels']) ?>;

    instanceSelect.required = true;
    let harga, total;
    const formattedNumber = new Intl.NumberFormat('id-ID', {
        style: 'decimal',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
        useGrouping: true
    })
    document.querySelector('#uang').addEventListener('keyup', function(e) {
        e.currentTarget.value = Number(e.currentTarget.value.replace(/\./g, "")).toLocaleString('id');
    });
    document.querySelector('#jenis_bbm').addEventListener('change', (e) => {
        harga = fuels[e.target.value]['harga'];
        stok = fuels[e.target.value]['stok']
        document.querySelector('#stokBBM2').textContent = 'Stok ' + e.target.value;
        document.querySelector('#stok2').textContent = (fuels[e.target.value]['stok'] <= 0) ? '0,00 L' : formattedNumber.format(fuels[e.target.value]['stok']) + ' L';
        document.querySelector('#stok').textContent = (stok <= 0) ? '0,00 L' : formattedNumber.format(stok) + ' L';
        updateSumary();
    })
    document.querySelector('#uang').addEventListener('change', (e) => {
        total = e.currentTarget.value.replace(/\./g, "");
        updateSumary();
    })
    instanceSelect.addEventListener('change', () => {
        document.querySelector('#metode_pembayaran').style.display =
            (instanceSelect.value == "<?= $data['instances'][0]['nama_instansi'] ?>") ? 'block' : 'none';
    })
    <?php if (App::CheckUser('admin')) { ?>
        document.querySelector('#timestamp').addEventListener('change', async (e) => {
            let bodyContent = new FormData();
            bodyContent.append("timestamp", e.currentTarget.value);
            let response = await fetch("<?= BASEURL ?>/Fuel/getFuelByTimestamp/", {
                method: "POST",
                body: bodyContent,
            });
            // console.log(await response.json())
            (await response.json()).forEach(element => {
                fuels[element['jenis_bbm']]['harga'] = element['harga']
            });
        })
    <?php } ?>

    function updateSumary() {
        if (!(harga && total)) return;
        qty = total / harga;
        document.querySelector('#sumary').style.display = 'block';
        document.querySelector('#harga').textContent = 'Rp. ' + Number(harga).toLocaleString('id') + ',-';
        document.querySelector('input[name="harga"]').value = harga;
        document.querySelector('#qty').textContent = formattedNumber.format(qty) + ' L';
        document.querySelector('input[name="qty"]').value = qty.toFixed(2);
        document.querySelector('#total').textContent = 'Rp. ' + Number(total).toLocaleString('id') + ',-';
        document.querySelector('input[name="total"]').value = total;
    }

    <?php if (App::CheckUser('petugas')) { ?>
        document.querySelector('input[name="time"]').addEventListener("click", function() {
            document.querySelector('input[name="time"]').focus(); // Set focus to the input field
            document.querySelector('input[name="time"]').showPicker(); // Trigger a click event on the input field to show the picker
        });
        document.querySelector('input[name="time"]').addEventListener("focus", function() {
            document.querySelector('input[name="time"]').showPicker() // Trigger a click event on the input field to show the picker
        });
    <?php } else { ?>
        document.querySelector('input[name="timestamp"]').addEventListener("click", function() {
            document.querySelector('input[name="timestamp"]').focus(); // Set focus to the input field
            document.querySelector('input[name="timestamp"]').showPicker(); // Trigger a click event on the input field to show the picker
        });
        document.querySelector('input[name="timestamp"]').addEventListener("focus", function() {
            document.querySelector('input[name="timestamp"]').showPicker() // Trigger a click event on the input field to show the picker
        });
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector("#record-tab")?.classList.add("active");
        });
    <?php } ?>
</script>
<?php
if (isset($_SESSION['InputError'])) unset($_SESSION['InputError']);
?>