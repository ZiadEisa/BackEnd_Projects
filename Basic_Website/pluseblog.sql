-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2024 at 08:35 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pluseblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `BlogID` int(11) NOT NULL,
  `BlogContent` text NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `Dlikes` int(11) NOT NULL DEFAULT 0,
  `userID` int(11) NOT NULL,
  `image` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`BlogID`, `BlogContent`, `likes`, `Dlikes`, `userID`, `image`) VALUES
(106, 'aaaaaaaaaaaaaaaa', 0, 0, 1, NULL),
(107, 'cscszc', 0, 0, 1, ''),
(108, 'ascsz', 0, 0, 1, NULL),
(109, 'ascsz', 0, 0, 1, NULL),
(110, 'Blog1', 0, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `CommentID` int(11) NOT NULL,
  `BlogID` int(11) DEFAULT NULL,
  `Content` text DEFAULT NULL,
  `userID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Name` varchar(30) NOT NULL,
  `UserID` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Name`, `UserID`, `email`, `password`) VALUES
('Adel', 1, 'fsdfsf@gmail.com', '111'),
('wefaes', 2, 'fsdfsf@gmail.com', '123'),
('wefaes', 3, 'fsdfsf@gmail.com', '123'),
('nbow', 4, 'asdzsdc@sdcd.sdmfa', '123'),
('samy', 5, 'sfsfsfsdad@gmail.com', '123'),
('nnlnsd', 6, 'sfsfsfsdad@gmail.com', '123'),
('dd', 7, 'sfsfsfsdad@gmail.com', '123'),
('Ziad_Mohammadx', 8, 'fsdfsf@gmail.com', '123'),
('Ziadca', 9, 'ziadesaa102@gmail.com', '123'),
('qfwfwe', 10, 'ziadesaa102@gmail.com', '123'),
('mjolfa', 11, 'ziadesaa102@gmail.com', '123'),
('fasdcf', 12, 'ziadesaa102@gmail.com', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`BlogID`),
  ADD KEY `fk_user_blog` (`userID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `fk_Bl_Com` (`BlogID`),
  ADD KEY `fk_Bl_usr` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `BlogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `fk_user_blog` FOREIGN KEY (`userID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_Bl_Com` FOREIGN KEY (`BlogID`) REFERENCES `blog` (`BlogID`),
  ADD CONSTRAINT `fk_Bl_usr` FOREIGN KEY (`userID`) REFERENCES `user` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
