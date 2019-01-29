-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2019 at 07:43 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employer_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `employer`
--

CREATE TABLE `employer` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `emailid` varchar(50) NOT NULL,
  `mobilenumber` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employer`
--

INSERT INTO `employer` (`id`, `username`, `firstname`, `lastname`, `emailid`, `mobilenumber`, `password`, `created_at`) VALUES
(16, 'Amar', 'amaraaa', 'nathaaaasdaaaa', 'amarnatah@gmail.com', '67868787689', '$2y$10$fOu8h9.x6dgKIyxV9NYTGuHtO/Cs2bDTI47nxct3L7lpWFoiSdffO', '2018-09-24 15:14:43'),
(26, 'aaa', 'aa', 'aa', 'aaaaa@gmail.com', '324242424', '$2y$10$xgZD61Xg0vsdbE2bgnf0WuWJ3uhMhl8XZAA0tciV/xXXGe.rRlklu', '2018-09-27 15:14:27'),
(27, 'bbb', 'bbb3e4', 'bbb', 'bbbb@gmasi.com', '23423424', '$2y$10$SHDreqPATi/YbYl/BeYSK.LVafHmBDK7qqI.tBB0OlSUZMQ/ueWFy', '2018-09-27 15:15:09'),
(29, 'ddd', 'ddd', 'ddd', 'ddd@gmail.com', '3242342424234', '$2y$10$OJLATfLxebhnwMHcx4gYdO8fDnoXth.nb5pE0MkjqX17urRyrpVU2', '2018-09-27 15:35:29'),
(30, 'abhikm', 'sdhjakdask', 'shdsj', 'jedhgsakjda@gmail.com', '82638726482864', '$2y$10$LYXLITgw801XTPdWl8iMt.wgyQohTDlzyGnIU9tKUyRPFER48/xaa', '2019-01-12 08:58:30'),
(31, 'Abhi', 'Abhilash', 'Karanth', 'asdakjhdka@gmail.com', '65238744286', '$2y$10$4VWoHV9ylz6IE1spgjyhtea2UF3NE6b3mnsgZpaziy.eiSxu/atBy', '2019-01-12 09:05:00'),
(32, 'abh', 'ccc', 'sss', 'asaadaa@gmail.com', '6789797979', '$2y$10$wEizeTIfRTIcs32.uOxage/pis.ZVdnlSG/Bb1ZJVgNxk0hKKDGue', '2019-01-29 11:52:26'),
(33, 'ggg', 'hhh', 'ahsdakjh@gmail.com', 'ashsaskl@gmail.com', '56787687898', '$2y$10$ueoyOxXerzks3cYvcMIZoeTKETCfHemt43sFf6MghtVrPS6vY3WiS', '2019-01-29 12:04:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employer`
--
ALTER TABLE `employer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `firstname` (`firstname`),
  ADD UNIQUE KEY `lastname` (`lastname`),
  ADD UNIQUE KEY `emailid` (`emailid`),
  ADD UNIQUE KEY `mobilenumber` (`mobilenumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employer`
--
ALTER TABLE `employer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
