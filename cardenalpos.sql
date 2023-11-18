-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2023 a las 12:21:46
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
  `fecha_creado` date NOT NULL,
  `fecha_apartado` datetime NOT NULL,
  `fecha_retiro` datetime NOT NULL,
  `abono` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `color` varchar(15) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcajas`
--

CREATE TABLE `tbcajas` (
  `id` int(11) NOT NULL,
  `monto_inicial` decimal(10,2) NOT NULL,
  `fecha_apertura` date NOT NULL,
  `fecha_cierre` date DEFAULT NULL,
  `monto_final` decimal(10,2) DEFAULT NULL,
  `total_ventas` int(11) DEFAULT NULL,
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
  `fecha` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbcategorias`
--

INSERT INTO `tbcategorias` (`id`, `categoria`, `fecha`, `estado`) VALUES
(1, 'SIN CATEGORIA', '2023-11-11 18:56:23', 1),
(2, 'CABLES', '2023-11-11 18:56:27', 1),
(3, 'LUCES', '2023-11-11 18:56:29', 1),
(4, 'SUSPENSIONES', '2023-11-11 18:56:35', 1),
(5, 'TRANSMICIONES', '2023-11-11 18:56:53', 1);

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
(1, 'Nacional', '604650769', 'JIMENEZ CASCANTE YARITZA MARIAN', '88774455', NULL, '<p>NO DIR</p>', '2023-11-12 00:59:11', 1),
(2, 'Nacional', '602070058', 'FLORES HERRERA ALEXANDER', '8877994455', 'alexander@gmail.com', '<p>San Jose</p>', '2023-11-12 00:59:40', 1);

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
  `serie` varchar(20) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `id_proveedor` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbcompras`
--

INSERT INTO `tbcompras` (`id`, `productos`, `subtotal`, `iva`, `total`, `fecha`, `hora`, `serie`, `estado`, `id_proveedor`, `id_usuario`) VALUES
(1, '[{\"id\":2,\"nombre\":\"CABLE VELOC. YBR125ED DISCO VINI\",\"precio\":\"950.00\",\"cantidad\":10},{\"id\":3,\"nombre\":\"SWITCH LUCES IZQ. NXR\\/XL200\\/CARGO KGA VINI\",\"precio\":\"2245.00\",\"cantidad\":5},{\"id\":4,\"nombre\":\"STOP.U PIRAMIDAL XR200 UNIVER. TW\",\"precio\":\"2280.00\",\"cantidad\":5},{\"id\":6,\"nombre\":\"LL.19 90\\/90x19 K-669 52P\",\"precio\":\"18720.00\",\"cantidad\":3},{\"id\":1,\"nombre\":\"LL.17 90\\/90x17 K-6309 49P TL\",\"precio\":\"23180.00\",\"cantidad\":2},{\"id\":7,\"nombre\":\"LL.17 80\\/80x17 K-6309 41P TL\",\"precio\":\"12970.00\",\"cantidad\":1},{\"id\":5,\"nombre\":\"LL.21 90\\/90x21 K-6309 54P\",\"precio\":\"15900.00\",\"cantidad\":2},{\"id\":8,\"nombre\":\"LL.18 120\\/80x18 K-6309 62P TL\",\"precio\":\"24800.00\",\"cantidad\":5}]', 303415.00, 39443.95, 342858.95, '2023-11-17', '18:13:04', '9557697508', 1, 1, 1),
(2, '[{\"id\":9,\"nombre\":\"DISCO SSD M2 NVMe PCOe 1TB\",\"precio\":\"69469.00\",\"cantidad\":10}]', 694690.00, 90309.70, 784999.70, '2023-11-17', '20:37:50', '1374800366', 1, 1, 1);

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
(1, '604200530', 'Moto Repuestos Cardenal', '84503737', 'motorepuestoscardenal@hotmail.com', 'LA COLNIA, GUAYCARA, GOLFITO, PUNTARENAS, COSTA RICA', '<p><strong>¡Gracias por su preferencia!</strong></p>', 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcotizaciones`
--

