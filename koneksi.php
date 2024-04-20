<?php
$conn = mysqli_connect("localhost", "root", "", "galeri_foto");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}