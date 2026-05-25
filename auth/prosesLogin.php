<?php

session_start();
include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query  = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['login']    = true;
            $_SESSION['id']       = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role']     = $row['role'];
            $_SESSION['foto']     = $row['foto_pengguna'];
            
            if ($row['role'] == 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../user/dashboard.php");
            }
            exit;
        }
    }
    header("Location: ../login.php?pesan=gagal");
}