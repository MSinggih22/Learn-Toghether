<!DOCTYPE html>
<html lang="en">

<head>
    <title>Learn Toghether</title>
    <link rel="stylesheet" href="css/style.css">
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
                        <span class="link_name">Category</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Category</a></li>
                    <li><a href="#">HTML & CSS</a></li>
                    <li><a href="#">JavaScript</a></li>
                    <li><a href="#">PHP & MySQL</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class='bx bx-book-alt'></i>
                        <span class="link_name">Posts</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Posts</a></li>
                    <li><a href="#">Web Design</a></li>
                    <li><a href="#">Login Form</a></li>
                    <li><a href="#">Card Design</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="link_name">Analytics</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Analytics</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-line-chart'></i>
                    <span class="link_name">Chart</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Chart</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class='bx bx-plug'></i>
                        <span class="link_name">Plugins</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Plugins</a></li>
                    <li><a href="#">UI Face</a></li>
                    <li><a href="#">Pigments</a></li>
                    <li><a href="#">Box Icons</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-compass'></i>
                    <span class="link_name">Explore</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Explore</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-history'></i>
                    <span class="link_name">History</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">History</a></li>
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
        </ul>
    </div>

    <section class="home-section">
        <div class="home-content">
            <a href="newpost.php" class="create-post-button">Create New Post</a>
            <i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
            <span class="text"></span>
            <div id="boxes">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "lt";
                $conn = mysqli_connect($servername, $username, $password, $dbname);
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // select all data from the "boxes" table
                $sql = "SELECT * FROM topics";
                $result = mysqli_query($conn, $sql);

                // loop through the data and create a box for each row
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='box'>";
                        echo "<div class='box-image'>";
                        echo "<img src='assets/image/tes.png' alt='Image description' class='box-image'>";
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

    <div class="container">
        <a href="login.php" class="btn btn-login">Log In</a>
        <a href="register.php" class="btn btn-register">Sign Up</a>
    </div>

    <div class="search-container">
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