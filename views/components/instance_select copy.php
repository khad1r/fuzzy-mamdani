<div class="instance-dropdown">
    <!-- <button onclick="myFunction()" class="form-control">Dropdown</button> -->
    <input type="text" id="instance_select" placeholder="Pilih Instansi" readonly name="instansi" class="form-control">
    <div id="instance_dropdown" class="dropdown-content">
        <input type="text" class="form-control" id="myInput" placeholder="Cari...">
        <?php
        foreach ($data['instances'] as $instance) {
        ?>
            <button type="button" value="<?= $instance['nama_instansi'] ?>"><?= $instance['nama_instansi'] ?></button>
        <?php
        }
        ?>
    </div>
</div>

<script>
    const instanceSelectContainer = document.querySelector('.instance-dropdown');
    const instanceSelect = instanceSelectContainer.querySelector('#instance_select');
    const instanceDropdown = instanceSelectContainer.querySelector('#instance_dropdown');
    const options = instanceDropdown.querySelectorAll('button');
    const searchInstanceSelect = instanceDropdown.querySelector('input#myInput');
    let OptionShow = [...options];
    const assignBTN = (BTNNode) => {
        BTNNode.addEventListener('click', (e) => {
            e.preventDefault;
            instanceSelect.value = BTNNode.value;
            instanceDropdown.classList.remove("show");
            instanceSelect.dispatchEvent(new Event('change'));
        })
    };
    const showOptions = function() {
        options.forEach(option => option.style.display = 'none');
        index = 5;
        count = 0
        OptionShow.forEach(option => {
            if (count++ > index) return
            option.style.display = ''
        });
    }
    options.forEach(option => {
        assignBTN(option)
    });
    instanceSelect.addEventListener('click', (e) => {
        e.preventDefault;
        instanceDropdown.classList.add("show");
        searchInstanceSelect.focus();
    })
    instanceDropdown.addEventListener('click', (e) => {
        if (e.target !== e.currentTarget) return;
        instanceDropdown.classList.remove("show");
    })
    window.addEventListener('click', function(e) {
        if (instanceSelectContainer.contains(e.target)) {
            return
        }
        if (!instanceDropdown.classList.contains("show")) {
            return
        }
        if (!instanceSelectContainer.contains(e.target)) {
            instanceDropdown.classList.remove("show");
        }
    });
    searchInstanceSelect.addEventListener('keyup', (e) => {
        OptionShow = [];
        let filter = e.target.value.toUpperCase();
        options.forEach(option => {
            if (option.value.toUpperCase().indexOf(filter) > -1) OptionShow.push(option);
        });
        showOptions();
    });
    showOptions();
</script>