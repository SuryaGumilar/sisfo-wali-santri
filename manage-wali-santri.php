<?php

$title = "Kelola Wali Santri";
require 'includes/header.php';
require 'backend/functions.php';

checkRole(['admin']);

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Ambil data
// $result = $conn->query("SELECT * FROM wali ORDER BY username DESC LIMIT $limit OFFSET $offset");
$total = $conn->query("SELECT COUNT(*) AS total FROM wali")->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);

// Proses filtering dan pencarian
$search = $_GET['search'] ?? '';
$filter = $_GET['filter'] ?? '';
$sql = "SELECT * FROM wali WHERE 1";
if ($filter) $sql .= " AND tingkat = '$filter'";
if ($search) $sql .= " AND (username LIKE '%$search%' OR nama LIKE '%$search%')";
$search_result = $conn->query($sql);

// Ambil data unik untuk dropdown filter
$tingkatOptions = $conn->query("SELECT DISTINCT tingkat FROM wali");

?>

<main>
    <div class="container-sm">
        <h4 class="text-center m-5">Kelola Data Wali Santri</h4>
        <div class="container mt-5">
            <!-- Pencarian dan Filtering -->
            <form method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Cari..." value="<?= htmlspecialchars($search) ?>">
                    </div>
                    <div class="col-md-4">
                        <select name="filter" class="form-select">
                            <option value="">Semua Tingkat</option>
                            <?php while ($row = $tingkatOptions->fetch_assoc()): ?>
                                <option value="<?= $row['tingkat'] ?>" <?= $row['tingkat'] == $filter ? 'selected' : '' ?>>
                                    <?= $row['tingkat'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
        <div class="table-responsive text-center"">
            <form id="deleteForm" method="POST" action="backend/delete-wali-santri.php">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Tingkat</th>
                            <th>TTL</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $search_result->fetch_assoc()): ?>
                        <tr>
                            <td><input type="checkbox" name="selected_ids[]" value="<?= $row['username'] ?>"></td>
                            <td><?= $row['username'] ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['tingkat'] ?></td>
                            <td><?= $row['tempatLahir'] . ', ' . $row['tglLahir'] ?></td>
                            <td>
                                <button class="btn btn-danger" onclick="confirmDelete(<?= $row['username'] ?>)">Hapus</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <button type="submit" class="btn btn-danger">Hapus Terpilih</button>
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

        <div class="common-box">
            <h4 class="text-center">Tambah Wali Santri</h4>
            <p>Pilih file Excel yang ingin diunggah untuk menambahkan wali santri.</p>
            <form action="backend/add-wali-santri.php" method="POST" enctype="multipart/form-data">
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

        <script>
            function confirmDelete(id) {
                if (confirm("Yakin ingin menghapus data ini?")) {
                    window.location.href = `backend/delete-wali-santri.php?username=${id}`;
                }
            }

            // Select All Checkbox
            document.getElementById('selectAll').addEventListener('change', function () {
                document.querySelectorAll('input[name="selected_ids[]"]').forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Single Delete Confirmation
            document.querySelectorAll('.delete-single').forEach(button => {
                button.addEventListener('click', function () {
                    if (confirm('Apakah Anda yakin ingin menghapus?')) {
                        window.location.href = `delete-wali-santri.php?id=${this.dataset.id}`;
                    }
                });
            });
        </script>
</main>
<?php include 'includes/footer.php'; ?>