<?php

$title = "Dashboard Pengurus";
require 'includes/header.php';

checkRole(['pengurus']);

?>
<h1 class="greet">Selamat datang <?php echo htmlspecialchars($_SESSION['username']); ?></h1>

<?php include 'includes/footer.php'; ?>