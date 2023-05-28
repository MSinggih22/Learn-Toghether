<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['token'])) {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$token = $_SESSION['token'];

include '../db/db-connect.php';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare('SELECT * FROM sessions WHERE user_id = :user_id AND token = :token');
    $stmt->execute(['user_id' => $user_id, 'token' => $token]);
    $session = $stmt->fetch();

    if (!$session) {
        header('Location: ../login.php');
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
    <link rel="stylesheet" href="../../css/inside-forum.css">
    <link rel="stylesheet" href="../../css/main.css">
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
            <div id="posts">
                <?php
                $stmt = $conn->prepare("SELECT COUNT(*) AS comment_count FROM topics_comments WHERE topic_id = ?");
                $stmt->bind_param("i", $topicID);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $commentCount = $row['comment_count'];

                $forumID = $_GET['id'];

                $stmt = $conn->prepare("SELECT * FROM topics WHERE id_topics = ?");
                $stmt->bind_param("i", $forumID);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $img = $row["img"];
                    $topicID = $row['id_topics'];
                    $authorID = $row['user_id'];
                    $authorStmt = $conn->prepare("SELECT * FROM users WHERE id_user = ?");
                    $authorStmt->bind_param("i", $authorID);
                    $authorStmt->execute();
                    $authorResult = $authorStmt->get_result();
                    echo "<div class='content-boxes'>";
                    if ($authorResult->num_rows > 0) {
                        $authorRow = $authorResult->fetch_assoc();
                        echo "<div class='profile-box'>";
                        echo "<div class='profile-box-image'>";
                        echo "<img src='data:image/jpeg;base64," . base64_encode($authorRow['users_image']) . "' alt='authorImage' class='profile-image'>";
                        echo "</div>";
                        echo "<div class='profile-box-name'>";
                        echo "<p class='username'>" . $authorRow['username'] . "</p>";
                        echo "</div>";
                        echo "<div class='profile-box-buttons'>";

                        $commentStmt = $conn->prepare("SELECT COUNT(*) AS comment_count FROM topics_comments WHERE topic_id = ?");
                        $commentStmt->bind_param("i", $topicID);
                        $commentStmt->execute();
                        $commentResult = $commentStmt->get_result();
                        $commentRow = $commentResult->fetch_assoc();
                        $commentCount = $commentRow['comment_count'];

                        $currentUserID = $user_id;
                        $viewsStmt = $conn->prepare("SELECT COUNT(*) AS views_count FROM topics_views WHERE topic_id = ?");
                        $viewsStmt->bind_param("i", $topicID);
                        $viewsStmt->execute();
                        $viewsResult = $viewsStmt->get_result();

                        $followersStmt = $conn->prepare("SELECT COUNT(*) AS followers_count FROM topics_followers WHERE topic_id = ?");
                        $followersStmt->bind_param("i", $topicID);
                        $followersStmt->execute();
                        $followersResult = $followersStmt->get_result();
                        $followersRow = $followersResult->fetch_assoc();
                        $followersCount = $followersRow['followers_count'];

                        if ($viewsResult->num_rows > 0) {
                            $viewsRow = $viewsResult->fetch_assoc();
                            $viewsCount = $viewsRow['views_count'];
                        } else {
                            $viewsCount = 0;
                        }

                        echo "<p class='post-button bx bx-show'>" . $viewsCount . " </p>";
                        echo "<p class='post-button bx bx-comment'>" . $commentCount . " </p>";
                        echo "<p class='post-button bx bx-user-plus'>" . $followersCount . " </p>";
                        echo "<form method='post'>";
                        echo "<button type='submit' name='follow-button'>";
                        $userId = $_SESSION['user_id'];
                        $topicId = $topicID;
                        $checkQuery = "SELECT * FROM topics_followers WHERE user_id = ? AND topic_id = ?";
                        $checkStmt = $conn->prepare($checkQuery);
                        $checkStmt->bind_param("ii", $userId, $topicId);
                        $checkStmt->execute();
                        $checkResult = $checkStmt->get_result();

                        if (mysqli_num_rows($checkResult) > 0) {
                            $action = "unfollow";
                            $buttonText = "Unfollow";
                        } else {
                            $action = "follow";
                            $buttonText = "+ Follow";
                        }

                        echo $buttonText;
                        echo "<input type='hidden' name='action' value='$action'>";
                        echo "</button>";
                        echo "</form>";
                        echo "<p class='created'>" . "Time Posted: " . $row['created_at'] . " </p>";
                        echo "</div>";
                        echo "</div>";

                        if (isset($_POST['action'])) {
                            $action = $_POST['action'];
                            $userId = $_SESSION['user_id'];
                            $topicId = $topicID;

                            if ($action == 'follow') {
                                $insertQuery = "INSERT INTO topics_followers (user_id, topic_id, followed_at) VALUES (?, ?, NOW())";
                                $insertStmt = $conn->prepare($insertQuery);
                                $insertStmt->bind_param("ii", $userId, $topicId);
                                if ($insertStmt->execute()) {
                                    echo "<script>window.location.href = 'log-forum.php';</script>";
                                } else {
                                    echo "Terjadi kesalahan: " . mysqli_error($conn);
                                }
                            } elseif ($action == 'unfollow') {
                                $deleteQuery = "DELETE FROM topics_followers WHERE user_id = ? AND topic_id = ?";
                                $deleteStmt = $conn->prepare($deleteQuery);
                                $deleteStmt->bind_param("ii", $userId, $topicId);
                                if ($deleteStmt->execute()) {
                                    echo "<script>window.location.href = 'log-forum.php';</script>";
                                } else {
                                    echo "Terjadi kesalahan: " . mysqli_error($conn);
                                }
                            }
                        }

                        $checkStmt = $conn->prepare("SELECT * FROM topics_views WHERE topic_id = ? AND user_id = ?");
                        $checkStmt->bind_param("ii", $topicID, $currentUserID);
                        $checkStmt->execute();
                        $checkResult = $checkStmt->get_result();

                        if ($checkResult->num_rows === 0) {
                            $addViewStmt = $conn->prepare("INSERT INTO topics_views (topic_id, user_id) VALUES (?, ?)");
                            $addViewStmt->bind_param("ii", $topicID, $currentUserID);
                            $addViewStmt->execute();
                        }
                    }
                    echo "<div class='content-box'>";
                    echo "<div class='post-content'>";
                    echo "<div class='content-box-title'>";
                    echo "<h2>" . $row['title'] . "</h2>";
                    echo "</div>";
                    echo "<div class='content-box-description'>";
                    echo "<p>" . $row['description'] . "</p>";
                    echo "</div>";
                    echo "<div class='content-box-image'>";
                    echo "<img src='data:image/jpeg;base64," . base64_encode($img) . "' alt='Image description' class='post-image'>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";

                    $commentsStmt = $conn->prepare("SELECT tc.comment, tc.created_at, u.username, u.users_image FROM topics_comments tc INNER JOIN users u ON tc.user_id = u.id_user WHERE tc.topic_id = ?");
                    $commentsStmt->bind_param("i", $forumID);
                    $commentsStmt->execute();
                    $commentsResult = $commentsStmt->get_result();
                    $commentCount = $commentsResult->num_rows;


                    // Display comments
                    echo "<h3>Comments:</h3>";
                    echo "<div class='comments-boxes'>";

                    if ($commentCount > 0) {
                        echo "<div id='commentsContainer' class='content-box-comments'>";
                        $commentIndex = 0;

                        while ($commentRow = $commentsResult->fetch_assoc()) {
                            echo "<div class='comment'>";
                            echo "<div class='comment-user'>";
                            echo "<img src='data:image/jpeg;base64," . base64_encode($commentRow['users_image']) . "' alt='commentImage' class='profile-image'>";
                            echo "<p>" . $commentRow['username'] . "</p>";
                            echo "</div>";
                            echo "<p class='comment-text'>" . $commentRow['comment'] . "</p>";
                            echo "</div>";
                        }

                        echo "</div>";
                    }

                    // Display comment form
                    echo "<div class='comment-form'>";
                    echo "<h4>Add a Comment:</h4>";
                    echo "<form action='" . $_SERVER["PHP_SELF"] . "?id=" . $forumID . "' method='POST' onsubmit='return confirm(\"Are you sure you want to submit this comment?\");'>";
                    echo "<input type='hidden' name='topic_id' value='" . $forumID . "'>";
                    echo "<textarea name='comment' placeholder='Enter your comment' required></textarea>";
                    echo "<button type='submit'>Submit</button>";
                    echo "</form>";
                    echo "</div>";

                    // Check if the form is submitted
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Get the form data
                        $topicID = $_POST['topic_id'];
                        $userID = $_SESSION['user_id'];
                        $comment = $_POST['comment'];
                        $createdAt = date("Y-m-d H:i:s");

                        $stmt = $conn->prepare("INSERT INTO topics_comments (user_id, topic_id, comment, created_at) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("iiss", $userID, $topicID, $comment, $createdAt);
                        if ($stmt->execute()) {
                            echo "<p>Comment added successfully.</p>";
                            // Redirect to the same page to avoid resubmission on page refresh
                            echo "<script>window.location.href = '" . $_SERVER["PHP_SELF"] . "?id=" . $forumID . "';</script>";
                            exit();
                        } else {
                            echo "<p>Error: " . $stmt->error . "</p>";
                        }
                    }
                } else {
                    echo "<p>Forum not found.</p>";
                }
                echo "</div>";
                echo "</div>";
                $conn->close();
                ?>
            </div>
        </div>
    </section>
    <script src="../../js/script.js"></script>
</body>

</html>