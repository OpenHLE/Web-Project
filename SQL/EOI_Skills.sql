-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: ictstu-db1.cc.swin.edu.au
-- Generation Time: Apr 03, 2025 at 03:52 PM
-- Server version: 5.5.68-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `s105550047_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `EOI_Skills`
--

CREATE TABLE `EOI_Skills` (
  `EOInumber` int(11) DEFAULT NULL,
  `Skills` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `EOI_Skills`
--

INSERT INTO `EOI_Skills` (`EOInumber`, `Skills`) VALUES
(27, 'java'),
(27, 'statistic'),
(27, 'cybersecurity'),
(28, 'html'),
(28, 'css'),
(28, 'ui_ux'),
(28, 'js'),
(29, 'ui_ux'),
(30, 'otherskill'),
(31, 'sql'),
(31, 'otherskill'),
(32, 'php'),
(32, 'sql'),
(32, 'python'),
(32, 'c/c++'),
(33, 'java');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `EOI_Skills`
--
ALTER TABLE `EOI_Skills`
  ADD KEY `fk_eoi_skills` (`EOInumber`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `EOI_Skills`
--
ALTER TABLE `EOI_Skills`
  ADD CONSTRAINT `fk_eoi_skills` FOREIGN KEY (`EOInumber`) REFERENCES `EOI` (`EOInumber`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
