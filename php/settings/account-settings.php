<?php
session_start();
include '../../db/database-connect.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);

    $username = $row['username'];
    $email = $row['email'];
    $users_image = $row['users_image'];
} else {
    echo "Error fetching user data from the database.";
}

$submitMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-username'])) {
    $newUsername = $_POST['username'];

    $sql = "UPDATE users SET username = '$newUsername' WHERE id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['username'] = $newUsername;

        $submitMessage = "Username updated successfully.";
    } else {
        echo "Error updating username: " . mysqli_error($conn);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-email'])) {
    $newEmail = $_POST['email'];

    $sql = "UPDATE users SET email = '$newEmail' WHERE id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['email'] = $newEmail;

        $submitMessage = "Email updated successfully.";
    } else {
        echo "Error updating email: " . mysqli_error($conn);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-password'])) {
    $newPassword = $_POST['password'];

    $sql = "UPDATE users SET password = '$newPassword' WHERE id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        $submitMessage = "Password updated successfully.";
    } else {
        echo "Error updating password: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Learn Together</title>
    <link rel="stylesheet" href="../../css/forum.css">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/login.css">
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
                <a href="index.html">
                    <i class='bx bx-home'></i>
                    <span class="link_name">Home</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="index.html">Home</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="index.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Forum</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Forum</a></li>
                    <li><a href="forum-category.php">Category</a></li>
                    <li><a href="#">Trending</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="link_name">Timeline</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Timeline</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Customer Services</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Customer Service</a></li>
                    <li><a href="#">Faqs</a></li>
                    <li><a href="#">Gudlines</a></li>
                    <li><a href="#">Rules</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class='bx bx-cog'></i>
                        <span class="link_name">Settings</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu blank">
                    <li>
                        <a class="link_name" href="#">Settings</a>
                    </li>
                </ul>
            </li>
    </div>
    <section class="section">
        <div class="content">
            <i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
            <span class="text"></span>
            <div id="boxes">
                <h1>Account Settings</h1>
                <h2>Welcome, <?php echo $username; ?>!</h2>
                <h3>Your Profile</h3>
                <p>Username: <?php echo $username; ?></p>
                <p>Email: <?php echo $email; ?></p>
                <img src="<?php echo $users_image; ?>" alt="Profile Image" width="200" height="200">
                <form class="acc-set" method="POST" action="account-settings.php" enctype="multipart/form-data">
                    <label for="username">Change Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo $username; ?>" required placeholder="Enter new username">
                    <input type="password" id="current-password-username" name="current-password-username" required placeholder="Enter current password">
                    <input type="submit" name="update-username" value="Update Username">

                    <label for="email">Change Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" placeholder="Enter new email">
                    <input type="password" id="current-password-email" name="current-password-email" required placeholder="Enter current password">
                    <input type="submit" name="update-email" value="Update Email">

                    <label for="password">Change Password</label>
                    <input type="password" id="current-password" name="current-password" required placeholder="Enter current password">

                    <input type="password" id="new-password" name="new-password" placeholder="Enter new password">

                    <input type="password" id="confirm-new-password" name="confirm-new-password" placeholder="Confirm new password">

                    <input type="submit" name="update-password" value="Update Password">

                    <label for="profile-image">Change Profile</label>
                    <input type="file" id="profile-image" name="profile-image">

                    <input type="submit" value="Save Changes">
                </form>
                <p><?php echo $submitMessage; ?></p>
            </div>
        </div>
    </section>  





    <script src="../../js/script.js"></script>
    <Script>
        let arrow = document.querySelectorAll(".arrow");
        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e) => {
                let arrowParent = e.target.parentElement.parentElement;
                arrowParent.classList.toggle("showMenu");
                let mainContent = document.querySelector(".section");
                mainContent.classList.toggle("shifted");
            });
        }
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-chevron-right");
        console.log(sidebarBtn);
        sidebarBtn.addEventListener("click", () => {
            sidebar.classList.toggle("close");
            let mainContent = document.querySelector(".section");
            mainContent.classList.toggle("shifted");
        });
    </Script>
</body>

</html>

</html>