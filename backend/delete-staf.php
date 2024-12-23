<?php
require 'functions.php';

if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $conn->query("DELETE FROM users WHERE username = $username");
    if ($_GET['role'] === 'pengurus') {
        $conn->query("UPDATE wali SET pengurus = NULL WHERE username = $username");
    }
    header("Location: ../manage-staf.php");
}
?>