<script>
    console.log('tes')
    const transaction = <?= json_encode($data['transaction']) ?>;
    // document.querySelector('#form-transaksi').action = '<?= BASEURL ?>/Transaction/change/';
    document.addEventListener("DOMContentLoaded", function() {
        instanceSelect.value = transaction['instansi']
        instanceId.value = transaction['id_instansi']
        jenisBBM = document.querySelector('#jenis_bbm')
        for (var i = 0; i < jenisBBM.options.length; i++) {
            if (jenisBBM.options[i].innerText == transaction['jenis_bbm']) {
                jenisBBM.options[i].selected = true;
                break;
            }
        }
        const date = new Date(transaction['timestamp']);
        const year = date.getFullYear();
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const day = date.getDate().toString().padStart(2, '0');
        const hour = date.getHours().toString().padStart(2, '0');
        const minute = date.getMinutes().toString().padStart(2, '0');
        <?php if (App::CheckUser('petugas')) { ?>
            document.querySelector('input[name="time"]').value = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
        <?php } else { ?>
            document.querySelector('input[name="timestamp"]').value = `${year}-${month}-${day}T${hour}:${minute}`;
        <?php } ?>
        document.querySelector('#stokBBM').textContent = 'Stok ' + transaction['jenis_bbm'];
        document.querySelector('#stok').textContent = formattedNumber.format(fuels[transaction['jenis_bbm']]['stok']) + ' L';
        // document.querySelector('#stokInUse').textContent = formattedNumber.format(fuels[transaction['jenis_bbm']]['in_use_stok']) + ' L';
        document.querySelector('input[name="nota"]').value = transaction['nota']
        document.querySelector('#uang').value = transaction['total'].toLocaleString('id')
        document.querySelector('input[name="plat_nomor"]').value = transaction['plat_nomor']
        document.querySelector('input[name="record"]').value = 'Update Transaksi'
        document.querySelector('input[name="record"]').style.backgroundColor = '#f9a825';
        document.querySelector('textarea[name="keterangan"]').textContent = transaction['keterangan'];
        document.querySelector('#metode_pembayaran').style.display =
            (instanceSelect.value == "<?= $data['instances'][0]['nama_instansi'] ?>") ? 'block' : 'none';
        metodePembayaran = document.querySelector('select[name="metode_pembayaran"]')
        for (var i = 0; i < metodePembayaran.options.length; i++) {
            if (metodePembayaran.options[i].value == transaction['metode_pembayaran']) {
                metodePembayaran.options[i].selected = true;
                break;
            }
        }
        harga = transaction['harga']
        total = transaction['total']
        updateSumary()
    });
    document.querySelector('#form-transaksi').addEventListener('submit', function(e) {
        e.preventDefault;
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'id';
        input.value = transaction['id'];
        e.currentTarget.appendChild(input);
        e.currentTarget.submit();
    });
</script>