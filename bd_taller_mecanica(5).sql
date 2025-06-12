-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2025 at 10:36 AM
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
-- Database: `bd_taller_mecanica`
--

-- --------------------------------------------------------

--
-- Table structure for table `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `id_solicitud` int(11) DEFAULT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_mecanico` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion_cliente` varchar(255) NOT NULL,
  `estado_cita` enum('En revision','Finalizada') NOT NULL,
  `veredicto_mecanico` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `citas`
--

INSERT INTO `citas` (`id`, `id_solicitud`, `id_cliente`, `id_vehiculo`, `id_mecanico`, `fecha`, `descripcion_cliente`, `estado_cita`, `veredicto_mecanico`) VALUES
(1, 1, 1, 3, 3, '2025-06-27', 'Suena de forma extraña al cambiar las marchas', 'En revision', ''),
(2, 2, 2, 4, 3, '2025-06-25', 'Suena raro al arrancar', 'Finalizada', 'Correcto, fallo en la inyeccion. nuevos manguitos.'),
(3, 3, 3, 2, 5, '2025-06-27', 'Suena raro al arrancar el motor', 'En revision', ''),
(4, 4, 4, 5, 5, '2025-07-22', 'Cambio de ruedas', 'Finalizada', 'Hecho. Cuatro de 19\".'),
(5, 5, 5, 6, 8, '2025-07-20', 'Los frenos hacen ruido al frenar.\r\n\r\n', 'En revision', ''),
(6, 9, 9, 10, 5, '2025-06-13', 'Tirones al acelerar.', 'En revision', ''),
(7, 17, 13, 16, 8, '2025-06-18', 'Se escucha un golpeteo cerca de las ruedas.', 'Finalizada', 'Objeto saliente interrumpe giro y correcto funcionamiento'),
(8, 7, 7, 8, 8, '2025-08-27', 'Ruidos al pasar baches o badenes.', 'Finalizada', 'Reajuste de suspensiones'),
(9, 8, 8, 9, 8, '2025-07-06', 'Crujidos al girar el volante.', 'En revision', ''),
(10, 16, 3, 15, 5, '2025-07-30', 'Una rueda pierde aire con frecuencia.', 'En revision', '');

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `email`, `telefono`) VALUES
(1, 'Miguel', 'miguelflonav@gmail.com', '633612329'),
(2, 'Pedro', 'pedro@pedro.com', '622612354'),
(3, 'Amalia', 'amanavarrete@gmail.com', '657483203'),
(4, 'Raul Garces', 'rgarces@gmail.com', '689654675'),
(5, 'Ivan garces', 'igarces@gmail.com', '827342132'),
(6, 'David Exposito', 'dvdgon@gmail.com', '384729934'),
(7, 'Ines Guillo', 'inesigg@gmail.com', '834574923'),
(8, 'Adrian Jimenez', 'adri014@gmail.com', '612345677'),
(9, 'Oliver Isaac', 'oliva@gmail.com', '743829832'),
(10, 'Sergio Gomez', 'sgalejo@gmial.com', '738228823'),
(11, 'Javi Baez', 'javibaez02@gmail.com', '928374365'),
(12, 'Mauricio', 'mauricio@gmail.com', '829128192'),
(13, 'Iris Andres', 'irissan@gmail.com', '382483200');

-- --------------------------------------------------------

--
-- Table structure for table `clientes_vehiculos`
--

CREATE TABLE `clientes_vehiculos` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `clientes_vehiculos`
--

INSERT INTO `clientes_vehiculos` (`id`, `id_cliente`, `id_vehiculo`) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 2, 2),
(4, 2, 4),
(5, 3, 2),
(6, 3, 15),
(7, 4, 5),
(8, 5, 6),
(9, 5, 13),
(10, 6, 7),
(11, 7, 8),
(12, 8, 9),
(13, 9, 10),
(14, 10, 11),
(15, 11, 12),
(16, 12, 14),
(17, 13, 16),
(18, 11, 17);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `rol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Recepcionista'),
(3, 'Mecanico');

-- --------------------------------------------------------

--
-- Table structure for table `solicitudes_cita`
--

