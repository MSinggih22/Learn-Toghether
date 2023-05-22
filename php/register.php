<?php
include '../db/database-connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user inputs from the form
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirmpassword"];

    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit;
    }
    $stmt = $connection->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
    $stmt->execute([$username, $email, $password]);

    echo '<script>window.location.href = ".php";</script>';
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Learn Together</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/login.css">
    <script src="js/script.js"></script>
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
        </ul>
    </div>
    <section class="section">
        <div class="content">
            <i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
            <span class="text"></span>
            <div class="register">
                <h1>Create an account</h1>
                <form class="form" action="#" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="alert alert-error"></div>
                    <input type="text" placeholder="User Name" name="username" required />
                    <input type="email" placeholder="Email" name="email" required />
                    <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
                    <input type="password" placeholder="Confirm Password" name="confirmpassword" autocomplete="new-password" required />
                    <input type="submit" value="Register" name="register" class="btn btn-block btn-primary" />
                </form>
            </div>
        </div>
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


            //login regis
            const loginBtn = document.querySelector(".btn-login");
            const registerBtn = document.querySelector(".btn-register");
            loginBtn.addEventListener("click", () => {
                console.log("Login button clicked");
            });
            registerBtn.addEventListener("click", () => {
                console.log("Register button clicked");
            }); //search script
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