-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2025 at 05:43 PM
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
-- Database: `assm_db_jarufu`
--

-- --------------------------------------------------------

--
-- Table structure for table `ac_assets`
--

CREATE TABLE `ac_assets` (
  `serial_number` varchar(200) NOT NULL,
  `reference_number` varchar(200) DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `warranty_expiry_date` varchar(200) DEFAULT NULL,
  `warranty_number` varchar(200) DEFAULT NULL,
  `model` varchar(200) DEFAULT NULL,
  `type` varchar(200) DEFAULT NULL,
  `capacity` varchar(200) DEFAULT NULL,
  `derivery_note_number` varchar(200) DEFAULT NULL,
  `derivery_note_date` date DEFAULT NULL,
  `lpo_no` varchar(100) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `invoice_no` varchar(200) DEFAULT NULL,
  `installation_date` date DEFAULT NULL,
  `installed_by` varchar(200) DEFAULT NULL,
  `condition` enum('New','Mid-used','Old') NOT NULL DEFAULT 'New',
  `status` enum('Working','Under Repair','Scrapped') NOT NULL DEFAULT 'Working',
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `justification_form_no` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ac_assets`
--

INSERT INTO `ac_assets` (`serial_number`, `reference_number`, `supplier_id`, `brand_id`, `warranty_expiry_date`, `warranty_number`, `model`, `type`, `capacity`, `derivery_note_number`, `derivery_note_date`, `lpo_no`, `invoice_date`, `invoice_no`, `installation_date`, `installed_by`, `condition`, `status`, `location_id`, `justification_form_no`, `created_at`, `updated_at`, `created_by`) VALUES
('AA', '987766666', 2, 2, '2005-09-23', '5656777', 'MDF', 'TYPE', '56', '789', '2025-06-18', '67YTY', '2025-06-26', '76876', '2025-07-03', 'BTY', 'Mid-used', 'Under Repair', 2, '78', '2025-06-20 07:34:44', '2025-06-20 07:34:44', NULL),
('AC-2025-001', 'REF-001', 1, 2, '2027-12-31', 'WR-78945', 'Mitsubishi X50', 'Split', '24000 BTU', 'DN-2025-03', '2025-06-18', 'LPO-5566', '2025-06-20', 'INV-7788', '2025-06-21', 'Technician Sam', 'New', 'Working', 3, 'JFN-9901', '2025-06-20 05:02:48', '2025-06-20 05:02:48', 1),
('moni77', '78888', 2, 3, '7888', '7988', '786', '79000', '4678', 'uii;io;', '2025-06-26', 'uiip[o', '2025-06-26', 'iopo[]', '2025-07-02', 'i;\'pi', 'Mid-used', 'Working', 2, 'yi;o;p\'i\'', '2025-06-20 07:38:54', '2025-06-20 07:38:54', NULL),
('moni776', '78888', 2, 3, '7888', '7988', '786', '79000', '4678', 'uii;io;', '2025-06-26', 'uiip[o', '2025-06-26', 'iopo[]', '2025-07-02', 'i;\'pi', 'Mid-used', 'Working', 2, 'yi;o;p\'i\'', '2025-06-20 07:39:45', '2025-06-20 07:39:45', NULL),
('monica', '78888', 2, 3, '7888', '7988', '786', '79000', '4678', 'uii;io;', '2025-06-26', 'uiip[o', '2025-06-26', 'iopo[]', '2025-07-02', 'i;\'pi', 'Mid-used', 'Working', 2, 'yi;o;p\'i\'', '2025-06-20 07:37:42', '2025-06-20 07:37:42', NULL),
('rttttt', 'jjkkk', 2, 2, '667778', 'yuu78', 'y67', 'iuyt', '67yg', '67909', '2025-06-26', '78890090', '2025-06-26', 'uyttyy', '2025-06-26', 'hggg', 'Mid-used', 'Under Repair', 2, 'uuyyygg', '2025-06-20 09:57:59', '2025-06-20 09:57:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ac_movements`
--

CREATE TABLE `ac_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ac_id` bigint(20) UNSIGNED NOT NULL,
  `from_location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `to_location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `movement_type` varchar(20) DEFAULT NULL,
  `moved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ac_services`
--

CREATE TABLE `ac_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ac_id` bigint(20) UNSIGNED NOT NULL,
  `service_date` date DEFAULT NULL,
  `service_type` varchar(255) DEFAULT NULL,
  `technical_name` bigint(20) UNSIGNED DEFAULT NULL,
  `issues_found` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'LG', '2025-06-20 04:38:54', '2025-06-20 04:38:54'),
