<?php

$title = "Dashboard Bendahara";
require 'includes/header.php';
require 'backend/functions.php';

checkRole(['bendahara']);

?>
<main >
    <div class="container-sm">
    <?php

// Tampilkan semua pembayaran
$payments = $conn->query("SELECT pembayaran_spp.*, wali.nama FROM pembayaran_spp JOIN wali ON pembayaran_spp.username = wali.username");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paymentId = $_POST['pembayaran_id'];
    $status = 'Sudah Dibayar';
    
    $sql = "UPDATE pembayaran_spp SET status = '$status' WHERE pembayaran_id = $paymentId";

    if ($conn->query($sql) === TRUE) {
        header("Refresh: 0");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
}
?>
<div class="container mt-5">
    <h4 class="greet">Selamat datang <?php echo htmlspecialchars($_SESSION['username']); ?></h4>
    <h4>Daftar Pembayaran SPP</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Wali Santri</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Status</th>
                <th>Bukti</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $payments->fetch_assoc()): ?>
            <tr>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['bulan'] ?></td>
                <td><?= $row['tahun'] ?></td>
                <td>
                    <span class="badge <?= $row['status'] === 'Sudah Dibayar' ? 'bg-success' : ($row['status'] === 'Belum Diperiksa' ? 'bg-warning' : 'bg-danger') ?>">
                        <?= $row['status'] ?>
                    </span>
                </td>
                <td>
                    <?php if ($row['bukti_pembayaran']): ?>
                        <a href="<?= $row['bukti_pembayaran'] ?>" target="_blank" class="btn btn-info btn-sm">Lihat Bukti</a>
                    <?php else: ?>
                        Tidak Ada
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($row['status'] === 'Belum Diperiksa'): ?>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="pembayaran_id" value="<?= $row['pembayaran_id'] ?>">
                            <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</div>
</main>
<?php include 'includes/footer.php'; ?>