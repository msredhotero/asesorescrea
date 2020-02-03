-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-02-2020 a las 00:02:32
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
-- Estructura de tabla para la tabla `dbdocumentacionasociados`
--

CREATE TABLE IF NOT EXISTS `dbdocumentacionasociados` (
`iddocumentacionasociado` int(11) NOT NULL,
  `refasociados` int(11) NOT NULL,
  `refdocumentaciones` int(11) NOT NULL,
  `archivo` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `type` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `refestadodocumentaciones` int(11) NOT NULL,
  `fechacrea` datetime NOT NULL,
  `fechamodi` datetime NOT NULL,
  `usuariocrea` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `usuariomodi` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dbdocumentacionasociados`
--
ALTER TABLE `dbdocumentacionasociados`
 ADD PRIMARY KEY (`iddocumentacionasociado`), ADD KEY `fk_das_d_idx` (`refdocumentaciones`), ADD KEY `fk_das_ed_idx` (`refestadodocumentaciones`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dbdocumentacionasociados`
--
ALTER TABLE `dbdocumentacionasociados`
MODIFY `iddocumentacionasociado` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dbdocumentacionasociados`
--
ALTER TABLE `dbdocumentacionasociados`
ADD CONSTRAINT `fk_das_d` FOREIGN KEY (`refdocumentaciones`) REFERENCES `dbdocumentaciones` (`iddocumentacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_das_ed` FOREIGN KEY (`refestadodocumentaciones`) REFERENCES `tbestadodocumentaciones` (`idestadodocumentacion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
