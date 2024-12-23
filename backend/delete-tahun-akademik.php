<?php
require 'functions.php';

if (isset($_GET['idTahun'])) {
    $idTahun = (int) $_GET['idTahun'];
    $conn->query("DELETE FROM tahun_akademik WHERE idTahun = $idTahun");
    header("Location: ../dashboard-admin.php");
}
?>