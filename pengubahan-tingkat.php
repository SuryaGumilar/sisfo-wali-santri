<?php

$title = "Pengubahan Tingkat";
require 'includes/header.php';
require 'backend/functions.php';
checkRole(['admin']);

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Ambil data
$total = $conn->query("SELECT COUNT(*) AS total FROM wali")->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);

$filter = $_GET['filter'] ?? 'I';
$sql = "SELECT * FROM wali WHERE 1";
if ($filter) $sql .= " AND tingkat = '$filter'";
$result = $conn->query($sql);

// Ambil data unik untuk dropdown filter
$tingkatOptions = $conn->query("SELECT DISTINCT tingkat FROM wali");

$jmlSantri = $conn->query("SELECT COUNT(*) AS jmlSantri FROM wali WHERE tingkat = '$filter'")->fetch_assoc()['jmlSantri'];

?>

<div class="container mt-4">
    <h4>Pengubahan Tingkat</h4>
    <p>Jumlah Santri: <?= $jmlSantri ?></p>

    <form method="GET" class="mb-4">
        <div class="mb-3">
            <label for="kelasDropdown" class="form-label">Tingkat saat ini:</label>
            <select name="filter" id="kelasDropdown" class="form-select">
                <?php while ($row = $tingkatOptions->fetch_assoc()): ?>
                    <option value="<?= $row['tingkat'] ?>" <?= $row['tingkat'] == $filter ? 'selected' : '' ?>>
                        <?= $row['tingkat'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary mt-2 btn-sm">Filter</button>
            </div>
        </div>
    </form>
    <div class="table-responsive"">
        <form id="ubahForm" method="POST" action="backend/update-tingkat.php" class="mb-4">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>TTL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><input type="checkbox" name="selected_ids[]" value="<?= $row['username'] ?>"></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['tempatLahir'] . ', ' . $row['tglLahir'] ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="mb-3">
                <label for="ubahTingkat" class="form-label">Ubah tingkat menjadi: </label>
                <select name="tingkat" id="ubahTingkat" class="form-select" require>
                    <option value="I">I</option>
                    <option value="II">II</option>
                    <option value="III">III</option>
                </select>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary mt-2 btn-sm">Ubah</button>
                </div>
            </div>
        </form>
    </div>
    <nav aria-label="Wali santri table">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($i === $page) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
<script>
    // Select All Checkbox
    document.getElementById('selectAll').addEventListener('change', function () {
        document.querySelectorAll('input[name="selected_ids[]"]').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // // Single Delete Confirmation
    // document.querySelectorAll('.delete-single').forEach(button => {
    //     button.addEventListener('click', function () {
    //         if (confirm('Apakah Anda yakin ingin menghapus?')) {
    //             window.location.href = `delete-wali-santri.php?id=${this.dataset.id}`;
    //         }
    //     });
    // });
</script>
<?php include 'includes/footer.php'; ?>