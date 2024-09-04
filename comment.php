<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$content_id = $_POST['content_id'];
$comment = $_POST['comment'];

$stmt = $conn->prepare("INSERT INTO comments (user_id, content_id, comment) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $user_id, $content_id, $comment);

if ($stmt->execute()) {
    header("Location: home.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
