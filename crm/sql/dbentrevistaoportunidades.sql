-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-01-2020 a las 20:04:53
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
-- Estructura de tabla para la tabla `dbentrevistaoportunidades`
--

CREATE TABLE IF NOT EXISTS `dbentrevistaoportunidades` (
`identrevistaoportunidad` int(11) NOT NULL,
  `refoportunidades` int(11) NOT NULL,
  `entrevistador` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `domicilio` varchar(199) COLLATE utf8_spanish_ci NOT NULL,
  `codigopostal` int(11) NOT NULL,
  `refestadoentrevistas` int(11) NOT NULL,
  `fechacrea` datetime NOT NULL,
  `fechamodi` datetime NOT NULL,
  `usuariocrea` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `usuariomodi` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dbentrevistaoportunidades`
--
ALTER TABLE `dbentrevistaoportunidades`
 ADD PRIMARY KEY (`identrevistaoportunidad`), ADD KEY `fk_eo_o_idx` (`refoportunidades`), ADD KEY `fk_eo_est_idx` (`refestadoentrevistas`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dbentrevistaoportunidades`
--
ALTER TABLE `dbentrevistaoportunidades`
MODIFY `identrevistaoportunidad` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dbentrevistaoportunidades`
--
ALTER TABLE `dbentrevistaoportunidades`
ADD CONSTRAINT `fk_eo_est` FOREIGN KEY (`refestadoentrevistas`) REFERENCES `tbestadoentrevistas` (`idestadoentrevista`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_eo_o` FOREIGN KEY (`refoportunidades`) REFERENCES `dboportunidades` (`idoportunidad`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
