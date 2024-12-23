<?php

$title = "Riwayat Absensi";
require 'includes/header.php';
require 'backend/functions.php';

checkRole(['wali']);

$username = $_SESSION['username'];

$res = $conn->query("SELECT nama FROM wali WHERE username = '$username'");
if ($row = $res->fetch_assoc()) {
    $nama = $row['nama'];
}

$sql = "SELECT * FROM absensi WHERE username=$username";
$filter_result = $conn->query($sql);

?>

<main class="container container-sm mt-5">
    <h4 class="mb-4 text-center">Riwayat Absensi <?= htmlspecialchars($nama) ?></h4>
    <div class="table-responsive text-center"">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $filter_result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['tanggal'] ?></td>
                    <td><?= $row['status'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</main>
<?php include 'includes/footer.php'; ?>