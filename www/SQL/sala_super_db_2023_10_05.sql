-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2023 at 01:16 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sala_super_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `catid` int(11) NOT NULL,
  `category` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`catid`, `category`) VALUES
(24, 'Cosmetic'),
(25, 'Grocery'),
(26, 'Stationary');

-- --------------------------------------------------------

--
-- Table structure for table `incoming_stock`
--

CREATE TABLE `incoming_stock` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `purchaseprice` float NOT NULL,
  `saleprice` float NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incoming_stock`
--

INSERT INTO `incoming_stock` (`id`, `pid`, `stock`, `purchaseprice`, `saleprice`, `date_time`) VALUES
(22, 22, 150, 126, 145, '2023-09-05 14:32:20'),
(23, 23, 144, 136, 145, '2023-09-05 14:35:24'),
(24, 24, 180, 100, 130, '2023-09-05 14:37:59'),
(25, 25, 144, 140, 160, '2023-09-05 14:39:37'),
(26, 26, 90, 116, 130, '2023-09-05 14:40:48'),
(27, 27, 180, 118, 125, '2023-09-05 14:41:32'),
(28, 28, 144, 140, 160, '2023-09-05 14:42:55'),
(29, 29, 144, 105, 125, '2023-09-05 14:45:47'),
(30, 30, 144, 105, 125, '2023-09-05 14:46:55'),
(31, 31, 144, 105, 125, '2023-09-05 14:47:35'),
(32, 32, 144, 105, 125, '2023-09-05 14:49:55'),
(33, 33, 144, 105, 125, '2023-09-05 14:50:45'),
(34, 34, 147, 149.66, 160, '2023-09-05 14:52:27'),
(35, 35, 36, 395, 420, '2023-09-05 14:55:57'),
(36, 36, 120, 142.17, 150, '2023-09-05 14:57:06'),
(37, 37, 144, 65, 70, '2023-09-05 14:58:32'),
(38, 38, 48, 169, 180, '2023-09-05 14:59:46'),
(39, 39, 288, 37.45, 40, '2023-09-05 15:00:39'),
(40, 40, 48, 174, 185, '2023-09-05 15:02:26'),
(41, 41, 32, 328, 350, '2023-09-05 15:06:28'),
(42, 42, 18, 215, 250, '2023-09-05 15:08:56'),
(43, 43, 12, 262, 310, '2023-09-05 15:09:45'),
(44, 44, 20, 255, 300, '2023-09-05 15:14:08'),
(45, 45, 72, 112, 140, '2023-09-05 15:15:34'),
(46, 46, 60, 114, 125, '2023-09-05 15:17:19'),
(47, 47, 60, 183, 200, '2023-09-05 15:18:15'),
(48, 48, 24, 245, 275, '2023-09-05 15:22:31'),
(49, 49, 30, 200, 260, '2023-09-05 15:25:08'),
(50, 50, 24, 186.5, 230, '2023-09-05 15:26:37'),
(51, 51, 120, 109, 120, '2023-09-05 15:28:02'),
(52, 52, 48, 223, 265, '2023-09-05 15:29:08'),
(53, 53, 24, 403, 480, '2023-09-05 15:29:49'),
(54, 54, 17, 130, 140, '2023-09-05 15:32:11'),
(55, 55, 4, 267, 285, '2023-09-05 15:43:58'),
(56, 56, 12, 252, 360, '2023-09-05 15:45:00'),
(57, 57, 6, 325, 340, '2023-09-05 15:47:32'),
(59, 59, 12, 310, 335, '2023-09-05 15:49:39'),
(61, 61, 12, 141, 150, '2023-09-05 15:57:28'),
(62, 62, 5, 141, 150, '2023-09-05 15:58:14'),
(63, 63, 7, 141, 150, '2023-09-05 15:58:39'),
(64, 64, 15, 134, 145, '2023-09-05 16:02:32'),
(65, 65, 9, 134, 145, '2023-09-05 16:03:14'),
(66, 66, 36, 121, 130, '2023-09-05 16:04:32'),
(67, 67, 4, 277, 300, '2023-09-05 16:07:05'),
(68, 68, 8, 277, 300, '2023-09-05 16:07:31'),
(69, 69, 36, 122, 150, '2023-09-05 16:13:13'),
(70, 70, 12, 122, 150, '2023-09-05 16:15:18'),
(71, 71, 24, 122, 150, '2023-09-05 16:16:18'),
(72, 72, 400, 10.5, 19.75, '2023-09-05 16:19:53'),
(73, 73, 720, 15.2083, 20, '2023-09-05 16:24:35'),
(74, 74, 10, 1550, 1650, '2023-09-05 16:27:23'),
(75, 75, 3, 1045, 1100, '2023-09-05 16:28:28'),
(76, 76, 40, 150, 300, '2023-09-05 16:31:09'),
(77, 77, 240, 22, 25, '2023-09-05 16:35:06'),
(78, 78, 24, 300, 335, '2023-09-05 16:35:46'),
(79, 79, 360, 18.55, 20, '2023-09-05 16:37:01'),
(80, 80, 18, 399, 430, '2023-09-05 16:38:16'),
(81, 81, 100, 112, 120, '2023-09-05 16:39:00'),
(82, 82, 100, 110, 120, '2023-09-05 16:40:42'),
(83, 83, 120, 27, 30, '2023-09-05 16:44:36');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `subtotal` double NOT NULL,
  `discount` double NOT NULL,
  `total` double NOT NULL,
  `payment_type` tinytext NOT NULL,
  `due` double NOT NULL,
  `paid` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `pid` int(11) NOT NULL,
  `barcode` varchar(1000) NOT NULL,
  `product` varchar(200) NOT NULL,
  `catid` int(11) NOT NULL,
  `description` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`pid`, `barcode`, `product`, `catid`, `description`) VALUES
(22, '4791111100302', 'Baby Cheramy 70g', 25, 'Baby Cheramy 70g'),
(23, '4792081026425', 'Pears Chooty Pack 70g', 25, 'Pears Chooty Pack 70g'),
(24, '4792054016736', 'Rathmal Baby Soap 60g', 26, 'Rathmal Baby Soap 60g'),
(25, '4792068132231', 'Rani Soap 90g', 26, 'Rani Soap 90g'),
(26, '4791111153186', 'Velvet Cutie 70g', 26, 'Velvet Cutie 70g'),
(27, '4792081031580', 'Lux Soap 70g', 26, 'Lux Soap 70g'),
(28, '4792068131135', 'Khomba Soap 90g', 26, 'Khomba Soap 90g'),
(29, '4796000523620', 'Calin Red 80g', 25, 'Calin Red 80g'),
(30, '4796000523774', 'Calin Khomba 80g', 25, 'Calin Khomba 80g'),
(31, '4796000523590', 'Calin Rose 80g', 25, 'Calin Rose 80g'),
(32, '4796000523583', 'Calin White 80g', 25, 'Calin White 80g'),
(33, '4796000523613', 'Calin Sandalwood 80g', 25, 'Calin Sandalwood 80g'),
(34, '4792081025978', 'Lifebuoy 100g', 25, 'Lifebuoy 100g'),
(35, '4792081023509', 'Sunlight 3 Pack (110g)', 25, 'Sunlight 3 Pack (110g)'),
(36, '4792081023493', 'Sunlight 110g', 25, 'Sunlight 110g'),
(37, '4796005650550', 'Vim 100g', 25, 'Vim 100g'),
(38, '4796005657412', 'Vim 3 Pack 100g', 25, 'Vim 3 Pack 100g'),
(39, '4796005676956', 'Vim Podda 50g', 25, 'Vim Podda 50g'),
(40, '4792081029327', 'Signal 70g', 25, 'Signal 70g'),
(41, '4796005678592', 'Signal + Brush Pack', 25, 'Signal + Brush Pack'),
(42, '4791111102030', 'Clogard Tooth Paste 120g', 25, 'Clogard Tooth Paste 120g'),
(43, '4791111102054', 'Clogard Tooth Paste 160g', 25, 'Clogard Tooth Paste 160g'),
(44, '4792022090249', 'Sudantha Tooth Paste 120g', 25, 'Sudantha Tooth Paste 120g'),
(45, '4792125311234', 'Vendol T&G 80g', 25, 'Vendol T&G 80g'),
(46, '4791111102016', 'Clogard Tooth Paste 40g', 25, 'Clogard Tooth Paste 40g'),
(47, '4791111102023', 'Clogard Tooth Paste 70g', 25, 'Clogard Tooth Paste 70g'),
(48, '4792172005643', 'Supirivicky Tooth Paste 110g', 25, 'Supirivicky Tooth Paste 110g'),
(49, '4792149602004', 'Ravan Black Hair', 25, 'Ravan Black Hair Colour Liquid'),
(50, '4796022661980', 'Abha Black Henna Lq', 25, 'Abha Black Henna Lq'),
(51, '4792081023578', 'Wonderlight Soap 110g', 25, 'Wonderlight Soap 110g'),
(52, '4792037107703', 'Harpic 200ml', 25, 'Harpic 200ml'),
(53, '4792037107741', 'Harpic 500ml', 25, 'Harpic 500ml'),
(54, '4792099010898', 'IODEX HeadFast 9g', 25, 'IODEX HeadFast 9g'),
(55, '4796005660030', 'Vim Dish Wash 250ml', 25, 'Vim Dish Wash 250ml'),
(56, '4796019200024', 'Supirisidu Tile Cleaner 500ml', 25, 'Supirisidu Tile Cleaner 500ml'),
(57, '4791111107028', 'Dandex Shampoo 80ml', 24, 'Dandex Shampoo 80ml'),
(59, '4792081032181', 'Sunsilk Shampoo 80ml', 24, 'Sunsilk Shampoo 80ml'),
(61, '4791111144092', 'Dandex Shampoo VE 40ml', 24, 'Dandex Shampoo VE 40ml'),
(62, '4791111144085', 'Dandex Shampoo KA 40ml', 24, 'Dandex Shampoo KA 40ml'),
(63, '4791111144078', 'Dandex Shampoo CA 40ml', 24, 'Dandex Shampoo CA 40ml'),
(64, '4792081029365', 'Sunsilk Shampoo Y 40ml', 24, 'Sunsilk Shampoo Y 40ml'),
(65, '4792081031993', 'Sunsilk Shampoo O 40ml', 24, 'Sunsilk Shampoo O 40ml'),
(66, '4792081029624', 'Lifebuoy Shampoo 40ml', 24, 'Lifebuoy Shampoo 40ml'),
(67, '4792081032655', 'Lifebuoy Shampoo B 80ml', 24, 'Lifebuoy Shampoo B 80ml'),
(68, '4792081032204', 'Lifebuoy Shampoo P 80ml', 24, 'Lifebuoy Shampoo P 80ml'),
(69, '4791010003322', 'Amritha Sticks Jasmine 25g', 24, 'Amritha Sticks Jasmine 25g'),
(70, '4791010003209', 'Amritha Sticks Green 25g', 24, 'Amritha Sticks Green 25g'),
(71, '4791010007504', 'Amritha Sticks Floral 25g', 24, 'Amritha Sticks Floral 25g'),
(72, '72041953', 'Candles Monara', 26, 'Candles Monara'),
(73, '4797001016609', 'Soorya Match Box', 25, 'Soorya Match Box'),
(74, '4792037130923', 'Mortein Spray 600ml', 25, 'Mortein Spray 600ml'),
(75, '4792037130688', 'Mortein Spray 250ml', 25, 'Mortein Spray 250ml'),
(76, '76043109', 'Orchid Paper Serviettes', 25, 'Orchid Paper Serviettes'),
(77, '4791111180137', 'Diva Washing Powder 45g', 25, 'Diva Washing Powder 45g'),
(78, '4791111180465', 'Diva Washing Powder 700g', 25, 'Diva Washing Powder 700g'),
(79, '4796005678479', 'Rin Washing Powder 40g', 25, 'Rin Washing Powder 40g'),
(80, '4796005669804', 'Sunlight Washing Powder 1kg', 25, 'Sunlight Washing Powder 1kg'),
(81, '4796005669835', 'Sunlight Washing Powder 200g', 25, 'Sunlight Washing Powder 200g'),
(82, '4791111180014', 'Diva Washing Powder 200g', 25, 'Diva Washing Powder 200g'),
(83, '4796000523415', 'Calin Washing Powder 50g', 25, 'Calin Washing Powder 50g');

-- --------------------------------------------------------

--
-- Table structure for table `product_stock`
--

CREATE TABLE `product_stock` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `purchaseprice` float NOT NULL,
  `saleprice` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_stock`
