-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2024 at 02:12 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `activity` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES
(1, 1, 'Logged in', '2024-05-23 03:35:41', '2024-05-23 03:35:41'),
(2, 1, 'Visited Coach List Page.', '2024-05-23 03:35:48', '2024-05-23 03:35:48'),
(3, 1, 'Visited Coach List Page.', '2024-05-23 03:36:08', '2024-05-23 03:36:08'),
(4, 1, 'Visited Coach List Page.', '2024-05-23 03:39:55', '2024-05-23 03:39:55'),
(5, 1, 'Visited Coach List Page.', '2024-05-23 03:40:20', '2024-05-23 03:40:20'),
(6, 1, 'Added new Sport named, Shot put.', '2024-05-23 03:41:01', '2024-05-23 03:41:01'),
(7, 1, 'Visited Coach List Page.', '2024-05-23 03:41:01', '2024-05-23 03:41:01'),
(8, 1, 'Visited Coach List Page.', '2024-05-23 03:42:25', '2024-05-23 03:42:25'),
(9, 1, 'Visited Coach List Page.', '2024-05-23 03:44:04', '2024-05-23 03:44:04'),
(10, 1, 'Visited Coach List Page.', '2024-05-23 03:44:24', '2024-05-23 03:44:24'),
(11, 1, 'Visited Coach List Page.', '2024-05-23 03:44:47', '2024-05-23 03:44:47'),
(12, 1, 'Visited Coach List Page.', '2024-05-23 03:45:02', '2024-05-23 03:45:02'),
(13, 1, 'Visited Coach List Page.', '2024-05-23 03:45:37', '2024-05-23 03:45:37'),
(14, 1, 'Visited Coach List Page.', '2024-05-23 03:45:59', '2024-05-23 03:45:59'),
(15, 1, 'Visited Coach List Page.', '2024-05-23 03:46:12', '2024-05-23 03:46:12'),
(16, 1, 'Visited Coach List Page.', '2024-05-23 03:46:41', '2024-05-23 03:46:41'),
(17, 1, 'Added new Sport named, Javelin Throw.', '2024-05-23 03:48:03', '2024-05-23 03:48:03'),
(18, 1, 'Visited Coach List Page.', '2024-05-23 03:48:04', '2024-05-23 03:48:04'),
(19, 1, 'Added new Sport named, Track and FIeld.', '2024-05-23 03:54:22', '2024-05-23 03:54:22'),
(20, 1, 'Visited Coach List Page.', '2024-05-23 03:54:22', '2024-05-23 03:54:22'),
(21, 1, 'Deleted Sport named, Track and FIeld on the list.', '2024-05-23 03:55:12', '2024-05-23 03:55:12'),
(22, 1, 'Visited Coach List Page.', '2024-05-23 03:55:14', '2024-05-23 03:55:14'),
(23, 1, 'Added new Sport named, Track and FIeld.', '2024-05-23 03:55:19', '2024-05-23 03:55:19'),
(24, 1, 'Visited Coach List Page.', '2024-05-23 03:55:20', '2024-05-23 03:55:20'),
(25, 1, 'Visited Coach List Page.', '2024-05-23 03:56:31', '2024-05-23 03:56:31'),
(26, 1, 'Visited Coach List Page.', '2024-05-23 03:56:58', '2024-05-23 03:56:58'),
(27, 1, 'Visited Coach List Page.', '2024-05-23 03:58:01', '2024-05-23 03:58:01'),
(28, 1, 'Visited Coach List Page.', '2024-05-23 03:58:03', '2024-05-23 03:58:03'),
(29, 1, 'Visited Coach List Page.', '2024-05-23 03:59:13', '2024-05-23 03:59:13'),
(30, 1, 'Visited Coach List Page.', '2024-05-23 04:00:39', '2024-05-23 04:00:39'),
(31, 1, 'Visited Coach List Page.', '2024-05-23 04:01:35', '2024-05-23 04:01:35'),
(32, 1, 'Visited Coach List Page.', '2024-05-23 04:03:18', '2024-05-23 04:03:18'),
(33, 1, 'Visited Coach List Page.', '2024-05-23 04:10:02', '2024-05-23 04:10:02'),
(34, 1, 'Visited Coach List Page.', '2024-05-23 04:11:27', '2024-05-23 04:11:27'),
(35, 1, 'Visited Coach List Page.', '2024-05-23 04:13:16', '2024-05-23 04:13:16'),
(36, 1, 'Visited Coach List Page.', '2024-05-23 04:14:15', '2024-05-23 04:14:15'),
(37, 1, 'Visited Coach List Page.', '2024-05-23 04:14:23', '2024-05-23 04:14:23'),
(38, 1, 'Visited Coach List Page.', '2024-05-23 04:15:33', '2024-05-23 04:15:33'),
(39, 1, 'Visited Coach List Page.', '2024-05-23 04:16:08', '2024-05-23 04:16:08'),
(40, 1, 'Visited Coach List Page.', '2024-05-23 04:16:29', '2024-05-23 04:16:29'),
(41, 1, 'Visited Coach List Page.', '2024-05-23 04:17:12', '2024-05-23 04:17:12'),
(42, 1, 'Visited Coach List Page.', '2024-05-23 04:21:00', '2024-05-23 04:21:00'),
(43, 1, 'Visited Coach List Page.', '2024-05-23 04:22:59', '2024-05-23 04:22:59'),
(44, 1, 'Visited Coach List Page.', '2024-05-23 04:23:04', '2024-05-23 04:23:04'),
(45, 1, 'Visited Coach List Page.', '2024-05-23 04:24:14', '2024-05-23 04:24:14'),
(46, 1, 'Visited Coach List Page.', '2024-05-23 04:24:22', '2024-05-23 04:24:22'),
(47, 1, 'Visited Coach List Page.', '2024-05-23 04:24:43', '2024-05-23 04:24:43'),
(48, 1, 'Registered new coach, Kevin Maceda for sport 4.', '2024-05-23 04:25:11', '2024-05-23 04:25:11'),
(49, 1, 'Visited Coach List Page.', '2024-05-23 04:25:11', '2024-05-23 04:25:11'),
(50, 1, 'Deleted Coach, Kevin Maceda.', '2024-05-23 04:32:09', '2024-05-23 04:32:09'),
(51, 1, 'Visited Coach List Page.', '2024-05-23 04:32:09', '2024-05-23 04:32:09'),
(52, 1, 'Registered new coach, Kevin Maceda for sport Shot put.', '2024-05-23 04:32:29', '2024-05-23 04:32:29'),
(53, 1, 'Registered new coach, Kevin Maceda for sport Shot put.', '2024-05-23 04:32:30', '2024-05-23 04:32:30'),
(54, 1, 'Visited Coach List Page.', '2024-05-23 04:32:30', '2024-05-23 04:32:30'),
(58, 1, 'Deleted Coach, Kevin Maceda.', '2024-05-23 04:33:44', '2024-05-23 04:33:44'),
(59, 1, 'Visited Coach List Page.', '2024-05-23 04:33:45', '2024-05-23 04:33:45'),
(60, 1, 'Registered new coach, Kevin Maceda for sport Shot put.', '2024-05-23 04:34:02', '2024-05-23 04:34:02'),
(61, 1, 'Visited Coach List Page.', '2024-05-23 04:34:02', '2024-05-23 04:34:02'),
(64, 1, 'Deleted Coach, Kevin Maceda.', '2024-05-23 04:35:24', '2024-05-23 04:35:24'),
(65, 1, 'Visited Coach List Page.', '2024-05-23 04:35:25', '2024-05-23 04:35:25'),
(66, 1, 'Registered new coach, Kevin Maceda for sport Shot put.', '2024-05-23 04:35:38', '2024-05-23 04:35:38'),
(67, 1, 'Visited Coach List Page.', '2024-05-23 04:35:38', '2024-05-23 04:35:38'),
(70, 1, 'Deleted Coach, Kevin Maceda.', '2024-05-23 04:37:34', '2024-05-23 04:37:34'),
(71, 1, 'Visited Coach List Page.', '2024-05-23 04:37:35', '2024-05-23 04:37:35'),
(72, 1, 'Registered new coach, Kevin Maceda for sport Javelin Throw.', '2024-05-23 04:37:48', '2024-05-23 04:37:48'),
(73, 1, 'Visited Coach List Page.', '2024-05-23 04:37:49', '2024-05-23 04:37:49'),
(86, 1, 'Visited Athlete List Page', '2024-05-23 04:43:15', '2024-05-23 04:43:15'),
(87, 1, 'Visited Athlete List Page', '2024-05-23 04:44:48', '2024-05-23 04:44:48'),
(88, 1, 'Visited Athlete List Page', '2024-05-23 04:44:55', '2024-05-23 04:44:55'),
(89, 1, 'Visited Athlete List Page', '2024-05-23 04:45:21', '2024-05-23 04:45:21'),
(91, 1, 'Visited Athlete List Page', '2024-05-23 04:45:43', '2024-05-23 04:45:43'),
(112, 1, 'Visited Athlete List Page', '2024-05-23 05:29:18', '2024-05-23 05:29:18'),
(113, 1, 'Visited Athlete List Page', '2024-05-23 05:30:01', '2024-05-23 05:30:01'),
(114, 1, 'Visited Athlete List Page', '2024-05-23 05:31:12', '2024-05-23 05:31:12'),
(127, 1, 'Visited Athlete List Page', '2024-05-23 05:38:57', '2024-05-23 05:38:57'),
(128, 1, 'Visited Coach List Page.', '2024-05-23 05:39:08', '2024-05-23 05:39:08'),
(136, 6, 'Visited My Profile.', '2024-05-23 05:45:30', '2024-05-23 05:45:30'),
(137, 6, 'Visited My Profile.', '2024-05-23 05:45:50', '2024-05-23 05:45:50'),
(138, 6, 'Visited My Profile.', '2024-05-23 05:46:06', '2024-05-23 05:46:06'),
(140, 1, 'Logged out', '2024-05-23 05:55:04', '2024-05-23 05:55:04'),
(146, 6, 'Visited My Profile.', '2024-05-23 07:19:44', '2024-05-23 07:19:44'),
(157, 1, 'Logged in', '2024-05-23 07:30:49', '2024-05-23 07:30:49'),
(158, 1, 'Visited Coach List Page.', '2024-05-23 07:30:51', '2024-05-23 07:30:51'),
(159, 1, 'Deleted Coach, Kevin Maceda.', '2024-05-23 07:30:57', '2024-05-23 07:30:57'),
(160, 1, 'Visited Coach List Page.', '2024-05-23 07:30:58', '2024-05-23 07:30:58'),
(161, 1, 'Visited Athlete List Page', '2024-05-23 07:31:00', '2024-05-23 07:31:00'),
(162, 1, 'Visited Coach List Page.', '2024-05-23 07:31:01', '2024-05-23 07:31:01'),
(163, 1, 'Registered new coach, Kevin Maceda for sport Track and FIeld.', '2024-05-23 07:31:25', '2024-05-23 07:31:25'),
(164, 1, 'Registered new coach, Kevin Maceda for sport Javelin Throw.', '2024-05-23 07:31:26', '2024-05-23 07:31:26'),
(165, 1, 'Visited Coach List Page.', '2024-05-23 07:31:26', '2024-05-23 07:31:26'),
(180, 1, 'Visited Coach List Page.', '2024-05-23 07:37:29', '2024-05-23 07:37:29'),
(181, 1, 'Visited Athlete List Page', '2024-05-23 07:37:33', '2024-05-23 07:37:33'),
(182, 1, 'Logged out', '2024-05-23 07:37:38', '2024-05-23 07:37:38'),
(201, 1, 'Logged in', '2024-05-23 07:57:01', '2024-05-23 07:57:01'),
(202, 1, 'Logged out', '2024-05-23 07:57:08', '2024-05-23 07:57:08'),
(205, 1, 'Logged in', '2024-05-25 00:14:19', '2024-05-25 00:14:19'),
(206, 1, 'Visited Athlete List Page', '2024-05-25 00:14:28', '2024-05-25 00:14:28'),
(227, 1, 'Deleted Athlete, Roxy Merced.', '2024-05-25 00:20:05', '2024-05-25 00:20:05'),
(228, 1, 'Visited Athlete List Page', '2024-05-25 00:20:06', '2024-05-25 00:20:06'),
(229, 1, 'Visited Coach List Page.', '2024-05-25 00:20:09', '2024-05-25 00:20:09'),
(239, 1, 'Visited Coach List Page.', '2024-05-25 00:25:05', '2024-05-25 00:25:05'),
(240, 1, 'Visited Coach List Page.', '2024-05-25 00:25:18', '2024-05-25 00:25:18'),
(244, 1, 'Logged out', '2024-05-25 00:25:46', '2024-05-25 00:25:46'),
(268, 6, 'Visited My Profile.', '2024-05-25 00:51:55', '2024-05-25 00:51:55'),
(280, 1, 'Logged in', '2024-05-25 00:59:07', '2024-05-25 00:59:07'),
(284, 1, 'Visited Coach List Page.', '2024-05-25 00:59:45', '2024-05-25 00:59:45'),
(285, 1, 'Deleted Coach, Kevin Maceda.', '2024-05-25 01:00:01', '2024-05-25 01:00:01'),
(286, 1, 'Visited Coach List Page.', '2024-05-25 01:00:01', '2024-05-25 01:00:01'),
(287, 1, 'Deleted Sport named, Track and FIeld on the list.', '2024-05-25 01:00:08', '2024-05-25 01:00:08'),
(288, 1, 'Visited Coach List Page.', '2024-05-25 01:00:09', '2024-05-25 01:00:09'),
(289, 1, 'Deleted Sport named, Javelin Throw on the list.', '2024-05-25 01:00:13', '2024-05-25 01:00:13'),
(290, 1, 'Visited Coach List Page.', '2024-05-25 01:00:14', '2024-05-25 01:00:14'),
(291, 1, 'Added new Sport named, Javelin Throw.', '2024-05-25 01:00:30', '2024-05-25 01:00:30'),
(292, 1, 'Visited Coach List Page.', '2024-05-25 01:00:31', '2024-05-25 01:00:31'),
(293, 1, 'Registered new coach, Kevin Maceda for sport Javelin Throw.', '2024-05-25 01:00:45', '2024-05-25 01:00:45'),
(294, 1, 'Visited Coach List Page.', '2024-05-25 01:00:46', '2024-05-25 01:00:46'),
(306, 1, 'Deleted Coach, Kevin Maceda.', '2024-05-25 01:03:02', '2024-05-25 01:03:02'),
(307, 1, 'Visited Coach List Page.', '2024-05-25 01:03:03', '2024-05-25 01:03:03'),
(308, 1, 'Deleted Sport named, Javelin Throw on the list.', '2024-05-25 01:03:07', '2024-05-25 01:03:07'),
(309, 1, 'Visited Coach List Page.', '2024-05-25 01:03:09', '2024-05-25 01:03:09'),
(310, 1, 'Visited Coach List Page.', '2024-05-25 01:03:47', '2024-05-25 01:03:47'),
(311, 1, 'Added new Sport named, Javelin Throw.', '2024-05-25 01:03:57', '2024-05-25 01:03:57'),
(312, 1, 'Visited Coach List Page.', '2024-05-25 01:03:58', '2024-05-25 01:03:58'),
(313, 1, 'Registered new coach, Kevin Maceda for sport Javelin Throw.', '2024-05-25 01:04:11', '2024-05-25 01:04:11'),
(314, 1, 'Visited Coach List Page.', '2024-05-25 01:04:12', '2024-05-25 01:04:12'),
(315, 13, 'Logged in', '2024-05-25 01:04:23', '2024-05-25 01:04:23'),
(316, 13, 'Visited Coach Dashboard.', '2024-05-25 01:04:23', '2024-05-25 01:04:23'),
(317, 13, 'Visited Javelin Throw page.', '2024-05-25 01:04:26', '2024-05-25 01:04:26'),
(318, 13, 'Visited List of Athletes under of Javelin Throw .', '2024-05-25 01:04:27', '2024-05-25 01:04:27'),
(319, 13, 'Registered new athlete, dsgdsg dfg.', '2024-05-25 01:04:48', '2024-05-25 01:04:48'),
(320, 13, 'Visited List of Athletes under of Javelin Throw .', '2024-05-25 01:04:49', '2024-05-25 01:04:49'),
(321, 13, 'Visited List of Athletes under of Javelin Throw .', '2024-05-25 01:05:04', '2024-05-25 01:05:04'),
(322, 13, 'Logged out', '2024-05-25 01:05:14', '2024-05-25 01:05:14'),
(323, 14, 'Logged in', '2024-05-25 01:05:26', '2024-05-25 01:05:26'),
(324, 14, 'Visited Javelin Throw page.', '2024-05-25 01:05:28', '2024-05-25 01:05:28'),
(325, 1, 'Logged out', '2024-05-25 01:05:36', '2024-05-25 01:05:36'),
(326, 13, 'Logged in', '2024-05-25 01:05:44', '2024-05-25 01:05:44'),
(327, 13, 'Visited Coach Dashboard.', '2024-05-25 01:05:44', '2024-05-25 01:05:44'),
(328, 13, 'Visited Javelin Throw page.', '2024-05-25 01:05:47', '2024-05-25 01:05:47'),
(329, 14, 'Visited Javelin Throw page.', '2024-05-25 01:06:31', '2024-05-25 01:06:31'),
(330, 13, 'Visited Javelin Throw page.', '2024-05-25 01:06:38', '2024-05-25 01:06:38'),
(331, 13, 'Visited List of Athletes under of Javelin Throw .', '2024-05-25 01:06:39', '2024-05-25 01:06:39'),
(332, 14, 'Visited My Profile.', '2024-05-25 01:06:43', '2024-05-25 01:06:43'),
(333, 14, 'Logged out', '2024-05-25 01:06:57', '2024-05-25 01:06:57'),
(334, 13, 'Visited Javelin Throw page.', '2024-05-25 01:07:01', '2024-05-25 01:07:01'),
(335, 13, 'Visited List of Athletes under of Javelin Throw .', '2024-05-25 01:07:02', '2024-05-25 01:07:02'),
(336, 13, 'Logged out', '2024-05-25 01:10:21', '2024-05-25 01:10:21'),
(337, 1, 'Logged in', '2024-05-25 01:10:29', '2024-05-25 01:10:29'),
(338, 1, 'Visited Athlete List Page', '2024-05-25 01:10:36', '2024-05-25 01:10:36'),
(339, 1, 'Visited Coach List Page.', '2024-05-25 01:10:38', '2024-05-25 01:10:38'),
(340, 13, 'Logged in', '2024-05-25 01:12:39', '2024-05-25 01:12:39'),
(341, 13, 'Visited Coach Dashboard.', '2024-05-25 01:12:40', '2024-05-25 01:12:40'),
(342, 13, 'Visited Coach Dashboard.', '2024-05-25 01:22:54', '2024-05-25 01:22:54'),
(343, 13, 'Visited Javelin Throw page.', '2024-05-25 01:22:57', '2024-05-25 01:22:57'),
(344, 13, 'Posted new task \"Upload your Requirements\" .', '2024-05-25 01:23:30', '2024-05-25 01:23:30'),
(345, 13, 'Visited Javelin Throw page.', '2024-05-25 01:23:30', '2024-05-25 01:23:30'),
(346, 13, 'Visited the Upload your Requirements page.', '2024-05-25 01:23:34', '2024-05-25 01:23:34'),
(347, 13, 'Visited Checklist Page.', '2024-05-25 01:23:36', '2024-05-25 01:23:36'),
(348, 13, 'Created new checklist, \"Upload here\" on the material Upload your Requirements.', '2024-05-25 01:23:45', '2024-05-25 01:23:45'),
(349, 13, 'Visited Checklist Page.', '2024-05-25 01:23:45', '2024-05-25 01:23:45'),
(350, 13, 'Visited the Upload here form.', '2024-05-25 01:23:51', '2024-05-25 01:23:51'),
(351, 13, 'Visited the Upload here form.', '2024-05-25 01:24:25', '2024-05-25 01:24:25'),
(352, 13, 'Visited the Upload here form.', '2024-05-25 01:24:57', '2024-05-25 01:24:57'),
(353, 13, 'Visited the Upload here form.', '2024-05-25 01:25:05', '2024-05-25 01:25:05'),
(354, 1, 'Logged out', '2024-05-25 01:25:10', '2024-05-25 01:25:10'),
(355, 14, 'Logged in', '2024-05-25 01:25:30', '2024-05-25 01:25:30'),
(356, 14, 'Visited Javelin Throw page.', '2024-05-25 01:25:35', '2024-05-25 01:25:35'),
(357, 14, 'Visited the Upload your Requirements page.', '2024-05-25 01:25:37', '2024-05-25 01:25:37'),
(358, 14, 'Visited Checklist Page.', '2024-05-25 01:25:40', '2024-05-25 01:25:40'),
(359, 14, 'Visited the Upload here form.', '2024-05-25 01:25:42', '2024-05-25 01:25:42'),
(360, 14, 'Visited the Upload here form.', '2024-05-25 01:25:54', '2024-05-25 01:25:54'),
(361, 14, 'Visited the Upload here form.', '2024-05-25 01:26:03', '2024-05-25 01:26:03'),
(362, 13, 'Reset the form of Upload here.', '2024-05-25 01:27:38', '2024-05-25 01:27:38'),
(363, 13, 'Visited the Upload here form.', '2024-05-25 01:27:38', '2024-05-25 01:27:38'),
(364, 13, 'Visited Javelin Throw page.', '2024-05-25 01:27:43', '2024-05-25 01:27:43'),
(365, 13, 'Deleted a Task, \"Upload your Requirements\" .', '2024-05-25 01:27:46', '2024-05-25 01:27:46'),
(366, 13, 'Visited Javelin Throw page.', '2024-05-25 01:27:47', '2024-05-25 01:27:47'),
(367, 13, 'Posted new task \"Requirement\" .', '2024-05-25 01:28:10', '2024-05-25 01:28:10'),
(368, 13, 'Visited Javelin Throw page.', '2024-05-25 01:28:11', '2024-05-25 01:28:11'),
(369, 13, 'Visited the Requirement page.', '2024-05-25 01:28:14', '2024-05-25 01:28:14'),
(370, 13, 'Visited Checklist Page.', '2024-05-25 01:28:15', '2024-05-25 01:28:15'),
(371, 13, 'Created new checklist, \"Uploading Documents\" on the material Requirement.', '2024-05-25 01:28:23', '2024-05-25 01:28:23'),
(372, 13, 'Visited Checklist Page.', '2024-05-25 01:28:24', '2024-05-25 01:28:24'),
(373, 13, 'Visited the Uploading Documents form.', '2024-05-25 01:28:26', '2024-05-25 01:28:26'),
(374, 13, 'Visited the Uploading Documents form.', '2024-05-25 01:28:38', '2024-05-25 01:28:38'),
(375, 13, 'Visited the Uploading Documents form.', '2024-05-25 01:28:59', '2024-05-25 01:28:59'),
(376, 14, 'Visited Javelin Throw page.', '2024-05-25 01:29:14', '2024-05-25 01:29:14'),
(377, 14, 'Visited Javelin Throw page.', '2024-05-25 01:29:17', '2024-05-25 01:29:17'),
(378, 14, 'Visited the Requirement page.', '2024-05-25 01:29:19', '2024-05-25 01:29:19'),
(379, 14, 'Visited Checklist Page.', '2024-05-25 01:29:21', '2024-05-25 01:29:21'),
(380, 14, 'Visited the Uploading Documents form.', '2024-05-25 01:29:30', '2024-05-25 01:29:30'),
(381, 14, 'Submitted Form.', '2024-05-25 01:29:38', '2024-05-25 01:29:38'),
(382, 14, 'Visited the Requirement page.', '2024-05-25 01:29:38', '2024-05-25 01:29:38'),
(383, 13, 'Visited Javelin Throw page.', '2024-05-25 01:29:44', '2024-05-25 01:29:44'),
(384, 13, 'Visited the Requirement page.', '2024-05-25 01:29:46', '2024-05-25 01:29:46'),
(385, 13, 'Visited Checklist Page.', '2024-05-25 01:29:48', '2024-05-25 01:29:48'),
(386, 13, 'Visited the Uploading Documents form.', '2024-05-25 01:29:51', '2024-05-25 01:29:51'),
(387, 13, 'Rated \"5\" the \"Uploading Documents\" checklist.', '2024-05-25 01:30:01', '2024-05-25 01:30:01'),
(388, 13, 'Visited the Uploading Documents form.', '2024-05-25 01:30:01', '2024-05-25 01:30:01'),
(389, 13, 'Marked as done the \"Uploading Documents\" checklist.', '2024-05-25 01:30:04', '2024-05-25 01:30:04'),
(390, 13, 'Visited the Uploading Documents form.', '2024-05-25 01:30:04', '2024-05-25 01:30:04'),
(391, 13, 'Visited the Uploading Documents form.', '2024-05-25 01:30:06', '2024-05-25 01:30:06'),
(392, 13, 'Visited Checklist Page.', '2024-05-25 01:30:10', '2024-05-25 01:30:10'),
(393, 14, 'Visited the Requirement page.', '2024-05-25 01:30:13', '2024-05-25 01:30:13'),
(394, 14, 'Visited My Profile.', '2024-05-25 01:30:25', '2024-05-25 01:30:25'),
(395, 13, 'Logged out', '2024-05-25 01:34:00', '2024-05-25 01:34:00'),
(396, 14, 'Logged out', '2024-05-25 01:34:06', '2024-05-25 01:34:06'),
(397, 1, 'Logged in', '2024-06-12 03:45:26', '2024-06-12 03:45:26'),
(398, 1, 'Visited Athlete List Page', '2024-06-12 03:45:36', '2024-06-12 03:45:36'),
(399, 1, 'Visited Coach List Page.', '2024-06-12 03:45:43', '2024-06-12 03:45:43'),
(400, 1, 'Logged out', '2024-06-12 03:45:49', '2024-06-12 03:45:49'),
(401, 13, 'Logged in', '2024-06-12 03:45:58', '2024-06-12 03:45:58'),
(402, 13, 'Visited Coach Dashboard.', '2024-06-12 03:45:59', '2024-06-12 03:45:59'),
(403, 13, 'Visited Coach Dashboard.', '2024-06-12 03:46:16', '2024-06-12 03:46:16'),
(404, 13, 'Logged out', '2024-06-12 03:46:21', '2024-06-12 03:46:21'),
(405, 14, 'Logged in', '2024-06-12 03:46:37', '2024-06-12 03:46:37'),
(406, 14, 'Visited Javelin Throw page.', '2024-06-12 03:46:43', '2024-06-12 03:46:43'),
(407, 14, 'Visited Javelin Throw page.', '2024-06-12 03:47:11', '2024-06-12 03:47:11'),
(408, 14, 'Visited My Profile.', '2024-06-12 03:47:17', '2024-06-12 03:47:17'),
(409, 14, 'Visited My Profile.', '2024-06-12 03:47:57', '2024-06-12 03:47:57'),
(410, 14, 'Visited My Profile.', '2024-06-12 03:48:55', '2024-06-12 03:48:55'),
(411, 14, 'Logged out', '2024-06-12 03:49:11', '2024-06-12 03:49:11'),
(412, 1, 'Logged in', '2024-06-12 03:49:22', '2024-06-12 03:49:22'),
(413, 1, 'Visited Coach List Page.', '2024-06-12 03:51:24', '2024-06-12 03:51:24'),
(414, 1, 'Logged out', '2024-06-12 03:51:33', '2024-06-12 03:51:33'),
(415, 13, 'Logged in', '2024-06-12 03:51:40', '2024-06-12 03:51:40'),
(416, 13, 'Visited Coach Dashboard.', '2024-06-12 03:51:41', '2024-06-12 03:51:41'),
(417, 13, 'Visited Javelin Throw page.', '2024-06-12 03:54:44', '2024-06-12 03:54:44'),
(418, 13, 'Visited List of Athletes under of Javelin Throw .', '2024-06-12 03:54:46', '2024-06-12 03:54:46');

