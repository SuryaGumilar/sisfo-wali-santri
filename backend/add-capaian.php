<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $nama_surat = $_POST['nama_surat'];
    $ayat = $_POST['ayat'];
    $juz = $_POST['juz'];
    $halaman = $_POST['halaman'];
    $tanggal = $_POST['tanggal'];

    // Ambil tahun aktif dari tabel tahun_akademik
    $tahun_aktif = $conn->query("SELECT tahun FROM tahun_akademik WHERE status = TRUE LIMIT 1");
    $tahun = $tahun_aktif->fetch_assoc()['tahun'];

    // Periksa apakah data sudah ada di tabel capaian
    $cek = $conn->query("SELECT * FROM capaian WHERE username = '$username' AND tanggal = '$tanggal'");
    if ($cek->num_rows > 0) {
        // Update data jika sudah ada
        $conn->query("
            UPDATE capaian 
            SET nama_surat = '$nama_surat', ayat = $ayat, juz = $juz, halaman = $halaman, tahun_akademik = '$tahun'
            WHERE username = '$username' AND nama_surat = '$nama_surat' AND ayat = $ayat
        ");
    } else {
        // Insert data baru jika belum ada
        $conn->query("
            INSERT INTO capaian (username, nama_surat, ayat, juz, halaman, tahun_akademik, tanggal)
            VALUES ('$username', '$nama_surat', $ayat, $juz, $halaman, '$tahun', '$tanggal')
        ");
    }

    // Redirect kembali ke halaman utama
    header("Location: ../manage-capaian.php?status=success");
    exit();
}
?>
