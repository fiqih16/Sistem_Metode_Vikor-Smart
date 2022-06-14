-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 03 Apr 2022 pada 14.01
-- Versi Server: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_smart_native`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE IF NOT EXISTS `alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `nama`) VALUES
(11, 'Lastin'),
(12, 'Sujoko/Saturi'),
(13, 'Hasyim'),
(14, 'Suwito'),
(15, 'Intan Ratnasari'),
(16, 'Kanifah'),
(17, 'H. Samsul'),
(18, 'Daroji'),
(19, 'Suparto'),
(20, 'Agus Purnomo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil`
--

CREATE TABLE IF NOT EXISTS `hasil` (
  `id_hasil` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `hasil`
--

INSERT INTO `hasil` (`id_hasil`, `id_alternatif`, `nilai`) VALUES
(1, 11, 0.75),
(2, 12, 0.548611),
(3, 13, 0.801852),
(4, 14, 0.861111),
(5, 15, 0.12963),
(6, 16, 0.666667),
(7, 17, 0.421296),
(8, 18, 0.622685),
(9, 19, 0.740741),
(10, 20, 0.694444);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE IF NOT EXISTS `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `kode_kriteria` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `type` enum('Benefit','Cost') NOT NULL,
  `bobot` float NOT NULL,
  `ada_pilihan` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `kode_kriteria`, `nama`, `type`, `bobot`, `ada_pilihan`) VALUES
(12, 'C1', 'Pinjaman', 'Cost', 20, 0),
(13, 'C2', 'Angsuran', 'Cost', 10, 0),
(14, 'C3', 'Jaminan', 'Benefit', 20, 1),
(15, 'C4', 'Status', 'Benefit', 70, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE IF NOT EXISTS `penilaian` (
  `id_penilaian` int(11) NOT NULL,
  `id_alternatif` int(10) NOT NULL,
  `id_kriteria` int(10) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `id_alternatif`, `id_kriteria`, `nilai`) VALUES
(95, 12, 12, 5000000),
(96, 12, 13, 10),
(97, 12, 14, 16),
(98, 12, 15, 4),
(99, 11, 12, 1000000),
(100, 11, 13, 12),
(101, 11, 14, 16),
(102, 11, 15, 5),
(103, 13, 12, 1200000),
(104, 13, 13, 6),
(105, 13, 14, 16),
(106, 13, 15, 5),
(107, 14, 12, 8000000),
(108, 14, 13, 4),
(109, 14, 14, 14),
(110, 14, 15, 5),
(111, 15, 12, 4000000),
(112, 15, 13, 10),
(113, 15, 14, 16),
(114, 15, 15, 1),
(115, 16, 12, 10000000),
(116, 16, 13, 3),
(117, 16, 14, 16),
(118, 16, 15, 5),
(119, 17, 12, 6000000),
(120, 17, 13, 6),
(121, 17, 14, 16),
(122, 17, 15, 3),
(123, 18, 12, 3000000),
(124, 18, 13, 6),
(125, 18, 14, 16),
(126, 18, 15, 4),
(127, 19, 12, 9000000),
(128, 19, 13, 6),
(129, 19, 14, 15),
(130, 19, 15, 5),
(131, 20, 12, 5000000),
(132, 20, 13, 10),
(133, 20, 14, 16),
(134, 20, 15, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_kriteria`
--

CREATE TABLE IF NOT EXISTS `sub_kriteria` (
  `id_sub_kriteria` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_sub_kriteria`, `id_kriteria`, `nama`, `nilai`) VALUES
(14, 14, '	BPKB Mobil', 5),
(15, 14, 'SK Kios', 4),
(16, 14, 'BPKB Motor', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(5) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama` varchar(70) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `role` char(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `email`, `role`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Admin', 'admin@gmail.com', '1'),
(8, 'user', '12dea96fec20593566ab75692c9949596833adc9', 'User', 'user@gmail.com', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indexes for table `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`id_hasil`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`);

--
-- Indexes for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_sub_kriteria`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `hasil`
--
ALTER TABLE `hasil`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=135;
--
-- AUTO_INCREMENT for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub_kriteria` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- DB Vikor
CREATE TABLE IF NOT EXISTS `alternatif_v` (
  `id_alternatif_v` int(11) NOT NULL,
  `nama_v` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO `alternatif_v` (`id_alternatif_v`, `nama_v`) VALUES
(1, 'Alternatif 1'),
(2, 'Alternatif 2'),
(3, 'Alternatif 3'),
(4, 'Alternatif 4'),
(5, 'Alternatif 5'),
(6, 'Alternatif 6');

CREATE TABLE IF NOT EXISTS `hasil_v` (
  `id_hasil_v` int(11) NOT NULL,
  `id_alternatif_v` int(11) NOT NULL,
  `nilai_v` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO `hasil_v` (`id_hasil_v`, `id_alternatif_v`, `nilai_v`) VALUES
(1, 1, 0.4018),
(2, 2, 0.0798),
(3, 3, 0.4737),
(4, 4, 0.9131),
(5, 5, 0),
(6, 6, 1);

CREATE TABLE IF NOT EXISTS `kriteria_v` (
  `id_kriteria_v` int(11) NOT NULL,
  `kode_kriteria_v` varchar(10) NOT NULL,
  `nama_v` varchar(50) NOT NULL,
  `bobot_v` float NOT NULL,
  `ada_pilihan_v` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO `kriteria_v` (`id_kriteria_v`, `kode_kriteria_v`, `nama_v`, `bobot_v`, `ada_pilihan_v`) VALUES
(1, 'C1', 'Efisiensi Keuangan', 0.3, 1),
(2, 'C2', 'Absensi', 0.15, 0),
(3, 'C3', 'Masa Jabatan', 0.1, 0),
(4, 'C4', 'Memiliki Keterampilan Teknis', 0.25, 0),
(5, 'C5', 'Inovatif', 0.2, 0);

CREATE TABLE IF NOT EXISTS `penilaian_v` (
  `id_penilaian_v` int(11) NOT NULL,
  `id_alternatif_v` int(10) NOT NULL,
  `id_kriteria_v` int(10) NOT NULL,
  `nilai_v` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

INSERT INTO `penilaian_v` (`id_penilaian_v`, `id_alternatif_v`, `id_kriteria_v`, `nilai_v`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 50),
(3, 1, 3, 40),
(4, 1, 4, 50),
(5, 1, 5, 30),
(6, 2, 1, 1),
(7, 2, 2, 40),
(8, 2, 3, 20),
(9, 2, 4, 50),
(10, 2, 5, 50),
(11, 3, 1, 1),
(12, 3, 2, 50),
(13, 3, 3, 10),
(14, 3, 4, 50),
(15, 3, 5, 30),
(16, 4, 1, 2),
(17, 4, 2, 20),
(18, 4, 3, 30),
(19, 4, 4, 50),
(20, 4, 5, 30),
(21, 5, 1, 1),
(22, 5, 2, 40),
(23, 5, 3, 30),
(24, 5, 4, 50),
(25, 5, 5, 50),
(26, 6, 1, 2),
(27, 6, 2, 10),
(28, 6, 3, 20),
(29, 6, 4, 30),
(30, 6, 5, 50);

CREATE TABLE IF NOT EXISTS `sub_kriteria_v` (
  `id_sub_kriteria_v` int(11) NOT NULL,
  `id_kriteria_v` int(11) NOT NULL,
  `nama_v` varchar(50) NOT NULL,
  `nilai_v` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO `sub_kriteria_v` (`id_sub_kriteria_v`, `id_kriteria_v`, `nama_v`, `nilai_v`) VALUES
(1, 1, 'Sangat Baik', 50),
(2, 1, 'Baik', 40),
(3, 1, 'Cukup', 30),
(4, 1, 'Buruk', 20),
(5, 1, 'Sangat Buruk', 10);


ALTER TABLE `alternatif_v`
  ADD PRIMARY KEY (`id_alternatif_v`);

--
-- Indexes for table `hasil`
--
ALTER TABLE `hasil_v`
  ADD PRIMARY KEY (`id_hasil_v`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria_v`
  ADD PRIMARY KEY (`id_kriteria_v`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian_v`
  ADD PRIMARY KEY (`id_penilaian_v`);

--
-- Indexes for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria_v`
  ADD PRIMARY KEY (`id_sub_kriteria_v`);

--
-- Indexes for table `user`
--
-- ALTER TABLE `user`
--   ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternatif`
--
ALTER TABLE `alternatif_v`
  MODIFY `id_alternatif_v` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `hasil`
--
ALTER TABLE `hasil_v`
  MODIFY `id_hasil_v` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria_v`
  MODIFY `id_kriteria_v` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian_v`
  MODIFY `id_penilaian_v` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria_v`
  MODIFY `id_sub_kriteria_v` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
-- ALTER TABLE `user`
--   MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;

-- End DB Vikor