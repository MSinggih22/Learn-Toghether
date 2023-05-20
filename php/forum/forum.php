<!DOCTYPE html>
<html lang="en">

<head>
    <title>Learn Together</title>
    <link rel="stylesheet" href="../../css/forum.css">
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
            <div id="boxes">
                <?php
                include '../../db/database-connect.php';

                $search = "";
                if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                }

                $sql = "SELECT * FROM topics WHERE title LIKE '%$search%'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $img = $row["img"];
                        $topic_id = $row['id'];
                        $topicID = $row['id'];

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
                        echo "<a href='inside-forum.php?id=" . $row['id'] . "'>"; // Modify the anchor tag with the appropriate forum page URL
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
    <Script>
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
    </Script>

</body>

</html>