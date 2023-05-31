<?php
include 'db/db-connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirmpassword"];

    if ($password !== $confirm_password) {
        echo '<script>alert("Passwords do not match.");</script>';
        echo '<script>window.location.href = "register.php";</script>';
    }

    $stmt = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
    $stmt->execute([$username, $email, $password]);

    echo '<script>window.location.href = "forum/forum.php";</script>';
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>LT-Register</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/login.css">

    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="sidebar close">
        <div class="logo-details">
            <i class='bx bx-book'></i>
            <span class="logo_name">Learning Together</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="home.php">
                    <i class='bx bx-home'></i>
                    <span class="link_name">Home</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="home.php">Home</a></li>
                </ul>
            </li>

            <li>
                <div class="iocn-link">
                    <a href="forum/forum.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Forum</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="forum/forum.php">Forum</a></li>
                    <li><a href="forum/category.php">Category</a></li>
                    <li><a href="forum/trending.php">Trending</a></li>
                </ul>
            </li>

            <li>
                <a href="timeline/timeline.php">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="link_name">Timeline</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="timeline/timeline.php">Timeline</a></li>
                </ul>
            </li>
            <li>
                <a href="materi/materi-list.php">
                    <i class='bx bx-buoy'></i>
                    <span class="link_name">Materi</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="materi/materi-list.php">Materi</a></li>
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
                    <li><a href="CS/faqs.php">Faqs</a></li>
                    <li><a href="CS/guidlines.php">Gudelines</a></li>
                </ul>
            </li>

        </ul>
    </div>
    <section class="section">
        <div class="content">
            <i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
            <span class="text"></span>
            <div class="register">
                <h1>Create an account</h1>
                <form class="form" action="#" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="alert alert-error"></div>
                    <input type="text" placeholder="User Name" name="username" required />
                    <input type="email" placeholder="Email" name="email" required />
                    <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
                    <input type="password" placeholder="Confirm Password" name="confirmpassword" autocomplete="new-password" required />
                    <p> Already Have An Account? <a href="login.php" class="account">Login!</a></p>
                    <input type="submit" value="Register" name="register" class="btn btn-block btn-primary" />
                </form>
            </div>
        </div>
        </div>
        <script src="../js/script.js"></script>
</body>

</html>