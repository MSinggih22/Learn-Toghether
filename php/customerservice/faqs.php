<!DOCTYPE html>
<html lang="en">

<head>
    <title>Learn Together-FAQS</title>
    <link rel="stylesheet" href="../../css/forum.css">
    <link rel="stylesheet" href="../../css/index.css">
    <link rel="stylesheet" href="../../css/cs.css">
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
                <a href="../home/home.php">
                    <i class='bx bx-home'></i>
                    <span class="link_name">Home</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../home/home.php">Home</a></li>
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
                    <li><a href="../forum/forum-category.php">Category</a></li>
                    <li><a href="../forum/forum-trending.php">Trending</a></li>
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
                <div class="iocn-link">
                    <a href="../customerservice/CS.php">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Customer Services</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Customer Service</a></li>
                    <li><a href="../customerservice/faqs.php">Faqs</a></li>
                    <li><a href="../customerservice/guidlines.php">Gudlines</a></li>
                    <li><a href="../customerservice/rules.php">Rules</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="../settings/settings.php">
                        <i class='bx bx-cog'></i>
                        <span class="link_name">Settings</span>
                    </a>
                </div>
                <ul class="sub-menu blank">
                    <li>
                        <a class="link_name" href="../settings/settings.php">Settings</a>
                    </li>
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
                    <div class="faq-item">
                        <h3>1. Apa itu website forum belajar LearnTogether?</h3>
                        <p>
                            Website forum belajar LearnTogether adalah platform online yang memungkinkan pengguna untuk berbagi pengetahuan, bertanya pertanyaan, dan berdiskusi tentang topik pembelajaran tertentu.
                        </p>
                    </div>
                    <div class="faq-item">
                        <h3>2. Bagaimana cara bergabung dengan forum belajar pada website LearnTogether?</h3>
                        <p>
                            Untuk bergabung dengan forum belajar, Anda perlu membuat akun dengan mengisi formulir pendaftaran yang tersedia. Setelah itu, Anda dapat masuk ke akun Anda dan mulai berpartisipasi dalam diskusi.
                        </p>
                    </div>
                    <div class="faq-item">
                        <h3>3. Apakah bergabung dengan forum belajar ini gratis?</h3>
                        <p>
                            Ya, bergabung dengan forum belajar ini adalah gratis. Tidak dikenakan biaya pendaftaran atau biaya langganan.
                        </p>
                    </div>
                    <div class="faq-item">
                        <h3>4. Bagaimana cara mengajukan pertanyaan atau memulai diskusi baru di forum?</h3>
                        <p>
                            Anda dapat mengajukan pertanyaan atau memulai diskusi baru dengan menulis postingan baru di forum yang sesuai dengan topik yang ingin Anda bahas. Pastikan untuk memberikan judul yang jelas dan menjelaskan pertanyaan atau topik Anda dengan detail.
                        </p>
                    </div>
                    <div class="faq-item">
                        <h3>5. Bagaimana cara mencari topik atau pertanyaan yang sudah dibahas sebelumnya di forum?</h3>
                        <p>
                            Anda dapat menggunakan fungsi pencarian di forum untuk mencari topik atau pertanyaan yang sudah dibahas sebelumnya. Gunakan kata kunci yang relevan untuk memperoleh hasil pencarian yang sesuai.
                        </p>
                    </div>
                    <div class="faq-item">
                        <h3>6. Apakah saya dapat mengirim pesan pribadi kepada pengguna lain di forum ini?</h3>
                        <p>
                            Ya, dalam beberapa forum belajar, Anda dapat mengirim pesan pribadi kepada pengguna lain untuk berkomunikasi secara langsung. Biasanya ada opsi "pesan pribadi" atau "kirim pesan" di profil pengguna.
                        </p>
                    </div>
                    <div class="faq-item">
                        <h3>7. Bagaimana cara mengubah atau menghapus postingan saya di forum?</h3>
                        <p>
                            Biasanya, Anda dapat mengubah atau menghapus postingan Anda sendiri di forum dengan menggunakan opsi "edit" atau "hapus" yang tersedia di setiap postingan yang Anda buat.
                        </p>
                    </div>
                </div>
            </div>
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