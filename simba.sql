-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2024 at 06:13 AM
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
-- Database: `simba`
--

-- --------------------------------------------------------

--
-- Table structure for table `conferences`
--

CREATE TABLE `conferences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `theme` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `venue` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `is_published` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conferences`
--

INSERT INTO `conferences` (`id`, `title`, `theme`, `date`, `venue`, `region`, `is_published`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'cbajdvjhwd', 'wwrrrrrrrrrrrrrrrrrw', '2024-06-29', 'dnqw', 'Arusha', 1, '2024-06-24 03:25:42', '2024-06-24 03:45:35', NULL),
(3, 'the fourth african confeence on applied informatics(ACAI)', 'harnessing applied informatics fro social and economic development', '2024-10-09', 'gran melia hotel', 'Arusha', 0, '2024-06-24 03:28:58', '2024-06-24 03:28:58', NULL);

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
-- Table structure for table `logos`
--

CREATE TABLE `logos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `route` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logos`
--

INSERT INTO `logos` (`id`, `name`, `photo`, `route`, `is_published`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'iaa logo', 'logo/iG3syFs630lw1HvqJ7K525VDzYvPJ556Vja0gnRE.png', NULL, 1, '2024-06-12 07:17:34', '2024-06-13 03:26:34', NULL),
(5, 'unknown', 'logo/lraR0rv2bkzBRi8hyTeC8puJw1AYshaxV2VZBIt6.png', NULL, 1, '2024-06-12 07:46:13', '2024-06-13 03:10:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `organization` varchar(255) NOT NULL,
  `speaker_id` bigint(20) UNSIGNED NOT NULL,
  `conference_id` bigint(20) UNSIGNED NOT NULL,
  `photo` varchar(255) NOT NULL,
  `is_published` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `title`, `organization`, `speaker_id`, `conference_id`, `photo`, `is_published`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'yasini mussa', 'exam officer', 'INSTITUTE OF ACCOUNTANCY ARUSHAa', 1, 3, 'members/6nx5mrfmo9FkbCYF5BxBE7s4CxbbmH9xYzHuRV36.jpg', 1, '2024-06-24 06:25:03', '2024-06-28 03:27:50', NULL),
