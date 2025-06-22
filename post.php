<?php
include_once "../config/database.php";
$db = (new Database())->connect();

$method = $_SERVER['REQUEST_METHOD'];
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
$accept = $_SERVER['HTTP_ACCEPT'] ?? '';

$message = "";

// Handle JSON POST (API mode)
if (strpos($contentType, 'application/json') !== false) {
    header("Content-Type: application/json");
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['title']) || empty(trim($data['title']))) {
        echo json_encode(["error" => "Title is required"]);
        exit;
    }

    $stmt = $db->prepare("INSERT INTO books (title, author, genre, year_published) VALUES (?, ?, ?, ?)");
    $result = $stmt->execute([
        $data['title'],
        $data['author'] ?? null,
        $data['genre'] ?? null,
        $data['year_published'] ?? null
    ]);

    echo json_encode(["message" => $result ? "Book added successfully" : "Failed to add book"]);
    exit;
}

// Handle Form POST (HTML mode)
if ($method === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $genre = trim($_POST['genre'] ?? '');
    $year = trim($_POST['year_published'] ?? '');

    if (!empty($title)) {
        $stmt = $db->prepare("INSERT INTO books (title, author, genre, year_published) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([$title, $author, $genre, $year]);
        $message = $result ? "✅ Book added successfully!" : "❌ Failed to add book.";
    } else {
        $message = "⚠️ Title is required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Book | Library API</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #f7f8fc, #e2eafc);
            color: #333;
            padding: 2rem;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #007BFF;
            margin-bottom: 1.5rem;
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
            background: #28a745;
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        .msg {
            text-align: center;
            margin-top: 1rem;
            font-weight: bold;
            color: #333;
        }
        .links {
            margin-top: 2rem;
        }
        .links a {
            color: #007BFF;
            text-decoration: none;
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
        <h1>➕ Add a New Book</h1>

        <form method="POST" action="">
            <input type="text" name="title" placeholder="Title" required>
            <input type="text" name="author" placeholder="Author">
            <input type="text" name="genre" placeholder="Genre">
            <input type="number" name="year_published" placeholder="Year Published">
            <button type="submit">Add Book</button>
        </form>

        <?php if (!empty($message)) echo "<div class='msg'>$message</div>"; ?>

        <div class="links">
            🔄 <a href="/library-api/books/post.php">POST to /books/post.php to add</a> |
            📚 <a href="/library-api/books/get.php">View All Books</a> |
            🏠 <a href="/library-api/index.php">Back to Home</a>
        </div>
    </div>
</body>
</html>

