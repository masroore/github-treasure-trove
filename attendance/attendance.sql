-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2022 at 11:28 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `academicyears`
--

CREATE TABLE `academicyears` (
  `id` int(10) UNSIGNED NOT NULL,
  `acdemicyear` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `semester` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academicyears`
--

INSERT INTO `academicyears` (`id`, `acdemicyear`, `semester`, `status`, `created_at`, `updated_at`) VALUES
(1, '2020-2021', 'First Semester', '1', '2022-02-23 20:03:13', '2022-02-23 20:03:13'),
(2, '2020-2021', 'Second Semester', '0', '2022-02-23 20:03:13', '2022-02-23 20:03:13'),
(3, '2021-2022', 'First Semester', '0', '2022-02-23 20:03:13', '2022-02-23 20:03:13'),
(4, '2021-2022', 'Second Semester', '0', '2022-02-23 20:03:13', '2022-02-23 20:03:13');

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `feecode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(10) UNSIGNED NOT NULL,
  `lecturer_id` int(11) NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `programme` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assignment_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assignment_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `score` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lecdoc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subenddate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `semester` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `academicyear` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendamces`
--

CREATE TABLE `attendamces` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attendance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `month` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `day` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audits`
--

CREATE TABLE `audits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_id` bigint(20) UNSIGNED NOT NULL,
  `old_values` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_values` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(1023) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coureregistrations`
--

CREATE TABLE `coureregistrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `lecturer_id` int(11) DEFAULT NULL,
  `indexnumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cource_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cource_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credithours` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IA_mark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exams_mark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_marks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade_point` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_gp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `semester` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `academic_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `fvrt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coureregistrations`
--

INSERT INTO `coureregistrations` (`id`, `user_id`, `lecturer_id`, `indexnumber`, `level`, `cource_code`, `cource_title`, `credithours`, `IA_mark`, `exams_mark`, `total_marks`, `grade`, `grade_point`, `total_gp`, `semester`, `session`, `academic_year`, `status`, `resit`, `fvrt`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'GES11112', 'Level 100', 'BGEC100', 'Business Management 1', '3', '20', '40', '60', 'C+', '2', '6', 'First Semester', 'Morning Session', '2020-2021', '1', '0', '1', NULL, NULL),
(2, 3, NULL, 'GES11112', 'Level 100', 'BGEC101', 'Business Law ', '3', NULL, NULL, NULL, NULL, NULL, NULL, 'First Semester', 'Morning Session', '2020-2021', NULL, '0', '0', NULL, NULL),
(3, 3, NULL, 'GES11112', 'Level 100', 'BGEC102', 'Intro to Computer Skills', '3', NULL, NULL, NULL, NULL, NULL, NULL, 'First Semester', 'Morning Session', '2020-2021', NULL, '0', '0', NULL, NULL),
(4, 3, NULL, 'GES11112', 'Level 100', 'BGEC103', 'Business Statisties', '3', NULL, NULL, NULL, NULL, NULL, NULL, 'First Semester', 'Morning Session', '2020-2021', NULL, '0', '0', NULL, NULL),
(5, 3, NULL, 'GES11112', 'Level 100', 'BGEC104', 'Communication Skills', '3', NULL, NULL, NULL, NULL, NULL, NULL, 'First Semester', 'Morning Session', '2020-2021', NULL, '0', '0', NULL, NULL),
(6, 3, 1, 'GES11112', 'Level 100', 'BGEC109', 'Principles of Marketing', '3', '10', '46', '56', 'C', '1.5', '4.5', 'Second Semester', 'Morning Session', '2020-2021', '1', '0', '0', NULL, NULL),
(7, 3, NULL, 'GES11112', 'Level 100', 'BGEC110', 'Business Communication  11', '3', '33', '33', '66', 'B-', '2.5', '7.5', 'Second Semester', 'Morning Session', '2020-2021', NULL, '0', '0', NULL, NULL),
(8, 3, NULL, 'GES11112', 'Level 100', 'BGEC106', 'Business Communication 1', '3', NULL, NULL, NULL, NULL, NULL, NULL, 'Second Semester', 'Morning Session', '2020-2021', NULL, '0', '0', NULL, NULL),
(9, 3, NULL, 'GES11112', 'Level 100', 'BGEC107', 'Intro to Organisation Behaviour', '3', NULL, NULL, NULL, NULL, NULL, NULL, 'Second Semester', 'Morning Session', '2020-2021', NULL, '0', '0', NULL, NULL),
(10, 3, NULL, 'GES11112', 'Level 100', 'BGEC108', 'Elements of Economics', '3', NULL, NULL, NULL, NULL, NULL, NULL, 'Second Semester', 'Morning Session', '2020-2021', NULL, '0', '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credithours` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `program` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `code`, `credithours`, `level`, `program`, `created_at`, `updated_at`, `type`) VALUES
(1, 'Business Management 1', 'BGEC100', '3', 'Level 100', 'Degree', '2020-06-18 20:35:07', '2021-12-02 13:34:02', 'Core'),
(2, 'Business Law', 'BGEC101', '3', 'Level 100', 'Degree', '2020-06-18 20:35:40', '2021-12-02 13:34:12', 'Elective'),
(3, 'Intro to Computer Skills', 'BGEC102', '3', 'Level 100', 'Degree', '2020-06-18 20:35:59', '2020-06-18 20:35:59', NULL),
(4, 'Business Statisties', 'BGEC103', '3', 'Level 100', 'Degree', '2020-06-18 20:36:21', '2020-06-18 20:36:21', NULL),
(5, 'Communication Skills', 'BGEC104', '3', 'Level 100', 'Degree', '2020-06-18 20:36:42', '2020-06-18 20:36:42', NULL),
(6, 'Business Management 11', 'BGEC105', '3', 'Level 100', 'Degree', '2020-06-18 20:37:04', '2020-06-18 20:37:04', NULL),
(7, 'Business Communication 1', 'BGEC106', '3', 'Level 100', 'Degree', '2020-06-18 20:38:00', '2020-06-18 20:38:00', NULL),
(8, 'Intro to Organisation Behaviour', 'BGEC107', '3', 'Level 100', 'Degree', '2020-06-18 20:39:10', '2020-06-18 20:39:10', NULL),
(9, 'Elements of Economics', 'BGEC108', '3', 'Level 100', 'Degree', '2020-06-18 20:39:35', '2020-06-18 20:39:35', NULL),
(10, 'Principles of Marketing', 'BGEC109', '3', 'Level 100', 'Degree', '2020-06-18 20:39:50', '2020-06-18 20:39:50', NULL),
(11, 'Business Communication  11', 'BGEC110', '3', 'Level 100', 'Degree', '2020-06-18 20:40:20', '2020-06-18 20:40:20', NULL),
(12, 'Business Policy and Strategy 1', 'BCPC200', '3', 'Level 200', 'Degree', '2020-06-18 20:41:51', '2021-12-02 14:24:30', 'Core'),
(13, 'Business Finance', 'BCPC201', '3', 'Level 200', 'Degree', '2020-06-18 20:42:10', '2021-12-02 14:26:39', 'Core'),
(14, 'Entrepreneurship', 'BCPC202', '3', 'Level 200', 'Degree', '2020-06-18 20:42:25', '2021-12-02 14:26:49', 'Elective'),
(15, 'Economy of Ghana', 'BCPC203', '3', 'Level 200', 'Degree', '2020-06-18 20:42:37', '2020-06-18 20:42:37', NULL),
(16, 'Company Law', 'BCPC204', '3', 'Level 200', 'Degree', '2020-06-18 20:44:52', '2020-06-18 20:44:52', NULL),
(17, 'Business Policy and Strategy 11', 'BCPC205', '3', 'Level 200', 'Degree', '2020-06-18 20:45:27', '2020-06-18 20:45:27', NULL),
(18, 'Marketing Planning', 'BCPC206', '3', 'Level 200', 'Degree', '2020-06-18 20:45:51', '2020-06-18 20:45:51', NULL),
(19, 'Sales Management', 'BCPC207', '3', 'Level 200', 'Degree', '2020-06-18 20:46:18', '2020-06-18 20:46:18', NULL),
(20, 'Marketing Research', 'BCPC208', '3', 'Level 200', 'Degree', '2020-06-18 20:46:36', '2020-06-18 20:46:36', NULL),
(21, 'Human Resource Management', 'BCPC209', '3', 'Level 200', 'Degree', '2020-06-18 20:47:05', '2020-06-18 20:47:05', NULL),
(22, 'Research Methods', 'BACT300', '3', 'Level 300', 'Degree', '2020-06-18 20:48:30', '2021-12-02 14:31:07', 'Core'),
(23, 'Enterpreneurship Development', 'BACT301', '3', 'Level 300', 'Degree', '2020-06-18 20:48:56', '2021-12-02 14:31:44', 'Elective'),
(24, 'Cost Accounting', 'BACT302', '3', 'Level 300', 'Degree', '2020-06-18 20:49:17', '2020-06-18 20:49:17', NULL),
(25, 'Financial Reporting 1', 'BACT303', '3', 'Level 300', 'Degree', '2020-06-18 20:49:36', '2020-06-18 20:49:36', NULL),
(26, 'Financial Reporting 2', 'BACT304', '3', 'Level 300', 'Degree', '2020-06-18 20:49:51', '2020-06-18 20:49:51', NULL),
(27, 'Company and Partnership Law', 'BACT305', '3', 'Level 300', 'Degree', '2020-06-18 20:50:12', '2020-06-18 20:50:12', NULL),
(28, 'Management Accounting', 'BACT306', '3', 'Level 300', 'Degree', '2020-06-18 20:50:27', '2020-06-18 20:50:27', NULL),
(29, 'Taxation', 'BACT307', '3', 'Level 300', 'Degree', '2020-06-18 20:50:50', '2020-06-18 20:50:50', NULL),
(30, 'Audit & Internal Review', 'BACT308', '3', 'Level 300', 'Degree', '2020-06-18 20:51:41', '2020-06-18 20:51:41', NULL),
(31, 'Business Policy and Strategy', 'BBBA400', '3', 'Level 400', 'Degree', '2020-06-19 01:20:43', '2021-12-02 14:39:27', 'Core'),
(32, 'Coroperate Reporting 1', 'BBBA401', '3', 'Level 400', 'Degree', '2020-06-19 01:21:20', '2021-12-02 14:40:15', 'Elective'),
(33, 'Taxation & Fiscal Policy', 'BBBA402', '3', 'Level 400', 'Degree', '2020-06-19 01:21:43', '2020-06-19 01:21:43', NULL),
(34, 'Project Work', 'BBBA403', '6', 'Level 400', 'Degree', '2020-06-19 01:21:57', '2020-06-19 01:21:57', NULL),
(35, 'Internship', 'BBBA404', '3', 'Level 400', 'Degree', '2020-06-19 01:22:14', '2020-06-19 01:22:14', NULL),
(36, 'Information Management', 'BBBA405', '3', 'Level 400', 'Degree', '2020-06-19 01:22:43', '2020-06-19 01:22:43', NULL),
(37, 'Software Quality Management', 'BBBA406', '3', 'Level 400', 'Degree', '2020-06-19 01:23:10', '2020-06-19 01:23:10', NULL),
(38, 'Electronic Business', 'BBBA407', '3', 'Level 400', 'Degree', '2020-06-19 01:23:28', '2020-06-19 01:23:28', NULL),
(39, 'Mobile Web Development', 'BBBA408', '3', 'Level 400', 'Degree', '2020-06-19 01:23:49', '2020-06-19 01:23:49', NULL),
(40, 'computer & Network Security', 'BBBA409', '3', 'Level 400', 'Degree', '2020-06-19 01:24:32', '2020-06-19 01:24:32', NULL),
(41, 'Business Management Diploma', 'PDBA111', '2', 'Level 100', 'Diploma', '2020-12-19 14:57:23', '2020-12-19 14:57:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"81af35bb-3d0e-4aa8-a87f-9e658aff55d8\",\"displayName\":\"App\\\\Notifications\\\\Notifyusers\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"delay\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":13:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:8:\\\"App\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:1:{i:0;s:5:\\\"roles\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:12:\\\"notification\\\";O:29:\\\"App\\\\Notifications\\\\Notifyusers\\\":11:{s:5:\\\"email\\\";s:10:\\\"Ahmed Ahia\\\";s:4:\\\"name\\\";s:15:\\\"admin@admin.com\\\";s:2:\\\"id\\\";s:36:\\\"7701aa7f-7559-4a9a-a0af-b796c0fb151a\\\";s:6:\\\"locale\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1645646621, 1645646621),
(2, 'default', '{\"uuid\":\"c3b8b536-d858-4517-a17f-3420266a0f50\",\"displayName\":\"App\\\\Notifications\\\\Notifyusers\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"delay\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":13:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:8:\\\"App\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:1:{i:0;s:5:\\\"roles\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:12:\\\"notification\\\";O:29:\\\"App\\\\Notifications\\\\Notifyusers\\\":11:{s:5:\\\"email\\\";s:10:\\\"Ahmed Ahia\\\";s:4:\\\"name\\\";s:15:\\\"admin@admin.com\\\";s:2:\\\"id\\\";s:36:\\\"591f1834-72f5-4176-b0e3-8bf261b5cfd0\\\";s:6:\\\"locale\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1645646639, 1645646639),
(3, 'default', '{\"uuid\":\"a0df9dae-df27-4c42-a072-a5869d5fddd0\",\"displayName\":\"App\\\\Notifications\\\\Notifyusers\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"delay\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":13:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:8:\\\"App\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:1:{i:0;s:5:\\\"roles\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:12:\\\"notification\\\";O:29:\\\"App\\\\Notifications\\\\Notifyusers\\\":11:{s:5:\\\"email\\\";s:10:\\\"Ahmed Ahia\\\";s:4:\\\"name\\\";s:15:\\\"admin@admin.com\\\";s:2:\\\"id\\\";s:36:\\\"c5aacca6-45e0-4d6c-acc0-b7f2ffe78c55\\\";s:6:\\\"locale\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1645646651, 1645646651),
(4, 'default', '{\"uuid\":\"1e389d19-f3b5-4c20-b6c0-50a6d1368726\",\"displayName\":\"App\\\\Notifications\\\\Notifyusers\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"delay\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":13:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:8:\\\"App\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:1:{i:0;s:5:\\\"roles\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:12:\\\"notification\\\";O:29:\\\"App\\\\Notifications\\\\Notifyusers\\\":11:{s:5:\\\"email\\\";s:10:\\\"Ahmed Ahia\\\";s:4:\\\"name\\\";s:15:\\\"admin@admin.com\\\";s:2:\\\"id\\\";s:36:\\\"32c78a5f-f66d-405a-afd0-9fa989bd48c4\\\";s:6:\\\"locale\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1645646656, 1645646656),
(5, 'default', '{\"uuid\":\"a4536916-8027-467f-92c7-68a19452593a\",\"displayName\":\"App\\\\Notifications\\\\Notifyusers\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"delay\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":13:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:8:\\\"App\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:1:{i:0;s:5:\\\"roles\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:12:\\\"notification\\\";O:29:\\\"App\\\\Notifications\\\\Notifyusers\\\":11:{s:5:\\\"email\\\";s:10:\\\"Ahmed Ahia\\\";s:4:\\\"name\\\";s:15:\\\"admin@admin.com\\\";s:2:\\\"id\\\";s:36:\\\"a68da055-16a9-4560-aa17-37a78bed973b\\\";s:6:\\\"locale\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1645646662, 1645646662),
(6, 'default', '{\"uuid\":\"cd2a478a-6268-427b-8622-e0f04f9bf7e3\",\"displayName\":\"App\\\\Notifications\\\\Notifyusers\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"delay\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":13:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:8:\\\"App\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:1:{i:0;s:5:\\\"roles\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:12:\\\"notification\\\";O:29:\\\"App\\\\Notifications\\\\Notifyusers\\\":11:{s:5:\\\"email\\\";s:10:\\\"Ahmed Ahia\\\";s:4:\\\"name\\\";s:15:\\\"admin@admin.com\\\";s:2:\\\"id\\\";s:36:\\\"92094db7-5dbd-490a-a229-8dd3f4fd5734\\\";s:6:\\\"locale\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1645646669, 1645646669),
(7, 'default', '{\"uuid\":\"63ffe580-7a31-4d3b-b891-b3aae54527c9\",\"displayName\":\"App\\\\Notifications\\\\Notifyusers\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"delay\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":13:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:8:\\\"App\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:1:{i:0;s:5:\\\"roles\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:12:\\\"notification\\\";O:29:\\\"App\\\\Notifications\\\\Notifyusers\\\":11:{s:5:\\\"email\\\";s:10:\\\"Ahmed Ahia\\\";s:4:\\\"name\\\";s:15:\\\"admin@admin.com\\\";s:2:\\\"id\\\";s:36:\\\"160d193a-5095-4550-a041-a4a5c2d7597d\\\";s:6:\\\"locale\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1645646675, 1645646675),
(8, 'default', '{\"uuid\":\"4ff67139-c6b2-4edd-a86a-1ebac1500d35\",\"displayName\":\"App\\\\Notifications\\\\Notifyusers\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"delay\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":13:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:8:\\\"App\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:1:{i:0;s:5:\\\"roles\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:12:\\\"notification\\\";O:29:\\\"App\\\\Notifications\\\\Notifyusers\\\":11:{s:5:\\\"email\\\";s:10:\\\"Ahmed Ahia\\\";s:4:\\\"name\\\";s:15:\\\"admin@admin.com\\\";s:2:\\\"id\\\";s:36:\\\"3a2144af-9d13-4048-8758-c55dabd5b4ee\\\";s:6:\\\"locale\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1645646678, 1645646678),
(9, 'default', '{\"uuid\":\"9a4d4095-948c-492c-b961-1e891e66dfcc\",\"displayName\":\"App\\\\Notifications\\\\Notifyusers\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"delay\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":13:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:8:\\\"App\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:1:{i:0;s:5:\\\"roles\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:12:\\\"notification\\\";O:29:\\\"App\\\\Notifications\\\\Notifyusers\\\":11:{s:5:\\\"email\\\";s:10:\\\"Ahmed Ahia\\\";s:4:\\\"name\\\";s:15:\\\"admin@admin.com\\\";s:2:\\\"id\\\";s:36:\\\"1576b01e-02ba-4620-b7e6-25e8546814a8\\\";s:6:\\\"locale\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1645646689, 1645646689),
(10, 'default', '{\"uuid\":\"66ba85b8-9e3b-4e61-9bfa-3f2f47a7c2bf\",\"displayName\":\"App\\\\Notifications\\\\Notifyusers\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"delay\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":13:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:8:\\\"App\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:1:{i:0;s:5:\\\"roles\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:12:\\\"notification\\\";O:29:\\\"App\\\\Notifications\\\\Notifyusers\\\":11:{s:5:\\\"email\\\";s:10:\\\"Ahmed Ahia\\\";s:4:\\\"name\\\";s:15:\\\"admin@admin.com\\\";s:2:\\\"id\\\";s:36:\\\"b59db938-d1f2-4017-b309-48fcec1af35b\\\";s:6:\\\"locale\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1645646791, 1645646791),
(11, 'default', '{\"uuid\":\"2a72941b-b42c-43d7-8a83-5fa9da746ea6\",\"displayName\":\"App\\\\Notifications\\\\Notifyusers\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"delay\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":13:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:8:\\\"App\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:1:{i:0;s:5:\\\"roles\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:12:\\\"notification\\\";O:29:\\\"App\\\\Notifications\\\\Notifyusers\\\":11:{s:5:\\\"email\\\";s:10:\\\"Ahmed Ahia\\\";s:4:\\\"name\\\";s:15:\\\"admin@admin.com\\\";s:2:\\\"id\\\";s:36:\\\"45d8e0de-fb52-44e3-9a65-b5ba1790e7b6\\\";s:6:\\\"locale\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1645646844, 1645646844),
(12, 'default', '{\"uuid\":\"9fd0cbdd-6ef4-4fd3-898a-fdcf94fbf538\",\"displayName\":\"App\\\\Notifications\\\\Notifyusers\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"delay\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":13:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:8:\\\"App\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:1:{i:0;s:5:\\\"roles\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:12:\\\"notification\\\";O:29:\\\"App\\\\Notifications\\\\Notifyusers\\\":11:{s:5:\\\"email\\\";s:10:\\\"Ahmed Ahia\\\";s:4:\\\"name\\\";s:15:\\\"admin@admin.com\\\";s:2:\\\"id\\\";s:36:\\\"a147979f-8c81-4c81-bd00-42bbc6d0beb6\\\";s:6:\\\"locale\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1645647081, 1645647081),
(13, 'default', '{\"uuid\":\"2a8d455b-b8e8-4e4d-9fc1-523ad69e0797\",\"displayName\":\"App\\\\Notifications\\\\Notifyusers\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"delay\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":13:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:8:\\\"App\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:1:{i:0;s:5:\\\"roles\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:12:\\\"notification\\\";O:29:\\\"App\\\\Notifications\\\\Notifyusers\\\":11:{s:5:\\\"email\\\";s:10:\\\"Ahmed Ahia\\\";s:4:\\\"name\\\";s:15:\\\"admin@admin.com\\\";s:2:\\\"id\\\";s:36:\\\"2a899754-2e1b-403e-b613-2574279a459a\\\";s:6:\\\"locale\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1645647133, 1645647133);

-- --------------------------------------------------------

--
-- Table structure for table `language_lines`
--

CREATE TABLE `language_lines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

CREATE TABLE `lecturers` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateofbirth` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `faculty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qualification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menupermissions`
--

CREATE TABLE `menupermissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `sub_menu_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menupermissions`
--

INSERT INTO `menupermissions` (`id`, `sub_menu_id`, `menu_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(6, '2', '1', '6', NULL, NULL),
(7, '2', '1', '7', NULL, NULL),
(8, '2', '1', '8', NULL, NULL),
(9, '2', '1', '9', NULL, NULL),
(10, '2', '1', '10', NULL, NULL),
(11, '3', '2', '11', NULL, NULL),
(12, '3', '2', '12', NULL, NULL),
(13, '3', '2', '13', NULL, NULL),
(14, '3', '2', '14', NULL, NULL),
(15, '4', '3', '15', NULL, NULL),
(16, '4', '3', '16', NULL, NULL),
(17, '4', '3', '17', NULL, NULL),
(18, '4', '3', '18', NULL, NULL),
(19, '5', '4', '19', NULL, NULL),
(20, '5', '4', '20', NULL, NULL),
(21, '5', '4', '21', NULL, NULL),
(22, '5', '4', '22', NULL, NULL),
(23, '6', '5', '23', NULL, NULL),
(24, '6', '5', '24', NULL, NULL),
(25, '6', '5', '25', NULL, NULL),
(26, '6', '5', '26', NULL, NULL),
(27, '7', '1', '27', NULL, NULL),
(28, '7', '1', '28', NULL, NULL),
(29, '7', '1', '29', NULL, NULL),
(30, '7', '1', '30', NULL, NULL),
(31, '7', '1', '31', NULL, NULL),
(32, '8', '1', '32', NULL, NULL),
(33, '8', '1', '33', NULL, NULL),
(34, '8', '1', '34', NULL, NULL),
(35, '8', '1', '35', NULL, NULL),
(36, '8', '1', '36', NULL, NULL),
(37, '9', '2', '37', NULL, NULL),
(38, '9', '2', '38', NULL, NULL),
(39, '9', '2', '39', NULL, NULL),
(40, '9', '2', '40', NULL, NULL),
(41, '10', '5', '41', NULL, NULL),
(42, '10', '5', '42', NULL, NULL),
(43, '10', '5', '43', NULL, NULL),
(44, '10', '5', '44', NULL, NULL),
(45, '10', '5', '45', NULL, NULL),
(46, '11', '5', '46', NULL, NULL),
(47, '11', '5', '47', NULL, NULL),
(48, '11', '5', '48', NULL, NULL),
(49, '11', '5', '49', NULL, NULL),
(50, '12', '5', '50', NULL, NULL),
(51, '12', '5', '51', NULL, NULL),
(52, '12', '5', '52', NULL, NULL),
(53, '12', '5', '53', NULL, NULL),
(54, '13', '5', '54', NULL, NULL),
(55, '13', '5', '55', NULL, NULL),
(56, '13', '5', '56', NULL, NULL),
(57, '13', '5', '57', NULL, NULL),
(65, '20', '6', '65', NULL, NULL),
(66, '20', '6', '66', NULL, NULL),
(67, '20', '6', '67', NULL, NULL),
(68, '20', '6', '68', NULL, NULL),
(69, '20', '6', '69', NULL, NULL),
(70, '21', '6', '70', NULL, NULL),
(71, '21', '6', '71', NULL, NULL),
(72, '21', '6', '72', NULL, NULL),
(73, '21', '6', '73', NULL, NULL),
(74, '22', '10', '74', NULL, NULL),
(75, '22', '10', '75', NULL, NULL),
(76, '22', '10', '76', NULL, NULL),
(77, '22', '10', '77', NULL, NULL),
(78, '22', '10', '78', NULL, NULL),
(79, '23', '10', '79', NULL, NULL),
(80, '23', '10', '80', NULL, NULL),
(81, '23', '10', '81', NULL, NULL),
(82, '23', '10', '82', NULL, NULL),
(83, '24', '10', '83', NULL, NULL),
(84, '24', '10', '84', NULL, NULL),
(85, '24', '10', '85', NULL, NULL),
(86, '24', '10', '86', NULL, NULL),
(87, '25', '10', '87', NULL, NULL),
(88, '25', '10', '88', NULL, NULL),
(89, '25', '10', '89', NULL, NULL),
(90, '25', '10', '90', NULL, NULL),
(91, '26', '10', '91', NULL, NULL),
(92, '26', '10', '92', NULL, NULL),
(93, '26', '10', '93', NULL, NULL),
(94, '26', '10', '94', NULL, NULL),
(95, '27', '10', '95', NULL, NULL),
(96, '27', '10', '96', NULL, NULL),
(97, '27', '10', '97', NULL, NULL),
(98, '27', '10', '98', NULL, NULL),
(99, '28', '10', '99', NULL, NULL),
(100, '28', '10', '100', NULL, NULL),
(101, '28', '10', '101', NULL, NULL),
(102, '28', '10', '102', NULL, NULL),
(103, '29', '11', '103', NULL, NULL),
(104, '29', '11', '104', NULL, NULL),
(105, '29', '11', '105', NULL, NULL),
(106, '29', '11', '106', NULL, NULL),
(107, '29', '11', '107', NULL, NULL),
(108, '30', '11', '108', NULL, NULL),
(109, '30', '11', '109', NULL, NULL),
(110, '30', '11', '110', NULL, NULL),
(111, '30', '11', '111', NULL, NULL),
(112, '32', '11', '112', NULL, NULL),
(113, '32', '11', '113', NULL, NULL),
(114, '32', '11', '114', NULL, NULL),
(115, '32', '11', '115', NULL, NULL),
(116, '33', '11', '116', NULL, NULL),
(117, '33', '11', '117', NULL, NULL),
(118, '33', '11', '118', NULL, NULL),
(119, '33', '11', '119', NULL, NULL),
(120, '34', '7', '120', NULL, NULL),
(121, '34', '7', '121', NULL, NULL),
(122, '34', '7', '122', NULL, NULL),
(123, '34', '7', '123', NULL, NULL),
(124, '35', '8', '124', NULL, NULL),
(125, '35', '8', '125', NULL, NULL),
(126, '35', '8', '126', NULL, NULL),
(127, '35', '8', '127', NULL, NULL),
(128, '36', '9', '128', NULL, NULL),
(129, '36', '9', '129', NULL, NULL),
(130, '36', '9', '130', NULL, NULL),
(131, '36', '9', '131', NULL, NULL),
(132, '37', '37', '132', NULL, NULL),
(133, '37', '37', '133', NULL, NULL),
(134, '37', '37', '134', NULL, NULL),
(135, '37', '37', '135', NULL, NULL),
(136, '37', '37', '136', NULL, NULL),
(137, '38', '37', '137', NULL, NULL),
(138, '38', '37', '138', NULL, NULL),
(139, '38', '37', '139', NULL, NULL),
(140, '38', '37', '140', NULL, NULL),
(141, '39', '37', '141', NULL, NULL),
(142, '39', '37', '142', NULL, NULL),
(143, '39', '37', '143', NULL, NULL),
(144, '39', '37', '144', NULL, NULL),
(145, '40', '37', '145', NULL, NULL),
(146, '40', '37', '146', NULL, NULL),
(147, '40', '37', '147', NULL, NULL),
(148, '40', '37', '148', NULL, NULL),
(149, '41', '37', '149', NULL, NULL),
(150, '41', '37', '150', NULL, NULL),
(151, '41', '37', '151', NULL, NULL),
(152, '41', '37', '152', NULL, NULL),
(153, '42', '37', '153', NULL, NULL),
(154, '42', '37', '154', NULL, NULL),
(155, '42', '37', '155', NULL, NULL),
(156, '42', '37', '156', NULL, NULL),
(157, '43', '37', '157', NULL, NULL),
(158, '43', '37', '158', NULL, NULL),
(159, '43', '37', '159', NULL, NULL),
(160, '43', '37', '160', NULL, NULL),
(161, '44', '38', '161', NULL, NULL),
(162, '44', '38', '162', NULL, NULL),
(163, '44', '38', '163', NULL, NULL),
(164, '44', '38', '164', NULL, NULL),
(165, '44', '38', '165', NULL, NULL),
(166, '45', '38', '166', NULL, NULL),
(167, '45', '38', '167', NULL, NULL),
(168, '45', '38', '168', NULL, NULL),
(169, '45', '38', '169', NULL, NULL),
(170, '46', '38', '170', NULL, NULL),
(171, '46', '38', '171', NULL, NULL),
(172, '46', '38', '172', NULL, NULL),
(173, '46', '38', '173', NULL, NULL),
(174, '47', '38', '174', NULL, NULL),
(175, '47', '38', '175', NULL, NULL),
(176, '47', '38', '176', NULL, NULL),
(177, '47', '38', '177', NULL, NULL),
(178, '49', '38', '178', NULL, NULL),
(179, '49', '38', '179', NULL, NULL),
(180, '49', '38', '180', NULL, NULL),
(181, '49', '38', '181', NULL, NULL),
(182, '50', '38', '182', NULL, NULL),
(183, '50', '38', '183', NULL, NULL),
(184, '50', '38', '184', NULL, NULL),
(185, '50', '38', '185', NULL, NULL),
(186, '51', '38', '186', NULL, NULL),
(187, '51', '38', '187', NULL, NULL),
(188, '51', '38', '188', NULL, NULL),
(189, '51', '38', '189', NULL, NULL),
(190, '52', '28', '190', NULL, NULL),
(191, '52', '28', '191', NULL, NULL),
(192, '52', '28', '192', NULL, NULL),
(193, '52', '28', '193', NULL, NULL),
(194, '53', '29', '194', NULL, NULL),
(195, '53', '29', '195', NULL, NULL),
(196, '53', '29', '196', NULL, NULL),
(197, '53', '29', '197', NULL, NULL),
(198, '54', '30', '198', NULL, NULL),
(199, '54', '30', '199', NULL, NULL),
(200, '54', '30', '200', NULL, NULL),
(201, '54', '30', '201', NULL, NULL),
(202, '55', '31', '202', NULL, NULL),
(203, '55', '31', '203', NULL, NULL),
(204, '55', '31', '204', NULL, NULL),
(205, '55', '31', '205', NULL, NULL),
(206, '56', '32', '206', NULL, NULL),
(207, '56', '32', '207', NULL, NULL),
(208, '56', '32', '208', NULL, NULL),
(209, '56', '32', '209', NULL, NULL),
(210, '56', '32', '210', NULL, NULL),
(211, '57', '32', '211', NULL, NULL),
(212, '57', '32', '212', NULL, NULL),
(213, '57', '32', '213', NULL, NULL),
(214, '57', '32', '214', NULL, NULL),
(215, '58', '33', '215', NULL, NULL),
(216, '58', '33', '216', NULL, NULL),
(217, '58', '33', '217', NULL, NULL),
(218, '58', '33', '218', NULL, NULL),
(219, '58', '33', '219', NULL, NULL),
(220, '59', '33', '220', NULL, NULL),
(221, '59', '33', '221', NULL, NULL),
(222, '59', '33', '222', NULL, NULL),
(223, '59', '33', '223', NULL, NULL),
(224, '60', '33', '224', NULL, NULL),
(225, '60', '33', '225', NULL, NULL),
(226, '60', '33', '226', NULL, NULL),
(227, '60', '33', '227', NULL, NULL),
(228, '61', '34', '228', NULL, NULL),
(229, '61', '34', '229', NULL, NULL),
(230, '61', '34', '230', NULL, NULL),
(231, '61', '34', '231', NULL, NULL),
(232, '61', '34', '232', NULL, NULL),
(233, '62', '34', '233', NULL, NULL),
(234, '62', '34', '234', NULL, NULL),
(235, '62', '34', '235', NULL, NULL),
(236, '62', '34', '236', NULL, NULL),
(237, '63', '34', '237', NULL, NULL),
(238, '63', '34', '238', NULL, NULL),
(239, '63', '34', '239', NULL, NULL),
(240, '63', '34', '240', NULL, NULL),
(241, '64', '34', '241', NULL, NULL),
(242, '64', '34', '242', NULL, NULL),
(243, '64', '34', '243', NULL, NULL),
(244, '64', '34', '244', NULL, NULL),
(245, '65', '34', '245', NULL, NULL),
(246, '65', '34', '246', NULL, NULL),
(247, '65', '34', '247', NULL, NULL),
(248, '65', '34', '248', NULL, NULL),
(249, '68', '39', '249', NULL, NULL),
(250, '70', '36', '250', NULL, NULL),
(251, '70', '36', '251', NULL, NULL),
(252, '70', '36', '252', NULL, NULL),
(253, '70', '36', '253', NULL, NULL),
(254, '70', '36', '254', NULL, NULL),
(255, '71', '36', '255', NULL, NULL),
(256, '71', '36', '256', NULL, NULL),
(257, '71', '36', '257', NULL, NULL),
(258, '71', '36', '258', NULL, NULL),
(259, '72', '35', '259', NULL, NULL),
(260, '72', '35', '260', NULL, NULL),
(261, '72', '35', '261', NULL, NULL),
(262, '72', '35', '262', NULL, NULL),
(263, '72', '35', '263', NULL, NULL),
(264, '73', '35', '264', NULL, NULL),
(265, '73', '35', '265', NULL, NULL),
(266, '73', '35', '266', NULL, NULL),
(267, '73', '35', '267', NULL, NULL),
(268, '74', '41', '268', NULL, NULL),
(269, '74', '41', '269', NULL, NULL),
(270, '74', '41', '270', NULL, NULL),
(271, '74', '41', '271', NULL, NULL),
(272, '74', '41', '272', NULL, NULL),
(273, '75', '41', '273', NULL, NULL),
(274, '75', '41', '274', NULL, NULL),
(275, '75', '41', '275', NULL, NULL),
(276, '75', '41', '276', NULL, NULL),
(281, '81', '18', '281', NULL, NULL),
(282, '81', '18', '282', NULL, NULL),
(283, '81', '18', '283', NULL, NULL),
(284, '81', '18', '284', NULL, NULL),
(285, '82', '19', '285', NULL, NULL),
(286, '82', '19', '286', NULL, NULL),
(287, '82', '19', '287', NULL, NULL),
(288, '82', '19', '288', NULL, NULL),
(289, '82', '19', '289', NULL, NULL),
(290, '83', '19', '290', NULL, NULL),
(291, '83', '19', '291', NULL, NULL),
(292, '83', '19', '292', NULL, NULL),
(293, '83', '19', '293', NULL, NULL),
(294, '84', '20', '294', NULL, NULL),
(295, '84', '20', '295', NULL, NULL),
(296, '84', '20', '296', NULL, NULL),
(297, '84', '20', '297', NULL, NULL),
(298, '84', '20', '298', NULL, NULL),
(299, '85', '20', '299', NULL, NULL),
(300, '85', '20', '300', NULL, NULL),
(301, '85', '20', '301', NULL, NULL),
(302, '85', '20', '302', NULL, NULL),
(303, '86', '21', '303', NULL, NULL),
(304, '86', '21', '304', NULL, NULL),
(305, '86', '21', '305', NULL, NULL),
(306, '86', '21', '306', NULL, NULL),
(307, '86', '21', '307', NULL, NULL),
(308, '87', '21', '308', NULL, NULL),
(309, '87', '21', '309', NULL, NULL),
(310, '87', '21', '310', NULL, NULL),
(311, '87', '21', '311', NULL, NULL),
(312, '88', '21', '312', NULL, NULL),
(313, '88', '21', '313', NULL, NULL),
(314, '88', '21', '314', NULL, NULL),
(315, '88', '21', '315', NULL, NULL),
(316, '89', '13', '316', NULL, NULL),
(317, '89', '13', '317', NULL, NULL),
(318, '89', '13', '318', NULL, NULL),
(319, '89', '13', '319', NULL, NULL),
(320, '89', '13', '320', NULL, NULL),
(321, '90', '14', '321', NULL, NULL),
(322, '90', '14', '322', NULL, NULL),
(323, '90', '14', '323', NULL, NULL),
(324, '90', '14', '324', NULL, NULL),
(325, '91', '15', '325', NULL, NULL),
(326, '91', '15', '326', NULL, NULL),
(327, '91', '15', '327', NULL, NULL),
(328, '91', '15', '328', NULL, NULL),
(329, '92', '16', '329', NULL, NULL),
(330, '92', '16', '330', NULL, NULL),
(331, '92', '16', '331', NULL, NULL),
(332, '92', '16', '332', NULL, NULL),
(333, '93', '17', '333', NULL, NULL),
(334, '93', '17', '334', NULL, NULL),
(335, '93', '17', '335', NULL, NULL),
(336, '93', '17', '336', NULL, NULL),
(337, '93', '17', '337', NULL, NULL),
(338, '94', '22', '338', NULL, NULL),
(339, '94', '22', '339', NULL, NULL),
(340, '94', '22', '340', NULL, NULL),
(341, '94', '22', '341', NULL, NULL),
(342, '95', '23', '342', NULL, NULL),
(343, '95', '23', '343', NULL, NULL),
(344, '95', '23', '344', NULL, NULL),
(345, '95', '23', '345', NULL, NULL),
(346, '96', '24', '346', NULL, NULL),
(347, '96', '24', '347', NULL, NULL),
(348, '96', '24', '348', NULL, NULL),
(349, '96', '24', '349', NULL, NULL),
(350, '96', '24', '350', NULL, NULL),
(351, '97', '24', '351', NULL, NULL),
(352, '97', '24', '352', NULL, NULL),
(353, '97', '24', '353', NULL, NULL),
(354, '97', '24', '354', NULL, NULL),
(355, '98', '24', '355', NULL, NULL),
(356, '98', '24', '356', NULL, NULL),
(357, '98', '24', '357', NULL, NULL),
(358, '98', '24', '358', NULL, NULL),
(359, '99', '24', '359', NULL, NULL),
(360, '99', '24', '360', NULL, NULL),
(361, '99', '24', '361', NULL, NULL),
(362, '99', '24', '362', NULL, NULL),
(363, '100', '24', '363', NULL, NULL),
(364, '100', '24', '364', NULL, NULL),
(365, '100', '24', '365', NULL, NULL),
(366, '100', '24', '366', NULL, NULL),
(367, '101', '24', '367', NULL, NULL),
(368, '101', '24', '368', NULL, NULL),
(369, '101', '24', '369', NULL, NULL),
(370, '101', '24', '370', NULL, NULL),
(371, '102', '25', '371', NULL, NULL),
(372, '102', '25', '372', NULL, NULL),
(373, '102', '25', '373', NULL, NULL),
(374, '102', '25', '374', NULL, NULL),
(375, '102', '25', '375', NULL, NULL),
(376, '103', '26', '376', NULL, NULL),
(377, '103', '26', '377', NULL, NULL),
(378, '103', '26', '378', NULL, NULL),
(379, '103', '26', '379', NULL, NULL),
(380, '103', '26', '380', NULL, NULL),
(381, '104', '27', '381', NULL, NULL),
(382, '104', '27', '382', NULL, NULL),
(383, '104', '27', '383', NULL, NULL),
(384, '104', '27', '384', NULL, NULL),
(385, '104', '27', '385', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `title`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Front Desk', 1, NULL, NULL),
(2, 'Academics Year', 2, NULL, NULL),
(4, 'Academic Calendar', 3, NULL, NULL),
(5, 'Pre Admission', 4, NULL, NULL),
(6, 'Confirm Admission', 5, NULL, NULL),
(7, 'Admission Doc', 6, NULL, NULL),
(8, 'Revert Admission', 7, NULL, NULL),
(9, 'Add Student', 8, NULL, NULL),
(10, 'Student Portal', 9, NULL, NULL),
(11, 'Lecturer', 101, NULL, NULL),
(13, 'All studentds', 102, NULL, NULL),
(14, 'Level 100', 11, NULL, NULL),
(15, 'Level 200', 12, NULL, NULL),
(16, 'Level 300', 13, NULL, NULL),
(17, 'Level 400', 14, NULL, NULL),
(18, 'Graduated Students', 15, NULL, NULL),
(19, 'Student Punishment', 16, NULL, NULL),
(20, 'Student Promotion', 17, NULL, NULL),
(21, 'Disable Student', 18, NULL, NULL),
(22, 'Add Programme', 19, NULL, NULL),
(23, 'Add Faculty', 20, NULL, NULL),
(24, 'Add Course', 21, NULL, NULL),
(25, 'All Degree', 22, NULL, NULL),
(26, 'All Diploma', 23, NULL, NULL),
(27, 'Programmes and Courses', 24, NULL, NULL),
(28, 'Add Hall', 25, NULL, NULL),
(29, 'Add Timetable', 26, NULL, NULL),
(30, 'Generate Timetable', 27, NULL, NULL),
(31, 'Upload Timetable', 28, NULL, NULL),
(32, 'Student Grouping', 29, NULL, NULL),
(33, 'Results Management', 30, NULL, NULL),
(34, 'Polls Management', 31, NULL, NULL),
(35, 'Online Meetings', 32, NULL, NULL),
(36, 'Communicate', 33, NULL, NULL),
(37, 'Accounts', 34, NULL, NULL),
(38, 'Human Resource', 35, NULL, NULL),
(39, 'Support Tickets', 36, NULL, NULL),
(41, 'User Management', 37, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_id` bigint(20) NOT NULL,
  `to_id` bigint(20) NOT NULL,
  `body` varchar(5000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0000_00_00_000000_create_websockets_statistics_entries_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2015_07_22_115516_create_ticketit_tables', 1),
(5, '2015_07_22_123254_alter_users_table', 1),
(6, '2015_09_29_123456_add_completed_at_column_to_ticketit_table', 1),
(7, '2015_10_08_123457_create_settings_table', 1),
(8, '2016_01_15_002617_add_htmlcontent_to_ticketit_and_comments', 1),
(9, '2016_01_15_040207_enlarge_settings_columns', 1),
(10, '2016_01_15_120557_add_indexes', 1),
(11, '2018_11_06_222923_create_transactions_table', 1),
(12, '2018_11_07_192923_create_transfers_table', 1),
(13, '2018_11_07_202152_update_transfers_table', 1),
(14, '2018_11_15_124230_create_wallets_table', 1),
(15, '2018_11_19_164609_update_transactions_table', 1),
(16, '2018_11_20_133759_add_fee_transfers_table', 1),
(17, '2018_11_22_131953_add_status_transfers_table', 1),
(18, '2018_11_22_133438_drop_refund_transfers_table', 1),
(19, '2019_02_25_231036_create_scheduled_notifications_table', 1),
(20, '2019_05_13_111553_update_status_transfers_table', 1),
(21, '2019_06_25_103755_add_exchange_status_transfers_table', 1),
(22, '2019_07_29_184926_decimal_places_wallets_table', 1),
(23, '2019_08_19_000000_create_failed_jobs_table', 1),
(24, '2019_09_22_192348_create_messages_table', 1),
(25, '2019_10_02_193759_add_discount_transfers_table', 1),
(26, '2019_10_16_211433_create_favorites_table', 1),
(27, '2019_10_18_223259_add_avatar_to_users', 1),
(28, '2019_10_20_211056_add_messenger_color_to_users', 1),
(29, '2019_10_22_000539_add_dark_mode_to_users', 1),
(30, '2019_10_25_214038_add_active_status_to_users', 1),
(31, '2020_05_28_131254_create_notifications_table', 1),
(32, '2020_05_28_145811_create_jobs_table', 1),
(33, '2020_05_30_133422_create_osncodes_table', 1),
(34, '2020_05_31_154434_create_programmes_table', 1),
(35, '2020_05_31_182031_create_personalinfos_table', 1),
(36, '2020_05_31_182111_create_results_table', 1),
(37, '2020_05_31_182143_create_schools_table', 1),
(38, '2020_05_31_185049_create_applicationinfos_table', 1),
(39, '2020_05_31_185116_create_supportingdocs_table', 1),
(40, '2020_06_01_185858_create_guardianinfos_table', 1),
(41, '2020_06_06_122319_create_studentinfos_table', 1),
(42, '2020_06_06_232205_create_academicyears_table', 1),
(43, '2020_06_08_111017_create_courses_table', 1),
(44, '2020_06_08_231714_create_programmecourses_table', 1),
(45, '2020_06_09_214648_create_permission_tables', 1),
(46, '2020_06_11_003249_create_coureregistrations_table', 1),
(47, '2020_06_11_003932_create_lecturers_table', 1),
(48, '2020_06_12_150306_create_faculties_table', 1),
(49, '2020_06_14_101144_create_examresults_table', 1),
(50, '2020_06_18_131432_create_regacademicyears_table', 1),
(51, '2020_06_20_151716_create_assignments_table', 1),
(52, '2020_06_21_190926_create_submissions_table', 1),
(53, '2020_06_25_110202_create_pollscandidates_table', 1),
(54, '2020_06_25_111312_create_pollstypes_table', 1),
(55, '2020_06_25_111655_create_pollsmonitors_table', 1),
(56, '2020_06_25_111757_create_pollspositions_table', 1),
(57, '2020_06_25_112104_create_pollsvotes_table', 1),
(58, '2020_06_27_102635_create_exams_table', 1),
(59, '2020_06_27_152633_create_questions_table', 1),
(60, '2020_06_27_153858_create_qestion_options_table', 1),
(61, '2020_06_27_154630_create_answers_table', 1),
(62, '2020_06_27_195249_create_exam_scores_table', 1),
(63, '2020_06_29_182235_create_examchecks_table', 1),
(64, '2020_06_30_010355_create_activity_log_table', 1),
(65, '2020_06_30_154613_create_examtracks_table', 1),
(66, '2020_06_30_175703_create_examretryresponses_table', 1),
(67, '2020_07_13_123816_create_lec_cources_table', 1),
(68, '2020_07_13_183134_create_halls_table', 1),
(69, '2020_07_13_191106_create_timetables_table', 1),
(70, '2020_07_15_103140_create_timetablegroups_table', 1),
(71, '2020_07_19_215056_create_uploadedtimetables_table', 1),
(72, '2020_07_23_144152_create_zoomwebs_table', 1),
(73, '2020_07_24_215640_create_staffmeetings_table', 1),
(74, '2020_07_30_004043_create_language_lines_table', 1),
(75, '2020_08_01_011149_create_audits_table', 1),
(76, '2020_08_01_023503_create_ratings_table', 1),
(77, '2020_09_13_145510_create_admissionenquiries_table', 1),
(78, '2020_09_13_162931_create_visitors_table', 1),
(79, '2020_09_13_181950_create_calllogs_table', 1),
(80, '2020_09_13_221732_create_postaldispatches_table', 1),
(81, '2020_09_14_195500_create_postalreceives_table', 1),
(82, '2020_10_12_114725_create_accounts_table', 1),
(83, '2020_10_12_133805_create_mandatory_fees_table', 1),
(84, '2020_10_12_143910_create_otherservices_fees_table', 1),
(85, '2020_10_12_171207_create_semesterfees_table', 1),
(86, '2020_10_12_204804_create_studentfees_table', 1),
(87, '2020_10_15_221943_create_studentexams_table', 1),
(88, '2020_10_24_141922_create_support_tickets_table', 1),
(89, '2020_10_24_160349_create_support_tickets_replies_table', 1),
(90, '2020_10_24_160805_create_support_ticket_files_table', 1),
(91, '2020_10_25_171351_create_paymentdeadlines_table', 1),
(92, '2020_10_29_201733_create_resultsreleases_table', 1),
(93, '2020_10_29_220911_create_pollsreleases_table', 1),
(94, '2020_11_01_235345_create_staff_table', 1),
(95, '2020_11_02_053536_create_staffdocs_table', 1),
(96, '2020_11_03_003256_create_attendamces_table', 1),
(97, '2020_11_03_185340_create_payrolls_table', 1),
(98, '2020_11_04_192230_create_staffleaves_table', 1),
(99, '2020_11_07_083611_create_examcancels_table', 1),
(100, '2020_11_09_225111_create_graduating_lists_table', 1),
(101, '2020_11_10_105019_create_chatmessages_table', 1),
(102, '2020_11_13_230557_create_punishments_table', 1),
(103, '2020_11_13_235641_create_studentfines_table', 1),
(104, '2020_11_14_021457_create_dismssals_table', 1),
(105, '2020_11_14_030013_create_rasticates_table', 1),
(106, '2020_11_15_045436_create_defers_table', 1),
(107, '2020_11_26_102335_create_wallettops_table', 1),
(108, '2020_12_02_204815_create_courseoverviews_table', 1),
(109, '2020_12_04_231906_create_studentgroupings_table', 1),
(110, '2020_12_08_115024_create_announcements_table', 1),
(111, '2020_12_08_211033_create_gradebooks_table', 1),
(112, '2020_12_09_152133_create_lessondocs_table', 1),
(113, '2020_12_09_162730_create_videouploads_table', 1),
(114, '2020_12_11_113917_create_lessonplans_table', 1),
(115, '2020_12_12_141544_create_privatefiles_table', 1),
(116, '2020_12_12_202347_create_academic_calendars_table', 1),
(117, '2020_12_17_133306_create_admissionapproveinfos_table', 1),
(118, '2020_12_18_210314_create_student_attendances_table', 1),
(119, '2020_12_21_194234_create_chatcounts_table', 1),
(120, '2021_11_10_081623_add_progcode_to_studentinfos_table', 1),
(121, '2021_11_10_123801_create_menus_table', 1),
(122, '2021_11_10_124143_create_sub_menus_table', 1),
(123, '2021_11_10_124205_create_menupermissions_table', 1),
(124, '2021_11_10_130052_add_order_to_sub_menus_table', 1),
(125, '2021_11_11_151354_add_regemail_to_users_table', 1),
(126, '2021_11_23_213759_add_fcode_to_applicationinfos_table', 1),
(127, '2021_11_28_202049_add_depertment_to_support_tickets_table', 1),
(128, '2021_11_30_182558_add_status_to_defers_table', 1),
(129, '2021_11_30_182631_add_status_to_dismssals_table', 1),
(130, '2021_11_30_182659_add_status_to_rasticates_table', 1),
(131, '2021_11_30_182735_add_duration_to_studentinfos_table', 1),
(132, '2021_11_30_203325_add_complstatus_to_studentinfos_table', 1),
(133, '2021_12_02_131327_add_type_to_courses_table', 1),
(134, '2021_12_03_153935_add_title_to_studentinfos_table', 1),
(135, '2021_12_03_160206_add_title_to_personalinfos_table', 1),
(136, '2021_12_05_123914_create_paystackmodels_table', 1),
(137, '2021_12_05_215045_create_paystacklogs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(3, 'App\\User', 3),
(3, 'App\\User', 14),
(3, 'App\\User', 20),
(3, 'App\\User', 21),
(3, 'App\\User', 22),
(3, 'App\\User', 23),
(4, 'App\\User', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(6, 'view Front Desk', 'web', NULL, NULL),
(7, 'view Admission Enquiry', 'web', NULL, NULL),
(8, 'create Admission Enquiry', 'web', NULL, NULL),
(9, 'edit Admission Enquiry', 'web', NULL, NULL),
(10, 'delete Admission Enquiry', 'web', NULL, NULL),
(11, 'view Visitors Book', 'web', NULL, NULL),
(12, 'create Visitors Book', 'web', NULL, NULL),
(13, 'edit Visitors Book', 'web', NULL, NULL),
(14, 'delete Visitors Book', 'web', NULL, NULL),
(15, 'view Phone call log', 'web', NULL, NULL),
(16, 'create Phone call log', 'web', NULL, NULL),
(17, 'edit Phone call log', 'web', NULL, NULL),
(18, 'delete Phone call log', 'web', NULL, NULL),
(19, 'view Postal Dispatch', 'web', NULL, NULL),
(20, 'create Postal Dispatch', 'web', NULL, NULL),
(21, 'edit Postal Dispatch', 'web', NULL, NULL),
(22, 'delete Postal Dispatch', 'web', NULL, NULL),
(23, 'view Postal receive', 'web', NULL, NULL),
(24, 'create Postal receive', 'web', NULL, NULL),
(25, 'edit Postal receive', 'web', NULL, NULL),
(26, 'delete Postal receive', 'web', NULL, NULL),
(27, 'view Academics Year', 'web', NULL, NULL),
(28, 'view Add Academic Year', 'web', NULL, NULL),
(29, 'create Add Academic Year', 'web', NULL, NULL),
(30, 'edit Add Academic Year', 'web', NULL, NULL),
(31, 'delete Add Academic Year', 'web', NULL, NULL),
(32, 'view Academic Calendar', 'web', NULL, NULL),
(33, 'view Create Event', 'web', NULL, NULL),
(34, 'create Create Event', 'web', NULL, NULL),
(35, 'edit Create Event', 'web', NULL, NULL),
(36, 'delete Create Event', 'web', NULL, NULL),
(37, 'view All Event', 'web', NULL, NULL),
(38, 'create All Event', 'web', NULL, NULL),
(39, 'edit All Event', 'web', NULL, NULL),
(40, 'delete All Event', 'web', NULL, NULL),
(41, 'view Pre Admission', 'web', NULL, NULL),
(42, 'view Online Admissions', 'web', NULL, NULL),
(43, 'create Online Admissions', 'web', NULL, NULL),
(44, 'edit Online Admissions', 'web', NULL, NULL),
(45, 'delete Online Admissions', 'web', NULL, NULL),
(46, 'view Level 100', 'web', NULL, NULL),
(47, 'create Level 100', 'web', NULL, NULL),
(48, 'edit Level 100', 'web', NULL, NULL),
(49, 'delete Level 100', 'web', NULL, NULL),
(50, 'view Level 200', 'web', NULL, NULL),
(51, 'create Level 200', 'web', NULL, NULL),
(52, 'edit Level 200', 'web', NULL, NULL),
(53, 'delete Level 200', 'web', NULL, NULL),
(54, 'view Level 300', 'web', NULL, NULL),
(55, 'create Level 300', 'web', NULL, NULL),
(56, 'edit Level 300', 'web', NULL, NULL),
(57, 'delete Level 300', 'web', NULL, NULL),
(65, 'view Confirm Admission', 'web', NULL, NULL),
(66, 'view Confirm Admissions', 'web', NULL, NULL),
(67, 'create Confirm Admissions', 'web', NULL, NULL),
(68, 'edit Confirm Admissions', 'web', NULL, NULL),
(69, 'delete Confirm Admissions', 'web', NULL, NULL),
(70, 'view All Confirmed Admission', 'web', NULL, NULL),
(71, 'create All Confirmed Admission', 'web', NULL, NULL),
(72, 'edit All Confirmed Admission', 'web', NULL, NULL),
(73, 'delete All Confirmed Admission', 'web', NULL, NULL),
(74, 'view Student Portal', 'web', NULL, NULL),
(75, 'view Course Registration', 'web', NULL, NULL),
(76, 'create Course Registration', 'web', NULL, NULL),
(77, 'edit Course Registration', 'web', NULL, NULL),
(78, 'delete Course Registration', 'web', NULL, NULL),
(79, 'view My results', 'web', NULL, NULL),
(80, 'create My results', 'web', NULL, NULL),
(81, 'edit My results', 'web', NULL, NULL),
(82, 'delete My results', 'web', NULL, NULL),
(83, 'view Timetable', 'web', NULL, NULL),
(84, 'create Timetable', 'web', NULL, NULL),
(85, 'edit Timetable', 'web', NULL, NULL),
(86, 'delete Timetable', 'web', NULL, NULL),
(87, 'view All Support Tickets', 'web', NULL, NULL),
(88, 'create All Support Tickets', 'web', NULL, NULL),
(89, 'edit All Support Tickets', 'web', NULL, NULL),
(90, 'delete All Support Tickets', 'web', NULL, NULL),
(91, 'view Create New Ticket', 'web', NULL, NULL),
(92, 'create Create New Ticket', 'web', NULL, NULL),
(93, 'edit Create New Ticket', 'web', NULL, NULL),
(94, 'delete Create New Ticket', 'web', NULL, NULL),
(95, 'view Online Polls', 'web', NULL, NULL),
(96, 'create Online Polls', 'web', NULL, NULL),
(97, 'edit Online Polls', 'web', NULL, NULL),
(98, 'delete Online Polls', 'web', NULL, NULL),
(99, 'view View Polls Results', 'web', NULL, NULL),
(100, 'create View Polls Results', 'web', NULL, NULL),
(101, 'edit View Polls Results', 'web', NULL, NULL),
(102, 'delete View Polls Results', 'web', NULL, NULL),
(103, 'view Lecturer', 'web', NULL, NULL),
(104, 'view Profile', 'web', NULL, NULL),
(105, 'create Profile', 'web', NULL, NULL),
(106, 'edit Profile', 'web', NULL, NULL),
(107, 'delete Profile', 'web', NULL, NULL),
(108, 'view Enter results', 'web', NULL, NULL),
(109, 'create Enter results', 'web', NULL, NULL),
(110, 'edit Enter results', 'web', NULL, NULL),
(111, 'delete Enter results', 'web', NULL, NULL),
(112, 'view Request Leave', 'web', NULL, NULL),
(113, 'create Request Leave', 'web', NULL, NULL),
(114, 'edit Request Leave', 'web', NULL, NULL),
(115, 'delete Request Leave', 'web', NULL, NULL),
(116, 'view LMS', 'web', NULL, NULL),
(117, 'create LMS', 'web', NULL, NULL),
(118, 'edit LMS', 'web', NULL, NULL),
(119, 'delete LMS', 'web', NULL, NULL),
(120, 'view Admission Doc', 'web', NULL, NULL),
(121, 'create Admission Doc', 'web', NULL, NULL),
(122, 'edit Admission Doc', 'web', NULL, NULL),
(123, 'delete Admission Doc', 'web', NULL, NULL),
(124, 'view Revert Admission', 'web', NULL, NULL),
(125, 'create Revert Admission', 'web', NULL, NULL),
(126, 'edit Revert Admission', 'web', NULL, NULL),
(127, 'delete Revert Admission', 'web', NULL, NULL),
(128, 'view Add Student', 'web', NULL, NULL),
(129, 'create Add Student', 'web', NULL, NULL),
(130, 'edit Add Student', 'web', NULL, NULL),
(131, 'delete Add Student', 'web', NULL, NULL),
(132, 'view Accounts', 'web', NULL, NULL),
(133, 'view Mandatory Fees', 'web', NULL, NULL),
(134, 'create Mandatory Fees', 'web', NULL, NULL),
(135, 'edit Mandatory Fees', 'web', NULL, NULL),
(136, 'delete Mandatory Fees', 'web', NULL, NULL),
(137, 'view Other Fees', 'web', NULL, NULL),
(138, 'create Other Fees', 'web', NULL, NULL),
(139, 'edit Other Fees', 'web', NULL, NULL),
(140, 'delete Other Fees', 'web', NULL, NULL),
(141, 'view Fee Mater', 'web', NULL, NULL),
(142, 'create Fee Mater', 'web', NULL, NULL),
(143, 'edit Fee Mater', 'web', NULL, NULL),
(144, 'delete Fee Mater', 'web', NULL, NULL),
(145, 'view View Fees', 'web', NULL, NULL),
(146, 'create View Fees', 'web', NULL, NULL),
(147, 'edit View Fees', 'web', NULL, NULL),
(148, 'delete View Fees', 'web', NULL, NULL),
(149, 'view Dispatch Fees', 'web', NULL, NULL),
(150, 'create Dispatch Fees', 'web', NULL, NULL),
(151, 'edit Dispatch Fees', 'web', NULL, NULL),
(152, 'delete Dispatch Fees', 'web', NULL, NULL),
(153, 'view Transactions', 'web', NULL, NULL),
(154, 'create Transactions', 'web', NULL, NULL),
(155, 'edit Transactions', 'web', NULL, NULL),
(156, 'delete Transactions', 'web', NULL, NULL),
(157, 'view Student', 'web', NULL, NULL),
(158, 'create Student', 'web', NULL, NULL),
(159, 'edit Student', 'web', NULL, NULL),
(160, 'delete Student', 'web', NULL, NULL),
(161, 'view Human Resource', 'web', NULL, NULL),
(162, 'view Add Staff', 'web', NULL, NULL),
(163, 'create Add Staff', 'web', NULL, NULL),
(164, 'edit Add Staff', 'web', NULL, NULL),
(165, 'delete Add Staff', 'web', NULL, NULL),
(166, 'view All Staff', 'web', NULL, NULL),
(167, 'create All Staff', 'web', NULL, NULL),
(168, 'edit All Staff', 'web', NULL, NULL),
(169, 'delete All Staff', 'web', NULL, NULL),
(170, 'view Staff Attendance', 'web', NULL, NULL),
(171, 'create Staff Attendance', 'web', NULL, NULL),
(172, 'edit Staff Attendance', 'web', NULL, NULL),
(173, 'delete Staff Attendance', 'web', NULL, NULL),
(174, 'view Payroll', 'web', NULL, NULL),
(175, 'create Payroll', 'web', NULL, NULL),
(176, 'edit Payroll', 'web', NULL, NULL),
(177, 'delete Payroll', 'web', NULL, NULL),
(178, 'view Approved Leave', 'web', NULL, NULL),
(179, 'create Approved Leave', 'web', NULL, NULL),
(180, 'edit Approved Leave', 'web', NULL, NULL),
(181, 'delete Approved Leave', 'web', NULL, NULL),
(182, 'view Lecturer Rating', 'web', NULL, NULL),
(183, 'create Lecturer Rating', 'web', NULL, NULL),
(184, 'edit Lecturer Rating', 'web', NULL, NULL),
(185, 'delete Lecturer Rating', 'web', NULL, NULL),
(186, 'view Disable Staff', 'web', NULL, NULL),
(187, 'create Disable Staff', 'web', NULL, NULL),
(188, 'edit Disable Staff', 'web', NULL, NULL),
(189, 'delete Disable Staff', 'web', NULL, NULL),
(190, 'view Add Hall', 'web', NULL, NULL),
(191, 'create Add Hall', 'web', NULL, NULL),
(192, 'edit Add Hall', 'web', NULL, NULL),
(193, 'delete Add Hall', 'web', NULL, NULL),
(194, 'view Add Timetable', 'web', NULL, NULL),
(195, 'create Add Timetable', 'web', NULL, NULL),
(196, 'edit Add Timetable', 'web', NULL, NULL),
(197, 'delete Add Timetable', 'web', NULL, NULL),
(198, 'view Generate Timetable', 'web', NULL, NULL),
(199, 'create Generate Timetable', 'web', NULL, NULL),
(200, 'edit Generate Timetable', 'web', NULL, NULL),
(201, 'delete Generate Timetable', 'web', NULL, NULL),
(202, 'view Upload Timetable', 'web', NULL, NULL),
(203, 'create Upload Timetable', 'web', NULL, NULL),
(204, 'edit Upload Timetable', 'web', NULL, NULL),
(205, 'delete Upload Timetable', 'web', NULL, NULL),
(206, 'view Student Grouping', 'web', NULL, NULL),
(207, 'view Group Student', 'web', NULL, NULL),
(208, 'create Group Student', 'web', NULL, NULL),
(209, 'edit Group Student', 'web', NULL, NULL),
(210, 'delete Group Student', 'web', NULL, NULL),
(211, 'view View Grouping', 'web', NULL, NULL),
(212, 'create View Grouping', 'web', NULL, NULL),
(213, 'edit View Grouping', 'web', NULL, NULL),
(214, 'delete View Grouping', 'web', NULL, NULL),
(215, 'view Results Management', 'web', NULL, NULL),
(216, 'view Release Results', 'web', NULL, NULL),
(217, 'create Release Results', 'web', NULL, NULL),
(218, 'edit Release Results', 'web', NULL, NULL),
(219, 'delete Release Results', 'web', NULL, NULL),
(220, 'view Cancel Results Session', 'web', NULL, NULL),
(221, 'create Cancel Results Session', 'web', NULL, NULL),
(222, 'edit Cancel Results Session', 'web', NULL, NULL),
(223, 'delete Cancel Results Session', 'web', NULL, NULL),
(224, 'view Cancel Results Student', 'web', NULL, NULL),
(225, 'create Cancel Results Student', 'web', NULL, NULL),
(226, 'edit Cancel Results Student', 'web', NULL, NULL),
(227, 'delete Cancel Results Student', 'web', NULL, NULL),
(228, 'view Polls Management', 'web', NULL, NULL),
(229, 'view Add Polls', 'web', NULL, NULL),
(230, 'create Add Polls', 'web', NULL, NULL),
(231, 'edit Add Polls', 'web', NULL, NULL),
(232, 'delete Add Polls', 'web', NULL, NULL),
(233, 'view Manage Polls', 'web', NULL, NULL),
(234, 'create Manage Polls', 'web', NULL, NULL),
(235, 'edit Manage Polls', 'web', NULL, NULL),
(236, 'delete Manage Polls', 'web', NULL, NULL),
(237, 'view Manage Candidate', 'web', NULL, NULL),
(238, 'create Manage Candidate', 'web', NULL, NULL),
(239, 'edit Manage Candidate', 'web', NULL, NULL),
(240, 'delete Manage Candidate', 'web', NULL, NULL),
(241, 'view Release Polls Results', 'web', NULL, NULL),
(242, 'create Release Polls Results', 'web', NULL, NULL),
(243, 'edit Release Polls Results', 'web', NULL, NULL),
(244, 'delete Release Polls Results', 'web', NULL, NULL),
(245, 'view Polls Results', 'web', NULL, NULL),
(246, 'create Polls Results', 'web', NULL, NULL),
(247, 'edit Polls Results', 'web', NULL, NULL),
(248, 'delete Polls Results', 'web', NULL, NULL),
(249, 'view Support Tickets', 'web', NULL, NULL),
(250, 'view Communicate', 'web', NULL, NULL),
(251, 'view Send Nail', 'web', NULL, NULL),
(252, 'create Send Nail', 'web', NULL, NULL),
(253, 'edit Send Nail', 'web', NULL, NULL),
(254, 'delete Send Nail', 'web', NULL, NULL),
(255, 'view Send Sms', 'web', NULL, NULL),
(256, 'create Send Sms', 'web', NULL, NULL),
(257, 'edit Send Sms', 'web', NULL, NULL),
(258, 'delete Send Sms', 'web', NULL, NULL),
(259, 'view Online Meetings', 'web', NULL, NULL),
(260, 'view Schedule Meeting', 'web', NULL, NULL),
(261, 'create Schedule Meeting', 'web', NULL, NULL),
(262, 'edit Schedule Meeting', 'web', NULL, NULL),
(263, 'delete Schedule Meeting', 'web', NULL, NULL),
(264, 'view Staff Meeting', 'web', NULL, NULL),
(265, 'create Staff Meeting', 'web', NULL, NULL),
(266, 'edit Staff Meeting', 'web', NULL, NULL),
(267, 'delete Staff Meeting', 'web', NULL, NULL),
(268, 'view User Management', 'web', NULL, NULL),
(269, 'view Add Role', 'web', NULL, NULL),
(270, 'create Add Role', 'web', NULL, NULL),
(271, 'edit Add Role', 'web', NULL, NULL),
(272, 'delete Add Role', 'web', NULL, NULL),
(273, 'view Force Logout', 'web', NULL, NULL),
(274, 'create Force Logout', 'web', NULL, NULL),
(275, 'edit Force Logout', 'web', NULL, NULL),
(276, 'delete Force Logout', 'web', NULL, NULL),
(281, 'view Graduated Students', 'web', NULL, NULL),
(282, 'create Graduated Students', 'web', NULL, NULL),
(283, 'edit Graduated Students', 'web', NULL, NULL),
(284, 'delete Graduated Students', 'web', NULL, NULL),
(285, 'view Student Punishment', 'web', NULL, NULL),
(286, 'view Add Fine', 'web', NULL, NULL),
(287, 'create Add Fine', 'web', NULL, NULL),
(288, 'edit Add Fine', 'web', NULL, NULL),
(289, 'delete Add Fine', 'web', NULL, NULL),
(290, 'view Fine Student', 'web', NULL, NULL),
(291, 'create Fine Student', 'web', NULL, NULL),
(292, 'edit Fine Student', 'web', NULL, NULL),
(293, 'delete Fine Student', 'web', NULL, NULL),
(294, 'view Student Promotion', 'web', NULL, NULL),
(295, 'view Promote Student', 'web', NULL, NULL),
(296, 'create Promote Student', 'web', NULL, NULL),
(297, 'edit Promote Student', 'web', NULL, NULL),
(298, 'delete Promote Student', 'web', NULL, NULL),
(299, 'view Graduation List', 'web', NULL, NULL),
(300, 'create Graduation List', 'web', NULL, NULL),
(301, 'edit Graduation List', 'web', NULL, NULL),
(302, 'delete Graduation List', 'web', NULL, NULL),
(303, 'view Disable Student', 'web', NULL, NULL),
(304, 'view Dismiss Student', 'web', NULL, NULL),
(305, 'create Dismiss Student', 'web', NULL, NULL),
(306, 'edit Dismiss Student', 'web', NULL, NULL),
(307, 'delete Dismiss Student', 'web', NULL, NULL),
(308, 'view Rusticate Student', 'web', NULL, NULL),
(309, 'create Rusticate Student', 'web', NULL, NULL),
(310, 'edit Rusticate Student', 'web', NULL, NULL),
(311, 'delete Rusticate Student', 'web', NULL, NULL),
(312, 'view Defer Student', 'web', NULL, NULL),
(313, 'create Defer Student', 'web', NULL, NULL),
(314, 'edit Defer Student', 'web', NULL, NULL),
(315, 'delete Defer Student', 'web', NULL, NULL),
(316, 'view All studentds', 'web', NULL, NULL),
(317, 'view All Students', 'web', NULL, NULL),
(318, 'create All Students', 'web', NULL, NULL),
(319, 'edit All Students', 'web', NULL, NULL),
(320, 'delete All Students', 'web', NULL, NULL),
(321, 'view Student Info Level 100', 'web', NULL, NULL),
(322, 'create Student Info Level 100', 'web', NULL, NULL),
(323, 'edit Student Info Level 100', 'web', NULL, NULL),
(324, 'delete Student Info Level 100', 'web', NULL, NULL),
(325, 'view Student Info Level 200', 'web', NULL, NULL),
(326, 'create Student Info Level 200', 'web', NULL, NULL),
(327, 'edit Student Info Level 200', 'web', NULL, NULL),
(328, 'delete Student Info Level 200', 'web', NULL, NULL),
(329, 'view Student Info Level 300', 'web', NULL, NULL),
(330, 'create Student Info Level 300', 'web', NULL, NULL),
(331, 'edit Student Info Level 300', 'web', NULL, NULL),
(332, 'delete Student Info Level 300', 'web', NULL, NULL),
(333, 'view Level 400', 'web', NULL, NULL),
(334, 'view Student Info Level 400', 'web', NULL, NULL),
(335, 'create Student Info Level 400', 'web', NULL, NULL),
(336, 'edit Student Info Level 400', 'web', NULL, NULL),
(337, 'delete Student Info Level 400', 'web', NULL, NULL),
(338, 'view Add Programme', 'web', NULL, NULL),
(339, 'create Add programme', 'web', NULL, NULL),
(340, 'edit Add programme', 'web', NULL, NULL),
(341, 'delete Add programme', 'web', NULL, NULL),
(342, 'view Add Faculty', 'web', NULL, NULL),
(343, 'create Add Faculty', 'web', NULL, NULL),
(344, 'edit Add Faculty', 'web', NULL, NULL),
(345, 'delete Add Faculty', 'web', NULL, NULL),
(346, 'view Add Course', 'web', NULL, NULL),
(347, 'view Add Course Degree Level 100', 'web', NULL, NULL),
(348, 'create Add Course Degree Level 100', 'web', NULL, NULL),
(349, 'edit Add Course Degree Level 100', 'web', NULL, NULL),
(350, 'delete Add Course Degree Level 100', 'web', NULL, NULL),
(351, 'view Add Course Degree Level 200', 'web', NULL, NULL),
(352, 'create Add Course Degree Level 200', 'web', NULL, NULL),
(353, 'edit Add Course Degree Level 200', 'web', NULL, NULL),
(354, 'delete Add Course Degree Level 200', 'web', NULL, NULL),
(355, 'view Add Course Degree Level 300', 'web', NULL, NULL),
(356, 'create Add Course Degree Level 300', 'web', NULL, NULL),
(357, 'edit Add Course Degree Level 300', 'web', NULL, NULL),
(358, 'delete Add Course Degree Level 300', 'web', NULL, NULL),
(359, 'view Add Course Degree Level 400', 'web', NULL, NULL),
(360, 'create Add Course Degree Level 400', 'web', NULL, NULL),
(361, 'edit Add Course Degree Level 400', 'web', NULL, NULL),
(362, 'delete Add Course Degree Level 400', 'web', NULL, NULL),
(363, 'view Add Course Diploma Level 100', 'web', NULL, NULL),
(364, 'create Add Course Diploma Level 100', 'web', NULL, NULL),
(365, 'edit Add Course Diploma Level 100', 'web', NULL, NULL),
(366, 'delete Add Course Diploma Level 100', 'web', NULL, NULL),
(367, 'view Add Course Diploma Level 200', 'web', NULL, NULL),
(368, 'create Add Course Diploma Level 200', 'web', NULL, NULL),
(369, 'edit Add Course Diploma Level 200', 'web', NULL, NULL),
(370, 'delete Add Course Diploma Level 200', 'web', NULL, NULL),
(371, 'view All Degree', 'web', NULL, NULL),
(372, 'view All Degree Courses', 'web', NULL, NULL),
(373, 'create All Degree Courses', 'web', NULL, NULL),
(374, 'edit All Degree Courses', 'web', NULL, NULL),
(375, 'delete All Degree Courses', 'web', NULL, NULL),
(376, 'view All Diploma', 'web', NULL, NULL),
(377, 'view All Diploma Courses', 'web', NULL, NULL),
(378, 'create All Diploma Courses', 'web', NULL, NULL),
(379, 'edit All Diploma Courses', 'web', NULL, NULL),
(380, 'delete All Diploma Courses', 'web', NULL, NULL),
(381, 'view Programmes and Courses', 'web', NULL, NULL),
(382, 'view Programs and Courses', 'web', NULL, NULL),
(383, 'create Programs and Courses', 'web', NULL, NULL),
(384, 'edit Programs and Courses', 'web', NULL, NULL),
(385, 'delete Programs and Courses', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `programmecourses`
--

CREATE TABLE `programmecourses` (
  `id` int(10) UNSIGNED NOT NULL,
  `programme` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `progcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `semester` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coursetitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coursecode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credithours` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `programmecourses`
--

INSERT INTO `programmecourses` (`id`, `programme`, `progcode`, `semester`, `level`, `coursetitle`, `coursecode`, `credithours`, `created_at`, `updated_at`) VALUES
(1, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 100', 'Business Management 1', 'BGEC100', '3', NULL, NULL),
(2, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 100', 'Business Law ', 'BGEC101', '3', NULL, NULL),
(3, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 100', 'Intro to Computer Skills', 'BGEC102', '3', NULL, NULL),
(4, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 100', 'Business Statisties', 'BGEC103', '3', NULL, NULL),
(5, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 100', 'Communication Skills', 'BGEC104', '3', NULL, NULL),
(9, 'Bachelor of Science  in Information Technology Management', 'BITM', 'Second Semester', 'Level 100', 'Principles of Marketing', 'BGEC109', '3', NULL, NULL),
(10, 'Bachelor of Science  in Information Technology Management', 'BITM', 'Second Semester', 'Level 100', 'Business Communication  11', 'BGEC110', '3', NULL, NULL),
(11, 'Bachelor of Science  in Information Technology Management', 'BITM', 'Second Semester', 'Level 100', 'Business Communication 1', 'BGEC106', '3', NULL, NULL),
(12, 'Bachelor of Science  in Information Technology Management', 'BITM', 'Second Semester', 'Level 100', 'Intro to Organisation Behaviour', 'BGEC107', '3', NULL, NULL),
(13, 'Bachelor of Science  in Information Technology Management', 'BITM', 'Second Semester', 'Level 100', 'Elements of Economics', 'BGEC108', '3', NULL, NULL),
(16, 'Bachelor of Science  in Information Technology Management', 'BITM', 'Second Semester', 'Level 200', 'Business Policy and Strategy 11', 'BCPC205', '3', NULL, NULL),
(17, 'Bachelor of Science  in Information Technology Management', 'BITM', 'Second Semester', 'Level 200', 'Marketing Planning', 'BCPC206', '3', NULL, NULL),
(18, 'Bachelor of Science  in Information Technology Management', 'BITM', 'Second Semester', 'Level 200', 'Sales Management', 'BCPC207', '3', NULL, NULL),
(19, 'Bachelor of Science  in Information Technology Management', 'BITM', 'Second Semester', 'Level 200', 'Marketing Research', 'BCPC208', '3', NULL, NULL),
(20, 'Bachelor of Science  in Information Technology Management', 'BITM', 'Second Semester', 'Level 200', 'Human Resource Management', 'BCPC209', '3', NULL, NULL),
(21, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 200', 'Business Policy and Strategy 1', 'BCPC200', '3', NULL, NULL),
(22, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 200', 'Business Finance', 'BCPC201', '3', NULL, NULL),
(23, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 200', 'Entrepreneurship', 'BCPC202', '3', NULL, NULL),
(24, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 200', 'Economy of Ghana', 'BCPC203', '3', NULL, NULL),
(25, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 200', 'Company Law', 'BCPC204', '3', NULL, NULL),
(26, 'Bachelor of Science  in Information Technology Management', 'BITM', 'Second Semester', 'Level 300', 'Company and Partnership Law', 'BACT305', '3', NULL, NULL),
(27, 'Bachelor of Science  in Information Technology Management', 'BITM', 'Second Semester', 'Level 300', 'Management Accounting', 'BACT306', '3', NULL, NULL),
(28, 'Bachelor of Science  in Information Technology Management', 'BITM', 'Second Semester', 'Level 300', 'Taxation', 'BACT307', '3', NULL, NULL),
(29, 'Bachelor of Science  in Information Technology Management', 'BITM', 'Second Semester', 'Level 300', 'Audit & Internal Review', 'BACT308', '3', NULL, NULL),
(30, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 300', 'Research Methods', 'BACT300', '3', NULL, NULL),
(31, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 300', 'Enterpreneurship Development', 'BACT301', '3', NULL, NULL),
(32, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 300', 'Cost Accounting', 'BACT302', '3', NULL, NULL),
(33, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 300', 'Financial Reporting 1', 'BACT303', '3', NULL, NULL),
(34, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 300', 'Financial Reporting 2', 'BACT304', '3', NULL, NULL),
(35, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 400', 'Business Policy and Strategy ', 'BBBA400', '3', NULL, NULL),
(36, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 400', 'Coroperate Reporting 1', 'BBBA401', '3', NULL, NULL),
(37, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 400', 'Taxation & Fiscal Policy', 'BBBA402', '3', NULL, NULL),
(38, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 400', 'Project Work', 'BBBA403', '6', NULL, NULL),
(39, 'Bachelor of Science  in Information Technology Management', 'BITM', 'First Semester', 'Level 400', 'Internship', 'BBBA404', '3', NULL, NULL),
(40, 'Bachelor of Science  in Information Technology Management', 'BITM', 'Second Semester', 'Level 400', 'Information Management', 'BBBA405', '3', NULL, NULL),
(41, 'Bachelor of Science  in Information Technology Management', 'BITM', 'Second Semester', 'Level 400', 'Software Quality Management', 'BBBA406', '3', NULL, NULL),
(42, 'Bachelor of Science  in Information Technology Management', 'BITM', 'Second Semester', 'Level 400', 'Electronic Business', 'BBBA407', '3', NULL, NULL),
(43, 'Bachelor of Science  in Information Technology Management', 'BITM', 'Second Semester', 'Level 400', 'Mobile Web Development', 'BBBA408', '3', NULL, NULL),
(44, 'Bachelor of Science  in Information Technology Management', 'BITM', 'Second Semester', 'Level 400', 'computer & Network Security', 'BBBA409', '3', NULL, NULL),
(45, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 100', 'Business Management 1', 'BGEC100', '3', NULL, NULL),
(46, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 100', 'Business Law ', 'BGEC101', '3', NULL, NULL),
(47, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 100', 'Intro to Computer Skills', 'BGEC102', '3', NULL, NULL),
(48, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 100', 'Business Statisties', 'BGEC103', '3', NULL, NULL),
(49, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 100', 'Communication Skills', 'BGEC104', '3', NULL, NULL),
(50, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Second Semester', 'Level 100', 'Business Communication 1', 'BGEC106', '3', NULL, NULL),
(51, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Second Semester', 'Level 100', 'Intro to Organisation Behaviour', 'BGEC107', '3', NULL, NULL),
(52, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Second Semester', 'Level 100', 'Elements of Economics', 'BGEC108', '3', NULL, NULL),
(53, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Second Semester', 'Level 100', 'Principles of Marketing', 'BGEC109', '3', NULL, NULL),
(54, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Second Semester', 'Level 100', 'Business Communication  11', 'BGEC110', '3', NULL, NULL),
(55, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 200', 'Business Policy and Strategy 1', 'BCPC200', '3', NULL, NULL),
(56, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 200', 'Business Finance', 'BCPC201', '3', NULL, NULL),
(57, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 200', 'Entrepreneurship', 'BCPC202', '3', NULL, NULL),
(58, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 200', 'Economy of Ghana', 'BCPC203', '3', NULL, NULL),
(59, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 200', 'Company Law', 'BCPC204', '3', NULL, NULL),
(60, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Second Semester', 'Level 200', 'Business Policy and Strategy 11', 'BCPC205', '3', NULL, NULL),
(61, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Second Semester', 'Level 200', 'Marketing Planning', 'BCPC206', '3', NULL, NULL),
(62, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Second Semester', 'Level 200', 'Sales Management', 'BCPC207', '3', NULL, NULL),
(63, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Second Semester', 'Level 200', 'Marketing Research', 'BCPC208', '3', NULL, NULL),
(64, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Second Semester', 'Level 200', 'Human Resource Management', 'BCPC209', '3', NULL, NULL),
(65, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Second Semester', 'Level 300', 'Company and Partnership Law', 'BACT305', '3', NULL, NULL),
(66, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Second Semester', 'Level 300', 'Management Accounting', 'BACT306', '3', NULL, NULL),
(67, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Second Semester', 'Level 300', 'Taxation', 'BACT307', '3', NULL, NULL),
(68, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Second Semester', 'Level 300', 'Audit & Internal Review', 'BACT308', '3', NULL, NULL),
(69, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 300', 'Research Methods', 'BACT300', '3', NULL, NULL),
(70, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 300', 'Enterpreneurship Development', 'BACT301', '3', NULL, NULL),
(71, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 300', 'Cost Accounting', 'BACT302', '3', NULL, NULL),
(72, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 300', 'Financial Reporting 1', 'BACT303', '3', NULL, NULL),
(73, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 300', 'Financial Reporting 2', 'BACT304', '3', NULL, NULL),
(74, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Second Semester', 'Level 400', 'Information Management', 'BBBA405', '3', NULL, NULL),
(75, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Second Semester', 'Level 400', 'Software Quality Management', 'BBBA406', '3', NULL, NULL),
(76, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Second Semester', 'Level 400', 'Electronic Business', 'BBBA407', '3', NULL, NULL),
(77, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Second Semester', 'Level 400', 'Mobile Web Development', 'BBBA408', '3', NULL, NULL),
(78, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Second Semester', 'Level 400', 'computer & Network Security', 'BBBA409', '3', NULL, NULL),
(79, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 400', 'Business Policy and Strategy ', 'BBBA400', '3', NULL, NULL),
(80, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 400', 'Coroperate Reporting 1', 'BBBA401', '3', NULL, NULL),
(81, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 400', 'Taxation & Fiscal Policy', 'BBBA402', '3', NULL, NULL),
(82, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 400', 'Project Work', 'BBBA403', '6', NULL, NULL),
(83, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'First Semester', 'Level 400', 'Internship', 'BBBA404', '3', NULL, NULL),
(84, 'Diploma in Accounting', 'DIAA', 'Second Semester', 'Level 100', 'Business Communication 1', 'BGEC106', '3', NULL, NULL),
(85, 'Diploma in Accounting', 'DIAA', 'Second Semester', 'Level 100', 'Intro to Organisation Behaviour', 'BGEC107', '3', NULL, NULL),
(86, 'Diploma in Accounting', 'DIAA', 'Second Semester', 'Level 100', 'Elements of Economics', 'BGEC108', '3', NULL, NULL),
(87, 'Diploma in Accounting', 'DIAA', 'Second Semester', 'Level 100', 'Principles of Marketing', 'BGEC109', '3', NULL, NULL),
(88, 'Diploma in Accounting', 'DIAA', 'Second Semester', 'Level 100', 'Business Communication  11', 'BGEC110', '3', NULL, NULL),
(89, 'Diploma in Accounting', 'DIAA', 'First Semester', 'Level 100', 'Business Management 1', 'BGEC100', '3', NULL, NULL),
(90, 'Diploma in Accounting', 'DIAA', 'First Semester', 'Level 100', 'Business Law ', 'BGEC101', '3', NULL, NULL),
(91, 'Diploma in Accounting', 'DIAA', 'First Semester', 'Level 100', 'Intro to Computer Skills', 'BGEC102', '3', NULL, NULL),
(92, 'Diploma in Accounting', 'DIAA', 'First Semester', 'Level 100', 'Business Statisties', 'BGEC103', '3', NULL, NULL),
(93, 'Diploma in Accounting', 'DIAA', 'First Semester', 'Level 100', 'Communication Skills', 'BGEC104', '3', NULL, NULL),
(94, 'Diploma in Accounting', 'DIAA', 'First Semester', 'Level 200', 'Business Policy and Strategy 1', 'BCPC200', '3', NULL, NULL),
(95, 'Diploma in Accounting', 'DIAA', 'First Semester', 'Level 200', 'Business Finance', 'BCPC201', '3', NULL, NULL),
(96, 'Diploma in Accounting', 'DIAA', 'First Semester', 'Level 200', 'Entrepreneurship', 'BCPC202', '3', NULL, NULL),
(97, 'Diploma in Accounting', 'DIAA', 'First Semester', 'Level 200', 'Economy of Ghana', 'BCPC203', '3', NULL, NULL),
(98, 'Diploma in Accounting', 'DIAA', 'First Semester', 'Level 200', 'Company Law', 'BCPC204', '3', NULL, NULL),
(99, 'Diploma in Accounting', 'DIAA', 'Second Semester', 'Level 200', 'Business Policy and Strategy 11', 'BCPC205', '3', NULL, NULL),
(100, 'Diploma in Accounting', 'DIAA', 'Second Semester', 'Level 200', 'Marketing Planning', 'BCPC206', '3', NULL, NULL),
(101, 'Diploma in Accounting', 'DIAA', 'Second Semester', 'Level 200', 'Sales Management', 'BCPC207', '3', NULL, NULL),
(102, 'Diploma in Accounting', 'DIAA', 'Second Semester', 'Level 200', 'Marketing Research', 'BCPC208', '3', NULL, NULL),
(103, 'Diploma in Accounting', 'DIAA', 'Second Semester', 'Level 200', 'Human Resource Management', 'BCPC209', '3', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `programmes`
--

CREATE TABLE `programmes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `programmes`
--

INSERT INTO `programmes` (`id`, `name`, `code`, `type`, `duration`, `department`, `created_at`, `updated_at`) VALUES
(1, 'Bachelor of Science in Information Technology Management', 'BITM', 'Degree Programme', '4', 'Department of Information Technology Management', NULL, NULL),
(2, 'Bachelor of Arts in Public Relations Management', 'BAPR', 'Degree Programme', '4', 'Department of public relations', NULL, NULL),
(3, 'Diploma in Accounting', 'DIAA', 'Diploma Programme', '3', 'Department of Accounting', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `regacademicyears`
--

CREATE TABLE `regacademicyears` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `academicyear` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `semester` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `regacademicyears`
--

INSERT INTO `regacademicyears` (`id`, `user_id`, `academicyear`, `semester`, `created_at`, `updated_at`) VALUES
(1, '3', '2020-2021', 'First Semester', NULL, NULL),
(2, '3', '2020-2021', 'Second Semester', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(10) UNSIGNED NOT NULL,
  `osncode_id` int(11) DEFAULT NULL,
  `resulttype` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `examtype` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `examyear` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `indexnumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grad1` int(11) DEFAULT NULL,
  `subject2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grad2` int(11) DEFAULT NULL,
  `subject3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grad3` int(11) DEFAULT NULL,
  `subject4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grad4` int(11) DEFAULT NULL,
  `subject5` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade5` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grad5` int(11) DEFAULT NULL,
  `subject6` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade6` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grad6` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resultsreleases`
--

CREATE TABLE `resultsreleases` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resultsreleases`
--

INSERT INTO `resultsreleases` (`id`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'is_admin', 'web', NULL, NULL),
(2, 'is_superAdmin', 'web', NULL, NULL),
(3, 'Student', 'web', NULL, NULL),
(4, 'Lecturer', 'web', NULL, NULL),
(15, 'Human Resource Manager', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 3),
(75, 3),
(76, 3),
(77, 3),
(78, 3),
(79, 3),
(80, 3),
(81, 3),
(82, 3),
(83, 3),
(84, 3),
(85, 3),
(86, 3),
(87, 3),
(88, 3),
(89, 3),
(90, 3),
(91, 3),
(92, 3),
(93, 3),
(94, 3),
(95, 3),
(96, 3),
(97, 3),
(98, 3),
(99, 3),
(100, 3),
(101, 3),
(102, 3),
(103, 4),
(104, 4),
(105, 4),
(106, 4),
(107, 4),
(108, 4),
(109, 4),
(110, 4),
(111, 4),
(112, 4),
(113, 4),
(114, 4),
(115, 4),
(116, 4),
(117, 4),
(118, 4),
(119, 4),
(120, 1),
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(125, 1),
(126, 1),
(127, 1),
(128, 1),
(129, 1),
(130, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1),
(139, 1),
(140, 1),
(141, 1),
(142, 1),
(143, 1),
(144, 1),
(145, 1),
(146, 1),
(147, 1),
(148, 1),
(149, 1),
(150, 1),
(151, 1),
(152, 1),
(153, 1),
(154, 1),
(155, 1),
(156, 1),
(157, 1),
(158, 1),
(159, 1),
(160, 1),
(161, 1),
(161, 15),
(162, 1),
(162, 15),
(163, 1),
(163, 15),
(164, 1),
(164, 15),
(165, 1),
(165, 15),
(166, 1),
(166, 15),
(167, 1),
(167, 15),
(168, 1),
(168, 15),
(169, 1),
(169, 15),
(170, 1),
(170, 15),
(171, 1),
(171, 15),
(172, 1),
(172, 15),
(173, 1),
(173, 15),
(174, 1),
(174, 15),
(175, 1),
(175, 15),
(176, 1),
(176, 15),
(177, 1),
(177, 15),
(178, 1),
(178, 15),
(179, 1),
(179, 15),
(180, 1),
(180, 15),
(181, 1),
(181, 15),
(182, 1),
(182, 15),
(183, 1),
(183, 15),
(184, 1),
(184, 15),
(185, 1),
(185, 15),
(186, 1),
(186, 15),
(187, 1),
(187, 15),
(188, 1),
(188, 15),
(189, 1),
(189, 15),
(190, 1),
(191, 1),
(192, 1),
(193, 1),
(194, 1),
(195, 1),
(196, 1),
(197, 1),
(198, 1),
(199, 1),
(200, 1),
(201, 1),
(202, 1),
(203, 1),
(204, 1),
(205, 1),
(206, 1),
(207, 1),
(208, 1),
(209, 1),
(210, 1),
(211, 1),
(212, 1),
(213, 1),
(214, 1),
(215, 1),
(216, 1),
(217, 1),
(218, 1),
(219, 1),
(220, 1),
(221, 1),
(222, 1),
(223, 1),
(224, 1),
(225, 1),
(226, 1),
(227, 1),
(228, 1),
(229, 1),
(230, 1),
(231, 1),
(232, 1),
(233, 1),
(234, 1),
(235, 1),
(236, 1),
(237, 1),
(238, 1),
(239, 1),
(240, 1),
(241, 1),
(242, 1),
(243, 1),
(244, 1),
(245, 1),
(246, 1),
(247, 1),
(248, 1),
(249, 1),
(250, 1),
(250, 3),
(251, 1),
(251, 3),
(252, 1),
(253, 1),
(254, 1),
(255, 1),
(256, 1),
(257, 1),
(258, 1),
(259, 1),
(260, 1),
(261, 1),
(262, 1),
(263, 1),
(264, 1),
(265, 1),
(266, 1),
(267, 1),
(268, 1),
(269, 1),
(270, 1),
(271, 1),
(272, 1),
(273, 1),
(274, 1),
(275, 1),
(276, 1),
(281, 1),
(282, 1),
(283, 1),
(284, 1),
(285, 1),
(286, 1),
(287, 1),
(288, 1),
(289, 1),
(290, 1),
(291, 1),
(292, 1),
(293, 1),
(294, 1),
(295, 1),
(296, 1),
(297, 1),
(298, 1),
(299, 1),
(300, 1),
(301, 1),
(302, 1),
(303, 1),
(304, 1),
(305, 1),
(306, 1),
(307, 1),
(308, 1),
(309, 1),
(310, 1),
(311, 1),
(312, 1),
(313, 1),
(314, 1),
(315, 1),
(316, 1),
(317, 1),
(318, 1),
(319, 1),
(320, 1),
(321, 1),
(322, 1),
(323, 1),
(324, 1),
(325, 1),
(326, 1),
(327, 1),
(328, 1),
(329, 1),
(330, 1),
(331, 1),
(332, 1),
(333, 1),
(334, 1),
(335, 1),
(336, 1),
(337, 1),
(338, 1),
(339, 1),
(340, 1),
(341, 1),
(342, 1),
(343, 1),
(344, 1),
(345, 1),
(346, 1),
(347, 1),
(348, 1),
(349, 1),
(350, 1),
(351, 1),
(352, 1),
(353, 1),
(354, 1),
(355, 1),
(356, 1),
(357, 1),
(358, 1),
(359, 1),
(360, 1),
(361, 1),
(362, 1),
(363, 1),
(364, 1),
(365, 1),
(366, 1),
(367, 1),
(368, 1),
(369, 1),
(370, 1),
(371, 1),
(372, 1),
(373, 1),
(374, 1),
(375, 1),
(376, 1),
(377, 1),
(378, 1),
(379, 1),
(380, 1),
(381, 1),
(382, 1),
(383, 1),
(384, 1),
(385, 1);

-- --------------------------------------------------------

--
-- Table structure for table `scheduled_notifications`
--

CREATE TABLE `scheduled_notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `target_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `send_at` datetime NOT NULL,
  `sent_at` datetime DEFAULT NULL,
  `rescheduled_at` datetime DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` int(10) UNSIGNED NOT NULL,
  `osncode_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schstart` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schend` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schstart2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schend2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateofbirth` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `faculty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qualification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fathername` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mothername` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maritalstatus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workexperience` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eployid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salarygrade` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acctitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accnum` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bankname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bankbranch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resumedoc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `user_id`, `role`, `fullname`, `dateofbirth`, `address`, `faculty`, `gender`, `religion`, `qualification`, `number`, `fathername`, `mothername`, `maritalstatus`, `workexperience`, `eployid`, `salarygrade`, `salary`, `acctitle`, `accnum`, `bankname`, `bankbranch`, `resumedoc`, `created_at`, `updated_at`) VALUES
(1, '5', 'Lecturer', 'Ahmed Ahia Ogua', '2021-11-22', 'P. o. box ts 367', 'Others', 'Male', 'Moslem', 'Bsc in information mngmrnt', '0272185091', 'ogua', 'Ahmed Mason', 'Married', 'Bsc in information mngmrnt', 'LEC1019330', 'Grade 2', '2000', NULL, NULL, NULL, NULL, 'Resume/jmXifWkqXJlWlKVhgd2NLj78yUBSLtqPTKvGjorC.pdf', NULL, NULL),
(2, '15', 'Front_desk_help', 'Toure Domingo', '2021-11-25', 'P. o. box ts 367', 'Help Desk', 'Male', 'Moslem', 'bsc science', '0272185090', 'Junior Lamere', 'Ahmed Mason', 'Married', 'bsc science', 'OSMS1037870', 'Grade 1', '1000', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staffdocs`
--

CREATE TABLE `staffdocs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staffleaves`
--

CREATE TABLE `staffleaves` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staffid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applydate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leavedate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leavetype` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `days` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staffmeetings`
--

CREATE TABLE `staffmeetings` (
  `id` int(10) UNSIGNED NOT NULL,
  `zoomid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `starttime` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `join_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `studentinfos`
--

CREATE TABLE `studentinfos` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateofbirth` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `denomination` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `placeofbirth` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hometown` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disability` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maritalstutus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entrylevel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `programme` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currentlevel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `indexnumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gurdianname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relationship` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occupation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employed` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admitted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `completion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `academic_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `progcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `completstatus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `studentinfos`
--

INSERT INTO `studentinfos` (`id`, `user_id`, `fullname`, `gender`, `dateofbirth`, `religion`, `denomination`, `placeofbirth`, `nationality`, `hometown`, `region`, `disability`, `postcode`, `address`, `email`, `phone`, `maritalstutus`, `entrylevel`, `session`, `programme`, `type`, `currentlevel`, `indexnumber`, `gurdianname`, `relationship`, `occupation`, `mobile`, `employed`, `status`, `admitted`, `completion`, `academic_year`, `created_at`, `updated_at`, `progcode`, `duration`, `completstatus`, `title`) VALUES
(2, 3, 'Ahia  Ahmed', 'Male', '2021-11-08', 'Muslem', 'Christain', 'Teshie', 'Ghanaian', 'Teshie', 'Greater Accra', 'No', '00233', 'P. o. box ts 367', 'ogua@yahoo.com', '0272185090', 'Single', 'Level 100', 'Morning Session', 'Bachelor of Science  in Information Technology Management', 'Degree Programme', 'Level 100', 'GES11112', 'Ahmed Amartei Kudjoe', 'Mother', 'Trader', '0272185090', 'No', '1', 'AUG,2021', 'AUG,2025', '2020-2021', NULL, NULL, 'BITM', '1', 'Graduating', 'Mr'),
(14, 20, 'Zibit Amartey Junior', 'Male', '2021-11-17', 'Accra', 'Accra', 'Accra', 'Accra', 'Accra', 'Accra', 'No', '00233', 'P. o. box ts 367', 'junior@yahoo.com', '+233272185090', 'Single', 'Level 100', 'Morning Session', 'Bachelor of Science in Information Technology Management', 'Degree Programme', 'Level 100', 'GES43740', 'Abigai Agoa', 'Mother', 'Trader', '0208129151', 'No', '1', 'AUG,2021', 'AUG,2025', '2020-2021', NULL, NULL, 'BITM', '4', NULL, 'Mr'),
(15, 21, 'Mamoud Billal Kidija', 'Male', '2021-12-03', 'Christian', 'Christian', 'Tesg=hie', 'Ghanaian', 'Accra', '', 'No', '00233', 'minor stree\r\nSuit', 'test@gmail.com', '0272185091', 'Single', 'Level 200', 'Morning Session', 'Bachelor of Science in Information Technology Management ', ' Degree Programme', 'Level 200', 'GES26801', 'Akua Mason', 'MOTHER', 'STUDENT', '0272185091', 'Yes', '1', 'AUG,2021', 'AUG2024', '2020-2021', NULL, NULL, ' BITM ', '4', NULL, 'Mr'),
(16, 22, 'Toure Ogua', 'Male', '2021-12-02', 'Moslem', 'Christian', 'Teshie', 'Ghanaian', 'Accra', '', 'No', '00233', 'P. o. box ts 367', 'ogua@ogua.com', '0272185091', 'Single', 'Level 200', 'Morning Session', 'Bachelor of Arts in Public Relations Management ', ' Degree Programme', 'Level 200', 'GES79152', 'AHMED', 'MOTHER', 'STUDENT', '+233272185090', 'Yes', '1', 'AUG,2021', 'AUG2024', '2020-2021', NULL, NULL, ' BAPR ', ' 4 ', NULL, 'Mr'),
(17, 23, 'Abigai Agoe Adjie', 'Female', '2021-12-09', 'Moslem', 'Christian', 'Tesg=hie', 'Ghanaian', 'Accra', '', 'Disabled', '00233', 'P. o. box ts 367', 'abi@gmail.com', '0272185091', 'Married', 'Level 300', 'Morning Session', 'Diploma in Accounting ', ' Diploma Programme', 'Level 300', 'GES54920', 'Ahmed Ahia', 'MOTHER', 'STUDENT', '0272185090', 'Yes', '1', 'AUG,2021', 'AUG2024', '2020-2021', NULL, NULL, ' DIAA ', ' 3 ', NULL, 'Mrs');

-- --------------------------------------------------------

--
-- Table structure for table `student_attendances`
--

CREATE TABLE `student_attendances` (
  `id` int(10) UNSIGNED NOT NULL,
  `indexnumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attendance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `month` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `day` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `semester` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `academicyear` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coursecode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lectid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lecname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_attendances`
--

INSERT INTO `student_attendances` (`id`, `indexnumber`, `attendance`, `note`, `year`, `month`, `day`, `date`, `semester`, `academicyear`, `coursecode`, `session`, `lectid`, `lecname`, `created_at`, `updated_at`) VALUES
(8, 'GES11112', 'P', '', '2022', '02', '01', '2022-02-01', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(9, 'GES11112', 'P', '', '2022', '02', '02', '2022-02-02', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(10, 'GES11112', 'P', '', '2022', '02', '04', '2022-02-04', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(11, 'GES11112', 'P', '', '2022', '02', '07', '2022-02-07', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(12, 'GES11112', 'P', '', '2022', '02', '10', '2022-02-10', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(13, 'GES11112', 'P', '', '2022', '02', '12', '2022-02-12', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(14, 'GES11112', 'P', '', '2022', '02', '14', '2022-02-14', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(15, 'GES11112', 'P', '', '2022', '02', '15', '2022-02-15', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(16, 'GES11112', 'P', '', '2022', '02', '17', '2022-02-17', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(17, 'GES11112', 'P', '', '2022', '02', '19', '2022-02-19', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(18, 'GES11112', 'P', '', '2022', '02', '22', '2022-02-22', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(19, 'GES11112', 'P', '', '2022', '02', '23', '2022-02-23', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(20, 'GES11112', 'P', '', '2022', '02', '24', '2022-02-24', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(21, 'GES11112', 'P', '', '2022', '02', '25', '2022-02-25', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(22, 'GES43740', 'P', '', '2022', '02', '03', '2022-02-03', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(23, 'GES43740', 'P', '', '2022', '02', '05', '2022-02-05', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(24, 'GES43740', 'P', '', '2022', '02', '06', '2022-02-06', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(25, 'GES43740', 'P', '', '2022', '02', '07', '2022-02-07', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(26, 'GES43740', 'P', '', '2022', '02', '08', '2022-02-08', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(27, 'GES43740', 'P', '', '2022', '02', '09', '2022-02-09', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(28, 'GES43740', 'P', '', '2022', '02', '11', '2022-02-11', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(29, 'GES43740', 'P', '', '2022', '02', '13', '2022-02-13', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(30, 'GES43740', 'P', '', '2022', '02', '15', '2022-02-15', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(31, 'GES43740', 'P', '', '2022', '02', '16', '2022-02-16', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(32, 'GES43740', 'P', '', '2022', '02', '17', '2022-02-17', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(33, 'GES43740', 'P', '', '2022', '02', '19', '2022-02-19', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(34, 'GES43740', 'P', '', '2022', '02', '21', '2022-02-21', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(35, 'GES43740', 'P', '', '2022', '02', '23', '2022-02-23', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(36, 'GES43740', 'P', '', '2022', '02', '24', '2022-02-24', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(37, 'GES43740', 'P', '', '2022', '02', '25', '2022-02-25', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(38, 'GES11112', 'P', '', '2022', '01', '02', '2022-01-02', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(39, 'GES11112', 'P', '', '2022', '01', '04', '2022-01-04', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(40, 'GES11112', 'P', '', '2022', '01', '05', '2022-01-05', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(41, 'GES11112', 'P', '', '2022', '01', '12', '2022-01-12', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(42, 'GES11112', 'P', '', '2022', '01', '16', '2022-01-16', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(43, 'GES43740', 'P', '', '2022', '01', '05', '2022-01-05', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(44, 'GES43740', 'P', '', '2022', '01', '06', '2022-01-06', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(45, 'GES43740', 'P', '', '2022', '01', '10', '2022-01-10', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(46, 'GES43740', 'P', '', '2022', '01', '13', '2022-01-13', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(47, 'GES43740', 'P', '', '2022', '01', '14', '2022-01-14', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL),
(48, 'GES43740', 'P', '', '2022', '01', '17', '2022-01-17', 'First Semester', '2020-2021', 'BGEC100', 'Morning Session', '1', 'Ahmed Ahia', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_menus`
--

CREATE TABLE `sub_menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_menu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_menus`
--

INSERT INTO `sub_menus` (`id`, `menu_id`, `sub_menu`, `created_at`, `updated_at`, `order`) VALUES
(2, '1', 'Admission Enquiry', NULL, NULL, 1),
(3, '1', 'Visitors Book', NULL, NULL, 2),
(4, '1', 'Phone call log', NULL, NULL, 3),
(5, '1', 'Postal Dispatch', NULL, NULL, 4),
(6, '1', 'Postal receive', NULL, NULL, 5),
(7, '2', 'Add Academic Year', NULL, NULL, 1),
(8, '4', 'Create Event', NULL, NULL, 1),
(9, '4', 'All Event', NULL, NULL, 2),
(10, '5', 'Online Admissions', NULL, NULL, 1),
(11, '5', 'Level 100', NULL, NULL, 2),
(12, '5', 'Level 200', NULL, NULL, 3),
(13, '5', 'Level 300', NULL, NULL, 4),
(20, '6', 'Confirm Admissions', NULL, NULL, 1),
(21, '6', 'All Confirmed Admission', NULL, NULL, 2),
(22, '10', 'Course Registration', NULL, NULL, 1),
(23, '10', 'My results', NULL, NULL, 2),
(24, '10', 'Timetable', NULL, NULL, 3),
(25, '10', 'All Support Tickets', NULL, NULL, 4),
(26, '10', 'Create New Ticket', NULL, NULL, 5),
(27, '10', 'Online Polls', NULL, NULL, 6),
(28, '10', 'View Polls Results', NULL, NULL, 7),
(29, '11', 'Profile', NULL, NULL, 1),
(30, '11', 'Enter results', NULL, NULL, 2),
(31, '11', 'Timetable', NULL, NULL, 3),
(32, '11', 'Request Leave', NULL, NULL, 4),
(33, '11', 'LMS', NULL, NULL, 5),
(34, '7', 'Admission Doc', NULL, NULL, 1),
(35, '8', 'Revert Admission', NULL, NULL, 1),
(36, '9', 'Add Student', NULL, NULL, 1),
(37, '37', 'Mandatory Fees', NULL, NULL, 1),
(38, '37', 'Other Fees', NULL, NULL, 2),
(39, '37', 'Fee Mater', NULL, NULL, 3),
(40, '37', 'View Fees', NULL, NULL, 4),
(41, '37', 'Dispatch Fees', NULL, NULL, 5),
(42, '37', 'Transactions', NULL, NULL, 6),
(43, '37', 'Student', NULL, NULL, 7),
(44, '38', 'Add Staff', NULL, NULL, 1),
(45, '38', 'All Staff', NULL, NULL, 2),
(46, '38', 'Staff Attendance', NULL, NULL, 3),
(47, '38', 'Payroll', NULL, NULL, 4),
(48, '38', 'Request Leave', NULL, NULL, 5),
(49, '38', 'Approved Leave', NULL, NULL, 6),
(50, '38', 'Lecturer Rating', NULL, NULL, 7),
(51, '38', 'Disable Staff', NULL, NULL, 8),
(52, '28', 'Add Hall', NULL, NULL, 1),
(53, '29', 'Add Timetable', NULL, NULL, 1),
(54, '30', 'Generate Timetable', NULL, NULL, 1),
(55, '31', 'Upload Timetable', NULL, NULL, 1),
(56, '32', 'Group Student', NULL, NULL, 1),
(57, '32', 'View Grouping', NULL, NULL, 2),
(58, '33', 'Release Results', NULL, NULL, 1),
(59, '33', 'Cancel Results Session', NULL, NULL, 3),
(60, '33', 'Cancel Results Student', NULL, NULL, 2),
(61, '34', 'Add Polls', NULL, NULL, 1),
(62, '34', 'Manage Polls', NULL, NULL, 2),
(63, '34', 'Manage Candidate', NULL, NULL, 3),
(64, '34', 'Release Polls Results', NULL, NULL, 4),
(65, '34', 'Polls Results', NULL, NULL, 5),
(66, '34', 'Online Polls', NULL, NULL, 6),
(67, '34', 'View Polls Results', NULL, NULL, 7),
(68, '39', 'All Support Tickets', NULL, NULL, 1),
(69, '39', 'Create New Ticket', NULL, NULL, 2),
(70, '36', 'Send Nail', NULL, NULL, 1),
(71, '36', 'Send Sms', NULL, NULL, 2),
(72, '35', 'Schedule Meeting', NULL, NULL, 1),
(73, '35', 'Staff Meeting', NULL, NULL, 2),
(74, '41', 'Add Role', NULL, NULL, 1),
(75, '41', 'Force Logout', NULL, NULL, 2),
(81, '18', 'Graduated Students', NULL, NULL, 1),
(82, '19', 'Add Fine', NULL, NULL, 1),
(83, '19', 'Fine Student', NULL, NULL, 2),
(84, '20', 'Promote Student', NULL, NULL, 1),
(85, '20', 'Graduation List', NULL, NULL, 2),
(86, '21', 'Dismiss Student', NULL, NULL, 1),
(87, '21', 'Rusticate Student', NULL, NULL, 2),
(88, '21', 'Defer Student', NULL, NULL, 3),
(89, '13', 'All Students', NULL, NULL, 1),
(90, '14', 'Student Info Level 100', NULL, NULL, 1),
(91, '15', 'Student Info Level 200', NULL, NULL, 1),
(92, '16', 'Student Info Level 300', NULL, NULL, 1),
(93, '17', 'Student Info Level 400', NULL, NULL, 1),
(94, '22', 'Add programme', NULL, NULL, 1),
(95, '23', 'Add Faculty', NULL, NULL, 1),
(96, '24', 'Add Course Degree Level 100', NULL, NULL, 1),
(97, '24', 'Add Course Degree Level 200', NULL, NULL, 2),
(98, '24', 'Add Course Degree Level 300', NULL, NULL, 3),
(99, '24', 'Add Course Degree Level 400', NULL, NULL, 4),
(100, '24', 'Add Course Diploma Level 100', NULL, NULL, 5),
(101, '24', 'Add Course Diploma Level 200', NULL, NULL, 6),
(102, '25', 'All Degree Courses', NULL, NULL, 1),
(103, '26', 'All Diploma Courses', NULL, NULL, 1),
(104, '27', 'Programs and Courses', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `supportingdocs`
--

CREATE TABLE `supportingdocs` (
  `id` int(10) UNSIGNED NOT NULL,
  `osncode_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctype` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payable_id` bigint(20) UNSIGNED NOT NULL,
  `wallet_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('deposit','withdraw') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(64,0) NOT NULL,
  `confirmed` tinyint(1) NOT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `payable_type`, `payable_id`, `wallet_id`, `type`, `amount`, `confirmed`, `meta`, `uuid`, `created_at`, `updated_at`) VALUES
(1, 'App\\User', 3, 1, 'deposit', '2000', 1, '{\"Trantype\":\"WALLET TOPUP\\/DEPOSITE\",\"Reference\":\"DEPOSITE\"}', '30d2bbc0-5d25-49d9-9206-6d7bb45849bc', NULL, NULL),
(2, 'App\\User', 3, 1, 'withdraw', '-50', 1, '{\"Trantype\":\"Fees Payment\",\"Reference\":\"Hostel Refundable Deposit For Damages\",\"feecode\":\" OFEE104 \"}', '7fbe92a6-d079-480b-9899-88ed50418a95', NULL, NULL),
(3, 'App\\User', 3, 1, 'withdraw', '-900', 1, '{\"Trantype\":\"Fees Payment\",\"Reference\":\"Undergraduate Degree Morning Fee\",\"feecode\":\" FEE103\"}', '11fee34d-471d-4034-85bd-713e3e0adcbb', NULL, NULL),
(4, 'App\\User', 3, 2, 'deposit', '2000', 1, '{\"Trantype\":\"WALLET TOPUP\\/DEPOSITE\",\"Reference\":\"DEPOSITE\"}', '910881ea-cfbb-47e1-8196-19823cde7058', NULL, NULL),
(5, 'App\\User', 3, 2, 'withdraw', '-100', 1, '{\"Trantype\":\"Fees Payment\",\"Reference\":\"Undergraduate Degree Morning Fee\",\"feecode\":\" FEE103\"}', '07e245e0-1f91-47c3-9037-c346d661d925', NULL, NULL),
(6, 'App\\User', 3, 2, 'withdraw', '-1000', 1, '{\"Trantype\":\"Fees Payment\",\"Reference\":\"Undergraduate Degree Morning Fee\",\"feecode\":\" FEE103\"}', '15abb9a1-6110-4e84-8865-fd43f3d05d0c', NULL, NULL),
(7, 'App\\User', 3, 2, 'withdraw', '-40', 1, '{\"Trantype\":\"Fees Payment\",\"Reference\":\"Hostel Refundable Deposit For Damages\",\"feecode\":\" OFEE104 \"}', '89d5b321-8034-4ecf-97e9-ad1a1dfcec30', NULL, NULL),
(8, 'App\\User', 3, 2, 'withdraw', '-10', 1, '{\"Trantype\":\"Fees Payment\",\"Reference\":\"Hostel Refundable Deposit For Damages\",\"feecode\":\" OFEE104 \"}', 'c12a0ab8-a72b-4dc1-8f3c-dfe2a2d0f2ef', NULL, NULL),
(9, 'App\\User', 3, 2, 'withdraw', '-50', 1, '{\"Trantype\":\"Fees Payment\",\"Reference\":\"Late Registration Penalty\",\"feecode\":\"OFEE100\"}', '1a0d7ede-91d7-4c4f-8f3d-daa3d9995c7c', NULL, NULL),
(10, 'App\\User', 3, 2, 'deposit', '20000', 1, '{\"Trantype\":\"WALLET TOPUP\\/DEPOSITE\",\"Reference\":\"DEPOSITE\"}', '0653cb48-6d57-42b4-be99-e45d2575e33e', NULL, NULL),
(11, 'App\\User', 3, 2, 'deposit', '100', 1, '{\"Trantype\":\"WALLET TOPUP\\/DEPOSITE\",\"Reference\":\"DEPOSITE\"}', 'b4023172-179f-488f-bc0d-0d726c13ad48', NULL, NULL),
(12, 'App\\User', 3, 2, 'deposit', '200', 1, '{\"Trantype\":\"WALLET TOPUP\\/DEPOSITE\",\"Reference\":\"DEPOSITE\"}', '8cc21130-3ad0-4539-b512-b3ed61afcd89', NULL, NULL),
(13, 'App\\User', 3, 2, 'deposit', '200', 1, '{\"Trantype\":\"WALLET TOPUP\\/DEPOSITE\",\"Reference\":\"DEPOSITE\"}', '7d0d5ecf-0894-4789-9981-04c72f35b7ab', NULL, NULL),
(14, 'App\\User', 3, 2, 'deposit', '12', 1, '{\"Trantype\":\"WALLET TOPUP\\/DEPOSITE\",\"Reference\":\"DEPOSITE\"}', 'df792dc5-23f9-4717-ae99-28304c071f26', NULL, NULL),
(15, 'App\\User', 3, 2, 'deposit', '100', 1, '{\"Trantype\":\"WALLET TOPUP\\/DEPOSITE\",\"Reference\":\"DEPOSITE\"}', '44199a1c-5529-4c02-b8bb-19d71a403d44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_id` bigint(20) UNSIGNED NOT NULL,
  `to_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('exchange','transfer','paid','refund','gift') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'transfer',
  `status_last` enum('exchange','transfer','paid','refund','gift') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deposit_id` bigint(20) UNSIGNED NOT NULL,
  `withdraw_id` bigint(20) UNSIGNED NOT NULL,
  `discount` decimal(64,0) NOT NULL DEFAULT 0,
  `fee` decimal(64,0) NOT NULL DEFAULT 0,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uploadedtimetables`
--

CREATE TABLE `uploadedtimetables` (
  `id` int(10) UNSIGNED NOT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academicyear` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `uploadedtimetables`
--

INSERT INTO `uploadedtimetables` (`id`, `level`, `session`, `type`, `semester`, `academicyear`, `url`, `created_at`, `updated_at`) VALUES
(1, 'Level 100', 'Morning Session', 'DEGREE', 'Second Semester', '2020-2021', 'Timetable/Zqh0Iy0aJmUf9APgB3w6cZGaDj153e3wAV8rMK1V.pdf', NULL, NULL),
(2, 'Level 100', 'Morning Session', 'DEGREE', 'Second Semester', '2020-2021', 'Timetable/5CzBJFBwg0snn6TqH0VKB7rWAuqLnUJ0lFI2Q7hP.pdf', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT 0,
  `dark_mode` tinyint(1) NOT NULL DEFAULT 0,
  `messenger_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#2180f3',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar.png',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `indexnumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `force_logout` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `pro_pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ticketit_admin` tinyint(1) NOT NULL DEFAULT 0,
  `ticketit_agent` tinyint(1) NOT NULL DEFAULT 0,
  `regemail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `active_status`, `dark_mode`, `messenger_color`, `avatar`, `email_verified_at`, `indexnumber`, `force_logout`, `is_active`, `pro_pic`, `password`, `remember_token`, `created_at`, `updated_at`, `ticketit_admin`, `ticketit_agent`, `regemail`) VALUES
(1, 'Ahmed Ahia', 'admin@admin.com', 0, 0, '#2180f3', 'avatar.png', NULL, 'ADMIN', '0', '1', 'profileimage/Ft0yakeIOlVJNTI0d6CtT0l9uIMDDtjeJBZZ1Xca.jpeg', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, NULL, 0, 0, 'admin@admin.com'),
(3, 'Ahia  Ahmed', 'ogua@yahoo.com', 0, 0, '#2180f3', 'avatar.png', NULL, 'GES11112', '0', '1', 'profile_img/PWtOajo7IlrFa7pA9EVozIfsT0qi3JISw1T4PO4m.jpeg', '$2y$10$2z65xmpdEl8Y72mu/pws8erS33hr3ZHoOTk8KsYXWO5ytVIct4QtW', NULL, NULL, NULL, 0, 0, 'admin@admin.com'),
(5, 'Ahmed Ahia Ogua', 'ahia@yahoo.com', 0, 0, '#2180f3', 'avatar.png', NULL, 'LEC1019330', '0', '0', 'profileimage/Ft0yakeIOlVJNTI0d6CtT0l9uIMDDtjeJBZZ1Xca.jpeg', '$2y$10$bFsPiTwDw1KD1suMZ1yVpux5xKh77Z5/XEEBn30v/u5o1n/XIGnba', NULL, NULL, NULL, 0, 0, 'ahia@yahoo.com'),
(15, 'Toure Domingo', 'lec1037870@osms.edu.com', 0, 0, '#2180f3', 'avatar.png', NULL, 'OSMS1037870', '0', '0', 'profileimage/JhQ9mV1U7n6TCZTk8JGLMwsLmDTPT2rO9EK6CRhr.jpg', '$2y$10$n.HLsm5wzjBCHoU4HgKbpOxfzDS8V/sVwNOEbWGHYhP5NgQcuDbFW', NULL, NULL, NULL, 0, 0, 'domingo@gmail.com'),
(20, 'Zibit Amartey Junior', 'ges43740@osms.edu.com', 0, 0, '#2180f3', 'avatar.png', NULL, 'GES43740', '0', '0', 'profile_img/HxrrnpLAlECxtNWVxpJ6nzQSuUQTPcHR2Nw91mme.jpeg', '$2y$10$bKu5coHUToNvHIk.cGmfQ.Gx54pepqipJxoJ66o5TcJBXlVhEJmeK', NULL, NULL, NULL, 0, 0, 'junior@yahoo.com'),
(21, 'Mamoud Billal Kidija', 'GES26801@osms.edu.com', 0, 0, '#2180f3', 'avatar.png', NULL, 'GES26801', '0', '0', 'profileimage/0t4wBgXpzGr0UyXQC8p1Yp2T9zMzyRUoYJQIhnWs.jpg', '$2y$10$jfxJ2eG3FRW6hFTPUTiIW.eD40R0BzMeiGft5JF.hRI/mKVnGqDoe', NULL, NULL, NULL, 0, 0, 'test@gmail.com'),
(22, 'Toure Ogua', 'GES79152@osms.edu.com', 0, 0, '#2180f3', 'avatar.png', NULL, 'GES79152', '0', '0', 'profileimage/APIU2K96ftbfXqlCdQ7tYkt3P8SSSUjvCdOnj9PZ.jpg', '$2y$10$UPYTASs9S2hqhBUBexJuDe99YcfYcRAhDBT3KprxXMokGengVtzLW', NULL, NULL, NULL, 0, 0, 'ogua@ogua.com'),
(23, 'Abigai Agoe Adjie', 'GES54920@osms.edu.com', 0, 0, '#2180f3', 'avatar.png', NULL, 'GES54920', '0', '0', 'profileimage/I0gmRP8H7tFSgGIMFHxjfJPU7jBurHrNN1fDCDuz.jpg', '$2y$10$aUu7kblrlHgk3y2iHPFrZ.MkDsdnyNGS3u7nF16iavDvPmDih/gUu', NULL, NULL, NULL, 0, 0, 'abi@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `holder_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holder_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` decimal(64,0) NOT NULL DEFAULT 0,
  `decimal_places` smallint(6) NOT NULL DEFAULT 2,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `holder_type`, `holder_id`, `name`, `slug`, `description`, `balance`, `decimal_places`, `created_at`, `updated_at`) VALUES
(1, 'App\\User', 2, 'Default Wallet', 'default', NULL, '1050', 2, NULL, NULL),
(2, 'App\\User', 3, 'Default Wallet', 'default', NULL, '21412', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wallettops`
--

CREATE TABLE `wallettops` (
  `id` int(10) UNSIGNED NOT NULL,
  `tr_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `indexnumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'uppaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `websockets_statistics_entries`
--

CREATE TABLE `websockets_statistics_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peak_connection_count` int(11) NOT NULL,
  `websocket_message_count` int(11) NOT NULL,
  `api_message_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zoomwebs`
--

CREATE TABLE `zoomwebs` (
  `id` int(10) UNSIGNED NOT NULL,
  `zoomid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lec_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lec_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `starttime` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `programme` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cousers` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `join_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academicyear` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academicyears`
--
ALTER TABLE `academicyears`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_log_log_name_index` (`log_name`),
  ADD KEY `subject` (`subject_id`,`subject_type`),
  ADD KEY `causer` (`causer_id`,`causer_type`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendamces`
--
ALTER TABLE `attendamces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audits`
--
ALTER TABLE `audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audits_auditable_type_auditable_id_index` (`auditable_type`,`auditable_id`),
  ADD KEY `audits_user_id_user_type_index` (`user_id`,`user_type`);

--
-- Indexes for table `coureregistrations`
--
ALTER TABLE `coureregistrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `language_lines`
--
ALTER TABLE `language_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_lines_group_index` (`group`);

--
-- Indexes for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menupermissions`
--
ALTER TABLE `menupermissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `programmecourses`
--
ALTER TABLE `programmecourses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `programmes`
--
ALTER TABLE `programmes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `programmes_code_unique` (`code`);

--
-- Indexes for table `regacademicyears`
--
ALTER TABLE `regacademicyears`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resultsreleases`
--
ALTER TABLE `resultsreleases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `scheduled_notifications`
--
ALTER TABLE `scheduled_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staffdocs`
--
ALTER TABLE `staffdocs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staffleaves`
--
ALTER TABLE `staffleaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staffmeetings`
--
ALTER TABLE `staffmeetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentinfos`
--
ALTER TABLE `studentinfos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_attendances`
--
ALTER TABLE `student_attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_menus`
--
ALTER TABLE `sub_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supportingdocs`
--
ALTER TABLE `supportingdocs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_uuid_unique` (`uuid`),
  ADD KEY `transactions_payable_type_payable_id_index` (`payable_type`,`payable_id`),
  ADD KEY `payable_type_ind` (`payable_type`,`payable_id`,`type`),
  ADD KEY `payable_confirmed_ind` (`payable_type`,`payable_id`,`confirmed`),
  ADD KEY `payable_type_confirmed_ind` (`payable_type`,`payable_id`,`type`,`confirmed`),
  ADD KEY `transactions_type_index` (`type`),
  ADD KEY `transactions_wallet_id_foreign` (`wallet_id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transfers_uuid_unique` (`uuid`),
  ADD KEY `transfers_from_type_from_id_index` (`from_type`,`from_id`),
  ADD KEY `transfers_to_type_to_id_index` (`to_type`,`to_id`),
  ADD KEY `transfers_deposit_id_foreign` (`deposit_id`),
  ADD KEY `transfers_withdraw_id_foreign` (`withdraw_id`);

--
-- Indexes for table `uploadedtimetables`
--
ALTER TABLE `uploadedtimetables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_indexnumber_unique` (`indexnumber`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wallets_holder_type_holder_id_slug_unique` (`holder_type`,`holder_id`,`slug`),
  ADD KEY `wallets_holder_type_holder_id_index` (`holder_type`,`holder_id`),
  ADD KEY `wallets_slug_index` (`slug`);

--
-- Indexes for table `wallettops`
--
ALTER TABLE `wallettops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zoomwebs`
--
ALTER TABLE `zoomwebs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academicyears`
--
ALTER TABLE `academicyears`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendamces`
--
ALTER TABLE `attendamces`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audits`
--
ALTER TABLE `audits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coureregistrations`
--
ALTER TABLE `coureregistrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `language_lines`
--
ALTER TABLE `language_lines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lecturers`
--
ALTER TABLE `lecturers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menupermissions`
--
ALTER TABLE `menupermissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=386;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=386;

--
-- AUTO_INCREMENT for table `programmecourses`
--
ALTER TABLE `programmecourses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `programmes`
--
ALTER TABLE `programmes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `regacademicyears`
--
ALTER TABLE `regacademicyears`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resultsreleases`
--
ALTER TABLE `resultsreleases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `scheduled_notifications`
--
ALTER TABLE `scheduled_notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staffdocs`
--
ALTER TABLE `staffdocs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staffleaves`
--
ALTER TABLE `staffleaves`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staffmeetings`
--
ALTER TABLE `staffmeetings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `studentinfos`
--
ALTER TABLE `studentinfos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `student_attendances`
--
ALTER TABLE `student_attendances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `sub_menus`
--
ALTER TABLE `sub_menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `supportingdocs`
--
ALTER TABLE `supportingdocs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uploadedtimetables`
--
ALTER TABLE `uploadedtimetables`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wallettops`
--
ALTER TABLE `wallettops`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zoomwebs`
--
ALTER TABLE `zoomwebs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `transfers_deposit_id_foreign` FOREIGN KEY (`deposit_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfers_withdraw_id_foreign` FOREIGN KEY (`withdraw_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
