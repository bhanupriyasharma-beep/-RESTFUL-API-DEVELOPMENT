<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>📚 Library API Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Page Background */
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #dfe9f3, #ffffff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container Card */
        .container {
            background: #ffffff;
            padding: 2rem 3rem;
            border-radius: 18px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            max-width: 650px;
            width: 90%;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        /* Header */
        h1 {
            color: #333;
            margin-bottom: 1.8rem;
            font-size: 2rem;
        }

        /* Dashboard Links */
        .dashboard-links {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .link-card {
            padding: 1rem;
            border-radius: 12px;
            background: linear-gradient(145deg, #f0f0f0, #ffffff);
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.1);
            transition: transform 0.2s, background 0.3s;
        }

        .link-card:hover {
            background: #e7f0ff;
            transform: translateY(-5px);
        }

        .link-card a {
            text-decoration: none;
            color: #007BFF;
            font-size: 1.1rem;
            font-weight: 600;
            display: block;
        }

        /* Example ID link at bottom */
        .bottom-link {
            margin-top: 2rem;
            font-size: 0.95rem;
        }

        .bottom-link a {
            color: #28a745;
            font-weight: bold;
            text-decoration: none;
        }

        .bottom-link a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📚 Library API Dashboard</h1>
        <div class="dashboard-links">
            <div class="link-card">
                🔍 <a href="books/get.php">View All Books</a>
            </div>
            <div class="link-card">
                ➕ <a href="books/post.php">Add a New Book</a>
            </div>
            <div class="link-card">
                ✏️ <a href="books/put.php">Update Book</a>
            </div>
            <div class="link-card">
                ❌ <a href="books/delete.php">Delete Book</a>
            </div>
        </div>

        <div class="bottom-link">
           <li><a href="books/getbyid.php">📘 Try View Book by ID</a></li>

        </div>
    </div>
</body>
</html>



