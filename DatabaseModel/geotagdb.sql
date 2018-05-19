-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 19, 2018 at 05:20 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `idImg` int(11) NOT NULL AUTO_INCREMENT,
  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idImg`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
