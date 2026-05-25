<?php

session_start();

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: user/dashboard.php");
    }
    exit;
} else {
    header("Location: login.php");
    exit;
}