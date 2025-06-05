-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-05-2025 a las 00:07:11
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
-- Base de datos: `sistema_web`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios_seleccionados`
--

CREATE TABLE `horarios_seleccionados` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `materias` text DEFAULT NULL,
  `fecha_seleccion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios_usuario`
--

CREATE TABLE `horarios_usuario` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `materia_id` int(11) DEFAULT NULL,
  `grupo` varchar(10) DEFAULT NULL,
  `dia` varchar(20) DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `salon` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias_reinscripcion`
--

CREATE TABLE `materias_reinscripcion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `grupo` varchar(10) DEFAULT NULL,
  `creditos` int(11) DEFAULT NULL,
  `seriada` enum('Sí','No') DEFAULT NULL,
  `horario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `materias_reinscripcion`
--

INSERT INTO `materias_reinscripcion` (`id`, `nombre`, `grupo`, `creditos`, `seriada`, `horario`) VALUES
(1, 'Matemáticas I', 'A', 6, 'No', 'Lunes 8:00-10:00'),
(2, 'Física I', 'A', 6, 'No', 'Lunes 10:00-12:00'),
(3, 'Programación I', 'A', 8, 'No', 'Martes 8:00-10:00'),
(4, 'Química', 'A', 6, 'No', 'Martes 10:00-12:00'),
(5, 'Introducción a la Ingeniería', 'A', 4, 'No', 'Miércoles 8:00-10:00'),
(6, 'Dibujo Técnico', 'A', 4, 'No', 'Miércoles 10:00-12:00'),
(7, 'Comunicación Oral', 'A', 3, 'No', 'Jueves 8:00-9:30'),
(8, 'Taller de Ética', 'A', 2, 'No', 'Jueves 9:30-11:00'),
(9, 'Matemáticas I', 'B', 6, 'No', 'Lunes 12:00-14:00'),
(10, 'Física I', 'B', 6, 'No', 'Lunes 14:00-16:00'),
(11, 'Programación I', 'B', 8, 'No', 'Martes 12:00-14:00'),
(12, 'Química', 'B', 6, 'No', 'Martes 14:00-16:00'),
(13, 'Introducción a la Ingeniería', 'B', 4, 'No', 'Miércoles 12:00-14:00'),
(14, 'Dibujo Técnico', 'B', 4, 'No', 'Miércoles 14:00-16:00'),
(15, 'Comunicación Oral', 'B', 3, 'No', 'Jueves 12:00-13:30'),
(16, 'Taller de Ética', 'B', 2, 'No', 'Jueves 13:30-15:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `contrasena`) VALUES
(1, 'admin', '12345'),
(2, '202223013', '202223013');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `horarios_seleccionados`
--
ALTER TABLE `horarios_seleccionados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `horarios_usuario`
--
ALTER TABLE `horarios_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materias_reinscripcion`
--
ALTER TABLE `materias_reinscripcion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `horarios_seleccionados`
--
ALTER TABLE `horarios_seleccionados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `horarios_usuario`
--
ALTER TABLE `horarios_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `materias_reinscripcion`
--
ALTER TABLE `materias_reinscripcion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
