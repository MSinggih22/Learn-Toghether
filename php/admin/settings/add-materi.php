<?php
include '../../db/db-connect.php';
session_start();
$user_id = $_SESSION['user_id'];
$token = $_SESSION['token'];

try {
    include '../../db/db-connect.php';
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

if (isset($_POST['submit'])) {
    // Ambil data yang diisi dari form
    $title_materi = $_POST['title_materi'];
    $description = $_POST['description'];
    $link_video = $_POST['link_video'];
    $nama = $_POST['nama'];

    // Cari id_pengajar berdasarkan nama
    $query = "SELECT id_pengajar FROM profilepengajar WHERE nama = '$nama'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $id_pengajar = $row['id_pengajar'];

    // Insert data materi ke tabel materi
    $query = "INSERT INTO materi (title_materi, description, link_video, id_pengajar) 
              VALUES ('$title_materi', '$description', '$link_video', '$id_pengajar')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Informasikan pengguna bahwa materi telah ditambahkan
        echo "Materi telah ditambahkan.";
        header("Location: materi-settings.php");
        exit();
    } else {
        // Tampilkan pesan kesalahan jika terjadi masalah dalam menambahkan materi
        echo "Terjadi kesalahan. Silakan coba lagi.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Learn Together-Admin Menu</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../../css/main.css">
    <link rel="stylesheet" href="../../../css/admin-settings.css">
</head>

<body>
    <div class="sidebar close">
        <div class="logo-details">
            <i class='bx bx-book'></i>
            <span class="logo_name">LT-Admin Menu</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="../admin-menu.php">
                    <i class='bx bx-home'></i>
                    <span class="link_name">Dasboard</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../admin-menu.php">Dasboard</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="user-settings.php">
                        <i class='bx bx-user'></i>
                        <span class="link_name">Users Settings</span>
                    </a>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="user-settings.php">Users Settings</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="forum-settings.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Forum</span>
                    </a>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="forum-settings.php">Forum Settings</a></li>
                </ul>
            </li>
            <li>
                <a href="timeline-settings.php">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="link_name">Timeline Settings</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="timeline-settings.php">Timeline Settings</a></li>
                </ul>
            </li>
            <li>
                <a href="materi-settings.php">
                    <i class='bx bx-buoy'></i>
                    <span class="link_name">Materi Settings</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="materi-settings.php">Materi Settings</a></li>
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
                echo "<a class='bx bx-log-out logout-button' href='../../logout.php'></a>";
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
            <i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
            <div class="settings-form">
                <h1>Add Materi</h1>
                <form method="POST">
                    <label for="title_materi">Title:</label>
                    <input type="text" name="title_materi" required><br>

                    <label for="description">Descripton:</label>
                    <input name="description" required></input><br>

                    <label for="link_video">Link Video:</label>
                    <input type="text" name="link_video" required><br>

                    <label for="nama">instructor:</label>
                    <select name="nama" required>
                        <?php
                        // Ambil daftar instructor dari tabel profilepengajar
                        $query = "SELECT nama FROM profilepengajar";
                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['nama'] . "'>" . $row['nama'] . "</option>";
                        }
                        ?>
                    </select><br>
                    <input type="submit" name="submit" value="Add New Materi">
                </form>
            </div>
        </div>
    </div>
    <script src="../../../js/script.js"></script>
</body>

</html>