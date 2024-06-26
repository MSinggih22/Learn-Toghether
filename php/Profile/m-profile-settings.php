<?php
include '../db/db-connect.php';
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
        header('Location: ../login.php');
        exit();
    }
    $stmt = $pdo->prepare('SELECT role FROM users WHERE id_user = :user_id');
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch();
} catch (PDOException $e) {
    die("Connection error: " . $e->getMessage());
}

$query = "SELECT * FROM users WHERE id_user = '$user_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Periksa apakah tombol "submit" diklik
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($_FILES['users_image']['name'])) {
        // Mendapatkan informasi file gambar
        $file_name = $_FILES['users_image']['name'];
        $file_size = $_FILES['users_image']['size'];
        $file_tmp = $_FILES['users_image']['tmp_name'];
        $file_type = $_FILES['users_image']['type'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        if (in_array($file_ext, $allowed_extensions)) {
            $img_data = file_get_contents($file_tmp);
            $img_data = mysqli_real_escape_string($conn, $img_data);
            $query = "UPDATE users SET email = '$email', username = '$username', password = '$password' , users_image = '$img_data' WHERE id_user = '$user_id'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "Data telah diperbarui.";
            } else {
                echo "Terjadi kesalahan dalam mengupdate database. Silakan coba lagi.";
            }
        } else {
            echo "Hanya file gambar dengan ekstensi JPG, JPEG, PNG, atau GIF yang diizinkan.";
        }
    } else {
        $query = "UPDATE users SET email = '$email', username = '$username', password = '$password' WHERE id_user = '$user_id'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "Data telah diperbarui.";
            header("Location:m-profile-settings.php");
            exit();
        } else {
            echo "Terjadi kesalahan dalam mengupdate database. Silakan coba lagi.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Learn Together</title>
    <link rel="stylesheet" href="../../css/admin-settings.css">
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
                    <a href="../forum/log-forum.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Forum</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="../forum/log-forum.php">Forum</a></li>
                    <li><a href="../forum/log-category.php">Category</a></li>
                    <li><a href="../forum/log-trending.php">Trending</a></li>
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
                    <li><a href="../CS/log-faqs.php">Faqs</a></li>
                    <li><a href="../CS/log-guidlines.php">Gudlines</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="m-profile-settings.php">
                        <i class='bx bx-cog'></i>
                        <span class="link_name">Settings</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="m-profile-settings.php">Settings</a></li>
                    <li><a href="m-profile-settings.php">My Profile Settings</a></li>
                    <li><a href="m-forum-settings.php">My Forum Settings</a></li>
                    <li><a href="m-timeline-settings.php">My Timeline Settings</a></li>
                </ul>
            </li>
            <?php if ($user['role'] === 'admin') { ?>
                <li>
                    <div class="iocn-link">
                        <a href="../Admin/admin-menu.php">
                            <i class='bx bx-desktop'></i>
                            <span class="link_name">Admin Menu</span>
                        </a>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="../Admin/admin-menu.php">Admin Menu</a></li>
                    </ul>
                </li>
            <?php } ?>
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
                echo "<a class='bx bx-log-out logout-button' href='../logout.php'></a>";
                echo "</div>";
                echo "</li>";
            } else {
                echo "<p>Unable to fetch user data.</p>";
            }
            ?>
        </ul>
    </div>
    <section class="section">
        <div class="content">
            <i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
            <span class="text"></span>
            <div class="settings-form">
                <h1>Configure Account</h1>
                <form method="POST" enctype="multipart/form-data">
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?php echo $row['email']; ?>" required><br>

                    <label for="username">Username:</label>
                    <input type="text" name="username" value="<?php echo $row['username']; ?>" required><br>

                    <label for="password">Password:</label>
                    <input type="password" name="password" value="<?php echo $row['password']; ?>" required><br>

                    <label for="users_image">Gambar Profil:</label>
                    <input type="file" name="users_image" id="users_image">

                    <input type="submit" name="submit" value="Submit" onclick="return confirm('Apakah Anda yakin?')">
                </form>
            </div>
        </div>
    </section>
    <script src="../../js/script.js"></script>
</body>

</html>