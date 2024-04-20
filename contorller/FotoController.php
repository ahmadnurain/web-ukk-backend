<?php
include "koneksi.php";

// Pastikan koneksi berhasil dibuat
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Query untuk mengambil foto dari tabel foto
$query = "SELECT * FROM foto";
$stmt = mysqli_prepare($conn, $query);

// Periksa apakah query berhasil dieksekusi
if ($stmt) {
    // Eksekusi query
    mysqli_stmt_execute($stmt);

    // Ambil hasil query
    $result = mysqli_stmt_get_result($stmt);

    // Buat array untuk menyimpan hasil query
    $fotos = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $fotos[] = $row;
    }

    // Bebaskan hasil query
    mysqli_free_result($result);

    // Tutup statement
    mysqli_stmt_close($stmt);
} else {
    // Tangani kesalahan jika query gagal dieksekusi
    echo "Error: " . mysqli_error($conn);
}