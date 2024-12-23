<?php
require '../vendor/autoload.php';  // Autoload untuk PhpSpreadsheet
require 'functions.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


if ($_FILES['file']['name']) {
    $fileName = $_FILES['file']['tmp_name'];
    $spreadsheet = IOFactory::load($fileName);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    // Iterasi setiap baris di file Excel, mulai dari baris kedua (untuk melewati header)
    for ($i = 1; $i < count($rows); $i++) {
        $username = $rows[$i][0];       // Kolom pertama: username
        $plainPassword = $rows[$i][1];  // Kolom kedua: password plaintext
        $role = $rows[$i][2];

        // Hash password
        $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);


        // Eksekusi query untuk menyimpan ke database
        try {
            $query_users = "INSERT INTO users (username, password, role, is_active) VALUES ('$username', '$hashedPassword', '$role', true)";
            mysqli_query($conn, $query_users);
            
            if ($role == 'wali') {
                $nama = $rows[$i][4];
                $tempatLahir = $rows[$i][5];
                $tglLahir = $rows[$i][6];
                $tingkat = $rows[$i][7];
            
                $query_siswa = "INSERT INTO wali (username, nama, tempatLahir, tglLahir, tingkat) 
                                VALUES ('$username', '$nama', '$tempatLahir', '$tglLahir', '$tingkat')";
                mysqli_query($conn, $query_siswa);
            }
            header("Location: ../manage-wali-santri.php?message=Pengguna%20dengan%20username%20$username%20berhasil%20diimport.");
        } catch (PDOException $e) {
            header("Location: ../manage-wali-santri.php?message=Error%20saat%20menyimpan%20pengguna%20$username:%20".$e->getMessage()."");
        }
    }
} else {
    echo "File tidak ditemukan.";
}