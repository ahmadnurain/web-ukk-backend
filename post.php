<?php
include "koneksi.php";
include "contorller/PostController.php";
include "contorller/EditpostinganController.php";
include "contorller/DeleteController.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postingan Saya</title>
</head>

<body>

    <h1>Postingan Saya</h1>
    <!-- Tambahkan pesan sukses di sini -->
    <?php if (isset($success_message)) : ?>
    <div class="success-message">
        <?php echo $success_message; ?>
    </div>
    <?php endif; ?>

    <?php
    // Periksa apakah ada foto yang diunggah oleh pengguna yang sedang login
    if ($result && mysqli_num_rows($result) > 0) {
        // Tampilkan foto-foto tersebut
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div>";
            echo "<h3>".$row['judul_foto']."</h3>";
            echo "<img src='uploads/".$row['lokasi_file']."' alt='Foto'>";
            echo "<p>".$row['deskripsi_foto']."</p>";
            echo "<p>Tanggal Unggah: ".$row['tanggal_unggah']."</p>";

            // Form edit
            echo "<form action='' method='post' enctype='multipart/form-data'>";
            echo "<input type='hidden' name='post_id' value='".$row['foto_id']."'>"; // Menggunakan $row['id'] bukan $row['foto_id']
            echo "<input type='text' name='judul_foto' value='".$row['judul_foto']."'>";
            echo "<textarea name='deskripsi_foto'>".$row['deskripsi_foto']."</textarea>";
            echo "<input type='file' name='fileToUpload' id='fileToUpload'> "; // Tambahkan input file
            echo "<button type='submit' name='edit'>Edit</button>";
            echo "</form>";

            // Tombol delete
            echo "<form action='' method='post'>";
            echo "<input type='hidden' name='post_id' value='".$row['foto_id']."'>"; // Menggunakan $row['id'] bukan $row['foto_id']
            echo "<button type='submit' name='delete'>Delete</button>";
            echo "</form>";

            echo "</div>";
        }
    } else {
        echo "Belum ada postingan.";
    }
    ?>

</body>

</html>