<div class="picker-input" id="month-picker">
    <input id="Bulan" required type="month" value="<?= (isset($data['month'])) ? $data['month'] : date('Y-m') ?>" max="<?= date('Y-m') ?>" min="<?= date('Y-m', strtotime(FIRST_DATE)) ?>" pattern="[0-9]{4}-[0-9]{2}">
    <label for="Bulan" class="btn btn-md btn-primary">Bulan</label>
</div>
<script>
    const monthPickerContainer = document.getElementById("month-picker");
    const labelMonth = monthPickerContainer.querySelector("label");
    const monthPicker = monthPickerContainer.querySelector("input#Bulan");
    labelMonth.addEventListener("click", () => {
        monthPicker.showPicker();
    })
    monthPicker.addEventListener("change", () => {
        updateLabel()
    });
    updateLabel();

    function updateLabel() {
        const date = new Date(monthPicker.value);
        const formatter = new Intl.DateTimeFormat("id", {
            month: "long",
            year: "numeric"
        });
        const localizedMonth = formatter.format(date);
        labelMonth.innerHTML = localizedMonth;
    }
</script>