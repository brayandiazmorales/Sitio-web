-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2026 at 07:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistema_inscripciones`
--

-- --------------------------------------------------------

--
-- Table structure for table `inscripciones`
--

CREATE TABLE `inscripciones` (
  `id` int(11) NOT NULL,
  `matricula` varchar(20) NOT NULL,
  `alumno` varchar(150) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `semestre` varchar(10) NOT NULL,
  `turno` varchar(20) NOT NULL,
  `grupo` varchar(10) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `referencia` varchar(50) NOT NULL,
  `estado` enum('Pendiente','Validado','Rechazado') DEFAULT 'Pendiente',
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `clave_pago` varchar(40) DEFAULT NULL,
  `estado_pago` enum('Pendiente','Pagado') DEFAULT 'Pendiente',
  `fecha_pago` datetime DEFAULT NULL,
  `validado_por` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inscripciones`
--

INSERT INTO `inscripciones` (`id`, `matricula`, `alumno`, `correo`, `telefono`, `semestre`, `turno`, `grupo`, `monto`, `referencia`, `estado`, `fecha`, `clave_pago`, `estado_pago`, `fecha_pago`, `validado_por`) VALUES
(8, '2026-2408', 'JUAN CARLOS TREVIÑO', 'alumno@ibero.edu.mx', '3442323456', '5°', 'Matutino', 'A', 3500.00, 'IBERO-2026-2408', 'Validado', '2026-02-19 19:58:59', 'IBERO-2026-F2F3BEC3', 'Pendiente', NULL, NULL),
(9, '2026-7643', 'JUAN CARLOS TREVIÑO', 'carlosruiz@ibero.edu.mx', '8217723910', '4°', 'Matutino', 'A', 3500.00, 'IBERO-2026-7643', 'Validado', '2026-02-19 20:35:16', 'IBERO-2026-D5D47706', 'Pendiente', NULL, NULL),
(10, '2026-6266', 'ZABDIEL', 'pedrogarcia@ibero.edu.mx', '8282298921', '4°', 'Matutino', 'B', 3500.00, 'IBERO-2026-6266', 'Validado', '2026-02-19 21:10:15', 'IBERO-2026-9E05970C', 'Pendiente', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','alumno') NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `rol`, `fecha`) VALUES
(1, 'Administrador', 'admin@ibero.edu.mx', '3b612c75a7b5048a435fb6ec81e52ff92d6d795a8b5a9c17070f6a63c97a53b2', 'admin', '2026-02-19 16:24:36'),
(2, 'Alumno Prueba', 'alumno@ibero.edu.mx', '3376c84129ae157df6c4a2dc409233c4ecc08d4fa1be55e0f4ddb369fb093ee8', 'alumno', '2026-02-19 17:10:47'),
(3, 'pedro luis garcia garcia', 'pedrogarcia@ibero.edu.mx', '2702cb34ee041711b9df0c67a8d5c9de02110c80e3fc966ba8341456dbc9ef2b', 'alumno', '2026-02-19 20:06:19'),
(4, 'juan carlos ruiz', 'carlosruiz@ibero.edu.mx', 'ac9c2c34c9f7ad52528c3422af40a66e2e24aaf2a727831255413c9470158984', 'alumno', '2026-02-19 20:21:52'),
(5, 'jesus alonso', 'jesus@ibero.edu.mx', '461d7a1b4cd6f184844f52f43c445cb42b793971862935516816ab5d220db918', 'alumno', '2026-02-19 20:58:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
