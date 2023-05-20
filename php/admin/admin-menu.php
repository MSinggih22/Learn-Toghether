<!DOCTYPE html>
<html lang="en">

<head>
    <title>Learn Together</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/admin-menu.css">
</head>

<body>
    <div class="sidebar close">
        <div class="logo-details">
            <i class='bx bx-book'></i>
            <span class="logo_name">LT-Admin Menu</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="admin-menu.php">
                    <i class='bx bx-home'></i>
                    <span class="link_name">Dasboard</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="admin-menu.php">Dasboard</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="topics-admin.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Forum</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="topics-admin.php">Forum Settings</a></li>
                    <li><a href="topics-update.php">Update Topics</a></li>
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
            <h1>Dashboard</h1>
            <i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
            <div id="boxes">
                <?php
                include '../../db/database-connect.php';
                // Count the number of users
                $query = "SELECT COUNT(*) as user_count FROM users";
                $result = mysqli_query($conn, $query);
                $userCount = mysqli_fetch_assoc($result)['user_count'];

                // Count the number of posted topics
                $query = "SELECT COUNT(*) as topic_count FROM topics";
                $result = mysqli_query($conn, $query);
                $topicCount = mysqli_fetch_assoc($result)['topic_count'];

                mysqli_close($conn);
                ?>
                <div class="dash-users">
                    <h2 class="bx bx-user"> User :</h2>
                    <h3><?php echo $userCount; ?></h2>
                </div>
                <div class="dash-topics">
                    <h2 class="bx bx-detail"> Topics :</h2>
                    <h3><?php echo $topicCount; ?></h2>
                </div>
                <div class="dash-comments">
                    <h2 class="bx bx-comment"> Comment :</h2>
                    <h3><?php echo $userCount; ?></h2>
                </div>
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