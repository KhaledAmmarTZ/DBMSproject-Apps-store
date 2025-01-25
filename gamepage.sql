-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2024 at 04:29 PM
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
-- Database: `gamepage`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `image` varchar(255) DEFAULT NULL,
  `admin_id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dateofbirth` date DEFAULT NULL,
  `phonenumber` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`image`, `admin_id`, `username`, `email`, `dateofbirth`, `phonenumber`, `password`) VALUES
(NULL, '659031d04eabd', 'Admin', 'Admin@gmail.com', '2222-02-22', '01864488495', '1234'),
(NULL, 'Adm.65b228ce7c9e3', 'ammar', 'ada@gmail.com', '2002-02-22', '4363645636', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryname` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryname`, `description`) VALUES
('Girls', 'This is for Girls'),
('Kids', 'Under 7 years'),
('Men', 'Above 18 Years'),
('Teenage', 'Under 18 years');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `imag` varchar(255) DEFAULT NULL,
  `customer_id` varchar(255) NOT NULL,
  `usernam` varchar(255) NOT NULL,
  `emai` varchar(255) NOT NULL,
  `dateofbirt` date DEFAULT NULL,
  `phonenumbe` varchar(15) NOT NULL,
  `passwor` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 CHECK (`status` in (0,1)),
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`imag`, `customer_id`, `usernam`, `emai`, `dateofbirt`, `phonenumbe`, `passwor`, `status`, `amount`) VALUES
(NULL, '659031ebc20f1', 'customer23', 'khaledammar593@gmail.com', '1222-03-31', '01733010079', '1234', 1, 100.00),
('ingle-game.jpg', '6598419633f82', 'omi', 'omi@gmail.com', '2001-05-11', '342546436323', '1234', 1, 65.68),
(NULL, 'Cus.659eab9f315a6', 'erer', 'erer@gmail.com', '2001-02-22', '3653643453', '1234', 1, 116.40);

-- --------------------------------------------------------

--
-- Table structure for table `developer`
--

CREATE TABLE `developer` (
  `mage` varchar(255) DEFAULT NULL,
  `developer_id` varchar(255) NOT NULL,
  `sername` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `ateofbirth` date DEFAULT NULL,
  `honenumber` varchar(15) NOT NULL,
  `assword` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 CHECK (`status` in (0,1)),
  `amountre` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `developer`
--

INSERT INTO `developer` (`mage`, `developer_id`, `sername`, `mail`, `ateofbirth`, `honenumber`, `assword`, `status`, `amountre`) VALUES
(NULL, '659032cd9a321', 'developer', 'developer@gmail.com', '2122-02-22', '0186666666', '1234', 1, 100.00),
('categories-04.jpg', '65916e9984ea5', 'devil', 'devil@gmail.com', '2222-02-22', '0134567446', '2345', 1, 123.00);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` varchar(20) NOT NULL,
  `app_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `developer_id` varchar(20) DEFAULT NULL,
  `version` varchar(20) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `trating` decimal(3,2) DEFAULT NULL,
  `treviews` int(11) DEFAULT NULL,
  `download_count` int(11) DEFAULT NULL,
  `total_sold` decimal(10,2) DEFAULT 0.00,
  `categoryname` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `app_name`, `description`, `developer_id`, `version`, `price`, `release_date`, `trating`, `treviews`, `download_count`, `total_sold`, `categoryname`, `image`) VALUES
