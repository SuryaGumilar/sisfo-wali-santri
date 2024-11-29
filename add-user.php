<?php
include 'includes/auth.php';

checkRole(['pengurus']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna</title>
    <link rel="icon" href="images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="main-container">
        <div class="add-user-card">
            <h2>Upload File Excel</h2>
            <p>Pilih file Excel yang ingin diunggah untuk menambahkan data pengguna.</p>
            <form action="add-user.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="file">Pilih File Excel (.xls, .xlsx):</label>
                    <input type="file" id="file" name="file" accept=".xls,.xlsx" required>
                </div>
                <button type="submit" class="btn-submit">Unggah File</button>
            </form>
        </div>
    </div>
</body>
</html>