--

INSERT INTO `product_stock` (`id`, `pid`, `stock`, `purchaseprice`, `saleprice`) VALUES
(22, 22, 150, 126, 145),
(23, 23, 144, 136, 145),
(24, 24, 180, 100, 130),
(25, 25, 144, 140, 160),
(26, 26, 90, 116, 130),
(27, 27, 180, 118, 125),
(28, 28, 144, 140, 160),
(29, 29, 144, 105, 125),
(30, 30, 144, 105, 125),
(31, 31, 144, 105, 125),
(32, 32, 144, 105, 125),
(33, 33, 144, 105, 125),
(34, 34, 147, 149.66, 160),
(35, 35, 36, 395, 420),
(36, 36, 120, 142.17, 150),
(37, 37, 144, 65, 70),
(38, 38, 48, 169, 180),
(39, 39, 288, 37.45, 40),
(40, 40, 48, 174, 185),
(41, 41, 32, 328, 350),
(42, 42, 18, 215, 250),
(43, 43, 12, 262, 310),
(44, 44, 20, 255, 300),
(45, 45, 72, 112, 140),
(46, 46, 60, 114, 125),
(47, 47, 60, 183, 200),
(48, 48, 24, 245, 275),
(49, 49, 30, 200, 260),
(50, 50, 24, 186.5, 230),
(51, 51, 120, 109, 120),
(52, 52, 48, 223, 265),
(53, 53, 24, 403, 480),
(54, 54, 17, 130, 140),
(55, 55, 4, 267, 285),
(56, 56, 12, 252, 360),
(57, 57, 6, 325, 340),
(59, 59, 12, 310, 335),
(61, 61, 12, 141, 150),
(62, 62, 5, 141, 150),
(63, 63, 7, 141, 150),
(64, 64, 15, 134, 145),
(65, 65, 9, 134, 145),
(66, 66, 36, 121, 130),
(67, 67, 4, 277, 300),
(68, 68, 8, 277, 300),
(69, 69, 36, 122, 150),
(70, 70, 12, 122, 150),
(71, 71, 24, 122, 150),
(72, 72, 400, 10.5, 19.75),
(73, 73, 720, 15.2083, 20),
(74, 74, 10, 1550, 1650),
(75, 75, 3, 1045, 1100),
(76, 76, 40, 150, 300),
(77, 77, 240, 22, 25),
(78, 78, 24, 300, 335),
(79, 79, 360, 18.55, 20),
(80, 80, 18, 399, 430),
(81, 81, 100, 112, 120),
(82, 82, 100, 110, 120),
(83, 83, 120, 27, 30);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `useremail` varchar(200) NOT NULL,
  `userpassword` varchar(200) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `username`, `useremail`, `userpassword`, `role`) VALUES
(1, 'Sachintha', 'sachi.lifef@gmail.com', 'Sachintha123', 'Admin'),
(2, 'Lahiru', 'lahirurangebandata7070@gmail.com', 'Lahiru3350', 'Admin'),
(14, 'user', 'salasuper@gmail.com', 'Sala123', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`catid`);

--
-- Indexes for table `incoming_stock`
--
ALTER TABLE `incoming_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `product_stock`
--
ALTER TABLE `product_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `catid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `incoming_stock`
--
ALTER TABLE `incoming_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `product_stock`
--
ALTER TABLE `product_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
