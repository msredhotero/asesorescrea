-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-03-2020 a las 22:32:38
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `u115752684_asesores`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbclientes`
--

CREATE TABLE IF NOT EXISTS `dbclientes` (
`idcliente` int(11) NOT NULL,
  `reftipopersonas` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `apellidopaterno` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `apellidomaterno` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `razonsocial` varchar(160) COLLATE utf8_spanish_ci DEFAULT NULL,
  `domicilio` varchar(220) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefonofijo` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefonocelular` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL,
  `rfc` varchar(13) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ine` varchar(13) COLLATE utf8_spanish_ci DEFAULT NULL,
  `numerocliente` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `refusuarios` int(11) DEFAULT '0',
  `fechacrea` datetime NOT NULL,
  `fechamodi` datetime NOT NULL,
  `usuariocrea` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `usuariomodi` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `dbclientes`
--

INSERT INTO `dbclientes` (`idcliente`, `reftipopersonas`, `nombre`, `apellidopaterno`, `apellidomaterno`, `razonsocial`, `domicilio`, `telefonofijo`, `telefonocelular`, `email`, `rfc`, `ine`, `numerocliente`, `refusuarios`, `fechacrea`, `fechamodi`, `usuariocrea`, `usuariomodi`) VALUES
(6, 1, 'marcos', 'saupurein', 'safar', '', '', '', '', '', '', '', 'ASE0000000', 0, '2020-03-03 14:32:44', '2020-03-03 14:32:44', 'msredhotero@msn.com', 'msredhotero@msn.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dbclientes`
--
ALTER TABLE `dbclientes`
 ADD PRIMARY KEY (`idcliente`), ADD KEY `fk_cliente_tipopersona_idx` (`reftipopersonas`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dbclientes`
--
ALTER TABLE `dbclientes`
MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dbclientes`
--
ALTER TABLE `dbclientes`
ADD CONSTRAINT `fk_cliente_tipopersona` FOREIGN KEY (`reftipopersonas`) REFERENCES `tbtipopersonas` (`idtipopersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
