<?php
session_start();
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validasi password
    if ($password !== $confirmPassword) {
        header("Location: ../profile.php?message=Password%20dan%20konfirmasi%20tidak%20cocok");
        exit;
    }

    // Hash password baru
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Contoh username saat login (gunakan session pada implementasi nyata)
    $username = $_SESSION['username'];

    // Update password di database
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
    $stmt->bind_param("ss", $hashedPassword, $username);

    if ($stmt->execute()) {
        header("Location: ../profile.php?message=Password%20berhasil%20diubah!");
    } else {
        header("Location: ../profile.php?message=Terjadi%20kesalahan:%20" . urlencode($conn->error));
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>