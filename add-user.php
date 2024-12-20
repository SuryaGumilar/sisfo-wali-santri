<?php

$title = "Tambah Pengguna";
require 'includes/header.php';

checkRole(['admin']);

?>
<div class="common-box">
    <h2>Tambah Pengguna</h2>
    <p>Pilih file Excel yang ingin diunggah untuk menambahkan data pengguna.</p>
    <form action="backend/add-user-logic.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="file">Pilih File Excel (.xls, .xlsx):</label>
            <input type="file" id="file" name="file" accept=".xls,.xlsx" required>
        </div>
        <button type="submit" class="blue-button">Unggah File</button>
    </form>
</div>
<?php if (isset($_GET['message'])): ?>
    <div style="color: <?= strpos($_GET['message'], 'berhasil') !== false ? 'green' : 'red'; ?>; text-align: center; margin-top: 20px;">
        <?= htmlspecialchars($_GET['message']); ?>
    </div>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>