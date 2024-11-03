<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if(!isset($_SESSION['author_id']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head style="background-color:lightcyan;">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Logs</title>
    <style>
        th, td {
        padding: 15px;
        text-align: left;
        border: 1px solid;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
    <body style="background-color:lightcyan;">
        <h2>Client Logs</h2>

        <div style="text-align: center;"><input type="submit" value="Return To Your Profile" onclick="window.location.href='index.php'"></div>

        <table style="width:100%; margin-top: 50px;border-collapse: collapse;border: 1px solid;">
            <tr>
                <th>Log ID</th>
                <th>Action Done</th>
                <th>Designer ID</th>
                <th>Design ID</th>
                <th>Done By</th>
                <th>Date Logged</th>
            </tr>

            <?php $clientlogs = getAuthorLogs($pdo); ?>
            <?php foreach ($clientlogs as $row) { ?>
            <tr>
                <td><?php echo $row['logs_id']?></td>
                <td><?php echo $row['logsDescription']?></td>
                <td><?php echo $row['author_id']?></td>
                <td><?php echo $row['clients_id']?></td>
                <td><?php echo $row['doneBy']?></td>
                <td><?php echo $row['dateLogged']?></td>
            </tr>
            <?php } ?>
        </table>    
    </body>
</html>

