<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="css/styles.css">
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

    <script src="js/script.js"></script>
    <div><p>oya weeeeee!!!!!</p></div>
    <footer>
        All rights & engagements reserved
    </footer>
</body>

</html>