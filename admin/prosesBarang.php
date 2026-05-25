<?php

session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php?pesan=terlarang");
    exit;
}

include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['aksi'] == 'tambah') {
    $nama_perangkat = mysqli_real_escape_string($conn, $_POST['nama_perangkat']);
    $merek          = mysqli_real_escape_string($conn, $_POST['merek']);
    $harga          = (int)$_POST['harga'];
    $stok           = (int)$_POST['stok'];
    $id_jenis       = (int)$_POST['id_jenis'];

    $query = "INSERT INTO perangkat (nama_perangkat, merek, harga, stok, id_jenis) 
              VALUES ('$nama_perangkat', '$merek', '$harga', '$stok', $id_jenis)";
    
    if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php?status=tambah_sukses");
        exit;
    } else {
        echo "Gagal menambah barang: " . mysqli_error($conn);
    }
}

if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $id = (int)$_GET['id'];

    $query = "DELETE FROM perangkat WHERE id_perangkat = $id";
    
    if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php?status=hapus_sukses");
        exit;
    } else {
        echo "Gagal menghapus barang: " . mysqli_error($conn);
    }
}