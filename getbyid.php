<?php
include_once "../config/database.php";

$db = (new Database())->connect();
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

$book = null;
$error = "";

if ($id) {
    $stmt = $db->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->execute([$id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        $error = "❌ Book with ID $id not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>📘 View Book by ID</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #fdfbfb, #ebedee);
            padding: 2rem;
            color: #333;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
        }
        h1 {
            color: #007BFF;
            margin-bottom: 1.5rem;
        }
        form {
            margin-bottom: 2rem;
        }
        input[type="number"] {
            padding: 0.7rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            width: 60%;
            margin-right: 10px;
        }
        button {
            padding: 0.7rem 1.2rem;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        table {
            margin-top: 1rem;
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
        }
        th {
            background-color: #e9f0fb;
            color: #007BFF;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        .links {
            margin-top: 2rem;
        }
        .links a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
            margin: 0 10px;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>📘 Try View Book by ID</h1>
    <form method="GET" action="">
        <input type="number" name="id" placeholder="Enter Book ID" required>
        <button type="submit">🔍 Search</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php elseif ($book): ?>
        <table>
            <tr><th>ID</th><th>Title</th><th>Author</th><th>Genre</th><th>Year</th></tr>
            <tr>
                <td><?= $book['id'] ?></td>
                <td><?= $book['title'] ?></td>
                <td><?= $book['author'] ?></td>
                <td><?= $book['genre'] ?></td>
                <td><?= $book['year_published'] ?></td>
            </tr>
        </table>
    <?php endif; ?>

    <div class="links">
        📚 <a href="../books/get.php">View All Books</a> |
        🏠 <a href="../index.php">Back to Home</a>
    </div>
</div>
</body>
</html>
