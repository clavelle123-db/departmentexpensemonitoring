-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2025 at 07:51 AM
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
-- Database: `expenses_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `budgets`
--

CREATE TABLE `budgets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `spent_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `remaining_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `budgets`
--

INSERT INTO `budgets` (`id`, `department_id`, `amount`, `created_at`, `updated_at`, `total_amount`, `spent_amount`, `remaining_amount`) VALUES
(1, 1, 15000.00, '2025-06-30 01:27:23', '2025-08-22 04:08:36', 800000.00, 0.00, 800000.00),
(10, 15, 100000.00, '2025-08-18 22:15:53', '2025-08-18 22:15:53', 100000.00, 0.00, 100000.00),
(11, 16, 50000.00, '2025-08-18 22:52:03', '2025-08-22 04:10:10', 200000.00, 0.00, 200000.00),
(13, 18, 200000.00, '2025-08-22 04:09:09', '2025-08-22 04:09:09', 200000.00, 0.00, 200000.00),
(14, 19, 300000.00, '2025-08-22 04:10:36', '2025-08-22 04:10:36', 300000.00, 0.00, 300000.00);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `annual_budget` decimal(10,2) DEFAULT 0.00,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `department_head_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `created_at`, `updated_at`, `annual_budget`, `name`, `description`, `department_head_id`) VALUES
(1, '2025-06-29 17:18:14', '2025-08-22 04:08:36', 800000.00, 'BSIT', NULL, 3),
(15, '2025-08-18 22:15:28', '2025-08-18 22:41:05', 100000.00, 'BSIT-IV-EAST', 'BSIT YEAR LEVEL IV SECTION EAST', 8),
(16, '2025-08-18 22:51:32', '2025-08-22 04:10:10', 200000.00, 'BSIT-IV-NORTH', 'BSIT YEAR LEVEL IV SECTION NORTH', 7),
(18, '2025-08-22 04:06:37', '2025-08-22 04:09:09', 200000.00, 'BSIT-IV-WEST', 'BACHELOR OF SCIENCE', NULL),
(19, '2025-08-22 04:07:31', '2025-08-22 04:10:36', 300000.00, 'BSIT-IV-SOUTH', 'BACHELOR OF SCIENCE', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_description` text DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `applied_to` bigint(20) UNSIGNED NOT NULL,
  `status` int(2) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `event_description`, `amount`, `applied_to`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Foundation Day', 'foundation day event on August 30', 0.00, 2, 0, '2025-08-25 01:03:30', '2025-08-25 01:03:55'),
(3, 'National Heroes Day', 'day of the national heroes', 1000.00, 2, 0, '2025-08-25 22:37:01', '2025-08-25 22:38:32');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `expense_date` date NOT NULL,
  `category` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `user_id`, `department_id`, `expense_date`, `category`, `amount`, `description`, `receipt`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 1, '2025-06-30', 'Photobooth Materials', 2000.00, 'Insulator, Glue Stick, and Candle', '1751258365_online-booking system1.jpg', 'approved', '2025-06-29 20:39:25', '2025-06-30 17:40:28'),
(2, 4, 1, '2025-07-04', 'Stage Decor', 1500.00, 'Artificial Flower, Plastic Flower Vase, Styrofoam', '1751612077_IMG_20240210_214924.jpg', 'approved', '2025-07-03 22:54:37', '2025-07-04 01:38:25'),
(3, 4, 1, '2025-07-09', 'bachelor', 200000.00, 'science', NULL, 'approved', '2025-07-08 19:45:36', '2025-07-09 17:38:23'),
(4, 4, 1, '2025-07-09', 'bachelor', 200000.00, 'science', NULL, 'rejected', '2025-07-08 20:38:33', '2025-08-03 22:22:30');

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
-- Table structure for table `head_treasurers`
--

