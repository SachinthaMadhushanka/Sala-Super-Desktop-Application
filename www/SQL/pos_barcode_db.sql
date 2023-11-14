-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2023 at 11:11 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sala_super_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE `Category`
(
  `catid`    int(11) NOT NULL,
  `category` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`catid`, `category`)
VALUES (1, 'Soap'),
       (2, 'Mobile'),
       (3, 'Watches'),
       (4, 'Health Care'),
       (9, 'Grocery'),
       (10, 'Fashion'),
       (11, 'Electronics'),
       (12, 'Baby & Kids'),
       (13, 'Beverages'),
       (14, 'Cosmetics'),
       (15, 'Hardware'),
       (16, 'Laptop'),
       (17, 'Veg'),
       (18, 'Non Veg'),
       (19, 'Books'),
       (20, 'Vegetables'),
       (21, 'Spices'),
       (22, 'Body Lotions'),
       (23, 'Medicines');

-- --------------------------------------------------------

--
-- Table structure for table `Invoice`
--

CREATE TABLE `Invoice`
(
  `invoice_id`   int(11) NOT NULL,
  `date_time`    datetime NOT NULL,
  `subtotal`     double   NOT NULL,
  `discount`     double   NOT NULL,
  `total`        double   NOT NULL,
  `payment_type` tinytext NOT NULL,
  `due`          double   NOT NULL,
  `paid`         double   NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Invoice`
--
INSERT INTO `Invoice` (`invoice_id`, `date_time`, `subtotal`, `discount`, `total`, `payment_type`, `due`, `paid`)
VALUES (2, '2023-02-21 10:00:00', 425, 2, 437.75, 'Card', -62.25, 500),
       (3, '2023-03-05 10:00:00', 0, 2, 0, 'Cash', 0, 0),
       (4, '2023-02-21 10:00:00', 1045, 2, 1076.35, 'Check', 23.65, 1100),
       (5, '2023-03-01 10:00:00', 185, 2, 190.55, 'Cash', -9.45, 200),
       (6, '2023-03-02 10:00:00', 1220, 2, 1256.6, 'Card', 0, 1256.6),
       (7, '2023-03-02 10:00:00', 22550, 2, 23226.5, 'Check', 0, 23226.5),
       (8, '2023-03-02 10:00:00', 1000, 2, 1030, 'Card', 0, 1030),
       (9, '2023-03-02 10:00:00', 22300, 2, 22969, 'Check', 0, 22969),
       (10, '2023-03-02 10:00:00', 680, 2, 700.4, 'Cash', -9.6, 710),
       (11, '2023-03-02 10:00:00', 200, 2, 206, 'Cash', -14, 220),
       (12, '2023-03-02 10:00:00', 25, 2, 25.75, 'Cash', -4.25, 30),
       (13, '2023-03-02 10:00:00', 800, 2, 824, 'Cash', -76, 900),
       (14, '2023-03-02 10:00:00', 50, 2, 51.5, 'Card', 0, 51.5),
       (15, '2023-03-02 10:00:00', 50, 2, 51.5, 'Check', 0, 51.5),
       (16, '2023-03-02 10:00:00', 190, 2, 195.7, 'Card', 0, 195.7),
       (17, '2023-03-04 10:00:00', 25, 2, 25.75, 'Cash', -4.25, 30),
       (18, '2023-03-04 10:00:00', 1200, 2, 1236, 'Card', 0, 1236),
       (19, '2023-03-04 10:00:00', 750, 2, 772.5, 'Check', 0, 772.5),
       (20, '2023-03-04 10:00:00', 340, 2, 350.2, 'Cash', 0, 350.2),
       (21, '2023-03-04 10:00:00', 400, 2, 412, 'Cash', 0, 412),
       (22, '2023-03-04 10:00:00', 21500, 2, 22145, 'Card', 0, 22145),
       (23, '2023-03-06 10:00:00', 2920, 2, 3007.6, 'Cash', -92.4, 3100),
       (24, '2023-03-06 10:00:00', 225, 2, 231.75, 'Check', 0, 231.75),
       (26, '2023-03-07 10:00:00', 25, 2, 25.75, 'Cash', -4.25, 30),
       (27, '2023-03-07 10:00:00', 200, 2, 206, 'Card', 0, 206),
       (36, '2023-03-08 10:00:00', 1845, 2, 1900.35, 'Card', 0, 1900.35),
       (37, '2023-03-08 10:00:00', 840, 2, 865.2, 'Check', 0, 865.2),
       (38, '2023-03-08 10:00:00', 22550, 2, 23226.5, 'Cash', -1773.5, 25000),
       (39, '2023-03-09 10:00:00', 1050, 2, 1081.5, 'Cash', -18.5, 1100),
       (40, '2023-03-09 10:00:00', 750, 2, 772.5, 'Cash', 27.5, 800),
       (41, '2023-03-14 10:00:00', 750, 2, 772.5, 'Cash', -27.5, 800),
       (42, '2023-03-14 10:00:00', 200, 2, 206, 'Card', 0, 206),
       (43, '2023-03-17 10:00:00', 765, 2, 787.95, 'Cash', 787.95, 0),
       (44, '2023-03-17 10:00:00', 1400, 2, 1442, 'Cash', 58, 1500);


-- --------------------------------------------------------

--
-- Table structure for table `Invoice_Details`
--

CREATE TABLE `Invoice_Details`
(
  `id`         int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `stock_id`   int(11) NOT NULL,
  `qty`        int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Invoice_Details`
--

INSERT INTO `Invoice_Details` (`id`, `invoice_id`, `stock_id`, `qty`)
VALUES (15, 6, 6, 1),
       (16, 6, 8, 5),
       (17, 6, 3, 2),
       (18, 7, 2, 1),
       (19, 7, 1, 1),
       (20, 7, 4, 1),
       (21, 7, 11, 1),
       (22, 8, 7, 10),
       (23, 8, 10, 1),
       (24, 8, 9, 1),
       (25, 9, 11, 1),
       (26, 9, 4, 1),
       (27, 10, 12, 1),
       (28, 10, 3, 1),
       (29, 10, 6, 1),
       (30, 10, 5, 1),
       (31, 11, 2, 1),
       (32, 12, 7, 1),
       (33, 13, 4, 1),
       (34, 14, 1, 1),
       (35, 15, 1, 1),
       (36, 16, 7, 2),
       (37, 16, 8, 1),
       (38, 17, 7, 1),
       (39, 18, 3, 1),
       (40, 18, 4, 1),
       (41, 18, 12, 1),
       (42, 19, 10, 1),
       (43, 19, 9, 1),
       (44, 20, 6, 1),
       (45, 20, 8, 1),
       (46, 21, 3, 1),
       (47, 21, 12, 1),
       (48, 22, 11, 1),
       (87, 2, 7, 1),
       (88, 2, 2, 2),
       (94, 5, 7, 1),
       (95, 5, 3, 1),
       (96, 4, 8, 1),
       (97, 4, 7, 1),
       (98, 4, 5, 1),
       (99, 4, 4, 1),
       (100, 23, 3, 2),
       (101, 23, 1, 2),
       (102, 23, 10, 5),
       (103, 24, 7, 1),
       (104, 24, 6, 1),
       (115, 26, 7, 1),
       (116, 27, 2, 1),
       (162, 36, 7, 1),
       (163, 36, 2, 1),
       (164, 36, 1, 1),
       (165, 36, 3, 1),
       (166, 36, 10, 1),
       (167, 36, 5, 1),
       (168, 36, 6, 1),
       (169, 36, 8, 1),
       (170, 36, 9, 1),
       (171, 36, 12, 1),
       (172, 37, 6, 1),
       (173, 37, 10, 1),
       (174, 37, 8, 1),
       (175, 38, 4, 1),
       (176, 38, 9, 1),
       (177, 38, 11, 1),
       (178, 39, 3, 1),
       (179, 39, 1, 1),
       (180, 39, 8, 1),
       (181, 39, 10, 1),
       (182, 39, 6, 1),
       (184, 40, 10, 1),
       (185, 40, 9, 1),
       (186, 41, 1, 5),
       (187, 41, 10, 1),
       (189, 42, 2, 1),
       (190, 43, 1, 3),
       (191, 43, 2, 1),
       (192, 43, 8, 1),
       (193, 43, 7, 1),
       (194, 43, 9, 1),
       (200, 44, 2, 3),
       (201, 44, 3, 1),
       (202, 44, 8, 1),
       (203, 44, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Product`
--

CREATE TABLE `Product`
(
  `pid`         int(11) NOT NULL,
  `barcode`     varchar(1000) NOT NULL,
  `product`     varchar(200)  NOT NULL,
  `catid`       int(11) NOT NULL,
  `description` varchar(200)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Product`
--

INSERT INTO `Product` (`pid`, `barcode`, `product`, `catid`, `description`)
VALUES (1, '8901057510028', 'Kangaro Stapler Pins', 15, 'no 10 mm'),
       (2, '8901057310062', 'Kangaro Stapler', 15, 'no 10'),
       (3, '8901030865237', 'kissan tomato katchup', 9, 'just cetchup'),
       (4, '7121434', 'lenovo charger', 16, '12v'),
       (5, '5120819', 'Veg Burger', 17, 'small p'),
       (6, '6121422', 'Suger Packet 5 KG', 9, '5 KG Suger Packet '),
       (7, '8904000952210', 'Dyna Soap', 1, 'Dyna Premium Beauty Sandal and Saffron Soap'),
       (8, '8901030843891', 'Pepsodent Toothpaste', 9, 'Pepsodent GERMI CHECK JUMBO\r\nADVANCED GERMI CHECK FORMULA  '),
       (9, '8809461562230', 'Modelling Comb', 11, 'Modelling Comb Electronic Comb for men .'),
       (10, '8906105612730', 'Wow Omega 3 Capsules', 23, 'Wow Omega 3 60N softgel Capsules  '),
       (11, '6971914086630', 'Real me XT', 2, 'Model : RMX1921'),
       (12, '12114804', 'Mix Spices 500gm', 9, 'Mix Spices Pack 500gm');

-- --------------------------------------------------------


--
-- Table structure for table `Product_Stock`
--

CREATE TABLE `Product_Stock`
(
  `id`            int(11) NOT NULL,
  `pid`           int(11) NOT NULL,
  `stock`         int(11) NOT NULL,
  `purchaseprice` float NOT NULL,
  `saleprice`     float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Product_Stock`
--

INSERT INTO `Product_Stock` (`id`, `pid`, `stock`, `purchaseprice`, `saleprice`)
VALUES (1, 1, 474, 30, 50),
       (2, 2, 189, 150, 200),
       (3, 3, 166, 110, 160),
       (4, 4, 94, 450, 800),
       (5, 5, 997, 50, 80),
       (6, 6, 493, 120, 200),
       (7, 7, 975, 15, 25),
       (8, 8, 334, 80, 140),
       (9, 9, 114, 130, 250),
       (10, 10, 107, 380, 500),
       (11, 11, 145, 18000, 21500),
       (12, 12, 296, 180, 240);

-- -------------------------------------------


--
-- Table structure for table `Incoming_Stock`
--

CREATE TABLE `Incoming_Stock`
(
  `id`            int(11) NOT NULL,
  `pid`           int(11) NOT NULL,
  `stock`         int(11) NOT NULL,
  `purchaseprice` float    NOT NULL,
  `saleprice`     float    NOT NULL,
  `date_time`     datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Incoming_Stock`
--

INSERT INTO `Incoming_Stock` (`id`, `pid`, `stock`, `purchaseprice`, `saleprice`, date_time)
VALUES (1, 1, 474, 30, 50, '2023-01-01 10:00:00'),
       (2, 2, 189, 150, 200, '2023-01-02 11:00:00'),
       (3, 3, 166, 110, 160, '2023-01-03 12:00:00'),
       (4, 4, 94, 450, 800, '2023-01-04 13:00:00'),
       (5, 5, 997, 50, 80, '2023-01-05 14:00:00'),
       (6, 6, 493, 120, 200, '2023-01-06 15:00:00'),
       (7, 7, 975, 15, 25, '2023-01-07 16:00:00'),
       (8, 8, 334, 80, 140, '2023-01-08 17:00:00'),
       (9, 9, 114, 130, 250, '2023-01-09 18:00:00'),
       (10, 10, 107, 380, 500, '2023-01-10 19:00:00'),
       (11, 11, 145, 18000, 21500, '2023-01-11 20:00:00'),
       (12, 12, 296, 180, 240, '2023-01-12 21:00:00');


-- -------------------------------------------


--
-- Table structure for table `User`
--

CREATE TABLE `User`
(
  `userid`       int(11) NOT NULL,
  `username`     varchar(200) NOT NULL,
  `useremail`    varchar(200) NOT NULL,
  `userpassword` varchar(200) NOT NULL,
  `role`         varchar(50)  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`userid`, `username`, `useremail`, `userpassword`, `role`)
VALUES (1, 'Sachintha', 'sachi.lifef@gmail.com', 'Sachintha4107', 'Admin'),
       (2, 'Lahiru', 'lahirurangebandata7070@gmail.com', 'Lahiru3350', 'Admin'),
       (14, 'Staff', 'salasuper@gmail.com', 'Sala12345', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`catid`);

--
-- Indexes for table `Invoice`
--
ALTER TABLE `Invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `Invoice_Details`
--
ALTER TABLE `Invoice_Details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Product`
--
ALTER TABLE `Product`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `Product_Stock`
--
ALTER TABLE `Product_Stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Incoming_Stock`
--
ALTER TABLE `Incoming_Stock`
  ADD PRIMARY KEY (`id`);


--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Category`
--
ALTER TABLE `Category`
  MODIFY `catid` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `Invoice`
--
ALTER TABLE `Invoice`
  MODIFY `invoice_id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `Invoice_Details`
--
ALTER TABLE `Invoice_Details`
  MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT for table `Product`
--
ALTER TABLE `Product`
  MODIFY `pid` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `Product_Stock`
--
ALTER TABLE `Product_Stock`
  MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `Incoming_Stock`
--
ALTER TABLE `Incoming_Stock`
  MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `userid` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
