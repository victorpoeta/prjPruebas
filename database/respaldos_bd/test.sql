-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 26, 2017 at 05:34 AM
-- Server version: 10.2.3-MariaDB-log
-- PHP Version: 5.6.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_12_29_185453_create_sessions_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pagos`
--

CREATE TABLE `pagos` (
  `idpago` int(11) NOT NULL,
  `idestatuspago` int(11) NOT NULL,
  `idempresa` int(11) NOT NULL,
  `idtransbanc` int(11) NOT NULL,
  `montototal` double NOT NULL,
  `emailpagador` varchar(100) NOT NULL,
  `codusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Pago por transferencia';

--
-- Dumping data for table `pagos`
--

INSERT INTO `pagos` (`idpago`, `idestatuspago`, `idempresa`, `idtransbanc`, `montototal`, `emailpagador`, `codusuario`) VALUES
(172, 1, 1, 24, 1520.75, 'vpoeta@grupozoom.com', 3333),
(173, 1, 1, 24, 3041.5, 'vpoeta@grupozoom.com', 3334),
(174, 1, 1, 24, 4562.25, 'vpoeta@grupozoom.com', 3335),
(190, 1, 1, 24, 1520.75, 'vpoeta@grupozoom.com', 3333),
(191, 1, 1, 24, 3041.5, 'vpoeta@grupozoom.com', 3334),
(192, 1, 1, 24, 4562.25, 'vpoeta@grupozoom.com', 3335),
(205, 1, 1, 24, 1520.75, 'vpoeta@grupozoom.com', 3333),
(206, 1, 1, 24, 3041.5, 'vpoeta@grupozoom.com', 3334),
(207, 1, 1, 24, 4562.25, 'vpoeta@grupozoom.com', 3335),
(211, 1, 1, 24, 1520.75, 'vpoeta@grupozoom.com', 3333),
(212, 1, 1, 24, 3041.5, 'vpoeta@grupozoom.com', 3334),
(213, 1, 1, 24, 4562.25, 'vpoeta@grupozoom.com', 3335),
(214, 1, 1, 24, 1520.75, 'vpoeta@grupozoom.com', 3333),
(215, 1, 1, 24, 3041.5, 'vpoeta@grupozoom.com', 3334),
(216, 1, 1, 24, 4562.25, 'vpoeta@grupozoom.com', 3335),
(217, 1, 1, 24, 1520.75, 'vpoeta@grupozoom.com', 3333),
(218, 1, 1, 24, 3041.5, 'vpoeta@grupozoom.com', 3334),
(219, 1, 1, 24, 4562.25, 'vpoeta@grupozoom.com', 3335),
(220, 1, 1, 24, 1520.75, 'vpoeta@grupozoom.com', 3333),
(221, 1, 1, 24, 3041.5, 'vpoeta@grupozoom.com', 3334),
(222, 1, 1, 24, 4562.25, 'vpoeta@grupozoom.com', 3335),
(223, 1, 1, 24, 1520.75, 'vpoeta@grupozoom.com', 3333),
(224, 1, 1, 24, 3041.5, 'vpoeta@grupozoom.com', 3334),
(225, 1, 1, 24, 4562.25, 'vpoeta@grupozoom.com', 3335),
(226, 1, 1, 24, 1520.75, 'vpoeta@grupozoom.com', 3333),
(227, 1, 1, 24, 3041.5, 'vpoeta@grupozoom.com', 3334),
(228, 1, 1, 24, 4562.25, 'vpoeta@grupozoom.com', 3335),
(229, 1, 1, 24, 1520.75, 'vpoeta@grupozoom.com', 3333),
(230, 1, 1, 24, 3041.5, 'vpoeta@grupozoom.com', 3334),
(231, 1, 1, 24, 4562.25, 'vpoeta@grupozoom.com', 3335),
(232, 1, 1, 24, 1520.75, 'vpoeta@grupozoom.com', 3333),
(233, 1, 1, 24, 3041.5, 'vpoeta@grupozoom.com', 3334),
(234, 1, 1, 24, 4562.25, 'vpoeta@grupozoom.com', 3335),
(235, 1, 1, 24, 1520.75, 'vpoeta@grupozoom.com', 3333),
(236, 1, 1, 24, 3041.5, 'vpoeta@grupozoom.com', 3334),
(237, 1, 1, 24, 4562.25, 'vpoeta@grupozoom.com', 3335);

