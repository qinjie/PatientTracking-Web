-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2016 at 09:37 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parking_lots`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '2', 1459664390),
('manager', '3', 1459664390),
('manager', '4', 1459664390),
('master', '1', 1459664390),
('user', '5', 1459664390),
('user', '6', 1459664390),
('user', '7', 1459664390),
('user', '8', 1459664390);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, NULL, NULL, NULL, 1459664390, 1459664390),
('demo/test-post/create', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('demo/test-post/delete', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('demo/test-post/delete_own', 2, 'demo/test-post/update_own', 'isCreator', NULL, 1459664390, 1459664390),
('demo/test-post/index', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('demo/test-post/update', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('demo/test-post/update_own', 2, 'demo/test-post/update_own', 'isCreator', NULL, 1459664390, 1459664390),
('demo/test-post/view', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('manager', 1, NULL, NULL, NULL, 1459664390, 1459664390),
('master', 1, NULL, NULL, NULL, 1459664390, 1459664390),
('user', 1, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/car-park/create', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/car-park/delete', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/car-park/delete_own', 2, 'v1/car-park/update_own', 'isCreator', NULL, 1459664390, 1459664390),
('v1/car-park/index', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/car-park/search', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/car-park/update', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/car-park/update_own', 2, 'v1/car-park/update_own', 'isCreator', NULL, 1459664390, 1459664390),
('v1/car-park/view', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/sensor-gantry/create', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/sensor-gantry/create_own', 2, 'v1/sensor-gantry/create_own', 'isCarParkOwner', NULL, 1459664390, 1459664390),
('v1/sensor-gantry/delete', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/sensor-gantry/delete_own', 2, 'v1/sensor-gantry/update_own', 'isCarParkOwner', NULL, 1459664390, 1459664390),
('v1/sensor-gantry/index', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/sensor-gantry/search', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/sensor-gantry/update', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/sensor-gantry/update_own', 2, 'v1/sensor-gantry/update_own', 'isCarParkOwner', NULL, 1459664390, 1459664390),
('v1/sensor-gantry/view', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/traffic-flow/car-entry', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/traffic-flow/car-exit', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/traffic-flow/create', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/traffic-flow/delete', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/traffic-flow/index', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/traffic-flow/latest-all-car-park', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/traffic-flow/latest-all-car-park-today', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/traffic-flow/latest-by-car-park', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/traffic-flow/list-older-than-hours', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/traffic-flow/search', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/traffic-flow/update', 2, NULL, NULL, NULL, 1459664390, 1459664390),
('v1/traffic-flow/view', 2, NULL, NULL, NULL, 1459664390, 1459664390);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'manager'),
('admin', 'v1/traffic-flow/create'),
('admin', 'v1/traffic-flow/delete'),
('admin', 'v1/traffic-flow/update'),
('demo/test-post/delete_own', 'demo/test-post/delete'),
('demo/test-post/update_own', 'demo/test-post/update'),
('manager', 'demo/test-post/delete'),
('manager', 'demo/test-post/update'),
('manager', 'user'),
('manager', 'v1/car-park/create'),
('manager', 'v1/car-park/delete'),
('manager', 'v1/car-park/update'),
('manager', 'v1/sensor-gantry/create'),
('manager', 'v1/sensor-gantry/delete'),
('manager', 'v1/sensor-gantry/update'),
('manager', 'v1/traffic-flow/car-entry'),
('manager', 'v1/traffic-flow/car-exit'),
('master', 'admin'),
('user', 'demo/test-post/create'),
('user', 'demo/test-post/delete_own'),
('user', 'demo/test-post/index'),
('user', 'demo/test-post/update_own'),
('user', 'demo/test-post/view'),
('user', 'v1/car-park/delete_own'),
('user', 'v1/car-park/index'),
('user', 'v1/car-park/search'),
('user', 'v1/car-park/update_own'),
('user', 'v1/car-park/view'),
('user', 'v1/sensor-gantry/create_own'),
('user', 'v1/sensor-gantry/delete_own'),
('user', 'v1/sensor-gantry/index'),
('user', 'v1/sensor-gantry/search'),
('user', 'v1/sensor-gantry/update_own'),
('user', 'v1/sensor-gantry/view'),
('user', 'v1/traffic-flow/index'),
('user', 'v1/traffic-flow/latest-all-car-park'),
('user', 'v1/traffic-flow/latest-all-car-park-today'),
('user', 'v1/traffic-flow/latest-by-car-park'),
('user', 'v1/traffic-flow/list-older-than-hours'),
('user', 'v1/traffic-flow/search'),
('user', 'v1/traffic-flow/view'),
('v1/car-park/delete_own', 'v1/car-park/delete'),
('v1/car-park/update_own', 'v1/car-park/update'),
('v1/sensor-gantry/create_own', 'v1/sensor-gantry/create'),
('v1/sensor-gantry/delete_own', 'v1/sensor-gantry/delete'),
('v1/sensor-gantry/update_own', 'v1/sensor-gantry/update');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('isCarParkOwner', 'O:35:"common\\models\\auth\\CarParkOwnerRule":3:{s:4:"name";s:14:"isCarParkOwner";s:9:"createdAt";i:1459664390;s:9:"updatedAt";i:1459664390;}', 1459664390, 1459664390),
('isCreator', 'O:30:"common\\models\\auth\\CreatorRule":3:{s:4:"name";s:9:"isCreator";s:9:"createdAt";i:1459664390;s:9:"updatedAt";i:1459664390;}', 1459664390, 1459664390);

-- --------------------------------------------------------

--
-- Table structure for table `car_park`
--

CREATE TABLE `car_park` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(50) NOT NULL DEFAULT '',
  `lot_capacity` int(5) UNSIGNED NOT NULL,
  `car_count` int(5) UNSIGNED NOT NULL,
  `serial` varchar(32) DEFAULT '' COMMENT 'unique identifier of node',
  `status` int(2) UNSIGNED NOT NULL DEFAULT '1',
  `remark` varchar(100) DEFAULT '',
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `car_park`
--

INSERT INTO `car_park` (`id`, `label`, `lot_capacity`, `car_count`, `serial`, `status`, `remark`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Sports Complex', 40, 4, '', 1, '', 3, NULL, '2016-04-03 04:59:34'),
(2, 'ME Div', 30, 0, '', 1, '', 3, NULL, '2016-04-03 04:59:36'),
(3, 'BLK 40', 20, 0, '', 1, '', 4, NULL, '2016-04-03 04:57:23'),
(4, 'BLK 53', 30, 0, '', 1, '', 4, NULL, '2016-04-03 04:57:23'),
(5, 'School of BA', 25, 0, '', 1, '', 4, NULL, '2016-04-03 04:57:24'),
(6, 'Convention Hall', 10, 0, '', 1, '', 3, NULL, '2016-04-03 04:57:25'),
(9, 'Test', 99, 0, '', 1, '', 3, '2016-02-11 06:39:53', '2016-04-03 04:57:25');

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(20) NOT NULL DEFAULT '' COMMENT 'data type',
  `file_name` varchar(50) DEFAULT NULL,
  `file_type` varchar(10) DEFAULT NULL,
  `file_size` int(10) UNSIGNED DEFAULT NULL,
  `car_park_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1453623137),
