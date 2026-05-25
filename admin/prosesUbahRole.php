<?php

session_start();

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php?pesan=terlarang");
    exit;
}

include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_user   = (int)$_POST['id_user'];
    $role_baru = mysqli_real_escape_string($conn, $_POST['role_baru']);
    
    $query = "UPDATE users SET role = '$role_baru' WHERE id = $id_user";
    
    if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php?status=ubah_role_sukses");
        exit;
    } else {
        echo "Gagal mengubah role karyawan: " . mysqli_error($conn);
    }
}