<?php

$title = "Pembayaran SPP";
require 'includes/header.php';
require 'backend/functions.php';

checkRole(['wali']);

$payments = $conn->query("SELECT * FROM pembayaran_spp WHERE username = '{$_SESSION['username']}'");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $month = $_POST['bulan'];
    $year = $_POST['tahun'];
    $proof = $_FILES['bukti_pembayaran'];
    $username = $_SESSION['username'];

    $proofPath = 'uploads/' . basename($proof['name']);
    move_uploaded_file($proof['tmp_name'], $proofPath);

    $sql = "INSERT INTO pembayaran_spp (username, bulan, tahun, bukti_pembayaran, status) 
        VALUES ('$username', $month, $year, '$proofPath', 'Belum Diperiksa')";

    if ($conn->query($sql) === TRUE) {
        header("Refresh: 0");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>
<div class="container mt-5">
    <h4>Daftar Pembayaran SPP</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $payments->fetch_assoc()): ?>
            <tr>
                <td><?= $row['bulan'] ?></td>
                <td><?= $row['tahun'] ?></td>
                <td>
                    <span class="badge <?= $row['status'] === 'Sudah Dibayar' ? 'bg-success' : ($row['status'] === 'Belum Diperiksa' ? 'bg-warning' : 'bg-danger') ?>">
                        <?= $row['status'] ?>
                    </span>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    

    <h4>Kirim Bukti Pembayaran</h4>
    <form method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow">
        <div class="mb-3">
            <label for="month" class="form-label">Bulan</label>
            <input type="number" name="bulan" id="month" class="form-control" placeholder="Masukkan nomor bulan (contoh 12 untuk Desember)" required>
        </div>
        <div class="mb-3">
            <label for="year" class="form-label">Tahun</label>
            <input type="number" name="tahun" id="year" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="proof" class="form-label">Unggah Bukti Pembayaran</label>
            <input type="file" name="bukti_pembayaran" id="proof" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
</div>
</div>
<?php include 'includes/footer.php'; ?>