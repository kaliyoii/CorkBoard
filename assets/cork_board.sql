-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Waktu pembuatan: 19 Okt 2025 pada 16.22
-- Versi server: 8.0.40
-- Versi PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cork_board`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `boards`
--

CREATE TABLE `boards` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `color` varchar(20) DEFAULT '#ffffff',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `notes`
--

CREATE TABLE `notes` (
  `id` int NOT NULL,
  `board_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `note_content`
--

CREATE TABLE `note_content` (
  `note_id` int NOT NULL,
  `content` text NOT NULL,
  `color` varchar(20) DEFAULT '#ffffff',
  `pin_color` varchar(20) DEFAULT '#ff2400',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `note_layout`
--

CREATE TABLE `note_layout` (
  `note_id` int NOT NULL,
  `pos_x` int DEFAULT '0',
  `pos_y` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_admin` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `created_at`, `is_admin`) VALUES
(1, 'budi', 'budi@budi.com', '$2y$10$hHdr46W8MHqtES3mIF1WWOA4e4xwX6a7UcxuZNjb2PZnKbyNe3sSi', '2025-10-19 16:04:44', 0);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_user_notes`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_user_notes` (
`user_id` int
,`username` varchar(50)
,`board_id` int
,`board` varchar(100)
,`board_create` timestamp
,`note_id` int
,`note_create` timestamp
,`note_update` timestamp
);

-- --------------------------------------------------------

--
-- Struktur untuk view `view_user_notes`
--
DROP TABLE IF EXISTS `view_user_notes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_user_notes`  AS SELECT `b`.`user_id` AS `user_id`, `u`.`username` AS `username`, `n`.`board_id` AS `board_id`, `b`.`title` AS `board`, `b`.`created_at` AS `board_create`, `n`.`id` AS `note_id`, `nc`.`created_at` AS `note_create`, `nc`.`updated_at` AS `note_update` FROM (((`notes` `n` join `boards` `b` on((`n`.`board_id` = `b`.`id`))) join `users` `u` on((`b`.`user_id` = `u`.`id`))) join `note_content` `nc` on((`nc`.`note_id` = `n`.`id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `boards`
--
ALTER TABLE `boards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_boards_user` (`user_id`);

--
-- Indeks untuk tabel `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_notes_board` (`board_id`);

--
-- Indeks untuk tabel `note_content`
--
ALTER TABLE `note_content`
  ADD PRIMARY KEY (`note_id`);

--
-- Indeks untuk tabel `note_layout`
--
ALTER TABLE `note_layout`
  ADD PRIMARY KEY (`note_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `boards`
--
ALTER TABLE `boards`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `boards`
--
ALTER TABLE `boards`
  ADD CONSTRAINT `boards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `note_content`
--
ALTER TABLE `note_content`
  ADD CONSTRAINT `note_content_ibfk_1` FOREIGN KEY (`note_id`) REFERENCES `notes` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `note_layout`
--
ALTER TABLE `note_layout`
  ADD CONSTRAINT `note_layout_ibfk_1` FOREIGN KEY (`note_id`) REFERENCES `notes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
