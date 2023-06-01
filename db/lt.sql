

CREATE TABLE `faq` (
  `id_faqs` int(11) NOT NULL,
  `Pertanyaan` varchar(255) DEFAULT NULL,
  `Jawaban` varchar(255) DEFAULT NULL
)


CREATE TABLE `guidelines` (
  `id_guidelines` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
)



CREATE TABLE `materi` (
  `id_materi` int(11) NOT NULL,
  `title_materi` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `link_video` varchar(255) DEFAULT NULL,
  `id_pengajar` int(11) DEFAULT NULL
)



CREATE TABLE `profilepengajar` (
  `id_pengajar` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `pekerjaan` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL
)



CREATE TABLE `relasi_topics_category` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
)


CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(6) UNSIGNED NOT NULL,
  `token` varchar(100) NOT NULL
)



INSERT INTO `sessions` (`id`, `user_id`, `token`) VALUES
(142, 7, '574600c79d7da85f220c29f1ac014edc'),
(143, 6, '7c729f209b4ab8e45442a053c0ade3f0'),
(158, 1, '465fcaf662e9e83d9ca549aaa1079e3c');



CREATE TABLE `timeline` (
  `id_timeline` int(11) NOT NULL,
  `user_id` int(12) UNSIGNED DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `created_date` date DEFAULT current_timestamp()
)


CREATE TABLE `timeline_comments` (
  `id_timeline_comment` int(11) NOT NULL,
  `comments` text DEFAULT NULL,
  `timeline_id` int(11) DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL
)



CREATE TABLE `topics` (
  `id_topics` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `followers` int(11) DEFAULT 0,
  `img` longblob DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
)


CREATE TABLE `topics_category` (
  `id_t_category` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
)


CREATE TABLE `topics_comments` (
  `id_t_comments` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `topic_id` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
)

CREATE TABLE `topics_followers` (
  `id_t_follower` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `topic_id` int(11) NOT NULL,
  `followed_at` timestamp NOT NULL DEFAULT current_timestamp()
)

CREATE TABLE `topics_views` (
  `id_t_view` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `viewed_at` datetime DEFAULT NULL
)



CREATE TABLE `users` (
  `id_user` int(6) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `users_image` longblob DEFAULT NULL,
  `post_created_count` int(11) DEFAULT 0,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
)

ALTER TABLE `faq`
  ADD PRIMARY KEY (`id_faqs`);

ALTER TABLE `guidelines`
  ADD PRIMARY KEY (`id_guidelines`);


ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`),
  ADD KEY `id_pengajar` (`id_pengajar`);



ALTER TABLE `profilepengajar`
  ADD PRIMARY KEY (`id_pengajar`);


ALTER TABLE `relasi_topics_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `relasi_topics_category_ibfk_1` (`topic_id`),
  ADD KEY `relasi_topics_category_ibfk_2` (`category_id`);


ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_ibfk_1` (`user_id`);


ALTER TABLE `timeline`
  ADD PRIMARY KEY (`id_timeline`),
  ADD KEY `timeline_ibfk_1` (`user_id`);


ALTER TABLE `timeline_comments`
  ADD PRIMARY KEY (`id_timeline_comment`),
  ADD KEY `timeline_comments_ibfk_2` (`user_id`),
  ADD KEY `timeline_id` (`timeline_id`);


ALTER TABLE `topics`
  ADD PRIMARY KEY (`id_topics`),
  ADD KEY `user_id` (`user_id`);


ALTER TABLE `topics_category`
  ADD PRIMARY KEY (`id_t_category`);

ALTER TABLE `topics_comments`
  ADD PRIMARY KEY (`id_t_comments`),
  ADD KEY `topics_comments_ibfk_1` (`topic_id`),
  ADD KEY `topics_comments_ibfk_2` (`user_id`);


ALTER TABLE `topics_followers`
  ADD PRIMARY KEY (`id_t_follower`),
  ADD KEY `topics_followers_ibfk_1` (`user_id`),
  ADD KEY `topics_followers_ibfk_2` (`topic_id`);

ALTER TABLE `topics_views`
  ADD PRIMARY KEY (`id_t_view`),
  ADD KEY `fk_topic` (`topic_id`),
  ADD KEY `fk_user` (`user_id`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);


ALTER TABLE `materi`
  MODIFY `id_materi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `relasi_topics_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

ALTER TABLE `timeline`
  MODIFY `id_timeline` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;


ALTER TABLE `timeline_comments`
  MODIFY `id_timeline_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

ALTER TABLE `topics`
  MODIFY `id_topics` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;