CREATE TABLE `tbcotizaciones` (
  `id` int(11) NOT NULL,
  `productos` longtext NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `metodo` varchar(20) NOT NULL,
  `validez` varchar(30) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcreditos`
--

CREATE TABLE `tbcreditos` (
  `id` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
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
  `foto` varchar(200) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbinventario`
--

CREATE TABLE `tbinventario` (
  `id` int(11) NOT NULL,
  `movimiento` varchar(100) NOT NULL,
  `accion` varchar(20) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `stock_actual` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbinventario`
--

INSERT INTO `tbinventario` (`id`, `movimiento`, `accion`, `cantidad`, `stock_actual`, `fecha`, `id_producto`, `id_usuario`) VALUES
(1, 'Compra N°: 1', 'entrada', 10, 10, '2023-11-18 00:13:04', 2, 1),
(2, 'Compra N°: 1', 'entrada', 5, 5, '2023-11-18 00:13:04', 3, 1),
(3, 'Compra N°: 1', 'entrada', 5, 5, '2023-11-18 00:13:04', 4, 1),
(4, 'Compra N°: 1', 'entrada', 3, 3, '2023-11-18 00:13:04', 6, 1),
(5, 'Compra N°: 1', 'entrada', 2, 2, '2023-11-18 00:13:04', 1, 1),
(6, 'Compra N°: 1', 'entrada', 1, 1, '2023-11-18 00:13:04', 7, 1),
(7, 'Compra N°: 1', 'entrada', 2, 2, '2023-11-18 00:13:04', 5, 1),
(8, 'Compra N°: 1', 'entrada', 5, 5, '2023-11-18 00:13:04', 8, 1),
(9, 'Venta N°: 1', 'salida', 2, 8, '2023-11-18 00:14:05', 2, 1),
(10, 'Venta N°: 1', 'salida', 2, 3, '2023-11-18 00:14:05', 3, 1),
(11, 'Ajuste de Inventario: entrada', 'entrada', 2, 10, '2023-11-18 00:19:21', 2, 1),
(12, 'Ajuste de Inventario: salida', 'salida', 3, 7, '2023-11-18 00:19:59', 2, 1),
(13, 'Compra N°: 2', 'entrada', 10, 10, '2023-11-18 02:37:50', 9, 1),
(14, 'Venta N°: 2', 'salida', 5, 5, '2023-11-18 02:38:36', 9, 1);

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
(1, 'LITROS', 'LT', '2023-11-12 00:54:07', 1),
(2, 'METROS', 'MT', '2023-11-12 00:54:13', 1),
(3, 'UNIDAD', 'UNID', '2023-11-12 00:54:18', 1),
(4, 'CENTIMETROS', 'CM', '2023-11-12 00:54:27', 1),
(5, 'PULGADAS', 'IN', '2023-11-12 00:54:48', 1);

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
(1, '5420596', 'LL.17 90/90x17 K-6309 49P TL', 23180.00, 25000.00, 2, NULL, 1, '2023-11-18 00:13:04', 0, 3, 1),
(2, '8433332', 'CABLE VELOC. YBR125ED DISCO VINI', 950.00, 1200.00, 7, NULL, 1, '2023-11-18 00:19:59', 2, 3, 1),
(3, '8462370', 'SWITCH LUCES IZQ. NXR/XL200/CARGO KGA VINI', 2245.00, 2500.00, 3, NULL, 1, '2023-11-18 00:14:05', 2, 3, 1),
(4, '8468266', 'STOP.U PIRAMIDAL XR200 UNIVER. TW', 2280.00, 2500.00, 5, NULL, 1, '2023-11-18 00:13:04', 0, 3, 1),
(5, '5420191', 'LL.21 90/90x21 K-6309 54P', 15900.00, 17000.00, 2, NULL, 1, '2023-11-18 00:13:04', 0, 3, 1),
(6, '5420526', 'LL.19 90/90x19 K-669 52P', 18720.00, 20000.00, 3, NULL, 1, '2023-11-18 00:13:04', 0, 3, 1),
(7, '5420181', 'LL.17 80/80x17 K-6309 41P TL', 12970.00, 14000.00, 1, NULL, 1, '2023-11-18 00:13:04', 0, 3, 1),
(8, '5420166', 'LL.18 120/80x18 K-6309 62P TL', 24800.00, 28000.00, 5, NULL, 1, '2023-11-18 00:13:04', 0, 3, 1),
(9, '02-M21TB', 'DISCO SSD M2 NVMe PCOe 1TB', 69469.00, 75000.00, 5, NULL, 1, '2023-11-18 02:38:36', 5, 3, 1);

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
(1, 'Grupo FAVARCIA S.A.', '24539200', 'grupofavarcia@hotmail.com', '<p>Contiguo Campo Ferial Palmares ALAJUELA, PALMARES</p>', '2023-11-12 01:00:50', 1);

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
(1, 'Jocsan', 'Ramirez', 'jocsan@gmail.com', '83626991', 'Rio Claro', 'assets/images/perfil/20231117222657jocsan@gmail.com.jpg', '$2y$10$hSZ8sC7jEjI2nWPHDSKjjut3fYk4hbwL45tU7aiN13QVu9OchWKmq', NULL, '2023-11-18 04:26:57', 1, 1),
(2, 'Abdias', 'Ureña', 'abdias@gmail.com', '88997766', 'Rio Claro', 'assets/images/perfil/20231117223355abdias@gmail.com.jpg', '$2y$10$TjXJ374K8GbpImBEFSYHyOtRnEfbdU4NQ1eogBmYU7xVM0L5t1OUW', NULL, '2023-11-18 18:14:44', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbventas`
--

CREATE TABLE `tbventas` (
  `id` int(11) NOT NULL,
  `productos` longtext NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `metodo` varchar(20) NOT NULL,
  `serie` varchar(20) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `apertura` int(11) NOT NULL DEFAULT 1,
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbventas`
--

INSERT INTO `tbventas` (`id`, `productos`, `subtotal`, `iva`, `total`, `fecha`, `hora`, `metodo`, `serie`, `estado`, `apertura`, `id_cliente`, `id_usuario`) VALUES
(1, '[{\"id\":2,\"nombre\":\"CABLE VELOC. YBR125ED DISCO VINI\",\"precio\":\"1200.00\",\"cantidad\":2},{\"id\":3,\"nombre\":\"SWITCH LUCES IZQ. NXR\\/XL200\\/CARGO KGA VINI\",\"precio\":\"2500.00\",\"cantidad\":2}]', 7400.00, 962.00, 8362.00, '2023-11-17', '18:14:05', 'CONTADO', '00000001', 1, 1, 2, 1),
(2, '[{\"id\":9,\"nombre\":\"DISCO SSD M2 NVMe PCOe 1TB\",\"precio\":\"75000.00\",\"cantidad\":5}]', 375000.00, 48750.00, 423750.00, '2023-11-17', '20:38:36', 'CONTADO', '00000002', 1, 1, 2, 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbclientes`
--
ALTER TABLE `tbclientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbcompras`
--
ALTER TABLE `tbcompras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tbmedidas`
--
ALTER TABLE `tbmedidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbproductos`
--
ALTER TABLE `tbproductos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tbproveedor`
--
ALTER TABLE `tbproveedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbusuarios`
--
ALTER TABLE `tbusuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbventas`
--
ALTER TABLE `tbventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
