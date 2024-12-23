<?php

$title = "Dashboard Admin";
require 'includes/header.php';
require 'backend/functions.php';

checkRole(['admin']);

// Pagination
$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Ambil data
$result = $conn->query("SELECT * FROM tahun_akademik ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
$total = $conn->query("SELECT COUNT(*) AS total FROM tahun_akademik")->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);

?>
<main>
<div class="container-md">
    <h2 class="greet">Selamat datang <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
    <h4 class="text-center">Manajemen Tahun Akademik</h4>
    <form action="backend/add-tahun-akademik.php" method="POST">
        <label for="tahun">Tambahkan tahun akademik: </label>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="" aria-label="Masukkan tahun" aria-describedby="button-addon2" id="tahun" name="tahun" required>
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Tambah</button>
        </div>
    </form>
    <div class="table-responsive text-center"">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Tahun Akademik</th>
                <th>Status</th>
                <th>Tindakan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['tahun'] ?></td>
                <td><button title="Klik untuk mengubah status"
                    class="<?= $row['status'] ? 'btn btn-outline-success' : 'btn btn-primary' ?>" 
                    <?= $row['status'] ? 'disabled' : '' ?>
                    onclick="updateStatus(<?= $row['idTahun'] ?>)">
                    <?= $row['status'] ? 'Sedang Aktif' : 'Nonaktif' ?>
                </button></td>
                <td>
                    <?php if ($row['status']): ?>
                        <button class="btn btn-primary" onclick="window.location.href='pengubahan-tingkat.php?id=<?= $row['idTahun'] ?>'">Pengubahan Tingkat</button>
                        <button class="btn btn-primary" onclick="window.location.href='atur-pengurus.php?id=<?= $row['idTahun'] ?>'">Atur Pengurus</button>
                    <?php else: ?>
                        ---
                    <?php endif; ?>
                </td>
                <td>
                    <button class="btn btn-danger" onclick="confirmDelete(<?= $row['idTahun'] ?>)">Hapus</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
    <nav aria-label="Tahun akademik page">
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
    // Fungsi untuk memperbarui status tombol
    function updateStatus(idTahun) {
        fetch('backend/update-status-tahun.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ idTahun: idTahun })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload halaman untuk merefleksikan perubahan
                window.location.reload();
            } else {
                alert('Gagal memperbarui status.');
            }
        });
    }

    function confirmDelete(id) {
        if (confirm("Yakin ingin menghapus data ini?")) {
            window.location.href = `backend/delete-tahun-akademik.php?idTahun=${id}`;
        }
    }

</script>
</main>
<?php include 'includes/footer.php'; ?>