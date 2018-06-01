-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 01, 2018 at 11:29 PM
-- Server version: 5.7.20-log
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `destination`
--

INSERT INTO `destination` (`idDest`, `name`, `longitude`, `latitude`, `pending`, `country`) VALUES
(12, 'Beograd', 20.45434737375001, 44.77446920344899, 0, 'Srbija'),
(13, 'Kraljevo', 20.67407393625001, 43.71994548813585, 1, 'Srbija'),
(14, 'Kacarevo', 20.6982781904004, 44.966200860372346, 1, 'Srbija'),
(15, 'Zrenjanin', 20.37469649484376, 45.38151829026838, 1, 'Srbija');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `idImg` int(11) NOT NULL AUTO_INCREMENT,
  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idImg`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`idImg`, `img`) VALUES
(45, 'ALL_Users_-_UserPhoto.jpg'),
(46, 'b1.jpg'),
(47, 'b2.jpg'),
(48, 'b3.jpg'),
(49, 'b4.jpg'),
(50, 'inf11.jpg'),
(51, 'festival1.png'),
(52, 'festival2.png'),
(53, 'festival3.png'),
(54, 'festival4.png'),
(55, 'festival5.png'),
(56, 'festival6.png'),
(57, 'festival7.png'),
(58, 'bikovic1.jpg'),
(59, 'bjela4.jpg'),
(60, 'bjela5.jpg'),
(61, 'ovsJG.png'),
(62, '123.png'),
(63, '1231.png'),
(64, 'fb1.png'),
(65, 'b11.jpg'),
(66, 'b5.jpg'),
(67, 'inf12.jpg'),
(68, 'fb2.png'),
(69, 'bjela6.jpg');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`idReq`, `type`, `username`, `idRev`, `idDest`) VALUES
(1, 'Neispravan request', 'user', NULL, NULL),
(2, 'destination added', 'superuser', NULL, 13),
(3, 'destination added', 'superuser', NULL, 15),
(4, 'destination added', 'superuser', NULL, 14);

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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`idRev`, `content`, `upCount`, `downCount`, `date`, `username`, `idImg`, `idDest`) VALUES
(35, 'asdf', 0, 0, '2018-06-02 00:00:00', 'user', NULL, 12),
(36, 'asdasdasdasdasdasdasda', 0, 0, '2018-06-02 00:00:00', 'user', NULL, 12),
(37, '2132141242142132131312', 0, 0, '2018-06-02 00:00:00', 'user', NULL, 12);

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
('2018-05-29 00:00:00', 0, 0, 0, 0, 0),
('2018-05-30 00:00:00', 0, 0, 0, 0, 0),
('2018-05-31 00:00:00', 0, 0, 0, 0, 0),
('2018-06-01 00:00:00', 0, 0, 0, 0, 0),
('2018-06-02 00:00:00', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
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
('admin', 'admin@admin.com', 'admin', 'admin', 'Admin', 'Admin', 'male', 46),
('superuser', 'superuser@superuser.com', 'super_user', 'superuser', 'Superuser', 'Superuser', 'male', NULL),
('user', 'user@user.com', 'user', 'user', 'User', 'User', 'male', 47);

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
  ADD CONSTRAINT `username2` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
