-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 08, 2018 at 01:45 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id6095028_geotagdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `idImg` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `email`, `status`, `password`, `firstname`, `lastname`, `gender`, `idImg`) VALUES
('arnold', 'mikaitata@gmail.com', 'admin', '$2y$10$It83ttYP0PNyVNmihjUd7.6cX5iaK2wijTspE1JZz0qMk/krs47Qi', 'Milos', 'Matijasevic', 'male', 95),
('ciric_d', 'dejanciric2013@yahoo.com', 'super_user', '$2y$10$GUqGFx01SzmQjpJRAOg9PezWwH29Z/2UiC.sExm7YTW.dnIUq365q', 'Dejan', 'Ciric', 'male', 91),
('hudi', 'markohudomal@gmail.com', 'super_user', '$2y$10$KOmk2Y4ovNzISpdDThozReMp4SzjfC7hl60fgHm0K7kl9ElCye46.', 'Marko', 'Hudomal', 'male', 80),
('jakovj', 'jakovjezdic@gmail.com', 'admin', '$2y$10$6sdxB.IALnKHiXEJ8326DurEX3ZorlY2f8KD5mFzHIJyHbxPi42Nm', 'Jakov', 'Jezdić', 'male', 83),
('jaksaj', 'jaksajezdic03@gmail.com', 'user', '$2y$10$/xu.2B42yIdyfi0hq1HfqOgfLq5oKmT3PE/no9YFTujqr1bss2vvS', 'Jaksa', 'Jezdic', 'male', 99),
('jana', 'jjanakragovic@gmail.com', 'user', '$2y$10$FpcOBO2jwk9JzAJmzkVbauOX/9G2vw.EpxA0hiMwgwWMXUgydZz1S', 'jana', 'kragovic', 'female', NULL),
('milos96', 'tetraktis13@gmail.com', 'user', '$2y$10$s7V.fOB4SGKn/GXPmdC0Me7HRRBehdxa9CoMfztIAM4hHAjkAASRG', 'Milos', 'Cubrilo', 'male', NULL),
('sanja', 'sanja996@live.com', 'user', '$2y$10$W7lYkp7tfoBzXpin5/O.l.By3OVim0ZDzRtGDCg4TT53ISn6sT862', 'Sanja', 'Perisic', 'female', NULL),
('sara6', 'sacasara6@gmail.com', 'user', '$2y$10$pfPj0tYXzuccIA6Ngdqf0e82D/S6u.zxId3jQ/kgM4exHWSpN3xoG', 'Sara', 'Vukas', 'female', NULL),
('Veljko966', 'radioheadthom444@gmail.com', 'user', '$2y$10$Jqe9OBktMu5vCKvsJVsz9u/2gY0w85qU.rQ99IHjEeP.hONdDnUYO', 'Veljko', 'Djordjevic', 'male', 93);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idImg` (`idImg`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `idImg` FOREIGN KEY (`idImg`) REFERENCES `image` (`idImg`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
