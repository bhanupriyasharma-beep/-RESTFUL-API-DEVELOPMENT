<?php
include_once "../config/database.php";

$db = (new Database())->connect();
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

function renderHtml($data) {
    echo "<!DOCTYPE html><html lang='en'><head>
    <meta charset='UTF-8'>
    <title>Books List</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #f7f8fc, #e2eafc);
            color: #333;
            padding: 2rem;
        }
        .container {
            max-width: 900px;
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
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
            margin: 1rem 0;
        }
        th {
            background-color: #f2f2f2;
            color: #007BFF;
            font-weight: bold;
            border: 2px solid #007BFF;
            border-radius: 6px;
            text-transform: uppercase;
            padding: 12px 15px;
            box-shadow: inset 0 0 5px #007BFF44;
        }
        td {
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #007BFF;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            margin: 1rem 0.5rem 0 0.5rem;
        }
        .btn:hover {
            background: #0056b3;
        }
        .btn-reorder {
            background-color: #ff5722;
        }
        .btn-reorder:hover {
            background-color: #e64a19;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        .success {
            color: green;
            font-weight: bold;
            margin: 1rem 0;
        }
    </style>
    </head><body>
    <div class='container'>
    <h1>📚 Library Books</h1>";

    // ✅ Show success messages if applicable
    if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
        echo "<p class='success'>✅ Book deleted successfully.</p>";
    }

    if (isset($_GET['reordered']) && $_GET['reordered'] == 1) {
        echo "<p class='success'>✅ Book IDs have been rearranged successfully.</p>";
    }

    // ✅ Always show the reorder button
    echo "<a href='../reorder.php' class='btn btn-reorder'>🔁 Rearrange Book IDs</a>";

    if (isset($data['error'])) {
        echo "<p class='error'>{$data['error']}</p>";
    } elseif (isset($data['id'])) {
        echo "<table><tr>
                <th>ID</th><th>Title</th><th>Author</th><th>Genre</th><th>Year</th></tr>
              <tr>
                <td>{$data['id']}</td>
                <td>{$data['title']}</td>
                <td>{$data['author']}</td>
                <td>{$data['genre']}</td>
                <td>{$data['year_published']}</td>
              </tr></table>";
    } else {
        echo "<table><tr>
                <th>ID</th><th>Title</th><th>Author</th><th>Genre</th><th>Year</th>
              </tr>";
        foreach ($data as $book) {
            echo "<tr>
                <td>{$book['id']}</td>
                <td>{$book['title']}</td>
                <td>{$book['author']}</td>
                <td>{$book['genre']}</td>
                <td>{$book['year_published']}</td>
              </tr>";
        }
        echo "</table>";
    }

    echo "<br><a href='../index.php' class='btn'>🏠 Back to Home</a>";
    echo "</div></body></html>";
}

$stmt = $id
    ? $db->prepare("SELECT * FROM books WHERE id = ?")
    : $db->query("SELECT * FROM books");

if ($id) {
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $data = $result ?: ["error" => "Book not found"];
} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data = $result;
}

$acceptHeader = $_SERVER['HTTP_ACCEPT'] ?? '';

if (strpos($acceptHeader, 'text/html') !== false) {
    renderHtml($data);
} else {
    header("Content-Type: application/json");
    echo json_encode($data);
}
?>


