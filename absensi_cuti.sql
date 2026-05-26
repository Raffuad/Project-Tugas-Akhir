-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Bulan Mei 2026 pada 18.53
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi_cuti`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `attendance_date` date NOT NULL,
  `check_in_time` time DEFAULT NULL,
  `check_in_location` text DEFAULT NULL,
  `check_out_time` time DEFAULT NULL,
  `check_out_location` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `attendances`
--

INSERT INTO `attendances` (`id`, `user_id`, `attendance_date`, `check_in_time`, `check_in_location`, `check_out_time`, `check_out_location`, `created_at`, `updated_at`) VALUES
(1, 4, '2026-05-07', '21:56:12', '-6.494155,106.798248', NULL, NULL, '2026-05-07 14:56:12', '2026-05-07 14:56:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `activity` varchar(255) NOT NULL,
  `auditable_type` varchar(255) NOT NULL,
  `auditable_id` bigint(20) UNSIGNED NOT NULL,
  `old_values` text DEFAULT NULL,
  `new_values` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `activity`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `created_at`, `updated_at`) VALUES
(1, 5, 'memperbarui_data_user', 'App\\Models\\User', 6, '\"{\\\"gaji_pokok\\\":\\\"0.00\\\"}\"', '\"{\\\"gaji_pokok\\\":\\\"4000000\\\"}\"', '2026-04-28 17:16:35', '2026-04-28 17:16:35'),
(2, 6, 'mengajukan_cuti', 'App\\Models\\Leave', 1, NULL, '\"{\\\"user_id\\\":6,\\\"type\\\":\\\"cuti\\\",\\\"start_date\\\":\\\"2026-05-02\\\",\\\"end_date\\\":\\\"2026-05-05\\\",\\\"reason\\\":\\\"Liburan\\\",\\\"proof_document\\\":null,\\\"status\\\":\\\"pending\\\",\\\"updated_at\\\":\\\"2026-04-28T17:21:42.000000Z\\\",\\\"created_at\\\":\\\"2026-04-28T17:21:42.000000Z\\\",\\\"id\\\":1}\"', '2026-04-28 17:21:42', '2026-04-28 17:21:42'),
(3, 5, 'memperbarui_data_user', 'App\\Models\\User', 2, '\"{\\\"gaji_pokok\\\":\\\"0.00\\\"}\"', '\"{\\\"gaji_pokok\\\":\\\"8000000\\\"}\"', '2026-04-28 17:26:14', '2026-04-28 17:26:14'),
(4, 2, 'memproses_cuti', 'App\\Models\\Leave', 1, '\"{\\\"id\\\":1,\\\"user_id\\\":6,\\\"type\\\":\\\"cuti\\\",\\\"start_date\\\":\\\"2026-05-02\\\",\\\"end_date\\\":\\\"2026-05-05\\\",\\\"reason\\\":\\\"Liburan\\\",\\\"proof_document\\\":null,\\\"status\\\":\\\"pending\\\",\\\"approved_by\\\":null,\\\"approver_notes\\\":null,\\\"created_at\\\":\\\"2026-04-28T17:21:42.000000Z\\\",\\\"updated_at\\\":\\\"2026-04-28T17:21:42.000000Z\\\"}\"', '\"{\\\"status\\\":\\\"approved\\\",\\\"approved_by\\\":2,\\\"approver_notes\\\":\\\"oke saya approve\\\",\\\"updated_at\\\":\\\"2026-04-30 21:06:31\\\"}\"', '2026-04-30 14:06:31', '2026-04-30 14:06:31'),
(5, 4, 'mengajukan_cuti', 'App\\Models\\Leave', 2, NULL, '\"{\\\"user_id\\\":4,\\\"type\\\":\\\"cuti\\\",\\\"start_date\\\":\\\"2026-05-01\\\",\\\"end_date\\\":\\\"2026-05-03\\\",\\\"reason\\\":\\\"Liburan\\\",\\\"proof_document\\\":null,\\\"status\\\":\\\"pending\\\",\\\"updated_at\\\":\\\"2026-05-01T16:35:02.000000Z\\\",\\\"created_at\\\":\\\"2026-05-01T16:35:02.000000Z\\\",\\\"id\\\":2}\"', '2026-05-01 16:35:02', '2026-05-01 16:35:02'),
(6, 2, 'memproses_cuti', 'App\\Models\\Leave', 2, '\"{\\\"id\\\":2,\\\"user_id\\\":4,\\\"type\\\":\\\"cuti\\\",\\\"start_date\\\":\\\"2026-05-01\\\",\\\"end_date\\\":\\\"2026-05-03\\\",\\\"reason\\\":\\\"Liburan\\\",\\\"proof_document\\\":null,\\\"status\\\":\\\"pending\\\",\\\"approved_by\\\":null,\\\"approver_notes\\\":null,\\\"created_at\\\":\\\"2026-05-01T16:35:02.000000Z\\\",\\\"updated_at\\\":\\\"2026-05-01T16:35:02.000000Z\\\"}\"', '\"{\\\"status\\\":\\\"approved\\\",\\\"approved_by\\\":2,\\\"approver_notes\\\":\\\"oke saya approve\\\",\\\"updated_at\\\":\\\"2026-05-07 22:19:06\\\"}\"', '2026-05-07 15:19:06', '2026-05-07 15:19:06'),
(7, 5, 'memperbarui_data_user', 'App\\Models\\User', 3, '\"{\\\"gaji_pokok\\\":\\\"0.00\\\",\\\"tarif_lembur_per_jam\\\":\\\"0.00\\\"}\"', '\"{\\\"gaji_pokok\\\":\\\"4800000\\\",\\\"tarif_lembur_per_jam\\\":\\\"20000\\\"}\"', '2026-05-07 18:17:52', '2026-05-07 18:17:52'),
(8, 5, 'memperbarui_data_user', 'App\\Models\\User', 16, '\"{\\\"gaji_pokok\\\":\\\"0.00\\\",\\\"tarif_lembur_per_jam\\\":\\\"0.00\\\"}\"', '\"{\\\"gaji_pokok\\\":\\\"4800000\\\",\\\"tarif_lembur_per_jam\\\":\\\"20000\\\"}\"', '2026-05-07 18:18:46', '2026-05-07 18:18:46'),
(9, 5, 'memperbarui_data_user', 'App\\Models\\User', 4, '\"{\\\"gaji_pokok\\\":\\\"0.00\\\",\\\"tarif_lembur_per_jam\\\":\\\"0.00\\\"}\"', '\"{\\\"gaji_pokok\\\":\\\"4800000\\\",\\\"tarif_lembur_per_jam\\\":\\\"20000\\\"}\"', '2026-05-07 18:21:30', '2026-05-07 18:21:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `jobs`
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
-- Struktur dari tabel `job_batches`
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
-- Struktur dari tabel `leaves`
--

CREATE TABLE `leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('cuti','izin','sakit') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text NOT NULL,
  `proof_document` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approver_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `leaves`
