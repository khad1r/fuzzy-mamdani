<div class="row">
    <div class="col-sm me-auto">
        <h3><strong>Metode Pembayaran</strong></h3>
    </div>
    <div class="col-sm">
        <button type="button" class="btn btn-outline-primary btn-xl float-end" data-bs-toggle="modal" data-bs-target="#payingModal">
            Tambah Pembayaran
        </button>
    </div>
</div>
<hr>
<div class="table-responsive">
    <table class="table table-hover myTable">
        <thead class="thead-inverse">
            <tr>
                <th>Metode Pembayaran</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data['payings'] as $paying) {
            ?>
                <tr>
                    <td data-label="Metode Pembayaran">
                        <?= $paying['metode_pembayaran']; ?>
                    </td>
                    <td data-label="Keterangan">
                        <?= $paying['keterangan']; ?>
                    </td>
                    <td class="Aksi" data-label="Aksi">

                        <?php if ($paying['id'] > 2) { ?>
                            <span>
                                <a href="<?= BASEURL ?>/Setting/paying/editPembayaran/<?= $paying['id']; ?>/" class="btn btn-sm btn-warning fw-bold h4" title="Edit Data">
                                    <span class="" aria-hidden="true">&#x270E;</span> Edit
                                </a>&nbsp;
                                <button type="button" class="btn btn-sm btn-danger fw-bold h3" title="Hapus Data" onclick="deletePayment('<?= $paying['id']; ?>','<?= $paying['metode_pembayaran'] ?>')">
                                    <span aria-hidden="true">&times;</span> Hapus
                                </button>
                            </span>
                        <?php } ?>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<div class="modal fade <?= (!isset($data['editPembayaran'])) ? '' : 'addEdit' ?>" id="payingModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" name="PayingForm" action="<?= BASEURL ?>/Paying/submit/">
            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLongTitle">
                        <?= (!isset($data['editPembayaran'])) ? 'Tambah Metode Pembayaran' : 'Edit Metode Pembayaran' ?></h5>
                    <a class="btn btn-lg close" <?= (!isset($data['editPembayaran'])) ? 'data-bs-dismiss="modal"' : 'href="' . BASEURL . '/Setting/paying"' ?> aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Instansi</label>
                        <input type="text" class="form-control" maxlength="31" name="metode_pembayaran" id="metode_pembayaran" placeholder="Metode Pembayaran" value="<?= (!isset($data['editPembayaran'])) ? '' : $data['editPembayaran']['metode_pembayaran'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="5"><?= (!isset($data['editPembayaran'])) ? '' : $data['editPembayaran']['keterangan'] ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php
                    if (!isset($data['editPembayaran'])) {
                    ?>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <?php
                    } else {
                    ?>
                        <input type="hidden" name="id" value="<?= $data['editPembayaran']['id'] ?>">
                        <a class="btn btn-danger" href="<?= BASEURL ?>/Setting/paying">Batal</a>
                    <?php
                    }
                    ?>
                    <button type="submit" name="PayingForm" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    const deletePayment = (id, name) => {
        JSAlert.confirm(`Menghapus Metode ${name} Akan Mengakibatkan Transaksi Yang Menggunakan ${name} Tidak Dapat Direkap!!! <br>Tidak Dapat Direkap ${name}..?`, 'PERINGATAN!!!', JSAlert.Icons.Warning)
            .then(function(result) {
                if (!result) return;
                window.location.replace('<?= BASEURL ?>/Paying/delete/id/' + id)
            });
    }
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector("#pembayaran-tab").classList.add("active");
    });
</script>