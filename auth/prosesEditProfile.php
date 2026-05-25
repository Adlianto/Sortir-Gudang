<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php?pesan=belum_login");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_user  = $_SESSION['id'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    

    $query_lama  = "SELECT foto_pengguna FROM users WHERE id = '$id_user'";
    $result_lama = mysqli_query($conn, $query_lama);
    $user_lama   = mysqli_fetch_assoc($result_lama);
    $foto_lama   = $user_lama['foto_pengguna'];


    $namaFoto   = $_FILES['foto']['name'];
    $tmpName    = $_FILES['foto']['tmp_name'];
    $errorFoto  = $_FILES['foto']['error'];

    if ($errorFoto === 0) {
        $ekstensiValid = ['jpg', 'jpeg', 'png'];
        $ekstensiFoto  = strtolower(pathinfo($namaFoto, PATHINFO_EXTENSION));

        if (in_array($ekstensiFoto, $ekstensiValid)) {

            $namaFotoBaru = time() . '_' . $username . '.' . $ekstensiFoto;
            
            if (move_uploaded_file($tmpName, '../upload/' . $namaFotoBaru)) {
                
                if (!empty($foto_lama) && file_exists('../upload/' . $foto_lama)) {
                    unlink('../upload/' . $foto_lama);
                }
                $query = "UPDATE users SET username = '$username', foto_pengguna = '$namaFotoBaru' WHERE id = '$id_user'";
                $_SESSION['foto'] = $namaFotoBaru; // Update session foto
            } else {
                echo "<script>alert('Gagal mengupload foto baru!'); window.location='../editProfile.php';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Format foto tidak valid! Gunakan JPG/PNG.'); window.location='../editProfile.php';</script>";
            exit;
        }
    } else {
        $query = "UPDATE users SET username = '$username' WHERE id = '$id_user'";
    }

    // Eksekusi query ke database
    if (mysqli_query($conn, $query)) {
        $_SESSION['username'] = $username;

        if ($_SESSION['role'] === 'admin') {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../user/dashboard.php");
        }
        exit;
    } else {
        echo "Gagal memperbarui profil: " . mysqli_error($conn);
    }
}
?>