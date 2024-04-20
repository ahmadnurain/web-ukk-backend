<?php
// Include file koneksi database

session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika tidak, redirect ke halaman login
    header("Location: login.php");
    exit;
}

// Ambil user_id dari session
$user_id = $_SESSION['user_id'];

// Query database untuk mengambil data foto berdasarkan user_id yang sedang login
$query = "SELECT * FROM foto WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);