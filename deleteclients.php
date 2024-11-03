<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Client</title>
    <style>

    </style>
</head>
<body style="background-color:lightcyan;">
    <?php $getDesignsByID = getClientByID($pdo, $_GET['clients_id']); ?>
    <h1>Are you sure you want to delete this Client from your Newsletters?</h1>

    <table>
        <tr>
            <th>Client ID: </th>
            <td><?php echo $getDesignsByID['clients_id']; ?></td>
        </tr>
        <tr>
            <th>Client Name: </th>
            <td><?php echo $getDesignsByID['client_name']; ?></td>
        </tr>
        <tr>
            <th>Client Email: </th>
            <td><?php echo $getDesignsByID['email_clients']; ?></td>
        </tr>
        <tr>
            <th>Date Added: </th>
            <td><?php echo $getDesignsByID['date_added']; ?></td>
        </tr>
    </table>

    <form action="core/handleForms.php?clients_id=<?php echo $_GET['clients_id']; ?>&author_id=<?php echo $_GET['author_id']; ?>" method="POST">
        <input type="submit" name="deleteClientBtn" value="Delete">
    </form>

    <p><a href="viewclients.php?author_id=<?php echo $_GET['author_id']; ?>">Cancel</a></p>
</body>
</html>