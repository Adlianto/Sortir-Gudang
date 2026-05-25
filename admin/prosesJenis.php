<?php

session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php?pesan=terlarang");
    exit;
}

include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nama_jenis'])) {
    $nama_jenis = mysqli_real_escape_string($conn, $_POST['nama_jenis']);
    $query = "INSERT INTO jenis_perangkat (nama_jenis) VALUES ('$nama_jenis')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php?status=tambah_jenis_sukses");
        exit;
    } else {
        echo "Gagal menambah kategori: " . mysqli_error($conn);
    }
}

if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $id_jenis = (int)$_GET['id'];
    $query = "DELETE FROM jenis_perangkat WHERE id_jenis = $id_jenis";
    
    if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php?status=hapus_jenis_sukses");
        exit;
    } else {
        echo "Gagal menghapus kategori: " . mysqli_error($conn);
    }
}