('m140506_102106_rbac_init', 1453623347);

-- --------------------------------------------------------

--
-- Table structure for table `sensor_gantry`
--

CREATE TABLE `sensor_gantry` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(20) NOT NULL,
  `serial` varchar(20) NOT NULL,
  `exit_count` int(10) UNSIGNED DEFAULT '0',
  `entry_count` int(10) UNSIGNED DEFAULT '0',
  `car_park_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sensor_gantry`
--

INSERT INTO `sensor_gantry` (`id`, `label`, `serial`, `exit_count`, `entry_count`, `car_park_id`, `created_at`, `updated_at`) VALUES
(1, 'SP A', '6792b9e854279c65e722', 0, 2, 1, '0000-00-00 00:00:00', '2016-04-03 04:59:33'),
(2, 'SP B', 'd1bbd4ae664369f83a1a', 0, 2, 1, '0000-00-00 00:00:00', '2016-04-03 04:59:33'),
(3, 'ME A', '193a928500e65443a176', 2, 2, 2, '0000-00-00 00:00:00', '2016-04-03 04:59:35'),
(4, 'ME B', '22cd9ee4006e4fd873d6', 2, 2, 2, '0000-00-00 00:00:00', '2016-04-03 04:59:36'),
(6, 'BLK40 A', '4d6cb9c3aebbbe8efb5b', 0, 0, 3, '0000-00-00 00:00:00', '2016-04-03 04:57:47'),
(7, 'BLK53 A', 'c02e9e8bc99b6ff7022e', 0, 0, 4, '0000-00-00 00:00:00', '2016-04-03 04:57:48'),
(8, 'BLK53 B', 'f355e9e547d135456cc5', 0, 0, 4, '0000-00-00 00:00:00', '2016-04-03 04:57:49'),
(9, 'BA A', '2bdf1c1dc115905bbfcb', 0, 0, 5, '0000-00-00 00:00:00', '2016-04-03 04:57:49'),
(10, 'BA B', 'ad20666b6f4cfac8a5a6', 0, 0, 5, '0000-00-00 00:00:00', '2016-04-03 04:57:50'),
(11, 'CC A', '07e203c765f6cdf3286e', 0, 0, 6, '0000-00-00 00:00:00', '2016-04-03 04:57:51'),
(19, 'SP EEE', 'DR9H8FeoB-YvRe6egxAa', 0, 0, 1, '2016-02-11 06:35:19', '2016-04-03 04:57:51');

