<?php
session_start();
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Query untuk mencari user berdasarkan username
    $query = "SELECT * FROM users WHERE NIS = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verifikasi password (menggunakan hash)
        if (password_verify($password, $user['password'])) {
            // Set session jika login sukses
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect berdasarkan role
            if ($user['role'] === 'pengurus') {
                header('Location: dashboard-pengurus.html');
            } elseif ($user['role'] === 'bendahara') {
                header('Location: dashboard-bendahara.html');
            } else {
                header('Location: dashboard-wali.html');
            }
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}

?>
