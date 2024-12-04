
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    
    // Połączenie z bazą danych
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    
    // Sprawdzanie połączenia
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Dodawanie postu do bazy danych
    $sql = "INSERT INTO posts (title, content) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $content);
    $stmt->execute();
    
    $stmt->close();
    $conn->close();

    header('Location: ../admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj Post</title>
    <link rel="stylesheet" href="../assets/styles/desktop.css">
</head>
<body>
    <div class="container">
        <h1>Dodaj Post</h1>
        <form id="addPostForm" action="add_post.php" method="post">
            <div class="form-group">
                <label for="title">Tytuł:</label>
                <input type="text" id="title" name="title" minlength=3 required>
            </div>
            <div class="form-group">
                <label for="content">Treść:</label>
                <textarea id="content" name="content" minlength=10 required></textarea>
            </div>
            <button type="submit">Dodaj</button>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"> </script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script> 
    <script>
    $(document).ready(function () {
        $("#addPostForm").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                content: {
                    required: true,
                    minlength: 10,
                    maxlength: 500
                }
            },
            messages: {
                title: {
                    required: "Proszę wprowadzić tytuł",
                    minlength: "Tytuł musi mieć co najmniej 3 znaki",
                    maxlength: "Tytuł może miec najwyżej 50 znaków"
                },
                content: {
                    required: "Proszę wprowadzić treść",
                    minlength: "Treść musi mieć co najmniej 10 znaków",
                    maxlength: "Treść może miec najwyżej 500 znaków"
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
