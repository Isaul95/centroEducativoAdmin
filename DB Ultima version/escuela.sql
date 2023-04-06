-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 06-04-2023 a las 06:32:36
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `escuela`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
CREATE TABLE IF NOT EXISTS `alumnos` (
  `numero_control` varchar(200) NOT NULL DEFAULT '',
  `nombres` varchar(255) DEFAULT NULL,
  `apellido_paterno` varchar(100) DEFAULT NULL,
  `apellido_materno` varchar(100) DEFAULT NULL,
  `curp_texto` varchar(20) DEFAULT NULL,
  `direccion` varchar(300) DEFAULT NULL,
  `municipio_direccion` varchar(200) DEFAULT NULL,
  `estado_direccion` varchar(200) DEFAULT NULL,
  `fecha_nacimiento` varchar(200) DEFAULT NULL,
  `localidad` varchar(200) DEFAULT NULL,
  `municipio_localidad` varchar(200) DEFAULT NULL,
  `estado_localidad` varchar(200) DEFAULT NULL,
  `estado_civil` varchar(200) DEFAULT NULL,
  `sexo` varchar(200) DEFAULT NULL,
  `tipo_escuela_nivel_medio_superior` varchar(200) DEFAULT NULL,
  `institucion` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `acta_nacimiento` mediumblob,
  `certificado_bachillerato` mediumblob,
  `curp` mediumblob,
  `certificado_medico` mediumblob,
  `estatus` int DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_inscripcion` varchar(200) DEFAULT NULL,
  `facebook` varchar(200) DEFAULT NULL,
  `twitter` varchar(200) DEFAULT NULL,
  `instagram` varchar(200) DEFAULT NULL,
  `nombre_acta` varchar(200) DEFAULT NULL,
  `nombre_certificado_medico` varchar(200) DEFAULT NULL,
  `nombre_curp` varchar(200) DEFAULT NULL,
  `nombre_certificado_bachillerato` varchar(200) DEFAULT NULL,
  `estatus_alumno_activo` int DEFAULT NULL,
  `servicio_social` varchar(3) DEFAULT NULL,
  `practicas_prof` varchar(3) DEFAULT NULL,
  `titulacion` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`numero_control`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`numero_control`, `nombres`, `apellido_paterno`, `apellido_materno`, `curp_texto`, `direccion`, `municipio_direccion`, `estado_direccion`, `fecha_nacimiento`, `localidad`, `municipio_localidad`, `estado_localidad`, `estado_civil`, `sexo`, `tipo_escuela_nivel_medio_superior`, `institucion`, `email`, `telefono`, `acta_nacimiento`, `certificado_bachillerato`, `curp`, `certificado_medico`, `estatus`, `fecha_registro`, `fecha_inscripcion`, `facebook`, `twitter`, `instagram`, `nombre_acta`, `nombre_certificado_medico`, `nombre_curp`, `nombre_certificado_bachillerato`, `estatus_alumno_activo`, `servicio_social`, `practicas_prof`, `titulacion`) VALUES
('AACC21242', 'ALEJANDRO', 'ALTAMIRANO', 'CASTRO', NULL, 'JJ', 'J', 'J', '2021/02/02', 'J', 'JJ', 'J', 'Soltero(a)', 'Masculino', 'Bachillerato', 'J', 'JJ', 'J', NULL, NULL, NULL, NULL, 1, '2021-02-18 19:09:00', '2021/02/04', 'J', 'S', 'S', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
('IGGD212451', 'isaul', 'g', 'g', NULL, 'g', 'g', 'g', '2021/01/22', 'gg', 'g', 'g', 'Soltero(a)', 'Masculino', 'Bachillerato', 'hhh', 'nnn', '7777', NULL, NULL, NULL, NULL, 0, '2021-02-19 18:05:24', '2021/01/20', 'nn', 'nnn', 'nnn', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
('IHRDG21244', 'RAFAEL ISAUL', 'HERNANDEZ', 'RAMIREZ', 'HERR950902HGRRMF01', 'Juan Escudero 121', 'Iguala', 'Guerrero', '2023/03/24', 'Iguala', 'Iguala', 'Guerrero', 'Soltero(a)', 'Masculino', 'Bachillerato', 'Tec igual', 'rihr.9523@gmail.com', '7331170055', NULL, NULL, NULL, NULL, 0, '2023-03-30 05:48:30', '2023/03/03', 'no', 'no', 'no', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
('LCHC21242', 'LEDA GUADALUPE', 'CORDERO', 'HEREDIA', NULL, 'A', 'A', 'A', '2021/02/03', 'A', 'A', 'A', 'Soltero(a)', 'Femenino', 'Bachillerato', 'A', 'A', 'A', NULL, NULL, NULL, NULL, 1, '2023-03-30 05:48:11', '2021/02/24', 'A', 'A', 'A', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
('MASC21242', 'MARIA FERNANDA', 'AUSTRIA', 'SANCHEZ', NULL, 'A', 'A', 'A', '2021/02/02', 'A', 'A', 'A', 'Soltero(a)', 'Femenino', 'Bachillerato', 'A', 'A', 'A', NULL, NULL, NULL, NULL, 1, '2023-03-30 05:48:17', '2021/02/03', 'A', 'A', 'A', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
('RDS20230312', 'ROMER', 'DIEGOS', 'SOLÍS', 'HERR020995MF01HR', 'Escudero #121', 'Iguala', 'Guerrero', '2023/03/12', 'SFGFGF', 'SFGFGF', 'SFGFGF', NULL, 'Femenino', NULL, 'SFGFGF', 'SFGFGF', '7331170055', NULL, NULL, NULL, NULL, 0, '2023-03-30 05:48:22', '2023/03/31', 'FaceBook', 'SFGFGF', 'SFGFGF', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
('RET20230312', 'ROMAS', 'ESE', 'TEDEJA', NULL, 'fdvfdvfdvf', 'vfdvdv', 'fvfvfdv', '2023/03/12', 'vfdfvdf', 'fdvfdvfd', 'fdvfdv', NULL, 'Masculino', NULL, 'fvfvdf', 'dfffd', 'dfffdf', NULL, NULL, NULL, NULL, 0, '2023-03-13 05:09:28', '2023/03/10', 'xccc', 'cxxc', 'cxcc', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
('UCCC21243', 'URIEL', 'CORDOBA', 'CAMPOS', NULL, 'S', 'S', 'S', '2021/02/01', 'S', 'S', 'S', 'Soltero(a)', 'Masculino', 'Bachillerato', 'S', 'S', 'S', NULL, NULL, NULL, NULL, 1, '2021-02-03 19:06:24', '2021/02/09', 'S', 'S', 'S', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_escuela`
--

DROP TABLE IF EXISTS `datos_escuela`;
CREATE TABLE IF NOT EXISTS `datos_escuela` (
  `nombre` varchar(200) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `turno` varchar(50) DEFAULT NULL,
  `zona_escolar` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `datos_escuela`
--

INSERT INTO `datos_escuela` (`nombre`, `codigo`, `turno`, `zona_escolar`) VALUES
('GENERAL AMBROSIO FIGUEROA', '12DPR0647Q', 'MATUTINO', 137);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles`
--

DROP TABLE IF EXISTS `detalles`;
CREATE TABLE IF NOT EXISTS `detalles` (
  `id_detalle` int NOT NULL AUTO_INCREMENT,
  `alumno` varchar(200) DEFAULT NULL,
  `carrera` int DEFAULT NULL,
  `fecha_letra` varchar(100) DEFAULT NULL,
  `fecha_constancia` varchar(50) DEFAULT NULL,
  `promedio_alumno` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT '0',
  PRIMARY KEY (`id_detalle`),
  KEY `alumno` (`alumno`),
  KEY `carrera` (`carrera`),
  KEY `alumno_2` (`alumno`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `detalles`
--

INSERT INTO `detalles` (`id_detalle`, `alumno`, `carrera`, `fecha_letra`, `fecha_constancia`, `promedio_alumno`) VALUES
(29, 'IGGD212451', 7, NULL, NULL, NULL),
(31, 'AACC21242', 7, NULL, NULL, NULL),
(32, 'MASC21242', 7, 'dos días del mes de abril del dos mil veintitrés.', '01 de abril de 2023', '8.7'),
(33, 'LCHC21242', 7, NULL, NULL, NULL),
(34, 'UCCC21243', 7, 'un dia del mes de abril de dos mil veintitres', '01 de abril de 2023', '6.7'),
(59, 'IGGD212451', 7, NULL, NULL, NULL),
(60, 'IHRDG21244', 7, 'cinco días del mes de abrir del dos mil veintetres', '05 de abril de 2023', '9.8'),
(62, 'RDS20230312', 7, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grado_grupo`
--

DROP TABLE IF EXISTS `grado_grupo`;
CREATE TABLE IF NOT EXISTS `grado_grupo` (
  `id_grado_grupo` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `grado_y_grupo` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_grado_grupo`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `grado_grupo`
--

INSERT INTO `grado_grupo` (`id_grado_grupo`, `nombre`, `descripcion`, `grado_y_grupo`) VALUES
(1, '1 A', 'Grupo primero AA', '1°A'),
(2, '1 B', 'Grupo primero B', '1°B'),
(3, '2 A', 'Grupo segundo A', NULL),
(4, '2 B', 'Grupo segundo B', '2°B'),
(5, '3 A', 'Grupo tercero A', NULL),
(6, '3 B', 'Grupo tercero B', '3°B'),
(7, '4 A', 'Grupo cuarto A', '4°A'),
(8, '4 B', 'Grupo cuarto B', '4°B'),
(9, '5 A', 'Grupo quinto A', '5°A'),
(10, '5 B', 'Grupo quinto A', '5°B'),
(11, '6 A', 'Grupo sexto A', '6°A'),
(12, '6 B', 'Grupo sexto B', '6°B');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id`, `nombre`, `link`) VALUES
(1, 'Inicio', 'dashboard'),
(2, 'AltaBaucherBanco', 'alumnos/altaBaucherBanco'),
(3, 'FormatoRegistroPago', 'Finanzas/FormatoRegistroPago'),
(4, 'HabilitarAlumnos', 'Finanzas/HabilitarAlumnos'),
(5, 'Agregar usuarios', 'administrador/usuarios'),
(6, 'Agregar permisos', 'administrador/permisos'),
(7, 'PeriodoEscolar', 'Administrativos/PeriodoEscolar'),
(8, 'Carreras', 'Administrativos/Carreras'),
(9, 'Profesores', 'Administrativos/Profesores'),
(10, 'Alumnos', 'Administrativos/Alumnos'),
(11, 'Materias', 'Administrativos/Materias'),
(12, 'HorarioProfesor', 'Administrativos/HacerHorarioProfesor'),
(13, 'PlaneacionProfesores', 'Profesores/PlaneacionProfesores'),
(14, 'GradosGrupos', 'Administrativos/GradosGrupos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

DROP TABLE IF EXISTS `permisos`;
CREATE TABLE IF NOT EXISTS `permisos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_id` int DEFAULT NULL,
  `rol_id` int DEFAULT NULL,
  `read` int DEFAULT NULL,
  `insert` int DEFAULT NULL,
  `update` int DEFAULT NULL,
  `delete` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_menus_idx` (`menu_id`),
  KEY `fk_rol_idx` (`rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `menu_id`, `rol_id`, `read`, `insert`, `update`, `delete`) VALUES
(37, 4, 1, 1, 1, 1, 1),
(38, 3, 1, 1, 1, 1, 1),
(39, 5, 1, 1, 1, 1, 1),
(40, 6, 1, 1, 1, 1, 1),
(41, 2, 2, 1, 1, 1, 1),
(42, 7, 1, 1, 1, 1, 1),
(43, 8, 1, 1, 1, 1, 1),
(44, 9, 1, 1, 1, 1, 1),
(45, 10, 1, 1, 1, 1, 1),
(46, 2, 1, 1, 1, 1, 1),
(47, 11, 1, 1, 1, 1, 1),
(48, 12, 1, 1, 1, 1, 1),
(49, 13, 3, 1, 1, 1, 1),
(50, 14, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

DROP TABLE IF EXISTS `profesores`;
CREATE TABLE IF NOT EXISTS `profesores` (
  `id_profesores` int NOT NULL AUTO_INCREMENT,
  `nombres` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `nivel_de_estudios` varchar(200) DEFAULT NULL,
  `sexo` varchar(200) DEFAULT NULL,
  `edad` varchar(200) DEFAULT NULL,
  `titulado` varchar(200) DEFAULT NULL,
  `cedula` varchar(200) DEFAULT NULL,
  `rfc` varchar(15) DEFAULT NULL,
  `funcion` varchar(200) DEFAULT NULL,
  `ocupacion` varchar(200) DEFAULT NULL,
  `tipo_de_trabajo` varchar(200) DEFAULT NULL,
  `estado_civil` varchar(200) DEFAULT NULL,
  `direccion` varchar(1000) DEFAULT NULL,
  `ciudad_radicando` varchar(200) DEFAULT NULL,
  `nacionalidad` varchar(200) DEFAULT NULL,
  `telefono_celular` varchar(200) DEFAULT NULL,
  `correo` varchar(200) DEFAULT NULL,
  `grado_grupo` int NOT NULL,
  `universidad_procedente` varchar(300) DEFAULT NULL,
  `experiencia_docente` varchar(300) DEFAULT NULL,
  `trabajos_anteriores` varchar(500) DEFAULT NULL,
  `nombre_archivo` varchar(200) DEFAULT NULL,
  `curriculum` mediumblob,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `horario_asignado` int DEFAULT '0',
  `fecha_sep` varchar(20) DEFAULT NULL,
  `fecha_ct` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_profesores`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id_profesores`, `nombres`, `nivel_de_estudios`, `sexo`, `edad`, `titulado`, `cedula`, `rfc`, `funcion`, `ocupacion`, `tipo_de_trabajo`, `estado_civil`, `direccion`, `ciudad_radicando`, `nacionalidad`, `telefono_celular`, `correo`, `grado_grupo`, `universidad_procedente`, `experiencia_docente`, `trabajos_anteriores`, `nombre_archivo`, `curriculum`, `fecha_registro`, `horario_asignado`, `fecha_sep`, `fecha_ct`) VALUES
(1, 'Profesor 1', 'uh', 'uh', 'uh', 'uh', 'uh', NULL, NULL, 'uh', 'uh', 'uh', 'IGUALA #45', 'uh', 'uh', 'uh', 'uh', 2, 'uh', 'uh', 'uh', NULL, NULL, '2021-01-15 06:48:22', NULL, '01/09/1980', '22/09/2018'),
(2, 'Profesor 2', 'hi', 'ih', 'h', 'hi', 'hi', NULL, NULL, 'hi', 'hi', 'hi', 'MEXICO #4', 'ih', 'ih', 'ihi', 'hi', 2, 'hi', 'hi', 'hi', NULL, NULL, '2021-01-28 22:20:07', NULL, '01/09/1989', '22/01/2014'),
(3, 'Profesor 3', 'nj', 'nj', 'nj', 'nj', 'nj', NULL, NULL, 'nj', 'nj', 'jnj', 'CDMX', 'njn', 'jn', 'jn', 'jn', 2, 'nj', 'nj', 'nj', NULL, NULL, '2021-01-28 22:20:27', NULL, '01/09/1923', '14/01/2010'),
(4, 'Profesor 4', 'ko', 'ko', 'k', 'k', 'ok', NULL, NULL, 'oko', 'ko', 'ko', 'SONORA #5', 'ko', 'ko', 'ko', 'ko', 0, 'ko', 'ko', 'ko', NULL, NULL, '2021-02-19 04:16:31', 0, '01/09/2000', '14/01/2016');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `descripcion`) VALUES
(1, 'admin', NULL),
(2, 'alumno', NULL),
(3, 'profesor', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombres` varchar(100) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `rol_id` int DEFAULT NULL,
  `estado_usuario` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_rol_usuarios_idx` (`rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombres`, `apellidos`, `telefono`, `email`, `username`, `password`, `rol_id`, `estado_usuario`) VALUES
(2, 'Juan Salvador ', 'Perez Maldonado', '45454556', 'juancarlos@gmail.com', 'a', 'a', 1, 1),
(31, 'isaul', 'g g', '777888', 'nnn', 'student', 'a', 2, 1),
(32, 'Profesor 1', 'ji', 'iu', 'iu', 'profe', 'a', 3, 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalles`
--
ALTER TABLE `detalles`
  ADD CONSTRAINT `detalles_ibfk_6` FOREIGN KEY (`alumno`) REFERENCES `alumnos` (`numero_control`);

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `fk_menus` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  ADD CONSTRAINT `fk_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_rol_usuarios` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
