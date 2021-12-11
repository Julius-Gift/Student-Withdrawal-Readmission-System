-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2021 at 12:58 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `swrs`
--

-- --------------------------------------------------------

--
-- Table structure for table `readmission`
--

CREATE TABLE `readmission` (
  `appID` int(11) NOT NULL,
  `studentID` int(11) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `names` varchar(500) NOT NULL,
  `comp` varchar(20) NOT NULL,
  `school` varchar(255) NOT NULL,
  `program` varchar(255) NOT NULL,
  `with_date` date NOT NULL,
  `with_ext` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `postal` varchar(500) DEFAULT NULL,
  `tel` varchar(150) DEFAULT NULL,
  `reason` varchar(255) NOT NULL,
  `exp` text NOT NULL,
  `doc` varchar(650) NOT NULL,
  `doc_name` varchar(255) DEFAULT NULL,
  `sub_date` date NOT NULL,
  `location` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `read_feedback`
--

CREATE TABLE `read_feedback` (
  `feedback_id` int(11) NOT NULL,
  `feedback` varchar(20) NOT NULL,
  `feedback_on` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(350) NOT NULL,
  `password` longtext NOT NULL,
  `fullname` varchar(500) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw`
--

CREATE TABLE `withdraw` (
  `appId` int(11) NOT NULL,
  `studentID` int(11) DEFAULT NULL,
  `surname` varchar(255) NOT NULL,
  `names` varchar(255) NOT NULL,
  `computer` varchar(255) NOT NULL,
  `school` varchar(255) NOT NULL,
  `program` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `reason` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_from` varchar(50) DEFAULT NULL,
  `date_to` varchar(50) DEFAULT NULL,
  `doc_name` varchar(255) DEFAULT NULL,
  `pdf` varchar(535) NOT NULL,
  `loc` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `with_feedback`
--

CREATE TABLE `with_feedback` (
  `feedback_id` int(11) NOT NULL,
  `feedback` varchar(20) NOT NULL,
  `application_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `readmission`
--
ALTER TABLE `readmission`
  ADD PRIMARY KEY (`appID`),
  ADD KEY `readmission_ibfk_1` (`studentID`);

--
-- Indexes for table `read_feedback`
--
ALTER TABLE `read_feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `app_id` (`feedback_on`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD PRIMARY KEY (`appId`),
  ADD KEY `withdrawals_ibfk_1` (`studentID`);

--
-- Indexes for table `with_feedback`
--
ALTER TABLE `with_feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `app_id` (`application_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `readmission`
--
ALTER TABLE `readmission`
  MODIFY `appID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `read_feedback`
--
ALTER TABLE `read_feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `appId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `with_feedback`
--
ALTER TABLE `with_feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `readmission`
--
ALTER TABLE `readmission`
  ADD CONSTRAINT `readmission_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `read_feedback`
--
ALTER TABLE `read_feedback`
  ADD CONSTRAINT `read_feedback_ibfk_1` FOREIGN KEY (`feedback_on`) REFERENCES `readmission` (`appID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD CONSTRAINT `withdraw_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `with_feedback`
--
ALTER TABLE `with_feedback`
  ADD CONSTRAINT `with_feedback_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `withdraw` (`appId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