-- --------------------------------------------------------

--
-- Table structure for table `athletes`
--

CREATE TABLE `athletes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `birthdate` date DEFAULT NULL,
  `height` double(8,2) DEFAULT NULL,
  `weight` double(8,2) DEFAULT NULL,
  `coach_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `gender` enum('Male','Female','N/A','Others') DEFAULT NULL,
  `blood_type` char(255) DEFAULT NULL,
  `bmi` double(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `athletes`
--

INSERT INTO `athletes` (`id`, `user_id`, `birthdate`, `height`, `weight`, `coach_id`, `created_at`, `updated_at`, `gender`, `blood_type`, `bmi`) VALUES
(7, 14, NULL, NULL, NULL, 10, '2024-05-25 01:04:48', '2024-05-25 01:04:48', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `checklists`
--

CREATE TABLE `checklists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT '',
  `coach_id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `checklists`
--

INSERT INTO `checklists` (`id`, `title`, `description`, `coach_id`, `material_id`, `created_at`, `updated_at`) VALUES
(2, 'Uploading Documents', NULL, 10, 2, '2024-05-25 01:28:23', '2024-05-25 01:28:23');

-- --------------------------------------------------------

--
-- Table structure for table `checklist_items`
--

CREATE TABLE `checklist_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `checklist_id` bigint(20) UNSIGNED NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `field_type` varchar(255) NOT NULL,
  `options` text DEFAULT NULL,
  `minimum_threshold` int(11) DEFAULT NULL,
  `maximum_threshold` int(11) DEFAULT NULL,
  `is_required` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `checklist_items`
--

INSERT INTO `checklist_items` (`id`, `checklist_id`, `field_name`, `field_type`, `options`, `minimum_threshold`, `maximum_threshold`, `is_required`, `created_at`, `updated_at`) VALUES
(3, 2, 'Upload docx', 'file', 'document', NULL, NULL, 1, '2024-05-25 01:28:38', '2024-05-25 01:28:38');

-- --------------------------------------------------------

--
-- Table structure for table `checklist_responses`
--

CREATE TABLE `checklist_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `checklist_item_id` bigint(20) UNSIGNED NOT NULL,
  `athlete_id` bigint(20) UNSIGNED NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ch_favorites`
--

CREATE TABLE `ch_favorites` (
  `id` char(36) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `favorite_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ch_favorites`
--

INSERT INTO `ch_favorites` (`id`, `user_id`, `favorite_id`, `created_at`, `updated_at`) VALUES
('a6243004-5c67-492c-8444-86773b2f05ee', 13, 1, '2024-05-25 01:13:16', '2024-05-25 01:13:16'),
('db90b01a-5695-4939-a6d5-0f53169797fb', 1, 13, '2024-05-25 01:13:05', '2024-05-25 01:13:05');

-- --------------------------------------------------------

--
-- Table structure for table `ch_messages`
--

CREATE TABLE `ch_messages` (
  `id` char(36) NOT NULL,
  `from_id` bigint(20) NOT NULL,
  `to_id` bigint(20) NOT NULL,
  `body` varchar(5000) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ch_messages`
--

INSERT INTO `ch_messages` (`id`, `from_id`, `to_id`, `body`, `attachment`, `seen`, `created_at`, `updated_at`) VALUES
('340a1f53-1cc2-4a5b-a683-de3a5a8658d3', 1, 13, 'heelo', NULL, 1, '2024-05-25 01:13:26', '2024-05-25 01:13:28'),
('6b403161-e9ed-4655-9a5b-24e9e489be70', 1, 13, 'dds', NULL, 1, '2024-05-25 01:14:08', '2024-05-25 01:15:31'),
('908df34a-00b3-4118-a52f-9bd56b456243', 13, 1, 'gffg', NULL, 1, '2024-05-25 01:14:02', '2024-05-25 01:14:05'),
('a167c33c-924f-42c6-bade-d6a73a8e97b6', 13, 1, 'gdfgdsg', NULL, 1, '2024-05-25 01:18:17', '2024-05-25 01:22:25'),
('bb7034f2-fcd8-40ac-a258-f7439b33be77', 1, 13, 'hello', NULL, 1, '2024-05-25 01:13:09', '2024-05-25 01:13:16');

-- --------------------------------------------------------

--
-- Table structure for table `coaches`
--

CREATE TABLE `coaches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coach_number` varchar(255) NOT NULL,
  `sport_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coaches`
--

INSERT INTO `coaches` (`id`, `coach_number`, `sport_id`, `user_id`, `created_at`, `updated_at`) VALUES
(10, '2024COACH-JWV6RFFK', 6, 13, '2024-05-25 01:04:11', '2024-05-25 01:04:11');

-- --------------------------------------------------------

--
-- Table structure for table `coach_credentials`
--

CREATE TABLE `coach_credentials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coach_id` bigint(20) UNSIGNED NOT NULL,
  `seminar_name` varchar(255) DEFAULT NULL,
  `seminar_date` date DEFAULT NULL,
  `additional_details` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coach_credentials`
--

INSERT INTO `coach_credentials` (`id`, `coach_id`, `seminar_name`, `seminar_date`, `additional_details`, `created_at`, `updated_at`) VALUES
(11, 10, 'Lorem Ipsum', '2024-05-25', NULL, '2024-05-25 01:06:17', '2024-05-25 01:06:17'),
(12, 10, 'dsgdsg sdgd dfg', '2024-05-23', 'gdsdgds', '2024-05-25 01:06:17', '2024-05-25 01:06:17');

-- --------------------------------------------------------

--
-- Table structure for table `concerns`
--

CREATE TABLE `concerns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customizes`
--

CREATE TABLE `customizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sport_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `coach_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sport_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `material_number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT '',
  `sport_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `event_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `material_number`, `user_id`, `title`, `content`, `sport_id`, `created_at`, `updated_at`, `event_id`) VALUES
(2, '6651af2a7a0dd', 13, 'Requirement', 'required', 6, '2024-05-25 01:28:10', '2024-05-25 01:28:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `material_files`
--

CREATE TABLE `material_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(221, '2014_10_12_000000_create_users_table', 1),
(222, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(223, '2019_08_19_000000_create_failed_jobs_table', 1),
(224, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(225, '2024_02_05_052001_create_sports_table', 1),
(226, '2024_02_05_052002_create_coaches_table', 1),
(227, '2024_02_05_052009_create_athletes_table', 1),
(228, '2024_02_05_054141_create_visits_table', 1),
(229, '2024_02_05_054658_create_activity_logs_table', 1),
(230, '2024_02_05_133243_create_training_programs_table', 1),
(231, '2024_02_06_101411_create_customizes_table', 1),
(232, '2024_02_06_125758_add_profile_pic_to_users_table', 1),
(233, '2024_02_07_102753_create_materials_table', 1),
(234, '2024_02_07_103008_create_material_files_table', 1),
(235, '2024_02_07_999999_add_active_status_to_users', 1),
(236, '2024_02_07_999999_add_avatar_to_users', 1),
(237, '2024_02_07_999999_add_dark_mode_to_users', 1),
(238, '2024_02_07_999999_add_messenger_color_to_users', 1),
(239, '2024_02_07_999999_create_chatify_favorites_table', 1),
(240, '2024_02_07_999999_create_chatify_messages_table', 1),
(241, '2024_02_08_013606_create_notifications_table', 1),
(242, '2024_02_09_140327_create_checklists_table', 1),
(243, '2024_02_09_140348_create_checklist_items_table', 1),
(244, '2024_02_09_140402_create_checklist_responses_table', 1),
(245, '2024_02_12_121324_create_events_table', 1),
(246, '2024_02_14_110812_add_fields_to_athletes_table', 1),
(247, '2024_02_15_071311_create_ratings_table', 1),
(248, '2024_02_19_103118_create_concerns_table', 1),
(249, '2024_02_20_141005_add_event_id_to_materials_table', 1),
(250, '2024_05_23_141627_create_coach_credentials_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `sender_id`, `receiver_id`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(9, 1, 13, 'appointed you coach of Javelin Throw. Allowed number of Athletes is 1', 1, '2024-05-25 01:04:11', '2024-05-25 01:05:10'),
(10, 13, 14, 'created new task, \"Upload your Requirements\"  under of Javelin Throw.', 0, '2024-05-25 01:23:30', '2024-05-25 01:23:30'),
(11, 13, 14, 'created new checklist form, \"Upload here\" for Upload your Requirements under Javelin Throw.', 0, '2024-05-25 01:25:04', '2024-05-25 01:25:04'),
(12, 13, 14, 'created new task, \"Requirement\"  under of Javelin Throw.', 1, '2024-05-25 01:28:10', '2024-05-25 01:29:27'),
(13, 13, 14, 'created new checklist form, \"Uploading Documents\" for Requirement under Javelin Throw.', 1, '2024-05-25 01:28:59', '2024-05-25 01:29:24'),
(14, 13, 14, 'Rated your \"Uploading Documents\" checklist with \"5\".', 1, '2024-05-25 01:30:01', '2024-05-25 01:30:18'),
(15, 13, 14, 'Marked as done the \"Uploading Documents\" checklist.', 0, '2024-05-25 01:30:04', '2024-05-25 01:30:04');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `checklist_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `checklist_id`, `user_id`, `rating`, `is_completed`, `created_at`, `updated_at`) VALUES
(1, 2, 14, 5, 1, '2024-05-25 01:30:01', '2024-05-25 01:30:04');

-- --------------------------------------------------------

--
-- Table structure for table `sports`
--

CREATE TABLE `sports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `number_of_athlete_allowed` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sports`
--

INSERT INTO `sports` (`id`, `name`, `description`, `number_of_athlete_allowed`, `created_at`, `updated_at`) VALUES
(1, 'Shot put', NULL, 20, '2024-05-23 03:41:01', '2024-05-23 03:41:01'),
(6, 'Javelin Throw', NULL, 1, '2024-05-25 01:03:57', '2024-05-25 01:03:57');

-- --------------------------------------------------------

--
-- Table structure for table `training_programs`
--

CREATE TABLE `training_programs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coach_id` bigint(20) UNSIGNED NOT NULL,
  `athlete_id` bigint(20) UNSIGNED NOT NULL,
  `sport_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uploading_documents_data`
--

CREATE TABLE `uploading_documents_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `checklist_id` bigint(20) UNSIGNED NOT NULL,
  `Upload_docx` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `uploading_documents_data`
--

INSERT INTO `uploading_documents_data` (`id`, `created_at`, `updated_at`, `user_id`, `checklist_id`, `Upload_docx`) VALUES
(1, '2024-05-25 01:29:38', '2024-05-25 01:29:38', 14, 2, 'uploading_documents_data_folder/Sample-Narrative.docx');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_num` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `fname` varchar(255) NOT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `roles` varchar(255) NOT NULL,
  `course` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT 0,
  `avatar` varchar(255) NOT NULL DEFAULT 'avatar.png',
  `dark_mode` tinyint(1) NOT NULL DEFAULT 0,
  `messenger_color` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `student_num`, `name`, `lname`, `middlename`, `fname`, `gender`, `roles`, `course`, `email`, `email_verified_at`, `password`, `profile_pic`, `remember_token`, `created_at`, `updated_at`, `active_status`, `avatar`, `dark_mode`, `messenger_color`) VALUES
