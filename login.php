<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Informasi Wali Santri</title>
    <link rel="icon" href="images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <div class="common-box">
            <img src="images/logo.png" alt="Logo Aplikasi" class="logo">
            <!-- <h2>Login</h2> -->
            <hr>
            <form method="post" action="backend/login-logic.php">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" required>
                        <button type="button" id="togglePassword">🙈</button>
                    </div>
                </div>
                <?php
                    session_start();
                    // Tampilkan pesan dari session jika ada
                    if (isset($_SESSION['error'])) {
                        echo '<p style="color: red;">' . htmlspecialchars($_SESSION['error']) . '</p><br>';
                        unset($_SESSION['error']); // Hapus pesan setelah ditampilkan
                    }
                ?>
                <button type="submit" class="blue-button">Login</button>
            </form>
        </div>
    </div>
    

    <script>
        // JavaScript untuk toggle show/hide password
        const passwordField = document.getElementById("password");
        const togglePassword = document.getElementById("togglePassword");

        togglePassword.addEventListener("click", function () {
            if (passwordField.type === "password") {
                passwordField.type = "text";
                togglePassword.textContent = "👁️"; // Mengubah ikon ketika password terlihat
            } else {
                passwordField.type = "password";
                togglePassword.textContent = "🙈";
            }
        });
    </script>
</body>
</html>