<?php

$title = "Dashboard Pengurus";
require 'includes/header.php';
require 'backend/functions.php';
include 'includes/indo-date.php';

checkRole(['pengurus']);


$result = $conn->query("SELECT tingkat FROM wali WHERE pengurus='{$_SESSION['username']}' LIMIT 1");
$row = $result->fetch_assoc();
$tingkatSaatIni = strval($row['tingkat']);

$query = "
    SELECT wali.username, wali.nama, wali.tempatLahir, wali.tglLahir, absensi.status 
    FROM wali 
    LEFT JOIN absensi ON wali.username = absensi.username
    WHERE wali.pengurus = '{$_SESSION['username']}'
";

$res = $conn->query($query);

$jmlSantri = $conn->query("SELECT COUNT(*) AS jmlSantri FROM wali WHERE tingkat = '$tingkatSaatIni'")->fetch_assoc()['jmlSantri'];

?>

<main class="container-sm">
    <h3 class="greet">Selamat datang <?php echo htmlspecialchars($_SESSION['username']); ?></h3>
    <a href="manage-capaian.php" class="btn btn-primary" tabindex="-1" role="button" aria-disabled="true">Klik di sini untuk mengelola capaian santri</a>
    <h3 class="text-center">Absensi Hari Ini</h3>
    <p>Santri Tingkat: <?= $tingkatSaatIni ?></p>
    <p>Absensi Hari Ini (<?php echo "$hari, " . date('d') . " $bulan " . date('Y');?>)</p>
    <p>Jumlah Santri: <?= $jmlSantri ?></p>
    <div class="table-responsive text-center"">
        <form method="POST" action="backend/absensi.php">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIS</th> 
                        <th>Nama</th>
                        <th>TTL</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($r = $res->fetch_assoc()): ?>
                    <tr>
                        <td><input type="checkbox" name="selected_ids[]" value="<?= $r['username'] ?>"></td>
                        <td><?= $r['username'] ?></td>
                        <td><?= $r['nama'] ?></td>
                        <td><?= $r['tempatLahir'] . ', ' . $r['tglLahir'] ?></td>
                        <td><?= ($r['status'] ?? 'Belum diabsen') ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <label for="status">Status Kehadiran:</label>
            <select name="status" id="status" required>
                <option value="Hadir">Hadir</option>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
                <option value="Alpa">Alpa</option>
            </select>
            <button type="submit" class="btn btn-primary">Ubah</button>
        </form>
    </div>
</main>
<?php include 'includes/footer.php'; ?>