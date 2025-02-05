-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2025 at 08:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `msc_sdp_delivery_mgt_cb015490`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(20) NOT NULL,
  `customer_mobile_no` varchar(15) NOT NULL,
  `customer_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_mobile_no`, `customer_email`) VALUES
(1, 'Alice', '+1-684-1476', 'alice@gmail.com'),
(2, 'Bob', '+1-922-1096', 'bob@gmail.com'),
(3, 'Charlie', '+1-371-9055', 'charlie@gmail.com'),
(4, 'David', '+1-745-9410', 'david@gmail.com'),
(5, 'Eva', '+1-754-9243', 'eva@gmail.com'),
(6, 'Frank', '+1-949-4548', 'frank@gmail.com'),
(7, 'Grace', '+1-687-8037', 'grace@gmail.com'),
(8, 'Hannah', '+1-498-9478', 'hannah@gmail.com'),
(9, 'Ivy', '+1-610-2412', 'ivy@gmail.com'),
(10, 'Jack', '+1-554-7375', 'jack@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `delivery_id` int(11) NOT NULL,
  `delivery_address` varchar(50) NOT NULL,
  `delivery_status` enum('Ready to Dispatch','In Transit','Completed','Driver Assigned') DEFAULT 'Ready to Dispatch',
  `delivery_schedule` date NOT NULL,
  `delivery_driver_id` int(11) DEFAULT NULL,
  `delivery_order_id` int(11) NOT NULL,
  `delivery_instructions` varchar(100) DEFAULT NULL,
  `dispatcher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`delivery_id`, `delivery_address`, `delivery_status`, `delivery_schedule`, `delivery_driver_id`, `delivery_order_id`, `delivery_instructions`, `dispatcher_id`) VALUES
(1, 'No 10, Flower Road', 'Ready to Dispatch', '2025-02-13', NULL, 1, NULL, NULL),
(2, 'No 3 Oak Avenue', 'Ready to Dispatch', '2025-02-13', NULL, 2, NULL, NULL),
(3, 'No 9 Cherry Crescent', 'Ready to Dispatch', '2025-02-13', NULL, 3, NULL, NULL),
(4, 'No 6 Elm Drive', 'Driver Assigned', '2025-02-13', 7, 4, NULL, 1),
(5, 'No 22 Aspen Place', 'In Transit', '2025-02-13', 6, 5, 'Dial intercom to enter into building.', 1),
(6, 'No 8 Willow Court', 'Completed', '2025-02-13', 8, 6, NULL, 1),
(7, 'No 7 Birch Way', 'Ready to Dispatch', '2025-02-13', NULL, 7, NULL, NULL),
(8, 'No 5 Cedar Boulevard', 'Driver Assigned', '2025-02-13', 8, 8, NULL, 1),
(9, 'No 4 Pine Lane', 'In Transit', '2025-02-13', 9, 9, NULL, 1),
(10, 'No 1, Maple Street', 'Completed', '2025-02-11', 7, 10, NULL, 1),
(11, 'No 10, Flower Road', 'Ready to Dispatch', '2025-02-13', NULL, 11, NULL, NULL),
(12, 'No 3 Oak Avenue', 'Ready to Dispatch', '2025-02-13', NULL, 12, NULL, NULL),
(13, 'No 9 Cherry Crescent', 'Completed', '2025-02-12', 1, 13, 'Keep parcel near doorstep.', 1),
(14, 'No 6 Elm Drive', 'Ready to Dispatch', '2025-02-13', NULL, 14, NULL, NULL),
(15, 'No 22 Aspen Place', 'Ready to Dispatch', '2025-02-13', NULL, 15, NULL, NULL),
(16, 'No 8 Willow Court', 'Ready to Dispatch', '2025-02-13', NULL, 16, NULL, NULL),
(17, 'No 7 Birch Way', 'Ready to Dispatch', '2025-02-13', NULL, 17, NULL, NULL),
(18, 'No 5 Cedar Boulevard', 'Driver Assigned', '2025-02-13', 7, 18, NULL, 1),
(19, 'No 4 Pine Lane', 'Ready to Dispatch', '2025-02-09', NULL, 19, NULL, NULL),
(20, 'No 1, Maple Street', 'Completed', '2025-02-09', 8, 20, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `drivers_id` int(11) NOT NULL,
  `drivers_name` varchar(20) NOT NULL,
  `drivers_availability` tinyint(1) DEFAULT 1,
  `drivers_daily_quota` int(11) NOT NULL DEFAULT 10,
  `drivers_contact_no` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`drivers_id`, `drivers_name`, `drivers_availability`, `drivers_daily_quota`, `drivers_contact_no`) VALUES
(1, 'Paul', 1, 10, '+44 7123 456789'),
(2, 'John', 1, 8, '+44 7456 789012'),
(3, 'Zhang', 1, 1, '+44 7901 234567'),
(4, 'Raj', 0, 6, '+44 7532 456789'),
(5, 'Jessica', 1, 0, '+44 7700 900123'),
(6, 'Kim', 1, 9, '+44 7421 987654'),
(7, 'Sarah', 1, 10, '+44 7954 321098'),
(8, 'Amit', 1, 5, '+44 7711 223344'),
(9, 'Chen', 1, 9, '+44 7812 345678'),
(10, 'Michael', 1, 7, '+44 7377 889900');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `login_id` int(11) NOT NULL,
  `login_username` varchar(100) NOT NULL,
  `login_password` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`login_id`, `login_username`, `login_password`, `user_id`) VALUES
(1, 'oliver@gmail.com', '1252626215e3fddd8c9a88659bbed7d25f770cd1', 1),
(2, 'sophia@gmail.com', '9e0d4995bc8b540346e8ce3e7c50ba71812faf34\r\n\r\n', 2);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `module` int(11) NOT NULL,
  `module_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module`, `module_name`) VALUES
(1, 'Dispatcher Management');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orders_id` int(11) NOT NULL,
  `orders_qty` int(11) NOT NULL,
  `orders_date` datetime NOT NULL,
  `orders_total` decimal(8,2) NOT NULL,
  `orders_invoice_no` varchar(15) NOT NULL,
  `orders_customer_id` int(11) NOT NULL,
  `orders_product_id` int(11) NOT NULL,
  `orders_status` enum('OPEN','CLOSED') DEFAULT 'OPEN'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orders_id`, `orders_qty`, `orders_date`, `orders_total`, `orders_invoice_no`, `orders_customer_id`, `orders_product_id`, `orders_status`) VALUES
(1, 9, '2024-11-17 00:00:00', 2700.00, 'INV-8037', 2, 5, 'OPEN'),
(2, 5, '2024-10-02 00:00:00', 1000.00, 'INV-2414', 3, 4, 'OPEN'),
(3, 4, '2024-09-09 00:00:00', 4000.00, 'INV-5479', 4, 1, 'OPEN'),
(4, 5, '2024-12-19 00:00:00', 4000.00, 'INV-3036', 5, 2, 'OPEN'),
(5, 7, '2024-11-26 00:00:00', 7000.00, 'INV-9413', 6, 1, 'OPEN'),
(6, 8, '2024-11-28 00:00:00', 2400.00, 'INV-4769', 7, 5, 'OPEN'),
(7, 7, '2024-12-08 00:00:00', 5600.00, 'INV-3384', 8, 2, 'OPEN'),
(8, 4, '2024-11-02 00:00:00', 3200.00, 'INV-8448', 9, 2, 'OPEN'),
(9, 2, '2024-09-19 00:00:00', 1000.00, 'INV-7499', 10, 3, 'OPEN'),
(10, 5, '2024-12-20 00:00:00', 4000.00, 'INV-4124', 1, 2, 'OPEN'),
(11, 1, '2024-11-17 00:00:00', 500.00, 'INV-4141', 2, 3, 'CLOSED'),
(12, 4, '2024-12-23 00:00:00', 1200.00, 'INV-1821', 3, 5, 'CLOSED'),
(13, 7, '2024-11-13 00:00:00', 5600.00, 'INV-5563', 4, 2, 'OPEN'),
(14, 8, '2024-09-14 00:00:00', 4000.00, 'INV-4821', 5, 3, 'OPEN'),
(15, 5, '2024-10-15 00:00:00', 5000.00, 'INV-4923', 6, 1, 'OPEN'),
(16, 2, '2024-12-26 00:00:00', 2000.00, 'INV-8974', 7, 1, 'OPEN'),
(17, 10, '2024-12-09 00:00:00', 10000.00, 'INV-3129', 8, 1, 'CLOSED'),
(18, 3, '2024-09-18 00:00:00', 2400.00, 'INV-7302', 9, 2, 'OPEN'),
(19, 8, '2024-11-23 00:00:00', 1600.00, 'INV-4086', 10, 4, 'OPEN'),
(20, 10, '2024-12-01 00:00:00', 8000.00, 'INV-6025', 1, 2, 'CLOSED'),
(21, 5, '2024-10-20 00:00:00', 1500.00, 'INV-6278', 2, 3, 'OPEN'),
(22, 4, '2024-11-11 00:00:00', 4000.00, 'INV-9421', 3, 1, 'OPEN'),
(23, 6, '2024-09-25 00:00:00', 1800.00, 'INV-5754', 4, 3, 'OPEN'),
(24, 9, '2024-12-05 00:00:00', 2700.00, 'INV-5668', 5, 3, 'OPEN'),
(25, 7, '2024-10-14 00:00:00', 2100.00, 'INV-4414', 6, 5, 'OPEN');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(30) NOT NULL,
  `product_unit_price` decimal(8,2) NOT NULL,
  `product_status` enum('Available','Discontinued') DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_unit_price`, `product_status`) VALUES
