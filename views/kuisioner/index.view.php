<div class="container-fluid" style="max-width:50rem">
    <div class="container">
        <div class="d-flex justify-content-between">
            <h5><strong>Kuisioner</strong></h5>
            <a href="#" class="btn btn-outline-primary btn-xl float-end">
                🖥️ Link Demo
            </a>
        </div>
    </div>
    <p>
        Kuesioner Tipe Gaya Belajar 
    </p>
    <hr>
    <form method="post" id="form" action="kuisioner/done" autocomplete="off">
        <div class="form-group">
            <label>
                <strong>
                    <h4>Data Diri Responden</h4>
                </strong>
            </label>
            <div class="form-group mb-3">
                <label for="">
                    Nama Lengkap
                </label>
                <input type="text" required placeholder="Nama Lengkap" name="nama" class="form-control">
                <?php App::InputValidator('nama') ?>

            </div>
            <div class="form-group mb-3">
                <label for="">
                    Jenjang Sekolah
                </label>
                <input type="text" required placeholder="Jenjang Sekolah" name="jenjang_sekolah" class="form-control">
                <?php App::InputValidator('jenjang_sekolah') ?>

            </div>
        </div>
        <hr>
        <?php
        foreach ($data['kriteria'] as $kriteria) {
            $i = 1;
        ?>
            <div class="form-group">
                <label>
                    <strong>
                        <h4><?= $kriteria['kriteria'] ?></h4>
                    </strong>
                </label>
                        <?php while (isset($data['pertanyaan'][$kriteria['kode'] . "_" . $i])) {
                            $pertanyaan = $data['pertanyaan'][$kriteria['kode'] . "_" . $i++];
                        ?>
                            <p class="mt-4"><?= $pertanyaan['pertanyaan'] ?></p>
                            <hr>
                            <input type="radio" value="1" name="<?= $pertanyaan['kode'] ?>" required>
                            <span>Sangat Tidak Setuju</span><br>
                            <input type="radio" value="2" name="<?= $pertanyaan['kode'] ?>" required>
                            <span>Tidak Setuju</span><br>
                            <input type="radio" value="3" name="<?= $pertanyaan['kode'] ?>" required>
                            <span>Netral</span><br>
                            <input type="radio" value="4" name="<?= $pertanyaan['kode'] ?>" required>
                            <span>Setuju</span><br>
                            <input type="radio" value="5" name="<?= $pertanyaan['kode'] ?>" required>
                            <span>Sangat Setuju</span><br>
                            <?php App::InputValidator($pertanyaan['kode']) ?>
                            <hr>

                        <?php }  ?>
            </div>
            <hr>
        <?php } ?>
        <div class="form-group">
            <input type="submit" class="btn w-100" value="Submit Kuisioner" name="kuisioner">
        </div>
    </form>
</div>
<?php
if (isset($_SESSION['InputError'])) unset($_SESSION['InputError']);
?>