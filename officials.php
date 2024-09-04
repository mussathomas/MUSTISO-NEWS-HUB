<?php
include 'db.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    $id = $_POST['id'];
    $content_id = $_POST['content_id'];
    $comment = $_POST['comment'];

    $sql = "INSERT INTO comments (id, content_id, comment) VALUES ('$id', '$content_id', '$comment')";
    if (!$conn->query($sql)) {
        echo "Error: " . $conn->error;
    }
}

// Handle like submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['like'])) {
    $news_id = $_POST['news_id'];
    $user = $_POST['user'];

    // Prevent duplicate likes
    $check_sql = "SELECT * FROM likes WHERE news_id='$news_id' AND user='$user'";
    $result = $conn->query($check_sql);

    if ($result && $result->num_rows == 0) { // Changed the condition to check for 0 rows to insert a like
        $sql = "INSERT INTO likes (news_id, user) VALUES ('$news_id', '$user')";
        if (!$conn->query($sql)) {
            echo "Error: " . $conn->error;
        }
    }
}

// Fetch news articles
$sql = "SELECT * FROM news ORDER BY created_at DESC";
$news = $conn->query($sql);

if (!$news) {
    die("Error fetching news: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Feed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <style>
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
    <div class="container mt-5">
        <h2>Official News</h2>
        <?php while ($row = $news->fetch_assoc()) { ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($row['content']); ?></p>
                    <p class="text-muted"><?php echo htmlspecialchars($row['created_at']); ?></p>

                    <!-- Like Button -->
                    <form method="POST" class="d-inline">
                        <input type="hidden" name="news_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        <input type="hidden" name="user" value="User1"> <!-- Replace with dynamic user data -->
                        <button type="submit" name="like" class="btn btn-outline-primary btn-sm">Like</button>
                    </form>

                    <!-- Comment Form -->
                    <form method="POST" class="mt-2">
                        <input type="hidden" name="news_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        <input type="hidden" name="user" value="User1"> <!-- Replace with dynamic user data -->
                        <div class="input-group mb-3">
                            <input type="text" name="comment" class="form-control" placeholder="Add a comment..." required>
                            <button class="btn btn-primary" type="submit">Comment</button>
                        </div>
                    </form>

                    <!--Display Likes Count -->
                    <?php
                    $like_sql = "SELECT COUNT(*) as likes_count FROM likes WHERE user_id=" . $row['id'];
                    $like_result = $conn->query($like_sql);

                    if ($like_result) {
                        $like_row = $like_result->fetch_assoc();
                        echo "<p class='text-muted'>" . htmlspecialchars($like_row['likes_count']) . " Likes</p>";
                    } else {
                        echo "<p class='text-muted'>Error fetching likes: " . $conn->error . "</p>";
                    }
                    ?>

                    <!-- Display Comments -->
                    <?php
                    $comment_sql = "SELECT * FROM comments WHERE content_id=" . $row['id'] . " ORDER BY created_at DESC";
                    $comments = $conn->query($comment_sql);

                    if ($comments) {
                        echo "<ul class='list-group list-group-flush'>";
                        while ($comment_row = $comments->fetch_assoc()) {
                            echo "<li class='list-group-item'><strong>" . htmlspecialchars($comment_row['content_id']) . ":</strong> " . htmlspecialchars($comment_row['comment']) . "</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p class='text-muted'>Error fetching comments: " . $conn->error . "</p>";
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <script src="js/script.js"></script>
    <footer>
        All rights & engagements reserved
    </footer>
</body>

</html>