CREATE TABLE `solicitudes_cita` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `fecha_solicitada` date NOT NULL,
  `estado_solicitud` enum('pendiente','confirmada') NOT NULL,
  `descripcion_cliente` varchar(255) NOT NULL,
  `solicitante_nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `solicitudes_cita`
--

INSERT INTO `solicitudes_cita` (`id`, `id_cliente`, `id_vehiculo`, `fecha_solicitada`, `estado_solicitud`, `descripcion_cliente`, `solicitante_nombre`) VALUES
(1, 1, 3, '2025-06-27', 'confirmada', 'Suena de forma extraña al cambiar las marchas', 'Miguel'),
(2, 2, 4, '2025-06-25', 'confirmada', 'Suena raro al arrancar', 'Pedro '),
(3, 3, 2, '2025-06-27', 'confirmada', 'Suena raro al arrancar el motor', 'Amalia'),
(4, 4, 5, '2025-07-22', 'confirmada', 'Cambio de ruedas', 'Raul Garces'),
(5, 5, 6, '2025-07-20', 'confirmada', 'Los frenos hacen ruido al frenar.\r\n\r\n', 'Ivan garces'),
(6, 6, 7, '2025-08-28', 'pendiente', 'Neumáticos desgastados irregularmente', 'David Exposito'),
(7, 7, 8, '2025-08-27', 'confirmada', 'Ruidos al pasar baches o badenes.', 'Ines Guillo'),
(8, 8, 9, '2025-07-06', 'confirmada', 'Crujidos al girar el volante.', 'Adrian Jimenez'),
(9, 9, 10, '2025-06-13', 'confirmada', 'Tirones al acelerar.', 'Oliver Isaac'),
(10, 10, 11, '2025-09-15', 'pendiente', 'Pérdida de potencia.', 'Sergio Gomez'),
(11, 11, 12, '2025-08-15', 'pendiente', 'Problemas con los elevalunas eléctricos.', 'Javi Baez'),
(12, 5, 13, '2025-08-10', 'pendiente', 'No enfría el aire acondicionado.', 'Ivan Garces'),
(13, 12, 14, '2025-09-29', 'pendiente', 'Zumbido constante a ciertas velocidades.', 'Mauricio'),
(14, 1, 1, '2025-10-01', 'pendiente', 'Pierde líquido de frenos.', 'Miguel'),
(15, 1, 1, '2025-08-08', 'pendiente', 'NIIIDEA', 'Miguel'),
(16, 3, 15, '2025-07-30', 'confirmada', 'Una rueda pierde aire con frecuencia.', 'Amalia'),
(17, 13, 16, '2025-06-18', 'confirmada', 'Se escucha un golpeteo cerca de las ruedas.', 'Iris Andres');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `telefono`, `id_rol`) VALUES
(1, 'Admin', 'admin@admin.com', '202cb962ac59075b964b07152d234b70', 125463879, 1),
(2, 'recepcionista1', 'recepcionista1@gmail.com', '202cb962ac59075b964b07152d234b70', 654123987, 2),
(3, 'mecanico1', 'mecanico1@gmail.com', '202cb962ac59075b964b07152d234b70', 874563219, 3),
(4, 'recepcionista2', 'recepcionista2@gmail.com', '202cb962ac59075b964b07152d234b70', 519673248, 2),
(5, 'mecanico2', 'mecanico2@gmail.com', '202cb962ac59075b964b07152d234b70', 963471528, 3),
(8, 'mecanico3', 'mecanico3@mecanico3.com', '202cb962ac59075b964b07152d234b70', 622, 3);

-- --------------------------------------------------------

--
-- Table structure for table `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` int(11) NOT NULL,
  `marca` varchar(255) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `año` varchar(4) NOT NULL,
  `matricula` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `vehiculos`
--

INSERT INTO `vehiculos` (`id`, `marca`, `modelo`, `año`, `matricula`) VALUES
(1, 'BMW', '330d', '2012', 'LS 7892 AS'),
(2, 'Fiat', 'Punto', '2012', '9867 KJH'),
(3, 'Citroen', 'C4', '2006', 'GV 6831 YF'),
(4, 'Dacia', 'Sandero', '2014', 'POE 8376 hso'),
(5, 'Mazda', '3', '2008', 'CRE 3892 SPO'),
(6, 'Seat', 'Leon', '2011', 'FHR 8292 JIO'),
(7, 'SAAB', 'Cabrio', '2002', 'BPE 3933 KLP'),
(8, 'volkswagen', 'golf', '2019', '8493 JKL'),
(9, 'Peugeot', '208', '2021', '2371 MNB'),
(10, 'Audi', 'A3', '2020', '5108 HTR'),
(11, 'Toyota', 'Corola', '2023', '3267 BNM'),
(12, 'Mercedes-Benz', 'Clase A', '2021', '9951 LPO'),
(13, 'Hyundai', 'i30', '2022', '5896 TRE'),
(14, 'Skoda', 'Octavia', '2025', '1482 DFG'),
(15, 'Mercedes AMG', 'G63', '2022', 'TGF 9393 SSL'),
(16, 'opel', 'astra', '2018', '6283 PLM'),
(17, 'Megane', 'Cactus', '2009', '2893 IJH');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clientes_vehiculos`
--
ALTER TABLE `clientes_vehiculos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `solicitudes_cita`
--
ALTER TABLE `solicitudes_cita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `telefono` (`telefono`);

--
-- Indexes for table `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `clientes_vehiculos`
--
ALTER TABLE `clientes_vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `solicitudes_cita`
--
ALTER TABLE `solicitudes_cita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
