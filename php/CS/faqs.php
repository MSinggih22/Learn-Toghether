<!DOCTYPE html>
<html lang="en">

<head>
    <title>Learn Together-FAQS</title>
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/css.css">
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
                <a href="../home.php">
                    <i class='bx bx-home'></i>
                    <span class="link_name">Home</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../home.php">Home</a></li>
                </ul>
            </li>

            <li>
                <div class="iocn-link">
                    <a href="../forum/forum.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Forum</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="../forum/forum.php">Forum</a></li>
                    <li><a href="../forum/category.php">Category</a></li>
                    <li><a href="../forum/trending.php">Trending</a></li>
                </ul>
            </li>

            <li>
                <a href="../timeline/timeline.php">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="link_name">Timeline</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../timeline/timeline.php">Timeline</a></li>
                </ul>
            </li>
            <li>
                <a href="../materi/materi-list.php">
                    <i class='bx bx-buoy'></i>
                    <span class="link_name">Materi</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../materi/materi-list.php">Materi</a></li>
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
                    <li><a href="faqs.php">Faqs</a></li>
                    <li><a href="guidlines.php">Gudlines</a></li>
                </ul>
            </li>

        </ul>
    </div>
    <section class="section">
        <div class="content">
            <i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
            <span class="text"></span>
            <div id="boxes">
                <h2>Frequently Asked Questions</h2>
                <div class="faq-container">
                    <?php
                    include '../db/db-connect.php';
                    $sql = "SELECT * FROM faq";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="faq-item">';
                            echo '<h3>' . $row["Pertanyaan"] . '</h3>';
                            echo '<p>' . $row["Jawaban"] . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo "Tidak ada faq yang tersedia.";
                    }
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
        </div>
        <div class="container">
            <a href="../login.php" class="btn btn-login">Log In</a>
            <a href="../register.php" class="btn btn-register">Sign Up</a>
        </div>
    </section>

    <script src="../../js/script.js"></script>
</body>

</html>