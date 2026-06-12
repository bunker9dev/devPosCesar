-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-06-2026 a las 09:42:28
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
-- Base de datos: `devpos_cesar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

DROP TABLE IF EXISTS `auditoria`;
CREATE TABLE `auditoria` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `accion` varchar(50) DEFAULT NULL,
  `tabla` varchar(50) DEFAULT NULL,
  `registro_id` int(11) DEFAULT NULL,
  `detalle` text DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `modulo` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `auditoria`
--

INSERT INTO `auditoria` (`id`, `usuario_id`, `accion`, `tabla`, `registro_id`, `detalle`, `descripcion`, `ip`, `user_agent`, `modulo`, `created_at`) VALUES
(1, 2, 'TEST', 'usuarios', 1, NULL, 'PRUEBA DIRECTA', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:03:08'),
(2, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:05:10'),
(3, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:05:49'),
(4, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:07:40'),
(5, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:08:06'),
(6, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:15:46'),
(7, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:15:54'),
(8, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:18:07'),
(9, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:19:13'),
(10, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:27:00'),
(11, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:43:53'),
(12, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:44:01'),
(13, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:14'),
(14, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:14'),
(15, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:14'),
(16, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:14'),
(17, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:14'),
(18, 1, 'UPDATE', 'usuarios', 5, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:19'),
(19, 1, 'UPDATE', 'usuarios', 6, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:21'),
(20, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:23'),
(21, 1, 'UPDATE', 'usuarios', 5, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:25'),
(22, 1, 'UPDATE', 'usuarios', 6, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:26'),
(23, 1, 'UPDATE', 'usuarios', 7, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:27'),
(24, 1, 'UPDATE', 'usuarios', 6, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:28'),
(25, 1, 'UPDATE', 'usuarios', 5, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:30'),
(26, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:31'),
(27, 1, 'UPDATE', 'usuarios', 7, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:32'),
(28, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 04:15:20'),
(29, 1, 'CREATE', 'usuarios', 8, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 06:57:47'),
(30, 1, 'CREATE', 'usuarios', 9, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:00:26'),
(31, 1, 'CREATE', 'usuarios', 10, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:15:48'),
(32, 1, 'CREATE', 'usuarios', 11, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:17:22'),
(33, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 07:18:42'),
(34, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 07:18:48'),
(35, 1, 'CREATE', 'usuarios', 12, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:23:31'),
(36, 1, 'CREATE', 'usuarios', 13, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:33:09'),
(37, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 07:33:53'),
(38, 1, 'CREATE', 'usuarios', 14, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:34:35'),
(39, 1, 'CREATE', 'usuarios', 15, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:35:11'),
(40, 1, 'CREATE', 'usuarios', 16, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:35:48'),
(41, 1, 'CREATE', 'usuarios', 18, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:36:50'),
(42, 1, 'CREATE', 'usuarios', 19, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:37:09'),
(43, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 07:40:15'),
(44, 1, 'CREATE', 'usuarios', 20, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:40:45'),
(45, 1, 'CREATE', 'usuarios', 22, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:42:25'),
(46, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-14 03:23:41'),
(47, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-14 04:16:03'),
(48, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:12'),
(49, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:12'),
(50, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:12'),
(51, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:12'),
(52, 1, 'UPDATE', 'usuarios', 5, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:12'),
(53, 1, 'UPDATE', 'usuarios', 5, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:12'),
(54, 1, 'UPDATE', 'usuarios', 6, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:13'),
(55, 1, 'UPDATE', 'usuarios', 5, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:15'),
(56, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:16'),
(57, 1, 'UPDATE', 'usuarios', 7, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:18'),
(58, 1, 'UPDATE', 'usuarios', 7, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:19'),
(59, 1, 'UPDATE', 'usuarios', 6, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:20'),
(60, 1, 'UPDATE', 'usuarios', 5, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:22'),
(61, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:24'),
(62, 1, 'UPDATE', 'usuarios', 3, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:25'),
(63, 1, 'UPDATE', 'usuarios', 8, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:28'),
(64, 1, 'UPDATE', 'usuarios', 9, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:30'),
(65, 1, 'UPDATE', 'usuarios', 9, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:32'),
(66, 1, 'UPDATE', 'usuarios', 8, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:33'),
(67, 1, 'UPDATE', 'usuarios', 7, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:34'),
(68, 1, 'UPDATE', 'usuarios', 6, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:35'),
(69, 1, 'UPDATE', 'usuarios', 5, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:37'),
(70, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:39'),
(71, 1, 'UPDATE', 'usuarios', 5, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:41'),
(72, 1, 'UPDATE', 'usuarios', 6, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:42'),
(73, 1, 'UPDATE', 'usuarios', 7, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:43'),
(74, 1, 'UPDATE', 'usuarios', 8, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:45'),
(75, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-14 04:43:59'),
(76, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-14 04:57:58'),
(77, 1, 'UPDATE', 'usuarios', 6, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:05:35'),
(78, 1, 'UPDATE', 'usuarios', 7, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:05:37'),
(79, 1, 'UPDATE', 'usuarios', 3, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:06:52'),
(80, 1, 'UPDATE', 'usuarios', 3, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:06:52'),
(81, 1, 'UPDATE', 'usuarios', 3, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:06:55'),
(82, 1, 'UPDATE', 'usuarios', 5, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:06:56'),
(83, 1, 'UPDATE', 'usuarios', 8, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:06:58'),
(84, 1, 'UPDATE', 'usuarios', 8, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:07:00'),
(85, 1, 'UPDATE', 'usuarios', 5, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:21:40'),
(86, 1, 'UPDATE', 'usuarios', 6, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:21:42'),
(87, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:30:13'),
(88, 1, 'UPDATE', 'usuarios', 3, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:30:14'),
(89, 1, 'UPDATE', 'usuarios', 2, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:30:15'),
(90, 1, 'UPDATE', 'usuarios', 2, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:30:17'),
(91, 1, 'UPDATE', 'usuarios', 3, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:30:18'),
(92, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:30:19'),
(93, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:41:08'),
(94, 1, 'UPDATE', 'usuarios', 3, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:41:10'),
(95, 1, 'UPDATE', 'usuarios', 2, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:41:11'),
(96, 1, 'UPDATE', 'usuarios', 7, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:41:13'),
(97, 1, 'UPDATE', 'usuarios', 2, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:16'),
(98, 1, 'UPDATE', 'usuarios', 3, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:17'),
(99, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-14 05:42:36'),
(100, 1, 'UPDATE', 'usuarios', 5, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:41'),
(101, 1, 'UPDATE', 'usuarios', 7, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:43'),
(102, 1, 'UPDATE', 'usuarios', 7, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:45'),
(103, 1, 'UPDATE', 'usuarios', 6, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:47'),
(104, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:49'),
(105, 1, 'UPDATE', 'usuarios', 7, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:51'),
(106, 1, 'UPDATE', 'usuarios', 8, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:52'),
(107, 1, 'UPDATE', 'usuarios', 7, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:54'),
(108, 1, 'UPDATE', 'usuarios', 6, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:55'),
(109, 1, 'UPDATE', 'usuarios', 5, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:56'),
(110, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-14 05:55:14'),
(111, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-16 04:23:26'),
(112, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 02:32:08'),
(113, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 02:32:33'),
(114, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 02:32:41'),
(115, 1, 'UPDATE', 'usuarios', 22, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 02:32:49'),
(116, 1, 'UPDATE', 'usuarios', 20, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 02:32:50'),
(117, 1, 'UPDATE', 'usuarios', 19, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 02:32:51'),
(118, 1, 'UPDATE', 'usuarios', 18, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 02:32:53'),
(119, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 06:00:06'),
(120, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 06:00:13'),
(121, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 06:26:49'),
(122, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 06:28:09'),
(123, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 06:28:18'),
(124, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 06:28:26'),
(125, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 06:28:32'),
(126, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 06:31:06'),
(127, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 06:35:57'),
(128, 1, 'UPDATE', 'usuarios', 1, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:37:49'),
(129, 1, 'UPDATE', 'usuarios', 2, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:37:51'),
(130, 1, 'UPDATE', 'usuarios', 8, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:37:53'),
(131, 1, 'UPDATE', 'usuarios', 1, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:37:55'),
(132, 1, 'UPDATE', 'usuarios', 2, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:37:56'),
(133, 1, 'UPDATE', 'usuarios', 7, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:37:57'),
(134, 1, 'UPDATE', 'usuarios', 8, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:37:58'),
(135, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:37:59'),
(136, 1, 'UPDATE', 'usuarios', 13, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:01'),
(137, 1, 'UPDATE', 'usuarios', 9, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:03'),
(138, 1, 'UPDATE', 'usuarios', 9, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:05'),
(139, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:06'),
(140, 1, 'UPDATE', 'usuarios', 13, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:07'),
(141, 1, 'UPDATE', 'usuarios', 18, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:09'),
(142, 1, 'UPDATE', 'usuarios', 19, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:10'),
(143, 1, 'UPDATE', 'usuarios', 5, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:10'),
(144, 1, 'UPDATE', 'usuarios', 20, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:12'),
(145, 1, 'UPDATE', 'usuarios', 22, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:12'),
(146, 1, 'UPDATE', 'usuarios', 6, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:14'),
(147, 1, 'UPDATE', 'usuarios', 12, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:15'),
(148, 1, 'UPDATE', 'usuarios', 18, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:17'),
(149, 1, 'UPDATE', 'usuarios', 16, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:18'),
(150, 1, 'UPDATE', 'usuarios', 15, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:19'),
(151, 1, 'UPDATE', 'usuarios', 14, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:22'),
(152, 1, 'UPDATE', 'usuarios', 3, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:42:38'),
(153, 1, 'UPDATE', 'usuarios', 9, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:42:40'),
(154, 1, 'UPDATE', 'usuarios', 3, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:43:57'),
(155, 1, 'UPDATE', 'usuarios', 9, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:43:57'),
(156, 1, 'UPDATE', 'usuarios', 14, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:43:58'),
(157, 1, 'UPDATE', 'usuarios', 15, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:43:59'),
(158, 1, 'UPDATE', 'usuarios', 16, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:00'),
(159, 1, 'UPDATE', 'usuarios', 18, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:01'),
(160, 1, 'UPDATE', 'usuarios', 12, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:02'),
(161, 1, 'UPDATE', 'usuarios', 2, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:53'),
(162, 1, 'UPDATE', 'usuarios', 7, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:53'),
(163, 1, 'UPDATE', 'usuarios', 8, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:54'),
(164, 1, 'UPDATE', 'usuarios', 3, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:55'),
(165, 1, 'UPDATE', 'usuarios', 9, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:55'),
(166, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:56'),
(167, 1, 'UPDATE', 'usuarios', 13, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:56'),
(168, 1, 'UPDATE', 'usuarios', 14, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:57'),
(169, 1, 'UPDATE', 'usuarios', 15, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:58'),
(170, 1, 'UPDATE', 'usuarios', 16, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:58'),
(171, 1, 'UPDATE', 'usuarios', 2, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:26:28'),
(172, 1, 'UPDATE', 'usuarios', 7, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:26:29'),
(173, 1, 'UPDATE', 'usuarios', 8, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:26:29'),
(174, 1, 'UPDATE', 'usuarios', 3, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:26:30'),
(175, 1, 'UPDATE', 'usuarios', 9, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:26:30'),
(176, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:26:31'),
(177, 1, 'UPDATE', 'usuarios', 13, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:26:32'),
(178, 1, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:29:39'),
(179, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 01:53:46'),
(180, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 01:53:58'),
(181, 1, 'UPDATE', 'usuarios', 5, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:54:08'),
(182, 1, 'UPDATE', 'usuarios', 6, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:54:10'),
(183, 1, 'UPDATE', 'usuarios', 3, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:54:19'),
(184, 1, 'UPDATE', 'usuarios', 2, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:54:24'),
(185, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 02:22:22'),
(186, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 02:35:45'),
(187, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 02:37:01'),
(188, 1, 'UPDATE', 'usuarios', 2, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 03:14:17'),
(189, 1, 'UPDATE', 'usuarios', 2, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:00:53'),
(190, 1, 'CREATE', 'usuarios', 23, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:17:10'),
(191, 1, 'CREATE', 'usuarios', 24, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:31:07'),
(192, 1, 'CREATE', 'usuarios', 25, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:32:54'),
(193, 1, 'CREATE', 'usuarios', 26, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:36:39'),
(194, 1, 'CREATE', 'usuarios', 27, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:44:02'),
(195, 1, 'CREATE', 'usuarios', 28, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:44:22'),
(196, 1, 'CREATE', 'usuarios', 29, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:44:57'),
(197, 1, 'CREATE', 'usuarios', 30, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:46:41'),
(198, 1, 'CREATE', 'usuarios', 31, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:49:53'),
(199, 1, 'CREATE', 'usuarios', 32, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 05:00:07'),
(200, 1, 'CREATE', 'usuarios', 33, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 05:06:35'),
(201, 1, 'CREATE', 'usuarios', 34, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 05:07:23'),
(202, 1, 'CREATE', 'usuarios', 35, NULL, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 05:20:31'),
(203, 1, 'UPDATE', 'usuarios', 33, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 05:36:40'),
(204, 1, 'UPDATE', 'usuarios', 2, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 05:37:18'),
(205, 1, 'UPDATE', 'usuarios', 2, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 05:37:19'),
(206, 1, 'UPDATE', 'usuarios', 2, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 05:37:32'),
(207, 1, 'UPDATE', 'usuarios', 2, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 05:38:01'),
(208, 1, 'UPDATE', 'usuarios', 1, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 07:09:51'),
(209, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 14:58:19'),
(210, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 14:58:40'),
(211, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 15:01:01'),
(212, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 15:01:09'),
(213, 1, 'UPDATE', 'usuarios', 2, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 15:01:19'),
(214, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-19 15:09:01'),
(215, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-19 15:09:09'),
(216, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-19 15:14:58'),
(217, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-19 15:17:49'),
(218, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-19 15:17:55'),
(219, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-19 15:24:28'),
(220, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-19 15:41:24'),
(221, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-19 15:48:27'),
(222, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 15:59:02'),
(223, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:11:32'),
(224, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:12:14');
INSERT INTO `auditoria` (`id`, `usuario_id`, `accion`, `tabla`, `registro_id`, `detalle`, `descripcion`, `ip`, `user_agent`, `modulo`, `created_at`) VALUES
(225, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:12:20'),
(226, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:12:26'),
(227, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:12:39'),
(228, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:14:47'),
(229, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:14:56'),
(230, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:17:02'),
(231, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:18:08'),
(232, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:18:15'),
(233, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:21:52'),
(234, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:33:55'),
(235, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 17:06:04'),
(236, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 17:07:26'),
(237, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 17:18:57'),
(238, 1, 'UPDATE', 'usuarios', 2, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 02:08:52'),
(239, 1, 'UPDATE', 'usuarios', 2, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 02:41:56'),
(240, 1, 'UPDATE', 'usuarios', 2, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 02:42:19'),
(241, 1, 'UPDATE', 'usuarios', 2, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 02:52:51'),
(242, 1, 'UPDATE', 'usuarios', 2, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:13:00'),
(243, 1, 'UPDATE', 'usuarios', 2, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:14:10'),
(244, 1, 'UPDATE', 'usuarios', 2, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:21:39'),
(245, 1, 'UPDATE', 'usuarios', 3, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:21:53'),
(246, 1, 'UPDATE', 'usuarios', 3, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:22:05'),
(247, 1, 'UPDATE', 'usuarios', 3, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:22:12'),
(248, 1, 'UPDATE', 'usuarios', 3, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:22:26'),
(249, 1, 'UPDATE', 'usuarios', 3, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:22:35'),
(250, 1, 'UPDATE', 'usuarios', 4, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:23:04'),
(251, 1, 'UPDATE', 'usuarios', 2, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:37:13'),
(252, 1, 'UPDATE', 'usuarios', 2, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:37:40'),
(253, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 03:37:46'),
(254, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 03:37:59'),
(255, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 03:44:33'),
(256, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 03:47:54'),
(257, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 03:57:47'),
(258, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-20 04:10:16'),
(259, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-20 04:10:22'),
(260, 2, 'UPDATE', 'usuarios', 3, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:11:07'),
(261, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 04:11:19'),
(262, 3, 'LOGIN', 'usuarios', 3, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 04:11:32'),
(263, 3, 'UPDATE', 'usuarios', 2, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:31:37'),
(264, 3, 'UPDATE', 'usuarios', 2, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:31:39'),
(265, 3, 'UPDATE', 'usuarios', 2, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:31:40'),
(266, 3, 'UPDATE', 'usuarios', 2, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:31:40'),
(267, 3, 'UPDATE', 'usuarios', 2, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:31:41'),
(268, 3, 'UPDATE', 'usuarios', 2, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:31:42'),
(269, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 04:32:07'),
(270, 2, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:32:19'),
(271, 2, 'UPDATE', 'usuarios', 5, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:32:21'),
(272, 2, 'UPDATE', 'usuarios', 6, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:32:22'),
(273, 2, 'UPDATE', 'usuarios', 3, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:32:23'),
(274, 2, 'UPDATE', 'usuarios', 4, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:32:26'),
(275, 2, 'UPDATE', 'usuarios', 5, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:32:27'),
(276, 2, 'UPDATE', 'usuarios', 6, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:32:28'),
(277, 2, 'UPDATE', 'usuarios', 8, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:32:30'),
(278, 2, 'UPDATE', 'usuarios', 7, NULL, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:32:32'),
(279, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 04:44:02'),
(280, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 04:49:07'),
(281, 2, 'UPDATE', 'usuarios', 9, NULL, 'Usuario: super3 | Estado: Activo → Inactivo | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:55:03'),
(282, 2, 'UPDATE', 'usuarios', 9, NULL, 'Usuario: super3 | Estado: Inactivo → Activo | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:55:07'),
(283, 2, 'UPDATE', 'usuarios', 10, NULL, 'Usuario: once | Estado: Activo → Inactivo | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:55:09'),
(284, 2, 'UPDATE', 'usuarios', 9, NULL, 'Usuario: super3 | Estado: Activo → Inactivo | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:55:12'),
(285, 2, 'UPDATE', 'usuarios', 10, NULL, 'Usuario: once | Estado: Inactivo → Activo | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:55:14'),
(286, 2, 'UPDATE', 'usuarios', 9, NULL, 'Usuario: super3 | Estado: Inactivo → Activo | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:55:16'),
(287, 2, 'UPDATE', 'usuarios', 10, NULL, 'Usuario: once | Estado: Activo → Inactivo | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:55:18'),
(288, 2, 'UPDATE', 'usuarios', 10, NULL, 'Usuario: once | Estado: Inactivo → Activo | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:55:19'),
(289, 2, 'UPDATE', 'usuarios', 10, NULL, 'Usuario: once | Estado: Activo → Inactivo | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:55:27'),
(290, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 04:56:42'),
(291, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 04:57:22'),
(292, 2, 'UPDATE', 'usuarios', 13, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:57:51'),
(293, 2, 'UPDATE', 'usuarios', 13, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:58:25'),
(294, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 04:58:32'),
(295, 13, 'LOGIN', 'usuarios', 13, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 04:58:44'),
(296, 13, 'UPDATE', 'usuarios', 9, NULL, 'Usuario: super3 | Estado: Activo → Inactivo | Por: prueba', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:59:01'),
(297, 13, 'UPDATE', 'usuarios', 9, NULL, 'Usuario: super3 | Estado: Inactivo → Activo | Por: prueba', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:59:05'),
(298, 13, 'UPDATE', 'usuarios', 9, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 01:54:31'),
(299, 13, 'UPDATE', 'usuarios', 9, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 01:54:47'),
(300, 13, 'LOGOUT', 'usuarios', 13, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 01:54:56'),
(301, 9, 'LOGIN', 'usuarios', 9, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 01:55:05'),
(302, 9, 'LOGOUT', 'usuarios', 9, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 01:55:20'),
(303, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 01:55:27'),
(304, 1, 'UPDATE', 'usuarios', 3, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 01:55:49'),
(305, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 01:55:55'),
(306, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 01:56:24'),
(307, 2, 'UPDATE', 'usuarios', 9, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 01:56:51'),
(308, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 02:14:56'),
(309, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 02:37:19'),
(310, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 02:38:41'),
(311, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 02:41:44'),
(312, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 02:43:55'),
(313, 1, 'UPDATE', 'usuarios', 9, NULL, 'Usuario: super3 | Estado: Activo → Inactivo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 02:46:06'),
(314, 1, 'UPDATE', 'usuarios', 9, NULL, 'Usuario: super3 | Estado: Inactivo → Activo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 02:46:07'),
(315, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 02:46:44'),
(316, 1, 'UPDATE', 'usuarios', 9, NULL, 'Usuario: super3 | Estado: Activo → Inactivo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 02:46:54'),
(317, 1, 'UPDATE', 'usuarios', 9, NULL, 'Usuario: super3 | Estado: Inactivo → Activo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 02:46:55'),
(318, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 03:18:33'),
(319, 1, 'RESTORE', 'usuarios', 3, NULL, 'Usuario: bodega | Eliminado → Inactivo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 03:21:00'),
(320, 1, 'RESTORE', 'usuarios', 4, NULL, 'Usuario: asistente | Eliminado → Inactivo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 03:23:40'),
(321, 1, 'UPDATE', 'usuarios', 3, NULL, 'Usuario: bodega | Estado: Inactivo → Activo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 03:25:59'),
(322, 1, 'UPDATE', 'usuarios', 5, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'users', '2026-05-21 03:27:11'),
(323, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 03:42:39'),
(324, 1, 'RESTORE', 'usuarios', 5, NULL, 'Usuario: vendedor1 | Eliminado → Inactivo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 03:42:48'),
(325, 1, 'UPDATE', 'usuarios', 5, NULL, 'Usuario: vendedor1 | Estado: Inactivo → Activo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 03:42:50'),
(326, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 03:43:08'),
(327, 3, 'LOGIN', 'usuarios', 3, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 03:43:15'),
(328, 3, 'UPDATE', 'usuarios', 4, NULL, 'Usuario: asistente | Estado: Inactivo → Activo | Por: bodega', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 03:43:27'),
(329, 3, 'UPDATE', 'usuarios', 4, NULL, 'Usuario: asistente | Estado: Activo → Inactivo | Por: bodega', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 03:43:32'),
(330, 3, 'UPDATE', 'usuarios', 4, NULL, 'Usuario: asistente | Estado: Inactivo → Activo | Por: bodega', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 03:43:36'),
(331, 3, 'LOGIN', 'usuarios', 3, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 03:46:27'),
(332, 3, 'LOGOUT', 'usuarios', 3, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 04:07:11'),
(333, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 04:07:17'),
(334, 1, 'CREATE', 'proveedores', 1, NULL, 'Proveedor creado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-21 05:57:13'),
(335, 1, 'CREATE', 'proveedores', 2, NULL, 'Proveedor creado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-21 05:58:51'),
(336, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 15:11:24'),
(337, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Safari/605.1.15', 'auth', '2026-05-21 15:14:53'),
(338, 1, 'UPDATE', 'usuarios', 2, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 15:15:14'),
(339, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 15:15:25'),
(340, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 15:15:36'),
(341, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 15:50:19'),
(342, 2, 'ESTADO', 'proveedores', 1, NULL, 'Cambio estado a 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-21 15:50:56'),
(343, 2, 'ESTADO', 'proveedores', 1, NULL, 'Cambio estado a 1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-21 15:51:00'),
(344, 2, 'ESTADO', 'proveedores', 2, NULL, 'Cambio estado a 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-21 15:51:02'),
(345, 2, 'ESTADO', 'proveedores', 2, NULL, 'Cambio estado a 1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-21 15:51:03'),
(346, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 16:07:16'),
(347, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 16:18:01'),
(348, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 16:35:33'),
(349, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 16:38:37'),
(350, 2, 'CREAR', 'proveedores', 3, NULL, 'Creó proveedor Juan', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-21 16:55:45'),
(351, 2, 'CREAR', 'proveedores', 4, NULL, 'Creó proveedor Juanxcarlos', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-21 17:24:28'),
(352, 2, 'CREAR', 'proveedores', 5, NULL, 'Creó proveedor Pedro', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-21 17:26:46'),
(353, 2, 'CREAR', 'proveedores', 6, NULL, 'Creó proveedor Dos', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-21 18:08:31'),
(354, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 03:18:48'),
(355, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 04:46:09'),
(356, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 13:46:41'),
(357, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 13:46:48'),
(358, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 13:53:15'),
(359, 3, 'LOGIN', 'usuarios', 3, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 13:53:22'),
(360, 3, 'LOGOUT', 'usuarios', 3, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 14:35:59'),
(361, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 14:36:08'),
(362, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 14:36:28'),
(363, 3, 'LOGIN', 'usuarios', 3, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 14:36:35'),
(364, 3, 'ESTADO', 'proveedores', 4, NULL, 'Cambio estado a 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-22 14:37:57'),
(365, 3, 'LOGOUT', 'usuarios', 3, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 14:38:00'),
(366, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 14:38:05'),
(367, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 14:40:10'),
(368, 3, 'LOGIN', 'usuarios', 3, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 14:40:24'),
(369, 3, 'LOGOUT', 'usuarios', 3, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 14:40:44'),
(370, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 14:42:40'),
(371, 1, 'RESTORE', 'usuarios', 6, NULL, 'Usuario: secretaria | Eliminado → Inactivo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-22 14:42:56'),
(372, 1, 'UPDATE', 'usuarios', 6, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-22 14:44:53'),
(373, 1, 'UPDATE', 'usuarios', 3, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-22 14:45:11'),
(374, 1, 'UPDATE', 'usuarios', 5, NULL, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-22 14:45:26'),
(375, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 15:03:56'),
(376, 1, 'RESTORE', 'usuarios', 10, NULL, 'Usuario: once | Eliminado → Inactivo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-22 15:54:19'),
(377, 1, 'RESTORE', 'usuarios', 9, NULL, 'Usuario: super3 | Eliminado → Inactivo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-22 15:54:23'),
(378, 1, 'RESTORE', 'usuarios', 8, NULL, 'Usuario: super2 | Eliminado → Inactivo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-22 15:54:25'),
(379, 1, 'RESTORE', 'usuarios', 7, NULL, 'Usuario: testuser | Eliminado → Inactivo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-22 15:54:28'),
(380, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 15:56:54'),
(381, 3, 'LOGIN', 'usuarios', 3, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 15:57:01'),
(382, 3, 'LOGOUT', 'usuarios', 3, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 15:57:14'),
(383, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 15:57:21'),
(384, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 16:15:42'),
(385, 3, 'LOGIN', 'usuarios', 3, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 16:15:51'),
(386, 3, 'LOGOUT', 'usuarios', 3, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 16:15:55'),
(387, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 16:16:03'),
(388, 2, 'ESTADO', 'proveedores', 4, NULL, 'Cambio estado a 1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-22 16:17:12'),
(389, 2, 'ESTADO', 'proveedores', 1, NULL, 'Cambio estado a 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-22 16:17:16'),
(390, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 16:17:40'),
(391, 2, 'DELETE', 'proveedores', 1, NULL, 'Proveedor: Juan | Estado: 2 → 0 | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-22 16:35:42'),
(392, 2, 'DELETE', 'proveedores', 2, NULL, 'Proveedor: Juan55%%%% | Estado: 1 → 0 | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-22 16:35:46'),
(393, 2, 'DELETE', 'proveedores', 3, NULL, 'Proveedor: Juan | Estado: 1 → 0 | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-22 16:45:40'),
(394, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 16:45:57'),
(395, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 16:46:14'),
(396, 1, 'RESTORE', 'proveedores', 1, NULL, 'Proveedor: Juan | Estado: 0 → 1 (Restaurado) | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-22 16:49:33'),
(397, 1, 'RESTORE', 'proveedores', 2, NULL, 'Proveedor: Juan55%%%% | Estado: 0 → 1 (Restaurado) | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-22 16:49:35'),
(398, 1, 'RESTORE', 'proveedores', 3, NULL, 'Proveedor: Juan | Estado: 0 → 1 (Restaurado) | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-22 16:49:38'),
(399, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 16:50:19'),
(400, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-22 16:50:27'),
(401, 2, 'DELETE', 'proveedores', 1, NULL, 'Proveedor: Juan | Estado: 1 → 0 | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-22 16:51:20'),
(402, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-24 15:22:11'),
(403, 1, 'DELETE', 'proveedores', 6, NULL, 'Proveedor: Dos | Estado: 1 → 0 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-24 15:22:21'),
(404, 1, 'EDITAR', 'proveedores', 6, NULL, 'Actualizó proveedor Dos', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-24 15:25:57'),
(420, 1, 'EDITAR', 'proveedores', 6, NULL, 'Actualizó proveedor Dos', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-25 01:48:35'),
(421, 1, 'RESTORE', 'proveedores', 6, NULL, 'Proveedor: Dos | Estado: 0 → 1 (Restaurado) | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-25 01:48:38'),
(422, 1, 'DELETE', 'proveedores', 5, NULL, 'Proveedor: Pedro | Estado: 1 → 0 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-25 01:48:43'),
(423, 1, 'DELETE', 'proveedores', 3, NULL, 'Proveedor: Juan | Estado: 1 → 0 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-25 01:48:56'),
(424, 1, 'create', 'fabric_types', 0, NULL, 'Creó: Camuflado (009)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-26 03:27:47'),
(425, 1, 'create', 'fabric_types', 0, NULL, 'Creó: Dacron estampado (010)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-26 03:32:57'),
(426, 1, 'create', 'fabric_types', 0, NULL, 'Creó: Popelina (011)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-26 03:33:43'),
(427, 1, 'CREAR', 'proveedores', 9, NULL, 'Creó proveedor Cvxc', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-26 03:34:11'),
(428, 1, 'update', 'fabric_types', 11, NULL, 'Actualizó tipo: Nueva', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-26 05:26:48'),
(429, 1, 'update', 'fabric_types', 11, NULL, 'Actualizó tipo: Nueva', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-26 05:26:48'),
(430, 1, 'update', 'fabric_types', 11, NULL, 'Actualizó tipo: Nueva', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-26 05:26:48'),
(431, 1, 'update', 'fabric_types', 11, NULL, 'Actualizó tipo: Popelina', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-26 05:26:59'),
(432, 1, 'EDITAR', 'proveedores', 3, NULL, 'Actualizó proveedor Juan', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-26 05:29:43'),
(433, 1, 'EDITAR', 'proveedores', 2, NULL, 'Actualizó proveedor Juan55', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-26 05:30:01'),
(434, 1, 'update', 'fabric_types', 7, NULL, 'Actualizó tipo: Bengalina blusera 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-26 14:55:57'),
(435, 1, 'update', 'fabric_types', 9, NULL, 'Actualizó tipo: Camuflado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-26 15:05:04'),
(436, 1, 'update', 'fabric_types', 7, NULL, 'Actualizó tipo: Bengalina blusera 3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-26 15:06:27'),
(437, 1, 'update', 'fabric_types', 11, NULL, 'Actualizó tipo: Camuflado2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-26 15:21:19'),
(438, 1, 'ESTADO', 'proveedores', 9, NULL, 'Cambio estado a 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-27 02:03:50'),
(439, 1, 'ESTADO', 'proveedores', 9, NULL, 'Cambio estado a 1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-27 02:03:52'),
(440, 1, 'update', 'fabric_types', 10, NULL, 'Actualizó tipo: Camuflado3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-27 02:04:38'),
(441, 1, 'DELETE', 'fabric_types', 11, NULL, 'Tipo: Camuflado2 | Estado: 1 → 0 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-27 05:17:33'),
(442, 1, 'DELETE', 'fabric_types', 10, NULL, 'Tipo: Camuflado3 | Estado: 1 → 0 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 05:08:19'),
(443, 1, 'DELETE', 'fabric_types', 9, NULL, 'Tipo: Camuflado | Estado: 1 → 0 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 05:08:26'),
(444, 1, 'DELETE', 'fabric_types', 8, NULL, 'Tipo: Chalis Est. Flores | Estado: 1 → 0 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 05:08:28'),
(445, 1, 'DELETE', 'fabric_types', 7, NULL, 'Tipo: Bengalina blusera 3 | Estado: 1 → 0 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 05:08:31'),
(446, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-28 14:14:10'),
(447, 1, 'restore', 'fabric_types', 11, NULL, 'Restauró ID 11', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 15:51:57'),
(448, 1, 'restore', 'fabric_types', 11, NULL, 'Restauró ID 11', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 15:51:57'),
(449, 1, 'restore', 'fabric_types', 10, NULL, 'Restauró ID 10', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 15:51:58'),
(450, 1, 'restore', 'fabric_types', 9, NULL, 'Restauró ID 9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 15:52:04'),
(451, 1, 'restore', 'fabric_types', 8, NULL, 'Restauró ID 8', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 15:52:10');
INSERT INTO `auditoria` (`id`, `usuario_id`, `accion`, `tabla`, `registro_id`, `detalle`, `descripcion`, `ip`, `user_agent`, `modulo`, `created_at`) VALUES
(452, 1, 'create', 'fabric_colors', 0, NULL, 'Creó: Negro (001)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 19:00:24'),
(453, 1, 'create', 'fabric_colors', 0, NULL, 'Creó: Rojo (004)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 19:00:34'),
(454, 1, 'update', 'fabric_types', 4, NULL, 'Actualizó: Rojo rey', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 19:00:43'),
(455, 1, 'update', 'fabric_types', 3, NULL, 'Actualizó: Negro oscuro', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 22:02:10'),
(456, 1, 'update', 'fabric_types', 0, NULL, 'Actualizó: Rojo oscuro', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 22:17:20'),
(457, 1, 'update', 'fabric_types', 0, NULL, 'Actualizó: Rojo oscuro', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 22:17:37'),
(458, 1, 'update', 'fabric_colors', 4, NULL, 'Actualizó: Rojo oscuro', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 22:29:46'),
(459, 1, 'DELETE', 'fabric_types', 6, NULL, 'Tipo: Bengalina Blusera | Estado: 1 → 0 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 22:34:17'),
(460, 1, 'restore', 'fabric_types', 7, NULL, 'Restauró ID 7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 22:34:28'),
(461, 1, 'restore', 'fabric_types', 6, NULL, 'Restauró ID 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 22:34:30'),
(462, 1, 'DELETE', 'fabric_types', 6, NULL, 'Tipo: Bengalina Blusera | Estado: 1 → 0 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 22:34:40'),
(463, 1, 'DELETE', 'fabric_types', 7, NULL, 'Tipo: Bengalina blusera 3 | Estado: 1 → 0 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 22:34:42'),
(464, 1, 'DELETE', 'fabric_types', 8, NULL, 'Tipo: Chalis Est. Flores | Estado: 1 → 0 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 22:35:00'),
(465, 1, 'update', 'fabric_colors', 3, NULL, 'Actualizó: Negro nuevo', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 22:40:19'),
(466, 1, 'delete', 'fabric_colors', 3, NULL, 'Eliminó registro ID 3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 22:40:29'),
(467, 1, 'restore', 'fabric_colors', 3, NULL, 'Restauró ID 3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 22:40:37'),
(468, 1, 'create', 'fabric_colors', 0, NULL, 'Creó: Azul (005)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 22:41:01'),
(469, 1, 'create', 'fabric_colors', 0, NULL, 'Creó: Amarillo (006)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 22:41:06'),
(470, 1, 'create', 'fabric_colors', 0, NULL, 'Creó: Rosado (007)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-28 22:41:12'),
(471, 1, 'UPDATE', 'usuarios', 2, NULL, 'Usuario: admin | Estado: Activo → Inactivo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-31 04:48:55'),
(472, 1, 'UPDATE', 'usuarios', 2, NULL, 'Usuario: admin | Estado: Inactivo → Activo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-31 04:48:57'),
(473, 1, 'delete', 'fabric_colors', 3, NULL, 'Eliminó registro ID 3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-31 06:44:51'),
(474, 1, 'DELETE', 'fabric_types', 2, NULL, 'Tipo: algodon BordaDo | Estado: 1 → 0 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-31 06:45:31'),
(475, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-31 06:54:04'),
(476, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-31 06:54:12'),
(477, 2, 'DELETE', 'fabric_types', 9, NULL, 'Tipo: Camuflado | Estado: 1 → 0 | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-31 06:59:31'),
(478, 2, 'restore', 'fabric_types', 9, NULL, 'Restauró ID 9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-31 06:59:35'),
(479, 2, 'delete', 'fabric_colors', 4, NULL, 'Eliminó registro ID 4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-31 06:59:43'),
(480, 2, 'restore', 'fabric_colors', 4, NULL, 'Restauró ID 4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-31 06:59:44'),
(481, 2, 'delete', 'fabric_colors', 4, NULL, 'Eliminó registro ID 4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-31 06:59:51'),
(482, 2, 'restore', 'fabric_colors', 4, NULL, 'Restauró ID 4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-31 06:59:53'),
(483, 2, 'delete', 'fabric_colors', 4, NULL, 'Eliminó registro ID 4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-31 07:00:13'),
(484, 2, 'DELETE', 'fabric_types', 9, NULL, 'Tipo: Camuflado | Estado: 1 → 0 | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-05-31 07:00:37'),
(485, 2, 'update', 'fabric_types', 10, NULL, 'Actualizó: Camuflado4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-01 02:58:27'),
(486, 2, 'DELETE', 'fabric_types', 10, NULL, 'Tipo: Camuflado4 | Estado: 1 → 0 | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-01 02:58:33'),
(487, 2, 'create', 'fabric_types', 0, NULL, 'Creó: Bengalina (012)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-01 03:05:08'),
(488, 2, 'create', 'fabric_types', 0, NULL, 'Creó: Seda (013)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-01 03:05:16'),
(489, 2, 'DELETE', 'fabric_types', 11, NULL, 'Tipo: Camuflado2 | Estado: 1 → 0 | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-01 03:05:23'),
(490, 2, 'restore', 'fabric_types', 11, NULL, 'Restauró ID 11', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-01 03:05:27'),
(491, 2, 'DELETE', 'fabric_types', 11, NULL, 'Tipo: Camuflado2 | Estado: 1 → 0 | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-01 03:05:52'),
(492, 2, 'delete', 'fabric_colors', 5, NULL, 'Eliminó registro ID 5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-01 03:06:41'),
(493, 2, 'delete', 'fabric_colors', 6, NULL, 'Eliminó registro ID 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-01 03:06:50'),
(494, 2, 'create', 'fabric_colors', 0, NULL, 'Creó: Rojo (008)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-03 14:47:28'),
(495, 2, 'delete', 'fabric_colors', 9, NULL, 'Eliminó registro ID 9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-03 14:47:34'),
(496, 2, 'create', 'fabric_colors', 0, NULL, 'Creó: Rojo2 (010)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-03 14:50:42'),
(497, 2, 'delete', 'fabric_colors', 11, NULL, 'Eliminó registro ID 11', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-03 14:50:48'),
(498, 2, 'delete', 'fabric_colors', 7, NULL, 'Eliminó registro ID 7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-03 17:20:25'),
(499, 2, 'create', 'fabric_colors', 0, NULL, 'Creó: Rojo3 (012)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-04 01:26:53'),
(500, 2, 'create', 'fabric_colors', 0, NULL, 'Creó: Rojo4 (016)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-04 01:27:08'),
(501, 2, 'create', 'fabric_colors', 0, NULL, 'Creó: Rojo5 (017)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-04 01:27:17'),
(502, 2, 'delete', 'fabric_colors', 17, NULL, 'Eliminó registro ID 17', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-04 01:27:29'),
(503, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 01:28:50'),
(504, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 01:30:06'),
(505, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 01:30:19'),
(506, 3, 'LOGIN', 'usuarios', 3, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 01:34:13'),
(507, 3, 'LOGIN', 'usuarios', 3, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 03:30:16'),
(508, 3, 'LOGOUT', 'usuarios', 3, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 03:59:57'),
(509, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 04:15:55'),
(510, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 04:27:06'),
(511, 2, 'EDITAR', 'proveedores', 6, NULL, 'Actualizó proveedor Dos', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-04 04:34:37'),
(512, 2, 'DELETE', 'proveedores', 2, NULL, 'Proveedor: Juan55 | Estado: 1 → 0 | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-04 04:34:47'),
(513, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 04:38:14'),
(514, 3, 'LOGIN', 'usuarios', 3, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 04:38:20'),
(515, 3, 'LOGOUT', 'usuarios', 3, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 04:44:01'),
(516, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 04:44:13'),
(517, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 05:07:46'),
(518, 3, 'LOGIN', 'usuarios', 3, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 05:07:53'),
(519, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 05:08:16'),
(520, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 05:08:25'),
(521, 3, 'LOGIN', 'usuarios', 3, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 05:08:32'),
(522, 3, 'LOGIN', 'usuarios', 3, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 05:12:37'),
(523, 3, 'LOGOUT', 'usuarios', 3, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 05:29:32'),
(524, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 05:29:43'),
(525, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 05:30:42'),
(526, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 05:30:49'),
(527, 1, 'update', 'fabric_colors', 15, NULL, 'Actualizó: Rojo6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-04 05:34:10'),
(528, 1, 'update', 'fabric_colors', 15, NULL, 'Actualizó: Rojo7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-04 05:51:24'),
(529, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 05:51:46'),
(530, 2, 'update', 'fabric_colors', 15, NULL, 'Actualizó: Rojo6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-04 05:52:00'),
(531, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 06:08:52'),
(532, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 06:14:49'),
(533, 3, 'LOGIN', 'usuarios', 3, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 06:14:56'),
(534, 3, 'LOGOUT', 'usuarios', 3, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 06:15:07'),
(535, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 06:15:18'),
(536, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 06:20:06'),
(537, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 06:24:46'),
(538, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 06:24:52'),
(539, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 06:26:03'),
(540, 3, 'LOGIN', 'usuarios', 3, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 06:26:37'),
(541, 3, 'LOGOUT', 'usuarios', 3, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 06:27:12'),
(542, 2, 'delete', 'fabric_colors', 15, NULL, 'Eliminó registro ID 15', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-04 06:28:39'),
(543, 2, 'update', 'fabric_types', 12, NULL, 'Actualizó: Bengalina2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-04 06:28:50'),
(544, 2, 'DELETE', 'fabric_types', 12, NULL, 'Tipo: Bengalina2 | Estado: 1 → 0 | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-04 06:28:54'),
(545, 2, 'ESTADO', 'proveedores', 4, NULL, 'Cambio estado a 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-04 06:41:44'),
(546, 2, 'ESTADO', 'proveedores', 4, NULL, 'Cambio estado a 1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-04 06:41:46'),
(547, 2, 'ESTADO', 'proveedores', 6, NULL, 'Cambio estado a 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-04 06:41:48'),
(548, 2, 'ESTADO', 'proveedores', 6, NULL, 'Cambio estado a 1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-04 06:41:50'),
(549, 2, 'ESTADO', 'proveedores', 9, NULL, 'Cambio estado a 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-04 06:41:51'),
(550, 2, 'ESTADO', 'proveedores', 9, NULL, 'Cambio estado a 1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-04 06:41:53'),
(551, 2, 'ESTADO', 'proveedores', 4, NULL, 'Cambio estado a 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-04 06:46:48'),
(552, 2, 'ESTADO', 'proveedores', 6, NULL, 'Cambio estado a 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-04 06:46:49'),
(553, 2, 'ESTADO', 'proveedores', 6, NULL, 'Cambio estado a 1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-04 06:46:50'),
(554, 2, 'ESTADO', 'proveedores', 4, NULL, 'Cambio estado a 1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-04 06:46:51'),
(555, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-04 07:01:08'),
(556, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 02:38:47'),
(557, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 02:39:02'),
(558, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 02:42:21'),
(559, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 02:44:07'),
(560, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 02:44:14'),
(561, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 03:04:46'),
(562, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 03:14:08'),
(563, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 03:14:11'),
(564, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 03:14:17'),
(565, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 03:16:36'),
(566, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 03:16:46'),
(567, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 03:19:32'),
(568, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 03:29:42'),
(569, 1, 'TOGGLE', 'warehouses', 5, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:06'),
(570, 1, 'TOGGLE', 'warehouses', 5, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:06'),
(571, 1, 'TOGGLE', 'warehouses', 5, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:07'),
(572, 1, 'TOGGLE', 'warehouses', 5, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:07'),
(573, 1, 'TOGGLE', 'warehouses', 5, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:08'),
(574, 1, 'TOGGLE', 'warehouses', 5, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:08'),
(575, 1, 'TOGGLE', 'warehouses', 5, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:09'),
(576, 1, 'TOGGLE', 'warehouses', 5, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:10'),
(577, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:10'),
(578, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:11'),
(579, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:12'),
(580, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:12'),
(581, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:13'),
(582, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:13'),
(583, 1, 'TOGGLE', 'warehouses', 5, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:14'),
(584, 1, 'TOGGLE', 'warehouses', 5, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:14'),
(585, 1, 'TOGGLE', 'warehouses', 5, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:15'),
(586, 1, 'TOGGLE', 'warehouses', 5, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:15'),
(587, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:16'),
(588, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:16'),
(589, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:17'),
(590, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:17'),
(591, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:17'),
(592, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 03:58:17'),
(593, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 04:02:57'),
(594, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 04:02:57'),
(595, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 04:02:59'),
(596, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 04:02:59'),
(597, 1, 'TOGGLE', 'warehouses', 5, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 04:03:00'),
(598, 1, 'TOGGLE', 'warehouses', 5, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 04:03:00'),
(599, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 04:07:00'),
(600, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 04:07:01'),
(601, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 04:07:02'),
(602, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 04:07:02'),
(603, 1, 'TOGGLE', 'warehouses', 5, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 04:07:03'),
(604, 1, 'TOGGLE', 'warehouses', 5, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 04:07:03'),
(605, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 04:07:23'),
(606, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 04:07:23'),
(607, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 1 → 2 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 04:07:24'),
(608, 1, 'TOGGLE', 'warehouses', 2, NULL, 'Estado 2 → 1 | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-05 04:07:24'),
(609, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 04:11:58'),
(610, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 04:19:06'),
(611, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 04:20:14'),
(612, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 04:34:43'),
(613, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 04:42:11'),
(614, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 04:42:50'),
(615, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-05 04:42:57'),
(616, 2, 'TOGGLE', 'proveedores', 6, NULL, 'Estado 1 → 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-05 04:55:49'),
(617, 2, 'TOGGLE', 'proveedores', 9, NULL, 'Estado 1 → 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-05 04:55:52'),
(618, 2, 'TOGGLE', 'proveedores', 9, NULL, 'Estado 2 → 1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-05 04:55:54'),
(619, 2, 'TOGGLE', 'proveedores', 6, NULL, 'Estado 2 → 1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-05 04:55:55'),
(620, 2, 'DELETE', 'proveedores', 6, NULL, 'Proveedor eliminado: Dos', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-05 04:56:05'),
(621, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-07 02:30:59'),
(622, 1, 'UPDATE', 'usuarios', 1, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:29:27'),
(623, 1, 'UPDATE', 'usuarios', 1, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:29:51'),
(624, 1, 'TOGGLE', 'usuarios', 3, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:30:05'),
(625, 1, 'TOGGLE', 'usuarios', 3, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:30:06'),
(626, 1, 'TOGGLE', 'usuarios', 2, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:30:07'),
(627, 1, 'TOGGLE', 'usuarios', 2, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:30:08'),
(628, 1, 'TOGGLE', 'usuarios', 3, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:30:09'),
(629, 1, 'TOGGLE', 'usuarios', 6, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:30:09'),
(630, 1, 'TOGGLE', 'usuarios', 2, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:30:13'),
(631, 1, 'TOGGLE', 'usuarios', 2, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:30:17'),
(632, 1, 'TOGGLE', 'usuarios', 2, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:37:51'),
(633, 1, 'TOGGLE', 'usuarios', 2, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:37:51'),
(634, 1, 'TOGGLE', 'usuarios', 2, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:37:52'),
(635, 1, 'TOGGLE', 'usuarios', 2, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:39:36'),
(636, 1, 'TOGGLE', 'usuarios', 3, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:39:37'),
(637, 1, 'TOGGLE', 'usuarios', 5, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:39:39'),
(638, 1, 'TOGGLE', 'usuarios', 6, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:39:45'),
(639, 1, 'TOGGLE', 'usuarios', 7, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:39:47'),
(640, 1, 'DELETE', 'usuarios', 5, 'Eliminado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:45:22'),
(641, 1, 'DELETE', 'usuarios', 6, 'Eliminado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:54:45'),
(642, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-07 06:54:50'),
(643, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-07 06:54:57'),
(644, 2, 'DELETE', 'usuarios', 24, 'Eliminado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:55:06'),
(645, 2, 'DELETE', 'usuarios', 25, 'Eliminado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 06:55:21'),
(646, 2, 'DELETE', 'usuarios', 11, 'Eliminado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 07:06:57'),
(647, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-07 07:27:34'),
(648, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-07 07:28:07'),
(649, 2, 'DELETE', 'usuarios', 22, 'Eliminado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 07:28:48'),
(650, 2, 'DELETE', 'usuarios', 23, 'Eliminado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 07:28:53'),
(651, 2, 'DELETE', 'usuarios', 30, 'Eliminado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 07:29:01'),
(652, 2, 'TOGGLE', 'usuarios', 35, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-07 07:30:50'),
(653, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-07 07:39:13'),
(654, 2, 'UPDATE', 'usuarios', 13, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 00:42:36'),
(655, 2, 'DELETE', 'usuarios', 20, 'Eliminado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 00:42:47'),
(656, 2, 'TOGGLE', 'usuarios', 2, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 01:30:14'),
(657, 2, 'TOGGLE', 'usuarios', 2, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 01:30:14'),
(658, 2, 'TOGGLE', 'usuarios', 2, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 01:30:15'),
(659, 2, 'TOGGLE', 'usuarios', 3, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 01:30:15'),
(660, 2, 'TOGGLE', 'usuarios', 3, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 01:30:17'),
(661, 2, 'TOGGLE', 'usuarios', 2, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 01:30:18'),
(662, 2, 'TOGGLE', 'usuarios', 13, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 01:30:20'),
(663, 2, 'TOGGLE', 'usuarios', 13, 'Cambio de estado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 01:30:21'),
(664, 2, 'CREATE', 'usuarios', 37, 'Usuario creado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 01:47:46'),
(665, 2, 'TOGGLE', 'proveedores', 9, NULL, 'Estado 1 → 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-08 01:51:07'),
(666, 2, 'TOGGLE', 'proveedores', 9, NULL, 'Estado 2 → 1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-08 01:51:09'),
(667, 2, 'TOGGLE', 'proveedores', 4, NULL, 'Estado 1 → 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-08 01:52:52'),
(668, 2, 'TOGGLE', 'proveedores', 4, 'Estado 2 → 1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-08 03:16:57');
INSERT INTO `auditoria` (`id`, `usuario_id`, `accion`, `tabla`, `registro_id`, `detalle`, `descripcion`, `ip`, `user_agent`, `modulo`, `created_at`) VALUES
(669, 2, 'UPDATE', 'usuarios', 33, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 03:32:45'),
(670, 2, 'UPDATE', 'usuarios', 33, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 03:33:05'),
(671, 2, 'DELETE', 'usuarios', 33, 'Eliminado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 03:33:38'),
(672, 2, 'UPDATE', 'usuarios', 35, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 03:49:11'),
(673, 2, 'UPDATE', 'usuarios', 7, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 03:49:36'),
(674, 2, 'UPDATE', 'usuarios', 37, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 04:04:38'),
(675, 2, 'UPDATE', 'usuarios', 29, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 04:21:45'),
(676, 2, 'CREATE', 'usuarios', 38, 'Usuario creado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 04:43:06'),
(677, 2, 'CREATE', 'usuarios', 39, 'Usuario creado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 04:50:46'),
(678, 2, 'CREATE', 'usuarios', 40, 'Usuario creado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 04:55:59'),
(679, 2, 'UPDATE', 'usuarios', 40, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 05:25:33'),
(680, 2, 'UPDATE', 'usuarios', 40, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 05:25:33'),
(681, 2, 'UPDATE', 'usuarios', 40, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 05:26:02'),
(682, 2, 'UPDATE', 'usuarios', 40, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 05:28:58'),
(683, 2, 'UPDATE', 'usuarios', 40, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 05:32:10'),
(684, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-08 05:58:57'),
(685, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-08 05:59:04'),
(686, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-08 06:00:44'),
(687, 2, 'UPDATE', 'usuarios', 40, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 06:04:01'),
(688, 2, 'UPDATE', 'usuarios', 40, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 06:05:06'),
(689, 2, 'UPDATE', 'usuarios', 7, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 06:05:42'),
(690, 2, 'UPDATE', 'usuarios', 40, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 06:05:53'),
(691, 2, 'UPDATE', 'usuarios', 35, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 06:06:09'),
(692, 2, 'UPDATE', 'usuarios', 37, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 06:07:35'),
(693, 2, 'UPDATE', 'usuarios', 29, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 06:13:02'),
(694, 2, 'UPDATE', 'usuarios', 40, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 06:13:16'),
(695, 2, 'UPDATE', 'usuarios', 2, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 06:13:30'),
(696, 2, 'UPDATE', 'usuarios', 40, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 06:15:27'),
(697, 2, 'UPDATE', 'usuarios', 2, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-08 06:15:40'),
(698, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-08 06:27:28'),
(699, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-09 01:28:33'),
(700, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-09 02:01:51'),
(701, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-09 02:15:13'),
(702, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-09 02:24:47'),
(703, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-09 02:42:45'),
(704, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-09 03:24:16'),
(705, 2, 'CREATE', 'proveedores', 10, 'Proveedor creado: dos', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-09 03:49:34'),
(706, 2, 'TOGGLE', 'proveedores', 10, 'Estado 1 → 2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-09 03:51:08'),
(707, 2, 'TOGGLE', 'proveedores', 10, 'Estado 2 → 1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-09 03:51:08'),
(708, 2, 'TOGGLE', 'proveedores', 10, 'Estado 1 → 2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-09 03:51:08'),
(709, 2, 'TOGGLE', 'proveedores', 10, 'Estado 2 → 1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-09 03:51:09'),
(710, 2, 'TOGGLE', 'proveedores', 10, 'Estado 1 → 2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-09 03:51:11'),
(711, 2, 'TOGGLE', 'proveedores', 10, 'Estado 2 → 1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-09 03:51:11'),
(712, 2, 'TOGGLE', 'proveedores', 10, 'Estado 1 → 2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-09 03:51:14'),
(713, 2, 'TOGGLE', 'proveedores', 10, 'Estado 2 → 1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-09 03:51:14'),
(714, 2, 'UPDATE', 'proveedores', 10, 'Proveedor actualizado: dos ok', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-09 03:53:29'),
(715, 2, 'TOGGLE', 'proveedores', 10, 'Estado 1 → 2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-09 04:05:52'),
(716, 2, 'TOGGLE', 'proveedores', 9, 'Estado 1 → 2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-09 04:05:57'),
(717, 2, 'TOGGLE', 'proveedores', 9, 'Estado 2 → 1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-09 04:05:59'),
(718, 2, 'TOGGLE', 'proveedores', 10, 'Estado 2 → 1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-09 04:06:00'),
(719, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-09 04:16:26'),
(720, 2, 'TOGGLE', 'proveedores', 9, 'Estado 1 → 2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-09 04:29:58'),
(721, 2, 'TOGGLE', 'proveedores', 9, 'Estado 2 → 1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-09 04:29:59'),
(722, 2, 'DELETE', 'proveedores', 9, 'Proveedor eliminado: Cvxc', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-09 04:30:02'),
(723, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-09 04:30:11'),
(724, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-09 04:30:17'),
(725, 1, 'RESTORE', 'proveedores', 1, 'Proveedor restaurado: Juan', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-09 04:30:25'),
(726, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-09 04:30:42'),
(727, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-09 04:30:56'),
(728, 2, 'CREATE', 'fabric_colors', 18, NULL, 'Registro creado: negro | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-09 05:59:15'),
(729, 2, 'CREATE', 'fabric_colors', 19, NULL, 'Registro creado: azul pollito | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-09 05:59:31'),
(730, 2, 'CREATE', 'fabric_colors', 20, NULL, 'Registro creado: azul amarillo | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 03:11:52'),
(731, 2, 'TOGGLE', 'fabric_colors', 20, NULL, 'Estado: 1 → 2 | azul amarillo | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 03:43:05'),
(732, 2, 'TOGGLE', 'fabric_colors', 19, NULL, 'Estado: 1 → 2 | azul pollito | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 03:43:09'),
(733, 2, 'TOGGLE', 'fabric_colors', 18, NULL, 'Estado: 1 → 2 | negro | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 03:43:13'),
(734, 2, 'TOGGLE', 'fabric_colors', 18, NULL, 'Estado: 2 → 1 | negro | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 03:43:18'),
(735, 2, 'TOGGLE', 'fabric_colors', 19, NULL, 'Estado: 2 → 1 | azul pollito | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 03:43:19'),
(736, 2, 'TOGGLE', 'fabric_colors', 20, NULL, 'Estado: 2 → 1 | azul amarillo | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 03:43:21'),
(737, 2, 'UPDATE', 'fabric_colors', 20, NULL, 'Nombre: azul amarillo → azul amarillos | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 04:00:13'),
(738, 2, 'UPDATE', 'fabric_colors', 20, NULL, 'Nombre: azul amarillos → azul amarillos | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 04:00:41'),
(739, 2, 'UPDATE', 'fabric_colors', 20, NULL, 'Nombre: azul amarillos → azul amarillos | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 04:01:50'),
(740, 2, 'UPDATE', 'fabric_colors', 20, NULL, 'Nombre: azul amarillos → azul amarillosa | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 04:07:23'),
(741, 2, 'DELETE', 'proveedores', 10, 'Proveedor eliminado: dos ok', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-10 04:40:44'),
(742, 2, 'DELETE', 'proveedores', 1, 'Proveedor eliminado: Juan', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-06-10 05:37:31'),
(743, 2, 'DELETE', 'fabric_colors', 16, NULL, 'Registro eliminado: Rojo4 | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 05:37:37'),
(744, 2, 'DELETE', 'fabric_colors', 18, NULL, 'Registro eliminado: negro | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 05:39:20'),
(745, 2, 'UPDATE', 'usuarios', 27, 'Usuario actualizado', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-06-10 05:40:09'),
(746, 2, 'CREATE', 'fabric_colors', 22, NULL, 'Registro creado: amarillo1 | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 05:43:34'),
(747, 2, 'TOGGLE', 'fabric_colors', 19, NULL, 'Estado: 1 → 2 | azul pollito | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 05:43:43'),
(748, 2, 'TOGGLE', 'fabric_colors', 19, NULL, 'Estado: 2 → 1 | azul pollito | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 05:43:44'),
(749, 2, 'LOGOUT', 'usuarios', 2, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-10 05:43:55'),
(750, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-10 05:44:10'),
(751, 1, 'TOGGLE', 'fabric_colors', 22, NULL, 'Estado: 1 → 2 | amarillo1 | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 05:57:47'),
(752, 1, 'TOGGLE', 'fabric_colors', 22, NULL, 'Estado: 2 → 1 | amarillo1 | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 05:57:49'),
(753, 1, 'UPDATE', 'fabric_colors', 22, NULL, 'Nombre: amarillo1 → amarillo10 | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 05:57:54'),
(754, 1, 'DELETE', 'fabric_colors', 22, NULL, 'Registro eliminado: amarillo10 | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 05:57:59'),
(755, 1, 'TOGGLE', 'fabric_colors', 20, NULL, 'Estado: 1 → 2 | azul amarillosa | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 06:19:09'),
(756, 1, 'TOGGLE', 'fabric_colors', 20, NULL, 'Estado: 2 → 1 | azul amarillosa | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 06:19:09'),
(757, 1, 'TOGGLE', 'fabric_colors', 19, NULL, 'Estado: 1 → 2 | azul pollito | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 06:19:11'),
(758, 1, 'TOGGLE', 'fabric_colors', 19, NULL, 'Estado: 2 → 1 | azul pollito | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 06:19:15'),
(759, 1, 'LOGOUT', 'usuarios', 1, NULL, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-10 06:19:45'),
(760, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-10 06:19:51'),
(761, 1, 'TOGGLE', 'fabric_colors', 19, NULL, 'Estado: 1 → 2 | azul pollito | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 06:21:28'),
(762, 1, 'TOGGLE', 'fabric_colors', 19, NULL, 'Estado: 2 → 1 | azul pollito | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 06:21:30'),
(763, 1, 'RESTORE', 'fabric_colors', 22, NULL, 'Registro restaurado: amarillo10 | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 06:42:57'),
(764, 1, 'RESTORE', 'fabric_colors', 18, NULL, 'Registro restaurado: negro | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 06:43:11'),
(765, 1, 'RESTORE', 'fabric_colors', 17, NULL, 'Registro restaurado: Rojo5 | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 06:43:12'),
(766, 1, 'RESTORE', 'fabric_colors', 16, NULL, 'Registro restaurado: Rojo4 | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 06:43:14'),
(767, 1, 'CREATE', 'fabric_colors', 23, NULL, 'Registro creado: rojo7 | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 06:45:11'),
(768, 1, 'DELETE', 'fabric_colors', 23, NULL, 'Registro eliminado: rojo7 | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 06:45:16'),
(769, 1, 'RESTORE', 'fabric_colors', 23, NULL, 'Registro restaurado: rojo7 | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 06:45:22'),
(770, 1, 'LOGIN', 'usuarios', 1, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-10 06:45:52'),
(771, 1, 'RESTORE', 'fabric_colors', 15, NULL, 'Registro restaurado: Rojo6 | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 06:46:00'),
(772, 1, 'RESTORE', 'fabric_colors', 11, NULL, 'Registro restaurado: Rojo2 | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 06:46:08'),
(773, 1, 'RESTORE', 'fabric_colors', 9, NULL, 'Registro restaurado: Rojo | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 06:46:10'),
(774, 1, 'DELETE', 'fabric_colors', 15, NULL, 'Registro eliminado: Rojo6 | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 06:46:16'),
(775, 1, 'DELETE', 'fabric_colors', 16, NULL, 'Registro eliminado: Rojo4 | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 06:46:19'),
(776, 1, 'DELETE', 'fabric_colors', 17, NULL, 'Registro eliminado: Rojo5 | Usuario: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 06:46:21'),
(777, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-10 16:39:33'),
(778, 2, 'TOGGLE', 'fabric_colors', 11, NULL, 'Estado: 1 → 2 | Rojo2 | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 16:39:41'),
(779, 2, 'UPDATE', 'fabric_colors', 11, NULL, 'Nombre: Rojo2 → rojo212 | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 16:39:47'),
(780, 2, 'DELETE', 'fabric_colors', 11, NULL, 'Registro eliminado: rojo212 | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'products', '2026-06-10 16:39:51'),
(781, 2, 'LOGIN', 'usuarios', 2, NULL, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-06-10 17:24:19'),
(782, 2, 'TOGGLE', 'fabric_colors', 9, NULL, 'Estado: 1 → 2 | Rojo | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'products', '2026-06-11 04:08:07'),
(783, 2, 'TOGGLE', 'fabric_colors', 18, NULL, 'Estado: 1 → 2 | negro | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'products', '2026-06-11 04:22:36'),
(784, 2, 'TOGGLE', 'fabric_colors', 18, NULL, 'Estado: 2 → 1 | negro | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'products', '2026-06-11 04:22:39'),
(785, 2, 'TOGGLE', 'fabric_colors', 9, NULL, 'Estado: 2 → 1 | Rojo | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'products', '2026-06-11 04:22:41'),
(786, 2, 'UPDATE', 'fabric_colors', 9, NULL, 'Nombre: Rojo → rojo54 | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'products', '2026-06-11 04:22:48'),
(787, 2, 'TOGGLE', 'fabric_colors', 9, NULL, 'Estado: 1 → 2 | rojo54 | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'products', '2026-06-11 04:53:09'),
(788, 2, 'TOGGLE', 'fabric_colors', 18, NULL, 'Estado: 1 → 2 | negro | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'products', '2026-06-11 04:53:11'),
(789, 2, 'TOGGLE', 'fabric_colors', 18, NULL, 'Estado: 2 → 1 | negro | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'products', '2026-06-11 04:53:13'),
(790, 2, 'TOGGLE', 'fabric_colors', 9, NULL, 'Estado: 2 → 1 | rojo54 | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'products', '2026-06-11 04:53:15'),
(791, 2, 'UPDATE', 'fabric_colors', 9, NULL, 'Nombre: rojo54 → rojo | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'products', '2026-06-11 04:53:23'),
(792, 2, 'DELETE', 'fabric_colors', 20, NULL, 'Registro eliminado: azul amarillosa | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'products', '2026-06-11 04:53:36'),
(793, 2, 'TOGGLE', 'fabric_colors', 18, NULL, 'Estado: 1 → 2 | negro | Usuario: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'products', '2026-06-11 05:22:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `accion` varchar(50) NOT NULL,
  `entidad` varchar(100) NOT NULL,
  `entidad_id` int(11) DEFAULT NULL,
  `modulo` varchar(80) NOT NULL DEFAULT 'general',
  `detalle` longtext DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `usuario_id`, `accion`, `entidad`, `entidad_id`, `modulo`, `detalle`, `ip`, `user_agent`, `created_at`, `updated_at`) VALUES
(8, 1, 'CREATE', 'fabric_types', 6, 'inventory', '{\"codigo\":\"006\",\"nombre\":\"Bengalina Blusera\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-24 23:54:23', NULL),
(9, 1, 'CREATE', 'fabric_types', 7, 'inventory', '{\"codigo\":\"007\",\"nombre\":\"Bengalina Blusera V\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-24 23:54:34', NULL),
(10, 1, 'CREATE', 'fabric_types', 8, 'inventory', '{\"codigo\":\"008\",\"nombre\":\"Chalis Est. Flores\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-24 23:54:53', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fabric_colors`
--

