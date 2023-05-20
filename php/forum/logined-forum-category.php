<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['token'])) {
    header('Location: index.php');
    exit();
}

include '../../db/database-connect.php';
$sql = "SELECT * FROM topics_category";
$result = mysqli_query($conn, $sql);

$categories = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
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
    <title>Select Category</title>
</head>

<body>
    <h1>Select Category</h1>
    <ul>
        <?php foreach ($categories as $category) : ?>
            <li>
                <a href="topics-category-result.php?category_id=<?php echo $category['id']; ?>">
                    <?php echo $category['name']; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <p>Logged in as: <?php echo $loggedinUsername; ?></p>
</body>

</html>