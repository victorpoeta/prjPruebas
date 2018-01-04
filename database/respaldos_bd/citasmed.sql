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
-- Database: `citasmed`
--

-- --------------------------------------------------------

--
-- Table structure for table `cita`
--

CREATE TABLE `cita` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `fecha_cita` date NOT NULL,
  `id_horario` int(11) NOT NULL,
  `id_estatus` int(11) NOT NULL,
  `fecha_cre` datetime NOT NULL,
  `id_usuario_cre` int(11) NOT NULL,
  `fecha_mod` datetime DEFAULT NULL,
  `id_usuario_mod` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `especialidad`
--

CREATE TABLE `especialidad` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `especialidad`
--

INSERT INTO `especialidad` (`id`, `nombre`, `activo`) VALUES
(1, 'MEDICINA GENERAL', 1),
(2, 'CARDIOLOGíA', 1),
(3, 'NEFROLOGíA', 1),
(4, 'NEUROLOGíA', 1),
(5, 'PSIQUIATRíA', 1),
(6, 'DERMATOLOGíA', 1),
(7, 'GINECOLOGíA', 1),
(8, 'ONCOLOGíA', 1),
(9, 'UROLOGíA', 1),
(10, 'CIRUGíA MAXILOFACIAL', 1),
(11, 'PEDIATRíA', 1),
(12, 'ODONTOLOGíA', 1),
(13, 'OTORRINOLARINGOLOGíA', 1),
(14, 'ENDOCRINOLOGíA', 1),
(15, 'OFTALMOLOGíA', 1);

-- --------------------------------------------------------

--
-- Table structure for table `estado`
--

CREATE TABLE `estado` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_pais` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `estado`
--

INSERT INTO `estado` (`id`, `id_pais`, `nombre`) VALUES
(1, 23, 'AMAZONAS'),
(2, 23, 'APURE'),
(3, 23, 'ARAGUA'),
(4, 23, 'BARINAS'),
(5, 23, 'BOLIVAR'),
(6, 23, 'CARABOBO'),
(7, 23, 'COJEDES'),
(8, 23, 'DISTRITO CAPITAL'),
(9, 23, 'FALCON'),
(10, 23, 'GUARICO'),
(11, 23, 'LARA'),
(12, 23, 'MERIDA'),
(13, 23, 'MIRANDA'),
(14, 23, 'MONAGAS'),
(15, 23, 'SUCRE'),
(16, 23, 'TACHIRA'),
(17, 23, 'TRUJILLO'),
(18, 23, 'VARGAS'),
(19, 23, 'ZULIA');

-- --------------------------------------------------------

--
-- Table structure for table `estatus`
--

CREATE TABLE `estatus` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `siglas` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `estatus`
--

INSERT INTO `estatus` (`id`, `nombre`, `siglas`) VALUES
(1, 'CITADO', 'CI'),
(2, 'ATENDIDO', 'AT'),
(3, 'ANULADO', 'AN'),
(4, 'NO ATENDIO LLAMADO', 'NA');

-- --------------------------------------------------------

--
-- Table structure for table `horario`
--

CREATE TABLE `horario` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_especialidad` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `id_turno` int(11) NOT NULL,
  `dia` int(11) NOT NULL,
  `hora_desde` time NOT NULL,
  `hora_hasta` time NOT NULL,
  `cupo` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medico`
--

CREATE TABLE `medico` (
  `id` int(10) UNSIGNED NOT NULL,
  `cedula` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `nombres` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `sexo` enum('M','F') COLLATE utf8_unicode_ci NOT NULL,
  `domicilio` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `medico`
--

INSERT INTO `medico` (`id`, `cedula`, `nombres`, `apellidos`, `sexo`, `domicilio`, `telefono`, `email`) VALUES
(1, '1112233', 'JUAN', 'PEREZ', 'M', 'Caracas', '2125553300', '');

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
('2016_09_03_165251_tabla_paciente', 1),
('2016_09_03_165805_tabla_medico', 1),
('2016_09_03_165826_tabla_especialidad', 1),
('2016_09_03_165843_tabla_horario', 1),
('2016_09_03_173603_tabla_turno', 1),
('2016_09_03_174351_tabla_estatus', 1),
('2016_09_03_180112_tabla_cita', 1),
('2016_09_03_180858_tabla_parroquia', 1),
('2016_09_03_181243_tabla_municipio', 1),
('2016_09_03_181256_tabla_estado', 1),
('2016_09_03_181307_tabla_pais', 1),
('2016_09_03_181722_tabla_usuario_cita', 1);

-- --------------------------------------------------------

--
-- Table structure for table `municipio`
--

CREATE TABLE `municipio` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_estado` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `municipio`
--

