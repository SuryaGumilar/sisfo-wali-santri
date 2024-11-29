<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
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