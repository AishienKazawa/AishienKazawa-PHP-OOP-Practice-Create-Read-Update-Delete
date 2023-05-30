-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2023 at 06:53 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emplyee_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_accounts`
--

CREATE TABLE `admin_accounts` (
  `id` int(11) NOT NULL,
  `admin_id` varchar(12) NOT NULL,
  `first_name` varchar(25) DEFAULT NULL,
  `last_name` varchar(25) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_accounts`
--

INSERT INTO `admin_accounts` (`id`, `admin_id`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, '123456', 'Aishien', 'Kazawa', 'aishien@gmail.com', '$2y$10$zjbbsdcKUBMwXjqAjk1ANO5CDaOEa.zqdBtLsy9Bbwgjqh9AvlYJO');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `department_id` varchar(13) DEFAULT NULL,
  `department_name` varchar(10) DEFAULT NULL,
  `acronym` varchar(5) DEFAULT NULL,
  `manager` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `department_id`, `department_name`, `acronym`, `manager`) VALUES
(2, '50021', 'Dept-Dev', 'DPTDV', 'Kurumi Tokisaki'),
(3, '50033', 'Dept-Sales', 'DPTSL', 'Shido Itsuka'),
(4, '50031', 'Dept-Desig', 'DPTDS', 'Akira Shinzo');

-- --------------------------------------------------------

--
-- Table structure for table `employee_accounts`
--

CREATE TABLE `employee_accounts` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(12) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(60) NOT NULL,
  `account_created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee_accounts`
--

INSERT INTO `employee_accounts` (`id`, `employee_id`, `email`, `password`, `account_created`) VALUES
(10, '2023-149824', 'aishien@gmail.com', '$2y$10$5XKaltpCyG57OLRQrFmt4e6xI4D9Y9nh8GXRusduG0NnhxgHaZ/Te', '2023-05-21'),
(11, '2023-501943', 'tohka@gmail', '$2y$10$jRH7r.qWiRCOHznFIFFKCOO7Uju0jcYa.Efsvv2uC3iIRt6RG7tDm', '2023-05-21'),
(12, '2023-354230', 'saito@gmail.com', '$2y$10$X740S4CuOBcJzBWjQtPJ4O38ed479uiFGlXJ2bn14AzPmLfd5Rukq', '2023-05-21'),
(13, '2023-132160', 'minato@gmail.com', '$2y$10$k0tgsb1TGsAfyg61l5dTLuE6sHenv6j8AFOnmzcgmnIlm1pcKBVeW', '2023-05-21');

-- --------------------------------------------------------

--
-- Table structure for table `employee_details`
--

CREATE TABLE `employee_details` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(12) DEFAULT NULL,
  `first_name` varchar(25) DEFAULT NULL,
  `last_name` varchar(25) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `contact_number` varchar(13) DEFAULT NULL,
  `role` varchar(25) DEFAULT NULL,
  `department` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee_details`
--

INSERT INTO `employee_details` (`id`, `employee_id`, `first_name`, `last_name`, `address`, `gender`, `birthday`, `contact_number`, `role`, `department`) VALUES
(7, '2023-149824', 'Aishien', 'Kazawa', '23 SM North, Brgy Kamias', 'Male', '2023-12-02', '09953087689', 'Web Developer', 'Dept-Dev'),
(8, '2023-501943', 'Tohka', 'Yatogami', '23 SM North, Brgy Diaz', 'Female', '2023-12-12', '09653456421', 'Call Center Agents', 'Dept-Sales'),
(9, '2023-354230', 'Saito', 'Hiragaya', '23 SM South, Brgy Sangita', 'Male', '2023-05-02', '09653452311', 'Graphic Designer', 'Dept-Desig'),
(10, '2023-132160', 'Minato', 'Uzumaki', '23 SM Fairview, Brgy Cristosan', 'Male', '2023-05-03', '09265678765', 'Call Center Agents', 'Dept-Dev'),
(11, '2023-713482', 'Kurumi', 'Tokisaki', '23 SM North, Brgy Tungko', 'Female', '1996-11-23', '09653456421', 'Call Center Agents', 'Dept-Sales');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role` varchar(25) NOT NULL,
  `acronym` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role`, `acronym`) VALUES
(1, 'Web Developer', 'WD'),
(2, 'Graphic Designer', 'GD'),
(3, 'Call Center Agents', 'CCA'),
(4, 'Sales Agent', 'SA');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_id` (`admin_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `department_id` (`department_id`);

--
-- Indexes for table `employee_accounts`
--
ALTER TABLE `employee_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`);

--
-- Indexes for table `employee_details`
--
ALTER TABLE `employee_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emp_id` (`employee_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employee_accounts`
--
ALTER TABLE `employee_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `employee_details`
--
ALTER TABLE `employee_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee_accounts`
--
ALTER TABLE `employee_accounts`
  ADD CONSTRAINT `employee_accounts_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee_details` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
