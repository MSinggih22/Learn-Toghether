<?php
// Connect to the database (replace 'dbname', 'username', and 'password' with your own credentials)
include 'db/db-connect.php';

$connection = new mysqli($servername, $username, $password, $dbname);
if ($connection->connect_error) {
    die("Connection error: " . $connection->connect_error);
}
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query the database for the user with the given username and password
    $stmt = $connection->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    // Check if a user was found with the given username and password
    if ($user) {
        $token = bin2hex(random_bytes(16));
        $stmt = $connection->prepare('INSERT INTO sessions (user_id, token) VALUES (?, ?)');
        $stmt->bind_param('ss', $user['id_user'], $token);
        $stmt->execute();
        $stmt->close();

        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['token'] = $token;

        // Check if the logged-in user is an admin
        if ($user['role'] == 'admin') {
            // Redirect the admin to the admin menu
            header("Location: admin/admin-menu.php");
        } else {
            // Redirect the user to the inside page
            header("Location:log-home.php");
        }
        exit();
    } else {
        // Login failed
        echo '<script>alert("Invalid username or password");</script>';
        echo '<script>window.location.href = "login.php";</script>';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>LT-Login</title>
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
            <div class="login">
                <h2>Login</h2>
                <form action="login.php" method="post">
                    <input type="text" name="username" placeholder="Username" required="required" />
                    <input type="password" name="password" placeholder="Password" required="required" />
                    <p> Don't Have an Accoutn? <a href="register.php" class="account">Register Now!</a></p>
                    <input type="submit" name="login" value="Login">
                </form>
            </div>
        </div>
        </div>
        <script src="../js/script.js"></script>

</html>