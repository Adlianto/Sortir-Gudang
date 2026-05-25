<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php?pesan=belum_login");
    exit;
}
include 'config/koneksi.php';
$id_user = $_SESSION['id'];
$query = "SELECT * FROM users WHERE id = '$id_user'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="mb-3">
                <a href="<?= $_SESSION['role'] === 'admin' ? 'admin/dashboard.php' : 'user/dashboard.php'; ?>" class="text-decoration-none fw-bold" style="color: #A3AED0;">◄ Kembali</a>
            </div>
            <div class="card p-4 p-md-5">
                <h4 class="fw-bold text-center text-dark mb-4">Edit Profil</h4>
                <form action="auth/prosesEditProfile.php" method="POST" enctype="multipart/form-data">
                    <div class="text-center mb-4">
                        <?php if(!empty($user['foto_pengguna'])): ?>
                            <img src="upload/<?= htmlspecialchars($user['foto_pengguna']); ?>" class="avatar-old" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #1a1a1a;">
                        <?php else: ?>
                            <div class="avatar-old bg-secondary d-flex align-items-center justify-content-center text-white h1 mx-auto" style="width: 100px; height: 100px; border-radius: 50%;"><?= strtoupper(substr($user['username'], 0, 1)); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small">USERNAME</label>
                        <input type="text" name="username" class="form-control bg-light border-0" value="<?= htmlspecialchars($user['username']); ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary small">GANTI FOTO PROFIL</label>
                        <input type="file" name="foto" class="form-control bg-light border-0" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>