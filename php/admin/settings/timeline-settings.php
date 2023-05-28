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

            // Menghapus timeline
            if (isset($_GET['delete_id'])) {
                $deleteId = $_GET['delete_id'];
                $deleteSql = "DELETE FROM timeline WHERE id_timeline = $deleteId";
                mysqli_query($conn, $deleteSql);
            }

            $sql = "SELECT timeline.id_timeline, users.username, timeline.description, timeline.created_date FROM timeline JOIN users ON timeline.user_id = users.id_user";
            $result = mysqli_query($conn, $sql);
            $timelines = mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>
            <h1>Timeline Settings</h1>
            <div class="box">
                <table>
                    <tr>
                        <th>No</th>
                        <th>Creator</th>
                        <th>Description</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                    <?php $count = 1; ?>
                    <?php foreach ($timelines as $timeline) : ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $timeline['username']; ?></td>
                            <td><?php echo $timeline['description']; ?></td>
                            <td><?php echo $timeline['created_date']; ?></td>
                            <td>
                                <a href="timeline-settings.php?delete_id=<?php echo $timeline['id_timeline']; ?>" onclick="return confirm('Are you sure you want to delete this timeline?')">Delete</a>
                                <a href="edit/edit-timeline.php?id_timeline=<?php echo $timeline['id_timeline']; ?>">Edit</a>
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