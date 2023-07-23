<div class="container">
    <div class="row">
        <div class="col-sm me-auto">
            <h5><strong>Harga Jual BBM</strong></h5>
        </div>
        <div class="col-sm">
            <button type="button" class="btn btn-outline-primary btn-xl float-end" data-bs-toggle="modal" data-bs-target="#priceModal">
                Update Harga Jual
            </button>
        </div>
    </div>
    <hr>
    <div class="table-responsive">
        <table data-label="Tabel Harga Jual" class="table table-responsive table-hover table-sm table-bordered myTable" id="FormatTable">
            <thead class="sticky-top">
                <tr>
                    <th>Jenis BBM</th>
                    <th>Harga Jual</th>
                    <th>Waktu Diterapkan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data['price'] as $price) {
                ?>
                    <tr>
                        <td data-label="Jenis BBM">
                            <?= $price['jenis_bbm']; ?>
                        </td>
                        <td data-label="Harga Jual">
                            <?= 'Rp. ' . number_format($price['harga'], 2, ",", ".") . ",-/ltr" ?>
                        </td>
                        <td data-label="Waktu Diterapkan">
                            <?php
                            setlocale(LC_ALL, 'id-ID', 'id_ID');
                            $timestamp =  strftime("%d %B %Y Jam %H:%M", strtotime($price['waktu_diterapkan']));
                            echo $timestamp ?>
                        </td>
                        <td class="Aksi" data-label="Aksi">

                            <button type="button" class="btn btn-sm btn-danger fw-bold h3" title="Hapus Data" onclick='deletePrice(<?= json_encode($price) ?>)'>
                                <span aria-hidden="true">&times;</span> Hapus
                            </button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="priceModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" name="priceForm" id="priceForm" action="<?= BASEURL ?>/Price/submit/">
                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Update Harga Jual</h5>
                        <a class="btn btn-lg close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Waktu Penerapan</label>
                            <div class="input-group">
                                <input type="datetime-local" id="datepicker" name="waktu_diterapkan" value="<?= (new DateTime())->format('Y-m-d\TH:i') ?>" class="form-control" required>
                            </div>
                            <?php App::InputValidator('waktu_diterapkan') ?>

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
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp.</span>
                                <input type="text" class="form-control" name="harga" step="0.00001" inputmode="numeric" id="uang" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-success" value="Simpan" name="priceForm">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const deletePrice = (data) => {
        JSAlert.confirm(`Apa Anda Ingin Menghapus History Harga ${data.jenis_bbm} Jual Pada ${data.waktu_diterapkan} Ini..?`, 'PERINGATAN!!!', JSAlert.Icons.Warning)
            .then(function(result) {
                if (!result) return;
                window.location.replace('<?= BASEURL ?>/Price/delete/id/' + data.id)
            });
    }
    const formattedNumber = new Intl.NumberFormat('id-ID', {
        style: 'decimal',
        minimumFractionDigits: 5,
        maximumFractionDigits: 5,
        useGrouping: true
    })
    document.querySelector('#uang').addEventListener('keyup', function(e) {
        e.currentTarget.value = Number(e.currentTarget.value.replace(/\./g, "")).toLocaleString('id');
    });
    document.querySelector('#priceForm').addEventListener('submit', function(e) {
        e.preventDefault;
        document.querySelector('#uang').value = document.querySelector('#uang').value.replace(/\./g, "");
        e.currentTarget.submit();
    });
    monthPicker.addEventListener("change", (e) => {
        if (monthPicker.value === "") return;
        window.location.replace('<?= BASEURL ?>/Fuel/price/month/' + monthPicker.value)
    });

    document.querySelector("#price-tab").classList.add("active");

    <?php
    if (isset($_SESSION['InputError'])) {
        unset($_SESSION['InputError']);
    ?>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = new bootstrap.Modal(document.querySelector('#priceModal'));
            modal.show();
        });
    <?php
    }
    ?>
</script>