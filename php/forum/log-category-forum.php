<?php
session_start();
include '../db/db-connect.php';

$user_id = $_SESSION['user_id'];
$token = $_SESSION['token'];

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare('SELECT * FROM sessions WHERE user_id = :user_id AND token = :token');
    $stmt->execute(['user_id' => $user_id, 'token' => $token]);
    $session = $stmt->fetch();

    if (!$session) {
        // Invalid session, redirect to the login page
        header('Location: index.html');
        exit();
    }
} catch (PDOException $e) {
    die("Connection error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Learn Together</title>
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/forum.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
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
            <a href="../materi/log-materi-list.php">
                <i class='bx bx-buoy'></i>
                <span class="link_name">Materi</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="../materi/log=materi-list.php">Materi</a></li>
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
                <li><a href="../CS/log-guidlines.php">Gudlines</a></li>
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
                <li><a href="../Profile/m-profile-settings.php">My Profile Settings</a></li>
                <li><a href="../Profile/m-forum-settings.php">My Forum Settings</a></li>
                <li><a href="../Profile/m-timeline-settings.php">My Timeline Settings</a></li>
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
        <div id="boxes">
            <?php
            include '../db/db-connect.php';
            $search = "";
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
            }
            $category_id = $_GET['category_id'];

            $sql = "SELECT t.*
                    FROM topics AS t
                    INNER JOIN relasi_topics_category AS rtc ON t.id_topics = rtc.topic_id
                    WHERE rtc.category_id = $category_id
                    GROUP BY t.id_topics
                    ORDER BY t.id_topics";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $img = $row["img"];
                    $topic_id = $row['id_topics'];
                    $topicID = $row['id_topics'];

                    $commentStmt = $conn->prepare("SELECT COUNT(*) AS comment_count FROM topics_comments WHERE topic_id = ?");
                    $commentStmt->bind_param("i", $topicID);
                    $commentStmt->execute();
                    $commentResult = $commentStmt->get_result();
                    $commentRow = $commentResult->fetch_assoc();
                    $commentCount = $commentRow['comment_count'];

                    $viewsStmt = $conn->prepare("SELECT COUNT(*) AS views_count FROM topics_views WHERE topic_id = ?");
                    $viewsStmt->bind_param("i", $topicID);
                    $viewsStmt->execute();
                    $viewsResult = $viewsStmt->get_result();
                    $viewsRow = $viewsResult->fetch_assoc();
                    $viewsCount = $viewsRow['views_count'];

                    $followersStmt = $conn->prepare("SELECT COUNT(*) AS followers_count FROM topics_followers WHERE topic_id = ?");
                    $followersStmt->bind_param("i", $topicID);
                    $followersStmt->execute();
                    $followersResult = $followersStmt->get_result();
                    $followersRow = $followersResult->fetch_assoc();
                    $followersCount = $followersRow['followers_count'];

                    echo "<div class='box'>";
                    echo "<div class='box-image'>";
                    echo "<img src='data:image/jpeg;base64," . base64_encode($img) . "' alt='Image description' class='box-image'>";
                    echo "</div>";
                    echo "<div class='box-content'>";
                    echo "<div class='box-title'>";
                    echo "<a href='inside-forum.php?id=" . $row['id_topics'] . "'>"; // Modify the anchor tag with the appropriate forum page URL
                    echo "<h2>" . $row['title'] . "</h2>";
                    echo "</a>";
                    echo "</div>";
                    echo "<div class='box-description'>";
                    echo "<p>" . $row['description'] . "</p>";
                    echo "</div>";
                    echo "</div>";
                    echo "<div class='box-buttons'>";
                    echo "<button class='box-button bx bx-show'>" . $viewsCount . " Views</button>";
                    echo "<button class='box-button bx bx-comment'>" . $commentCount . " Comments</button>";
                    echo "<button class='box-button bx bx-user-plus'>" . $followersCount . " Followers</button>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No topics found.</p>";
            }
            mysqli_close($conn);
            ?>
            <div class="pagenat" id="pagination">
                <button id="prevBtn" disabled>Prev</button>
                <button id="nextBtn">Next</button>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <a href="../login.php" class="btn btn-login">Log In</a>
    <a href="../register.php" class="btn btn-register">Sign Up</a>
</div>
<div class="search-container">
    <form action="#" method="GET">
        <input type="text" name="search" placeholder="Search...">
        <button type="submit"><i class="bx bx-search"></i></button>
    </form>
</div>
<script src="../../js/script.js"></script>
</body>

</html>