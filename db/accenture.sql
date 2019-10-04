-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2019 at 03:24 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accenture`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `activo` tinyint(4) NOT NULL,
  `creado_fecha` datetime NOT NULL,
  `creado_por` int(11) NOT NULL,
  `modificado_fecha` datetime NOT NULL,
  `modificado_por` int(11) NOT NULL,
  `eliminado_fecha` datetime NOT NULL,
  `eliminado_por` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `activo`, `creado_fecha`, `creado_por`, `modificado_fecha`, `modificado_por`, `eliminado_fecha`, `eliminado_por`) VALUES
(1, 'Administrador', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(2, 'Asistente', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(3, 'MD', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(4, 'tuviejaaa', 0, '2019-06-21 06:09:18', 1, '2019-06-21 06:10:01', 1, '2019-06-21 06:10:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categorias_contenidos`
--

CREATE TABLE `categorias_contenidos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `puntos` int(11) NOT NULL,
  `activo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categorias_contenidos`
--

INSERT INTO `categorias_contenidos` (`id`, `nombre`, `puntos`, `activo`) VALUES
(1, 'Menciones', 0, 1),
(2, 'Actividades', 0, 1),
(3, 'Social Media', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contenidos`
--

CREATE TABLE `contenidos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `bajada` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `categoria_contenido` tinyint(4) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_publicacion` datetime NOT NULL,
  `fecha_actividad` datetime NOT NULL,
  `compartir` tinyint(4) NOT NULL,
  `activo` tinyint(4) NOT NULL,
  `creado_fecha` datetime NOT NULL,
  `creado_por` int(11) NOT NULL,
  `modificado_fecha` datetime NOT NULL,
  `modificado_por` int(11) NOT NULL,
  `eliminado_fecha` datetime NOT NULL,
  `eliminado_por` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contenidos`
--

INSERT INTO `contenidos` (`id`, `titulo`, `bajada`, `link`, `categoria_contenido`, `usuario_id`, `fecha_publicacion`, `fecha_actividad`, `compartir`, `activo`, `creado_fecha`, `creado_por`, `modificado_fecha`, `modificado_por`, `eliminado_fecha`, `eliminado_por`) VALUES
(4, 'Banco galicia es lo mas', 'Tiene muchos descuentos', 'http://galicia.com', 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '2019-06-20 22:39:43', 1, '2019-06-20 22:57:24', 1, '2019-06-20 23:00:12', 1),
(5, 'titulo', 'bajada', 'link', 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '2019-06-20 22:58:44', 1, '2019-06-20 22:59:36', 1, '2019-06-20 23:00:09', 1),
(6, 'titulo', 'bajada', 'link', 2, 1, '2019-06-03 00:00:00', '2019-06-12 00:00:00', 1, 0, '2019-06-20 22:59:18', 1, '0000-00-00 00:00:00', 0, '2019-06-20 23:00:07', 1),
(7, 'Banco galicia es lo mas', 'bajada', 'link', 1, 1, '2019-06-03 00:00:00', '2019-06-06 00:00:00', 1, 1, '2019-06-20 23:00:22', 1, '2019-06-20 23:00:31', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contenidos_leidos`
--