('app_6593d571ba4451.7', 'gensin', ' it is a great game', '65916e9984ea5', '1.2', 19.90, '2020-05-08', NULL, NULL, 1, 19.90, 'Teenage', ''),
('app_6593f0a7caae80.6', 'epic', 'wgat a agame', '65916e9984ea5', '2', 12.00, '2012-02-12', NULL, NULL, 1, 12.00, 'Men', NULL),
('app_6593f10e976a43.7', 'ff', ' abej agane', '659032cd9a321', '0.1', 0.00, '2011-11-11', NULL, NULL, 1, 0.00, 'Kids', NULL),
('app_6596c771543a57.0', 'ingle', ' femo ', '65916e9984ea5', '0.1', 23.00, '2009-02-22', 3.00, 2, 3, 69.00, 'Men', '../image/ingle-game.jpg'),
('app_65abe412a96789.4', 'tren', ' pls dont paly tis game', '65916e9984ea5', '1.003', 11.32, '2019-02-22', NULL, NULL, NULL, 11.32, 'Teenage', '../image/trending-04.jpg'),
('sadwasd', 'birbie', ' bododo', '65916e9984ea5', '2', 4.00, '2022-01-12', 0.00, NULL, 2, 8.00, 'Girls', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recharge`
--

CREATE TABLE `recharge` (
  `recharge_id` varchar(50) NOT NULL,
  `customer_id` varchar(50) DEFAULT NULL,
  `method` varchar(50) DEFAULT NULL,
  `recharge_amount` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recharge`
--

INSERT INTO `recharge` (`recharge_id`, `customer_id`, `method`, `recharge_amount`) VALUES
('recharge.65cf7bec4b77d', 'Cus.659eab9f315a6', 'Bkash', '2'),
('recharge.65cf7c3f70f59', 'Cus.659eab9f315a6', 'Rocket', '2'),
('recharge.65cf7d4a85c34', 'Cus.659eab9f315a6', 'Visa', '35.4');

-- --------------------------------------------------------

--
-- Table structure for table `remethod`
--

CREATE TABLE `remethod` (
  `method` varchar(50) NOT NULL,
  `disc` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `remethod`
--

INSERT INTO `remethod` (`method`, `disc`) VALUES
('Bkash', 'b'),
('Nagad', 'c'),
('Rocket', 'd'),
('Visa', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `report_id` varchar(50) NOT NULL,
  `customer_id` varchar(50) DEFAULT NULL,
  `product_id` varchar(50) DEFAULT NULL,
  `bug` tinyint(1) DEFAULT NULL,
  `crash` tinyint(1) DEFAULT NULL,
  `performance` tinyint(1) DEFAULT NULL,
  `feature` tinyint(1) DEFAULT NULL,
  `additionalComments` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`report_id`, `customer_id`, `product_id`, `bug`, `crash`, `performance`, `feature`, `additionalComments`) VALUES
('RE.65b225eb156a0', '659031ebc20f1', 'app_6596c771543a57.0', 0, 0, 0, 0, 'fsfsf'),
('RE.65b225f3c73d3', '659031ebc20f1', 'app_6596c771543a57.0', 1, 1, 1, 1, 'dfsf');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` varchar(255) NOT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT NULL CHECK (`rating` >= 0 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `customer_id`, `product_id`, `rating`, `comment`, `review_date`) VALUES
('659031ebc20f1_app_6596c771543a57.0', '659031ebc20f1', 'app_6596c771543a57.0', 5.00, 'sfsds', '2024-01-07 07:33:04'),
('6598419633f82_app_6596c771543a57.0', '6598419633f82', 'app_6596c771543a57.0', 1.00, 'fsdf', '2024-01-07 08:03:03');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` varchar(50) NOT NULL,
  `product_id` varchar(50) DEFAULT NULL,
  `customer_id` varchar(50) DEFAULT NULL,
  `transaction_date` datetime DEFAULT NULL,
  `transaction_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `product_id`, `customer_id`, `transaction_date`, `transaction_amount`) VALUES
('app_6593d571ba4451.7_6598419633f82', 'app_6593d571ba4451.7', '6598419633f82', '2024-01-06 07:06:48', 19.90),
('app_6593f0a7caae80.6_6598419633f82', 'app_6593f0a7caae80.6', '6598419633f82', '2024-01-06 06:55:40', 12.00),
('app_6593f10e976a43.7_6598419633f82', 'app_6593f10e976a43.7', '6598419633f82', '2024-02-16 14:57:30', 0.00),
('app_6596c771543a57.0_659031ebc20f1', 'app_6596c771543a57.0', '659031ebc20f1', '2024-01-05 18:50:23', 23.00),
('app_6596c771543a57.0_6598419633f82', 'app_6596c771543a57.0', '6598419633f82', '2024-01-05 18:51:39', 23.00),
('app_6596c771543a57.0_Cus.659eab9f315a6', 'app_6596c771543a57.0', 'Cus.659eab9f315a6', '2024-02-16 14:59:21', 23.00),
('app_65abe412a96789.4_6598419633f82', 'app_65abe412a96789.4', '6598419633f82', '2024-02-16 14:45:32', 11.32),
('sadwasd_659031ebc20f1', 'sadwasd', '659031ebc20f1', '2024-01-11 08:54:52', 4.00),
('sadwasd_6598419633f82', 'sadwasd', '6598419633f82', '2024-01-05 19:34:58', 4.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phonenumber` (`phonenumber`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryname`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `emai` (`emai`),
  ADD UNIQUE KEY `phonenumbe` (`phonenumbe`);

--
-- Indexes for table `developer`
--
ALTER TABLE `developer`
  ADD PRIMARY KEY (`developer_id`),
  ADD UNIQUE KEY `mail` (`mail`),
  ADD UNIQUE KEY `honenumber` (`honenumber`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `developer_id` (`developer_id`),
  ADD KEY `fk_product_category` (`categoryname`);

--
-- Indexes for table `recharge`
--
ALTER TABLE `recharge`
  ADD PRIMARY KEY (`recharge_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `method` (`method`);

--
-- Indexes for table `remethod`
--
ALTER TABLE `remethod`
  ADD PRIMARY KEY (`method`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`categoryname`) REFERENCES `category` (`categoryname`),
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`developer_id`) REFERENCES `developer` (`developer_id`);

--
-- Constraints for table `recharge`
--
ALTER TABLE `recharge`
  ADD CONSTRAINT `recharge_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `recharge_ibfk_2` FOREIGN KEY (`method`) REFERENCES `remethod` (`method`);

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `report_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
