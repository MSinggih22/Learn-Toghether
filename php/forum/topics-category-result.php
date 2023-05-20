<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['token'])) {
    header('Location: index.php');
    exit();
}
if (!isset($_GET['category_id'])) {
    header('Location: select_category.php');
    exit();
}
$category_id = $_GET['category_id'];
include '../../db/database-connect.php';

$sql = "SELECT name FROM topics_category WHERE id = '$category_id'";
$result = mysqli_query($conn, $sql);

$category_name = "";

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $category_name = $row['name'];
}

$sql = "SELECT t.* 
        FROM topics AS t
        INNER JOIN relasi_topics_category AS rtc ON rtc.topic_id = t.id
        WHERE rtc.category_id = '$category_id'";
$result = mysqli_query($conn, $sql);

$topics = array(); 

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $topics[] = $row;
    }
}
mysqli_close($conn);

$loggedInUser = $_SESSION['user_id'];
$loggedinUsername = "";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT username FROM users WHERE id = '$loggedInUser'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $loggedinUsername = $row['username'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Topics - <?php echo $category_name; ?></title>
</head>

<body>
    <h1>Topics - <?php echo $category_name; ?></h1>
    <ul>
        <?php foreach ($topics as $topic) : ?>
            <li>
                <h3><?php echo $topic['title']; ?></h3>
                <p><?php echo $topic['description']; ?></p>
            </li>e
        <?php endforeach; ?>
    </ul>
    <p>Logged in as: <?php echo $loggedinUsername; ?></p>
</body>

</html>