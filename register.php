<?php
include "./database/koneksi.php"; 
include "contorller/RegisterContoller.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Registrasi</h1>
    <?php if (!empty($error_message)): ?>
    <div style="color: red;"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form action="register.php" method="POST">
        <label for="NamaLengkap">Nama Lengkap:</label><br>
        <input type="text" id="nama_lengkap" name="nama_lengkap" required><br>
        <label for="Email">Email:</label><br>
        <input type="email" id="email" name="email" required><br <label for="Alamat">Alamat:</label><br>
        <input type="alamat" id="alamat" name="alamat" required><br <label for="Username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Register</button>
    </form>
</body>

</html>