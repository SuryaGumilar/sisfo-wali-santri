<?php
include 'includes/auth.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Default Title'; ?></title>
    <link rel="icon" href="images/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="navbar">
        <div class="navbar-left">
            <a href="dashboard-<?php echo urlencode($_SESSION['role']); ?>.php"><img src="images/logo.png" class="goToDashboard"></a>
        </div>
        <div class="navbar-right">
            <div class="dropdown">
                <button class="dropdown-button" id="dropdownButton">
                    <img src="images/profile.png" alt="Ikon Profil" class="navbar-icon">
                </button>
                <div class="dropdown-menu" id="dropdownMenu"">
                    <a href="profile.php">Profil</a>
                    <?php
                        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                            echo '<a href="manage-staf.php">Kelola Data Staf</a>';
                            echo '<a href="manage-wali-santri.php">Kelola Data Wali Santri</a>';
                    }
                    ?>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </header>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const dropdownButton = document.getElementById("dropdownButton");
        const dropdownMenu = document.getElementById("dropdownMenu");

        dropdownButton.addEventListener("click", () => {
            const isVisible = dropdownMenu.style.display === "block";
            dropdownMenu.style.display = isVisible ? "none" : "block";
        });

        // Optional: Close the menu if clicked outside
        document.addEventListener("click", (event) => {
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.style.display = "none";
            }
        });
        });
    </script>