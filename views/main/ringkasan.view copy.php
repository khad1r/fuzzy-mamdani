<div class="container" id="form">
    <?php
    $graph = [];
    foreach ($data['checklist'] as $kriteria) { ?>
        <div class="form-group">
            <label>
                <strong>
                    <h4><?= $kriteria['kriteria'] ?></h4>
                </strong>
            </label>
            <p class="mb-3"><?= $kriteria['deskripsi'] ?></p>
            <?php
            $graph[$kriteria['kode']] = [
                'skor' => $kriteria['skorKuisioner'],
                'nama' => $kriteria['sub-kriteria'],
                'label' => range(1, $kriteria['skor']),
            ];
            foreach ($kriteria['sub-kriteria'] as $sub_kriteria) {
                $graph[$sub_kriteria['kode']] = [
                    'skor' => $sub_kriteria['skorKuisioner'],
                    'nama' => $sub_kriteria['sub-kriteria'],
                    'label' => range(1, $sub_kriteria['skor']),
                ];
            ?>
                <div class="form-group mb-3">
                    <label for="">
                        <strong>
                            <h5><?= $sub_kriteria['kriteria'] ?></h5>
                        </strong>
                    </label>
                    <p class="mb-3"><?= $sub_kriteria['deskripsi'] ?></p>
                    <hr>
                    <canvas id="<?= $sub_kriteria['kode'] ?>" class="grafick"></canvas>
                </div>
            <?php } ?>
        </div>
        <hr>
    <?php } ?>
    <div class="form-group">
        <a href="<?= BASEURL ?>/Main/analisis" class="btn w-100">Anilisis</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const DATA = <?= json_encode($graph) ?>;
    document.querySelector("#Ringkasan").classList.add("active");
</script>