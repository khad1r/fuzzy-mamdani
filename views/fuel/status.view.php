<div class="container">
    <div class="row my-3">
        <?php
        require_once './views/components/fuel_desc.php';
        foreach ($data['fuels'] as $fuel) {
        ?>
            <div class="col-md-6 col-lg-6 px-4 mt-2">
                <?php renderHomeDesc($fuel) ?>
            </div>
        <?php
        }
        ?>
    </div>
    <table data-label="Tabel Stok" class="table table-responsive table-hover table-sm table-bordered myTable" id="FormatTable">
        <thead class="sticky-top">
            <tr>
                <th scope="col" width="10%" class="no-sort&search">ID STOK</th>
                <th scope="col" width="15%">BAHAN BAKAR</th>
                <th scope="col" width="15%">WAKTU PENGISIAN</th>
                <th scope="col" width="13%" class="no-sort&search">HARGA</th>
                <th scope="col" width="13%" class="no-sort&search">QTY PEMBELIAN</th>
                <!-- <th scope="col" width="12%" class="no-sort&search">STOK AKHIR</th> -->
                <!-- <th scope="col" width="13%" class="no-sort&search">PENYESUAIAN</th> -->
                <!-- <th scope="col" width="13%" class="no-sort&search">QTY PENJUALAN</th> -->
                <th scope="col" width="13%" class="no-sort&search">KETERANGAN</th>
                <!-- <th scope="col" width="2%" class="no-sort&search"></th> -->
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data['stok'] as $stok) {
            ?>
                <tr data-id="<?= $stok['id_stok'] ?>" <?= (App::CheckUser('admin', 'bag. keuangan')) ? 'data-bs-toggle="tooltip" data-bs-html="true" title="<h6><strong>Klik 2x untuk Melakukan Aksi</strong></h6>" ondblclick="StatusAction(this);"' : '' ?>>

                    <td scope="row" data-label="ID STOK">
                        <?php echo $stok['id_stok'] ?>
                    </td>

                    <td data-label="BAHAN BAKAR">
                        <?php echo $stok['jenis_bbm'] ?>
                    </td>
                    <td data-label="WAKTU">
                        <?php
                        setlocale(LC_ALL, 'id-ID', 'id_ID');
                        $timestamp =  strftime("%d %B %Y Jam %H:%M", strtotime($stok['waktu_pembelian']));
                        echo $timestamp ?>
                    </td>

                    <td data-label="HARGA">
                        <?php echo 'Rp. ' . number_format($stok['harga'], 0, ",", ".") . ",-/ltr" ?>
                    </td>
                    <td data-label="QTY PEMBELIAN">
                        <?php echo  number_format($stok['pembelian'], 2, ",", ".") . " L" ?>
                    </td>
                    <td data-label="KETERANGAN">
                        <?php echo $stok['keterangan'] ?>
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
    document.querySelector("#status-tab").classList.add("active");

    monthPicker.addEventListener("change", (e) => {
        if (monthPicker.value === "") return;
        window.location.replace('<?= BASEURL ?>/Fuel/status/month/' + monthPicker.value)
    });
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
                [1, "asc"],
                [2, "desc"],
            ],
        });

    });
    <?php if (App::CheckUser('admin', 'bag. keuangan')) { ?>
        // let myModal;
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    html: true,
                    placement: 'bottom'
                })
            })

        })

        function StatusAction(e) {
            var id = "" + e.getAttribute("data-id");
            var alert = new JSAlert(`Aksi Untuk Stok ${id}`);
            alert.addButton(`Hapus ${id}`).then(function() {
                // console.log("Alert button No pressed");
                JSAlert.confirm(`Apa Anda Yakin Menghapus Stok ${id}..?`, 'PERHATIAN!!!', JSAlert.Icons.Warning)
                    .then(function(result) {
                        if (!result) return;
                        window.location.replace('<?= BASEURL ?>/Fuel/deleteStok/id/' + encodeURIComponent(id));
                    });
            });
            alert.show();

        }
    <?php } ?>
</script>