ALTER TABLE `topics_category`
  MODIFY `id_t_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

ALTER TABLE `topics_comments`
  MODIFY `id_t_comments` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

ALTER TABLE `topics_followers`
  MODIFY `id_t_follower` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

ALTER TABLE `topics_views`
  MODIFY `id_t_view` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=426;

ALTER TABLE `users`
  MODIFY `id_user` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`id_pengajar`) REFERENCES `profilepengajar` (`id_pengajar`);

--
-- Ketidakleluasaan untuk tabel `relasi_topics_category`
--
ALTER TABLE `relasi_topics_category`
  ADD CONSTRAINT `relasi_topics_category_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id_topics`) ON DELETE CASCADE,
  ADD CONSTRAINT `relasi_topics_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `topics_category` (`id_t_category`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `timeline`
--
ALTER TABLE `timeline`
  ADD CONSTRAINT `timeline_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `timeline_comments`
--
ALTER TABLE `timeline_comments`
  ADD CONSTRAINT `timeline_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `timeline_comments_ibfk_3` FOREIGN KEY (`timeline_id`) REFERENCES `timeline` (`id_timeline`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `topics_comments`
--
ALTER TABLE `topics_comments`
  ADD CONSTRAINT `topics_comments_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id_topics`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `topics_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `topics_followers`
--
ALTER TABLE `topics_followers`
  ADD CONSTRAINT `topics_followers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `topics_followers_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id_topics`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `topics_views`
--
ALTER TABLE `topics_views`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

INSERT INTO `topics_category` (`id_t_category`, `name`) VALUES
(1, 'Engish'),
(2, 'Math'),
(6, 'Arsitektur'),
(7, 'Bahasa'),
(8, 'Keterampilan'),
(9, 'Ekonomi'),
(10, 'Hukum'),
(11, 'Ilmu fisika'),
(12, 'Olahraga'),
(13, 'Ilmu Sosial'),
(14, 'Jurnalisme'),
(16, 'Manajemen Bisnis'),
(18, 'Pariwisata'),
(21, 'Pengelolaan'),
(22, 'Rekayasa'),
(24, 'Sastra'),
(25, 'Seni Drama'),
(26, 'Seni Rupa'),
(29, 'Teknologi'),
(36, 'Musik & Seni'),
(37, 'Teknosains'),
(41, 'Web Developer'),
(42, 'Data Science'),
(43, 'Keuangan'),
(44, 'Mobile Developer'),
(45, 'Designer'),
(46, 'Digital Marketing'),
(49, 'Manajemen Bisnis'),
(50, 'Studi Kesehatan');

INSERT INTO `timeline_comments` (`id_timeline_comment`, `comments`, `timeline_id`, `user_id`) VALUES
(4, NULL, 3, 7),
(56, 'tes dari sin', 11, 6),
(62, 'Tess\r\n', 11, 6),
(63, 'wahyu tes\r\n', 11, 7),
(64, 'rtes', 11, 6),
(65, 'rtes', 11, 6),
(66, 'Cobak Cari Post Dari Sin Pasti Bagus', 3, 6),
(67, 'Cobak Cari Post Dari Sin Pasti Bagus', 3, 6);

INSERT INTO `timeline` (`id_timeline`, `user_id`, `description`, `created_date`) VALUES
(1, 6, 'TES', '2023-05-28'),
(3, 6, 'Sedang Mencari Topics Yang Bagus ', '0000-00-00'),
(11, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet scelerisque turpis, ut ullamcorper urna. In ut consectetur libero, vel auctor metus. Mauris dapibus libero ac dolor fermentum, vel vulputate felis fermentum. Nunc a convallis neque. Ut pretium eget purus id scelerisque. Aliquam vel fermentum nisl. Nam in neque libero.\r\n\r\nDuis scelerisque auctor vulputate. Nullam non sapien vehicula, consectetur nulla quis, lacinia dolor. Phasellus ligula nulla, suscipit ut dictum at, laoreet a magna. Nunc tincidunt nulla tellus. Sed enim diam, congue vehicula erat eget, laoreet luctus ante. Curabitur placerat libero magna, eget vehicula tellus porttitor sit amet. In nec vulputate nisi. Vivamus ultrices ac orci ut sodales. Fusce non rutrum nulla. Aenean finibus elit ut nibh venenatis lacinia. Praesent ultricies suscipit convallis. Duis diam massa, posuere non semper vel, pretium eget nulla. Pellentesque et aliquet nisl.\r\n\r\nMauris ipsum mauris, eleifend et sodales ut, porttitor a nis', '0000-00-00');

INSERT INTO `profilepengajar` (`id_pengajar`, `nama`, `pekerjaan`, `instagram`, `youtube`) VALUES
(1, 'Eko Kurniawan Khaneddy', 'Technical Architect', 'https://www.instagram.com/ProgrammerZamanNow/', 'https://www.youtube.com/@ProgrammerZamanNow'),
(2, 'Sandhika Galih\r\n', 'Lecturer\r\n', 'https://www.instagram.com/sandhikagalih', 'https://www.youtube.com/@sandhikagalihWPU');


INSERT INTO `faq` (`id_faqs`, `Pertanyaan`, `Jawaban`) VALUES
(1, 'Apa itu website forum belajar LearnTogether?', 'Website forum belajar LearnTogether adalah platform online yang memungkinkan pengguna untuk berbagi pengetahuan, bertanya pertanyaan, dan berdiskusi tentang topik pembelajaran tertentu.'),
(2, 'Bagaimana cara bergabung dengan forum belajar pada website LearnTogether?', 'Untuk bergabung dengan forum belajar, Anda perlu membuat akun dengan mengisi formulir pendaftaran yang tersedia. Setelah itu, Anda dapat masuk ke akun Anda dan mulai berpartisipasi dalam diskusi.'),
(3, 'Apakah bergabung dengan forum belajar ini gratis?', 'Ya, bergabung dengan forum belajar ini adalah gratis. Tidak dikenakan biaya pendaftaran atau biaya langganan.'),
(4, 'Bagaimana cara mengajukan pertanyaan atau memulai diskusi baru di forum?', 'Anda dapat mengajukan pertanyaan atau memulai diskusi baru dengan menulis postingan baru di forum yang sesuai dengan topik yang ingin Anda bahas. Pastikan untuk memberikan judul yang jelas dan menjelaskan pertanyaan atau topik Anda dengan detail.'),
(5, 'Bagaimana cara mencari topik atau pertanyaan yang sudah dibahas sebelumnya di forum?', 'Anda dapat menggunakan fungsi pencarian di forum untuk mencari topik atau pertanyaan yang sudah dibahas sebelumnya. Gunakan kata kunci yang relevan untuk memperoleh hasil pencarian yang sesuai.'),
(6, 'Bagaimana cara mengubah atau menghapus postingan saya di forum?', ' Biasanya, Anda dapat mengubah atau menghapus postingan Anda sendiri di forum dengan menggunakan opsi \"edit\" atau \"hapus\" yang tersedia di setiap postingan yang Anda buat.');

INSERT INTO `guidelines` (`id_guidelines`, `title`, `description`) VALUES
(0, 'TEs', '123'),
(1, 'Hargai anggota forum:', 'Bersikaplah sopan dan hormat terhadap semua anggota forum. Hindari penggunaan bahasa kasar, pelecehan, atau ancaman dalam komunikasi. Saling menghargai pendapat dan pengalaman setiap anggota.'),
(2, 'Buat postingan yang bermanfaat:', 'Pastikan postingan Anda relevan dengan topik pembelajaran. Tulis dengan jelas dan komunikatif agar mudah dipahami. Berikan argumen dan bukti yang mendukung pendapat atau jawaban Anda.'),
(3, 'Cari sebelum bertanya:', 'Gunakan fungsi pencarian forum untuk memastikan bahwa pertanyaan Anda belum dibahas sebelumnya. Baca thread atau topik serupa sebelum mengajukan pertanyaan baru.'),
(4, 'Berikan umpan balik yang konstruktif:', ' Jika Anda memberikan umpan balik atau kritik, pastikan agar tetap bersifat konstruktif dan membantu. Hindari komentar yang tidak relevan atau menyerang pribadi.'),
(5, 'Hati-hati dengan sumber informasi:', 'Pastikan informasi yang Anda bagikan akurat dan dapat dipertanggungjawabkan.\r\nBerikan sumber referensi atau tautan yang relevan jika memungkinkan.'),
(6, 'Laporkan pelanggaran:', 'Jika Anda menemui perilaku tidak pantas, spam, atau pelanggaran lainnya, laporkan kepada administrator forum.\r\nSertakan bukti dan informasi yang relevan dalam laporan Anda.'),
(7, 'Tidak ada promosi atau iklan:', 'Dilarang mempromosikan produk, layanan, atau iklan di forum, kecuali ada persetujuan khusus dari administrator.'),
(8, 'Tetap patuhi aturan hukum:', 'Jangan melakukan tindakan ilegal atau melanggar hukum dalam forum.\r\nHindari penyebaran konten yang melanggar hak cipta, pornografi, atau yang melanggar undang-undang lainnya.'),
(9, 'Jaga etika forum:', 'Ikuti pedoman dan peraturan yang ditetapkan oleh administrator forum.\r\nJika ada pertanyaan atau ketidakjelasan tentang pedoman, tanyakan kepada administrator atau moderator.');


INSERT INTO `materi` (`id_materi`, `title_materi`, `description`, `link_video`, `id_pengajar`) VALUES
(1, 'Membuat WEBSITE Kedai Kopi RESPONSIVE dengan HTML & CSS dari 0 + Autodeploy ke WEB HOSTING', 'Siap2 gaes, kita bakalan bikin website dari 0 sampai jadi dan bisa diakses semua orang, hanya menggunakan HTML, CSS dan sedikit JS saja tanpa library dan framework apapun. Tapi sebelumnya, mari ngopi dulu ~', 'https://www.youtube.com/watch?v=MCVkMmYL-aY', 2),
(2, 'Tips Belajar (Programming) ala Atomic Habits', 'kita akan membahas mengenai buku Atomic Habits karangan James Clear mengenai cara membentuk kebiasaan kecil untuk mencapai hasil yang menakjubkan, dan tips-tipsnya akan kita terapkan di pembelajaran kita.', 'https://www.youtube.com/watch?v=kjz71QXT-ew', 2),
(3, 'TUTORIAL JAVASCRIPT DASAR BAHASA INDONESIA', 'kita akan bahas tuntas dan lengkap selama 8 jam tentang JavaScript Dasar.', 'https://www.youtube.com/watch?v=SDROba_M42g&list=PL-CtdCApEFH8SS0Gsj9_a0cC0jypFEoSg', 1);
