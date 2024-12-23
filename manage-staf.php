<?php

$title = "Kelola Data Staf";
require 'includes/header.php';
require 'backend/functions.php';

checkRole(['admin']);

$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Ambil data
$result = $conn->query("SELECT * FROM users WHERE role != 'wali' ORDER BY username DESC LIMIT $limit OFFSET $offset");
$total = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role != 'wali'")->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);

?>
<main>
<div class="container-sm">
<h4 class="text-center m-5">Kelola Data Staf</h4>
<?php if (isset($_GET['message'])): ?>
    <div style="color: <?= strpos($_GET['message'], 'berhasil') !== false ? 'green' : 'red'; ?>; text-align: center; margin-bottom: 20px;">
        <?= htmlspecialchars($_GET['message']); ?>
    </div>
<?php endif; ?>
<div class="table-responsive text-center"">
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Username</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['username'] ?></td>
                <td><?= $row['role'] ?></td>
                <td>
                    <button class="btn btn-danger" onclick="confirmDelete(<?= $row['username'] ?>, <?= $row['role'] ?>)">Hapus</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<nav aria-label="Data staf page">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php if ($i === $page) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>


<div class="common-box">
    <h4 class="text-center">Tambah Staf</h4>
    <form action="backend/add-staf.php" method="POST" enctype="multipart/form-data">
        <label>Username:</label>
        <input type="text" name="username" required>
        
        <label>Password:</label>
        <input type="password" name="password" required>
        
        <label>Role:</label>
        <select name="role" id="roleSelector" required>
            <option value="admin">Admin</option>
            <option value="pengurus">Pengurus</option>
            <option value="bendahara">Bendahara</option>
        </select>
        <button type="submit" class="blue-button">Tambah</button>
    </form>
</div>

<script>
    function confirmDelete(username, role) {
            if (confirm("Yakin ingin menghapus data ini?")) {
                window.location.href = `backend/delete-staf.php?username=${username}&role=${role}`;
            }
        }
</script>

</div>
</main>
<?php include 'includes/footer.php'; ?>