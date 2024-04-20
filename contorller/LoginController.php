<?php // Proses login jika ada data yang dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    // Mendapatkan data dari form login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mengambil data pengguna dari database berdasarkan username
    $query = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // Memeriksa apakah password yang dimasukkan sesuai dengan password di database
        if (password_verify($password, $user['password'])) {
            // Login berhasil, simpan user_id dan username ke dalam session
            session_start();
            $_SESSION['user_id'] = $user['user_id']; // Perbaikan: Menyimpan user_id ke session
            $_SESSION['username'] = $username; // Menyimpan username ke session
            header("Location: dashboard.php"); // Redirect ke halaman dashboard setelah login berhasil
            exit;
        } else {
            $error_message = "Password salah!";
        }
    } else {
        $error_message = "Username tidak ditemukan!";
    }
}