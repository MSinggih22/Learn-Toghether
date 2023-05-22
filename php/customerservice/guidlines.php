<!DOCTYPE html>
<html lang="en">

<head>
    <title>Learn Together</title>
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
                <h2>Forum Guidelines</h2>
                <ol class="guidelines-list">
                    <li>
                        <h3>Hargai anggota forum:</h3>
                        <p>
                            Bersikaplah sopan dan hormat terhadap semua anggota forum. Hindari penggunaan bahasa kasar, pelecehan, atau ancaman dalam komunikasi. Saling menghargai pendapat dan pengalaman setiap anggota.
                        </p>
                    </li>
                    <li>
                        <h3>Buat postingan yang bermanfaat:</h3>
                        <p>
                            Pastikan postingan Anda relevan dengan topik pembelajaran. Tulis dengan jelas dan komunikatif agar mudah dipahami. Berikan argumen dan bukti yang mendukung pendapat atau jawaban Anda.
                        </p>
                    </li>
                    <li>
                        <h3>Jaga kerahasiaan dan privasi:</h3>
                        <ul>
                            <li>Hindari membagikan informasi pribadi seperti alamat, nomor telepon, atau data identitas lainnya di forum.</li>
                            <li>Jangan mempublikasikan konten pribadi orang lain tanpa izin mereka.</li>
                        </ul>
                    </li>
                    <li>
                        <h3>Cari sebelum bertanya:</h3>
                        <ul>
                            <li>Gunakan fungsi pencarian forum untuk memastikan bahwa pertanyaan Anda belum dibahas sebelumnya.</li>
                            <li>Baca thread atau topik serupa sebelum mengajukan pertanyaan baru.</li>
                        </ul>
                    </li>
                    <li>
                        <h3>Berikan umpan balik yang konstruktif:</h3>
                        <p>
                            Jika Anda memberikan umpan balik atau kritik, pastikan agar tetap bersifat konstruktif dan membantu. Hindari komentar yang tidak relevan atau menyerang pribadi.
                        </p>
                    </li>
                    <li>
                        <h3>Hati-hati dengan sumber informasi:</h3>
                        <ul>
                            <li>Pastikan informasi yang Anda bagikan akurat dan dapat dipertanggungjawabkan.</li>
                            <li>Berikan sumber referensi atau tautan yang relevan jika memungkinkan.</li>
                        </ul>
                    </li>
                    <li>
                        <h3>Laporkan pelanggaran:</h3>
                        <ul>
                            <li>Jika Anda menemui perilaku tidak pantas, spam, atau pelanggaran lainnya, laporkan kepada administrator forum.</li>
                            <li>Sertakan bukti dan informasi yang relevan dalam laporan Anda.</li>
                        </ul>
                    </li>
                    <li>
                        <h3>Tidak ada promosi atau iklan:</h3>
                        <p>
                            Dilarang mempromosikan produk, layanan, atau iklan di forum, kecuali ada persetujuan khusus dari administrator.
                        </p>
                    </li>
                    <li>
                        <h3>Tetap patuhi aturan hukum:</h3>
                        <ul>
                            <li>Jangan melakukan tindakan ilegal atau melanggar hukum dalam forum.</li>
                            <li>Hindari penyebaran konten yang melanggar hak cipta, pornografi, atau yang melanggar undang-undang lainnya.</li>
                        </ul>
                    </li>
                    <li>
                        <h3>Jaga etika forum:</h3>
                        <ul>
                            <li>Ikuti pedoman dan peraturan yang ditetapkan oleh administrator forum.</li>
                            <li>Jika ada pertanyaan atau ketidakjelasan tentang pedoman, tanyakan kepada administrator atau moderator.</li>
                        </ul>
                    </li>
                </ol>
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