(1, '', 'John M. Doe', 'Doe', 'M', 'John', 'Male', 'admin', '', 'admin.athlete@cvsu.edu.ph', '2024-05-23 03:34:53', '$2y$12$5dJ/M9xB6FrjjjLw0Fwy/uxtgw9vjBv4f23XtD/EMhKQO//NuGqvm', NULL, '1Da8rWxRtvJnznhaVn4GtIQom8U0oZ1NB0G5hY5q6JKqNtjbP7g48qUSAeke', '2024-05-23 03:34:54', '2024-05-25 01:22:55', 0, 'avatar.png', 0, '#ff2522'),
(6, '2012-100-065', 'Kevin Rosarda Maceda', 'Maceda', 'Rosarda', 'Kevin', NULL, 'user', NULL, 'macedamarkkevin@gmail.com.ph', NULL, '$2y$12$EebYWLIHWkhVJ0XXFjPKs.QfHG/fqGtEMwzDFfOaFSOsyZowIIYVO', NULL, NULL, '2024-05-23 05:27:40', '2024-05-23 05:27:40', 0, 'avatar.png', 0, NULL),
(13, NULL, 'Kevin Rosarda Maceda', 'Maceda', 'Rosarda', 'Kevin', 'Male', 'coach', NULL, 'macedamarkkevin@gmail.com', NULL, '$2y$12$HBeMZuKLjt/BXSGNufrNhuPihKyltr/pY3cRzi4NsVdRhSQ7W2dhq', NULL, NULL, '2024-05-25 01:04:11', '2024-05-25 01:13:44', 1, 'avatar.png', 0, '#00BCD4'),
(14, '2000-100-001', 'dsgdsg sdgd dfg', 'dfg', 'sdgd', 'dsgdsg', NULL, 'user', NULL, 'sample@gmail.com', NULL, '$2y$12$BMLoYAj1AtkW9rtH8Zf6hO.ogksnLiTu0s1Dt3CuJgF6iL0zMjQpi', NULL, NULL, '2024-05-25 01:04:48', '2024-05-25 01:04:48', 0, 'avatar.png', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `login` timestamp NULL DEFAULT NULL,
  `logout` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`id`, `user_id`, `login`, `logout`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-06-12 03:49:22', '2024-05-23 05:55:04', '2024-05-23 03:35:41', '2024-06-12 03:49:22'),
(9, 13, '2024-06-12 03:51:40', '2024-05-25 01:05:14', '2024-05-25 01:04:23', '2024-06-12 03:51:40'),
(10, 14, '2024-06-12 03:46:37', '2024-05-25 01:06:57', '2024-05-25 01:05:25', '2024-06-12 03:46:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `athletes`
--
ALTER TABLE `athletes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `athletes_coach_id_foreign` (`coach_id`),
  ADD KEY `athletes_user_id_foreign` (`user_id`);

--
-- Indexes for table `checklists`
--
ALTER TABLE `checklists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `checklists_coach_id_foreign` (`coach_id`),
  ADD KEY `checklists_material_id_foreign` (`material_id`);

--
-- Indexes for table `checklist_items`
--
ALTER TABLE `checklist_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `checklist_items_checklist_id_foreign` (`checklist_id`);

--
-- Indexes for table `checklist_responses`
--
ALTER TABLE `checklist_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `checklist_responses_checklist_item_id_foreign` (`checklist_item_id`),
  ADD KEY `checklist_responses_athlete_id_foreign` (`athlete_id`);

--
-- Indexes for table `ch_favorites`
--
ALTER TABLE `ch_favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_messages`
--
ALTER TABLE `ch_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coaches`
--
ALTER TABLE `coaches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coaches_sport_id_foreign` (`sport_id`),
  ADD KEY `coaches_user_id_foreign` (`user_id`);

--
-- Indexes for table `coach_credentials`
--
ALTER TABLE `coach_credentials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coach_credentials_coach_id_foreign` (`coach_id`);

--
-- Indexes for table `concerns`
--
ALTER TABLE `concerns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customizes`
--
ALTER TABLE `customizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customizes_user_id_foreign` (`user_id`),
  ADD KEY `customizes_sport_id_foreign` (`sport_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_user_id_foreign` (`user_id`),
  ADD KEY `events_coach_id_foreign` (`coach_id`),
  ADD KEY `events_sport_id_foreign` (`sport_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materials_user_id_foreign` (`user_id`),
  ADD KEY `materials_sport_id_foreign` (`sport_id`),
  ADD KEY `materials_event_id_foreign` (`event_id`);

--
-- Indexes for table `material_files`
--
ALTER TABLE `material_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_files_material_id_foreign` (`material_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_sender_id_foreign` (`sender_id`),
  ADD KEY `notifications_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ratings_checklist_id_foreign` (`checklist_id`),
  ADD KEY `ratings_user_id_foreign` (`user_id`);

--
-- Indexes for table `sports`
--
ALTER TABLE `sports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_programs`
--
ALTER TABLE `training_programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `training_programs_coach_id_foreign` (`coach_id`),
  ADD KEY `training_programs_athlete_id_foreign` (`athlete_id`),
  ADD KEY `training_programs_sport_id_foreign` (`sport_id`);

--
-- Indexes for table `uploading_documents_data`
--
ALTER TABLE `uploading_documents_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploading_documents_data_user_id_foreign` (`user_id`),
  ADD KEY `uploading_documents_data_checklist_id_foreign` (`checklist_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visits_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=419;

--
-- AUTO_INCREMENT for table `athletes`
--
ALTER TABLE `athletes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `checklists`
--
ALTER TABLE `checklists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `checklist_items`
--
ALTER TABLE `checklist_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `checklist_responses`
--
ALTER TABLE `checklist_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coaches`
--
ALTER TABLE `coaches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `coach_credentials`
--
ALTER TABLE `coach_credentials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `concerns`
--
ALTER TABLE `concerns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customizes`
--
ALTER TABLE `customizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `material_files`
--
ALTER TABLE `material_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sports`
--
ALTER TABLE `sports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `training_programs`
--
ALTER TABLE `training_programs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uploading_documents_data`
--
ALTER TABLE `uploading_documents_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `athletes`
--
ALTER TABLE `athletes`
  ADD CONSTRAINT `athletes_coach_id_foreign` FOREIGN KEY (`coach_id`) REFERENCES `coaches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `athletes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `checklists`
--
ALTER TABLE `checklists`
  ADD CONSTRAINT `checklists_coach_id_foreign` FOREIGN KEY (`coach_id`) REFERENCES `coaches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `checklists_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `checklist_items`
--
ALTER TABLE `checklist_items`
  ADD CONSTRAINT `checklist_items_checklist_id_foreign` FOREIGN KEY (`checklist_id`) REFERENCES `checklists` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `checklist_responses`
--
ALTER TABLE `checklist_responses`
  ADD CONSTRAINT `checklist_responses_athlete_id_foreign` FOREIGN KEY (`athlete_id`) REFERENCES `athletes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `checklist_responses_checklist_item_id_foreign` FOREIGN KEY (`checklist_item_id`) REFERENCES `checklist_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coaches`
--
ALTER TABLE `coaches`
  ADD CONSTRAINT `coaches_sport_id_foreign` FOREIGN KEY (`sport_id`) REFERENCES `sports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coaches_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coach_credentials`
--
ALTER TABLE `coach_credentials`
  ADD CONSTRAINT `coach_credentials_coach_id_foreign` FOREIGN KEY (`coach_id`) REFERENCES `coaches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customizes`
--
ALTER TABLE `customizes`
  ADD CONSTRAINT `customizes_sport_id_foreign` FOREIGN KEY (`sport_id`) REFERENCES `sports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customizes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_coach_id_foreign` FOREIGN KEY (`coach_id`) REFERENCES `coaches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `events_sport_id_foreign` FOREIGN KEY (`sport_id`) REFERENCES `sports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `events_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `materials_sport_id_foreign` FOREIGN KEY (`sport_id`) REFERENCES `sports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `materials_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `material_files`
--
ALTER TABLE `material_files`
  ADD CONSTRAINT `material_files_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_checklist_id_foreign` FOREIGN KEY (`checklist_id`) REFERENCES `checklists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `training_programs`
--
ALTER TABLE `training_programs`
  ADD CONSTRAINT `training_programs_athlete_id_foreign` FOREIGN KEY (`athlete_id`) REFERENCES `athletes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `training_programs_coach_id_foreign` FOREIGN KEY (`coach_id`) REFERENCES `coaches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `training_programs_sport_id_foreign` FOREIGN KEY (`sport_id`) REFERENCES `sports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `uploading_documents_data`
--
ALTER TABLE `uploading_documents_data`
  ADD CONSTRAINT `uploading_documents_data_checklist_id_foreign` FOREIGN KEY (`checklist_id`) REFERENCES `checklists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `uploading_documents_data_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `visits`
--
ALTER TABLE `visits`
  ADD CONSTRAINT `visits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
