<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $upload_id = $_POST['upload_id'];
    $user_id = $_POST['user_id'];

    // Prevent duplicate likes
    $check_sql = "SELECT * FROM likes1 WHERE upload_id='$upload_id' AND user_id='$user_id'";
    $result = $conn->query($check_sql);

    if ($result && $result->num_rows == 0) {
        $sql = "INSERT INTO likes1 (user_id, upload_id) VALUES ('$user_id', '$upload_id')";
        if ($conn->query($sql)) {
            header("Location: user_ads.php");
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "You have already liked this file.";
    }
}
?>