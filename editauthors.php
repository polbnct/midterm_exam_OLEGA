<?php require_once 'core/handleForms.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Designer</title>
    <style>
        p, h1{
            text-align: center;
        }
    </style>
</head>
<body style="background-color:lightcyan;">
    <?php 
    $getAuthorByID = getAuthorByID($pdo, $_GET['author_id']);
    
    if (!$getAuthorByID) {
        echo "<h2>Designer not found!</h2>";
        exit;
    }
    ?>
    
    <h1>Edit Author Profile</h1>
    <form action="core/handleForms.php?author_id=<?php echo $_GET['author_id']; ?>" method="POST">
        <p>
            <label for="first_name">First Name: </label>
            <input type="text" name="first_name" value="<?php echo $getAuthorByID['first_name']; ?>" required>
        </p>
        <p>
            <label for="last_name">Last Name: </label>
            <input type="text" name="last_name" value="<?php echo $getAuthorByID['last_name']; ?>" required>
        </p>
        <p>
            <label for="author_address">Address: </label>
            <input type="text" name="author_address" value="<?php echo $getAuthorByID['author_address']; ?>" required>
        </p>
        <p>
            <label for="age">Age: </label>
            <input type="number" name="age" min="1" value="<?php echo $getAuthorByID['age']; ?>" required>
        </p>
        <p>
            <label for="email_add">Email Address: </label>
            <input type="text" name="email_add" value="<?php echo $getAuthorByID['email_add']; ?>" required>
        </p>
        <p><input type="submit" name="editAuthorBtn" value="Update Author"></p>
    </form>
    
    <p><a href="index.php">Return to Home Screen</a></p>
</body>
</html>