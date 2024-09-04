<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO news (title, content) VALUES ('$title', '$content')";
    if ($conn->query($sql) === TRUE) {
        echo "News uploaded successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Upload News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .admin_dashboard{
            display: flex;
        }
        .container mt-3{

        }
        footer {
     background-color: #173459;
     color: white;
     padding: 1em;
     text-align: center;
     position: fixed;
     bottom: 0;
     width: 100%;
 }
    </style>
</head>

<body>
    <div class ="admin_dashboard">
    <div class="container mt-3">
        <h2>Upload News</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
    <div class="container mt-3">
<h1>Upload ads</h1>
    <form action="upload_process.php" method="POST" enctype="multipart/form-data">
        <label for="file">Select file:</label>
        <input type="file" class="btn btn-primary" name="file" id="file" required><br><br>

        <label for="description">Description:</label>
        <textarea name="description" class="form-label" id="description" required></textarea><br><br>

        <label for="file_type">File Type:</label>
        <select name="file_type" id="file_type" required>
            <option value="image">Image</option>
            <option value="video">Video</option>
        </select><br><br>

        <input type="submit" class="btn btn-primary" value="Upload">
    </form>
    </div>
    </di>
<footer>
        All rights & engagements reserved
    </footer>
</body>

</html>