<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $upload_id = $_POST['upload_id'];
    $user_id = $_POST['user_id'];
    $comment = $_POST['comment'];

    $sql = "INSERT INTO comments1 (user_id, upload_id, comment) VALUES ('$user_id', '$upload_id', '$comment')";
    if ($conn->query($sql)) {
        header("Location: user_ads.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>