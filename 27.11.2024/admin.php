
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
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

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

// Zamknięcie połączenia
$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administracyjny</title>
    <link rel="stylesheet" href="assets/styles/desktop.css">
</head>
<body>
    <div class="container">
        <h1>Panel Administracyjny</h1>
        <p><a href="logout.php">Wyloguj się</a></p>
        <p><a href="index.php">Strona główna</a></p>
        <h2>Posty</h2>
        <p><a href="posts/add_post.php">Dodaj nowy post</a></p>
        <ul>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <li><?php echo $row['title']; ?> - <a href="posts/edit_post.php?id=<?php echo $row['id']; ?>">Edytuj</a> | <a href="posts/delete_post.php?id=<?php echo $row['id']; ?>">Usuń</a></li>
            <?php endwhile; ?>
        <?php else: ?>
            <li>Brak postów</li>
        <?php endif; ?>
        </ul>
    </div>
</body>
</html>
