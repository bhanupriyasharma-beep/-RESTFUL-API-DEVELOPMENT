<?php
include_once "../config/database.php";
$db = (new Database())->connect();

$message = "";
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookId = $_POST['id'] ?? null;

    if ($bookId) {
        $stmt = $db->prepare("DELETE FROM books WHERE id = ?");
        $deleted = $stmt->execute([$bookId]);
        $message = $deleted ? "✅ Book deleted successfully!" : "❌ Failed to delete book.";
    } else {
        $message = "⚠️ Book ID is required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Book | Library API</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #fbecec, #e6f0f3);
            padding: 2rem;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 2rem;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 {
            color: #dc3545;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 1rem;
        }
        input {
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            background: #dc3545;
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
        }
        button:hover {
            background: #bd2130;
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
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>❌ Delete a Book</h2>
        <form method="POST">
            <input type="number" name="id" placeholder="Enter Book ID to Delete" value="<?= htmlspecialchars($id) ?>" required>
            <button type="submit">Delete Book</button>
        </form>

        <?php if (!empty($message)) echo "<div class='msg'>$message</div>"; ?>

        <div class="links">
            🧾 <a href="/library-api/books/get.php">View All Books</a> |
            🏠 <a href="/library-api/index.php">Back to Home</a>
        </div>
    </div>
</body>
</html>
