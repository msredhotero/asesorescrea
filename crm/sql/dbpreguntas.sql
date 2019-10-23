-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-10-2019 a las 00:45:15
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
-- Estructura de tabla para la tabla `dbpreguntas`
--

CREATE TABLE IF NOT EXISTS `dbpreguntas` (
`idpregunta` int(11) NOT NULL,
  `secuencia` int(11) NOT NULL,
  `pregunta` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `respuesta1` varchar(190) COLLATE utf8_spanish_ci NOT NULL,
  `respuesta2` varchar(190) COLLATE utf8_spanish_ci NOT NULL,
  `respuesta3` varchar(190) COLLATE utf8_spanish_ci DEFAULT NULL,
  `respuesta4` varchar(190) COLLATE utf8_spanish_ci DEFAULT NULL,
  `respuesta5` varchar(190) COLLATE utf8_spanish_ci DEFAULT NULL,
  `respuesta6` varchar(190) COLLATE utf8_spanish_ci DEFAULT NULL,
  `respuesta7` varchar(190) COLLATE utf8_spanish_ci DEFAULT NULL,
  `valor` int(11) NOT NULL DEFAULT '0',
  `depende` int(11) DEFAULT '0',
  `tiempo` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `dbpreguntas`
--

INSERT INTO `dbpreguntas` (`idpregunta`, `secuencia`, `pregunta`, `respuesta1`, `respuesta2`, `respuesta3`, `respuesta4`, `respuesta5`, `respuesta6`, `respuesta7`, `valor`, `depende`, `tiempo`) VALUES
(1, 1, 'Cuentas con experiencia previa en comercialización de productos financieros? ', 'No', 'Si', NULL, NULL, NULL, NULL, NULL, 0, 0, 20),
(2, 2, 'Si su respuesta fue Si.', 'Si, en tarjetas de crédito.', 'Si, he ofrecido créditos persoanlaes.', 'SI, en afore.', NULL, NULL, NULL, NULL, 0, 1, 20),
(3, 3, 'Diponibilidad de tiempo', 'Sólo puedo trabajar por las mañanas.', 'Únicamente puedo trabajar por la tardes.', 'No tengo problema con el horario.', 'Busco un empleo de tiempo completo.', NULL, NULL, NULL, 0, 0, 20),
(4, 4, 'Plan de comspensaciones', 'Puedo apegarme a un plan de compensación variable.', 'Para mi es necesario contar con un ingreso fijo.', NULL, NULL, NULL, NULL, NULL, 0, 0, 20),
(5, 5, 'Aptitudes de venta?', 'Nunca he vendido algo, pero no estoy cerrado a intentarlo.', 'Nunca vendería algo en mi vida.', 'He intentado vender y no he tenido éxito.', 'Tengo experiencia en ventas y he tenido buenos resultados.', NULL, NULL, NULL, 0, 0, 20),
(6, 6, 'Apego institucional:', 'Para mí es importante trabajar en una empresa reconocida.', 'Trabjar en una PYME representa mayores oprtunidades de desarrollo profesional.', 'No es importante el tamaño y antecedente una organización, soy responsable de mi éxito. ', '', NULL, NULL, NULL, 0, 0, 20),
(7, 7, 'Encuesta socioeconómica; nos interesa conocer tus principales gastos para asegurarnos de cumplir tu expectativa de ingresos, por eso te pedimos contestar cuanto gastas aproximadamente en los siguiente', 'Casa habitación; renta, pago de crédito hipotecario, mantenimiento mensual…', 'Servicios de casa habitación; gas, luz, teléfono, agua, predial…', 'Alimentación…', 'Transporte, gasolina, peaje o gasto en pasajes…', 'Vestimenta….', 'Escolares…', 'Recreativos…', 0, 0, 240);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dbpreguntas`
--
ALTER TABLE `dbpreguntas`
 ADD PRIMARY KEY (`idpregunta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dbpreguntas`
--
ALTER TABLE `dbpreguntas`
MODIFY `idpregunta` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
