-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 04, 2021 at 02:53 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `isdory`
--

-- --------------------------------------------------------

--
-- Table structure for table `aboutuses`
--

CREATE TABLE `aboutuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `aboutuses`
--

INSERT INTO `aboutuses` (`id`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum odio id voluptatibus incidunt cum? Atque quasi eum debitis optio ab. Esse itaque officiis tempora possimus odio rerum aperiam ratione, sunt. Lorem ipsum dolor sit amet, consectetur adipisicing elit sunt.</p><p>Lorem ipsum dolor sit amet, consectetur adipisici<strong>ng elit. Laborum odio id voluptatibus incidunt cum? Atque quasi eum debitis optio ab. Esse itaque officiis tempora possimus odio rerum aperiam ratione, sunt. Lorem ipsum dolor sit amet, consectetur adipisicing elit sunt.</strong></p><p><strong>Lorem ipsum dolor sit amet, consectetur adipisicin</strong>g elit. Laborum odio id voluptatibus incidunt cum? Atque quasi eum debitis optio ab. Esse itaque officiis tempora possimus odio rerum aperiam ratione, sunt. Lorem ipsum dolor sit amet, consectetur adipisicing elit sunt.</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum odio id voluptatibus incid<strong>unt cum? Atque quasi eum debitis optio ab. Esse itaque officiis tempora possimus odio rerum aperiam ratione, sunt. Lorem ipsum dolor sit amet, consectetur adipisicing elit sunt.</strong></p><p><strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum odio id voluptatibus incidunt cum? Atque quasi eum debitis optio ab. Esse itaque officiis tempora possimus odio rerum aperiam ratione, sunt. Lorem ipsum dolor sit amet, consectetur adipisicing elit sunt.</strong></p><p><strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum odio id voluptatibus incidunt cum? Atque quasi eum debitis optio ab. Esse itaque officiis tempora possimus odio rerum aperiam ratione, sunt. Lorem ipsum dolor sit amet, consectetur adipisicing elit sunt.</strong></p><p><strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum odio id voluptatibus incidunt c</strong>um? Atque quasi eum debitis optio ab. Esse itaque officiis tempora possimus odio rerum aperiam ratione, sunt. Lorem ipsum dolor sit amet, consectetur adipisicing elit sunt.</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum odio id voluptatibus incidunt cum? Atque quasi eum debitis optio ab. Esse itaque officiis tempora possimus odio rerum aperiam ratione, sunt. Lorem ipsum dolor sit amet, consectetur adipisicing elit sunt.</p>', '2021-08-29 17:46:55', '2021-08-29 17:46:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`, `created_by_id`) VALUES
(1, 'Security', '2021-08-28 03:56:57', '2021-08-28 03:56:57', NULL, NULL),
(2, 'Lift', '2021-08-28 03:57:06', '2021-08-28 03:57:06', NULL, NULL),
(3, 'Swimming fool', '2021-08-28 03:57:17', '2021-08-28 03:57:17', NULL, NULL),
(4, 'Play Area', '2021-08-28 03:57:31', '2021-08-28 03:57:31', NULL, NULL),
(5, 'football Court', '2021-08-28 03:59:46', '2021-08-28 03:59:46', NULL, NULL),
(6, 'Cricket Court', '2021-08-28 03:59:56', '2021-08-28 03:59:56', NULL, NULL),
(7, 'Garden', '2021-08-28 04:00:53', '2021-08-28 04:00:53', NULL, NULL),
(8, 'Unfurnished', '2021-08-28 04:01:13', '2021-08-28 04:01:13', NULL, NULL),
(9, '2 Car Parking', '2021-08-28 04:01:34', '2021-08-28 04:01:34', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `amenity_property`
--

CREATE TABLE `amenity_property` (
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `amenity_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `amenity_property`
--

INSERT INTO `amenity_property` (`property_id`, `amenity_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(6, 1),
(6, 5),
(6, 6),
(6, 7),
(6, 8),
(6, 9),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `host` varchar(46) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `description`, `subject_id`, `subject_type`, `user_id`, `properties`, `host`, `created_at`, `updated_at`) VALUES
(1, 'audit:created', 1, 'App\\Models\\Property#1', 1, '{\"property_title\":\"Tempora repellendus\",\"property_description\":\"<p>Laxury Home For Sale odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atcorrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum <strong>fuga<\\/strong>.<\\/p><p>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoraliz the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble thena bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain.<\\/p>\",\"type_id\":\"1\",\"rooms\":\"12\",\"property_price\":\"600\",\"per\":\"month\",\"google_map_location\":\"https:\\/\\/www.google.com\\/maps\\/embed?pb=!1m18!1m12!1m3!1d7977.51714436408!2d36.92382621899715!3d-1.3206022087286546!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f133a0cbcc349%3A0x7b5f23df06449900!2sKenya%20Airports%20Authority!5e0!3m2!1sen!2ske!4v1630145501021!5m2!1sen!2ske\\\" width=\\\"600\\\" height=\\\"450\\\"\",\"year_built\":\"20-08-2021\",\"area\":\"86\",\"property_video\":\"https:\\/\\/www.youtube.com\\/watch?v=qSxyffSB7wA\",\"status\":\"1\",\"available\":\"1\",\"feature_property\":\"1\",\"location\":\"Juja Thika\",\"updated_at\":\"2021-08-28 11:10:46\",\"created_at\":\"2021-08-28 11:10:46\",\"id\":1,\"property_main_photo\":null,\"property_photos\":[],\"floor_plans\":null,\"media\":[]}', '127.0.0.1', '2021-08-28 08:10:46', '2021-08-28 08:10:46'),
(2, 'audit:updated', 2, 'App\\Models\\Property#2', 1, '{\"feature_property\":\"0\",\"updated_at\":\"2021-08-29 15:53:09\",\"id\":2,\"property_main_photo\":null,\"property_photos\":[],\"floor_plans\":null,\"media\":[]}', '127.0.0.1', '2021-08-29 12:53:09', '2021-08-29 12:53:09'),
(3, 'audit:updated', 6, 'App\\Models\\Property#6', 1, '{\"feature_property\":\"0\",\"updated_at\":\"2021-08-29 15:54:18\",\"type_id\":\"2\",\"id\":6,\"property_main_photo\":null,\"property_photos\":[],\"floor_plans\":null,\"media\":[]}', '127.0.0.1', '2021-08-29 12:54:18', '2021-08-29 12:54:18'),
(4, 'audit:updated', 5, 'App\\Models\\Property#5', 1, '{\"feature_property\":\"0\",\"updated_at\":\"2021-08-29 15:55:26\",\"id\":5,\"property_main_photo\":null,\"property_photos\":[],\"floor_plans\":null,\"media\":[]}', '127.0.0.1', '2021-08-29 12:55:26', '2021-08-29 12:55:26'),
(5, 'audit:created', 1, 'App\\Models\\PropoertyInquiry#1', 1, '{\"full_name\":\"Garrison Gilmore\",\"phone_number\":\"940\",\"email_address\":\"wono@mailinator.com\",\"property_id\":\"2\",\"message\":\"Ea voluptatibus eos\",\"updated_at\":\"2021-08-29 18:37:03\",\"created_at\":\"2021-08-29 18:37:03\",\"id\":1}', '127.0.0.1', '2021-08-29 15:37:03', '2021-08-29 15:37:03'),
(6, 'audit:created', 2, 'App\\Models\\PropoertyInquiry#2', 1, '{\"full_name\":\"Daria Mcknight\",\"phone_number\":\"698\",\"email_address\":\"mehex@mailinator.com\",\"property_id\":\"2\",\"message\":\"Impedit vel exercit\",\"updated_at\":\"2021-08-29 18:40:02\",\"created_at\":\"2021-08-29 18:40:02\",\"id\":2}', '127.0.0.1', '2021-08-29 15:40:02', '2021-08-29 15:40:02'),
(7, 'audit:created', 1, 'App\\Models\\PropertyReview#1', 1, '{\"ratings\":\"1\",\"full_name\":\"Gay England\",\"email\":\"tycaxakiti@mailinator.com\",\"property_id\":\"2\",\"review\":\"Pariatur Iste cumqu\",\"updated_at\":\"2021-08-29 20:02:41\",\"created_at\":\"2021-08-29 20:02:41\",\"id\":1,\"photos\":[],\"media\":[]}', '127.0.0.1', '2021-08-29 17:02:41', '2021-08-29 17:02:41'),
(8, 'audit:created', 2, 'App\\Models\\PropertyReview#2', 1, '{\"ratings\":\"4\",\"full_name\":\"Ulla Nolan\",\"email\":\"wurulyz@mailinator.com\",\"property_id\":\"5\",\"review\":\"Incididunt veniam d\",\"updated_at\":\"2021-08-29 20:03:11\",\"created_at\":\"2021-08-29 20:03:11\",\"id\":2,\"photos\":[],\"media\":[]}', '127.0.0.1', '2021-08-29 17:03:11', '2021-08-29 17:03:11'),
(9, 'audit:created', 3, 'App\\Models\\PropertyReview#3', 1, '{\"ratings\":\"2\",\"full_name\":\"Molly Wooten\",\"email\":\"hiqule@mailinator.com\",\"property_id\":\"5\",\"review\":\"Aspernatur quibusdam\",\"updated_at\":\"2021-08-29 20:17:55\",\"created_at\":\"2021-08-29 20:17:55\",\"id\":3,\"photos\":[],\"media\":[]}', '127.0.0.1', '2021-08-29 17:17:55', '2021-08-29 17:17:55'),
(10, 'audit:created', 4, 'App\\Models\\PropertyReview#4', 1, '{\"ratings\":\"5\",\"full_name\":\"Keefe Garcia\",\"email\":\"higabixu@mailinator.com\",\"property_id\":\"6\",\"review\":\"Optio in qui sunt\",\"updated_at\":\"2021-09-04 11:33:18\",\"created_at\":\"2021-09-04 11:33:18\",\"id\":4,\"photos\":[],\"media\":[]}', '127.0.0.1', '2021-09-04 08:33:18', '2021-09-04 08:33:18'),
(11, 'audit:created', 5, 'App\\Models\\PropertyReview#5', 1, '{\"ratings\":\"1\",\"full_name\":\"Veronica Diaz\",\"email\":\"gozyv@mailinator.com\",\"property_id\":\"6\",\"review\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta officia cumque aperiam ab aliquam perspiciatis magni tenetur amet maiores totam, ut dolor sunt aliquid necessitatibus, nobis quod nulla debitis ad recusandae. Eius sapiente perferendis maiores ut obcaecati doloremque voluptas sequi?\",\"updated_at\":\"2021-09-04 11:33:48\",\"created_at\":\"2021-09-04 11:33:48\",\"id\":5,\"photos\":[],\"media\":[]}', '127.0.0.1', '2021-09-04 08:33:48', '2021-09-04 08:33:48'),
(12, 'audit:created', 3, 'App\\Models\\PropoertyInquiry#3', 1, '{\"property_id\":\"6\",\"full_name\":\"Justin Cherry\",\"phone_number\":\"484\",\"email_address\":\"ryhekuvol@mailinator.com\",\"message\":\"Illo voluptatem ut v\",\"updated_at\":\"2021-09-04 11:48:39\",\"created_at\":\"2021-09-04 11:48:39\",\"id\":3}', '127.0.0.1', '2021-09-04 08:48:39', '2021-09-04 08:48:39'),
(13, 'audit:created', 4, 'App\\Models\\PropoertyInquiry#4', 1, '{\"property_id\":\"6\",\"full_name\":\"Mariko Gallegos\",\"phone_number\":\"2147483648\",\"email_address\":\"voqyjupa@mailinator.com\",\"message\":\"Exercitation exceptu\",\"updated_at\":\"2021-09-04 11:50:55\",\"created_at\":\"2021-09-04 11:50:55\",\"id\":4}', '127.0.0.1', '2021-09-04 08:50:55', '2021-09-04 08:50:55'),
(14, 'audit:created', 5, 'App\\Models\\PropoertyInquiry#5', 1, '{\"property_id\":\"6\",\"full_name\":\"Andrew Key\",\"phone_number\":\"0717255460\",\"email_address\":\"dyrohurog@mailinator.com\",\"message\":\"hii nyumba iko\",\"updated_at\":\"2021-09-04 11:51:14\",\"created_at\":\"2021-09-04 11:51:14\",\"id\":5}', '127.0.0.1', '2021-09-04 08:51:15', '2021-09-04 08:51:15');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `description`, `created_at`, `updated_at`, `deleted_at`, `created_by_id`) VALUES
(1, 'Explore The World', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p>', '2021-08-29 13:32:59', '2021-08-29 13:32:59', NULL, NULL),
(2, 'Explore The World', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p>', '2021-08-29 13:32:59', '2021-08-29 13:32:59', NULL, NULL),
(3, 'Explore The World', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p>', '2021-08-29 13:32:59', '2021-08-29 13:32:59', NULL, NULL),
(4, 'Explore The World', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, ea? Vitae pariatur ab amet iusto tempore neque a, deserunt eaque recusandae obcaecati eos atque delectus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi labore vel enim repellendus excepturi autem. Eligendi cum laboriosam exercitationem illum repudiandae quasi sint dicta consectetur porro fuga ea, perspiciatis aut!</p>', '2021-08-29 13:32:59', '2021-08-29 13:32:59', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`, `created_by_id`) VALUES
(1, 'For sale', '2021-08-28 08:03:08', '2021-08-28 08:03:08', NULL, NULL),
(2, 'For rent', '2021-08-28 08:03:14', '2021-08-28 08:03:14', NULL, NULL),
(3, 'For hire', '2021-08-28 08:03:19', '2021-08-28 08:03:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us_messages`
--

CREATE TABLE `contact_us_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crm_customers`
--

CREATE TABLE `crm_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skype` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crm_documents`
--

CREATE TABLE `crm_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crm_notes`
--

CREATE TABLE `crm_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crm_statuses`
--

CREATE TABLE `crm_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `crm_statuses`
--

INSERT INTO `crm_statuses` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`, `created_by_id`) VALUES
(1, 'Lead', '2021-08-08 17:14:06', '2021-08-08 17:14:06', NULL, NULL),
(2, 'Customer', '2021-08-08 17:14:06', '2021-08-08 17:14:06', NULL, NULL),
(3, 'Partner', '2021-08-08 17:14:06', '2021-08-08 17:14:06', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`custom_properties`)),
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`responsive_images`)),
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `model_type`, `model_id`, `uuid`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Property', 1, '338afd10-928c-4d09-8aaa-d6d950c657cd', 'property_main_photo', '612a19407af19_b-2', '612a19407af19_b-2.jpg', 'image/jpeg', 'public', 'public', 188775, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 1, '2021-08-28 08:10:47', '2021-08-28 08:10:47'),
(2, 'App\\Models\\Property', 1, 'c59ee0ae-cc4b-4fcb-8076-2721435ea646', 'property_photos', '612a198423f32_s-1', '612a198423f32_s-1.jpg', 'image/jpeg', 'public', 'public', 191429, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 2, '2021-08-28 08:10:47', '2021-08-28 08:10:47'),
(3, 'App\\Models\\Property', 1, 'b1062afc-0ced-484c-bfa6-2cd837e5062e', 'property_photos', '612a198432a5a_s-2', '612a198432a5a_s-2.jpg', 'image/jpeg', 'public', 'public', 135252, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 3, '2021-08-28 08:10:48', '2021-08-28 08:10:48'),
(4, 'App\\Models\\Property', 1, 'b7dd0e8e-9610-4483-a9dd-080673e05972', 'property_photos', '612a1984424f3_s-3', '612a1984424f3_s-3.jpg', 'image/jpeg', 'public', 'public', 207185, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 4, '2021-08-28 08:10:48', '2021-08-28 08:10:49'),
(5, 'App\\Models\\Property', 1, '7caad4fe-d66b-40e0-bee3-283ef73f5811', 'property_photos', '612a19846772e_s-4', '612a19846772e_s-4.jpg', 'image/jpeg', 'public', 'public', 253733, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 5, '2021-08-28 08:10:49', '2021-08-28 08:10:49'),
(6, 'App\\Models\\Property', 1, '524a6178-692b-4e92-86bb-f07548ad87f6', 'property_photos', '612a198477cca_s-5', '612a198477cca_s-5.jpg', 'image/jpeg', 'public', 'public', 260647, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 6, '2021-08-28 08:10:49', '2021-08-28 08:10:49'),
(7, 'App\\Models\\Property', 1, '47472fba-28f2-46f8-8722-462c7732ba2e', 'floor_plans', '612a19a8d8255_floor-plan-1', '612a19a8d8255_floor-plan-1.png', 'image/png', 'public', 'public', 54127, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 7, '2021-08-28 08:10:49', '2021-08-28 08:10:50'),
(8, 'App\\Models\\Property', 2, '73c0894c-557f-47c7-83d0-0c8b3cd7bc34', 'property_main_photo', '612bad3ea1de2_b-2 (1)', '612bad3ea1de2_b-2-(1).jpg', 'image/jpeg', 'public', 'public', 188775, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 8, '2021-08-29 12:53:10', '2021-08-29 12:53:10'),
(9, 'App\\Models\\Property', 2, 'c95477a0-919d-405d-b1a3-5e272444779f', 'property_photos', '612bad5381e40_s-1', '612bad5381e40_s-1.jpg', 'image/jpeg', 'public', 'public', 191429, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 9, '2021-08-29 12:53:10', '2021-08-29 12:53:11'),
(10, 'App\\Models\\Property', 2, '717a19f7-72b0-4002-92eb-b162b0915ee9', 'property_photos', '612bad538d8f0_s-2', '612bad538d8f0_s-2.jpg', 'image/jpeg', 'public', 'public', 135252, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 10, '2021-08-29 12:53:11', '2021-08-29 12:53:11'),
(11, 'App\\Models\\Property', 2, '5c0ee9f8-679f-47c6-862b-5e84e3e82ba8', 'property_photos', '612bad539ded5_s-3', '612bad539ded5_s-3.jpg', 'image/jpeg', 'public', 'public', 207185, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 11, '2021-08-29 12:53:11', '2021-08-29 12:53:11'),
(12, 'App\\Models\\Property', 2, 'ef213ac2-8a3c-47c2-b9d6-3eac51e6b181', 'property_photos', '612bad53ae91e_s-4', '612bad53ae91e_s-4.jpg', 'image/jpeg', 'public', 'public', 253733, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 12, '2021-08-29 12:53:12', '2021-08-29 12:53:12'),
(13, 'App\\Models\\Property', 2, 'b94714c3-ddcd-4605-89b9-78d37824f413', 'property_photos', '612bad53d7360_s-5', '612bad53d7360_s-5.jpg', 'image/jpeg', 'public', 'public', 260647, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 13, '2021-08-29 12:53:12', '2021-08-29 12:53:12'),
(14, 'App\\Models\\Property', 2, '2925ff2f-9ddf-405b-9434-5420b732dac1', 'floor_plans', '612bad5e36c8c_floor-plan-1', '612bad5e36c8c_floor-plan-1.png', 'image/png', 'public', 'public', 54127, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 14, '2021-08-29 12:53:12', '2021-08-29 12:53:13'),
(15, 'App\\Models\\Property', 6, '94853569-59ec-4a65-a78f-f3946f17d8a8', 'property_main_photo', '612bad7dbcb94_b-2 (1)', '612bad7dbcb94_b-2-(1).jpg', 'image/jpeg', 'public', 'public', 188775, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 15, '2021-08-29 12:54:19', '2021-08-29 12:54:19'),
(16, 'App\\Models\\Property', 6, 'c00a6d0b-6fbe-4374-8105-ef6c5211877a', 'property_photos', '612bad92e9a88_s-2', '612bad92e9a88_s-2.jpg', 'image/jpeg', 'public', 'public', 135252, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 16, '2021-08-29 12:54:19', '2021-08-29 12:54:19'),
(17, 'App\\Models\\Property', 6, '7d903e95-2976-400a-88e9-6daf29b3eb93', 'property_photos', '612bad9305a5d_s-1', '612bad9305a5d_s-1.jpg', 'image/jpeg', 'public', 'public', 191429, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 17, '2021-08-29 12:54:20', '2021-08-29 12:54:20'),
(18, 'App\\Models\\Property', 6, '149fe0c4-ab1a-41e7-8a3f-1489cd2d9440', 'property_photos', '612bad9316422_s-3', '612bad9316422_s-3.jpg', 'image/jpeg', 'public', 'public', 207185, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 18, '2021-08-29 12:54:20', '2021-08-29 12:54:20'),
(19, 'App\\Models\\Property', 6, '24efec71-dc88-4707-8982-6f344a4a9bab', 'property_photos', '612bad9335209_s-4', '612bad9335209_s-4.jpg', 'image/jpeg', 'public', 'public', 253733, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 19, '2021-08-29 12:54:20', '2021-08-29 12:54:21'),
(20, 'App\\Models\\Property', 6, 'a5ca42af-f307-4375-b841-9a32044125bc', 'property_photos', '612bad9340c33_s-5', '612bad9340c33_s-5.jpg', 'image/jpeg', 'public', 'public', 260647, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 20, '2021-08-29 12:54:21', '2021-08-29 12:54:21'),
(21, 'App\\Models\\Property', 6, '15bb5d2e-0463-4035-9950-d76497afc848', 'floor_plans', '612bada22907e_floor-plan-1', '612bada22907e_floor-plan-1.png', 'image/png', 'public', 'public', 54127, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 21, '2021-08-29 12:54:21', '2021-08-29 12:54:22'),
(22, 'App\\Models\\Property', 5, 'e633b2d5-cb6a-4ddd-a4e1-f09dfd98a305', 'property_main_photo', '612badc3deab6_b-2 (1)', '612badc3deab6_b-2-(1).jpg', 'image/jpeg', 'public', 'public', 188775, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 22, '2021-08-29 12:55:26', '2021-08-29 12:55:27'),
(23, 'App\\Models\\Property', 5, 'b7ac4317-0c51-43ad-8d30-d10521365456', 'property_photos', '612badd75909c_s-1', '612badd75909c_s-1.jpg', 'image/jpeg', 'public', 'public', 191429, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 23, '2021-08-29 12:55:27', '2021-08-29 12:55:28'),
(24, 'App\\Models\\Property', 5, '1db84c9f-a0d5-48ad-b883-d080de9ee0ef', 'property_photos', '612badd769456_s-2', '612badd769456_s-2.jpg', 'image/jpeg', 'public', 'public', 135252, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 24, '2021-08-29 12:55:28', '2021-08-29 12:55:28'),
(25, 'App\\Models\\Property', 5, '4cbd293c-39a6-421e-a945-a700b47ce0cb', 'property_photos', '612badd777dad_s-3', '612badd777dad_s-3.jpg', 'image/jpeg', 'public', 'public', 207185, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 25, '2021-08-29 12:55:28', '2021-08-29 12:55:29'),
(26, 'App\\Models\\Property', 5, '8715d28c-9a01-4103-af6c-05789190ad7b', 'property_photos', '612badd787965_s-4', '612badd787965_s-4.jpg', 'image/jpeg', 'public', 'public', 253733, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 26, '2021-08-29 12:55:29', '2021-08-29 12:55:29'),
(27, 'App\\Models\\Property', 5, 'a80d0106-0768-4fcf-b818-6964dfd604c0', 'property_photos', '612badd7a9870_s-5', '612badd7a9870_s-5.jpg', 'image/jpeg', 'public', 'public', 260647, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 27, '2021-08-29 12:55:29', '2021-08-29 12:55:29'),
(28, 'App\\Models\\User', 1, 'a8b49cfd-509b-4bcc-b403-34037145b6fa', 'avatar', '612bb3994a3d4_65366942', '612bb3994a3d4_65366942.jpeg', 'image/jpeg', 'public', 'public', 13152, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 28, '2021-08-29 13:19:42', '2021-08-29 13:19:42'),
(29, 'App\\Models\\Blog', 1, '7e520106-f16f-40cd-b853-0ec208ab8f16', 'photo', '612bb6b9ba75f_b-1', '612bb6b9ba75f_b-1.jpg', 'image/jpeg', 'public', 'public', 84426, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 29, '2021-08-29 13:32:59', '2021-08-29 13:32:59'),
(30, 'App\\Models\\Blog', 2, '59296558-c421-41c3-a5ad-3ba1ff37010a', 'photo', '612bb6e109125_b-1', '612bb6e109125_b-1.jpg', 'image/jpeg', 'public', 'public', 84426, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 30, '2021-08-29 13:33:38', '2021-08-29 13:33:39'),
(31, 'App\\Models\\Blog', 3, 'd469e64c-e8f7-46bb-b688-c63859fda5cd', 'photo', '612bb6e7f3ba5_b-1', '612bb6e7f3ba5_b-1.jpg', 'image/jpeg', 'public', 'public', 84426, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 31, '2021-08-29 13:33:45', '2021-08-29 13:33:46'),
(32, 'App\\Models\\Blog', 4, '5583cfad-0dc8-4ef6-bbfd-866a0b3dfab7', 'photo', '612bb6ef26eb2_b-1', '612bb6ef26eb2_b-1.jpg', 'image/jpeg', 'public', 'public', 84426, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 32, '2021-08-29 13:33:52', '2021-08-29 13:33:54'),
(33, 'App\\Models\\OurPartner', 1, 'e5014b5d-3f34-4f38-8d92-237c2c49a722', 'logo', '612bb8aae7d19_13', '612bb8aae7d19_13.jpg', 'image/jpeg', 'public', 'public', 17040, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 33, '2021-08-29 13:41:33', '2021-08-29 13:41:33'),
(34, 'App\\Models\\OurPartner', 2, '9f7167a2-6ab3-4935-bc03-0826ff1f9199', 'logo', '612bb8c2d27ec_15', '612bb8c2d27ec_15.jpg', 'image/jpeg', 'public', 'public', 3400, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 34, '2021-08-29 13:41:39', '2021-08-29 13:41:40'),
(35, 'App\\Models\\OurPartner', 3, '3c4a04fa-8f31-4d6f-a3bb-1d1ac85514f4', 'logo', '612bb8c7bb931_16', '612bb8c7bb931_16.jpg', 'image/jpeg', 'public', 'public', 18594, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 35, '2021-08-29 13:41:45', '2021-08-29 13:41:45'),
(36, 'App\\Models\\OurPartner', 4, '5e17d7ce-d451-4df9-a9dc-0741e7fbf6ad', 'logo', '612bb8ce1704a_17', '612bb8ce1704a_17.jpg', 'image/jpeg', 'public', 'public', 19146, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 36, '2021-08-29 13:41:51', '2021-08-29 13:41:51'),
(37, 'App\\Models\\OurPartner', 5, '97f16505-4d80-47d7-82bd-53072ccff29b', 'logo', '612bb8d2ef87c_11', '612bb8d2ef87c_11.jpg', 'image/jpeg', 'public', 'public', 2907, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 37, '2021-08-29 13:41:56', '2021-08-29 13:41:56'),
(38, 'App\\Models\\OurPartner', 6, 'a301345d-31f5-4a1f-9ffe-6f13d6447c52', 'logo', '612bb8e0c4b95_11', '612bb8e0c4b95_11.jpg', 'image/jpeg', 'public', 'public', 2907, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 38, '2021-08-29 13:42:10', '2021-08-29 13:42:10'),
(39, 'App\\Models\\OurPartner', 7, '22e6acc2-6a5a-4922-b9c2-1490d3ee77b0', 'logo', '612bb8e655d0a_11 (1)', '612bb8e655d0a_11-(1).jpg', 'image/jpeg', 'public', 'public', 2907, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 39, '2021-08-29 13:42:15', '2021-08-29 13:42:16'),
(40, 'App\\Models\\OurPartner', 8, 'a5e1fa45-8ec3-490b-a728-82eac7edba1c', 'logo', '612bb8ebc84b3_12', '612bb8ebc84b3_12.jpg', 'image/jpeg', 'public', 'public', 19026, '[]', '{\"generated_conversions\":{\"thumb\":true,\"preview\":true}}', '[]', 40, '2021-08-29 13:42:20', '2021-08-29 13:42:21');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `full_name`, `phone_number`, `message`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Travis Young', '+1 (992) 826-3758', 'Consequatur tempora', '2021-09-04 09:21:02', '2021-09-04 09:21:02', NULL),
(2, 'Gideon', '0792866722', 'This is a real test message', '2021-09-04 09:36:22', '2021-09-04 09:36:22', NULL),
(3, 'Bradley Sutton', '0717255460', 'Tempor anim quis ut', '2021-09-04 09:37:49', '2021-09-04 09:37:49', NULL),
(4, 'wilson', '254717255460', 'message test', '2021-09-04 09:39:14', '2021-09-04 09:39:14', NULL),
(5, 'Gideon Hizdory', '254792866722', 'Hello chicken', '2021-09-04 09:47:00', '2021-09-04 09:47:00', NULL),
(6, 'Gideon Hizdory', '254717255460', 'Hello chicken', '2021-09-04 09:49:09', '2021-09-04 09:49:09', NULL);

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
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2021_08_28_000001_create_audit_logs_table', 1),
(4, '2021_08_28_000002_create_media_table', 1),
(5, '2021_08_28_000003_create_contact_us_messages_table', 1),
(6, '2021_08_28_000004_create_propoerty_inquiries_table', 1),
(7, '2021_08_28_000005_create_property_reviews_table', 1),
(8, '2021_08_28_000006_create_properties_table', 1),
(9, '2021_08_28_000007_create_aboutuses_table', 1),
(10, '2021_08_28_000008_create_categories_table', 1),
(11, '2021_08_28_000009_create_faqs_table', 1),
(12, '2021_08_28_000010_create_crm_documents_table', 1),
(13, '2021_08_28_000011_create_blogs_table', 1),
(14, '2021_08_28_000012_create_crm_notes_table', 1),
(15, '2021_08_28_000013_create_property_tags_table', 1),
(16, '2021_08_28_000014_create_crm_customers_table', 1),
(17, '2021_08_28_000015_create_seaches_table', 1),
(18, '2021_08_28_000016_create_crm_statuses_table', 1),
(19, '2021_08_28_000017_create_our_partners_table', 1),
(20, '2021_08_28_000018_create_users_table', 1),
(21, '2021_08_28_000019_create_subscribers_table', 1),
(22, '2021_08_28_000020_create_roles_table', 1),
(23, '2021_08_28_000021_create_permissions_table', 1),
(24, '2021_08_28_000022_create_amenities_table', 1),
(25, '2021_08_28_000023_create_property_property_tag_pivot_table', 1),
(26, '2021_08_28_000024_create_amenity_property_pivot_table', 1),
(27, '2021_08_28_000025_create_role_user_pivot_table', 1),
(28, '2021_08_28_000026_create_permission_role_pivot_table', 1),
(29, '2021_08_28_000027_add_relationship_fields_to_amenities_table', 1),
(30, '2021_08_28_000028_add_relationship_fields_to_properties_table', 1),
(31, '2021_08_28_000029_add_relationship_fields_to_propoerty_inquiries_table', 1),
(32, '2021_08_28_000030_add_relationship_fields_to_property_reviews_table', 1),
(33, '2021_08_28_000031_add_relationship_fields_to_categories_table', 1),
(34, '2021_08_28_000032_add_relationship_fields_to_crm_documents_table', 1),
(35, '2021_08_28_000033_add_relationship_fields_to_crm_notes_table', 1),
(36, '2021_08_28_000034_add_relationship_fields_to_crm_customers_table', 1),
(37, '2021_08_28_000035_add_relationship_fields_to_blogs_table', 1),
(38, '2021_08_28_000036_add_relationship_fields_to_crm_statuses_table', 1),
(39, '2021_08_28_000037_add_verification_fields', 1),
(40, '2021_08_28_000038_create_qa_topics_table', 1),
(41, '2021_08_28_000039_create_qa_messages_table', 1),
(42, '2021_09_04_000020_create_messages_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `our_partners`
--

CREATE TABLE `our_partners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `our_partners`
--

INSERT INTO `our_partners` (`id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2021-08-29 13:41:33', '2021-08-29 13:41:33', NULL),
(2, '2021-08-29 13:41:39', '2021-08-29 13:41:39', NULL),
(3, '2021-08-29 13:41:45', '2021-08-29 13:41:45', NULL),
(4, '2021-08-29 13:41:51', '2021-08-29 13:41:51', NULL),
(5, '2021-08-29 13:41:56', '2021-08-29 13:41:56', NULL),
(6, '2021-08-29 13:42:09', '2021-08-29 13:42:09', NULL),
(7, '2021-08-29 13:42:15', '2021-08-29 13:42:15', NULL),
(8, '2021-08-29 13:42:20', '2021-08-29 13:42:20', NULL);

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
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'user_management_access', NULL, NULL, NULL),
(2, 'permission_create', NULL, NULL, NULL),
(3, 'permission_edit', NULL, NULL, NULL),
(4, 'permission_show', NULL, NULL, NULL),
(5, 'permission_delete', NULL, NULL, NULL),
(6, 'permission_access', NULL, NULL, NULL),
(7, 'role_create', NULL, NULL, NULL),
(8, 'role_edit', NULL, NULL, NULL),
(9, 'role_show', NULL, NULL, NULL),
(10, 'role_delete', NULL, NULL, NULL),
(11, 'role_access', NULL, NULL, NULL),
(12, 'user_create', NULL, NULL, NULL),
(13, 'user_edit', NULL, NULL, NULL),
(14, 'user_show', NULL, NULL, NULL),
(15, 'user_delete', NULL, NULL, NULL),
(16, 'user_access', NULL, NULL, NULL),
(17, 'basic_c_r_m_access', NULL, NULL, NULL),
(18, 'crm_status_create', NULL, NULL, NULL),
(19, 'crm_status_edit', NULL, NULL, NULL),
(20, 'crm_status_show', NULL, NULL, NULL),
(21, 'crm_status_delete', NULL, NULL, NULL),
(22, 'crm_status_access', NULL, NULL, NULL),
(23, 'crm_customer_create', NULL, NULL, NULL),
(24, 'crm_customer_edit', NULL, NULL, NULL),
(25, 'crm_customer_show', NULL, NULL, NULL),
(26, 'crm_customer_delete', NULL, NULL, NULL),
(27, 'crm_customer_access', NULL, NULL, NULL),
(28, 'crm_note_create', NULL, NULL, NULL),
(29, 'crm_note_edit', NULL, NULL, NULL),
(30, 'crm_note_show', NULL, NULL, NULL),
(31, 'crm_note_delete', NULL, NULL, NULL),
(32, 'crm_note_access', NULL, NULL, NULL),
(33, 'crm_document_create', NULL, NULL, NULL),
(34, 'crm_document_edit', NULL, NULL, NULL),
(35, 'crm_document_show', NULL, NULL, NULL),
(36, 'crm_document_delete', NULL, NULL, NULL),
(37, 'crm_document_access', NULL, NULL, NULL),
(38, 'audit_log_show', NULL, NULL, NULL),
(39, 'audit_log_access', NULL, NULL, NULL),
(40, 'property_management_access', NULL, NULL, NULL),
(41, 'category_create', NULL, NULL, NULL),
(42, 'category_edit', NULL, NULL, NULL),
(43, 'category_show', NULL, NULL, NULL),
(44, 'category_delete', NULL, NULL, NULL),
(45, 'category_access', NULL, NULL, NULL),
(46, 'property_create', NULL, NULL, NULL),
(47, 'property_edit', NULL, NULL, NULL),
(48, 'property_show', NULL, NULL, NULL),
(49, 'property_delete', NULL, NULL, NULL),
(50, 'property_access', NULL, NULL, NULL),
(51, 'amenity_create', NULL, NULL, NULL),
(52, 'amenity_edit', NULL, NULL, NULL),
(53, 'amenity_show', NULL, NULL, NULL),
(54, 'amenity_delete', NULL, NULL, NULL),
(55, 'amenity_access', NULL, NULL, NULL),
(56, 'property_tag_create', NULL, NULL, NULL),
(57, 'property_tag_edit', NULL, NULL, NULL),
(58, 'property_tag_show', NULL, NULL, NULL),
(59, 'property_tag_delete', NULL, NULL, NULL),
(60, 'property_tag_access', NULL, NULL, NULL),
(61, 'propoerty_inquiry_create', NULL, NULL, NULL),
(62, 'propoerty_inquiry_edit', NULL, NULL, NULL),
(63, 'propoerty_inquiry_show', NULL, NULL, NULL),
(64, 'propoerty_inquiry_delete', NULL, NULL, NULL),
(65, 'propoerty_inquiry_access', NULL, NULL, NULL),
(66, 'property_review_create', NULL, NULL, NULL),
(67, 'property_review_edit', NULL, NULL, NULL),
(68, 'property_review_show', NULL, NULL, NULL),
(69, 'property_review_delete', NULL, NULL, NULL),
(70, 'property_review_access', NULL, NULL, NULL),
(71, 'page_access', NULL, NULL, NULL),
(72, 'about_us_create', NULL, NULL, NULL),
(73, 'about_us_edit', NULL, NULL, NULL),
(74, 'about_us_show', NULL, NULL, NULL),
(75, 'about_us_delete', NULL, NULL, NULL),
(76, 'about_us_access', NULL, NULL, NULL),
(77, 'faq_create', NULL, NULL, NULL),
(78, 'faq_edit', NULL, NULL, NULL),
(79, 'faq_show', NULL, NULL, NULL),
(80, 'faq_delete', NULL, NULL, NULL),
(81, 'faq_access', NULL, NULL, NULL),
(82, 'system_setting_access', NULL, NULL, NULL),
(83, 'contact_us_message_create', NULL, NULL, NULL),
(84, 'contact_us_message_edit', NULL, NULL, NULL),
(85, 'contact_us_message_show', NULL, NULL, NULL),
(86, 'contact_us_message_delete', NULL, NULL, NULL),
(87, 'contact_us_message_access', NULL, NULL, NULL),
(88, 'blog_create', NULL, NULL, NULL),
(89, 'blog_edit', NULL, NULL, NULL),
(90, 'blog_show', NULL, NULL, NULL),
(91, 'blog_delete', NULL, NULL, NULL),
(92, 'blog_access', NULL, NULL, NULL),
(93, 'seach_create', NULL, NULL, NULL),
(94, 'seach_edit', NULL, NULL, NULL),
(95, 'seach_show', NULL, NULL, NULL),
(96, 'seach_delete', NULL, NULL, NULL),
(97, 'seach_access', NULL, NULL, NULL),
(98, 'our_partner_create', NULL, NULL, NULL),
(99, 'our_partner_edit', NULL, NULL, NULL),
(100, 'our_partner_show', NULL, NULL, NULL),
(101, 'our_partner_delete', NULL, NULL, NULL),
(102, 'our_partner_access', NULL, NULL, NULL),
(103, 'subscriber_create', NULL, NULL, NULL),
(104, 'subscriber_edit', NULL, NULL, NULL),
(105, 'subscriber_show', NULL, NULL, NULL),
(106, 'subscriber_delete', NULL, NULL, NULL),
(107, 'subscriber_access', NULL, NULL, NULL),
(108, 'profile_password_edit', NULL, NULL, NULL),
(109, 'none', '2021-08-29 18:30:06', '2021-08-29 18:30:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49),
(1, 50),
(1, 51),
(1, 52),
(1, 53),
(1, 54),
(1, 55),
(1, 56),
(1, 57),
(1, 58),
(1, 59),
(1, 60),
(1, 61),
(1, 62),
(1, 63),
(1, 64),
(1, 65),
(1, 66),
(1, 67),
(1, 68),
(1, 69),
(1, 70),
(1, 71),
(1, 72),
(1, 73),
(1, 74),
(1, 75),
(1, 76),
(1, 77),
(1, 78),
(1, 79),
(1, 80),
(1, 81),
(1, 82),
(1, 83),
(1, 84),
(1, 85),
(1, 86),
(1, 87),
(1, 88),
(1, 89),
(1, 90),
(1, 91),
(1, 92),
(1, 93),
(1, 94),
(1, 95),
(1, 96),
(1, 97),
(1, 98),
(1, 99),
(1, 100),
(1, 101),
(1, 102),
(1, 103),
(1, 104),
(1, 105),
(1, 106),
(1, 107),
(1, 108),
(2, 109);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `property_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `rooms` int(11) NOT NULL,
  `property_price` decimal(15,2) NOT NULL,
  `per` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_map_location` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `year_built` date NOT NULL,
  `area` int(11) NOT NULL,
  `property_video` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `available` tinyint(1) NOT NULL DEFAULT 0,
  `feature_property` tinyint(1) DEFAULT 0,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `created_by_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `property_title`, `property_description`, `rooms`, `property_price`, `per`, `google_map_location`, `year_built`, `area`, `property_video`, `status`, `available`, `feature_property`, `location`, `created_at`, `updated_at`, `deleted_at`, `type_id`, `created_by_id`) VALUES
(1, 'Tempora repellendus', '<p>Laxury Home For Sale odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atcorrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum <strong>fuga</strong>.</p><p>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoraliz the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble thena bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain.</p>', 12, '600.00', 'month', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7977.51714436408!2d36.92382621899715!3d-1.3206022087286546!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f133a0cbcc349%3A0x7b5f23df06449900!2sKenya%20Airports%20Authority!5e0!3m2!1sen!2ske!4v1630145501021!5m2!1sen!2ske\" width=\"600\" height=\"450\"', '2021-08-20', 86, 'https://www.youtube.com/watch?v=qSxyffSB7wA', '1', 1, 1, 'Juja Thika', '2021-08-28 08:10:46', '2021-08-28 08:10:46', NULL, 1, 1),
(2, 'Tempora property 1', '<p>Laxury Home For Sale odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atcorrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum <strong>fuga</strong>.</p><p>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoraliz the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble thena bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain.</p>', 12, '600.00', 'month', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7977.51714436408!2d36.92382621899715!3d-1.3206022087286546!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f133a0cbcc349%3A0x7b5f23df06449900!2sKenya%20Airports%20Authority!5e0!3m2!1sen!2ske!4v1630145501021!5m2!1sen!2ske\" width=\"600\" height=\"450\"', '2021-08-20', 86, 'https://www.youtube.com/watch?v=qSxyffSB7wA', '1', 1, 0, 'Juja Thika', '2021-08-28 08:10:46', '2021-08-29 12:53:09', NULL, 1, 1),
(5, 'Tempora repellendus1', '<p>Laxury Home For Sale odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atcorrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum <strong>fuga</strong>.</p><p>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoraliz the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble thena bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain.</p>', 12, '600.00', 'month', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7977.51714436408!2d36.92382621899715!3d-1.3206022087286546!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f133a0cbcc349%3A0x7b5f23df06449900!2sKenya%20Airports%20Authority!5e0!3m2!1sen!2ske!4v1630145501021!5m2!1sen!2ske\" width=\"600\" height=\"450\"', '2021-08-20', 86, 'https://www.youtube.com/watch?v=qSxyffSB7wA', '1', 1, 0, 'Juja Thika', '2021-08-28 08:10:46', '2021-08-29 12:55:26', NULL, 1, 1),
(6, 'Tempora property 2', '<p>Laxury Home For Sale odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atcorrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum <strong>fuga</strong>.</p><p>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoraliz the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble thena bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain.</p>', 12, '600.00', 'month', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7977.51714436408!2d36.92382621899715!3d-1.3206022087286546!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f133a0cbcc349%3A0x7b5f23df06449900!2sKenya%20Airports%20Authority!5e0!3m2!1sen!2ske!4v1630145501021!5m2!1sen!2ske\" width=\"600\" height=\"450\"', '2021-08-20', 86, 'https://www.youtube.com/watch?v=qSxyffSB7wA', '1', 1, 0, 'Juja Thika', '2021-08-28 08:10:46', '2021-08-29 12:54:18', NULL, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `property_property_tag`
--

CREATE TABLE `property_property_tag` (
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `property_tag_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_reviews`
--

CREATE TABLE `property_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ratings` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `review` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `created_by_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_reviews`
--

INSERT INTO `property_reviews` (`id`, `full_name`, `ratings`, `email`, `review`, `created_at`, `updated_at`, `deleted_at`, `property_id`, `created_by_id`) VALUES
(1, 'Gay England', 1, 'tycaxakiti@mailinator.com', 'Pariatur Iste cumqu', '2021-08-29 17:02:41', '2021-08-29 17:02:41', NULL, 2, NULL),
(2, 'Ulla Nolan', 4, 'wurulyz@mailinator.com', 'Incididunt veniam d', '2021-08-29 17:03:11', '2021-08-29 17:03:11', NULL, 5, NULL),
(3, 'Molly Wooten', 2, 'hiqule@mailinator.com', 'Aspernatur quibusdam', '2021-08-29 17:17:55', '2021-08-29 17:17:55', NULL, 5, NULL),
(4, 'Keefe Garcia', 5, 'higabixu@mailinator.com', 'Optio in qui sunt', '2021-09-04 08:33:18', '2021-09-04 08:33:18', NULL, 6, NULL),
(5, 'Veronica Diaz', 1, 'gozyv@mailinator.com', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta officia cumque aperiam ab aliquam perspiciatis magni tenetur amet maiores totam, ut dolor sunt aliquid necessitatibus, nobis quod nulla debitis ad recusandae. Eius sapiente perferendis maiores ut obcaecati doloremque voluptas sequi?', '2021-09-04 08:33:48', '2021-09-04 08:33:48', NULL, 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `property_tags`
--

CREATE TABLE `property_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_tags`
--

INSERT INTO `property_tags` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Tag 1', '2021-08-29 12:55:36', '2021-08-29 12:55:36', NULL),
(2, 'Tag 3', '2021-08-29 12:55:45', '2021-08-29 12:55:45', NULL),
(3, 'Tag 5', '2021-08-29 12:55:51', '2021-08-29 12:55:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `propoerty_inquiries`
--

CREATE TABLE `propoerty_inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `created_by_id` bigint(20) UNSIGNED DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qa_messages`
--

CREATE TABLE `qa_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `topic_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qa_topics`
--

CREATE TABLE `qa_topics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', NULL, NULL, NULL),
(2, 'User', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 2),
(5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `seaches`
--

CREATE TABLE `seaches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` int(11) DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `verified_at` datetime DEFAULT NULL,
  `verification_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `phone`, `address`, `email`, `postal_code`, `city`, `country`, `facebook`, `twitter`, `instagram`, `youtube`, `about`, `website`, `email_verified_at`, `password`, `verified`, `verified_at`, `verification_token`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'John Doe', 'John Doe', '0717255461', 'Nairobi Kenya', 'admin@admin.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$p2Om3eU2EKdTjdw851im9uogHqNKrOF8LTKczm.n2tUgScNZc/8AO', 1, '2021-08-08 21:31:57', '', NULL, NULL, '2021-08-29 13:19:42', NULL),
(2, NULL, 'ewewew', NULL, NULL, 'wewe@mail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$f8S23mFFMrtvImeEZDJ8U.EwwGUbmj8QNZYb34Sr2Cn6L5HtV196C', 0, NULL, 'NnlmZtiJRo2jexZvJa49IjS8WgJwlTYQFBO2R1K632reguolGmtOSDayYKjDUC2Q', NULL, '2021-08-29 13:49:07', '2021-08-29 13:49:07', NULL),
(3, 'xametorig', 'Brianna Vasquez', '+1 (566) 827-4838', 'Temporibus molestiae', 'wulytu@mailinator.com', 3, 'In labore aut ut lor', 'Qui nulla eu cupidat', 'Excepturi blanditiis', 'Sit est ipsa doloru', 'Vero dignissimos ali', 'Quod in eum eos del', 'Sint quod sequi dol', 'https://www.fafubezolamepi.org.uk', NULL, '$2y$10$jDZqEKINlt1v0ZYxp9FvCePukbzBwIgyEDVGw8QhZvtqqErtQuzmK', 1, '2021-08-29 21:26:43', NULL, NULL, '2021-08-29 18:26:43', '2021-08-29 18:26:43', NULL),
(4, NULL, 'Kasper Waller', NULL, NULL, 'xywo@mailinator.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$U6P/BzNwiN9KbmoJZVu8o.CWyMucNEmS0qOw.fTutfvIrU5jeDSWe', 0, NULL, '14si16hLieSjNnLS4ZskkjaTHytyc0fqWwvaUPvXk5lpLTJvC0t6gvdnRJ7lTqhj', NULL, '2021-09-02 04:47:58', '2021-09-02 04:47:58', NULL),
(5, NULL, 'Brady Daniels', NULL, NULL, 'wilsonkinyuam@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$rQ0aBJ9.NZ2cGGTCspxAV.F0VJU1lI6ll8G6QA6K7LMHx.grziXZe', 1, '2021-09-02 07:49:21', NULL, NULL, '2021-09-02 04:48:59', '2021-09-02 04:49:21', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aboutuses`
--
ALTER TABLE `aboutuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `amenities_name_unique` (`name`),
  ADD KEY `created_by_fk_4565219` (`created_by_id`);

--
-- Indexes for table `amenity_property`
--
ALTER TABLE `amenity_property`
  ADD KEY `property_id_fk_4565220` (`property_id`),
  ADD KEY `amenity_id_fk_4565220` (`amenity_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by_fk_4565450` (`created_by_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD KEY `created_by_fk_4565139` (`created_by_id`);

--
-- Indexes for table `contact_us_messages`
--
ALTER TABLE `contact_us_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crm_customers`
--
ALTER TABLE `crm_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_fk_4565084` (`status_id`),
  ADD KEY `created_by_fk_4565491` (`created_by_id`);

--
-- Indexes for table `crm_documents`
--
ALTER TABLE `crm_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_fk_4565101` (`customer_id`),
  ADD KEY `created_by_fk_4565493` (`created_by_id`);

--
-- Indexes for table `crm_notes`
--
ALTER TABLE `crm_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_fk_4565095` (`customer_id`),
  ADD KEY `created_by_fk_4565492` (`created_by_id`);

--
-- Indexes for table `crm_statuses`
--
ALTER TABLE `crm_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by_fk_4565490` (`created_by_id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`);

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
-- Indexes for table `our_partners`
--
ALTER TABLE `our_partners`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD KEY `role_id_fk_4565062` (`role_id`),
  ADD KEY `permission_id_fk_4565062` (`permission_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `properties_property_title_unique` (`property_title`),
  ADD KEY `type_fk_4565198` (`type_id`),
  ADD KEY `created_by_fk_4565205` (`created_by_id`);

--
-- Indexes for table `property_property_tag`
--
ALTER TABLE `property_property_tag`
  ADD KEY `property_id_fk_4565230` (`property_id`),
  ADD KEY `property_tag_id_fk_4565230` (`property_tag_id`);

--
-- Indexes for table `property_reviews`
--
ALTER TABLE `property_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_fk_4565296` (`property_id`),
  ADD KEY `created_by_fk_4565295` (`created_by_id`);

--
-- Indexes for table `property_tags`
--
ALTER TABLE `property_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `property_tags_name_unique` (`name`);

--
-- Indexes for table `propoerty_inquiries`
--
ALTER TABLE `propoerty_inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_fk_4565271` (`property_id`),
  ADD KEY `created_by_fk_4565279` (`created_by_id`);

--
-- Indexes for table `qa_messages`
--
ALTER TABLE `qa_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qa_messages_topic_id_foreign` (`topic_id`),
  ADD KEY `qa_messages_sender_id_foreign` (`sender_id`);

--
-- Indexes for table `qa_topics`
--
ALTER TABLE `qa_topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qa_topics_creator_id_foreign` (`creator_id`),
  ADD KEY `qa_topics_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD KEY `user_id_fk_4565071` (`user_id`),
  ADD KEY `role_id_fk_4565071` (`role_id`);

--
-- Indexes for table `seaches`
--
ALTER TABLE `seaches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aboutuses`
--
ALTER TABLE `aboutuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_us_messages`
--
ALTER TABLE `contact_us_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crm_customers`
--
ALTER TABLE `crm_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crm_documents`
--
ALTER TABLE `crm_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crm_notes`
--
ALTER TABLE `crm_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crm_statuses`
--
ALTER TABLE `crm_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `our_partners`
--
ALTER TABLE `our_partners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `property_reviews`
--
ALTER TABLE `property_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `property_tags`
--
ALTER TABLE `property_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `propoerty_inquiries`
--
ALTER TABLE `propoerty_inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `qa_messages`
--
ALTER TABLE `qa_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qa_topics`
--
ALTER TABLE `qa_topics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `seaches`
--
ALTER TABLE `seaches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `amenities`
--
ALTER TABLE `amenities`
  ADD CONSTRAINT `created_by_fk_4565219` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `amenity_property`
--
ALTER TABLE `amenity_property`
  ADD CONSTRAINT `amenity_id_fk_4565220` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `property_id_fk_4565220` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `created_by_fk_4565450` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `created_by_fk_4565139` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `crm_customers`
--
ALTER TABLE `crm_customers`
  ADD CONSTRAINT `created_by_fk_4565491` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `status_fk_4565084` FOREIGN KEY (`status_id`) REFERENCES `crm_statuses` (`id`);

--
-- Constraints for table `crm_documents`
--
ALTER TABLE `crm_documents`
  ADD CONSTRAINT `created_by_fk_4565493` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `customer_fk_4565101` FOREIGN KEY (`customer_id`) REFERENCES `crm_customers` (`id`);

--
-- Constraints for table `crm_notes`
--
ALTER TABLE `crm_notes`
  ADD CONSTRAINT `created_by_fk_4565492` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `customer_fk_4565095` FOREIGN KEY (`customer_id`) REFERENCES `crm_customers` (`id`);

--
-- Constraints for table `crm_statuses`
--
ALTER TABLE `crm_statuses`
  ADD CONSTRAINT `created_by_fk_4565490` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_id_fk_4565062` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_id_fk_4565062` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `created_by_fk_4565205` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `type_fk_4565198` FOREIGN KEY (`type_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `property_property_tag`
--
ALTER TABLE `property_property_tag`
  ADD CONSTRAINT `property_id_fk_4565230` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `property_tag_id_fk_4565230` FOREIGN KEY (`property_tag_id`) REFERENCES `property_tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_reviews`
--
ALTER TABLE `property_reviews`
  ADD CONSTRAINT `created_by_fk_4565295` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `property_fk_4565296` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`);

--
-- Constraints for table `propoerty_inquiries`
--
ALTER TABLE `propoerty_inquiries`
  ADD CONSTRAINT `created_by_fk_4565279` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `property_fk_4565271` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`);

--
-- Constraints for table `qa_messages`
--
ALTER TABLE `qa_messages`
  ADD CONSTRAINT `qa_messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `qa_messages_topic_id_foreign` FOREIGN KEY (`topic_id`) REFERENCES `qa_topics` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `qa_topics`
--
ALTER TABLE `qa_topics`
  ADD CONSTRAINT `qa_topics_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `qa_topics_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_id_fk_4565071` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_id_fk_4565071` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
