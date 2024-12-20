<?php

$title = "Dashboard Admin";
require 'includes/header.php';

checkRole(['admin']);

?>
<h1 class="greet">Selamat datang <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    
<?php include 'includes/footer.php'; ?>