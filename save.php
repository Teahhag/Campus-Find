
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $item = $_POST['item'] ?? '';
    $status = $_POST['status'] ?? '';
    $description = $_POST['description'] ?? '';
    $contact = $_POST['contact'] ?? '';

    $stmt = $conn->prepare(
        "INSERT INTO items (item, status, description, contact) VALUES (?, ?, ?, ?)"
    );

    if (!$stmt) {
        die("SQL error: " . $conn->error);
    }

    $stmt->bind_param("ssss", $item, $status, $description, $contact);

    if ($stmt->execute()) {
        echo "<script>alert('Item reported successfully!'); window.location='index.php';</script>";
    } else {
        die("Insert error: " . $stmt->error);
    }

    $stmt->close();
} else {
    echo "Please submit the form from the homepage.";
}

$conn->close();
?>
