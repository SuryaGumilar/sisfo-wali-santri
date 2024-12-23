<?php
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_ids'])) {
    $ids = implode(",", array_map('intval', $_POST['selected_ids']));
    $conn->query("DELETE FROM wali WHERE username IN ($ids)");
    $conn->query("DELETE FROM users WHERE username IN ($ids)");
    header('Location: ../manage-wali-santri.php');
    exit;
} elseif (isset($_GET['username'])) {
    $username = $_GET['username'];
    $conn->query("DELETE FROM wali WHERE username = $username");
    $conn->query("DELETE FROM users WHERE username = $username");
    header("Location: ../manage-wali-santri.php");
}
?>