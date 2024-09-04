<!-- upload_process.php -->
<?php
session_start();
include 'db.php'; // database connection

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Unauthorized access.");
}

$user_id = $_SESSION['user_id'];
$file = $_FILES['file'];
$description = $_POST['description'];
$file_type = $_POST['file_type'];

$target_dir = "uploads/";
$target_file = $target_dir . basename($file["name"]);
$upload_ok = 1;

// Check if file is an image or video
$allowed_types = ($file_type === 'image') ? ['jpg', 'jpeg', 'png', 'gif'] : ['mp4', 'avi', 'mov'];
$file_ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (!in_array($file_ext, $allowed_types)) {
    die("Sorry, only " . implode(", ", $allowed_types) . " files are allowed.");
}

// Move the file to the uploads directory
if (move_uploaded_file($file["tmp_name"], $target_file)) {
    // Insert file info into database
    $sql = "INSERT INTO uploads (user_id, file_path, description, file_type) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isss', $user_id, $target_file, $description, $file_type);

    if ($stmt->execute()) {
        echo "File uploaded successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Sorry, there was an error uploading your file.";
}
?>