<?php

function sanitizeInput($input) {
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}

function registerAuthor($pdo, $username, $user_password, $hashed_password, $confirm_password, $first_name, $last_name, $author_address, $age, $email_add) {
    if (checkUsernameExistence($pdo, $username)) {
        return "UsernameAlreadyExists";
    }
    if($user_password != $confirm_password) {
        return "PasswordNotMatch";
    }
    if (!validatePassword($user_password)) {
        return "InvalidPassword";
    }

    $query1 = "INSERT INTO author_account (username, user_password) VALUES (?, ?)";
    $statement1 = $pdo -> prepare($query1);
    $executeQuery1 = $statement1 -> execute([$username, $hashed_password]);

    $query2 = "INSERT INTO author_info (first_name, last_name, author_address, age, email_add) VALUES (?, ?, ?, ?, ?)";
    $statement2 = $pdo -> prepare($query2);
    $executeQuery2 = $statement2 -> execute([$first_name, $last_name, $author_address, $age, $email_add]);

    if ($executeQuery1 && $executeQuery2) {
        return "registrationSuccess";
    }
}

function getAuthorLogs ($pdo) {
    $query = "SELECT * FROM author_logs ORDER BY dateLogged DESC";
    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute();

    if($executeQuery) {
        return $statement -> fetchAll();
    }
}

function logDesignerAction($pdo, $logsDescription, $author_id, $clients_id, $doneBy){
    $query = "INSERT INTO author_logs (logsDescription, author_id, clients_id, doneBy) VALUES (?,?,?,?)";
    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute([$logsDescription, $author_id, $clients_id, $doneBy]);

    if($executeQuery){
        return true;
    }
}

function getNewestclients_id($pdo) {
	$query = "SELECT clients_id
			FROM clients
			ORDER BY clients_id DESC
    		LIMIT 1;";
		$statement = $pdo -> prepare($query);
		$executeQuery = $statement -> execute();
		
		if ($executeQuery) {
			return $statement -> fetch();
		}
}

function redirectWithMessage($location, $message) {
    $_SESSION['message'] = $message;
    header("Location: $location");
    exit();
}

function updateAuthor($pdo, $first_name, $last_name, $author_address, $age, $email_add, $author_id) {
    $sql = "UPDATE author_info
            SET first_name = ?, last_name = ?, author_address = ?, age = ?, email_add = ?
            WHERE author_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$first_name, $last_name, $author_address, $age, $email_add, $author_id]);
    return $executeQuery;
}

function deleteAuthor($pdo, $author_id) {
    $query1 = "DELETE FROM clients WHERE clients_id = ?";
    $statement1 = $pdo -> prepare($query1);
    $executeQuery1 = $statement1 -> execute(['clients_id']);

    if($executeQuery1) {
        $query2 = "DELETE FROM author_info WHERE author_id = ?";
        $statement2 = $pdo -> prepare($query2);
        $executeQuery2 = $statement2 -> execute([$author_id]);

        $query3 = "DELETE FROM author_account WHERE userID = ?";
        $statement3 = $pdo -> prepare($query3);
        $executeQuery3 = $statement3 -> execute([$author_id]);

        if($executeQuery2 && $executeQuery2) {
            return true;
        }
    }
}

function getAllAuthor($pdo) {
    $sql = "SELECT * FROM author_info";
    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute();
    
    if ($success) {
        return $stmt->fetchAll();
    } else {
        return false;
    }
}

function getAuthorByID($pdo, $author_id) {
    $sql = "SELECT * FROM author_info WHERE author_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$author_id]);
    return $stmt->fetch();
}

function getClientsbyAuthors($pdo, $author_id) {
    $sql = "SELECT clients.clients_id, clients.client_name, clients.email_clients, clients.date_added
            FROM clients
            JOIN author_info ON clients.author_id = author_info.author_id
            WHERE clients.author_id = ?
            ORDER BY clients.client_name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$author_id]);
    return $stmt->fetchAll();
}

function insertClients($pdo, $client_name, $email_clients, $author_id) {
    $sql = "INSERT INTO clients (client_name, email_clients, author_id) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$client_name, $email_clients, $author_id]);

    if($executeQuery) {
        $clients_id = getNewestclients_id($pdo)['clients_id'];
        $designData = getClientByID($pdo, $clients_id);
        logDesignerAction($pdo, "ADDED", $designData['author_id'], $clients_id, $_SESSION['author_id']);
        return true;
    }
}

function getClientByID($pdo, $clients_id) {
    $sql = "SELECT clients.author_id, clients.clients_id, clients.client_name, clients.email_clients, clients.date_added
            FROM clients
            JOIN author_info ON clients.author_id = author_info.author_id
            WHERE clients.clients_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$clients_id]);
    return $stmt->fetch();
}

function updateClient($pdo, $client_name, $email_clients, $clients_id) {
    $designData = getClientByID($pdo, $clients_id);

    $sql = "UPDATE clients
            SET client_name = ?, email_clients = ?
            WHERE clients_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$client_name, $email_clients, $clients_id]);

    if($executeQuery) {
        logDesignerAction($pdo, "UPDATED", $designData['author_id'], $clients_id, $_SESSION['author_id']);
        return true;
    }
}

function deleteClient($pdo, $clients_id) {
    $designData = getClientByID($pdo, $clients_id);
    

    $sql = "DELETE FROM clients WHERE clients_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$clients_id]);

    if($executeQuery) {
        logDesignerAction($pdo, "REMOVED", $designData['author_id'], $clients_id, $_SESSION['author_id']);
        return true;
    }
}


function loginAuthor ($pdo, $username, $user_password) {
    $sql = "SELECT * FROM author_account WHERE username=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);

    if ($stmt->rowCount() == 1) {
        $userInfoRow = $stmt->fetch();
        $usernameFromDB = $userInfoRow['username'];
        $passwordFromDB = $userInfoRow['user_password'];

        if (password_verify($user_password, $passwordFromDB)) {
            $_SESSION['author_id'] = $userInfoRow['userID']; // Ensure this is consistent with your index.php
            $_SESSION['username'] = $usernameFromDB;
            $_SESSION['message'] = "Login successful!";
            return 'loginSuccess';
        } else {
            $_SESSION['message'] = "Password is incorrect!";
            return 'incorrectPassword';
        }
    } else {
        $_SESSION['message'] = "Username doesn't exist from the database. You may consider registration first.";
        return 'usernameDoesNotExist';
    }
}

function checkUsernameExistence($pdo, $username) {
	$query = "SELECT * FROM author_account WHERE username = ?";
	$statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$username]);

	if($statement -> rowCount() > 0) {
		return true;
	}
}

function checkUserExistence($pdo, $first_name, $last_name, $author_address, $age, $email_add) {
	$query = "SELECT * FROM author_info
				WHERE first_name = ? AND 
				last_name = ? AND
				author_address = ? AND
				age = ? AND
                email_add = ? ";
	$statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$first_name, $last_name, $author_address, $age, $email_add]);

	if($statement -> rowCount() > 0) {
		return true;
	}
}

function validatePassword($user_password) {
	if(strlen($user_password) >= 8) {
		$hasLower = false;
		$hasUpper = false;
		$hasNumber = false;

		for($i = 0; $i < strlen($user_password); $i++) {
			if(ctype_lower($user_password[$i])) {
				$hasLower = true;
			}
			if(ctype_upper($user_password[$i])) {
				$hasUpper = true;
			}
			if(ctype_digit($user_password[$i])) {
				$hasNumber = true;
			}

			if($hasLower && $hasUpper && $hasNumber) {
				return true;
			}
		}
	}
	return false;
}

?>
