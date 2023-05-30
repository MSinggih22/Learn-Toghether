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
                    <a href="../forum/forum.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Forum</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="../forum/forum.php">Forum</a></li>
                    <li><a href="../forum/category.php">Category</a></li>
                    <li><a href="../forum/trending.php">Trending</a></li>
                </ul>
            </li>

            <li>
                <a href="timeline.php">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="link_name">Timeline</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="timeline.php">Timeline</a></li>
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
                    <li><a href="../CS/guidlines.php">Gudlines</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <section class="section">
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

                    if (!empty($comments)) {
                        echo "<button onclick='toggleComments(this)' class='show-comment-button'>Show Comment</button>";
                        echo "<div class='box-comments' style='display: none;'>";
                        foreach ($comments as $comment) {
                            $commentContent = $comment['comment'];
                            $commentUsername = $comment['comment_username'];
                            echo "<div class='comment'>";
                            echo "<p>Comment:</p>";
                            echo "<span class='comment-username'>{$commentUsername}: </span>";
                            echo "<p>{$commentContent}</p>";
                            echo "</div>";
                        }
                        echo "</div>";
                    } else {
                        echo "<div class='box-comments' style='display: none;'></div>";
                    }
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
    <div class="container">
        <a href="../login.php" class="btn btn-login">Log In</a>
        <a href="../register.php" class="btn btn-register">Sign Up</a>
    </div>
    <script src="../../js/script.js"></script>

</body>

</html>