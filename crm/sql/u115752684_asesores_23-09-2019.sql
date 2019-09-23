-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-09-2019 a las 18:39:39
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
  `nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `sexo` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `refestadocivil` int(11) NOT NULL,
  `rfc` varchar(13) COLLATE utf8_spanish_ci NOT NULL,
  `curp` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `fechanacimiento` date NOT NULL,
  `numerocliente` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `nacionalidad` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `refpromotores` int(11) DEFAULT NULL,
  `refrolhogar` int(11) NOT NULL,
  `reftipoclientes` int(11) NOT NULL,
  `refentidadnacimiento` int(11) NOT NULL,
  `fechacrea` datetime NOT NULL,
  `fechamodi` datetime NOT NULL,
  `usuariocrea` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `usuariomodi` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbdocumentacionsolicitudes`
--

CREATE TABLE IF NOT EXISTS `dbdocumentacionsolicitudes` (
`iddocumentacionsolicitud` int(11) NOT NULL,
  `refsolicitudes` int(11) NOT NULL,
  `documentacion` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `obligatoria` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `cantidadarchivos` int(11) NOT NULL,
  `fechacrea` datetime NOT NULL,
  `fechamodi` datetime NOT NULL,
  `usuariocrea` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `usuariomodi` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbdocumentacionsolicitudesarchivos`
--

CREATE TABLE IF NOT EXISTS `dbdocumentacionsolicitudesarchivos` (
`iddocumentacionsolicitudarchivo` int(11) NOT NULL,
  `refsolicitudes` int(11) NOT NULL,
  `refdocumentacionsolicitudes` int(11) NOT NULL,
  `archivo` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `type` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `refestadoarchivos` int(11) NOT NULL,
  `fechacrea` datetime NOT NULL,
  `fechamodi` datetime NOT NULL,
  `usuariocrea` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `usuariomodi` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbpromotores`
--

CREATE TABLE IF NOT EXISTS `dbpromotores` (
`idpromotor` int(11) NOT NULL,
  `reftipopromotores` int(11) NOT NULL,
  `refusuarios` int(11) DEFAULT NULL,
  `nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `rfc` varchar(13) COLLATE utf8_spanish_ci DEFAULT NULL,
  `curp` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `comision` decimal(18,2) DEFAULT NULL,
  `teloficina` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telparticular` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telmovil` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `refpromotorestados` int(11) DEFAULT NULL,
  `refsucursales` int(11) DEFAULT NULL,
  `refsupervisorusuario` int(11) DEFAULT NULL,
  `fechacrea` datetime DEFAULT NULL,
  `fechamodi` datetime DEFAULT NULL,
  `usuariocrea` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuariomodi` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbsolicitudes`
--

CREATE TABLE IF NOT EXISTS `dbsolicitudes` (
`idsolicitud` int(11) NOT NULL,
  `reftiposolicitudes` int(11) NOT NULL,
  `refestadosolicitudes` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `fechanacimiento` date NOT NULL,
  `telefono` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `sexo` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `codigopostal` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `reftipoingreso` int(11) NOT NULL,
  `refclientes` int(11) DEFAULT NULL,
  `refusuarios` int(11) DEFAULT NULL,
  `fechacrea` datetime NOT NULL,
  `fechamodi` datetime NOT NULL,
  `usuariocrea` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `usuariomodi` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbsucursales`
--

CREATE TABLE IF NOT EXISTS `dbsucursales` (
`idsucursal` int(11) NOT NULL,
  `refentidades` int(11) NOT NULL,
  `calle` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `colonia` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `ciudad` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `codigopostal` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `lada` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fax` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `contacto` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL,
  `refpadre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbusuarios`
--

CREATE TABLE IF NOT EXISTS `dbusuarios` (
`idusuario` int(11) NOT NULL,
  `usuario` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `refroles` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nombrecompleto` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `activo` bit(1) DEFAULT b'0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `dbusuarios`
--

INSERT INTO `dbusuarios` (`idusuario`, `usuario`, `password`, `refroles`, `email`, `nombrecompleto`, `activo`) VALUES
(1, 'Marcos', 'marcos', 1, 'msredhotero@msn.com', 'Saupurein Marcos', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `predio_menu`
--

CREATE TABLE IF NOT EXISTS `predio_menu` (
`idmenu` int(11) NOT NULL,
  `url` varchar(65) COLLATE utf8_spanish_ci NOT NULL,
  `icono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Orden` smallint(6) DEFAULT NULL,
  `hover` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `permiso` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `administracion` bit(1) DEFAULT NULL,
  `torneo` bit(1) DEFAULT NULL,
  `reportes` bit(1) DEFAULT NULL,
  `grupo` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `predio_menu`
--

INSERT INTO `predio_menu` (`idmenu`, `url`, `icono`, `nombre`, `Orden`, `hover`, `permiso`, `administracion`, `torneo`, `reportes`, `grupo`) VALUES
(13, '../index.php', 'dashboard', 'Dashboard', 1, NULL, 'Administrador', b'1', b'1', b'0', 0),
(19, '../clientes/', 'people_outline', 'Clientes', 2, NULL, 'Administrador', b'1', b'0', b'0', 0),
(20, '../usuarios/', 'account_circle', 'Usuarios', 12, NULL, 'Administrador', b'1', b'0', b'0', 0),
(21, '../sucursal/', 'chevron_right', 'Sucursal', 9, NULL, 'Administrador', b'1', b'0', b'0', 3),
(23, '../entidades/', 'chevron_right', 'Entidades', 4, NULL, 'Administrador', b'1', b'0', b'0', 3),
(24, '../documentaciones/', 'chevron_right', 'Documentaciones', 6, NULL, 'Administrador', b'1', b'0', b'0', 3),
(26, '../solicitudes/', 'date_range', 'Solicitudes', 3, NULL, 'Administrador', b'1', b'1', b'1', 0),
(27, '../promotores/', 'chevron_right', 'Promotores', 10, NULL, 'Administrador', b'1', b'1', b'1', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbconfiguracion`
--

CREATE TABLE IF NOT EXISTS `tbconfiguracion` (
`idconfiguracion` int(11) NOT NULL,
  `razonsocial` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `empresa` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `sistema` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbconfiguracion`
--

INSERT INTO `tbconfiguracion` (`idconfiguracion`, `razonsocial`, `empresa`, `sistema`, `direccion`, `telefono`, `email`) VALUES
(1, 'Asesores CREA', 'Asesores CREA', 'CRM Asesores CREA', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbentidades`
--

CREATE TABLE IF NOT EXISTS `tbentidades` (
`identidad` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(2) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbentidades`
--

INSERT INTO `tbentidades` (`identidad`, `nombre`, `clave`) VALUES
(1, 'DISTRITO FEDERAL', 'DF'),
(2, 'ESTADO DE MEXICO', 'ME'),
(3, 'PUEBLA', 'PU'),
(5, 'SIN ENTIDAD', ''),
(6, 'HIDALGO', 'HG'),
(7, 'COLIMA', 'CO'),
(9, 'CIUDAD DE MEXICO', ''),
(15, 'ESTADO DE MEXICO', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbentidadnacimiento`
--

CREATE TABLE IF NOT EXISTS `tbentidadnacimiento` (
`identidadnacimiento` int(11) NOT NULL,
  `entidadnacimiento` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(2) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbentidadnacimiento`
--

INSERT INTO `tbentidadnacimiento` (`identidadnacimiento`, `entidadnacimiento`, `clave`) VALUES
(1, 'AGUASCALIENTES', 'AS'),
(2, 'BAJA CALIFORNIA NTE.', 'BC'),
(3, 'BAJA CALIFORNIA SUR', 'BS'),
(4, 'CAMPECHE', 'CC'),
(5, 'COAHUILA ', 'CL'),
(6, 'COLIMA ', 'CM'),
(7, 'CHIAPAS', 'CS'),
(8, 'CHIHUAHUA', 'CH'),
(9, 'DISTRITO FEDERAL', 'DF'),
(10, 'DURANGO', 'DG'),
(11, 'GUANAJUATO', 'GT'),
(12, 'GUERRERO', 'GR'),
(13, 'HIDALGO', 'HG'),
(14, 'JALISCO', 'JC'),
(15, 'MEXICO', 'MC'),
(16, 'MICHOACAN', 'MN'),
(17, 'MORELOS', 'MS'),
(18, 'NAYARIT', 'NT'),
(19, 'NUEVO LEON', 'NL'),
(20, 'OAXACA', 'OC'),
(21, 'PUEBLA', 'PL'),
(22, 'QUERETARO', 'QT'),
(23, 'QUINTANA ROO', 'QR'),
(24, 'SAN LUIS POTOSI', 'SP'),
(25, 'SINALOA', 'SL'),
(26, 'SONORA', 'SR'),
(27, 'TABASCO', 'TC'),
(28, 'TAMAULIPAS', 'TS'),
(29, 'TLAXCALA', 'TL'),
(30, 'VERACRUZ', 'VZ'),
(31, 'YUCATAN', 'YN'),
(32, 'ZACATECAS', 'ZS'),
(33, 'SERV. EXTERIOR MEXICANO ', 'SM'),
(34, 'NACIDO EN EL EXTRANJERO ', 'NE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbestadocivil`
--

CREATE TABLE IF NOT EXISTS `tbestadocivil` (
`idestadocivil` int(11) NOT NULL,
  `estadocivil` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbestadocivil`
--

INSERT INTO `tbestadocivil` (`idestadocivil`, `estadocivil`) VALUES
(1, 'SOLTERO(A)'),
(2, 'CASADO(A)'),
(3, 'UNION LIBRE'),
(4, 'DIVORCIADO(A)'),
(6, 'VIUDO(A)'),
(7, 'SEPARADO(A)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbestadosolicitudes`
--

CREATE TABLE IF NOT EXISTS `tbestadosolicitudes` (
`idestadosolicitud` int(11) NOT NULL,
  `estadosolicitud` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbestadosolicitudes`
--

INSERT INTO `tbestadosolicitudes` (`idestadosolicitud`, `estadosolicitud`) VALUES
(1, 'Iniciado'),
(2, 'Pre-Analisis'),
(3, 'Aprobado'),
(4, 'Ortorgado'),
(5, 'Liquidado'),
(6, 'Cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbpromotorestados`
--

CREATE TABLE IF NOT EXISTS `tbpromotorestados` (
`idpromotorestado` int(11) NOT NULL,
  `promotorestado` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbpromotorestados`
--

INSERT INTO `tbpromotorestados` (`idpromotorestado`, `promotorestado`) VALUES
(1, 'Activo'),
(2, 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbroles`
--

CREATE TABLE IF NOT EXISTS `tbroles` (
`idrol` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `activo` bit(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbroles`
--

INSERT INTO `tbroles` (`idrol`, `descripcion`, `activo`) VALUES
(1, 'Administrador', b'1'),
(2, 'Supervisor', b'1'),
(3, 'Asesor', b'1'),
(4, 'Cliente', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbrolhogar`
--

CREATE TABLE IF NOT EXISTS `tbrolhogar` (
`idrolhogar` int(11) NOT NULL,
  `rolhogar` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbrolhogar`
--

INSERT INTO `tbrolhogar` (`idrolhogar`, `rolhogar`) VALUES
(1, 'JEFE(A) DE FAMILIA'),
(2, 'ESPOSO(A)'),
(3, 'HIJO(A)'),
(4, 'OTRO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtipoclientes`
--

CREATE TABLE IF NOT EXISTS `tbtipoclientes` (
`idtipocliente` int(11) NOT NULL,
  `tipocliente` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbtipoclientes`
--

INSERT INTO `tbtipoclientes` (`idtipocliente`, `tipocliente`) VALUES
(1, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtipoingreso`
--

CREATE TABLE IF NOT EXISTS `tbtipoingreso` (
`idtipoingreso` int(11) NOT NULL,
  `tipoingreso` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbtipoingreso`
--

INSERT INTO `tbtipoingreso` (`idtipoingreso`, `tipoingreso`) VALUES
(1, 'Por Web'),
(2, 'Por CRM - Cliente'),
(3, 'Por CRM - Manual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtipopromotores`
--

CREATE TABLE IF NOT EXISTS `tbtipopromotores` (
`idtipopromotor` int(11) NOT NULL,
  `tipopromotor` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbtipopromotores`
--

INSERT INTO `tbtipopromotores` (`idtipopromotor`, `tipopromotor`) VALUES
(1, 'Contrato'),
(2, 'Eventual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtiposolicitudes`
--

CREATE TABLE IF NOT EXISTS `tbtiposolicitudes` (
`idtiposolicitud` int(11) NOT NULL,
  `tiposolicitud` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `condocumentacion` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `tope` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbtiposolicitudes`
--

INSERT INTO `tbtiposolicitudes` (`idtiposolicitud`, `tiposolicitud`, `condocumentacion`, `tope`) VALUES
(1, 'Seguro de Auto', '1', 1),
(2, 'Gastos Medicos', '1', 1),
(3, 'TELMEX Inbursa Integral', '1', 1),
(4, 'Gastos Medicos Bajo Costo - VRIM', '1', 1),
(5, 'Vida Express', '1', 1),
(6, 'Terminal Punto de Venta', '1', 1),
(7, 'Tarjeta de Credito', '1', 1),
(8, 'TELMEX Credito', '1', 1),
(9, 'Gastos Medicos Bajo Costo - Sevi', '1', 1),
(10, 'Gastos Medicos Bajo Costo - Cancer', '1', 1),
(11, 'Gastos Medicos Bajo Costo - Inbursa Medic', '1', 1),
(12, 'Credito Hipotecario - Mejora', '1', 1),
(13, 'Credito Hipotecario - Nuevo', '1', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dbclientes`
--
ALTER TABLE `dbclientes`
 ADD PRIMARY KEY (`idcliente`);

--
-- Indices de la tabla `dbdocumentacionsolicitudes`
--
ALTER TABLE `dbdocumentacionsolicitudes`
 ADD PRIMARY KEY (`iddocumentacionsolicitud`);

--
-- Indices de la tabla `dbdocumentacionsolicitudesarchivos`
--
ALTER TABLE `dbdocumentacionsolicitudesarchivos`
 ADD PRIMARY KEY (`iddocumentacionsolicitudarchivo`);

--
-- Indices de la tabla `dbpromotores`
--
ALTER TABLE `dbpromotores`
 ADD PRIMARY KEY (`idpromotor`);

--
-- Indices de la tabla `dbsolicitudes`
--
ALTER TABLE `dbsolicitudes`
 ADD PRIMARY KEY (`idsolicitud`);

--
-- Indices de la tabla `dbsucursales`
--
ALTER TABLE `dbsucursales`
 ADD PRIMARY KEY (`idsucursal`);

--
-- Indices de la tabla `dbusuarios`
--
ALTER TABLE `dbusuarios`
 ADD PRIMARY KEY (`idusuario`), ADD KEY `fk_dbusuarios_tbroles1_idx` (`refroles`);

--
-- Indices de la tabla `predio_menu`
--
ALTER TABLE `predio_menu`
 ADD PRIMARY KEY (`idmenu`);

--
-- Indices de la tabla `tbconfiguracion`
--
ALTER TABLE `tbconfiguracion`
 ADD PRIMARY KEY (`idconfiguracion`);

--
-- Indices de la tabla `tbentidades`
--
ALTER TABLE `tbentidades`
 ADD PRIMARY KEY (`identidad`);

--
-- Indices de la tabla `tbentidadnacimiento`
--
ALTER TABLE `tbentidadnacimiento`
 ADD PRIMARY KEY (`identidadnacimiento`);

--
-- Indices de la tabla `tbestadocivil`
--
ALTER TABLE `tbestadocivil`
 ADD PRIMARY KEY (`idestadocivil`);

--
-- Indices de la tabla `tbestadosolicitudes`
--
ALTER TABLE `tbestadosolicitudes`
 ADD PRIMARY KEY (`idestadosolicitud`);

--
-- Indices de la tabla `tbpromotorestados`
--
ALTER TABLE `tbpromotorestados`
 ADD PRIMARY KEY (`idpromotorestado`);

--
-- Indices de la tabla `tbroles`
--
ALTER TABLE `tbroles`
 ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `tbrolhogar`
--
ALTER TABLE `tbrolhogar`
 ADD PRIMARY KEY (`idrolhogar`);

--
-- Indices de la tabla `tbtipoclientes`
--
ALTER TABLE `tbtipoclientes`
 ADD PRIMARY KEY (`idtipocliente`);

--
-- Indices de la tabla `tbtipoingreso`
--
ALTER TABLE `tbtipoingreso`
 ADD PRIMARY KEY (`idtipoingreso`);

--
-- Indices de la tabla `tbtipopromotores`
--
ALTER TABLE `tbtipopromotores`
 ADD PRIMARY KEY (`idtipopromotor`);

--
-- Indices de la tabla `tbtiposolicitudes`
--
ALTER TABLE `tbtiposolicitudes`
 ADD PRIMARY KEY (`idtiposolicitud`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dbclientes`
--
ALTER TABLE `dbclientes`
MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `dbdocumentacionsolicitudes`
--
ALTER TABLE `dbdocumentacionsolicitudes`
MODIFY `iddocumentacionsolicitud` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `dbdocumentacionsolicitudesarchivos`
--
ALTER TABLE `dbdocumentacionsolicitudesarchivos`
MODIFY `iddocumentacionsolicitudarchivo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `dbpromotores`
--
ALTER TABLE `dbpromotores`
MODIFY `idpromotor` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `dbsolicitudes`
--
ALTER TABLE `dbsolicitudes`
MODIFY `idsolicitud` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `dbsucursales`
--
ALTER TABLE `dbsucursales`
MODIFY `idsucursal` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `dbusuarios`
--
ALTER TABLE `dbusuarios`
MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `predio_menu`
--
ALTER TABLE `predio_menu`
MODIFY `idmenu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT de la tabla `tbconfiguracion`
--
ALTER TABLE `tbconfiguracion`
MODIFY `idconfiguracion` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tbentidades`
--
ALTER TABLE `tbentidades`
MODIFY `identidad` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `tbentidadnacimiento`
--
ALTER TABLE `tbentidadnacimiento`
MODIFY `identidadnacimiento` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT de la tabla `tbestadocivil`
--
ALTER TABLE `tbestadocivil`
MODIFY `idestadocivil` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `tbestadosolicitudes`
--
ALTER TABLE `tbestadosolicitudes`
MODIFY `idestadosolicitud` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `tbpromotorestados`
--
ALTER TABLE `tbpromotorestados`
MODIFY `idpromotorestado` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tbroles`
--
ALTER TABLE `tbroles`
MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `tbrolhogar`
--
ALTER TABLE `tbrolhogar`
MODIFY `idrolhogar` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `tbtipoclientes`
--
ALTER TABLE `tbtipoclientes`
MODIFY `idtipocliente` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tbtipoingreso`
--
ALTER TABLE `tbtipoingreso`
MODIFY `idtipoingreso` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `tbtipopromotores`
--
ALTER TABLE `tbtipopromotores`
MODIFY `idtipopromotor` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tbtiposolicitudes`
--
ALTER TABLE `tbtiposolicitudes`
MODIFY `idtiposolicitud` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dbusuarios`
--
ALTER TABLE `dbusuarios`
ADD CONSTRAINT `fk_usua_roles` FOREIGN KEY (`refroles`) REFERENCES `tbroles` (`idrol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