--

INSERT INTO `leaves` (`id`, `user_id`, `type`, `start_date`, `end_date`, `reason`, `proof_document`, `status`, `approved_by`, `approver_notes`, `created_at`, `updated_at`) VALUES
(1, 6, 'cuti', '2026-05-02', '2026-05-05', 'Liburan', NULL, 'approved', 2, 'oke saya approve', '2026-04-28 17:21:42', '2026-04-30 14:06:31'),
(2, 4, 'cuti', '2026-05-01', '2026-05-03', 'Liburan', NULL, 'approved', 2, 'oke saya approve', '2026-05-01 16:35:02', '2026-05-07 15:19:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_15_173612_create_settings_table', 1),
(5, '2025_07_15_175045_create_attendances_table', 1),
(6, '2025_07_16_140312_create_overtimes_table', 1),
(7, '2025_07_16_150209_create_leaves_table', 1),
(8, '2025_07_16_191020_add_salary_columns_to_users_table', 1),
(9, '2025_07_16_211518_create_audit_logs_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `overtimes`
--

CREATE TABLE `overtimes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `overtime_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approver_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'qr_token_2026-04-28', 'uoFnjTBBg4qu8dyzgwWS7EMdhuT4fRBOvG3vvHwT', '2026-04-27 18:02:24', '2026-04-27 18:02:24'),
(2, 'qr_token_2026-04-29', 'Jtw1XOdCmKZFqO8SJtRwVg58CawmJawHHcYbXRWr', '2026-04-28 17:15:55', '2026-04-28 17:15:55'),
(3, 'jam_masuk', '08:00', '2026-04-28 17:24:57', '2026-05-14 22:51:54'),
(4, 'jam_pulang', '17:00', '2026-04-28 17:24:57', '2026-05-14 22:51:54'),
(5, 'radius_absensi', '200', '2026-04-28 17:24:57', '2026-04-28 17:24:57'),
(6, 'lokasi_kantor_lat', 'GQ4X+54 Bojonggede, Kabupaten Bogor, Jawa Barat', '2026-04-28 17:24:57', '2026-04-28 17:24:57'),
(7, 'lokasi_kantor_lon', 'GQ4X+54 Bojonggede, Kabupaten Bogor, Jawa Barat', '2026-04-28 17:24:57', '2026-04-28 17:24:57'),
(8, 'qr_token_2026-04-30', 'SDiLZ72xNj2buS2jzHg9GdDYPQFlOTaF8gmRhpnZ', '2026-04-30 13:40:14', '2026-04-30 13:40:14'),
(9, 'qr_token_2026-05-07', '9Npuhi4ttjgqTeImTOI5HqipCb0e2YJoOfnAr8id', '2026-05-07 14:25:41', '2026-05-07 14:25:41'),
(10, 'qr_token_2026-05-08', '4Ey7QXOV6PHKIpPH1qe64ZFme05QjMeUxaBBKSvf', '2026-05-07 18:21:46', '2026-05-07 18:21:46'),
(11, 'qr_token_2026-05-15', 'l8QH3T5W7I0vdpJUtf5BVZbq6Du4yQrZ62kBgXtk', '2026-05-14 22:50:38', '2026-05-14 22:50:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','atasan','karyawan') NOT NULL DEFAULT 'karyawan',
  `gaji_pokok` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tarif_lembur_per_jam` decimal(15,2) NOT NULL DEFAULT 0.00,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `gaji_pokok`, `tarif_lembur_per_jam`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Direktur', 'atasan@gmail.com', NULL, '$2y$10$idSibViGAsxTrMjAX.vLt.pjyRTEkWzwFJ/6ebcWdOpxTnQYyjki.', 'atasan', 8000000.00, 0.00, NULL, '2026-04-27 17:48:31', '2026-05-18 16:33:05'),
(3, 'Dewa', 'dewa@gmail.com', NULL, '$2y$12$KtR7A2v.L08Fe3GDivLsfONS9BNqcaEE5nMSFSqMfU6Ay6k47kXSC', 'karyawan', 4800000.00, 20000.00, NULL, '2026-04-27 17:48:32', '2026-05-07 18:17:52'),
(4, 'Rafeldi', 'rafeldi@gmail.com', NULL, '$2y$12$qCDXR7dD8q1Bnp.EuLpu7eP2j2ONp7eQvykxaBI9HDBA99J.aa0Oy', 'karyawan', 4800000.00, 20000.00, NULL, '2026-04-27 17:58:08', '2026-05-07 18:21:30'),
(5, 'Admin', 'admin@gmail.com', NULL, '$2y$10$eMPik3nkVmXEaL1YNArcWOTKDFFIYg7olNM1m4hlN3l2gV5LUqdaS', 'admin', 0.00, 0.00, NULL, '2026-04-27 18:01:24', '2026-05-18 16:20:38'),
(6, 'Radits', 'radityaanwar@gmail.com', NULL, '$2y$10$qLzO5OHLe2jWu6YKCaQud..M6Uu41A7S9KgfpQVk9RLu0wJdEs5Za', 'karyawan', 4000000.00, 0.00, NULL, '2026-04-27 18:03:14', '2026-05-20 13:02:02'),
(8, 'Ahmad Fauzi', 'ahmadfauzi@gmail.com', NULL, '$2y$12$dglw2GMLiM4d1qxTCtt/eukkdSb1YWuhQDLtY1.mej5m3Q3.AMabO', 'karyawan', 0.00, 0.00, NULL, '2026-05-07 18:15:10', '2026-05-07 18:15:10'),
(9, 'Budi Santoso', 'budisantoso@gmail.com', NULL, '$2y$12$ZIWN5s92wXX/FUyyOV/JEOe8GH1m8vpWwabR.6KxZrVblvVcLzP9i', 'karyawan', 0.00, 0.00, NULL, '2026-05-07 18:15:10', '2026-05-07 18:15:10'),
(10, 'Citra Lestari', 'citralestari@gmail.com', NULL, '$2y$12$yxF53H2rH8GHH9YHN.ylHuVtWnDi6AOMqiyJMS.IfLwXpA0M3B28C', 'karyawan', 0.00, 0.00, NULL, '2026-05-07 18:15:11', '2026-05-07 18:15:11'),
(11, 'Dewi Anggraini', 'dewianggraini@gmail.com', NULL, '$2y$12$sZQfRFeMA./guUlQAr9ZNOrADTDs8Eq4akJC/CYWgXvUhmAsSfhFK', 'karyawan', 0.00, 0.00, NULL, '2026-05-07 18:15:11', '2026-05-07 18:15:11'),
(12, 'Eko Prasetyo', 'ekoprasetyo@gmail.com', NULL, '$2y$12$Zm0cwSXntTInWb/fLrI0n.QT4FVMHPQ.i9rUa2r8cj6GDYWr274L.', 'karyawan', 0.00, 0.00, NULL, '2026-05-07 18:15:11', '2026-05-07 18:15:11'),
(13, 'Fitri Handayani', 'fitrihandayani@gmail.com', NULL, '$2y$12$6I7pTcx5HtA/ZnmJ9vrSxebqc9d.vBcnBJ.YqBbvZjSkPx2DCmE.a', 'karyawan', 0.00, 0.00, NULL, '2026-05-07 18:15:12', '2026-05-07 18:15:12'),
(14, 'Gilang Ramadhan', 'gilangramadhan@gmail.com', NULL, '$2y$12$w3JqDedDjLBj/T9rQvSK1e9PLOQpXQ4Zn61pPhLepH51KQOr0Dgpa', 'karyawan', 0.00, 0.00, NULL, '2026-05-07 18:15:12', '2026-05-07 18:15:12'),
(15, 'Hendra Wijaya', 'hendrawijaya@gmail.com', NULL, '$2y$12$CX4h6gb0sTcEPWRalQ5EsOpwNnEOWoZifyhL//n2mVBvcwz68icCW', 'karyawan', 0.00, 0.00, NULL, '2026-05-07 18:15:12', '2026-05-07 18:15:12'),
(16, 'Intan Permata', 'intanpermata@gmail.com', NULL, '$2y$12$xBWlwJXNKYkJNGFK1xj13uwN7MZJiSOT8w6S/oGlpVLy2eyblgRjK', 'karyawan', 4800000.00, 20000.00, NULL, '2026-05-07 18:15:13', '2026-05-07 18:18:46'),
(17, 'Joko Susilo', 'jokosusilo@gmail.com', NULL, '$2y$12$f1fFbOCzvRow6D8fMHC.juLjz.K0Ihw.TR4so9NdNYXTqKyq7nwIG', 'karyawan', 0.00, 0.00, NULL, '2026-05-07 18:15:13', '2026-05-07 18:15:13');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendances_user_id_attendance_date_unique` (`user_id`,`attendance_date`);

--
-- Indeks untuk tabel `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leaves_user_id_foreign` (`user_id`),
  ADD KEY `leaves_approved_by_foreign` (`approved_by`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `overtimes`
--
ALTER TABLE `overtimes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `overtimes_user_id_foreign` (`user_id`),
  ADD KEY `overtimes_approved_by_foreign` (`approved_by`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `overtimes`
--
ALTER TABLE `overtimes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `leaves_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `leaves_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `overtimes`
--
ALTER TABLE `overtimes`
  ADD CONSTRAINT `overtimes_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `overtimes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
