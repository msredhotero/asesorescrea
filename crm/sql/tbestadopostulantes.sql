-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-11-2019 a las 23:11:23
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
-- Estructura de tabla para la tabla `tbestadopostulantes`
--

CREATE TABLE IF NOT EXISTS `tbestadopostulantes` (
`idestadopostulante` int(11) NOT NULL,
  `estadopostulante` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `orden` int(11) DEFAULT NULL,
  `url` varchar(180) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbestadopostulantes`
--

INSERT INTO `tbestadopostulantes` (`idestadopostulante`, `estadopostulante`, `orden`, `url`) VALUES
(1, 'Registro Inicial', 1, 'index.php'),
(2, 'Pruebas VERITAS', 5, 'entrevistaveritas.php'),
(3, 'Comprobar SIAP', 2, 'siap.php'),
(4, 'Entrevista Regional I', 3, 'entrevistaregional.php'),
(5, 'Pruebas Psicometricas', 4, 'prueba.php'),
(7, 'Registro de Documentacion I', 6, 'index.php'),
(8, 'Registro de Documentacion II', 7, 'index.php'),
(9, 'Rechazado', 99, 'index.php');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbestadopostulantes`
--
ALTER TABLE `tbestadopostulantes`
 ADD PRIMARY KEY (`idestadopostulante`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbestadopostulantes`
--
ALTER TABLE `tbestadopostulantes`
MODIFY `idestadopostulante` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