CREATE TABLE `contenidos_leidos` (
  `id` int(11) NOT NULL,
  `id_contenido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contenido_afinidad`
--

CREATE TABLE `contenido_afinidad` (
  `id` int(11) NOT NULL,
  `id_contenido` int(11) NOT NULL,
  `id_afinidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grupos_afinidad`
--

CREATE TABLE `grupos_afinidad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `activo` tinyint(4) NOT NULL,
  `creado_fecha` datetime NOT NULL,
  `creado_por` int(11) NOT NULL,
  `modificado_fecha` datetime NOT NULL,
  `modificado_por` int(11) NOT NULL,
  `eliminado_fecha` datetime NOT NULL,
  `eliminado_por` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grupos_afinidad`
--

INSERT INTO `grupos_afinidad` (`id`, `nombre`, `activo`, `creado_fecha`, `creado_por`, `modificado_fecha`, `modificado_por`, `eliminado_fecha`, `eliminado_por`) VALUES
(1, 'Tecnologia', 1, '2019-06-21 06:00:24', 1, '2019-06-21 06:01:27', 1, '2019-06-21 06:01:30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `redes_sociales`
--

CREATE TABLE `redes_sociales` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `activo` tinyint(4) NOT NULL,
  `creado_fecha` datetime NOT NULL,
  `creado_por` int(11) NOT NULL,
  `modificado_fecha` datetime NOT NULL,
  `modificado_por` int(11) NOT NULL,
  `eliminado_fecha` datetime NOT NULL,
  `eliminado_por` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `redes_sociales`
--

INSERT INTO `redes_sociales` (`id`, `nombre`, `activo`, `creado_fecha`, `creado_por`, `modificado_fecha`, `modificado_por`, `eliminado_fecha`, `eliminado_por`) VALUES
(1, 'Facebook', 1, '2019-06-21 05:29:12', 1, '2019-06-21 05:38:34', 1, '0000-00-00 00:00:00', 0),
(2, 'Twitter', 0, '2019-06-21 05:39:07', 1, '0000-00-00 00:00:00', 0, '2019-06-21 05:39:10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `redsocial_usuario`
--

CREATE TABLE `redsocial_usuario` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_redsocial` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `activo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tabla_puntos`
--

CREATE TABLE `tabla_puntos` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_contenido` int(11) NOT NULL,
  `id_redsocial` int(11) NOT NULL,
  `puntos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tiempo_app`
--

CREATE TABLE `tiempo_app` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `apellido` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `categoria` int(11) NOT NULL,
  `clave` varchar(200) NOT NULL,
  `activo` tinyint(4) NOT NULL,
  `creado_fecha` datetime NOT NULL,
  `creado_por` int(11) NOT NULL,
  `modificado_fecha` datetime NOT NULL,
  `modificado_por` int(11) NOT NULL,
  `eliminado_fecha` datetime NOT NULL,
  `eliminado_por` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `apellido`, `email`, `categoria`, `clave`, `activo`, `creado_fecha`, `creado_por`, `modificado_fecha`, `modificado_por`, `eliminado_fecha`, `eliminado_por`) VALUES
(1, 'Alan', 'Stiberman', 'alanstib@gmail.com', 1, '*4ACFE3202A5FF5CF467898FC58AAB1D615029441', 1, '2019-06-17 03:44:00', 1, '2019-06-17 06:44:00', 1, '0000-00-00 00:00:00', 0),
(2, 'Ariel', 'Lipschutz', 'ariellipschutz@gmail.com', 1, '*4ACFE3202A5FF5CF467898FC58AAB1D615029441', 1, '2019-06-17 18:18:01', 1, '2019-06-17 18:28:11', 1, '2019-06-20 22:32:54', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuario_afinidad`
--

CREATE TABLE `usuario_afinidad` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_afinidad` int(11) NOT NULL,
  `notificaciones` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categorias_contenidos`
--
ALTER TABLE `categorias_contenidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contenidos`
--
ALTER TABLE `contenidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contenidos_leidos`
--
ALTER TABLE `contenidos_leidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contenido_afinidad`
--
ALTER TABLE `contenido_afinidad`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grupos_afinidad`
--
ALTER TABLE `grupos_afinidad`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `redes_sociales`
--
ALTER TABLE `redes_sociales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `redsocial_usuario`
--
ALTER TABLE `redsocial_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabla_puntos`
--
ALTER TABLE `tabla_puntos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tiempo_app`
--
ALTER TABLE `tiempo_app`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario_afinidad`
--
ALTER TABLE `usuario_afinidad`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categorias_contenidos`
--
ALTER TABLE `categorias_contenidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contenidos`
--
ALTER TABLE `contenidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contenidos_leidos`
--
ALTER TABLE `contenidos_leidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contenido_afinidad`
--
ALTER TABLE `contenido_afinidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grupos_afinidad`
--
ALTER TABLE `grupos_afinidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `redes_sociales`
--
ALTER TABLE `redes_sociales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `redsocial_usuario`
--
ALTER TABLE `redsocial_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabla_puntos`
--
ALTER TABLE `tabla_puntos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tiempo_app`
--
ALTER TABLE `tiempo_app`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usuario_afinidad`
--
ALTER TABLE `usuario_afinidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
