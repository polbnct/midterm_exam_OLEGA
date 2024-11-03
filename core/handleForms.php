<?php
require_once 'dbConfig.php';
require_once 'models.php';

if (isset($_POST['loginBtn'])) {
    $username = sanitizeInput($_POST['username']);
    $user_password = $_POST['user_password'];

    $loginStatus = loginAuthor($pdo, $username, $user_password);

    switch ($loginStatus) {
        case "loginSuccess":
            redirectWithMessage('../index.php', '');
            break;
        case "usernameDoesNotExist":
            redirectWithMessage('../login.php', 'Username does not exist!');
            break;
        case "incorrectPassword":
            header("Location: ../login.php");
            exit(); 
        default:
            redirectWithMessage('../login.php', 'An unexpected error occurred.');
            break;
    }
}

if(isset($_POST['registerBtn'])) {
    $username = sanitizeInput($_POST['username']);
    $user_password = $_POST['user_password'];
    $hashed_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
    $confirm_password = sanitizeInput($_POST['confirm_password']);
    $first_name = sanitizeInput($_POST['first_name']);
    $last_name = sanitizeInput($_POST['last_name']);
    $author_address = $_POST['author_address'];
    $age = $_POST['age'];
    $email_add = $_POST['email_add'];

    $function = registerAuthor($pdo, $username, $user_password, $hashed_password, $confirm_password, $first_name, $last_name, $author_address, $age, $email_add);
    if($function == "registrationSuccess") {
        header("Location: ../login.php");
    } elseif($function == "UsernameAlreadyExists") {
        $_SESSION['message'] = "Username already exists! Please choose a different username!";
        header("Location: ../register.php");
    } elseif($function == "UserAlreadyExists") {
        $_SESSION['message'] = "User already exists! Please edit your existing account instead!";
        header("Location: ../register.php");
    } elseif($function == "PasswordNotMatch") {
        $_SESSION['message'] = "Password does not match!";
        header("Location: ../register.php");
    } elseif($function == "InvalidPassword") {
        $_SESSION['message'] = "Password is not strong enough! Make sure it is 8 letters long, has uppercase and lowercase characters, and numbers.";
        header("Location: ../register.php");
    } else {
        echo "<h2>User addition failed.</h2>";
        echo '<a href="../register.php">';
        echo '<input type="submit" id="returnHomeButton" value="Return to register page" style="padding: 6px 8px; margin: 8px 2px;">';
        echo '</a>';
    } 
}


if (isset($_POST['editAuthorBtn'])) {
    $query = updateAuthor($pdo, $_POST['first_name'], $_POST['last_name'], $_POST['author_address'], $_POST['age'], $_POST['email_add'], $_GET['author_id']);
    if ($query) {
        header("Location: ../index.php");
        exit(); 
    } else {
        echo "Edit Failed";
    }
}

if (isset($_POST['insertNewClientBtn'])) {
    $query = insertClients($pdo, $_POST['client_name'], $_POST['email_clients'], $_GET['author_id']);
    if ($query) {
        header("Location: ../viewclients.php?author_id=" . $_GET['author_id']);
        exit(); 
    } else {
        echo "Insertion Failed";
    }
}

if (isset($_POST['editClientBtn'])) {
    if (isset($_GET['clients_id'])) {
        $query = updateClient($pdo, $_POST['client_name'], $_POST['email_clients'], $_GET['clients_id']);
        if ($query) {
            header("Location: ../viewclients.php?author_id=" . $_GET['author_id']);
            exit(); 
        } else {
            echo "Update Failed";
        }
    } else {
        echo "No design ID provided.";
    }
}

if (isset($_POST['deleteClientBtn'])) {
    $query = deleteClient($pdo, $_GET['clients_id']);
    if ($query) {
        header("Location: ../viewclients.php?author_id=" . $_GET['author_id']);
        exit(); 
    } else {
        echo "Deletion Failed";
    }
}

?>
