-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-03-2020 a las 22:32:46
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
-- Estructura de tabla para la tabla `dbcotizaciones`
--

CREATE TABLE IF NOT EXISTS `dbcotizaciones` (
`idcotizacion` int(11) NOT NULL,
  `refclientes` int(11) NOT NULL,
  `refproductos` int(11) NOT NULL,
  `refasesores` int(11) NOT NULL,
  `refasociados` int(11) DEFAULT NULL,
  `refestadocotizaciones` int(11) NOT NULL,
  `observaciones` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaemitido` datetime DEFAULT NULL,
  `primaneta` decimal(18,2) DEFAULT NULL,
  `primatotal` decimal(18,2) DEFAULT NULL,
  `recibopago` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechapago` datetime DEFAULT NULL,
  `nrorecibo` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL,
  `importecomisionagente` decimal(18,2) DEFAULT NULL,
  `importebonopromotor` decimal(18,2) DEFAULT NULL,
  `fechacrea` datetime NOT NULL,
  `fechamodi` datetime NOT NULL,
  `usuariocrea` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `usuariomodi` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `refusuarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dbcotizaciones`
--
ALTER TABLE `dbcotizaciones`
 ADD PRIMARY KEY (`idcotizacion`), ADD KEY `fk_cotizaciones_prd_idx` (`refproductos`), ADD KEY `fk_cotizaciones_clie_idx` (`refclientes`), ADD KEY `fk_cotizaciones_ase_idx` (`refasesores`), ADD KEY `fk_cotizaciones_est_idx` (`refestadocotizaciones`), ADD KEY `fk_cotizaciones_usu_idx` (`refusuarios`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dbcotizaciones`
--
ALTER TABLE `dbcotizaciones`
MODIFY `idcotizacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dbcotizaciones`
--
ALTER TABLE `dbcotizaciones`
ADD CONSTRAINT `fk_cotizaciones_ase` FOREIGN KEY (`refasesores`) REFERENCES `dbasesores` (`idasesor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_cotizaciones_clie` FOREIGN KEY (`refclientes`) REFERENCES `dbclientes` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_cotizaciones_est` FOREIGN KEY (`refestadocotizaciones`) REFERENCES `tbestadocotizaciones` (`idestadocotizacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_cotizaciones_prd` FOREIGN KEY (`refproductos`) REFERENCES `tbproductos` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_cotizaciones_usu` FOREIGN KEY (`refusuarios`) REFERENCES `dbusuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
