-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: sala_super_db
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `catid` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(200) NOT NULL,
  PRIMARY KEY (`catid`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (24,'Cosmetic'),(25,'Grocery'),(26,'Stationary');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incoming_stock`
--

DROP TABLE IF EXISTS `incoming_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incoming_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `purchaseprice` float NOT NULL,
  `saleprice` float NOT NULL,
  `date_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incoming_stock`
--

LOCK TABLES `incoming_stock` WRITE;
/*!40000 ALTER TABLE `incoming_stock` DISABLE KEYS */;
INSERT INTO `incoming_stock` VALUES (22,22,150,126,145,'2023-09-05 14:32:20'),(23,23,144,136,145,'2023-09-05 14:35:24'),(24,24,180,100,130,'2023-09-05 14:37:59'),(25,25,144,140,160,'2023-09-05 14:39:37'),(26,26,90,116,130,'2023-09-05 14:40:48'),(27,27,180,118,125,'2023-09-05 14:41:32'),(28,28,144,140,160,'2023-09-05 14:42:55'),(29,29,144,105,125,'2023-09-05 14:45:47'),(30,30,144,105,125,'2023-09-05 14:46:55'),(31,31,144,105,125,'2023-09-05 14:47:35'),(32,32,144,105,125,'2023-09-05 14:49:55'),(33,33,144,105,125,'2023-09-05 14:50:45'),(34,34,147,149.66,160,'2023-09-05 14:52:27'),(35,35,36,395,420,'2023-09-05 14:55:57'),(36,36,120,142.17,150,'2023-09-05 14:57:06'),(37,37,144,65,70,'2023-09-05 14:58:32'),(38,38,48,169,180,'2023-09-05 14:59:46'),(39,39,288,37.45,40,'2023-09-05 15:00:39'),(40,40,48,174,185,'2023-09-05 15:02:26'),(41,41,32,328,350,'2023-09-05 15:06:28'),(42,42,18,215,250,'2023-09-05 15:08:56'),(43,43,12,262,310,'2023-09-05 15:09:45'),(44,44,20,255,300,'2023-09-05 15:14:08'),(45,45,72,112,140,'2023-09-05 15:15:34'),(46,46,60,114,125,'2023-09-05 15:17:19'),(47,47,60,183,200,'2023-09-05 15:18:15'),(48,48,24,245,275,'2023-09-05 15:22:31'),(49,49,30,200,260,'2023-09-05 15:25:08'),(50,50,24,186.5,230,'2023-09-05 15:26:37'),(51,51,120,109,120,'2023-09-05 15:28:02'),(52,52,48,223,265,'2023-09-05 15:29:08'),(53,53,24,403,480,'2023-09-05 15:29:49'),(54,54,17,130,140,'2023-09-05 15:32:11'),(55,55,4,267,285,'2023-09-05 15:43:58'),(56,56,12,252,360,'2023-09-05 15:45:00'),(57,57,6,325,340,'2023-09-05 15:47:32'),(59,59,12,310,335,'2023-09-05 15:49:39'),(61,61,12,141,150,'2023-09-05 15:57:28'),(62,62,5,141,150,'2023-09-05 15:58:14'),(63,63,7,141,150,'2023-09-05 15:58:39'),(64,64,15,134,145,'2023-09-05 16:02:32'),(65,65,9,134,145,'2023-09-05 16:03:14'),(66,66,36,121,130,'2023-09-05 16:04:32'),(67,67,4,277,300,'2023-09-05 16:07:05'),(68,68,8,277,300,'2023-09-05 16:07:31'),(69,69,36,122,150,'2023-09-05 16:13:13'),(70,70,12,122,150,'2023-09-05 16:15:18'),(71,71,24,122,150,'2023-09-05 16:16:18'),(72,72,400,10.5,19.75,'2023-09-05 16:19:53'),(73,73,720,15.2083,20,'2023-09-05 16:24:35'),(74,74,10,1550,1650,'2023-09-05 16:27:23'),(75,75,3,1045,1100,'2023-09-05 16:28:28'),(76,76,40,150,300,'2023-09-05 16:31:09'),(77,77,240,22,25,'2023-09-05 16:35:06'),(78,78,24,300,335,'2023-09-05 16:35:46'),(79,79,360,18.55,20,'2023-09-05 16:37:01'),(80,80,18,399,430,'2023-09-05 16:38:16'),(81,81,100,112,120,'2023-09-05 16:39:00'),(82,82,100,110,120,'2023-09-05 16:40:42'),(83,83,120,27,30,'2023-09-05 16:44:36'),(84,84,18,430,440,'2023-09-05 17:21:03'),(85,85,36,206,220,'2023-09-05 17:33:57'),(86,86,50,205,220,'2023-09-05 17:34:45'),(87,87,12,854,880,'2023-09-05 17:37:55'),(88,88,72,83,90,'2023-09-05 17:39:44'),(89,89,50,128,160,'2023-09-05 17:41:49'),(90,90,50,88,110,'2023-09-05 17:44:27'),(91,91,50,104,130,'2023-09-05 17:45:33'),(92,92,50,144,180,'2023-09-05 17:50:56'),(93,93,50,136,170,'2023-09-05 17:52:16'),(94,94,72,136,140,'2023-09-05 17:58:02'),(95,95,80,28.5,30,'2023-09-05 17:59:45'),(96,96,12,750,790,'2023-09-05 18:10:21'),(97,97,39,460,490,'2023-09-05 18:13:10'),(98,98,40,785,830,'2023-09-05 18:15:45'),(99,99,48,530.75,550,'2023-09-05 18:19:15'),(100,100,40,595,620,'2023-09-05 18:23:19'),(101,101,36,1042.2,1080,'2023-09-05 18:25:40'),(102,102,36,1042.2,1080,'2023-09-05 18:26:28'),(103,103,12,1300,1350,'2023-09-05 18:30:46'),(104,104,50,200,220,'2023-09-05 18:53:15'),(105,105,450,66,70,'2023-09-05 18:56:56'),(106,106,80,115,130,'2023-09-05 19:02:45'),(107,107,450,57.9,60,'2023-09-05 19:09:45'),(108,108,48,355,410,'2023-09-05 19:14:17'),(109,109,18,250,525,'2023-09-05 19:24:35'),(110,110,12,1208,1250,'2023-09-05 19:31:46'),(111,111,10,270,300,'2023-09-05 19:37:04'),(112,112,72,380,625,'2023-09-05 19:40:02'),(113,113,1440,3.333,4.166,'2023-09-05 19:47:22'),(114,114,15,350,370,'2023-09-05 19:59:18'),(115,115,15,190,230,'2023-09-05 20:02:32'),(116,116,36,82,85,'2023-09-05 20:07:20'),(117,117,60,33,35,'2023-09-05 20:10:28'),(118,118,20,575,620,'2023-09-05 20:26:23'),(119,119,50,115,130,'2023-09-05 20:33:31'),(120,120,12,219,250,'2023-09-05 20:39:34'),(121,121,112,47.143,50,'2023-09-05 20:46:44'),(122,122,20,175,400,'2023-09-05 20:53:50'),(123,123,36,85,200,'2023-09-05 20:59:33'),(124,124,120,114,130,'2023-09-05 21:03:22'),(125,125,120,103,125,'2023-09-05 21:28:05'),(126,126,120,89,100,'2023-09-05 21:29:05'),(127,127,120,120,150,'2023-09-05 21:32:41'),(128,128,60,281.82,310,'2023-09-05 21:36:27'),(129,129,25,255,400,'2023-09-05 21:53:17'),(130,130,25,230,500,'2023-09-05 21:54:08'),(131,131,1,6250,10250,'2023-09-05 21:55:08'),(132,132,5,850,1650,'2023-09-05 22:09:25'),(133,133,5,850,1650,'2023-09-05 22:10:53'),(134,134,20,82.5,125,'2023-09-05 22:18:47'),(135,135,10,165,250,'2023-09-05 22:19:41'),(136,136,1000,0.95,2,'2023-09-05 22:57:18'),(137,137,25,950,1100,'2023-09-06 00:25:00'),(138,138,15,1900,2200,'2023-09-06 00:25:52'),(139,139,15,925,1050,'2023-09-06 00:28:55'),(140,140,10,1850,2100,'2023-09-06 00:32:41'),(141,141,10,1075,1150,'2023-09-06 00:34:52'),(142,142,5,220,350,'2023-09-06 00:39:06'),(143,143,2,292,700,'2023-09-06 00:42:34'),(144,144,2,220,500,'2023-09-06 00:43:44');
/*!40000 ALTER TABLE `incoming_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` datetime NOT NULL,
  `subtotal` double NOT NULL,
  `discount` double NOT NULL,
  `total` double NOT NULL,
  `payment_type` tinytext NOT NULL,
  `due` double NOT NULL,
  `paid` double NOT NULL,
  PRIMARY KEY (`invoice_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice`
--

LOCK TABLES `invoice` WRITE;
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_details`
--

DROP TABLE IF EXISTS `invoice_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_details`
--

LOCK TABLES `invoice_details` WRITE;
/*!40000 ALTER TABLE `invoice_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `barcode` varchar(1000) NOT NULL,
  `product` varchar(200) NOT NULL,
  `catid` int(11) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (22,'4791111100302','Baby Cheramy 70g',25,'Baby Cheramy 70g'),(23,'4792081026425','Pears Chooty Pack 70g',25,'Pears Chooty Pack 70g'),(24,'4792054016736','Rathmal Baby Soap 60g',26,'Rathmal Baby Soap 60g'),(25,'4792068132231','Rani Soap 90g',26,'Rani Soap 90g'),(26,'4791111153186','Velvet Cutie 70g',26,'Velvet Cutie 70g'),(27,'4792081031580','Lux Soap 70g',26,'Lux Soap 70g'),(28,'4792068131135','Khomba Soap 90g',26,'Khomba Soap 90g'),(29,'4796000523620','Calin Red 80g',25,'Calin Red 80g'),(30,'4796000523774','Calin Khomba 80g',25,'Calin Khomba 80g'),(31,'4796000523590','Calin Rose 80g',25,'Calin Rose 80g'),(32,'4796000523583','Calin White 80g',25,'Calin White 80g'),(33,'4796000523613','Calin Sandalwood 80g',25,'Calin Sandalwood 80g'),(34,'4792081025978','Lifebuoy 100g',25,'Lifebuoy 100g'),(35,'4792081023509','Sunlight 3 Pack (110g)',25,'Sunlight 3 Pack (110g)'),(36,'4792081023493','Sunlight 110g',25,'Sunlight 110g'),(37,'4796005650550','Vim 100g',25,'Vim 100g'),(38,'4796005657412','Vim 3 Pack 100g',25,'Vim 3 Pack 100g'),(39,'4796005676956','Vim Podda 50g',25,'Vim Podda 50g'),(40,'4792081029327','Signal 70g',25,'Signal 70g'),(41,'4796005678592','Signal + Brush Pack',25,'Signal + Brush Pack'),(42,'4791111102030','Clogard Tooth Paste 120g',25,'Clogard Tooth Paste 120g'),(43,'4791111102054','Clogard Tooth Paste 160g',25,'Clogard Tooth Paste 160g'),(44,'4792022090249','Sudantha Tooth Paste 120g',25,'Sudantha Tooth Paste 120g'),(45,'4792125311234','Vendol T&G 80g',25,'Vendol T&G 80g'),(46,'4791111102016','Clogard Tooth Paste 40g',25,'Clogard Tooth Paste 40g'),(47,'4791111102023','Clogard Tooth Paste 70g',25,'Clogard Tooth Paste 70g'),(48,'4792172005643','Supirivicky Tooth Paste 110g',25,'Supirivicky Tooth Paste 110g'),(49,'4792149602004','Ravan Black Hair',25,'Ravan Black Hair Colour Liquid'),(50,'4796022661980','Abha Black Henna Lq',25,'Abha Black Henna Lq'),(51,'4792081023578','Wonderlight Soap 110g',25,'Wonderlight Soap 110g'),(52,'4792037107703','Harpic 200ml',25,'Harpic 200ml'),(53,'4792037107741','Harpic 500ml',25,'Harpic 500ml'),(54,'4792099010898','IODEX HeadFast 9g',25,'IODEX HeadFast 9g'),(55,'4796005660030','Vim Dish Wash 250ml',25,'Vim Dish Wash 250ml'),(56,'4796019200024','Supirisidu Tile Cleaner 500ml',25,'Supirisidu Tile Cleaner 500ml'),(57,'4791111107028','Dandex Shampoo 80ml',24,'Dandex Shampoo 80ml'),(59,'4792081032181','Sunsilk Shampoo 80ml',24,'Sunsilk Shampoo 80ml'),(61,'4791111144092','Dandex Shampoo VE 40ml',24,'Dandex Shampoo VE 40ml'),(62,'4791111144085','Dandex Shampoo KA 40ml',24,'Dandex Shampoo KA 40ml'),(63,'4791111144078','Dandex Shampoo CA 40ml',24,'Dandex Shampoo CA 40ml'),(64,'4792081029365','Sunsilk Shampoo Y 40ml',24,'Sunsilk Shampoo Y 40ml'),(65,'4792081031993','Sunsilk Shampoo O 40ml',24,'Sunsilk Shampoo O 40ml'),(66,'4792081029624','Lifebuoy Shampoo 40ml',24,'Lifebuoy Shampoo 40ml'),(67,'4792081032655','Lifebuoy Shampoo B 80ml',24,'Lifebuoy Shampoo B 80ml'),(68,'4792081032204','Lifebuoy Shampoo P 80ml',24,'Lifebuoy Shampoo P 80ml'),(69,'4791010003322','Amritha Sticks Jasmine 25g',24,'Amritha Sticks Jasmine 25g'),(70,'4791010003209','Amritha Sticks Green 25g',24,'Amritha Sticks Green 25g'),(71,'4791010007504','Amritha Sticks Floral 25g',24,'Amritha Sticks Floral 25g'),(72,'72041953','Candles Monara',26,'Candles Monara'),(73,'4797001016609','Soorya Match Box',25,'Soorya Match Box'),(74,'4792037130923','Mortein Spray 600ml',25,'Mortein Spray 600ml'),(75,'4792037130688','Mortein Spray 250ml',25,'Mortein Spray 250ml'),(76,'76043109','Orchid Paper Serviettes',25,'Orchid Paper Serviettes'),(77,'4791111180137','Diva Washing Powder 45g',25,'Diva Washing Powder 45g'),(78,'4791111180465','Diva Washing Powder 700g',25,'Diva Washing Powder 700g'),(79,'4796005678479','Rin Washing Powder 40g',25,'Rin Washing Powder 40g'),(80,'4796005669804','Sunlight Washing Powder 1kg',25,'Sunlight Washing Powder 1kg'),(81,'4796005669835','Sunlight Washing Powder 200g',25,'Sunlight Washing Powder 200g'),(82,'4791111180014','Diva Washing Powder 200g',25,'Diva Washing Powder 200g'),(83,'4796000523415','Calin Washing Powder 50g',25,'Calin Washing Powder 50g'),(84,'4791085292959','Raththi Kiri The 200g',25,'Raththi Kiri The 200g'),(85,'4796005674556','Rin Washing Powder 500g',25,'Rin Washing Powder 500g'),(86,'4796005669828','Sunlight Washing Powder 400g',25,'Sunlight Washing Powder 400g'),(87,'4791085292928','Raththi Kiri The 400g',25,'Raththi Kiri The 400g'),(88,'4792024015783','Maggi Tikiri 40g',25,'Maggi Tikiri 40g'),(89,'4792149027036','Raigam Soya Prawn 100g',25,'Raigam Soya Prawn 100g'),(90,'4792149014050','Raigam Soya Blue 50g',25,'Raigam Soya Blue 50g'),(91,'4792149027104','Raigam Soya Kiri Kos 60g',25,'Raigam Soya Kiri Kos 60g'),(92,'4792149011226','Raigam Soya Cuttle Fish 110g',25,'Raigam Soya Cuttle Fish 110g'),(93,'4792149010618','Raigam Soya Curry Rasa 90g',25,'Raigam Soya Curry Rasa 90g'),(94,'4792024015646','Maggi Noodles Chicken Flavor 73g',25,'Maggi Noodles Chicken Flavor 73g'),(95,'4792024013239','Maggi Rasamusu 6g',25,'Maggi Rasamusu 6g'),(96,'4791085292911','Raththi Red Cow 400g',25,'Raththi Red Cow 400g'),(97,'4792024016216','Nestomalt 175g',25,'Nestomalt 175g'),(98,'4792024016131','Nestomalt 400g',25,'Nestomalt 400g'),(99,'4791085292980','Raththi 200g',25,'Raththi 200g'),(100,'4792024018302','Nestomalt 300g',25,'Nestomalt 300g'),(101,'4791085011079','Anchor 400g',25,'Anchor 400g'),(102,'4791085081072','Raththi 400g',25,'Raththi 400g'),(103,'4791085171070','Anlene 400g',25,'Anlene 400g'),(104,'4797001036720','Suposha 250g',25,'Suposha 250g'),(105,'4792024016193','Nestomalt 28g',25,'Nestomalt 28g'),(106,'4792018233131','Prima Kottu Mee 80g',25,'Prima Kottu Mee 80g'),(107,'107070945','Nespray 18g',25,'Nespray 18g'),(108,'4792018233681','Prima Special 325g',25,'Prima Special 325g'),(109,'4796004100223','Star Gold Pasta 400g',25,'Star Gold Pasta 400g'),(110,'4792024000383','Maggi Seasoning Powder 500g',25,'Maggi Seasoning Powder 500g (Stock Powder)'),(111,'4797001015183','Rayin String Hopper Flour 1kg',25,'Rayin String Hopper Flour 1kg'),(112,'4793002131006','Ocean Jack Mackerel 425g',25,'Ocean Jack Mackerel 425g (Salmon)'),(113,'4792099010805','Panadol Tablet',25,'Panadol Tablet'),(114,'4792099010201','Panadol liquid 100ml',25,'Panadol liquid 100ml'),(115,'4792000014113','Morison Gripe Mixture 100ml',25,'Morison Gripe Mixture 100ml. Infant Carminative Syrup'),(116,'4796025380178','Astra 40g',25,'Astra 40g'),(117,'117081028','Astra Buddy 18g',25,'Astra Buddy 18g'),(118,'4797001036737','Suposha 750g',25,'Suposha 750g'),(119,'4792024011754','Milo 180ml',25,'Milo 180ml'),(120,'4791111143491','Cotton Buds BC 100 Pieces',25,'Baby Cheramy Cotton Buds 100 Pieces'),(121,'4796005673245','Know Chicken Cube 10g',25,'Know Chicken Cube 10g'),(122,'122085350','Umbalakada 100g Bottle',25,'Umbalakada (Maldive Fish) 100g Bottle'),(123,'123085933','Milk Shorties Biscuit 200g',25,'Milk Shorties Biscuit 200g + 20g'),(124,'4792081021116','Signal Fighter Brush',25,'Signal Fighter Brush'),(125,'4791010002066','Denta Comfort Tooth Brush',25,'Denta Comfort Tooth Brush'),(126,'4791111102603','Clogard Tooth Brush',25,'Clogard Tooth Brush'),(127,'8901358702443','Razor Gillette Blue II',25,'Razor Gillette Blue II'),(128,'8720608620463','Laojee 100g Packet',25,'Laojee 100g Packet'),(129,'129095317','Paththara',25,'Paththara'),(130,'130095408','Sudu Paththara',25,'Sudu Paththara'),(131,'131095508','China Paththara',25,'China Paththara'),(132,'132100925','Chili Powder 1Kg Lankan Choice',25,'Chili Powder 1Kg Lankan Choice (Miris Kudu)'),(133,'133101053','Chili Pieces Lankan Choice 1 Kg',25,'Chili Pieces Lankan Choice 1 Kg (Kaali Miris)'),(134,'134101847','Kurundu Pothu 25g (Cinnoman)',25,'Kurundu Pothu 25g (Cinnoman)'),(135,'135101941','Kurundu Pothu 50g (Cinnoman)',25,'Kurundu Pothu 50g (Cinnoman)'),(136,'136105718','Shopping Bag Small',25,'Shopping Bag Small'),(137,'137122500','Neth Nadu 5Kg',25,'Neth Nadu 5Kg'),(138,'138122552','Neth Nadu 10Kg',25,'Neth Nadu 10Kg'),(139,'139122855','Kakulu Hal 5Kg',25,'Kakulu Hal 5Kg'),(140,'140123241','Kakulu Hal 10Kg',25,'Kakulu Hal 10Kg'),(141,'141123452','Wasala Samba 5Kg',25,'Wasala Samba 5Kg'),(142,'142123906','Shopping Bag Large Pack',25,'Shopping Bag Large Pack'),(143,'143124234','Grocery Bag 7*10',25,'Grocery Shopping Bag 7*10'),(144,'144124344','Grocery Bag 5*7',25,'Grocery Shopping Bag 5*7');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_stock`
--

DROP TABLE IF EXISTS `product_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `purchaseprice` float NOT NULL,
  `saleprice` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_stock`
--

LOCK TABLES `product_stock` WRITE;
/*!40000 ALTER TABLE `product_stock` DISABLE KEYS */;
INSERT INTO `product_stock` VALUES (22,22,150,126,145),(23,23,144,136,145),(24,24,180,100,130),(25,25,144,140,160),(26,26,90,116,130),(27,27,180,118,125),(28,28,144,140,160),(29,29,144,105,125),(30,30,144,105,125),(31,31,144,105,125),(32,32,144,105,125),(33,33,144,105,125),(34,34,147,149.66,160),(35,35,36,395,420),(36,36,120,142.17,150),(37,37,144,65,70),(38,38,48,169,180),(39,39,288,37.45,40),(40,40,48,174,185),(41,41,32,328,350),(42,42,18,215,250),(43,43,12,262,310),(44,44,20,255,300),(45,45,72,112,140),(46,46,60,114,125),(47,47,60,183,200),(48,48,24,245,275),(49,49,30,200,260),(50,50,24,186.5,230),(51,51,120,109,120),(52,52,48,223,265),(53,53,24,403,480),(54,54,17,130,140),(55,55,4,267,285),(56,56,12,252,360),(57,57,6,325,340),(59,59,12,310,335),(61,61,12,141,150),(62,62,5,141,150),(63,63,7,141,150),(64,64,15,134,145),(65,65,9,134,145),(66,66,36,121,130),(67,67,4,277,300),(68,68,8,277,300),(69,69,36,122,150),(70,70,12,122,150),(71,71,24,122,150),(72,72,400,10.5,19.75),(73,73,720,15.2083,20),(74,74,10,1550,1650),(75,75,3,1045,1100),(76,76,40,150,300),(77,77,240,22,25),(78,78,24,300,335),(79,79,360,18.55,20),(80,80,18,399,430),(81,81,100,112,120),(82,82,100,110,120),(83,83,120,27,30),(84,84,18,430,440),(85,85,36,206,220),(86,86,50,205,220),(87,87,12,854,880),(88,88,72,83,90),(89,89,50,128,160),(90,90,50,88,110),(91,91,50,104,130),(92,92,50,144,180),(93,93,50,136,170),(94,94,72,136,140),(95,95,80,28.5,30),(96,96,12,750,790),(97,97,39,460,490),(98,98,40,785,830),(99,99,48,530.75,550),(100,100,40,595,620),(101,101,36,1042.2,1080),(102,102,36,1042.2,1080),(103,103,12,1300,1350),(104,104,50,200,220),(105,105,450,66,70),(106,106,80,115,130),(107,107,450,57.9,60),(108,108,48,355,410),(109,109,18,250,525),(110,110,12,1208,1250),(111,111,10,270,300),(112,112,72,380,625),(113,113,1440,3.333,4.166),(114,114,15,350,370),(115,115,15,190,230),(116,116,36,82,85),(117,117,60,33,35),(118,118,20,575,620),(119,119,50,115,130),(120,120,12,219,250),(121,121,112,47.143,50),(122,122,20,175,400),(123,123,36,85,200),(124,124,120,114,130),(125,125,120,103,125),(126,126,120,89,100),(127,127,120,120,150),(128,128,60,281.82,310),(129,129,25,255,400),(130,130,25,230,500),(131,131,1,6250,10250),(132,132,5,850,1650),(133,133,5,850,1650),(134,134,20,82.5,125),(135,135,10,165,250),(136,136,1000,0.95,2),(137,137,25,950,1100),(138,138,15,1900,2200),(139,139,15,925,1050),(140,140,10,1850,2100),(141,141,10,1075,1150),(142,142,5,220,350),(143,143,2,292,700),(144,144,2,220,500);
/*!40000 ALTER TABLE `product_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `useremail` varchar(200) NOT NULL,
  `userpassword` varchar(200) NOT NULL,
  `role` varchar(50) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Sachintha','sachi.lifef@gmail.com','Sachintha123','Admin'),(14,'user','salasuper@gmail.com','Sala123','User');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-10  1:16:45
