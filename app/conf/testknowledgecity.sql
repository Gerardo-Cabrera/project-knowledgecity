-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2020 a las 12:12:48
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.9

-- --------------------------------------------------------

--
-- Base de datos: `testknowledgecity`
--
CREATE DATABASE IF NOT EXISTS `testknowledgecity` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `testknowledgecity`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `api_users`
--

DROP TABLE IF EXISTS `api_users`;
CREATE TABLE `api_users` (
  `id` bigint(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `api_users`
--

INSERT INTO `api_users` (`id`, `username`, `password`) VALUES
(1, 'devuser', '12345678'),
(2, 'devtest', '12345678');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `id` bigint(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `student_group` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `students`
--

INSERT INTO `students` (`id`, `name`, `lastname`, `username`, `student_group`) VALUES
(1, 'Mark', 'Zuckerberg', 'mzuckerber', 'Default group'),
(2, 'Bill', 'Gates', 'bgates', 'Default group'),
(3, 'Jeff', 'Bezos', 'jbezos', 'Default group'),
(4, 'Elon', 'Musk', 'emusk', 'Default group'),
(5, 'Steve', 'Jobs', 'sjobs', 'Default group'),
(6, 'Steve', 'Wozniak', 'swozniak', 'Default group'),
(7, 'Linus', 'Torvalds', 'ltorvalds', 'Default group'),
(8, 'Richard', 'Stallman', 'rstallman', 'Default group'),
(9, 'Larry', 'Page', 'lpage', 'Default group'),
(10, 'Michael', 'Jordan', 'mjordan', 'Default group'),
(11, 'Michale', 'Schumacher', 'mschumacher', 'Default group'),
(12, 'Michael', 'Jackson', 'mjackson', 'Default group'),
(13, 'Freddie', 'Mercury', 'fmercury', 'Default group'),
(14, 'Guido', 'van Rossum', 'gvanrossum', 'Default group');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `api_users`
--
ALTER TABLE `api_users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `api_users`
--
ALTER TABLE `api_users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
