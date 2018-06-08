-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 08, 2018 at 03:05 PM
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
-- Table structure for table `destination`
--

CREATE TABLE `destination` (
  `idDest` int(11) NOT NULL,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` double NOT NULL,
  `latitude` double NOT NULL,
  `pending` tinyint(1) NOT NULL,
  `country` varchar(40) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `destination`
--

INSERT INTO `destination` (`idDest`, `name`, `longitude`, `latitude`, `pending`, `country`) VALUES
(28, 'Belgrade', 20.45434737375001, 44.77446920344899, 0, 'Serbia'),
(29, 'Rome', 12.49234938791028, 41.89429773813156, 0, 'Italy'),
(30, 'Nendaz', 7.295358421113292, 46.1829901279531, 0, 'Switzerland'),
(31, 'Barcelona', 2.149465324189464, 41.37551524085872, 0, 'Spain'),
(32, 'London', -0.1138555986620986, 51.510244665939226, 0, 'United Kingdom'),
(33, 'Jabuka', 19.505204154755916, 43.34399127838991, 0, 'Serbia'),
(34, 'Novi Sad', 19.837368919160212, 45.271344287683824, 0, 'Serbia'),
(35, 'Krakow', 19.96569805995955, 50.05459246817252, 0, 'Poland'),
(36, 'Moscow', 37.65917950527205, 55.75056782695307, 1, 'Russia'),
(37, 'Kavos', 20.113670166893144, 39.38237598062632, 0, 'Greece'),
(38, 'Monte Carlo', 7.424680527610917, 43.739221412788794, 0, 'Monaco'),
(39, 'Berlin', 13.405440148277421, 52.52035931466906, 1, 'Germany');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `idImg` int(11) NOT NULL,
  `img` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`idImg`, `img`) VALUES
(74, 'nendaz.jpg'),
(75, 'barcelona.jpg'),
(76, 'belgrade.jpg'),
(77, 'redstar_stadium.jpg'),
(78, 'blok_30.jpg'),
(79, 'hudi.jpg'),
(80, 'hudi1.jpg'),
(81, 'rome.jpg'),
(82, 'prof.jpg'),
(83, 'prof.jpg'),
(84, 'nendaz.jpg'),
(85, 'belgrade.jpg'),
(86, 'redstar_stadium.jpg'),
(87, 'blok_30.jpg'),
(88, 'granicni_prelaz.jpg'),
(89, 'exit.jpg'),
(90, 'barcelona.jpg'),
(91, 'DejanProfile.png'),
(92, '20171230_185942.jpg'),
(93, 'slika21.jpg'),
(94, '20171230_1859421.jpg'),
(95, 'ja3.png'),
(96, '1.jpg'),
(97, '11.jpg'),
(98, '12.jpg'),
(99, 'jaksa.jpg'),
(100, 'monte_carlo.jpg'),
(101, 'redstar_stadium1.jpg'),
(102, 'zoltan.jpg'),
(103, 'bg_ugly.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `idReq` int(11) NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idRev` int(11) DEFAULT NULL,
  `idDest` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`idReq`, `type`, `username`, `idRev`, `idDest`) VALUES
(13, 'destination confirm', 'jakovj', NULL, 29),
(14, 'destination confirm', 'jakovj', NULL, 30),
(15, 'destination confirm', 'jakovj', NULL, 31),
(16, 'destination confirm', 'jakovj', NULL, 32),
(19, 'destination confirm', 'hudi', NULL, 34),
(20, 'destination confirm', 'hudi', NULL, 33),
(22, 'destination confirm', 'ciric_d', NULL, 35),
(23, 'destination added', 'ciric_d', NULL, 36),
(24, 'destination confirm', 'arnold', NULL, 37),
(25, 'destination confirm', 'jakovj', NULL, 38),
(26, 'destination added', 'hudi', NULL, 39),
(28, 'user promotion', 'jaksaj', NULL, NULL),
(29, 'negative review', 'zoltan56', 82, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `idRev` int(11) NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `upCount` int(11) NOT NULL,
  `downCount` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `idImg` int(11) DEFAULT NULL,
  `idDest` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`idRev`, `content`, `upCount`, `downCount`, `date`, `username`, `idImg`, `idDest`) VALUES
