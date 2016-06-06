-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2016 at 09:43 PM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `goca`
--

-- --------------------------------------------------------

--
-- Table structure for table `komentari`
--

DROP TABLE IF EXISTS `komentari`;
CREATE TABLE IF NOT EXISTS `komentari` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(20) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `email` varchar(30) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `komentar` text COLLATE utf8_slovenian_ci NOT NULL,
  `vrijeme` timestamp NULL DEFAULT NULL,
  `vijest` int(11) NOT NULL,
  `korisnik` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vijest` (`vijest`),
  KEY `korisnik` (`korisnik`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

DROP TABLE IF EXISTS `korisnici`;
CREATE TABLE IF NOT EXISTS `korisnici` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `korisnik` varchar(20) COLLATE utf8_slovenian_ci NOT NULL,
  `admin` tinyint(4) NOT NULL,
  `lozinka` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `imeprezime` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `korisnik` (`korisnik`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `korisnik`, `admin`, `lozinka`, `email`, `imeprezime`) VALUES
(13, 'admin', 1, '21232f297a57a5a743894a0e4a801fc3', 'asabanovic3@gmail.com', 'Amir Sabanovic');

-- --------------------------------------------------------

--
-- Table structure for table `vijesti`
--

DROP TABLE IF EXISTS `vijesti`;
CREATE TABLE IF NOT EXISTS `vijesti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `autor` int(11) NOT NULL,
  `naslov` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `datum` timestamp NOT NULL,
  `tekst` text COLLATE utf8_slovenian_ci NOT NULL,
  `detaljnije` text COLLATE utf8_slovenian_ci NOT NULL,
  `komentarisanje` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `autor` (`autor`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `vijesti`
--

INSERT INTO `vijesti` (`id`, `autor`, `naslov`, `datum`, `tekst`, `detaljnije`, `komentarisanje`) VALUES
(5, 13, 'Prva vijest', '2016-06-06 20:58:29', 'Tekst prve vijesti.', 'Detaljnije o prvoj vijesti...', 1),
(6, 13, 'Obilježena godišnjica od tragične smrti pet rudara u jami Raspotočje', '2016-06-06 21:27:32', 'Danas je u organizaciji RMU Zenica obilježena prva godišnjica pogibije pet rudara u jami \r\n					Raspotočje kada su usljed gorskog udara u jami ostala zarobljena 34 rudara u septembru 2014. godine, piše \r\n					bh. novinska agencija Patria. Nažalost za pet rudara Fejzu Isakovića, Mehemeda Dizdarevića, Mehmedaliju \r\n					Halilovića, Fahira Halača i Hajrudin Bradarca bilo je prekasno', 'Danas je u organizaciji RMU Zenica obilježena prva godišnjica pogibije pet rudara u jami \r\n					Raspotočje kada su usljed gorskog udara u jami ostala zarobljena 34 rudara u septembru 2014. godine, piše \r\n					bh. novinska agencija Patria. Nažalost za pet rudara Fejzu Isakovića, Mehemeda Dizdarevića, Mehmedaliju \r\n					Halilovića, Fahira Halača i Hajrudin Bradarca bilo je prekasno', 0),
(7, 13, 'Visočki predstavnik na Sarajevo Youth Film festivalu je film “Mašta”, TV Furda produkcije', '2016-06-06 21:27:32', 'Danas je u organizaciji RMU Zenica obilježena prva godišnjica pogibije pet rudara u jami \r\n					Raspotočje kada su usljed gorskog udara u jami ostala zarobljena 34 rudara u septembru 2014. godine, piše \r\n					bh. novinska agencija Patria. Nažalost za pet rudara Fejzu Isakovića, Mehemeda Dizdarevića, Mehmedaliju \r\n					Halilovića, Fahira Halača i Hajrudin Bradarca bilo je prekasno.', 'Danas je u organizaciji RMU Zenica obilježena prva godišnjica pogibije pet rudara u jami \r\n					Raspotočje kada su usljed gorskog udara u jami ostala zarobljena 34 rudara u septembru 2014. godine, piše \r\n					bh. novinska agencija Patria. Nažalost za pet rudara Fejzu Isakovića, Mehemeda Dizdarevića, Mehmedaliju \r\n					Halilovića, Fahira Halača i Hajrudin Bradarca bilo je prekasno.', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentari`
--
ALTER TABLE `komentari`
  ADD CONSTRAINT `komentari_ibfk_1` FOREIGN KEY (`vijest`) REFERENCES `vijesti` (`id`),
  ADD CONSTRAINT `komentari_ibfk_2` FOREIGN KEY (`korisnik`) REFERENCES `korisnici` (`id`);

--
-- Constraints for table `vijesti`
--
ALTER TABLE `vijesti`
  ADD CONSTRAINT `vijesti_ibfk_1` FOREIGN KEY (`autor`) REFERENCES `korisnici` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
