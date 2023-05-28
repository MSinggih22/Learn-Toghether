<?php
include '../db/db-connect.php';
$sql = "SELECT * FROM topics_category";
$result = mysqli_query($conn, $sql);

$categories = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
}

mysqli_close($conn);
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
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
                <a href="topics-category-result.php?category_id=<?php echo $category['id_t_category']; ?>">
                    <?php echo $category['name']; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>

</html>