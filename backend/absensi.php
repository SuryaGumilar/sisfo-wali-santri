<?php
require 'functions.php';

// Menyimpan absensi yang telah dipilih
if (isset($_POST['status'])) {
    $status = $_POST['status'];
    $ids = $_POST['selected_ids'];
    $tanggal = date('Y-m-d');

    $tahunQuery = "SELECT tahun FROM tahun_akademik WHERE status = TRUE LIMIT 1";
    $tahunResult = $conn->query($tahunQuery);

    foreach ($ids as $id) {
        $checkQuery = "SELECT * FROM absensi WHERE username = ? AND tanggal = ?";
        $stmtCheck = $conn->prepare($checkQuery);
        $stmtCheck->bind_param("ss", $id, $tanggal);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();

        if ($tahunResult->num_rows > 0) {
            $tahunRow = $tahunResult->fetch_assoc();
            $tahun_akademik = $tahunRow['tahun'];

            if ($result->num_rows > 0) {
                // Jika data ada, lakukan UPDATE
                $stmt = $conn->prepare("UPDATE absensi SET status = ?, tanggal = ?, tahun_akademik = ? WHERE username = ?");
                $stmt->bind_param("ssss", $status, $tanggal, $tahun_akademik, $id);
                if ($stmt->execute()) {
                    echo "Data berhasil diupdate.";
                    header('Location: ../dashboard-pengurus.php');
                } else {
                    echo "Error: " . $stmt->error;
                }
            } else {
                // Jika data tidak ada, lakukan INSERT
                $stmt = $conn->prepare("INSERT INTO absensi (username, status, tanggal, tahun_akademik) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $id, $status, $tanggal, $tahun_akademik);
                if ($stmt->execute()) {
                    echo "Data berhasil ditambahkan.";
                    header('Location: ../dashboard-pengurus.php');
                } else {
                    echo "Error: " . $stmt->error;
                }
            }
        }
        
    }
}

$conn->close();

?>