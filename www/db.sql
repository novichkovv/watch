-- MySQL dump 10.13  Distrib 5.5.52, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: 
-- ------------------------------------------------------
-- Server version	5.5.52-0+deb8u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `watches_store`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `watches_store` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `watches_store`;

--
-- Table structure for table `order_address_relations`
--

DROP TABLE IF EXISTS `order_address_relations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_address_relations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `address_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_address_relations`
--

LOCK TABLES `order_address_relations` WRITE;
/*!40000 ALTER TABLE `order_address_relations` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_address_relations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_statuses`
--

DROP TABLE IF EXISTS `order_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_statuses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_statuses`
--

LOCK TABLES `order_statuses` WRITE;
/*!40000 ALTER TABLE `order_statuses` DISABLE KEYS */;
INSERT INTO `order_statuses` VALUES (1,'Получен'),(2,'Подтвержден'),(3,'Отказ'),(4,'Трэш');
/*!40000 ALTER TABLE `order_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `address_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `status_id` bigint(20) unsigned NOT NULL,
  `click_id` varchar(255) DEFAULT NULL,
  `my_name` varchar(255) DEFAULT NULL,
  `aff_order_id` varchar(255) DEFAULT NULL,
  `t_field` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `price_usd` decimal(10,2) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `pay_date` datetime DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_info` varchar(255) DEFAULT NULL,
  `referer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (48,39,0,2,3,'w7RH3AO6L302ATJ0H2436ER2','nik','2301773','',638.00,0.00,'2016-10-23 21:17:22','2016-10-27 04:19:09','','',''),(49,39,0,3,1,'w7RH3AO6L302ATJ0H2436ER2','nik','2301765','',0.00,NULL,'2016-10-23 21:18:03',NULL,'',NULL,NULL),(50,39,0,2,0,'w7RH3AO6L302ATJ0H2436ER2','nik',NULL,'',0.00,NULL,'2016-10-23 21:18:12',NULL,'',NULL,NULL),(51,39,0,2,0,'w7RH3AO6L302ATJ0H2436ER2','nik',NULL,'',0.00,NULL,'2016-10-23 21:18:29',NULL,'',NULL,NULL),(52,40,0,2,1,'w7RH3AO6L302ATJ0H2436ER2','nik','2301773','',0.00,NULL,'2016-10-23 21:20:02',NULL,'',NULL,NULL),(53,40,0,2,0,'w7RH3AO6L302ATJ0H2436ER2','nik',NULL,'',0.00,NULL,'2016-10-23 21:20:08',NULL,'',NULL,NULL),(54,40,0,2,0,'w7RH3AO6L302ATJ0H2436ER2','nik',NULL,'',0.00,NULL,'2016-10-23 21:20:13',NULL,'',NULL,NULL),(55,40,0,2,0,'w7RH3AO6L302ATJ0H2436ER2','nik',NULL,'',0.00,NULL,'2016-10-23 21:20:17',NULL,'',NULL,NULL),(56,40,0,2,0,'w7RH3AO6L302ATJ0H2436ER2','nik',NULL,'',0.00,NULL,'2016-10-23 21:20:22',NULL,'',NULL,NULL),(57,41,0,2,1,'w7RH3AO6L302ATJ0H2436ER2','nik','2301783','',0.00,NULL,'2016-10-23 21:22:47',NULL,'',NULL,NULL),(58,42,0,2,1,'w7RH3AO6L302ATJ0H2436ER2','nik','2301790','',0.00,NULL,'2016-10-23 21:24:50',NULL,'',NULL,NULL),(59,43,0,2,1,'w7RH3AO6L302ATJ0H2436ER2','nik','2301793','',0.00,NULL,'2016-10-23 21:26:08',NULL,'',NULL,NULL),(60,43,0,3,1,'w7RH3AO6L302ATJ0H2436ER2','nik','2301794','',0.00,NULL,'2016-10-23 21:26:31',NULL,'',NULL,NULL),(61,43,0,2,0,'w7RH3AO6L302ATJ0H2436ER2','nik',NULL,'',0.00,NULL,'2016-10-23 21:26:37',NULL,'',NULL,NULL),(62,43,0,2,0,'w7RH3AO6L302ATJ0H2436ER2','nik',NULL,'',0.00,NULL,'2016-10-23 21:26:42',NULL,'',NULL,NULL),(63,43,0,2,0,'w7RH3AO6L302ATJ0H2436ER2','nik',NULL,'',0.00,NULL,'2016-10-23 21:26:53',NULL,'',NULL,NULL),(64,43,0,2,0,'w7RH3AO6L302ATJ0H2436ER2','nik',NULL,'',0.00,NULL,'2016-10-23 21:26:58',NULL,'',NULL,NULL),(65,43,0,2,0,'w7RH3AO6L302ATJ0H2436ER2','nik',NULL,'',0.00,NULL,'2016-10-23 21:27:18',NULL,'',NULL,NULL),(66,44,0,2,1,'w7RH3AO6L302ATJ0H2436ER2','nik','2301802','',0.00,NULL,'2016-10-23 21:27:55',NULL,'',NULL,NULL),(67,44,0,2,0,'w7RH3AO6L302ATJ0H2436ER2','nik',NULL,'',0.00,NULL,'2016-10-23 21:28:01',NULL,'',NULL,NULL),(68,44,0,2,0,'w7RH3AO6L302ATJ0H2436ER2','nik',NULL,'',0.00,NULL,'2016-10-23 21:29:02',NULL,'',NULL,NULL),(69,44,0,2,0,'w7RH3AO6L302ATJ0H2436ER2','nik',NULL,'',0.00,NULL,'2016-10-23 21:29:06',NULL,'',NULL,NULL),(70,44,0,2,0,'w7RH3AO6L302ATJ0H2436ER2','nik',NULL,'',0.00,NULL,'2016-10-23 21:29:09',NULL,'',NULL,NULL),(71,44,0,2,0,'w7RH3AO6L302ATJ0H2436ER2','nik',NULL,'',0.00,NULL,'2016-10-23 21:29:17',NULL,'',NULL,NULL),(72,45,0,2,1,'w7RH3AO6L302ATJ0H2436ER2','nik','2301811','',0.00,NULL,'2016-10-23 21:31:06',NULL,'',NULL,NULL),(73,45,0,2,0,'w7RH3AO6L302ATJ0H2436ER2','nik',NULL,'',0.00,NULL,'2016-10-23 21:31:11',NULL,'',NULL,NULL),(74,45,0,2,0,'w7RH3AO6L302ATJ0H2436ER2','nik',NULL,'',0.00,NULL,'2016-10-23 21:31:15',NULL,'',NULL,NULL),(75,46,0,2,2,'wH4L59K48UJKK8K0HS2MTEMM','nik','2304221','',638.00,0.00,'2016-10-24 08:19:25','2016-10-24 12:38:10','','',''),(76,47,0,2,1,'','','2304785','',0.00,NULL,'2016-10-24 09:30:09',NULL,'',NULL,NULL),(77,48,0,2,1,'','','2305592','',0.00,NULL,'2016-10-24 11:15:04',NULL,'',NULL,NULL),(78,49,0,2,1,'','','2305713','',0.00,NULL,'2016-10-24 11:31:22',NULL,'',NULL,NULL),(79,50,0,2,1,'','','2309737','',0.00,NULL,'2016-10-24 20:15:07',NULL,'',NULL,NULL),(80,53,0,4,1,'','','2619374','',0.00,NULL,'2016-12-03 10:45:48',NULL,'',NULL,NULL),(81,54,0,4,3,'2343954','zhenya','2619386','',1100.00,0.00,'2016-12-03 10:47:27','2016-12-03 13:47:32','','',''),(82,57,0,4,1,'','','2622085','',0.00,NULL,'2016-12-03 16:06:56',NULL,'',NULL,NULL),(83,63,0,4,3,'wGQRV65OMAH3MHI11CRSD0FE','nik','2622677','',1100.00,0.00,'2016-12-03 17:06:50','2016-12-07 19:18:42','','',''),(84,64,0,4,3,'wAVCIT9DLD4VAHI1HG2CUQPS','nik','2622860','',1100.00,0.00,'2016-12-03 17:26:44','2016-12-03 21:36:32','','',''),(85,67,0,4,3,'w7AVV795QEGSIHI1HSDD7504','nik','2622922','',1100.00,0.00,'2016-12-03 17:33:13','2016-12-03 21:18:47','','',''),(86,68,0,4,2,'wCET0CC8DH3UJII1150C4RNQ','nik','2623207','',1100.00,0.00,'2016-12-03 18:05:58','2016-12-03 21:18:47','','',''),(87,69,0,4,3,'wLGGJKOKH1I8TII1HLOVFM50','nik','2623243','',1100.00,0.00,'2016-12-03 18:10:18','2016-12-04 15:58:13','','',''),(88,72,0,4,3,'wAJHP6EUGPH7QII1HA510TL6','nik','2623435','',1100.00,0.00,'2016-12-03 18:36:02','2016-12-07 19:09:44','','',''),(89,75,0,4,3,'wET2B28P8J91CJI1HEDDB16K','nik','2623808','',1100.00,0.00,'2016-12-03 19:27:54','2016-12-04 18:27:37','','',''),(90,75,0,4,0,'wET2B28P8J91CJI1HEDDB16K','nik',NULL,'',0.00,NULL,'2016-12-03 19:28:04',NULL,'',NULL,NULL),(91,80,0,4,3,'wO1HKMFUTM3TEKI11BU2VN5I','nik','2624133','',1100.00,0.00,'2016-12-03 20:17:56','2016-12-03 23:27:08','','',''),(92,80,0,4,0,'wO1HKMFUTM3TEKI11BU2VN5I','nik',NULL,'',0.00,NULL,'2016-12-03 20:18:31',NULL,'',NULL,NULL),(93,85,0,4,3,'wAKR98KRLB7S0KI1HVUIOUCC','nik','2624212','',1100.00,0.00,'2016-12-03 20:34:16','2016-12-03 23:51:09','','',''),(94,86,0,4,3,'wPQJFC7S2UJ2GUI1HDRFHPEU','nik','2626052','',1100.00,0.00,'2016-12-04 06:18:17','2016-12-04 09:27:23','','',''),(95,87,0,4,3,'w2QMFKFNG0BULVI11BDQ5CCA','nik','2626466','',1100.00,0.00,'2016-12-04 07:14:04','2016-12-04 10:24:21','','',''),(96,88,0,4,3,'wP9E5LCQQ4D0AVI1HS2TV5NE','nik','2626572','',1100.00,0.00,'2016-12-04 07:25:54','2016-12-04 10:33:23','','',''),(97,91,0,4,2,'wLI616ASGE6S80J1HQVAGNEK','nik','2627083','',1100.00,0.00,'2016-12-04 08:20:57','2016-12-04 11:33:16','','',''),(98,94,0,4,3,'wAM5CGB6RA3F50J11GPRHVHG','nik','2627169','',1100.00,0.00,'2016-12-04 08:31:33','2016-12-04 11:42:25','','',''),(99,96,0,4,3,'wPJMQPV37LSKE1J11FDGPVMI','nik','2627510','',1100.00,0.00,'2016-12-04 09:14:12','2016-12-04 12:30:13','','',''),(100,98,0,4,3,'wBPA1RCIFC1G21J11M1NR2GM','nik','2627737','',1100.00,0.00,'2016-12-04 09:36:56','2016-12-04 12:51:36','','',''),(101,99,0,4,3,'wC8RGDCCDTBHM3J1H3OVA1ME','nik','2628728','',1100.00,0.00,'2016-12-04 11:17:31','2016-12-04 14:27:26','','',''),(108,112,0,4,3,'w2S817BNNNG0JBJ1HF4OCRFS','nik','2633063','',1100.00,0.00,'2016-12-04 19:40:04','2016-12-04 22:48:09','','',''),(109,113,0,4,2,'wLPLNFBGLS8UQMJ1H1FC4CUA','nik','2635659','',1100.00,0.00,'2016-12-05 06:55:04','2016-12-06 08:55:01','','',''),(110,116,0,4,3,'wJLO0PVU5C5G7NJ1HJJM8P54','nik','2636282','',1100.00,0.00,'2016-12-05 08:09:27','2016-12-05 11:42:45','','',''),(111,117,0,4,1,'wAN5AB0F527L4OJ1HC85NPCO','nik','2636371','',0.00,NULL,'2016-12-05 08:18:03',NULL,'',NULL,NULL),(112,118,0,4,2,'wK6FHASLV96EBTJ1H5E6RPUG','nik','2639041','',1100.00,0.00,'2016-12-05 13:28:58','2016-12-05 16:54:16','','',''),(113,119,0,4,2,'w1PATFPDJ98I5VJ1H23RNG5I','nik','2640065','',1100.00,0.00,'2016-12-05 15:35:07','2016-12-05 18:51:49','','',''),(114,122,0,4,0,'wTROOG2QQTL5Q0K1HJ8G09JQ','nik',NULL,'',0.00,NULL,'2016-12-05 16:51:11',NULL,'',NULL,NULL),(115,122,0,4,0,'wQE70EGH4HSP61K1HNUS78QM','nik',NULL,'',0.00,NULL,'2016-12-05 17:02:16',NULL,'',NULL,NULL),(116,122,0,4,0,'wQE70EGH4HSP61K1HNUS78QM','nik',NULL,'',0.00,NULL,'2016-12-05 17:02:17',NULL,'',NULL,NULL),(117,127,0,4,3,'wIPH3UM8HIRPO3K1HITT3F14','nik','2642174','',1100.00,0.00,'2016-12-05 19:44:46','2016-12-05 23:03:07','','',''),(118,130,0,4,2,'wHG67MK34K2SV4K11F09PVKI','nik','2642515','',1100.00,0.00,'2016-12-05 20:39:44','2016-12-06 09:00:31','','',''),(119,131,0,4,2,'wQQVFHQFAP5OH4K1H4IGB5KU','nik','2642523','',1100.00,0.00,'2016-12-05 20:40:53','2016-12-06 12:44:31','','',''),(120,134,0,4,3,'w3S6642C2QTLBBK1HPF41Q9M','nik','2643599','',1100.00,0.00,'2016-12-06 03:59:51','2016-12-06 08:09:14','','',''),(121,148,0,4,1,'','','2645079','',0.00,NULL,'2016-12-06 08:03:48',NULL,'',NULL,NULL),(122,151,0,4,3,'wJOR2QDHEMUSNGK115RS5R55','nik','2645325','',1100.00,0.00,'2016-12-06 08:32:49','2016-12-06 11:49:11','','',''),(123,152,0,4,1,'wT4BLVJT9G253HK1HRVDL032','nik','2645906','',0.00,NULL,'2016-12-06 09:39:52',NULL,'',NULL,NULL),(124,155,0,4,3,'wPNMMTPOU41FGKK1HD65AOOA','nik','2647133','',1100.00,0.00,'2016-12-06 12:11:02','2016-12-06 15:19:15','','',''),(125,156,0,4,2,'2','nov','2661140','',1100.00,0.00,'2016-12-06 19:19:47','2016-12-08 08:02:07','','',''),(126,157,0,4,2,'wIJON4DCFDRKPRK1HI11J5IG','nik','2650729','',1100.00,0.00,'2016-12-06 19:33:04','2016-12-06 22:54:10','','',''),(127,160,0,4,2,'wLFFE7VJROVEJRK1118KC9UU','nik','2650767','',1100.00,0.00,'2016-12-06 19:39:57','2016-12-06 23:00:08','','',''),(128,80,0,4,1,'2','nov','2651851','',0.00,NULL,'2016-12-07 02:06:44',NULL,'',NULL,NULL),(129,80,0,4,0,'2','nov',NULL,'',0.00,NULL,'2016-12-07 02:27:21',NULL,'',NULL,NULL),(130,80,0,4,0,'2','nov',NULL,'',0.00,NULL,'2016-12-07 02:36:31',NULL,'',NULL,NULL),(131,169,0,4,1,'2','nov','2652709','',0.00,NULL,'2016-12-07 05:56:53',NULL,'',NULL,NULL),(132,172,0,4,0,'2','nov',NULL,'',0.00,NULL,'2016-12-07 07:26:06',NULL,'',NULL,NULL),(133,175,0,4,1,'2','nov','2653400','',0.00,NULL,'2016-12-07 07:30:23',NULL,'',NULL,NULL),(134,178,0,4,1,'2','nov','2654285','',0.00,NULL,'2016-12-07 09:19:29',NULL,'',NULL,NULL),(135,179,0,4,1,'2','nov','2654443','',0.00,NULL,'2016-12-07 09:37:17',NULL,'',NULL,NULL),(136,182,0,4,1,'2','nov','2654585','',0.00,NULL,'2016-12-07 09:54:02',NULL,'',NULL,NULL),(137,185,0,4,1,'2','nov','2655233','',0.00,NULL,'2016-12-07 11:06:11',NULL,'',NULL,NULL),(138,186,0,4,1,'2','nov','2655292','',0.00,NULL,'2016-12-07 11:13:47',NULL,'',NULL,NULL),(139,187,0,4,1,'2','nov','2655370','',0.00,NULL,'2016-12-07 11:21:15',NULL,'',NULL,NULL),(140,188,0,4,1,'2','nov','2655476','',0.00,NULL,'2016-12-07 11:33:50',NULL,'',NULL,NULL),(141,188,0,4,0,'2','nov',NULL,'',0.00,NULL,'2016-12-07 11:34:27',NULL,'',NULL,NULL),(142,188,0,4,0,'2','nov',NULL,'',0.00,NULL,'2016-12-07 11:50:40',NULL,'',NULL,NULL),(143,195,0,4,1,'2','nov','2656829','',0.00,NULL,'2016-12-07 14:11:21',NULL,'',NULL,NULL),(144,188,0,4,1,'2','nov','2656943','',0.00,NULL,'2016-12-07 14:24:39',NULL,'',NULL,NULL),(145,200,0,4,1,'2','nov','2657018','',0.00,NULL,'2016-12-07 14:33:12',NULL,'',NULL,NULL),(146,200,0,4,0,'2','nov',NULL,'',0.00,NULL,'2016-12-07 14:33:13',NULL,'',NULL,NULL),(147,201,0,4,1,'2','nov','2658042','',0.00,NULL,'2016-12-07 16:31:15',NULL,'',NULL,NULL),(148,202,0,4,1,'2','nov','2658111','',0.00,NULL,'2016-12-07 16:39:24',NULL,'',NULL,NULL),(149,202,0,4,0,'2','nov',NULL,'',0.00,NULL,'2016-12-07 16:39:25',NULL,'',NULL,NULL),(150,203,0,4,1,'2','nov','2658173','',0.00,NULL,'2016-12-07 16:45:12',NULL,'',NULL,NULL),(151,206,0,4,1,'2','nov','2658176','',0.00,NULL,'2016-12-07 16:45:19',NULL,'',NULL,NULL),(152,207,0,4,1,'2','nov','2658989','',0.00,NULL,'2016-12-07 18:27:53',NULL,'',NULL,NULL),(153,208,0,4,1,'2','nov','2659779','',0.00,NULL,'2016-12-07 20:19:24',NULL,'',NULL,NULL),(154,209,0,4,1,'2','nov','2660809','',0.00,NULL,'2016-12-08 03:19:48',NULL,'',NULL,NULL),(155,209,0,4,0,'2','nov',NULL,'',0.00,NULL,'2016-12-08 03:19:49',NULL,'',NULL,NULL),(156,210,0,4,1,'2','nov','2661140','',0.00,NULL,'2016-12-08 04:45:55',NULL,'',NULL,NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_key` varchar(255) NOT NULL,
  `landing_key` varchar(255) NOT NULL,
  `success_landing_key` varchar(255) DEFAULT NULL,
  `cross_product_id` bigint(20) unsigned DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `webmaster_id` varchar(255) DEFAULT NULL,
  `affiliate_id` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `product_description` text,
  `create_date` datetime NOT NULL,
  `checkout_sequence` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'porshe-design-watch','porshe',NULL,NULL,'Часы Porshe Design','17763','1889',3990.00,NULL,'2016-10-19 09:54:39',1),(2,'tights','tights','parfum',3,'Колготаны','17763','2132',860.00,NULL,'2016-10-22 16:09:12',1),(3,'parfum','parfum','parfum_sold',0,'Много парфюма','17763','2114',0.00,NULL,'2016-10-23 12:23:34',1),(4,'smartwatch','smartwatch','parfum_sold',0,'Smart Watch','17763','1750',5190.00,NULL,'2016-12-03 08:51:39',1);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_config`
--

DROP TABLE IF EXISTS `system_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_config` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `config_key` varchar(255) NOT NULL,
  `config_value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_config`
--

LOCK TABLES `system_config` WRITE;
/*!40000 ALTER TABLE `system_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_routes`
--

DROP TABLE IF EXISTS `system_routes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_routes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `route` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `hidden` tinyint(4) NOT NULL,
  `permitted` tinyint(4) NOT NULL,
  `extenal` tinyint(4) NOT NULL,
  `parent` bigint(20) unsigned NOT NULL,
  `icon` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_routes`
--

LOCK TABLES `system_routes` WRITE;
/*!40000 ALTER TABLE `system_routes` DISABLE KEYS */;
INSERT INTO `system_routes` VALUES (22,'','Пользователи',100,0,0,0,0,'icon-user'),(23,'system_users','Пользователи',101,0,0,0,22,'icon-user'),(24,'system_users/groups','Группы',102,0,0,0,22,'icon-users'),(25,'system_users/add_user','Добавить Потльзователя',103,0,0,0,22,'icon-user-follow'),(26,'system_users/add_group','Добавить группу',104,0,0,0,22,'icon-users'),(27,'system_users/permissions','Доступы',105,0,0,0,22,'icon-settings'),(28,'orders','Заказы',1,0,0,0,0,'icon-basket'),(29,'products','Товары',2,0,0,0,0,'icon-list'),(30,'','Главная',0,1,1,0,0,''),(31,'faq','Справка',100,0,0,0,0,'icon-question'),(32,'','Главная',0,0,0,0,0,'icon-bar-chart'),(33,'formatting','Форматирование',80,0,0,0,0,'icon-disc');
/*!40000 ALTER TABLE `system_routes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_routes_user_groups_relations`
--

DROP TABLE IF EXISTS `system_routes_user_groups_relations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_routes_user_groups_relations` (
  `system_route_id` bigint(20) unsigned NOT NULL,
  `user_group_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_routes_user_groups_relations`
--

LOCK TABLES `system_routes_user_groups_relations` WRITE;
/*!40000 ALTER TABLE `system_routes_user_groups_relations` DISABLE KEYS */;
INSERT INTO `system_routes_user_groups_relations` VALUES (32,1),(28,1),(29,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(31,1),(32,6),(28,6),(29,6),(22,6),(23,6),(24,6),(25,6),(26,6),(27,6),(31,6);
/*!40000 ALTER TABLE `system_routes_user_groups_relations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_users`
--

DROP TABLE IF EXISTS `system_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_group_id` bigint(20) unsigned NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_users`
--

LOCK TABLES `system_users` WRITE;
/*!40000 ALTER TABLE `system_users` DISABLE KEYS */;
INSERT INTO `system_users` VALUES (75,1,'admin','c4ca4238a0b923820dcc509a6f75849b','0000-00-00 00:00:00'),(76,6,'nikita','4744e08db6e28cdc08adffec87c96344','2016-09-09 08:14:26');
/*!40000 ALTER TABLE `system_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_addresses`
--

DROP TABLE IF EXISTS `user_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `zip` varchar(30) DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_addresses`
--

LOCK TABLES `user_addresses` WRITE;
/*!40000 ALTER TABLE `user_addresses` DISABLE KEYS */;
INSERT INTO `user_addresses` VALUES (2,0,NULL,NULL,'1426000','','Москва','Russssss','2 Квесисская 22'),(3,3,NULL,NULL,'142603','','Москва','Russssss','Большая'),(4,2,NULL,NULL,'142600','','Москва','sr','2 Квесисская 22'),(5,2,NULL,NULL,'142600','','Москва','srdgf','2 Квесисская 22'),(6,2,NULL,NULL,'142600','','Москва','d','2 Квесисская 22'),(7,2,NULL,NULL,'142600','','Москва','we','2 Квесисская 22'),(8,2,NULL,NULL,'142600','','Москва','s','2 Квесисская 22'),(9,2,NULL,NULL,'142600','','Москва','dc','2 Квесисская 22'),(10,10,'a','s','738129','','Paris','Region','Address'),(11,2,'a','s','738129','','Paris','Region','Address'),(12,0,NULL,NULL,'sdf','','','sdf',''),(13,0,NULL,NULL,'sd','','','sd',''),(14,0,NULL,NULL,'sd','','','sd',''),(15,0,NULL,NULL,'234234','','sdfds','222','vcx');
/*!40000 ALTER TABLE `user_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_cc`
--

DROP TABLE IF EXISTS `user_cc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_cc` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `cc_number` varchar(255) DEFAULT NULL,
  `cc_month` varchar(255) DEFAULT NULL,
  `cc_year` varchar(255) DEFAULT NULL,
  `cc_cvv` varchar(255) DEFAULT NULL,
  `cc_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_cc`
--

LOCK TABLES `user_cc` WRITE;
/*!40000 ALTER TABLE `user_cc` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_cc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_groups`
--

LOCK TABLES `user_groups` WRITE;
/*!40000 ALTER TABLE `user_groups` DISABLE KEYS */;
INSERT INTO `user_groups` VALUES (1,'admin','2016-09-07 23:34:00'),(6,'Менеджер','2016-09-09 08:08:26');
/*!40000 ALTER TABLE `user_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=211 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (31,'Женя',NULL,'328583543','2016-10-19 11:32:25'),(32,'Женя',NULL,'12485385','2016-10-19 11:33:50'),(33,'Вася',NULL,'8285920432','2016-10-19 11:54:43'),(34,'Кексель',NULL,'+79110999462','2016-10-20 04:42:11'),(35,'test api',NULL,'+79110999469','2016-10-20 04:45:13'),(36,'Test Api',NULL,'245364758','2016-10-23 12:40:11'),(37,'Test Api',NULL,'3243564','2016-10-23 13:07:21'),(38,'Test Api',NULL,'24354675','2016-10-23 13:16:18'),(39,'Милана',NULL,'89285250401','2016-10-23 21:17:22'),(40,'Аврор',NULL,'89152478488','2016-10-23 21:20:02'),(41,'Абдал',NULL,'89679403777','2016-10-23 21:22:47'),(42,'Хаба',NULL,'89050388888','2016-10-23 21:24:50'),(43,'Зухра',NULL,'89285731725','2016-10-23 21:26:08'),(44,'Насир',NULL,'89634209666','2016-10-23 21:27:55'),(45,'Исмаэль',NULL,'89257154272','2016-10-23 21:31:06'),(46,'Эльмира',NULL,'79892898939','2016-10-24 08:19:25'),(47,'Светлана',NULL,'380674406050','2016-10-24 09:30:09'),(48,'Test123pixel',NULL,'891110992931','2016-10-24 11:15:04'),(49,'Test Api',NULL,'12312312321','2016-10-24 11:31:22'),(50,'Ольга',NULL,'+79603558969','2016-10-24 20:15:07'),(51,NULL,NULL,NULL,'2016-10-24 20:15:13'),(52,NULL,NULL,NULL,'2016-10-24 20:15:14'),(53,'Test Api',NULL,'1324567','2016-12-03 10:45:48'),(54,'Test Api',NULL,'123456','2016-12-03 10:47:27'),(55,NULL,NULL,NULL,'2016-12-03 10:47:28'),(56,NULL,NULL,NULL,'2016-12-03 10:47:28'),(57,'Test',NULL,'8911199934','2016-12-03 16:06:56'),(58,NULL,NULL,NULL,'2016-12-03 16:07:03'),(59,NULL,NULL,NULL,'2016-12-03 16:07:03'),(60,NULL,NULL,NULL,'2016-12-03 16:31:19'),(61,NULL,NULL,NULL,'2016-12-03 16:33:53'),(62,NULL,NULL,NULL,'2016-12-03 17:02:36'),(63,'Ужегов Альберт Владимирович ',NULL,'89187083888','2016-12-03 17:06:50'),(64,'Минаев Малик Османович ',NULL,'89896678358','2016-12-03 17:26:44'),(65,NULL,NULL,NULL,'2016-12-03 17:26:46'),(66,NULL,NULL,NULL,'2016-12-03 17:26:46'),(67,'Абдуллаев Максим курбаналиевич',NULL,'89993000051','2016-12-03 17:33:13'),(68,'Саламов Адамо Мовленович',NULL,'79604414400','2016-12-03 18:05:58'),(69,'Факри абануб айман',NULL,'89374229826','2016-12-03 18:10:18'),(70,NULL,NULL,NULL,'2016-12-03 18:10:21'),(71,NULL,NULL,NULL,'2016-12-03 18:10:21'),(72,'Веремеев Данила Владимирович',NULL,'89044375577','2016-12-03 18:36:02'),(73,NULL,NULL,NULL,'2016-12-03 18:36:05'),(74,NULL,NULL,NULL,'2016-12-03 18:36:05'),(75,'тарамбаем хусайн андиевич ',NULL,'89667243336','2016-12-03 19:27:54'),(76,NULL,NULL,NULL,'2016-12-03 19:27:56'),(77,NULL,NULL,NULL,'2016-12-03 19:27:56'),(78,NULL,NULL,NULL,'2016-12-03 19:28:05'),(79,NULL,NULL,NULL,'2016-12-03 19:28:06'),(80,'Алиев Бахридин Абдуалиевич',NULL,'9539236669','2016-12-03 20:17:56'),(81,NULL,NULL,NULL,'2016-12-03 20:17:58'),(82,NULL,NULL,NULL,'2016-12-03 20:17:58'),(83,NULL,NULL,NULL,'2016-12-03 20:18:31'),(84,NULL,NULL,NULL,'2016-12-03 20:18:32'),(85,'Булуев Хасан Исрепилович',NULL,'89280886585','2016-12-03 20:34:16'),(86,'Фаттоев Ислом Искандарович',NULL,'89532288476','2016-12-04 06:18:17'),(87,'Магомадов Лом-Али т',NULL,'89388948839','2016-12-04 07:14:04'),(88,'Алиев Бахридин Абдалиевич',NULL,'9539236669','2016-12-04 07:25:54'),(89,NULL,NULL,NULL,'2016-12-04 07:25:56'),(90,NULL,NULL,NULL,'2016-12-04 07:25:56'),(91,'Григорьев Игорь вадимович',NULL,'89509122664','2016-12-04 08:20:57'),(92,NULL,NULL,NULL,'2016-12-04 08:20:58'),(93,NULL,NULL,NULL,'2016-12-04 08:20:58'),(94,'даудов усман мамедович',NULL,'89889091314','2016-12-04 08:31:33'),(95,NULL,NULL,NULL,'2016-12-04 08:31:38'),(96,'джабаев али хусайнович',NULL,'89280187810','2016-12-04 09:14:12'),(97,NULL,NULL,NULL,'2016-12-04 09:14:14'),(98,'Коля',NULL,'89621142286','2016-12-04 09:36:56'),(99,'Балабаев Виктор Андреевич',NULL,'89992748228','2016-12-04 11:17:31'),(100,NULL,NULL,NULL,'2016-12-04 11:17:34'),(101,NULL,NULL,NULL,'2016-12-04 11:17:34'),(102,'Test',NULL,'12343556','2016-12-04 14:37:53'),(103,NULL,NULL,NULL,'2016-12-04 14:37:55'),(104,NULL,NULL,NULL,'2016-12-04 14:37:55'),(105,NULL,NULL,NULL,'2016-12-04 14:41:00'),(106,NULL,NULL,NULL,'2016-12-04 14:41:00'),(107,'Test',NULL,'1234567','2016-12-04 14:46:09'),(108,NULL,NULL,NULL,'2016-12-04 14:46:11'),(109,NULL,NULL,NULL,'2016-12-04 14:46:11'),(110,NULL,NULL,NULL,'2016-12-04 14:47:30'),(111,NULL,NULL,NULL,'2016-12-04 14:47:30'),(112,'Тихонов алеша',NULL,'89613410062','2016-12-04 19:40:04'),(113,'Хакимжон ',NULL,'89267636111 ','2016-12-05 06:55:04'),(114,NULL,NULL,NULL,'2016-12-05 06:55:06'),(115,NULL,NULL,NULL,'2016-12-05 06:55:06'),(116,'Константин ',NULL,'+79826570807','2016-12-05 08:09:27'),(117,'орозомамабетов Азамат',NULL,'89165483730','2016-12-05 08:18:03'),(118,'Маврин Роман',NULL,'89600305485','2016-12-05 13:28:58'),(119,'Таран Артур Валерьевич ',NULL,'89841604354','2016-12-05 15:35:07'),(120,NULL,NULL,NULL,'2016-12-05 15:35:14'),(121,NULL,NULL,NULL,'2016-12-05 15:35:15'),(122,'алиев',NULL,'шамиль','2016-12-05 16:51:11'),(123,NULL,NULL,NULL,'2016-12-05 16:51:13'),(124,NULL,NULL,NULL,'2016-12-05 16:51:13'),(125,NULL,NULL,NULL,'2016-12-05 17:02:18'),(126,NULL,NULL,NULL,'2016-12-05 17:02:18'),(127,'Гаджиев Руслан Гаджиевич',NULL,'89884335111','2016-12-05 19:44:46'),(128,NULL,NULL,NULL,'2016-12-05 19:44:49'),(129,NULL,NULL,NULL,'2016-12-05 19:44:49'),(130,'Гагик Мгдесян Тиранович',NULL,'+79997195441','2016-12-05 20:39:44'),(131,'Адельшин Забир Мурадович ',NULL,'89285317341','2016-12-05 20:40:53'),(132,NULL,NULL,NULL,'2016-12-05 20:40:55'),(133,NULL,NULL,NULL,'2016-12-05 20:40:55'),(134,'Балтабаев Исмаилжан ',NULL,'89091778757','2016-12-06 03:59:51'),(135,NULL,NULL,NULL,'2016-12-06 03:59:58'),(136,NULL,NULL,NULL,'2016-12-06 03:59:58'),(137,NULL,NULL,NULL,'2016-12-06 07:54:18'),(138,NULL,NULL,NULL,'2016-12-06 07:54:21'),(139,NULL,NULL,NULL,'2016-12-06 07:54:22'),(140,NULL,NULL,NULL,'2016-12-06 07:54:24'),(141,NULL,NULL,NULL,'2016-12-06 07:54:27'),(142,NULL,NULL,NULL,'2016-12-06 07:54:53'),(143,NULL,NULL,NULL,'2016-12-06 07:55:10'),(144,NULL,NULL,NULL,'2016-12-06 07:55:22'),(145,NULL,NULL,NULL,'2016-12-06 07:55:27'),(146,NULL,NULL,NULL,'2016-12-06 08:03:26'),(147,NULL,NULL,NULL,'2016-12-06 08:03:27'),(148,'test1',NULL,'891110009912','2016-12-06 08:03:48'),(149,NULL,NULL,NULL,'2016-12-06 08:03:54'),(150,NULL,NULL,NULL,'2016-12-06 08:03:54'),(151,'Идрисов Джамболат Алаудинович ',NULL,'89288926007','2016-12-06 08:32:49'),(152,'Кожевников А В',NULL,'79992105359','2016-12-06 09:39:52'),(153,NULL,NULL,NULL,'2016-12-06 09:39:54'),(154,NULL,NULL,NULL,'2016-12-06 09:39:54'),(155,'Нуриев Аташка Магомедович',NULL,'89604112808','2016-12-06 12:11:02'),(156,'Соломкин Денис Юрьевич',NULL,'89155450428','2016-12-06 19:19:47'),(157,'Мейманжанов',NULL,'89263868842','2016-12-06 19:33:04'),(158,NULL,NULL,NULL,'2016-12-06 19:33:07'),(159,NULL,NULL,NULL,'2016-12-06 19:33:07'),(160,'Зубайраев Араб Магомедович',NULL,'89659580416','2016-12-06 19:39:57'),(161,NULL,NULL,NULL,'2016-12-06 19:39:59'),(162,NULL,NULL,NULL,'2016-12-06 19:39:59'),(163,NULL,NULL,NULL,'2016-12-07 02:06:46'),(164,NULL,NULL,NULL,'2016-12-07 02:06:46'),(165,NULL,NULL,NULL,'2016-12-07 02:27:22'),(166,NULL,NULL,NULL,'2016-12-07 02:27:22'),(167,NULL,NULL,NULL,'2016-12-07 02:36:32'),(168,NULL,NULL,NULL,'2016-12-07 02:36:32'),(169,'Лукьянов Денис Юрьевич ',NULL,'89603036654 ','2016-12-07 05:56:53'),(170,NULL,NULL,NULL,'2016-12-07 05:56:56'),(171,NULL,NULL,NULL,'2016-12-07 05:56:56'),(172,'Аббас',NULL,'Гаджиев ','2016-12-07 07:26:06'),(173,NULL,NULL,NULL,'2016-12-07 07:26:13'),(174,NULL,NULL,NULL,'2016-12-07 07:26:13'),(175,'Алексей Александрович ',NULL,'89997844547','2016-12-07 07:30:23'),(176,NULL,NULL,NULL,'2016-12-07 07:30:24'),(177,NULL,NULL,NULL,'2016-12-07 07:30:24'),(178,'Артык генджайев',NULL,'9110015352','2016-12-07 09:19:29'),(179,'Адам Цакаев',NULL,'89659636787','2016-12-07 09:37:17'),(180,NULL,NULL,NULL,'2016-12-07 09:37:44'),(181,NULL,NULL,NULL,'2016-12-07 09:37:47'),(182,'Адам',NULL,'89604404818','2016-12-07 09:54:02'),(183,NULL,NULL,NULL,'2016-12-07 09:54:06'),(184,NULL,NULL,NULL,'2016-12-07 09:54:06'),(185,'Алимов амирхан мусинович',NULL,'89063524008','2016-12-07 11:06:11'),(186,'Абуев зелиммхан хусейнович',NULL,'Чр надтеречный район сел надтеречное ул Северная 25','2016-12-07 11:13:47'),(187,'Якуб',NULL,'89990870706','2016-12-07 11:21:15'),(188,'Гильмутдинов рамиль ращитович',NULL,'89172720261','2016-12-07 11:33:50'),(189,NULL,NULL,NULL,'2016-12-07 11:33:52'),(190,NULL,NULL,NULL,'2016-12-07 11:33:52'),(191,NULL,NULL,NULL,'2016-12-07 11:34:28'),(192,NULL,NULL,NULL,'2016-12-07 11:34:28'),(193,NULL,NULL,NULL,'2016-12-07 11:50:41'),(194,NULL,NULL,NULL,'2016-12-07 11:50:41'),(195,'Шамсудинова Марият',NULL,'89285072722','2016-12-07 14:11:21'),(196,NULL,NULL,NULL,'2016-12-07 14:11:23'),(197,NULL,NULL,NULL,'2016-12-07 14:11:23'),(198,NULL,NULL,NULL,'2016-12-07 14:24:42'),(199,NULL,NULL,NULL,'2016-12-07 14:24:42'),(200,'Коновалов Антон Александрович ',NULL,'89670915157','2016-12-07 14:33:12'),(201,'Сайдуллаев Милана ',NULL,'89280555065','2016-12-07 16:31:15'),(202,'лидер',NULL,'89287494582','2016-12-07 16:39:24'),(203,'Канукоев Мартин Лионидович ',NULL,'89640304775','2016-12-07 16:45:12'),(204,NULL,NULL,NULL,'2016-12-07 16:45:15'),(205,NULL,NULL,NULL,'2016-12-07 16:45:15'),(206,'Хамракулов Салохиддин Негматович ',NULL,'89279570088','2016-12-07 16:45:19'),(207,'Ткач Михаил Викторович ',NULL,'+79005771916','2016-12-07 18:27:53'),(208,'Курмагомедов Магомед Ахмедович',NULL,'89673963211','2016-12-07 20:19:24'),(209,'Муслим Буйлаш',NULL,'+79623153655','2016-12-08 03:19:48'),(210,'Хабибулин Александр Сергеевич ',NULL,'89990574616','2016-12-08 04:45:55');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-08  6:59:00
