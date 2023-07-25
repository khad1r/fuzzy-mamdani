<div class="container" id="form">
    <div class="form-group">
        <label>
            <strong>
                <h4>Variabel</h4>
            </strong>
        </label>
        <table class="table table-responsive table-hover table-sm table-bordered myTable">
            <?php
            $crite = [];
            foreach ($data['kriteria'] as $kriteria) {
                $crite[] = $kriteria['kriteria'];
            ?>
                <tr>
                    <td><?= $kriteria['kriteria'] ?></td>
                    <td><b><?= $data['score'][$kriteria['kode']] ?></b></td>
                </tr>
            <?php } ?>
            <tr>
                <td>Maturity Level</td>
                <td><b>OUTPUT</b></td>
            </tr>
        </table>
    </div>
    <hr>
    <div class="form-group">
        <label>
            <strong>
                <h4>Himpunan Fuzzy</h4>
            </strong>
        </label>
        <table class="table table-responsive table-hover table-sm table-bordered myTable">
            <tr>
                <td>Variabel</td>
                <td>Himpunan</td>
                <td>Semesta</td>
                <td>Domain</td>
            </tr>
            <tr>
                <td rowspan="5"><?= "&neArr;" . implode(',<br>&neArr;', $crite) ?>,<br>&seArr;Maturity Level </td>
                <td>Sangat Tidak Baik</td>
                <td>[0-100]</td>
                <td>[0 0 10 30]</td>
            </tr>
            <tr>
                <td>Tidak Baik</td>
                <td>[0-100]</td>
                <td>[10 30 50]</td>
            </tr>
            <tr>
                <td>Cukup</td>
                <td>[0-100]</td>
                <td>[30 50 70]</td>
            </tr>
            <tr>
                <td>Baik</td>
                <td>[0-100]</td>
                <td>[50 70 90]</td>
            </tr>
            <tr>
                <td>Sangat Baik</td>
                <td>[0-100]</td>
                <td>[80 90 100 100]</td>
            </tr>
        </table>
    </div>
    <hr>
    <div class="form-group">
        <label>
            <strong>
                <h4>Fungsi Keangotaan</h4>
            </strong>
        </label>
        <img src="<?= BASEURL . $data['membership_function'] ?>" class="img-fluid img-responsive" style="width:100%">
    </div>
    <hr>
    <div class="form-group">
        <label>
            <strong>
                <h4>Rule Fuzzy</h4>
            </strong>
        </label>
        <table class="table table-responsive table-hover table-sm table-bordered myTable">
            <?php

            $rules = [
                "IF (<i>Funtional Suitability</i>[<b>Sangat Baik</b>] AND (<i>Usability</i>[<b>Sangat Baik</b>] OR <i>Reliability</i>[<b>Sangat Baik</b>])) THEN <i>Maturity Level</i>[<b>Sangat Baik</b>]",
                "IF (<i>Funtional Suitability</i>[<b>Baik</b>] AND (<i>Usability</i>[<b>Sangat Baik</b>] OR <i>Reliability</i>[<b>Sangat Baik</b>])) THEN <i>Maturity Level</i>[<b>Sangat Baik</b>]",
                "IF (<i>Funtional Suitability</i>[<b>Cukup</b>] AND (<i>Usability</i>[<b>Baik</b>] OR <i>Reliability</i>[<b>Sangat Baik</b>])) THEN <i>Maturity Level</i>[<b>Baik</b>]",
                "IF (<i>Funtional Suitability</i>[<b>Sangat Tidak Baik</b>] AND (<i>Usability</i>[<b>Sangat Baik</b>] OR <i>Reliability</i>[<b>Baik</b>])) THEN <i>Maturity Level</i>[<b>Cukup</b>]",
                "IF (<i>Funtional Suitability</i>[<b>Tidak Baik</b>] AND (<i>Usability</i>[<b>Cukup</b>] OR <i>Reliability</i>[<b>Cukup</b>])) THEN <i>Maturity Level</i>[<b>Tidak Baik</b>]",
                "IF (<i>Funtional Suitability</i>[<b>Sangat Baik</b>] AND (<i>Usability</i>[<b>Baik</b>] OR <i>Reliability</i>[<b>Tidak Baik</b>])) THEN <i>Maturity Level</i>[<b>Baik</b>]",
                "IF (<i>Funtional Suitability</i>[<b>Baik</b>] AND (<i>Usability</i>[<b>Tidak Baik</b>] OR <i>Reliability</i>[<b>Sangat Tidak Baik</b>])) THEN <i>Maturity Level</i>[<b>Tidak Baik</b>]",
                "IF (<i>Funtional Suitability</i>[<b>Cukup</b>] AND (<i>Usability</i>[<b>Sangat Tidak Baik</b>] OR <i>Reliability</i>[<b>Sangat Baik</b>])) THEN <i>Maturity Level</i>[<b>Cukup</b>"
            ];
            foreach ($rules as $key => $rule) { ?>
                <tr>
                    <td>Rule <?= $key + 1 ?></td>
                    <td><?= $rule ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <hr>
    <div class="form-group">
        <label>
            <strong>
                <h4>Defuzzyfikasi Komposisi Aturan</h4>
            </strong>
        </label>
        <img src="<?= BASEURL . $data['membership_activity'] ?>" class="img-fluid img-responsive" style="width:100%">
    </div>
    <hr>
    <div class="form-group">
        <label>
            <strong>
                <h4>Hasil Komposisi Defuzzyfikasi Mean Of Maximum</h4>
            </strong>
        </label>
        <img src="<?= BASEURL . $data['result_mom'] ?>" class="img-fluid img-responsive" style="width:100%">
    </div>
    <hr>
    <div class="form-group">
        <label>
            <strong>
                <h4>Hasil Fuzzy Mamdani</h4>
            </strong>
        </label>
        <p class="mb-3">Maturity Level yang didapatkan adalah : </p>
        <h3><b><?= $data['maturity'] ?></b></h3>
    </div>
</div>
<script>
    document.querySelector("#Analisis").classList.add("active");
</script>