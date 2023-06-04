<?php
session_start();
$user_id = $_SESSION['user_id'];
$token = $_SESSION['token'];

try {
    include '../db/db-connect.php';
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare('SELECT * FROM sessions WHERE user_id = :user_id AND token = :token');
    $stmt->execute(['user_id' => $user_id, 'token' => $token]);
    $session = $stmt->fetch();

    if (!$session) {
        header('Location: ../login.php');
        exit();
    }
    $stmt = $pdo->prepare('SELECT role FROM users WHERE id_user = :user_id');
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch();
} catch (PDOException $e) {
    die("Connection error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>LT-Timeline</title>
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/timeline.css">
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
                    <a href="../forum/log-forum.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Forum</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="../forum/log-forum.php">Forum</a></li>
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
                    <li><a class="link_name" href="../materi/log-materi-list.php">Materi</a></li>
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
                    <a href="../Profile/m-profile-settings.php">
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
            <?php if ($user['role'] === 'admin') { ?>
                <li>
                    <div class="iocn-link">
                        <a href="Admin/admin-menu.php">
                            <i class='bx bx-desktop'></i>
                            <span class="link_name">Admin Menu</span>
                        </a>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="../Admin/admin-menu.php">Admin Menu</a></li>
                    </ul>
                </li>
            <?php } ?>
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
        <a href="post-timeline.php" class="create-post-button">Create a Post</a>
        <div class="content">
            <i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
            <span class="text"></span>

            <?php
            include '../db/db-connect.php';
            function getComments($conn, $timeline_id)
            {
                $commentSql = "SELECT c.comments, u.username AS comment_username
                       FROM timeline_comments AS c
                       JOIN users AS u ON c.user_id = u.id_user
                       WHERE c.timeline_id = {$timeline_id}";
                $commentResult = mysqli_query($conn, $commentSql);

                $comments = array();
                while ($commentRow = mysqli_fetch_assoc($commentResult)) {
                    $comment = array(
                        'comment' => $commentRow['comments'],
                        'comment_username' => $commentRow['comment_username']
                    );
                    $comments[] = $comment;
                }

                return $comments;
            }
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $timeline_id = $_POST['timeline_id'];
                $comment = $_POST['comment'];
                $user_id = $_SESSION['user_id'];

                $timelineExistsSql = "SELECT id_timeline FROM timeline WHERE id_timeline = {$timeline_id}";
                $timelineExistsResult = mysqli_query($conn, $timelineExistsSql);

                if (mysqli_num_rows($timelineExistsResult) > 0) {
                    // Insert the comment into the timeline_comments table
                    $insertSql = "INSERT INTO timeline_comments (timeline_id, comments, user_id) VALUES ({$timeline_id}, '{$comment}', {$user_id})";
                    $insertResult = mysqli_query($conn, $insertSql);
                }
            }


            $sql = "SELECT t.id_timeline, t.user_id, t.description, u.username, u.users_image
            FROM timeline AS t
            JOIN users AS u ON t.user_id = u.id_user";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $timeline_id = $row['id_timeline'];
                    $user_id = $row['user_id'];
                    $username = $row['username'];
                    $description = $row['description'];
                    $profile_image = $row['users_image'];
                    echo "<div class='box'>";
                    echo "<div class='box-image'>";
                    echo "<img src='data:image/jpeg;base64," . base64_encode($profile_image) . "' alt='Profile Image' class='profile-image'>";
                    echo "</div>";
                    echo "<div class='box-content'>";
                    echo "<div class='box-title'>";
                    echo "<h3>{$username}</h3>";
                    echo "</div>";
                    echo "<div class='box-description'>";
                    echo "<p1>{$description}</p1>";
                    echo "</div>";

                    // Query untuk mendapatkan komentar dari table timeline_comments
                    $commentSql = "SELECT c.comments, u.username AS comment_username
                         FROM timeline_comments AS c
                         JOIN users AS u ON c.user_id = u.id_user
                         WHERE c.timeline_id = {$user_id}";
                    $commentResult = mysqli_query($conn, $commentSql);

                    $comments = getComments($conn, $timeline_id);

                    echo "<button onclick='toggleComments(this)' class='show-comment-button'>Show Comment</button>";
                    echo "<div class='box-comments' style='display: none;'>";
                    echo "<h4>Comment:</h4>";

                    foreach ($comments as $comment) {
                        $commentContent = $comment['comment'];
                        $commentUsername = $comment['comment_username'];
                        echo "<div class='comment'>";
                        echo "<span class='comment-username'>{$commentUsername}: </span>";
                        echo "<p>{$commentContent}</p>";

                        echo "</div>";
                    }
                    echo "<button onclick='toggleCommentForm(this)' class='add-comment-button'>Add Coment</button>";
                    echo "<div class='comment-form' style='display: none;'>";
                    echo "<form action='' method='POST'>";
                    echo "<textarea name='comment' placeholder='Masukkan komentar Anda' required></textarea>";
                    echo "<input type='hidden' name='timeline_id' value='{$timeline_id}'>";

                    if (isset($_SESSION['user_id'])) {
                        $sessionUserID = $_SESSION['user_id'];
                        echo "<input type='hidden' name='user_id' value='{$sessionUserID}'>";
                    }

                    echo "<button type='submit'>Kirim</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No timeline entries found.</p>";
            }
            mysqli_close($conn);
            ?>
        </div>
    </section>
    <script src="../../js/script.js"></script>

</body>

</html>