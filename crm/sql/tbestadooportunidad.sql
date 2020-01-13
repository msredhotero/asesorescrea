-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-01-2020 a las 20:04:34
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
-- Estructura de tabla para la tabla `tbestadooportunidad`
--

CREATE TABLE IF NOT EXISTS `tbestadooportunidad` (
`idestadooportunidad` int(11) NOT NULL,
  `estadooportunidad` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbestadooportunidad`
--

INSERT INTO `tbestadooportunidad` (`idestadooportunidad`, `estadooportunidad`) VALUES
(1, 'Por Atender'),
(2, 'Cita Programada'),
(3, 'Aceptado'),
(4, 'Rechazado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbestadooportunidad`
--
ALTER TABLE `tbestadooportunidad`
 ADD PRIMARY KEY (`idestadooportunidad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbestadooportunidad`
--
ALTER TABLE `tbestadooportunidad`
MODIFY `idestadooportunidad` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
