-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 13, 2021 at 03:58 PM
-- Server version: 10.3.27-MariaDB-0+deb10u1
-- PHP Version: 7.3.27-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `det_anki`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `mac_address` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cars_data`
--

CREATE TABLE `cars_data` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `date_time_micro` datetime(2) NOT NULL DEFAULT current_timestamp(2),
  `student_id` int(10) NOT NULL,
  `car_id` int(50) DEFAULT NULL,
  `mac_address` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `speed` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `car_type` varchar(50) DEFAULT NULL,
  `custom_field1` varchar(255) DEFAULT NULL,
  `custom_field2` varchar(255) DEFAULT NULL,
  `custom_field3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `active` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `docs`
--

CREATE TABLE `docs` (
  `doc_id` int(11) NOT NULL,
  `parent_doc_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `docs`
--

INSERT INTO `docs` (`doc_id`, `parent_doc_id`, `name`, `content`, `created`, `modified`) VALUES
(1, NULL, 'Teachers', 'Coming soon...', '2021-06-21 10:35:13', '2021-06-21 10:35:13'),
(2, NULL, 'Students', 'Coming soon...', '2021-06-21 10:35:52', '2021-06-21 10:35:52'),
(3, NULL, 'Overdrive Class Methods', 'Coming soon...', '2021-06-21 10:36:00', '2021-06-21 10:36:00'),
(4, 1, 'Getting Started', 'Coming soon...', '2021-06-21 10:37:48', '2021-06-21 10:37:48'),
(5, 1, 'Setup Wifi and Internet', 'Coming soon...', '2021-06-21 10:37:48', '2021-06-21 10:37:48'),
(6, 1, 'Managing Cars', 'Coming soon...', '2021-06-21 10:37:48', '2021-06-21 10:37:48'),
(7, 1, 'Managing Classes', 'Coming soon...', '2021-06-21 10:37:48', '2021-06-21 10:37:48'),
(8, 1, 'Managing Students', 'Coming soon...', '2021-06-21 10:37:48', '2021-06-21 10:37:48'),
(9, 1, 'FAQ and troubleshooting', 'Coming soon...', '2021-06-21 10:37:48', '2021-06-21 10:37:48'),
(10, 1, 'Get help on MS Teams', 'Coming soon...', '2021-06-21 10:37:48', '2021-06-21 10:37:48'),
(11, 2, 'Getting started', 'Coming soon...', '2021-06-21 10:37:48', '2021-06-21 10:37:48'),
(12, 2, 'Configuring Thonny', 'Coming soon...', '2021-06-21 10:37:48', '2021-06-21 10:37:48'),
(13, 2, 'Configuring Putty Terminal', 'Coming soon...', '2021-06-21 10:37:48', '2021-06-21 10:37:48'),
(14, 2, 'How to drive your car', 'Coming soon...', '2021-06-21 10:39:17', '2021-06-21 10:39:17'),
(15, 2, 'Code examples', 'Coming soon...', '2021-06-21 10:39:17', '2021-06-21 10:39:17'),
(16, 2, 'Managing your code', 'Coming soon...', '2021-06-21 10:39:17', '2021-06-21 10:39:17'),
(17, 2, 'Track and location data', 'Coming soon...', '2021-06-21 10:39:17', '2021-06-21 10:39:17'),
(18, 2, 'Writing custom functions', 'Coming soon...', '2021-06-21 10:39:17', '2021-06-21 10:39:17'),
(19, 2, 'Writing custom classes/methods', 'Coming soon...', '2021-06-21 10:39:17', '2021-06-21 10:39:17'),
(20, 2, 'Database Schema Diagram', 'Coming soon...', '2021-06-21 10:39:17', '2021-06-21 10:39:17'),
(21, 2, 'Writing SQL', 'Coming soon...', '2021-06-21 10:39:17', '2021-06-21 10:39:17'),
(22, 2, 'More advanced challenges', 'Coming soon...', '2021-06-21 10:39:17', '2021-06-21 10:39:17'),
(23, 2, 'Troubleshooting', 'Coming soon...', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(24, 2, 'FAQ', 'Coming soon...', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(25, 3, 'brakeLightsOff()', 'Coming soon...', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(26, 3, 'brakeLightsOn()', 'Coming soon...', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(27, 3, 'changeLane()', 'Coming soon...', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(28, 3, 'changeLaneLeft()', 'Coming soon...', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(29, 3, 'changeLaneRight()', 'Coming soon...', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(30, 3, 'changeSpeed()', '<pre><code class=\"language-python\">car.changeSpeed(<strong>int_speed, int_acceleration</strong>)</code></pre>\r\n<br />\r\nChanges the speed of the car, setting a new speed and acceleration value.\r\n<br />\r\n<br />\r\n<strong>int_speed</strong> should be an integer between 0-1000<br />\r\n<strong>int_acceleration</strong> should be an integer between 0-1000<br />\r\n<br />\r\n<h4>Example Usage</h4>\r\n<br>\r\n<pre><code class=\"language-python\"># change speed to 30% and acceleration to 50%\r\ncar.changeSpeed(300, 500)\r\n</code></pre>\r\n<br>\r\n<pre><code class=\"language-python\"># stop as quick as possible\r\ncar.changeSpeed(0, 1000)\r\n</code></pre>', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(31, 3, 'disconnect()', 'Coming soon...', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(32, 3, 'doMission()', 'Coming soon...', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(33, 3, 'doUturn()', 'Coming soon...', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(34, 3, 'enableLocationData()', 'Coming soon...', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(35, 3, 'getCarId()', 'Coming soon...', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(36, 3, 'getLapCount()', 'Coming soon...', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(37, 3, 'getLapTime()', 'Coming soon...', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(38, 3, 'getLocation()', 'Coming soon...', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(39, 3, 'getOffset()', 'Coming soon...', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(40, 3, 'getPiece()', 'Coming soon...', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(41, 3, 'getSpeed()', 'Coming soon...', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(42, 3, 'getStudentId()', 'Coming soon...', '2021-06-21 10:41:52', '2021-06-21 10:41:52'),
(43, 3, 'getUsername()', 'Coming soon...', '2021-06-21 10:43:51', '2021-06-21 10:43:51'),
(44, 3, 'ping()', 'Coming soon...', '2021-06-21 10:43:51', '2021-06-21 10:43:51'),
(45, 3, 'printDebuggingInfo()', 'Coming soon...', '2021-06-21 10:43:51', '2021-06-21 10:43:51'),
(46, 3, 'sendCommand()', 'Coming soon...', '2021-06-21 10:43:51', '2021-06-21 10:43:51'),
(47, 3, 'sendCommandRaw()', 'Coming soon...', '2021-06-21 10:43:51', '2021-06-21 10:43:51'),
(48, 3, 'setEngineLights()', 'Coming soon...', '2021-06-21 10:43:51', '2021-06-21 10:43:51'),
(49, 3, 'setLane()', 'Coming soon...', '2021-06-21 10:43:51', '2021-06-21 10:43:51'),
(50, 3, 'setLaneChangeAmount()', 'Coming soon...', '2021-06-21 10:43:51', '2021-06-21 10:43:51'),
(51, 3, 'stopCar()', 'Coming soon...', '2021-06-21 10:43:51', '2021-06-21 10:43:51'),
(52, 3, 'stopCarFast()', 'Coming soon...', '2021-06-21 10:43:51', '2021-06-21 10:43:51'),
(53, 3, 'turnLeft()', 'Coming soon...', '2021-06-21 10:44:14', '2021-06-21 10:44:14'),
(54, 3, 'turnRight()', 'Coming soon...', '2021-06-21 10:44:14', '2021-06-21 10:44:14');

-- --------------------------------------------------------

--
-- Table structure for table `lap_times`
--

CREATE TABLE `lap_times` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `lap_time` varchar(100) DEFAULT NULL,
  `lap_count` int(10) DEFAULT NULL,
  `speed` int(9) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `students_cars`
--

CREATE TABLE `students_cars` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(8) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `last_ip` varchar(255) NOT NULL,
  `last_agent` mediumtext NOT NULL,
  `last_login_time` datetime DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `firstname`, `lastname`, `last_ip`, `last_agent`, `last_login_time`, `admin`, `created`, `modified`) VALUES
(1, 'teacher', '$2y$10$nz9Hhyg2UzihdlhJ73mL0eLR7m6PMeMo/36xp/Jb33gCbPWMElUQS', 'teacher', '', '192.168.0.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2021-07-13 14:56:22', 1, '2021-05-21 11:20:00', '2021-07-13 14:56:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`),
  ADD KEY `mac_address` (`mac_address`);

--
-- Indexes for table `cars_data`
--
ALTER TABLE `cars_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mac` (`mac_address`),
  ADD KEY `mac_address` (`mac_address`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `docs`
--
ALTER TABLE `docs`
  ADD PRIMARY KEY (`doc_id`);

--
-- Indexes for table `lap_times`
--
ALTER TABLE `lap_times`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `students_cars`
--
ALTER TABLE `students_cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`,`car_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cars_data`
--
ALTER TABLE `cars_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `docs`
--
ALTER TABLE `docs`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `lap_times`
--
ALTER TABLE `lap_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students_cars`
--
ALTER TABLE `students_cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
