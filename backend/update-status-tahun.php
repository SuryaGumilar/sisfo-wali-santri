<?php
require 'functions.php';

header('Content-Type: application/json');

try {
    // Ambil data dari request
    $data = json_decode(file_get_contents('php://input'), true);
    $idTahun = $data['idTahun'] ?? null;

    if ($idTahun) {
        // Set semua status ke FALSE
        $pdo->query("UPDATE tahun_akademik SET status = FALSE");

        // Set status ke TRUE untuk record dengan ID yang diberikan
        $stmt = $pdo->prepare("UPDATE tahun_akademik SET status = TRUE WHERE idTahun = :idTahun");
        $stmt->execute(['idTahun' => $idTahun]);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'ID tidak valid.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>