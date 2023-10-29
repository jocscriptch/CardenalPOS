-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-10-2023 a las 00:29:42
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cardenalpos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbabonos`
--

CREATE TABLE `tbabonos` (
  `id` int(11) NOT NULL,
  `abono` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_credito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbapartados`
--

CREATE TABLE `tbapartados` (
  `id` int(11) NOT NULL,
  `productos` longtext NOT NULL,
  `fecha_apartado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_retiro` datetime NOT NULL,
  `abono` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `color` varchar(15) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcajas`
--

CREATE TABLE `tbcajas` (
  `id` int(11) NOT NULL,
  `monto_inicial` decimal(10,2) NOT NULL,
  `fecha_apertura` date NOT NULL,
  `fecha_cierre` date NOT NULL,
  `monto_final` decimal(10,2) NOT NULL,
  `total_ventas` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcategorias`
--

CREATE TABLE `tbcategorias` (
  `id` int(11) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbcategorias`
--

INSERT INTO `tbcategorias` (`id`, `categoria`, `fecha`, `estado`) VALUES
(1, 'HONDA', '2023-09-30 20:03:20', 1),
(2, 'SUZUKI', '2023-09-30 20:03:05', 1),
(3, 'YAMAHA', '2023-09-30 20:03:10', 1),
(4, 'LLANTAS', '2023-10-03 20:59:28', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbclientes`
--

CREATE TABLE `tbclientes` (
  `id` int(11) NOT NULL,
  `identidad` varchar(50) NOT NULL,
  `num_identidad` varchar(15) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbclientes`
--

INSERT INTO `tbclientes` (`id`, `identidad`, `num_identidad`, `nombre`, `telefono`, `correo`, `direccion`, `fecha`, `estado`) VALUES
(1, 'Nacional', '604650768', 'DELGADO ALTAMIRANO GREIVIN STIWART', '88774455', NULL, '<p>Holaaa</p>', '2023-10-27 20:55:43', 1),
(2, 'Nacional', '107200233', 'CASTRO MORA SARAY MARIA', '83747218', NULL, '<p>PZ</p>', '2023-10-03 21:04:53', 1),
(4, 'Nacional', '604740047', 'CABRERA ORTEGA JULIO JAFED', '88888888', NULL, '<p>km31</p>', '2023-10-17 15:43:27', 1),
(5, 'Nacional', '604570448', 'TORRES VALVERDE ADRIAN ALBERTO', '55555', NULL, '<p>hols</p>', '2023-10-17 19:24:34', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcompras`
--

CREATE TABLE `tbcompras` (
  `id` int(11) NOT NULL,
  `productos` longtext NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `serie` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `id_proveedor` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbcompras`
--

INSERT INTO `tbcompras` (`id`, `productos`, `subtotal`, `iva`, `total`, `fecha`, `hora`, `serie`, `estado`, `id_proveedor`, `id_usuario`) VALUES
(2, '[{\"id\":4,\"nombre\":\"CABLE VELOC. YBR125ED DISCO VINI\",\"precio\":\"950.00\",\"cantidad\":\"3\"},{\"id\":5,\"nombre\":\"SWITCH LUCES IZQ. NXR\\/XL200\\/CARGO KGA VINI\",\"precio\":\"2245.00\",\"cantidad\":\"4\"},{\"id\":6,\"nombre\":\"STOP.U PIRAMIDAL XR200 UNIVER. TW\",\"precio\":\"2280.00\",\"cantidad\":\"2\"},{\"id\":7,\"nombre\":\"LL.17 80\\/80x17 K-6309 41P TL\",\"precio\":\"12970.00\",\"cantidad\":\"2\"},{\"id\":8,\"nombre\":\"LL.17 90\\/90x17 K-6309 49P TL\",\"precio\":\"23180.00\",\"cantidad\":1},{\"id\":9,\"nombre\":\"LL.18 120\\/80x18 K-6309 62P TL\",\"precio\":\"24800.00\",\"cantidad\":1},{\"id\":10,\"nombre\":\"LL.21 90\\/90x21 K-6309 54P\",\"precio\":\"15900.00\",\"cantidad\":1},{\"id\":11,\"nombre\":\"LL.19 90\\/90x19 K-669 52P\",\"precio\":\"18720.00\",\"cantidad\":\"2\"}]', 143650.00, 18674.50, 162324.50, '2023-10-30', '00:01:07', '1', 1, 2, 1),
(3, '[{\"id\":4,\"nombre\":\"CABLE VELOC. YBR125ED DISCO VINI\",\"precio\":\"950.00\",\"cantidad\":\"5\"},{\"id\":5,\"nombre\":\"SWITCH LUCES IZQ. NXR\\/XL200\\/CARGO KGA VINI\",\"precio\":\"2245.00\",\"cantidad\":1}]', 7904.35, 909.35, 6995.00, '2023-10-30', '00:19:53', '2', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbconfiguracion`
--

CREATE TABLE `tbconfiguracion` (
  `id` int(11) NOT NULL,
  `id_empresa` varchar(15) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `direccion` text NOT NULL,
  `mensaje` text NOT NULL,
  `impuesto` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbconfiguracion`
--

INSERT INTO `tbconfiguracion` (`id`, `id_empresa`, `nombre`, `telefono`, `correo`, `direccion`, `mensaje`, `impuesto`) VALUES
(1, '1122334488', 'Moto Repuestos Cardenal', '88775522', 'cardenal@gmail.com', 'Rio Claro', '<p><strong>¡GRACIAS POR SU PREFERENCIA!</strong></p>', 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcotizaciones`
--

CREATE TABLE `tbcotizaciones` (
  `id` int(11) NOT NULL,
  `productos` longtext NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `validez` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcreditos`
--

CREATE TABLE `tbcreditos` (
  `id` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1,
  `id_venta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbgastos`
--

CREATE TABLE `tbgastos` (
  `id` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbinventario`
--

CREATE TABLE `tbinventario` (
  `id` int(11) NOT NULL,
  `entradas` int(11) NOT NULL DEFAULT 0,
  `salidas` int(11) NOT NULL DEFAULT 0,
  `fecha` date NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbmedidas`
--

CREATE TABLE `tbmedidas` (
  `id` int(11) NOT NULL,
  `medida` varchar(100) NOT NULL,
  `abreviatura` varchar(10) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbmedidas`
--

INSERT INTO `tbmedidas` (`id`, `medida`, `abreviatura`, `fecha`, `estado`) VALUES
(1, 'CENTIMETROS', 'CM', '2023-09-30 20:02:49', 1),
(2, 'METROS', 'M', '2023-09-30 20:02:02', 1),
(3, 'LITROS', 'L', '2023-09-30 20:02:15', 1),
(4, 'PULGADAS', 'IN', '2023-09-30 20:02:21', 1),
(5, 'KILOGRAMO', 'KG', '2023-10-03 20:57:50', 1),
(6, 'UNIDAD', 'U', '2023-10-03 20:58:05', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbproductos`
--

CREATE TABLE `tbproductos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 0,
  `foto` varchar(100) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ventas` int(11) NOT NULL DEFAULT 0,
  `id_medida` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbproductos`
--

INSERT INTO `tbproductos` (`id`, `codigo`, `descripcion`, `precio_compra`, `precio_venta`, `cantidad`, `foto`, `estado`, `fecha`, `ventas`, `id_medida`, `id_categoria`) VALUES
(4, '4994100009900', 'CABLE VELOC. YBR125ED DISCO VINI', 950.00, 1000.00, 38, NULL, 1, '2023-10-29 23:19:53', 0, 2, 1),
(5, '4621205009900', 'SWITCH LUCES IZQ. NXR/XL200/CARGO KGA VINI', 2245.00, 25000.00, 25, NULL, 1, '2023-10-29 23:19:53', 0, 6, 3),
(6, '4691002019900', 'STOP.U PIRAMIDAL XR200 UNIVER. TW', 2280.00, 2500.00, 11, NULL, 1, '2023-10-29 23:01:07', 0, 6, 3),
(7, '3611200000100', 'LL.17 80/80x17 K-6309 41P TL', 12970.00, 13500.00, 12, NULL, 1, '2023-10-29 23:01:07', 0, 6, 2),
(8, '3611200000101', 'LL.17 90/90x17 K-6309 49P TL', 23180.00, 24000.00, 7, NULL, 1, '2023-10-29 23:01:07', 0, 6, 2),
(9, '3611200000102', 'LL.18 120/80x18 K-6309 62P TL', 24800.00, 25500.00, 7, NULL, 1, '2023-10-29 23:01:07', 0, 6, 3),
(10, '3611200000103', 'LL.21 90/90x21 K-6309 54P', 15900.00, 16500.00, 7, NULL, 1, '2023-10-29 23:01:07', 0, 6, 1),
(11, '3611200000104', 'LL.19 90/90x19 K-669 52P', 18720.00, 19500.00, 12, NULL, 1, '2023-10-29 23:01:07', 0, 6, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbproveedor`
--

CREATE TABLE `tbproveedor` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbproveedor`
--

INSERT INTO `tbproveedor` (`id`, `nombre`, `telefono`, `correo`, `direccion`, `fecha`, `estado`) VALUES
(1, 'Repuestos Gigantes', '88775566', 'repuestosgigantes@gmail.com', '<p>SAN JOSE</p>', '2023-10-28 23:39:32', 1),
(2, 'Grupo FAVARCIA S.A.', '24539200', 'grupofavarcia@hotmail.com', '<p>ALAJUELA, PALMARES Contiguo Campo Ferial Palmares</p>', '2023-10-29 03:11:43', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbusuarios`
--

CREATE TABLE `tbusuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `perfil` varchar(100) DEFAULT NULL,
  `clave` varchar(200) NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbusuarios`
--

INSERT INTO `tbusuarios` (`id`, `nombre`, `apellido`, `correo`, `telefono`, `direccion`, `perfil`, `clave`, `token`, `fecha`, `estado`, `rol`) VALUES
(1, 'Jocsan', 'Ramirez Chaves', 'jocsan@gmail.com', '83626991', 'Rio Claro', NULL, '$2y$10$hmDhU1t8djd45IRnfR1vAOy2LKTf5coOzrtbBpd6UhV8FeuoihaoW', NULL, '2023-09-30 19:58:50', 1, 1),
(2, 'Abdias', 'Ureña', 'abdias@gmail.com', '88776655', 'Rio Claro', NULL, '$2y$10$fllQOWCBFR7qsAi0R5V37u1B9YrBxzsdlEDsTERDlHf3Glq1Zq5b2', NULL, '2023-09-30 19:59:27', 1, 1),
(3, 'Antony', 'Valverde', 'gato@gmail.com', '88994455', 'La Esperanza', NULL, '$2y$10$9onI0tsyiP2W1bS0306u8.2kj5/MD3LZ3DIQ4UvamFUU8DuQYV266', NULL, '2023-10-17 19:08:39', 1, 2),
(4, 'Saray', 'Castro Mora', 'sarayc@gmail.com', '88774422', 'PZ', NULL, '$2y$10$GiZjEAJrmlkKZDFHGCFLLuJksbjqXvb.N22M.2ELi.Q1cpeOucsTK', NULL, '2023-10-28 20:01:05', 1, 1),
(5, 'Julio', 'Cabrera', 'julio@gmail.com', '88888888', 'Km31', NULL, '$2y$10$KGdEWcZCqGc9rgyrEUe1M.1IwNAPt76zw6YAryj7718INnFm/mnXG', NULL, '2023-10-28 20:01:03', 1, 1),
(6, 'Cristofer', 'Barrios', 'cristofer@gmail.com', '8888888', 'PZ', NULL, '$2y$10$SvDHQopYERojyr1Q3lUCLugRHJH3bsZKrVxYT14l4LcBPxvxrVR1C', NULL, '2023-10-17 19:19:42', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbventas`
--

CREATE TABLE `tbventas` (
  `id` int(11) NOT NULL,
  `productos` longtext NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `apertura` int(11) NOT NULL DEFAULT 1,
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbabonos`
--
ALTER TABLE `tbabonos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_credito` (`id_credito`);

--
-- Indices de la tabla `tbapartados`
--
ALTER TABLE `tbapartados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `tbcajas`
--
ALTER TABLE `tbcajas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tbcategorias`
--
ALTER TABLE `tbcategorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbclientes`
--
ALTER TABLE `tbclientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbcompras`
--
ALTER TABLE `tbcompras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tbconfiguracion`
--
ALTER TABLE `tbconfiguracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbcotizaciones`
--
ALTER TABLE `tbcotizaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `tbcreditos`
--
ALTER TABLE `tbcreditos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_venta` (`id_venta`);

--
-- Indices de la tabla `tbgastos`
--
ALTER TABLE `tbgastos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tbinventario`
--
ALTER TABLE `tbinventario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tbmedidas`
--
ALTER TABLE `tbmedidas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbproductos`
--
ALTER TABLE `tbproductos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_medida` (`id_medida`);

--
-- Indices de la tabla `tbproveedor`
--
ALTER TABLE `tbproveedor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbusuarios`
--
ALTER TABLE `tbusuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbventas`
--
ALTER TABLE `tbventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbabonos`
--
ALTER TABLE `tbabonos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbapartados`
--
ALTER TABLE `tbapartados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbcajas`
--
ALTER TABLE `tbcajas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbcategorias`
--
ALTER TABLE `tbcategorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbclientes`
--
ALTER TABLE `tbclientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbcompras`
--
ALTER TABLE `tbcompras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbconfiguracion`
--
ALTER TABLE `tbconfiguracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbcotizaciones`
--
ALTER TABLE `tbcotizaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbcreditos`
--
ALTER TABLE `tbcreditos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbgastos`
--
ALTER TABLE `tbgastos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbinventario`
--
ALTER TABLE `tbinventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbmedidas`
--
ALTER TABLE `tbmedidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbproductos`
--
ALTER TABLE `tbproductos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tbproveedor`
--
ALTER TABLE `tbproveedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbusuarios`
--
ALTER TABLE `tbusuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbventas`
--
ALTER TABLE `tbventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbabonos`
--
ALTER TABLE `tbabonos`
  ADD CONSTRAINT `tbabonos_ibfk_1` FOREIGN KEY (`id_credito`) REFERENCES `tbcreditos` (`id`);

--
-- Filtros para la tabla `tbapartados`
--
ALTER TABLE `tbapartados`
  ADD CONSTRAINT `tbapartados_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tbclientes` (`id`);

--
-- Filtros para la tabla `tbcajas`
--
ALTER TABLE `tbcajas`
  ADD CONSTRAINT `tbcajas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tbusuarios` (`id`);

--
-- Filtros para la tabla `tbcompras`
--
ALTER TABLE `tbcompras`
  ADD CONSTRAINT `tbcompras_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `tbproveedor` (`id`),
  ADD CONSTRAINT `tbcompras_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `tbusuarios` (`id`);

--
-- Filtros para la tabla `tbcotizaciones`
--
ALTER TABLE `tbcotizaciones`
  ADD CONSTRAINT `tbcotizaciones_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tbclientes` (`id`);

--
-- Filtros para la tabla `tbcreditos`
--
ALTER TABLE `tbcreditos`
  ADD CONSTRAINT `tbcreditos_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `tbventas` (`id`);

--
-- Filtros para la tabla `tbgastos`
--
ALTER TABLE `tbgastos`
  ADD CONSTRAINT `tbgastos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tbusuarios` (`id`);

--
-- Filtros para la tabla `tbinventario`
--
ALTER TABLE `tbinventario`
  ADD CONSTRAINT `tbinventario_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `tbproductos` (`id`),
  ADD CONSTRAINT `tbinventario_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `tbusuarios` (`id`);

--
-- Filtros para la tabla `tbproductos`
--
ALTER TABLE `tbproductos`
  ADD CONSTRAINT `tbproductos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `tbcategorias` (`id`),
  ADD CONSTRAINT `tbproductos_ibfk_2` FOREIGN KEY (`id_medida`) REFERENCES `tbmedidas` (`id`);

--
-- Filtros para la tabla `tbventas`
--
ALTER TABLE `tbventas`
  ADD CONSTRAINT `tbventas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tbclientes` (`id`),
  ADD CONSTRAINT `tbventas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `tbusuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
