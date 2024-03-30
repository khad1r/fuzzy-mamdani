<div class="container">
    <div class="table-responsive">
        <table class="table table-responsive table-hover table-sm table-bordered myTable" id="FormatTable">
            <thead class="sticky-top">
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Jenjang Sekolah</th>
                    <?php foreach ($data['checklist'] as $kriteria) { ?>
                        <?php foreach ($kriteria['pertanyaan'] as $key => $value) {
                            $i = 1;
                            $answer_order[] = $key;
                        ?>
                            <th><?= "P" . $i++ //$value['kode'] 
                                ?></th>
                        <?php } ?>
                    <?php } ?>
                    <th>Skor Visual</th>
                    <th>Skor Auditori</th>
                    <th>Skor Kinestetik</th>
                    <th>Hasil Visual</th>
                    <th>Hasil Auditori</th>
                    <th>Hasil Kinestetik</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data['Kuisioner'] as $kuisioner) {
                ?>
                    <tr>
                        <td data-label="Nama Lengkap">
                            <?= $kuisioner['nama']; ?>
                        </td>
                        <td data-label="Jenjang Sekolah">
                            <?= $kuisioner['jenjang_sekolah']; ?>
                        </td>
                        <?php foreach ($answer_order as $kuisioner_id) { ?>
                            <td data-label="<?= $kuisioner_id ?>">
                                <?= $kuisioner[$kuisioner_id]; ?>
                            </td>
                        <?php } ?>
                        <td data-label="Skor Visual">
                            <?= $kuisioner['V']; ?>
                        </td>
                        <td data-label="Skor Auditori">
                            <?= $kuisioner['A']; ?>
                        </td>
                        <td data-label="Skor Kinestetik">
                            <?= $kuisioner['K']; ?>
                        </td>
                        <td data-label="Hasil Visual">
                            <?= $kuisioner['HASIL_V']; ?>
                        </td>
                        <td data-label="Hasil Auditori">
                            <?= $kuisioner['HASIL_A']; ?>
                        </td>
                        <td data-label="Hasil Kinestetik">
                            <?= $kuisioner['HASIL_K']; ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    document.querySelector("#Kuisioner").classList.add("active");
</script>