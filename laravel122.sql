-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th4 07, 2026 lúc 05:29 PM
-- Phiên bản máy phục vụ: 8.0.30
-- Phiên bản PHP: 8.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `laravel122`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `members`
--

CREATE TABLE `members` (
  `id` bigint UNSIGNED NOT NULL,
  `fullname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numb` int DEFAULT '0',
  `id_group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `members`
--

INSERT INTO `members` (`id`, `fullname`, `avatar`, `phone`, `email`, `address`, `status`, `numb`, `id_group`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test Member', 'avatar.jpg', '0123456789', 'member@gmail.com', 'Ha Noi', 'active', 0, '1', NULL, '$2y$12$1keoFBFrT/gxeUmA579pRu4mQg8tD/JhBziyAIXHXWU1OQKCPdkjG', NULL, '2026-04-07 09:32:43', '2026-04-07 09:32:43'),
(2, 'Test Member 2', 'avatar.jpg', '0123456789', 'member2@gmail.com', 'Ha Noi', 'active', 0, '1', NULL, '$2y$12$jazuBojnGf/t94eeGhv0BO7s9L0UibZn5B8xhdwz2vLdcGg/2.kvu', NULL, '2026-04-07 09:32:43', '2026-04-07 09:32:43'),
(3, 'Test Member 3', 'avatar.jpg', '0123456789', 'member3@gmail.com', 'Ha Noi', 'active', 0, '1', NULL, '$2y$12$89ZIi1YgJRFuXUf1E3Kl8uJtE6OIRwaOjXvEfWkEfqPlGHt3bXMS2', NULL, '2026-04-07 09:32:43', '2026-04-07 09:32:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_04_082648_create_members_table', 1),
(5, '2026_04_07_171302_create_personal_access_tokens_table', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Member', 1, 'member-token', 'acb0f1e8bf6841eecc436fc51fe858eb53bdc0a3eef2be5e9dba0c1ed3aac5e6', '[\"*\"]', NULL, NULL, '2026-04-07 10:13:15', '2026-04-07 10:13:15'),
(2, 'App\\Models\\Member', 1, 'member-token', '556641d53ac114f7125c65d555ce2a3db2b48e64b45176be92fb0ecfb0815006', '[\"*\"]', NULL, NULL, '2026-04-07 10:18:01', '2026-04-07 10:18:01'),
(3, 'App\\Models\\Member', 1, 'member-token', '45d537d4a3c1257f1875f8cf4410fd9158250cb1902bb66b093174a62eefa8e0', '[\"*\"]', NULL, NULL, '2026-04-07 10:18:16', '2026-04-07 10:18:16'),
(4, 'App\\Models\\Member', 1, 'member-token', '8256d65d0c51b558c0c6858813d2918ecf4b9b0fbd4c5a5074a4bb22236b2f53', '[\"*\"]', NULL, NULL, '2026-04-07 10:18:27', '2026-04-07 10:18:27'),
(5, 'App\\Models\\Member', 1, 'member-token', '69b7ad1fa5b8382fe813e7c7c7144671858fbe4d13fb20d6d27b3f632b5045b7', '[\"*\"]', NULL, NULL, '2026-04-07 10:19:51', '2026-04-07 10:19:51'),
(6, 'App\\Models\\Member', 1, 'member-token', '25f3acdbe09aaa2b751cf0e50d361a092648e38b0fc02a89d0549e6c4ae97168', '[\"*\"]', NULL, NULL, '2026-04-07 10:19:54', '2026-04-07 10:19:54'),
(7, 'App\\Models\\Member', 1, 'member-token', '1ea36e7cc9c83cb1903e85fb5a784f2d2326364ab94fb4173a102ea9ff3ddef2', '[\"*\"]', NULL, NULL, '2026-04-07 10:20:43', '2026-04-07 10:20:43'),
(8, 'App\\Models\\Member', 1, 'member-token', 'c2264d3a7247c2ada6371ee0978cee3c22295a6e14d44f23698ae0dd651162f4', '[\"*\"]', '2026-04-07 10:21:59', NULL, '2026-04-07 10:20:49', '2026-04-07 10:21:59'),
(9, 'App\\Models\\Member', 1, 'member-token', '06f0e0384c43b2bba26978f86d5bb1326ce88d28d8ebbffd90595d38a950ecc2', '[\"*\"]', '2026-04-07 10:24:19', NULL, '2026-04-07 10:22:02', '2026-04-07 10:24:19'),
(10, 'App\\Models\\Member', 1, 'member-token', 'f0197ad379806fb14b07079a1abb4c52bc55bbd56dd56de14c42288d222e7545', '[\"*\"]', '2026-04-07 10:24:21', NULL, '2026-04-07 10:24:21', '2026-04-07 10:24:21'),
(11, 'App\\Models\\Member', 1, 'member-token', 'b2e63610eb7471e676c1643b8724430e0d1ded5a9b8f5cf9c7b1cba7ea82f5a4', '[\"*\"]', '2026-04-07 10:24:26', NULL, '2026-04-07 10:24:25', '2026-04-07 10:24:26'),
(12, 'App\\Models\\Member', 1, 'member-token', '45a145c8720a8f819db1ef522175f9b8b10ca3d7cbcd3de6743bd7e9c51399ce', '[\"*\"]', '2026-04-07 10:24:28', NULL, '2026-04-07 10:24:28', '2026-04-07 10:24:28'),
(13, 'App\\Models\\Member', 1, 'member-token', '5cadfc056639cc56092b1252994430d7d719be9d2f86e521cb47ac93a09d9b9a', '[\"*\"]', '2026-04-07 10:24:31', NULL, '2026-04-07 10:24:31', '2026-04-07 10:24:31'),
(14, 'App\\Models\\Member', 1, 'member-token', 'e2644d7c86677235fd78a18bd1438e299872a03d44e09833343be469b10ece69', '[\"*\"]', '2026-04-07 10:25:30', NULL, '2026-04-07 10:24:36', '2026-04-07 10:25:30'),
(15, 'App\\Models\\Member', 1, 'member-token', '904e083cd559eacf6667b7481fb4ec6dbd8676e74cd09e0297e9fe4b15d22741', '[\"*\"]', '2026-04-07 10:29:32', NULL, '2026-04-07 10:25:34', '2026-04-07 10:29:32');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('nyYFleLSOx93kD70DzdbHFyCCkULlZsCDCaqqUG6', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMHdERTlMYktuQk5Xc05HRzBWRTdUSzhwSDVWS1A0WXVMSEI1NTZWeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZW1iZXIvbG9naW4iO3M6NToicm91dGUiO3M6MTI6Im1lbWJlci5sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1775580674);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `fullname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numb` int DEFAULT '0',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `fullname`, `numb`, `email`, `address`, `phone`, `avatar`, `status`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 0, 'admin@gmail.com', NULL, NULL, NULL, 'active', 'admin', '2026-04-07 09:32:43', '$2y$12$BDYz6g4ydhpZI8z5QPt2qua.erG4r53aI/ab8JlRHgD9d9fOkoY1K', 'Ab05M4cxj4', '2026-04-07 09:32:43', '2026-04-07 09:32:43'),
(2, 'Test User 2', 0, 'admin2@gmail.com', NULL, NULL, NULL, 'pending', 'admin', '2026-04-07 09:32:43', '$2y$12$zS6ov4XBqwT5V3E4BDiYOOxCXtpiPYo0Ddhhztl3EtQ1EUc..l.Vi', 'XrlmTraE1s', '2026-04-07 09:32:43', '2026-04-07 09:32:43'),
(3, 'Test User 3', 0, 'admin3@gmail.com', NULL, NULL, NULL, 'pending', 'admin', '2026-04-07 09:32:43', '$2y$12$zVG1Cd5MZB.1zEC6DemMP.dRAypKG2LfGxbhmwCqpTfTO47NZ0XPu', 'IVMcVj2Ul8', '2026-04-07 09:32:43', '2026-04-07 09:32:43');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `members_email_unique` (`email`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
