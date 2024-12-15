<?php
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validasi password
    if ($password !== $confirmPassword) {
        die("Password dan konfirmasi password tidak cocok!");
    }

    // Hash password baru
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Contoh username saat login (gunakan session pada implementasi nyata)
    $username = $_SESSION['username'];

    // Update password di database
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
    $stmt->bind_param("ss", $hashedPassword, $username);

    if ($stmt->execute()) {
        echo "Password berhasil diubah!";
    } else {
        echo "Terjadi kesalahan: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>