<?php

$title = "Dashboard Wali Santri";
require 'includes/header.php';
require 'backend/functions.php';

checkRole(['wali']);

$result = $conn->query("SELECT nama FROM wali WHERE username='{$_SESSION['username']}'");
$nama = $result->fetch_assoc();

$data_wali = $conn->query("
    SELECT nama_surat, ayat, juz, halaman, tanggal
    FROM capaian WHERE username = '{$_SESSION['username']}'
");

while ($row = $data_wali->fetch_assoc()){
    if ($row['tanggal'] == date('Y-m-d')) {
        $capaianHariIni = $row['nama_surat'] . ':' . $row['ayat'] . ' Juz ' . $row['juz'] . ', Halaman ' . $row['halaman'];
    } else {
        $capaianHariIni = 'Belum ada capaian';
    }
}

$data_absen = $conn->query("
    SELECT status, tanggal
    FROM absensi WHERE username = '{$_SESSION['username']}'
");

while ($row = $data_absen->fetch_assoc()){
    if ($row['tanggal'] == date('Y-m-d')) {
        $absenHariIni = $row['status'];
    } else {
        $absenHariIni = 'Belum diabsen';
    }
}
    


?>

<main class="container-sm">
    <h3 class="greet">Selamat datang wali <?php echo htmlspecialchars($nama['nama']); ?></h3>
    <main class="content">
        <div class="card"> 
        <div class="card-description">SPP BULAN INI SUDAH DIBAYAR</div>
        <a href="#riwayat1" class="card-link">MENU SPP</a>
        </div>
        <div class="card">
        <div class="card-description">ABSENSI HARI INI:<br>
        <?php echo htmlspecialchars($absenHariIni); ?></div>
        <a href="riwayat-absensi.php" class="card-link">LIHAT RIWAYAT ABSENSI</a>
        </div>
        <div class="card">
        <div class="card-description">CAPAIAN HARI INI:<br>
            <?php echo htmlspecialchars($capaianHariIni); ?></div>
        <a href="riwayat-capaian-wali.php" class="card-link">LIHAT RIWAYAT CAPAIAN</a>
    </main>
</main>

<?php include 'includes/footer.php' ?>