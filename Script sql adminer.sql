-- Adminer 4.7.9 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `components`;
CREATE TABLE `components` (
  `UserID` int(11) NOT NULL,
  `ComponentID` int(11) NOT NULL AUTO_INCREMENT,
  `ComponentName` varchar(40) DEFAULT NULL,
  `ComponentTypeID` int(11) NOT NULL,
  `Privacy` varchar(5) DEFAULT NULL,
  `dependsOn` int(11) DEFAULT NULL,
  PRIMARY KEY (`ComponentID`),
  UNIQUE KEY `ComponentID` (`ComponentID`),
  KEY `UserID` (`UserID`),
  KEY `ComponentTypeID` (`ComponentTypeID`),
  KEY `dependsOn` (`dependsOn`),
  CONSTRAINT `components_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  CONSTRAINT `components_ibfk_2` FOREIGN KEY (`ComponentTypeID`) REFERENCES `componenttype` (`ComponentTypeID`),
  CONSTRAINT `components_ibfk_3` FOREIGN KEY (`dependsOn`) REFERENCES `components` (`ComponentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `componenttype`;
CREATE TABLE `componenttype` (
  `ComponentTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `ComponentType` varchar(50) NOT NULL,
  PRIMARY KEY (`ComponentTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `componenttypexproperties`;
CREATE TABLE `componenttypexproperties` (
  `PKCTXP` int(11) NOT NULL AUTO_INCREMENT,
  `ComponentTypeID` int(11) NOT NULL,
  `PropertyID` int(11) NOT NULL,
  PRIMARY KEY (`PKCTXP`),
  KEY `ComponentTypeID` (`ComponentTypeID`),
  KEY `PropertyID` (`PropertyID`),
  CONSTRAINT `componenttypexproperties_ibfk_1` FOREIGN KEY (`ComponentTypeID`) REFERENCES `componenttype` (`ComponentTypeID`),
  CONSTRAINT `componenttypexproperties_ibfk_2` FOREIGN KEY (`PropertyID`) REFERENCES `properties` (`PropertyID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `properties`;
CREATE TABLE `properties` (
  `PropertyID` int(11) NOT NULL AUTO_INCREMENT,
  `PropertyName` varchar(75) NOT NULL,
  `UnitType` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`PropertyID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `propertiesxcomponents`;
CREATE TABLE `propertiesxcomponents` (
  `PKPXC` int(11) NOT NULL AUTO_INCREMENT,
  `PropertyID` int(11) NOT NULL,
  `ComponentID` int(11) NOT NULL,
  `Valuee` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`PKPXC`),
  KEY `PropertyID` (`PropertyID`),
  KEY `ComponentID` (`ComponentID`),
  CONSTRAINT `propertiesxcomponents_ibfk_1` FOREIGN KEY (`PropertyID`) REFERENCES `properties` (`PropertyID`),
  CONSTRAINT `propertiesxcomponents_ibfk_2` FOREIGN KEY (`ComponentID`) REFERENCES `components` (`ComponentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(20) DEFAULT NULL,
  `LastName` varchar(20) DEFAULT NULL,
  `email` varchar(75) NOT NULL,
  `passwd` varchar(50) NOT NULL,
  `APIKEY` varchar(15) NOT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 2023-05-09 09:44:46