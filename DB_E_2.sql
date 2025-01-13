-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Des 2024 pada 06.02
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
-- Database: `tubes_pw`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_telp` varchar(255) NOT NULL,
  `admin_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `admin_name`, `admin_email`, `admin_password`, `admin_telp`, `admin_picture`) VALUES
(1, 'Febry Sigmahan', 'febry@gmail.com', '11111111', '1234567890', 'zeta.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `id_booking` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hall_package`
--

CREATE TABLE `hall_package` (
  `id_hall_package` int(11) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `capacity` int(11) NOT NULL,
  `facility` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `package_picture` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hall_package`
--

INSERT INTO `hall_package` (`id_hall_package`, `package_name`, `price`, `capacity`, `facility`, `description`, `package_picture`, `created_at`, `updated_at`) VALUES
(19, 'Wedding Package', 80000000, 150, 'Master of Ceremony, Event Organizer, Sound System, Projector, Consumption Included', 'Wedding Package for your best moment', 'Wedding.jpg', NULL, NULL),
(21, 'Meeting Package', 12000000, 10, 'Moderator, Sound System, Projector, Consumption Not Included', 'Discuss Your Important Things Here', 'meeting.jpg', NULL, NULL),
(22, 'Birthday Package', 50000000, 100, 'Master of Ceremony, Sound System, Projector, Consumption Included', 'For Your Birthday', 'birthday.jpeg', NULL, NULL);

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
(1, '2024_11_13_010412_create_personal_access_tokens_table', 1),
(3, '2024_11_13_123156_create_sessions_table', 2),
(4, '2024_11_23_134503_add_timestamps_to_hall_package_table', 3),
(5, '2024_12_01_123657_create_room_type_table', 4),
(6, '2024_12_11_150927_add_timestamps_to_users_table', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment`
--

CREATE TABLE `payment` (
  `id_payment` int(11) NOT NULL,
  `id_booking` int(11) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `payment_status` tinyint(1) NOT NULL,
  `total_price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
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
-- Struktur dari tabel `rooms`
--

CREATE TABLE `rooms` (
  `id_room` int(11) NOT NULL,
  `id_room_type` int(11) DEFAULT NULL,
  `room_number` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rooms`
--

INSERT INTO `rooms` (`id_room`, `id_room_type`, `room_number`, `status`) VALUES
(1, 51, 1, 0),
(2, 51, 2, 0),
(3, 51, 3, 0),
(4, 51, 4, 0),
(5, 51, 5, 0),
(6, 51, 6, 0),
(7, 51, 7, 0),
(8, 51, 8, 0),
(9, 51, 9, 0),
(10, 51, 10, 0),
(11, 51, 11, 0),
(12, 51, 12, 0),
(13, 51, 13, 0),
(14, 51, 14, 0),
(15, 51, 15, 0),
(16, 51, 16, 0),
(17, 51, 17, 0),
(18, 51, 18, 0),
(19, 51, 19, 0),
(20, 51, 20, 0),
(21, 51, 21, 0),
(22, 51, 22, 0),
(23, 51, 23, 0),
(24, 51, 24, 0),
(25, 51, 25, 0),
(26, 52, 26, 0),
(27, 52, 27, 0),
(28, 52, 28, 0),
(29, 52, 29, 0),
(30, 52, 30, 0),
(31, 52, 31, 0),
(32, 52, 32, 0),
(33, 52, 33, 0),
(34, 52, 34, 0),
(35, 52, 35, 0),
(36, 52, 36, 0),
(37, 52, 37, 0),
(38, 52, 38, 0),
(39, 52, 39, 0),
(40, 52, 40, 0),
(41, 52, 41, 0),
(42, 52, 42, 0),
(43, 52, 43, 0),
(44, 52, 44, 0),
(45, 52, 45, 0),
(46, 52, 46, 0),
(47, 52, 47, 0),
(48, 52, 48, 0),
(49, 52, 49, 0),
(50, 52, 50, 0),
(51, 54, 51, 0),
(52, 54, 52, 0),
(53, 54, 53, 0),
(54, 54, 54, 0),
(55, 54, 55, 0),
(56, 54, 56, 0),
(57, 54, 57, 0),
(58, 54, 58, 0),
(59, 54, 59, 0),
(60, 54, 60, 0),
(61, 54, 61, 0),
(62, 54, 62, 0),
(63, 54, 63, 0),
(64, 54, 64, 0),
(65, 54, 65, 0),
(66, 54, 66, 0),
(67, 54, 67, 0),
(68, 54, 68, 0),
(69, 54, 69, 0),
(70, 54, 70, 0),
(71, 54, 71, 0),
(72, 54, 72, 0),
(73, 54, 73, 0),
(74, 54, 74, 0),
(75, 54, 75, 0),
(76, NULL, 76, 0),
(77, NULL, 77, 0),
(78, NULL, 78, 0),
(79, NULL, 79, 0),
(80, NULL, 80, 0),
(81, NULL, 81, 0),
(82, NULL, 82, 0),
(83, NULL, 83, 0),
(84, NULL, 84, 0),
(85, NULL, 85, 0),
(86, NULL, 86, 0),
(87, NULL, 87, 0),
(88, NULL, 88, 0),
(89, NULL, 89, 0),
(90, NULL, 90, 0),
(91, NULL, 91, 0),
(92, NULL, 92, 0),
(93, NULL, 93, 0),
(94, NULL, 94, 0),
(95, NULL, 95, 0),
(96, NULL, 96, 0),
(97, NULL, 97, 0),
(98, NULL, 98, 0),
(99, NULL, 99, 0),
(100, NULL, 100, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `room_type`
--

CREATE TABLE `room_type` (
  `id_room_type` int(11) NOT NULL,
  `name_type` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `number_of_room` int(11) NOT NULL,
  `maximum_people` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `facility` varchar(255) NOT NULL,
  `room_picture` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `room_type`
--

INSERT INTO `room_type` (`id_room_type`, `name_type`, `price`, `number_of_room`, `maximum_people`, `description`, `facility`, `room_picture`, `created_at`, `updated_at`) VALUES
(51, 'President Room', 2500000, 25, 2, 'Room For The Richest Man Alive', 'Bed Type : Queen, Bathtub, Breakfast, Lunch, Dinner, Heater Included, Smoking No', 'presidentRoom.jpg', NULL, NULL),
(52, 'Luxury Room', 1000000, 25, 2, 'Room For A Good People With Money', 'Bed Type : Double, Bathtub, Breakfast, Dinner, Heater Included, Smoking No', 'Luxury Room.jpeg', NULL, NULL),
(54, 'Standard Room', 500000, 25, 3, 'For Reguler People', 'Bed Type : Single, Shower, Breakfast, Heater Not Included, Smoking Yes', 'Standard Room.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
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
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('biZ8wvkwN5bruxBcty8iDffctYeIhwG0I7iwNMmJ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVUhNcERTNkUxazhzSkdGV1JEUU56dGRjN2dBaDI0cHBIb004b0xlVCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxODoiYWRtaW5fbG9nZ2VkX2luX2F0IjtPOjI1OiJJbGx1bWluYXRlXFN1cHBvcnRcQ2FyYm9uIjozOntzOjQ6ImRhdGUiO3M6MjY6IjIwMjQtMTItMTcgMDU6MDI6MjAuNTU1MzgwIjtzOjEzOiJ0aW1lem9uZV90eXBlIjtpOjM7czo4OiJ0aW1lem9uZSI7czozOiJVVEMiO319', 1734411742);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_hall`
--

CREATE TABLE `transaksi_hall` (
  `id_transaksi_hall` int(11) NOT NULL,
  `id_booking` int(11) NOT NULL,
  `id_hall_package` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `attendee_number` int(11) NOT NULL,
  `status_checkout` tinyint(1) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_kamar`
--

CREATE TABLE `transaksi_kamar` (
  `id_transaksi_kamar` int(11) NOT NULL,
  `id_booking` int(11) NOT NULL,
  `id_room` int(11) NOT NULL,
  `extra_bed` tinyint(1) NOT NULL,
  `status_checkout` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `user_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `first_name`, `last_name`, `email`, `password`, `telepon`, `user_picture`, `created_at`, `updated_at`) VALUES
(11, 'Eric', 'Daniswara', 'eric@gmail.com', '11111111', '1234567890', 'zeta.jpg', NULL, NULL),
(14, 'Agusssss', 'AgusAgus', 'agus@gmail.com', '11111111', '1234567890', 'logo.jpg', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `user_id_fk_bookings` (`id_user`);

--
-- Indeks untuk tabel `hall_package`
--
ALTER TABLE `hall_package`
  ADD PRIMARY KEY (`id_hall_package`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id_payment`),
  ADD KEY `id_booking_fk_payment` (`id_booking`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id_room`),
  ADD KEY `room_type_id_fk` (`id_room_type`);

--
-- Indeks untuk tabel `room_type`
--
ALTER TABLE `room_type`
  ADD PRIMARY KEY (`id_room_type`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `transaksi_hall`
--
ALTER TABLE `transaksi_hall`
  ADD PRIMARY KEY (`id_transaksi_hall`),
  ADD KEY `booking_id_fk` (`id_booking`),
  ADD KEY `hall_package_id_fk` (`id_hall_package`);

--
-- Indeks untuk tabel `transaksi_kamar`
--
ALTER TABLE `transaksi_kamar`
  ADD PRIMARY KEY (`id_transaksi_kamar`),
  ADD KEY `id_booking_fk_transaksi_kamar` (`id_booking`),
  ADD KEY `id_room_fk` (`id_room`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id_booking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=256;

--
-- AUTO_INCREMENT untuk tabel `hall_package`
--
ALTER TABLE `hall_package`
  MODIFY `id_hall_package` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `payment`
--
ALTER TABLE `payment`
  MODIFY `id_payment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id_room` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT untuk tabel `room_type`
--
ALTER TABLE `room_type`
  MODIFY `id_room_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `transaksi_hall`
--
ALTER TABLE `transaksi_hall`
  MODIFY `id_transaksi_hall` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT untuk tabel `transaksi_kamar`
--
ALTER TABLE `transaksi_kamar`
  MODIFY `id_transaksi_kamar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `user_id_fk_bookings` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `id_booking_fk_payment` FOREIGN KEY (`id_booking`) REFERENCES `bookings` (`id_booking`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `room_type_id_fk` FOREIGN KEY (`id_room_type`) REFERENCES `room_type` (`id_room_type`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi_hall`
--
ALTER TABLE `transaksi_hall`
  ADD CONSTRAINT `booking_id_fk` FOREIGN KEY (`id_booking`) REFERENCES `bookings` (`id_booking`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hall_package_id_fk` FOREIGN KEY (`id_hall_package`) REFERENCES `hall_package` (`id_hall_package`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi_kamar`
--
ALTER TABLE `transaksi_kamar`
  ADD CONSTRAINT `id_booking_fk_transaksi_kamar` FOREIGN KEY (`id_booking`) REFERENCES `bookings` (`id_booking`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_room_fk` FOREIGN KEY (`id_room`) REFERENCES `rooms` (`id_room`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
