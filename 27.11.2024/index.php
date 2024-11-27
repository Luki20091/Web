
<!--
	ooooo        ooooo     ooo oooo    oooo ooooo
	`888'        `888'     `8' `888   .8P'  `888'
	 888          888       8   888  d8'     888
	 888          888       8   88888[       888
	 888          888       8   888`88b.     888
	 888       o  `88.    .8'   888  `88b.   888
	o888ooooood8    `YbodP'    o888o  o888o o888o
-->
<?php
session_start();
require_once 'config.php';

// Połączenie z bazą danych
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Sprawdzanie połączenia
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
