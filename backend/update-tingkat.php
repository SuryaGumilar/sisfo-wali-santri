<?php
require 'functions.php';

$tingkat_baru = $_POST['tingkat'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_ids'])) {
    $ids = implode(",", array_map('intval', $_POST['selected_ids']));
    $conn->query("UPDATE wali SET tingkat = '$tingkat_baru' WHERE username IN ($ids)");
    header('Location: ../pengubahan-tingkat.php');
    exit;
} else {
    echo "<script>alert('Harap pilih setidaknya satu data');</script>";
    header('Location: ../pengubahan-tingkat.php');
}
?>