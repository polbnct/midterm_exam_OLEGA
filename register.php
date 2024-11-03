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
    <h2 style="text-align: center;">Register Now to become an Author!</h2>

    <?php if (isset($_SESSION['message'])) { ?>
		    <h1 style="color: red;"><?php echo $_SESSION['message']; ?></h1>
	    <?php } unset($_SESSION['message']); ?>

    <form action="core/handleForms.php" method="POST">
        <p style="text-align: center;">
        <label for="username">Username</label>
        <input type="text" name="username" required>
        </p>
        <p style="text-align: center;">
        <label for="user_password">Password</label>
        <input type="password" name="user_password" required>
        </p>
        <p style="text-align: center;">
        <label for="confirm_password">Confirm password</label>
        <input type="password" name="confirm_password" required>
        </p>
        <p style="text-align: center;">
            <label for="first_name">First Name: </label>
            <input type="text" name="first_name" required>
        </p>
        <p style="text-align: center;">
            <label for="last_name">Last Name: </label>
            <input type="text" name="last_name" required>
        </p>
        <p style="text-align: center;">
            <label for="author_address">Address: </label>
            <input type="text" name="author_address" required>
        </p>
        <p style="text-align: center;">
            <label for="age">Age: </label>
            <input type="number" name="age" min="1" required>
        </p>
        <p style="text-align: center;">
            <label for="email_add">Email Address: </label>
            <input type="text" name="email_add" required>
        </p>
        <p style="text-align: center;">
            <input type="submit" name="registerBtn" value="Register Account">
        </p>
        <p style="text-align: center;">
            <input type="submit" name="returnButton" value="Return to Login Page" onclick="window.location.href='login.php'">
        </p>
    </form>
</body>
</html>