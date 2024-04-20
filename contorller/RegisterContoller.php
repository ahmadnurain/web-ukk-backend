<?php 
$error_message = "";

// Proses registrasi jika ada data yang dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Periksa apakah email atau username sudah ada dalam database
    $query = "SELECT * FROM user WHERE email='$email' OR username='$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $error_message = "Email atau username sudah digunakan!";
    } else {
        // Enkripsi password sebelum disimpan ke database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Simpan data pengguna ke database
        $insert_query = "INSERT INTO user (nama_lengkap, email, alamat, username, password) 
                         VALUES ('$nama_lengkap', '$email', '$alamat', '$username', '$hashed_password')";
        $insert_result = mysqli_query($conn, $insert_query);

        if ($insert_result) {
            // Registrasi berhasil, redirect ke halaman login
            header("Location: login.php");
            exit;
        } else {
            $error_message = "Registrasi gagal!";
        }
    }
}