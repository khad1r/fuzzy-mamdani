<div class="container-fluid" style="max-width:50rem">
    <div id="form">
        <div class="form-group mb-3">
            <label for="">
                <strong>
                    <h5>Terima Kasih Responden </h5>
                </strong>
            </label>
            <p class="mb-3">Tipe Gaya Belajar Visual : <?= $data['HASIL_V'] ?></p>
            <p class="mb-3">Tipe Gaya Belajar Auditori : <?= $data['HASIL_A'] ?></p>
            <p class="mb-3">Tipe Gaya Belajar Kinestetik : <?= $data['HASIL_K'] ?></p>
            <hr>
            <img src="<?= BASEURL ?>/assets/export/membership_activity.png" class="img-fluid img-responsive" style="width:100%">
            <hr>
        </div>
        <div class="form-group">
            <a href="<?= BASEURL ?>" class="btn w-100">Isi lagi </a>
        </div>
    </div>
</div>