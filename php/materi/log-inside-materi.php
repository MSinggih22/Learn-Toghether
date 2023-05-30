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
    <title>Forum</title>
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/inside-materis.css">
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
                    <a href="forum.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Forum</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="forum.php">Forum</a></li>
                    <li><a href="category.php">Category</a></li>
                    <li><a href="trending.php">Trending</a></li>
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
                    <li><a class="link_name" href="../materi/log-materi-list.php">Materi</a></li>
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
                    <li><a href="./CS/log-guidlines.php">Gudlines</a></li>
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

            <div id="boxes">
                <?php
                include '../db/db-connect.php';

                if (isset($_GET['id'])) {
                    $materiId = $_GET['id'];

                    // Query untuk mendapatkan informasi materi dan profil pengajar berdasarkan ID materi
                    $sql = "SELECT m.*, p.nama, p.pekerjaan, p.instagram, p.youtube
        FROM Materi m
        INNER JOIN ProfilePengajar p ON m.id_pengajar = p.id_pengajar
        WHERE m.id_materi = $materiId";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $title = $row['title_materi'];
                        $description = $row['description'];
                        $linkVideo = $row['link_video'];
                        $idPengajar = $row['id_pengajar'];

                        // Query untuk mendapatkan informasi profil pengajar berdasarkan ID pengajar
                        $sqlProfile = "SELECT nama, pekerjaan, instagram, youtube
               FROM ProfilePengajar
               WHERE id_pengajar = $idPengajar";
                        $resultProfile = mysqli_query($conn, $sqlProfile);

                        if (mysqli_num_rows($resultProfile) > 0) {
                            $rowProfile = mysqli_fetch_assoc($resultProfile);
                            $namaPengajar = $rowProfile['nama'];
                            $pekerjaan = $rowProfile['pekerjaan'];
                            $instagram = $rowProfile['instagram'];
                            $youtube = $rowProfile['youtube'];

                            // Tampilkan informasi materi dan profil pengajar
                            echo "<div class='content-box'>";
                            echo "<h1>$title</h1>";
                            echo "<p>$description</p>";
                            echo "<div class='video-container'>";
                            echo '<div id="player-' . $materiId . '"></div>';
                            echo "</div>";
                            echo "</div>";

                            echo "<div class='profile-box'>";
                            echo "<h2>Profile Pengajar</h2>";
                            echo "<p>Nama: $namaPengajar</p>";
                            echo "<p>Pekerjaan: $pekerjaan</p>";
                            echo "<p>Instagram: <a href='../new-page.php?url=$instagram' target='_blank'>$instagram</a></p>";
                            echo "<p>YouTube: <a href='../new-page.php?url=$youtube' target='_blank'>$youtube</a></p>";
                            echo "</div>";
                        } else {
                            echo "<p>Profil pengajar tidak ditemukan.</p>";
                        }
                    } else {
                        echo "<p>Materi tidak ditemukan.</p>";
                    }
                } else {
                    echo "<p>ID materi tidak valid.</p>";
                }

                mysqli_close($conn);
                ?>
            </div>
        </div>
    </section>
    <script>
        // Automatically play the video when the page is loaded
        document.addEventListener('DOMContentLoaded', function() {
            var videoId = "<?php echo $linkVideo; ?>";
            var materiId = "<?php echo $materiId; ?>";
            var playerId = "player-" + materiId;
            playVideo(playerId, videoId);
        });
    </script>
    <script src="../../js/script.js"></script>
</body>

</html>