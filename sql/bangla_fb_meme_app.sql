-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2024 at 09:43 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bangla_fb_meme_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `memes`
--

CREATE TABLE `memes` (
  `id` int(100) NOT NULL,
  `img` varchar(500) NOT NULL,
  `like` int(100) NOT NULL DEFAULT 0,
  `download` int(100) NOT NULL DEFAULT 0,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `memes`
--

INSERT INTO `memes` (`id`, `img`, `like`, `download`, `create_at`) VALUES
(1, 'https://i.ibb.co/xHCmqBC/image.png', 0, 0, '2024-08-26 19:08:50'),
(2, 'https://i.ibb.co/jvmQtqc/image.png', 0, 0, '2024-08-26 19:09:18'),
(5, 'https://i.ibb.co/jvmQtqc/image.png', 0, 0, '2024-08-26 19:39:57'),
(6, 'https://i.ibb.co/jvmQtqc/image.png', 0, 0, '2024-08-26 19:40:01'),
(7, 'https://i.ibb.co/jvmQtqc/image.png', 0, 0, '2024-08-26 19:40:04'),
(8, 'https://i.ibb.co/jvmQtqc/image.png', 0, 0, '2024-08-26 19:40:07'),
(9, 'https://i.ibb.co/jvmQtqc/image.png', 0, 0, '2024-08-26 19:40:10'),
(10, 'https://i.ibb.co/jvmQtqc/image.png', 0, 0, '2024-08-26 19:40:21');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(100) NOT NULL,
  `ban_ad_id` varchar(255) NOT NULL,
  `int_ad_id` varchar(255) NOT NULL,
  `is_ads_enable` int(100) NOT NULL DEFAULT 1,
  `notice` varchar(255) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `one_app_id` varchar(255) NOT NULL,
  `one_api_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `ban_ad_id`, `int_ad_id`, `is_ads_enable`, `notice`, `package_name`, `create_at`, `one_app_id`, `one_api_key`) VALUES
(1, '0', '0', 1, '0', '0', '2024-08-26 18:16:51', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `pass`, `create_at`) VALUES
(1, 'admin', 'admin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '2024-08-18 10:27:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `memes`
--
ALTER TABLE `memes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `memes`
--
ALTER TABLE `memes`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