-- --------------------------------------------------------

--
-- Table structure for table `pagos_doc`
--

CREATE TABLE `pagos_doc` (
  `id` int(11) NOT NULL,
  `idpago` int(11) NOT NULL,
  `tipodoc` int(11) NOT NULL,
  `nrodoc` varchar(25) NOT NULL,
  `monto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Detalle de pagos por transferencia';

--
-- Dumping data for table `pagos_doc`
--

INSERT INTO `pagos_doc` (`id`, `idpago`, `tipodoc`, `nrodoc`, `monto`) VALUES
(23, 172, 1, '123456712', 250),
(24, 173, 2, '01E105-00001102', 1171),
(25, 174, 1, '91500121', 100),
(36, 190, 1, '123456712', 250),
(37, 191, 2, '01E105-00001102', 1171),
(38, 192, 1, '91500121', 100),
(47, 205, 1, '123456712', 250),
(48, 206, 2, '01E105-00001102', 1171),
(49, 207, 1, '91500121', 100),
(52, 211, 1, '123456712', 250),
(53, 212, 2, '01E105-00001102', 1171),
(54, 213, 1, '91500121', 100),
(55, 214, 1, '123456712', 250),
(56, 215, 2, '01E105-00001102', 1171),
(57, 216, 1, '91500121', 100),
(58, 217, 1, '123456712', 250),
(59, 218, 2, '01E105-00001102', 1171),
(60, 219, 1, '91500121', 100),
(61, 220, 1, '123456712', 250),
(62, 221, 2, '01E105-00001102', 1171),
(63, 222, 1, '91500121', 100),
(64, 223, 1, '123456712', 250),
(65, 224, 2, '01E105-00001102', 1171),
(66, 225, 1, '91500121', 100),
(67, 226, 1, '123456712', 250),
(68, 227, 2, '01E105-00001102', 1171),
(69, 228, 1, '91500121', 100),
(70, 229, 1, '123456712', 250),
(71, 230, 2, '01E105-00001102', 1171),
(72, 231, 1, '91500121', 100),
(73, 232, 1, '123456712', 250),
(74, 233, 2, '01E105-00001102', 1171),
(75, 234, 1, '91500121', 100),
(76, 235, 1, '123456712', 250),
(77, 236, 2, '01E105-00001102', 1171),
(78, 237, 1, '91500121', 100);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp
) ;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  `login` varchar(40) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`, `login`) VALUES
('fc69987144a8a47791f87aad85f6147be94e3e7d', NULL, '10.0.3.49', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWE81bTZRZzA4V29Dbm9JNTlTQVZ6bXhsanN5RDJUdnVRWXRpSTZtdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTAyOiJodHRwOi8vMTAuMC4zLjQ5L3ByalBydWViYXMvcHVibGljL0NpdWRhZFppcENvZGVESEwyP2ZpbHRyb0NpdWRhZD1NQUQmbm9tYnJlX3BhaXM9c3BhaW4mc2lnbGFzX3BhaXM9RVMiO31zOjU6ImZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToiX3NmMl9tZXRhIjthOjM6e3M6MToidSI7aToxNDk1NDgwOTQyO3M6MToiYyI7aToxNDk1NDY1MTQ0O3M6MToibCI7czoxOiIwIjt9fQ==', 1495480942, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`idpago`);

--
-- Indexes for table `pagos_doc`
--
ALTER TABLE `pagos_doc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `sessions_id_unique` (`id`);

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
-- AUTO_INCREMENT for table `pagos`
--
ALTER TABLE `pagos`
  MODIFY `idpago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;
--
-- AUTO_INCREMENT for table `pagos_doc`
--
ALTER TABLE `pagos_doc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