-- --------------------------------------------------------

--
-- Table structure for table `traffic_flow`
--

CREATE TABLE `traffic_flow` (
  `id` int(10) UNSIGNED NOT NULL,
  `sensor_gantry_id` int(10) UNSIGNED NOT NULL,
  `direction` int(2) UNSIGNED NOT NULL COMMENT '0 OUT, 1 IN',
  `entry_count` int(10) UNSIGNED NOT NULL,
  `exit_count` int(10) UNSIGNED NOT NULL,
  `car_park_id` int(10) UNSIGNED NOT NULL,
  `car_count` int(10) UNSIGNED DEFAULT NULL,
  `empty_lot` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `traffic_flow`
--

INSERT INTO `traffic_flow` (`id`, `sensor_gantry_id`, `direction`, `entry_count`, `exit_count`, `car_park_id`, `car_count`, `empty_lot`, `created_at`, `updated_at`) VALUES
(64, 3, 1, 1, 0, 2, 1, 29, '2016-04-03 04:45:04', '2016-04-03 04:45:04'),
(65, 4, 1, 1, 0, 2, 2, 28, '2016-04-03 04:45:05', '2016-04-03 04:45:05'),
(66, 3, 1, 1, 1, 2, 1, 29, '2016-04-03 04:45:05', '2016-04-03 04:45:05'),
(67, 4, 1, 1, 1, 2, 0, 30, '2016-04-03 04:45:06', '2016-04-03 04:45:06'),
(68, 1, 1, 2, 0, 1, 1, 39, '2016-04-03 04:47:16', '2016-04-03 04:47:16'),
(69, 2, 1, 2, 0, 1, 2, 38, '2016-04-03 04:47:17', '2016-04-03 04:47:17'),
(70, 3, 1, 2, 1, 2, 1, 29, '2016-04-03 04:47:17', '2016-04-03 04:47:17'),
(71, 4, 1, 2, 1, 2, 2, 28, '2016-04-03 04:47:18', '2016-04-03 04:47:18'),
(72, 3, 1, 2, 2, 2, 1, 29, '2016-04-03 04:47:19', '2016-04-03 04:47:19'),
(73, 4, 1, 2, 2, 2, 0, 30, '2016-04-03 04:47:19', '2016-04-03 04:47:19'),
(74, 1, 1, 1, 0, 1, 1, 39, '2016-04-03 04:58:55', '2016-04-03 04:58:55'),
(75, 2, 1, 1, 0, 1, 2, 38, '2016-04-03 04:58:56', '2016-04-03 04:58:56'),
(76, 3, 1, 1, 0, 2, 1, 29, '2016-04-03 04:58:57', '2016-04-03 04:58:57'),
(77, 4, 1, 1, 0, 2, 2, 28, '2016-04-03 04:58:58', '2016-04-03 04:58:58'),
(78, 3, 1, 1, 1, 2, 1, 29, '2016-04-03 04:58:58', '2016-04-03 04:58:58'),
(79, 4, 1, 1, 1, 2, 0, 30, '2016-04-03 04:58:59', '2016-04-03 04:58:59'),
(80, 1, 1, 2, 0, 1, 3, 37, '2016-04-03 04:59:33', '2016-04-03 04:59:33'),
(82, 3, 1, 2, 1, 2, 1, 29, '2016-04-03 04:59:34', '2016-04-03 04:59:34'),
(83, 4, 1, 2, 1, 2, 2, 28, '2016-04-03 04:59:35', '2016-04-03 04:59:35'),
(84, 3, 1, 2, 2, 2, 1, 29, '2016-04-03 04:59:35', '2016-04-03 04:59:35');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) DEFAULT '',
  `password_hash` varchar(255) NOT NULL DEFAULT '',
  `access_token` varchar(32) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `email_confirm_token` varchar(255) DEFAULT NULL,
  `role` int(10) UNSIGNED DEFAULT '10',
  `status` mediumint(6) NOT NULL DEFAULT '10',
  `allowance` int(10) UNSIGNED DEFAULT NULL,
  `timestamp` int(10) UNSIGNED DEFAULT NULL,
  `created_at` int(10) UNSIGNED DEFAULT NULL,
  `updated_at` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `access_token`, `password_reset_token`, `email`, `email_confirm_token`, `role`, `status`, `allowance`, `timestamp`, `created_at`, `updated_at`) VALUES
