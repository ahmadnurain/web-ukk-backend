<?php

// Proses like atau dislike saat tombol ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['foto_id'])) {
    // Ambil foto_id dari data yang dikirimkan melalui POST
    $foto_id = intval($_POST['foto_id']); // Validasi input sebagai integer
    $user_id = $_SESSION['user_id'];
    $tanggal = date('Y-m-d');

    // Cek apakah foto sudah di-like oleh pengguna yang login
    $cek_like_stmt = mysqli_prepare($conn, "SELECT * FROM `like_foto` WHERE foto_id = ? AND user_id = ?");
    mysqli_stmt_bind_param($cek_like_stmt, "ii", $foto_id, $user_id);
    mysqli_stmt_execute($cek_like_stmt);
    $result = mysqli_stmt_get_result($cek_like_stmt);

    if (mysqli_num_rows($result) == 0) {
        // Jika belum di-like, lakukan like
        $like_stmt = mysqli_prepare($conn, "INSERT INTO `like_foto` (foto_id, user_id, tanggal_like) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($like_stmt, "iis", $foto_id, $user_id, $tanggal);
        if (mysqli_stmt_execute($like_stmt)) {
            // Redirect kembali ke dashboard setelah melakukan like
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Gagal melakukan like.";
        }
    } else {
        // Jika sudah di-like, lakukan unlike (dislike)
        $dislike_stmt = mysqli_prepare($conn, "DELETE FROM `like_foto` WHERE foto_id = ? AND user_id = ?");
        mysqli_stmt_bind_param($dislike_stmt, "ii", $foto_id, $user_id);
        if (mysqli_stmt_execute($dislike_stmt)) {
            // Redirect kembali ke dashboard setelah melakukan dislike
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Gagal melakukan dislike.";
        }
    }
} 