DROP TABLE IF EXISTS `fabric_colors`;
CREATE TABLE `fabric_colors` (
  `id` int(11) NOT NULL,
  `codigo` varchar(30) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `hex` varchar(7) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `fabric_colors`
--

INSERT INTO `fabric_colors` (`id`, `codigo`, `nombre`, `hex`, `estado`, `created_at`, `deleted_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(3, '001', 'Negro nuevo', NULL, 0, '2026-05-28 14:00:24', '2026-05-31 01:44:50', NULL, NULL, NULL, NULL),
(4, '004', 'Rojo oscuro', NULL, 0, '2026-05-28 14:00:34', '2026-05-31 02:00:13', NULL, NULL, NULL, NULL),
(5, '005', 'Azul', NULL, 0, '2026-05-28 17:41:00', '2026-05-31 22:06:41', NULL, NULL, NULL, NULL),
(6, '006', 'Amarillo', NULL, 0, '2026-05-28 17:41:06', '2026-05-31 22:06:50', NULL, NULL, NULL, NULL),
(7, '007', 'Rosado', NULL, 0, '2026-05-28 17:41:11', '2026-06-03 12:20:25', NULL, NULL, NULL, NULL),
(9, '008', 'rojo', NULL, 1, '2026-06-03 09:47:28', NULL, '2026-06-10 01:46:10', NULL, 1, NULL),
(11, '010', 'rojo212', NULL, 0, '2026-06-03 09:50:41', '2026-06-10 11:39:51', '2026-06-10 01:46:08', NULL, 1, 2),
(15, '012', 'Rojo6', NULL, 0, '2026-06-03 20:26:53', '2026-06-10 01:46:16', '2026-06-10 01:46:00', NULL, 1, 1),
(16, '016', 'Rojo4', NULL, 0, '2026-06-03 20:27:08', '2026-06-10 01:46:18', '2026-06-10 01:43:13', NULL, 1, 1),
(17, '017', 'Rojo5', NULL, 0, '2026-06-03 20:27:17', '2026-06-10 01:46:21', '2026-06-10 01:43:12', NULL, 1, 1),
(18, '018', 'negro', NULL, 2, '2026-06-09 00:59:15', NULL, '2026-06-10 01:43:11', 2, 1, NULL),
(19, '019', 'azul pollito', NULL, 1, '2026-06-09 00:59:31', NULL, NULL, 2, NULL, NULL),
(20, '020', 'azul amarillosa', NULL, 0, '2026-06-09 22:11:51', '2026-06-10 23:53:36', NULL, 2, NULL, 2),
(22, '021', 'amarillo10', NULL, 1, '2026-06-10 00:43:34', NULL, '2026-06-10 01:42:57', 2, 1, NULL),
(23, '023', 'rojo7', NULL, 1, '2026-06-10 01:45:11', NULL, '2026-06-10 01:45:22', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fabric_types`
--

DROP TABLE IF EXISTS `fabric_types`;
CREATE TABLE `fabric_types` (
  `id` int(11) NOT NULL,
  `codigo` varchar(30) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `fabric_types`
--

INSERT INTO `fabric_types` (`id`, `codigo`, `nombre`, `estado`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(2, '1', 'algodon BordaDo', 0, '2026-05-25 03:18:54', NULL, NULL, NULL, '2026-05-31 06:45:31', NULL),
(6, '006', 'Bengalina Blusera', 0, '2026-05-25 04:54:23', NULL, NULL, NULL, '2026-05-28 22:34:39', NULL),
(7, '007', 'Bengalina blusera 3', 0, '2026-05-25 04:54:34', NULL, NULL, NULL, '2026-05-28 22:34:42', NULL),
(8, '008', 'Chalis Est. Flores', 0, '2026-05-25 04:54:53', NULL, NULL, NULL, '2026-05-28 22:35:00', NULL),
(9, '009', 'Camuflado', 0, '2026-05-26 03:27:45', NULL, NULL, NULL, '2026-05-31 07:00:37', NULL),
(10, '010', 'Camuflado4', 0, '2026-05-26 03:32:57', NULL, NULL, NULL, '2026-06-01 02:58:33', NULL),
(11, '011', 'Camuflado2', 0, '2026-05-26 03:33:43', NULL, NULL, NULL, '2026-06-01 03:05:51', NULL),
(12, '012', 'Bengalina2', 0, '2026-06-01 03:05:08', NULL, NULL, NULL, '2026-06-04 06:28:53', NULL),
(13, '013', 'Seda', 1, '2026-06-01 03:05:16', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventory_movements`
--

DROP TABLE IF EXISTS `inventory_movements`;
CREATE TABLE `inventory_movements` (
  `id` int(11) NOT NULL,
  `roll_id` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `metros` decimal(10,2) NOT NULL,
  `precio` decimal(14,2) DEFAULT NULL,
  `warehouse_origen_id` int(11) DEFAULT NULL,
  `warehouse_destino_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `referencia_id` int(11) DEFAULT NULL,
  `nota` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `modulo` varchar(50) NOT NULL,
  `accion` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `nombre`, `modulo`, `accion`, `created_at`, `updated_at`) VALUES
(1, 'users.view', 'users', 'view', NULL, NULL),
(2, 'users.create', 'users', 'create', NULL, NULL),
(3, 'users.edit', 'users', 'edit', NULL, NULL),
(4, 'users.delete', 'users', 'delete', NULL, NULL),
(5, 'users.restore', 'users', 'restore', NULL, NULL),
(6, 'products.view', 'products', 'view', NULL, NULL),
(7, 'products.create', 'products', 'create', NULL, NULL),
(8, 'products.edit', 'products', 'edit', NULL, NULL),
(9, 'products.delete', 'products', 'delete', NULL, NULL),
(10, 'products.restore', 'products', 'restore', NULL, NULL),
(11, 'warehouses.view', 'warehouses', 'view', NULL, NULL),
(12, 'warehouses.create', 'warehouses', 'create', NULL, NULL),
(13, 'warehouses.edit', 'warehouses', 'edit', NULL, NULL),
(14, 'warehouses.delete', 'warehouses', 'delete', NULL, NULL),
(15, 'warehouses.restore', 'warehouses', 'restore', NULL, NULL),
(16, 'roles.view', 'roles', 'view', NULL, NULL),
(17, 'roles.create', 'roles', 'create', NULL, NULL),
(18, 'roles.edit', 'roles', 'edit', NULL, NULL),
(19, 'roles.delete', 'roles', 'delete', NULL, NULL),
(20, 'roles.restore', 'roles', 'restore', NULL, NULL),
(21, 'proveedores.view', 'proveedores', 'view', NULL, NULL),
(22, 'proveedores.create', 'proveedores', 'create', NULL, NULL),
(23, 'proveedores.edit', 'proveedores', 'edit', NULL, NULL),
(24, 'proveedores.delete', 'proveedores', 'delete', NULL, NULL),
(25, 'proveedores.restore', 'proveedores', 'restore', NULL, NULL),
(26, 'users.view_username', 'users', 'view_username', NULL, NULL),
(27, 'users.view_email', 'users', 'view_email', NULL, NULL),
(28, 'users.view_avatar', 'users', 'view_avatar', NULL, NULL),
(29, 'products.view_cost', 'products', 'view_cost', NULL, NULL),
(30, 'users.view_deleted', 'users', 'view_deleted', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contacto` varchar(300) DEFAULT NULL,
  `nit` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Activo, 2=Inactivo',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `contacto`, `nit`, `email`, `telefono`, `ciudad`, `estado`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'Juan', '', '', NULL, '7412458', 'medellin', 0, '2026-05-21 00:57:11', '2026-06-10 00:37:31', 1, NULL, '2026-06-10 00:37:31', 2),
(2, 'Juan55', '', '4455', '', '7412458', 'Medellín', 0, '2026-05-21 00:58:51', '2026-06-03 23:34:46', 1, 1, NULL, NULL),
(3, 'Juan', 'Tyrty', '123456', '', '', 'Medellín', 0, '2026-05-21 11:55:44', '2026-05-26 00:29:43', 2, 1, NULL, NULL),
(4, 'Juanxcarlos', 'arensd', '12345623', NULL, NULL, 'Medellín', 1, '2026-05-21 12:24:28', '2026-06-07 22:16:57', 2, NULL, NULL, NULL),
(5, 'Pedro', 'sUAREZ', '1234563453', NULL, NULL, 'Medellín', 0, '2026-05-21 12:26:46', '2026-05-24 20:48:43', 2, NULL, NULL, NULL),
(6, 'Dos', 'Gonzalez', '1245689587', '', '', 'Medellín', 0, '2026-05-21 13:08:31', '2026-06-04 23:56:04', NULL, 2, NULL, NULL),
(9, 'Cvxc', '', '12345678', '', '', 'Medellín', 0, '2026-05-25 22:34:11', '2026-06-08 23:30:02', 1, NULL, '2026-06-08 23:30:02', 2),
(10, 'dos ok', '', '12345', '', '', 'medellin', 0, '2026-06-08 22:49:34', '2026-06-09 23:40:44', 2, 2, '2026-06-09 23:40:44', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchases`
--

DROP TABLE IF EXISTS `purchases`;
CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `numero_documento` varchar(80) NOT NULL,
  `fecha` date NOT NULL,
  `total` decimal(14,2) NOT NULL DEFAULT 0.00,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'abierta',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `descripcion`) VALUES
(1, 'super', 'Superadministrador del sistema'),
(2, 'administrador', 'Administrador del negocio'),
(3, 'secretaria', 'Apoyo administrativo'),
(4, 'bodeguero', 'Encargado de inventario'),
(5, 'vendedor', 'Encargado de ventas'),
(6, 'asistente', 'Apoyo general');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES
(248, 1, 1),
(249, 1, 2),
(250, 1, 3),
(251, 1, 4),
(252, 1, 5),
(253, 1, 6),
(254, 1, 7),
(255, 1, 8),
(256, 1, 9),
(257, 1, 10),
(258, 1, 11),
(259, 1, 12),
(260, 1, 13),
(261, 1, 14),
(262, 1, 15),
(263, 1, 16),
(264, 1, 17),
(265, 1, 18),
(266, 1, 19),
(267, 1, 20),
(268, 1, 21),
(269, 1, 22),
(270, 1, 23),
(271, 1, 24),
(272, 1, 25),
(273, 1, 26),
(274, 1, 27),
(275, 1, 28),
(276, 1, 29),
(277, 1, 30),
(278, 2, 1),
(279, 2, 2),
(280, 2, 3),
(281, 2, 4),
(282, 2, 26),
(283, 2, 6),
(284, 2, 7),
(285, 2, 8),
(286, 2, 9),
(287, 2, 11),
(288, 2, 16),
(289, 2, 21),
(290, 3, 1),
(291, 3, 26),
(292, 3, 6),
(293, 3, 21),
(294, 4, 6),
(295, 4, 7),
(296, 4, 8),
(297, 4, 11),
(298, 4, 13),
(299, 5, 6),
(300, 5, 21),
(301, 6, 1),
(302, 6, 6),
(303, 6, 11),
(304, 6, 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rolls`
--

DROP TABLE IF EXISTS `rolls`;
CREATE TABLE `rolls` (
  `id` int(11) NOT NULL,
  `fabric_type_id` int(11) NOT NULL,
  `fabric_color_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `codigo_barra` varchar(30) NOT NULL,
  `codigo_visible` varchar(60) NOT NULL,
  `metros` decimal(10,2) NOT NULL,
  `precio_compra` decimal(14,2) NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'activo',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ultimo_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `nombre`, `apellido`, `imagen`, `password`, `rol_id`, `estado`, `created_at`, `ultimo_login`) VALUES
(1, 'super', 'Alvaro', 'angulo4', NULL, '$2y$10$RSzWovudV1TflDF6PEtseuIEKYaM41vy1QoJhNPiR4Mgm.gzHeVsW', 1, 1, '2026-05-13 01:58:39', '2026-06-10 01:45:52'),
(2, 'admin', 'Jose', 'Gerente', 'user_6a265e0ca75b3.png', '$2y$10$MdmYsBXnKKZFbvtccI.qKeYHdd26cZ2G9bF123WO0DAmU4l0unAye', 2, 1, '2026-05-13 01:58:39', '2026-06-10 12:24:18'),
(3, 'bodega', 'Luis', 'Inventario', '3636d93d7ca203fd08fb0aa7d612746a.png', '$2y$10$dqoBrCstrAiDpDc4CPZl5e8IgXrHe.L3dVFf5qaa4O/lTQI7MfODi', 4, 1, '2026-05-13 01:58:39', '2026-06-04 01:26:37'),
(4, 'asistente', 'Laura', 'Apoyo', '7b91618a516c7c3e3022fc350bd86918.png', '$2y$10$RSzWovudV1TflDF6PEtseuIEKYaM41vy1QoJhNPiR4Mgm.gzHeVsW', 4, 0, '2026-05-13 01:58:39', NULL),
(5, 'vendedor1', 'Ana', 'Ventas', 'd481660f9d233d0d1bfa72d0606c769d.png', '$2y$10$RSzWovudV1TflDF6PEtseuIEKYaM41vy1QoJhNPiR4Mgm.gzHeVsW', 5, 0, '2026-05-13 01:58:39', NULL),
(6, 'secretaria', 'olga', 'Oficina', 'default.png', '$2y$10$RSzWovudV1TflDF6PEtseuIEKYaM41vy1QoJhNPiR4Mgm.gzHeVsW', 3, 0, '2026-05-13 01:58:39', NULL),
(7, 'testuser', 'Pedro', 'Pruebas', 'user_6a265bb6acce2.png', '$2y$10$RSzWovudV1TflDF6PEtseuIEKYaM41vy1QoJhNPiR4Mgm.gzHeVsW', 2, 1, '2026-05-13 01:58:39', NULL),
(8, 'super2', 'miqguel', 'Perez', NULL, '$2y$10$r6y1woEnEoXVy036Hw97e.T/xCpqHckWrtgXX98aZ0FcdJcEyBhQu', 2, 0, '2026-05-13 06:57:47', NULL),
(9, 'super3', 'Juan', 'quinrtero', 'default.png', '$2y$10$LN7GelcOWT2v0jpAuWXCbeXOd62l749EQKOygrjwdmDTYOc1CPeEa', 2, 0, '2026-05-13 07:00:26', NULL),
(10, 'once', 'DFSG', '', NULL, '$2y$10$gE/SnGPNudUz4NjbFS0oYurHiXt7fWtToehsSwFggx3bTsNvdq37y', 6, 0, '2026-05-13 07:15:48', NULL),
(11, 'cuatro', 'Fernando', 'Guzman', NULL, '$2y$10$WJ9QX1R0eUevL9523b3UhOCtkyItF8QgfZm9wvpWueQtE3CKsOuxa', 5, 0, '2026-05-13 07:17:20', NULL),
(12, 'prueb', 'glor', 'ber', NULL, '$2y$10$o7xAIDhooBXTKB6Lyahy/uVwj2jZi3mzPX/UV.qWF7ZnlRAsqf.pW', 5, 0, '2026-05-13 07:23:31', NULL),
(13, 'prueba', 'COlombia', 'quintero', 'default.png', '$2y$10$9QrmdAg/3FoZ5w/5AtVTEeJHWiGGZx7e4/xnvDorxlLA76VFr0AAS', 2, 1, '2026-05-13 07:33:09', NULL),
(14, 'prueba5', 'Juan', 'Guzman', NULL, '$2y$10$GSVqtuwx/TLmyC3CPuIb4ezrv5dybvJ5HZJOlXySeBpMm93ZcvkYG', 4, 0, '2026-05-13 07:34:34', NULL),
(15, 'prueba6', 'Juan', 'Guzman', NULL, '$2y$10$LoJ1ujNqGgz176xYzFncq.2Wt/6LCgRSE87EOjH3AWowcl1gMQON2', 4, 0, '2026-05-13 07:35:11', NULL),
(16, 'prueba7', 'Juan', 'Guzman', NULL, '$2y$10$.4LcfouBN.qjldRFE0g0ruwFezijY4m67F/FUH2Ss7v8em9hgTZ0q', 4, 0, '2026-05-13 07:35:48', NULL),
(18, 'prueba8', 'Juan', 'Guzman', NULL, '$2y$10$LbpYmwz0i7Ckf7VLwP.vxeLBGSaY4AQ2BumHAqJm1cr/mtIRaHFKy', 4, 0, '2026-05-13 07:36:49', NULL),
(19, 'prueba9', 'Juan', 'Guzman', NULL, '$2y$10$0yPa7bbnYsSLnCwdFp8XA.bzLImubZpHoPGENxGX65RBRAW3qduEW', 4, 0, '2026-05-13 07:37:09', NULL),
(20, 'prueba0', 'DFSG', 'Perez', NULL, '$2y$10$ywHNVDFGsC.qSsusSIaK8OLworsE0VIX0Xjk4I/E/4/k5dvX8mBTm', 5, 0, '2026-05-13 07:40:45', NULL),
(22, 'prueba11', 'DFSG', 'Perez', NULL, '$2y$10$7ttnUj0rWFinz2M69rx5Jegz7zcV6r9xyAaPP/Dp1hG4S27k5KNe6', 5, 0, '2026-05-13 07:42:25', NULL),
(23, 'busdf', 'asdfasdf', '', 'default.png', '$2y$10$YkdzbUSEcfjFutMBMKpFmusXadcAg/p6QmzYhuTmvWj9zsxw7xnYS', 4, 0, '2026-05-19 04:17:09', NULL),
(24, 'qaws', 'Juan', 'asd', 'default.png', '$2y$10$.cTUmwqb70Ec.rQ0pqpk/emS.i477UAw5dHvMVnaY9lbsZZfjnYwq', 5, 0, '2026-05-19 04:31:07', NULL),
(25, 'qwer', 'Juan', 'Guzman', 'default.png', '$2y$10$5JkH4BqdPjkbAsM0FTdQoeSY1Zdvav1JKiqB8UjRWgpRe7S/7ggY6', 4, 0, '2026-05-19 04:32:54', NULL),
(26, 'qasw', 'sd', 'asdas', 'default.png', '$2y$10$WhUSme2LsLrJ9FVmcVw6oOc18NmMYGTOB9aB1WWRNK1yToTgeEvY.', 4, 1, '2026-05-19 04:36:39', NULL),
(27, 'qazxs', 'Juan2', '', 'default.png', '$2y$10$Lsk4xzWFAJuUeoqC4Xl3U.sDCsOD.G9H5fQcXjCppeQ9UEbgCAzBi', 4, 1, '2026-05-19 04:44:02', NULL),
(28, 'qazxc', 'qwqw', 'Guzman', 'default.png', '$2y$10$v6rKIjRcufC4xF4JsIVlkO2vkydVuo/7HQFICEZHz5P5eyL/N8KAi', 3, 1, '2026-05-19 04:44:22', NULL),
(29, 'qwert', 'dfsdgf', 'sdfgsdfg', 'user_6a265d6e3a6e0.png', '$2y$10$ANt5oZMgyRxgF3hrA1tKHePw1m7jn14BxJS2/PtWfqM8xy5rEP42W', 4, 1, '2026-05-19 04:44:56', NULL),
(30, 'qwsde4', 'Juan', 'Guzman', 'bff24b9076efd42f2b17ddb52ef8a3dd.png', '$2y$10$3J5mKSJ7pN.vqTQof8mOsObK206Yciwt.PERj2YChdIJ9WqgKWeRC', 5, 0, '2026-05-19 04:46:41', NULL),
(31, 'wewqe', 'wqerw', 'qwewqr', 'd50256f24fa54d0ff38d36450435ac12.png', '$2y$10$7Zvm/8D8bAaamB7dzHUKKexSyD88fdYKJdZhL9FKjSQjEgqB2fxOe', 4, 0, '2026-05-19 04:49:52', NULL),
(32, 'frgt', 'qweqwr', 'wdewr', 'f9be669723862e702214f3fb7f0980a9.png', '$2y$10$HHd/Fcamz07I1RtQM0wOze/1GC3kI8k9aURz3cSljbaEMTbvplNXm', 4, 0, '2026-05-19 05:00:07', NULL),
(33, 'qwasddf', 'safdsdf', 'asdfsdf', 'f71fdab8526dcb34b3b1e4e706411980.png', '$2y$10$vI7DdowWk/FkRnyFx1KPfu4ALDfcudbNAeC/F80ULElIoQTx.c8.q', 5, 0, '2026-05-19 05:06:35', NULL),
(34, 'qwewqe', 'erewr', '', '3e7f3f7e68a3be4977ec833f0839f350.png', '$2y$10$MmllyCN5jjB84wdQBVGoluNKEh0YjJDEp1tYb2XM/WP8KUty69FDm', 4, 0, '2026-05-19 05:07:23', NULL),
(35, 'qasd', 'asdsf', 'sdfdsf', 'user_6a265bd1b0a22.png', '$2y$10$b6XfP5PtgtmlSo/J2vu6qOZhhRUFi7NVRiOfBGen3fslNdCZ/roRm', 4, 1, '2026-05-19 05:20:31', NULL),
(37, 'admin2', 'Carlos', 'Gutierrez', 'user_6a265c27a4b9e.jpeg', '$2y$10$l9HPvJGRsfjvGn1M32xuPOqGJ3QDEHwFi84QSMYtZqabatPnGpBy2', 6, 1, '2026-06-08 01:47:46', NULL),
(38, 'admin3', 'kilo', '', NULL, '$2y$10$8dLKTx80pqVIZ1Keg5GLAeU8E4343cyT0Fo2XcAFAKPunu3BBor0S', 6, 1, '2026-06-08 04:43:06', NULL),
(39, 'admin4', 'PEDRO', '', NULL, '$2y$10$pNsVPy8qElmwPtdE8Q7hv.2FiGUpRQM19JuFz7g5AM3vob2ygc1t.', 2, 1, '2026-06-08 04:50:44', NULL),
(40, 'admin5', 'juan', '', 'user_6a265dff587da.png', '$2y$10$.0WXcwg2niIUSiAkFR9eTuD4H5MK/DUOL42FuImoq6VYLhsq34Xbi', 6, 1, '2026-06-08 04:55:59', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `warehouses`
--

DROP TABLE IF EXISTS `warehouses`;
CREATE TABLE `warehouses` (
  `id` int(11) NOT NULL,
  `codigo` varchar(30) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ubicacion` varchar(150) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `warehouses`
--

INSERT INTO `warehouses` (`id`, `codigo`, `nombre`, `ubicacion`, `descripcion`, `estado`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'BOD-PRINCIPAL', 'Bodega principal', NULL, NULL, 0, '2026-05-24 22:05:13', NULL, NULL, NULL, NULL, NULL),
(2, '', 'dos', 'Medellin', NULL, 1, '2026-05-30 22:30:30', NULL, NULL, NULL, NULL, NULL),
(5, 'BOD-003', 'tres', 'Belen', NULL, 2, '2026-05-30 22:50:16', NULL, NULL, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_audit_usuario` (`usuario_id`),
  ADD KEY `idx_audit_entidad` (`entidad`,`entidad_id`),
  ADD KEY `idx_audit_modulo` (`modulo`),
  ADD KEY `idx_audit_fecha` (`created_at`);

--
-- Indices de la tabla `fabric_colors`
--
ALTER TABLE `fabric_colors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_fabric_colors_codigo` (`codigo`),
  ADD UNIQUE KEY `uq_fabric_colors_nombre` (`nombre`);

--
-- Indices de la tabla `fabric_types`
--
ALTER TABLE `fabric_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_fabric_types_codigo` (`codigo`),
  ADD UNIQUE KEY `uq_fabric_types_nombre` (`nombre`);

--
-- Indices de la tabla `inventory_movements`
--
ALTER TABLE `inventory_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_movements_roll` (`roll_id`),
  ADD KEY `idx_movements_tipo` (`tipo`),
  ADD KEY `idx_movements_origin` (`warehouse_origen_id`),
  ADD KEY `idx_movements_destination` (`warehouse_destino_id`),
  ADD KEY `fk_mov_created_by` (`created_by`),
  ADD KEY `fk_mov_updated_by` (`updated_by`),
  ADD KEY `fk_mov_deleted_by` (`deleted_by`),
  ADD KEY `idx_mov_purchase` (`purchase_id`),
  ADD KEY `idx_mov_fecha` (`created_at`),
  ADD KEY `idx_mov_deleted` (`deleted_at`),
  ADD KEY `idx_mov_referencia` (`referencia_id`),
  ADD KEY `idx_mov_roll_fecha` (`roll_id`,`created_at`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nit` (`nit`),
  ADD KEY `idx_estado` (`estado`),
  ADD KEY `idx_created_by` (`created_by`),
  ADD KEY `idx_updated_by` (`updated_by`);

--
-- Indices de la tabla `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_purchase_doc_supplier` (`numero_documento`,`supplier_id`),
  ADD KEY `idx_purchases_supplier` (`supplier_id`),
  ADD KEY `idx_purchases_estado` (`estado`),
  ADD KEY `idx_purchases_fecha` (`fecha`),
  ADD KEY `idx_purchases_deleted` (`deleted_at`),
  ADD KEY `fk_purchases_created_by` (`created_by`),
  ADD KEY `fk_purchases_updated_by` (`updated_by`),
  ADD KEY `fk_purchases_deleted_by` (`deleted_by`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indices de la tabla `rolls`
--
ALTER TABLE `rolls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_rolls_codigo_barra` (`codigo_barra`),
  ADD KEY `idx_rolls_codigo_visible` (`codigo_visible`),
  ADD KEY `fk_rolls_color` (`fabric_color_id`),
  ADD KEY `fk_rolls_supplier` (`supplier_id`),
  ADD KEY `fk_rolls_purchase` (`purchase_id`),
  ADD KEY `fk_rolls_created_by` (`created_by`),
  ADD KEY `fk_roll_updated_by` (`updated_by`),
  ADD KEY `fk_roll_deleted_by` (`deleted_by`),
  ADD KEY `idx_roll_type_color_warehouse` (`fabric_type_id`,`fabric_color_id`,`warehouse_id`),
  ADD KEY `idx_roll_deleted` (`deleted_at`),
  ADD KEY `idx_roll_warehouse_estado` (`warehouse_id`,`estado`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `rol_id` (`rol_id`);

--
-- Indices de la tabla `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_warehouses_codigo` (`codigo`),
  ADD KEY `fk_warehouse_created_by` (`created_by`),
  ADD KEY `fk_warehouse_updated_by` (`updated_by`),
  ADD KEY `fk_warehouse_deleted_by` (`deleted_by`),
  ADD KEY `idx_warehouse_estado` (`estado`),
  ADD KEY `idx_warehouse_deleted` (`deleted_at`),
  ADD KEY `idx_warehouse_nombre` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=794;

--
-- AUTO_INCREMENT de la tabla `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `fabric_colors`
--
ALTER TABLE `fabric_colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `fabric_types`
--
ALTER TABLE `fabric_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `inventory_movements`
--
ALTER TABLE `inventory_movements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=305;

--
-- AUTO_INCREMENT de la tabla `rolls`
--
ALTER TABLE `rolls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `fk_audit_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `inventory_movements`
--
ALTER TABLE `inventory_movements`
  ADD CONSTRAINT `fk_mov_created_by` FOREIGN KEY (`created_by`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `fk_mov_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_mov_purchase` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_mov_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_movements_destination` FOREIGN KEY (`warehouse_destino_id`) REFERENCES `warehouses` (`id`),
  ADD CONSTRAINT `fk_movements_origin` FOREIGN KEY (`warehouse_origen_id`) REFERENCES `warehouses` (`id`),
  ADD CONSTRAINT `fk_movements_roll` FOREIGN KEY (`roll_id`) REFERENCES `rolls` (`id`);

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `fk_proveedor_created_by` FOREIGN KEY (`created_by`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `fk_proveedor_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `fk_purchases_created_by` FOREIGN KEY (`created_by`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_purchases_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_purchases_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `proveedores` (`id`),
  ADD CONSTRAINT `fk_purchases_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`);

--
-- Filtros para la tabla `rolls`
--
ALTER TABLE `rolls`
  ADD CONSTRAINT `fk_roll_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_roll_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_rolls_color` FOREIGN KEY (`fabric_color_id`) REFERENCES `fabric_colors` (`id`),
  ADD CONSTRAINT `fk_rolls_created_by` FOREIGN KEY (`created_by`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `fk_rolls_purchase` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`),
  ADD CONSTRAINT `fk_rolls_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `proveedores` (`id`),
  ADD CONSTRAINT `fk_rolls_type` FOREIGN KEY (`fabric_type_id`) REFERENCES `fabric_types` (`id`),
  ADD CONSTRAINT `fk_rolls_warehouse` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `warehouses`
--
ALTER TABLE `warehouses`
  ADD CONSTRAINT `fk_warehouse_created_by` FOREIGN KEY (`created_by`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_warehouse_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_warehouse_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
