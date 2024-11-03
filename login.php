<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter</title>
</head>
<body style="background-color:lightcyan;">
    <h3 style="font-family:'Times New Roman', Times, serif; text-align:center;">Welcome kind Author!</h3>
    <h2 style="font-family:'Times New Roman', Times, serif; text-align:center;">Please Login to your account below!</h2>

    <?php if (isset($_SESSION['message'])) { ?>
        <h1 style="color: red;"><?php echo htmlspecialchars($_SESSION['message']); ?></h1>
    <?php unset($_SESSION['message']); } ?>

    <form action="core/handleForms.php" method="POST">
        <p style="font-family:'Times New Roman', Times, serif; text-align:center;">
            <label for="username">Username: </label>
            <input type="text" name="username" required>
        </p>
        <p style="font-family:'Times New Roman', Times, serif; text-align:center;">
            <label for="user_password">Password: </label>
            <input type="password" name="user_password" required>
        </p>
        <p style="font-family:'Times New Roman', Times, serif; text-align:center;">
            <input type="submit" name="loginBtn" value="Log in">
        </p>
        <div class="register-link" style="font-family:'Times New Roman', Times, serif; text-align:center;">
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </div>
    </form>
</body>
</html>