<?php
include '../../db/db-connect.php';
session_start();
$user_id = $_SESSION['user_id'];
$token = $_SESSION['token'];
try {
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

$id_topics = $_GET['id_topics'];
$query = "SELECT * FROM topics WHERE id_topics = '$id_topics'";
$result = mysqli_query($conn, $query);
$topics = mysqli_fetch_assoc($result);

if (isset($_POST['simpan'])) {
    // Ambil data yang diperbarui dari form
    $title = $_POST['title'];
    $description = $_POST['description'];

    if ($_FILES['img']['name'] != '') {
        // Mendapatkan informasi file gambar
        $file_name = $_FILES['img']['name'];
        $file_size = $_FILES['img']['size'];
        $file_tmp = $_FILES['img']['tmp_name'];
        $file_type = $_FILES['img']['type'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        if (in_array($file_ext, $allowed_extensions)) {
            $query = "UPDATE topics SET title = '$title', description = '$description' , img = '$file_name' WHERE id_topics = '$id_topics'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                // Informasikan pengguna bahwa data telah diperbarui
                echo "Data telah diperbarui.";
            } else {
                // Tampilkan pesan kesalahan jika terjadi masalah dalam memperbarui data
                echo "Terjadi kesalahan. Silakan coba lagi.";
            }
        } else {
            // Tampilkan pesan kesalahan jika ekstensi file tidak valid
            echo "Hanya file gambar dengan ekstensi JPG, JPEG, PNG, atau GIF yang diizinkan.";
        }
    } else {
        $query = "UPDATE topics SET title = '$title', description = '$description' WHERE id_topics = '$id_topics'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            // Informasikan pengguna bahwa data telah diperbarui
            echo "Data telah diperbarui.";
            header("Location: user-settings.php");
            exit();
        } else {
            // Tampilkan pesan kesalahan jika terjadi masalah dalam memperbarui data
            echo "Terjadi kesalahan. Silakan coba lagi.";
        }
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
            <span class="logo_name">Learning Together</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="../../log-home.php">
                    <i class='bx bx-home'></i>
                    <span class="link_name">Home</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../log-home.php">Home</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="../../forum/log-forum.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Forum</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="../../forum/log-forum.php">Forum</a></li>
                    <li><a href="../../forum/log-category.php">Category</a></li>
                    <li><a href="../../forum/log-trending.php">Trending</a></li>
                </ul>
            </li>

            <li>
                <a href="../../timeline/log-timeline.php">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="link_name">Timeline</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../../timeline/log-timeline.php">Timeline</a></li>
                </ul>
            </li>
            <li>
                <a href="../../materi/log-materi-list.php">
                    <i class='bx bx-buoy'></i>
                    <span class="link_name">Materi</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../../materi/log=materi-list.php">Materi</a></li>
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
                    <li><a href="../../CS/log-faqs.php">Faqs</a></li>
                    <li><a href="../../CS/log-guidlines.php">Gudlines</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="../../settings/settings.php">
                        <i class='bx bx-cog'></i>
                        <span class="link_name">Settings</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Settings</a></li>
                    <li><a href="../../Profile/m-profile-settings.php">My Profile Settings</a></li>
                    <li><a href="../../Profile/m-forum-settings.php">My Forum Settings</a></li>
                    <li><a href="../../Profile/m-timeline-settings.php">My Timeline Settings</a></li>
                </ul>
            </li>
            <?php
            $stmt = $pdo->prepare('SELECT * FROM users WHERE id_user = :user_id');
            $stmt->execute(['user_id' => $user_id]);
            $user = $stmt->fetch();

            if ($user) {
                echo "<li>";
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
                echo "</div>";
                echo "</li>";
            } else {
                echo "<p>Unable to fetch user data.</p>";
            }
            ?>
        </ul>
    </div>

    <div class="section">
        <div class="content">
            <i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
            <div class="settings-form">
                <form method="POST" enctype="multipart/form-data">
                    <h1>Configure Topics <?php echo $topics['title']; ?></h1>

                    <label for="title">Title:</label>
                    <input type="title" name="title" value="<?php echo $topics['title']; ?>" required><br>

                    <label for="description">Description:</label>
                    <input type="text" name="description" value="<?php echo $topics['description']; ?>" required><br>

                    <label for="img">Gambar:</label>
                    <input type="file" name="img"><br>

                    <input type="submit" name="simpan" value="simpan">

                </form>
            </div>
        </div>
    </div>
    <script src="../../../js/script.js"></script>
</body>

</html>