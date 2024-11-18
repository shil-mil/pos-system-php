-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:4306
-- Generation Time: Nov 18, 2024 at 04:44 PM
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
-- Database: `db_kapitansisig`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `firstname` varchar(191) NOT NULL,
  `lastname` varchar(191) NOT NULL,
  `username` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `is_banned` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=not_banned,1=banned',
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `position` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `firstname`, `lastname`, `username`, `password`, `is_banned`, `created_at`, `position`) VALUES
(1, 'Kristyle Marie', 'Modin', 'kmgmodin', '$2y$10$Aj1WGyrfovmy5VQA3wXKleP0nrV42X5knV.jfYJI1AStwXaV3kzDK', 0, '2024-10-16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`) VALUES
(1, 'Sisig Meal', 0),
(2, 'Barkada Meals', 0),
(5, 'Shawarma Meals', 0),
(6, 'Meryenda Meals', 0),
(7, 'Extra', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(566) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`) VALUES
(1, 'khim'),
(2, 'Dawn'),
(3, 'Shiloh Millondaga'),
(4, 'Evanica'),
(5, 'Kristyle'),
(6, 'Shiloh'),
(7, 'AJ');

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `category` varchar(191) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `reorder_point` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`, `unit_id`, `category`, `quantity`, `reorder_point`) VALUES
(4, 'Pork Belly', 13, 'Meat & Poultry', 3000.00, 10.00),
(5, 'Spoon', 14, 'Cutlery', 4.00, 10.00),
(6, 'Soy Sauce', 18, 'Condiments', 6000.00, 10.00),
(7, 'Tuna', 13, 'Meat & Poultry', 0.00, 10.00),
(8, 'Egg', 14, 'Others', 43.00, 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `ingredients_items`
--

CREATE TABLE `ingredients_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredients_items`
--

INSERT INTO `ingredients_items` (`id`, `order_id`, `ingredient_id`, `unit_id`, `price`, `quantity`) VALUES
(67, 41, 5, 14, 10.00, 1.00),
(68, 41, 6, 19, 70.00, 1.00),
(69, 41, 4, 16, 250.00, 1.00),
(70, 41, 8, 15, 120.00, 1.00),
(71, 42, 5, 14, 10.00, 2.00),
(72, 42, 6, 19, 70.00, 4.00),
(73, 42, 4, 16, 250.00, 2.00),
(74, 42, 8, 15, 120.00, 3.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `tracking_no` varchar(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `total_amount` varchar(100) NOT NULL,
  `amount_received` decimal(10,2) NOT NULL,
  `change_money` varchar(200) NOT NULL,
  `order_date` datetime DEFAULT NULL,
  `order_status` enum('Placed','Preparing','Completed','Cancelled') NOT NULL DEFAULT 'Placed' COMMENT 'placed, preparing, completed, cancelled',
  `payment_mode` varchar(100) NOT NULL COMMENT 'cash,online',
  `order_placed_by_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `tracking_no`, `invoice_no`, `total_amount`, `amount_received`, `change_money`, `order_date`, `order_status`, `payment_mode`, `order_placed_by_id`) VALUES
(16, 4, '568089', 'INV-841807', '200', 0.00, '', '2024-11-10 01:14:43', 'Completed', 'Cash Payment', 'Kristyle Marie'),
(17, 5, '460969', 'INV-530521', '200', 0.00, '', '2024-11-10 01:15:21', 'Completed', 'Cash Payment', 'Kristyle Marie'),
(18, 6, '882668', 'INV-464532', '100', 0.00, '', '2024-11-10 01:16:35', 'Placed', 'Cash Payment', 'Kristyle Marie'),
(19, 6, '279301', 'INV-254926', '100', 0.00, '', '2024-11-10 01:17:38', 'Preparing', 'Cash Payment', 'Kristyle Marie'),
(20, 4, '987494', 'INV-382907', '410', 0.00, '', '2024-11-10 01:47:03', 'Preparing', 'Cash Payment', 'Kristyle Marie'),
(21, 6, '000001', 'INV-460557', '100', 0.00, '', '2024-11-10 01:57:09', 'Placed', 'Online Payment', 'Kristyle Marie'),
(22, 6, '000002', 'INV-369317', '100', 0.00, '', '2024-11-12 08:56:18', 'Placed', 'Online Payment', 'Kristyle Marie'),
(23, 4, '000003', 'INV-557417', '10', 10.00, '0', '2024-11-18 10:15:38', 'Preparing', 'Cash Payment', 'Kristyle Marie'),
(24, 7, '000004', 'INV-243240', '100', 120.00, '20', '2024-11-18 10:17:31', 'Placed', 'Cash Payment', 'Kristyle Marie'),
(25, 7, '000005', 'INV-312838', '10', 10.00, '0', '2024-11-18 10:22:21', 'Preparing', 'Cash Payment', 'Kristyle Marie');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` varchar(100) NOT NULL,
  `quantity` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `price`, `quantity`) VALUES
(1, 1, 1, '10.00', '3'),
(2, 2, 1, '10.00', '10'),
(3, 3, 1, '10.00', '1'),
(4, 4, 1, '10.00', '1'),
(5, 5, 1, '10.00', '1'),
(6, 6, 2, '50.00', '1'),
(7, 7, 3, '100.00', '1'),
(8, 8, 1, '10.00', '1'),
(9, 9, 1, '10.00', '1'),
(10, 10, 3, '100.00', '1'),
(11, 11, 3, '100.00', '1'),
(12, 12, 3, '100.00', '10'),
(13, 13, 1, '10.00', '1'),
(14, 14, 4, '190.00', '1'),
(15, 15, 6, '100.00', '1'),
(16, 15, 8, '10.00', '1'),
(17, 16, 6, '100.00', '2'),
(18, 17, 5, '100.00', '2'),
(19, 18, 5, '100.00', '1'),
(20, 19, 6, '100.00', '1'),
(21, 20, 5, '100.00', '4'),
(22, 20, 8, '10.00', '1'),
(23, 21, 5, '100.00', '1'),
(24, 22, 6, '100.00', '1'),
(25, 23, 8, '10.00', '1'),
(26, 24, 5, '100.00', '1'),
(27, 25, 8, '10.00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `productname` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `productname`, `description`, `price`, `image`, `created_at`, `quantity`) VALUES
(5, 1, 'Pork Sisig (Test 1)', '', 100.00, 'pics/uploads/products/1724471945.jpg\r\n', '2024-11-08', 4),
(6, 1, 'Tuna Sisig', '', 100.00, 'pics/uploads/products/1724471945.jpg\r\n', '2024-11-08', 0),
(8, 7, 'Fried Egg', '', 10.00, 'pics/uploads/products/1724471945.jpg\r\n', '2024-11-08', 41);

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorders`
--

CREATE TABLE `purchaseorders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `tracking_no` varchar(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `total_amount` varchar(100) NOT NULL,
  `order_date` datetime NOT NULL,
  `order_status` varchar(100) NOT NULL,
  `ingPayment_mode` varchar(100) NOT NULL,
  `order_placed_by_id` varchar(100) NOT NULL,
  `supplierName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchaseorders`
--

INSERT INTO `purchaseorders` (`id`, `customer_id`, `tracking_no`, `invoice_no`, `total_amount`, `order_date`, `order_status`, `ingPayment_mode`, `order_placed_by_id`, `supplierName`) VALUES
(41, 1, '000001', 'INV-653110', '450', '2024-11-18 09:22:23', 'Delivered', 'Cash Payment', 'Kristyle Marie', '1'),
(42, 1, '000002', 'INV-758307', '1160', '2024-11-18 09:52:41', 'Delivered', 'Online Payment', 'Kristyle Marie', '1');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `product_id`, `name`, `created_at`) VALUES
(1, 1, '', '2024-10-22 05:38:04'),
(2, 2, '', '2024-10-22 06:57:40'),
(3, 3, '', '2024-10-22 07:03:38'),
(4, 4, '', '2024-11-08 12:49:51'),
(5, 5, '', '2024-11-08 13:05:37'),
(6, 6, '', '2024-11-08 13:25:18'),
(7, 8, '', '2024-11-08 13:50:49');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_ingredients`
--

CREATE TABLE `recipe_ingredients` (
  `id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_ingredients`
--

INSERT INTO `recipe_ingredients` (`id`, `recipe_id`, `ingredient_id`, `quantity`, `unit_id`) VALUES
(1, 1, 15, 1.00, 16),
(5, 2, 19, 50.00, 13),
(6, 2, 22, 50.00, 18),
(7, 2, 21, 50.00, 13),
(8, 2, 18, 1.00, 14),
(9, 2, 20, 50.00, 13),
(10, 2, 23, 50.00, 18),
(11, 3, 24, 100.00, 13),
(12, 1, 16, 1.00, 14),
(13, 4, 4, 100.00, 13),
(14, 4, 5, 1.00, 14),
(15, 4, 6, 50.00, 18),
(16, 5, 4, 100.00, 13),
(17, 5, 5, 1.00, 14),
(18, 5, 6, 100.00, 18),
(19, 6, 7, 100.00, 13),
(20, 6, 5, 1.00, 14),
(21, 6, 6, 50.00, 13),
(22, 7, 8, 1.00, 14);

-- --------------------------------------------------------

--
-- Table structure for table `stockin`
--

CREATE TABLE `stockin` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `purchaseorder_id` int(11) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `stockin_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stockin`
--

INSERT INTO `stockin` (`id`, `admin_id`, `purchaseorder_id`, `invoice_no`, `supplier_id`, `stockin_date`) VALUES
(42, 1, 41, 'INV-653110', 1, '2024-11-18 09:23:30'),
(43, 1, 42, 'INV-758307', 1, '2024-11-18 09:53:00');

-- --------------------------------------------------------

--
-- Table structure for table `stockin_ingredients`
--

CREATE TABLE `stockin_ingredients` (
  `id` int(11) NOT NULL,
  `stockin_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `totalPrice` int(11) NOT NULL,
  `expiryDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stockin_ingredients`
--

INSERT INTO `stockin_ingredients` (`id`, `stockin_id`, `ingredient_id`, `quantity`, `unit_id`, `totalPrice`, `expiryDate`) VALUES
(72, 42, 5, 2.00, 14, 20, '2024-12-07'),
(73, 42, 6, 2.00, 19, 140, '2024-11-18'),
(74, 42, 4, 1.00, 16, 250, '2024-11-18'),
(75, 42, 8, 1.00, 15, 120, '2024-11-28'),
(76, 43, 5, 2.00, 14, 20, '2024-11-29'),
(77, 43, 6, 4.00, 19, 280, '2024-12-04'),
(78, 43, 4, 2.00, 16, 500, '2024-11-30'),
(79, 43, 8, 3.00, 15, 360, '2024-12-05');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `firstname` varchar(191) NOT NULL,
  `lastname` varchar(191) NOT NULL,
  `phonenumber` varchar(191) NOT NULL,
  `address` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `firstname`, `lastname`, `phonenumber`, `address`) VALUES
(1, 'Kristyle Marie', 'Modin', '09094192413', 'Purok Lomboy Coog, Mandug,'),
(2, 'Kassandra Mae', 'Modin', '0934567890', 'Coog'),
(3, 'Kim 3', 'Modin', '1234567890', 'bfjdh');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_ingredients`
--

CREATE TABLE `supplier_ingredients` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `unit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier_ingredients`
--

INSERT INTO `supplier_ingredients` (`id`, `supplier_id`, `ingredient_id`, `price`, `unit_id`) VALUES
(4, 1, 5, 10.00, 14),
(5, 2, 4, 150.00, 16),
(6, 2, 7, 170.00, 16),
(7, 1, 6, 70.00, 19),
(8, 2, 8, 120.00, 15),
(9, 1, 4, 250.00, 16),
(10, 1, 8, 120.00, 15);

-- --------------------------------------------------------

--
-- Table structure for table `units_of_measure`
--

CREATE TABLE `units_of_measure` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `uom_name` varchar(255) DEFAULT NULL,
  `type` enum('reference','bigger','smaller') DEFAULT NULL,
  `ratio` decimal(10,5) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `rounding_precision` decimal(10,5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `units_of_measure`
--

INSERT INTO `units_of_measure` (`id`, `category_id`, `uom_name`, `type`, `ratio`, `active`, `rounding_precision`) VALUES
(13, 5, 'g', 'reference', 1.00000, 1, 0.01000),
(14, 6, 'pcs', 'reference', 1.00000, 1, 0.01000),
(15, 6, 'dozen', 'bigger', 12.00000, 1, 0.01000),
(16, 5, 'kg', 'bigger', 1000.00000, 1, 0.01000),
(18, 7, 'ml', 'reference', 1.00000, 1, 0.01000),
(19, 7, 'L', 'bigger', 1000.00000, 1, 0.01000),
(20, 7, 'gl', 'bigger', 0.00026, 1, 0.01000),
(22, 5, 'mg', 'smaller', 0.00100, 1, 0.00000);

-- --------------------------------------------------------

--
-- Table structure for table `unit_categories`
--

CREATE TABLE `unit_categories` (
  `id` int(11) NOT NULL,
  `category_unit_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit_categories`
--

INSERT INTO `unit_categories` (`id`, `category_unit_name`) VALUES
(5, 'Weight'),
(6, 'Quantity'),
(7, 'Volume');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `ingredients_items`
--
ALTER TABLE `ingredients_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ingredient_id` (`ingredient_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchaseorders`
--
ALTER TABLE `purchaseorders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_id` (`recipe_id`),
  ADD KEY `ingredient_id` (`ingredient_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `stockin`
--
ALTER TABLE `stockin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stockin_ingredients`
--
ALTER TABLE `stockin_ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_ingredients`
--
ALTER TABLE `supplier_ingredients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_ingredients_ibfk_1` (`supplier_id`),
  ADD KEY `supplier_ingredients_ibfk_2` (`ingredient_id`);

--
-- Indexes for table `units_of_measure`
--
ALTER TABLE `units_of_measure`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `unit_categories`
--
ALTER TABLE `unit_categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ingredients_items`
--
ALTER TABLE `ingredients_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `purchaseorders`
--
ALTER TABLE `purchaseorders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `stockin`
--
ALTER TABLE `stockin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `stockin_ingredients`
--
ALTER TABLE `stockin_ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier_ingredients`
--
ALTER TABLE `supplier_ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `units_of_measure`
--
ALTER TABLE `units_of_measure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `unit_categories`
--
ALTER TABLE `unit_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD CONSTRAINT `ingredients_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `units_of_measure` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `supplier_ingredients`
--
ALTER TABLE `supplier_ingredients`
  ADD CONSTRAINT `supplier_ingredients_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `supplier_ingredients_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
