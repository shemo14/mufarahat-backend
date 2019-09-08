-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2019 at 11:07 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mofrhat`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_sections`
--

CREATE TABLE `app_sections` (
  `id` int(10) UNSIGNED NOT NULL,
  `title_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `android` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ios` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_sections`
--

INSERT INTO `app_sections` (`id`, `title_ar`, `title_en`, `desc_ar`, `desc_en`, `android`, `ios`, `img_ar`, `img_en`, `created_at`, `updated_at`) VALUES
(1, 'عنوان', 'address', 'وصف', 'description', '11', '11', 'image.png', 'image.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'اوامر الشبكة', '2019-09-07 19:53:52', '2019-09-07 19:53:52'),
(2, 'site_name_ar', 'مفرحات', '2019-09-07 19:53:52', '2019-09-07 19:53:52'),
(3, 'site_name_en', 'Mofrhat', '2019-09-07 19:53:52', '2019-09-07 19:53:52'),
(4, 'address_ar', 'السعوديه', '2019-09-07 19:53:52', '2019-09-07 19:53:52'),
(5, 'address_en', 'السعوديه', '2019-09-07 19:53:52', '2019-09-07 19:53:52'),
(6, 'email', 'email@yahoo.com', '2019-09-07 19:53:52', '2019-09-07 19:53:52'),
(7, 'phone', '+966123456789', '2019-09-07 19:53:52', '2019-09-07 19:53:52'),
(8, 'about_us_ar', 'من نحن', '2019-09-07 19:53:52', '2019-09-07 19:53:52'),
(9, 'about_us_en', 'who', '2019-09-07 19:53:52', '2019-09-07 19:53:52'),
(10, 'roles_ar', 'الشروط والاحكام', '2019-09-07 19:53:52', '2019-09-07 19:53:52'),
(11, 'roles_en', 'roles', '2019-09-07 19:53:52', '2019-09-07 19:53:52');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name_ar`, `name_en`, `shipping`, `created_at`, `updated_at`) VALUES
(1, 'maka', '', '20', '2019-09-07 19:53:40', '2019-09-07 19:53:40'),
(2, 'Gaddah', '', '30', '2019-09-07 19:53:40', '2019-09-07 19:53:40');

-- --------------------------------------------------------

--
-- Table structure for table `contact_uses`
--

CREATE TABLE `contact_uses` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `msg` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delegates`
--

CREATE TABLE `delegates` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `car_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `licenses_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2013_09_07_210842_create_cities_table', 1),
(2, '2013_09_07_211119_create_warehouses_table', 1),
(3, '2014_10_12_000000_create_users_table', 1),
(4, '2014_10_12_100000_create_password_resets_table', 1),
(5, '2015_09_07_213636_create_delegates_table', 1),
(6, '2018_06_26_110013_create_roles_table', 1),
(7, '2018_06_26_110120_create_permissions_table', 1),
(8, '2018_07_01_104552_create_reports_table', 1),
(9, '2018_07_01_123905_create_app_seetings_table', 1),
(10, '2018_07_02_074616_create_socials_table', 1),
(11, '2019_03_07_114041_create_categories_table', 1),
(12, '2019_07_11_094950_create_app_sections_table', 1),
(13, '2019_07_15_143944_create_contact_uses_table', 1),
(14, '2019_07_24_072907_create_notifies_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifies`
--

CREATE TABLE `notifies` (
  `id` int(10) UNSIGNED NOT NULL,
  `title_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `permissions` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permissions`, `role_id`, `created_at`, `updated_at`) VALUES
