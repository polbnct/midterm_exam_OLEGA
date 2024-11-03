<?php 
require_once 'core/models.php'; 
require_once 'core/dbConfig.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Clients</title>
    <style>
        th, td {
        padding: 15px;
        text-align: left;
        border: 1px solid;
        }
        p, h2, h3, h1 {
            text-align: center;
        }
    </style>
</head>
<body style="background-color:lightcyan;">
    <p><a href="index.php">Return to Home Screen</a></p>

    <?php 
    if (isset($_GET['author_id'])) {
        $getAllInfoByauthor_id = getAuthorByID($pdo, $_GET['author_id']);
        
        if ($getAllInfoByauthor_id) {
    ?>
            <h1>Author ID: <?php echo htmlspecialchars($getAllInfoByauthor_id['author_id']); ?></h1>

            <h2>Add New Clients for your Newsletter!</h2>
            <form action="core/handleForms.php?author_id=<?php echo $_GET['author_id']; ?>" method="POST">
                <div style="text-align: center;">
                    <label for="client_name">Client Name: </label>
                    <input type="text" name="client_name" required>
                </div>
                <div style="text-align: center;">
                    <label for="email_clients">Client Email: </label>
                    <input type="text" name="email_clients" step="0.01" min="1" required>
                </div>
                <div style="text-align: center;">
                    <input type="submit" name="insertNewClientBtn" value="Add Design">
                </div>
            </form>

            <h2>Current Clients</h2>
            <table style="width:100%; margin-top: 50px;border-collapse: collapse;border: 1px solid;">
                <thead>
                    <tr>
                        <th>Client ID</th>
                        <th>Client Name:</th>
                        <th>Client Email:</th>
                        <th>Date Added</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $getClientsByAuthors = getClientsByAuthors($pdo, $_GET['author_id']); 
                    foreach ($getClientsByAuthors as $row) { 
                    ?>
                        <tr>
                            <td><?php echo ($row['clients_id']); ?></td>
                            <td><?php echo ($row['client_name']); ?></td>
                            <td><?php echo ($row['email_clients']); ?></td>
                            <td><?php echo ($row['date_added']); ?></td>
                            <td>
                                <a href="editclients.php?clients_id=<?php echo $row['clients_id']; ?>&author_id=<?php echo $_GET['author_id']; ?>">Edit</a>
                                <a href="deleteclients.php?clients_id=<?php echo $row['clients_id']; ?>&author_id=<?php echo $_GET['author_id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
    <?php 
        } else {
            echo "<h2>Designer not found.</h2>";
        }
    } else {
        echo "<h2>No designer ID provided.</h2>";
    }
    ?>
</body>
</html>