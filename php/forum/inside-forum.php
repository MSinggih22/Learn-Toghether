<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forum</title>
    <link rel="stylesheet" href="../../css/inside-forums.css">
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
                <a href="index.html">
                    <i class='bx bx-home'></i>
                    <span class="link_name">Home</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="index.html">Home</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="index.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Forum</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Forum</a></li>
                    <li><a href="forum-category.php">Category</a></li>
                    <li><a href="#">Trending</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="link_name">Timeline</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Timeline</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Customer Services</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Customer Service</a></li>
                    <li><a href="#">Faqs</a></li>
                    <li><a href="#">Gudlines</a></li>
                    <li><a href="#">Rules</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class='bx bx-cog'></i>
                        <span class="link_name">Settings</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu blank">
                    <li>
                        <a class="link_name" href="#">Settings</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <section class="section">
        <div class="content">
            <i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
            <span class="text"></span>
            <div id="posts">
                <?php
                include '../../db/database-connect.php';

                $forumID = $_GET['id'];
                $commentStmt = $conn->prepare("SELECT COUNT(*) AS comment_count FROM topics_comments WHERE topic_id = ?");
                $commentStmt->bind_param("i", $forumID);
                $commentStmt->execute();
                $commentResult = $commentStmt->get_result();
                $commentRow = $commentResult->fetch_assoc();
                $commentCount = $commentRow['comment_count'];

                $viewsStmt = $conn->prepare("SELECT COUNT(*) AS views_count FROM topics_views WHERE topic_id = ?");
                $viewsStmt->bind_param("i", $forumID);
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


                $forumID = $_GET['id'];

                $stmt = $conn->prepare("SELECT * FROM topics WHERE id = ?");
                $stmt->bind_param("i", $forumID);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $img = $row["img"];

                    $authorID = $row['user_id'];
                    $authorStmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
                    $authorStmt->bind_param("i", $authorID);
                    $authorStmt->execute();
                    $authorResult = $authorStmt->get_result();
                    echo "<div class='content-boxes'>";
                    if ($authorResult->num_rows > 0) {
                        $authorRow = $authorResult->fetch_assoc();
                        echo "<div class='profile-box'>";
                        echo "<div class='profile-box-image'>";
                        echo "<img src='" . $authorRow['users_image'] . "' alt='Author Image'>";
                        echo "</div>";
                        echo "<div class='profile-box-name'>";
                        echo "<p class='username'>" . $authorRow['username'] . "</p>";
                        echo "</div>";
                        echo "<div class='profile-box-buttons'>";
                        echo "<p class='post-button bx bx-show'>" . $viewsCount . " </p>";
                        echo "<p class='post-button bx bx-comment'>" . $commentCount . " </p>";
                        echo "<p class='post-button bx bx-user-plus'>" . $followersCount . " </p>";
                        echo "<p class='created'>"  . "Time Posted: " . $row['created_at'] . " </p>";
                        echo "</div>";
                        echo "</div>";
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

                    $commentsStmt = $conn->prepare("SELECT tc.comment, tc.created_at, u.username, u.users_image FROM topics_comments tc INNER JOIN users u ON tc.user_id = u.id WHERE tc.topic_id = ?");
                    $commentsStmt->bind_param("i", $forumID);
                    $commentsStmt->execute();
                    $commentsResult = $commentsStmt->get_result();
                    $commentCount = $commentsResult->num_rows;

                    echo "<h3>Comments:</h3>";
                    echo "<div class='comments-boxes'>";

                    if ($commentCount > 0) {
                        echo "<div id='commentsContainer' class='content-box-comments'>";
                        $commentIndex = 0;

                        while ($commentRow = $commentsResult->fetch_assoc()) {
                            echo "<div class='comment'>";
                            echo "<div class='comment-user'>";
                            echo "<img src='" . $commentRow['users_image'] . "' alt='User Profile Image'>";
                            echo "<p>" . $commentRow['username'] . "</p>";
                            echo "</div>";
                            echo "<p class='comment-text'>" . $commentRow['comment'] . "</p>";
                            echo "</div>";
                        }

                        echo "</div>";
                    }
                    echo "<div class='comment-form'>";
                    echo "<h4>Add a Comment:</h4>";
                    echo "<form action='../login.php' method='POST'>";
                    echo "<input type='hidden' name='topic_id' value='" . $forumID . "'>";
                    echo "<textarea name='comment' placeholder='Enter your comment' required></textarea>";
                    echo "<button type='submit'>Submit</button>";
                    echo "</form>";
                    echo "</div>";
                } else {
                    echo "Forum not found.";
                }
                echo "</div>";
                echo "</div>";
                mysqli_close($conn);
                ?>
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

    <script src="js/script.js"></script>
    <script>
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
    </script>
</body>

</html>