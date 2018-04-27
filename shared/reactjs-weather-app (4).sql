-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2018 at 07:07 AM
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
  `created` varchar(40) CHARACTER SET utf8 NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `user_id`, `request_activity_id`, `title`, `address`, `due_date`, `content`, `category_id`, `status`, `assigned`, `created`, `modified`) VALUES
(11, 2, 0, 'Move bed mattress tv and two box', '300 stacy lane perth', '2018-04-12T14:00:00.000Z', 'Need two people to movemy three seater in my van literally 10 metres away.\n\nWould be ideal to come by 630pm tonight OR\nAround 9pm', 0, 'open', '', '2018-04-23 10:32:22', '2018-04-23 08:32:22'),
(12, 2, 0, 'Move bed mattress tv and two box', '300 stacy lane perth', '2018-04-17T14:00:00.000Z', 'Need two people to movemy three seater in my van literally 10 metres away.\n\nWould be ideal to come by 630pm tonight OR\nAround 9pm', 0, 'open', '', '2018-04-23 10:34:28', '2018-04-23 08:34:28'),
(13, 2, 0, 'Calling All Travellers! Share Yo', '555 erick street bulimba', '2018-04-11T14:00:00.000Z', 'Need two people to movemy three seater in my van literally 10 metres away.\n\nWould be ideal to come by 630pm tonight OR\nAround 9pm', 0, 'open', '', '2018-04-23 10:35:34', '2018-04-23 08:35:34'),
(16, 0, 0, '', '', '', '', 0, 'open', '', '2018-04-26 07:26:13', '2018-04-26 05:26:13'),
(17, 2, 0, 'Carpet Cleaning New Farm', 'South Brisbane QLD, Australia', '2018-04-05T14:00:00.000Z', 'Looking for help to Install and dismantle an exhibition stand.\nBasic tools required cordless drill, bits, tape and hi-vis shirt/vest.\n\nBrisbane Convention and Exhibition Centre\n5 May 2pm-10pm\n6 May 7am-11am\n10 May 3pm-12am\n21hrs total\nMust be available all days', 0, 'open', '', '2018-04-26 07:26:14', '2018-04-26 05:26:14'),
(18, 0, 0, '', '', '', '', 0, 'open', '', '2018-04-27 04:40:23', '2018-04-27 02:40:23'),
(19, 2, 0, 'JUST NOW', '555 erick street bulimba', '2018-04-09T14:00:00.000Z', 'lid prop `selected` of type `string` supplied to `Calendar`, expected `object`. Check the render method of `OnClickOutside(Calendar)`.\nwarning @ warning.js:45\ncheckPropTypes @ ReactElementValidator.js:189\nvalidatePropTypes @ ReactElementValidator.js:208\ncreateElement @ ReactElementValidator.js:242\nrender @ react-onclickoutside.es.js:331\n_renderValidatedComponentWithoutOwnerOrContext @ ReactCompositeComponent.js:587\n_renderValidatedComponent @ ReactCompositeComponent.js:607\nReactCompositeComponent__renderValidatedComponent @ ReactPerf.js:66\nmountComponent @ ReactCompositeComponent.js:220\nReactCompositeComponent_mountComponent @ ReactPerf.js:66\nmountComponent @ ReactReconciler.js:37\nmountChildren @ ReactMultiChild.js:241\n_createContentMarkup @ ReactDOMComponent.js:591\nmountComponent @ ReactDOMComponent.js:479\nmountComponent @ ReactReconciler.js:37\nmountComponent @ ReactCompositeComponent.js:225\nReactCompositeComponent_mountComponent @ ReactPerf.js:66\nmountComponent @ ReactReconciler.js:37\n_mountChildByNameAtIndex @ ReactMultiChild.js:474\n_updateChildren @ ReactMultiChild.js:378\nupdateChildren @ ReactMultiChild.js:326\n_updateDOMChildren @ ReactDOMComponent.js:871\nupdateComponent @ ReactDOMComponent.js:700\nreceiveComponent @ ReactDOMComponent.js:645\nreceiveComponent @ ReactReconciler.js:87\n_updateRenderedComponent @ ReactCompositeComponent.js:562\n_performComponentUpdate @ ReactCompositeComponent.js:544\nupdateComponent @ ReactCompositeComponent.js:473\nReactCompositeComponent_updateComponent @ ReactPerf.js:66\nreceiveComponent @ ReactCompositeComponent.js:405\nreceiveComponent @ ReactReconciler.js:87\n_updateRenderedComponent @ ReactCompositeComponent.js:562\n_performComponentUpdate @ ReactCompositeComponent.js:544\nupdateComponent @ ReactCompositeComponent.js:473\nReactCompositeComponent_updateComponent @ ReactPerf.js:66\nreceiveComponent @ ReactCompositeComponent.js:405\nreceiveComponent @ ReactReconciler.js:87\n_updateRenderedComponent @ ReactCompositeComponent.js:562\n_performComponentUpdate @ ReactCompositeComponent.js:544\nupdateComponent @ ReactCompositeComponent.js:473\nReactCompositeComponent_updateComponent @ ReactPerf.js:66\nperformUpdateIfNecessary @ ReactCompositeComponent.js:421\nperformUpdateIfNecessary @ ReactReconciler.js:102\nrunBatchedUpdates @ ReactUpdates.js:129\nperform @ Transaction.js:136\nperform @ Transaction.js:136\nperform @ ReactUpdates.js:86\nflushBatchedUpdates @ ReactUpdates.js:147\nReactUpdates_flushBatchedUpdates @ ReactPerf.js:66\ncloseAll @ Transaction.js:202\nperform @ Transaction.js:149\nbatchedUpdates @ ReactDefaultBatchingStrategy.js:62\nbatchedUpdates @ ReactUpdates.js:94\ndispatchEvent @ ReactEventListener.js:204\nwarning.js:45 Warning: Failed propType: Invalid prop `selected` of type `string` supplied to `Month`, expected `object`. Check the render method of `Calendar`.\nwarning @ warning.js:45\ncheckPropTypes @ ReactElementValidator.js:189\nvalidatePropTypes @ ReactElementValidator.js:208\ncreateElement @ ReactElementValidator.js:242\nCalendar._this.renderMonths @ index.js:2194\nrender @ index.js:2294\n_renderValidatedComponentWithoutOwnerOrContext @ ReactCompositeComponent.js:587\n_renderValidatedComponent @ ReactCompositeComponent.js:607\nReactCompositeComponent__renderValidatedComponent @ ReactPerf.js:66\nmountComponent @ ReactCompositeComponent.js:220\nReactCompositeComponent_mountComponent @ ReactPerf.js:66\nmountComponent @ ReactReconciler.js:37\nmountComponent @ ReactCompositeComponent.js:225\nReactCompositeComponent_mountComponent @ ReactPerf.js:66\nmountComponent @ ReactReconciler.js:37\nmountChildren @ ReactMultiChild.js:241\n_createContentMarkup @ ReactDOMComponent.js:591\nmountComponent @ ReactDOMComponent.js:479\nmountComponent @ ReactReconciler.js:37\nmountComponent @ ReactCompositeComponent.js:225\nReactCompositeComponent_mountComponent @ ReactPerf.js:66\nmountComponent @ ReactReconciler.js:37\n_mountChildByNameAtIndex @ ReactMultiChild.js:474\n_updateChildren @ ReactMultiChild.js:378\nupdateChildren @ ReactMultiChild.js:326\n_updateDOMChildren @ ReactDOMComponent.js:871\nupdateComponent @ ReactDOMComponent.js:700\nreceiveComponent @ ReactDOMComponent.js:645\nreceiveComponent @ ReactReconciler.js:87\n_updateRenderedComponent @ ReactCompositeComponent.js:562\n_performComponentUpdate @ ReactCompositeComponent.js:544\nupdateComponent @ ReactCompositeComponent.js:473\nReactCompositeComponent_updateComponent @ ReactPerf.js:66\nreceiveComponent @ ReactCompositeComponent.js:405\nreceiveComponent @ ReactReconciler.js:87\n_updateRenderedComponent @ ReactCompositeComponent.js:562\n_performComponentUpdate @ ReactCompositeComponent.js:544\nupdateComponent @ ReactCompositeComponent.js:473\nReactCompositeComponent_updateComponent @ ReactPerf.js:66\nreceiveComponent @ ReactCompositeComponent.js:405\nreceiveComponent @ ReactReconciler.js:87\n_updateRenderedComponent @ ReactCompositeComponent.js:562\n_performComponentUpdate @ ReactCompositeComponent.js:544\nupdateComponent @ ReactCompositeComponent.js:473\nReactCompositeComponent_updateComponent @ ReactPerf.js:66\nperformUpdateIfNecessary @ ReactCompositeComponent.js:421\nperformUpdateIfNecessary @ ReactReconciler.js:102\nrunBatchedUpdates @ ReactUpdates.js:129\nperform @ Transaction.js:136\nperform @ Transaction.js:136\nperform @ ReactUpdates.js:86\nflushBatchedUpdates @ ReactUpdates.js:147\nReactUpdates_flushBatchedUpdates @ ReactPerf.js:66\ncloseAll @ Transaction.js:202\nperform @ Transaction.js:149\nbatchedUpdates @ ReactDefaultBatchingStrategy.js:62\nbatchedUpdates @ ReactUpdates.js:94\ndispatchEvent @ ReactEventListener.js:204\nwarning.js:45 Warning: Failed propType: Invalid prop `selected` of type `string` supplied to `Week`, expected `object`. Check the', 0, 'open', '', '2018-04-27 04:40:24', '2018-04-27 02:40:24'),
(21, 2, 0, 'XCVXCBVMCVMXCVBMCVM', '300 stacy lane perth', '2018-04-23T14:00:00.000Z', 'XC ZC Bxc xc ', 0, 'open', '', '2018-04-27 06:02:41', '2018-04-27 04:02:41'),
(22, 0, 0, '', '', '', '', 0, 'open', '', '0000-00-00 00:00:00', '2018-04-27 04:18:50'),
(23, 0, 0, '', '', '', '', 0, 'open', '', '0000-00-00 00:00:00', '2018-04-27 04:23:13'),
(24, 0, 0, '', '', '', '', 0, 'open', '', '0000-00-00 00:00:00', '2018-04-27 04:23:14'),
(25, 0, 0, '', '', '', '', 0, 'open', '', '0000-00-00 00:00:00', '2018-04-27 04:24:57'),
(26, 2, 0, 'Establishing time line legal doc', '555 erick street bulimba', '2018-05-04T14:00:00.000Z', 'Needing to transfers date, time of work place incidents in a formal letter, of complaint.\nREQUIREMENTS\nThis task has certain requirements of the Tasker\nMust be able to put it into legal, phasing\nUse calendar exact time and date in document', 0, 'open', '', '2018-04-27 04:24:57', '2018-04-27 04:24:57'),
(27, 2, 0, 'Establishing time line legal doc', '300 stacy lane perth', '2018-04-12T14:00:00.000Z', 'EQUIREMENTS\nThis task has certain requirements of the Tasker\nMust be able to put it into legal, phasing\nUse calendar exact time and date in document', 0, 'open', '', '2018-04-27 04:26:10', '2018-04-27 04:26:10'),
(28, 2, 0, 'Establishing time line legal doc', '400 queen street', '2018-05-04T14:00:00.000Z', 'The hinge has popped out from this cupboard and I don’t know how to reconnect it - hoping to get some one to fix it', 0, 'open', '', '2018-04-27 04:27:52', '2018-04-27 04:27:52'),
(29, 2, 0, 'Qualified bookkeeping personal n', '555 erick street bulimba', '2018-05-04T14:00:00.000Z', 'The hinge has popped out from this cupboard and I don’t know how to reconnect it - hoping to get some one to fix it', 0, 'open', '', '2018-04-27T04:30:49.301Z', '2018-04-27 04:30:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `user_name` varchar(50) NOT NULL,
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

INSERT INTO `users` (`id`, `name`, `user_name`, `password`, `email`, `contact_number`, `address`, `date_of_birth`, `nationality`, `gender`, `date_of_joining`, `user_group_id`, `cast`, `religion`, `marital_status`, `nominee_name`, `father_name`, `mother_name`, `modified`, `created`) VALUES
(2, 'arden', 'fff', 'd23b499f09b7e2d5276b7a3f77bcb86519e0c48abd379dc37fe30148d7ecb054', 'kharddie@gmail.com ', 0, '', '0000-00-00', '', '', '0000-00-00', 0, '', '', '', '', '', '', '2018-04-17 10:17:31', '0000-00-00 00:00:00');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
