<?php 
include "koneksi.php"; 
include "contorller/LoginController.php"

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Login</h1>
    <?php if (!empty($error_message)): ?>
    <div style="color: red;"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <div>
        <form action="login.php" method="POST">
            <label for="username">Username:</label><br />
            <input type="text" name="username"><br />
            <label for="password">Password</label>
            <input type="password" name="password"><br />
            <button type="submit">Submit</button>
        </form>
        <a href="register.php">Resgiter</a>
    </div>
</body>

</html>