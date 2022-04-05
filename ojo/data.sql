-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-10-2021 a las 23:56:06
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `data`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `casos`
--

CREATE TABLE `casos` (
  `id` int(20) NOT NULL,
  `isFlagrancia` tinyint(1) NOT NULL DEFAULT 0,
  `isBanda` tinyint(1) NOT NULL DEFAULT 0,
  `banda` varchar(100) DEFAULT NULL,
  `entidad_id` int(10) NOT NULL,
  `entidad` varchar(100) DEFAULT NULL,
  `documento_id` int(10) NOT NULL,
  `documento` varchar(50) NOT NULL,
  `fecha_recepcion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_expiracion` timestamp NOT NULL DEFAULT current_timestamp(),
  `plazo` int(3) NOT NULL,
  `fiscalia` varchar(100) NOT NULL,
  `carpeta_fiscal` varchar(100) NOT NULL,
  `delito_id` int(11) NOT NULL,
  `modalidad_id` int(11) DEFAULT NULL,
  `banco_id` int(10) DEFAULT NULL,
  `cantidad` varchar(20) DEFAULT NULL,
  `moneda_id` int(10) DEFAULT NULL,
  `investigador_id` int(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `casos`
--

INSERT INTO `casos` (`id`, `isFlagrancia`, `isBanda`, `banda`, `entidad_id`, `entidad`, `documento_id`, `documento`, `fecha_recepcion`, `fecha_expiracion`, `plazo`, `fiscalia`, `carpeta_fiscal`, `delito_id`, `modalidad_id`, `banco_id`, `cantidad`, `moneda_id`, `investigador_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(21, 0, 0, NULL, 3, 'Qui a mollitia est e', 6, 'Assumenda quam sed u', '2021-06-25 05:00:00', '2021-08-09 05:00:00', 45, '', 'Incidunt incidunt ', 1, 25, 6, '88', 1, 1, '2021-10-15 15:14:08', '2021-09-29 14:29:54', NULL),
(22, 0, 0, NULL, 1, 'Quisquam quos impedi', 3, 'Deleniti ea exercita', '1975-11-24 05:00:00', '1975-12-09 05:00:00', 15, '', 'Aut duis fugiat cons', 1, 25, 2, '38', 2, 1, '2021-10-15 15:14:11', '2021-09-29 14:39:53', '2021-09-29 14:39:53'),
(23, 1, 1, 'ositos', 3, 'Elit voluptas minim', 4, 'Molestiae recusandae', '1989-06-23 05:00:00', '1989-07-08 05:00:00', 15, 'HUREUR', 'Dolorem rerum minima', 1, 25, 3, '42', 3, 1, '2021-10-15 15:14:13', '2021-09-29 15:40:05', NULL),
(30, 1, 1, 'dffdgd', 1, 'Delectus eum volupt', 3, 'Mollit ut fuga Laud', '1977-01-07 05:00:00', '1977-03-05 05:00:00', 57, 'Voluptatibus reprehe', 'Doloribus perferendi', 1, 25, 3, '7', 1, 1, '2021-10-15 15:49:34', '2021-10-15 15:35:48', NULL),
(31, 1, 1, 'ggddg', 2, 'Vero accusantium fac', 1, 'Consequatur optio a', '1970-10-15 05:00:00', '1971-01-06 05:00:00', 83, 'Voluptatem omnis ut ', 'Quas ad ut enim dolo', 1, 24, 3, '10', 1, 1, '2021-10-15 15:49:39', '2021-10-15 15:37:35', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caso_has_persons`
--

CREATE TABLE `caso_has_persons` (
  `id` int(11) NOT NULL,
  `caso_id` int(10) NOT NULL,
  `person_id` int(11) NOT NULL,
  `situacion_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `caso_has_persons`
--

INSERT INTO `caso_has_persons` (`id`, `caso_id`, `person_id`, `situacion_id`) VALUES
(28, 21, 34, 1),
(30, 21, 36, 1),
(31, 27, 37, 1),
(32, 23, 38, 1),
(33, 21, 39, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `data_correos`
--

CREATE TABLE `data_correos` (
  `id` int(11) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `person_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `data_correos`
--

INSERT INTO `data_correos` (`id`, `correo`, `person_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'rutwa@gmail.com', 38, '2021-10-10 07:30:23', '2021-10-10 07:30:23', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `data_cuenta_bancarias`
--

CREATE TABLE `data_cuenta_bancarias` (
  `id` int(11) NOT NULL,
  `person_id` int(10) NOT NULL,
  `banco_id` int(10) NOT NULL,
  `cuenta_bancaria` text NOT NULL,
  `moneda_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `data_cuenta_bancarias`
--

INSERT INTO `data_cuenta_bancarias` (`id`, `person_id`, `banco_id`, `cuenta_bancaria`, `moneda_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 38, 4, '4545646', 1, '2021-09-29 23:56:34', '2021-09-29 23:56:34', NULL),
(2, 38, 2, '34563465346', 2, '2021-09-30 00:04:18', '2021-09-30 00:04:18', NULL),
(3, 38, 2, '34563465346', 2, '2021-10-09 23:51:27', '2021-10-09 23:51:27', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `data_imagenes`
--

CREATE TABLE `data_imagenes` (
  `id` int(11) NOT NULL,
  `image_url` varchar(200) NOT NULL,
  `person_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `data_imagenes`
--

INSERT INTO `data_imagenes` (`id`, `image_url`, `person_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(11, 'images/1hQLXkdzKCPSjoWUlrUsjqCyhPC0hRfE9op2OcjH.jpg', 38, '2021-10-10 23:00:42', '2021-10-10 23:00:42', '2021-10-10 23:00:42'),
(12, 'images/xREx3n3mBayDPZ5boWYxjL8eSkeXj3LaBEsu8H1f.jpg', 38, '2021-10-10 22:55:57', '2021-10-10 22:55:57', '2021-10-10 22:55:57'),
(13, 'images/8IYaGvNebqW47WTueVMLJtEM4v2REKfk7DXtWQUP.jpg', 38, '2021-10-11 16:26:33', '2021-10-11 16:26:33', '2021-10-11 16:26:33'),
(14, 'images/J3PUldIfboJqxnocXqYY6PDXilLAvQqThUUxQB2H.jpg', 38, '2021-10-11 16:26:32', '2021-10-11 16:26:32', '2021-10-11 16:26:32'),
(15, 'images/vFgyoKSX1rpXsJ9Pu5rD5GJHU69FPiA1oLvLu2Dm.jpg', 38, '2021-10-11 16:26:31', '2021-10-11 16:26:31', '2021-10-11 16:26:31'),
(16, 'images/MbwoRfjgFNTqxm3NFWiUCxPHznaDyicZ99003n2t.jpg', 38, '2021-10-11 16:26:30', '2021-10-11 16:26:30', '2021-10-11 16:26:30'),
(17, 'images/dTwLubqt9KHWWx0WIheiD3UiFd5KPKt9JXFNEGef.jpg', 38, '2021-10-11 16:26:29', '2021-10-11 16:26:29', '2021-10-11 16:26:29'),
(18, 'images/9fiPZzTBofFrdNGMwXXgOPi4KTklDcxrgcLjrqJn.jpg', 38, '2021-10-10 22:55:48', '2021-10-10 22:55:48', '2021-10-10 22:55:48'),
(19, 'images/iYyjoNMyaxIVKvc2tH0FXbth6eNgnVKNJUt8WbSq.jpg', 38, '2021-10-11 16:27:50', '2021-10-11 16:27:50', NULL),
(20, 'images/GbfFIrWQg0t5zXp4BFcTdtSKPZcpSrfKSjp68tq7.jpg', 39, '2021-10-15 18:14:18', '2021-10-15 18:14:18', NULL),
(21, 'images/gvvnJf8z6PePtTO7hiQJ0RhcImwgepWEygJsas9q.jpg', 39, '2021-10-15 18:14:18', '2021-10-15 18:14:18', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `data_paginas_web`
--

CREATE TABLE `data_paginas_web` (
  `id` int(11) NOT NULL,
  `pagina_web` varchar(200) NOT NULL,
  `person_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `data_paginas_web`
--

INSERT INTO `data_paginas_web` (`id`, `pagina_web`, `person_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'http://rr.com', 38, '2021-10-10 07:31:06', '2021-10-10 07:31:06', NULL),
(2, 'http://rr.com', 38, '2021-10-11 17:34:39', '2021-10-11 17:34:39', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `data_redes_sociales`
--

CREATE TABLE `data_redes_sociales` (
  `id` int(11) NOT NULL,
  `red_social` varchar(200) NOT NULL,
  `person_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `data_redes_sociales`
--

INSERT INTO `data_redes_sociales` (`id`, `red_social`, `person_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'https://stackoverflow.com/questions/60605795', 38, '2021-10-11 17:35:00', '2021-10-11 17:35:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `data_tarjetas`
--

CREATE TABLE `data_tarjetas` (
  `id` int(11) NOT NULL,
  `banco_id` int(11) NOT NULL,
  `numero_tarjeta` varchar(50) NOT NULL,
  `person_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `data_tarjetas`
--

INSERT INTO `data_tarjetas` (`id`, `banco_id`, `numero_tarjeta`, `person_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 4, '15151515', 38, '2021-10-10 07:25:40', '2021-10-10 07:25:40', NULL),
(2, 5, '3535', 38, '2021-10-10 07:30:41', '2021-10-10 07:30:41', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `data_telefonos`
--

CREATE TABLE `data_telefonos` (
  `id` int(10) NOT NULL,
  `person_id` int(10) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `operador_id` int(10) NOT NULL,
  `sistema_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `data_telefonos`
--

INSERT INTO `data_telefonos` (`id`, `person_id`, `telefono`, `operador_id`, `sistema_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 38, '989103280', 1, 1, '2021-09-29 22:30:51', '2021-09-29 22:30:51', NULL),
(2, 38, '989103280', 1, 1, '2021-09-29 22:31:13', '2021-09-29 22:31:13', NULL),
(3, 38, '989103280', 1, 1, '2021-09-29 22:32:06', '2021-09-29 22:32:06', NULL),
(4, 38, '989103280', 1, 1, '2021-09-29 22:34:46', '2021-09-29 22:34:46', NULL),
(5, 38, '93025875', 2, 2, '2021-09-29 22:37:23', '2021-09-29 22:37:23', NULL),
(6, 38, '89898989', 3, 4, '2021-09-29 22:39:08', '2021-09-29 22:39:08', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id` int(10) NOT NULL,
  `empresa` varchar(100) NOT NULL,
  `ruc` int(22) NOT NULL,
  `representante_legal_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `empresa`, `ruc`, `representante_legal_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 'Aut rerum amet in s', 25, 27, '2021-09-27 14:23:15', '2021-09-27 14:23:15', NULL),
(6, 'Itaque commodi sed m', 47, 29, '2021-09-27 14:23:15', '2021-09-27 14:23:15', NULL),
(7, 'Ea in proident cons', 60, 36, '2021-09-27 14:30:14', '2021-09-27 14:30:14', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fiscalias`
--

CREATE TABLE `fiscalias` (
  `id` int(11) NOT NULL,
  `fiscalia` varchar(100) NOT NULL,
  `caso_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `fiscalias`
--

INSERT INTO `fiscalias` (`id`, `fiscalia`, `caso_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'Voluptatibus reprehe', 30, '2021-10-15 15:35:48', '2021-10-15 15:35:48', NULL),
(5, 'Voluptatem omnis ut ', 31, '2021-10-15 15:37:35', '2021-10-15 15:37:35', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_bancos`
--

CREATE TABLE `info_bancos` (
  `id` int(10) NOT NULL,
  `banco` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `info_bancos`
--

INSERT INTO `info_bancos` (`id`, `banco`) VALUES
(1, 'Banco de Comercio'),
(2, 'Banco de Crédito del Perú'),
(3, 'Banco Interamericano de Finanzas (BanBif)'),
(4, 'Banco Financiero'),
(5, 'Banco BBVA Continental'),
(6, 'Banco Citibank Perú'),
(7, 'Banco Interbank'),
(8, 'Banco MiBanco'),
(9, 'Banco Scotiabank Perú'),
(10, 'Banco GNB Perú'),
(11, 'Banco Falabella'),
(12, 'Banco Ripley'),
(13, 'Banco Santander Perú'),
(14, 'Banco Azteca'),
(15, 'Banco Cencosud'),
(16, 'Banco ICBC PERU BANK'),
(17, 'Estatal Agrobanco'),
(18, 'Estatal Banco de la Nación'),
(19, 'Estatal COFIDE'),
(20, 'Estatal Fondo MiVivienda'),
(21, 'Financiera Amérika'),
(22, 'Financiera Crediscotia'),
(23, 'Financiera Confianza'),
(24, 'Financiera Compartamos'),
(25, 'Financiera Credinka'),
(26, 'Financiera Efectiva'),
(27, 'Financiera Proempresa'),
(28, 'Financiera Mitsui'),
(29, 'Financiera Oh!'),
(30, 'Financiera Qapaq'),
(31, 'Financiera TFC'),
(32, 'Caja Municipal Arequipa'),
(33, 'Caja Municipal Cusco'),
(34, 'Caja Municipal Del Santa'),
(35, 'Caja Municipal Trujillo'),
(36, 'Caja Municipal Huancayo'),
(37, 'Caja Municipal Ica'),
(38, 'Caja Municipal Maynas'),
(39, 'Caja Municipal Paita'),
(40, 'Caja Municipal Piura'),
(41, 'Caja Municipal Sullana'),
(42, 'Caja Municipal Tacna'),
(43, 'Caja Metropolitana de Lima'),
(44, 'Caja Rural Incasur'),
(45, 'Caja Rural Los Andes'),
(46, 'Caja Rural Prymera'),
(47, 'Caja Rural Sipán'),
(48, 'Caja Rural Del Centro'),
(49, 'Caja Rural Raíz'),
(50, 'Edpymes Acceso Crediticio'),
(51, 'Edpymes Alternativa'),
(52, 'Edpymes BBVA Consumer Finance'),
(53, 'Edpymes Credivisión'),
(54, 'Edpymes Inversiones La Cruz'),
(55, 'Edpymes Mi Casita'),
(56, 'Edpymes Marcimex'),
(57, 'Edpymes GMG Servicios Perú'),
(58, 'Edpymes Santander Consumer Perú'),
(59, 'Inversión J.P. Morgan Banco de Inversión');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_delitos`
--

CREATE TABLE `info_delitos` (
  `id` int(11) NOT NULL,
  `delito` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `info_delitos`
--

INSERT INTO `info_delitos` (`id`, `delito`) VALUES
(1, 'Delito informatico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_distritos`
--

CREATE TABLE `info_distritos` (
  `id` char(6) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `region_id` char(6) DEFAULT NULL,
  `province_id` char(6) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `info_distritos`
--

INSERT INTO `info_distritos` (`id`, `name`, `region_id`, `province_id`, `created_at`, `updated_at`) VALUES
('010101', 'Chachapoyas', '010100', '010000', NULL, NULL),
('010102', 'Asunción', '010100', '010000', NULL, NULL),
('010103', 'Balsas', '010100', '010000', NULL, NULL),
('010104', 'Cheto', '010100', '010000', NULL, NULL),
('010105', 'Chiliquin', '010100', '010000', NULL, NULL),
('010106', 'Chuquibamba', '010100', '010000', NULL, NULL),
('010107', 'Granada', '010100', '010000', NULL, NULL),
('010108', 'Huancas', '010100', '010000', NULL, NULL),
('010109', 'La Jalca', '010100', '010000', NULL, NULL),
('010110', 'Leimebamba', '010100', '010000', NULL, NULL),
('010111', 'Levanto', '010100', '010000', NULL, NULL),
('010112', 'Magdalena', '010100', '010000', NULL, NULL),
('010113', 'Mariscal Castilla', '010100', '010000', NULL, NULL),
('010114', 'Molinopampa', '010100', '010000', NULL, NULL),
('010115', 'Montevideo', '010100', '010000', NULL, NULL),
('010116', 'Olleros', '010100', '010000', NULL, NULL),
('010117', 'Quinjalca', '010100', '010000', NULL, NULL),
('010118', 'San Francisco de Daguas', '010100', '010000', NULL, NULL),
('010119', 'San Isidro de Maino', '010100', '010000', NULL, NULL),
('010120', 'Soloco', '010100', '010000', NULL, NULL),
('010121', 'Sonche', '010100', '010000', NULL, NULL),
('010201', 'Bagua', '010200', '010000', NULL, NULL),
('010202', 'Aramango', '010200', '010000', NULL, NULL),
('010203', 'Copallin', '010200', '010000', NULL, NULL),
('010204', 'El Parco', '010200', '010000', NULL, NULL),
('010205', 'Imaza', '010200', '010000', NULL, NULL),
('010206', 'La Peca', '010200', '010000', NULL, NULL),
('010301', 'Jumbilla', '010300', '010000', NULL, NULL),
('010302', 'Chisquilla', '010300', '010000', NULL, NULL),
('010303', 'Churuja', '010300', '010000', NULL, NULL),
('010304', 'Corosha', '010300', '010000', NULL, NULL),
('010305', 'Cuispes', '010300', '010000', NULL, NULL),
('010306', 'Florida', '010300', '010000', NULL, NULL),
('010307', 'Jazan', '010300', '010000', NULL, NULL),
('010308', 'Recta', '010300', '010000', NULL, NULL),
('010309', 'San Carlos', '010300', '010000', NULL, NULL),
('010310', 'Shipasbamba', '010300', '010000', NULL, NULL),
('010311', 'Valera', '010300', '010000', NULL, NULL),
('010312', 'Yambrasbamba', '010300', '010000', NULL, NULL),
('010401', 'Nieva', '010400', '010000', NULL, NULL),
('010402', 'El Cenepa', '010400', '010000', NULL, NULL),
('010403', 'Río Santiago', '010400', '010000', NULL, NULL),
('010501', 'Lamud', '010500', '010000', NULL, NULL),
('010502', 'Camporredondo', '010500', '010000', NULL, NULL),
('010503', 'Cocabamba', '010500', '010000', NULL, NULL),
('010504', 'Colcamar', '010500', '010000', NULL, NULL),
('010505', 'Conila', '010500', '010000', NULL, NULL),
('010506', 'Inguilpata', '010500', '010000', NULL, NULL),
('010507', 'Longuita', '010500', '010000', NULL, NULL),
('010508', 'Lonya Chico', '010500', '010000', NULL, NULL),
('010509', 'Luya', '010500', '010000', NULL, NULL),
('010510', 'Luya Viejo', '010500', '010000', NULL, NULL),
('010511', 'María', '010500', '010000', NULL, NULL),
('010512', 'Ocalli', '010500', '010000', NULL, NULL),
('010513', 'Ocumal', '010500', '010000', NULL, NULL),
('010514', 'Pisuquia', '010500', '010000', NULL, NULL),
('010515', 'Providencia', '010500', '010000', NULL, NULL),
('010516', 'San Cristóbal', '010500', '010000', NULL, NULL),
('010517', 'San Francisco de Yeso', '010500', '010000', NULL, NULL),
('010518', 'San Jerónimo', '010500', '010000', NULL, NULL),
('010519', 'San Juan de Lopecancha', '010500', '010000', NULL, NULL),
('010520', 'Santa Catalina', '010500', '010000', NULL, NULL),
('010521', 'Santo Tomas', '010500', '010000', NULL, NULL),
('010522', 'Tingo', '010500', '010000', NULL, NULL),
('010523', 'Trita', '010500', '010000', NULL, NULL),
('010601', 'San Nicolás', '010600', '010000', NULL, NULL),
('010602', 'Chirimoto', '010600', '010000', NULL, NULL),
('010603', 'Cochamal', '010600', '010000', NULL, NULL),
('010604', 'Huambo', '010600', '010000', NULL, NULL),
('010605', 'Limabamba', '010600', '010000', NULL, NULL),
('010606', 'Longar', '010600', '010000', NULL, NULL),
('010607', 'Mariscal Benavides', '010600', '010000', NULL, NULL),
('010608', 'Milpuc', '010600', '010000', NULL, NULL),
('010609', 'Omia', '010600', '010000', NULL, NULL),
('010610', 'Santa Rosa', '010600', '010000', NULL, NULL),
('010611', 'Totora', '010600', '010000', NULL, NULL),
('010612', 'Vista Alegre', '010600', '010000', NULL, NULL),
('010701', 'Bagua Grande', '010700', '010000', NULL, NULL),
('010702', 'Cajaruro', '010700', '010000', NULL, NULL),
('010703', 'Cumba', '010700', '010000', NULL, NULL),
('010704', 'El Milagro', '010700', '010000', NULL, NULL),
('010705', 'Jamalca', '010700', '010000', NULL, NULL),
('010706', 'Lonya Grande', '010700', '010000', NULL, NULL),
('010707', 'Yamon', '010700', '010000', NULL, NULL),
('020101', 'Huaraz', '020100', '020000', NULL, NULL),
('020102', 'Cochabamba', '020100', '020000', NULL, NULL),
('020103', 'Colcabamba', '020100', '020000', NULL, NULL),
('020104', 'Huanchay', '020100', '020000', NULL, NULL),
('020105', 'Independencia', '020100', '020000', NULL, NULL),
('020106', 'Jangas', '020100', '020000', NULL, NULL),
('020107', 'La Libertad', '020100', '020000', NULL, NULL),
('020108', 'Olleros', '020100', '020000', NULL, NULL),
('020109', 'Pampas Grande', '020100', '020000', NULL, NULL),
('020110', 'Pariacoto', '020100', '020000', NULL, NULL),
('020111', 'Pira', '020100', '020000', NULL, NULL),
('020112', 'Tarica', '020100', '020000', NULL, NULL),
('020201', 'Aija', '020200', '020000', NULL, NULL),
('020202', 'Coris', '020200', '020000', NULL, NULL),
('020203', 'Huacllan', '020200', '020000', NULL, NULL),
('020204', 'La Merced', '020200', '020000', NULL, NULL),
('020205', 'Succha', '020200', '020000', NULL, NULL),
('020301', 'Llamellin', '020300', '020000', NULL, NULL),
('020302', 'Aczo', '020300', '020000', NULL, NULL),
('020303', 'Chaccho', '020300', '020000', NULL, NULL),
('020304', 'Chingas', '020300', '020000', NULL, NULL),
('020305', 'Mirgas', '020300', '020000', NULL, NULL),
('020306', 'San Juan de Rontoy', '020300', '020000', NULL, NULL),
('020401', 'Chacas', '020400', '020000', NULL, NULL),
('020402', 'Acochaca', '020400', '020000', NULL, NULL),
('020501', 'Chiquian', '020500', '020000', NULL, NULL),
('020502', 'Abelardo Pardo Lezameta', '020500', '020000', NULL, NULL),
('020503', 'Antonio Raymondi', '020500', '020000', NULL, NULL),
('020504', 'Aquia', '020500', '020000', NULL, NULL),
('020505', 'Cajacay', '020500', '020000', NULL, NULL),
('020506', 'Canis', '020500', '020000', NULL, NULL),
('020507', 'Colquioc', '020500', '020000', NULL, NULL),
('020508', 'Huallanca', '020500', '020000', NULL, NULL),
('020509', 'Huasta', '020500', '020000', NULL, NULL),
('020510', 'Huayllacayan', '020500', '020000', NULL, NULL),
('020511', 'La Primavera', '020500', '020000', NULL, NULL),
('020512', 'Mangas', '020500', '020000', NULL, NULL),
('020513', 'Pacllon', '020500', '020000', NULL, NULL),
('020514', 'San Miguel de Corpanqui', '020500', '020000', NULL, NULL),
('020515', 'Ticllos', '020500', '020000', NULL, NULL),
('020601', 'Carhuaz', '020600', '020000', NULL, NULL),
('020602', 'Acopampa', '020600', '020000', NULL, NULL),
('020603', 'Amashca', '020600', '020000', NULL, NULL),
('020604', 'Anta', '020600', '020000', NULL, NULL),
('020605', 'Ataquero', '020600', '020000', NULL, NULL),
('020606', 'Marcara', '020600', '020000', NULL, NULL),
('020607', 'Pariahuanca', '020600', '020000', NULL, NULL),
('020608', 'San Miguel de Aco', '020600', '020000', NULL, NULL),
('020609', 'Shilla', '020600', '020000', NULL, NULL),
('020610', 'Tinco', '020600', '020000', NULL, NULL),
('020611', 'Yungar', '020600', '020000', NULL, NULL),
('020701', 'San Luis', '020700', '020000', NULL, NULL),
('020702', 'San Nicolás', '020700', '020000', NULL, NULL),
('020703', 'Yauya', '020700', '020000', NULL, NULL),
('020801', 'Casma', '020800', '020000', NULL, NULL),
('020802', 'Buena Vista Alta', '020800', '020000', NULL, NULL),
('020803', 'Comandante Noel', '020800', '020000', NULL, NULL),
('020804', 'Yautan', '020800', '020000', NULL, NULL),
('020901', 'Corongo', '020900', '020000', NULL, NULL),
('020902', 'Aco', '020900', '020000', NULL, NULL),
('020903', 'Bambas', '020900', '020000', NULL, NULL),
('020904', 'Cusca', '020900', '020000', NULL, NULL),
('020905', 'La Pampa', '020900', '020000', NULL, NULL),
('020906', 'Yanac', '020900', '020000', NULL, NULL),
('020907', 'Yupan', '020900', '020000', NULL, NULL),
('021001', 'Huari', '021000', '020000', NULL, NULL),
('021002', 'Anra', '021000', '020000', NULL, NULL),
('021003', 'Cajay', '021000', '020000', NULL, NULL),
('021004', 'Chavin de Huantar', '021000', '020000', NULL, NULL),
('021005', 'Huacachi', '021000', '020000', NULL, NULL),
('021006', 'Huacchis', '021000', '020000', NULL, NULL),
('021007', 'Huachis', '021000', '020000', NULL, NULL),
('021008', 'Huantar', '021000', '020000', NULL, NULL),
('021009', 'Masin', '021000', '020000', NULL, NULL),
('021010', 'Paucas', '021000', '020000', NULL, NULL),
('021011', 'Ponto', '021000', '020000', NULL, NULL),
('021012', 'Rahuapampa', '021000', '020000', NULL, NULL),
('021013', 'Rapayan', '021000', '020000', NULL, NULL),
('021014', 'San Marcos', '021000', '020000', NULL, NULL),
('021015', 'San Pedro de Chana', '021000', '020000', NULL, NULL),
('021016', 'Uco', '021000', '020000', NULL, NULL),
('021101', 'Huarmey', '021100', '020000', NULL, NULL),
('021102', 'Cochapeti', '021100', '020000', NULL, NULL),
('021103', 'Culebras', '021100', '020000', NULL, NULL),
('021104', 'Huayan', '021100', '020000', NULL, NULL),
('021105', 'Malvas', '021100', '020000', NULL, NULL),
('021201', 'Caraz', '021200', '020000', NULL, NULL),
('021202', 'Huallanca', '021200', '020000', NULL, NULL),
('021203', 'Huata', '021200', '020000', NULL, NULL),
('021204', 'Huaylas', '021200', '020000', NULL, NULL),
('021205', 'Mato', '021200', '020000', NULL, NULL),
('021206', 'Pamparomas', '021200', '020000', NULL, NULL),
('021207', 'Pueblo Libre', '021200', '020000', NULL, NULL),
('021208', 'Santa Cruz', '021200', '020000', NULL, NULL),
('021209', 'Santo Toribio', '021200', '020000', NULL, NULL),
('021210', 'Yuracmarca', '021200', '020000', NULL, NULL),
('021301', 'Piscobamba', '021300', '020000', NULL, NULL),
('021302', 'Casca', '021300', '020000', NULL, NULL),
('021303', 'Eleazar Guzmán Barron', '021300', '020000', NULL, NULL),
('021304', 'Fidel Olivas Escudero', '021300', '020000', NULL, NULL),
('021305', 'Llama', '021300', '020000', NULL, NULL),
('021306', 'Llumpa', '021300', '020000', NULL, NULL),
('021307', 'Lucma', '021300', '020000', NULL, NULL),
('021308', 'Musga', '021300', '020000', NULL, NULL),
('021401', 'Ocros', '021400', '020000', NULL, NULL),
('021402', 'Acas', '021400', '020000', NULL, NULL),
('021403', 'Cajamarquilla', '021400', '020000', NULL, NULL),
('021404', 'Carhuapampa', '021400', '020000', NULL, NULL),
('021405', 'Cochas', '021400', '020000', NULL, NULL),
('021406', 'Congas', '021400', '020000', NULL, NULL),
('021407', 'Llipa', '021400', '020000', NULL, NULL),
('021408', 'San Cristóbal de Rajan', '021400', '020000', NULL, NULL),
('021409', 'San Pedro', '021400', '020000', NULL, NULL),
('021410', 'Santiago de Chilcas', '021400', '020000', NULL, NULL),
('021501', 'Cabana', '021500', '020000', NULL, NULL),
('021502', 'Bolognesi', '021500', '020000', NULL, NULL),
('021503', 'Conchucos', '021500', '020000', NULL, NULL),
('021504', 'Huacaschuque', '021500', '020000', NULL, NULL),
('021505', 'Huandoval', '021500', '020000', NULL, NULL),
('021506', 'Lacabamba', '021500', '020000', NULL, NULL),
('021507', 'Llapo', '021500', '020000', NULL, NULL),
('021508', 'Pallasca', '021500', '020000', NULL, NULL),
('021509', 'Pampas', '021500', '020000', NULL, NULL),
('021510', 'Santa Rosa', '021500', '020000', NULL, NULL),
('021511', 'Tauca', '021500', '020000', NULL, NULL),
('021601', 'Pomabamba', '021600', '020000', NULL, NULL),
('021602', 'Huayllan', '021600', '020000', NULL, NULL),
('021603', 'Parobamba', '021600', '020000', NULL, NULL),
('021604', 'Quinuabamba', '021600', '020000', NULL, NULL),
('021701', 'Recuay', '021700', '020000', NULL, NULL),
('021702', 'Catac', '021700', '020000', NULL, NULL),
('021703', 'Cotaparaco', '021700', '020000', NULL, NULL),
('021704', 'Huayllapampa', '021700', '020000', NULL, NULL),
('021705', 'Llacllin', '021700', '020000', NULL, NULL),
('021706', 'Marca', '021700', '020000', NULL, NULL),
('021707', 'Pampas Chico', '021700', '020000', NULL, NULL),
('021708', 'Pararin', '021700', '020000', NULL, NULL),
('021709', 'Tapacocha', '021700', '020000', NULL, NULL),
('021710', 'Ticapampa', '021700', '020000', NULL, NULL),
('021801', 'Chimbote', '021800', '020000', NULL, NULL),
('021802', 'Cáceres del Perú', '021800', '020000', NULL, NULL),
('021803', 'Coishco', '021800', '020000', NULL, NULL),
('021804', 'Macate', '021800', '020000', NULL, NULL),
('021805', 'Moro', '021800', '020000', NULL, NULL),
('021806', 'Nepeña', '021800', '020000', NULL, NULL),
('021807', 'Samanco', '021800', '020000', NULL, NULL),
('021808', 'Santa', '021800', '020000', NULL, NULL),
('021809', 'Nuevo Chimbote', '021800', '020000', NULL, NULL),
('021901', 'Sihuas', '021900', '020000', NULL, NULL),
('021902', 'Acobamba', '021900', '020000', NULL, NULL),
('021903', 'Alfonso Ugarte', '021900', '020000', NULL, NULL),
('021904', 'Cashapampa', '021900', '020000', NULL, NULL),
('021905', 'Chingalpo', '021900', '020000', NULL, NULL),
('021906', 'Huayllabamba', '021900', '020000', NULL, NULL),
('021907', 'Quiches', '021900', '020000', NULL, NULL),
('021908', 'Ragash', '021900', '020000', NULL, NULL),
('021909', 'San Juan', '021900', '020000', NULL, NULL),
('021910', 'Sicsibamba', '021900', '020000', NULL, NULL),
('022001', 'Yungay', '022000', '020000', NULL, NULL),
('022002', 'Cascapara', '022000', '020000', NULL, NULL),
('022003', 'Mancos', '022000', '020000', NULL, NULL),
('022004', 'Matacoto', '022000', '020000', NULL, NULL),
('022005', 'Quillo', '022000', '020000', NULL, NULL),
('022006', 'Ranrahirca', '022000', '020000', NULL, NULL),
('022007', 'Shupluy', '022000', '020000', NULL, NULL),
('022008', 'Yanama', '022000', '020000', NULL, NULL),
('030101', 'Abancay', '030100', '030000', NULL, NULL),
('030102', 'Chacoche', '030100', '030000', NULL, NULL),
('030103', 'Circa', '030100', '030000', NULL, NULL),
('030104', 'Curahuasi', '030100', '030000', NULL, NULL),
('030105', 'Huanipaca', '030100', '030000', NULL, NULL),
('030106', 'Lambrama', '030100', '030000', NULL, NULL),
('030107', 'Pichirhua', '030100', '030000', NULL, NULL),
('030108', 'San Pedro de Cachora', '030100', '030000', NULL, NULL),
('030109', 'Tamburco', '030100', '030000', NULL, NULL),
('030201', 'Andahuaylas', '030200', '030000', NULL, NULL),
('030202', 'Andarapa', '030200', '030000', NULL, NULL),
('030203', 'Chiara', '030200', '030000', NULL, NULL),
('030204', 'Huancarama', '030200', '030000', NULL, NULL),
('030205', 'Huancaray', '030200', '030000', NULL, NULL),
('030206', 'Huayana', '030200', '030000', NULL, NULL),
('030207', 'Kishuara', '030200', '030000', NULL, NULL),
('030208', 'Pacobamba', '030200', '030000', NULL, NULL),
('030209', 'Pacucha', '030200', '030000', NULL, NULL),
('030210', 'Pampachiri', '030200', '030000', NULL, NULL),
('030211', 'Pomacocha', '030200', '030000', NULL, NULL),
('030212', 'San Antonio de Cachi', '030200', '030000', NULL, NULL),
('030213', 'San Jerónimo', '030200', '030000', NULL, NULL),
('030214', 'San Miguel de Chaccrampa', '030200', '030000', NULL, NULL),
('030215', 'Santa María de Chicmo', '030200', '030000', NULL, NULL),
('030216', 'Talavera', '030200', '030000', NULL, NULL),
('030217', 'Tumay Huaraca', '030200', '030000', NULL, NULL),
('030218', 'Turpo', '030200', '030000', NULL, NULL),
('030219', 'Kaquiabamba', '030200', '030000', NULL, NULL),
('030220', 'José María Arguedas', '030200', '030000', NULL, NULL),
('030301', 'Antabamba', '030300', '030000', NULL, NULL),
('030302', 'El Oro', '030300', '030000', NULL, NULL),
('030303', 'Huaquirca', '030300', '030000', NULL, NULL),
('030304', 'Juan Espinoza Medrano', '030300', '030000', NULL, NULL),
('030305', 'Oropesa', '030300', '030000', NULL, NULL),
('030306', 'Pachaconas', '030300', '030000', NULL, NULL),
('030307', 'Sabaino', '030300', '030000', NULL, NULL),
('030401', 'Chalhuanca', '030400', '030000', NULL, NULL),
('030402', 'Capaya', '030400', '030000', NULL, NULL),
('030403', 'Caraybamba', '030400', '030000', NULL, NULL),
('030404', 'Chapimarca', '030400', '030000', NULL, NULL),
('030405', 'Colcabamba', '030400', '030000', NULL, NULL),
('030406', 'Cotaruse', '030400', '030000', NULL, NULL),
('030407', 'Ihuayllo', '030400', '030000', NULL, NULL),
('030408', 'Justo Apu Sahuaraura', '030400', '030000', NULL, NULL),
('030409', 'Lucre', '030400', '030000', NULL, NULL),
('030410', 'Pocohuanca', '030400', '030000', NULL, NULL),
('030411', 'San Juan de Chacña', '030400', '030000', NULL, NULL),
('030412', 'Sañayca', '030400', '030000', NULL, NULL),
('030413', 'Soraya', '030400', '030000', NULL, NULL),
('030414', 'Tapairihua', '030400', '030000', NULL, NULL),
('030415', 'Tintay', '030400', '030000', NULL, NULL),
('030416', 'Toraya', '030400', '030000', NULL, NULL),
('030417', 'Yanaca', '030400', '030000', NULL, NULL),
('030501', 'Tambobamba', '030500', '030000', NULL, NULL),
('030502', 'Cotabambas', '030500', '030000', NULL, NULL),
('030503', 'Coyllurqui', '030500', '030000', NULL, NULL),
('030504', 'Haquira', '030500', '030000', NULL, NULL),
('030505', 'Mara', '030500', '030000', NULL, NULL),
('030506', 'Challhuahuacho', '030500', '030000', NULL, NULL),
('030601', 'Chincheros', '030600', '030000', NULL, NULL),
('030602', 'Anco_Huallo', '030600', '030000', NULL, NULL),
('030603', 'Cocharcas', '030600', '030000', NULL, NULL),
('030604', 'Huaccana', '030600', '030000', NULL, NULL),
('030605', 'Ocobamba', '030600', '030000', NULL, NULL),
('030606', 'Ongoy', '030600', '030000', NULL, NULL),
('030607', 'Uranmarca', '030600', '030000', NULL, NULL),
('030608', 'Ranracancha', '030600', '030000', NULL, NULL),
('030609', 'Rocchacc', '030600', '030000', NULL, NULL),
('030610', 'El Porvenir', '030600', '030000', NULL, NULL),
('030611', 'Los Chankas', '030600', '030000', NULL, NULL),
('030701', 'Chuquibambilla', '030700', '030000', NULL, NULL),
('030702', 'Curpahuasi', '030700', '030000', NULL, NULL),
('030703', 'Gamarra', '030700', '030000', NULL, NULL),
('030704', 'Huayllati', '030700', '030000', NULL, NULL),
('030705', 'Mamara', '030700', '030000', NULL, NULL),
('030706', 'Micaela Bastidas', '030700', '030000', NULL, NULL),
('030707', 'Pataypampa', '030700', '030000', NULL, NULL),
('030708', 'Progreso', '030700', '030000', NULL, NULL),
('030709', 'San Antonio', '030700', '030000', NULL, NULL),
('030710', 'Santa Rosa', '030700', '030000', NULL, NULL),
('030711', 'Turpay', '030700', '030000', NULL, NULL),
('030712', 'Vilcabamba', '030700', '030000', NULL, NULL),
('030713', 'Virundo', '030700', '030000', NULL, NULL),
('030714', 'Curasco', '030700', '030000', NULL, NULL),
('040101', 'Arequipa', '040100', '040000', NULL, NULL),
('040102', 'Alto Selva Alegre', '040100', '040000', NULL, NULL),
('040103', 'Cayma', '040100', '040000', NULL, NULL),
('040104', 'Cerro Colorado', '040100', '040000', NULL, NULL),
('040105', 'Characato', '040100', '040000', NULL, NULL),
('040106', 'Chiguata', '040100', '040000', NULL, NULL),
('040107', 'Jacobo Hunter', '040100', '040000', NULL, NULL),
('040108', 'La Joya', '040100', '040000', NULL, NULL),
('040109', 'Mariano Melgar', '040100', '040000', NULL, NULL),
('040110', 'Miraflores', '040100', '040000', NULL, NULL),
('040111', 'Mollebaya', '040100', '040000', NULL, NULL),
('040112', 'Paucarpata', '040100', '040000', NULL, NULL),
('040113', 'Pocsi', '040100', '040000', NULL, NULL),
('040114', 'Polobaya', '040100', '040000', NULL, NULL),
('040115', 'Quequeña', '040100', '040000', NULL, NULL),
('040116', 'Sabandia', '040100', '040000', NULL, NULL),
('040117', 'Sachaca', '040100', '040000', NULL, NULL),
('040118', 'San Juan de Siguas', '040100', '040000', NULL, NULL),
('040119', 'San Juan de Tarucani', '040100', '040000', NULL, NULL),
('040120', 'Santa Isabel de Siguas', '040100', '040000', NULL, NULL),
('040121', 'Santa Rita de Siguas', '040100', '040000', NULL, NULL),
('040122', 'Socabaya', '040100', '040000', NULL, NULL),
('040123', 'Tiabaya', '040100', '040000', NULL, NULL),
('040124', 'Uchumayo', '040100', '040000', NULL, NULL),
('040125', 'Vitor', '040100', '040000', NULL, NULL),
('040126', 'Yanahuara', '040100', '040000', NULL, NULL),
('040127', 'Yarabamba', '040100', '040000', NULL, NULL),
('040128', 'Yura', '040100', '040000', NULL, NULL),
('040129', 'José Luis Bustamante Y Rivero', '040100', '040000', NULL, NULL),
('040201', 'Camaná', '040200', '040000', NULL, NULL),
('040202', 'José María Quimper', '040200', '040000', NULL, NULL),
('040203', 'Mariano Nicolás Valcárcel', '040200', '040000', NULL, NULL),
('040204', 'Mariscal Cáceres', '040200', '040000', NULL, NULL),
('040205', 'Nicolás de Pierola', '040200', '040000', NULL, NULL),
('040206', 'Ocoña', '040200', '040000', NULL, NULL),
('040207', 'Quilca', '040200', '040000', NULL, NULL),
('040208', 'Samuel Pastor', '040200', '040000', NULL, NULL),
('040301', 'Caravelí', '040300', '040000', NULL, NULL),
('040302', 'Acarí', '040300', '040000', NULL, NULL),
('040303', 'Atico', '040300', '040000', NULL, NULL),
('040304', 'Atiquipa', '040300', '040000', NULL, NULL),
('040305', 'Bella Unión', '040300', '040000', NULL, NULL),
('040306', 'Cahuacho', '040300', '040000', NULL, NULL),
('040307', 'Chala', '040300', '040000', NULL, NULL),
('040308', 'Chaparra', '040300', '040000', NULL, NULL),
('040309', 'Huanuhuanu', '040300', '040000', NULL, NULL),
('040310', 'Jaqui', '040300', '040000', NULL, NULL),
('040311', 'Lomas', '040300', '040000', NULL, NULL),
('040312', 'Quicacha', '040300', '040000', NULL, NULL),
('040313', 'Yauca', '040300', '040000', NULL, NULL),
('040401', 'Aplao', '040400', '040000', NULL, NULL),
('040402', 'Andagua', '040400', '040000', NULL, NULL),
('040403', 'Ayo', '040400', '040000', NULL, NULL),
('040404', 'Chachas', '040400', '040000', NULL, NULL),
('040405', 'Chilcaymarca', '040400', '040000', NULL, NULL),
('040406', 'Choco', '040400', '040000', NULL, NULL),
('040407', 'Huancarqui', '040400', '040000', NULL, NULL),
('040408', 'Machaguay', '040400', '040000', NULL, NULL),
('040409', 'Orcopampa', '040400', '040000', NULL, NULL),
('040410', 'Pampacolca', '040400', '040000', NULL, NULL),
('040411', 'Tipan', '040400', '040000', NULL, NULL),
('040412', 'Uñon', '040400', '040000', NULL, NULL),
('040413', 'Uraca', '040400', '040000', NULL, NULL),
('040414', 'Viraco', '040400', '040000', NULL, NULL),
('040501', 'Chivay', '040500', '040000', NULL, NULL),
('040502', 'Achoma', '040500', '040000', NULL, NULL),
('040503', 'Cabanaconde', '040500', '040000', NULL, NULL),
('040504', 'Callalli', '040500', '040000', NULL, NULL),
('040505', 'Caylloma', '040500', '040000', NULL, NULL),
('040506', 'Coporaque', '040500', '040000', NULL, NULL),
('040507', 'Huambo', '040500', '040000', NULL, NULL),
('040508', 'Huanca', '040500', '040000', NULL, NULL),
('040509', 'Ichupampa', '040500', '040000', NULL, NULL),
('040510', 'Lari', '040500', '040000', NULL, NULL),
('040511', 'Lluta', '040500', '040000', NULL, NULL),
('040512', 'Maca', '040500', '040000', NULL, NULL),
('040513', 'Madrigal', '040500', '040000', NULL, NULL),
('040514', 'San Antonio de Chuca', '040500', '040000', NULL, NULL),
('040515', 'Sibayo', '040500', '040000', NULL, NULL),
('040516', 'Tapay', '040500', '040000', NULL, NULL),
('040517', 'Tisco', '040500', '040000', NULL, NULL),
('040518', 'Tuti', '040500', '040000', NULL, NULL),
('040519', 'Yanque', '040500', '040000', NULL, NULL),
('040520', 'Majes', '040500', '040000', NULL, NULL),
('040601', 'Chuquibamba', '040600', '040000', NULL, NULL),
('040602', 'Andaray', '040600', '040000', NULL, NULL),
('040603', 'Cayarani', '040600', '040000', NULL, NULL),
('040604', 'Chichas', '040600', '040000', NULL, NULL),
('040605', 'Iray', '040600', '040000', NULL, NULL),
('040606', 'Río Grande', '040600', '040000', NULL, NULL),
('040607', 'Salamanca', '040600', '040000', NULL, NULL),
('040608', 'Yanaquihua', '040600', '040000', NULL, NULL),
('040701', 'Mollendo', '040700', '040000', NULL, NULL),
('040702', 'Cocachacra', '040700', '040000', NULL, NULL),
('040703', 'Dean Valdivia', '040700', '040000', NULL, NULL),
('040704', 'Islay', '040700', '040000', NULL, NULL),
('040705', 'Mejia', '040700', '040000', NULL, NULL),
('040706', 'Punta de Bombón', '040700', '040000', NULL, NULL),
('040801', 'Cotahuasi', '040800', '040000', NULL, NULL),
('040802', 'Alca', '040800', '040000', NULL, NULL),
('040803', 'Charcana', '040800', '040000', NULL, NULL),
('040804', 'Huaynacotas', '040800', '040000', NULL, NULL),
('040805', 'Pampamarca', '040800', '040000', NULL, NULL),
('040806', 'Puyca', '040800', '040000', NULL, NULL),
('040807', 'Quechualla', '040800', '040000', NULL, NULL),
('040808', 'Sayla', '040800', '040000', NULL, NULL),
('040809', 'Tauria', '040800', '040000', NULL, NULL),
('040810', 'Tomepampa', '040800', '040000', NULL, NULL),
('040811', 'Toro', '040800', '040000', NULL, NULL),
('050101', 'Ayacucho', '050100', '050000', NULL, NULL),
('050102', 'Acocro', '050100', '050000', NULL, NULL),
('050103', 'Acos Vinchos', '050100', '050000', NULL, NULL),
('050104', 'Carmen Alto', '050100', '050000', NULL, NULL),
('050105', 'Chiara', '050100', '050000', NULL, NULL),
('050106', 'Ocros', '050100', '050000', NULL, NULL),
('050107', 'Pacaycasa', '050100', '050000', NULL, NULL),
('050108', 'Quinua', '050100', '050000', NULL, NULL),
('050109', 'San José de Ticllas', '050100', '050000', NULL, NULL),
('050110', 'San Juan Bautista', '050100', '050000', NULL, NULL),
('050111', 'Santiago de Pischa', '050100', '050000', NULL, NULL),
('050112', 'Socos', '050100', '050000', NULL, NULL),
('050113', 'Tambillo', '050100', '050000', NULL, NULL),
('050114', 'Vinchos', '050100', '050000', NULL, NULL),
('050115', 'Jesús Nazareno', '050100', '050000', NULL, NULL),
('050116', 'Andrés Avelino Cáceres Dorregaray', '050100', '050000', NULL, NULL),
('050201', 'Cangallo', '050200', '050000', NULL, NULL),
('050202', 'Chuschi', '050200', '050000', NULL, NULL),
('050203', 'Los Morochucos', '050200', '050000', NULL, NULL),
('050204', 'María Parado de Bellido', '050200', '050000', NULL, NULL),
('050205', 'Paras', '050200', '050000', NULL, NULL),
('050206', 'Totos', '050200', '050000', NULL, NULL),
('050301', 'Sancos', '050300', '050000', NULL, NULL),
('050302', 'Carapo', '050300', '050000', NULL, NULL),
('050303', 'Sacsamarca', '050300', '050000', NULL, NULL),
('050304', 'Santiago de Lucanamarca', '050300', '050000', NULL, NULL),
('050401', 'Huanta', '050400', '050000', NULL, NULL),
('050402', 'Ayahuanco', '050400', '050000', NULL, NULL),
('050403', 'Huamanguilla', '050400', '050000', NULL, NULL),
('050404', 'Iguain', '050400', '050000', NULL, NULL),
('050405', 'Luricocha', '050400', '050000', NULL, NULL),
('050406', 'Santillana', '050400', '050000', NULL, NULL),
('050407', 'Sivia', '050400', '050000', NULL, NULL),
('050408', 'Llochegua', '050400', '050000', NULL, NULL),
('050409', 'Canayre', '050400', '050000', NULL, NULL),
('050410', 'Uchuraccay', '050400', '050000', NULL, NULL),
('050411', 'Pucacolpa', '050400', '050000', NULL, NULL),
('050412', 'Chaca', '050400', '050000', NULL, NULL),
('050501', 'San Miguel', '050500', '050000', NULL, NULL),
('050502', 'Anco', '050500', '050000', NULL, NULL),
('050503', 'Ayna', '050500', '050000', NULL, NULL),
('050504', 'Chilcas', '050500', '050000', NULL, NULL),
('050505', 'Chungui', '050500', '050000', NULL, NULL),
('050506', 'Luis Carranza', '050500', '050000', NULL, NULL),
('050507', 'Santa Rosa', '050500', '050000', NULL, NULL),
('050508', 'Tambo', '050500', '050000', NULL, NULL),
('050509', 'Samugari', '050500', '050000', NULL, NULL),
('050510', 'Anchihuay', '050500', '050000', NULL, NULL),
('050511', 'Oronccoy', '050500', '050000', NULL, NULL),
('050601', 'Puquio', '050600', '050000', NULL, NULL),
('050602', 'Aucara', '050600', '050000', NULL, NULL),
('050603', 'Cabana', '050600', '050000', NULL, NULL),
('050604', 'Carmen Salcedo', '050600', '050000', NULL, NULL),
('050605', 'Chaviña', '050600', '050000', NULL, NULL),
('050606', 'Chipao', '050600', '050000', NULL, NULL),
('050607', 'Huac-Huas', '050600', '050000', NULL, NULL),
('050608', 'Laramate', '050600', '050000', NULL, NULL),
('050609', 'Leoncio Prado', '050600', '050000', NULL, NULL),
('050610', 'Llauta', '050600', '050000', NULL, NULL),
('050611', 'Lucanas', '050600', '050000', NULL, NULL),
('050612', 'Ocaña', '050600', '050000', NULL, NULL),
('050613', 'Otoca', '050600', '050000', NULL, NULL),
('050614', 'Saisa', '050600', '050000', NULL, NULL),
('050615', 'San Cristóbal', '050600', '050000', NULL, NULL),
('050616', 'San Juan', '050600', '050000', NULL, NULL),
('050617', 'San Pedro', '050600', '050000', NULL, NULL),
('050618', 'San Pedro de Palco', '050600', '050000', NULL, NULL),
('050619', 'Sancos', '050600', '050000', NULL, NULL),
('050620', 'Santa Ana de Huaycahuacho', '050600', '050000', NULL, NULL),
('050621', 'Santa Lucia', '050600', '050000', NULL, NULL),
('050701', 'Coracora', '050700', '050000', NULL, NULL),
('050702', 'Chumpi', '050700', '050000', NULL, NULL),
('050703', 'Coronel Castañeda', '050700', '050000', NULL, NULL),
('050704', 'Pacapausa', '050700', '050000', NULL, NULL),
('050705', 'Pullo', '050700', '050000', NULL, NULL),
('050706', 'Puyusca', '050700', '050000', NULL, NULL),
('050707', 'San Francisco de Ravacayco', '050700', '050000', NULL, NULL),
('050708', 'Upahuacho', '050700', '050000', NULL, NULL),
('050801', 'Pausa', '050800', '050000', NULL, NULL),
('050802', 'Colta', '050800', '050000', NULL, NULL),
('050803', 'Corculla', '050800', '050000', NULL, NULL),
('050804', 'Lampa', '050800', '050000', NULL, NULL),
('050805', 'Marcabamba', '050800', '050000', NULL, NULL),
('050806', 'Oyolo', '050800', '050000', NULL, NULL),
('050807', 'Pararca', '050800', '050000', NULL, NULL),
('050808', 'San Javier de Alpabamba', '050800', '050000', NULL, NULL),
('050809', 'San José de Ushua', '050800', '050000', NULL, NULL),
('050810', 'Sara Sara', '050800', '050000', NULL, NULL),
('050901', 'Querobamba', '050900', '050000', NULL, NULL),
('050902', 'Belén', '050900', '050000', NULL, NULL),
('050903', 'Chalcos', '050900', '050000', NULL, NULL),
('050904', 'Chilcayoc', '050900', '050000', NULL, NULL),
('050905', 'Huacaña', '050900', '050000', NULL, NULL),
('050906', 'Morcolla', '050900', '050000', NULL, NULL),
('050907', 'Paico', '050900', '050000', NULL, NULL),
('050908', 'San Pedro de Larcay', '050900', '050000', NULL, NULL),
('050909', 'San Salvador de Quije', '050900', '050000', NULL, NULL),
('050910', 'Santiago de Paucaray', '050900', '050000', NULL, NULL),
('050911', 'Soras', '050900', '050000', NULL, NULL),
('051001', 'Huancapi', '051000', '050000', NULL, NULL),
('051002', 'Alcamenca', '051000', '050000', NULL, NULL),
('051003', 'Apongo', '051000', '050000', NULL, NULL),
('051004', 'Asquipata', '051000', '050000', NULL, NULL),
('051005', 'Canaria', '051000', '050000', NULL, NULL),
('051006', 'Cayara', '051000', '050000', NULL, NULL),
('051007', 'Colca', '051000', '050000', NULL, NULL),
('051008', 'Huamanquiquia', '051000', '050000', NULL, NULL),
('051009', 'Huancaraylla', '051000', '050000', NULL, NULL),
('051010', 'Huaya', '051000', '050000', NULL, NULL),
('051011', 'Sarhua', '051000', '050000', NULL, NULL),
('051012', 'Vilcanchos', '051000', '050000', NULL, NULL),
('051101', 'Vilcas Huaman', '051100', '050000', NULL, NULL),
('051102', 'Accomarca', '051100', '050000', NULL, NULL),
('051103', 'Carhuanca', '051100', '050000', NULL, NULL),
('051104', 'Concepción', '051100', '050000', NULL, NULL),
('051105', 'Huambalpa', '051100', '050000', NULL, NULL),
('051106', 'Independencia', '051100', '050000', NULL, NULL),
('051107', 'Saurama', '051100', '050000', NULL, NULL),
('051108', 'Vischongo', '051100', '050000', NULL, NULL),
('060101', 'Cajamarca', '060100', '060000', NULL, NULL),
('060102', 'Asunción', '060100', '060000', NULL, NULL),
('060103', 'Chetilla', '060100', '060000', NULL, NULL),
('060104', 'Cospan', '060100', '060000', NULL, NULL),
('060105', 'Encañada', '060100', '060000', NULL, NULL),
('060106', 'Jesús', '060100', '060000', NULL, NULL),
('060107', 'Llacanora', '060100', '060000', NULL, NULL),
('060108', 'Los Baños del Inca', '060100', '060000', NULL, NULL),
('060109', 'Magdalena', '060100', '060000', NULL, NULL),
('060110', 'Matara', '060100', '060000', NULL, NULL),
('060111', 'Namora', '060100', '060000', NULL, NULL),
('060112', 'San Juan', '060100', '060000', NULL, NULL),
('060201', 'Cajabamba', '060200', '060000', NULL, NULL),
('060202', 'Cachachi', '060200', '060000', NULL, NULL),
('060203', 'Condebamba', '060200', '060000', NULL, NULL),
('060204', 'Sitacocha', '060200', '060000', NULL, NULL),
('060301', 'Celendín', '060300', '060000', NULL, NULL),
('060302', 'Chumuch', '060300', '060000', NULL, NULL),
('060303', 'Cortegana', '060300', '060000', NULL, NULL),
('060304', 'Huasmin', '060300', '060000', NULL, NULL),
('060305', 'Jorge Chávez', '060300', '060000', NULL, NULL),
('060306', 'José Gálvez', '060300', '060000', NULL, NULL),
('060307', 'Miguel Iglesias', '060300', '060000', NULL, NULL),
('060308', 'Oxamarca', '060300', '060000', NULL, NULL),
('060309', 'Sorochuco', '060300', '060000', NULL, NULL),
('060310', 'Sucre', '060300', '060000', NULL, NULL),
('060311', 'Utco', '060300', '060000', NULL, NULL),
('060312', 'La Libertad de Pallan', '060300', '060000', NULL, NULL),
('060401', 'Chota', '060400', '060000', NULL, NULL),
('060402', 'Anguia', '060400', '060000', NULL, NULL),
('060403', 'Chadin', '060400', '060000', NULL, NULL),
('060404', 'Chiguirip', '060400', '060000', NULL, NULL),
('060405', 'Chimban', '060400', '060000', NULL, NULL),
('060406', 'Choropampa', '060400', '060000', NULL, NULL),
('060407', 'Cochabamba', '060400', '060000', NULL, NULL),
('060408', 'Conchan', '060400', '060000', NULL, NULL),
('060409', 'Huambos', '060400', '060000', NULL, NULL),
('060410', 'Lajas', '060400', '060000', NULL, NULL),
('060411', 'Llama', '060400', '060000', NULL, NULL),
('060412', 'Miracosta', '060400', '060000', NULL, NULL),
('060413', 'Paccha', '060400', '060000', NULL, NULL),
('060414', 'Pion', '060400', '060000', NULL, NULL),
('060415', 'Querocoto', '060400', '060000', NULL, NULL),
('060416', 'San Juan de Licupis', '060400', '060000', NULL, NULL),
('060417', 'Tacabamba', '060400', '060000', NULL, NULL),
('060418', 'Tocmoche', '060400', '060000', NULL, NULL),
('060419', 'Chalamarca', '060400', '060000', NULL, NULL),
('060501', 'Contumaza', '060500', '060000', NULL, NULL),
('060502', 'Chilete', '060500', '060000', NULL, NULL),
('060503', 'Cupisnique', '060500', '060000', NULL, NULL),
('060504', 'Guzmango', '060500', '060000', NULL, NULL),
('060505', 'San Benito', '060500', '060000', NULL, NULL),
('060506', 'Santa Cruz de Toledo', '060500', '060000', NULL, NULL),
('060507', 'Tantarica', '060500', '060000', NULL, NULL),
('060508', 'Yonan', '060500', '060000', NULL, NULL),
('060601', 'Cutervo', '060600', '060000', NULL, NULL),
('060602', 'Callayuc', '060600', '060000', NULL, NULL),
('060603', 'Choros', '060600', '060000', NULL, NULL),
('060604', 'Cujillo', '060600', '060000', NULL, NULL),
('060605', 'La Ramada', '060600', '060000', NULL, NULL),
('060606', 'Pimpingos', '060600', '060000', NULL, NULL),
('060607', 'Querocotillo', '060600', '060000', NULL, NULL),
('060608', 'San Andrés de Cutervo', '060600', '060000', NULL, NULL),
('060609', 'San Juan de Cutervo', '060600', '060000', NULL, NULL),
('060610', 'San Luis de Lucma', '060600', '060000', NULL, NULL),
('060611', 'Santa Cruz', '060600', '060000', NULL, NULL),
('060612', 'Santo Domingo de la Capilla', '060600', '060000', NULL, NULL),
('060613', 'Santo Tomas', '060600', '060000', NULL, NULL),
('060614', 'Socota', '060600', '060000', NULL, NULL),
('060615', 'Toribio Casanova', '060600', '060000', NULL, NULL),
('060701', 'Bambamarca', '060700', '060000', NULL, NULL),
('060702', 'Chugur', '060700', '060000', NULL, NULL),
('060703', 'Hualgayoc', '060700', '060000', NULL, NULL),
('060801', 'Jaén', '060800', '060000', NULL, NULL),
('060802', 'Bellavista', '060800', '060000', NULL, NULL),
('060803', 'Chontali', '060800', '060000', NULL, NULL),
('060804', 'Colasay', '060800', '060000', NULL, NULL),
('060805', 'Huabal', '060800', '060000', NULL, NULL),
('060806', 'Las Pirias', '060800', '060000', NULL, NULL),
('060807', 'Pomahuaca', '060800', '060000', NULL, NULL),
('060808', 'Pucara', '060800', '060000', NULL, NULL),
('060809', 'Sallique', '060800', '060000', NULL, NULL),
('060810', 'San Felipe', '060800', '060000', NULL, NULL),
('060811', 'San José del Alto', '060800', '060000', NULL, NULL),
('060812', 'Santa Rosa', '060800', '060000', NULL, NULL),
('060901', 'San Ignacio', '060900', '060000', NULL, NULL),
('060902', 'Chirinos', '060900', '060000', NULL, NULL),
('060903', 'Huarango', '060900', '060000', NULL, NULL),
('060904', 'La Coipa', '060900', '060000', NULL, NULL),
('060905', 'Namballe', '060900', '060000', NULL, NULL),
('060906', 'San José de Lourdes', '060900', '060000', NULL, NULL),
('060907', 'Tabaconas', '060900', '060000', NULL, NULL),
('061001', 'Pedro Gálvez', '061000', '060000', NULL, NULL),
('061002', 'Chancay', '061000', '060000', NULL, NULL),
('061003', 'Eduardo Villanueva', '061000', '060000', NULL, NULL),
('061004', 'Gregorio Pita', '061000', '060000', NULL, NULL),
('061005', 'Ichocan', '061000', '060000', NULL, NULL),
('061006', 'José Manuel Quiroz', '061000', '060000', NULL, NULL),
('061007', 'José Sabogal', '061000', '060000', NULL, NULL),
('061101', 'San Miguel', '061100', '060000', NULL, NULL),
('061102', 'Bolívar', '061100', '060000', NULL, NULL),
('061103', 'Calquis', '061100', '060000', NULL, NULL),
('061104', 'Catilluc', '061100', '060000', NULL, NULL),
('061105', 'El Prado', '061100', '060000', NULL, NULL),
('061106', 'La Florida', '061100', '060000', NULL, NULL),
('061107', 'Llapa', '061100', '060000', NULL, NULL),
('061108', 'Nanchoc', '061100', '060000', NULL, NULL),
('061109', 'Niepos', '061100', '060000', NULL, NULL),
('061110', 'San Gregorio', '061100', '060000', NULL, NULL),
('061111', 'San Silvestre de Cochan', '061100', '060000', NULL, NULL),
('061112', 'Tongod', '061100', '060000', NULL, NULL),
('061113', 'Unión Agua Blanca', '061100', '060000', NULL, NULL),
('061201', 'San Pablo', '061200', '060000', NULL, NULL),
('061202', 'San Bernardino', '061200', '060000', NULL, NULL),
('061203', 'San Luis', '061200', '060000', NULL, NULL),
('061204', 'Tumbaden', '061200', '060000', NULL, NULL),
('061301', 'Santa Cruz', '061300', '060000', NULL, NULL),
('061302', 'Andabamba', '061300', '060000', NULL, NULL),
('061303', 'Catache', '061300', '060000', NULL, NULL),
('061304', 'Chancaybaños', '061300', '060000', NULL, NULL),
('061305', 'La Esperanza', '061300', '060000', NULL, NULL),
('061306', 'Ninabamba', '061300', '060000', NULL, NULL),
('061307', 'Pulan', '061300', '060000', NULL, NULL),
('061308', 'Saucepampa', '061300', '060000', NULL, NULL),
('061309', 'Sexi', '061300', '060000', NULL, NULL),
('061310', 'Uticyacu', '061300', '060000', NULL, NULL),
('061311', 'Yauyucan', '061300', '060000', NULL, NULL),
('070101', 'Callao', '070100', '070000', NULL, NULL),
('070102', 'Bellavista', '070100', '070000', NULL, NULL),
('070103', 'Carmen de la Legua Reynoso', '070100', '070000', NULL, NULL),
('070104', 'La Perla', '070100', '070000', NULL, NULL),
('070105', 'La Punta', '070100', '070000', NULL, NULL),
('070106', 'Ventanilla', '070100', '070000', NULL, NULL),
('070107', 'Mi Perú', '070100', '070000', NULL, NULL),
('080101', 'Cusco', '080100', '080000', NULL, NULL),
('080102', 'Ccorca', '080100', '080000', NULL, NULL),
('080103', 'Poroy', '080100', '080000', NULL, NULL),
('080104', 'San Jerónimo', '080100', '080000', NULL, NULL),
('080105', 'San Sebastian', '080100', '080000', NULL, NULL),
('080106', 'Santiago', '080100', '080000', NULL, NULL),
('080107', 'Saylla', '080100', '080000', NULL, NULL),
('080108', 'Wanchaq', '080100', '080000', NULL, NULL),
('080201', 'Acomayo', '080200', '080000', NULL, NULL),
('080202', 'Acopia', '080200', '080000', NULL, NULL),
('080203', 'Acos', '080200', '080000', NULL, NULL),
('080204', 'Mosoc Llacta', '080200', '080000', NULL, NULL),
('080205', 'Pomacanchi', '080200', '080000', NULL, NULL),
('080206', 'Rondocan', '080200', '080000', NULL, NULL),
('080207', 'Sangarara', '080200', '080000', NULL, NULL),
('080301', 'Anta', '080300', '080000', NULL, NULL),
('080302', 'Ancahuasi', '080300', '080000', NULL, NULL),
('080303', 'Cachimayo', '080300', '080000', NULL, NULL),
('080304', 'Chinchaypujio', '080300', '080000', NULL, NULL),
('080305', 'Huarocondo', '080300', '080000', NULL, NULL),
('080306', 'Limatambo', '080300', '080000', NULL, NULL),
('080307', 'Mollepata', '080300', '080000', NULL, NULL),
('080308', 'Pucyura', '080300', '080000', NULL, NULL),
('080309', 'Zurite', '080300', '080000', NULL, NULL),
('080401', 'Calca', '080400', '080000', NULL, NULL),
('080402', 'Coya', '080400', '080000', NULL, NULL),
('080403', 'Lamay', '080400', '080000', NULL, NULL),
('080404', 'Lares', '080400', '080000', NULL, NULL),
('080405', 'Pisac', '080400', '080000', NULL, NULL),
('080406', 'San Salvador', '080400', '080000', NULL, NULL),
('080407', 'Taray', '080400', '080000', NULL, NULL),
('080408', 'Yanatile', '080400', '080000', NULL, NULL),
('080501', 'Yanaoca', '080500', '080000', NULL, NULL),
('080502', 'Checca', '080500', '080000', NULL, NULL),
('080503', 'Kunturkanki', '080500', '080000', NULL, NULL),
('080504', 'Langui', '080500', '080000', NULL, NULL),
('080505', 'Layo', '080500', '080000', NULL, NULL),
('080506', 'Pampamarca', '080500', '080000', NULL, NULL),
('080507', 'Quehue', '080500', '080000', NULL, NULL),
('080508', 'Tupac Amaru', '080500', '080000', NULL, NULL),
('080601', 'Sicuani', '080600', '080000', NULL, NULL),
('080602', 'Checacupe', '080600', '080000', NULL, NULL),
('080603', 'Combapata', '080600', '080000', NULL, NULL),
('080604', 'Marangani', '080600', '080000', NULL, NULL),
('080605', 'Pitumarca', '080600', '080000', NULL, NULL),
('080606', 'San Pablo', '080600', '080000', NULL, NULL),
('080607', 'San Pedro', '080600', '080000', NULL, NULL),
('080608', 'Tinta', '080600', '080000', NULL, NULL),
('080701', 'Santo Tomas', '080700', '080000', NULL, NULL),
('080702', 'Capacmarca', '080700', '080000', NULL, NULL),
('080703', 'Chamaca', '080700', '080000', NULL, NULL),
('080704', 'Colquemarca', '080700', '080000', NULL, NULL),
('080705', 'Livitaca', '080700', '080000', NULL, NULL),
('080706', 'Llusco', '080700', '080000', NULL, NULL),
('080707', 'Quiñota', '080700', '080000', NULL, NULL),
('080708', 'Velille', '080700', '080000', NULL, NULL),
('080801', 'Espinar', '080800', '080000', NULL, NULL),
('080802', 'Condoroma', '080800', '080000', NULL, NULL),
('080803', 'Coporaque', '080800', '080000', NULL, NULL),
('080804', 'Ocoruro', '080800', '080000', NULL, NULL),
('080805', 'Pallpata', '080800', '080000', NULL, NULL),
('080806', 'Pichigua', '080800', '080000', NULL, NULL),
('080807', 'Suyckutambo', '080800', '080000', NULL, NULL),
('080808', 'Alto Pichigua', '080800', '080000', NULL, NULL),
('080901', 'Santa Ana', '080900', '080000', NULL, NULL),
('080902', 'Echarate', '080900', '080000', NULL, NULL),
('080903', 'Huayopata', '080900', '080000', NULL, NULL),
('080904', 'Maranura', '080900', '080000', NULL, NULL),
('080905', 'Ocobamba', '080900', '080000', NULL, NULL),
('080906', 'Quellouno', '080900', '080000', NULL, NULL),
('080907', 'Kimbiri', '080900', '080000', NULL, NULL),
('080908', 'Santa Teresa', '080900', '080000', NULL, NULL),
('080909', 'Vilcabamba', '080900', '080000', NULL, NULL),
('080910', 'Pichari', '080900', '080000', NULL, NULL),
('080911', 'Inkawasi', '080900', '080000', NULL, NULL),
('080912', 'Villa Virgen', '080900', '080000', NULL, NULL),
('080913', 'Villa Kintiarina', '080900', '080000', NULL, NULL),
('080914', 'Megantoni', '080900', '080000', NULL, NULL),
('081001', 'Paruro', '081000', '080000', NULL, NULL),
('081002', 'Accha', '081000', '080000', NULL, NULL),
('081003', 'Ccapi', '081000', '080000', NULL, NULL),
('081004', 'Colcha', '081000', '080000', NULL, NULL),
('081005', 'Huanoquite', '081000', '080000', NULL, NULL),
('081006', 'Omacha', '081000', '080000', NULL, NULL),
('081007', 'Paccaritambo', '081000', '080000', NULL, NULL),
('081008', 'Pillpinto', '081000', '080000', NULL, NULL),
('081009', 'Yaurisque', '081000', '080000', NULL, NULL),
('081101', 'Paucartambo', '081100', '080000', NULL, NULL),
('081102', 'Caicay', '081100', '080000', NULL, NULL),
('081103', 'Challabamba', '081100', '080000', NULL, NULL),
('081104', 'Colquepata', '081100', '080000', NULL, NULL),
('081105', 'Huancarani', '081100', '080000', NULL, NULL),
('081106', 'Kosñipata', '081100', '080000', NULL, NULL),
('081201', 'Urcos', '081200', '080000', NULL, NULL),
('081202', 'Andahuaylillas', '081200', '080000', NULL, NULL),
('081203', 'Camanti', '081200', '080000', NULL, NULL),
('081204', 'Ccarhuayo', '081200', '080000', NULL, NULL),
('081205', 'Ccatca', '081200', '080000', NULL, NULL),
('081206', 'Cusipata', '081200', '080000', NULL, NULL),
('081207', 'Huaro', '081200', '080000', NULL, NULL),
('081208', 'Lucre', '081200', '080000', NULL, NULL),
('081209', 'Marcapata', '081200', '080000', NULL, NULL),
('081210', 'Ocongate', '081200', '080000', NULL, NULL),
('081211', 'Oropesa', '081200', '080000', NULL, NULL),
('081212', 'Quiquijana', '081200', '080000', NULL, NULL),
('081301', 'Urubamba', '081300', '080000', NULL, NULL),
('081302', 'Chinchero', '081300', '080000', NULL, NULL),
('081303', 'Huayllabamba', '081300', '080000', NULL, NULL),
('081304', 'Machupicchu', '081300', '080000', NULL, NULL),
('081305', 'Maras', '081300', '080000', NULL, NULL),
('081306', 'Ollantaytambo', '081300', '080000', NULL, NULL),
('081307', 'Yucay', '081300', '080000', NULL, NULL),
('090101', 'Huancavelica', '090100', '090000', NULL, NULL),
('090102', 'Acobambilla', '090100', '090000', NULL, NULL),
('090103', 'Acoria', '090100', '090000', NULL, NULL),
('090104', 'Conayca', '090100', '090000', NULL, NULL),
('090105', 'Cuenca', '090100', '090000', NULL, NULL),
('090106', 'Huachocolpa', '090100', '090000', NULL, NULL),
('090107', 'Huayllahuara', '090100', '090000', NULL, NULL),
('090108', 'Izcuchaca', '090100', '090000', NULL, NULL),
('090109', 'Laria', '090100', '090000', NULL, NULL),
('090110', 'Manta', '090100', '090000', NULL, NULL),
('090111', 'Mariscal Cáceres', '090100', '090000', NULL, NULL),
('090112', 'Moya', '090100', '090000', NULL, NULL),
('090113', 'Nuevo Occoro', '090100', '090000', NULL, NULL),
('090114', 'Palca', '090100', '090000', NULL, NULL),
('090115', 'Pilchaca', '090100', '090000', NULL, NULL),
('090116', 'Vilca', '090100', '090000', NULL, NULL),
('090117', 'Yauli', '090100', '090000', NULL, NULL),
('090118', 'Ascensión', '090100', '090000', NULL, NULL),
('090119', 'Huando', '090100', '090000', NULL, NULL),
('090201', 'Acobamba', '090200', '090000', NULL, NULL),
('090202', 'Andabamba', '090200', '090000', NULL, NULL),
('090203', 'Anta', '090200', '090000', NULL, NULL),
('090204', 'Caja', '090200', '090000', NULL, NULL),
('090205', 'Marcas', '090200', '090000', NULL, NULL),
('090206', 'Paucara', '090200', '090000', NULL, NULL),
('090207', 'Pomacocha', '090200', '090000', NULL, NULL),
('090208', 'Rosario', '090200', '090000', NULL, NULL),
('090301', 'Lircay', '090300', '090000', NULL, NULL),
('090302', 'Anchonga', '090300', '090000', NULL, NULL),
('090303', 'Callanmarca', '090300', '090000', NULL, NULL),
('090304', 'Ccochaccasa', '090300', '090000', NULL, NULL),
('090305', 'Chincho', '090300', '090000', NULL, NULL),
('090306', 'Congalla', '090300', '090000', NULL, NULL),
('090307', 'Huanca-Huanca', '090300', '090000', NULL, NULL),
('090308', 'Huayllay Grande', '090300', '090000', NULL, NULL),
('090309', 'Julcamarca', '090300', '090000', NULL, NULL),
('090310', 'San Antonio de Antaparco', '090300', '090000', NULL, NULL),
('090311', 'Santo Tomas de Pata', '090300', '090000', NULL, NULL),
('090312', 'Secclla', '090300', '090000', NULL, NULL),
('090401', 'Castrovirreyna', '090400', '090000', NULL, NULL),
('090402', 'Arma', '090400', '090000', NULL, NULL),
('090403', 'Aurahua', '090400', '090000', NULL, NULL),
('090404', 'Capillas', '090400', '090000', NULL, NULL),
('090405', 'Chupamarca', '090400', '090000', NULL, NULL),
('090406', 'Cocas', '090400', '090000', NULL, NULL),
('090407', 'Huachos', '090400', '090000', NULL, NULL),
('090408', 'Huamatambo', '090400', '090000', NULL, NULL),
('090409', 'Mollepampa', '090400', '090000', NULL, NULL),
('090410', 'San Juan', '090400', '090000', NULL, NULL),
('090411', 'Santa Ana', '090400', '090000', NULL, NULL),
('090412', 'Tantara', '090400', '090000', NULL, NULL),
('090413', 'Ticrapo', '090400', '090000', NULL, NULL),
('090501', 'Churcampa', '090500', '090000', NULL, NULL),
('090502', 'Anco', '090500', '090000', NULL, NULL),
('090503', 'Chinchihuasi', '090500', '090000', NULL, NULL),
('090504', 'El Carmen', '090500', '090000', NULL, NULL),
('090505', 'La Merced', '090500', '090000', NULL, NULL),
('090506', 'Locroja', '090500', '090000', NULL, NULL),
('090507', 'Paucarbamba', '090500', '090000', NULL, NULL),
('090508', 'San Miguel de Mayocc', '090500', '090000', NULL, NULL),
('090509', 'San Pedro de Coris', '090500', '090000', NULL, NULL),
('090510', 'Pachamarca', '090500', '090000', NULL, NULL),
('090511', 'Cosme', '090500', '090000', NULL, NULL),
('090601', 'Huaytara', '090600', '090000', NULL, NULL),
('090602', 'Ayavi', '090600', '090000', NULL, NULL),
('090603', 'Córdova', '090600', '090000', NULL, NULL),
('090604', 'Huayacundo Arma', '090600', '090000', NULL, NULL),
('090605', 'Laramarca', '090600', '090000', NULL, NULL),
('090606', 'Ocoyo', '090600', '090000', NULL, NULL),
('090607', 'Pilpichaca', '090600', '090000', NULL, NULL),
('090608', 'Querco', '090600', '090000', NULL, NULL),
('090609', 'Quito-Arma', '090600', '090000', NULL, NULL),
('090610', 'San Antonio de Cusicancha', '090600', '090000', NULL, NULL),
('090611', 'San Francisco de Sangayaico', '090600', '090000', NULL, NULL),
('090612', 'San Isidro', '090600', '090000', NULL, NULL),
('090613', 'Santiago de Chocorvos', '090600', '090000', NULL, NULL),
('090614', 'Santiago de Quirahuara', '090600', '090000', NULL, NULL),
('090615', 'Santo Domingo de Capillas', '090600', '090000', NULL, NULL),
('090616', 'Tambo', '090600', '090000', NULL, NULL),
('090701', 'Pampas', '090700', '090000', NULL, NULL),
('090702', 'Acostambo', '090700', '090000', NULL, NULL),
('090703', 'Acraquia', '090700', '090000', NULL, NULL),
('090704', 'Ahuaycha', '090700', '090000', NULL, NULL),
('090705', 'Colcabamba', '090700', '090000', NULL, NULL),
('090706', 'Daniel Hernández', '090700', '090000', NULL, NULL),
('090707', 'Huachocolpa', '090700', '090000', NULL, NULL),
('090709', 'Huaribamba', '090700', '090000', NULL, NULL),
('090710', 'Ñahuimpuquio', '090700', '090000', NULL, NULL),
('090711', 'Pazos', '090700', '090000', NULL, NULL),
('090713', 'Quishuar', '090700', '090000', NULL, NULL),
('090714', 'Salcabamba', '090700', '090000', NULL, NULL),
('090715', 'Salcahuasi', '090700', '090000', NULL, NULL),
('090716', 'San Marcos de Rocchac', '090700', '090000', NULL, NULL),
('090717', 'Surcubamba', '090700', '090000', NULL, NULL),
('090718', 'Tintay Puncu', '090700', '090000', NULL, NULL),
('090719', 'Quichuas', '090700', '090000', NULL, NULL),
('090720', 'Andaymarca', '090700', '090000', NULL, NULL);
INSERT INTO `info_distritos` (`id`, `name`, `region_id`, `province_id`, `created_at`, `updated_at`) VALUES
('090721', 'Roble', '090700', '090000', NULL, NULL),
('090722', 'Pichos', '090700', '090000', NULL, NULL),
('090723', 'Santiago de Tucuma', '090700', '090000', NULL, NULL),
('100101', 'Huanuco', '100100', '100000', NULL, NULL),
('100102', 'Amarilis', '100100', '100000', NULL, NULL),
('100103', 'Chinchao', '100100', '100000', NULL, NULL),
('100104', 'Churubamba', '100100', '100000', NULL, NULL),
('100105', 'Margos', '100100', '100000', NULL, NULL),
('100106', 'Quisqui (Kichki)', '100100', '100000', NULL, NULL),
('100107', 'San Francisco de Cayran', '100100', '100000', NULL, NULL),
('100108', 'San Pedro de Chaulan', '100100', '100000', NULL, NULL),
('100109', 'Santa María del Valle', '100100', '100000', NULL, NULL),
('100110', 'Yarumayo', '100100', '100000', NULL, NULL),
('100111', 'Pillco Marca', '100100', '100000', NULL, NULL),
('100112', 'Yacus', '100100', '100000', NULL, NULL),
('100113', 'San Pablo de Pillao', '100100', '100000', NULL, NULL),
('100201', 'Ambo', '100200', '100000', NULL, NULL),
('100202', 'Cayna', '100200', '100000', NULL, NULL),
('100203', 'Colpas', '100200', '100000', NULL, NULL),
('100204', 'Conchamarca', '100200', '100000', NULL, NULL),
('100205', 'Huacar', '100200', '100000', NULL, NULL),
('100206', 'San Francisco', '100200', '100000', NULL, NULL),
('100207', 'San Rafael', '100200', '100000', NULL, NULL),
('100208', 'Tomay Kichwa', '100200', '100000', NULL, NULL),
('100301', 'La Unión', '100300', '100000', NULL, NULL),
('100307', 'Chuquis', '100300', '100000', NULL, NULL),
('100311', 'Marías', '100300', '100000', NULL, NULL),
('100313', 'Pachas', '100300', '100000', NULL, NULL),
('100316', 'Quivilla', '100300', '100000', NULL, NULL),
('100317', 'Ripan', '100300', '100000', NULL, NULL),
('100321', 'Shunqui', '100300', '100000', NULL, NULL),
('100322', 'Sillapata', '100300', '100000', NULL, NULL),
('100323', 'Yanas', '100300', '100000', NULL, NULL),
('100401', 'Huacaybamba', '100400', '100000', NULL, NULL),
('100402', 'Canchabamba', '100400', '100000', NULL, NULL),
('100403', 'Cochabamba', '100400', '100000', NULL, NULL),
('100404', 'Pinra', '100400', '100000', NULL, NULL),
('100501', 'Llata', '100500', '100000', NULL, NULL),
('100502', 'Arancay', '100500', '100000', NULL, NULL),
('100503', 'Chavín de Pariarca', '100500', '100000', NULL, NULL),
('100504', 'Jacas Grande', '100500', '100000', NULL, NULL),
('100505', 'Jircan', '100500', '100000', NULL, NULL),
('100506', 'Miraflores', '100500', '100000', NULL, NULL),
('100507', 'Monzón', '100500', '100000', NULL, NULL),
('100508', 'Punchao', '100500', '100000', NULL, NULL),
('100509', 'Puños', '100500', '100000', NULL, NULL),
('100510', 'Singa', '100500', '100000', NULL, NULL),
('100511', 'Tantamayo', '100500', '100000', NULL, NULL),
('100601', 'Rupa-Rupa', '100600', '100000', NULL, NULL),
('100602', 'Daniel Alomía Robles', '100600', '100000', NULL, NULL),
('100603', 'Hermílio Valdizan', '100600', '100000', NULL, NULL),
('100604', 'José Crespo y Castillo', '100600', '100000', NULL, NULL),
('100605', 'Luyando', '100600', '100000', NULL, NULL),
('100606', 'Mariano Damaso Beraun', '100600', '100000', NULL, NULL),
('100607', 'Pucayacu', '100600', '100000', NULL, NULL),
('100608', 'Castillo Grande', '100600', '100000', NULL, NULL),
('100609', 'Pueblo Nuevo', '100600', '100000', NULL, NULL),
('100610', 'Santo Domingo de Anda', '100600', '100000', NULL, NULL),
('100701', 'Huacrachuco', '100700', '100000', NULL, NULL),
('100702', 'Cholon', '100700', '100000', NULL, NULL),
('100703', 'San Buenaventura', '100700', '100000', NULL, NULL),
('100704', 'La Morada', '100700', '100000', NULL, NULL),
('100705', 'Santa Rosa de Alto Yanajanca', '100700', '100000', NULL, NULL),
('100801', 'Panao', '100800', '100000', NULL, NULL),
('100802', 'Chaglla', '100800', '100000', NULL, NULL),
('100803', 'Molino', '100800', '100000', NULL, NULL),
('100804', 'Umari', '100800', '100000', NULL, NULL),
('100901', 'Puerto Inca', '100900', '100000', NULL, NULL),
('100902', 'Codo del Pozuzo', '100900', '100000', NULL, NULL),
('100903', 'Honoria', '100900', '100000', NULL, NULL),
('100904', 'Tournavista', '100900', '100000', NULL, NULL),
('100905', 'Yuyapichis', '100900', '100000', NULL, NULL),
('101001', 'Jesús', '101000', '100000', NULL, NULL),
('101002', 'Baños', '101000', '100000', NULL, NULL),
('101003', 'Jivia', '101000', '100000', NULL, NULL),
('101004', 'Queropalca', '101000', '100000', NULL, NULL),
('101005', 'Rondos', '101000', '100000', NULL, NULL),
('101006', 'San Francisco de Asís', '101000', '100000', NULL, NULL),
('101007', 'San Miguel de Cauri', '101000', '100000', NULL, NULL),
('101101', 'Chavinillo', '101100', '100000', NULL, NULL),
('101102', 'Cahuac', '101100', '100000', NULL, NULL),
('101103', 'Chacabamba', '101100', '100000', NULL, NULL),
('101104', 'Aparicio Pomares', '101100', '100000', NULL, NULL),
('101105', 'Jacas Chico', '101100', '100000', NULL, NULL),
('101106', 'Obas', '101100', '100000', NULL, NULL),
('101107', 'Pampamarca', '101100', '100000', NULL, NULL),
('101108', 'Choras', '101100', '100000', NULL, NULL),
('110101', 'Ica', '110100', '110000', NULL, NULL),
('110102', 'La Tinguiña', '110100', '110000', NULL, NULL),
('110103', 'Los Aquijes', '110100', '110000', NULL, NULL),
('110104', 'Ocucaje', '110100', '110000', NULL, NULL),
('110105', 'Pachacutec', '110100', '110000', NULL, NULL),
('110106', 'Parcona', '110100', '110000', NULL, NULL),
('110107', 'Pueblo Nuevo', '110100', '110000', NULL, NULL),
('110108', 'Salas', '110100', '110000', NULL, NULL),
('110109', 'San José de Los Molinos', '110100', '110000', NULL, NULL),
('110110', 'San Juan Bautista', '110100', '110000', NULL, NULL),
('110111', 'Santiago', '110100', '110000', NULL, NULL),
('110112', 'Subtanjalla', '110100', '110000', NULL, NULL),
('110113', 'Tate', '110100', '110000', NULL, NULL),
('110114', 'Yauca del Rosario', '110100', '110000', NULL, NULL),
('110201', 'Chincha Alta', '110200', '110000', NULL, NULL),
('110202', 'Alto Laran', '110200', '110000', NULL, NULL),
('110203', 'Chavin', '110200', '110000', NULL, NULL),
('110204', 'Chincha Baja', '110200', '110000', NULL, NULL),
('110205', 'El Carmen', '110200', '110000', NULL, NULL),
('110206', 'Grocio Prado', '110200', '110000', NULL, NULL),
('110207', 'Pueblo Nuevo', '110200', '110000', NULL, NULL),
('110208', 'San Juan de Yanac', '110200', '110000', NULL, NULL),
('110209', 'San Pedro de Huacarpana', '110200', '110000', NULL, NULL),
('110210', 'Sunampe', '110200', '110000', NULL, NULL),
('110211', 'Tambo de Mora', '110200', '110000', NULL, NULL),
('110301', 'Nasca', '110300', '110000', NULL, NULL),
('110302', 'Changuillo', '110300', '110000', NULL, NULL),
('110303', 'El Ingenio', '110300', '110000', NULL, NULL),
('110304', 'Marcona', '110300', '110000', NULL, NULL),
('110305', 'Vista Alegre', '110300', '110000', NULL, NULL),
('110401', 'Palpa', '110400', '110000', NULL, NULL),
('110402', 'Llipata', '110400', '110000', NULL, NULL),
('110403', 'Río Grande', '110400', '110000', NULL, NULL),
('110404', 'Santa Cruz', '110400', '110000', NULL, NULL),
('110405', 'Tibillo', '110400', '110000', NULL, NULL),
('110501', 'Pisco', '110500', '110000', NULL, NULL),
('110502', 'Huancano', '110500', '110000', NULL, NULL),
('110503', 'Humay', '110500', '110000', NULL, NULL),
('110504', 'Independencia', '110500', '110000', NULL, NULL),
('110505', 'Paracas', '110500', '110000', NULL, NULL),
('110506', 'San Andrés', '110500', '110000', NULL, NULL),
('110507', 'San Clemente', '110500', '110000', NULL, NULL),
('110508', 'Tupac Amaru Inca', '110500', '110000', NULL, NULL),
('120101', 'Huancayo', '120100', '120000', NULL, NULL),
('120104', 'Carhuacallanga', '120100', '120000', NULL, NULL),
('120105', 'Chacapampa', '120100', '120000', NULL, NULL),
('120106', 'Chicche', '120100', '120000', NULL, NULL),
('120107', 'Chilca', '120100', '120000', NULL, NULL),
('120108', 'Chongos Alto', '120100', '120000', NULL, NULL),
('120111', 'Chupuro', '120100', '120000', NULL, NULL),
('120112', 'Colca', '120100', '120000', NULL, NULL),
('120113', 'Cullhuas', '120100', '120000', NULL, NULL),
('120114', 'El Tambo', '120100', '120000', NULL, NULL),
('120116', 'Huacrapuquio', '120100', '120000', NULL, NULL),
('120117', 'Hualhuas', '120100', '120000', NULL, NULL),
('120119', 'Huancan', '120100', '120000', NULL, NULL),
('120120', 'Huasicancha', '120100', '120000', NULL, NULL),
('120121', 'Huayucachi', '120100', '120000', NULL, NULL),
('120122', 'Ingenio', '120100', '120000', NULL, NULL),
('120124', 'Pariahuanca', '120100', '120000', NULL, NULL),
('120125', 'Pilcomayo', '120100', '120000', NULL, NULL),
('120126', 'Pucara', '120100', '120000', NULL, NULL),
('120127', 'Quichuay', '120100', '120000', NULL, NULL),
('120128', 'Quilcas', '120100', '120000', NULL, NULL),
('120129', 'San Agustín', '120100', '120000', NULL, NULL),
('120130', 'San Jerónimo de Tunan', '120100', '120000', NULL, NULL),
('120132', 'Saño', '120100', '120000', NULL, NULL),
('120133', 'Sapallanga', '120100', '120000', NULL, NULL),
('120134', 'Sicaya', '120100', '120000', NULL, NULL),
('120135', 'Santo Domingo de Acobamba', '120100', '120000', NULL, NULL),
('120136', 'Viques', '120100', '120000', NULL, NULL),
('120201', 'Concepción', '120200', '120000', NULL, NULL),
('120202', 'Aco', '120200', '120000', NULL, NULL),
('120203', 'Andamarca', '120200', '120000', NULL, NULL),
('120204', 'Chambara', '120200', '120000', NULL, NULL),
('120205', 'Cochas', '120200', '120000', NULL, NULL),
('120206', 'Comas', '120200', '120000', NULL, NULL),
('120207', 'Heroínas Toledo', '120200', '120000', NULL, NULL),
('120208', 'Manzanares', '120200', '120000', NULL, NULL),
('120209', 'Mariscal Castilla', '120200', '120000', NULL, NULL),
('120210', 'Matahuasi', '120200', '120000', NULL, NULL),
('120211', 'Mito', '120200', '120000', NULL, NULL),
('120212', 'Nueve de Julio', '120200', '120000', NULL, NULL),
('120213', 'Orcotuna', '120200', '120000', NULL, NULL),
('120214', 'San José de Quero', '120200', '120000', NULL, NULL),
('120215', 'Santa Rosa de Ocopa', '120200', '120000', NULL, NULL),
('120301', 'Chanchamayo', '120300', '120000', NULL, NULL),
('120302', 'Perene', '120300', '120000', NULL, NULL),
('120303', 'Pichanaqui', '120300', '120000', NULL, NULL),
('120304', 'San Luis de Shuaro', '120300', '120000', NULL, NULL),
('120305', 'San Ramón', '120300', '120000', NULL, NULL),
('120306', 'Vitoc', '120300', '120000', NULL, NULL),
('120401', 'Jauja', '120400', '120000', NULL, NULL),
('120402', 'Acolla', '120400', '120000', NULL, NULL),
('120403', 'Apata', '120400', '120000', NULL, NULL),
('120404', 'Ataura', '120400', '120000', NULL, NULL),
('120405', 'Canchayllo', '120400', '120000', NULL, NULL),
('120406', 'Curicaca', '120400', '120000', NULL, NULL),
('120407', 'El Mantaro', '120400', '120000', NULL, NULL),
('120408', 'Huamali', '120400', '120000', NULL, NULL),
('120409', 'Huaripampa', '120400', '120000', NULL, NULL),
('120410', 'Huertas', '120400', '120000', NULL, NULL),
('120411', 'Janjaillo', '120400', '120000', NULL, NULL),
('120412', 'Julcán', '120400', '120000', NULL, NULL),
('120413', 'Leonor Ordóñez', '120400', '120000', NULL, NULL),
('120414', 'Llocllapampa', '120400', '120000', NULL, NULL),
('120415', 'Marco', '120400', '120000', NULL, NULL),
('120416', 'Masma', '120400', '120000', NULL, NULL),
('120417', 'Masma Chicche', '120400', '120000', NULL, NULL),
('120418', 'Molinos', '120400', '120000', NULL, NULL),
('120419', 'Monobamba', '120400', '120000', NULL, NULL),
('120420', 'Muqui', '120400', '120000', NULL, NULL),
('120421', 'Muquiyauyo', '120400', '120000', NULL, NULL),
('120422', 'Paca', '120400', '120000', NULL, NULL),
('120423', 'Paccha', '120400', '120000', NULL, NULL),
('120424', 'Pancan', '120400', '120000', NULL, NULL),
('120425', 'Parco', '120400', '120000', NULL, NULL),
('120426', 'Pomacancha', '120400', '120000', NULL, NULL),
('120427', 'Ricran', '120400', '120000', NULL, NULL),
('120428', 'San Lorenzo', '120400', '120000', NULL, NULL),
('120429', 'San Pedro de Chunan', '120400', '120000', NULL, NULL),
('120430', 'Sausa', '120400', '120000', NULL, NULL),
('120431', 'Sincos', '120400', '120000', NULL, NULL),
('120432', 'Tunan Marca', '120400', '120000', NULL, NULL),
('120433', 'Yauli', '120400', '120000', NULL, NULL),
('120434', 'Yauyos', '120400', '120000', NULL, NULL),
('120501', 'Junin', '120500', '120000', NULL, NULL),
('120502', 'Carhuamayo', '120500', '120000', NULL, NULL),
('120503', 'Ondores', '120500', '120000', NULL, NULL),
('120504', 'Ulcumayo', '120500', '120000', NULL, NULL),
('120601', 'Satipo', '120600', '120000', NULL, NULL),
('120602', 'Coviriali', '120600', '120000', NULL, NULL),
('120603', 'Llaylla', '120600', '120000', NULL, NULL),
('120604', 'Mazamari', '120600', '120000', NULL, NULL),
('120605', 'Pampa Hermosa', '120600', '120000', NULL, NULL),
('120606', 'Pangoa', '120600', '120000', NULL, NULL),
('120607', 'Río Negro', '120600', '120000', NULL, NULL),
('120608', 'Río Tambo', '120600', '120000', NULL, NULL),
('120609', 'Vizcatan del Ene', '120600', '120000', NULL, NULL),
('120701', 'Tarma', '120700', '120000', NULL, NULL),
('120702', 'Acobamba', '120700', '120000', NULL, NULL),
('120703', 'Huaricolca', '120700', '120000', NULL, NULL),
('120704', 'Huasahuasi', '120700', '120000', NULL, NULL),
('120705', 'La Unión', '120700', '120000', NULL, NULL),
('120706', 'Palca', '120700', '120000', NULL, NULL),
('120707', 'Palcamayo', '120700', '120000', NULL, NULL),
('120708', 'San Pedro de Cajas', '120700', '120000', NULL, NULL),
('120709', 'Tapo', '120700', '120000', NULL, NULL),
('120801', 'La Oroya', '120800', '120000', NULL, NULL),
('120802', 'Chacapalpa', '120800', '120000', NULL, NULL),
('120803', 'Huay-Huay', '120800', '120000', NULL, NULL),
('120804', 'Marcapomacocha', '120800', '120000', NULL, NULL),
('120805', 'Morococha', '120800', '120000', NULL, NULL),
('120806', 'Paccha', '120800', '120000', NULL, NULL),
('120807', 'Santa Bárbara de Carhuacayan', '120800', '120000', NULL, NULL),
('120808', 'Santa Rosa de Sacco', '120800', '120000', NULL, NULL),
('120809', 'Suitucancha', '120800', '120000', NULL, NULL),
('120810', 'Yauli', '120800', '120000', NULL, NULL),
('120901', 'Chupaca', '120900', '120000', NULL, NULL),
('120902', 'Ahuac', '120900', '120000', NULL, NULL),
('120903', 'Chongos Bajo', '120900', '120000', NULL, NULL),
('120904', 'Huachac', '120900', '120000', NULL, NULL),
('120905', 'Huamancaca Chico', '120900', '120000', NULL, NULL),
('120906', 'San Juan de Iscos', '120900', '120000', NULL, NULL),
('120907', 'San Juan de Jarpa', '120900', '120000', NULL, NULL),
('120908', 'Tres de Diciembre', '120900', '120000', NULL, NULL),
('120909', 'Yanacancha', '120900', '120000', NULL, NULL),
('130101', 'Trujillo', '130100', '130000', NULL, NULL),
('130102', 'El Porvenir', '130100', '130000', NULL, NULL),
('130103', 'Florencia de Mora', '130100', '130000', NULL, NULL),
('130104', 'Huanchaco', '130100', '130000', NULL, NULL),
('130105', 'La Esperanza', '130100', '130000', NULL, NULL),
('130106', 'Laredo', '130100', '130000', NULL, NULL),
('130107', 'Moche', '130100', '130000', NULL, NULL),
('130108', 'Poroto', '130100', '130000', NULL, NULL),
('130109', 'Salaverry', '130100', '130000', NULL, NULL),
('130110', 'Simbal', '130100', '130000', NULL, NULL),
('130111', 'Victor Larco Herrera', '130100', '130000', NULL, NULL),
('130201', 'Ascope', '130200', '130000', NULL, NULL),
('130202', 'Chicama', '130200', '130000', NULL, NULL),
('130203', 'Chocope', '130200', '130000', NULL, NULL),
('130204', 'Magdalena de Cao', '130200', '130000', NULL, NULL),
('130205', 'Paijan', '130200', '130000', NULL, NULL),
('130206', 'Rázuri', '130200', '130000', NULL, NULL),
('130207', 'Santiago de Cao', '130200', '130000', NULL, NULL),
('130208', 'Casa Grande', '130200', '130000', NULL, NULL),
('130301', 'Bolívar', '130300', '130000', NULL, NULL),
('130302', 'Bambamarca', '130300', '130000', NULL, NULL),
('130303', 'Condormarca', '130300', '130000', NULL, NULL),
('130304', 'Longotea', '130300', '130000', NULL, NULL),
('130305', 'Uchumarca', '130300', '130000', NULL, NULL),
('130306', 'Ucuncha', '130300', '130000', NULL, NULL),
('130401', 'Chepen', '130400', '130000', NULL, NULL),
('130402', 'Pacanga', '130400', '130000', NULL, NULL),
('130403', 'Pueblo Nuevo', '130400', '130000', NULL, NULL),
('130501', 'Julcan', '130500', '130000', NULL, NULL),
('130502', 'Calamarca', '130500', '130000', NULL, NULL),
('130503', 'Carabamba', '130500', '130000', NULL, NULL),
('130504', 'Huaso', '130500', '130000', NULL, NULL),
('130601', 'Otuzco', '130600', '130000', NULL, NULL),
('130602', 'Agallpampa', '130600', '130000', NULL, NULL),
('130604', 'Charat', '130600', '130000', NULL, NULL),
('130605', 'Huaranchal', '130600', '130000', NULL, NULL),
('130606', 'La Cuesta', '130600', '130000', NULL, NULL),
('130608', 'Mache', '130600', '130000', NULL, NULL),
('130610', 'Paranday', '130600', '130000', NULL, NULL),
('130611', 'Salpo', '130600', '130000', NULL, NULL),
('130613', 'Sinsicap', '130600', '130000', NULL, NULL),
('130614', 'Usquil', '130600', '130000', NULL, NULL),
('130701', 'San Pedro de Lloc', '130700', '130000', NULL, NULL),
('130702', 'Guadalupe', '130700', '130000', NULL, NULL),
('130703', 'Jequetepeque', '130700', '130000', NULL, NULL),
('130704', 'Pacasmayo', '130700', '130000', NULL, NULL),
('130705', 'San José', '130700', '130000', NULL, NULL),
('130801', 'Tayabamba', '130800', '130000', NULL, NULL),
('130802', 'Buldibuyo', '130800', '130000', NULL, NULL),
('130803', 'Chillia', '130800', '130000', NULL, NULL),
('130804', 'Huancaspata', '130800', '130000', NULL, NULL),
('130805', 'Huaylillas', '130800', '130000', NULL, NULL),
('130806', 'Huayo', '130800', '130000', NULL, NULL),
('130807', 'Ongon', '130800', '130000', NULL, NULL),
('130808', 'Parcoy', '130800', '130000', NULL, NULL),
('130809', 'Pataz', '130800', '130000', NULL, NULL),
('130810', 'Pias', '130800', '130000', NULL, NULL),
('130811', 'Santiago de Challas', '130800', '130000', NULL, NULL),
('130812', 'Taurija', '130800', '130000', NULL, NULL),
('130813', 'Urpay', '130800', '130000', NULL, NULL),
('130901', 'Huamachuco', '130900', '130000', NULL, NULL),
('130902', 'Chugay', '130900', '130000', NULL, NULL),
('130903', 'Cochorco', '130900', '130000', NULL, NULL),
('130904', 'Curgos', '130900', '130000', NULL, NULL),
('130905', 'Marcabal', '130900', '130000', NULL, NULL),
('130906', 'Sanagoran', '130900', '130000', NULL, NULL),
('130907', 'Sarin', '130900', '130000', NULL, NULL),
('130908', 'Sartimbamba', '130900', '130000', NULL, NULL),
('131001', 'Santiago de Chuco', '131000', '130000', NULL, NULL),
('131002', 'Angasmarca', '131000', '130000', NULL, NULL),
('131003', 'Cachicadan', '131000', '130000', NULL, NULL),
('131004', 'Mollebamba', '131000', '130000', NULL, NULL),
('131005', 'Mollepata', '131000', '130000', NULL, NULL),
('131006', 'Quiruvilca', '131000', '130000', NULL, NULL),
('131007', 'Santa Cruz de Chuca', '131000', '130000', NULL, NULL),
('131008', 'Sitabamba', '131000', '130000', NULL, NULL),
('131101', 'Cascas', '131100', '130000', NULL, NULL),
('131102', 'Lucma', '131100', '130000', NULL, NULL),
('131103', 'Marmot', '131100', '130000', NULL, NULL),
('131104', 'Sayapullo', '131100', '130000', NULL, NULL),
('131201', 'Viru', '131200', '130000', NULL, NULL),
('131202', 'Chao', '131200', '130000', NULL, NULL),
('131203', 'Guadalupito', '131200', '130000', NULL, NULL),
('140101', 'Chiclayo', '140100', '140000', NULL, NULL),
('140102', 'Chongoyape', '140100', '140000', NULL, NULL),
('140103', 'Eten', '140100', '140000', NULL, NULL),
('140104', 'Eten Puerto', '140100', '140000', NULL, NULL),
('140105', 'José Leonardo Ortiz', '140100', '140000', NULL, NULL),
('140106', 'La Victoria', '140100', '140000', NULL, NULL),
('140107', 'Lagunas', '140100', '140000', NULL, NULL),
('140108', 'Monsefu', '140100', '140000', NULL, NULL),
('140109', 'Nueva Arica', '140100', '140000', NULL, NULL),
('140110', 'Oyotun', '140100', '140000', NULL, NULL),
('140111', 'Picsi', '140100', '140000', NULL, NULL),
('140112', 'Pimentel', '140100', '140000', NULL, NULL),
('140113', 'Reque', '140100', '140000', NULL, NULL),
('140114', 'Santa Rosa', '140100', '140000', NULL, NULL),
('140115', 'Saña', '140100', '140000', NULL, NULL),
('140116', 'Cayalti', '140100', '140000', NULL, NULL),
('140117', 'Patapo', '140100', '140000', NULL, NULL),
('140118', 'Pomalca', '140100', '140000', NULL, NULL),
('140119', 'Pucala', '140100', '140000', NULL, NULL),
('140120', 'Tuman', '140100', '140000', NULL, NULL),
('140201', 'Ferreñafe', '140200', '140000', NULL, NULL),
('140202', 'Cañaris', '140200', '140000', NULL, NULL),
('140203', 'Incahuasi', '140200', '140000', NULL, NULL),
('140204', 'Manuel Antonio Mesones Muro', '140200', '140000', NULL, NULL),
('140205', 'Pitipo', '140200', '140000', NULL, NULL),
('140206', 'Pueblo Nuevo', '140200', '140000', NULL, NULL),
('140301', 'Lambayeque', '140300', '140000', NULL, NULL),
('140302', 'Chochope', '140300', '140000', NULL, NULL),
('140303', 'Illimo', '140300', '140000', NULL, NULL),
('140304', 'Jayanca', '140300', '140000', NULL, NULL),
('140305', 'Mochumi', '140300', '140000', NULL, NULL),
('140306', 'Morrope', '140300', '140000', NULL, NULL),
('140307', 'Motupe', '140300', '140000', NULL, NULL),
('140308', 'Olmos', '140300', '140000', NULL, NULL),
('140309', 'Pacora', '140300', '140000', NULL, NULL),
('140310', 'Salas', '140300', '140000', NULL, NULL),
('140311', 'San José', '140300', '140000', NULL, NULL),
('140312', 'Tucume', '140300', '140000', NULL, NULL),
('150101', 'Lima', '150100', '150000', NULL, NULL),
('150102', 'Ancón', '150100', '150000', NULL, NULL),
('150103', 'Ate', '150100', '150000', NULL, NULL),
('150104', 'Barranco', '150100', '150000', NULL, NULL),
('150105', 'Breña', '150100', '150000', NULL, NULL),
('150106', 'Carabayllo', '150100', '150000', NULL, NULL),
('150107', 'Chaclacayo', '150100', '150000', NULL, NULL),
('150108', 'Chorrillos', '150100', '150000', NULL, NULL),
('150109', 'Cieneguilla', '150100', '150000', NULL, NULL),
('150110', 'Comas', '150100', '150000', NULL, NULL),
('150111', 'El Agustino', '150100', '150000', NULL, NULL),
('150112', 'Independencia', '150100', '150000', NULL, NULL),
('150113', 'Jesús María', '150100', '150000', NULL, NULL),
('150114', 'La Molina', '150100', '150000', NULL, NULL),
('150115', 'La Victoria', '150100', '150000', NULL, NULL),
('150116', 'Lince', '150100', '150000', NULL, NULL),
('150117', 'Los Olivos', '150100', '150000', NULL, NULL),
('150118', 'Lurigancho', '150100', '150000', NULL, NULL),
('150119', 'Lurin', '150100', '150000', NULL, NULL),
('150120', 'Magdalena del Mar', '150100', '150000', NULL, NULL),
('150121', 'Pueblo Libre', '150100', '150000', NULL, NULL),
('150122', 'Miraflores', '150100', '150000', NULL, NULL),
('150123', 'Pachacamac', '150100', '150000', NULL, NULL),
('150124', 'Pucusana', '150100', '150000', NULL, NULL),
('150125', 'Puente Piedra', '150100', '150000', NULL, NULL),
('150126', 'Punta Hermosa', '150100', '150000', NULL, NULL),
('150127', 'Punta Negra', '150100', '150000', NULL, NULL),
('150128', 'Rímac', '150100', '150000', NULL, NULL),
('150129', 'San Bartolo', '150100', '150000', NULL, NULL),
('150130', 'San Borja', '150100', '150000', NULL, NULL),
('150131', 'San Isidro', '150100', '150000', NULL, NULL),
('150132', 'San Juan de Lurigancho', '150100', '150000', NULL, NULL),
('150133', 'San Juan de Miraflores', '150100', '150000', NULL, NULL),
('150134', 'San Luis', '150100', '150000', NULL, NULL),
('150135', 'San Martín de Porres', '150100', '150000', NULL, NULL),
('150136', 'San Miguel', '150100', '150000', NULL, NULL),
('150137', 'Santa Anita', '150100', '150000', NULL, NULL),
('150138', 'Santa María del Mar', '150100', '150000', NULL, NULL),
('150139', 'Santa Rosa', '150100', '150000', NULL, NULL),
('150140', 'Santiago de Surco', '150100', '150000', NULL, NULL),
('150141', 'Surquillo', '150100', '150000', NULL, NULL),
('150142', 'Villa El Salvador', '150100', '150000', NULL, NULL),
('150143', 'Villa María del Triunfo', '150100', '150000', NULL, NULL),
('150201', 'Barranca', '150200', '150000', NULL, NULL),
('150202', 'Paramonga', '150200', '150000', NULL, NULL),
('150203', 'Pativilca', '150200', '150000', NULL, NULL),
('150204', 'Supe', '150200', '150000', NULL, NULL),
('150205', 'Supe Puerto', '150200', '150000', NULL, NULL),
('150301', 'Cajatambo', '150300', '150000', NULL, NULL),
('150302', 'Copa', '150300', '150000', NULL, NULL),
('150303', 'Gorgor', '150300', '150000', NULL, NULL),
('150304', 'Huancapon', '150300', '150000', NULL, NULL),
('150305', 'Manas', '150300', '150000', NULL, NULL),
('150401', 'Canta', '150400', '150000', NULL, NULL),
('150402', 'Arahuay', '150400', '150000', NULL, NULL),
('150403', 'Huamantanga', '150400', '150000', NULL, NULL),
('150404', 'Huaros', '150400', '150000', NULL, NULL),
('150405', 'Lachaqui', '150400', '150000', NULL, NULL),
('150406', 'San Buenaventura', '150400', '150000', NULL, NULL),
('150407', 'Santa Rosa de Quives', '150400', '150000', NULL, NULL),
('150501', 'San Vicente de Cañete', '150500', '150000', NULL, NULL),
('150502', 'Asia', '150500', '150000', NULL, NULL),
('150503', 'Calango', '150500', '150000', NULL, NULL),
('150504', 'Cerro Azul', '150500', '150000', NULL, NULL),
('150505', 'Chilca', '150500', '150000', NULL, NULL),
('150506', 'Coayllo', '150500', '150000', NULL, NULL),
('150507', 'Imperial', '150500', '150000', NULL, NULL),
('150508', 'Lunahuana', '150500', '150000', NULL, NULL),
('150509', 'Mala', '150500', '150000', NULL, NULL),
('150510', 'Nuevo Imperial', '150500', '150000', NULL, NULL),
('150511', 'Pacaran', '150500', '150000', NULL, NULL),
('150512', 'Quilmana', '150500', '150000', NULL, NULL),
('150513', 'San Antonio', '150500', '150000', NULL, NULL),
('150514', 'San Luis', '150500', '150000', NULL, NULL),
('150515', 'Santa Cruz de Flores', '150500', '150000', NULL, NULL),
('150516', 'Zúñiga', '150500', '150000', NULL, NULL),
('150601', 'Huaral', '150600', '150000', NULL, NULL),
('150602', 'Atavillos Alto', '150600', '150000', NULL, NULL),
('150603', 'Atavillos Bajo', '150600', '150000', NULL, NULL),
('150604', 'Aucallama', '150600', '150000', NULL, NULL),
('150605', 'Chancay', '150600', '150000', NULL, NULL),
('150606', 'Ihuari', '150600', '150000', NULL, NULL),
('150607', 'Lampian', '150600', '150000', NULL, NULL),
('150608', 'Pacaraos', '150600', '150000', NULL, NULL),
('150609', 'San Miguel de Acos', '150600', '150000', NULL, NULL),
('150610', 'Santa Cruz de Andamarca', '150600', '150000', NULL, NULL),
('150611', 'Sumbilca', '150600', '150000', NULL, NULL),
('150612', 'Veintisiete de Noviembre', '150600', '150000', NULL, NULL),
('150701', 'Matucana', '150700', '150000', NULL, NULL),
('150702', 'Antioquia', '150700', '150000', NULL, NULL),
('150703', 'Callahuanca', '150700', '150000', NULL, NULL),
('150704', 'Carampoma', '150700', '150000', NULL, NULL),
('150705', 'Chicla', '150700', '150000', NULL, NULL),
('150706', 'Cuenca', '150700', '150000', NULL, NULL),
('150707', 'Huachupampa', '150700', '150000', NULL, NULL),
('150708', 'Huanza', '150700', '150000', NULL, NULL),
('150709', 'Huarochiri', '150700', '150000', NULL, NULL),
('150710', 'Lahuaytambo', '150700', '150000', NULL, NULL),
('150711', 'Langa', '150700', '150000', NULL, NULL),
('150712', 'Laraos', '150700', '150000', NULL, NULL),
('150713', 'Mariatana', '150700', '150000', NULL, NULL),
('150714', 'Ricardo Palma', '150700', '150000', NULL, NULL),
('150715', 'San Andrés de Tupicocha', '150700', '150000', NULL, NULL),
('150716', 'San Antonio', '150700', '150000', NULL, NULL),
('150717', 'San Bartolomé', '150700', '150000', NULL, NULL),
('150718', 'San Damian', '150700', '150000', NULL, NULL),
('150719', 'San Juan de Iris', '150700', '150000', NULL, NULL),
('150720', 'San Juan de Tantaranche', '150700', '150000', NULL, NULL),
('150721', 'San Lorenzo de Quinti', '150700', '150000', NULL, NULL),
('150722', 'San Mateo', '150700', '150000', NULL, NULL),
('150723', 'San Mateo de Otao', '150700', '150000', NULL, NULL),
('150724', 'San Pedro de Casta', '150700', '150000', NULL, NULL),
('150725', 'San Pedro de Huancayre', '150700', '150000', NULL, NULL),
('150726', 'Sangallaya', '150700', '150000', NULL, NULL),
('150727', 'Santa Cruz de Cocachacra', '150700', '150000', NULL, NULL),
('150728', 'Santa Eulalia', '150700', '150000', NULL, NULL),
('150729', 'Santiago de Anchucaya', '150700', '150000', NULL, NULL),
('150730', 'Santiago de Tuna', '150700', '150000', NULL, NULL),
('150731', 'Santo Domingo de Los Olleros', '150700', '150000', NULL, NULL),
('150732', 'Surco', '150700', '150000', NULL, NULL),
('150801', 'Huacho', '150800', '150000', NULL, NULL),
('150802', 'Ambar', '150800', '150000', NULL, NULL),
('150803', 'Caleta de Carquin', '150800', '150000', NULL, NULL),
('150804', 'Checras', '150800', '150000', NULL, NULL),
('150805', 'Hualmay', '150800', '150000', NULL, NULL),
('150806', 'Huaura', '150800', '150000', NULL, NULL),
('150807', 'Leoncio Prado', '150800', '150000', NULL, NULL),
('150808', 'Paccho', '150800', '150000', NULL, NULL),
('150809', 'Santa Leonor', '150800', '150000', NULL, NULL),
('150810', 'Santa María', '150800', '150000', NULL, NULL),
('150811', 'Sayan', '150800', '150000', NULL, NULL),
('150812', 'Vegueta', '150800', '150000', NULL, NULL),
('150901', 'Oyon', '150900', '150000', NULL, NULL),
('150902', 'Andajes', '150900', '150000', NULL, NULL),
('150903', 'Caujul', '150900', '150000', NULL, NULL),
('150904', 'Cochamarca', '150900', '150000', NULL, NULL),
('150905', 'Navan', '150900', '150000', NULL, NULL),
('150906', 'Pachangara', '150900', '150000', NULL, NULL),
('151001', 'Yauyos', '151000', '150000', NULL, NULL),
('151002', 'Alis', '151000', '150000', NULL, NULL),
('151003', 'Allauca', '151000', '150000', NULL, NULL),
('151004', 'Ayaviri', '151000', '150000', NULL, NULL),
('151005', 'Azángaro', '151000', '150000', NULL, NULL),
('151006', 'Cacra', '151000', '150000', NULL, NULL),
('151007', 'Carania', '151000', '150000', NULL, NULL),
('151008', 'Catahuasi', '151000', '150000', NULL, NULL),
('151009', 'Chocos', '151000', '150000', NULL, NULL),
('151010', 'Cochas', '151000', '150000', NULL, NULL),
('151011', 'Colonia', '151000', '150000', NULL, NULL),
('151012', 'Hongos', '151000', '150000', NULL, NULL),
('151013', 'Huampara', '151000', '150000', NULL, NULL),
('151014', 'Huancaya', '151000', '150000', NULL, NULL),
('151015', 'Huangascar', '151000', '150000', NULL, NULL),
('151016', 'Huantan', '151000', '150000', NULL, NULL),
('151017', 'Huañec', '151000', '150000', NULL, NULL),
('151018', 'Laraos', '151000', '150000', NULL, NULL),
('151019', 'Lincha', '151000', '150000', NULL, NULL),
('151020', 'Madean', '151000', '150000', NULL, NULL),
('151021', 'Miraflores', '151000', '150000', NULL, NULL),
('151022', 'Omas', '151000', '150000', NULL, NULL),
('151023', 'Putinza', '151000', '150000', NULL, NULL),
('151024', 'Quinches', '151000', '150000', NULL, NULL),
('151025', 'Quinocay', '151000', '150000', NULL, NULL),
('151026', 'San Joaquín', '151000', '150000', NULL, NULL),
('151027', 'San Pedro de Pilas', '151000', '150000', NULL, NULL),
('151028', 'Tanta', '151000', '150000', NULL, NULL),
('151029', 'Tauripampa', '151000', '150000', NULL, NULL),
('151030', 'Tomas', '151000', '150000', NULL, NULL),
('151031', 'Tupe', '151000', '150000', NULL, NULL),
('151032', 'Viñac', '151000', '150000', NULL, NULL),
('151033', 'Vitis', '151000', '150000', NULL, NULL),
('160101', 'Iquitos', '160100', '160000', NULL, NULL),
('160102', 'Alto Nanay', '160100', '160000', NULL, NULL),
('160103', 'Fernando Lores', '160100', '160000', NULL, NULL),
('160104', 'Indiana', '160100', '160000', NULL, NULL),
('160105', 'Las Amazonas', '160100', '160000', NULL, NULL),
('160106', 'Mazan', '160100', '160000', NULL, NULL),
('160107', 'Napo', '160100', '160000', NULL, NULL),
('160108', 'Punchana', '160100', '160000', NULL, NULL),
('160110', 'Torres Causana', '160100', '160000', NULL, NULL),
('160112', 'Belén', '160100', '160000', NULL, NULL),
('160113', 'San Juan Bautista', '160100', '160000', NULL, NULL),
('160201', 'Yurimaguas', '160200', '160000', NULL, NULL),
('160202', 'Balsapuerto', '160200', '160000', NULL, NULL),
('160205', 'Jeberos', '160200', '160000', NULL, NULL),
('160206', 'Lagunas', '160200', '160000', NULL, NULL),
('160210', 'Santa Cruz', '160200', '160000', NULL, NULL),
('160211', 'Teniente Cesar López Rojas', '160200', '160000', NULL, NULL),
('160301', 'Nauta', '160300', '160000', NULL, NULL),
('160302', 'Parinari', '160300', '160000', NULL, NULL),
('160303', 'Tigre', '160300', '160000', NULL, NULL),
('160304', 'Trompeteros', '160300', '160000', NULL, NULL),
('160305', 'Urarinas', '160300', '160000', NULL, NULL),
('160401', 'Ramón Castilla', '160400', '160000', NULL, NULL),
('160402', 'Pebas', '160400', '160000', NULL, NULL),
('160403', 'Yavari', '160400', '160000', NULL, NULL),
('160404', 'San Pablo', '160400', '160000', NULL, NULL),
('160501', 'Requena', '160500', '160000', NULL, NULL),
('160502', 'Alto Tapiche', '160500', '160000', NULL, NULL),
('160503', 'Capelo', '160500', '160000', NULL, NULL),
('160504', 'Emilio San Martín', '160500', '160000', NULL, NULL),
('160505', 'Maquia', '160500', '160000', NULL, NULL),
('160506', 'Puinahua', '160500', '160000', NULL, NULL),
('160507', 'Saquena', '160500', '160000', NULL, NULL),
('160508', 'Soplin', '160500', '160000', NULL, NULL),
('160509', 'Tapiche', '160500', '160000', NULL, NULL),
('160510', 'Jenaro Herrera', '160500', '160000', NULL, NULL),
('160511', 'Yaquerana', '160500', '160000', NULL, NULL),
('160601', 'Contamana', '160600', '160000', NULL, NULL),
('160602', 'Inahuaya', '160600', '160000', NULL, NULL),
('160603', 'Padre Márquez', '160600', '160000', NULL, NULL),
('160604', 'Pampa Hermosa', '160600', '160000', NULL, NULL),
('160605', 'Sarayacu', '160600', '160000', NULL, NULL),
('160606', 'Vargas Guerra', '160600', '160000', NULL, NULL),
('160701', 'Barranca', '160700', '160000', NULL, NULL),
('160702', 'Cahuapanas', '160700', '160000', NULL, NULL),
('160703', 'Manseriche', '160700', '160000', NULL, NULL),
('160704', 'Morona', '160700', '160000', NULL, NULL),
('160705', 'Pastaza', '160700', '160000', NULL, NULL),
('160706', 'Andoas', '160700', '160000', NULL, NULL),
('160801', 'Putumayo', '160800', '160000', NULL, NULL),
('160802', 'Rosa Panduro', '160800', '160000', NULL, NULL),
('160803', 'Teniente Manuel Clavero', '160800', '160000', NULL, NULL),
('160804', 'Yaguas', '160800', '160000', NULL, NULL),
('170101', 'Tambopata', '170100', '170000', NULL, NULL),
('170102', 'Inambari', '170100', '170000', NULL, NULL),
('170103', 'Las Piedras', '170100', '170000', NULL, NULL),
('170104', 'Laberinto', '170100', '170000', NULL, NULL),
('170201', 'Manu', '170200', '170000', NULL, NULL),
('170202', 'Fitzcarrald', '170200', '170000', NULL, NULL),
('170203', 'Madre de Dios', '170200', '170000', NULL, NULL),
('170204', 'Huepetuhe', '170200', '170000', NULL, NULL),
('170301', 'Iñapari', '170300', '170000', NULL, NULL),
('170302', 'Iberia', '170300', '170000', NULL, NULL),
('170303', 'Tahuamanu', '170300', '170000', NULL, NULL),
('180101', 'Moquegua', '180100', '180000', NULL, NULL),
('180102', 'Carumas', '180100', '180000', NULL, NULL),
('180103', 'Cuchumbaya', '180100', '180000', NULL, NULL),
('180104', 'Samegua', '180100', '180000', NULL, NULL),
('180105', 'San Cristóbal', '180100', '180000', NULL, NULL),
('180106', 'Torata', '180100', '180000', NULL, NULL),
('180201', 'Omate', '180200', '180000', NULL, NULL),
('180202', 'Chojata', '180200', '180000', NULL, NULL),
('180203', 'Coalaque', '180200', '180000', NULL, NULL),
('180204', 'Ichuña', '180200', '180000', NULL, NULL),
('180205', 'La Capilla', '180200', '180000', NULL, NULL),
('180206', 'Lloque', '180200', '180000', NULL, NULL),
('180207', 'Matalaque', '180200', '180000', NULL, NULL),
('180208', 'Puquina', '180200', '180000', NULL, NULL),
('180209', 'Quinistaquillas', '180200', '180000', NULL, NULL),
('180210', 'Ubinas', '180200', '180000', NULL, NULL),
('180211', 'Yunga', '180200', '180000', NULL, NULL),
('180301', 'Ilo', '180300', '180000', NULL, NULL),
('180302', 'El Algarrobal', '180300', '180000', NULL, NULL),
('180303', 'Pacocha', '180300', '180000', NULL, NULL),
('190101', 'Chaupimarca', '190100', '190000', NULL, NULL),
('190102', 'Huachon', '190100', '190000', NULL, NULL),
('190103', 'Huariaca', '190100', '190000', NULL, NULL),
('190104', 'Huayllay', '190100', '190000', NULL, NULL),
('190105', 'Ninacaca', '190100', '190000', NULL, NULL),
('190106', 'Pallanchacra', '190100', '190000', NULL, NULL),
('190107', 'Paucartambo', '190100', '190000', NULL, NULL),
('190108', 'San Francisco de Asís de Yarusyacan', '190100', '190000', NULL, NULL),
('190109', 'Simon Bolívar', '190100', '190000', NULL, NULL),
('190110', 'Ticlacayan', '190100', '190000', NULL, NULL),
('190111', 'Tinyahuarco', '190100', '190000', NULL, NULL),
('190112', 'Vicco', '190100', '190000', NULL, NULL),
('190113', 'Yanacancha', '190100', '190000', NULL, NULL),
('190201', 'Yanahuanca', '190200', '190000', NULL, NULL),
('190202', 'Chacayan', '190200', '190000', NULL, NULL),
('190203', 'Goyllarisquizga', '190200', '190000', NULL, NULL),
('190204', 'Paucar', '190200', '190000', NULL, NULL),
('190205', 'San Pedro de Pillao', '190200', '190000', NULL, NULL),
('190206', 'Santa Ana de Tusi', '190200', '190000', NULL, NULL),
('190207', 'Tapuc', '190200', '190000', NULL, NULL),
('190208', 'Vilcabamba', '190200', '190000', NULL, NULL),
('190301', 'Oxapampa', '190300', '190000', NULL, NULL),
('190302', 'Chontabamba', '190300', '190000', NULL, NULL),
('190303', 'Huancabamba', '190300', '190000', NULL, NULL),
('190304', 'Palcazu', '190300', '190000', NULL, NULL),
('190305', 'Pozuzo', '190300', '190000', NULL, NULL),
('190306', 'Puerto Bermúdez', '190300', '190000', NULL, NULL),
('190307', 'Villa Rica', '190300', '190000', NULL, NULL),
('190308', 'Constitución', '190300', '190000', NULL, NULL),
('200101', 'Piura', '200100', '200000', NULL, NULL),
('200104', 'Castilla', '200100', '200000', NULL, NULL),
('200105', 'Catacaos', '200100', '200000', NULL, NULL),
('200107', 'Cura Mori', '200100', '200000', NULL, NULL),
('200108', 'El Tallan', '200100', '200000', NULL, NULL),
('200109', 'La Arena', '200100', '200000', NULL, NULL),
('200110', 'La Unión', '200100', '200000', NULL, NULL),
('200111', 'Las Lomas', '200100', '200000', NULL, NULL),
('200114', 'Tambo Grande', '200100', '200000', NULL, NULL),
('200115', 'Veintiseis de Octubre', '200100', '200000', NULL, NULL),
('200201', 'Ayabaca', '200200', '200000', NULL, NULL),
('200202', 'Frias', '200200', '200000', NULL, NULL),
('200203', 'Jilili', '200200', '200000', NULL, NULL),
('200204', 'Lagunas', '200200', '200000', NULL, NULL),
('200205', 'Montero', '200200', '200000', NULL, NULL),
('200206', 'Pacaipampa', '200200', '200000', NULL, NULL),
('200207', 'Paimas', '200200', '200000', NULL, NULL),
('200208', 'Sapillica', '200200', '200000', NULL, NULL),
('200209', 'Sicchez', '200200', '200000', NULL, NULL),
('200210', 'Suyo', '200200', '200000', NULL, NULL),
('200301', 'Huancabamba', '200300', '200000', NULL, NULL),
('200302', 'Canchaque', '200300', '200000', NULL, NULL),
('200303', 'El Carmen de la Frontera', '200300', '200000', NULL, NULL),
('200304', 'Huarmaca', '200300', '200000', NULL, NULL),
('200305', 'Lalaquiz', '200300', '200000', NULL, NULL),
('200306', 'San Miguel de El Faique', '200300', '200000', NULL, NULL),
('200307', 'Sondor', '200300', '200000', NULL, NULL),
('200308', 'Sondorillo', '200300', '200000', NULL, NULL),
('200401', 'Chulucanas', '200400', '200000', NULL, NULL),
('200402', 'Buenos Aires', '200400', '200000', NULL, NULL),
('200403', 'Chalaco', '200400', '200000', NULL, NULL),
('200404', 'La Matanza', '200400', '200000', NULL, NULL),
('200405', 'Morropon', '200400', '200000', NULL, NULL),
('200406', 'Salitral', '200400', '200000', NULL, NULL),
('200407', 'San Juan de Bigote', '200400', '200000', NULL, NULL),
('200408', 'Santa Catalina de Mossa', '200400', '200000', NULL, NULL),
('200409', 'Santo Domingo', '200400', '200000', NULL, NULL),
('200410', 'Yamango', '200400', '200000', NULL, NULL),
('200501', 'Paita', '200500', '200000', NULL, NULL),
('200502', 'Amotape', '200500', '200000', NULL, NULL),
('200503', 'Arenal', '200500', '200000', NULL, NULL),
('200504', 'Colan', '200500', '200000', NULL, NULL),
('200505', 'La Huaca', '200500', '200000', NULL, NULL),
('200506', 'Tamarindo', '200500', '200000', NULL, NULL),
('200507', 'Vichayal', '200500', '200000', NULL, NULL),
('200601', 'Sullana', '200600', '200000', NULL, NULL),
('200602', 'Bellavista', '200600', '200000', NULL, NULL),
('200603', 'Ignacio Escudero', '200600', '200000', NULL, NULL),
('200604', 'Lancones', '200600', '200000', NULL, NULL),
('200605', 'Marcavelica', '200600', '200000', NULL, NULL),
('200606', 'Miguel Checa', '200600', '200000', NULL, NULL),
('200607', 'Querecotillo', '200600', '200000', NULL, NULL),
('200608', 'Salitral', '200600', '200000', NULL, NULL),
('200701', 'Pariñas', '200700', '200000', NULL, NULL),
('200702', 'El Alto', '200700', '200000', NULL, NULL),
('200703', 'La Brea', '200700', '200000', NULL, NULL),
('200704', 'Lobitos', '200700', '200000', NULL, NULL),
('200705', 'Los Organos', '200700', '200000', NULL, NULL),
('200706', 'Mancora', '200700', '200000', NULL, NULL),
('200801', 'Sechura', '200800', '200000', NULL, NULL),
('200802', 'Bellavista de la Unión', '200800', '200000', NULL, NULL),
('200803', 'Bernal', '200800', '200000', NULL, NULL),
('200804', 'Cristo Nos Valga', '200800', '200000', NULL, NULL),
('200805', 'Vice', '200800', '200000', NULL, NULL),
('200806', 'Rinconada Llicuar', '200800', '200000', NULL, NULL),
('210101', 'Puno', '210100', '210000', NULL, NULL),
('210102', 'Acora', '210100', '210000', NULL, NULL),
('210103', 'Amantani', '210100', '210000', NULL, NULL),
('210104', 'Atuncolla', '210100', '210000', NULL, NULL),
('210105', 'Capachica', '210100', '210000', NULL, NULL),
('210106', 'Chucuito', '210100', '210000', NULL, NULL),
('210107', 'Coata', '210100', '210000', NULL, NULL),
('210108', 'Huata', '210100', '210000', NULL, NULL),
('210109', 'Mañazo', '210100', '210000', NULL, NULL),
('210110', 'Paucarcolla', '210100', '210000', NULL, NULL),
('210111', 'Pichacani', '210100', '210000', NULL, NULL),
('210112', 'Plateria', '210100', '210000', NULL, NULL),
('210113', 'San Antonio', '210100', '210000', NULL, NULL),
('210114', 'Tiquillaca', '210100', '210000', NULL, NULL),
('210115', 'Vilque', '210100', '210000', NULL, NULL),
('210201', 'Azángaro', '210200', '210000', NULL, NULL),
('210202', 'Achaya', '210200', '210000', NULL, NULL),
('210203', 'Arapa', '210200', '210000', NULL, NULL),
('210204', 'Asillo', '210200', '210000', NULL, NULL),
('210205', 'Caminaca', '210200', '210000', NULL, NULL),
('210206', 'Chupa', '210200', '210000', NULL, NULL),
('210207', 'José Domingo Choquehuanca', '210200', '210000', NULL, NULL),
('210208', 'Muñani', '210200', '210000', NULL, NULL),
('210209', 'Potoni', '210200', '210000', NULL, NULL),
('210210', 'Saman', '210200', '210000', NULL, NULL),
('210211', 'San Anton', '210200', '210000', NULL, NULL),
('210212', 'San José', '210200', '210000', NULL, NULL),
('210213', 'San Juan de Salinas', '210200', '210000', NULL, NULL),
('210214', 'Santiago de Pupuja', '210200', '210000', NULL, NULL),
('210215', 'Tirapata', '210200', '210000', NULL, NULL),
('210301', 'Macusani', '210300', '210000', NULL, NULL),
('210302', 'Ajoyani', '210300', '210000', NULL, NULL),
('210303', 'Ayapata', '210300', '210000', NULL, NULL),
('210304', 'Coasa', '210300', '210000', NULL, NULL),
('210305', 'Corani', '210300', '210000', NULL, NULL),
('210306', 'Crucero', '210300', '210000', NULL, NULL),
('210307', 'Ituata', '210300', '210000', NULL, NULL),
('210308', 'Ollachea', '210300', '210000', NULL, NULL),
('210309', 'San Gaban', '210300', '210000', NULL, NULL),
('210310', 'Usicayos', '210300', '210000', NULL, NULL),
('210401', 'Juli', '210400', '210000', NULL, NULL),
('210402', 'Desaguadero', '210400', '210000', NULL, NULL),
('210403', 'Huacullani', '210400', '210000', NULL, NULL),
('210404', 'Kelluyo', '210400', '210000', NULL, NULL),
('210405', 'Pisacoma', '210400', '210000', NULL, NULL),
('210406', 'Pomata', '210400', '210000', NULL, NULL),
('210407', 'Zepita', '210400', '210000', NULL, NULL),
('210501', 'Ilave', '210500', '210000', NULL, NULL),
('210502', 'Capazo', '210500', '210000', NULL, NULL),
('210503', 'Pilcuyo', '210500', '210000', NULL, NULL),
('210504', 'Santa Rosa', '210500', '210000', NULL, NULL),
('210505', 'Conduriri', '210500', '210000', NULL, NULL),
('210601', 'Huancane', '210600', '210000', NULL, NULL),
('210602', 'Cojata', '210600', '210000', NULL, NULL),
('210603', 'Huatasani', '210600', '210000', NULL, NULL),
('210604', 'Inchupalla', '210600', '210000', NULL, NULL),
('210605', 'Pusi', '210600', '210000', NULL, NULL),
('210606', 'Rosaspata', '210600', '210000', NULL, NULL),
('210607', 'Taraco', '210600', '210000', NULL, NULL),
('210608', 'Vilque Chico', '210600', '210000', NULL, NULL),
('210701', 'Lampa', '210700', '210000', NULL, NULL),
('210702', 'Cabanilla', '210700', '210000', NULL, NULL),
('210703', 'Calapuja', '210700', '210000', NULL, NULL),
('210704', 'Nicasio', '210700', '210000', NULL, NULL),
('210705', 'Ocuviri', '210700', '210000', NULL, NULL),
('210706', 'Palca', '210700', '210000', NULL, NULL),
('210707', 'Paratia', '210700', '210000', NULL, NULL),
('210708', 'Pucara', '210700', '210000', NULL, NULL),
('210709', 'Santa Lucia', '210700', '210000', NULL, NULL),
('210710', 'Vilavila', '210700', '210000', NULL, NULL),
('210801', 'Ayaviri', '210800', '210000', NULL, NULL),
('210802', 'Antauta', '210800', '210000', NULL, NULL),
('210803', 'Cupi', '210800', '210000', NULL, NULL),
('210804', 'Llalli', '210800', '210000', NULL, NULL),
('210805', 'Macari', '210800', '210000', NULL, NULL),
('210806', 'Nuñoa', '210800', '210000', NULL, NULL),
('210807', 'Orurillo', '210800', '210000', NULL, NULL),
('210808', 'Santa Rosa', '210800', '210000', NULL, NULL),
('210809', 'Umachiri', '210800', '210000', NULL, NULL),
('210901', 'Moho', '210900', '210000', NULL, NULL),
('210902', 'Conima', '210900', '210000', NULL, NULL),
('210903', 'Huayrapata', '210900', '210000', NULL, NULL),
('210904', 'Tilali', '210900', '210000', NULL, NULL),
('211001', 'Putina', '211000', '210000', NULL, NULL),
('211002', 'Ananea', '211000', '210000', NULL, NULL),
('211003', 'Pedro Vilca Apaza', '211000', '210000', NULL, NULL),
('211004', 'Quilcapuncu', '211000', '210000', NULL, NULL),
('211005', 'Sina', '211000', '210000', NULL, NULL),
('211101', 'Juliaca', '211100', '210000', NULL, NULL),
('211102', 'Cabana', '211100', '210000', NULL, NULL),
('211103', 'Cabanillas', '211100', '210000', NULL, NULL),
('211104', 'Caracoto', '211100', '210000', NULL, NULL),
('211105', 'San Miguel', '211100', '210000', NULL, NULL),
('211201', 'Sandia', '211200', '210000', NULL, NULL),
('211202', 'Cuyocuyo', '211200', '210000', NULL, NULL),
('211203', 'Limbani', '211200', '210000', NULL, NULL),
('211204', 'Patambuco', '211200', '210000', NULL, NULL),
('211205', 'Phara', '211200', '210000', NULL, NULL),
('211206', 'Quiaca', '211200', '210000', NULL, NULL),
('211207', 'San Juan del Oro', '211200', '210000', NULL, NULL),
('211208', 'Yanahuaya', '211200', '210000', NULL, NULL),
('211209', 'Alto Inambari', '211200', '210000', NULL, NULL),
('211210', 'San Pedro de Putina Punco', '211200', '210000', NULL, NULL),
('211301', 'Yunguyo', '211300', '210000', NULL, NULL),
('211302', 'Anapia', '211300', '210000', NULL, NULL),
('211303', 'Copani', '211300', '210000', NULL, NULL),
('211304', 'Cuturapi', '211300', '210000', NULL, NULL),
('211305', 'Ollaraya', '211300', '210000', NULL, NULL),
('211306', 'Tinicachi', '211300', '210000', NULL, NULL),
('211307', 'Unicachi', '211300', '210000', NULL, NULL),
('220101', 'Moyobamba', '220100', '220000', NULL, NULL),
('220102', 'Calzada', '220100', '220000', NULL, NULL),
('220103', 'Habana', '220100', '220000', NULL, NULL),
('220104', 'Jepelacio', '220100', '220000', NULL, NULL),
('220105', 'Soritor', '220100', '220000', NULL, NULL),
('220106', 'Yantalo', '220100', '220000', NULL, NULL),
('220201', 'Bellavista', '220200', '220000', NULL, NULL),
('220202', 'Alto Biavo', '220200', '220000', NULL, NULL),
('220203', 'Bajo Biavo', '220200', '220000', NULL, NULL),
('220204', 'Huallaga', '220200', '220000', NULL, NULL),
('220205', 'San Pablo', '220200', '220000', NULL, NULL),
('220206', 'San Rafael', '220200', '220000', NULL, NULL),
('220301', 'San José de Sisa', '220300', '220000', NULL, NULL),
('220302', 'Agua Blanca', '220300', '220000', NULL, NULL),
('220303', 'San Martín', '220300', '220000', NULL, NULL),
('220304', 'Santa Rosa', '220300', '220000', NULL, NULL),
('220305', 'Shatoja', '220300', '220000', NULL, NULL),
('220401', 'Saposoa', '220400', '220000', NULL, NULL),
('220402', 'Alto Saposoa', '220400', '220000', NULL, NULL),
('220403', 'El Eslabón', '220400', '220000', NULL, NULL),
('220404', 'Piscoyacu', '220400', '220000', NULL, NULL),
('220405', 'Sacanche', '220400', '220000', NULL, NULL),
('220406', 'Tingo de Saposoa', '220400', '220000', NULL, NULL),
('220501', 'Lamas', '220500', '220000', NULL, NULL),
('220502', 'Alonso de Alvarado', '220500', '220000', NULL, NULL),
('220503', 'Barranquita', '220500', '220000', NULL, NULL),
('220504', 'Caynarachi', '220500', '220000', NULL, NULL),
('220505', 'Cuñumbuqui', '220500', '220000', NULL, NULL),
('220506', 'Pinto Recodo', '220500', '220000', NULL, NULL),
('220507', 'Rumisapa', '220500', '220000', NULL, NULL),
('220508', 'San Roque de Cumbaza', '220500', '220000', NULL, NULL),
('220509', 'Shanao', '220500', '220000', NULL, NULL),
('220510', 'Tabalosos', '220500', '220000', NULL, NULL),
('220511', 'Zapatero', '220500', '220000', NULL, NULL),
('220601', 'Juanjuí', '220600', '220000', NULL, NULL),
('220602', 'Campanilla', '220600', '220000', NULL, NULL),
('220603', 'Huicungo', '220600', '220000', NULL, NULL),
('220604', 'Pachiza', '220600', '220000', NULL, NULL),
('220605', 'Pajarillo', '220600', '220000', NULL, NULL),
('220701', 'Picota', '220700', '220000', NULL, NULL),
('220702', 'Buenos Aires', '220700', '220000', NULL, NULL),
('220703', 'Caspisapa', '220700', '220000', NULL, NULL),
('220704', 'Pilluana', '220700', '220000', NULL, NULL),
('220705', 'Pucacaca', '220700', '220000', NULL, NULL),
('220706', 'San Cristóbal', '220700', '220000', NULL, NULL),
('220707', 'San Hilarión', '220700', '220000', NULL, NULL),
('220708', 'Shamboyacu', '220700', '220000', NULL, NULL),
('220709', 'Tingo de Ponasa', '220700', '220000', NULL, NULL),
('220710', 'Tres Unidos', '220700', '220000', NULL, NULL),
('220801', 'Rioja', '220800', '220000', NULL, NULL),
('220802', 'Awajun', '220800', '220000', NULL, NULL),
('220803', 'Elías Soplin Vargas', '220800', '220000', NULL, NULL),
('220804', 'Nueva Cajamarca', '220800', '220000', NULL, NULL),
('220805', 'Pardo Miguel', '220800', '220000', NULL, NULL),
('220806', 'Posic', '220800', '220000', NULL, NULL),
('220807', 'San Fernando', '220800', '220000', NULL, NULL),
('220808', 'Yorongos', '220800', '220000', NULL, NULL),
('220809', 'Yuracyacu', '220800', '220000', NULL, NULL),
('220901', 'Tarapoto', '220900', '220000', NULL, NULL),
('220902', 'Alberto Leveau', '220900', '220000', NULL, NULL),
('220903', 'Cacatachi', '220900', '220000', NULL, NULL),
('220904', 'Chazuta', '220900', '220000', NULL, NULL),
('220905', 'Chipurana', '220900', '220000', NULL, NULL),
('220906', 'El Porvenir', '220900', '220000', NULL, NULL),
('220907', 'Huimbayoc', '220900', '220000', NULL, NULL),
('220908', 'Juan Guerra', '220900', '220000', NULL, NULL);
INSERT INTO `info_distritos` (`id`, `name`, `region_id`, `province_id`, `created_at`, `updated_at`) VALUES
('220909', 'La Banda de Shilcayo', '220900', '220000', NULL, NULL),
('220910', 'Morales', '220900', '220000', NULL, NULL),
('220911', 'Papaplaya', '220900', '220000', NULL, NULL),
('220912', 'San Antonio', '220900', '220000', NULL, NULL),
('220913', 'Sauce', '220900', '220000', NULL, NULL),
('220914', 'Shapaja', '220900', '220000', NULL, NULL),
('221001', 'Tocache', '221000', '220000', NULL, NULL),
('221002', 'Nuevo Progreso', '221000', '220000', NULL, NULL),
('221003', 'Polvora', '221000', '220000', NULL, NULL),
('221004', 'Shunte', '221000', '220000', NULL, NULL),
('221005', 'Uchiza', '221000', '220000', NULL, NULL),
('230101', 'Tacna', '230100', '230000', NULL, NULL),
('230102', 'Alto de la Alianza', '230100', '230000', NULL, NULL),
('230103', 'Calana', '230100', '230000', NULL, NULL),
('230104', 'Ciudad Nueva', '230100', '230000', NULL, NULL),
('230105', 'Inclan', '230100', '230000', NULL, NULL),
('230106', 'Pachia', '230100', '230000', NULL, NULL),
('230107', 'Palca', '230100', '230000', NULL, NULL),
('230108', 'Pocollay', '230100', '230000', NULL, NULL),
('230109', 'Sama', '230100', '230000', NULL, NULL),
('230110', 'Coronel Gregorio Albarracín Lanchipa', '230100', '230000', NULL, NULL),
('230111', 'La Yarada los Palos', '230100', '230000', NULL, NULL),
('230201', 'Candarave', '230200', '230000', NULL, NULL),
('230202', 'Cairani', '230200', '230000', NULL, NULL),
('230203', 'Camilaca', '230200', '230000', NULL, NULL),
('230204', 'Curibaya', '230200', '230000', NULL, NULL),
('230205', 'Huanuara', '230200', '230000', NULL, NULL),
('230206', 'Quilahuani', '230200', '230000', NULL, NULL),
('230301', 'Locumba', '230300', '230000', NULL, NULL),
('230302', 'Ilabaya', '230300', '230000', NULL, NULL),
('230303', 'Ite', '230300', '230000', NULL, NULL),
('230401', 'Tarata', '230400', '230000', NULL, NULL),
('230402', 'Héroes Albarracín', '230400', '230000', NULL, NULL),
('230403', 'Estique', '230400', '230000', NULL, NULL),
('230404', 'Estique-Pampa', '230400', '230000', NULL, NULL),
('230405', 'Sitajara', '230400', '230000', NULL, NULL),
('230406', 'Susapaya', '230400', '230000', NULL, NULL),
('230407', 'Tarucachi', '230400', '230000', NULL, NULL),
('230408', 'Ticaco', '230400', '230000', NULL, NULL),
('240101', 'Tumbes', '240100', '240000', NULL, NULL),
('240102', 'Corrales', '240100', '240000', NULL, NULL),
('240103', 'La Cruz', '240100', '240000', NULL, NULL),
('240104', 'Pampas de Hospital', '240100', '240000', NULL, NULL),
('240105', 'San Jacinto', '240100', '240000', NULL, NULL),
('240106', 'San Juan de la Virgen', '240100', '240000', NULL, NULL),
('240201', 'Zorritos', '240200', '240000', NULL, NULL),
('240202', 'Casitas', '240200', '240000', NULL, NULL),
('240203', 'Canoas de Punta Sal', '240200', '240000', NULL, NULL),
('240301', 'Zarumilla', '240300', '240000', NULL, NULL),
('240302', 'Aguas Verdes', '240300', '240000', NULL, NULL),
('240303', 'Matapalo', '240300', '240000', NULL, NULL),
('240304', 'Papayal', '240300', '240000', NULL, NULL),
('250101', 'Calleria', '250100', '250000', NULL, NULL),
('250102', 'Campoverde', '250100', '250000', NULL, NULL),
('250103', 'Iparia', '250100', '250000', NULL, NULL),
('250104', 'Masisea', '250100', '250000', NULL, NULL),
('250105', 'Yarinacocha', '250100', '250000', NULL, NULL),
('250106', 'Nueva Requena', '250100', '250000', NULL, NULL),
('250107', 'Manantay', '250100', '250000', NULL, NULL),
('250201', 'Raymondi', '250200', '250000', NULL, NULL),
('250202', 'Sepahua', '250200', '250000', NULL, NULL),
('250203', 'Tahuania', '250200', '250000', NULL, NULL),
('250204', 'Yurua', '250200', '250000', NULL, NULL),
('250301', 'Padre Abad', '250300', '250000', NULL, NULL),
('250302', 'Irazola', '250300', '250000', NULL, NULL),
('250303', 'Curimana', '250300', '250000', NULL, NULL),
('250304', 'Neshuya', '250300', '250000', NULL, NULL),
('250305', 'Alexander Von Humboldt', '250300', '250000', NULL, NULL),
('250401', 'Purús', '250400', '250000', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_documentos`
--

CREATE TABLE `info_documentos` (
  `id` int(11) NOT NULL,
  `documento` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `info_documentos`
--

INSERT INTO `info_documentos` (`id`, `documento`) VALUES
(1, 'Oficio'),
(2, 'Solicitud'),
(3, 'Orden Telefónica'),
(4, 'Parte'),
(5, 'Virtual'),
(6, 'Acta Intervención'),
(7, 'Hoja Tramite'),
(8, 'Informe');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_entidad`
--

CREATE TABLE `info_entidad` (
  `id` int(11) NOT NULL,
  `entidad` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `info_entidad`
--

INSERT INTO `info_entidad` (`id`, `entidad`) VALUES
(1, 'Fiscalia'),
(2, 'Directa'),
(3, 'Policía Nacional');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_modalidad`
--

CREATE TABLE `info_modalidad` (
  `id` int(11) NOT NULL,
  `delitos_id` int(11) NOT NULL,
  `modalidad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `info_modalidad`
--

INSERT INTO `info_modalidad` (`id`, `delitos_id`, `modalidad`) VALUES
(1, 5, 'Hurto'),
(2, 5, 'Robo'),
(3, 5, 'Abigeato'),
(4, 5, 'Apropiación Ilícita'),
(5, 5, 'Receptación'),
(6, 5, 'Estafas Y Otras Defraudaciones'),
(7, 5, 'Fraude En La AdmistracióN De Personas Jurídicas'),
(8, 5, 'Extorsión'),
(9, 5, 'Usurpación'),
(10, 5, 'Daños al Patrimonio'),
(11, 5, 'Delitos Informáticos'),
(12, 5, 'Chantaje'),
(13, 4, 'Violacion Libertad Personal'),
(14, 4, 'Violación De La Intimidad'),
(15, 4, 'Violación De Domicilio'),
(16, 4, 'Violación Del Secreto De Las Comunicaciones'),
(17, 4, 'Violación Del Secreto Profesional'),
(18, 4, 'Violación De La Libertad De Reunión'),
(19, 4, 'Violación De La Libertad De Trabajo'),
(20, 4, 'Violación De La Libertad De Expresión'),
(21, 4, 'Violación Libertad Sexual'),
(22, 4, 'Proxenetismo'),
(23, 4, 'Ofensas Al Pudor Público'),
(24, 1, 'Homicidio'),
(25, 1, 'Aborto'),
(26, 1, 'Lesiones'),
(27, 1, 'Exposición al Peligro o Abandono De Personas En Peligro'),
(28, 2, 'Injuria'),
(29, 2, 'Calumnia'),
(30, 2, 'Difamación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_monedas`
--

CREATE TABLE `info_monedas` (
  `id` int(11) NOT NULL,
  `moneda` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `info_monedas`
--

INSERT INTO `info_monedas` (`id`, `moneda`, `created_at`, `updated_at`) VALUES
(1, 'Soles', '2021-10-15 13:52:38', NULL),
(2, 'Dolares', '2021-10-15 13:52:38', NULL),
(3, 'Euros', '2021-10-15 13:52:44', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_operadoras`
--

CREATE TABLE `info_operadoras` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `info_operadoras`
--

INSERT INTO `info_operadoras` (`id`, `name`) VALUES
(1, 'Telefónica del Perú'),
(2, 'América Móvil (Claro Perú)'),
(3, 'Entel'),
(4, 'Bitel');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_paises`
--

CREATE TABLE `info_paises` (
  `id` int(10) NOT NULL,
  `pais` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `info_paises`
--

INSERT INTO `info_paises` (`id`, `pais`) VALUES
(1, 'Afganistán'),
(3, 'Albania'),
(4, 'Alemania'),
(5, 'Andorra'),
(6, 'Angola'),
(7, 'Antigua y Barbuda'),
(8, 'Arabia Saudita'),
(9, 'Argelia'),
(10, 'Argentina'),
(11, 'Armenia'),
(12, 'Australia'),
(13, 'Austria'),
(14, 'Azerbaiyán'),
(15, 'Bahamas'),
(16, 'Bangladés'),
(17, 'Barbados'),
(18, 'Baréin'),
(19, 'Bélgica'),
(20, 'Belice'),
(21, 'Benín'),
(22, 'Bielorrusia'),
(23, 'Birmania'),
(24, 'Bolivia'),
(25, 'Bosnia-Herzegovina'),
(26, 'Botsuana'),
(27, 'Brasil'),
(28, 'Brunéi'),
(29, 'Bulgaria'),
(30, 'Burkina Faso'),
(31, 'Burundi'),
(32, 'Bután'),
(33, 'Cabo Verde'),
(34, 'Camboya'),
(35, 'Camerún'),
(36, 'Canadá'),
(37, 'Catar'),
(38, 'Chad'),
(39, 'Chile'),
(40, 'China'),
(41, 'Chipre'),
(42, 'Colombia'),
(43, 'Comoras'),
(44, 'Congo'),
(45, 'Corea del Norte'),
(46, 'Corea del Sur'),
(47, 'Costa de Marfil'),
(48, 'Costa Rica'),
(49, 'Croacia'),
(50, 'Cuba'),
(51, 'Dinamarca'),
(52, 'Dominica'),
(53, 'Ecuador'),
(54, 'Egipto'),
(55, 'El Salvador'),
(56, 'Emiratos Árabes Unidos'),
(57, 'Eritrea'),
(58, 'Eslovaquia'),
(59, 'Eslovenia'),
(60, 'España'),
(61, 'Estados Unidos'),
(62, 'Estonia'),
(63, 'Etiopía'),
(64, 'Filipinas'),
(65, 'Finlandia'),
(66, 'Fiyi'),
(67, 'Francia'),
(68, 'Gabón'),
(69, 'Gambia'),
(70, 'Georgia'),
(71, 'Ghana'),
(72, 'Granada'),
(73, 'Grecia'),
(74, 'Guatemala'),
(75, 'Guinea'),
(76, 'Guinea Ecuatorial'),
(77, 'Guinea-Bisáu'),
(78, 'Guyana'),
(79, 'Haití'),
(80, 'Honduras'),
(81, 'Hungría'),
(82, 'India'),
(83, 'Indonesia'),
(84, 'Irak'),
(85, 'Irán'),
(86, 'Irlanda'),
(87, 'Islandia'),
(88, 'Islas Marshall'),
(89, 'Islas Salomón'),
(90, 'Israel'),
(91, 'Italia'),
(92, 'Jamaica'),
(93, 'Japón'),
(94, 'Jordania'),
(95, 'Kazajistán'),
(96, 'Kenia'),
(97, 'Kirguistán'),
(98, 'Kiribati'),
(99, 'Kosovo'),
(100, 'Kuwait'),
(101, 'Laos'),
(102, 'Lesoto'),
(103, 'Letonia'),
(104, 'Líbano'),
(105, 'Liberia'),
(106, 'Libia'),
(107, 'Liechtenstein'),
(108, 'Lituania'),
(109, 'Luxemburgo'),
(110, 'Macedonia'),
(111, 'Madagascar'),
(112, 'Malasia'),
(113, 'Malaui'),
(114, 'Maldivas'),
(115, 'Malí'),
(116, 'Malta'),
(117, 'Marruecos'),
(118, 'Mauricio'),
(119, 'Mauritania'),
(120, 'México'),
(121, 'Micronesia'),
(122, 'Moldavia'),
(123, 'Mónaco'),
(124, 'Mongolia'),
(125, 'Montenegro'),
(126, 'Mozambique'),
(127, 'Namibia'),
(128, 'Nauru'),
(129, 'Nepal'),
(130, 'Nicaragua'),
(131, 'Níger'),
(132, 'Nigeria'),
(133, 'Noruega'),
(134, 'Nueva Zelanda'),
(135, 'Omán'),
(136, 'Países Bajos'),
(137, 'Pakistán'),
(138, 'Palaos'),
(139, 'Palestina'),
(140, 'Panamá'),
(141, 'Papúa Nueva Guinea'),
(142, 'Paraguay'),
(143, 'Perú'),
(144, 'Polonia'),
(145, 'Portugal'),
(146, 'Reino Unido'),
(147, 'República Centroafricana'),
(148, 'República Checa'),
(149, 'República Democrática del Congo'),
(150, 'República Dominicana'),
(151, 'Ruanda'),
(152, 'Rumania'),
(153, 'Rusia'),
(154, 'Samoa'),
(155, 'San Cristóbal y Nieves'),
(156, 'San Marino'),
(157, 'San Vicente y las Granadinas'),
(158, 'Santa Lucía'),
(159, 'Santo Tomé y Príncipe'),
(160, 'Senegal'),
(161, 'Serbia'),
(162, 'Seychelles'),
(163, 'Sierra Leona'),
(164, 'Singapur'),
(165, 'Siria'),
(166, 'Somalia'),
(167, 'Sri Lanka'),
(168, 'Suazilandia'),
(169, 'Sudáfrica'),
(170, 'Sudán'),
(171, 'Sudán del Sur'),
(172, 'Suecia'),
(173, 'Suiza'),
(174, 'Surinam'),
(175, 'Tailandia'),
(176, 'Taiwán'),
(177, 'Tanzania'),
(178, 'Tayikistán'),
(179, 'Timor Oriental'),
(180, 'Togo'),
(181, 'Tonga'),
(182, 'Trinidad y Tobago'),
(183, 'Túnez'),
(184, 'Turkmenistán'),
(185, 'Turquía'),
(186, 'Tuvalu'),
(187, 'Ucrania'),
(188, 'Uganda'),
(189, 'Uruguay'),
(190, 'Uzbekistán'),
(191, 'Vanuatu'),
(192, 'Vaticano'),
(193, 'Venezuela'),
(194, 'Vietnam'),
(195, 'Yemen'),
(196, 'Yibuti'),
(197, 'Zambia'),
(198, 'Zimbabue');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_provincias`
--

CREATE TABLE `info_provincias` (
  `id` char(6) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `region_id` char(6) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `info_provincias`
--

INSERT INTO `info_provincias` (`id`, `name`, `region_id`, `created_at`, `updated_at`) VALUES
('010100', 'Chachapoyas', '010000', NULL, NULL),
('010200', 'Bagua', '010000', NULL, NULL),
('010300', 'Bongará', '010000', NULL, NULL),
('010400', 'Condorcanqui', '010000', NULL, NULL),
('010500', 'Luya', '010000', NULL, NULL),
('010600', 'Rodríguez de Mendoza', '010000', NULL, NULL),
('010700', 'Utcubamba', '010000', NULL, NULL),
('020100', 'Huaraz', '020000', NULL, NULL),
('020200', 'Aija', '020000', NULL, NULL),
('020300', 'Antonio Raymondi', '020000', NULL, NULL),
('020400', 'Asunción', '020000', NULL, NULL),
('020500', 'Bolognesi', '020000', NULL, NULL),
('020600', 'Carhuaz', '020000', NULL, NULL),
('020700', 'Carlos Fermín Fitzcarrald', '020000', NULL, NULL),
('020800', 'Casma', '020000', NULL, NULL),
('020900', 'Corongo', '020000', NULL, NULL),
('021000', 'Huari', '020000', NULL, NULL),
('021100', 'Huarmey', '020000', NULL, NULL),
('021200', 'Huaylas', '020000', NULL, NULL),
('021300', 'Mariscal Luzuriaga', '020000', NULL, NULL),
('021400', 'Ocros', '020000', NULL, NULL),
('021500', 'Pallasca', '020000', NULL, NULL),
('021600', 'Pomabamba', '020000', NULL, NULL),
('021700', 'Recuay', '020000', NULL, NULL),
('021800', 'Santa', '020000', NULL, NULL),
('021900', 'Sihuas', '020000', NULL, NULL),
('022000', 'Yungay', '020000', NULL, NULL),
('030100', 'Abancay', '030000', NULL, NULL),
('030200', 'Andahuaylas', '030000', NULL, NULL),
('030300', 'Antabamba', '030000', NULL, NULL),
('030400', 'Aymaraes', '030000', NULL, NULL),
('030500', 'Cotabambas', '030000', NULL, NULL),
('030600', 'Chincheros', '030000', NULL, NULL),
('030700', 'Grau', '030000', NULL, NULL),
('040100', 'Arequipa', '040000', NULL, NULL),
('040200', 'Camaná', '040000', NULL, NULL),
('040300', 'Caravelí', '040000', NULL, NULL),
('040400', 'Castilla', '040000', NULL, NULL),
('040500', 'Caylloma', '040000', NULL, NULL),
('040600', 'Condesuyos', '040000', NULL, NULL),
('040700', 'Islay', '040000', NULL, NULL),
('040800', 'La Uniòn', '040000', NULL, NULL),
('050100', 'Huamanga', '050000', NULL, NULL),
('050200', 'Cangallo', '050000', NULL, NULL),
('050300', 'Huanca Sancos', '050000', NULL, NULL),
('050400', 'Huanta', '050000', NULL, NULL),
('050500', 'La Mar', '050000', NULL, NULL),
('050600', 'Lucanas', '050000', NULL, NULL),
('050700', 'Parinacochas', '050000', NULL, NULL),
('050800', 'Pàucar del Sara Sara', '050000', NULL, NULL),
('050900', 'Sucre', '050000', NULL, NULL),
('051000', 'Víctor Fajardo', '050000', NULL, NULL),
('051100', 'Vilcas Huamán', '050000', NULL, NULL),
('060100', 'Cajamarca', '060000', NULL, NULL),
('060200', 'Cajabamba', '060000', NULL, NULL),
('060300', 'Celendín', '060000', NULL, NULL),
('060400', 'Chota', '060000', NULL, NULL),
('060500', 'Contumazá', '060000', NULL, NULL),
('060600', 'Cutervo', '060000', NULL, NULL),
('060700', 'Hualgayoc', '060000', NULL, NULL),
('060800', 'Jaén', '060000', NULL, NULL),
('060900', 'San Ignacio', '060000', NULL, NULL),
('061000', 'San Marcos', '060000', NULL, NULL),
('061100', 'San Miguel', '060000', NULL, NULL),
('061200', 'San Pablo', '060000', NULL, NULL),
('061300', 'Santa Cruz', '060000', NULL, NULL),
('070100', 'Prov. Const. del Callao', '070000', NULL, NULL),
('080100', 'Cusco', '080000', NULL, NULL),
('080200', 'Acomayo', '080000', NULL, NULL),
('080300', 'Anta', '080000', NULL, NULL),
('080400', 'Calca', '080000', NULL, NULL),
('080500', 'Canas', '080000', NULL, NULL),
('080600', 'Canchis', '080000', NULL, NULL),
('080700', 'Chumbivilcas', '080000', NULL, NULL),
('080800', 'Espinar', '080000', NULL, NULL),
('080900', 'La Convención', '080000', NULL, NULL),
('081000', 'Paruro', '080000', NULL, NULL),
('081100', 'Paucartambo', '080000', NULL, NULL),
('081200', 'Quispicanchi', '080000', NULL, NULL),
('081300', 'Urubamba', '080000', NULL, NULL),
('090100', 'Huancavelica', '090000', NULL, NULL),
('090200', 'Acobamba', '090000', NULL, NULL),
('090300', 'Angaraes', '090000', NULL, NULL),
('090400', 'Castrovirreyna', '090000', NULL, NULL),
('090500', 'Churcampa', '090000', NULL, NULL),
('090600', 'Huaytará', '090000', NULL, NULL),
('090700', 'Tayacaja', '090000', NULL, NULL),
('100100', 'Huánuco', '100000', NULL, NULL),
('100200', 'Ambo', '100000', NULL, NULL),
('100300', 'Dos de Mayo', '100000', NULL, NULL),
('100400', 'Huacaybamba', '100000', NULL, NULL),
('100500', 'Huamalíes', '100000', NULL, NULL),
('100600', 'Leoncio Prado', '100000', NULL, NULL),
('100700', 'Marañón', '100000', NULL, NULL),
('100800', 'Pachitea', '100000', NULL, NULL),
('100900', 'Puerto Inca', '100000', NULL, NULL),
('101000', 'Lauricocha ', '100000', NULL, NULL),
('101100', 'Yarowilca ', '100000', NULL, NULL),
('110100', 'Ica ', '110000', NULL, NULL),
('110200', 'Chincha ', '110000', NULL, NULL),
('110300', 'Nasca ', '110000', NULL, NULL),
('110400', 'Palpa ', '110000', NULL, NULL),
('110500', 'Pisco ', '110000', NULL, NULL),
('120100', 'Huancayo ', '120000', NULL, NULL),
('120200', 'Concepción ', '120000', NULL, NULL),
('120300', 'Chanchamayo ', '120000', NULL, NULL),
('120400', 'Jauja ', '120000', NULL, NULL),
('120500', 'Junín ', '120000', NULL, NULL),
('120600', 'Satipo ', '120000', NULL, NULL),
('120700', 'Tarma ', '120000', NULL, NULL),
('120800', 'Yauli ', '120000', NULL, NULL),
('120900', 'Chupaca ', '120000', NULL, NULL),
('130100', 'Trujillo ', '130000', NULL, NULL),
('130200', 'Ascope ', '130000', NULL, NULL),
('130300', 'Bolívar ', '130000', NULL, NULL),
('130400', 'Chepén ', '130000', NULL, NULL),
('130500', 'Julcán ', '130000', NULL, NULL),
('130600', 'Otuzco ', '130000', NULL, NULL),
('130700', 'Pacasmayo ', '130000', NULL, NULL),
('130800', 'Pataz ', '130000', NULL, NULL),
('130900', 'Sánchez Carrión ', '130000', NULL, NULL),
('131000', 'Santiago de Chuco ', '130000', NULL, NULL),
('131100', 'Gran Chimú ', '130000', NULL, NULL),
('131200', 'Virú ', '130000', NULL, NULL),
('140100', 'Chiclayo ', '140000', NULL, NULL),
('140200', 'Ferreñafe ', '140000', NULL, NULL),
('140300', 'Lambayeque ', '140000', NULL, NULL),
('150100', 'Lima ', '150000', NULL, NULL),
('150200', 'Barranca ', '150000', NULL, NULL),
('150300', 'Cajatambo ', '150000', NULL, NULL),
('150400', 'Canta ', '150000', NULL, NULL),
('150500', 'Cañete ', '150000', NULL, NULL),
('150600', 'Huaral ', '150000', NULL, NULL),
('150700', 'Huarochirí ', '150000', NULL, NULL),
('150800', 'Huaura ', '150000', NULL, NULL),
('150900', 'Oyón ', '150000', NULL, NULL),
('151000', 'Yauyos ', '150000', NULL, NULL),
('160100', 'Maynas ', '160000', NULL, NULL),
('160200', 'Alto Amazonas ', '160000', NULL, NULL),
('160300', 'Loreto ', '160000', NULL, NULL),
('160400', 'Mariscal Ramón Castilla ', '160000', NULL, NULL),
('160500', 'Requena ', '160000', NULL, NULL),
('160600', 'Ucayali ', '160000', NULL, NULL),
('160700', 'Datem del Marañón ', '160000', NULL, NULL),
('160800', 'Putumayo', '160000', NULL, NULL),
('170100', 'Tambopata ', '170000', NULL, NULL),
('170200', 'Manu ', '170000', NULL, NULL),
('170300', 'Tahuamanu ', '170000', NULL, NULL),
('180100', 'Mariscal Nieto ', '180000', NULL, NULL),
('180200', 'General Sánchez Cerro ', '180000', NULL, NULL),
('180300', 'Ilo ', '180000', NULL, NULL),
('190100', 'Pasco ', '190000', NULL, NULL),
('190200', 'Daniel Alcides Carrión ', '190000', NULL, NULL),
('190300', 'Oxapampa ', '190000', NULL, NULL),
('200100', 'Piura ', '200000', NULL, NULL),
('200200', 'Ayabaca ', '200000', NULL, NULL),
('200300', 'Huancabamba ', '200000', NULL, NULL),
('200400', 'Morropón ', '200000', NULL, NULL),
('200500', 'Paita ', '200000', NULL, NULL),
('200600', 'Sullana ', '200000', NULL, NULL),
('200700', 'Talara ', '200000', NULL, NULL),
('200800', 'Sechura ', '200000', NULL, NULL),
('210100', 'Puno ', '210000', NULL, NULL),
('210200', 'Azángaro ', '210000', NULL, NULL),
('210300', 'Carabaya ', '210000', NULL, NULL),
('210400', 'Chucuito ', '210000', NULL, NULL),
('210500', 'El Collao ', '210000', NULL, NULL),
('210600', 'Huancané ', '210000', NULL, NULL),
('210700', 'Lampa ', '210000', NULL, NULL),
('210800', 'Melgar ', '210000', NULL, NULL),
('210900', 'Moho ', '210000', NULL, NULL),
('211000', 'San Antonio de Putina ', '210000', NULL, NULL),
('211100', 'San Román ', '210000', NULL, NULL),
('211200', 'Sandia ', '210000', NULL, NULL),
('211300', 'Yunguyo ', '210000', NULL, NULL),
('220100', 'Moyobamba ', '220000', NULL, NULL),
('220200', 'Bellavista ', '220000', NULL, NULL),
('220300', 'El Dorado ', '220000', NULL, NULL),
('220400', 'Huallaga ', '220000', NULL, NULL),
('220500', 'Lamas ', '220000', NULL, NULL),
('220600', 'Mariscal Cáceres ', '220000', NULL, NULL),
('220700', 'Picota ', '220000', NULL, NULL),
('220800', 'Rioja ', '220000', NULL, NULL),
('220900', 'San Martín ', '220000', NULL, NULL),
('221000', 'Tocache ', '220000', NULL, NULL),
('230100', 'Tacna ', '230000', NULL, NULL),
('230200', 'Candarave ', '230000', NULL, NULL),
('230300', 'Jorge Basadre ', '230000', NULL, NULL),
('230400', 'Tarata ', '230000', NULL, NULL),
('240100', 'Tumbes ', '240000', NULL, NULL),
('240200', 'Contralmirante Villar ', '240000', NULL, NULL),
('240300', 'Zarumilla ', '240000', NULL, NULL),
('250100', 'Coronel Portillo ', '250000', NULL, NULL),
('250200', 'Atalaya ', '250000', NULL, NULL),
('250300', 'Padre Abad ', '250000', NULL, NULL),
('250400', 'Purús', '250000', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_regiones`
--

CREATE TABLE `info_regiones` (
  `id` char(6) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `info_regiones`
--

INSERT INTO `info_regiones` (`id`, `name`, `created_at`, `updated_at`) VALUES
('010000', 'Amazonas', NULL, NULL),
('020000', 'Áncash', NULL, NULL),
('030000', 'Apurímac', NULL, NULL),
('040000', 'Arequipa', NULL, NULL),
('050000', 'Ayacucho', NULL, NULL),
('060000', 'Cajamarca', NULL, NULL),
('070000', 'Callao', NULL, NULL),
('080000', 'Cusco', NULL, NULL),
('090000', 'Huancavelica', NULL, NULL),
('100000', 'Huánuco', NULL, NULL),
('110000', 'Ica', NULL, NULL),
('120000', 'Junín', NULL, NULL),
('130000', 'La Libertad', NULL, NULL),
('140000', 'Lambayeque', NULL, NULL),
('150000', 'Lima', NULL, NULL),
('160000', 'Loreto', NULL, NULL),
('170000', 'Madre de Dios', NULL, NULL),
('180000', 'Moquegua', NULL, NULL),
('190000', 'Pasco', NULL, NULL),
('200000', 'Piura', NULL, NULL),
('210000', 'Puno', NULL, NULL),
('220000', 'San Martín', NULL, NULL),
('230000', 'Tacna', NULL, NULL),
('240000', 'Tumbes', NULL, NULL),
('250000', 'Ucayali', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_sistemas`
--

CREATE TABLE `info_sistemas` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `info_sistemas`
--

INSERT INTO `info_sistemas` (`id`, `name`) VALUES
(1, 'Android '),
(2, 'iOS Apple'),
(3, 'Symbian'),
(4, 'Blackberry OS'),
(5, 'Windows Phone');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_tipo_documento_identidad`
--

CREATE TABLE `info_tipo_documento_identidad` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `info_tipo_documento_identidad`
--

INSERT INTO `info_tipo_documento_identidad` (`id`, `name`) VALUES
(1, 'DNI'),
(2, 'RUC'),
(3, 'Cedula de identidad'),
(4, 'Carnet de extranjeria'),
(5, 'Pasaporte');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_03_07_003244_create_permission_tables', 2),
(5, '2021_09_09_163540_create_sessions_table', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(5, 'App\\Models\\User', 1),
(6, 'App\\Models\\User', 1),
(7, 'App\\Models\\User', 1),
(8, 'App\\Models\\User', 1),
(8, 'App\\Models\\User', 2),
(9, 'App\\Models\\User', 1),
(11, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(5, 'Sistema', 'web', '2021-03-23 02:27:34', '2021-03-23 02:27:34'),
(6, 'Claro', 'web', '2021-03-23 02:27:44', '2021-03-23 02:27:44'),
(7, 'Movistar', 'web', '2021-03-23 02:27:50', '2021-03-23 02:27:50'),
(8, 'Entel', 'web', '2021-03-23 02:28:00', '2021-03-23 02:28:00'),
(9, 'Reniec', 'web', '2021-03-23 02:28:13', '2021-03-23 02:28:13'),
(10, 'SBS', 'web', '2021-03-23 02:28:18', '2021-03-23 02:28:18'),
(11, 'Email', 'web', '2021-04-03 20:23:48', '2021-04-03 20:23:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` int(11) NOT NULL,
  `nombres` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paterno` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `materno` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_documento` int(1) DEFAULT NULL,
  `numero_documento` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edad` int(3) NOT NULL,
  `sexo` int(1) NOT NULL,
  `pais_id` int(10) NOT NULL,
  `region_id` int(10) DEFAULT NULL,
  `provincia_id` int(10) DEFAULT NULL,
  `distrito_id` int(10) DEFAULT NULL,
  `direccion` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coordenadas` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_img` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `nombres`, `paterno`, `materno`, `alias`, `tipo_documento`, `numero_documento`, `edad`, `sexo`, `pais_id`, `region_id`, `provincia_id`, `distrito_id`, `direccion`, `coordenadas`, `profile_img`, `created_at`, `updated_at`, `deleted_at`) VALUES
(38, 'In velit id velit at', 'Error magna assumend', 'Laboriosam quo et n', NULL, 1, '44445555', 84, 1, 99, NULL, NULL, 150101, 'Repellendus Expedit', 'Animi esse autem ex', 'images/iYyjoNMyaxIVKvc2tH0FXbth6eNgnVKNJUt8WbSq.jpg', '2021-10-12 13:47:20', '2021-10-11 16:30:44', NULL),
(39, 'Carlos', 'Juala', 'Jurjnej', NULL, 1, '345434', 22, 1, 143, 150000, 150100, 150104, 'calle shell', '(-12.122447371162744, -77.03115723917848)', NULL, '2021-10-12 22:19:35', '2021-10-12 22:19:35', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombres` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paterno` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `materno` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_ip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google2fa_enable` tinyint(1) NOT NULL DEFAULT 0,
  `google2fa_secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nombres`, `paterno`, `materno`, `dni`, `telefono`, `email`, `email_verified_at`, `password`, `remember_token`, `last_ip`, `google2fa_enable`, `google2fa_secret`, `created_at`, `updated_at`) VALUES
(1, 'Hegel', 'Covarrubias', '', '42370304', '989106280', 'hegel.covarrubias@gmail.com', NULL, '$2y$10$uh9lkvlklyYibe.UaMYhJO8LNif6UW3bbxOB.dH.tU51sY.FjWehK', NULL, '192.168.154.247', 1, 'WFSSQHEN6IB66FKY', '2021-03-16 20:17:44', '2021-10-16 21:35:06'),
(2, 'Carlitos', 'arreola', '', '32327', '989541257', 'carlos@gmail.com', NULL, '', NULL, '', 0, NULL, '2021-03-05 03:35:50', '2021-03-18 15:16:06');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `casos`
--
ALTER TABLE `casos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `caso_has_persons`
--
ALTER TABLE `caso_has_persons`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `data_correos`
--
ALTER TABLE `data_correos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `data_cuenta_bancarias`
--
ALTER TABLE `data_cuenta_bancarias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `data_imagenes`
--
ALTER TABLE `data_imagenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `data_paginas_web`
--
ALTER TABLE `data_paginas_web`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `data_redes_sociales`
--
ALTER TABLE `data_redes_sociales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `data_tarjetas`
--
ALTER TABLE `data_tarjetas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `data_telefonos`
--
ALTER TABLE `data_telefonos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fiscalias`
--
ALTER TABLE `fiscalias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `info_bancos`
--
ALTER TABLE `info_bancos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `info_delitos`
--
ALTER TABLE `info_delitos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `info_distritos`
--
ALTER TABLE `info_distritos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `info_entidad`
--
ALTER TABLE `info_entidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `info_monedas`
--
ALTER TABLE `info_monedas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `info_operadoras`
--
ALTER TABLE `info_operadoras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `info_paises`
--
ALTER TABLE `info_paises`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `info_provincias`
--
ALTER TABLE `info_provincias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `info_regiones`
--
ALTER TABLE `info_regiones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `info_sistemas`
--
ALTER TABLE `info_sistemas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `info_tipo_documento_identidad`
--
ALTER TABLE `info_tipo_documento_identidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_documento` (`numero_documento`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `dni` (`dni`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `casos`
--
ALTER TABLE `casos`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `caso_has_persons`
--
ALTER TABLE `caso_has_persons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `data_correos`
--
ALTER TABLE `data_correos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `data_cuenta_bancarias`
--
ALTER TABLE `data_cuenta_bancarias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `data_imagenes`
--
ALTER TABLE `data_imagenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `data_paginas_web`
--
ALTER TABLE `data_paginas_web`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `data_redes_sociales`
--
ALTER TABLE `data_redes_sociales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `data_tarjetas`
--
ALTER TABLE `data_tarjetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `data_telefonos`
--
ALTER TABLE `data_telefonos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `fiscalias`
--
ALTER TABLE `fiscalias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `info_bancos`
--
ALTER TABLE `info_bancos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `info_entidad`
--
ALTER TABLE `info_entidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `info_monedas`
--
ALTER TABLE `info_monedas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `info_operadoras`
--
ALTER TABLE `info_operadoras`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `info_paises`
--
ALTER TABLE `info_paises`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT de la tabla `info_sistemas`
--
ALTER TABLE `info_sistemas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `info_tipo_documento_identidad`
--
ALTER TABLE `info_tipo_documento_identidad`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
