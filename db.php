
<?php
$conn = new mysqli("localhost", "root", "", "campus_lost_found");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
