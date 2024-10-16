-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-10-2024 a las 14:59:56
-- Versión del servidor: 10.4.16-MariaDB
-- Versión de PHP: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `curso_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bookmark`
--

CREATE TABLE `bookmark` (
  `user_id` varchar(20) NOT NULL,
  `playlist_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `bookmark`
--

INSERT INTO `bookmark` (`user_id`, `playlist_id`) VALUES
('5h2BNg65D3RZAds5lYRd', 'YIalgp1eZaJPYIIGYIW3'),
('4kwn465uzJCUjLTTKneS', 'YIalgp1eZaJPYIIGYIW3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `id` varchar(20) NOT NULL,
  `content_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comentario`
--

INSERT INTO `comentario` (`id`, `content_id`, `user_id`, `tutor_id`, `comment`, `date`) VALUES
('cJeefJzaeBoIy5ebhHzq', 'Btqa1dHOzXTamZON3IBj', '4kwn465uzJCUjLTTKneS', 'dyIdgWjEyr9tOPvnFay8', 'lol', '2024-10-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` int(10) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`name`, `email`, `number`, `message`) VALUES
('Yonathan  Sanchez', 'daatfrontend@gmail.com', 2147483647, 'sdawda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenido`
--

CREATE TABLE `contenido` (
  `id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `playlist_id` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `video` varchar(100) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'deactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `contenido`
--

INSERT INTO `contenido` (`id`, `tutor_id`, `playlist_id`, `title`, `description`, `video`, `thumb`, `date`, `status`) VALUES
('Btqa1dHOzXTamZON3IBj', 'dyIdgWjEyr9tOPvnFay8', 'YIalgp1eZaJPYIIGYIW3', 'laravel 1', 'prueba 2', 'ezRsm46dGF63GfswDwQ7.mp4', 'Vp1SO9S3PPZPy2D3wLnh.jpg', '2024-09-16', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `user_id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `content_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `likes`
--

INSERT INTO `likes` (`user_id`, `tutor_id`, `content_id`) VALUES
('5h2BNg65D3RZAds5lYRd', 'dyIdgWjEyr9tOPvnFay8', 'Btqa1dHOzXTamZON3IBj'),
('4kwn465uzJCUjLTTKneS', 'dyIdgWjEyr9tOPvnFay8', 'Btqa1dHOzXTamZON3IBj');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playlist`
--

CREATE TABLE `playlist` (
  `id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'deactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `playlist`
--

INSERT INTO `playlist` (`id`, `tutor_id`, `title`, `description`, `thumb`, `date`, `status`) VALUES
('lrNIA44e2nIjSZaSHbLJ', 'dyIdgWjEyr9tOPvnFay8', 'python', 'prueba', 'BcU6yAJB1VlXL1fjuCH5.png', '2024-08-31', 'activo'),
('YIalgp1eZaJPYIIGYIW3', 'dyIdgWjEyr9tOPvnFay8', 'laravel', '            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestiae voluptatum dolores provident reiciendis, corporis aperiam amet recusandae nesciunt quos doloremque in? Accusantium officia excepturi corporis libero! Maiores delectus inventore velit?', 'bz5MrexkLjrupVe5NRGG.jpg', '2024-08-31', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `profession` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`id`, `name`, `profession`, `email`, `password`, `image`) VALUES
('4YKLh764h5qtAlnEksTA', 'verchiel', 'developer', 'yonathansanchez0503@gmail.com', '6bb0e3b82a69a2bdf7139d17eeb5f79818b92a4d', 'Dq8zLnmVhJL6k5WDvT3w.jpg'),
('dyIdgWjEyr9tOPvnFay8', 'daat code', 'desginer', 'daatfrontend@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'S6K8qwQmhyXR6eM6jVRR.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `name`, `email`, `password`, `image`) VALUES
('4kwn465uzJCUjLTTKneS', 'Yonathans', 'daatfrontend@gmail.com', '6b6277afcb65d33525545904e95c2fa240632660', '0Ri22ZrwipQ3GEc25Nxl.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contenido`
--
ALTER TABLE `contenido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
