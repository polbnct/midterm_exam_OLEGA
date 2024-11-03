<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Designs</title>
</head>
<body style="background-color:lightcyan;">
    <h1>Edit Client Info</h1>
    
    <p><a href="viewclients.php?author_id=<?php echo $_GET['author_id']; ?>">View other Clients</a></p>
    
    <?php 
    if (isset($_GET['clients_id'])) {
        $getClientByID = getClientByID($pdo, $_GET['clients_id']);
        
        if ($getClientByID) { 
    ?>
        <form action="core/handleForms.php?clients_id=<?php echo $_GET['clients_id']; ?>&author_id=<?php echo $_GET['author_id']; ?>" method="POST">
            <div>
                <label for="client_name">Client Name</label>
                <input type="text" name="client_name" value="<?php echo htmlspecialchars($getClientByID['client_name']); ?>" required>
            </div>
            <div>
                <label for="client_name">Client Email:</label>
                <input type="text" name="email_clients" value="<?php echo htmlspecialchars($getClientByID['email_clients']); ?>" required>
            </div>
            <div>
                <input type="submit" name="editClientBtn" value="Update Client">
            </div>
        </form>
    <?php 
        } else {
            echo "<p>Design not found.</p>";
        }
    } else {
        echo "<p>No design ID provided.</p>";
    }
    ?>
    
    <p><a href="viewclients.php?author_id=<?php echo $_GET['author_id']; ?>">Return to Clients</a></p>
</body>
</html>