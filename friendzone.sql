-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2024 at 01:12 PM
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
-- Database: `friendzone`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `interaction_id` int(11) NOT NULL,
  `comment_content` varchar(280) NOT NULL,
  `commenter_email` varchar(100) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `interaction_id`, `comment_content`, `commenter_email`, `timestamp`) VALUES
(1, 3, 'Yes I can see your test post', 'jamal.kingston@email.com', '2024-02-27 11:33:38'),
(2, 7, 'Nice to meet you Jude!', 'toke.makinwa@email.com', '2024-02-27 14:16:55'),
(3, 3, 'Hey, I think the site works!', 'jane.doe@email.com', '2024-02-27 15:25:59');

-- --------------------------------------------------------

--
-- Table structure for table `interactions`
--

CREATE TABLE `interactions` (
  `id` int(11) NOT NULL,
  `content` varchar(280) NOT NULL,
  `email` varchar(100) NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interactions`
--

INSERT INTO `interactions` (`id`, `content`, `email`, `timestamp`) VALUES
(2, 'Test post', 'toke.makinwa@email.com', '2024-02-24 16:47:01'),
(3, 'Hello, This is another test post.', 'toke.makinwa@email.com', '2024-02-24 16:52:29'),
(4, 'checking for another user.', 'jamal.kingston@email.com', '2024-02-24 16:53:08'),
(6, 'testing again', 'langjing.xu@email.com', '2024-02-27 12:38:26'),
(7, 'Hello, my name is Jude and I am new to Friendzone :)', 'jude.bello@email.com', '2024-02-27 15:16:42');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `interaction_id` int(11) NOT NULL,
  `liker_email` varchar(100) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `interaction_id`, `liker_email`, `timestamp`) VALUES
(1, 4, 'jamal.kingston@email.com', '2024-02-24 17:30:15'),
(2, 3, 'toke.makinwa@email.com', '2024-02-24 19:09:26'),
(3, 2, 'toke.makinwa@email.com', '2024-02-27 11:34:03'),
(4, 4, 'jamal.kingston@email.com', '2024-02-27 11:34:37'),
(5, 6, 'langjing.xu@email.com', '2024-02-27 11:38:55'),
(6, 7, 'jude.bello@email.com', '2024-02-27 14:17:05');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `ID` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `biography` varchar(280) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`ID`, `email`, `biography`) VALUES
(1, 'toke.makinwa@email.com', 'Hello, my name is Toke and welcome to my profile! Lets connect :)'),
(2, 'jane.doe@gmail.com', 'hello!');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `phone_number`) VALUES
(1, 'Johnny', 'Smith', 'johnny.smith@email.com', '$2y$10$iCXAwsn1by4QaaXLLM4v4OxUsnjncrcNb.hapX3LvLV88GcWEY7dC', 1234567891),
(3, 'Busola', 'Adeaga', 'busola.adeaga@email.com', '$2y$10$xlYSWkOtaHe9iPEH4WXAT.mbav/ooHAumRR0Kar7nru6oiM5RpanK', 1234567892),
(4, 'Toke', 'Makinwa', 'toke.makinwa@email.com', '$2y$10$bnzRuUw2jbDlQw3Da5EE4..NSvqdRsVHYpOCNIm8uAz1mCpotXU32', 1234567893),
(5, 'Jamal', 'Kingston', 'jamal.kingston@email.com', '$2y$10$KW79RyMb46Z/SNcQh90QAOu/0ZZeTq0NjPjVl0EVwsFe6Mo21KwhC', 1234567894),
(6, 'Langjing', 'Xu', 'langjing.xu@email.com', '$2y$10$E6w/XxmHtTT5DVz5fV37Z.uNuDcUt9gKZkxJKFexrgIgEVQuRIhNS', 1234567895),
(7, 'Jane', 'Doe', 'jane.doe@email.com', '$2y$10$Hi1yNoPpEghFNKVYsvDFMugF4ozCM45iEqYSHS7/d8hyW5aIj006.', 1234567896),
(8, 'Jude', 'Bello', 'jude.bello@email.com', '$2y$10$GYDJPg/pbMP3A8pl/zu.SeyyoIjSJAx1.1T0MKLZt2gD5n7jaVOCq', 1234567897);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interaction_id` (`interaction_id`);

--
-- Indexes for table `interactions`
--
ALTER TABLE `interactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interaction_id` (`interaction_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `interactions`
--
ALTER TABLE `interactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`interaction_id`) REFERENCES `interactions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`interaction_id`) REFERENCES `interactions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
