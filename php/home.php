<!DOCTYPE html>
<html>

<head>
    <title>LT-Home</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/main.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
</head>
<body>
    <div class="sidebar close">
        <div class="logo-details">
            <i class='bx bx-book'></i>
            <span class="logo_name">Learning Together</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="home.php">
                    <i class='bx bx-home'></i>
                    <span class="link_name">Home</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="home.php">Home</a></li>
                </ul>
            </li>

            <li>
                <div class="iocn-link">
                    <a href="forum/forum.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Forum</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="forum/forum.php">Forum</a></li>
                    <li><a href="forum/category.php">Category</a></li>
                    <li><a href="forum/trending.php">Trending</a></li>
                </ul>
            </li>

            <li>
                <a href="timeline/timeline.php">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="link_name">Timeline</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="timeline/timeline.php">Timeline</a></li>
                </ul>
            </li>
            <li>
                <a href="materi/materi-list.php">
                    <i class='bx bx-buoy'></i>
                    <span class="link_name">Materi</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="materi/materi-list.php">Materi</a></li>
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
                    <li><a href="CS/faqs.php">Faqs</a></li>
                    <li><a href="CS/guidlines.php">Gudelines</a></li>
                </ul>
            </li>

        </ul>
    </div>
    <section class="section">
        <div class="content"><i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
        </div>
        <div class="border">
            <div class="row">
                <div class="welc">
                    <h1 data-aos="fade-up" data-aos-duration="1000">Welcome to Learning Together</h1>
                    <h2 data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000"">Online Learning forum</h2>
                    <a href=" register.php" data-aos="fade-up" data-aos-delay="800" data-aos-duration="1000" class="btn-register">Create Your
                        Account and Get Started</a>
                </div>
            </div>
        </div>
        <div class="featurelist" data-aos="fade-up" data-aos-delay="1200" data-aos-duration="1000">
            <h1>---List Features---</h1>
            <div class="box-container" data-aos="fade-up" data-aos-delay="1600" data-aos-duration="1000">
                <div class="box">
                    <div class="icon"><i class="bx bx-collection"></i></div>
                    <a href="forum/forum.php">
                        <h4 class="title">FORUM</h4>
                    </a>
                    <p class="description">create and view many useful forums in the forums feature.</p>
                </div>
                <div class="box">
                    <div class="icon"><i class="bx bx-pie-chart"></i></div>
                    <a href="timeline/timeline.php">
                        <h4 class="title">TIMELINE</h4>
                    </a>
                    <p class="description">Make a post about your forum and see the stories of website users
                    </p>
                </div>
                <div class="box">
                    <div class="icon"><i class="bx bx-buoy"></i></div>
                    <a href="materi/materi-list.php">
                        <h4 class="title">MATERI</h4>
                    </a>
                    <p class="description">take a look at the many learning materials that have been created by trusted
                        teachers</p>
                </div>
            </div>
        </div>
        <div class="Teamlist" data-aos="fade-up" data-aos-delay="2000" data-aos-duration="1000">
            <h1>---DEV TEAM---</h1>
            <div class="box-container" data-aos="fade-up" data-aos-delay="2400" data-aos-duration="1000">
                <div class="box">
                    <div class="image"> <img src="../assets/image/User-Man.png" class="image-fluid"></div>
                    <a href="">
                        <h4 class="Name">MUHAMAD SINGGIH</h4>
                    </a>
                </div>
                <div class="box">
                    <div class="image">
                        <div class="image"> <img src="../assets/image/User-Man.png" class="image-fluid"></div>
                    </div>
                    <a href="">
                        <h4 class="Name">Islam Anasta Irawan</h4>
                    </a>
                </div>
                <div class="box">
                    <div class="image">
                        <div class="image"> <img src="../assets/image/User-Woman.png" class="image-fluid"></div>
                    </div>
                    <a href="">
                        <h4 class="Name">Citra Khairunisa</h4>
                    </a>
                </div>
            </div>
            <div class="bottom-section">
                <div class="container-bottom">
                    <p><a href="mailto:singgipenaraga@gmail.com">singgipenaraga@gmail.com</a> |
                        <a href="">LinkdedIn Profile</a> | <a href="https://github.com/Singgih115">Github</a>
                    </p>
                    <p>&copy; Copyright Muhamad Singgih. All Rights Reserved</p>
                </div>
            </div>
        </div>
        <div class=" container">
            <a href="login.php" class="btn btn-login">Log In</a>
            <a href="register.php" class="btn btn-register">Sign Up</a>
        </div>
    </section>
    <script src="../js/aosinit.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>