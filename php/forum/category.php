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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/category.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <title>LT-Forum</title>
</head>

<body>
    <div class="sidebar close">
        <div class="logo-details">
            <i class='bx bx-book'></i>
            <span class="logo_name">Learning Together</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="../home.php">
                    <i class='bx bx-home'></i>
                    <span class="link_name">Home</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../home.php">Home</a></li>
                </ul>
            </li>

            <li>
                <div class="iocn-link">
                    <a href="forum.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Forum</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="forum.php">Forum</a></li>
                    <li><a href="category.php">Category</a></li>
                    <li><a href="trending.php">Trending</a></li>
                </ul>
            </li>

            <li>
                <a href="../timeline/timeline.php">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="link_name">Timeline</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../timeline/timeline.php">Timeline</a></li>
                </ul>
            </li>
            <li>
                <a href="../materi/materi-list.php">
                    <i class='bx bx-buoy'></i>
                    <span class="link_name">Materi</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../materi/materi-list.php">Materi</a></li>
                </ul>
            </li>

            <li>
                <div class="iocn-link">
                    <a href="">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Customer Services</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Customer Service</a></li>
                    <li><a href="../CS/faqs.php">Faqs</a></li>
                    <li><a href="../CS/guidlines.php">Gudelines</a></li>
                </ul>
            </li>

        </ul>
    </div>
    <section class="section">
        <div class="content">
            <i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
            <span class="text"></span>
            <div id="boxes">
                <h1>Select Category</h1>
                <div class="list-container">
                    <?php foreach ($categories as $category) : ?>
                        <a href="category-forum.php?category_id=<?php echo $category['id_t_category']; ?>" class="button">
                            <?php echo $category['name']; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="container">
            <a href="../login.php" class="btn btn-login">Log In</a>
            <a href="../register.php" class="btn btn-register">Sign Up</a>
        </div>
    </section>

    <script src="../../js/script.js"></script>
</body>

</html>