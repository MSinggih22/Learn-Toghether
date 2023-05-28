<?php
session_start();
include '../db/db-connect.php';

// Get the user ID and session token from the session
$user_id = $_SESSION['user_id'];
$token = $_SESSION['token'];

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the SQL statement to fetch the session from the sessions table
    $stmt = $pdo->prepare('SELECT * FROM sessions WHERE user_id = :user_id AND token = :token');
    $stmt->execute(['user_id' => $user_id, 'token' => $token]);
    $session = $stmt->fetch();

    if (!$session) {
        // Invalid session, redirect to the login page
        header('Location: ../login.html');
        exit();
    }
} catch (PDOException $e) {
    die("Connection error: " . $e->getMessage());
}
?>
<?php

if (!isset($_SESSION['user_id']) || !isset($_SESSION['token'])) {
    header('Location: ../login.php');
    exit();
}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $img = addslashes(file_get_contents($_FILES['img']['tmp_name']));

    $user_id = $_SESSION['user_id'];

    $categories = $_POST['category'];

    $followers = 0;

    $sql = "INSERT INTO topics (user_id, title, description,  followers, img, created_at) 
            VALUES ('$user_id', '$title', '$description', '$followers', '$img', NOW())";
    mysqli_query($conn, $sql);

    $topic_id = mysqli_insert_id($conn);

    foreach ($categories as $category_id) {
        $sql = "INSERT INTO relasi_topics_category (topic_id, category_id) VALUES ('$topic_id', '$category_id')";
        mysqli_query($conn, $sql);
    }

    mysqli_close($conn);

    header("Location: log-forum.php");
    exit();
}

$sql = "SELECT * FROM topics_category";
$result = mysqli_query($conn, $sql);

$categories = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
}

$loggedInUser = $_SESSION['user_id'];
$loggedinUsername = "";


// Retrieve the username of the logged in user
$sql = "SELECT username FROM users WHERE id_user = '$loggedInUser'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $loggedinUsername = $row['username'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forum</title>
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/post.css">

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
                <a href="../log-home.php">
                    <i class='bx bx-home'></i>
                    <span class="link_name">Home</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../log-home.php">Home</a></li>
                </ul>
            </li>

            <li>
                <div class="iocn-link">
                    <a href="log-forum.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Forum</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="log-forum.php">Forum</a></li>
                    <li><a href="log-category.php">Category</a></li>
                    <li><a href="log-trending.php">Trending</a></li>
                </ul>
            </li>

            <li>
                <a href="../timeline/log-timeline.php">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="link_name">Timeline</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../timeline/log-timeline.php">Timeline</a></li>
                </ul>
            </li>
            <li>
                <a href="">
                    <i class='bx bx-buoy'></i>
                    <span class="link_name">Materi</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="">Materi</a></li>
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
                    <li><a href="../CS/log-faqs.php">Faqs</a></li>
                    <li><a href="./CS/log-guidlines.php">Gudlines</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="../settings/settings.php">
                        <i class='bx bx-cog'></i>
                        <span class="link_name">Settings</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Settings</a></li>
                    <li><a href="../settings/profile-settings.php">Profile Settings</a></li>
                    <li><a href="../settings/forum-settings.php">Topics Setting</a></li>
                    <li><a href="../settings/account-settings.php">Account Settings</a></li>
                </ul>
            </li>

            <?php
            $stmt = $pdo->prepare('SELECT * FROM users WHERE id_user = :user_id');
            $stmt->execute(['user_id' => $user_id]);
            $user = $stmt->fetch();
            if ($user) {
                echo "<div class='profile-details'>";
                echo "<div class='profile-details'>";
                echo "<div class='profile-content'>";
                echo "<img src='data:image/jpeg;base64," . base64_encode($user['users_image']) . "' alt='profileImage' class='profile-image'>";
                echo "</div>";
                echo "<div class='name-job'>";
                echo "<div class='profile_name'>";
                echo "<h2>" . $user['username'] . "</h2>";
                echo "</div>";
                echo  "</div>";
                echo "<a class='bx bx-log-out logout-button' href='../logout.php'></a>";
                echo  "</div>";
                echo "</div>";
                echo "</li>";
            } else {
                echo "<p>Unable to fetch wuser data.</p>";
            }
            ?>
        </ul>
    </div>
    <section class="section">
        <div class="content">
            <i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
            <span class="text"></span>
            <div class="post">
                <form class="form-container" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to submit?');">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description"></textarea>

                    <label for="category">Category:</label>
                    <?php foreach ($categories as $category) : ?>
                        <label>
                            <input type="checkbox" name="category[]" value="<?php echo $category['id_t_category']; ?>">
                            <?php echo $category['name']; ?>
                        </label>
                    <?php endforeach; ?>
                    <label for="img">Select img:</label>
                    <input type="file" name="img" id="img">
                    <button type="submit" name="submit">Add</button>
                </form>
            </div>
        </div>
    </section>
    <script src="../../js/script.js"></script>

</body>

</html>