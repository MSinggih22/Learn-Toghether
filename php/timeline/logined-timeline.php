<?php
session_start();
$user_id = $_SESSION['user_id'];
$token = $_SESSION['token'];

try {
    include '../../db/database-connect.php';
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare('SELECT * FROM sessions WHERE user_id = :user_id AND token = :token');
    $stmt->execute(['user_id' => $user_id, 'token' => $token]);
    $session = $stmt->fetch();

    if (!$session) {
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
    <title>LT-Timeline</title>
    <link rel="stylesheet" href="../../css/timeline.css">
    <link rel="stylesheet" href="../../css/index.css">
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
                <a href="../home/home.php">
                    <i class='bx bx-home'></i>
                    <span class="link_name">Home</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../home/home.php">Home</a></li>
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
                    <li><a href="forum-category.php">Category</a></li>
                    <li><a href="forum-trending.php">Trending</a></li>
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
                <div class="iocn-link">
                    <a href="../customerservice/CS.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Customer Services</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Customer Service</a></li>
                    <li><a href="../customerservice/faqs.php">Faqs</a></li>
                    <li><a href="../customerservice/guidlines.php">Gudlines</a></li>
                    <li><a href="../customerservice/rules.php">Rules</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="../settings/settings.php">
                        <i class='bx bx-cog'></i>
                        <span class="link_name">Settings</span>
                    </a>
                </div>
                <ul class="sub-menu blank">
                    <li>
                        <a class="link_name" href="../settings/settings.php">Settings</a>
                    </li>
                </ul>
            </li>
            <?php
            $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :user_id');
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
            <div class="boxes">
                <?php
                include '../../db/database-connect.php';

                function getComments($conn, $timeline_id)
                {
                    $commentSql = "SELECT c.comments, u.username AS comment_username
                       FROM timeline_comments AS c
                       JOIN users AS u ON c.user_id = u.id
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

                    $timelineExistsSql = "SELECT id FROM timeline WHERE id = {$timeline_id}";
                    $timelineExistsResult = mysqli_query($conn, $timelineExistsSql);

                    if (mysqli_num_rows($timelineExistsResult) > 0) {
                        // Insert the comment into the timeline_comments table
                        $insertSql = "INSERT INTO timeline_comments (timeline_id, comments, user_id) VALUES ({$timeline_id}, '{$comment}', {$user_id})";
                        $insertResult = mysqli_query($conn, $insertSql);
                    }
                }

                $sql = "SELECT t.id, t.user_id, t.description, u.username, u.users_image
            FROM timeline AS t
            JOIN users AS u ON t.user_id = u.id";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $timeline_id = $row['id'];
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
                        echo "<p>{$description}</p>";
                        echo "</div>";

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

                        echo "<button onclick='toggleCommentForm(this)' class='add-comment-button'>Add Coment</button>";
                        echo "<div class='comment-form' style='display: none;'>";
                        echo "<h4>Comment:</h4>";
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
                    }
                } else {
                    echo "<p>No timeline entries found.</p>";
                }
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </section>




    <script>
        function toggleCommentForm(button) {
            var commentForm = button.nextElementSibling;
            if (commentForm.style.display === 'none') {
                commentForm.style.display = 'block';
                button.textContent = 'Close Comment';
            } else {
                commentForm.style.display = 'none';
                button.textContent = 'Add Coment :';
            }
        }

        function toggleComments(button) {
            var commentsDiv = button.nextElementSibling;
            if (commentsDiv.style.display === "none") {
                commentsDiv.style.display = "block";
                button.innerText = "Hide Comment";
            } else {
                commentsDiv.style.display = "none";
                button.innerText = "Show Comment";
            }
        }
        let arrow = document.querySelectorAll(".arrow");
        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e) => {
                let arrowParent = e.target.parentElement.parentElement;
                arrowParent.classList.toggle("showMenu");
                let mainContent = document.querySelector(".section");
                mainContent.classList.toggle("shifted");
            });
        }
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-chevron-right");
        console.log(sidebarBtn);
        sidebarBtn.addEventListener("click", () => {
            sidebar.classList.toggle("close");
            let mainContent = document.querySelector(".section");
            mainContent.classList.toggle("shifted");
        });

        function chonclick(element) {
            let currentClass = element.getAttribute("class");
            if (currentClass.includes("bx-chevron-right")) {
                element.setAttribute("class", "bx bx-chevron-left");
            } else {
                element.setAttribute("class", "bx bx-chevron-right");
            }
        }
    </script>
    <script src="../../js/script.js"></script>

</body>

</html>