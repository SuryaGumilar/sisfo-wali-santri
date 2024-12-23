<?php

$title = "Atur Pengurus";
require 'includes/header.php';
require 'backend/functions.php';
checkRole(['admin']);

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Ambil data
$total = $conn->query("SELECT COUNT(*) AS total FROM wali")->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);

// Fetch tingkat yang ada di tabel wali
$tingkatResult = $conn->query("SELECT DISTINCT tingkat FROM wali
                                ORDER BY CASE 
                                        WHEN tingkat = 'I' THEN 1
                                        WHEN tingkat = 'II' THEN 2
                                        WHEN tingkat = 'III' THEN 3
                                    END;");
$tingkatOptions = [];
while ($row = $tingkatResult->fetch_assoc()) {
    $tingkatOptions[] = $row['tingkat'];
}

// Pengurus yang sudah terdaftar, disusun berdasarkan tingkat
$pengurusTerdaftar = [];
foreach ($tingkatOptions as $tingkat) {
    $query = $conn->prepare("SELECT pengurus FROM wali WHERE tingkat = ?");
    $query->bind_param("s", $tingkat); // Asumsikan tingkat bertipe string
    $query->execute();
    $resultTerdaftar = $query->get_result();
    
    // Ambil pengurus untuk tingkat tertentu
    if ($row = $resultTerdaftar->fetch_assoc()) {
        $pengurusTerdaftar[$tingkat] = $row['pengurus'];
    }
}

// Fetch pengurus dari tabel users
$pengurusResult = $conn->query("SELECT username FROM users WHERE role = 'pengurus'");
$pengurusOptions = [];
while ($row = $pengurusResult->fetch_assoc()) {
    $pengurusOptions[] = $row;
}

?>
<div class="container mt-4">
    <h4>Atur Pengurus</h4>
    <div class="table-responsive text-center">
        <form id="ubahForm" method="POST" action="backend/update-tingkat.php" class="mb-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Daftar Tingkat</th>
                        <th>Pengurus</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($tingkatOptions as $tingkat): ?>
                    <tr>
                        <td><?= $tingkat ?></td>
                        <td>
                            <?= isset($pengurusTerdaftar[$tingkat]) && $resultTerdaftar->num_rows > 0 
                                ? $pengurusTerdaftar[$tingkat] 
                                : 'Belum ada pengurus' ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    </div>
    <nav aria-label="Pengurus table">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($i === $page) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <div class="container mt-4">
        <form method="POST" action="backend/update-pengurus.php">
            <div class="mb-3">
                <label for="tingkat" class="form-label">Kelola Tingkat</label>
                <select name="tingkat" id="tingkat" class="form-select" required>
                    <option value="" disabled selected>Pilih tingkat</option>
                    <?php foreach ($tingkatOptions as $tingkat): ?>
                        <option value="<?= $tingkat ?>"><?= $tingkat ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="pengurus" class="form-label">Oleh Pengurus:</label>
                <select name="pengurus" id="pengurus" class="form-select" required>
                    <option value="" disabled selected>Pilih pengurus</option>
                    <?php foreach ($pengurusOptions as $pengurus): ?>
                        <option value="<?= $pengurus['username'] ?>"><?= $pengurus['username'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="tetapkan" class="btn btn-primary">Tetapkan</button>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>