(1, 'master', 'auth-key-test-admin', '$2y$10$vsK92gjucpYK7MP.6w9Pk.N01/uH.EPaHHwnVYEAcSCjNruZ/YTPK', 'abcd1234', NULL, 'zqi2@np.edu.sg', NULL, 40, 10, NULL, NULL, 0, 0),
(2, 'admin', 'auth-key-test-admin', '$2y$10$vsK92gjucpYK7MP.6w9Pk.N01/uH.EPaHHwnVYEAcSCjNruZ/YTPK', 'abcd1234', NULL, 'zqi2@np.edu.sg', NULL, 30, 10, 299, 1449553016, 0, 0),
(3, 'manager1', 'auth-key-test-admin', '$2y$10$vsK92gjucpYK7MP.6w9Pk.N01/uH.EPaHHwnVYEAcSCjNruZ/YTPK', 'abcd1234', NULL, 'zqi2@np.edu.sg', NULL, 20, 10, 299, 1449473415, 0, 0),
(4, 'manager2', 'auth-key-test-admin', '$2y$10$vsK92gjucpYK7MP.6w9Pk.N01/uH.EPaHHwnVYEAcSCjNruZ/YTPK', 'abcd1234', NULL, 'zqi2@np.edu.sg', NULL, 20, 10, 299, 1432481401, 0, 0),
(5, 'user1', 'auth-key-test-admin', '$2y$10$vsK92gjucpYK7MP.6w9Pk.N01/uH.EPaHHwnVYEAcSCjNruZ/YTPK', 'abcd1234', NULL, 'zqi2@np.edu.sg', NULL, 10, 10, 299, 1452130625, 0, 0),
(6, 'user2', 'auth-key-test-admin', '$2y$10$vsK92gjucpYK7MP.6w9Pk.N01/uH.EPaHHwnVYEAcSCjNruZ/YTPK', 'abcd1234', NULL, 'zqi2@np.edu.sg', NULL, 10, 10, 299, 1432560400, 0, 0),
(7, 'user3', 'auth-key-test-admin', '$2y$10$vsK92gjucpYK7MP.6w9Pk.N01/uH.EPaHHwnVYEAcSCjNruZ/YTPK', 'abcd1234', NULL, 'zqi2@np.edu.sg', NULL, 10, 10, 299, 1434507798, 0, 0),
(8, 'user4', 'auth-key-test-admin', '$2y$10$vsK92gjucpYK7MP.6w9Pk.N01/uH.EPaHHwnVYEAcSCjNruZ/YTPK', 'abcd1234', NULL, 'zqi2@np.edu.sg', NULL, 10, 10, 299, 1434507798, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(32) NOT NULL DEFAULT '',
  `label` varchar(10) DEFAULT NULL,
  `ip_address` varchar(32) DEFAULT NULL,
  `expire` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `user_id`, `token`, `label`, `ip_address`, `expire`, `created_at`) VALUES
