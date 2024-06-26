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
        header('Location: ../login.php');
        exit();
    }

    $stmt = $pdo->prepare('SELECT role FROM users WHERE id_user = :user_id');
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch();
    
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
    <link rel="stylesheet" href="../../css/settings.css">
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
            include '../db/db-connect.php';

            // Menghapus forum
            if (isset($_GET['delete_id'])) {
                $deleteId = $_GET['delete_id'];
                $deleteSql = "DELETE FROM topics WHERE id_topics = $deleteId";
                mysqli_query($conn, $deleteSql);
            }

            $sql = "SELECT topics.id_topics, users.username, topics.title, topics.created_at FROM topics JOIN users ON topics.user_id = users.id_user where $user_id = topics.user_id";
            $result = mysqli_query($conn, $sql);
            $forums = mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>
            <h1>Forum Settings</h1>
            <div class="box">
                <table>
                    <tr>
                        <th>No</th>
                        <th>Creator</th>
                        <th>Title</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    <?php $count = 1; ?>
                    <?php foreach ($forums as $forum) : ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $forum['username']; ?></td>
                            <td><?php echo $forum['title']; ?></td>
                            <td><?php echo $forum['created_at']; ?></td>
                            <td>
                                <a href="m-forum-settings.php?delete_id=<?php echo $forum['id_topics']; ?>" onclick="return confirm('Are you sure you want to delete this forum?')">Delete</a>
                                <a href="edit/e-m-forum-settings.php?id_topics=<?php echo $forum['id_topics']; ?>">Edit</a>
                            </td>
                        </tr>
                        <?php $count++; ?>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
    <script src="../../js/script.js"></script>

</body>

</html>