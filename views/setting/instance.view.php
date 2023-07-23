<div class="row">
    <div class="col-sm me-auto">
        <h3><strong>Instansi</strong></h3>
    </div>
    <div class="col-sm">
        <button type="button" class="btn btn-outline-primary btn-xl float-end" data-bs-toggle="modal" data-bs-target="#instanceModal">
            Tambah Instansi
        </button>
    </div>
</div>
<hr>
<div class="table-responsive">
    <table class="table table-hover myTable">
        <thead class="thead-inverse">
            <tr>
                <th width="25%">Nama Instansi</th>
                <th width="50%">Keterangan</th>
                <th width="25%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data['instances'] as $instance) {
            ?>
                <tr>
                    <td data-label="Nama Instansi">
                        <?= $instance['nama_instansi']; ?>
                    </td>
                    <td data-label="Keterangan">
                        <?= $instance['keterangan']; ?>
                    </td>
                    <td class="Aksi" data-label="Aksi">
                        <?php if ($instance['id_instansi'] != 0) { ?>
                            <span>
                                <a href="<?= BASEURL ?>/Setting/instance/editInstansi/<?= $instance['id_instansi']; ?>#instansi" class="btn btn-sm btn-warning fw-bold h4" title="Edit Data">
                                    <span class="" aria-hidden="true">&#x270E;</span> Edit
                                </a>&nbsp;
                                <button type="button" class="btn btn-sm btn-danger fw-bold h3" title="Hapus Data" onclick="deleteInstance('<?= $instance['id_instansi']; ?>','<?= $instance['nama_instansi'] ?>')">
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
<div class="modal fade <?= (!isset($data['editInstansi'])) ? '' : 'addEdit' ?>" id="instanceModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" name="InstanceForm" action="<?= BASEURL ?>/Instance/submit/">
            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLongTitle">
                        <?= (!isset($data['editInstansi'])) ? 'Tambah Instansi' : 'Edit Instansi' ?></h5>
                    <a class="btn btn-lg close" <?= (!isset($data['editInstansi'])) ? 'data-bs-dismiss="modal"' : 'href="' . BASEURL . '/Setting/instance"' ?> aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Instansi</label>
                        <input type="text" class="form-control" maxlength="31" name="nama_instansi" id="nama_instansi" placeholder="Nama Instansi" value="<?= (!isset($data['editInstansi'])) ? '' : $data['editInstansi']['nama_instansi'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="5"><?= (!isset($data['editInstansi'])) ? '' : $data['editInstansi']['keterangan'] ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php
                    if (!isset($data['editInstansi'])) {
                    ?>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <?php
                    } else {
                    ?>
                        <input type="hidden" name="id_instansi" value="<?= $data['editInstansi']['id_instansi'] ?>">
                        <a class="btn btn-danger" href="<?= BASEURL ?>/Setting/instance">Batal</a>
                    <?php
                    }
                    ?>
                    <button type="submit" name="InstanceForm" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    const deleteInstance = (id, name) => {
        JSAlert.confirm(`Menghapus Instansi ${name} Akan Mengakibatkan Transaksi Yang Dilakukan Instasi ${name} Tidak Dapat Direkap!!! <br>Ingin Menghapus ${name}..?`, 'PERINGATAN!!!', JSAlert.Icons.Warning)
            .then(function(result) {
                if (!result) return;
                window.location.replace('<?= BASEURL ?>/Instance/delete/id/' + id)
            });
    }
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector("#instansi-tab").classList.add("active");
    });
</script>