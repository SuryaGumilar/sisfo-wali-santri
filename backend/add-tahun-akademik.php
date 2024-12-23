<?php
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tahun = $conn->real_escape_string($_POST['tahun']);

    $check = $conn->query("SELECT * FROM tahun_akademik WHERE tahun = '$tahun'");
    if ($check->num_rows > 0) {
        echo "<script>alert('Tahun akademik sudah ada! Silakan tambahkan tahun yang berbeda.'); window.location.href = 'index.php';</script>";
    } else {
        $conn->query("INSERT INTO tahun_akademik (tahun) VALUES ('$tahun')");
        header("Location: ../dashboard-admin.php");
    }
}
?>