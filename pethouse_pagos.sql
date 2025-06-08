-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-06-2025 a las 19:52:40
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pethouse_pagos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boletas`
--

CREATE TABLE `boletas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `referencia` varchar(50) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `boletas`
--

INSERT INTO `boletas` (`id`, `usuario_id`, `total`, `referencia`, `fecha`) VALUES
(1, 0, 18.50, 'PET-6843D06CE0E97', '2025-06-07 05:38:52'),
(2, 0, 18.50, 'PET-6843D08D70F87', '2025-06-07 05:39:25'),
(3, 0, 18.50, 'PET-6843D09233F1D', '2025-06-07 05:39:30'),
(4, 0, 18.50, 'PET-6843D0A551869', '2025-06-07 05:39:49'),
(5, 0, 18.50, 'PET-6843D5030F935', '2025-06-07 05:58:27'),
(6, 0, 18.50, 'PET-6843D5BFCA8A0', '2025-06-07 06:01:35'),
(7, 0, 18.50, 'PET-6843D6693B9F3', '2025-06-07 06:04:25'),
(8, 0, 18.50, 'PET-6843D66B4A6E5', '2025-06-07 06:04:27'),
(9, 0, 18.50, 'PET-6843D74FAD674', '2025-06-07 06:08:15'),
(10, 0, 25.99, 'PET-6843D765B06C4', '2025-06-07 06:08:38'),
(11, 0, 92.50, 'PET-6843D82226F79', '2025-06-07 06:11:46'),
(12, 0, 25.99, 'PET-6843D9794A80E', '2025-06-07 06:17:29'),
(13, 0, 25.99, 'PET-6843DAE8AB8BF', '2025-06-07 06:23:36'),
(14, 0, 597.77, 'PET-6843DF840CD7D', '2025-06-07 06:43:16'),
(15, 0, 58.50, 'PET-6844ACAE68A0B', '2025-06-07 21:18:38'),
(16, 0, 25.99, 'PET-6844DE51D1249', '2025-06-08 00:50:25'),
(17, 0, 25.99, 'PET-684512AA5DC32', '2025-06-08 04:33:46'),
(18, 0, 25.99, 'PET-6845135BC5EA5', '2025-06-08 04:36:43'),
(19, 0, 44.49, 'PET-684524840A831', '2025-06-08 05:49:56'),
(20, 0, 44.49, 'PET-6845274A2D63A', '2025-06-08 06:01:46'),
(21, 0, 133.47, 'PET-684527B8C9AEA', '2025-06-08 06:03:36'),
(22, 0, 55.50, 'PET-68452B34D1C1F', '2025-06-08 06:18:28'),
(23, 0, 88.98, 'PET-68452F0785B24', '2025-06-08 06:34:47'),
(24, 0, 88.98, 'PET-6845A04E7B687', '2025-06-08 14:38:06'),
(25, 0, 181.93, 'PET-6845A076126AE', '2025-06-08 14:38:46'),
(26, 0, 259.90, 'PET-6845A28206265', '2025-06-08 14:47:30'),
(27, 0, 122.46, 'PET-6845A2DDF2446', '2025-06-08 14:49:01'),
(28, 0, 18.50, 'PET-6845ADE3142C5', '2025-06-08 15:36:03'),
(29, 0, 25.99, 'PET-6845AE1705A9F', '2025-06-08 15:36:55'),
(30, 7, 18.50, 'PET-6845AF85BCF14', '2025-06-08 15:43:01'),
(31, 7, 185.45, 'PET-6845B189AE9BB', '2025-06-08 15:51:37'),
(32, 7, 44.49, 'PET-6845B29EDEABB', '2025-06-08 15:56:14'),
(33, 7, 37.00, 'PET-6845B69DEDAD3', '2025-06-08 16:13:17'),
(34, 7, 3.00, 'PET-6845B72017DE1', '2025-06-08 16:15:28'),
(35, 7, 18.50, 'PET-6845C1B7ADEED', '2025-06-08 17:00:39'),
(36, 7, 337.87, 'PET-6845C93391005', '2025-06-08 17:32:35'),
(37, 7, 228.00, 'PET-6845CD875644E', '2025-06-08 17:51:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boleta_detalles`
--

CREATE TABLE `boleta_detalles` (
  `id` int(11) NOT NULL,
  `boleta_id` int(11) NOT NULL,
  `producto_nombre` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `boleta_detalles`
--

INSERT INTO `boleta_detalles` (`id`, `boleta_id`, `producto_nombre`, `cantidad`, `subtotal`) VALUES
(1, 9, 'Antiparasitario', 1, 18.50),
(2, 10, 'Alimento Premium', 1, 25.99),
(3, 11, 'Antiparasitario', 5, 92.50),
(4, 12, 'Alimento Premium', 1, 25.99),
(5, 13, 'Alimento Premium', 1, 25.99),
(6, 14, 'Alimento Premium', 23, 597.77),
(7, 15, 'Antiparasitario', 1, 18.50),
(8, 15, 'romel', 1, 40.00),
(9, 16, 'Alimento Premium', 1, 25.99),
(10, 17, 'Alimento Premium', 1, 25.99),
(11, 18, 'Alimento Premium', 1, 25.99),
(12, 19, 'Alimento Premium', 1, 25.99),
(13, 19, 'Antiparasitario', 1, 18.50),
(14, 20, 'Alimento Premium', 1, 25.99),
(15, 20, 'Antiparasitario', 1, 18.50),
(16, 21, 'Alimento Premium', 3, 77.97),
(17, 21, 'Antiparasitario', 3, 55.50),
(18, 22, 'Antiparasitario', 3, 55.50),
(19, 23, 'Alimento Premium', 2, 51.98),
(20, 23, 'Antiparasitario', 2, 37.00),
(21, 24, 'Alimento Premium', 2, 51.98),
(22, 24, 'Antiparasitario', 2, 37.00),
(23, 25, 'Alimento Premium', 7, 181.93),
(24, 26, 'Alimento Premium', 10, 259.90),
(25, 27, 'Alimento Premium', 4, 103.96),
(26, 27, 'Antiparasitario', 1, 18.50),
(27, 28, 'Antiparasitario', 1, 18.50),
(28, 29, 'Alimento Premium', 1, 25.99),
(29, 30, 'Antiparasitario', 1, 18.50),
(30, 31, 'Alimento Premium', 5, 129.95),
(31, 31, 'Antiparasitario', 3, 55.50),
(32, 32, 'Alimento Premium', 1, 25.99),
(33, 32, 'Antiparasitario', 1, 18.50),
(34, 33, 'Antiparasitario', 2, 37.00),
(35, 34, 'periquito pin pin', 3, 3.00),
(36, 35, 'Antiparasitario', 1, 18.50),
(37, 36, 'Alimento Premium', 13, 337.87),
(38, 37, 'periquito pin pin', 19, 228.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjetas`
--

CREATE TABLE `tarjetas` (
  `id` int(11) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `expiracion` varchar(7) NOT NULL,
  `cvv` varchar(5) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tarjetas`
--

INSERT INTO `tarjetas` (`id`, `numero`, `nombre`, `expiracion`, `cvv`, `creado_en`) VALUES
(1, '11111111111111111111', 'romel', '12/2023', '583', '2025-06-07 05:38:52'),
(2, '111111111111111', 'romel', '12/2026', '123', '2025-06-07 05:39:49'),
(3, '111111111111', 'romel', '12/2025', '521', '2025-06-07 05:46:31'),
(4, '11111111111', 'roeml', '12/2028', '123', '2025-06-07 05:53:38'),
(5, '1111', '111', '11/2020', '123', '2025-06-07 05:55:36'),
(6, '123', '123', '12//202', '123', '2025-06-07 06:08:37'),
(7, '111', '11', '11/2021', '111', '2025-06-07 06:17:29'),
(8, '11', '11', '11/2021', '111', '2025-06-08 04:36:43'),
(9, '1', '1', '1/1', '11', '2025-06-08 06:18:28'),
(10, '2', '2', '2', '2', '2025-06-08 16:15:27');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `boletas`
--
ALTER TABLE `boletas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `referencia` (`referencia`);

--
-- Indices de la tabla `boleta_detalles`
--
ALTER TABLE `boleta_detalles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `boleta_id` (`boleta_id`);

--
-- Indices de la tabla `tarjetas`
--
ALTER TABLE `tarjetas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero` (`numero`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `boletas`
--
ALTER TABLE `boletas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `boleta_detalles`
--
ALTER TABLE `boleta_detalles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `tarjetas`
--
ALTER TABLE `tarjetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `boleta_detalles`
--
ALTER TABLE `boleta_detalles`
  ADD CONSTRAINT `boleta_detalles_ibfk_1` FOREIGN KEY (`boleta_id`) REFERENCES `boletas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
