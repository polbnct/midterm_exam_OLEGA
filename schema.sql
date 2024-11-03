CREATE TABLE author_info (
    author_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR (32),
    last_name VARCHAR (32),
    author_address VARCHAR (64),
    age INT CHECK (age >= 18),
    email_add VARCHAR (128),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE clients  (
    clients_id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR (128),
    email_clients VARCHAR (128),
    author_id INT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE author_account (
        userID INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR (64),
        user_password VARCHAR (64)
);

CREATE TABLE author_logs (
    logs_id INT AUTO_INCREMENT PRIMARY KEY,
    logsDescription VARCHAR (255),
    author_id INT,
    clients_id INT,
    doneBy INT,
    dateLogged TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);