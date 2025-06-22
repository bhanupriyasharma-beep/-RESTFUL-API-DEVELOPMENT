<?php
include_once "config/database.php";

$db = (new Database())->connect();

try {
    // Begin transaction
    if (!$db->inTransaction()) {
        $db->beginTransaction();
    }

    // Fetch all book IDs in current order
    $stmt = $db->query("SELECT id FROM books ORDER BY id ASC");
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Temporary new ID
    $newId = 1;

    // Update each book with new ID
    foreach ($books as $book) {
        $stmt = $db->prepare("UPDATE books SET id = ? WHERE id = ?");
        $stmt->execute([$newId, $book['id']]);
        $newId++;
    }

    $db->commit();

    // ✅ Redirect back to get.php with success flag
    header("Location: books/get.php?reordered=1");
    exit;
} catch (PDOException $e) {
    // Rollback only if transaction was started
    if ($db->inTransaction()) {
        $db->rollBack();
    }

    // Send error message
    echo "<h2>❌ Failed to reorder IDs: " . htmlspecialchars($e->getMessage()) . "</h2>";
}
?>


