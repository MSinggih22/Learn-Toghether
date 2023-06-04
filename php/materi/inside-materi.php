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
                <a href="../timeline/timeline.php">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="link_name">Timeline</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../timeline/timeline.php">Timeline</a></li>
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
                            echo "<h2>Profil Pengajar</h2>";
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
        document.addEventListener('DOMContentLoaded', function() {
            var videoId = "<?php echo $linkVideo; ?>";
            var materiId = "<?php echo $materiId; ?>";
            var playerId = "player-" + materiId;
            playVideo(playerId, videoId);
        });
    </script>
    <script src="../../js/script.js"></script>
    <div class="container">
        <a href="../login.php" class="btn btn-login">Log In</a>
        <a href="../register.php" class="btn btn-register">Sign Up</a>
    </div>
</body>

</html>