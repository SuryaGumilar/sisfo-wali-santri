<?php

$title = "Kelola Capaian";
require 'includes/header.php';
require 'backend/functions.php';
include 'includes/indo-date.php';

checkRole(['pengurus']);

// Ambil data unik untuk dropdown filter
$tingkatOptions = $conn->query("SELECT DISTINCT tingkat FROM wali");

$result = $conn->query("SELECT tingkat FROM wali WHERE pengurus='{$_SESSION['username']}' LIMIT 1");
$row = $result->fetch_assoc();
$tingkatSaatIni = strval($row['tingkat']); // Konversi ke string

// Ambil data
$data_wali = $conn->query("
    SELECT w.username, w.nama, w.tempatLahir, w.tglLahir,
           c.nama_surat, c.ayat, c.juz, c.halaman, c.tanggal
    FROM wali w
    LEFT JOIN capaian c ON w.username = c.username WHERE tingkat = '$tingkatSaatIni'
");

$jmlSantri = $conn->query("SELECT COUNT(*) AS jmlSantri FROM wali WHERE tingkat = '$tingkatSaatIni'")->fetch_assoc()['jmlSantri'];

$capaian = $conn->query("SELECT CONCAT(nama_surat, ':', ayat, ', Juz ', juz, ', Halaman ', halaman) AS keterangan FROM capaian");

?>

<main class="container-sm pt-5">
    <p><b>Santri Tingkat <?= $tingkatSaatIni ?></b></p>
    <p><b>Capaian Hari Ini (<?php echo "$hari, " . date('d') . " $bulan " . date('Y');?>)</b></p>
    <p>Jumlah Santri: <?= $jmlSantri ?></p>
    <div class="d-flex justify-content-start mb-3">
        <button class="btn btn-primary" 
                data-bs-toggle="modal" 
                data-bs-target="#ubahCapaianModal" 
                data-username="" 
                data-nama_surat="" 
                data-ayat="" 
                data-juz="" 
                data-halaman="">
            Ubah Capaian Hari Ini
        </button>
    </div>
    <div class="table-responsive text-center"">
        <!-- <form action="riwayat-capaian.php" method="post"> -->
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>TTL</th>
                        <th>Capaian Hari Ini</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $data_wali->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['tempatLahir'] . ', ' . $row['tglLahir'] ?></td>
                        <td><?= $row['tanggal'] == date('Y-m-d') ? $row['nama_surat'] . ':' . $row['ayat'] . ' Juz ' . $row['juz'] . ', Halaman ' . $row['halaman'] : 'Belum ada capaian' ?></td>  
                        <td>
                            <button onclick="lihatRiwayat(<?= $row['username'] ?>)" name="username" value="<?= $row['username'] ?>" class="btn btn-primary">Riwayat Capaian</button>
                            
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <!-- </form> -->
    </div>
    <!-- Modal -->
    <div class="modal fade" id="ubahCapaianModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Capaian Santri Hari Ini</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" action="backend/add-capaian.php">
            <div class="modal-body">
                <div class="container mt-5">
                    <div class="mb-3">
                        <label for="username" class="form-label">Pilih NIS</label>
                        <select name="username" id="username" class="form-select" required>
                            <?php
                                $users = $conn->query("SELECT username FROM wali WHERE tingkat = '$tingkatSaatIni'");
                                while ($user = $users->fetch_assoc()) {
                                    echo "<option value='{$user['username']}'>{$user['username']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_surat" class="form-label">Nama Surat</label>
                        <input type="text" name="nama_surat" id="nama_surat" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="ayat" class="form-label">Ayat</label>
                        <input type="number" name="ayat" id="ayat" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="juz" class="form-label">Juz</label>
                        <input type="number" name="juz" id="juz" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="halaman" class="form-label">Halaman</label>
                        <input type="number" name="halaman" id="halaman" class="form-control" required>
                    </div>
                    <input type="hidden" name="tanggal" value="<?= date('Y-m-d') ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
        </div>
    </div>
    </div>
    <script>
        function lihatRiwayat(username) {
            window.location.href = `riwayat-capaian.php?username=${username}`;
            
        }
    </script>
</main>
<?php include 'includes/footer.php'; ?>