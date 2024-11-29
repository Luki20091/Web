<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}

require_once '../config.php';

// Załóżmy, że mamy funkcję do pobierania postu po ID
function getPostById($id, $conn) {
    $sql = "SELECT * FROM posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
    $stmt->close();
    return $post;
}

// Połączenie z bazą danych
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Sprawdzanie połączenia
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$post = getPostById($_GET['id'], $conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['edit'])) {
        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);
    
        // Aktualizacja postu w bazie danych
        $sql = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $title, $content, $_GET['id']);
        $stmt->execute();
    
        $stmt->close();
        $conn->close();
    }
    header('Location: ../admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Post</title>
    <link rel="stylesheet" href="../assets/styles/desktop.css">
</head>
<body>
    <div class="container">
        <h1>Edytuj Post</h1>
        <form id="editPostForm" action="edit_post.php?id=<?php echo $_GET['id']; ?>" method="post">
            <div class="form-group">
                <label for="title">Tytuł:</label>
                <input type="text" id="title" name="title" value="<?php echo $post['title']; ?>" required>
            </div>
            <div class="form-group">
                <label for="content">Treść:</label>
                <textarea id="content" name="content" required><?php echo $post['content']; ?></textarea>
            </div>
            <button name="edit" type="submit">Zaktualizuj</button>
            <button name="discard" type="submit">Anuluj</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
    <script>
    $(document).ready(function () {
        $("#editPostForm").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 3
                },
                content: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                title: {
                    required: "Proszę wprowadzić tytuł",
                    minlength: "Tytuł musi mieć co najmniej 3 znaki"
                },
                content: {
                    required: "Proszę wprowadzić treść",
                    minlength: "Treść musi mieć co najmniej 10 znaków"
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