INSERT INTO `municipio` (`id`, `id_estado`, `nombre`) VALUES
(1, 8, 'LIBERTADOR'),
(2, 13, 'BARUTA'),
(3, 13, 'CHACAO'),
(4, 13, 'EL HATILLO'),
(5, 13, 'SUCRE');

-- --------------------------------------------------------

--
-- Table structure for table `paciente`
--

CREATE TABLE `paciente` (
  `id` int(10) UNSIGNED NOT NULL,
  `cedula` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `nombres` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `sexo` enum('M','F') COLLATE utf8_unicode_ci NOT NULL,
  `fecha_nac` date NOT NULL,
  `id_parroquia` int(11) NOT NULL,
  `domicilio` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `antec_pers` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `antec_fam` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `alergias` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pais`
--

CREATE TABLE `pais` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pais`
--

INSERT INTO `pais` (`id`, `nombre`) VALUES
(1, 'ALEMANIA'),
(2, 'ARGENTINA'),
(3, 'BOLIVIA'),
(4, 'BRASIL'),
(5, 'COLOMBIA'),
(6, 'CUBA'),
(7, 'ECUADOR'),
(8, 'EL SALVADOR'),
(9, 'ESPAñA'),
(10, 'FRANCIA'),
(11, 'GUATEMALA'),
(12, 'GUYANA'),
(13, 'HAITI'),
(14, 'ITALIA'),
(15, 'NICARAGUA'),
(16, 'PANAMá'),
(17, 'PARAGUAY'),
(18, 'PERú'),
(19, 'PORTUGAL'),
(20, 'REPUBLICA DOMINICANA'),
(21, 'USA'),
(22, 'URUGUAY'),
(23, 'VENEZUELA');

-- --------------------------------------------------------

--
-- Table structure for table `parroquia`
--

CREATE TABLE `parroquia` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_municipio` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `parroquia`
--

INSERT INTO `parroquia` (`id`, `id_municipio`, `nombre`, `activo`) VALUES
(1, 1, '23 DE ENERO', 1),
(2, 1, 'ALTAGRACIA', 1),
(3, 1, 'ANTIMANO', 1),
(4, 1, 'CARICUAO', 1),
(5, 1, 'COCHE', 1),
(6, 1, 'EL JUNQUITO', 1),
(7, 1, 'EL PARAISO', 1),
(8, 1, 'EL RECREO', 1),
(9, 1, 'EL VALLE', 1),
(10, 1, 'LA CANDELARIA', 1),
(11, 1, 'LA PASTORA', 1),
(12, 1, 'LA VEGA', 1),
(13, 1, 'SAN BERNANDINO', 1),
(14, 1, 'SAN JOSE', 1),
(15, 1, 'SAN JUAN', 1),
(16, 1, 'SAN PEDRO', 1),
(17, 1, 'SANTA ROSALIA', 1),
(18, 1, 'SANTA TERESA', 1),
(19, 1, 'SUCRE', 1),
(20, 3, 'CHACAO', 1),
(21, 2, 'BARUTA', 1),
(22, 2, 'EL CAFETAL', 1),
(23, 2, 'LAS MINAS', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `turno`
--

CREATE TABLE `turno` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(40) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `turno`
--

INSERT INTO `turno` (`id`, `nombre`) VALUES
(1, 'MAÑANA'),
(2, 'TARDE'),
(3, 'NOCHE'),
(4, 'AMBOS (MAÑANA Y TARDE)');

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

-- --------------------------------------------------------

--
-- Table structure for table `usuario_cita`
--

CREATE TABLE `usuario_cita` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `nombres` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `clave` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `usuario_cita`
--

INSERT INTO `usuario_cita` (`id`, `login`, `nombres`, `apellidos`, `clave`, `password`, `activo`, `created_at`, `updated_at`) VALUES
(2, 'vpoeta', 'Victor', 'Poeta', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '$2y$10$ZQCtshrJEA9xnuqeinv5guDo9bPJH3S.n8.Rbi4Wu9axXbrVrBSMS', 1, '2017-03-06 23:08:50', '2017-03-06 23:08:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estatus`
--
ALTER TABLE `estatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `municipio`
--
ALTER TABLE `municipio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parroquia`
--
ALTER TABLE `parroquia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `turno`
--
ALTER TABLE `turno`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `usuario_cita`
--
ALTER TABLE `usuario_cita`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_cita_login_unique` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cita`
--
ALTER TABLE `cita`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `estado`
--
ALTER TABLE `estado`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `estatus`
--
ALTER TABLE `estatus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `horario`
--
ALTER TABLE `horario`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `medico`
--
ALTER TABLE `medico`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `municipio`
--
ALTER TABLE `municipio`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pais`
--
ALTER TABLE `pais`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `parroquia`
--
ALTER TABLE `parroquia`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `turno`
--
ALTER TABLE `turno`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuario_cita`
--
ALTER TABLE `usuario_cita`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