CREATE TABLE `head_treasurers` (
  `head_treasurer_id` bigint(20) UNSIGNED NOT NULL,
  `treasurer_name` varchar(255) NOT NULL,
  `section_assigned` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_29_021159_add_role_to_users_table', 2),
(5, '2025_06_29_021854_create_departments_table', 3),
(6, '2025_06_29_021854_create_expenses_table', 3),
(7, '2025_06_29_021855_create_budgets_table', 3),
(8, '2025_06_29_042045_update_users_table', 4),
(9, '2025_06_29_051935_update_users_table_with_employee_fields', 5),
(11, '2025_06_29_235539_add_annual_budget_to_departments', 6),
(12, '2025_06_30_010611_create_departments_table', 6),
(14, '2025_06_30_011418_update_departments_table', 7),
(15, '2025_06_30_064347_create_budgets_table', 8),
(16, '2025_06_30_073632_add_department_head_id_to_departments_table', 9),
(17, '2025_06_30_094517_add_department_id_to_users_table', 10),
(18, '2025_06_30_095149_add_department_id_to_users_table', 11),
(19, '2025_06_30_232405_create_settings_table', 11),
(20, '2025_07_04_052647_create_notifications_table', 12),
(21, '2025_07_04_095117_add_expense_id_to_notifications_table', 13),
(22, '2025_08_24_135353_create_sections_table', 14),
(23, '2025_08_24_135440_create_events_table', 15),
(24, '2025_08_24_135456_create_treasurers_table', 16),
(25, '2025_08_24_135507_create_head_treasurers_table', 17);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `expense_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'pending',
  `message` varchar(255) NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `expense_id`, `type`, `message`, `read`, `created_at`, `updated_at`) VALUES
(1, 3, NULL, 'pending', 'Rona Jean submitted ₱1,500.00 for approval.', 1, '2025-07-03 22:54:37', '2025-07-03 23:26:50'),
(2, 4, NULL, 'approved', 'Your expense of ₱1,500.00 was approved.', 1, '2025-07-04 01:38:25', '2025-07-04 01:53:09'),
(3, 3, NULL, 'pending', 'Rona Jean submitted ₱200,000.00 for approval.', 1, '2025-07-08 19:45:36', '2025-07-09 17:37:47'),
(4, 4, NULL, 'over_budget', 'Your submission exceeds the department budget.', 0, '2025-07-08 19:45:36', '2025-07-08 19:45:36'),
(5, 3, NULL, 'pending', 'Rona Jean submitted ₱200,000.00 for approval.', 1, '2025-07-08 20:38:33', '2025-07-09 17:37:37'),
(6, 4, NULL, 'over_budget', 'Your submission exceeds the department budget.', 1, '2025-07-08 20:38:33', '2025-08-03 22:23:21');

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
-- Table structure for table `remittances`
--

CREATE TABLE `remittances` (
  `remittance_id` bigint(20) UNSIGNED NOT NULL,
  `treasurer_id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `remittance_date` date NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `is_remitted` int(2) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `year_level` varchar(255) NOT NULL,
  `no_of_students` int(2) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`section_id`, `section_name`, `year_level`, `no_of_students`, `created_at`, `updated_at`) VALUES
(2, 'North', 'BSIT-III', 25, '2025-08-24 21:55:03', '2025-08-25 02:57:57'),
(4, 'EAST', 'BSIT-IV', 40, '2025-08-28 15:15:41', '2025-08-28 15:15:41'),
(11, 'North', '2', 0, '2025-09-14 01:32:36', '2025-09-14 01:32:36');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('foMlTrr5UGikeuFVD6GPQ3i6ecDCfwH8urX8Udko', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibWNLcEZqdklEeVZHcFlyd1cxWkZDZDczQnlNQTdiUkhFOG5JY3F0aiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9zZWN0aW9ucyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1759910288),
('h6GJ5y65k6Ryq0a4ubbbJez6K1U3rHXzYmAxCdNF', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOFBPVE9FcG51UDF4eEJrZ01jY2hpY25DTTUwTTV1aTJiNnVYa0Q4MCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1759910140),
('HN42U3lRl0NeScVPLAQ5aAbC3KWxWOutiJkLWvSE', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiY0dIVGd3UTFxVHcxbDN1aVo0bnZqM2UxNFZ2bnZVRzdUYmJhNWFndiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1761537842),
('la3htuDllGbDn8lUVaRvCJQiR52nN9i42aVtP5et', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNWVTTXFlSjY3blpJQTFJUUpCNXlQWExaSWdwRjFTeEt2TjlSamttRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761628325),
('tzBivL74TsgoaJJcLtYCoitx2gm6HVEDeu0dvnMW', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMExES2FEYjdYVnBIOUFmNUJ0aXAwZXpSMjFnbnFtSlFWQUVWbFlXMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1761710710),
('WCuUqf5Q1pqZFtfVXx71W8hdzQF0TvvOsnU3VJrI', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSWw5UUZDazdQWGVSb3RyQ0h2a0hvQ1daNVZCQUpPSTVHS0taQkV6YSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761711988);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'enable_notifications', '1', '2025-06-30 15:54:50', '2025-06-30 16:18:22');

-- --------------------------------------------------------

--
-- Table structure for table `treasurers`
--

