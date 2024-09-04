<!-- user_page.php -->
<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Fetch all uploaded files
$sql = "SELECT * FROM uploads ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Page</title>
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
       <div class="header">
    <h1>MUSTISO NEWS HUB</h1>
    <span class="open-btn" onclick="openNav()">&#9776;</span>
</div>

<div id="myNavbar" class="navbar">
    <a href="javascript:void(0)" class="close-btn" onclick="closeNav()">&times;</a>
    <a href="home.php">Home</a>
    <a href="officials.php">Officials</a>
    <a href="user_ads.php">Ads</a>
    <a href="leadership.html">Leadership</a>
    <a href="letters.html">Letters</a>
    <div class="useracc">
    <h1>You, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <h1>Uploaded Files</h1>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div>
            <?php if ($row['file_type'] == 'image') { ?>
                <img src="<?php echo htmlspecialchars($row['file_path']); ?>" alt="Image" style="width: 600px;">
            <?php } else { ?>
                <video width="600" controls>
                    <source src="<?php echo htmlspecialchars($row['file_path']); ?>"
                        type="video/<?php echo htmlspecialchars(pathinfo($row['file_path'], PATHINFO_EXTENSION)); ?>">
                    Your browser does not support the video tag.
                </video>
            <?php } ?>
            <p><?php echo htmlspecialchars($row['description']); ?></p>

            <!-- Like Button -->
            <form method="POST" action="like_process.php" style="display:inline;">
                <input type="hidden" name="upload_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
                <button type="submit">Like</button>
            </form>

            <!-- Comment Form -->
            <form method="POST" action="comment_process.php" style="display:inline;">
                <input type="hidden" name="upload_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
                <textarea name="comment" required></textarea>
                <button type="submit">Comment</button>
            </form>

            <!-- Display Likes Count -->
            <?php
            $like_sql = "SELECT COUNT(*) as likes_count FROM likes1 WHERE upload_id=" . $row['id'];
            $like_result = $conn->query($like_sql);
            $like_row = $like_result->fetch_assoc();
            ?>
            <p>Likes: <?php echo htmlspecialchars($like_row['likes_count']); ?></p>

            <!-- Display Comments -->
            <?php
            $comment_sql = "SELECT * FROM comments1 WHERE upload_id=" . $row['id'] . " ORDER BY created_at DESC";
            $comments = $conn->query($comment_sql);
            ?>
            <ul>
                <?php while ($comment_row = $comments->fetch_assoc()) { ?>
                    <li><strong><?php echo htmlspecialchars($comment_row['user_id']); ?>:</strong>
                        <?php echo htmlspecialchars($comment_row['comment']); ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    <script src="js/script.js"></script>
    <footer>
        All rights & engagements reserved
    </footer>
</body>

</html>