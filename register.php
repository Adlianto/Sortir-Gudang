<?php
session_start();

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="asset/css/style.css">
</head>
<body>
    <div class="register-wrapper">
        <div class="register-header">
            <h2>Daftar Akun</h2>
        </div>

        <?php if (isset($_GET['error']) && $_GET['error'] == 'username_kembar'): ?>
            <div class="alert-box alert-danger">
                Username sudah digunakan
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error']) && $_GET['error'] == 'gagal_upload'): ?>
            <div class="alert-box alert-danger">
                Gagal mengupload foto profil mohon coba lagi
            </div>
        <?php endif; ?>

        <form action="auth/prosesRegister.php" method="POST" enctype="multipart/form-data">
            
            <div class="form-group">
                <label>Username Baru:</label>
                <input type="text" name="username" placeholder="username..." autocomplete="off" required>
            </div>
            
            <div class="form-group">
                <label>Password Baru:</label>
                <input type="password" name="password" placeholder="password..." required>
            </div>

            <div class="form-group">
                <label>Foto Profil (JPG/PNG, Max 2MB):</label>
                <input type="file" name="foto" accept="image/*" required style="cursor: pointer;">
            </div>

            <button type="submit">Daftar</button>
        </form>
    
        <div class="register-footer">
            Sudah punya akun? <a href="login.php">Login di sini</a>
        </div>

    </div>

</body>
</html>