(2, 'Eliaman Sedoyeka', 'Rector', 'INSTITUTE OF ACCOUNTANCY ARUSHA', 3, 3, 'members/lDUjLk2jYojvjBcYmVJIe4ApOpBJON74mGgxgnMq.jpg', 1, '2024-06-28 02:44:49', '2024-06-28 02:44:49', NULL),
(3, 'mohamed Hamisi', 'prof', 'University of Dodoma', 4, 3, 'members/KRC2bzitjT38SCNQD0740UoY32GP6iWTEGZIJZTb.jpg', 1, '2024-06-28 02:45:54', '2024-06-28 02:45:54', NULL),
(4, 'rashid sule', 'dk', 'ega', 6, 3, 'members/pzApKB4GTPq7Kz85uxjMzlw8JFn3NLSe3NN4hgwI.jpg', 1, '2024-06-28 02:46:48', '2024-06-28 02:46:48', NULL),
(5, 'khally kardashian', 'Social dev officer', 'district of iringa', 1, 3, 'members/idFA64Zk6yeGzYflyHI3vwRhXbbX3zVuvs2JbO5C.jpg', 1, '2024-06-28 03:12:59', '2024-06-28 03:12:59', NULL),
(6, 'mohamed Hamisi', 'exam officer', 'University of Dodoma', 4, 3, 'members/m4zKr1PSyNmF4oxwSBlXoyjUddNC1EmEyCUVfLYx.jpg', 1, '2024-06-28 03:13:48', '2024-06-28 03:13:48', NULL),
(7, 'mohamed Hamisi', 'exam officer', 'University of Dodoma', 4, 3, 'members/Nf8UUrRaDoPtw2zp9MZRkRyUTlwqp7rcotShXz6v.jpg', 1, '2024-06-28 03:14:23', '2024-06-28 03:14:23', NULL),
(8, 'mohamed Hamisi', 'exam officer', 'University of Dodoma', 4, 3, 'members/9ct92wTCAje59sl7CBBh8Bm1l2hIC9XmvoYGpWjB.jpg', 1, '2024-06-28 03:14:45', '2024-06-28 03:14:45', NULL),
(9, 'mohamed Hamisi', 'exam officer', 'University of Dodoma', 4, 3, 'members/GNcKka2C3idj8EY8icbMuQeVRVubOmCxQo5kgLU3.jpg', 1, '2024-06-28 03:15:12', '2024-06-28 03:15:12', NULL),
(10, 'rashid sule', 'program', 'ega', 6, 3, 'members/GAT2l8CXNMFf7aKRVVCEdnmI45Py9fyjo78tiPA5.jpg', 1, '2024-06-28 03:16:20', '2024-06-28 03:16:20', NULL),
(11, 'rashid sule', 'program', 'ega', 6, 3, 'members/gE8P3XwTiuw6jJWt0BnBqmTQPUDeK6p5XfzPcKf8.jpg', 1, '2024-06-28 03:16:41', '2024-06-28 03:16:41', NULL),
(12, 'rashid sule', 'program', 'ega', 6, 3, 'members/H65Y48up4JLjV9W0xWDohPrYdvG7FcGXyHajyNpE.jpg', 1, '2024-06-28 03:17:02', '2024-06-28 03:17:02', NULL),
(13, 'yasinta', 'cbajdvjhwd', 'INSTITUTE OF ACCOUNTANCY ARUSHA', 1, 3, 'members/82mYMkXQ5qUSPinRj1wTfeSIdmUjtGRoKw8A4mHL.jpg', 1, '2024-06-28 03:18:03', '2024-06-28 03:18:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_published` tinyint(1) DEFAULT 0,
  `no` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `is_published`, `no`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Header Top Bar', 1, 1, '2024-06-10 06:02:26', '2024-06-10 07:43:28', NULL),
(2, 'Header Nav Bar', 1, 2, '2024-06-10 06:22:35', '2024-06-10 07:44:02', NULL),
(3, 'more', 0, 3, '2024-06-10 06:32:42', '2024-06-10 06:32:42', NULL);

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_06_05_100146_create_roles_table', 1),
(6, '2024_06_05_112928_create_permissions_table', 2),
(7, '2024_06_10_065354_create_menus_table', 3),
(8, '2024_06_10_103713_create_menu_items_table', 4),
(9, '2024_06_10_110449_create_primary_menus_table', 5),
(11, '2024_06_11_075423_create_submenus_table', 6),
(12, '2024_06_12_090821_create_logos_table', 7),
(13, '2024_06_13_081916_add_content_to_primary_menus_table', 8),
(14, '2024_06_18_073617_create_speakers_table', 9),
(15, '2024_06_19_070232_create_conferences_table', 10),
(16, '2024_06_24_065543_create_members_table', 11),
(17, '2024_07_01_054242_add_no_to_speakers_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'permission_create', '2024-06-05 09:55:53', '2024-06-05 09:55:53', NULL),
(3, 'permission_edit', '2024-06-05 09:58:13', '2024-06-05 09:58:13', NULL),
(4, 'permission_delete', '2024-06-05 10:29:45', '2024-06-05 10:29:45', NULL),
(5, 'menu_item_access', '2024-06-05 10:33:32', '2024-06-05 10:33:32', NULL),
(6, 'menu_item_edit', '2024-06-06 04:30:12', '2024-06-06 04:30:12', NULL);

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
-- Table structure for table `primary_menus`
--

CREATE TABLE `primary_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `route` varchar(255) DEFAULT NULL,
  `external_url` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `no` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `primary_menus`
--

INSERT INTO `primary_menus` (`id`, `name`, `route`, `external_url`, `content`, `no`, `is_published`, `menu_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Home', 'webhome', NULL, NULL, '1', 1, 2, '2024-06-11 03:37:41', '2024-06-12 03:18:23', NULL),
(3, 'Registration', 'registration', NULL, NULL, '2', 1, 2, '2024-06-11 04:01:52', '2024-06-12 04:52:22', NULL),
(5, 'Programs', NULL, NULL, NULL, '3', 1, 2, '2024-06-11 05:20:44', '2024-06-13 06:00:11', NULL),
(6, 'Abstract', 'abstract', NULL, NULL, '4', 1, 2, '2024-06-11 05:55:29', '2024-06-12 03:21:03', NULL),
(7, 'Speakers', 'speakers', NULL, NULL, '5', 1, 2, '2024-06-11 05:58:22', '2024-06-19 03:59:37', NULL),
(8, 'Destination', NULL, NULL, NULL, '6', 1, 2, '2024-06-11 05:58:48', '2024-06-11 07:19:23', NULL),
(9, 'Contacts', 'contact', NULL, NULL, '7', 1, 2, '2024-06-11 05:59:13', '2024-06-12 03:21:58', NULL),
(11, 'phone number', NULL, NULL, '07856898764', '1', 1, 1, '2024-06-13 05:43:55', '2024-06-13 05:43:55', NULL),
(12, 'envelope', NULL, NULL, 'iaa@iaa.ac.tzs', '2', 1, 1, '2024-06-13 05:45:22', '2024-06-13 05:59:32', NULL),
(13, 'map-marker', NULL, NULL, 'Njiro Hills', '3', 1, 1, '2024-06-13 06:01:05', '2024-06-13 06:05:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `speakers`
--

CREATE TABLE `speakers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `no` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `speakers`
--

INSERT INTO `speakers` (`id`, `type`, `no`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Speaker', 3, '2024-06-18 05:21:06', '2024-07-01 02:52:32', NULL),
(3, 'guest of honour', 1, '2024-06-24 03:49:30', '2024-07-01 02:52:00', NULL),
(4, 'keytone speaker', 2, '2024-06-24 03:50:04', '2024-07-01 02:52:18', NULL),
(5, 'workshop director', 4, '2024-06-24 03:50:35', '2024-07-01 02:52:45', NULL),
(6, 'organizing committee', 5, '2024-06-24 03:51:37', '2024-07-01 02:52:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `submenus`
--

CREATE TABLE `submenus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `route` varchar(255) DEFAULT NULL,
  `external_url` varchar(255) DEFAULT NULL,
  `primary_menu_id` bigint(20) UNSIGNED NOT NULL,
  `is_published` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `submenus`
--

INSERT INTO `submenus` (`id`, `name`, `route`, `external_url`, `primary_menu_id`, `is_published`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Workshops', 'workshop', NULL, 5, 1, '2024-06-11 05:25:44', '2024-06-12 05:41:49', NULL),
(3, 'Hotels', 'hotels', NULL, 8, 1, '2024-06-11 07:15:03', '2024-06-12 05:40:42', NULL),
(4, 'Past Conference', 'past-conference', NULL, 5, 1, '2024-06-11 07:23:36', '2024-06-12 05:42:10', NULL),
(5, 'Tourism', 'tour', NULL, 8, 1, '2024-06-11 09:54:44', '2024-06-12 05:41:06', NULL),
(6, 'Conference Venue', 'conference-venue', NULL, 8, 1, '2024-06-11 09:55:06', '2024-06-12 05:41:30', NULL),
(7, 'Scientific Assembly', 'scientific-assembly', NULL, 5, 1, '2024-06-11 09:56:16', '2024-06-12 05:42:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'yasini.selemani@iaa.ac.tz', NULL, '$2y$10$WoDWySgNy9amqfx4HDNrEODv/s4VfD5NKPdKR0VmrfY3w/sH1BJua', NULL, '2024-06-05 07:37:54', '2024-06-05 07:37:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conferences`
--
ALTER TABLE `conferences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `logos`
--
ALTER TABLE `logos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `members_speaker_id_foreign` (`speaker_id`),
  ADD KEY `members_conference_id_foreign` (`conference_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_name_unique` (`name`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `primary_menus`
--
ALTER TABLE `primary_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `primary_menus_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `speakers`
--
ALTER TABLE `speakers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submenus`
--
ALTER TABLE `submenus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submenus_primary_menu_id_foreign` (`primary_menu_id`);

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
-- AUTO_INCREMENT for table `conferences`
--
ALTER TABLE `conferences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logos`
--
ALTER TABLE `logos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `primary_menus`
--
ALTER TABLE `primary_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `speakers`
--
ALTER TABLE `speakers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `submenus`
--
ALTER TABLE `submenus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_conference_id_foreign` FOREIGN KEY (`conference_id`) REFERENCES `conferences` (`id`),
  ADD CONSTRAINT `members_speaker_id_foreign` FOREIGN KEY (`speaker_id`) REFERENCES `speakers` (`id`);

--
-- Constraints for table `primary_menus`
--
ALTER TABLE `primary_menus`
  ADD CONSTRAINT `primary_menus_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`);

--
-- Constraints for table `submenus`
--
ALTER TABLE `submenus`
  ADD CONSTRAINT `submenus_primary_menu_id_foreign` FOREIGN KEY (`primary_menu_id`) REFERENCES `primary_menus` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
