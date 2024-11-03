<?php 
require_once 'core/dbConfig.php';
require_once 'core/models.php'; 

if(!isset($_SESSION['author_id']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter</title>
    <style>
        th, td {
        padding: 15px;
        text-align: left;
        border: 1px solid;
        }
    </style>
</head>
<body style="background-color:lightcyan;">
    <h2 style="text-align: center;">Welcome <?php echo getAuthorByID($pdo, $_SESSION['author_id'])['first_name'] ?> to Newsletter Management System</h2>

    <div style="text-align: center;"><input type="submit" value="Log out" onclick="window.location.href='core/logout.php'"></div>
    <div style="text-align: center;"><input type="submit"  value="System Logs" onclick="window.location.href='clientlogs.php'"></div>

    <h2 style="text-align: center;">Newsletter Clients Name:</h2>
    <h3 style="text-align: center;">Name of the Clients that subscribe to the newsletter using their Email Address Only.</h3>
        <table style="width:100%; margin-top: 50px;border-collapse: collapse;border: 1px solid;">
            <tr>
                <th>Clients ID</th>
                <th>Client Name</th>
                <th>Client Email</th>
                <th>Date Added</th>
                <th>Action</th>
            </tr>
            
            <?php $getDesignByauthor_id = getClientsByAuthors($pdo, $_SESSION['author_id']); ?>
            <?php foreach ($getDesignByauthor_id as $row) { ?>
            <tr>
                <td><?php echo $row['clients_id']?></td>
                <td><?php echo $row['client_name']?></td>
                <td><?php echo $row['email_clients']?></td>
                <td><?php echo $row['date_added']?></td>
                <td>
                    <?php
                        $clients_id = $row['clients_id'];
                        $author_id = $_SESSION['author_id'];
                    ?>
                    <input type="submit" value="Edit Design" onclick="window.location.href='editclients.php?clients_id=<?php echo $clients_id; ?>&author_id=<?php echo $author_id; ?>';">
                    <input type="submit" value="Remove Design" onclick="window.location.href='deleteclients.php?clients_id=<?php echo $clients_id; ?>&author_id=<?php echo $author_id; ?>';">
                </td>
            </tr>
            <?php } ?>
        </table> <br>

        <div style="text-align: center;"><input type="submit" value="Add New Clients" onclick="window.location.href='viewclients.php?author_id=<?php echo $_SESSION['author_id']; ?>';"></div>

        <br><br><br>
        <h3 style="text-align: center;">Author Logged in and Profile</h3>
        <table style="width:100%; margin-top: 50px;border-collapse: collapse;border: 1px solid;">
            <tr>
                <th>Author ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>Age</th>
                <th>Email Address</th>
                <th>Date Added</th>
            </tr>

            <?php $userData = getAuthorByID($pdo, $_SESSION['author_id']); ?>
            <tr>
                <td><?php echo $userData['author_id']?></td>
                <td><?php echo $userData['first_name']?></td>
                <td><?php echo $userData['last_name']?></td>
                <td><?php echo $userData['author_address']?></td>
                <td><?php echo $userData['age']?></td>
                <td><?php echo $userData['email_add']?></td>
                <td><?php echo $userData['date_added']?></td>
            </tr>
        </table>

        <div style="text-align: center;"><input type="submit" value="Edit Profile" onclick="window.location.href='editauthors.php?author_id=<?php echo $userData['author_id']; ?>';"></div>
    </body>
</html>