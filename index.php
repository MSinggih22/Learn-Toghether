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
            <button id="create-box-btn">Create a new box</button>
        </ul>
    </div>

    <section class="home-section">
        <div class="home-content">
            <a href="newpost.html" class="create-post-button">Create New Post</a>
            <i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
            <span class="text"></span>
            <div class="forum-title-box">
                <div class="main-box">
                    <div class="box">
                        <div class="box-image">
                            <img src="image/tes.png" alt="Image description" class="box-image">
                        </div>
                        <div class="box-content">
                            <div class="box-title">
                                <a href="">
                                    <h2>Importan English</h2>
                                </a>
                            </div>
                            <div class="box-description">
                                <p>This is a brief description of the box content.</p>
                            </div>
                        </div>
                        <div class="box-buttons">
                            <button class="box-button bx bx-show">100 Views</button>
                            <button class="box-button bx bx-comment">10 Comments</button>
                            <button class="box-button bx bx-user-plus">10 Followers</button>
                        </div>
                    </div>
                </div>
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
        searchBar.addEventListener("keyup", function (e) {
            const term = e.target.value.toLowerCase();
            const items = document.querySelectorAll("div.item");
            Array.from(items).forEach(function (item) {
                const title = item.textContent;
                if (title.toLowerCase().indexOf(term) != -1) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        });


        const createBoxBtn = document.querySelector("#create-box-btn");
        let mainBox = document.querySelector(".main-box");

        createBoxBtn.addEventListener("click", function () {
            const newBox = document.createElement("div");
            newBox.classList.add("box");
            newBox.style.top = mainBox.getBoundingClientRect().top + 250 + "px"; // position new box 200px below main box

            const boxImage = document.createElement("div");
            boxImage.classList.add("box-image");
            const image = document.createElement("img");
            image.src = "image/tes.png";
            image.alt = "Image description";
            image.classList.add("box-image");
            boxImage.appendChild(image);
            newBox.appendChild(boxImage);

            const boxContent = document.createElement("div");
            boxContent.classList.add("box-content");
            const boxTitle = document.createElement("div");
            boxTitle.classList.add("box-title");
            const titleLink = document.createElement("a");
            titleLink.href = "#";
            const titleHeading = document.createElement("h2");
            titleHeading.textContent = "New Box Title";
            titleLink.appendChild(titleHeading);
            boxTitle.appendChild(titleLink);
            boxContent.appendChild(boxTitle);
            const boxDescription = document.createElement("div");
            boxDescription.classList.add("box-description");
            const descriptionText = document.createElement("p");
            descriptionText.textContent =
                "This is a brief description of the new box content.";
            boxDescription.appendChild(descriptionText);
            boxContent.appendChild(boxDescription);
            newBox.appendChild(boxContent);

            const boxButtons = document.createElement("div");
            boxButtons.classList.add("box-buttons");
            const viewsButton = document.createElement("button");
            viewsButton.classList.add("box-button", "bx", "bx-show");
            viewsButton.textContent = "100 Views";
            const commentsButton = document.createElement("button");
            commentsButton.classList.add("box-button", "bx", "bx-comment");
            commentsButton.textContent = "10 Comments";
            const followersButton = document.createElement("button");
            followersButton.classList.add("box-button", "bx", "bx-user-plus");
            followersButton.textContent = "10 Followers";
            boxButtons.appendChild(viewsButton);
            boxButtons.appendChild(commentsButton);
            boxButtons.appendChild(followersButton);
            newBox.appendChild(boxButtons);

            mainBox.insertAdjacentElement("afterend", newBox);
            mainBox = newBox; // update mainBox to reference the newly created box
        });

    </script>
</body>

</html>