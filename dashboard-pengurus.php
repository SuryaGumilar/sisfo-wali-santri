<?php

$title = "Dashboard Pengurus";
require 'includes/header.php';

checkRole(['pengurus']);

?>

<main class="container-sm">
    <h3 class="greet">Selamat datang <?php echo htmlspecialchars($_SESSION['username']); ?></h3>
    <a href="manage-capaian.php" class="btn btn-primary" tabindex="-1" role="button" aria-disabled="true">Klik di sini untuk mengelola capaian santri</a>

</main>
<?php include 'includes/footer.php'; ?>