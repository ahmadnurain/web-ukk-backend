<?php
include "koneksi.php";

// Periksa apakah form untuk mengirim komentar telah disubmit
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $photo_id = $_POST['foto_id'];
    $user_id = $_POST['user_id'];
    $comment_text = $_POST['isi_komentar'];
    $comment_date = date("Y-m-d H:i:s"); // Ambil tanggal dan waktu saat ini

    // Periksa apakah koneksi ke database berhasil
    if (!$conn) {
        die("Koneksi ke database gagal: " . mysqli_connect_error());
    }

    // Query SQL untuk menyimpan komentar ke database
    $sql = "INSERT INTO komentar_foto (foto_id, user_id, isi_komentar, tanggal_komentar) VALUES ('$photo_id', '$user_id', '$comment_text', '$comment_date')";

    // Jalankan query SQL
    if (mysqli_query($conn, $sql)) {
        echo "<p>Komentar berhasil disimpan.</p>";
    } else {
        echo "<p>Gagal menyimpan komentar: " . mysqli_error($conn) . "</p>";
    }

    // Tutup koneksi ke database
    mysqli_close($conn);
}

// Lanjutkan dengan menampilkan halaman HTML
include "contorller/DashboardController.php";
include "contorller/FotoController.php";
include "contorller/LikeController.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
</head>

<body>
    <nav>
        <div>
            <span>Selamat datang, <?php echo $_SESSION['username']; ?>!</span>
            <form action="" method="POST">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>
    </nav>
    <h1>Selamat datang di halaman dashboard, <?php echo $_SESSION['username']; ?>!</h1>
    <a href="pages/upload.php">Upload Foto</a>
    <!-- Tampilkan foto dan informasi -->
    <?php foreach ($fotos as $foto): ?>
    <div>
        <img src="uploads/<?php echo $foto['lokasi_file']; ?>" alt="<?php echo $foto['judul_foto']; ?>">
        <h2><?php echo $foto['judul_foto']; ?></h2>
        <p><?php echo $foto['deskripsi_foto']; ?></p>
        <p>Tanggal Unggah: <?php echo $foto['tanggal_unggah']; ?></p>
        <p>Foto ID: <?php echo $foto['foto_id']; ?></p>

        <!-- Tombol Like -->
        <form action="dashboard.php" method="post">
            <input type="hidden" name="foto_id" value="<?php echo $foto['foto_id']; ?>">
            <button type="submit" class="like-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="svg">
                    <path
                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                </svg>
            </button>
        </form>

        <!-- //form koemntar -->
        <form action="dashboard.php" method="post">
            <input type="hidden" name="foto_id" value="<?php echo $foto['foto_id']; ?>">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <textarea name="isi_komentar" placeholder="Masukkan komentar Anda" required></textarea>
            <button type="submit" name="submit">Kirim Komentar</button>
        </form>

        <!-- //menampilkan koemntar -->
        <div>
            <?php
    // Query untuk mendapatkan data komentar
    $query = "SELECT * FROM komentar_foto WHERE foto_id = " . $foto['foto_id'];
    $result = mysqli_query($conn, $query);

    // Periksa apakah terdapat komentar
    if (mysqli_num_rows($result) > 0) {
        // Tampilkan komentar
        while ($row = mysqli_fetch_assoc($result)) {
            // Ambil informasi pengguna yang memberikan komentar
            $user_query = "SELECT username FROM user WHERE user_id = " . $row['user_id'];
            $user_result = mysqli_query($conn, $user_query);
            $user_row = mysqli_fetch_assoc($user_result);
            $username = $user_row['username'];

            // Tampilkan nama pengguna, isi komentar, dan tanggal komentar
            echo "<div class='comment'>";
            echo "<p><strong>$username</strong> - " . $row['isi_komentar'] . "</p>";
            echo "<p>Tanggal Komentar: " . $row['tanggal_komentar'] . "</p>";
            echo "</div>";
        }
    } 
    ?>
        </div>

    </div>
    <?php endforeach; ?>

    <script src="src/js/main.js"></script>
</body>

</html>