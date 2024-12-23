<?php

$title = "Riwayat Capaian";
require 'includes/header.php';
require 'backend/functions.php';

checkRole(['pengurus']);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $username = $_GET['username'];
    $res = $conn->query("SELECT nama FROM wali WHERE username = '$username'");
    if ($row = $res->fetch_assoc()) {
        $nama = $row['nama'];
    }

    $sql = "SELECT * FROM capaian WHERE username = '$username'";
    $result = $conn->query($sql);
}


?>

<main class="container container-sm mt-5">
    <?php
    if ($_SESSION['role'] === 'pengurus') {
        echo '<a class="btn btn-secondary mb-5" href="manage-capaian.php">Kembali ke Kelola Capaian</a>';
    }
    ?>
    <h4 class="mb-4 text-center">Riwayat Capaian <?= htmlspecialchars($nama) ?></h4>
    <div class="table-responsive text-center"">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Surat</th>
                    <th>Ayat</th>
                    <th>Juz</th>
                    <th>Halaman</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['tanggal'] ?></td>
                    <td><?= $row['nama_surat'] ?></td>
                    <td><?= $row['ayat'] ?></td>
                    <td><?= $row['juz'] ?></td>
                    <td><?= $row['halaman'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</main>
<?php include 'includes/footer.php'; ?>