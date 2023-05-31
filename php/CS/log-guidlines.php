<?php
session_start();
include '../db/db-connect.php';

$user_id = $_SESSION['user_id'];
$token = $_SESSION['token'];

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare('SELECT * FROM sessions WHERE user_id = :user_id AND token = :token');
    $stmt->execute(['user_id' => $user_id, 'token' => $token]);
    $session = $stmt->fetch();

    if (!$session) {
        // Invalid session, redirect to the login page
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
    <title>Learn Together</title>
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/css.css">
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
                    <li><a class="link_name" href="../log=home.php">Home</a></li>
                </ul>
            </li>

            <li>
                <div class="iocn-link">
                    <a href="../forum/log=forum.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Forum</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="../forum/log=forum.php">Forum</a></li>
                    <li><a href="../forum/log=category.php">Category</a></li>
                    <li><a href="../forum/log=trending.php">Trending</a></li>
                </ul>
            </li>

            <li>
                <a href="../timeline/timeline.php">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="link_name">Timeline</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../timeline/log=timeline.php">Timeline</a></li>
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
                    <li><a href="log=faqs.php">Faqs</a></li>
                    <li><a href="log=guidlines.php">Gudlines</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="../profile/m-profile-settings.phpp">
                        <i class='bx bx-cog'></i>
                        <span class="link_name">Settings</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="../profile/m-profile-settings.php">Settings</a></li>
                    <li><a href="../profile/m-profile-settings.php">Profile Settings</a></li>
                    <li><a href="../profile/m-forum-settings.php">Topics Setting</a></li>
                    <li><a href="../profile/m-timeline-settings.php">Timeline</a></li>
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
            <div id="boxes">
                <h2>Forum Guidelines</h2>
                <div class="guidlines-container">
                    <?php
                    include '../db/db-connect.php';
                    $sql = "SELECT * FROM Guidelines";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="guidlines-item">';
                            echo '<h3>' . $row["title"] . '</h3>';
                            echo '<p>' . $row["description"] . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo "Tidak ada guidelines yang tersedia.";
                    }
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </section>
    </section>
    <script src="../../js/script.js"></script>
</body>

</html>