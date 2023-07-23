<div class="row">
    <div class="col-sm me-auto">
        <h3><strong>Refresh Data</strong></h3>
    </div>
</div>
<hr>
<p>
    Tombol refresh data ini <span class="text-warning">berfungsi untuk menyinkronkan data pada aplikasi</span>.
    Proses ini melibatkan sinkronisasi data dari awal sehingga diperlukan waktu yang cukup lama untuk menyelesaikan proses tersebut.
</p><br />
<p>
    Tombol refresh data ini <span class="text-warning">sebaiknya digunakan ketika terjadi perbedaan data atau ketidaksesuaian antara data transaksi, harga, dan stok pada aplikasi dengan perekapan</span>. Anda dapat menggunakan tombol ini <span class="text-success">secara berkala atau saat diperlukan untuk memastikan data yang digunakan di aplikasi selalu akurat dan terbaru</span>. Namun, perlu diingat bahwa <span class="text-danger">proses sinkronisasi ini dapat memakan waktu yang cukup lama</span>, sehingga disarankan untuk tidak menggunakannya terlalu sering jika tidak diperlukan.
</p><br />
<form method="post" name="refresh">
    <button type="submit" class="btn btn-warning" id="refresh" name="refresh">&#10226;
        Refresh Data
</form>
<script>
    document.querySelector('#refresh').addEventListener('click', (e) => {
        loadingPage.style.display = "";
    })
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector("#refresh-tab").classList.add("active");
    });
</script>