<?php
require '../vendor/autoload.php';  // Autoload untuk PhpSpreadsheet

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

    $query = "INSERT INTO users (username, password, role, is_active) VALUES (:username, :password, :role, true)";
    $stmt = $pdo->prepare($query);

    // Iterasi setiap baris di file Excel, mulai dari baris kedua (untuk melewati header)
    for ($i = 1; $i < count($rows); $i++) {
        $username = $rows[$i][0];       // Kolom pertama: username
        $plainPassword = $rows[$i][1];  // Kolom kedua: password plaintext
        $role = $rows[$i][2];

        // Hash password
        $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);

        // Eksekusi query untuk menyimpan ke database
        try {
            $stmt->execute([
                ':username' => $username,
                ':password' => $hashedPassword,
                ':role' => $role
            ]);
            header("Location: ../add-user.php?message=Pengguna%20dengan%20username%20$username%20berhasil%20diimport.");
        } catch (PDOException $e) {
            header("Location: ../add-user.php?message=Error%20saat%20menyimpan%20pengguna%20$username:%20".$e->getMessage()."");
        }
    }
} else {
    echo "File tidak ditemukan.";
}
