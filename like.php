<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$content_id = $_GET['content_id'];

$stmt = $conn->prepare("INSERT INTO likes (user_id, content_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $content_id);

if ($stmt->execute()) {
    header("Location: home.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>