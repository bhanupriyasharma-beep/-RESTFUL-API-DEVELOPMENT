<?php
include_once "../config/database.php";
$db = (new Database())->connect();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $genre = trim($_POST['genre'] ?? '');
    $year = trim($_POST['year_published'] ?? '');

    if ($id && $title) {
        $stmt = $db->prepare("UPDATE books SET title = ?, author = ?, genre = ?, year_published = ? WHERE id = ?");
        $success = $stmt->execute([$title, $author, $genre, $year, $id]);
        $message = $success ? "✅ Book updated successfully!" : "❌ Update failed.";
    } else {
        $message = "⚠️ Book ID and Title are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Book | Library API</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #f7f8fc, #e2eafc);
            padding: 2rem;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #007BFF;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            max-width: 500px;
            margin: auto;
        }
        input {
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }
        button {
            background: #ffc107;
            color: #000;
            padding: 0.75rem;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
        }
        button:hover {
            background: #e0a800;
        }
        .msg {
            margin-top: 1rem;
            font-weight: bold;
        }
        .links {
            margin-top: 2rem;
        }
        .links a {
            margin: 0 10px;
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>✏️ Update Book</h1>
        <form method="POST">
            <input type="number" name="id" placeholder="Book ID" required>
            <input type="text" name="title" placeholder="New Title" required>
            <input type="text" name="author" placeholder="New Author">
            <input type="text" name="genre" placeholder="New Genre">
            <input type="number" name="year_published" placeholder="New Year Published">
            <button type="submit">Update Book</button>
        </form>
        <?php if ($message) echo "<div class='msg'>$message</div>"; ?>

        <div class="links">
            🆙 <a href="put.php">PUT to /books/put.php to update</a> |
            📚 <a href="get.php">View All Books</a> |
            🏠 <a href="../index.php">Back to Home</a>
        </div>
    </div>
</body>
</html>