(66, 'Perfect ski resort, we had a great time ! :)', 3, 0, '2018-06-07 00:00:00', 'jakovj', 84, 30),
(67, 'Magic place, where you can enjoy many different things. Walking, enjoying the magnificient view of mouth of Danube and Sava. Visit some open exibitions.', 5, 0, '2018-06-07 00:00:00', 'hudi', 85, 28),
(69, 'Probably coolest place in Belgrade - Blok 30.', 2, 1, '2018-06-07 00:00:00', 'hudi', 87, 28),
(70, 'Horrible place on border between Serbia and Montenegro.\r\nMy friend Jakov got fully inspected by angry Serbian custom officers in search for illegal substances and weapons...', 2, 1, '2018-06-07 00:00:00', 'hudi', 88, 33),
(71, 'Visited <strong>Exit festival</strong> last year, great fun, great place, great people.', 3, 0, '2018-06-07 00:00:00', 'hudi', 89, 34),
(72, 'One of the largest cities we\'ve visited. We were stunned by Sagrada Familia, Park Guell and other Gaudi\'s masterpieces. Hopefully, we left just before the terrorist attack :(', 4, 3, '2018-06-07 00:00:00', 'jakovj', 90, 31),
(73, 'I live in this city just 3 years, sometimes there are traffic problems, but mostly it is a great city with great night life ! Cheers', 3, 0, '2018-06-07 00:00:00', 'ciric_d', NULL, 28),
(75, 'Great place, I\'ve been there for last New Year\'s holiday, worth visiting :)', 2, 1, '2018-06-07 00:00:00', 'ciric_d', 94, 35),
(78, 'One of the best summer party destinations, there are parties every day and night.\r\nI recommend this destinations for everyone who is seeking for parties and summer fun.\r\nThere is awesome aqua park too', 4, 1, '2018-06-08 00:00:00', 'arnold', 98, 37),
(79, 'Cool place!', 6, 1, '2018-06-08 00:00:00', 'jaksaj', 100, 38),
(80, 'Visit <strong>Red Star Belgrade Stadium</strong>! A lot of trophies, pictures, equipments from a last century. Football lovers must come here an enjoy.', 0, 1, '2018-06-08 00:00:00', 'hudi', 101, 28),
(82, 'I would never recommend anyone to visit Belgrade as it is the dirtiest city ever! Garbage everywhere.', 0, 6, '2018-06-08 00:00:00', 'zoltan56', 103, 28);

-- --------------------------------------------------------

--
-- Table structure for table `statistic`
--

CREATE TABLE `statistic` (
  `date` datetime NOT NULL,
  `userCount` int(11) NOT NULL,
  `reviewCount` int(11) NOT NULL,
  `destinationCount` int(11) NOT NULL,
  `positiveVoteCount` int(11) NOT NULL,
  `negativeVoteCount` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `statistic`
--

INSERT INTO `statistic` (`date`, `userCount`, `reviewCount`, `destinationCount`, `positiveVoteCount`, `negativeVoteCount`) VALUES
('2018-06-08 00:00:00', 5, 5, 1, 0, 0),
('2018-06-07 00:00:00', 9, 10, 8, 0, 0);

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
('Veljko966', 'radioheadthom444@gmail.com', 'user', '$2y$10$Jqe9OBktMu5vCKvsJVsz9u/2gY0w85qU.rQ99IHjEeP.hONdDnUYO', 'Veljko', 'Djordjevic', 'male', 93),
('zoltan56', 'zoltan@o3enzyme.com', 'user', '$2y$10$.RV0oi0qfFUj2L4zSlBduOAvSIHzipXFc4/K52z/slgmOnxtmCJhK', 'Zoltan', 'Bartoš', 'male', 102);

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE `vote` (
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `idRev` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`username`, `idRev`, `type`) VALUES
('arnold', 66, 1),
('arnold', 67, 1),
('arnold', 69, 1),
('arnold', 70, 1),
('arnold', 71, 1),
('arnold', 72, 1),
('arnold', 73, 1),
('arnold', 75, 1),
('arnold', 82, -1),
('ciric_d', 67, 1),
('ciric_d', 69, -1),
('ciric_d', 70, -1),
('ciric_d', 71, 1),
('ciric_d', 72, 1),
('ciric_d', 78, -1),
('ciric_d', 79, 1),
('hudi', 66, 1),
('hudi', 72, -1),
('hudi', 73, 1),
('hudi', 75, -1),
('hudi', 78, 1),
('hudi', 79, 1),
('hudi', 82, -1),
('jakovj', 67, 1),
('jakovj', 69, 1),
('jakovj', 70, 1),
('jakovj', 71, 1),
('jakovj', 73, 1),
('jakovj', 75, 1),
('jakovj', 78, 1),
('jakovj', 79, 1),
('jakovj', 80, -1),
('jakovj', 82, -1),
('jaksaj', 66, 1),
('jaksaj', 67, 1),
('jaksaj', 72, 1),
('jaksaj', 78, 1),
('jaksaj', 82, -1),
('jana', 72, -1),
('jana', 79, -1),
('milos96', 78, 1),
('milos96', 79, 1),
('sanja', 67, 1),
('sanja', 72, -1),
('sanja', 79, 1),
('sanja', 82, -1),
('Veljko966', 72, 1),
('Veljko966', 79, 1),
('Veljko966', 82, -1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`idDest`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`idImg`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`idReq`),
  ADD KEY `username` (`username`),
  ADD KEY `idRev` (`idRev`),
  ADD KEY `idDest` (`idDest`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`idRev`),
  ADD KEY `idImg` (`idImg`),
  ADD KEY `username` (`username`),
  ADD KEY `idDest` (`idDest`);

--
-- Indexes for table `statistic`
--
ALTER TABLE `statistic`
  ADD PRIMARY KEY (`date`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idImg` (`idImg`);

--
-- Indexes for table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`username`,`idRev`),
  ADD KEY `idRev` (`idRev`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `destination`
--
ALTER TABLE `destination`
  MODIFY `idDest` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `idImg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `idReq` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `idRev` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

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
