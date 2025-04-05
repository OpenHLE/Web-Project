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
-- Table structure for table `EOI`
--

CREATE TABLE `EOI` (
  `EOInumber` int(11) NOT NULL,
  `JobReferenceNumber` varchar(5) DEFAULT NULL,
  `FirstName` varchar(20) DEFAULT NULL,
  `LastName` varchar(20) DEFAULT NULL,
  `BirthDate` varchar(2) DEFAULT NULL,
  `BirthMonth` varchar(2) DEFAULT NULL,
  `BirthYear` varchar(4) DEFAULT NULL,
  `Gender` enum('Male','Female','Other') DEFAULT NULL,
  `StreetAddress` varchar(40) DEFAULT NULL,
  `TownOrSuburbs` varchar(40) DEFAULT NULL,
  `State` varchar(20) DEFAULT NULL,
  `Postcode` varchar(4) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `PhoneNumber` varchar(18) DEFAULT NULL,
  `OtherSkills` text,
  `Status` enum('New','Current','Final') DEFAULT 'New'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `EOI`
--

INSERT INTO `EOI` (`EOInumber`, `JobReferenceNumber`, `FirstName`, `LastName`, `BirthDate`, `BirthMonth`, `BirthYear`, `Gender`, `StreetAddress`, `TownOrSuburbs`, `State`, `Postcode`, `Email`, `PhoneNumber`, `OtherSkills`, `Status`) VALUES
(27, 'CS847', 'John', 'Smith', '02', '06', '1999', 'Male', 'Duy Tan', 'Ha Dong', 'WA', '6578', 'Smith@mai.com', '4523984202', 'Ethical hacking', 'New'),
(28, 'FD647', 'Laura', 'Heart', '09', '07', '1999', 'Male', 'Hang Ma', 'Hoan Kiem', 'SA', '5314', 'Laura@mail.com', '2357038275', '', 'New'),
(29, 'UX174', 'Mai', 'Nguyen', '08', '07', '2000', 'Female', 'Tan Mai', 'Hoang Mai', 'VIC', '3819', 'Maipretty@mail.com', '7420841841', '', 'New'),
(30, 'IS765', 'Peter', 'Dang', '23', '12', '1998', 'Male', 'Nguyen Trai', 'Ha Dong', 'VIC', '3819', 'Peterdeptrai@mailmail.com', '1410384104', 'I\'m friendly', 'New'),
(31, 'DM153', 'Johnny', 'Pham', '03', '04', '1945', 'Male', 'Tran Dai Nghia', 'Hai Ba Trung', 'NSW', '1739', 'Babyjohn@mail.dot', '8931748011', 'I work very hard', 'New'),
(32, 'FD647', 'Donald', 'Duck', '02', '02', '2010', 'Female', 'Ta quang buu', 'Hai Ba Trung', 'VIC', '3475', 'DuckyDuckDuck@mail.donald', '0141847104', '', 'New'),
(33, 'BD137', 'Huj', 'Akandric', '31', '08', '1999', 'Male', '35th akandia avenue', 'Lokand', 'ACT', '2600', 'DAWG@mail.net', '0192384182', 'Be a monster that eats other monsters', 'Final');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `EOI`
--
ALTER TABLE `EOI`
  ADD PRIMARY KEY (`EOInumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `EOI`
--
ALTER TABLE `EOI`
  MODIFY `EOInumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
