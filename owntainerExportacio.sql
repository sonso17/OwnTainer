-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2023 at 07:10 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `owntainer`
--

-- --------------------------------------------------------

--
-- Table structure for table `components`
--

CREATE TABLE `components` (
  `UserID` int(11) NOT NULL,
  `ComponentID` int(11) NOT NULL,
  `ComponentName` varchar(40) DEFAULT NULL,
  `ComponentTypeID` int(11) NOT NULL,
  `Privacy` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `components`
--

INSERT INTO `components` (`UserID`, `ComponentID`, `ComponentName`, `ComponentTypeID`, `Privacy`) VALUES
(12, 1, 'Processador1', 1, 'false'),
(12, 2, 'Processador2', 1, 'true'),
(12, 3, 'Processador3', 1, 'false'),
(12, 4, 'Processador4', 1, 'true'),
(12, 16, 'processador chulo', 1, 'false'),
(12, 17, 'processador chulo', 1, 'false'),
(12, 18, 'processador chulo', 1, 'true'),
(12, 19, 'processador chulo', 1, 'true'),
(12, 28, 'processador molon', 1, 'true'),
(12, 29, 'processador molon', 1, 'true');

-- --------------------------------------------------------

--
-- Table structure for table `componenttype`
--

CREATE TABLE `componenttype` (
  `ComponentTypeID` int(11) NOT NULL,
  `ComponentType` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `componenttype`
--

INSERT INTO `componenttype` (`ComponentTypeID`, `ComponentType`) VALUES
(1, 'CPU');

-- --------------------------------------------------------

--
-- Table structure for table `componenttypexproperties`
--

CREATE TABLE `componenttypexproperties` (
  `PKCTXP` int(11) NOT NULL,
  `ComponentTypeID` int(11) NOT NULL,
  `PropertyID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `componenttypexproperties`
--

INSERT INTO `componenttypexproperties` (`PKCTXP`, `ComponentTypeID`, `PropertyID`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `PropertyID` int(11) NOT NULL,
  `PropertyName` varchar(75) NOT NULL,
  `UnitType` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`PropertyID`, `PropertyName`, `UnitType`) VALUES
(1, 'Company', ''),
(2, 'Model', ''),
(3, 'Clock', 'GHz'),
(4, 'Cache', 'MB'),
(5, 'Soket', ''),
(6, 'Cores', ''),
(7, 'CodeName', '');

-- --------------------------------------------------------

--
-- Table structure for table `propertiesxcomponents`
--

CREATE TABLE `propertiesxcomponents` (
  `PKPXC` int(11) NOT NULL,
  `PropertyID` int(11) NOT NULL,
  `ComponentID` int(11) NOT NULL,
  `Valuee` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `propertiesxcomponents`
--

INSERT INTO `propertiesxcomponents` (`PKPXC`, `PropertyID`, `ComponentID`, `Valuee`) VALUES
(1, 1, 1, 'Intel'),
(2, 2, 1, 'i3 2405'),
(3, 3, 1, '2.5'),
(4, 4, 1, '23'),
(5, 5, 1, 'LGA 1155'),
(6, 6, 1, '4'),
(7, 7, 1, 'cofee lake'),
(8, 1, 2, 'AMD'),
(9, 2, 2, 'athlon x2'),
(10, 3, 2, '1.5'),
(11, 4, 2, '3'),
(12, 5, 2, 'AM2'),
(13, 6, 2, '2'),
(14, 7, 2, 'processadorMolon'),
(15, 1, 3, 'Intel'),
(16, 2, 3, 'Core i5 6400'),
(17, 3, 3, '3.00'),
(18, 4, 3, '20'),
(19, 5, 3, 'LGA1155'),
(20, 6, 3, '4'),
(21, 7, 3, 'noSeCodeName'),
(22, 1, 4, 'AMD'),
(23, 2, 4, 'FX8350'),
(24, 3, 4, '2,59'),
(25, 4, 4, '8'),
(26, 5, 4, 'AM3+'),
(27, 6, 4, '8'),
(28, 7, 4, 'AMDMolon'),
(29, 1, 18, 'IntelXulo'),
(30, 2, 18, 'i7 9450H'),
(31, 3, 18, '2,5'),
(32, 4, 18, '6'),
(33, 5, 18, '775'),
(34, 6, 18, '12'),
(35, 7, 18, 'cofee Lake'),
(71, 1, 28, 'Intel'),
(72, 2, 28, 'i7 9450H'),
(73, 3, 28, '2,5'),
(74, 4, 28, '6'),
(75, 5, 28, '775'),
(76, 6, 28, '12'),
(77, 7, 28, 'cofee Lake'),
(78, 1, 28, 'Intel'),
(79, 2, 28, 'i7 9450H'),
(80, 3, 28, '2,5'),
(81, 4, 28, '6'),
(82, 5, 28, '775'),
(83, 6, 28, '12'),
(84, 7, 28, 'cofee Lake');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `FirstName` varchar(20) DEFAULT NULL,
  `LastName` varchar(20) DEFAULT NULL,
  `email` varchar(75) NOT NULL,
  `passwd` varchar(50) NOT NULL,
  `APIKEY` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `FirstName`, `LastName`, `email`, `passwd`, `APIKEY`) VALUES
(5, 'Aleix12', 'aleix12', 'aleix2231@fedrick.cat', 'aleix1234', 'oioz0bjVYUqCGzU'),
(7, 'Frick', 'fedrick', 'fedrick@fedrick.cat', 'fedrick1234', 'mtK3iRIg37580Tq'),
(10, 'Aleix12', 'aleix12', 'aleix22312@fedrick.cat', 'aleix1234', 'P9eEAMncaHZnE97'),
(12, 'Aleix13', 'aleix13', 'aleix1@fedrick.cat', 'aleix123413', '2PyEL61y9c8m8H5');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `components`
--
ALTER TABLE `components`
  ADD PRIMARY KEY (`ComponentID`),
  ADD UNIQUE KEY `ComponentID` (`ComponentID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ComponentTypeID` (`ComponentTypeID`);

--
-- Indexes for table `componenttype`
--
ALTER TABLE `componenttype`
  ADD PRIMARY KEY (`ComponentTypeID`);

--
-- Indexes for table `componenttypexproperties`
--
ALTER TABLE `componenttypexproperties`
  ADD PRIMARY KEY (`PKCTXP`),
  ADD KEY `ComponentTypeID` (`ComponentTypeID`),
  ADD KEY `PropertyID` (`PropertyID`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`PropertyID`);

--
-- Indexes for table `propertiesxcomponents`
--
ALTER TABLE `propertiesxcomponents`
  ADD PRIMARY KEY (`PKPXC`),
  ADD KEY `PropertyID` (`PropertyID`),
  ADD KEY `ComponentID` (`ComponentID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `components`
--
ALTER TABLE `components`
  MODIFY `ComponentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `componenttype`
--
ALTER TABLE `componenttype`
  MODIFY `ComponentTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `componenttypexproperties`
--
ALTER TABLE `componenttypexproperties`
  MODIFY `PKCTXP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `PropertyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `propertiesxcomponents`
--
ALTER TABLE `propertiesxcomponents`
  MODIFY `PKPXC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `components`
--
ALTER TABLE `components`
  ADD CONSTRAINT `components_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `components_ibfk_2` FOREIGN KEY (`ComponentTypeID`) REFERENCES `componenttype` (`ComponentTypeID`);

--
-- Constraints for table `componenttypexproperties`
--
ALTER TABLE `componenttypexproperties`
  ADD CONSTRAINT `componenttypexproperties_ibfk_1` FOREIGN KEY (`ComponentTypeID`) REFERENCES `componenttype` (`ComponentTypeID`),
  ADD CONSTRAINT `componenttypexproperties_ibfk_2` FOREIGN KEY (`PropertyID`) REFERENCES `properties` (`PropertyID`);

--
-- Constraints for table `propertiesxcomponents`
--
ALTER TABLE `propertiesxcomponents`
  ADD CONSTRAINT `propertiesxcomponents_ibfk_1` FOREIGN KEY (`PropertyID`) REFERENCES `properties` (`PropertyID`),
  ADD CONSTRAINT `propertiesxcomponents_ibfk_2` FOREIGN KEY (`ComponentID`) REFERENCES `components` (`ComponentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
