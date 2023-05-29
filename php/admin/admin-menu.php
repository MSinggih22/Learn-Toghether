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
    <title>Learn Together-Admin Menu</title>
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
                    <a href="settings/user-settings.php">
                        <i class='bx bx-user'></i>
                        <span class="link_name">Users Settings</span>
                    </a>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="settings/user-settings.php">Users Settings</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="settings/forum-settings.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Forum</span>
                    </a>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="settings/forum-settings.php">Forum Settings</a></li>
                </ul>
            </li>
            <li>
                <a href="settings/timeline-settings.php">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="link_name">Timeline Settings</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="settings/timeline-settings.php">Timeline Settings</a></li>
                </ul>
            </li>
            <li>
                <a href="settings/materi-settings.php">
                    <i class='bx bx-buoy'></i>
                    <span class="link_name">Materi Settings</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="settings/materi-settings.php">Materi Settings</a></li>
                </ul>
            </li>
            <li>
                <a href="settings/faq-settings.php">
                    <i class='bx bx-message'></i>
                    <span class="link_name">Faq Settings</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="settings/faq-settings.php">Faq Settings</a></li>
                </ul>
            </li>
            <li>
                <a href="settings/guidlines-settings.php">
                    <i class='bx bx-news'></i>
                    <span class="link_name">Guidlines Settings</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="settings/guidlines-settings.php">Guidlines Settings</a></li>
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
    <div class="section">
        <div class="content">
            <h1>Dashboard</h1>
            <i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
            <div id="boxes">
                <?php
                include '../db/db-connect.php';
                // Count the number of users
                $query = "SELECT COUNT(*) as user_count FROM users";
                $result = mysqli_query($conn, $query);
                $userCount = mysqli_fetch_assoc($result)['user_count'];

                // Count the number of posted topics
                $query = "SELECT COUNT(*) as topic_count FROM topics";
                $result = mysqli_query($conn, $query);
                $topicCount = mysqli_fetch_assoc($result)['topic_count'];

                $query = "SELECT COUNT(*) as timeline_count FROM timeline";
                $result = mysqli_query($conn, $query);
                $timelinecount = mysqli_fetch_assoc($result)['timeline_count'];

                $query = "SELECT COUNT(*) as materi_count FROM materi";
                $result = mysqli_query($conn, $query);
                $matericount = mysqli_fetch_assoc($result)['materi_count'];


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
                    <h2 class="bx bx-comment"> Timeline:</h2>
                    <h3><?php echo $timelinecount; ?></h2>
                </div>
                <div class="dash-comments">
                    <h2 class="bx bx-book"> Materi:</h2>
                    <h3><?php echo $matericount; ?></h2>
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