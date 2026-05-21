-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2026 a las 20:03:07
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
CREATE DATABASE IF NOT EXISTS `devpos_cesar` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `devpos_cesar`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

CREATE TABLE `auditoria` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `accion` varchar(50) DEFAULT NULL,
  `tabla` varchar(50) DEFAULT NULL,
  `registro_id` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `modulo` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `auditoria`
--

INSERT INTO `auditoria` (`id`, `usuario_id`, `accion`, `tabla`, `registro_id`, `descripcion`, `ip`, `user_agent`, `modulo`, `created_at`) VALUES
(1, 2, 'TEST', 'usuarios', 1, 'PRUEBA DIRECTA', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:03:08'),
(2, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:05:10'),
(3, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:05:49'),
(4, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:07:40'),
(5, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:08:06'),
(6, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:15:46'),
(7, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:15:54'),
(8, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:18:07'),
(9, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:19:13'),
(10, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:27:00'),
(11, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:43:53'),
(12, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 03:44:01'),
(13, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:14'),
(14, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:14'),
(15, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:14'),
(16, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:14'),
(17, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:14'),
(18, 1, 'UPDATE', 'usuarios', 5, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:19'),
(19, 1, 'UPDATE', 'usuarios', 6, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:21'),
(20, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:23'),
(21, 1, 'UPDATE', 'usuarios', 5, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:25'),
(22, 1, 'UPDATE', 'usuarios', 6, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:26'),
(23, 1, 'UPDATE', 'usuarios', 7, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:27'),
(24, 1, 'UPDATE', 'usuarios', 6, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:28'),
(25, 1, 'UPDATE', 'usuarios', 5, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:30'),
(26, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:31'),
(27, 1, 'UPDATE', 'usuarios', 7, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'general', '2026-05-13 03:51:32'),
(28, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 04:15:20'),
(29, 1, 'CREATE', 'usuarios', 8, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 06:57:47'),
(30, 1, 'CREATE', 'usuarios', 9, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:00:26'),
(31, 1, 'CREATE', 'usuarios', 10, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:15:48'),
(32, 1, 'CREATE', 'usuarios', 11, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:17:22'),
(33, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 07:18:42'),
(34, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 07:18:48'),
(35, 1, 'CREATE', 'usuarios', 12, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:23:31'),
(36, 1, 'CREATE', 'usuarios', 13, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:33:09'),
(37, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 07:33:53'),
(38, 1, 'CREATE', 'usuarios', 14, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:34:35'),
(39, 1, 'CREATE', 'usuarios', 15, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:35:11'),
(40, 1, 'CREATE', 'usuarios', 16, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:35:48'),
(41, 1, 'CREATE', 'usuarios', 18, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:36:50'),
(42, 1, 'CREATE', 'usuarios', 19, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:37:09'),
(43, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-13 07:40:15'),
(44, 1, 'CREATE', 'usuarios', 20, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:40:45'),
(45, 1, 'CREATE', 'usuarios', 22, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-13 07:42:25'),
(46, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-14 03:23:41'),
(47, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-14 04:16:03'),
(48, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:12'),
(49, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:12'),
(50, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:12'),
(51, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:12'),
(52, 1, 'UPDATE', 'usuarios', 5, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:12'),
(53, 1, 'UPDATE', 'usuarios', 5, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:12'),
(54, 1, 'UPDATE', 'usuarios', 6, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:13'),
(55, 1, 'UPDATE', 'usuarios', 5, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:15'),
(56, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:16'),
(57, 1, 'UPDATE', 'usuarios', 7, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:18'),
(58, 1, 'UPDATE', 'usuarios', 7, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:19'),
(59, 1, 'UPDATE', 'usuarios', 6, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:20'),
(60, 1, 'UPDATE', 'usuarios', 5, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:22'),
(61, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:24'),
(62, 1, 'UPDATE', 'usuarios', 3, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:25'),
(63, 1, 'UPDATE', 'usuarios', 8, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:28'),
(64, 1, 'UPDATE', 'usuarios', 9, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:30'),
(65, 1, 'UPDATE', 'usuarios', 9, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:32'),
(66, 1, 'UPDATE', 'usuarios', 8, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:33'),
(67, 1, 'UPDATE', 'usuarios', 7, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:34'),
(68, 1, 'UPDATE', 'usuarios', 6, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:35'),
(69, 1, 'UPDATE', 'usuarios', 5, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:37'),
(70, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:39'),
(71, 1, 'UPDATE', 'usuarios', 5, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:41'),
(72, 1, 'UPDATE', 'usuarios', 6, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:42'),
(73, 1, 'UPDATE', 'usuarios', 7, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:43'),
(74, 1, 'UPDATE', 'usuarios', 8, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 04:18:45'),
(75, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-14 04:43:59'),
(76, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-14 04:57:58'),
(77, 1, 'UPDATE', 'usuarios', 6, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:05:35'),
(78, 1, 'UPDATE', 'usuarios', 7, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:05:37'),
(79, 1, 'UPDATE', 'usuarios', 3, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:06:52'),
(80, 1, 'UPDATE', 'usuarios', 3, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:06:52'),
(81, 1, 'UPDATE', 'usuarios', 3, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:06:55'),
(82, 1, 'UPDATE', 'usuarios', 5, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:06:56'),
(83, 1, 'UPDATE', 'usuarios', 8, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:06:58'),
(84, 1, 'UPDATE', 'usuarios', 8, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:07:00'),
(85, 1, 'UPDATE', 'usuarios', 5, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:21:40'),
(86, 1, 'UPDATE', 'usuarios', 6, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:21:42'),
(87, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:30:13'),
(88, 1, 'UPDATE', 'usuarios', 3, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:30:14'),
(89, 1, 'UPDATE', 'usuarios', 2, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:30:15'),
(90, 1, 'UPDATE', 'usuarios', 2, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:30:17'),
(91, 1, 'UPDATE', 'usuarios', 3, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:30:18'),
(92, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:30:19'),
(93, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:41:08'),
(94, 1, 'UPDATE', 'usuarios', 3, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:41:10'),
(95, 1, 'UPDATE', 'usuarios', 2, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:41:11'),
(96, 1, 'UPDATE', 'usuarios', 7, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:41:13'),
(97, 1, 'UPDATE', 'usuarios', 2, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:16'),
(98, 1, 'UPDATE', 'usuarios', 3, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:17'),
(99, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-14 05:42:36'),
(100, 1, 'UPDATE', 'usuarios', 5, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:41'),
(101, 1, 'UPDATE', 'usuarios', 7, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:43'),
(102, 1, 'UPDATE', 'usuarios', 7, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:45'),
(103, 1, 'UPDATE', 'usuarios', 6, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:47'),
(104, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:49'),
(105, 1, 'UPDATE', 'usuarios', 7, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:51'),
(106, 1, 'UPDATE', 'usuarios', 8, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:52'),
(107, 1, 'UPDATE', 'usuarios', 7, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:54'),
(108, 1, 'UPDATE', 'usuarios', 6, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:55'),
(109, 1, 'UPDATE', 'usuarios', 5, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-14 05:42:56'),
(110, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-14 05:55:14'),
(111, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-16 04:23:26'),
(112, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 02:32:08'),
(113, 2, 'LOGOUT', 'usuarios', 2, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 02:32:33'),
(114, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 02:32:41'),
(115, 1, 'UPDATE', 'usuarios', 22, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 02:32:49'),
(116, 1, 'UPDATE', 'usuarios', 20, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 02:32:50'),
(117, 1, 'UPDATE', 'usuarios', 19, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 02:32:51'),
(118, 1, 'UPDATE', 'usuarios', 18, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 02:32:53'),
(119, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 06:00:06'),
(120, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 06:00:13'),
(121, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 06:26:49'),
(122, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 06:28:09'),
(123, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 06:28:18'),
(124, 2, 'LOGOUT', 'usuarios', 2, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 06:28:26'),
(125, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 06:28:32'),
(126, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 06:31:06'),
(127, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-18 06:35:57'),
(128, 1, 'UPDATE', 'usuarios', 1, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:37:49'),
(129, 1, 'UPDATE', 'usuarios', 2, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:37:51'),
(130, 1, 'UPDATE', 'usuarios', 8, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:37:53'),
(131, 1, 'UPDATE', 'usuarios', 1, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:37:55'),
(132, 1, 'UPDATE', 'usuarios', 2, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:37:56'),
(133, 1, 'UPDATE', 'usuarios', 7, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:37:57'),
(134, 1, 'UPDATE', 'usuarios', 8, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:37:58'),
(135, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:37:59'),
(136, 1, 'UPDATE', 'usuarios', 13, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:01'),
(137, 1, 'UPDATE', 'usuarios', 9, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:03'),
(138, 1, 'UPDATE', 'usuarios', 9, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:05'),
(139, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:06'),
(140, 1, 'UPDATE', 'usuarios', 13, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:07'),
(141, 1, 'UPDATE', 'usuarios', 18, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:09'),
(142, 1, 'UPDATE', 'usuarios', 19, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:10'),
(143, 1, 'UPDATE', 'usuarios', 5, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:10'),
(144, 1, 'UPDATE', 'usuarios', 20, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:12'),
(145, 1, 'UPDATE', 'usuarios', 22, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:12'),
(146, 1, 'UPDATE', 'usuarios', 6, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:14'),
(147, 1, 'UPDATE', 'usuarios', 12, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:15'),
(148, 1, 'UPDATE', 'usuarios', 18, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:17'),
(149, 1, 'UPDATE', 'usuarios', 16, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:18'),
(150, 1, 'UPDATE', 'usuarios', 15, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:19'),
(151, 1, 'UPDATE', 'usuarios', 14, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:38:22'),
(152, 1, 'UPDATE', 'usuarios', 3, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:42:38'),
(153, 1, 'UPDATE', 'usuarios', 9, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:42:40'),
(154, 1, 'UPDATE', 'usuarios', 3, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:43:57'),
(155, 1, 'UPDATE', 'usuarios', 9, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:43:57'),
(156, 1, 'UPDATE', 'usuarios', 14, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:43:58'),
(157, 1, 'UPDATE', 'usuarios', 15, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:43:59'),
(158, 1, 'UPDATE', 'usuarios', 16, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:00'),
(159, 1, 'UPDATE', 'usuarios', 18, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:01'),
(160, 1, 'UPDATE', 'usuarios', 12, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:02'),
(161, 1, 'UPDATE', 'usuarios', 2, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:53'),
(162, 1, 'UPDATE', 'usuarios', 7, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:53'),
(163, 1, 'UPDATE', 'usuarios', 8, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:54'),
(164, 1, 'UPDATE', 'usuarios', 3, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:55'),
(165, 1, 'UPDATE', 'usuarios', 9, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:55'),
(166, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:56'),
(167, 1, 'UPDATE', 'usuarios', 13, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:56'),
(168, 1, 'UPDATE', 'usuarios', 14, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:57'),
(169, 1, 'UPDATE', 'usuarios', 15, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:58'),
(170, 1, 'UPDATE', 'usuarios', 16, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-18 06:44:58'),
(171, 1, 'UPDATE', 'usuarios', 2, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:26:28'),
(172, 1, 'UPDATE', 'usuarios', 7, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:26:29'),
(173, 1, 'UPDATE', 'usuarios', 8, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:26:29'),
(174, 1, 'UPDATE', 'usuarios', 3, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:26:30'),
(175, 1, 'UPDATE', 'usuarios', 9, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:26:30'),
(176, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:26:31'),
(177, 1, 'UPDATE', 'usuarios', 13, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:26:32'),
(178, 1, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:29:39'),
(179, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 01:53:46'),
(180, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 01:53:58'),
(181, 1, 'UPDATE', 'usuarios', 5, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:54:08'),
(182, 1, 'UPDATE', 'usuarios', 6, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:54:10'),
(183, 1, 'UPDATE', 'usuarios', 3, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:54:19'),
(184, 1, 'UPDATE', 'usuarios', 2, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 01:54:24'),
(185, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 02:22:22'),
(186, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 02:35:45'),
(187, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 02:37:01'),
(188, 1, 'UPDATE', 'usuarios', 2, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 03:14:17'),
(189, 1, 'UPDATE', 'usuarios', 2, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:00:53'),
(190, 1, 'CREATE', 'usuarios', 23, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:17:10'),
(191, 1, 'CREATE', 'usuarios', 24, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:31:07'),
(192, 1, 'CREATE', 'usuarios', 25, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:32:54'),
(193, 1, 'CREATE', 'usuarios', 26, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:36:39'),
(194, 1, 'CREATE', 'usuarios', 27, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:44:02'),
(195, 1, 'CREATE', 'usuarios', 28, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:44:22'),
(196, 1, 'CREATE', 'usuarios', 29, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:44:57'),
(197, 1, 'CREATE', 'usuarios', 30, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:46:41'),
(198, 1, 'CREATE', 'usuarios', 31, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 04:49:53'),
(199, 1, 'CREATE', 'usuarios', 32, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 05:00:07'),
(200, 1, 'CREATE', 'usuarios', 33, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 05:06:35'),
(201, 1, 'CREATE', 'usuarios', 34, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 05:07:23'),
(202, 1, 'CREATE', 'usuarios', 35, 'Creación de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 05:20:31'),
(203, 1, 'UPDATE', 'usuarios', 33, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 05:36:40'),
(204, 1, 'UPDATE', 'usuarios', 2, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 05:37:18'),
(205, 1, 'UPDATE', 'usuarios', 2, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 05:37:19'),
(206, 1, 'UPDATE', 'usuarios', 2, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 05:37:32'),
(207, 1, 'UPDATE', 'usuarios', 2, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 05:38:01'),
(208, 1, 'UPDATE', 'usuarios', 1, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 07:09:51'),
(209, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 14:58:19'),
(210, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 14:58:40'),
(211, 2, 'LOGOUT', 'usuarios', 2, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 15:01:01'),
(212, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 15:01:09'),
(213, 1, 'UPDATE', 'usuarios', 2, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-19 15:01:19'),
(214, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-19 15:09:01'),
(215, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-19 15:09:09'),
(216, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-19 15:14:58'),
(217, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-19 15:17:49'),
(218, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-19 15:17:55'),
(219, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-19 15:24:28'),
(220, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-19 15:41:24'),
(221, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-19 15:48:27'),
(222, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 15:59:02'),
(223, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:11:32'),
(224, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:12:14'),
(225, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:12:20'),
(226, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:12:26'),
(227, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:12:39'),
(228, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:14:47'),
(229, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:14:56'),
(230, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:17:02');
INSERT INTO `auditoria` (`id`, `usuario_id`, `accion`, `tabla`, `registro_id`, `descripcion`, `ip`, `user_agent`, `modulo`, `created_at`) VALUES
(231, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:18:08'),
(232, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:18:15'),
(233, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:21:52'),
(234, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 16:33:55'),
(235, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 17:06:04'),
(236, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 17:07:26'),
(237, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-19 17:18:57'),
(238, 1, 'UPDATE', 'usuarios', 2, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 02:08:52'),
(239, 1, 'UPDATE', 'usuarios', 2, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 02:41:56'),
(240, 1, 'UPDATE', 'usuarios', 2, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 02:42:19'),
(241, 1, 'UPDATE', 'usuarios', 2, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 02:52:51'),
(242, 1, 'UPDATE', 'usuarios', 2, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:13:00'),
(243, 1, 'UPDATE', 'usuarios', 2, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:14:10'),
(244, 1, 'UPDATE', 'usuarios', 2, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:21:39'),
(245, 1, 'UPDATE', 'usuarios', 3, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:21:53'),
(246, 1, 'UPDATE', 'usuarios', 3, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:22:05'),
(247, 1, 'UPDATE', 'usuarios', 3, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:22:12'),
(248, 1, 'UPDATE', 'usuarios', 3, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:22:26'),
(249, 1, 'UPDATE', 'usuarios', 3, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:22:35'),
(250, 1, 'UPDATE', 'usuarios', 4, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:23:04'),
(251, 1, 'UPDATE', 'usuarios', 2, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:37:13'),
(252, 1, 'UPDATE', 'usuarios', 2, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 03:37:40'),
(253, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 03:37:46'),
(254, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 03:37:59'),
(255, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 03:44:33'),
(256, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 03:47:54'),
(257, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 03:57:47'),
(258, 2, 'LOGOUT', 'usuarios', 2, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-20 04:10:16'),
(259, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'auth', '2026-05-20 04:10:22'),
(260, 2, 'UPDATE', 'usuarios', 3, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:11:07'),
(261, 2, 'LOGOUT', 'usuarios', 2, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 04:11:19'),
(262, 3, 'LOGIN', 'usuarios', 3, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 04:11:32'),
(263, 3, 'UPDATE', 'usuarios', 2, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:31:37'),
(264, 3, 'UPDATE', 'usuarios', 2, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:31:39'),
(265, 3, 'UPDATE', 'usuarios', 2, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:31:40'),
(266, 3, 'UPDATE', 'usuarios', 2, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:31:40'),
(267, 3, 'UPDATE', 'usuarios', 2, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:31:41'),
(268, 3, 'UPDATE', 'usuarios', 2, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:31:42'),
(269, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 04:32:07'),
(270, 2, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:32:19'),
(271, 2, 'UPDATE', 'usuarios', 5, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:32:21'),
(272, 2, 'UPDATE', 'usuarios', 6, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:32:22'),
(273, 2, 'UPDATE', 'usuarios', 3, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:32:23'),
(274, 2, 'UPDATE', 'usuarios', 4, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:32:26'),
(275, 2, 'UPDATE', 'usuarios', 5, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:32:27'),
(276, 2, 'UPDATE', 'usuarios', 6, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:32:28'),
(277, 2, 'UPDATE', 'usuarios', 8, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:32:30'),
(278, 2, 'UPDATE', 'usuarios', 7, 'Cambio de estado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:32:32'),
(279, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 04:44:02'),
(280, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 04:49:07'),
(281, 2, 'UPDATE', 'usuarios', 9, 'Usuario: super3 | Estado: Activo → Inactivo | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:55:03'),
(282, 2, 'UPDATE', 'usuarios', 9, 'Usuario: super3 | Estado: Inactivo → Activo | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:55:07'),
(283, 2, 'UPDATE', 'usuarios', 10, 'Usuario: once | Estado: Activo → Inactivo | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:55:09'),
(284, 2, 'UPDATE', 'usuarios', 9, 'Usuario: super3 | Estado: Activo → Inactivo | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:55:12'),
(285, 2, 'UPDATE', 'usuarios', 10, 'Usuario: once | Estado: Inactivo → Activo | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:55:14'),
(286, 2, 'UPDATE', 'usuarios', 9, 'Usuario: super3 | Estado: Inactivo → Activo | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:55:16'),
(287, 2, 'UPDATE', 'usuarios', 10, 'Usuario: once | Estado: Activo → Inactivo | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:55:18'),
(288, 2, 'UPDATE', 'usuarios', 10, 'Usuario: once | Estado: Inactivo → Activo | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:55:19'),
(289, 2, 'UPDATE', 'usuarios', 10, 'Usuario: once | Estado: Activo → Inactivo | Por: admin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:55:27'),
(290, 2, 'LOGOUT', 'usuarios', 2, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 04:56:42'),
(291, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 04:57:22'),
(292, 2, 'UPDATE', 'usuarios', 13, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:57:51'),
(293, 2, 'UPDATE', 'usuarios', 13, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:58:25'),
(294, 2, 'LOGOUT', 'usuarios', 2, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 04:58:32'),
(295, 13, 'LOGIN', 'usuarios', 13, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-20 04:58:44'),
(296, 13, 'UPDATE', 'usuarios', 9, 'Usuario: super3 | Estado: Activo → Inactivo | Por: prueba', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:59:01'),
(297, 13, 'UPDATE', 'usuarios', 9, 'Usuario: super3 | Estado: Inactivo → Activo | Por: prueba', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-20 04:59:05'),
(298, 13, 'UPDATE', 'usuarios', 9, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 01:54:31'),
(299, 13, 'UPDATE', 'usuarios', 9, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 01:54:47'),
(300, 13, 'LOGOUT', 'usuarios', 13, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 01:54:56'),
(301, 9, 'LOGIN', 'usuarios', 9, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 01:55:05'),
(302, 9, 'LOGOUT', 'usuarios', 9, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 01:55:20'),
(303, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 01:55:27'),
(304, 1, 'UPDATE', 'usuarios', 3, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 01:55:49'),
(305, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 01:55:55'),
(306, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 01:56:24'),
(307, 2, 'UPDATE', 'usuarios', 9, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 01:56:51'),
(308, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 02:14:56'),
(309, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 02:37:19'),
(310, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 02:38:41'),
(311, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 02:41:44'),
(312, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 02:43:55'),
(313, 1, 'UPDATE', 'usuarios', 9, 'Usuario: super3 | Estado: Activo → Inactivo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 02:46:06'),
(314, 1, 'UPDATE', 'usuarios', 9, 'Usuario: super3 | Estado: Inactivo → Activo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 02:46:07'),
(315, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 02:46:44'),
(316, 1, 'UPDATE', 'usuarios', 9, 'Usuario: super3 | Estado: Activo → Inactivo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 02:46:54'),
(317, 1, 'UPDATE', 'usuarios', 9, 'Usuario: super3 | Estado: Inactivo → Activo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 02:46:55'),
(318, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 03:18:33'),
(319, 1, 'RESTORE', 'usuarios', 3, 'Usuario: bodega | Eliminado → Inactivo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 03:21:00'),
(320, 1, 'RESTORE', 'usuarios', 4, 'Usuario: asistente | Eliminado → Inactivo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 03:23:40'),
(321, 1, 'UPDATE', 'usuarios', 3, 'Usuario: bodega | Estado: Inactivo → Activo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 03:25:59'),
(322, 1, 'UPDATE', 'usuarios', 5, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'users', '2026-05-21 03:27:11'),
(323, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 03:42:39'),
(324, 1, 'RESTORE', 'usuarios', 5, 'Usuario: vendedor1 | Eliminado → Inactivo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 03:42:48'),
(325, 1, 'UPDATE', 'usuarios', 5, 'Usuario: vendedor1 | Estado: Inactivo → Activo | Por: super', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 03:42:50'),
(326, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 03:43:08'),
(327, 3, 'LOGIN', 'usuarios', 3, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 03:43:15'),
(328, 3, 'UPDATE', 'usuarios', 4, 'Usuario: asistente | Estado: Inactivo → Activo | Por: bodega', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 03:43:27'),
(329, 3, 'UPDATE', 'usuarios', 4, 'Usuario: asistente | Estado: Activo → Inactivo | Por: bodega', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 03:43:32'),
(330, 3, 'UPDATE', 'usuarios', 4, 'Usuario: asistente | Estado: Inactivo → Activo | Por: bodega', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 03:43:36'),
(331, 3, 'LOGIN', 'usuarios', 3, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 03:46:27'),
(332, 3, 'LOGOUT', 'usuarios', 3, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 04:07:11'),
(333, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 04:07:17'),
(334, 1, 'CREATE', 'proveedores', 1, 'Proveedor creado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-21 05:57:13'),
(335, 1, 'CREATE', 'proveedores', 2, 'Proveedor creado', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-21 05:58:51'),
(336, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 15:11:24'),
(337, 1, 'LOGIN', 'usuarios', 1, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Safari/605.1.15', 'auth', '2026-05-21 15:14:53'),
(338, 1, 'UPDATE', 'usuarios', 2, 'Actualización de usuario', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'users', '2026-05-21 15:15:14'),
(339, 1, 'LOGOUT', 'usuarios', 1, 'Usuario cerró sesión manualmente', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 15:15:25'),
(340, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 15:15:36'),
(341, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 15:50:19'),
(342, 2, 'ESTADO', 'proveedores', 1, 'Cambio estado a 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-21 15:50:56'),
(343, 2, 'ESTADO', 'proveedores', 1, 'Cambio estado a 1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-21 15:51:00'),
(344, 2, 'ESTADO', 'proveedores', 2, 'Cambio estado a 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-21 15:51:02'),
(345, 2, 'ESTADO', 'proveedores', 2, 'Cambio estado a 1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-21 15:51:03'),
(346, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 16:07:16'),
(347, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 16:18:01'),
(348, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 16:35:33'),
(349, 2, 'LOGIN', 'usuarios', 2, 'Inicio de sesión exitoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'auth', '2026-05-21 16:38:37'),
(350, 2, 'CREAR', 'proveedores', 3, 'Creó proveedor Juan', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-21 16:55:45'),
(351, 2, 'CREAR', 'proveedores', 4, 'Creó proveedor Juanxcarlos', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-21 17:24:28'),
(352, 2, 'CREAR', 'proveedores', 5, 'Creó proveedor Pedro', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'suppliers', '2026-05-21 17:26:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `nit` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Activo, 2=Inactivo',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `apellidos`, `nit`, `email`, `telefono`, `ciudad`, `estado`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Juan', '', NULL, NULL, '7412458', 'medellin', 1, '2026-05-21 00:57:11', '2026-05-21 10:50:59', 1, NULL),
(2, 'Juan55%%%%', '', NULL, NULL, '7412458', 'medellin', 1, '2026-05-21 00:58:51', '2026-05-21 10:51:03', 1, NULL),
(3, 'Juan', 'tyrty', '123456', NULL, NULL, 'Medellin', 1, '2026-05-21 11:55:44', NULL, 2, NULL),
(4, 'Juanxcarlos', 'arensd', '12345623', NULL, NULL, 'Medellín', 1, '2026-05-21 12:24:28', NULL, 2, NULL),
(5, 'Pedro', 'sUAREZ', '1234563453', NULL, NULL, 'Medellín', 1, '2026-05-21 12:26:46', NULL, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

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
(3, 'bodeguero', 'Encargado de inventario'),
(4, 'asistente', 'Apoyo general'),
(5, 'vendedor', 'Encargado de ventas'),
(6, 'secretaria', 'Apoyo administrativo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

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
(1, 'super', 'Antonio', 'Arenas', NULL, '$2y$10$RSzWovudV1TflDF6PEtseuIEKYaM41vy1QoJhNPiR4Mgm.gzHeVsW', 1, 1, '2026-05-13 01:58:39', '2026-05-21 10:14:50'),
(2, 'admin', 'Jose', 'Gerente', '2b8f40c9706b02ac49769770d655fb41.png', '$2y$10$MdmYsBXnKKZFbvtccI.qKeYHdd26cZ2G9bF123WO0DAmU4l0unAye', 2, 1, '2026-05-13 01:58:39', '2026-05-21 11:38:36'),
(3, 'bodega', 'Luis', 'Inventario', '3636d93d7ca203fd08fb0aa7d612746a.png', '$2y$10$dqoBrCstrAiDpDc4CPZl5e8IgXrHe.L3dVFf5qaa4O/lTQI7MfODi', 2, 1, '2026-05-13 01:58:39', NULL),
(4, 'asistente', 'Laura', 'Apoyo', '7b91618a516c7c3e3022fc350bd86918.png', '$2y$10$RSzWovudV1TflDF6PEtseuIEKYaM41vy1QoJhNPiR4Mgm.gzHeVsW', 4, 1, '2026-05-13 01:58:39', NULL),
(5, 'vendedor1', 'Ana', 'Ventas', 'd481660f9d233d0d1bfa72d0606c769d.png', '$2y$10$RSzWovudV1TflDF6PEtseuIEKYaM41vy1QoJhNPiR4Mgm.gzHeVsW', 5, 1, '2026-05-13 01:58:39', NULL),
(6, 'secretaria', 'Marta', 'Oficina', NULL, '$2y$10$RSzWovudV1TflDF6PEtseuIEKYaM41vy1QoJhNPiR4Mgm.gzHeVsW', 6, 0, '2026-05-13 01:58:39', NULL),
(7, 'testuser', 'Pedro', 'Pruebas', NULL, '$2y$10$RSzWovudV1TflDF6PEtseuIEKYaM41vy1QoJhNPiR4Mgm.gzHeVsW', 2, 0, '2026-05-13 01:58:39', NULL),
(8, 'super2', 'miqguel', 'Perez', NULL, '$2y$10$r6y1woEnEoXVy036Hw97e.T/xCpqHckWrtgXX98aZ0FcdJcEyBhQu', 2, 0, '2026-05-13 06:57:47', NULL),
(9, 'super3', 'Juan', 'quinrtero', 'default.png', '$2y$10$LN7GelcOWT2v0jpAuWXCbeXOd62l749EQKOygrjwdmDTYOc1CPeEa', 2, 1, '2026-05-13 07:00:26', NULL),
(10, 'once', 'DFSG', '', NULL, '$2y$10$gE/SnGPNudUz4NjbFS0oYurHiXt7fWtToehsSwFggx3bTsNvdq37y', 6, 2, '2026-05-13 07:15:48', NULL),
(11, 'cuatro', 'Fernando', 'Guzman', NULL, '$2y$10$WJ9QX1R0eUevL9523b3UhOCtkyItF8QgfZm9wvpWueQtE3CKsOuxa', 5, 1, '2026-05-13 07:17:20', NULL),
(12, 'prueb', 'glor', 'ber', NULL, '$2y$10$o7xAIDhooBXTKB6Lyahy/uVwj2jZi3mzPX/UV.qWF7ZnlRAsqf.pW', 5, 1, '2026-05-13 07:23:31', NULL),
(13, 'prueba', 'cvxc', 'quintero', 'default.png', '$2y$10$9QrmdAg/3FoZ5w/5AtVTEeJHWiGGZx7e4/xnvDorxlLA76VFr0AAS', 2, 1, '2026-05-13 07:33:09', NULL),
(14, 'prueba5', 'Juan', 'Guzman', NULL, '$2y$10$GSVqtuwx/TLmyC3CPuIb4ezrv5dybvJ5HZJOlXySeBpMm93ZcvkYG', 4, 0, '2026-05-13 07:34:34', NULL),
(15, 'prueba6', 'Juan', 'Guzman', NULL, '$2y$10$LoJ1ujNqGgz176xYzFncq.2Wt/6LCgRSE87EOjH3AWowcl1gMQON2', 4, 0, '2026-05-13 07:35:11', NULL),
(16, 'prueba7', 'Juan', 'Guzman', NULL, '$2y$10$.4LcfouBN.qjldRFE0g0ruwFezijY4m67F/FUH2Ss7v8em9hgTZ0q', 4, 0, '2026-05-13 07:35:48', NULL),
(18, 'prueba8', 'Juan', 'Guzman', NULL, '$2y$10$LbpYmwz0i7Ckf7VLwP.vxeLBGSaY4AQ2BumHAqJm1cr/mtIRaHFKy', 4, 1, '2026-05-13 07:36:49', NULL),
(19, 'prueba9', 'Juan', 'Guzman', NULL, '$2y$10$0yPa7bbnYsSLnCwdFp8XA.bzLImubZpHoPGENxGX65RBRAW3qduEW', 4, 1, '2026-05-13 07:37:09', NULL),
(20, 'prueba0', 'DFSG', 'Perez', NULL, '$2y$10$ywHNVDFGsC.qSsusSIaK8OLworsE0VIX0Xjk4I/E/4/k5dvX8mBTm', 5, 1, '2026-05-13 07:40:45', NULL),
(22, 'prueba11', 'DFSG', 'Perez', NULL, '$2y$10$7ttnUj0rWFinz2M69rx5Jegz7zcV6r9xyAaPP/Dp1hG4S27k5KNe6', 5, 1, '2026-05-13 07:42:25', NULL),
(23, 'busdf', 'asdfasdf', '', 'default.png', '$2y$10$YkdzbUSEcfjFutMBMKpFmusXadcAg/p6QmzYhuTmvWj9zsxw7xnYS', 4, 1, '2026-05-19 04:17:09', NULL),
(24, 'qaws', 'Juan', 'asd', 'default.png', '$2y$10$.cTUmwqb70Ec.rQ0pqpk/emS.i477UAw5dHvMVnaY9lbsZZfjnYwq', 5, 1, '2026-05-19 04:31:07', NULL),
(25, 'qwer', 'Juan', 'Guzman', 'default.png', '$2y$10$5JkH4BqdPjkbAsM0FTdQoeSY1Zdvav1JKiqB8UjRWgpRe7S/7ggY6', 4, 1, '2026-05-19 04:32:54', NULL),
(26, 'qasw', 'sd', 'asdas', 'default.png', '$2y$10$WhUSme2LsLrJ9FVmcVw6oOc18NmMYGTOB9aB1WWRNK1yToTgeEvY.', 4, 1, '2026-05-19 04:36:39', NULL),
(27, 'qazxs', 'Juan', '', 'default.png', '$2y$10$Lsk4xzWFAJuUeoqC4Xl3U.sDCsOD.G9H5fQcXjCppeQ9UEbgCAzBi', 4, 1, '2026-05-19 04:44:02', NULL),
(28, 'qazxc', 'qwqw', 'Guzman', 'default.png', '$2y$10$v6rKIjRcufC4xF4JsIVlkO2vkydVuo/7HQFICEZHz5P5eyL/N8KAi', 3, 1, '2026-05-19 04:44:22', NULL),
(29, 'qwert', 'dfsdgf', 'sdfgsdfg', 'default.png', '$2y$10$ANt5oZMgyRxgF3hrA1tKHePw1m7jn14BxJS2/PtWfqM8xy5rEP42W', 4, 1, '2026-05-19 04:44:56', NULL),
(30, 'qwsde4', 'Juan', 'Guzman', 'bff24b9076efd42f2b17ddb52ef8a3dd.png', '$2y$10$3J5mKSJ7pN.vqTQof8mOsObK206Yciwt.PERj2YChdIJ9WqgKWeRC', 5, 1, '2026-05-19 04:46:41', NULL),
(31, 'wewqe', 'wqerw', 'qwewqr', 'd50256f24fa54d0ff38d36450435ac12.png', '$2y$10$7Zvm/8D8bAaamB7dzHUKKexSyD88fdYKJdZhL9FKjSQjEgqB2fxOe', 4, 1, '2026-05-19 04:49:52', NULL),
(32, 'frgt', 'qweqwr', 'wdewr', 'f9be669723862e702214f3fb7f0980a9.png', '$2y$10$HHd/Fcamz07I1RtQM0wOze/1GC3kI8k9aURz3cSljbaEMTbvplNXm', 4, 1, '2026-05-19 05:00:07', NULL),
(33, 'qwasddf', 'safdsdf', 'asdfsdf', 'f71fdab8526dcb34b3b1e4e706411980.png', '$2y$10$vI7DdowWk/FkRnyFx1KPfu4ALDfcudbNAeC/F80ULElIoQTx.c8.q', 5, 1, '2026-05-19 05:06:35', NULL),
(34, 'qwewqe', 'erewr', '', '3e7f3f7e68a3be4977ec833f0839f350.png', '$2y$10$MmllyCN5jjB84wdQBVGoluNKEh0YjJDEp1tYb2XM/WP8KUty69FDm', 4, 1, '2026-05-19 05:07:23', NULL),
(35, 'qasd', 'asdsf', 'sdfdsf', 'e9b0a21cb0bd719a8d31a9af1efaa909.png', '$2y$10$b6XfP5PtgtmlSo/J2vu6qOZhhRUFi7NVRiOfBGen3fslNdCZ/roRm', 4, 1, '2026-05-19 05:20:31', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditoria`
--
ALTER TABLE `auditoria`
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
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=353;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `fk_proveedor_created_by` FOREIGN KEY (`created_by`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `fk_proveedor_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);
--
-- Base de datos: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Volcado de datos para la tabla `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2026-05-13 01:46:03', '{\"Console\\/Mode\":\"collapse\",\"lang\":\"es\"}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indices de la tabla `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indices de la tabla `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indices de la tabla `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indices de la tabla `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indices de la tabla `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indices de la tabla `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indices de la tabla `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indices de la tabla `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indices de la tabla `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indices de la tabla `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indices de la tabla `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indices de la tabla `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indices de la tabla `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Base de datos: `restaurante_db`
--
CREATE DATABASE IF NOT EXISTS `restaurante_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `restaurante_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platos`
--

CREATE TABLE `platos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `orden` int(11) DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `platos`
--

INSERT INTO `platos` (`id`, `nombre`, `descripcion`, `valor`, `imagen`, `activo`, `orden`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, 'plato 1', 'delicioso plato', 50000.00, 'assets/imagenes/platos/b19ad843e7dc9511009b3ac7c905f421.png', 1, 3, '2026-05-15 19:32:31', '2026-05-16 08:24:36'),
(2, 'plato 1', 'delicioso plato', 100.00, 'assets/imagenes/platos/47a681da62ee90da7b46391f82b32dae.png', 1, 0, '2026-05-16 02:38:52', '2026-05-16 08:24:47'),
(3, 'plato 1', 'delicioso plato', 50000.00, 'assets/imagenes/platos/09bf7cf336424032ccaf080ef0565008.png', 0, 0, '2026-05-16 02:39:34', '2026-05-16 08:43:45'),
(4, 'plato 1', 'delicioso plato', 50000.00, 'assets/imagenes/platos/09bf7cf336424032ccaf080ef0565008.png', 0, 0, '2026-05-16 02:39:39', '2026-05-16 08:43:41'),
(5, 'plato 1', 'delicioso plato', 50000.00, 'assets/imagenes/platos/09bf7cf336424032ccaf080ef0565008.png', 0, 0, '2026-05-16 02:39:52', '2026-05-16 08:43:33'),
(6, 'plato 1', 'delicioso plato', 50000.00, 'assets/imagenes/platos/a0e3ce3049355e61e3a1963e2ddb9212.png', 0, 1, '2026-05-16 02:51:00', '2026-05-16 08:56:14'),
(7, 'uno', 'gfh', 1.00, 'assets/imagenes/platos/c1a1961617978797161e6565ecc87eaf.png', 1, 0, '2026-05-16 02:52:58', '2026-05-16 02:52:58'),
(8, 'gf', 'fdgfh', 4.00, 'assets/imagenes/platos/219482c102ac8ae73879bc20feab5a5c.png', 1, 0, '2026-05-16 03:27:25', '2026-05-16 03:27:25'),
(9, 'nuevo', 'asfdf', 4.00, 'assets/imagenes/platos/61e333fbf52c2b7a62640591267a0ed2.png', 1, 0, '2026-05-16 06:21:52', '2026-05-16 06:21:52'),
(10, 'dfsfds', 'sdfgdsfg', 36887.00, 'assets/imagenes/platos/2456cd50c929af0fd94b7f41d1280420.png', 1, 0, '2026-05-16 06:22:14', '2026-05-16 06:22:14'),
(11, 'ujyjgh', 'ghkjkffghk', 8987907.00, 'assets/imagenes/platos/bd65e2f3e0ac81bcaed93c21e9cf0cec.png', 1, 0, '2026-05-16 06:22:26', '2026-05-16 06:22:26');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `platos`
--
ALTER TABLE `platos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `platos`
--
ALTER TABLE `platos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Base de datos: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
