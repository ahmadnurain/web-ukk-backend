<?php
$error_message = "";

// Fungsi untuk menghapus postingan dan file foto
function deletePost($post_id, &$error_message) {
    global $conn;

    // Ambil lokasi file foto sebelum dihapus
    $query_select = "SELECT lokasi_file FROM foto WHERE foto_id='$post_id'";
    $result_select = mysqli_query($conn, $query_select);
    if ($result_select && mysqli_num_rows($result_select) > 0) {
        $row = mysqli_fetch_assoc($result_select);
        $lokasi_file = $row['lokasi_file'];
        // Hapus file foto dari server
        if (unlink("uploads/".$lokasi_file)) {
            // Hapus data postingan dari database
            $query_delete = "DELETE FROM foto WHERE foto_id='$post_id'";
            $result_delete = mysqli_query($conn, $query_delete);
            if ($result_delete) {
                $error_message =  "Postingan dan file foto berhasil dihapus.";
                header("Location: post.php");
            } else {
                $error_message =  "Gagal menghapus postingan: " . mysqli_error($conn);
            }
        } else {
            $error_message =  "Gagal menghapus file foto.";
        }
    } else {
        $error_message =  "Gagal menghapus postingan: Data tidak ditemukan.";
    }
    return $error_message;
}

// Periksa apakah tombol delete diklik
if (isset($_POST['delete'])) {
    $post_id = $_POST['post_id'];
    // Lakukan proses delete postingan
    deletePost($post_id, $error_message);
}