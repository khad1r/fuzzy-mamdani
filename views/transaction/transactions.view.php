<div class="container-fluid px-5">
    <div class="container">

        <div class="d-flex justify-content-center justify-content-md-between flex-column flex-md-row mb-md-0 mb-3">
            <div class="d-flex justify-content-between justify-content-md-start flex-md-column flex-row">
                <h2><strong>Transaksi</strong></h2>
                <!-- <a href="<?= BASEURL ?>/" class="text-decoration-none h5 pe-auto">Kembali</a> -->
            </div>
            <hr class="d-lg-none">
            <div class="d-flex flex-row justify-content-center align-items-center">
                <?php require_once './views/components/date_picker.php' ?>
                <?php if (App::CheckUser('admin', 'bag. teknik')) { ?>
                    <button type="button" class="btn btn-outline-success btn-xl" id="btnExport">
                        Unduh Tagihan
                    </button>

                <?php } ?>
            </div>
        </div>
        <hr>
    </div>

    <div class="d-flex flex-column flex-md-row w-100 justify-content-center justify-content-lg-end" id="tooltable" role="group" aria-label="Tool Table">
        <input type="text" id="cari" placeholder="Cari.." autocomplete="off" class="form-control me-md-2 mb-2 mb-md-0">
        <?php require_once './views/components/instance_select.php' ?>

    </div>

    <table data-label="Tabel Transaksi" class="table table-responsive table-hover table-sm table-bordered myTable" id="FormatTable">
        <thead class="sticky-top">
            <tr>
                <th scope="col" width="5%" class="no-sort&search">NO</th>
                <th scope="col" width="12%">WAKTU</th>
                <th scope="col" width="10%">NOTA</th>
                <th scope="col" width="20%">INSTANSI</th>
                <th scope="col" width="13%">NOMOR PLAT</th>
                <th scope="col" width="8%">BAHAN BAKAR</th>
                <th scope="col" width="10%" class="no-sort&search">HARGA</th>
                <th scope="col" width="7%" class="no-sort&search">QTY</th>
                <th scope="col" width="10%">TOTAL</th>
                <?php
                if (App::CheckUser()) {
                ?>
                    <th scope="col" width="5%" class="no-sort&search">AKSI</th>
                <?php
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $current_date = new DateTime();
            foreach ($data['transactions'] as $transaction) {
            ?>
                <tr data-id="<?= $i ?>">

                    <td scope="row" data-label="NO">
                        <?php echo $i++ ?>
                    </td>
                    <td data-label="WAKTU">
                        <?php
                        setlocale(LC_ALL, 'id-ID', 'id_ID');
                        $timestamp =  strftime("%d %B %Y Jam %H:%M", strtotime($transaction['timestamp']));
                        echo $timestamp ?>
                    </td>
                    <td data-label="NOTA">
                        <?php echo $transaction['nota'] ?>
                    </td>
                    </td>
                    <td data-label="INSTANSI">
                        <?php
                        echo $transaction['instansi'];
                        if ($transaction['id_instansi'] == 0) {
                        ?>
                            <i class="mt-1 text-primary">( <?= $transaction['metode_pembayaran'] ?> )</i>
                        <?php
                        }
                        ?>
                    </td>
                    <td data-label="NOMOR PLAT">
                        <?php echo $transaction['plat_nomor'] ?>
                    </td>
                    <td data-label="BAHAN BAKAR">
                        <?php echo $transaction['jenis_bbm'] ?>
                    </td>
                    <td data-label="HARGA">
                        <?php echo 'Rp. ' . number_format($transaction['harga'], 0, ",", ".") . ",-/ltr" ?>
                    </td>
                    <td data-label="QTY">
                        <?php echo  number_format($transaction['qty'], 2, ",", ".") . " L" ?>
                    </td>
                    <td data-label="TOTAL">
                        <?php echo 'Rp. ' . number_format($transaction['total'], 0, ",", ".") . ",-" ?>
                    </td>
                    <?php
                    if (App::CheckUser()) {
                    ?>
                        <td data-label="AKSI">
                            <?php
                            if (
                                App::CheckUser()
                                && (date("Y-m-d", strtotime($transaction['timestamp'])) == date('Y-m-d')
                                    && $transaction['petugas'] == $_SESSION['user']['username'])
                                || (App::CheckUser('admin'))
                            ) {
                            ?>
                                <a href="<?= BASEURL . '/Transaction/update/id/' . $transaction['id'] ?>" class="btn btn-sm btn-warning fw-bold h4" title="Edit Data">
                                    <span class="" aria-hidden="true">&#x270E;</span> Edit
                                </a>&nbsp;
                            <?php
                            }
                            ?>
                        </td>
                    <?php
                    }
                    ?>
                </tr>
            <?php
            }
            ?>

        <tbody>
    </table>
    <form id="invisible_form" action="<?= BASEURL ?>/Transaction/getBill/" method="post">
        <input id="hiddenMonth" name="month" type="hidden">
        <input id="hiddenInstance" name="id_instansi" type="hidden">
    </form>
</div>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.css" />

<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.js"></script>

<script>
    datePicker.addEventListener("change", (e) => {
        if (datePicker.value === "") return;
        window.location.replace('<?= BASEURL ?>/Transaction/report/date/' + datePicker.value)
    });

    OptionAll = document.createElement('button');
    OptionAll.value = "All";
    OptionAll.textContent = "All";
    assignBTN(OptionAll);
    instanceDropdown.insertBefore(OptionAll, searchInstanceSelect.nextSibling);

    <?php if (App::CheckUser('admin', 'bag. teknik')) { ?>
        document.querySelector('#btnExport').addEventListener('click', (e) => {
            if (instanceSelect.value === "" || instanceSelect.value === "All") {

                JSAlert.alert("Silahkan Pilih Instansi.");
                instanceSelect.focus();
                return
            };
            let date = new Date(datePicker.value);
            let month = date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2);
            JSAlert.confirm(`Anda Akan Mengexport Rekap Excel ${instanceSelect.value} Untuk Bulan ${month}`, null, JSAlert.Icons.Information)
                .then(function(result) {
                    if (!result) return;
                    loadingPage.style.display = "";
                    document.querySelector('#hiddenMonth').value = month;
                    document.querySelector('#hiddenInstance').value = instanceId.value;
                    document.querySelector('#invisible_form').submit();
                    waitCoocke('DownloadCookie', 'Rekap' + instanceId.value, () => {
                        loadingPage.style.display = "none";
                    })
                });

        })
    <?php } ?>

    $(document).ready(function() {

        var Ftable = $("#FormatTable").DataTable({
            "dom": "ftlp",
            "language": {
                "lengthMenu": "Menampilkan _MENU_ baris per halaman",
                "zeroRecords": "Tidak ada data",
                "infoEmpty": "Tidak ada data",
                "search": "Cari : ",
                "paginate": {
                    "first": "<<",
                    "last": ">>",
                    "next": ">",
                    "previous": "<"
                }
            },
            "order": [
                [0, "desc"]
            ],
            "columnDefs": [{
                targets: "no-sort&search",
                searchable: false,
            }]
        });
        FSettings = Ftable.settings();
        $("#tooltable").appendTo("#FormatTable_filter");
        $("#instance_select").on("change", function() {
            instance = (this.value === 'All') ? '' : this.value
            Ftable.search(instance).draw();
        })
        $("#cari").keyup(function() {
            Ftable.search(this.value).draw();
        })
    });
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector("#transaksi-tab").classList.add("active");
    });
</script>