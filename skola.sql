-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2020 at 03:32 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skola`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(3) UNSIGNED NOT NULL,
  `ime` varchar(20) NOT NULL,
  `prezime` varchar(30) NOT NULL,
  `korime` varchar(10) NOT NULL,
  `lozinka` varchar(256) NOT NULL,
  `status` enum('Profesor','Student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `ime`, `prezime`, `korime`, `lozinka`, `status`) VALUES
(1, 'Ivan', 'Miljković', 'ivanm', 'ivanm', 'Profesor'),
(2, 'Jovan', 'Delević', 'jovand', 'jovand', 'Profesor'),
(3, 'Pera', 'Perić', 'perap', 'perap', 'Student'),
(4, 'Jovan', 'Jović', 'jovanj', 'jovanj', 'Student'),
(5, 'Joca', 'Jocić', 'jocaj', 'jocaj', 'Student'),
(6, 'Aca', 'Acić', 'acaa', 'acaa', 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `nacinpolaganja`
--

CREATE TABLE `nacinpolaganja` (
  `id` int(2) UNSIGNED NOT NULL,
  `naziv` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nacinpolaganja`
--

INSERT INTO `nacinpolaganja` (`id`, `naziv`) VALUES
(1, 'pismeno'),
(2, 'usmeno'),
(3, 'kolokvijumi - parcijalno'),
(4, 'praktični zadatak');

-- --------------------------------------------------------

--
-- Table structure for table `predmeti`
--

CREATE TABLE `predmeti` (
  `id` int(10) UNSIGNED NOT NULL,
  `naziv` varchar(50) NOT NULL,
  `nacinpolaganja` int(2) NOT NULL,
  `datum` date NOT NULL,
  `idProfesora` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `predmeti`
--

INSERT INTO `predmeti` (`id`, `naziv`, `nacinpolaganja`, `datum`, `idProfesora`) VALUES
(1, 'Programiranje veb aplikacija', 4, '2020-02-22', 1),
(2, 'Baze podataka 2', 1, '2020-02-20', 1),
(3, 'Big Data', 3, '2020-02-05', 1),
(4, 'Arhitektura i organizacija računara 1', 1, '2020-02-27', 2),
(5, 'Arhitektura i organizacija računara 2', 2, '2020-02-28', 2),
(6, 'Aplikativni softver', 3, '2020-02-05', 2);

-- --------------------------------------------------------

--
-- Table structure for table `prijava`
--

CREATE TABLE `prijava` (
  `id` int(3) UNSIGNED NOT NULL,
  `idStudenta` int(3) NOT NULL,
  `idPredmeta` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prijava`
--

INSERT INTO `prijava` (`id`, `idStudenta`, `idPredmeta`) VALUES
(1, 3, 2),
(2, 3, 1),
(3, 3, 4),
(4, 4, 5),
(5, 4, 4),
(6, 4, 1),
(7, 5, 2),
(8, 5, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vwpredmeti`
-- (See below for the actual view)
--
CREATE TABLE `vwpredmeti` (
`id` int(10) unsigned
,`naziv` varchar(50)
,`nacinpolaganja` int(2)
,`datum` date
,`idProfesora` int(3)
,`nazivNP` varchar(30)
,`ime` varchar(20)
,`prezime` varchar(30)
);

-- --------------------------------------------------------

--
-- Structure for view `vwpredmeti`
--
DROP TABLE IF EXISTS `vwpredmeti`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vwpredmeti`  AS  select `predmeti`.`id` AS `id`,`predmeti`.`naziv` AS `naziv`,`predmeti`.`nacinpolaganja` AS `nacinpolaganja`,`predmeti`.`datum` AS `datum`,`predmeti`.`idProfesora` AS `idProfesora`,`nacinpolaganja`.`naziv` AS `nazivNP`,`korisnici`.`ime` AS `ime`,`korisnici`.`prezime` AS `prezime` from ((`predmeti` join `nacinpolaganja` on(`predmeti`.`nacinpolaganja` = `nacinpolaganja`.`id`)) join `korisnici` on(`predmeti`.`idProfesora` = `korisnici`.`id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korime` (`korime`);

--
-- Indexes for table `nacinpolaganja`
--
ALTER TABLE `nacinpolaganja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `predmeti`
--
ALTER TABLE `predmeti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `naziv` (`naziv`);

--
-- Indexes for table `prijava`
--
ALTER TABLE `prijava`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nacinpolaganja`
--
ALTER TABLE `nacinpolaganja`
  MODIFY `id` int(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `predmeti`
--
ALTER TABLE `predmeti`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `prijava`
--
ALTER TABLE `prijava`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
