-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2018 at 10:18 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reactjs-weather-app`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created`, `modified`) VALUES
(1, 'Fashion', 'Category for anything related to fashion.', '2014-06-01 00:35:07', '2014-05-30 07:34:33'),
(2, 'Electronics', 'Gadgets, drones and more.', '2014-06-01 00:35:07', '2014-05-30 07:34:33'),
(3, 'Motors', 'Motor sports and more', '2014-06-01 00:35:07', '2014-05-30 07:34:54'),
(5, 'Movies', 'Movie products.', '0000-00-00 00:00:00', '2016-01-08 03:27:26'),
(6, 'shoes', 'shoes of all kinds', '0000-00-00 00:00:00', '2016-01-08 03:27:47'),
(13, 'Sports', 'Drop into new winter gear.', '2016-01-09 02:24:24', '2016-01-08 15:24:24'),
(25, 'testTEST99', 'TEST99', '2018-04-17 06:19:55', '2018-04-17 04:19:55'),
(24, 'teset2', 'teset2', '2018-04-17 06:16:13', '2018-04-17 04:16:13'),
(23, 'test', 'test', '2018-04-17 06:14:06', '2018-04-17 04:14:06'),
(26, '', '', '2018-04-17 07:45:30', '2018-04-17 05:45:30');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category_id`, `created`, `modified`) VALUES
(292, '', '', 0, '2018-04-16 11:44:11', '2018-04-16 09:44:11'),
(296, '', '', 0, '2018-04-17 02:39:46', '2018-04-17 00:39:46'),
(298, '', '', 0, '2018-04-17 05:12:30', '2018-04-17 03:12:30'),
(294, '', '', 0, '2018-04-16 12:09:18', '2018-04-16 10:09:18'),
(295, 'this is a tesstxx', 'nice name', 6, '2018-04-16 12:09:18', '2018-04-16 10:09:18'),
(289, '', '', 0, '2018-04-16 11:19:21', '2018-04-16 09:19:21'),
(299, 'new product', 'new product', 2, '2018-04-17 05:12:30', '2018-04-17 03:12:30'),
(300, '', '', 0, '2018-04-17 05:55:30', '2018-04-17 03:55:30'),
(301, '', '', 0, '2018-04-17 05:55:30', '2018-04-17 03:55:30'),
(302, '', '', 0, '2018-04-17 06:09:23', '2018-04-17 04:09:23'),
(303, '', '', 0, '2018-04-17 06:09:23', '2018-04-17 04:09:23'),
(304, '', '', 0, '2018-04-19 05:26:03', '2018-04-19 03:26:03'),
(305, '', '', 0, '2018-04-19 05:46:39', '2018-04-19 03:46:39'),
(306, '', '', 0, '2018-04-19 05:46:40', '2018-04-19 03:46:40'),
(307, '', '', 0, '2018-04-19 05:59:52', '2018-04-19 03:59:52'),
(308, '', '', 0, '2018-04-19 06:01:01', '2018-04-19 04:01:01'),
(309, '', '', 0, '2018-04-19 06:01:51', '2018-04-19 04:01:51'),
(310, '', '', 0, '2018-04-19 06:01:52', '2018-04-19 04:01:52'),
(311, '', '', 0, '2018-04-19 06:01:53', '2018-04-19 04:01:53'),
(312, '', '', 0, '2018-04-19 06:01:55', '2018-04-19 04:01:55'),
(313, '', '', 0, '2018-04-19 06:01:56', '2018-04-19 04:01:56'),
(314, '', '', 0, '2018-04-19 06:01:56', '2018-04-19 04:01:56'),
(315, '', '', 0, '2018-04-19 06:01:57', '2018-04-19 04:01:57'),
(316, '', '', 0, '2018-04-19 06:01:58', '2018-04-19 04:01:58'),
(317, '', '', 0, '2018-04-19 06:01:58', '2018-04-19 04:01:58'),
(318, '', '', 0, '2018-04-19 06:02:20', '2018-04-19 04:02:20'),
(319, '', '', 0, '2018-04-19 06:02:21', '2018-04-19 04:02:21');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_activity_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `address` varchar(32) NOT NULL,
  `due_date` varchar(40) CHARACTER SET utf8 NOT NULL,
  `content` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `assigned` varchar(3) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `user_id`, `request_activity_id`, `title`, `address`, `due_date`, `content`, `category_id`, `status`, `assigned`, `created`, `modified`) VALUES
(39, 2, 0, 'Bed,mattress, two bedside table ', '44 qilance street', '2018-09-06T14:00:00.000Z', 'I want the double bed&amp;mattress and two bedside table to be delivered at Caulfield South from Murrumbeena twelve minutes drive', 0, 'open', '', '2018-04-20 05:53:55', '2018-04-20 03:53:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(40) NOT NULL,
  `contact_number` int(20) NOT NULL,
  `address` varchar(300) NOT NULL,
  `date_of_birth` date NOT NULL,
  `nationality` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `date_of_joining` date NOT NULL,
  `user_group_id` int(10) NOT NULL,
  `cast` varchar(20) NOT NULL,
  `religion` varchar(20) NOT NULL,
  `marital_status` varchar(20) NOT NULL,
  `nominee_name` varchar(60) NOT NULL,
  `father_name` varchar(60) NOT NULL,
  `mother_name` varchar(60) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `email`, `contact_number`, `address`, `date_of_birth`, `nationality`, `gender`, `date_of_joining`, `user_group_id`, `cast`, `religion`, `marital_status`, `nominee_name`, `father_name`, `mother_name`, `modified`, `created`) VALUES
(2, 'arden', 'd23b499f09b7e2d5276b7a3f77bcb86519e0c48abd379dc37fe30148d7ecb054', 'kharddie@gmail.com', 0, '', '0000-00-00', '', '', '0000-00-00', 0, '', '', '', '', '', '', '2018-04-17 10:17:31', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_group_id` (`user_group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=320;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
