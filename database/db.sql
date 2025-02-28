-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-02-2025 a las 22:27:43
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
-- Base de datos: `sistemaescolar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos`
--

CREATE TABLE `archivos` (
  `id` int(11) NOT NULL,
  `id_tarea` int(11) NOT NULL,
  `ruta_archivo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `archivos`
--

INSERT INTO `archivos` (`id`, `id_tarea`, `ruta_archivo`) VALUES
(7, 51, 'Gato.jpg'),
(8, 52, 'Gato2.PNG'),
(12, 60, 'Gato2.PNG');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id_materia` int(11) NOT NULL,
  `nombre_materia` varchar(255) NOT NULL,
  `hora_creacion` datetime DEFAULT NULL,
  `hora_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id_materia`, `nombre_materia`, `hora_creacion`, `hora_actualizacion`, `estado`) VALUES
(1, 'MATEMÁTICA', '2023-12-28 20:29:10', '2025-02-24 15:51:23', '1'),
(3, 'LENGUAJE', '2025-02-24 15:52:21', NULL, '1'),
(4, 'CIENCIAS', '2025-02-25 07:53:03', NULL, '1'),
(6, 'INGLES', '2025-02-25 13:10:28', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id_notificacion` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `id_tarea` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `leido` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id_notificacion`, `mensaje`, `id_tarea`, `fecha_creacion`, `leido`) VALUES
(22, 'Se ha creado una nueva tarea en la materia MATEMÁTICA: Tarea 7', 51, '2025-02-28 13:34:30', 0),
(23, 'Se ha creado una nueva tarea en la materia MATEMÁTICA: Tarea 8', 52, '2025-02-28 13:34:42', 0),
(24, 'Se ha creado una nueva tarea en la materia MATEMÁTICA: Tarea 9', 53, '2025-02-28 13:34:53', 0),
(27, 'Se ha creado una nueva tarea en la materia LENGUAJE: Tarea 1', 56, '2025-02-28 15:46:02', 0),
(33, 'Se ha creado una nueva tarea en la materia INGLES: prueba 123', 60, '2025-02-28 16:08:39', 0),
(34, 'La tarea \'prueba 123\' de la materia \'INGLES\' está próxima a vencer.', 60, '2025-02-28 16:08:39', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(255) NOT NULL,
  `hora_creacion` datetime DEFAULT NULL,
  `hora_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`, `hora_creacion`, `hora_actualizacion`, `estado`) VALUES
(1, 'ADMINISTRADOR', '2025-02-19 11:07:00', '2025-02-25 00:49:01', '1'),
(2, 'PROFESOR', '2025-02-19 11:07:00', NULL, '1'),
(4, 'ESTUDIANTE', '2025-02-23 20:27:29', '2025-02-25 19:07:04', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id_tarea` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_entrega` date NOT NULL,
  `estado` varchar(50) NOT NULL,
  `hora_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `hora_actualizacion` datetime DEFAULT NULL,
  `id_materia` int(11) NOT NULL,
  `hora_entrega` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id_tarea`, `titulo`, `descripcion`, `fecha_entrega`, `estado`, `hora_creacion`, `hora_actualizacion`, `id_materia`, `hora_entrega`) VALUES
(51, 'Tarea 7', 'Tarea 7', '2025-03-08', 'completado', '2025-02-28 13:34:30', NULL, 1, '19:34:00'),
(52, 'Tarea 8', 'Tarea 8', '2025-03-07', 'completado', '2025-02-28 13:34:42', NULL, 1, '19:34:00'),
(53, 'Tarea 9', 'Tarea 9', '2025-03-06', 'Pendiente', '2025-02-28 13:34:53', NULL, 1, '13:38:00'),
(56, 'Tarea 1', 'descripcion 2', '2025-02-28', 'Pendiente', '2025-02-28 15:46:02', NULL, 3, '17:46:00'),
(60, 'prueba 123', 'prueba 123', '2025-03-02', 'completado', '2025-02-28 16:08:39', NULL, 6, '17:08:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `hora_creacion` datetime DEFAULT NULL,
  `hora_actualizacion` datetime DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombres`, `rol_id`, `email`, `password`, `hora_creacion`, `hora_actualizacion`, `estado`) VALUES
(32, 'Jhon Perez', 1, 'admin@admin.com', '$2y$10$RZSdTIlV2uRV2nKGsfv36uvT67UYqxHsuI8z1QmEGFqm5tg6vsgEe', '2025-02-23 22:29:36', '2025-02-24 09:08:09', '1'),
(39, 'PROFESOR', 2, 'profesor@gmail.com', '$2y$10$H3/ZpSzL4jdNMelvONVOVORKcvuTe7r7HZorOBEt4pFFEaYIVPUHy', '2025-02-24 15:57:58', '2025-02-28 09:26:43', '1'),
(41, 'estudiante', 4, 'estudiante@gmail.com', '$2y$10$RZSdTIlV2uRV2nKGsfv36uvT67UYqxHsuI8z1QmEGFqm5tg6vsgEe', '2025-02-25 07:54:45', '2025-02-28 09:26:58', '1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tarea` (`id_tarea`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id_materia`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `id_tarea` (`id_tarea`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `nombre_rol` (`nombre_rol`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id_tarea`),
  ADD KEY `id_materia` (`id_materia`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos`
--
ALTER TABLE `archivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id_tarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD CONSTRAINT `archivos_ibfk_1` FOREIGN KEY (`id_tarea`) REFERENCES `tareas` (`id_tarea`);

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_tarea`) REFERENCES `tareas` (`id_tarea`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id_rol`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
