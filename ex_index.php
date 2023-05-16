<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lt";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['token'])) {
    // User is not logged in, redirect to the login page
    header('Location: index.html');
    exit();
}

// Get the user ID and session token from the session
$user_id = $_SESSION['user_id'];
$token = $_SESSION['token'];

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the SQL statement to fetch the session from the sessions table
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
    <title>Learn Toghether</title>
    <link rel="stylesheet" href="css/home.css">
    <script src="js/script.js"></script>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="sidebar close">
        <div class="logo-details">
            <i class='bx bx-book'></i>
            <span class="logo_name">Learning Toghether</span>
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
                    <a href="#">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Forum</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Forum</a></li>
                    <li><a href="#">Category</a></li>
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
                <a href="#">
                    <i class='bx bx-cog'></i>
                    <span class="link_name">Setting</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Setting</a></li>
                </ul>
            </li>
            <li>
                <?php
                // Prepare the SQL statement to fetch the user from the users table
                $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :user_id');
                $stmt->execute(['user_id' => $user_id]);
                $user = $stmt->fetch();

                if ($user) {
                    // User found, display the username
                    echo "<div class='profile-details'>";
                    echo "<div class='profile-details'>";
                    echo "<div class='profile-content'>";
                    echo "<img src='image/tes.png' alt='profileImg'>";
                    echo "</div>";
                    echo "<div class='name-job'>";
                    echo "<div class='profile_name'>";
                    echo "<h2>" . $user['username'] . "</h2>";
                    echo "</div>";
                    echo  "</div>";
                    echo "<a class='bx bx-log-out' href='logout.php'></a>";
                    echo "</div>";
                    echo "</li>";
                } else {
                    // User not found
                    echo "<p>Unable to fetch user data.</p>";
                }
                ?>
        </ul>
    </div>

    <section class="home-section">
        <div class="home-content">
            <a href="post-forum.php" class="create-post-button">Create New Post</a>
            <i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
            <span class="text"></span>
            <div id="boxes">
                <?php
                // select all data from the "boxes" table
                $sql = "SELECT * FROM topics";
                $result = mysqli_query($conn, $sql);

                // loop through the data and create a box for each row
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $img = $row["img"];
                        echo "<div class='box'>";
                        echo "<div class='box-image'>";
                        echo "<img src='data:image/jpeg;base64," . base64_encode($img) . "' alt='Image description' class='box-image'>";
                        echo "</div>";
                        echo "<div class='box-content'>";
                        echo "<div class='box-title'>";
                        echo "<a href=''>";
                        echo "<h2>" . $row['title'] . "</h2>";
                        echo "</a>";
                        echo "</div>";
                        echo "<div class='box-description'>";
                        echo "<p>" . $row['description'] . "</p>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class='box-buttons'>";
                        echo "<button class='box-button bx bx-show'>" . $row['views'] . " Views</button>";
                        echo "<button class='box-button bx bx-comment'>" . $row['comments'] . " Comments</button>";
                        echo "<button class='box-button bx bx-user-plus'>" . $row['followers'] . " Followers</button>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </section>
    <div class="search">
        <form action="#">
            <input type="text" placeholder="Search...">
            <button type="submit"><i class="bx bx-search"></i></button>
        </form>
    </div>

    <script>
        let arrow = document.querySelectorAll(".arrow");
        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e) => {
                let arrowParent = e.target.parentElement.parentElement;
                arrowParent.classList.toggle("showMenu");
                let mainContent = document.querySelector(".home-section");
                mainContent.classList.toggle("shifted");
            });
        }
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-chevron-right");
        console.log(sidebarBtn);
        sidebarBtn.addEventListener("click", () => {
            sidebar.classList.toggle("close");
            let mainContent = document.querySelector(".home-section");
            mainContent.classList.toggle("shifted");
        });


        //login regis script
        const loginBtn = document.querySelector(".btn-login");
        const registerBtn = document.querySelector(".btn-register");
        loginBtn.addEventListener("click", () => {
            console.log("Login button clicked");
        });
        registerBtn.addEventListener("click", () => {
            console.log("Register button clicked");
        });

        //search script
        const searchBar = document.querySelector('input[type="text"]');
        searchBar.addEventListener("keyup", function(e) {
            const term = e.target.value.toLowerCase();
            const items = document.querySelectorAll("div.item");
            Array.from(items).forEach(function(item) {
                const title = item.textContent;
                if (title.toLowerCase().indexOf(term) != -1) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        });
    </script>
</body>

</html>