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
VALUES (1, 'Sachintha', 'sachi.lifef@gmail.com', 'Sachintha123', 'Admin'),
       (2, 'Lahiru', 'lahirurangebandata7070@gmail.com', 'Lahiru3350', 'Admin'),
       (14, 'user', 'salasuper@gmail.com', 'Sala123', 'User');

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