(46, 'dashboard', 1, '2019-09-07 20:00:35', '2019-09-07 20:00:35'),
(47, 'permissionslist', 1, '2019-09-07 20:00:35', '2019-09-07 20:00:35'),
(48, 'addpermissionspage', 1, '2019-09-07 20:00:35', '2019-09-07 20:00:35'),
(49, 'addpermission', 1, '2019-09-07 20:00:35', '2019-09-07 20:00:35'),
(50, 'editpermissionpage', 1, '2019-09-07 20:00:35', '2019-09-07 20:00:35'),
(51, 'updatepermission', 1, '2019-09-07 20:00:35', '2019-09-07 20:00:35'),
(52, 'deletepermission', 1, '2019-09-07 20:00:35', '2019-09-07 20:00:35'),
(53, 'admins', 1, '2019-09-07 20:00:35', '2019-09-07 20:00:35'),
(54, 'addadmin', 1, '2019-09-07 20:00:35', '2019-09-07 20:00:35'),
(55, 'updateadmin', 1, '2019-09-07 20:00:35', '2019-09-07 20:00:35'),
(56, 'deleteadmin', 1, '2019-09-07 20:00:35', '2019-09-07 20:00:35'),
(57, 'deleteadmins', 1, '2019-09-07 20:00:35', '2019-09-07 20:00:35'),
(58, 'users', 1, '2019-09-07 20:00:35', '2019-09-07 20:00:35'),
(59, 'adduser', 1, '2019-09-07 20:00:35', '2019-09-07 20:00:35'),
(60, 'updateuser', 1, '2019-09-07 20:00:35', '2019-09-07 20:00:35'),
(61, 'deleteuser', 1, '2019-09-07 20:00:35', '2019-09-07 20:00:35'),
(62, 'deleteusers', 1, '2019-09-07 20:00:35', '2019-09-07 20:00:35'),
(63, 'send-fcm', 1, '2019-09-07 20:00:35', '2019-09-07 20:00:35'),
(64, 'categories', 1, '2019-09-07 20:00:35', '2019-09-07 20:00:35'),
(65, 'addCategory', 1, '2019-09-07 20:00:36', '2019-09-07 20:00:36'),
(66, 'updateCategory', 1, '2019-09-07 20:00:36', '2019-09-07 20:00:36'),
(67, 'deleteCategory', 1, '2019-09-07 20:00:36', '2019-09-07 20:00:36'),
(68, 'deleteCategories', 1, '2019-09-07 20:00:36', '2019-09-07 20:00:36'),
(69, 'allreports', 1, '2019-09-07 20:00:36', '2019-09-07 20:00:36'),
(70, 'deletereports', 1, '2019-09-07 20:00:36', '2019-09-07 20:00:36'),
(71, 'settings', 1, '2019-09-07 20:00:36', '2019-09-07 20:00:36'),
(72, 'sitesetting', 1, '2019-09-07 20:00:36', '2019-09-07 20:00:36'),
(73, 'add-social', 1, '2019-09-07 20:00:36', '2019-09-07 20:00:36'),
(74, 'update-social', 1, '2019-09-07 20:00:36', '2019-09-07 20:00:36'),
(75, 'delete-social', 1, '2019-09-07 20:00:36', '2019-09-07 20:00:36'),
(76, 'appSection', 1, '2019-09-07 20:00:36', '2019-09-07 20:00:36'),
(77, 'aboutUs', 1, '2019-09-07 20:00:36', '2019-09-07 20:00:36'),
(78, 'roles', 1, '2019-09-07 20:00:36', '2019-09-07 20:00:36');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(10) UNSIGNED NOT NULL,
  `event` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supervisor` int(11) NOT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `event`, `supervisor`, `ip`, `country`, `city`, `area`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'قام اوامر الشبكه بتعديل بيانات المشرف', 1, '::1', '', '', '', 1, '2019-09-07 19:58:35', '2019-09-07 19:58:35');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `created_at`, `updated_at`) VALUES
(1, 'مدير عام', '2019-09-07 19:53:49', '2019-09-07 19:53:49');

-- --------------------------------------------------------

--
-- Table structure for table `socials`
--

CREATE TABLE `socials` (
  `id` int(10) UNSIGNED NOT NULL,
  `site_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.png',
  `active` int(11) NOT NULL DEFAULT '0',
  `checked` int(11) NOT NULL DEFAULT '0',
  `role` int(11) NOT NULL DEFAULT '0',
  `isNotify` int(11) NOT NULL DEFAULT '1',
  `type` enum('user','delegate') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `lat` decimal(16,14) DEFAULT NULL,
  `lang` decimal(16,14) DEFAULT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `address`, `code`, `device_id`, `avatar`, `active`, `checked`, `role`, `isNotify`, `type`, `lat`, `lang`, `city_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'اوامر الشبكه', 'aait@info.com', '123456789', '$2y$10$AWKhkADFSNDcp0KypjC2o.QoZErzh3G.jhLEm9tZaNnKpWqCwyGQq', 'مصر - المنصوره', NULL, '1111111111', 'default.png', 0, 0, 1, 1, 'user', NULL, NULL, 1, NULL, '2019-09-07 19:53:45', '2019-09-07 19:58:34'),
(2, 'مندوب', 'delegate@info.com', '01022222222', '$2y$10$ODUIZrR4o4U0rGW0n58Fueea9J5967QFnpnNtqC7Y.hnQ4EEH.6c6', 'السعوديه - جده', NULL, '1111111111', 'default.png', 0, 0, 0, 1, 'delegate', NULL, NULL, 2, NULL, '2019-09-07 19:53:45', '2019-09-07 19:53:45');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `name`, `phone`, `address`, `city_id`, `created_at`, `updated_at`) VALUES
(1, 'مستودع مكه ', '0103333333', 'السعوديه - مكه', 1, '2019-09-07 19:53:42', '2019-09-07 19:53:42'),
(2, 'مستودع جده ', '0103333333', 'السعوديه - جده', 2, '2019-09-07 19:53:42', '2019-09-07 19:53:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_sections`
--
ALTER TABLE `app_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_uses`
--
ALTER TABLE `contact_uses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delegates`
--
ALTER TABLE `delegates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delegates_user_id_foreign` (`user_id`),
  ADD KEY `delegates_warehouse_id_foreign` (`warehouse_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifies`
--
ALTER TABLE `notifies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifies_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `socials`
--
ALTER TABLE `socials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD KEY `users_city_id_foreign` (`city_id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warehouses_city_id_foreign` (`city_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_sections`
--
ALTER TABLE `app_sections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_uses`
--
ALTER TABLE `contact_uses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delegates`
--
ALTER TABLE `delegates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `notifies`
--
ALTER TABLE `notifies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `socials`
--
ALTER TABLE `socials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `delegates`
--
ALTER TABLE `delegates`
  ADD CONSTRAINT `delegates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `delegates_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifies`
--
ALTER TABLE `notifies`
  ADD CONSTRAINT `notifies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD CONSTRAINT `warehouses_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
