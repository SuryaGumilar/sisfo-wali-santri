<?php

$title = "Dashboard Bendahara";
require 'includes/header.php';

checkRole(['bendahara']);

?>
<main >
    <div class="container-sm">
    
    </div>
    <h2 class="greet">Selamat datang <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
</main>
<?php include 'includes/footer.php'; ?>