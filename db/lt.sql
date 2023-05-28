-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Bulan Mei 2023 pada 17.41
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lt`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `faq`
--

CREATE TABLE `faq` (
  `id_faqs` int(11) NOT NULL,
  `Pertanyaan` varchar(255) DEFAULT NULL,
  `Jawaban` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `guidelines` (
  `id_guidelines` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `guidelines`
--



-- --------------------------------------------------------

--
-- Struktur dari tabel `materi`
--

CREATE TABLE `materi` (
  `id_materi` int(11) NOT NULL,
  `title_materi` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `link_video` varchar(255) DEFAULT NULL,
  `id_pengajar` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `materi`
--

CREATE TABLE `profilepengajar` (
  `id_pengajar` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `pekerjaan` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `relasi_topics_category` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `relasi_topics_category`
--


CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(6) UNSIGNED NOT NULL,
  `token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `timeline`
--

CREATE TABLE `timeline` (
  `id_timeline` int(11) NOT NULL,
  `user_id` int(12) UNSIGNED DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `created_date` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `timeline_comments` (
  `id_timeline_comment` int(11) NOT NULL,
  `comments` text DEFAULT NULL,
  `timeline_id` int(11) DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `topics` (
  `id_topics` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `followers` int(11) DEFAULT 0,
  `img` longblob DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `topics_category` (
  `id_t_category` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `topics_comments` (
  `id_t_comments` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `topic_id` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `topics_followers` (
  `id_t_follower` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `topic_id` int(11) NOT NULL,
  `followed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `topics_views` (
  `id_t_view` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `viewed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

truktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(6) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `users_image` mediumblob DEFAULT NULL,
  `post_created_count` int(11) DEFAULT 0,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Indeks untuk tabel `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id_faqs`);

--
-- Indeks untuk tabel `guidelines`
--
ALTER TABLE `guidelines`
  ADD PRIMARY KEY (`id_guidelines`);

--
-- Indeks untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`),
  ADD KEY `id_pengajar` (`id_pengajar`);

--
-- Indeks untuk tabel `profilepengajar`
--
ALTER TABLE `profilepengajar`
  ADD PRIMARY KEY (`id_pengajar`);

--
-- Indeks untuk tabel `relasi_topics_category`
--
ALTER TABLE `relasi_topics_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `relasi_topics_category_ibfk_1` (`topic_id`),
  ADD KEY `relasi_topics_category_ibfk_2` (`category_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_ibfk_1` (`user_id`);

--
-- Indeks untuk tabel `timeline`
--
ALTER TABLE `timeline`
  ADD PRIMARY KEY (`id_timeline`),
  ADD KEY `timeline_ibfk_1` (`user_id`);

--
-- Indeks untuk tabel `timeline_comments`
--
ALTER TABLE `timeline_comments`
  ADD PRIMARY KEY (`id_timeline_comment`),
  ADD KEY `timeline_comments_ibfk_2` (`user_id`),
  ADD KEY `timeline_id` (`timeline_id`);

--
-- Indeks untuk tabel `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id_topics`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `topics_category`
--
ALTER TABLE `topics_category`
  ADD PRIMARY KEY (`id_t_category`);

--
-- Indeks untuk tabel `topics_comments`
--
ALTER TABLE `topics_comments`
  ADD PRIMARY KEY (`id_t_comments`),
  ADD KEY `topics_comments_ibfk_1` (`topic_id`),
  ADD KEY `topics_comments_ibfk_2` (`user_id`);

--
-- Indeks untuk tabel `topics_followers`
--
ALTER TABLE `topics_followers`
  ADD PRIMARY KEY (`id_t_follower`),
  ADD KEY `topics_followers_ibfk_1` (`user_id`),
  ADD KEY `topics_followers_ibfk_2` (`topic_id`);

--
-- Indeks untuk tabel `topics_views`
--
ALTER TABLE `topics_views`
  ADD PRIMARY KEY (`id_t_view`),
  ADD KEY `fk_topic` (`topic_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `relasi_topics_category`
--
ALTER TABLE `relasi_topics_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT untuk tabel `timeline`
--
ALTER TABLE `timeline`
  MODIFY `id_timeline` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `timeline_comments`
--
ALTER TABLE `timeline_comments`
  MODIFY `id_timeline_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT untuk tabel `topics`
--
ALTER TABLE `topics`
  MODIFY `id_topics` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `topics_category`
--
ALTER TABLE `topics_category`
  MODIFY `id_t_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `topics_comments`
--
ALTER TABLE `topics_comments`
  MODIFY `id_t_comments` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `topics_followers`
--
ALTER TABLE `topics_followers`
  MODIFY `id_t_follower` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT untuk tabel `topics_views`
--
ALTER TABLE `topics_views`
  MODIFY `id_t_view` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=425;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`id_pengajar`) REFERENCES `profilepengajar` (`id_pengajar`) ON DELETE CASCADE ON UPDATE CASCADE;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
