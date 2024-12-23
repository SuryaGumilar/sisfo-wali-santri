<?php
require 'functions.php';

$type = $_GET['type'];

if ($type === 'jumlah') {
    $result = $conn->query("SELECT COUNT(*) as jumlah FROM siswa");
    $data = $result->fetch_assoc();
    echo json_encode(['jumlah' => $data['jumlah']]);
} elseif ($type === 'kelas') {
    $result = $conn->query("SELECT DISTINCT kelas FROM siswa");
    $kelas = [];
    while ($row = $result->fetch_assoc()) {
        $kelas[] = $row['kelas'];
    }
    echo json_encode(['kelas' => $kelas]);
} elseif ($type === 'siswa') {
    $kelas = $_GET['kelas'];
    $result = $conn->query("SELECT id, nis, nama, CONCAT(tempatLahir, ', ', tglLahir) as ttl FROM siswa WHERE kelas = '$kelas'");
    $siswa = [];
    while ($row = $result->fetch_assoc()) {
        $siswa[] = $row;
    }
    echo json_encode(['siswa' => $siswa]);
}

$conn->close();
?>