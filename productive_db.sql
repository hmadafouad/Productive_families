-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2019 at 04:17 AM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `productive_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`) VALUES
(1, 'Cooking'),
(2, 'Desserts'),
(3, 'Accessories'),
(4, 'Knitting'),
(5, 'Drinks');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Price` int(11) NOT NULL,
  `Date` date NOT NULL,
  `City` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ID`, `Name`, `Description`, `Price`, `Date`, `City`, `img`, `Cat_ID`, `Member_ID`) VALUES
(58, 'warak enab', '', 50, '2019-04-17', 'Jeddah', '55836_warak enan.jpg', 1, 15),
(60, 'dress', 'by knitting', 80, '2019-04-17', 'Medina', '64534_dress.jpg', 4, 26),
(61, 'kabsaa', 'saudi', 80, '2019-04-17', 'Jeddah', '70931_kabsa.jpg', 1, 26),
(62, 'necklace', 'handmade', 30, '2019-04-17', 'Mecca', '35164_necklace.jpg', 3, 27),
(63, 'kunafa', '', 50, '2019-04-17', 'Mecca', '11065_Kunafa.jpg', 2, 27),
(77, 'Bracelet', 'for women', 50, '2019-05-06', 'Jeddah', '90229_Bracelet.jpg', 3, 15);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `Rating` int(11) DEFAULT NULL,
  `Item_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`Rating`, `Item_ID`) VALUES
(4, 58),
(5, 58),
(4, 58),
(4, 63),
(4, 63),
(3, 63),
(5, 63),
(2, 58),
(2, 58),
(3, 63),
(3, 63),
(2, 63),
(1, 63),
(2, 63),
(1, 63),
(5, 63),
(1, 63),
(4, 63),
(3, 63),
(2, 63),
(1, 63);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `Phone` int(11) NOT NULL,
  `Instagram` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT '0',
  `City` varchar(255) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Name`, `Email`, `Password`, `FullName`, `Phone`, `Instagram`, `GroupID`, `City`, `Date`) VALUES
(1, 'hmada', '', '123123', 'hmada fouad', 0, 'hmada.fouad', 1, 'jeddah', '2019-05-01'),
(2, 'osamah', 'osamah@gmail.com', '123123', 'osamah hael', 0, '', 1, '', '0000-00-00'),
(15, 'malek', 'malek@gmail.com', '123123', 'malek agely', 508765336, 'Hmada.foud', 0, 'Jeddah', '2019-04-04'),
(26, 'alaa', 'alaa@gmail.com', '123123', 'alaa saed', 557793480, 'alaa.al', 0, 'Medina', '2019-04-17'),
(27, 'rehamm', 'reham@gmail.com', '123123', 'reham mohammed', 0, 'rehaam.77', 0, 'Mecca', '2019-04-17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `cat_1` (`Cat_ID`),
  ADD KEY `Member_1` (`Member_ID`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD KEY `rate_id` (`Item_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `Member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rate_id` FOREIGN KEY (`Item_ID`) REFERENCES `items` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
