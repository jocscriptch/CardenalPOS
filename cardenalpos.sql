-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2023 a las 14:59:17
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

--
-- Volcado de datos para la tabla `tbabonos`
--

INSERT INTO `tbabonos` (`id`, `abono`, `fecha`, `id_credito`) VALUES
(1, 5000.00, '2023-11-02 06:23:23', 1),
(2, 3362.00, '2023-11-04 06:28:30', 1);

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
  `fecha` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbcategorias`
--

INSERT INTO `tbcategorias` (`id`, `categoria`, `fecha`, `estado`) VALUES
(1, 'SIN CATEGORIA', '2023-10-31 18:28:41', 1),
(2, 'CABLES', '2023-11-01 15:20:40', 1),
(3, 'TRANSMISIONES', '2023-11-01 20:57:40', 1),
(4, 'SUSPENSIONES', '2023-11-01 20:57:45', 1),
(5, 'MOTOR', '2023-11-01 20:57:47', 1);

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
(1, 'Nacional', '602070058', 'FLORES HERRERA ALEXANDER', '88774422', NULL, '<p>NO DIR</p>', '2023-11-03 23:52:18', 1),
(2, 'Nacional', '604650775', 'ROJAS ORTIZ ANGEL DAVID', '60551122', NULL, '<p>PUNTARENAS</p>', '2023-11-04 04:29:37', 1);

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
(1, '[{\"id\":1,\"nombre\":\"CABLE VELOC. YBR125ED DISCO VINI\",\"precio\":\"950.00\",\"cantidad\":10},{\"id\":2,\"nombre\":\"SWITCH LUCES IZQ. NXR\\/XL200\\/CARGO KGA VINI\",\"precio\":\"2245.00\",\"cantidad\":9}]', 29705.00, 3861.65, 33566.65, '2023-11-03', '22:34:19', '1744820040', 1, 2, 1);

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
(1, '604200530', 'Moto Repuestos Cardenal', '84503737', 'motorepuestoscardenal@hotmail.com', 'LA COLONIA, GUAYCARA, GOLFITO, PUNTARENAS, COSTA RICA', '<p><strong>¡GRACIAS POR SU PREFERENCIA!</strong></p>', 13);

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

--
-- Volcado de datos para la tabla `tbcotizaciones`
--

INSERT INTO `tbcotizaciones` (`id`, `productos`, `subtotal`, `iva`, `total`, `fecha`, `hora`, `metodo`, `validez`, `id_cliente`) VALUES
(1, '[{\"id\":1,\"nombre\":\"CABLE VELOC. YBR125ED DISCO VINI\",\"precio\":\"1200.00\",\"cantidad\":1},{\"id\":3,\"nombre\":\"STOP.U PIRAMIDAL XR200 UNIVER. TW\",\"precio\":\"2500.00\",\"cantidad\":1}]', 3700.00, 481.00, 4181.00, '2023-11-04', '14:29:18', 'CONTADO', '15 DIAS', 2),
(2, '[{\"id\":1,\"nombre\":\"CABLE VELOC. YBR125ED DISCO VINI\",\"precio\":\"1200.00\",\"cantidad\":6}]', 7200.00, 936.00, 8136.00, '2023-11-04', '14:52:30', 'CONTADO', '5 DIAS', 2),
(3, '[{\"id\":3,\"nombre\":\"STOP.U PIRAMIDAL XR200 UNIVER. TW\",\"precio\":\"2500.00\",\"cantidad\":4}]', 10000.00, 1300.00, 11300.00, '2023-11-04', '14:55:08', 'CREDITO', '20 DIAS', 1);

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

--
-- Volcado de datos para la tabla `tbcreditos`
--

INSERT INTO `tbcreditos` (`id`, `monto`, `fecha`, `hora`, `estado`, `id_venta`) VALUES
(1, 8362.00, '2023-11-04', '00:22:24', 0, 1);

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
(1, 'LITROS', 'LT', '2023-10-31 23:20:33', 1),
(2, 'UNIDAD', 'UNID', '2023-10-31 23:21:22', 1),
(3, 'CENTIMETROS', 'CM', '2023-10-31 23:20:50', 1),
(4, 'METROS', 'MT', '2023-10-31 23:20:57', 1),
(5, 'PULGADAS', 'IN', '2023-10-31 23:21:08', 1),
(6, 'MILILITROS', 'ML', '2023-11-02 02:57:16', 1);

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
(1, '8433332', 'CABLE VELOC. YBR125ED DISCO VINI', 950.00, 1200.00, 6, NULL, 1, '2023-11-04 06:22:24', 0, 2, 2),
(2, '8462370', 'SWITCH LUCES IZQ. NXR/XL200/CARGO KGA VINI', 2245.00, 2500.00, 6, NULL, 1, '2023-11-04 06:22:24', 0, 2, 1),
(3, '8468266', 'STOP.U PIRAMIDAL XR200 UNIVER. TW', 2280.00, 2500.00, 2, NULL, 1, '2023-11-03 23:53:39', 0, 2, 1),
(4, '5420181', 'LL.17 80/80x17 K-6309 41P TL', 12970.00, 13550.00, 2, NULL, 1, '2023-11-03 23:53:39', 0, 2, 1),
(5, '5420596', 'LL.17 90/90x17 K-6309 49P TL', 23180.00, 25000.00, 1, NULL, 1, '2023-11-03 23:53:39', 0, 2, 1),
(6, '5420166', 'LL.18 120/80x18 K-6309 62P TL', 24800.00, 26000.00, 1, NULL, 1, '2023-11-04 00:16:22', 0, 2, 2),
(7, '5420191', 'LL.21 90/90x21 K-6309 54P', 15900.00, 16500.00, 1, NULL, 1, '2023-11-03 23:53:39', 0, 2, 1),
(8, '5420526', 'LL.19 90/90x19 K-669 52P', 18720.00, 19500.00, 2, NULL, 1, '2023-11-03 23:53:39', 0, 2, 2);

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
(1, 'Repuestos Gigante', '88774452', 'repuestosgigantes@gmail.com', '<p>San Jose</p>', '2023-11-02 02:59:28', 1),
(2, 'Grupo FAVARCIA S.A.', '24539200', 'grupofavarcia@gmail.com', '<p>ALAJUELA, PALMARES Contiguo Campo Ferial Palmares</p>', '2023-11-02 02:42:12', 1);

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
(1, 'Jocsan', 'Ramirez', 'jocsan@gmail.com', '83626991', 'Rio Claro', NULL, '$2y$10$xM4gBea0ngb6DLuK.wIkXeYlervooaEu2uhVBruyU.cMeOTBGpXLO', NULL, '2023-10-31 23:13:08', 1, 1),
(2, 'Abdias', 'Ureña Soto', 'abdias@gmail.com', '88888888', 'Rio Claro', NULL, '$2y$10$3J52Q23XgfBAU8mZhQyAhO3qGUqyAcGmS3Q2KUrX3rCK/y0OxwRbe', NULL, '2023-11-01 00:25:55', 1, 1),
(3, 'Antony', 'Valverder Rojas', 'gato@gmail.com', '88667755', 'La Esperanza', NULL, '$2y$10$2bHkXrfhRZo1gLn/ytqDz.AFSUwjk3g9Qq25BtkX/fgqLcgwClLZu', NULL, '2023-11-02 02:56:42', 1, 2);

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
(1, '[{\"id\":1,\"nombre\":\"CABLE VELOC. YBR125ED DISCO VINI\",\"precio\":\"1200.00\",\"cantidad\":2},{\"id\":2,\"nombre\":\"SWITCH LUCES IZQ. NXR\\/XL200\\/CARGO KGA VINI\",\"precio\":\"2500.00\",\"cantidad\":2}]', 7400.00, 962.00, 8362.00, '2023-11-04', '00:22:24', 'CREDITO', '00000001', 1, 1, 2, 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbconfiguracion`
--
ALTER TABLE `tbconfiguracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbcotizaciones`
--
ALTER TABLE `tbcotizaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbcreditos`
--
ALTER TABLE `tbcreditos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tbproveedor`
--
ALTER TABLE `tbproveedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbusuarios`
--
ALTER TABLE `tbusuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbventas`
--
ALTER TABLE `tbventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