(1, 5, 'abcdefg123456', NULL, NULL, '2016-01-24 04:14:30', '2016-01-24 04:14:30');

-- --------------------------------------------------------

--
-- Table structure for table `_test_country`
--

CREATE TABLE `_test_country` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` char(2) NOT NULL,
  `name` char(52) NOT NULL,
  `population` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `_test_person`
--

CREATE TABLE `_test_person` (
  `id` int(11) NOT NULL COMMENT 'Unique person identifier',
  `first_name` varchar(60) NOT NULL COMMENT 'First name',
  `last_name` varchar(60) NOT NULL COMMENT 'Last name',
  `parent_id` int(11) UNSIGNED DEFAULT NULL,
  `country_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'Residing Country',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Person master table';

-- --------------------------------------------------------

--
-- Table structure for table `_test_post`
--

CREATE TABLE `_test_post` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `tags` text COLLATE utf8_unicode_ci,
  `status` int(4) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED DEFAULT NULL,
  `updated_at` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `_test_post`
--

INSERT INTO `_test_post` (`id`, `title`, `content`, `tags`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 'Test Post from User 1', 'Hello', 'abc', 1, 3, NULL, NULL),
(5, 'World', 'world', 'world', 1, 6, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `car_park`
--
ALTER TABLE `car_park`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projectId` (`user_id`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`car_park_id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `sensor_gantry`
--
ALTER TABLE `sensor_gantry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_park_id` (`car_park_id`);

--
-- Indexes for table `traffic_flow`
--
ALTER TABLE `traffic_flow`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_park_id` (`car_park_id`),
  ADD KEY `sensor_gantry_id` (`sensor_gantry_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_username` (`username`),
  ADD KEY `idx_user_email` (`email`),
  ADD KEY `idx_user_status` (`status`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `userId` (`user_id`);

--
-- Indexes for table `_test_country`
--
ALTER TABLE `_test_country`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`user_id`);

--
-- Indexes for table `_test_person`
--
ALTER TABLE `_test_person`
  ADD PRIMARY KEY (`id`),
  ADD KEY `countryId` (`country_id`);

--
-- Indexes for table `_test_post`
--
ALTER TABLE `_test_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_post_author` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car_park`
--
ALTER TABLE `car_park`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sensor_gantry`
--
ALTER TABLE `sensor_gantry`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `traffic_flow`
--
ALTER TABLE `traffic_flow`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `_test_country`
--
ALTER TABLE `_test_country`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `_test_person`
--
ALTER TABLE `_test_person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique person identifier';
--
-- AUTO_INCREMENT for table `_test_post`
--
ALTER TABLE `_test_post`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `car_park`
--
ALTER TABLE `car_park`
  ADD CONSTRAINT `car_park_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `file`
--
ALTER TABLE `file`
  ADD CONSTRAINT `file_ibfk_1` FOREIGN KEY (`car_park_id`) REFERENCES `car_park` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sensor_gantry`
--
ALTER TABLE `sensor_gantry`
  ADD CONSTRAINT `sensor_gantry_ibfk_1` FOREIGN KEY (`car_park_id`) REFERENCES `car_park` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `traffic_flow`
--
ALTER TABLE `traffic_flow`
  ADD CONSTRAINT `traffic_flow_ibfk_1` FOREIGN KEY (`car_park_id`) REFERENCES `car_park` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `traffic_flow_ibfk_2` FOREIGN KEY (`sensor_gantry_id`) REFERENCES `sensor_gantry` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_token`
--
ALTER TABLE `user_token`
  ADD CONSTRAINT `user_token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `_test_country`
--
ALTER TABLE `_test_country`
  ADD CONSTRAINT `_test_country_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `_test_person`
--
ALTER TABLE `_test_person`
  ADD CONSTRAINT `_test_person_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `_test_country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `_test_post`
--
ALTER TABLE `_test_post`
  ADD CONSTRAINT `FK_post_author` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