(2, 'Samsung', '2025-06-20 04:39:07', '2025-06-20 04:39:07'),
(3, 'Hp', '2025-06-20 04:39:16', '2025-06-20 04:39:16'),
(4, 'Haier', '2025-06-20 04:40:06', '2025-06-20 04:40:06'),
(5, 'Hitachi', '2025-06-20 04:40:41', '2025-06-20 04:40:41');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Site', '2025-06-20 04:46:30', '2025-06-20 04:46:30'),
(2, 'Building', '2025-06-20 04:46:40', '2025-06-20 04:46:40'),
(3, 'Room', '2025-06-20 04:46:47', '2025-06-20 04:47:33');

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
(5, '2024_06_05_112928_create_permissions_table', 1),
(6, '2024_12_30_075248_create_roles_table', 1),
(7, '2025_01_02_063338_create_permission_role_table', 1),
(8, '2025_01_02_073509_create_role_user_table', 1),
(9, '2025_06_20_051852_create_suppliers_table', 1),
(10, '2025_06_20_052025_create_brands_table', 1),
(11, '2025_06_20_052034_create_locations_table', 1),
(12, '2025_06_20_052121_create_ac_assets_table', 1),
(13, '2025_06_20_055048_create_ac_movements_table', 1),
(14, '2025_06_20_055104_create_ac_services_table', 1),
(15, '2025_06_20_055131_create_store_invetories_table', 1),
(16, '2025_06_20_055229_create_documents_table', 1);

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
(15, 'main_setting_access', NULL, NULL, NULL),
(16, 'user_access', NULL, NULL, NULL);

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
(2, 15);

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

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'Personal Access Token', 'e208009f319691679a66f2ed34d9bb4da4b6d21dc89abdf380f2f07de2708a41', '[\"*\"]', '2025-06-20 05:31:19', NULL, '2025-06-20 04:34:14', '2025-06-20 05:31:19');

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
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `store_invetories`
--

CREATE TABLE `store_invetories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ac_id` bigint(20) UNSIGNED NOT NULL,
  `source` varchar(20) DEFAULT NULL,
  `date_received` date DEFAULT NULL,
  `store_location` varchar(20) DEFAULT NULL,
  `initial_status` enum('New','Used','Damaged') DEFAULT NULL,
  `updated_status` enum('New','Used','Damaged') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `physical_address` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `physical_address`, `mobile`, `created_at`, `updated_at`) VALUES
(1, 'Cool Breeze Ltd', 'Dar es Salaam, TZ', '+255712345678', '2025-06-20 04:54:22', '2025-06-20 04:54:22'),
(2, 'Safario Cooling Factory LLC', 'Dubai', '+255712345678', '2025-06-20 04:55:37', '2025-06-20 04:55:37'),
(3, 'Raj Air Conditioning Systems LLC', 'Rigga Building, Deira, Dubai, UAE', '+971-4-222-3897', '2025-06-20 04:56:22', '2025-06-20 04:56:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `campus_id` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(1) DEFAULT 0,
  `two_factor_expires_at` datetime DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `campus_id`, `email`, `email_verified_at`, `password`, `active`, `two_factor_expires_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', '785987184', 1, 'admin@admin.com', NULL, '$2y$10$BmJrfV66iqz81hdpd/yfrOoFbjkkLOn/QRF2qGMUPNjVj.6IG6t5a', 0, NULL, NULL, NULL, NULL, NULL),
(2, 'fm manager', '785987186', 1, 'fm.manager@gmail.com', NULL, '$2y$10$YcEc8PZILuzKOLAUPcZqZ.HEpCkFF1JIJwcaVgMLWqBaZVLqbi5d6', 0, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ac_assets`
--
ALTER TABLE `ac_assets`
  ADD UNIQUE KEY `ac_assets_serial_number_unique` (`serial_number`),
  ADD KEY `ac_assets_supplier_id_foreign` (`supplier_id`),
  ADD KEY `ac_assets_brand_id_foreign` (`brand_id`),
  ADD KEY `ac_assets_location_id_foreign` (`location_id`),
  ADD KEY `ac_assets_created_by_foreign` (`created_by`);

--
-- Indexes for table `ac_movements`
--
ALTER TABLE `ac_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ac_movements_from_location_id_foreign` (`from_location_id`),
  ADD KEY `ac_movements_to_location_id_foreign` (`to_location_id`),
  ADD KEY `ac_movements_moved_by_foreign` (`moved_by`);

--
-- Indexes for table `ac_services`
--
ALTER TABLE `ac_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ac_services_technical_name_foreign` (`technical_name`),
  ADD KEY `ac_services_location_id_foreign` (`location_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD KEY `role_id_fk_10194065` (`role_id`),
  ADD KEY `permission_id_fk_10194065` (`permission_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD KEY `user_id_fk_10194074` (`user_id`),
  ADD KEY `role_id_fk_10194074` (`role_id`);

--
-- Indexes for table `store_invetories`
--
ALTER TABLE `store_invetories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
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
-- AUTO_INCREMENT for table `ac_movements`
--
ALTER TABLE `ac_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ac_services`
--
ALTER TABLE `ac_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `store_invetories`
--
ALTER TABLE `store_invetories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ac_assets`
--
ALTER TABLE `ac_assets`
  ADD CONSTRAINT `ac_assets_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ac_assets_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ac_assets_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ac_assets_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ac_movements`
--
ALTER TABLE `ac_movements`
  ADD CONSTRAINT `ac_movements_from_location_id_foreign` FOREIGN KEY (`from_location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ac_movements_moved_by_foreign` FOREIGN KEY (`moved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ac_movements_to_location_id_foreign` FOREIGN KEY (`to_location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ac_services`
--
ALTER TABLE `ac_services`
  ADD CONSTRAINT `ac_services_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ac_services_technical_name_foreign` FOREIGN KEY (`technical_name`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_id_fk_10194065` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_id_fk_10194065` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_id_fk_10194074` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_id_fk_10194074` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
