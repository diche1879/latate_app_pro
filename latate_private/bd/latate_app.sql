-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-10-2024 a las 09:19:44
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
-- Base de datos: `latate_app`
--
CREATE DATABASE IF NOT EXISTS `latate_app` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `latate_app`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `id_category` int(7) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `category_site` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id_category`, `category_name`, `category_site`) VALUES
(1, 'jacquard50', ''),
(2, 'jacquard20', ''),
(3, 'prints twill', ''),
(4, 'prints organic', ''),
(5, 'prints voile', ''),
(6, 'brodats', 'pasillo 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

CREATE TABLE `clients` (
  `id_client` int(11) NOT NULL,
  `email_client` varchar(30) NOT NULL,
  `username_client` varchar(20) NOT NULL,
  `client_company` varchar(30) NOT NULL,
  `client_nif` varchar(20) NOT NULL,
  `client_phone` varchar(120) NOT NULL,
  `client_country` varchar(30) NOT NULL,
  `client_city` varchar(100) NOT NULL,
  `client_address` varchar(100) NOT NULL,
  `client_p_code` varchar(10) NOT NULL,
  `password_client` varchar(20) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clients`
--

INSERT INTO `clients` (`id_client`, `email_client`, `username_client`, `client_company`, `client_nif`, `client_phone`, `client_country`, `client_city`, `client_address`, `client_p_code`, `password_client`, `id_role`) VALUES
(1, 'telasplus@gmail.com', 'telasplus', '', '', '', '', '', '', '', '$2y$10$0al.Lr3YzkZ2H', 1),
(2, 'tiendatela@gmail.com', 'tiendatela', '', '', '', '', '', '', '', '$2y$10$MkP/MgdH1epv9', 2),
(3, 'latelaPrueba@gmail.com', 'latelaPrueba', '', '', '', '', '', '', '', '$2y$10$jastaoQQgCAmb', 1),
(4, 'tiendaPrueba@gmail.com', 'tiendaPrueba', 'tiendaPrueba&daughter', 't4567889', '+951 56789', 'Canada', 'Vancouver', 'Elmet str.', '90876545', '$2y$10$9D4CGHdJGBCox', 2),
(5, 'clientnovalid@gmail.com', 'ClientNoValid', '', '', '', '', '', '', '', '$2y$10$5PnDsHqovckak', 3),
(8, 'testuser@example.com', 'testuser123', 'Empresa Prueba S.A.', 'A12345678', '+1 (123) 456-7890', 'Estados Unidos', 'San Francisco', '123 Calle Ejemplo, Apt 456', '94105', '$2y$10$cD7t99zCayrO6', 1),
(9, 'cliente@gmail.com', 'cleintePruebaupdate', 'clientePrueba&son', 'y0413362c', '+39 7876543', 'Europa', 'Roma', 'Via Campo dei Fiori', '67100', '$2y$10$LKloNfBiKyJFl', 1),
(10, 'storeprueba@gmail.com', 'storeprueba', 'storeprueba&son', 'y5647389m', '', '', '', '', '', '$2y$10$NdDBvuhN9vYlN', 2),
(11, 'pruebafinal@gmail.com', 'PruebaFinal', 'Prueba & Final', 'e567899', '0078 6574839', 'Europa', 'Barcelona', 'c. dels Calders', '08003', '$2y$10$joUuoJHz6w4SR', 2),
(12, 'hampersand@gmail.com', 'hampersand', 'hampersand&co', 'y75645234c', '645362711', 'europe', 'amsterdam', 'c.dels tulipans', '567483', '$2y$10$5aG5gsYn/b9Du', 2),
(13, 'hampersand2@gmail.com', 'hampersand2', 'hampersand2&com', '564738', '56748329', 'Africa', 'Asmara', 'c. del rio grande', '678594', '$2y$10$WNFdeCzJjr5.K', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `order_amount` decimal(10,2) NOT NULL,
  `order_state` varchar(20) NOT NULL DEFAULT 'processing',
  `order_pdf` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id_order`, `id_client`, `order_date`, `order_amount`, `order_state`, `order_pdf`) VALUES
(1, 1, '2024-10-03 08:33:02', 1234.00, 'processing', 'telasplus_85.pdf'),
(2, 2, '2024-10-03 08:45:03', 125.00, 'processing', 'tiendatela_39.pdf'),
(3, 3, '2024-10-03 08:46:36', 120.00, 'processing', 'latelaPrueba_40.pdf'),
(6, 4, '2024-10-04 08:49:52', 890.00, 'processing', 'tiendaPrue_91.pdf'),
(8, 2, '2024-10-04 10:32:11', 87.00, 'processing', 'tiendatela_16.pdf'),
(9, 3, '2024-10-07 07:43:20', 456.01, 'processing', 'latelaPrueba_27.pdf'),
(10, 1, '2024-10-08 10:10:11', 255.00, 'processing', 'telasplus_72.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_product` int(10) NOT NULL,
  `image` varchar(30) DEFAULT NULL,
  `reference` varchar(10) NOT NULL,
  `article` varchar(20) NOT NULL,
  `composition` varchar(20) NOT NULL,
  `weight` varchar(10) NOT NULL,
  `width` varchar(10) NOT NULL,
  `format` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `price_dos` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `availability` varchar(20) DEFAULT NULL,
  `id_category` int(7) NOT NULL,
  `id_user` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_product`, `image`, `reference`, `article`, `composition`, `weight`, `width`, `format`, `price`, `price_dos`, `stock`, `description`, `availability`, `id_category`, `id_user`) VALUES
(1, NULL, 'J501-01', 'JACQUARD 50 Pink', '100% CO', '300g', '138/140 cm', '5m folded into a 75 cm wide piece', 12.00, 0.00, NULL, NULL, 'yes', 1, 1),
(2, NULL, 'PT120-21', 'Print Twill MT Baby', '100% CO', '110 gr/m2', '148/150cm', '5m folded into a 75 cm wide piece', 10.00, 0.00, NULL, NULL, 'yes', 3, 1),
(4, NULL, 'PT121-21', 'Print Twill MT Baby', '100% CO', '110 gr/m2', '148/150cm', '5m folded into a 75 cm wide piece', 11.00, 0.00, NULL, NULL, 'no', 3, 1),
(5, NULL, 'PO101-21', 'Print Organic MT Ess', '100% CO', '110 gr/m2', '148/150cm', '5m folded into a 75 cm wide piece', 13.00, 0.00, NULL, NULL, 'yes', 4, 1),
(6, NULL, 'PE129-21', 'Print Voile MT Essen', '100% CO', '70 gr/m2', '148/150cm', '5m folded into a 75 cm wide piece', 14.00, 0.00, NULL, NULL, 'yes', 5, 1),
(7, NULL, 'EW301-00', 'EMBROIDERY WHITE 1', '100% COt', '300gr', '148cm', '5m folded into a 75 cm wide piece', 14.00, 0.00, 4, 'no hay descripción', 'yes', 6, 1),
(8, 'prueba_71.jpg', '123fg', 'prueba', '', '', '', '', 12.00, 0.00, 2, NULL, NULL, 4, 6),
(10, '', '322131', 'jacquard', '100% cotton', '300', '140', '5m folded into a 75 cm wide piece', 14.00, 0.00, 3, '', NULL, 1, 6),
(11, '', '4534345', 'pritnt twill', '1112', '3222', '233', 'gdsfgsgre', 12.00, 0.00, 4, '', NULL, 3, 6),
(12, '', 'bret-56', 'prueba2', '100% cotton', '234 gr', '150 200cm', 'sdsdfsddf', 34.00, 0.00, 67, 'sdfsdf', NULL, 5, 6),
(13, '', 'EW301-43', 'doble precio', '100% algodon', '300g', '150cm', '5m folded into a 75 cm wide piece', 15.00, 18.00, 4, 'kjsdhfsdhfias lkdjjfljs', NULL, 6, 6),
(14, '', 'J501-67', 'ProdPruebaDos', 'cotton', '90g', '120cm', '5m folded into a 75 cm wide piece', 14.68, 17.76, 5, '', NULL, 1, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `name_rol` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_role`, `name_rol`) VALUES
(1, 'wholesaler'),
(2, 'store'),
(3, 'denied');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_user` int(7) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_surname` varchar(30) NOT NULL,
  `user` varchar(10) DEFAULT NULL,
  `user_mail` varchar(30) NOT NULL,
  `user_password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_user`, `user_name`, `user_surname`, `user`, `user_mail`, `user_password`) VALUES
(1, 'Latate', 'Latate', 'latatedes', 'latate@gmail.com', 'Latate'),
(3, 'hola', 'mundo', 'holamundo', 'hola@gmail.com', '$2y$10$Xbk.UdCKqyx.lXXzQYzmTeY2Q5mXb7BSgq/hf3j0uBEFcixc/6Neu'),
(6, 'Teresa', 'Gasbarro', 'Tere79', 'teresa79@gmail.com', '$2y$10$VQ3JVYs4qKImieEbLkupG.5exqU8Fyijt2VyWxl5AaOVGOACLPFMO');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Indices de la tabla `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id_client`),
  ADD KEY `id_role` (`id_role`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_client` (`id_client`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `id_category` (`id_category`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `clients`
--
ALTER TABLE `clients`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_product` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_user` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`);

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id_client`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
