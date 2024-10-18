-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2024 at 06:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-learn`
--

-- --------------------------------------------------------

--
-- Table structure for table `ahli_kumpulan`
--

CREATE TABLE `ahli_kumpulan` (
  `kumpulan_id` int(10) NOT NULL,
  `pelajar_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ahli_kumpulan`
--

INSERT INTO `ahli_kumpulan` (`kumpulan_id`, `pelajar_id`) VALUES
(2, 1),
(2, 3),
(8, 5),
(8, 6);

-- --------------------------------------------------------

--
-- Table structure for table `cikgu`
--

CREATE TABLE `cikgu` (
  `cikgu_id` int(11) NOT NULL,
  `nama_cikgu` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `kata_laluan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cikgu`
--

INSERT INTO `cikgu` (`cikgu_id`, `nama_cikgu`, `email`, `kata_laluan`) VALUES
(1, 'haziq hakimi', 'haziq@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `kandungan`
--

CREATE TABLE `kandungan` (
  `kandungan_id` int(10) NOT NULL,
  `nama_kandungan` varchar(100) NOT NULL,
  `deskripsi_kandungan` varchar(500) NOT NULL,
  `kandungan_path` varchar(500) NOT NULL,
  `urutan_kandungan` int(10) NOT NULL,
  `sp_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kandungan`
--

INSERT INTO `kandungan` (`kandungan_id`, `nama_kandungan`, `deskripsi_kandungan`, `kandungan_path`, `urutan_kandungan`, `sp_id`) VALUES
(21, 'Maksud atur cara komputer ', 'Maksud atur cara komputer ialah urutan arahan berkod yang dimasukkan di dalam komputer bagi membolehkan data diproses oleh komputer.', '../uploads/test1.pdf', 3, 1),
(25, '', 'Mengenal pasti algoritma iaitu pseudokod dan carta alir. ', '../uploads/6.1.2_1.pdf', 1, 23),
(26, '', '', '../uploads/6.1.3.pdf', 1, 24),
(27, '', '', '../uploads/6.1.4.pdf', 1, 25),
(28, '', '', '../uploads/6.1.5.pdf', 1, 26),
(31, 'contoh', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/pp1kLRmBabs?si=GPznQG0LT64MWF1f\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', '../uploads/test1_1.pdf', 2, 26),
(35, '', 'vadio', '../uploads/1 Minute Sample Video.mp4', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kandungan_kuiz`
--

