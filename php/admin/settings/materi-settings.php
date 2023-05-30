<?php
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Learn Together-Admin Menu</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../../css/main.css">
    <link rel="stylesheet" href="../../../css/settings.css">
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
            <li>
                <a href="faq-settings.php">
                    <i class='bx bx-message'></i>
                    <span class="link_name">Faq Settings</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="faq-settings.php">Faq Settings</a></li>
                </ul>
            </li>
            <li>
                <a href="guidlines-settings.php">
                    <i class='bx bx-news'></i>
                    <span class="link_name">Guidlines Settings</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="guidlines-settings.php">Guidlines Settings</a></li>
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
            <?php
            include '../../db/db-connect.php';

            // Menghapus materi
            if (isset($_GET['delete_id'])) {
                $deleteId = $_GET['delete_id'];
                $deleteSql = "DELETE FROM materi WHERE id_materi = $deleteId";
                mysqli_query($conn, $deleteSql);
            }

            $sql = "SELECT m.id_materi, m.title_materi, m.description, m.link_video, p.nama FROM materi m JOIN profilepengajar p ON m.id_pengajar = p.id_pengajar";
            $result = mysqli_query($conn, $sql);
            $materis = mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>
            <h1>Materi Settings</h1>
            <div class="box">
                <a href="add-materi.php" class="add-materi">Add New Materi</a>
                <table>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Instructor</th>
                        <th>Action</th>
                    </tr>
                    <?php $count = 1; ?>
                    <?php foreach ($materis as $materi) : ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $materi['title_materi']; ?></td>
                            <td><?php echo $materi['nama']; ?></td>
                            <td>
                                <a href="materi-settings.php?delete_id=<?php echo $materi['id_materi']; ?>" onclick="return confirm('Are you sure you want to delete this materi?')">Delete</a>
                                <a href="edit/edit-materi.php?id_materi=<?php echo $materi['id_materi']; ?>">Edit</a>
                            </td>
                        </tr>
                        <?php $count++; ?>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

    <script src="../../../js/script.js"></script>

</body>

</html>