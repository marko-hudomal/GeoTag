-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 06, 2018 at 10:17 AM
-- Server version: 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `geotagdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `destination`
--

DROP TABLE IF EXISTS `destination`;
CREATE TABLE IF NOT EXISTS `destination` (
  `idDest` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` double NOT NULL,
  `latitude` double NOT NULL,
  `pending` tinyint(1) NOT NULL,
  `country` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idDest`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `destination`
--

INSERT INTO `destination` (`idDest`, `name`, `longitude`, `latitude`, `pending`, `country`) VALUES
(12, 'Beograd', 20.45434737375001, 44.77446920344899, 0, 'Srbija'),
(16, 'Titel', 20.285432578828136, 45.2114980600597, 0, 'Srbija'),
(17, 'Vrsac', 21.29480147531251, 45.120482958475634, 0, 'Srbija'),
(20, 'Pancevo', 20.65210128000001, 44.87090149651767, 0, 'Srbija'),
(21, 'Rimini', 12.56753707101575, 44.08999561760694, 0, 'Italija'),
(25, 'Grac', 15.46655440500001, 47.051826810104906, 1, 'Austrija'),
(26, 'Pariz', 2.3269059675000108, 48.919290244349654, 1, 'Francuska');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `idImg` int(11) NOT NULL AUTO_INCREMENT,
  `img` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idImg`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`idImg`, `img`) VALUES
(72, 'pic_grand.jpg'),
(73, 'pic_grand1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

DROP TABLE IF EXISTS `request`;
CREATE TABLE IF NOT EXISTS `request` (
  `idReq` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idRev` int(11) DEFAULT NULL,
  `idDest` int(11) DEFAULT NULL,
  PRIMARY KEY (`idReq`),
  KEY `username` (`username`),
  KEY `idRev` (`idRev`),
  KEY `idDest` (`idDest`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`idReq`, `type`, `username`, `idRev`, `idDest`) VALUES
(11, 'destination added', 'superuser', NULL, 25),
(12, 'destination added', 'superuser', NULL, 26);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
CREATE TABLE IF NOT EXISTS `review` (
  `idRev` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `upCount` int(11) NOT NULL,
  `downCount` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `idImg` int(11) DEFAULT NULL,
  `idDest` int(11) NOT NULL,
  PRIMARY KEY (`idRev`),
  KEY `idImg` (`idImg`),
  KEY `username` (`username`),
  KEY `idDest` (`idDest`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`idRev`, `content`, `upCount`, `downCount`, `date`, `username`, `idImg`, `idDest`) VALUES
(53, '1111', 1, 1, '2018-06-04 00:00:00', 'superuser', NULL, 12),
(55, 'pozitivan rev', 2, 0, '2018-06-04 00:00:00', 'superuser', NULL, 12),
(56, 'negativan rev', 0, 2, '2018-06-04 00:00:00', 'superuser', NULL, 12),
(57, '1111', 0, 1, '2018-06-04 00:00:00', 'user', NULL, 12),
(58, 'review', 0, 1, '2018-06-04 00:00:00', 'user', 73, 12),
(59, 'review bez slike', 0, 1, '2018-06-04 00:00:00', 'user', NULL, 12);

-- --------------------------------------------------------

--
-- Table structure for table `statistic`
--

DROP TABLE IF EXISTS `statistic`;
CREATE TABLE IF NOT EXISTS `statistic` (
  `date` datetime NOT NULL,
  `userCount` int(11) NOT NULL,
  `reviewCount` int(11) NOT NULL,
  `destinationCount` int(11) NOT NULL,
  `positiveVoteCount` int(11) NOT NULL,
  `negativeVoteCount` int(11) NOT NULL,
  PRIMARY KEY (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `statistic`
--

INSERT INTO `statistic` (`date`, `userCount`, `reviewCount`, `destinationCount`, `positiveVoteCount`, `negativeVoteCount`) VALUES
('2018-06-04 00:00:00', 3, 6, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `idImg` int(11) DEFAULT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `idImg` (`idImg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `email`, `status`, `password`, `firstname`, `lastname`, `gender`, `idImg`) VALUES
('admin', 'admin@o3enzyme.com', 'admin', '$2y$10$swhPDdt8Wet90ZUTDxl9nu/ixf71FjpLoPaJuEYK/VlCa3/glnoh2', 'Admin', 'Admin', 'male', NULL),
('markohudomal', 'markohudomal@yahoo.com', 'admin', '$2y$10$jSkVxQe5Yd.7ZPAGP6ZB3OV5LEAmRdbh8RylCb6tHjoU3NjE2btx2', 'Marko', 'Hudomal', 'male', NULL),
('superuser', 'superuser@fxprix.com', 'super_user', '$2y$10$opt2L0zHRTF6fKrEAEOapeyrfHVcWzQ8SRAKNuuJoQMms2UGXYIBK', 'SuperUser', 'SuperUser', 'male', NULL),
('user', 'user@loketa.com', 'user', '$2y$10$LTlkmHSvwjiyFKPcJxZapOfP76nQuY1pp9/SMOWHKkB2/Dh4pohTC', 'User', 'User', 'female', NULL),
('user2', 'user2@sfamo.com', 'user', '$2y$10$ySfS1xkG8gSk2tA47lvu4u1JwRUtkKI7FGUy7lE0On4g5jvZNaoe2', 'User2', 'User2', 'male', NULL),
('user3', 'user3@o3enzyme.com', 'user', '$2y$10$r0x3a452DmYR1dc4tZ/D9.brzrZGZMK7AXks1wdQlFqLvgox5S0uy', 'User3', 'User3', 'female', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

DROP TABLE IF EXISTS `vote`;
CREATE TABLE IF NOT EXISTS `vote` (
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `idRev` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL,
  PRIMARY KEY (`username`,`idRev`),
  KEY `idRev` (`idRev`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`username`, `idRev`, `type`) VALUES
('admin', 53, -1),
('admin', 55, 1),
('admin', 56, -1),
('admin', 57, -1),
('admin', 58, -1),
('admin', 59, -1),
('user', 53, 1),
('user', 55, 1),
('user', 56, -1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `idDest2` FOREIGN KEY (`idDest`) REFERENCES `destination` (`idDest`) ON DELETE CASCADE,
  ADD CONSTRAINT `idRev1` FOREIGN KEY (`idRev`) REFERENCES `review` (`idRev`) ON DELETE CASCADE,
  ADD CONSTRAINT `username3` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `idDest1` FOREIGN KEY (`idDest`) REFERENCES `destination` (`idDest`) ON DELETE CASCADE,
  ADD CONSTRAINT `idImg1` FOREIGN KEY (`idImg`) REFERENCES `image` (`idImg`),
  ADD CONSTRAINT `username1` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `idImg` FOREIGN KEY (`idImg`) REFERENCES `image` (`idImg`);

--
-- Constraints for table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `idRev` FOREIGN KEY (`idRev`) REFERENCES `review` (`idRev`) ON DELETE CASCADE,
  ADD CONSTRAINT `username2` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
