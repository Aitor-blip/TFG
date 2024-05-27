


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `categorias` (
  `idCategoria` int(11) NOT NULL,
  `nombreCategoria` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `nombreCategoria`) VALUES
(1, 'Bragas y Tangas'),
(2, 'Sujetadores'),
(3, 'Fotos de pies'),
(4, 'Juguetes sexuales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

CREATE TABLE `fotos` (
  `idFoto` int(11) NOT NULL,
  `nombreFoto` varchar(255) DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fotos`
--

INSERT INTO `fotos` (`idFoto`, `nombreFoto`, `idProducto`, `idUsuario`) VALUES
(3, '../assets/uploads/bragas1.jpg', 4, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `megusta`
--

CREATE TABLE `megusta` (
  `idMeGusta` int(11) NOT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `idMensaje` int(11) NOT NULL,
  `idEmisor` int(11) DEFAULT NULL,
  `idReceptor` int(11) DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `contenido` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `nombreProducto` varchar(25) DEFAULT NULL,
  `talla` varchar(25) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `condicion` varchar(50) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idCategoria` int(11) DEFAULT NULL,
  `estado` enum('vendido','comprado') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `nombreProducto`, `talla`, `descripcion`, `precio`, `condicion`, `idUsuario`, `idCategoria`, `estado`) VALUES
(4, 'braga', 'fcdea', ' cvxfs', 33.00, 'cvsd', 2, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRol` int(11) NOT NULL,
  `nombreRol` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idRol`, `nombreRol`) VALUES
(1, 'admin'),
(2, 'usuario'),
(3, 'invitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

CREATE TABLE `transacciones` (
  `idTransaccion` int(11) NOT NULL,
  `idComprador` int(11) DEFAULT NULL,
  `idVendedor` int(11) DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `fechaTransaccion` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `metodoPago` varchar(255) DEFAULT NULL,
  `estado` enum('pendiente','completado','cancelado') NOT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `nombreUsuario` varchar(25) DEFAULT NULL,
  `nombre` varchar(25) DEFAULT NULL,
  `apellidos1` varchar(25) DEFAULT NULL,
  `apellidos2` varchar(25) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `sexo` varchar(10) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  `fechaRegistro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fechaBaja` timestamp NULL DEFAULT NULL,
  `calificacion` int(5) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nombreUsuario`, `nombre`, `apellidos1`, `apellidos2`, `email`, `password`, `sexo`, `descripcion`, `fechaNacimiento`, `fechaRegistro`, `fechaBaja`, `calificacion`, `foto`) VALUES
(1, 'oly', 'oly', 'oly', 'oly', 'oly@oly.com', '$2y$10$7teQj3KeWh.9W2TUAfbvGeIK6yS/JOvJM2mbq1Al3TW.048OGyCia', 'femenino', 'vsxjsxjxvsw', '1999-12-12', '2024-05-25 17:19:13', NULL, NULL, '../assets/uploads/perfil8.jpg'),
(2, 'paula', 'paula', 'paula', 'paula', 'paula@paula.com', '$2y$10$PPRf5ZtNjiYPT/vkRog2zu.NGVkcjUy0VbBdhzENBat4yOaUsYFLy', 'femenino', 'hgntdy', '2001-05-09', '2024-05-25 21:52:52', NULL, NULL, '../assets/uploads/perfil2.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_roles`
--

CREATE TABLE `usuarios_roles` (
  `idUsuarioRol` int(11) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idRol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios_roles`
--

INSERT INTO `usuarios_roles` (`idUsuarioRol`, `idUsuario`, `idRol`) VALUES
(1, 1, 2),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `validaciondni`
--

CREATE TABLE `validaciondni` (
  `idValidacion` int(11) NOT NULL,
  `dni` blob NOT NULL,
  `estado` enum('pendiente','validado','rechazado') NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `fechaValidacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;