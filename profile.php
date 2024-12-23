<?php

$title = "Informasi Login";
require 'includes/header.php';

?>
<main>
<div class="common-box">
    <h2>Informasi Login</h2>
    <p>Nama: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
    <form action="backend/update-password.php" method="POST">
        <div class="input-group">
            <label for="password">Password Baru</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="input-group">
            <label for="confirm-password">Konfirmasi Password</label>
            <input type="password" id="confirm-password" name="confirm_password" required>
        </div>
        <button type="submit" class="blue-button">Ubah Password</button>
        <?php if (isset($_GET['message'])): ?>
            <div style="color: <?= strpos($_GET['message'], 'berhasil') !== false ? 'green' : 'red'; ?>; text-align: center; margin-top: 20px;">
                <?= htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>
    </form>
</div>
</main>
<?php include 'includes/footer.php'; ?>