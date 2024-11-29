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
// Tworzenie tabeli 'posts', jeśli nie istnieje, i wstawienie jednorazowo posta 
$sql = "CREATE TABLE IF NOT EXISTS posts (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    title VARCHAR(255) NOT NULL, 
    content TEXT NOT NULL, 
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
)"; 
if ($conn->query($sql) === FALSE) { 
    die("Error creating table: " . $conn->error); 
} else { 
    // Sprawdzenie czy tabela jest pusta 
    $sql = "SELECT COUNT(*) as count FROM posts"; 
    $result = $conn->query($sql); 
    $row = $result->fetch_assoc(); 
    if ($row['count'] == 0) { 
        // Wstawienie jednorazowo posta 
        $sql = "INSERT INTO posts (title, content) VALUES ('Lorem Ipsum', 'Simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.')"; 
        if ($conn->query($sql) === FALSE) { 
            die("Error inserting initial post: " . $conn->error); 
        }
    }
}
// Pobieranie postów z bazy danych
$sql = "SELECT * FROM posts";
$result = $conn->query($sql);

// Zamknięcie połączenia z bazą danych
$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moja Strona</title>
    <link rel="stylesheet" href="assets/styles/desktop.css">
</head>
<body>
    <div class="container">
        <h1>Witamy na naszej stronie!</h1>
        <?php if (isset($_SESSION['username'])): ?>
            <p>Witaj, <?php echo $_SESSION['username']; ?>! <a href="logout.php">Wyloguj się</a></p>
            <p><a href="admin.php">Panel administracyjny</a></p>
        <?php else: ?>
            <p><a href="login.php">Zaloguj się</a></p>
        <?php endif; ?>

        <h2>Posty</h2>
        <ul>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <li><strong><?php echo $row['title']; ?></strong><br><?php echo $row['content']; ?></li>
            <?php endwhile; ?>
        <?php else: ?>
            <li>Brak postów</li>
        <?php endif; ?>
        </ul>
    </div>
</body>
</html>
