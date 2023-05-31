<?php
include '../../../db/db-connect.php';
session_start();
$s_user_id = $_SESSION['user_id'];
$token = $_SESSION['token'];

$user_id = $_GET['user_id'];

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare('SELECT * FROM sessions WHERE user_id = :user_id AND token = :token');
    $stmt->execute(['user_id' => $s_user_id, 'token' => $token]);
    $session = $stmt->fetch();

    if (!$session) {
        header('Location: index.html');
        exit();
    }
} catch (PDOException $e) {
    die("Connection error: " . $e->getMessage());
}

$query = "SELECT * FROM users WHERE id_user = '$user_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Periksa apakah tombol "Simpan" diklik
if (isset($_POST['simpan'])) {
    // Ambil data yang diperbarui dari form
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $u_image = $_FILES['users_image'];

    $filename = $u_image['name'];
    $tmpFilePath = $u_image['tmp_name'];
    $fileSize = $u_image['size'];
    $fileType = $u_image['type'];

    // Read the contents of the image file
    $imageData = addslashes(file_get_contents($tmpFilePath)); // Add addslashes() to handle special characters

    $query = "UPDATE users SET email = '$email', username = '$username', password = '$password', users_image = '$imageData' WHERE id_user = '$user_id'";
    $result = mysqli_query($conn, $query);


    if ($result) {
        // Informasikan pengguna bahwa data telah diperbarui
        echo "Data telah diperbarui.";
        header("Location: ../user-settings.php");
        exit();
    } else {
        // Tampilkan pesan kesalahan jika terjadi masalah dalam memperbarui data
        echo "Terjadi kesalahan. Silakan coba lagi.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Learn Together-Admin Menu</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../../../css/main.css">
    <link rel="stylesheet" href="../../../../css/admin-settings.css">
</head>

<body>
    <div class="sidebar close">
        <div class="logo-details">
            <i class='bx bx-book'></i>
            <span class="logo_name">LT-Admin Menu</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="../../admin-menu.php">
                    <i class='bx bx-home'></i>
                    <span class="link_name">Dasboard</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../../admin-menu.php">Dasboard</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="../user-settings.php">
                        <i class='bx bx-user'></i>
                        <span class="link_name">Users Settings</span>
                    </a>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="../user-settings.php">Users Settings</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="../forum-settings.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Forum</span>
                    </a>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="../forum-settings.php">Forum Settings</a></li>
                </ul>
            </li>
            <li>
                <a href="../timeline-settings.php">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="link_name">Timeline Settings</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../timeline-settings.php">Timeline Settings</a></li>
                </ul>
            </li>
            <li>
                <a href="../materi-settings.php">
                    <i class='bx bx-buoy'></i>
                    <span class="link_name">Materi Settings</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../materi-settings.php">Materi Settings</a></li>
                </ul>
            </li>
            <li>
                <a href="../faq-settings.php">
                    <i class='bx bx-message'></i>
                    <span class="link_name">Faq Settings</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../faq-settings.php">Faq Settings</a></li>
                </ul>
            </li>
            <li>
                <a href="../guidlines-settings.php">
                    <i class='bx bx-news'></i>
                    <span class="link_name">Guidlines Settings</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../guidlines-settings.php">Guidlines Settings</a></li>
                </ul>
            </li>
            <?php
            $stmt = $pdo->prepare('SELECT * FROM users WHERE id_user = :user_id');
            $stmt->execute(['user_id' => $s_user_id]);
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

    <div class="section">
        <div class="content">
            <i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
            <div class="settings-form">
                <form method="POST" enctype="multipart/form-data">
                    <h1>Configure (<?php echo $row['username']; ?>) Account</h1>
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?php echo $row['email']; ?>" required><br>

                    <label for="username">Username:</label>
                    <input type="text" name="username" value="<?php echo $row['username']; ?>" required><br>

                    <label for="password">Password:</label>
                    <input type="password" name="password" value="<?php echo $row['password']; ?>" required><br>

                    <label for="role">Role:</label>
                    <select name="role" required>
                        <option value="admin" <?php if ($row['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                        <option value="user" <?php if ($row['role'] == 'user') echo 'selected'; ?>>User</option>
                    </select><br>

                    <label for="users_image">Gambar Profil:</label>
                    <input type="file" name="users_image"><br>

                    <input type="submit" name="simpan" value="Simpan">
                </form>
            </div>
        </div>
    </div>
    <script src="../../../../js/script.js"></script>
</body>

</html>