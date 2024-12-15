<?php
session_start();
session_unset(); // Hapus semua data session
session_destroy(); // Hapus sesi
header('Location: login.php'); // Redirect ke halaman login
exit();
?>