<?php

session_start();

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: user/dashboard.php");
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./asset/css/style.css">
</head>
<body>

    <div class="login-wrapper">
        
        <div class="login-header">
            <h2>Masuk Sekarang</h2>
        </div>

        <?php if (isset($_GET['pesan'])): ?>
            <div class="alert-box alert-danger">
                <?php 
                    if ($_GET['pesan'] == 'gagal') echo "Username atau Password salah!";
                    if ($_GET['pesan'] == 'belum_login') echo "Kamu harus login dulu!";
                    if ($_GET['pesan'] == 'terlarang') echo "Akses ditolak!";
                    if ($_GET['pesan'] == 'logout') echo "Kamu telah berhasil logout.";
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'sukses_register'): ?>
            <div class="alert-box alert-success">
                Registrasi berhasil! Silakan login.
            </div>
        <?php endif; ?>

        <form action="auth/prosesLogin.php" method="POST">
            
            <div class="form-group">
                <label>USERNAME</label>
                <input type="text" name="username" placeholder="username..." autocomplete="off" required>
            </div>

            <div class="form-group">
                <label>PASSWORD</label>
                <input type="password" name="password" placeholder="password..." required>
            </div>

            <button type="submit">Masuk</button>
        </form>

        <div class="login-footer">
            <span>Belum punya akun? <a href="register.php">Daftar Akun Baru</a></span>
        </div>

    </div>

</body>
</html>     