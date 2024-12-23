<?php
require 'functions.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tetapkan'])) {
    $selectedTingkat = $_POST['tingkat'];
    $selectedPengurus = $_POST['pengurus'];

    // Update pengurus di tabel wali
    $updateQuery = $conn->prepare("UPDATE wali SET pengurus = ? WHERE tingkat = ?");
    $updateQuery->bind_param("ss", $selectedPengurus, $selectedTingkat);
    $updateQuery->execute();

    if ($updateQuery->affected_rows > 0) {
        header('Location: ../atur-pengurus.php');
        echo '<div class="alert alert-success">Pengurus berhasil diperbarui.</div>';
    } else {
        header('Location: ../atur-pengurus.php');
        echo '<div class="alert alert-warning">Tidak ada data yang diubah.</div>';
    }
}
?>