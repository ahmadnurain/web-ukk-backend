<?php
// KomentarController.php

function simpanKomentar($photo_id, $user_id, $comment_text, $comment_date) {
    global $conn;

    $sql = "INSERT INTO komentar_foto (foto_id, user_id, isi_komentar, tanggal_komentar) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        return "Error: " . $conn->error;
    } else {
        $stmt->bind_param("iiss", $photo_id, $user_id, $comment_text, $comment_date);

        if ($stmt->execute()) {
            $stmt->close(); // Tutup statement setelah eksekusi berhasil
            return true;
        } else {
            $stmt->close(); // Tutup statement jika eksekusi gagal
            return "Gagal menyimpan komentar: " . $stmt->error;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    include "../koneksi.php"; // Sertakan file koneksi

    // Ambil data dari form
    $photo_id = $_POST['foto_id'];
    $user_id = $_POST['user_id'];
    $comment_text = $_POST['isi_komentar'];
    $comment_date = date("Y-m-d H:i:s");

    // Simpan komentar ke database
    $result = simpanKomentar($photo_id, $user_id, $comment_text, $comment_date);

    // Beri respons berdasarkan hasil penyimpanan
    if ($result === true) {
        echo "<p>Komentar berhasil disimpan.</p>";
    } else {
        echo "<p>Gagal menyimpan komentar: " . $result . "</p>";
    }
}