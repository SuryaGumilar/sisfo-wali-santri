<?php
session_start();

// Timeout setelah 1 minggu (604800 detik)
$timeout_duration = 604800;

// Periksa waktu aktivitas terakhir
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout_duration)) {
    // Hapus session jika timeout
    session_unset();
    session_destroy();
    header('Location: login.php'); // Redirect ke halaman login
    exit();
}

// Perbarui waktu aktivitas terakhir
$_SESSION['last_activity'] = time();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect ke halaman login
    exit();
}

// Fungsi untuk memeriksa role
function checkRole($allowed_roles) {
    if (!in_array($_SESSION['role'], $allowed_roles)) {
        header('Location: unauthorized.php'); // Redirect jika akses ditolak
        exit();
    }
}
?>