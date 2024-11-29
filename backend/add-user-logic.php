<?php
require 'vendor/autoload.php';  // Autoload untuk PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$host = 'localhost';
$db = 'sisfo_wali_santri';
$user = 'root';
$pass = '';

// Koneksi ke database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

if ($_FILES['file']['name']) {
    $fileName = $_FILES['file']['tmp_name'];
    $spreadsheet = IOFactory::load($fileName);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    $query = "INSERT INTO users (username, password, role, is_active) VALUES (:username, :password, 'wali', true)";
    $stmt = $pdo->prepare($query);

    // Iterasi setiap baris di file Excel, mulai dari baris kedua (untuk melewati header)
    for ($i = 1; $i < count($rows); $i++) {
        $username = $rows[$i][0];       // Kolom pertama: username
        $plainPassword = $rows[$i][1];  // Kolom kedua: password plaintext

        // Hash password
        $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);

        // Eksekusi query untuk menyimpan ke database
        try {
            $stmt->execute([
                ':username' => $username,
                ':password' => $hashedPassword
            ]);
            echo "Pengguna dengan username $username berhasil diimport.<br>";
        } catch (PDOException $e) {
            echo "Error saat menyimpan pengguna $username: " . $e->getMessage() . "<br>";
        }
    }
} else {
    echo "File tidak ditemukan.";
}