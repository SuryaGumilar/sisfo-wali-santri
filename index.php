<?php
include 'includes/auth.php';

if ($_SESSION['role'] === 'pengurus') {
    header('Location: dashboard-pengurus.php');
    exit();
} elseif ($_SESSION['role'] === 'bendahara') {
    header('Location: dashboard-bendahara.php');
    exit();
} else {
    header('Location: dashboard-wali.php');
    exit();
}
?>