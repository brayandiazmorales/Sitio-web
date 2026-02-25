-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2026 at 10:53 PM
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
  `estado_pago` enum('Pendiente','En revisión','Pagado') DEFAULT 'Pendiente',
  `fecha_pago` datetime DEFAULT NULL,
  `validado_por` int(11) DEFAULT NULL,
  `comprobante_pago` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inscripciones`
--

INSERT INTO `inscripciones` (`id`, `matricula`, `alumno`, `correo`, `telefono`, `semestre`, `turno`, `grupo`, `monto`, `referencia`, `estado`, `fecha`, `clave_pago`, `estado_pago`, `fecha_pago`, `validado_por`, `comprobante_pago`) VALUES
(17, '2026-5819', 'JUAN CARLOS TREVIÑO', 'juan@ibero.edu.mx', '8124162191', '1°', 'Matutino', 'A', 3500.00, 'IBERO-2026-5819', 'Validado', '2026-02-20 14:18:25', 'IBERO-2026-36B2A90C', 'Pagado', '2026-02-20 08:38:00', NULL, 'comprobantes/1771597160_Voucher_2026-5819.pdf'),
(18, '2026-1426', 'JUAN CARLOS TREVIÑO', 'carlosruiz@ibero.edu.mx', '8124162191', '4°', 'Matutino', NULL, 3500.00, 'IBERO-2026-1426', 'Pendiente', '2026-02-23 14:37:49', NULL, 'En revisión', NULL, NULL, 'comprobantes/1771857498_Voucher_2026-5819 (1).pdf'),
(19, '2026-5819', 'JUAN CARLOS TREVIÑO', 'carlosruiz@ibero.edu.mx', '8124162191', '4°', 'Matutino', NULL, 3500.00, 'IBERO-2026-5819', 'Pendiente', '2026-02-23 14:37:53', 'IBERO-2026-D8C332A6', 'Pagado', '2026-02-23 10:02:47', NULL, 'comprobantes/1771857498_Voucher_2026-5819 (1).pdf');

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
(5, 'jesus alonso', 'jesus@ibero.edu.mx', '461d7a1b4cd6f184844f52f43c445cb42b793971862935516816ab5d220db918', 'alumno', '2026-02-19 20:58:08'),
(6, 'Carlos Adrian Garza Garza', 'Carlosgarza@ibero.edu.mx', 'ac9c2c34c9f7ad52528c3422af40a66e2e24aaf2a727831255413c9470158984', 'alumno', '2026-02-20 13:14:53'),
(7, 'Nuevo Administrador', 'admin2@ibero.edu.mx', '3b0b01e1e1f2fee1bd464ded0ecb23d0b11f4e85c8942a08cec242f182f46bdb', 'admin', '2026-02-20 14:07:36'),
(8, 'Brayan Diaz Morales', 'brayan@ibero.edu.mx', 'a930145867eeba10c6496bf881587171b0a0015fc4082e648d09da9df7f081dc', 'admin', '2026-02-20 14:15:31'),
(9, 'Juan Trevio', 'juan@ibero.edu.mx', 'f6ccb3e8d609012238c0b39e60b2c9632b3cdede91e035dad1de43469768f4cc', 'alumno', '2026-02-20 14:17:28');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
