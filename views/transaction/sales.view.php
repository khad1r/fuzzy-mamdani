<div class="container">
    <div class="d-flex justify-content-center justify-content-lg-between flex-column flex-lg-row mb-3">
        <span>
            <h2 class="text-center"><strong>Laporan Penjualan</strong></h2>
        </span>

        <div class="d-flex flex-row justify-content-center align-items-center">
            <?php require_once './views/components/month_picker.php' ?>
        </div>
    </div>
    <table data-label="Tabel Rekap Penjualan" class="table table-responsive table-hover table-sm table-bordered myTable" id="FormatTable">
        <thead class="sticky-top">
            <tr>
                <th scope="col" width="10%" class="no-sort&search">TANGGAL</th>
                <th scope="col" width="16%">BAHAN BAKAR</th>
                <th scope="col" width="12%" class="no-sort&search">HARGA</th>
                <th scope="col" width="10%" class="no-sort&search">QTY</th>
                <th scope="col" width="12%" class="no-sort&search">JUMLAH</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data['sales'] as $sale) {
            ?>
                <tr>
                    <td scope="row" data-label="TANGGAL">
                        <?php echo date('d/m/Y', strtotime($sale['tgl'])) ?>
                    </td>

                    <td data-label="BAHAN BAKAR">
                        <?php echo $sale['jenis_bbm'] ?>
                    </td>
                    <td data-label="HARGA">
                        <?php echo 'Rp. ' . number_format($sale['harga'], 2, ",", ".") . ",-/ltr" ?>
                    </td>
                    <td data-label="QTY">
                        <?php echo  number_format($sale['qty'], 2, ",", ".") . " L" ?>
                    </td>
                    <td data-label="JUMLAH">
                        <?php echo 'Rp. ' . number_format($sale['total'], 2, ",", ".") . ",-" ?>
                    </td>
                </tr>
            <?php
            }
            ?>

        <tbody>
    </table>
</div>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.css" />

<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.js"></script>

<script>
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
        });

    });
    monthPicker.addEventListener("change", (e) => {
        if (monthPicker.value === "") return;
        window.location.replace('<?= BASEURL ?>/Transaction/sales/month/' + monthPicker.value)
    });
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector("#penjualan-tab").classList.add("active");
    });
</script>