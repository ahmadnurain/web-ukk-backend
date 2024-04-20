<?php
$error_message = "";
$success_message = "";

// Fungsi untuk menghapus foto
function deletePhoto($file_path) {
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

// Fungsi untuk mengedit postingan
function editPost($post_id, $judul_foto, $deskripsi_foto, $lokasi_file) {
    global $conn, $error_message, $success_message;

    // Ambil lokasi file foto lama sebelum diubah
    $query_select = "SELECT lokasi_file FROM foto WHERE foto_id='$post_id'";
    $result_select = mysqli_query($conn, $query_select);
    if ($result_select && mysqli_num_rows($result_select) > 0) {
        $row = mysqli_fetch_assoc($result_select);
        $old_file = 'uploads/'. $row['lokasi_file'];
        
        // Hapus foto lama hanya jika ada file baru yang diunggah
        if (!empty($lokasi_file)) {
            deletePhoto($old_file);
        }
    }

    // Update postingan dengan informasi baru
    $query = "UPDATE foto SET judul_foto='$judul_foto', deskripsi_foto='$deskripsi_foto'";
    
    // Jika lokasi_file tidak kosong, tambahkan ke dalam query
    if (!empty($lokasi_file)) {
        $query .= ", lokasi_file='$lokasi_file'";
    }
    
    $query .= " WHERE foto_id='$post_id'";
    
    $result = mysqli_query($conn, $query);
    if ($result) {
        // Set pesan sukses sebelum redirect
        $success_message = "Postingan berhasil diupdate.";
        // Redirect ke halaman yang sama setelah proses edit selesai
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        $error_message =  "Gagal mengupdate postingan: " . mysqli_error($conn);
    }
}

// Periksa apakah tombol edit diklik
if (isset($_POST['edit'])) {
    $post_id = $_POST['post_id'];
    $judul_foto = $_POST['judul_foto'];
    $deskripsi_foto = $_POST['deskripsi_foto'];
    $nama_file = basename($_FILES["fileToUpload"]["name"]);
    
    // Cek apakah pengguna mengunggah file
    if (!empty($nama_file)) {
        $lokasi_file = $nama_file; // Sesuaikan path
    
        // Periksa apakah file gambar asli atau palsu
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            // Jika semua kondisi terpenuhi, coba upload file
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],'uploads/'.$lokasi_file)) {
                // Lakukan proses edit postingan
                editPost($post_id, $judul_foto, $deskripsi_foto, $nama_file); // Ubah parameter
            } else {
                $error_message =  "Maaf, terjadi kesalahan saat mengunggah file.";
            }
        } else {
            $error_message =  "File bukan gambar.";
        }
    } else {
        // Jika tidak ada file yang diunggah, edit hanya judul dan deskripsi
        editPost($post_id, $judul_foto, $deskripsi_foto, ''); // Tidak ada file yang diunggah
    }
}