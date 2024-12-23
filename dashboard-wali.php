<?php

$title = "Dashboard Wali Santri";
require 'includes/header.php';

checkRole(['wali']);

?>
<h2 class="greet">Selamat datang wali <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
<main class="content">
    <div class="card">
    <div class="card-description">SPP BULAN INI SUDAH DIBAYAR</div>
    <a href="#riwayat1" class="card-link">MENU SPP</a>
    </div>
    <div class="card">
    <div class="card-description">ABSENSI HARI INI: {status absensi}</div>
    <a href="#riwayat2" class="card-link">LIHAT RIWAYAT</a>
    </div>
    <div class="card">
    <div class="card-description">CAPAIAN HARI INI: QS AL-FATIHAH 1-7</div>
    <a href="#riwayat3" class="card-link">LIHAT RIWAYAT</a>
    </div>
</main>
<?php include 'includes/footer.php'; ?>