-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 20, 2016 at 08:37 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.5.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `patient_tracking`
--

-- --------------------------------------------------------

--
-- Table structure for table `alert_area`
--

CREATE TABLE `alert_area` (
  `id` int(10) UNSIGNED NOT NULL,
  `floor_id` int(10) UNSIGNED DEFAULT NULL,
  `quuppa_id` varchar(500) DEFAULT NULL COMMENT 'zone id of tag location',
  `description` varchar(500) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `button`
--

CREATE TABLE `button` (
  `id` int(10) UNSIGNED NOT NULL,
  `resident_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `button`
--

INSERT INTO `button` (`id`, `resident_id`, `created_at`) VALUES
(1, 30, '2016-09-19 03:13:37'),
(2, 31, '2016-09-19 03:21:01'),
(3, 32, '2016-09-19 03:02:31');

-- --------------------------------------------------------

--
-- Table structure for table `button_history`
--

CREATE TABLE `button_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `tagid` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `button_history`
--

INSERT INTO `button_history` (`id`, `tagid`, `created_at`) VALUES
(1, 'b4994c8bc62a', '2016-11-29 03:15:34'),
(2, 'b4994c8bc62a', '2016-11-29 03:20:10'),
(3, 'b4994c8bc62a', '2016-11-29 03:20:22'),
(4, 'b4994c8bc62a', '2016-11-29 03:20:34'),
(5, 'b4994c8bc62a', '2016-11-29 03:20:42'),
(6, 'b4994c8bc62a', '2016-11-29 03:20:48'),
(7, 'b4994c8bc62a', '2016-11-29 03:20:59'),
(8, 'b4994c8bc62a', '2016-11-29 03:24:26'),
(9, 'b4994c8bc62a', '2016-11-29 03:24:38'),
(10, 'b4994c8bc62a', '2016-11-29 03:25:39'),
(11, 'b4994c8bc62a', '2016-11-29 03:26:01'),
(12, 'b4994c8bc62a', '2016-11-29 03:30:28'),
(13, 'b4994c8bc62a', '2016-11-29 03:30:33'),
(14, 'b4994c8bc62a', '2016-11-29 03:30:33'),
(15, 'b4994c8bc62a', '2016-11-29 03:30:34'),
(16, 'b4994c8bc62a', '2016-11-29 03:32:37'),
(17, 'b4994c8bc62a', '2016-11-29 03:33:47'),
(18, 'b4994c8bc62a', '2016-11-29 03:34:53'),
(19, 'b4994c8bc62a', '2016-11-29 03:35:23'),
(20, 'b4994c8bc62a', '2016-11-29 03:35:30'),
(21, 'b4994c8bc62a', '2016-11-29 03:35:33'),
(22, 'b4994c8bc62a', '2016-11-29 03:36:09'),
(23, 'b4994c8bc62a', '2016-11-29 03:37:05'),
(24, 'b4994c8bc62a', '2016-11-29 03:38:14'),
(25, 'b4994c8bc62a', '2016-11-29 03:38:25'),
(26, 'b4994c8bc62a', '2016-11-29 03:39:29'),
(27, 'b4994c8bc62a', '2016-11-29 03:40:42'),
(28, 'b4994c8bc62a', '2016-11-29 03:43:32'),
(29, 'b4994c8bc62a', '2016-11-29 03:45:01'),
(30, 'b4994c8bc62a', '2016-11-29 03:45:07'),
(31, 'b4994c8bc62a', '2016-11-29 03:45:38'),
(32, 'b4994c8bc62a', '2016-11-29 03:46:29'),
(33, 'b4994c8bc62a', '2016-11-29 03:46:33'),
(34, 'b4994c8bc62a', '2016-11-29 03:48:29'),
(35, 'b4994c8bc62a', '2016-11-29 03:48:39'),
(36, 'b4994c8bc62a', '2016-11-29 03:49:09'),
(37, 'b4994c8bc62a', '2016-11-29 03:49:58'),
(38, 'b4994c8bc62a', '2016-11-29 03:56:46'),
(39, 'b4994c8bc62a', '2016-11-29 03:56:59'),
(40, 'b4994c8bc62a', '2016-11-29 03:57:40'),
(41, 'b4994c8bc62a', '2016-11-29 03:57:50'),
(42, 'b4994c8bc62a', '2016-11-29 03:58:20'),
(43, 'b4994c8bc62a', '2016-11-29 03:58:29'),
(44, 'b4994c8bc62a', '2016-11-29 03:58:36'),
(45, 'b4994c8bc62a', '2016-11-29 03:58:43'),
(46, 'b4994c8bc62a', '2016-11-29 03:59:31'),
(47, 'b4994c8bc62a', '2016-11-29 04:00:13'),
(48, 'b4994c8bc62a', '2016-11-29 04:01:37'),
(49, 'b4994c8bc62a', '2016-11-29 04:02:01'),
(50, 'b4994c8bc62a', '2016-11-29 05:43:09'),
(51, 'b4994c8bc62a', '2016-11-29 05:43:18'),
(52, 'b4994c8bc62a', '2016-11-29 05:44:12'),
(53, 'b4994c8bc62a', '2016-11-29 05:53:54'),
(54, 'b4994c8bc62a', '2016-11-29 05:54:48'),
(55, 'b4994c8bc62a', '2016-11-29 05:55:56'),
(56, 'b4994c8bc62a', '2016-11-29 05:56:02'),
(57, 'b4994c8bc62a', '2016-11-29 05:56:06'),
(58, 'b4994c8bc62a', '2016-11-29 05:57:55');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` char(2) NOT NULL,
  `name` char(52) NOT NULL,
  `population` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `userId` int(10) UNSIGNED DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fcmtoken`
--

CREATE TABLE `fcmtoken` (
  `id` int(10) UNSIGNED NOT NULL,
  `fcm_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fcmtoken`
--

INSERT INTO `fcmtoken` (`id`, `fcm_token`) VALUES
(1, 'd5Ys1wl4h_g:APA91bEMScnmc37cjqsm8vxcL2TUMNBOvfMf51PeV_le-lWKY8cKfBlRf7cKrM5iWJh9-CvR47emYcOfogQ-S7B1JeN0617ksD9OAdMZE2fLIn7gOtiv7mn3_1aQ812GgyC3Ma6IR6qm'),
(2, 'cf4lgOYGpEw:APA91bGajVGUsyWJjLhTpolgVBZAak9ZQcQ6AW1M0MREVCGADN3EWctrtPbrtFPzRUUfVMMAk8ayXR3s2vD8bf9YiMdTOyiBFg10-HxSiMyAEjWRsZam0IEbgAW6LsnDMgQ_8N5J3mjt'),
(3, 'dN-P4wxSgVk:APA91bGc2dLar-5pnVFBk1afXa7P13bH_mOR51IbZLoI6e8f1ysGo56-vZS4Txrc3RGI4kL07s0KTg19eAiyr7IMxZchGdWqg0mAVq-UXh5pSKYztG7WOLX6_JW0f1QVQ4TzbrZ2o00i'),
(8, 'fM2fiSFmqBg:APA91bFX0i1yp4vYlIeR-MYvPcOPsSUYdvGktXE8U8aAXR8kXWGaiVVrrrQvF8rfkjtbfF8EBToVu-Us8iDqvgOL9Mu_2xmrH-G4ZuOdxLLZJEWt36ymV2AL7uHUV0vu6YYo06CMhTUw');

-- --------------------------------------------------------

--
-- Table structure for table `floor`
--

CREATE TABLE `floor` (
  `id` int(10) UNSIGNED NOT NULL,
  `quuppa_id` varchar(20) DEFAULT NULL,
  `label` varchar(50) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `width` float NOT NULL,
  `height` float NOT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `floor`
--

INSERT INTO `floor` (`id`, `quuppa_id`, `label`, `description`, `width`, `height`, `created_at`, `updated_at`) VALUES
(7, 'Wards B1R', 'B5-1', 'Block B Level 1 Ward Right Wing', 20, 6, '0000-00-00 00:00:00', '2016-09-19 01:21:56'),
(8, 'Wards B2', 'B5-2', 'Block B Level 2 Ward', 10, 10, '0000-00-00 00:00:00', '2016-09-18 11:05:52');

-- --------------------------------------------------------

--
-- Table structure for table `floor_manager`
--

CREATE TABLE `floor_manager` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL,
  `floorid` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `floor_map`
--

CREATE TABLE `floor_map` (
  `id` int(10) UNSIGNED NOT NULL,
  `floor_id` int(10) UNSIGNED NOT NULL,
  `file_type` varchar(10) DEFAULT NULL,
  `file_name` varchar(30) DEFAULT NULL,
  `file_ext` varchar(10) DEFAULT NULL,
  `file_path` varchar(100) DEFAULT NULL,
  `thumbnail_path` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `floor_map`
--

INSERT INTO `floor_map` (`id`, `floor_id`, `file_type`, `file_name`, `file_ext`, `file_path`, `thumbnail_path`, `created_at`, `updated_at`) VALUES
(9, 7, 'image/png', '7', 'png', 'uploads/maps/7.png', 'uploads/maps/thumbnail_7.png', '2016-10-17 01:35:22', '2016-10-17 02:05:07');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(10) UNSIGNED NOT NULL,
  `resident_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `floor_id` int(10) UNSIGNED DEFAULT NULL,
  `coorx` float NOT NULL,
  `coory` float NOT NULL,
  `zone` varchar(50) DEFAULT NULL,
  `outside` int(1) DEFAULT '0' COMMENT '	0 = inside, 1 = outside	',
  `azimuth` float UNSIGNED DEFAULT NULL COMMENT '[0-360) degree',
  `speed` float UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `resident_id`, `user_id`, `floor_id`, `coorx`, `coory`, `zone`, `outside`, `azimuth`, `speed`, `created_at`) VALUES
(1, 30, NULL, 7, 5, 4, 'Wards B1R', 0, 0, 0, '2016-11-01 02:27:42'),
(2, NULL, 5, 7, 1, 6, 'Wards B1R', 0, 0, 0, '2016-11-01 02:27:42'),
(3, 32, NULL, 7, 5, 1, 'Wards B1R', 0, 0, 0, '2016-11-01 02:27:42'),
(4, 31, NULL, 7, 2, 1, 'Wards B1R', 0, 0, 0, '2016-11-01 02:27:42');

-- --------------------------------------------------------

--
-- Table structure for table `location_history`
--

CREATE TABLE `location_history` (
  `id` int(15) UNSIGNED NOT NULL,
  `tagid` varchar(20) DEFAULT NULL,
  `coorx` float NOT NULL DEFAULT '0',
  `coory` float NOT NULL DEFAULT '0',
  `zone` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `marker`
--

CREATE TABLE `marker` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(50) DEFAULT NULL,
  `mac` varchar(20) DEFAULT NULL,
  `floor_id` int(10) UNSIGNED DEFAULT NULL,
  `position` smallint(5) UNSIGNED NOT NULL,
  `pixelx` int(11) NOT NULL,
  `pixely` int(11) NOT NULL,
  `coorx` float NOT NULL,
  `coory` float NOT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `marker`
--

INSERT INTO `marker` (`id`, `label`, `mac`, `floor_id`, `position`, `pixelx`, `pixely`, `coorx`, `coory`, `created_at`, `updated_at`) VALUES
(8, '', NULL, 7, 1, 50, 542, 0, 0, '2016-10-17 02:06:13', '2016-10-17 02:06:13'),
(9, '', NULL, 7, 2, 1022, 540, 9, 0, '2016-10-17 02:06:25', '2016-10-17 02:06:25'),
(10, '', NULL, 7, 3, 1014, 63, 9, 9, '2016-10-17 02:06:31', '2016-10-17 02:06:31'),
(11, '', NULL, 7, 4, 54, 63, 0, 9, '2016-10-17 02:06:43', '2016-10-17 02:06:43');

-- --------------------------------------------------------

--
-- Table structure for table `nextofkin`
--

CREATE TABLE `nextofkin` (
  `id` int(10) UNSIGNED NOT NULL,
  `nric` varchar(20) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `remark` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nextofkin`
--

INSERT INTO `nextofkin` (`id`, `nric`, `first_name`, `last_name`, `contact`, `email`, `remark`, `created_at`, `updated_at`) VALUES
(8, 'SG0001', 'Priscilla', 'Liew', '95612345', 'priscilla_liew@gmail.com', '', '2016-09-15 01:58:08', '2016-09-19 01:26:10'),
(9, 'SG0002', 'Donald', 'Chew', '81542935', 'donald_chew@gmail.com', '', '2016-09-15 01:59:38', '2016-09-19 01:26:19'),
(10, 'SG0003', 'Melinda', 'Heng', '96722341', 'melinda_heng@gmail.com', '', '2016-09-15 02:00:07', '2016-09-19 01:26:30'),
(11, 'SG0004', 'Tung', 'Phung', '', '', '', '2016-09-23 07:27:25', '2016-09-23 07:27:25');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(10) UNSIGNED NOT NULL,
  `resident_id` int(10) UNSIGNED NOT NULL,
  `last_position` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '1: Went to alert area; 2: Pressed the button; 3: Out of tracking area'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `resident_id`, `last_position`, `created_at`, `updated_at`, `user_id`, `type`) VALUES
(1, 30, 7, '2016-11-29 03:33:47', '2016-11-29 03:33:47', NULL, 2),
(2, 30, 7, '2016-11-29 03:34:53', '2016-11-29 03:34:53', NULL, 2),
(3, 30, 7, '2016-11-29 03:35:23', '2016-11-29 03:35:23', NULL, 2),
(4, 30, 7, '2016-11-29 03:35:30', '2016-11-29 03:35:30', NULL, 2),
(5, 30, 7, '2016-11-29 03:35:33', '2016-11-29 03:35:33', NULL, 2),
(6, 30, 7, '2016-11-29 03:36:09', '2016-11-29 03:36:09', NULL, 2),
(7, 30, 7, '2016-11-29 03:37:05', '2016-11-29 03:37:05', NULL, 2),
(8, 30, 7, '2016-11-29 03:38:14', '2016-11-29 03:38:14', NULL, 2),
(9, 30, 7, '2016-11-29 03:38:25', '2016-11-29 03:38:25', NULL, 2),
(10, 30, 7, '2016-11-29 03:39:29', '2016-11-29 03:39:29', NULL, 2),
(11, 30, 7, '2016-11-29 03:40:42', '2016-11-29 03:40:42', NULL, 2),
(12, 30, 7, '2016-11-29 03:43:32', '2016-11-29 03:43:32', NULL, 2),
(13, 30, 7, '2016-11-29 03:45:01', '2016-11-29 03:45:01', NULL, 2),
(14, 30, 7, '2016-11-29 03:45:07', '2016-11-29 03:45:07', NULL, 2),
(15, 30, 7, '2016-11-29 03:45:38', '2016-11-29 03:45:38', NULL, 2),
(16, 30, 7, '2016-11-29 03:46:29', '2016-11-29 03:46:29', NULL, 2),
(17, 30, 7, '2016-11-29 03:46:33', '2016-11-29 03:46:33', NULL, 2),
(18, 30, 7, '2016-11-29 03:48:39', '2016-11-29 03:48:39', NULL, 2),
(19, 30, 7, '2016-11-29 03:49:09', '2016-11-29 03:49:09', NULL, 2),
(20, 30, 7, '2016-11-29 03:49:58', '2016-11-29 03:49:58', NULL, 2),
(21, 30, 7, '2016-11-29 03:56:46', '2016-11-29 03:56:46', NULL, 2),
(22, 30, 7, '2016-11-29 03:56:59', '2016-11-29 03:56:59', NULL, 2),
(23, 30, 7, '2016-11-29 03:57:40', '2016-11-29 03:57:40', NULL, 2),
(24, 30, 7, '2016-11-29 03:57:50', '2016-11-29 03:57:50', NULL, 2),
(25, 30, 7, '2016-11-29 03:58:20', '2016-11-29 03:58:20', NULL, 2),
(26, 30, 7, '2016-11-29 03:58:29', '2016-11-29 03:58:29', NULL, 2),
(27, 30, 7, '2016-11-29 03:58:36', '2016-11-29 03:58:36', NULL, 2),
(28, 30, 7, '2016-11-29 03:58:43', '2016-11-29 03:58:43', NULL, 2),
(29, 30, 7, '2016-11-29 03:59:31', '2016-11-29 03:59:31', NULL, 2),
(30, 30, 7, '2016-11-29 04:00:13', '2016-11-29 04:00:13', NULL, 2),
(31, 30, 7, '2016-11-29 04:01:37', '2016-11-29 04:01:37', NULL, 2),
(32, 30, 7, '2016-11-29 04:02:01', '2016-11-29 04:02:01', NULL, 2),
(33, 30, 7, '2016-11-29 05:43:09', '2016-11-29 05:43:09', NULL, 2),
(34, 30, 7, '2016-11-29 05:43:18', '2016-11-29 05:43:18', NULL, 2),
(35, 30, 7, '2016-11-29 05:44:12', '2016-11-29 05:44:12', NULL, 2),
(36, 30, 7, '2016-11-29 05:53:54', '2016-11-29 05:53:54', NULL, 2),
(37, 30, 7, '2016-11-29 05:54:48', '2016-11-29 05:54:48', NULL, 2),
(38, 30, 7, '2016-11-29 05:55:56', '2016-11-29 05:55:56', NULL, 2),
(39, 30, 7, '2016-11-29 05:56:02', '2016-11-29 05:56:02', NULL, 2),
(40, 30, 7, '2016-11-29 05:56:06', '2016-11-29 05:56:06', NULL, 2),
(41, 30, 7, '2016-11-29 05:57:55', '2016-11-29 05:57:55', NULL, 2),
(43, 30, 7, '2016-12-19 06:36:14', '2016-12-19 06:36:14', NULL, 1),
(44, 30, 7, '2016-12-19 06:36:16', '2016-12-19 06:36:16', NULL, 1),
(45, 30, 7, '2016-12-19 06:36:54', '2016-12-19 06:36:54', NULL, 1),
(46, 30, 7, '2016-12-19 06:36:59', '2016-12-19 06:36:59', NULL, 1),
(47, 30, 7, '2016-12-19 06:37:00', '2016-12-19 06:37:00', NULL, 1),
(48, 30, 7, '2016-12-19 06:37:02', '2016-12-19 06:37:02', NULL, 1),
(49, 30, 7, '2016-12-19 06:37:11', '2016-12-19 06:37:11', NULL, 1),
(50, 30, 7, '2016-12-19 06:37:24', '2016-12-19 06:37:24', NULL, 1),
(51, 30, 7, '2016-12-19 06:38:24', '2016-12-19 06:38:24', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `resident`
--

CREATE TABLE `resident` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `nric` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL DEFAULT 'male' COMMENT 'male, female',
  `birthday` date DEFAULT '0000-00-00',
  `contact` varchar(20) DEFAULT NULL,
  `remark` varchar(500) DEFAULT NULL,
  `file_path` varchar(100) DEFAULT NULL,
  `thumbnail_path` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resident`
--

INSERT INTO `resident` (`id`, `firstname`, `lastname`, `nric`, `gender`, `birthday`, `contact`, `remark`, `file_path`, `thumbnail_path`, `updated_at`, `created_at`) VALUES
(30, 'Tim', 'Chew', 'SG1234', 'Male', '1940-06-11', '', 'Early stage Dementia; allergic to Panadol.', 'uploads/human_images/Tim_Chew.png', 'uploads/human_images/thumbnail_Tim_Chew.png', '2016-10-17 01:59:43', '2016-09-14 04:47:21'),
(31, 'Mark', 'Liew', 'SG1235', 'Male', '1940-06-11', '', 'History of epileptic seizure. ', 'uploads/human_images/Mark_Liew.png', 'uploads/human_images/thumbnail_Mark_Liew.png', '2016-10-17 01:59:48', '2016-09-14 04:47:45'),
(32, 'Bill', 'Heng', 'SG1236', 'Male', '1940-06-11', '', 'Moderate insomnia', 'uploads/human_images/Bill_Heng.png', 'uploads/human_images/thumbnail_Bill_Heng.png', '2016-10-17 01:59:52', '2016-09-14 04:48:05');

-- --------------------------------------------------------

--
-- Table structure for table `resident_relative`
--

CREATE TABLE `resident_relative` (
  `id` int(10) UNSIGNED NOT NULL,
  `resident_id` int(10) UNSIGNED NOT NULL,
  `nextofkin_id` int(10) UNSIGNED NOT NULL,
  `relation` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resident_relative`
--

INSERT INTO `resident_relative` (`id`, `resident_id`, `nextofkin_id`, `relation`, `created_at`, `updated_at`) VALUES
(1, 32, 10, 'Wife', '2016-09-15 02:00:22', '2016-09-15 02:00:22'),
(2, 31, 8, 'Wife', '2016-09-15 02:00:32', '2016-09-15 02:00:32'),
(3, 30, 9, 'Daughter', '2016-09-15 02:00:42', '2016-09-18 10:42:38'),
(4, 32, 11, '2nd Wife', '2016-09-23 07:27:40', '2016-09-23 07:27:40');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(20) NOT NULL,
  `tagid` varchar(20) DEFAULT NULL,
  `status` int(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1 = active, 0 = inactive',
  `resident_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `label`, `tagid`, `status`, `resident_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Patient_1133', 'b4994c8bc62a', 1, 30, NULL, '2016-09-14 04:48:55', '2016-09-14 04:49:27'),
(2, 'Patient_1252', 'b4994c8bc93e', 1, 31, NULL, '2016-09-14 04:50:10', '2016-09-14 04:50:10'),
(3, 'Patient_1267', 'b4994c8ba064', 1, 32, NULL, '2016-09-14 04:50:30', '2016-09-14 04:50:30'),
(4, 'Nurse_0983', 'b4994c8778d0', 1, NULL, 5, '2016-09-14 04:50:54', '2016-09-14 04:51:11');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) DEFAULT '',
  `password_hash` varchar(255) DEFAULT '',
  `access_token` varchar(32) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT '',
  `email_confirm_token` varchar(255) DEFAULT NULL,
  `role` int(10) UNSIGNED DEFAULT '10',
  `status` smallint(6) DEFAULT '10',
  `allowance` int(10) UNSIGNED DEFAULT NULL,
  `timestamp` int(10) UNSIGNED DEFAULT NULL,
  `file_path` varchar(100) DEFAULT NULL,
  `thumbnail_path` varchar(100) DEFAULT NULL,
  `created_at` int(10) UNSIGNED DEFAULT NULL,
  `updated_at` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `access_token`, `password_reset_token`, `email`, `email_confirm_token`, `role`, `status`, `allowance`, `timestamp`, `file_path`, `thumbnail_path`, `created_at`, `updated_at`) VALUES
(1, 'master', 'auth-key-test-admin', '$2y$10$vsK92gjucpYK7MP.6w9Pk.N01/uH.EPaHHwnVYEAcSCjNruZ/YTPK', 'abcd1234', '', 'zqi2@np.edu.sg', '', 40, 10, NULL, NULL, NULL, NULL, 0, 0),
(2, 'admin', 'auth-key-test-admin', '$2y$10$vsK92gjucpYK7MP.6w9Pk.N01/uH.EPaHHwnVYEAcSCjNruZ/YTPK', 'abcd1234', NULL, 'zqi2@np.edu.sg', NULL, 30, 10, 298, 1457497221, 'uploads/human_images/admin.png', 'uploads/human_images/thumbnail_admin.png', 0, 0),
(3, 'manager1', 'auth-key-test-admin', '$2y$10$vsK92gjucpYK7MP.6w9Pk.N01/uH.EPaHHwnVYEAcSCjNruZ/YTPK', 'abcd1234', NULL, 'zqi2@np.edu.sg', NULL, 20, 10, 299, 1457498221, NULL, NULL, 0, 0),
(4, 'manager2', 'auth-key-test-admin', '$2y$10$vsK92gjucpYK7MP.6w9Pk.N01/uH.EPaHHwnVYEAcSCjNruZ/YTPK', 'abcd1234', NULL, 'zqi2@np.edu.sg', NULL, 20, 10, 299, 1432481401, NULL, NULL, 0, 0),
(5, 'nurse1', 'auth-key-test-admin', '$2y$13$ciC0m7m2MEhq4jY/dfu36uFYttQbYxxOnwghDe.UPstXh1zfYvCMK', 'abcd1234', NULL, 'zqi2@np.edu.sg', NULL, 10, 10, 297, 1457685422, 'uploads/human_images/nurse1.png', 'uploads/human_images/thumbnail_nurse1.png', 0, 0),
(6, 'nurse2', 'auth-key-test-admin', '$2y$10$vsK92gjucpYK7MP.6w9Pk.N01/uH.EPaHHwnVYEAcSCjNruZ/YTPK', 'abcd1234', NULL, 'zqi2@np.edu.sg', NULL, 10, 10, 299, 1432560400, NULL, NULL, 0, 0),
(8, 'nurse3', 'auth-key-test-admin', '$2y$10$vsK92gjucpYK7MP.6w9Pk.N01/uH.EPaHHwnVYEAcSCjNruZ/YTPK', 'abcd1234', NULL, 'zqi2@np.edu.sg', NULL, 10, 10, 299, 1434507798, NULL, NULL, 0, 0),
(66, 'username', 'toL0dfZhirB7jQgZ70ljCnGaD31HoqiJ', '$2y$13$yI/cSfY.E6opPfJEP9TfaOHS9Hnu7L6ANYGZ3YSxzxqs0DFDQ1N2.', NULL, NULL, 'zkendytq@gmail.com', NULL, 40, 10, NULL, NULL, NULL, NULL, 4294967295, 4294967295),
(67, 'staff', 'SIb5mc_jmD3DkvxwaX_5sl86-D0C0PIv', '$2y$13$Eb6zXmM.Usf0/11P68b2MutwmXU/3EtdXTbYNJQaaImUD54.q.6Mq', NULL, NULL, 'congaductq2@gmail.com', NULL, 10, 10, NULL, NULL, NULL, NULL, 4294967295, 4294967295);

-- --------------------------------------------------------

--
-- Table structure for table `usertoken`
--

CREATE TABLE `usertoken` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(32) NOT NULL DEFAULT '',
  `label` varchar(10) DEFAULT NULL,
  `mac_address` varchar(255) DEFAULT NULL,
  `expire` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usertoken`
--

INSERT INTO `usertoken` (`id`, `user_id`, `token`, `label`, `mac_address`, `expire`, `created_at`) VALUES
(1, 2, 'dd3f5eee9f65b9818fd062c311086831', NULL, 'f8:32:e4:5f:73:f5', '2016-08-28 08:31:00', '2016-05-06 02:45:47'),
(2, 67, '2648e4e102d9a134cb9992314186178b', NULL, 'f8:32:e4:5f:73:f5', '2016-09-25 02:46:23', '2016-07-28 08:16:17'),
(3, 2, '1e45e58e3643e26f990ab3c4e28fa983', NULL, 'f8:32:e4:5f:6f:35', '2016-09-22 06:07:26', '2016-08-22 06:07:26'),
(11, 6, 'b4e0123ba0c22d8ccc17c7b28155c9aa', NULL, 'E0:DB:10:6E:E7:19', '2016-10-16 08:13:47', '2016-09-16 08:13:47'),
(61, 5, 'J-S5b29s4jqeLr-XNuiQQop3qLJ96DVk', 'ACCESS', '::1', '2016-11-18 09:11:53', '2016-10-19 09:11:53'),
(62, 5, '5be1ff67e8fc27d2a59ebc5a2fd62771', NULL, 'ABCD', '2016-11-19 09:12:04', '2016-10-19 09:12:04'),
(63, 5, 'bba8d93b16162a9e60d4c74b48d9c928', NULL, '40:0E:85:64:61:DA', '2016-12-09 06:07:54', '2016-10-24 02:07:24'),
(64, 5, '014784bfb68fee42e231ae73a794a69c', NULL, 'E0:DB:10:6E:E7:19', '2016-11-24 02:35:39', '2016-10-24 02:35:39'),
(65, 5, 'a734c380e981efc4be557ddabf559a6a', NULL, 'f8:32:e4:5f:77:4f', '2016-12-09 06:11:03', '2016-11-09 06:11:03'),
(66, 5, 'be242911ba27e04432b27af1464594ce', NULL, 'f8:32:e4:5f:73:f5', '2017-12-15 01:48:07', '2016-11-15 01:48:07'),
(67, 5, '1aae257778ff9c2d1e20daa8246b64e4', NULL, 'fM2fiSFmqBg:APA91bFX0i1yp4vYlIeR-MYvPcOPsSUYdvGktXE8U8aAXR8kXWGaiVVrrrQvF8rfkjtbfF8EBToVu-Us8iDqvgOL9Mu_2xmrH-G4ZuOdxLLZJEWt36ymV2AL7uHUV0vu6YYo06CMhTUw', '2017-01-20 06:28:23', '2016-12-20 06:28:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alert_area`
--
ALTER TABLE `alert_area`
  ADD PRIMARY KEY (`id`),
  ADD KEY `floor_id` (`floor_id`);

--
-- Indexes for table `button`
--
ALTER TABLE `button`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tagid` (`resident_id`);

--
-- Indexes for table `button_history`
--
ALTER TABLE `button_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `fcmtoken`
--
ALTER TABLE `fcmtoken`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `floor`
--
ALTER TABLE `floor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `label` (`label`),
  ADD UNIQUE KEY `quuppa_id` (`quuppa_id`);

--
-- Indexes for table `floor_manager`
--
ALTER TABLE `floor_manager`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `floorid` (`floorid`);

--
-- Indexes for table `floor_map`
--
ALTER TABLE `floor_map`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `floor_id` (`floor_id`),
  ADD KEY `floorid` (`floor_id`),
  ADD KEY `floorid_2` (`floor_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `humanid` (`resident_id`),
  ADD KEY `floorid` (`floor_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `location_history`
--
ALTER TABLE `location_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marker`
--
ALTER TABLE `marker`
  ADD PRIMARY KEY (`id`),
  ADD KEY `floorid` (`floor_id`);

--
-- Indexes for table `nextofkin`
--
ALTER TABLE `nextofkin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nric` (`nric`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `humanid` (`resident_id`),
  ADD KEY `notification_userid` (`user_id`),
  ADD KEY `last_position` (`last_position`);

--
-- Indexes for table `resident`
--
ALTER TABLE `resident`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resident_relative`
--
ALTER TABLE `resident_relative`
  ADD PRIMARY KEY (`id`),
  ADD KEY `humanid` (`resident_id`,`nextofkin_id`),
  ADD KEY `nextokinid` (`nextofkin_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `label` (`label`),
  ADD UNIQUE KEY `tagid` (`tagid`),
  ADD UNIQUE KEY `resident_id` (`resident_id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`),
  ADD KEY `humanid` (`resident_id`),
  ADD KEY `mac` (`tagid`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usertoken`
--
ALTER TABLE `usertoken`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `userId` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alert_area`
--
ALTER TABLE `alert_area`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `button`
--
ALTER TABLE `button`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `button_history`
--
ALTER TABLE `button_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fcmtoken`
--
ALTER TABLE `fcmtoken`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `floor`
--
ALTER TABLE `floor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `floor_manager`
--
ALTER TABLE `floor_manager`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `floor_map`
--
ALTER TABLE `floor_map`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `location_history`
--
ALTER TABLE `location_history`
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `marker`
--
ALTER TABLE `marker`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `nextofkin`
--
ALTER TABLE `nextofkin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `resident`
--
ALTER TABLE `resident`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `resident_relative`
--
ALTER TABLE `resident_relative`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `usertoken`
--
ALTER TABLE `usertoken`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `alert_area`
--
ALTER TABLE `alert_area`
  ADD CONSTRAINT `alertarea_floorid` FOREIGN KEY (`floor_id`) REFERENCES `floor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `button`
--
ALTER TABLE `button`
  ADD CONSTRAINT `button_residentid` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `floor_manager`
--
ALTER TABLE `floor_manager`
  ADD CONSTRAINT `floormanager_floorid` FOREIGN KEY (`floorid`) REFERENCES `floor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `floormanager_userid` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `floor_map`
--
ALTER TABLE `floor_map`
  ADD CONSTRAINT `floormap_floorid` FOREIGN KEY (`floor_id`) REFERENCES `floor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `location_floorid` FOREIGN KEY (`floor_id`) REFERENCES `floor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `location_residentid` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `location_userid` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `marker`
--
ALTER TABLE `marker`
  ADD CONSTRAINT `marker_floorid` FOREIGN KEY (`floor_id`) REFERENCES `floor` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_floorid` FOREIGN KEY (`last_position`) REFERENCES `floor` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_residentid` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_userid` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `resident_relative`
--
ALTER TABLE `resident_relative`
  ADD CONSTRAINT `residentrelative_nextofkinid` FOREIGN KEY (`nextofkin_id`) REFERENCES `nextofkin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `residentrelative_residentid` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tag`
--
ALTER TABLE `tag`
  ADD CONSTRAINT `tag_residentid` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_userid` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usertoken`
--
ALTER TABLE `usertoken`
  ADD CONSTRAINT `usertoken_userid` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
