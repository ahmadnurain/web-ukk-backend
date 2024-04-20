<?php
// Include file koneksi database
include "../koneksi.php";
$error_message = "";
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika tidak, redirect ke halaman login
    header("Location: login.php");
    exit;
}

// Folder tempat menyimpan foto
$folder_foto = "uploads"; // Lokasi folder menyimpan foto

// Periksa apakah tombol submit diklik
if (isset($_POST["submit"])) {
    $judul_foto = $_POST["judul_foto"];
    $deskripsi_foto = $_POST["deskripsi_foto"];
    $tanggal_unggah = date("Y-m-d"); // Ambil tanggal saat ini
    $nama_file = basename($_FILES["fileToUpload"]["name"]);
    $lokasi_file =$nama_file; // Ubah lokasi file

    $user_id = $_SESSION['user_id']; // Ambil user_id dari session

    // Periksa apakah file gambar asli atau palsu
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        // Periksa apakah file sudah ada
        if (file_exists('../uploads/'.$lokasi_file)) {
            $error_message =  "Maaf, file sudah ada.";
        } else {
            // Jika semua kondisi terpenuhi, coba upload file
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], '../uploads/'.$lokasi_file)) {
                // Simpan informasi foto ke dalam database
                $query = "INSERT INTO foto (judul_foto, deskripsi_foto, tanggal_unggah, lokasi_file, user_id) 
                          VALUES ('$judul_foto', '$deskripsi_foto', '$tanggal_unggah', '$lokasi_file', '$user_id')";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    $error_message = "File $nama_file berhasil diunggah.";
                } else {
                    $error_message =  "Maaf, terjadi kesalahan saat menyimpan informasi ke database.";
                }
            } else {
                $error_message =  "Maaf, terjadi kesalahan saat mengunggah file.";
            }
        }
    } else {
        $error_message =  "File bukan gambar.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Foto</title>
</head>

<body>
    <h1>Upload Foto</h1>
    <?php if (isset($error_message)) : ?>
    <div class="error-message">
        <?php echo $error_message; ?>
    </div>
    <?php endif; ?>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <label for="judul_foto">Judul Foto:</label><br>
        <input type="text" name="judul_foto"><br>
        <label for="deskripsi_foto">Deskripsi Foto:</label><br>
        <textarea name="deskripsi_foto"></textarea><br>
        <input type="file" name="fileToUpload" id="fileToUpload"><br>
        <button type="submit" name="submit">Upload</button>
    </form>
</body>

</html>