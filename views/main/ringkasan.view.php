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
                'nama' => $kriteria['kriteria'],
                // 'label' => range(1, $kriteria['skor']),
            ];
            foreach ($kriteria['sub-kriteria'] as $sub_kriteria) {
                $graph[$sub_kriteria['kode']] = [
                    'skor' => $sub_kriteria['skorKuisioner'],
                    'nama' => $sub_kriteria['sub-kriteria'],
                    // 'label' => range(1, $sub_kriteria['skor']),
                ];
            ?>
                <div class="form-group mb-3">
                    <label for="">
                        <strong>
                            <h5><?= $sub_kriteria['sub-kriteria'] ?></h5>
                        </strong>
                    </label>
                    <p class="mb-3"><?= $sub_kriteria['deskripsi'] ?></p>
                    <hr>
                    <canvas id="<?= $sub_kriteria['kode'] ?>" class="grafick"></canvas>
                </div>
            <?php } ?>
            <hr class="mt-5">
            <hr>
            <p class="my-3">Kemudian Didapatkan Rata Rata Untuk Kriteria <?= $kriteria['kriteria'] ?> Adalah <b><?= $kriteria['total'] ?></b></p>
            <canvas id="<?= $kriteria['kode'] ?>" class="grafick"></canvas>
        </div>
        <hr>
    <?php } ?>
    <div class="form-group">
        <a href="<?= BASEURL ?>/Main/analisis" class="btn w-100">Anilisis</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.querySelector("#Ringkasan").classList.add("active");
    const graphs = {};
    const DATA = <?= json_encode($graph) ?>;

    function countScoreOccurrence(scores) {
        occurrence = []
        scores.forEach(score => {
            score = parseFloat(score).toFixed(2)
            occurrence[score] = occurrence[score] + 1 || 1
        });
        return occurrence;
    }
    Object.entries(DATA).forEach(async ([key, value]) => {
        const score = await countScoreOccurrence(value.skor);
        const labels = Object.keys(score); // Extract keys (scores) as labels
        const values = Object.values(score); // Extract values (occurrences) as data

        console.log(value, score, labels, values);
        graphs[key] = new Chart(document.querySelector('#' + key), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: value.nama,
                    data: values,
                    backgroundColor: '#75caf3'
                    // backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    // borderColor: 'rgba(255, 99, 132, 1)',
                    // borderWidth: 1
                }]
            },
            options: {
                aspectRatio: 32 / 9,
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });
    })
</script>