CREATE TABLE `kandungan_kuiz` (
  `kandungan_kuiz_id` int(10) NOT NULL,
  `deskripsi_kandungan` varchar(500) DEFAULT NULL,
  `kandungan_path` varchar(500) DEFAULT NULL,
  `pautan_url` varchar(500) DEFAULT NULL,
  `urutan_kandungan` int(10) NOT NULL,
  `kuiz_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kandungan_kuiz`
--

INSERT INTO `kandungan_kuiz` (`kandungan_kuiz_id`, `deskripsi_kandungan`, `kandungan_path`, `pautan_url`, `urutan_kandungan`, `kuiz_id`) VALUES
(3, 'adventure time', '../uploads/293414.jpg', '', 2, 1),
(5, 'Sila kilk pautan ini untuk menjawab kuiz', '', 'https://www.youtube.com/results?search_query=roblox+scp', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kandungan_tugasan`
--

CREATE TABLE `kandungan_tugasan` (
  `kandungan_tugasan_id` int(10) NOT NULL,
  `deskripsi_kandungan` varchar(500) DEFAULT NULL,
  `kandungan_path` varchar(500) DEFAULT NULL,
  `pautan_url` varchar(500) DEFAULT NULL,
  `urutan_kandungan` int(10) NOT NULL,
  `tugasan_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kandungan_tugasan`
--

INSERT INTO `kandungan_tugasan` (`kandungan_tugasan_id`, `deskripsi_kandungan`, `kandungan_path`, `pautan_url`, `urutan_kandungan`, `tugasan_id`) VALUES
(2, '', '../uploads/64a46p6gysgd1.png', '', 1, 8),
(3, 'test', '../uploads/296960.jpg', '', 2, 2),
(5, '', '../uploads/04-MOHD HAZIQ HAKIMI.pdf', '', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `kuiz`
--

CREATE TABLE `kuiz` (
  `kuiz_id` int(10) NOT NULL,
  `nama_kuiz` varchar(50) NOT NULL,
  `deskripsi_kuiz` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kuiz`
--

INSERT INTO `kuiz` (`kuiz_id`, `nama_kuiz`, `deskripsi_kuiz`) VALUES
(1, 'kuiz 1', 'kuiz testing'),
(2, 'Kuiz 2', 'kuiz for testing lorep ipsum');

-- --------------------------------------------------------

--
-- Table structure for table `kumpulan`
--

CREATE TABLE `kumpulan` (
  `kumpulan_id` int(10) NOT NULL,
  `nama_kumpulan` varchar(100) NOT NULL,
  `maksimum_ahli` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kumpulan`
--

INSERT INTO `kumpulan` (`kumpulan_id`, `nama_kumpulan`, `maksimum_ahli`) VALUES
(2, 'Mawar', 3),
(7, 'tempurung', 7),
(8, 'scratch', 3);

-- --------------------------------------------------------

--
-- Table structure for table `pelajar`
--

CREATE TABLE `pelajar` (
  `pelajar_id` int(11) NOT NULL,
  `nama_pelajar` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `kata_laluan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelajar`
--

INSERT INTO `pelajar` (`pelajar_id`, `nama_pelajar`, `email`, `kata_laluan`) VALUES
(1, 'hakimi', 'hakimi@email.com', '123'),
(2, 'Muhammad Ikhwan', 'ikhwan@gmail.com', '123'),
(3, 'Muhammad Akmal', 'test@email.com', '123'),
(4, 'Siti Aisyah', 'test2@email.com', '123'),
(5, 'Mohd Nabil', 'test3@email.com', '123'),
(6, 'Daniel Fitri', 'test4@email.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `penyerahan`
--

CREATE TABLE `penyerahan` (
  `penyerahan_id` int(10) NOT NULL,
  `tarikh_penyerahan1` date NOT NULL,
  `penyerahan_path1` varchar(500) NOT NULL,
  `komen` varchar(200) DEFAULT NULL,
  `tarikh_penyerahan2` date DEFAULT NULL,
  `penyerahan_path2` varchar(500) DEFAULT NULL,
  `url_video` varchar(500) DEFAULT NULL,
  `markah` int(10) DEFAULT NULL,
  `rubrik_id` int(10) DEFAULT NULL,
  `tugasan_id` int(10) NOT NULL,
  `pelajar_id` int(10) DEFAULT NULL,
  `kumpulan_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penyerahan`
--

INSERT INTO `penyerahan` (`penyerahan_id`, `tarikh_penyerahan1`, `penyerahan_path1`, `komen`, `tarikh_penyerahan2`, `penyerahan_path2`, `url_video`, `markah`, `rubrik_id`, `tugasan_id`, `pelajar_id`, `kumpulan_id`) VALUES
(17, '2024-09-19', '../uploads/test_4.docx', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL),
(30, '2024-10-16', '../uploads/Borang-mastautin.pdf', 'test2', '2024-10-16', '../uploads/Borang-mastautin_3.pdf', 'https://www.youtube.com/watch?v=DPja1bfY7Uw', 49, 6, 8, 1, NULL),
(33, '2024-10-16', '../uploads/Borang-mastautin_7.pdf', 'perlu perbaiki bahagian ', '2024-10-17', '../uploads/Borang-mastautin_12.pdf', NULL, NULL, NULL, 8, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rubrik`
--

CREATE TABLE `rubrik` (
  `rubrik_id` int(10) NOT NULL,
  `nama_rubrik` varchar(500) NOT NULL,
  `deskripsi_rubrik` varchar(1000) NOT NULL,
  `markah_min` int(10) NOT NULL,
  `markah_max` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rubrik`
--

INSERT INTO `rubrik` (`rubrik_id`, `nama_rubrik`, `deskripsi_rubrik`, `markah_min`, `markah_max`) VALUES
(1, 'TP1', '', 1, 20),
(2, 'TP2', '', 21, 34),
(5, 'TP3', '', 35, 48),
(6, 'TP4', '', 49, 56),
(7, 'TP5', '', 57, 64),
(8, 'TP6', '', 65, 100);

-- --------------------------------------------------------

--
-- Table structure for table `standard_kandungan`
--

CREATE TABLE `standard_kandungan` (
  `sk_id` int(10) NOT NULL,
  `nama_sk` varchar(50) NOT NULL,
  `kod_sk` int(10) NOT NULL,
  `urutan_sk` int(10) NOT NULL,
  `cikgu_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `standard_kandungan`
--

INSERT INTO `standard_kandungan` (`sk_id`, `nama_sk`, `kod_sk`, `urutan_sk`, `cikgu_id`) VALUES
(1, 'Asas Pengaturcaraan', 1, 1, 1),
(5, 'Pembangunan Kod Arahan', 2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `standard_pembelajaran`
--

CREATE TABLE `standard_pembelajaran` (
  `sp_id` int(10) NOT NULL,
  `nama_sp` varchar(100) NOT NULL,
  `deskripsi_sp` varchar(300) NOT NULL,
  `urutan_sp` int(10) NOT NULL,
  `sk_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `standard_pembelajaran`
--

INSERT INTO `standard_pembelajaran` (`sp_id`, `nama_sp`, `deskripsi_sp`, `urutan_sp`, `sk_id`) VALUES
(1, 'Menyatakan maksud pengaturcaraan dan kegunaan atur cara dalam perkakasan harian.	', '', 1, 1),
(23, 'Mengenal pasti algoritma iaitu pseudokod dan carta alir.', '', 2, 1),
(24, 'Menulis pseudokod dan melukis carta alir struktur kawalan jujukan ', '', 3, 1),
(25, 'Menghuraikan satu masalah menggunakan menggunakan pseudokod dan carta alir. ', '', 4, 1),
(26, 'Menilai dan membuat penambahbaikan pseudokod dan carta alir yang dihasilkan. ', '', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tugasan`
--

CREATE TABLE `tugasan` (
  `tugasan_id` int(10) NOT NULL,
  `nama_tugasan` varchar(300) NOT NULL,
  `deskripsi_tugasan` varchar(500) NOT NULL,
  `jenis_tugasan` varchar(50) NOT NULL,
  `sijil_path` varchar(500) NOT NULL,
  `tarikh_due` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tugasan`
--

INSERT INTO `tugasan` (`tugasan_id`, `nama_tugasan`, `deskripsi_tugasan`, `jenis_tugasan`, `sijil_path`, `tarikh_due`) VALUES
(1, 'Menghuraikan satu masalah menggunakan menggunakan pseudokod dan carta alir. ', 'Buat algoritma, pseudokod dan carta alir.', 'individu', '../uploads/test_6.pdf', '2024-09-27'),
(2, 'Mengenalpasti Objek Teknologi Dalam Kehidupan', 'Dalam tugasan ini, pelajar diarahkan untuk menyenaraikan objek2 teknologi yang terdapat pada masa kini', 'kumpulan', '../uploads/Scratch-Running-unscreen_1.gif', '2024-09-20'),
(8, 'test', 'tugasan projek ini bertujuan untuk testing', 'individu', '../uploads/Borang-mastautin_5.pdf', '2024-10-10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ahli_kumpulan`
--
ALTER TABLE `ahli_kumpulan`
  ADD PRIMARY KEY (`kumpulan_id`,`pelajar_id`),
  ADD KEY `ahli_kumpulan_ibfk_1` (`pelajar_id`,`kumpulan_id`) USING BTREE;

--
-- Indexes for table `cikgu`
--
ALTER TABLE `cikgu`
  ADD PRIMARY KEY (`cikgu_id`);

--
-- Indexes for table `kandungan`
--
ALTER TABLE `kandungan`
  ADD PRIMARY KEY (`kandungan_id`),
  ADD KEY `kandungan_ibfk_1` (`sp_id`);

--
-- Indexes for table `kandungan_kuiz`
--
ALTER TABLE `kandungan_kuiz`
  ADD PRIMARY KEY (`kandungan_kuiz_id`),
  ADD KEY `kuiz_id` (`kuiz_id`);

--
-- Indexes for table `kandungan_tugasan`
--
ALTER TABLE `kandungan_tugasan`
  ADD PRIMARY KEY (`kandungan_tugasan_id`),
  ADD KEY `tugasan_id` (`tugasan_id`);

--
-- Indexes for table `kuiz`
--
ALTER TABLE `kuiz`
  ADD PRIMARY KEY (`kuiz_id`);

--
-- Indexes for table `kumpulan`
--
ALTER TABLE `kumpulan`
  ADD PRIMARY KEY (`kumpulan_id`);

--
-- Indexes for table `pelajar`
--
ALTER TABLE `pelajar`
  ADD PRIMARY KEY (`pelajar_id`);

--
-- Indexes for table `penyerahan`
--
ALTER TABLE `penyerahan`
  ADD PRIMARY KEY (`penyerahan_id`),
  ADD KEY `pelajar_id` (`pelajar_id`),
  ADD KEY `kumpulan_id` (`kumpulan_id`),
  ADD KEY `tugasan_id` (`tugasan_id`),
  ADD KEY `penyerahan_ibfk_4` (`rubrik_id`);

--
-- Indexes for table `rubrik`
--
ALTER TABLE `rubrik`
  ADD PRIMARY KEY (`rubrik_id`);

--
-- Indexes for table `standard_kandungan`
--
ALTER TABLE `standard_kandungan`
  ADD PRIMARY KEY (`sk_id`),
  ADD KEY `cikgu_id` (`cikgu_id`);

--
-- Indexes for table `standard_pembelajaran`
--
ALTER TABLE `standard_pembelajaran`
  ADD PRIMARY KEY (`sp_id`);

--
-- Indexes for table `tugasan`
--
ALTER TABLE `tugasan`
  ADD PRIMARY KEY (`tugasan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cikgu`
--
ALTER TABLE `cikgu`
  MODIFY `cikgu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kandungan`
--
ALTER TABLE `kandungan`
  MODIFY `kandungan_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `kandungan_kuiz`
--
ALTER TABLE `kandungan_kuiz`
  MODIFY `kandungan_kuiz_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kandungan_tugasan`
--
ALTER TABLE `kandungan_tugasan`
  MODIFY `kandungan_tugasan_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kuiz`
--
ALTER TABLE `kuiz`
  MODIFY `kuiz_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kumpulan`
--
ALTER TABLE `kumpulan`
  MODIFY `kumpulan_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pelajar`
--
ALTER TABLE `pelajar`
  MODIFY `pelajar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `penyerahan`
--
ALTER TABLE `penyerahan`
  MODIFY `penyerahan_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `rubrik`
--
ALTER TABLE `rubrik`
  MODIFY `rubrik_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `standard_kandungan`
--
ALTER TABLE `standard_kandungan`
  MODIFY `sk_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `standard_pembelajaran`
--
ALTER TABLE `standard_pembelajaran`
  MODIFY `sp_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tugasan`
--
ALTER TABLE `tugasan`
  MODIFY `tugasan_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ahli_kumpulan`
--
ALTER TABLE `ahli_kumpulan`
  ADD CONSTRAINT `ahli_kumpulan_ibfk_1` FOREIGN KEY (`pelajar_id`) REFERENCES `pelajar` (`pelajar_id`),
  ADD CONSTRAINT `ahli_kumpulan_ibfk_2` FOREIGN KEY (`kumpulan_id`) REFERENCES `kumpulan` (`kumpulan_id`);

--
-- Constraints for table `kandungan`
--
ALTER TABLE `kandungan`
  ADD CONSTRAINT `kandungan_ibfk_1` FOREIGN KEY (`sp_id`) REFERENCES `standard_pembelajaran` (`sp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `kandungan_kuiz`
--
ALTER TABLE `kandungan_kuiz`
  ADD CONSTRAINT `kandungan_kuiz_ibfk_1` FOREIGN KEY (`kuiz_id`) REFERENCES `kuiz` (`kuiz_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `kandungan_tugasan`
--
ALTER TABLE `kandungan_tugasan`
  ADD CONSTRAINT `kandungan_tugasan_ibfk_1` FOREIGN KEY (`tugasan_id`) REFERENCES `tugasan` (`tugasan_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `penyerahan`
--
ALTER TABLE `penyerahan`
  ADD CONSTRAINT `penyerahan_ibfk_1` FOREIGN KEY (`pelajar_id`) REFERENCES `pelajar` (`pelajar_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `penyerahan_ibfk_2` FOREIGN KEY (`kumpulan_id`) REFERENCES `kumpulan` (`kumpulan_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `penyerahan_ibfk_3` FOREIGN KEY (`tugasan_id`) REFERENCES `tugasan` (`tugasan_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `penyerahan_ibfk_4` FOREIGN KEY (`rubrik_id`) REFERENCES `rubrik` (`rubrik_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `standard_kandungan`
--
ALTER TABLE `standard_kandungan`
  ADD CONSTRAINT `standard_kandungan_ibfk_1` FOREIGN KEY (`cikgu_id`) REFERENCES `cikgu` (`cikgu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
