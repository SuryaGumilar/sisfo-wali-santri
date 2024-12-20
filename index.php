<?php
include 'includes/auth.php';

if ($_SESSION['role'] === 'admin') {
    header('Location: dashboard-admin.php');
    exit();
} elseif ($_SESSION['role'] === 'pengurus') {
    header('Location: dashboard-pengurus.php');
    exit();
} elseif ($_SESSION['role'] === 'bendahara') {
    header('Location: dashboard-bendahara.php');
    exit();
} elseif ($_SESSION['role'] === 'wali') {
    header('Location: dashboard-wali.php');
    exit();
}
?>