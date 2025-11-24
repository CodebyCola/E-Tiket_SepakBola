-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Nov 2025 pada 13.36
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `etiket_sepakbola`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(12) NOT NULL,
  `namaLengkap` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(16) DEFAULT NULL,
  `jumlah_tiket` int(12) DEFAULT NULL,
  `total_harga` int(12) DEFAULT NULL,
  `tanggal_beli` date DEFAULT current_timestamp(),
  `status` enum('Pending','Paid') DEFAULT 'Pending',
  `id_match` int(20) DEFAULT NULL,
  `id_user` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `namaLengkap`, `email`, `no_hp`, `jumlah_tiket`, `total_harga`, `tanggal_beli`, `status`, `id_match`, `id_user`) VALUES
(3, 'Nicolaus Narindra Lianto', 'nicolaus@gmail.com', '089694053081', 2, 640000, '2025-11-24', 'Paid', 16, 2),
(4, 'Nicolaus Narindra Lianto', 'nicolaus@gmail.com', '089694053081', 4, 1120000, '2025-11-24', 'Pending', 17, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pertandingan`
--

CREATE TABLE `pertandingan` (
  `id_match` int(20) NOT NULL,
  `tim_home` int(12) DEFAULT NULL,
  `tim_away` int(12) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu` time DEFAULT NULL,
  `lokasi` varchar(200) DEFAULT NULL,
  `harga_tiket` int(12) DEFAULT NULL,
  `stok_tiket` int(12) DEFAULT NULL,
  `skor_home` int(11) DEFAULT NULL,
  `skor_away` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pertandingan`
--

INSERT INTO `pertandingan` (`id_match`, `tim_home`, `tim_away`, `tanggal`, `waktu`, `lokasi`, `harga_tiket`, `stok_tiket`, `skor_home`, `skor_away`) VALUES
(1, 1, 2, '2025-01-05', '20:00:00', 'Old Trafford', 250000, 0, 2, 1),
(2, 3, 4, '2025-01-07', '19:30:00', 'Anfield', 300000, 0, 1, 3),
(3, 5, 6, '2025-01-09', '21:00:00', 'Etihad Stadium', 270000, 0, 0, 2),
(4, 2, 3, '2025-01-12', '20:00:00', 'Stamford Bridge', 240000, 0, 2, 2),
(5, 4, 5, '2025-01-15', '19:00:00', 'Emirates Stadium', 320000, 0, 3, 1),
(6, 6, 1, '2025-01-17', '21:00:00', 'Tottenham Stadium', 260000, 0, 1, 0),
(7, 3, 1, '2025-01-20', '20:00:00', 'Anfield', 310000, 0, 2, 1),
(8, 2, 4, '2025-01-22', '19:30:00', 'Stamford Bridge', 250000, 0, 0, 0),
(9, 6, 3, '2025-01-25', '21:00:00', 'Tottenham Stadium', 270000, 0, 1, 3),
(10, 5, 2, '2025-01-28', '20:00:00', 'Etihad Stadium', 300000, 0, 2, 1),
(11, 4, 6, '2025-02-02', '19:00:00', 'Emirates Stadium', 260000, 0, 3, 2),
(12, 1, 4, '2025-02-05', '20:00:00', 'Old Trafford', 290000, 0, 1, 1),
(13, 2, 5, '2025-02-10', '21:00:00', 'Stamford Bridge', 255000, 0, 0, 2),
(14, 3, 6, '2025-02-12', '19:30:00', 'Anfield', 280000, 0, 4, 3),
(15, 5, 3, '2025-02-20', '20:00:00', 'Etihad Stadium', 330000, 0, 2, 0),
(16, 4, 1, '2025-03-10', '20:00:00', 'Emirates Stadium', 320000, 198, NULL, NULL),
(17, 6, 2, '2025-03-12', '19:00:00', 'Tottenham Stadium', 280000, 146, NULL, NULL),
(18, 3, 5, '2025-03-15', '21:00:00', 'Anfield', 330000, 180, NULL, NULL),
(19, 1, 4, '2025-03-19', '20:00:00', 'Old Trafford', 300000, 170, NULL, NULL),
(20, 2, 6, '2025-03-22', '19:30:00', 'Stamford Bridge', 260000, 160, NULL, NULL),
(21, 6, 5, '2025-03-25', '21:00:00', 'Tottenham Stadium', 310000, 180, NULL, NULL),
(22, 5, 4, '2025-03-28', '20:00:00', 'Etihad Stadium', 350000, 200, NULL, NULL),
(23, 3, 2, '2025-04-02', '19:00:00', 'Anfield', 290000, 190, NULL, NULL),
(24, 4, 3, '2025-04-05', '21:00:00', 'Emirates Stadium', 340000, 175, NULL, NULL),
(25, 2, 1, '2025-04-08', '20:00:00', 'Stamford Bridge', 270000, 155, NULL, NULL),
(26, 1, 6, '2025-04-12', '19:00:00', 'Old Trafford', 310000, 180, NULL, NULL),
(27, 5, 3, '2025-04-15', '21:00:00', 'Etihad Stadium', 360000, 190, NULL, NULL),
(28, 6, 4, '2025-04-18', '20:00:00', 'Tottenham Stadium', 300000, 140, NULL, NULL),
(29, 4, 2, '2025-04-20', '19:00:00', 'Emirates Stadium', 320000, 160, NULL, NULL),
(30, 3, 1, '2025-04-25', '20:00:00', 'Anfield', 330000, 200, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `reviews`
--

CREATE TABLE `reviews` (
  `id_review` int(12) NOT NULL,
  `id_user` int(12) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `komentar` varchar(255) DEFAULT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp(),
  `rating` tinyint(1) DEFAULT NULL,
  `status` enum('menunggu','disetujui','ditolak') NOT NULL DEFAULT 'menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reviews`
--

INSERT INTO `reviews` (`id_review`, `id_user`, `nama`, `komentar`, `tanggal`, `rating`, `status`) VALUES
(1, 2, 'Nico', 'Website ini keren banget!, layanannya cepat dan keaslian tiketnya terjamin. Pokoknya jos deh!', '2025-11-11 21:02:12', 5, 'disetujui');

-- --------------------------------------------------------

--
-- Struktur dari tabel `teams`
--

CREATE TABLE `teams` (
  `id_team` int(12) NOT NULL,
  `nama_team` varchar(255) DEFAULT NULL,
  `stadium` varchar(255) DEFAULT NULL,
  `logo_team` varchar(255) DEFAULT NULL,
  `primary_color` varchar(8) DEFAULT NULL,
  `secondary_color` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `teams`
--

INSERT INTO `teams` (`id_team`, `nama_team`, `stadium`, `logo_team`, `primary_color`, `secondary_color`) VALUES
(1, 'Manchester United', 'Old Trafford', '../Assets/images/LogoTeam/manutd.png', '#DA291C', '#FBE122'),
(2, 'Chelsea', 'Stamford Bridge', '../Assets/images/LogoTeam/chelsea.png', '#034694', '#0A1A3B'),
(3, 'Liverpool', 'Anfield', '../Assets/images/LogoTeam/liverpool.png', '#C8102E', '#00A398'),
(4, 'Arsenal', 'Emirates Stadium', '../Assets/images/LogoTeam/arsenal.png', '#EF0107', '#063672'),
(5, 'Manchester City', 'Etihad Stadium', '../Assets/images/LogoTeam/mancity.png', '#6CABDD', '#004C97'),
(6, 'Tottenham Hotspur', 'Tottenham Stadium', '../Assets/images/LogoTeam/totham.png', '#F6F6F6', '#FFFFFF');

-- --------------------------------------------------------

--
-- Struktur dari tabel `team_stats`
--

CREATE TABLE `team_stats` (
  `id_stats` int(11) NOT NULL,
  `id_team` int(11) NOT NULL,
  `league_position` int(11) DEFAULT NULL,
  `played` int(11) DEFAULT 0,
  `wins` int(11) DEFAULT 0,
  `draws` int(11) DEFAULT 0,
  `losses` int(11) DEFAULT 0,
  `goals` int(11) DEFAULT 0,
  `points` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `team_stats`
--

INSERT INTO `team_stats` (`id_stats`, `id_team`, `league_position`, `played`, `wins`, `draws`, `losses`, `goals`, `points`) VALUES
(1, 1, 7, 4, 1, 1, 2, 4, 4),
(2, 2, 10, 5, 0, 2, 3, 4, 2),
(3, 3, 3, 6, 3, 1, 2, 12, 10),
(4, 4, 1, 5, 3, 2, 0, 10, 11),
(5, 5, 2, 5, 3, 0, 2, 7, 9),
(6, 6, 5, 5, 2, 0, 3, 9, 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(12) NOT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `nama_lengkap` varchar(200) DEFAULT NULL,
  `telp` varchar(16) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama`, `nama_lengkap`, `telp`, `tanggal_lahir`, `email`, `password`, `role`) VALUES
(2, 'nico', 'Nicolaus Narindra Lianto', '089694053081', '2006-05-05', 'nicolaus@gmail.com', '$2y$10$FHn8OAoU4Nje6V0yxUZdsOfMifprZb17BG5qOcPrIkVZCC3ucYJ6O', 'user'),
(3, 'rafli', 'Rafli Wibowo', '081232342453', '2006-08-24', 'rafli@gmail.com', '$2y$10$6FBLyvI56R2reiwFCG48Y.rlaVwCDNa8zQdUKACMia94qUlSeBFwO', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `id_match` (`id_match`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `pertandingan`
--
ALTER TABLE `pertandingan`
  ADD PRIMARY KEY (`id_match`),
  ADD KEY `tim_home` (`tim_home`),
  ADD KEY `tim_away` (`tim_away`);

--
-- Indeks untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id_review`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id_team`),
  ADD UNIQUE KEY `nama_team` (`nama_team`);

--
-- Indeks untuk tabel `team_stats`
--
ALTER TABLE `team_stats`
  ADD PRIMARY KEY (`id_stats`),
  ADD KEY `id_team` (`id_team`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `nama` (`nama`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pertandingan`
--
ALTER TABLE `pertandingan`
  MODIFY `id_match` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id_review` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `team_stats`
--
ALTER TABLE `team_stats`
  MODIFY `id_stats` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `id_match` FOREIGN KEY (`id_match`) REFERENCES `pertandingan` (`id_match`),
  ADD CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `pertandingan`
--
ALTER TABLE `pertandingan`
  ADD CONSTRAINT `tim_away` FOREIGN KEY (`tim_away`) REFERENCES `teams` (`id_team`),
  ADD CONSTRAINT `tim_home` FOREIGN KEY (`tim_home`) REFERENCES `teams` (`id_team`);

--
-- Ketidakleluasaan untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `team_stats`
--
ALTER TABLE `team_stats`
  ADD CONSTRAINT `id_team` FOREIGN KEY (`id_team`) REFERENCES `teams` (`id_team`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
