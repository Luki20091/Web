
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
    header('Location: ../login.php');
    exit();
}

require_once '../config.php';

// Załóżmy, że mamy funkcję do usuwania postu po ID
function deletePostById($id, $conn) {
    $sql = "DELETE FROM posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

if (isset($_GET['id'])) {
    // Połączenie z bazą danych
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Sprawdzanie połączenia
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    deletePostById($_GET['id'], $conn);
    $conn->close();

    header('Location: ../admin.php');
    exit();
}
?>
