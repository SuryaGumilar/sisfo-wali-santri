<?php

$title = "Dashboard Bendahara";
require 'includes/header.php';

checkRole(['bendahara']);

?>
<h1 class="greet">Selamat datang <?php echo htmlspecialchars($_SESSION['username']); ?></h1>

<?php include 'includes/footer.php'; ?>