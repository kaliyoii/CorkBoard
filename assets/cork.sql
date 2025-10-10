-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2025 at 04:28 AM
-- Server version: 10.4.24-MariaDB-log
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cork`
--

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `color` varchar(50) DEFAULT NULL,
  `pin_color` varchar(50) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `type` varchar(100) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `x` int(11) DEFAULT 0,
  `y` int(11) DEFAULT 0,
  `w` int(11) DEFAULT 0,
  `h` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `user_id`, `title`, `content`, `color`, `pin_color`, `timestamp`, `type`, `img`, `x`, `y`, `w`, `h`) VALUES
(1, 2, 'Meeting Notes', 'Discuss project milestones and team updates.', '#ffcc00', '#ff9900', '2025-10-10 09:26:24', 'important', 'meeting.png', 100, 200, 300, 150),
(2, 2, 'Shopping List', 'Eggs, Milk, Bread, Butter, Coffee', '#99ffcc', '#33cc99', '2025-10-09 09:15:00', 'list', 'shopping.png', 50, 100, 250, 120),
(3, 1, 'Daily Reminder', 'Call the client at 3 PM.', '#ccccff', '#6666ff', '2025-10-08 14:00:00', 'reminder', 'reminder.jpg', 200, 300, 200, 100),
(4, 3, 'Workout Plan', 'Pushups, Situps, Running, Stretching.', '#ff9999', '#cc3333', '2025-10-07 06:00:00', 'note', 'fitness.png', 400, 250, 220, 130);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `level`) VALUES
(1, 'budi', 'budi', 'admin'),
(2, 'udin', 'udin', 'user'),
(3, 'budi', 'budi', 'admin'),
(4, 'udin', 'udin', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notes_user` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `fk_notes_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