(1, 'Laptop', 1000.00, 'Available'),
(2, 'Smartphone', 800.00, 'Available'),
(3, 'Tablet', 500.00, 'Available'),
(4, 'Headphones', 200.00, 'Available'),
(5, 'Smartwatch', 300.00, 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'Dispatcher');

-- --------------------------------------------------------

--
-- Table structure for table `role_module`
--

CREATE TABLE `role_module` (
  `role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_module`
--

INSERT INTO `role_module` (`role_id`, `module_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_role` int(11) NOT NULL,
  `user_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_role`, `user_status`) VALUES
(1, 'Oliver', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `customer_mobile_no` (`customer_mobile_no`),
  ADD UNIQUE KEY `customer_email` (`customer_email`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`delivery_id`),
  ADD KEY `delivery_driver_id` (`delivery_driver_id`),
  ADD KEY `delivery_order_id` (`delivery_order_id`),
  ADD KEY `dispatcher_id` (`dispatcher_id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`drivers_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`login_id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`module`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orders_id`),
  ADD UNIQUE KEY `orders_invoice_no` (`orders_invoice_no`),
  ADD KEY `orders_customer_id` (`orders_customer_id`),
  ADD KEY `orders_product_id` (`orders_product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `drivers_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `module` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orders_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`delivery_driver_id`) REFERENCES `drivers` (`drivers_id`),
  ADD CONSTRAINT `delivery_ibfk_2` FOREIGN KEY (`delivery_order_id`) REFERENCES `orders` (`orders_id`),
  ADD CONSTRAINT `delivery_ibfk_3` FOREIGN KEY (`dispatcher_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`orders_customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`orders_product_id`) REFERENCES `product` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
