<div class="container">
    <div class="row my-3">
        <?php
        require_once './views/components/fuel_desc.php';
        foreach ($data['fuels'] as $fuel) {
            if (!empty($fuel['stick'])) {
        ?>
                <div class="col-md-6 col-lg-6 px-4 mt-2">
                    <?php renderStickDesc($fuel) ?>
                </div>
        <?php
            }
        }
        ?>
    </div>
    <table data-label="Tabel Pengukuran Stok (Opname)" class="table table-responsive table-hover table-sm table-bordered myTable" id="FormatTable">
        <thead class="sticky-top">
            <tr>
                <th scope="col" width="2%" class="no-sort&search">NO</th>
                <th scope="col" width="8%">BAHAN BAKAR</th>
                <th scope="col" width="10%">WAKTU</th>
                <th scope="col" width="20%" class="no-sort&search">PENGUKURAN</th>
                <th scope="col" width="15%" class="no-sort&search">LOSSES</th>
                <th scope="col" width="15%" class="no-sort&search">KETERANGAN</th>
                <th scope="col" width="10%" class="no-sort&search">PETUGAS</th>
                <?php if (App::CheckUser('admin', 'petugas')) { ?>
                    <th scope="col" width="5%">Aksi</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($data['stick'] as $stick) {
            ?>
                <tr data-id="<?= $no ?>">

                    <td scope="row" data-label="NO">
                        <?php echo $no++ ?>
                    </td>

                    <td data-label="BAHAN BAKAR">
                        <?php echo $stick['jenis_bbm'] ?>
                    </td>
                    <td data-label="WAKTU">
                        <?php
                        setlocale(LC_ALL, 'id-ID', 'id_ID');
                        $timestamp =  strftime("%d %B %Y Jam %H:%M", strtotime($stick['timestamp']));
                        echo $timestamp ?>
                    </td>

                    <td data-label="PENGUKURAN">
                        <?php echo number_format($stick['tinggi_cm'], 0, ",", ".") . " CM" ?>
                        &nbsp;⇔&nbsp;
                        <strong>
                            <?php echo  number_format($stick['liter'], 2, ",", ".") . " L" ?>
                        </strong>
                    </td>
                    <td data-label="LOSSES">

                        <span>
                            <?php echo  number_format($stick['stok_by_app'], 2, ",", ".") . " L"
                            ?>
                            &nbsp;-&nbsp;
                            <?php echo  number_format($stick['liter'], 2, ",", ".") . " L"
                            ?>
                            &nbsp;⇛&nbsp;
                            <span class="text-danger">
                                <?php echo  number_format($stick['stok_by_app'] - $stick['liter'], 2, ",", ".") . " L"
                                ?>
                            </span>
                        </span>
                    </td>
                    <td data-label="KETERANGAN">
                        <?php echo $stick['keterangan'] ?>
                    </td>
                    <td data-label="PETUGAS">
                        <?php echo $stick['petugas'] ?>
                    </td>
                    <?php if (App::CheckUser('admin', 'petugas')) { ?>
                        <td class="Aksi" data-label="Aksi">

                            <button type="button" class="btn btn-sm btn-danger fw-bold h3" title="Hapus Data" onclick='deleteStik(<?= json_encode($stick) ?>)'>
                                <span aria-hidden="true">&times;</span> Hapus
                            </button>
                        </td>
                    <?php } ?>
                </tr>
            <?php
            }
            ?>

        <tbody>
    </table>
</div>

<script>
    monthPicker.addEventListener("change", (e) => {
        if (monthPicker.value === "") return;
        window.location.replace('<?= BASEURL ?>/Fuel/stick/month/' + monthPicker.value)
    });

    <?php if (App::CheckUser('admin', 'petugas')) { ?>
        const deleteStik = (data) => {
            JSAlert.confirm(`Apa Anda Ingin Menghapus Pencatatan Stik/Opname ${data.jenis_bbm} Pada ${data.timestamp} Ini..?`, 'PERINGATAN!!!', JSAlert.Icons.Warning)
                .then(function(result) {
                    if (!result) return;
                    window.location.replace('<?= BASEURL ?>/Fuel/deleteStik/id/' + data.id)
                });
        }
    <?php } ?>
    document.querySelector("#stick-tab").classList.add("active");
</script>