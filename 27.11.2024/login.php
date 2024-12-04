<?php
session_start();
require_once 'config.php';

// Połączenie z bazą danych
$conn = new mysqli($servername, $dbusername, $dbpassword);

// Sprawdzanie połączenia
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Tworzenie bazy danych, jeśli nie istnieje
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === FALSE) {
    die("Error creating database: " . $conn->error);
}

// Wybór bazy danych
$conn->select_db($dbname);

// Tworzenie tabeli 'users', jeśli nie istnieje
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating table: " . $conn->error);
}

// Tworzenie użytkownika admin, jeśli nie istnieje
$sql = "SELECT * FROM users WHERE username = 'admin'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $sql = "INSERT INTO users (username, password) VALUES ('admin', 'admin1')";
    if ($conn->query($sql) === FALSE) {
        die("Error creating admin: " . $conn->error);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    
    // Sprawdzenie użytkownika w bazie danych
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password == $row['password']) {
            $_SESSION['username'] = $username;
            header('Location: admin.php');
            exit();
        } else {
            $error = "Nieprawidłowa nazwa użytkownika lub hasło.";
        }
    } else {
        $error = "Nieprawidłowa nazwa użytkownika lub hasło.";
    }
    
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link rel="stylesheet" href="assets/styles/desktop.css">
</head>
<body>
    <div class="container">
        <h1>Logowanie</h1>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form id="loginForm" action="login.php" method="post">
            <div class="form-group">
                <label for="username">Nazwa użytkownika:</label>
                <input type="text" id="username" minlength=5 name="username" placeholder="admin" required>
            </div>
            <div class="form-group">
                <label for="password">Hasło:</label>
                <input type="password" id="password" minlength=6 name="password" placeholder="admin1"  required>
            </div>
            <button type="submit">Zaloguj się</button>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"> </script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script> 
    <script>
    $(document).ready(function () {
        $("#loginForm").validate({
            rules: {
                username: {
                    required: true,
                    minlength: 5
                },
                password: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                username: {
                    required: "Proszę wprowadzić nazwę użytkownika",
                    minlength: "Nazwa użytkownika musi mieć co najmniej 5 znaków"
                },
                password: {
                    required: "Proszę wprowadzić hasło",
                    minlength: "Hasło musi mieć co najmniej 6 znaków"
                }
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            highlight: function (element) {
                $(element).css('background-color', '#ffdddd');
            },
            unhighlight: function (element) {
                $(element).css('background-color', '#ffffff');
            }
        });
    });
    </script>
</body>
</html>
