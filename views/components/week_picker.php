<?php
$curentWeek = date('Y') . '-W' . date("W");
$firstWeek = date('Y', strtotime(FIRST_DATE)) . '-W' . date("W", strtotime(FIRST_DATE));
?>
<div class="picker-input" id="week-picker">
    <input id="week" required type="week" value="<?= (isset($data['week'])) ? $data['week'] : $curentWeek ?>" max="<?= $curentWeek ?>" min="<?= $firstWeek ?>" pattern="[0-9]{4}-W[0-9]{2}">
    <label for="date" class="btn btn-md btn-primary">Minggu</label>
</div>
<script>
    const weekPickerContainer = document.getElementById("week-picker");
    const labelWeek = weekPickerContainer.querySelector("label");
    const weekPicker = weekPickerContainer.querySelector("input#week");
    labelWeek.addEventListener("click", () => {
        weekPicker.showPicker();
    })
    weekPicker.addEventListener("change", () => {
        updateDateLabel()
    });
    updateDateLabel();

    function updateDateLabel() {
        const weekValue = weekPicker.value;

        const year = weekValue.substr(0, 4);
        const week = weekValue.substr(6, 2);

        const date = new Date(year, 0, (week - 1) * 7);

        const formatter = new Intl.DateTimeFormat("id", {
            month: "long",
            year: "numeric"
        });
        const month = formatter.format(date).split(" ")[0];
        const localizedDate = `${month} ${year}`;
        labelWeek.innerHTML = localizedDate;
    }
</script>