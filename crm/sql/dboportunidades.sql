-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-01-2020 a las 20:04:48
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
-- Estructura de tabla para la tabla `dboportunidades`
--

CREATE TABLE IF NOT EXISTS `dboportunidades` (
`idoportunidad` int(11) NOT NULL,
  `nombredespacho` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `persona` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL,
  `refusuarios` int(11) NOT NULL,
  `refreferentes` int(11) DEFAULT NULL,
  `refestadooportunidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dboportunidades`
--
ALTER TABLE `dboportunidades`
 ADD PRIMARY KEY (`idoportunidad`), ADD KEY `fk_o_usu_idx` (`refusuarios`), ADD KEY `fk_o_est_idx` (`refestadooportunidad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dboportunidades`
--
ALTER TABLE `dboportunidades`
MODIFY `idoportunidad` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dboportunidades`
--
ALTER TABLE `dboportunidades`
ADD CONSTRAINT `fk_o_est` FOREIGN KEY (`refestadooportunidad`) REFERENCES `tbestadooportunidad` (`idestadooportunidad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_o_usu` FOREIGN KEY (`refusuarios`) REFERENCES `dbusuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
