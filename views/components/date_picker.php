<div class="picker-input" id="date-picker">
    <input id="date" required type="date" value="<?= (isset($data['date'])) ? $data['date'] : date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d', strtotime(FIRST_DATE)) ?>" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
    <label for="date" class="btn btn-md btn-primary">Tanggal</label>
</div>
<script>
    const datePickerContainer = document.getElementById("date-picker");
    const labelDate = datePickerContainer.querySelector("label");
    const datePicker = datePickerContainer.querySelector("input#date");
    labelDate.addEventListener("click", () => {
        datePicker.showPicker();
    })
    datePicker.addEventListener("change", () => {
        updateDateLabel()
    });
    updateDateLabel();

    function updateDateLabel() {
        const date = new Date(datePicker.value);
        const formatter = new Intl.DateTimeFormat("id", {
            day: "numeric",
            month: "long",
            year: "numeric"
        });
        const localizedDate = formatter.format(date);
        labelDate.innerHTML = localizedDate;
    }
</script>