<?php
session_start();
include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
    $namaFoto   = $_FILES['foto']['name'];
    $tmpName    = $_FILES['foto']['tmp_name'];
    $errorFoto  = $_FILES['foto']['error'];

    if ($errorFoto === 0) {
        $ekstensiValid = ['jpg', 'jpeg', 'png'];
        $ekstensiFoto  = explode('.', $namaFoto);
        $ekstensiFoto  = strtolower(end($ekstensiFoto));

        if (in_array($ekstensiFoto, $ekstensiValid)) {
            $namaFotoBaru = time() . '_' . $username . '.' . $ekstensiFoto;
            
            if (move_uploaded_file($tmpName, '../upload/' . $namaFotoBaru)) {
                $query = "INSERT INTO users (username, password, foto_pengguna, role) 
                          VALUES ('$username', '$password', '$namaFotoBaru', 'user')";
                
                if (mysqli_query($conn, $query)) {
                    header("Location: ../login.php?status=sukses_register");
                    exit;
                } else {
                    echo "Gagal input ke database: " . mysqli_error($conn);
                    exit;
                }
            }
        }
    }
    header("Location: ../register.php?error=gagal_upload");
}
?>