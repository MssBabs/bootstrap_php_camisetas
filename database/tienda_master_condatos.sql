-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 14-12-2021 a las 23:19:41
-- Versión del servidor: 8.0.27-0ubuntu0.20.04.1
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_master`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Manga Corta'),
(3, 'Manga larga'),
(4, 'Sudaderas'),
(5, 'POP'),
(11, 'Tirantes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas_pedidos`
--

CREATE TABLE `lineas_pedidos` (
  `id` int NOT NULL,
  `pedido_id` int NOT NULL,
  `producto_id` int NOT NULL,
  `unidades` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `lineas_pedidos`
--

INSERT INTO `lineas_pedidos` (`id`, `pedido_id`, `producto_id`, `unidades`) VALUES
(1, 1, 7, 1),
(2, 1, 6, 38),
(3, 1, 1, 1),
(4, 2, 7, 1),
(5, 2, 12, 20),
(6, 2, 9, 1),
(7, 2, 8, 2),
(8, 3, 7, 1),
(9, 3, 12, 1),
(10, 3, 9, 1),
(11, 3, 8, 3),
(13, 5, 8, 1),
(14, 5, 6, 1),
(15, 5, 10, 1),
(19, 7, 8, 1),
(20, 7, 6, 1),
(21, 7, 10, 1),
(22, 8, 3, 1),
(23, 8, 6, 1),
(24, 8, 12, 1),
(25, 9, 5, 1),
(26, 9, 1, 1),
(27, 10, 7, 1),
(28, 11, 12, 2),
(29, 11, 8, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `localidad` varchar(100) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `coste` float(200,2) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `provincia`, `localidad`, `direccion`, `coste`, `estado`, `fecha`, `hora`) VALUES
(1, 1, 'Madrid', 'skdjfkas', 'asdfasd', 807.00, 'sended', '2020-12-28', '13:08:56'),
(2, 3, 'Sevilla', 'Sevilla', 'C/ del Pez, 25', 108.00, 'sended', '2020-12-28', '13:22:06'),
(3, 3, 'Murcia', 'Murcia', 'C/ sol', 124.00, 'confirm', '2020-12-28', '13:23:40'),
(5, 1, 'Madrid', 'Madrid', 'C/ del Pez, 25', 46.00, 'confirm', '2020-12-28', '14:07:07'),
(7, 1, 'Segovia', 'Sepulveda', 'C/ Azoge', 46.00, 'confirm', '2020-12-28', '14:35:59'),
(8, 7, 'Sevilla', 'Murcia', 'Cosa', 48.00, 'confirm', '2021-01-04', '13:48:44'),
(9, 1, 'asdf', 'asdf', 'sadfs', 35.00, 'confirm', '2021-01-21', '22:00:55'),
(10, 14, 'sadf', 'asdf', 'asdf', 37.00, 'confirm', '2021-01-21', '22:40:32'),
(11, 7, 'Madrid', 'Fuenlabrada', 'C/ del pez, 23', 44.80, 'confirm', '2021-12-14', '22:56:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int NOT NULL,
  `categoria_id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  `precio` float(100,2) NOT NULL,
  `stock` int NOT NULL,
  `oferta` varchar(2) DEFAULT NULL,
  `fecha` date NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `descripcion`, `precio`, `stock`, `oferta`, `fecha`, `imagen`) VALUES
(1, 1, 'Modelo A', 'Camisa sencilla a rayas', 10.00, 20, 'no', '2020-12-15', 'ghd.jpg'),
(2, 1, 'Modelo B', 'Marinero', 12.00, 5, 'no', '2020-12-15', 'hmgoepprod.jpg'),
(3, 1, 'Sencilla gris', 'Sencilla gris\r\n', 12.00, 4, 'si', '2020-12-15', 'uuu.jpg'),
(5, 4, 'Sudadera gris G1', 'Sudadera gris básica', 25.00, 10, 'si', '2020-12-28', 'sudaderagris.jpg'),
(6, 3, 'Larga R1', 'Camisa larga gris', 20.00, 3, 'no', '2020-12-28', 'largagris.jpg'),
(7, 4, 'Sudadera yellow', 'Sudadera amarilla', 37.00, 3, 'no', '2020-12-28', 'sudaderaamarilla.jpg'),
(8, 5, 'minion girl', 'Chica minion', 16.00, 0, 'no', '2020-12-28', 'pop02.jpg'),
(9, 5, 'night king', 'Rey de la noche', 23.00, 1, 'no', '2020-12-28', 'pop01.jpeg'),
(10, 11, 'Sencilla negra', 'Tirantes sencilla negra', 8.10, 0, 'si', '2020-12-28', 'tirantesnegra.jpg'),
(11, 3, 'larga bicolor', 'larga bicolor', 21.06, 2, 'si', '2020-12-28', 'largaroja.jpg'),
(12, 5, 'Live to ride', 'Motocicleta', 14.40, 2, 'no', '2020-12-28', 'pop03.jpg'),
(13, 11, 'Tirantes azul', 'Sencilla azul', 4.05, 2, 'no', '2021-02-04', 'tirantesazul.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(20) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
-- TODOS LOS USUARIOS TIENE EN ESTA PRUEBA LA MISMA CONTRASEÑA: secreto
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `password`, `rol`, `imagen`) VALUES
(1, 'Admin', 'Admin', 'admin@admin.com', '$2y$04$ZXAzQItgQpM9SIK8c9uzB.fVToPCDUj8V6W0.sV.vsrPPjSsLuI8q', 'admin', NULL),
(3, 'Miguel ', 'García López', 'cosa01@iestetuan.es', '$2y$04$ZXAzQItgQpM9SIK8c9uzB.fVToPCDUj8V6W0.sV.vsrPPjSsLuI8q', 'user', NULL),
(7, 'alberto', 'lopez', 'alberto@es.es', '$2y$04$ZXAzQItgQpM9SIK8c9uzB.fVToPCDUj8V6W0.sV.vsrPPjSsLuI8q', 'user', NULL),
(14, 'pepe1', 'López', 'pepe@pepe.es', '$2y$04$ZXAzQItgQpM9SIK8c9uzB.fVToPCDUj8V6W0.sV.vsrPPjSsLuI8q', 'user', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_linea_pedido` (`pedido_id`),
  ADD KEY `fk_linea_producto` (`producto_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedido_usuario` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_producto_categoria` (`categoria_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  ADD CONSTRAINT `fk_linea_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `fk_linea_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
