-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2024 at 01:44 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital_praj`
--

-- --------------------------------------------------------

--
-- Table structure for table `123`
--

CREATE TABLE `123` (
  `date` date NOT NULL,
  `9-10` varchar(12) NOT NULL,
  `10-11` varchar(12) NOT NULL,
  `11-12` varchar(12) NOT NULL,
  `12-1` varchar(12) NOT NULL,
  `1-2` varchar(12) NOT NULL,
  `2-3` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `123`
--

INSERT INTO `123` (`date`, `9-10`, `10-11`, `11-12`, `12-1`, `1-2`, `2-3`) VALUES
('2024-02-01', '', '', 'yes', '', '', 'yes'),
('2024-02-02', '', 'yes', 'yes', 'yes', 'yes', ''),
('2024-02-09', '', 'yes', '', '', 'yes', ''),
('2024-02-10', 'yes', '', 'yes', 'yes', 'yes', ''),
('2024-02-14', '', '', '', 'yes', '', ''),
('2024-02-24', 'yes', '', 'yes', 'yes', '', 'yes'),
('2024-02-26', 'yes', '', '', '', '', ''),
('2024-02-28', 'yes', '', '', '', 'yes', 'yes'),
('2024-02-29', 'yes', '', '', '', '', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `9347`
--

CREATE TABLE `9347` (
  `date` date NOT NULL,
  `9-10` varchar(12) DEFAULT NULL,
  `10-11` varchar(12) DEFAULT NULL,
  `11-12` varchar(12) DEFAULT NULL,
  `12-1` varchar(12) DEFAULT NULL,
  `1-2` varchar(12) DEFAULT NULL,
  `2-3` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `9347`
--

INSERT INTO `9347` (`date`, `9-10`, `10-11`, `11-12`, `12-1`, `1-2`, `2-3`) VALUES
('2024-02-03', 'yes', 'yes', 'yes', NULL, NULL, NULL),
('2024-02-08', 'yes', 'yes', 'yes', NULL, NULL, NULL),
('2024-02-17', 'yes', NULL, 'yes', 'yes', NULL, NULL),
('2024-02-23', NULL, 'yes', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `D_id` int(11) NOT NULL,
  `slot_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`D_id`, `slot_id`) VALUES
(123, 1);

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `D_id` int(11) NOT NULL,
  `D_name` varchar(60) NOT NULL,
  `Experience` int(11) NOT NULL,
  `D_number` varchar(13) NOT NULL,
  `D_password` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`D_id`, `D_name`, `Experience`, `D_number`, `D_password`) VALUES
(0, 'tejesh_b', 0, '', 321),
(123, 'Avinash', 5, '9347923953', 123),
(321, 'Somu', 6, '7892345656', 12345),
(9347, 'Tejesh_B', 0, '9347923953', 9347),
(123456, '', 0, '', 123456);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `P_number` varchar(11) NOT NULL,
  `P_Name` varchar(60) NOT NULL,
  `Age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`P_number`, `P_Name`, `Age`) VALUES
('9367845464', 'Tejesh', 19);

-- --------------------------------------------------------

--
-- Table structure for table `slot`
--

CREATE TABLE `slot` (
  `slot_id` int(11) NOT NULL,
  `D_id` int(11) NOT NULL,
  `Time` time NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slot`
--

INSERT INTO `slot` (`slot_id`, `D_id`, `Time`, `Date`) VALUES
(1, 123, '05:14:00', '2024-02-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `123`
--
ALTER TABLE `123`
  ADD PRIMARY KEY (`date`);

--
-- Indexes for table `9347`
--
ALTER TABLE `9347`
  ADD PRIMARY KEY (`date`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD KEY `D_id` (`D_id`),
  ADD KEY `slot_id` (`slot_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`D_id`);

--
-- Indexes for table `slot`
--
ALTER TABLE `slot`
  ADD PRIMARY KEY (`slot_id`),
  ADD KEY `D_id` (`D_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`D_id`) REFERENCES `doctors` (`D_id`),
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`slot_id`) REFERENCES `slot` (`slot_id`);

--
-- Constraints for table `slot`
--
ALTER TABLE `slot`
  ADD CONSTRAINT `slot_ibfk_1` FOREIGN KEY (`D_id`) REFERENCES `doctors` (`D_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
