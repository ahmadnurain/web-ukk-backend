<?php 
session_start();
// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    // Jika tidak, redirect ke halaman login
    header("Location: login.php");
    exit;
}


// Logout jika tombol logout diklik
if (isset($_POST['logout'])) {
    // Hapus sesi
    session_destroy();
    // Redirect ke halaman login
    header("Location: login.php");
    exit;
}
// $userId = $_SESSION['user_id'];