CREATE TABLE `treasurers` (
  `treasurer_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `treasurer_name` varchar(255) DEFAULT NULL,
  `section_assigned` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `treasurers`
--

INSERT INTO `treasurers` (`treasurer_id`, `user_id`, `treasurer_name`, `section_assigned`, `created_at`, `updated_at`) VALUES
(11, 3, NULL, 2, '2025-08-30 17:11:22', '2025-08-30 17:11:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `role` enum('admin','head','user') NOT NULL DEFAULT 'user',
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_id`, `first_name`, `middle_name`, `last_name`, `username`, `name`, `email`, `address`, `gender`, `birthdate`, `role`, `department_id`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'EMP0002', 'Geralyn', 'S.', 'Garcia', 'geralyn29', 'Geralyn S. Garcia', 'geralyn29@gmail.com', 'Madridejos', 'female', '2005-06-22', 'admin', 1, 'active', '2025-06-29 07:38:19', '$2y$12$Q0F0/ia.FpG2K9yo1ddFQe8sIpp5wGIJHwG6BFQS/4pVGU9.LWLL2', 'yIXeZmLJhM7xieDZsnUZT53Ife1fifeZCTj4ktLlwQnR7pMJN0HuJV2XYDkk', '2025-06-29 07:38:19', '2025-06-29 07:39:06'),
(3, 'EMP0003', 'Clavelle', 'Oropesa', 'Apawan', 'clavelle30', 'Clavelle Oropesa Apawan', 'clavelle30@gmail.com', 'Madridejos', 'female', '2003-07-24', 'head', 1, 'active', '2025-06-29 18:15:34', '$2y$12$AcAYXFabJYN70qZXlMD/9OnwFCnPI6d0GY4rh/I5oHAGkcZYQUqba', NULL, '2025-06-29 18:15:34', '2025-06-29 18:15:34'),
(4, 'EMP0004', 'Rona Jean', 'Escala', 'Umbao', 'ronajean31', 'Rona Jean Escala Umbao', 'ronajean31@gmail.com', 'Madridejos', 'female', '2004-05-26', 'head', 1, 'active', NULL, '$2y$12$imQRoavSkdCI18RTFUJQauz33LESJBsmqCMF5T.3gHeWZaTKEQHiO', '5HU4BiJYfUFZxtkxzC3jzXG3pFxYG1Pj5zF2tfU3e5WRXwDYakeezTVPJ9j1', '2025-06-29 18:22:51', '2025-08-28 05:31:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `budgets_department_id_foreign` (`department_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_department_head_id_foreign` (`department_head_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `events_applied_to_foreign` (`applied_to`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_user_id_foreign` (`user_id`),
  ADD KEY `expenses_department_id_foreign` (`department_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `head_treasurers`
--
ALTER TABLE `head_treasurers`
  ADD PRIMARY KEY (`head_treasurer_id`),
  ADD UNIQUE KEY `head_treasurers_section_assigned_unique` (`section_assigned`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `notifications_user_id_foreign` (`user_id`),
  ADD KEY `notifications_expense_id_foreign` (`expense_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `remittances`
--
ALTER TABLE `remittances`
  ADD PRIMARY KEY (`remittance_id`),
  ADD KEY `treasurer_id` (`treasurer_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`section_id`),
  ADD UNIQUE KEY `uc_section_year` (`section_name`,`year_level`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `treasurers`
--
ALTER TABLE `treasurers`
  ADD PRIMARY KEY (`treasurer_id`),
  ADD KEY `treasurers_section_assigned_foreign` (`section_assigned`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_employee_id_unique` (`employee_id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_department_id_foreign` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budgets`
--
ALTER TABLE `budgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `head_treasurers`
--
ALTER TABLE `head_treasurers`
  MODIFY `head_treasurer_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `remittances`
--
ALTER TABLE `remittances`
  MODIFY `remittance_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `section_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `treasurers`
--
ALTER TABLE `treasurers`
  MODIFY `treasurer_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budgets`
--
ALTER TABLE `budgets`
  ADD CONSTRAINT `budgets_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_applied_to_foreign` FOREIGN KEY (`applied_to`) REFERENCES `sections` (`section_id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `expenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `head_treasurers`
--
ALTER TABLE `head_treasurers`
  ADD CONSTRAINT `head_treasurers_section_assigned_foreign` FOREIGN KEY (`section_assigned`) REFERENCES `sections` (`section_id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_expense_id_foreign` FOREIGN KEY (`expense_id`) REFERENCES `expenses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `remittances`
--
ALTER TABLE `remittances`
  ADD CONSTRAINT `remittances_ibfk_1` FOREIGN KEY (`treasurer_id`) REFERENCES `treasurers` (`treasurer_id`),
  ADD CONSTRAINT `remittances_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);

--
-- Constraints for table `treasurers`
--
ALTER TABLE `treasurers`
  ADD CONSTRAINT `treasurers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `treasurers_section_assigned_foreign` FOREIGN KEY (`section_assigned`) REFERENCES `sections` (`section_id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
