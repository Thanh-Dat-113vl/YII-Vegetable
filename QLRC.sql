-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.17-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for QLRC
CREATE DATABASE IF NOT EXISTS `QLRC` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `QLRC`;

-- Dumping structure for table QLRC.banner
CREATE TABLE IF NOT EXISTS `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table QLRC.banner: ~0 rows (approximately)

-- Dumping structure for table QLRC.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk_category_user` (`created_by`),
  CONSTRAINT `fk_category_user` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table QLRC.category: ~4 rows (approximately)
INSERT INTO `category` (`id`, `name`, `slug`, `created_at`, `updated_at`, `status`, `created_by`) VALUES
	(1, 'Rau', 'Rau', '2025-09-12 00:54:37', '2025-09-16 04:06:00', 1, 4),
	(2, 'Củ', 'Củ', '2025-09-12 00:55:58', '2025-09-12 00:55:58', 1, 4),
	(4, 'Đạt Cao', 'Đạt-cao', '2025-09-12 03:38:24', '2025-09-12 03:38:24', 1, 4),
	(6, 'Rau muốn', 'rau-muốn', '2025-09-12 09:01:21', '2025-09-12 09:01:21', 1, 4);

-- Dumping structure for table QLRC.migration
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table QLRC.migration: ~4 rows (approximately)
INSERT INTO `migration` (`version`, `apply_time`) VALUES
	('m000000_000000_base', 1755912293),
	('m250823_012519_create_user_table', 1755912328),
	('m250823_040331_create_banner_table', 1755921860),
	('m250823_055729_create_user_table', 1755928715);

-- Dumping structure for table QLRC.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','confirmed','shipping','completed','cancelled') DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `shipping_address` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table QLRC.orders: ~0 rows (approximately)

-- Dumping structure for table QLRC.order_item
CREATE TABLE IF NOT EXISTS `order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table QLRC.order_item: ~0 rows (approximately)

-- Dumping structure for table QLRC.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk_product_created_by` (`created_by`),
  KEY `fk_product_category` (`category_id`),
  CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_product_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table QLRC.product: ~0 rows (approximately)

-- Dumping structure for table QLRC.review
CREATE TABLE IF NOT EXISTS `review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `comment` text,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `review_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table QLRC.review: ~0 rows (approximately)

-- Dumping structure for table QLRC.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'customer',
  `phone` varchar(20) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- Dumping data for table QLRC.user: ~11 rows (approximately)
INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `role`, `phone`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
	(4, 'admin', '05sKvh0FgXfpab3e6AQidglLR_EDTpor', '$2y$13$DBkvZCgKxNEDN08PF4/D1.m3PjMKc5Pc0WHnCP2ToE5Mdt8pal0rO', NULL, 'caothanh113vl1@gmail.com', '0', NULL, 10, '2025-08-27 09:49:01', '2025-08-27 09:49:01', 'HpTXE9amuFfuEAMKYTVpEXv4ZGH_k1oX_1756288141'),
	(6, 'dat', 'OyVUBZfxcQVNlo2akZFRW1RE8ysloCwN', '$2y$13$pe8XQ4qHU035U93wfqrzJOVSwhhxKcinddC9O85/IARywxi.r2Vga', NULL, 'caothanhdat113vl@gmail.com', '2', NULL, 1, '2025-09-17 08:05:25', '2025-09-20 07:14:18', NULL),
	(7, 'dat1', 'R6bPctojjAlsb8qiPqsFlXQXTdtiW2yA', '$2y$13$P5L7L7DqC4mgZDmq5N93jufSBVn2Wvyu1lBDexgrAHt3a0xkwWG/e', NULL, 'caothanh113vl@gmail.com', '1', NULL, 1, '2025-09-17 08:06:05', '2025-09-20 07:16:03', NULL),
	(8, 'test', '3IiHNkrgbPGBDMZOaJa2Jco4mjdiDNJo', '$2y$13$GIJ6zQVV1xizuXGxXuOgBuJzauj9KAAE2SFYvmUU1wdHfXePxeK5O', NULL, 'test@gmail.com', '0', NULL, 1, '2025-09-17 08:45:38', '2025-09-17 08:45:38', NULL),
	(9, '3', 'l_yWJNdIrnwEhrbVt9oUONHRH_eD15LY', '$2y$13$KE3GNjtISdiS0ebYNvWKEerpVmZzdGz1I1ZFFj5wtwXy1Bne3DfQ6', NULL, 'test1@gmail.com', '0', NULL, 1, '2025-09-20 04:24:11', '2025-09-20 04:24:11', NULL),
	(10, '1', 'CSa5gCkgijIoP-H5dBmXk1HQH3hBit1T', '$2y$13$jLrD38ZOizZEo8LiZhPZFez9JqEqJvyrDP69oHe/65mOvH8/cfuxS', NULL, 'test2@gmail.com', '0', NULL, 1, '2025-09-20 04:24:43', '2025-09-20 04:24:43', NULL),
	(11, '4', 'Ii6tFU4VdNT-DAXqwRc40CtrLRF6UFVm', '$2y$13$Ixed3TKNZlyFrT7hri6J4OyfjTg.hH9.qqq3kTUXi6o22XJmth1/C', NULL, 'test4@gmail.com', '0', NULL, 1, '2025-09-20 04:24:58', '2025-09-20 04:24:58', NULL),
	(17, '5', 'l_yWJNdIrnwEhrbVt9oUONHRH_eD15LY', '$2y$13$KE3GNjtISdiS0ebYNvWKEerpVmZzdGz1I1ZFFj5wtwXy1Bne3DfQ6', NULL, 'test5@gmail.com', '0', NULL, 1, '2025-09-20 04:24:11', '2025-09-20 04:24:11', NULL),
	(18, '6', 'Ii6tFU4VdNT-DAXqwRc40CtrLRF6UFVm', '$2y$13$Ixed3TKNZlyFrT7hri6J4OyfjTg.hH9.qqq3kTUXi6o22XJmth1/C', NULL, 'test6@gmail.com', '0', NULL, 1, '2025-09-20 04:24:58', '2025-09-20 04:24:58', NULL),
	(19, '7', 'Ii6tFU4VdNT-DAXqwRc40CtrLRF6UFVm', '$2y$13$Ixed3TKNZlyFrT7hri6J4OyfjTg.hH9.qqq3kTUXi6o22XJmth1/C', NULL, 'test7@gmail.com', '0', NULL, 1, '2025-09-20 04:24:58', '2025-09-20 04:24:58', NULL),
	(20, '8', 'Ii6tFU4VdNT-DAXqwRc40CtrLRF6UFVm', '$2y$13$Ixed3TKNZlyFrT7hri6J4OyfjTg.hH9.qqq3kTUXi6o22XJmth1/C', NULL, 'test8@gmail.com', '0', NULL, 1, '2025-09-20 04:24:58', '2025-09-20 04:24:58', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
