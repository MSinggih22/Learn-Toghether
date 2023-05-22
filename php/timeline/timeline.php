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

                        // Query untuk mendapatkan komentar dari table timeline_comments
                        $commentSql = "SELECT c.comments, u.username AS comment_username
                         FROM timeline_comments AS c
                         JOIN users AS u ON c.user_id = u.id
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
                    }
                } else {
                    echo "<p>No timeline entries found.</p>";
                }
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </section>
    <div class="container">
        <a href="../login.php" class="btn btn-login">Log In</a>
        <a href="../register.php" class="btn btn-register">Sign Up</a>
    </div>
    <script>
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
        ow = document.querySelectorAll(".arrow");
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