<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Your Account</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="login-container">
        <h2>Login to Your Account</h2>
        <?php
        if (isset($_GET['pesan'])) {
            if ($_GET['pesan'] == "gagal") {
                echo "<script>alert('Login gagal! Username dan password salah!')</script>";
            } else if ($_GET['pesan'] == "logout") {
                echo "<p class='success'>Anda telah berhasil logout</p>";
            } else if ($_GET['pesan'] == "belum_login") {
                echo "<p class='error'>Anda harus login untuk mengakses halaman admin</p>";
            }
        }
        ?>
        <form method="POST" action="cek_login.php">
            <div class="input-group">
                <label for="username">Username</label>
                <div class="input-field">
                    <span class="icon">@</span>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <div class="input-field">
                    <span class="icon">🔐</span>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
            </div>
            <button type="submit" class="login-btn">Login</button>
    </div>
</body>
</html>