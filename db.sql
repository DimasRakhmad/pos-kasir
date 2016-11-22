-- MySQL dump 10.13  Distrib 5.7.9, for linux-glibc2.5 (x86_64)
--
-- Host: localhost    Database: pelangi
-- ------------------------------------------------------
-- Server version	5.5.50-0ubuntu0.14.04.1

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
-- Table structure for table `account_groups`
--

DROP TABLE IF EXISTS `account_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `normal_balance` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_groups`
--

LOCK TABLES `account_groups` WRITE;
/*!40000 ALTER TABLE `account_groups` DISABLE KEYS */;
INSERT INTO `account_groups` VALUES (1,'Pendapatan Usaha','Pendapatan','Kredit','2016-10-17 14:49:50','2016-10-17 14:49:50'),(2,'Biaya Produksi','Biaya dan Beban','Debit','2016-10-17 14:49:50','2016-10-17 14:49:50'),(3,'Biaya Operasional','Biaya dan Beban','Debit','2016-10-17 14:49:50','2016-10-17 14:49:50'),(4,'Biaya Non Operasional','Biaya dan Beban','Debit','2016-10-17 14:49:50','2016-10-17 14:49:50'),(5,'Pendapatan Luar Usaha','Pendapatan','Kredit','2016-10-17 14:49:50','2016-10-17 14:49:50'),(6,'Kas','Harta','Debit','2016-10-17 14:49:50','2016-10-17 14:49:50'),(7,'Kewajiban','Hutang','Kredit','2016-10-17 14:49:50','2016-10-17 14:49:50'),(8,'Piutang','Harta','Debit','2016-10-17 14:49:50','2016-10-17 14:49:50'),(9,'Kas Bank','Harta','Debit','2016-10-17 14:49:50','2016-10-17 14:49:50'),(10,'Piutang Karyawan','Harta','Debit','2016-10-17 14:49:50','2016-10-17 14:49:50');
/*!40000 ALTER TABLE `account_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accounting_transactions`
--

DROP TABLE IF EXISTS `accounting_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounting_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL,
  `transaction_id` int(10) unsigned NOT NULL,
  `amount` double(20,2) NOT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `accounting_transactions_account_id_foreign` (`account_id`),
  KEY `accounting_transactions_transaction_id_foreign` (`transaction_id`),
  CONSTRAINT `accounting_transactions_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `accounting_transactions_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounting_transactions`
--

LOCK TABLES `accounting_transactions` WRITE;
/*!40000 ALTER TABLE `accounting_transactions` DISABLE KEYS */;
INSERT INTO `accounting_transactions` VALUES (1,1,2,1240000.00,NULL,'2016-10-18 01:39:53','2016-10-18 01:39:53'),(2,3,2,-1240000.00,NULL,'2016-10-18 01:39:53','2016-10-18 01:39:53'),(3,1,2,1240000.00,NULL,'2016-10-18 01:40:06','2016-10-18 01:40:06'),(4,3,2,-1240000.00,NULL,'2016-10-18 01:40:06','2016-10-18 01:40:06'),(5,1,1,110000.00,NULL,'2016-10-18 03:26:12','2016-10-18 03:26:12'),(6,3,1,-110000.00,NULL,'2016-10-18 03:26:12','2016-10-18 03:26:12'),(7,1,1,110000.00,NULL,'2016-10-18 03:29:04','2016-10-18 03:29:04'),(8,3,1,-110000.00,NULL,'2016-10-18 03:29:04','2016-10-18 03:29:04'),(9,1,1,110000.00,NULL,'2016-10-18 03:29:25','2016-10-18 03:29:25'),(10,3,1,-110000.00,NULL,'2016-10-18 03:29:25','2016-10-18 03:29:25'),(11,1,1,110000.00,NULL,'2016-10-18 03:31:27','2016-10-18 03:31:27'),(12,3,1,-110000.00,NULL,'2016-10-18 03:31:27','2016-10-18 03:31:27'),(13,1,1,110000.00,NULL,'2016-10-18 03:31:42','2016-10-18 03:31:42'),(14,3,1,-110000.00,NULL,'2016-10-18 03:31:42','2016-10-18 03:31:42'),(15,1,3,50000.00,NULL,'2016-10-18 03:32:10','2016-10-18 03:32:10'),(16,3,3,-50000.00,NULL,'2016-10-18 03:32:10','2016-10-18 03:32:10'),(17,1,3,50000.00,NULL,'2016-10-18 03:32:56','2016-10-18 03:32:56'),(18,3,3,-50000.00,NULL,'2016-10-18 03:32:56','2016-10-18 03:32:56'),(19,7,4,50000.00,NULL,'2016-10-18 03:35:21','2016-10-18 03:35:21'),(20,3,4,-50000.00,NULL,'2016-10-18 03:35:22','2016-10-18 03:35:22'),(21,7,4,50000.00,NULL,'2016-10-18 03:35:34','2016-10-18 03:35:34'),(22,3,4,-50000.00,NULL,'2016-10-18 03:35:34','2016-10-18 03:35:34'),(23,7,4,50000.00,NULL,'2016-10-18 03:50:44','2016-10-18 03:50:44'),(24,3,4,-50000.00,NULL,'2016-10-18 03:50:44','2016-10-18 03:50:44'),(25,1,5,100000.00,NULL,'2016-10-18 03:51:29','2016-10-18 03:51:29'),(26,3,5,-100000.00,NULL,'2016-10-18 03:51:29','2016-10-18 03:51:29'),(27,7,6,70000.00,NULL,'2016-10-18 03:54:20','2016-10-18 03:54:20'),(28,3,6,-70000.00,NULL,'2016-10-18 03:54:21','2016-10-18 03:54:21'),(29,1,7,85000.00,NULL,'2016-10-18 04:01:42','2016-10-18 04:01:42'),(30,3,7,-85000.00,NULL,'2016-10-18 04:01:42','2016-10-18 04:01:42'),(31,1,8,105000.00,NULL,'2016-10-18 04:07:46','2016-10-18 04:07:46'),(32,3,8,-105000.00,NULL,'2016-10-18 04:07:46','2016-10-18 04:07:46'),(33,1,9,115000.00,NULL,'2016-10-18 04:08:44','2016-10-18 04:08:44'),(34,3,9,-115000.00,NULL,'2016-10-18 04:08:44','2016-10-18 04:08:44'),(35,1,10,40000.00,NULL,'2016-10-18 04:09:21','2016-10-18 04:09:21'),(36,3,10,-40000.00,NULL,'2016-10-18 04:09:21','2016-10-18 04:09:21'),(37,1,11,90000.00,NULL,'2016-10-18 04:10:38','2016-10-18 04:10:38'),(38,3,11,-90000.00,NULL,'2016-10-18 04:10:38','2016-10-18 04:10:38'),(39,1,13,90000.00,NULL,'2016-10-18 08:35:35','2016-10-18 08:35:35'),(40,3,13,-90000.00,NULL,'2016-10-18 08:35:35','2016-10-18 08:35:35'),(41,1,13,90000.00,NULL,'2016-10-18 08:36:13','2016-10-18 08:36:13'),(42,3,13,-90000.00,NULL,'2016-10-18 08:36:13','2016-10-18 08:36:13');
/*!40000 ALTER TABLE `accounting_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_group_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `accounts_account_group_id_foreign` (`account_group_id`),
  CONSTRAINT `accounts_account_group_id_foreign` FOREIGN KEY (`account_group_id`) REFERENCES `account_groups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,6,'101','Kas','2016-10-17 14:49:50','2016-10-17 14:49:50'),(2,2,'501','Pembelian','2016-10-17 14:49:50','2016-10-17 14:49:50'),(3,1,'401','Penjualan','2016-10-17 14:49:50','2016-10-17 14:49:50'),(4,4,'502','Compliment','2016-10-17 14:49:50','2016-10-17 14:49:50'),(5,4,'503','Void','2016-10-17 14:49:50','2016-10-17 14:49:50'),(6,5,'402','Administration Cost','2016-10-17 14:49:50','2016-10-17 14:49:50'),(7,5,'403','Delivery Cost','2016-10-17 14:49:50','2016-10-17 14:49:50'),(8,1,NULL,'Kredit Mandiri','2016-10-17 14:49:50','2016-10-17 14:49:50'),(9,1,NULL,'Debit Mandiri','2016-10-17 14:49:50','2016-10-17 14:49:50');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `areas`
--

LOCK TABLES `areas` WRITE;
/*!40000 ALTER TABLE `areas` DISABLE KEYS */;
INSERT INTO `areas` VALUES (1,'Atas','2016-10-17 14:49:48','2016-10-17 14:49:48'),(2,'Depan','2016-10-17 14:49:48','2016-10-17 14:49:48'),(3,'Bawah','2016-10-17 14:49:48','2016-10-17 14:49:48');
/*!40000 ALTER TABLE `areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Appetizer','','2016-10-17 14:49:48','0000-00-00 00:00:00'),(2,'Main Course','','2016-10-17 14:49:48','0000-00-00 00:00:00'),(3,'Deesert','','2016-10-17 14:49:48','0000-00-00 00:00:00'),(4,'Beverages','','2016-10-17 14:49:48','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `edcs`
--

DROP TABLE IF EXISTS `edcs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `edcs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_kredit_id` int(10) unsigned DEFAULT NULL,
  `account_debit_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `edcs_account_debit_id_foreign` (`account_debit_id`),
  KEY `edcs_account_kredit_id_foreign` (`account_kredit_id`),
  CONSTRAINT `edcs_account_debit_id_foreign` FOREIGN KEY (`account_debit_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `edcs_account_kredit_id_foreign` FOREIGN KEY (`account_kredit_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `edcs`
--

LOCK TABLES `edcs` WRITE;
/*!40000 ALTER TABLE `edcs` DISABLE KEYS */;
INSERT INTO `edcs` VALUES (1,'Mandiri',8,9,'2016-10-17 14:49:51','2016-10-17 14:49:51');
/*!40000 ALTER TABLE `edcs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'Tepung','KG',NULL,'2016-10-17 14:49:51','2016-10-17 14:49:51'),(2,'Beras','KG',NULL,'2016-10-17 14:49:51','2016-10-17 14:49:51'),(3,'Gula','KG',NULL,'2016-10-17 14:49:51','2016-10-17 14:49:51'),(4,'Kecap','KG',NULL,'2016-10-17 14:49:51','2016-10-17 14:49:51'),(5,'Sambal','KG',NULL,'2016-10-17 14:49:51','2016-10-17 14:49:51'),(6,'Garam','KG',NULL,'2016-10-17 14:49:51','2016-10-17 14:49:51'),(7,'Minyak Goreng','liter',NULL,'2016-10-17 14:49:51','2016-10-17 14:49:51'),(8,'Telur','kg',NULL,'2016-10-17 14:49:51','2016-10-17 14:49:51'),(9,'Bawang','ons',NULL,'2016-10-17 14:49:51','2016-10-17 14:49:51');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_id` int(10) unsigned NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `members_account_id_foreign` (`account_id`),
  CONSTRAINT `members_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `menus_code_unique` (`code`),
  KEY `menus_category_id_foreign` (`category_id`),
  CONSTRAINT `menus_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,1,'A001','Kentang Goreng',10000,NULL,'2016-10-17 14:49:48','0000-00-00 00:00:00'),(2,1,'A002','Tempe Mendoan',20000,NULL,'2016-10-17 14:49:48','0000-00-00 00:00:00'),(3,2,'MC001','Nasi Goreng',30000,NULL,'2016-10-17 14:49:48','0000-00-00 00:00:00'),(4,2,'MC002','Mie Ayam',40000,NULL,'2016-10-17 14:49:48','0000-00-00 00:00:00'),(5,3,'D001','Puding',25000,NULL,'2016-10-17 14:49:48','0000-00-00 00:00:00'),(6,3,'D002','Pancake',15000,NULL,'2016-10-17 14:49:48','0000-00-00 00:00:00'),(7,4,'B001','Jus Semangka',15000,NULL,'2016-10-17 14:49:48','0000-00-00 00:00:00'),(8,4,'B002','Lemon Tea',15000,NULL,'2016-10-17 14:49:48','0000-00-00 00:00:00'),(9,2,'12345','Karedok',20000,'22','2016-10-18 01:35:52','2016-10-18 01:35:52'),(10,3,'3323','Mie Goreng',300000,'123','2016-10-18 01:36:26','2016-10-18 01:36:26');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2015_01_15_105324_create_roles_table',1),('2015_01_15_114412_create_role_user_table',1),('2015_01_26_115212_create_permissions_table',1),('2015_01_26_115523_create_permission_role_table',1),('2015_02_09_132439_create_permission_user_table',1),('2016_10_13_202238_create_table_areas',1),('2016_10_13_202311_create_table_tables',1),('2016_10_13_202331_create_table_categories',1),('2016_10_13_202344_create_table_items',1),('2016_10_13_202358_create_table_menu',1),('2016_10_13_202414_create_table_account_group',1),('2016_10_13_202424_create_table_account',1),('2016_10_13_202442_create_table_transaction',1),('2016_10_13_203226_create_table_purchase',1),('2016_10_13_203314_create_table_transaction_detail',1),('2016_10_13_203339_create_table_member',1),('2016_10_13_203355_create_table_recipe',1),('2016_10_14_034803_create_e_d_cs_table',1),('2016_10_14_091354_create_accounting_transaction',1),('2016_10_14_101617_create_sale_table',1),('2016_10_14_171625_alter_table_user_add_type',1),('2016_10_14_183931_create_table_stock',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `permission_role_permission_id_index` (`permission_id`),
  KEY `permission_role_role_id_index` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_user`
--

DROP TABLE IF EXISTS `permission_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `permission_user_permission_id_index` (`permission_id`),
  KEY `permission_user_user_id_index` (`user_id`),
  CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_user`
--

LOCK TABLES `permission_user` WRITE;
/*!40000 ALTER TABLE `permission_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` int(10) unsigned NOT NULL,
  `supplier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `purchases_transaction_id_foreign` (`transaction_id`),
  CONSTRAINT `purchases_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchases`
--

LOCK TABLES `purchases` WRITE;
/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipes`
--

DROP TABLE IF EXISTS `recipes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `recipes_menu_id_foreign` (`menu_id`),
  KEY `recipes_item_id_foreign` (`item_id`),
  CONSTRAINT `recipes_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `recipes_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipes`
--

LOCK TABLES `recipes` WRITE;
/*!40000 ALTER TABLE `recipes` DISABLE KEYS */;
INSERT INTO `recipes` VALUES (1,9,4,20.00,'2016-10-18 01:35:52','2016-10-18 01:35:52'),(2,9,9,30.00,'2016-10-18 01:35:52','2016-10-18 01:35:52'),(3,10,6,34.00,'2016-10-18 01:36:26','2016-10-18 01:36:26'),(4,10,7,3.00,'2016-10-18 01:36:26','2016-10-18 01:36:26'),(5,10,4,45.00,'2016-10-18 01:36:26','2016-10-18 01:36:26');
/*!40000 ALTER TABLE `recipes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `role_user_role_id_index` (`role_id`),
  KEY `role_user_user_id_index` (`user_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (1,1,1,'2016-10-17 14:49:49','2016-10-17 14:49:49'),(2,2,2,'2016-10-17 14:49:49','2016-10-17 14:49:49'),(3,3,3,'2016-10-17 14:49:49','2016-10-17 14:49:49'),(4,5,4,'2016-10-17 14:49:50','2016-10-17 14:49:50');
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin','admin',NULL,1,'2016-10-17 14:49:48','2016-10-17 14:49:48'),(2,'Cashier','cashier',NULL,1,'2016-10-17 14:49:48','2016-10-17 14:49:48'),(3,'Waiters','waiters',NULL,1,'2016-10-17 14:49:48','2016-10-17 14:49:48'),(4,'Accounting','accounting',NULL,1,'2016-10-17 14:49:48','2016-10-17 14:49:48'),(5,'Manager','manager',NULL,1,'2016-10-17 14:49:48','2016-10-17 14:49:48');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` int(10) unsigned NOT NULL,
  `table_id` int(10) unsigned DEFAULT NULL,
  `subtotal` double(20,2) NOT NULL,
  `discount` double(20,2) NOT NULL DEFAULT '0.00',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `memo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pay_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `edc_id` int(10) unsigned DEFAULT NULL,
  `member_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `sales_transaction_id_foreign` (`transaction_id`),
  KEY `sales_edc_id_foreign` (`edc_id`),
  KEY `sales_member_id_foreign` (`member_id`),
  KEY `sales_table_id_foreign` (`table_id`),
  CONSTRAINT `sales_edc_id_foreign` FOREIGN KEY (`edc_id`) REFERENCES `edcs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sales_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sales_table_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sales_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (1,1,NULL,110000.00,0.00,'finish','Take Away','','cash',NULL,NULL,'2016-10-17 14:52:55','2016-10-18 03:31:42'),(2,2,1,1240000.00,0.00,'finish','Dine In','','cash',NULL,NULL,'2016-10-18 01:38:44','2016-10-18 01:40:06'),(3,3,NULL,50000.00,0.00,'finish','Delivery','','cash',NULL,NULL,'2016-10-18 03:31:48','2016-10-18 03:32:56'),(4,4,NULL,50000.00,0.00,'finish','Take Away','','void',NULL,NULL,'2016-10-18 03:35:12','2016-10-18 03:50:44'),(5,5,NULL,100000.00,0.00,'finish','Take Away','','cash',NULL,NULL,'2016-10-18 03:50:56','2016-10-18 03:51:29'),(6,6,NULL,70000.00,0.00,'finish','Take Away','','void',NULL,NULL,'2016-10-18 03:54:00','2016-10-18 03:54:20'),(7,7,NULL,85000.00,0.00,'finish','Take Away','','cash',NULL,NULL,'2016-10-18 04:01:26','2016-10-18 04:01:42'),(8,8,1,105000.00,0.00,'finish','Dine In','','cash',NULL,NULL,'2016-10-18 04:02:43','2016-10-18 04:07:46'),(9,9,NULL,115000.00,0.00,'finish','Take Away','','cash',NULL,NULL,'2016-10-18 04:08:27','2016-10-18 04:08:44'),(10,10,NULL,40000.00,0.00,'finish','Take Away','','cash',NULL,NULL,'2016-10-18 04:09:06','2016-10-18 04:09:21'),(11,11,NULL,90000.00,0.00,'finish','Take Away','','cash',NULL,NULL,'2016-10-18 04:10:09','2016-10-18 04:10:38'),(13,13,NULL,90000.00,0.00,'finish','Take Away','','cash',NULL,NULL,'2016-10-18 08:31:46','2016-10-18 08:36:13'),(16,16,1,0.00,0.00,'checkout','Dine In','','',NULL,NULL,'2016-10-18 08:50:59','2016-10-18 08:51:13');
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stocks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(10) unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `amount` double(8,2) NOT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocks`
--

LOCK TABLES `stocks` WRITE;
/*!40000 ALTER TABLE `stocks` DISABLE KEYS */;
INSERT INTO `stocks` VALUES (1,6,'out','2016-10-18',136.00,'recipe','2016-10-18 01:39:52','2016-10-18 01:39:52'),(2,7,'out','2016-10-18',12.00,'recipe','2016-10-18 01:39:53','2016-10-18 01:39:53'),(3,4,'out','2016-10-18',180.00,'recipe','2016-10-18 01:39:53','2016-10-18 01:39:53'),(4,4,'out','2016-10-18',40.00,'recipe','2016-10-18 01:39:53','2016-10-18 01:39:53'),(5,9,'out','2016-10-18',60.00,'recipe','2016-10-18 01:39:53','2016-10-18 01:39:53'),(6,6,'out','2016-10-18',136.00,'recipe','2016-10-18 01:40:06','2016-10-18 01:40:06'),(7,7,'out','2016-10-18',12.00,'recipe','2016-10-18 01:40:06','2016-10-18 01:40:06'),(8,4,'out','2016-10-18',180.00,'recipe','2016-10-18 01:40:06','2016-10-18 01:40:06'),(9,4,'out','2016-10-18',40.00,'recipe','2016-10-18 01:40:06','2016-10-18 01:40:06'),(10,9,'out','2016-10-18',60.00,'recipe','2016-10-18 01:40:06','2016-10-18 01:40:06');
/*!40000 ALTER TABLE `stocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tables`
--

DROP TABLE IF EXISTS `tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `area_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Available',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tables_code_unique` (`code`),
  KEY `tables_area_id_foreign` (`area_id`),
  CONSTRAINT `tables_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tables`
--

LOCK TABLES `tables` WRITE;
/*!40000 ALTER TABLE `tables` DISABLE KEYS */;
INSERT INTO `tables` VALUES (1,1,'M001','Meja 1','Terisi','2016-10-17 14:49:48','2016-10-18 08:50:58'),(2,2,'M002','Meja 2','Available','2016-10-17 14:49:48','0000-00-00 00:00:00'),(3,1,'M003','Meja 3','Available','2016-10-17 14:49:48','0000-00-00 00:00:00'),(4,3,'M004','Meja 4','Available','2016-10-17 14:49:48','0000-00-00 00:00:00'),(999,3,'M999','Di Bawa Pulang','Available','2016-10-17 14:49:48','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_details`
--

DROP TABLE IF EXISTS `transaction_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned DEFAULT NULL,
  `menu_id` int(10) unsigned DEFAULT NULL,
  `price` int(11) NOT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `discount` double(20,2) NOT NULL,
  `total` double(20,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `transaction_details_transaction_id_foreign` (`transaction_id`),
  KEY `transaction_details_item_id_foreign` (`item_id`),
  KEY `transaction_details_menu_id_foreign` (`menu_id`),
  CONSTRAINT `transaction_details_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transaction_details_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transaction_details_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_details`
--

LOCK TABLES `transaction_details` WRITE;
/*!40000 ALTER TABLE `transaction_details` DISABLE KEYS */;
INSERT INTO `transaction_details` VALUES (1,2,NULL,10,0,'',4,300000,0.00,1200000.00,'2016-10-18 01:39:38','2016-10-18 01:39:38'),(2,2,NULL,9,0,'',2,20000,0.00,40000.00,'2016-10-18 01:39:38','2016-10-18 01:39:38'),(3,1,NULL,1,0,'',3,10000,0.00,30000.00,'2016-10-18 03:26:04','2016-10-18 03:26:04'),(4,1,NULL,4,0,'',2,40000,0.00,80000.00,'2016-10-18 03:26:04','2016-10-18 03:26:04'),(5,3,NULL,3,0,'',1,30000,0.00,30000.00,'2016-10-18 03:31:58','2016-10-18 03:31:58'),(6,3,NULL,2,0,'',1,20000,0.00,20000.00,'2016-10-18 03:31:58','2016-10-18 03:31:58'),(7,3,NULL,NULL,0,'Delivery Cost',0,0,0.00,1000.00,'2016-10-18 03:32:10','2016-10-18 03:32:10'),(8,3,NULL,NULL,0,'Delivery Cost',0,0,0.00,1000.00,'2016-10-18 03:32:56','2016-10-18 03:32:56'),(9,4,NULL,3,0,'',1,30000,0.00,30000.00,'2016-10-18 03:35:16','2016-10-18 03:35:16'),(10,4,NULL,2,0,'',1,20000,0.00,20000.00,'2016-10-18 03:35:16','2016-10-18 03:35:16'),(11,5,NULL,3,0,'',3,30000,0.00,90000.00,'2016-10-18 03:51:15','2016-10-18 03:51:15'),(12,5,NULL,1,0,'',1,10000,0.00,10000.00,'2016-10-18 03:51:15','2016-10-18 03:51:15'),(13,6,NULL,2,0,'',3,20000,0.00,60000.00,'2016-10-18 03:54:07','2016-10-18 03:54:07'),(14,6,NULL,1,0,'',1,10000,0.00,10000.00,'2016-10-18 03:54:08','2016-10-18 03:54:08'),(15,7,NULL,5,0,'',1,25000,0.00,25000.00,'2016-10-18 04:01:31','2016-10-18 04:01:31'),(16,7,NULL,3,0,'',2,30000,0.00,60000.00,'2016-10-18 04:01:31','2016-10-18 04:01:31'),(17,8,NULL,2,0,'',4,20000,0.00,80000.00,'2016-10-18 04:02:51','2016-10-18 04:02:51'),(18,8,NULL,5,0,'',1,25000,0.00,25000.00,'2016-10-18 04:02:51','2016-10-18 04:02:51'),(19,9,NULL,6,0,'',1,15000,0.00,15000.00,'2016-10-18 04:08:36','2016-10-18 04:08:36'),(20,9,NULL,5,0,'',4,25000,0.00,100000.00,'2016-10-18 04:08:36','2016-10-18 04:08:36'),(21,10,NULL,6,0,'',1,15000,0.00,15000.00,'2016-10-18 04:09:11','2016-10-18 04:09:11'),(22,10,NULL,5,0,'',1,25000,0.00,25000.00,'2016-10-18 04:09:11','2016-10-18 04:09:11'),(23,11,NULL,5,0,'',2,25000,0.00,50000.00,'2016-10-18 04:10:14','2016-10-18 04:10:14'),(24,11,NULL,4,0,'',1,40000,0.00,40000.00,'2016-10-18 04:10:14','2016-10-18 04:10:14'),(43,13,NULL,2,0,'',4,20000,0.00,80000.00,'2016-10-18 08:35:17','2016-10-18 08:35:17'),(44,13,NULL,1,0,'',1,10000,0.00,10000.00,'2016-10-18 08:35:18','2016-10-18 08:35:18'),(53,16,NULL,2,0,'',1,20000,0.00,20000.00,'2016-10-18 08:51:09','2016-10-18 08:51:09'),(54,16,NULL,4,0,'',1,40000,0.00,40000.00,'2016-10-18 08:51:10','2016-10-18 08:51:10'),(55,16,NULL,5,0,'',1,25000,0.00,25000.00,'2016-10-18 08:52:30','2016-10-18 08:52:30'),(56,16,NULL,6,0,'',1,15000,0.00,15000.00,'2016-10-18 08:52:30','2016-10-18 08:52:30'),(57,16,NULL,10,0,'',1,300000,0.00,300000.00,'2016-10-18 08:53:53','2016-10-18 08:53:53'),(58,16,NULL,6,0,'',1,15000,0.00,15000.00,'2016-10-18 08:54:35','2016-10-18 08:54:35');
/*!40000 ALTER TABLE `transaction_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total` double(20,2) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `inputer` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_code_unique` (`code`),
  KEY `transactions_inputer_foreign` (`inputer`),
  CONSTRAINT `transactions_inputer_foreign` FOREIGN KEY (`inputer`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,'TR201610170952551','Penjualan 2016-10-17 0','2016-10-17',NULL,110000.00,'Sales',2,'2016-10-17 14:52:55','2016-10-18 03:31:42'),(2,'TR201610180838441','Penjualan 2016-10-18 0','2016-10-18',NULL,1240000.00,'Sales',2,'2016-10-18 01:38:44','2016-10-18 01:40:06'),(3,'TR201610181031482','Penjualan 2016-10-18 1','2016-10-18',NULL,50000.00,'Sales',2,'2016-10-18 03:31:48','2016-10-18 03:32:56'),(4,'TR201610181035123','Penjualan 2016-10-18 2','2016-10-18',NULL,50000.00,'Sales',2,'2016-10-18 03:35:12','2016-10-18 03:50:44'),(5,'TR201610181050564','Penjualan 2016-10-18 3','2016-10-18',NULL,100000.00,'Sales',2,'2016-10-18 03:50:56','2016-10-18 03:51:29'),(6,'TR201610181054005','Penjualan 2016-10-18 4','2016-10-18',NULL,70000.00,'Sales',2,'2016-10-18 03:54:00','2016-10-18 03:54:20'),(7,'TR201610181101266','Penjualan 2016-10-18 5','2016-10-18',NULL,85000.00,'Sales',2,'2016-10-18 04:01:26','2016-10-18 04:01:42'),(8,'TR201610181102437','Penjualan 2016-10-18 6','2016-10-18',NULL,105000.00,'Sales',2,'2016-10-18 04:02:43','2016-10-18 04:07:46'),(9,'TR201610181108278','Penjualan 2016-10-18 7','2016-10-18',NULL,115000.00,'Sales',2,'2016-10-18 04:08:27','2016-10-18 04:08:44'),(10,'TR201610181109069','Penjualan 2016-10-18 8','2016-10-18',NULL,40000.00,'Sales',2,'2016-10-18 04:09:06','2016-10-18 04:09:21'),(11,'TR2016101811100910','Penjualan 2016-10-18 9','2016-10-18',NULL,90000.00,'Sales',2,'2016-10-18 04:10:09','2016-10-18 04:10:38'),(13,'TR2016101803314611','Penjualan 2016-10-18 10','2016-10-18',NULL,90000.00,'Sales',2,'2016-10-18 08:31:46','2016-10-18 08:36:13'),(16,'TR2016101803505912','Penjualan 2016-10-18 11','2016-10-18',NULL,0.00,'Sales',2,'2016-10-18 08:50:59','2016-10-18 08:50:59');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin','$2y$10$KCnznXmnX.SMtYw3qnAEtOisQlzmZZHWEe7NJiE2b5k3uzSKDub2u',NULL,'2016-10-17 14:49:48','2016-10-17 14:49:48','admin'),(2,'Kasir','kasir','$2y$10$qCrSgnah37GF6ow5EpeaJO1eI7QAvCsX.7vtQFXkoB65FhDShtqQC',NULL,'2016-10-17 14:49:49','2016-10-17 14:49:49','kasir'),(3,'Waiter','waiter','$2y$10$QTRD2Sv1iO4JMUj0IY8GJuV6xqGpj2GUblHOu28FK1Rh.e8zY7Pha',NULL,'2016-10-17 14:49:49','2016-10-17 14:49:49','kasir'),(4,'Manager','manager','$2y$10$pXZKfTXzSBEcwkbK.B08fOb/VcRiJtrraMrGiPLsNOZ0zKmzqZoi6',NULL,'2016-10-17 14:49:50','2016-10-17 14:49:50','kasir');
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

-- Dump completed on 2016-10-18 18:40:15
