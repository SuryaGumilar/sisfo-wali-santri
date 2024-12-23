<?php
require 'functions.php';

$username = $_POST['username'];
$plainPassword = $_POST['password'];
$hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);
$role = $_POST['role'];

$query = "INSERT INTO users (username, password, role, is_active) VALUES (:username, :password, :role, true)";
$stmt = $pdo->prepare($query);

try {
    $stmt->execute([
        ':username' => $username,
        ':password' => $hashedPassword,
        ':role' => $role
    ]);
    header("Location: ../manage-staf.php?message=Pengguna%20dengan%20username%20$username%20berhasil%20ditambahkan.");
} catch (PDOException $e) {
    header("Location: ../manage-staf.php?message=Error%20saat%20menyimpan%20pengguna%20$username:%20".$e->getMessage()."");
}