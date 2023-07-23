<div class="container">
    <div class="table-responsive">
        <table class="table table-responsive table-hover table-sm table-bordered myTable" id="FormatTable">
            <thead class="sticky-top">
                <tr>
                    <th colspan="3" rowspan="2">Data Responden</th>
                    <?php $answer_order = [] ?>
                    <?php foreach ($data['checklist'] as $key => $value) { ?>
                        <th colspan="<?= $data['colspan'][$key] ?>"><?= $value['kriteria'] ?></th>
                    <?php } ?>
                </tr>
                <tr>
                    <?php foreach ($data['checklist'] as $kriteria) { ?>
                        <?php foreach ($kriteria['sub-kriteria'] as $key => $value) { ?>
                            <th colspan="<?= $data['colspan'][$key] ?>"><?= $value['sub-kriteria'] ?></th>
                        <?php } ?>
                    <?php } ?>
                </tr>
                <tr>
                    <th>Email</th>
                    <th>Nama Lengkap</th>
                    <th>Program Studi</th>
                    <?php foreach ($data['checklist'] as $kriteria) { ?>
                        <?php foreach ($kriteria['sub-kriteria'] as $sub_kriteria) {
                            $i = 1;
                        ?>
                            <?php foreach ($sub_kriteria['pertanyaan'] as $key => $value) {
                                $answer_order[] = $key;
                            ?>
                                <th><?= "P" . $i++ //$value['kode'] 
                                    ?></th>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data['Kuisioner'] as $kuisioner) {
                ?>
                    <tr>
                        <td data-label="Email">
                            <?= $kuisioner['email']; ?>
                        </td>
                        <td data-label="Nama Lengkap">
                            <?= $kuisioner['nama']; ?>
                        </td>
                        <td data-label="Program Studi">
                            <?= $kuisioner['program_studi']; ?>
                        </td>
                        <?php foreach ($answer_order as $kuisioner_id) { ?>
                            <td data-label="<?= $kuisioner_id ?>">
                                <?= $kuisioner[$kuisioner_id]; ?>
                            </td>
                        <?php } ?>
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