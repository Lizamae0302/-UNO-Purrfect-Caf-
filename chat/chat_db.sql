-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2025 at 06:43 AM
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
-- Database: `chat_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `incoming_msg_id` int(255) NOT NULL,
  `outgoing_msg_id` int(255) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  `msg_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `seen_status` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`, `msg_time`, `seen_status`, `created_at`) VALUES
(36, 1647513543, 886176994, 'ibog cj nimo', '2025-03-26 11:17:02', 1, '2025-03-26 16:30:22'),
(52, 886176994, 1647513543, 'katu man educ akoa.', '2025-03-26 11:17:02', 0, '2025-03-26 16:30:22'),
(81, 0, 0, '$message', '2025-03-26 11:17:29', 0, '2025-03-26 16:30:22'),
(148, 618898102, 753595524, 'hello', '2025-03-27 02:16:33', 1, '2025-03-27 02:16:33'),
(149, 753595524, 618898102, 'keiven cinco marapo', '2025-03-27 02:19:09', 1, '2025-03-27 02:19:09'),
(150, 1647513543, 753595524, 'ibog si Cj nimo', '2025-03-27 02:19:49', 1, '2025-03-27 02:19:49'),
(151, 618898102, 753595524, 'ouh saman?', '2025-03-27 02:21:55', 1, '2025-03-27 02:21:55'),
(152, 753595524, 618898102, 'ngi ibog diay ka ha', '2025-03-27 02:23:05', 1, '2025-03-27 02:23:05'),
(153, 753595524, 741877610, 'Hellooo', '2025-03-27 02:24:15', 1, '2025-03-27 02:24:15'),
(154, 741877610, 753595524, 'hello', '2025-03-27 02:24:20', 0, '2025-03-27 02:24:20'),
(156, 753595524, 1647513543, 'I know', '2025-03-27 02:25:43', 1, '2025-03-27 02:25:43'),
(157, 1647513543, 753595524, 'unya unsa imong ma say?', '2025-03-27 02:26:03', 1, '2025-03-27 02:26:03'),
(158, 618898102, 753595524, 'ouh ngano mn?', '2025-03-27 02:26:11', 1, '2025-03-27 02:26:11'),
(159, 753595524, 618898102, 'pabasa ko ni jeff', '2025-03-27 02:26:37', 1, '2025-03-27 02:26:37'),
(160, 753595524, 1647513543, 'Di nako sya type. Educ akoa', '2025-03-27 02:26:58', 1, '2025-03-27 02:26:58'),
(161, 618898102, 753595524, 'pabasaha, bsan e labay pa nimo niya', '2025-03-27 02:27:07', 1, '2025-03-27 02:27:07'),
(162, 753595524, 618898102, 'naa ra luyo oh', '2025-03-27 02:28:13', 1, '2025-03-27 02:28:13'),
(163, 753595524, 618898102, 'tawgon nako?', '2025-03-27 02:28:18', 1, '2025-03-27 02:28:18'),
(164, 618898102, 753595524, 'tawga', '2025-03-27 02:36:11', 1, '2025-03-27 02:36:11'),
(165, 1647513543, 753595524, 'Sows denial', '2025-03-27 02:39:25', 1, '2025-03-27 02:39:25'),
(166, 753595524, 618898102, 'hi', '2025-03-27 03:48:05', 0, '2025-03-27 03:48:05'),
(168, 1647513543, 689376157, 'Hi palihug ko inggon ni jai nga kaon saktos uras...', '2025-03-27 04:03:27', 1, '2025-03-27 04:03:27'),
(170, 689376157, 1280693420, 'Bayot', '2025-03-27 05:42:40', 0, '2025-03-27 05:42:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `unique_id` int(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `chatroom_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `unique_id`, `fname`, `lname`, `email`, `password`, `img`, `status`, `chatroom_id`) VALUES
(1, 618898102, 'ZEI', 'JI', 'zeiksenpai6@gmail.com', 'bb3aec0fdcdbc2974890f805c585d432', '17430002751722e0e9123a00336902318639cc4133.jpg', 'Offline', NULL),
(2, 1647513543, 'Seven', 'MD', 'seven@gmail.com', '28198b369067e88dab9fefe85484dbf4', '17428783180b28e4f201f9a6262a0afc996ed8c30d.jpg', 'Offline', NULL),
(6, 753595524, 'Yukirin', 'Kabane', 'yukichirin@gmail.com', 'd819fc9c60f83ebd97728dbaa7496a21', '1742984196download (51).jpg', 'Offline', NULL),
(11, 689376157, 'Kieven', 'Salibongcogon', 'Bayot@gmail.com', '202cb962ac59075b964b07152d234b70', '17430481641000006043.jpg', 'Offline', NULL),
(12, 1280693420, 'Aki_', 'Ra', 'akira@gmail.com', '14f1f9729a8142e82600dac241e82fe2', '17430541471000005283.jpg', 'Active now', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
