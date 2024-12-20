<?php

$title = "Dashboard Wali Santri";
require 'includes/header.php';

checkRole(['wali']);

?>
<h1 class="greet">Selamat datang wali <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
<main class="content">
    <div class="card">
    <div class="card-description">SPP BULAN INI SUDAH DIBAYAR</div>
    <a href="#riwayat1" class="card-link">LIHAT RIWAYAT</a>
    </div>
    <div class="card">
    <div class="card-description">REKAP ABSENSI ALFA: 0 SAKIT: 0</div>
    <a href="#riwayat2" class="card-link">LIHAT RIWAYAT</a>
    </div>
    <div class="card">
    <div class="card-description">CAPAIAN SANTRI QS AL-FATIHAH 1-7</div>
    <a href="#riwayat3" class="card-link">LIHAT RIWAYAT</a>
    </div>
</main>
<?php include 'includes/footer.php'; ?>