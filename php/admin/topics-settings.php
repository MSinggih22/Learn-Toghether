<!DOCTYPE html>
<html lang="en">

<head>
    <title>Learn Together</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../css/index.css">
    <link rel="stylesheet" href="../../css/forum.css">
</head>
<body>
    <div class="sidebar close">
        <div class="logo-details">
            <i class='bx bx-book'></i>
            <span class="logo_name">Learning Together Admin Menu</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="index.html">
                    <i class='bx bx-home'></i>
                    <span class="link_name">Dasboadr</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="index.html">Dasboard</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="index.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Forum Settings</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="topics-settings.php">Topics Setting</a></li>
                    <li><a href="comment-setting.php>Comment Settings</a></li>
                    <li><a href="">Views Settings</a></li>
                    <li><a href=" #">Follower Settings</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="link_name">Timeline-Settings</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Timeline-Settings</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Users Settings</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Users Settings</a></li>
                    <li><a href="#">Delete User</a></li>
                    <li><a href="#">Edit User Profile</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="section">
        <div class="content">
            <i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
            <div id="boxes">
                <?php
                require_once '../database-connect.php';
                // Fungsi untuk mendapatkan semua pengaturan dari tabel topics
                function getTopicsSettings()
                {
                    global $conn;
                    $query = "SELECT * FROM topics";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "ID: " . $row["id"] . "<br>";
                            echo "User ID: " . $row["user_id"] . "<br>";
                            echo "Title: " . $row["title"] . "<br>";
                            echo "Description: " . $row["description"] . "<br>";
                            echo "Views: " . $row["views"] . "<br>";
                            echo "Comments: " . $row["comments"] . "<br>";
                            echo "Followers: " . $row["followers"] . "<br>";
                            echo "Image: <img src=''><br>";
                            echo "Created At: " . $row["created_at"] . "<br><br>";
                            echo "<a href='?delete=" . $row["id"] . "' onclick='return confirmDelete()'>Delete</a><br><br>";
                        }
                    } else {
                        echo "No topics found.";
                    }

                    if (isset($_GET['delete'])) {
                        $topicId = $_GET['delete'];

                        // Delete topic from the database
                        $query = "DELETE FROM topics WHERE id = $topicId";
                        mysqli_query($conn, $query);

                        // Display success message
                        echo "Topic deleted successfully.";
                    }
                }
                function getTopicsCommentsSettings()
                {
                    global $conn;
                    $query = "SELECT * FROM topics_comments";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "ID: " . $row["id"] . "<br>";
                            echo "User ID: " . $row["user_id"] . "<br>";
                            echo "Topic ID: " . $row["topic_id"] . "<br>";
                            echo "Comment: " . $row["comment"] . "<br>";
                            echo "Created At: " . $row["created_at"] . "<br><br>";
                            echo "<a href='delete/delete-comments.php?id=" . $row["id"] . "'>Delete</a><br><br>";
                        }
                    } else {
                        echo "No comments found.";
                    }
                }

                // Fungsi untuk mendapatkan semua pengaturan dari tabel topic_views
                function getTopicViewsSettings()
                {
                    global $conn;
                    $query = "SELECT * FROM topic_views";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "ID: " . $row["id"] . "<br>";
                            echo "User ID: " . $row["user_id"] . "<br>";
                            echo "Topic ID: " . $row["topic_id"] . "<br>";
                            echo "Viewed At: " . $row["viewed_at"] . "<br><br>";
                            echo "<a href='delete/delete-view.php?id=" . $row["id"] . "'>Delete</a><br><br>";
                        }
                    } else {
                        echo "No views found.";
                    }
                }

                function getSessionsSettings()
                {
                    global $conn;
                    $query = "SELECT * FROM sessions";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "ID: " . $row["id"] . "<br>";
                            echo "User ID: " . $row["user_id"] . "<br>";
                            echo "Token: " . $row["token"] . "<br><br>";
                            echo "<a href='delete_session.php?id=" . $row["id"] . "'>Delete</a><br><br>";
                        }
                    } else {
                        echo "No sessions found.";
                    }
                }
                function displayAllSettings()
                {
                    echo "<h2>Topics Settings</h2>";
                    getTopicsSettings();

                    echo "<h2>Topics Comments Settings</h2>";
                    getTopicsCommentsSettings();

                    echo "<h2>Topic Views Settings</h2>";
                    getTopicViewsSettings();

                    echo "<h2>Sessions Settings</h2>";
                    getSessionsSettings();
                }
                function isAdminLoggedIn()
                {
                    session_start();
                    if (isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] === true) {
                        return true;
                    } else {
                        return false;
                    }
                }
                if (isAdminLoggedIn()) {
                    displayAllSettings();
                } else {
                    header("Location: admin_login.php");
                    exit();
                }
                mysqli_close($conn);
                ?>
            </div>
        </div>
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