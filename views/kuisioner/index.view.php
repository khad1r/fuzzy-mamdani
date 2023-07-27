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
        Deskripsi Kuisioner
    </p>
    <hr>
    <form method="post" id="form" autocomplete="off">
        <div class="form-group">
            <label>
                <strong>
                    <h4>Data Diri Responden</h4>
                </strong>
            </label>
            <div class="form-group mb-3">
                <label for="">
                    Email
                </label>
                <input type="email" required placeholder="name@email.com" name="email" class="form-control">
                <?php App::InputValidator('email') ?>
            </div>
            <div class="form-group mb-3">
                <label for="">
                    Nama Lengkap
                </label>
                <input type="text" required placeholder="Nama Lengkap" name="nama" class="form-control">
                <?php App::InputValidator('nama') ?>

            </div>
            <div class="form-group mb-3">
                <label for="">
                    Program Studi
                </label>
                <input type="text" required placeholder="Program Studi" name="program_studi" class="form-control">
                <?php App::InputValidator('program_studi') ?>

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
                <p class="mb-3"><?= $kriteria['deskripsi'] ?></p>
                <?php while (isset($data['sub-kriteria'][$kriteria['kode'] . "_" . $i])) {
                    $sub_kriteria = $data['sub-kriteria'][$kriteria['kode'] . "_" . $i++];
                    $j = 1;
                ?>
                    <div class="form-group mb-3">
                        <label for="">
                            <strong>
                                <h5><?= $sub_kriteria['sub-kriteria'] ?></h5>
                            </strong>
                        </label>
                        <p class="mb-3"><?= $sub_kriteria['deskripsi'] ?></p>
                        <hr>
                        <hr>
                        <?php while (isset($data['pertanyaan'][$sub_kriteria['kode'] . "_" . $j])) {
                            $pertanyaan = $data['pertanyaan'][$sub_kriteria['kode'] . "_" . $j++];
                        ?>
                            <p class="mt-4"><?= $pertanyaan['pertanyaan'] ?></p>
                            <input type="number" min="0" max="100" placeholder="0 - 100" class="form-control" inputmode="numeric" name="<?= $pertanyaan['kode'] ?>" required>
                            <?php App::InputValidator($pertanyaan['kode']) ?>

                        <?php }  ?>
                    </div>
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