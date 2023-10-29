-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for goodsone-api
CREATE DATABASE IF NOT EXISTS `goodsone-v2` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `goodsone-v2`;

-- Dumping structure for table goodsone-api.activity_log
CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint unsigned DEFAULT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint unsigned DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `properties` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_log_log_name_index` (`log_name`)
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.activity_log: ~0 rows (approximately)
INSERT INTO `activity_log` (`id`, `log_name`, `batch_uuid`, `event`, `subject_id`, `subject_type`, `causer_id`, `causer_type`, `description`, `properties`, `created_at`, `updated_at`) VALUES
	(1, 'Employee Rank log', NULL, 'created', 6, 'App\\Models\\MasterData\\Level', 1, 'App\\Models\\User', 'Angela Sherly created employee level', '{"attributes":{"icon":null,"name":"Middle","from":501,"until":650,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 04:52:00', '2023-10-20 04:52:00'),
	(2, 'Employee Rank log', NULL, 'updated', 6, 'App\\Models\\MasterData\\Level', 1, 'App\\Models\\User', 'Angela Sherly updated employee level', '{"attributes":{"name":"jokowi","from":50,"until":100,"updated_by":1},"old":{"name":"Middle","from":501,"until":650,"updated_by":null}}', '2023-10-20 04:52:35', '2023-10-20 04:52:35'),
	(3, 'Employee Rank log', NULL, 'updated', 6, 'App\\Models\\MasterData\\Level', 1, 'App\\Models\\User', 'Angela Sherly updated employee level', '{"attributes":{"name":"Superstar","from":301,"until":500},"old":{"name":"jokowi","from":50,"until":100}}', '2023-10-20 04:57:36', '2023-10-20 04:57:36'),
	(4, 'Vendor Membership log', NULL, 'created', 7, 'App\\Models\\MasterData\\Membership', 1, 'App\\Models\\User', 'Angela Sherly created membership', '{"attributes":{"name":"jokowi","image":"membership_198249_Screenshot_2023-10-19_095607.png","from":50,"until":100,"point":1000,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 05:02:10', '2023-10-20 05:02:10'),
	(5, 'Vendor Membership log', NULL, 'updated', 7, 'App\\Models\\MasterData\\Membership', 1, 'App\\Models\\User', 'Angela Sherly updated membership', '{"attributes":{"name":"MAXX","updated_by":1},"old":{"name":"jokowi","updated_by":null}}', '2023-10-20 05:03:00', '2023-10-20 05:03:00'),
	(6, 'Vendor Membership log', NULL, 'deleted', 7, 'App\\Models\\MasterData\\Membership', 1, 'App\\Models\\User', 'Angela Sherly deleted membership', '{"old":{"name":"MAXX","image":"membership_198249_Screenshot_2023-10-19_095607.png","from":50,"until":100,"point":1000,"created_by":1,"updated_by":1,"deleted_by":null}}', '2023-10-20 05:03:27', '2023-10-20 05:03:27'),
	(7, 'Vendor Membership log', NULL, 'updated', 7, 'App\\Models\\MasterData\\Membership', 1, 'App\\Models\\User', 'Angela Sherly updated membership', '{"attributes":{"deleted_by":1},"old":{"deleted_by":null}}', '2023-10-20 05:03:27', '2023-10-20 05:03:27'),
	(8, 'Benefit log', NULL, 'created', 1, 'App\\Models\\MasterData\\Benefit', 1, 'App\\Models\\User', 'Angela Sherly created benefit', '{"attributes":{"image":"benefit_605694_delivery.png","name":"Gratis Ongkir Jabodetabek","is_publish":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 05:31:11', '2023-10-20 05:31:11'),
	(9, 'Benefit log', NULL, 'created', 2, 'App\\Models\\MasterData\\Benefit', 1, 'App\\Models\\User', 'Angela Sherly created benefit', '{"attributes":{"image":"benefit_690621_point-earned.png","name":"Earn & Exchange G Points","is_publish":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 05:32:02', '2023-10-20 05:32:02'),
	(10, 'Benefit log', NULL, 'created', 3, 'App\\Models\\MasterData\\Benefit', 1, 'App\\Models\\User', 'Angela Sherly created benefit', '{"attributes":{"image":"benefit_609419_cs.png","name":"Priority Customer Service","is_publish":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 05:32:39', '2023-10-20 05:32:39'),
	(11, 'Benefit log', NULL, 'created', 4, 'App\\Models\\MasterData\\Benefit', 1, 'App\\Models\\User', 'Angela Sherly created benefit', '{"attributes":{"image":"benefit_448957_voucher.png","name":"Promo Voucher 100k","is_publish":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 05:32:59', '2023-10-20 05:32:59'),
	(12, 'Benefit log', NULL, 'created', 5, 'App\\Models\\MasterData\\Benefit', 1, 'App\\Models\\User', 'Angela Sherly created benefit', '{"attributes":{"image":"benefit_996573_extra-point.png","name":"Extra +1 G Points Every Transaction","is_publish":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 05:34:54', '2023-10-20 05:34:54'),
	(13, 'Benefit log', NULL, 'updated', 5, 'App\\Models\\MasterData\\Benefit', 1, 'App\\Models\\User', 'Angela Sherly updated benefit', '{"attributes":{"name":"Extra +2 G Points Every Transaction","updated_by":1},"old":{"name":"Extra +1 G Points Every Transaction","updated_by":null}}', '2023-10-20 05:44:50', '2023-10-20 05:44:50'),
	(14, 'Benefit log', NULL, 'updated', 5, 'App\\Models\\MasterData\\Benefit', 1, 'App\\Models\\User', 'Angela Sherly updated benefit', '{"attributes":{"name":"Extra +1 G Points Every Transaction","is_publish":0},"old":{"name":"Extra +2 G Points Every Transaction","is_publish":1}}', '2023-10-20 05:45:11', '2023-10-20 05:45:11'),
	(15, 'Benefit log', NULL, 'updated', 5, 'App\\Models\\MasterData\\Benefit', 1, 'App\\Models\\User', 'Angela Sherly updated benefit', '{"attributes":{"is_publish":1},"old":{"is_publish":0}}', '2023-10-20 05:45:39', '2023-10-20 05:45:39'),
	(16, 'Benefit log', NULL, 'created', 6, 'App\\Models\\MasterData\\Benefit', 1, 'App\\Models\\User', 'Angela Sherly created benefit', '{"attributes":{"image":"benefit_307201_extra-point.png","name":"Extra +2 G Points Every Transaction","is_publish":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 05:46:17', '2023-10-20 05:46:17'),
	(17, 'Benefit log', NULL, 'created', 7, 'App\\Models\\MasterData\\Benefit', 1, 'App\\Models\\User', 'Angela Sherly created benefit', '{"attributes":{"image":"benefit_667695_extra-point.png","name":"Extra +3 G Points Every Transaction","is_publish":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 05:46:28', '2023-10-20 05:46:28'),
	(18, 'Benefit log', NULL, 'created', 8, 'App\\Models\\MasterData\\Benefit', 1, 'App\\Models\\User', 'Angela Sherly created benefit', '{"attributes":{"image":"benefit_758597_extra-point.png","name":"Extra +5 G Points Every Transaction","is_publish":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 05:46:41', '2023-10-20 05:46:41'),
	(19, 'Benefit log', NULL, 'created', 9, 'App\\Models\\MasterData\\Benefit', 1, 'App\\Models\\User', 'Angela Sherly created benefit', '{"attributes":{"image":"benefit_441670_extra-point.png","name":"Extra +10 G Points Every Transaction","is_publish":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 05:46:51', '2023-10-20 05:46:51'),
	(20, 'Benefit log', NULL, 'created', 10, 'App\\Models\\MasterData\\Benefit', 1, 'App\\Models\\User', 'Angela Sherly created benefit', '{"attributes":{"image":"benefit_132367_extra-point.png","name":"apa aja","is_publish":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 05:47:55', '2023-10-20 05:47:55'),
	(21, 'Benefit log', NULL, 'deleted', 10, 'App\\Models\\MasterData\\Benefit', 1, 'App\\Models\\User', 'Angela Sherly deleted benefit', '{"old":{"image":"benefit_132367_extra-point.png","name":"apa aja","is_publish":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 05:48:16', '2023-10-20 05:48:16'),
	(22, 'Benefit log', NULL, 'updated', 10, 'App\\Models\\MasterData\\Benefit', 1, 'App\\Models\\User', 'Angela Sherly updated benefit', '{"attributes":{"updated_by":1,"deleted_by":1},"old":{"updated_by":null,"deleted_by":null}}', '2023-10-20 05:48:16', '2023-10-20 05:48:16'),
	(23, 'User Angela Sherly show data vendor', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly show data vendor', '"127.0.0.1"', '2023-10-20 05:54:06', '2023-10-20 05:54:06'),
	(24, 'Master Vehicle log', NULL, 'created', 1, 'App\\Models\\MasterData\\Vehicle', 1, 'App\\Models\\User', 'Angela Sherly created vehicle', '{"attributes":{"model_name":"GRAND MAXX 2014","plate_number":"B 8009 BVI","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 05:58:08', '2023-10-20 05:58:08'),
	(25, 'Master Vehicle log', NULL, 'created', 2, 'App\\Models\\MasterData\\Vehicle', 1, 'App\\Models\\User', 'Angela Sherly created vehicle', '{"attributes":{"model_name":"TOYOTA AVANZA 2018","plate_number":"B 7956 YUG","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 05:58:55', '2023-10-20 05:58:55'),
	(26, 'Master Vehicle log', NULL, 'created', 3, 'App\\Models\\MasterData\\Vehicle', 1, 'App\\Models\\User', 'Angela Sherly created vehicle', '{"attributes":{"model_name":"HONDA JAZZ 2017","plate_number":"B 8976 CFG","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 05:59:35', '2023-10-20 05:59:35'),
	(27, 'Master Vehicle log', NULL, 'updated', 3, 'App\\Models\\MasterData\\Vehicle', 1, 'App\\Models\\User', 'Angela Sherly updated vehicle', '{"attributes":{"model_name":"HONDA JAZZ PUTIH 2015","plate_number":"B 8976 NBA","updated_by":1},"old":{"model_name":"HONDA JAZZ 2017","plate_number":"B 8976 CFG","updated_by":null}}', '2023-10-20 06:00:02', '2023-10-20 06:00:02'),
	(28, 'Product Category log', NULL, 'created', 16, 'App\\Models\\MasterData\\ProductCategory', 1, 'App\\Models\\User', 'Angela Sherly created product category', '{"attributes":{"name":"Test","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:04:41', '2023-10-20 06:04:41'),
	(29, 'Product Category log', NULL, 'updated', 16, 'App\\Models\\MasterData\\ProductCategory', 1, 'App\\Models\\User', 'Angela Sherly updated product category', '{"attributes":{"name":"test2","updated_by":1},"old":{"name":"Test","updated_by":null}}', '2023-10-20 06:05:05', '2023-10-20 06:05:05'),
	(30, 'Product Category log', NULL, 'deleted', 16, 'App\\Models\\MasterData\\ProductCategory', 1, 'App\\Models\\User', 'Angela Sherly deleted product category', '{"old":{"name":"test2","created_by":1,"updated_by":1,"deleted_by":null}}', '2023-10-20 06:05:28', '2023-10-20 06:05:28'),
	(31, 'Product Category log', NULL, 'updated', 16, 'App\\Models\\MasterData\\ProductCategory', 1, 'App\\Models\\User', 'Angela Sherly updated product category', '{"attributes":{"deleted_by":1},"old":{"deleted_by":null}}', '2023-10-20 06:05:28', '2023-10-20 06:05:28'),
	(32, 'Product Attribute log', NULL, 'created', 1, 'App\\Models\\MasterData\\ProductAttribute', 1, 'App\\Models\\User', 'Angela Sherly created product attribute', '{"attributes":{"product_category_id":1,"name":"Warna","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:06:58', '2023-10-20 06:06:58'),
	(33, 'Product Attribute log', NULL, 'created', 2, 'App\\Models\\MasterData\\ProductAttribute', 1, 'App\\Models\\User', 'Angela Sherly created product attribute', '{"attributes":{"product_category_id":2,"name":"Bunga","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:07:21', '2023-10-20 06:07:21'),
	(34, 'Product Attribute log', NULL, 'created', 3, 'App\\Models\\MasterData\\ProductAttribute', 1, 'App\\Models\\User', 'Angela Sherly created product attribute', '{"attributes":{"product_category_id":2,"name":"Pernak Pernik","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:07:30', '2023-10-20 06:07:30'),
	(35, 'Product Attribute log', NULL, 'created', 4, 'App\\Models\\MasterData\\ProductAttribute', 1, 'App\\Models\\User', 'Angela Sherly created product attribute', '{"attributes":{"product_category_id":2,"name":"Size","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:07:39', '2023-10-20 06:07:39'),
	(36, 'Product Attribute log', NULL, 'created', 5, 'App\\Models\\MasterData\\ProductAttribute', 1, 'App\\Models\\User', 'Angela Sherly created product attribute', '{"attributes":{"product_category_id":3,"name":"Bunga","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:08:00', '2023-10-20 06:08:00'),
	(37, 'Product Attribute log', NULL, 'created', 6, 'App\\Models\\MasterData\\ProductAttribute', 1, 'App\\Models\\User', 'Angela Sherly created product attribute', '{"attributes":{"product_category_id":4,"name":"Requested","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:08:25', '2023-10-20 06:08:25'),
	(38, 'Product Attribute log', NULL, 'created', 7, 'App\\Models\\MasterData\\ProductAttribute', 1, 'App\\Models\\User', 'Angela Sherly created product attribute', '{"attributes":{"product_category_id":5,"name":"Gate","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:08:47', '2023-10-20 06:08:47'),
	(39, 'Product Attribute log', NULL, 'created', 8, 'App\\Models\\MasterData\\ProductAttribute', 1, 'App\\Models\\User', 'Angela Sherly created product attribute', '{"attributes":{"product_category_id":5,"name":"Kaki","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:08:58', '2023-10-20 06:08:58'),
	(40, 'Product Attribute log', NULL, 'created', 9, 'App\\Models\\MasterData\\ProductAttribute', 1, 'App\\Models\\User', 'Angela Sherly created product attribute', '{"attributes":{"product_category_id":6,"name":"Bunga","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:09:30', '2023-10-20 06:09:30'),
	(41, 'Product Attribute log', NULL, 'created', 10, 'App\\Models\\MasterData\\ProductAttribute', 1, 'App\\Models\\User', 'Angela Sherly created product attribute', '{"attributes":{"product_category_id":6,"name":"Finishing Bunga","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:09:39', '2023-10-20 06:09:39'),
	(42, 'Product Attribute log', NULL, 'created', 11, 'App\\Models\\MasterData\\ProductAttribute', 1, 'App\\Models\\User', 'Angela Sherly created product attribute', '{"attributes":{"product_category_id":6,"name":"Pernak Pernik","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:09:50', '2023-10-20 06:09:50'),
	(43, 'Product Attribute log', NULL, 'created', 12, 'App\\Models\\MasterData\\ProductAttribute', 1, 'App\\Models\\User', 'Angela Sherly created product attribute', '{"attributes":{"product_category_id":6,"name":"Size","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:09:56', '2023-10-20 06:09:56'),
	(44, 'Product Attribute log', NULL, 'created', 13, 'App\\Models\\MasterData\\ProductAttribute', 1, 'App\\Models\\User', 'Angela Sherly created product attribute', '{"attributes":{"product_category_id":6,"name":"Tiang Tenda 5 x 5","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:10:08', '2023-10-20 06:10:08'),
	(45, 'Product Attribute log', NULL, 'updated', 7, 'App\\Models\\MasterData\\ProductAttribute', 1, 'App\\Models\\User', 'Angela Sherly updated product attribute', '{"attributes":{"name":"Bunga","updated_by":1},"old":{"name":"Gate","updated_by":null}}', '2023-10-20 06:11:09', '2023-10-20 06:11:09'),
	(46, 'Product Variant log', NULL, 'created', 1, 'App\\Models\\MasterData\\ProductVariant', 1, 'App\\Models\\User', 'Angela Sherly created product variant', '{"attributes":{"product_attribute_id":1,"attribute_id":null,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:19:02', '2023-10-20 06:19:02'),
	(47, 'Product Variant log', NULL, 'created', 2, 'App\\Models\\MasterData\\ProductVariant', 1, 'App\\Models\\User', 'Angela Sherly created product variant', '{"attributes":{"product_attribute_id":1,"attribute_id":null,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:19:17', '2023-10-20 06:19:17'),
	(48, 'Product Variant log', NULL, 'created', 3, 'App\\Models\\MasterData\\ProductVariant', 1, 'App\\Models\\User', 'Angela Sherly created product variant', '{"attributes":{"product_attribute_id":1,"attribute_id":null,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:19:23', '2023-10-20 06:19:23'),
	(49, 'Product Variant log', NULL, 'created', 4, 'App\\Models\\MasterData\\ProductVariant', 1, 'App\\Models\\User', 'Angela Sherly created product variant', '{"attributes":{"product_attribute_id":1,"attribute_id":null,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:19:32', '2023-10-20 06:19:32'),
	(50, 'Product Variant log', NULL, 'created', 5, 'App\\Models\\MasterData\\ProductVariant', 1, 'App\\Models\\User', 'Angela Sherly created product variant', '{"attributes":{"product_attribute_id":1,"attribute_id":null,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:19:38', '2023-10-20 06:19:38'),
	(51, 'Product Variant log', NULL, 'created', 6, 'App\\Models\\MasterData\\ProductVariant', 1, 'App\\Models\\User', 'Angela Sherly created product variant', '{"attributes":{"product_attribute_id":1,"attribute_id":null,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:19:48', '2023-10-20 06:19:48'),
	(52, 'Product Variant log', NULL, 'created', 7, 'App\\Models\\MasterData\\ProductVariant', 1, 'App\\Models\\User', 'Angela Sherly created product variant', '{"attributes":{"product_attribute_id":2,"attribute_id":null,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:20:32', '2023-10-20 06:20:32'),
	(53, 'Product Variant log', NULL, 'created', 8, 'App\\Models\\MasterData\\ProductVariant', 1, 'App\\Models\\User', 'Angela Sherly created product variant', '{"attributes":{"product_attribute_id":2,"attribute_id":null,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:20:44', '2023-10-20 06:20:44'),
	(54, 'Product Variant log', NULL, 'created', 9, 'App\\Models\\MasterData\\ProductVariant', 1, 'App\\Models\\User', 'Angela Sherly created product variant', '{"attributes":{"product_attribute_id":2,"attribute_id":null,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:21:03', '2023-10-20 06:21:03'),
	(55, 'Product Variant log', NULL, 'created', 10, 'App\\Models\\MasterData\\ProductVariant', 1, 'App\\Models\\User', 'Angela Sherly created product variant', '{"attributes":{"product_attribute_id":2,"attribute_id":null,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:21:15', '2023-10-20 06:21:15'),
	(56, 'Product Variant log', NULL, 'created', 11, 'App\\Models\\MasterData\\ProductVariant', 1, 'App\\Models\\User', 'Angela Sherly created product variant', '{"attributes":{"product_attribute_id":2,"attribute_id":null,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:21:25', '2023-10-20 06:21:25'),
	(57, 'Product Variant log', NULL, 'created', 12, 'App\\Models\\MasterData\\ProductVariant', 1, 'App\\Models\\User', 'Angela Sherly created product variant', '{"attributes":{"product_attribute_id":3,"attribute_id":null,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:21:59', '2023-10-20 06:21:59'),
	(58, 'Product Variant log', NULL, 'created', 13, 'App\\Models\\MasterData\\ProductVariant', 1, 'App\\Models\\User', 'Angela Sherly created product variant', '{"attributes":{"product_attribute_id":3,"attribute_id":null,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:22:08', '2023-10-20 06:22:08'),
	(59, 'Product Variant log', NULL, 'created', 14, 'App\\Models\\MasterData\\ProductVariant', 1, 'App\\Models\\User', 'Angela Sherly created product variant', '{"attributes":{"product_attribute_id":4,"attribute_id":null,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:22:41', '2023-10-20 06:22:41'),
	(60, 'Product Variant log', NULL, 'created', 15, 'App\\Models\\MasterData\\ProductVariant', 1, 'App\\Models\\User', 'Angela Sherly created product variant', '{"attributes":{"product_attribute_id":4,"attribute_id":null,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:22:47', '2023-10-20 06:22:47'),
	(61, 'Product Variant log', NULL, 'created', 16, 'App\\Models\\MasterData\\ProductVariant', 1, 'App\\Models\\User', 'Angela Sherly created product variant', '{"attributes":{"product_attribute_id":4,"attribute_id":null,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:22:55', '2023-10-20 06:22:55'),
	(62, 'Product Variant log', NULL, 'updated', 16, 'App\\Models\\MasterData\\ProductVariant', 1, 'App\\Models\\User', 'Angela Sherly updated product variant', '{"attributes":{"updated_by":1},"old":{"updated_by":null}}', '2023-10-20 06:23:46', '2023-10-20 06:23:46'),
	(63, 'Master Department log', NULL, 'created', 3, 'App\\Models\\MasterData\\Department', 1, 'App\\Models\\User', 'Angela Sherly created departement', '{"attributes":{"name":"Warehouse","payroll_type":"1","is_has_schedule":0,"clock_in":"12:00:00","clock_out":"20:00:00","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:28:01', '2023-10-20 06:28:01'),
	(64, 'Master Department log', NULL, 'updated', 3, 'App\\Models\\MasterData\\Department', 1, 'App\\Models\\User', 'Angela Sherly updated departement', '{"attributes":{"name":"Marketing","clock_in":"00:00:00","clock_out":"01:00:00","updated_by":1},"old":{"name":"Warehouse","clock_in":"12:00:00","clock_out":"20:00:00","updated_by":null}}', '2023-10-20 06:29:33', '2023-10-20 06:29:33'),
	(65, 'Master Department log', NULL, 'updated', 3, 'App\\Models\\MasterData\\Department', 1, 'App\\Models\\User', 'Angela Sherly updated departement', '{"attributes":{"name":"Warehouse","clock_in":null,"clock_out":null},"old":{"name":"Marketing","clock_in":"00:00:00","clock_out":"00:00:00"}}', '2023-10-20 06:30:29', '2023-10-20 06:30:29'),
	(66, 'Master Department log', NULL, 'deleted', 3, 'App\\Models\\MasterData\\Department', 1, 'App\\Models\\User', 'Angela Sherly deleted departement', '{"old":{"name":"Warehouse","payroll_type":"1","is_has_schedule":0,"clock_in":null,"clock_out":null,"created_by":1,"updated_by":1,"deleted_by":null}}', '2023-10-20 06:30:48', '2023-10-20 06:30:48'),
	(67, 'Master Department log', NULL, 'updated', 3, 'App\\Models\\MasterData\\Department', 1, 'App\\Models\\User', 'Angela Sherly updated departement', '{"attributes":{"deleted_by":1},"old":{"deleted_by":null}}', '2023-10-20 06:30:48', '2023-10-20 06:30:48'),
	(68, 'Master Position log', NULL, 'created', 1, 'App\\Models\\MasterData\\Position', 1, 'App\\Models\\User', 'Angela Sherly created position', '{"attributes":{"name":"Coordinator","career_level_id":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:34:32', '2023-10-20 06:34:32'),
	(69, 'Master Position log', NULL, 'created', 2, 'App\\Models\\MasterData\\Position', 1, 'App\\Models\\User', 'Angela Sherly created position', '{"attributes":{"name":"PIC","career_level_id":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:34:59', '2023-10-20 06:34:59'),
	(70, 'Master Position log', NULL, 'created', 3, 'App\\Models\\MasterData\\Position', 1, 'App\\Models\\User', 'Angela Sherly created position', '{"attributes":{"name":"Tukang","career_level_id":3,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:35:17', '2023-10-20 06:35:17'),
	(71, 'Master Position log', NULL, 'created', 4, 'App\\Models\\MasterData\\Position', 1, 'App\\Models\\User', 'Angela Sherly created position', '{"attributes":{"name":"Asisten Tukang","career_level_id":3,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:35:39', '2023-10-20 06:35:39'),
	(72, 'Master Position log', NULL, 'created', 5, 'App\\Models\\MasterData\\Position', 1, 'App\\Models\\User', 'Angela Sherly created position', '{"attributes":{"name":"OB","career_level_id":3,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 06:36:01', '2023-10-20 06:36:01'),
	(73, 'Master Position log', NULL, 'updated', 5, 'App\\Models\\MasterData\\Position', 1, 'App\\Models\\User', 'Angela Sherly updated position', '{"attributes":{"name":"Office Boy","updated_by":1},"old":{"name":"OB","updated_by":null}}', '2023-10-20 06:36:36', '2023-10-20 06:36:36'),
	(74, 'Master Position log', NULL, 'updated', 5, 'App\\Models\\MasterData\\Position', 1, 'App\\Models\\User', 'Angela Sherly updated position', '{"attributes":{"career_level_id":2},"old":{"career_level_id":3}}', '2023-10-20 06:36:48', '2023-10-20 06:36:48'),
	(75, 'Master Position log', NULL, 'updated', 5, 'App\\Models\\MasterData\\Position', 1, 'App\\Models\\User', 'Angela Sherly updated position', '{"attributes":{"career_level_id":3},"old":{"career_level_id":2}}', '2023-10-20 06:37:01', '2023-10-20 06:37:01'),
	(76, 'Master Position log', NULL, 'deleted', 5, 'App\\Models\\MasterData\\Position', 1, 'App\\Models\\User', 'Angela Sherly deleted position', '{"old":{"name":"Office Boy","career_level_id":3,"created_by":1,"updated_by":1,"deleted_by":null}}', '2023-10-20 06:37:16', '2023-10-20 06:37:16'),
	(77, 'Master Position log', NULL, 'updated', 5, 'App\\Models\\MasterData\\Position', 1, 'App\\Models\\User', 'Angela Sherly updated position', '{"attributes":{"deleted_by":1},"old":{"deleted_by":null}}', '2023-10-20 06:37:16', '2023-10-20 06:37:16'),
	(78, 'User Angela Sherly show data Employee', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly show data Employee', '"127.0.0.1"', '2023-10-20 06:40:04', '2023-10-20 06:40:04'),
	(79, 'default', NULL, 'created', 1, 'App\\Models\\MasterData\\Employee', 1, 'App\\Models\\User', 'created', '{"attributes":{"department_id":1,"position_id":1,"level_id":1,"photo":null,"fullname":"Alfonsius Gideon","employee_number":"A0001","phone_number":null,"email":"alfonsiusgideon@gmail.com","email_verified_at":null,"otp":null,"otp_verified_at":null,"reset_token":null,"notification_token":null,"dateofbirth":"1997-11-09","gender":"2","ktp_img":null,"vaccine_img":null,"salary":3000000,"loan_limit":5000000,"active_loan_limit":5000000,"points":0,"is_active":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 07:24:22', '2023-10-20 07:24:22'),
	(80, 'User Angela Sherly create data Employee', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly create data Employee', '"127.0.0.1"', '2023-10-20 07:24:22', '2023-10-20 07:24:22'),
	(81, 'default', NULL, 'created', 2, 'App\\Models\\MasterData\\Employee', 1, 'App\\Models\\User', 'created', '{"attributes":{"department_id":1,"position_id":1,"level_id":1,"photo":null,"fullname":"Aprillia Dessire","employee_number":"A0002","phone_number":null,"email":"aiprilliadesssire@gmail.com","email_verified_at":null,"otp":null,"otp_verified_at":null,"reset_token":null,"notification_token":null,"dateofbirth":"1997-11-09","gender":"1","ktp_img":null,"vaccine_img":null,"salary":3000000,"loan_limit":5000000,"active_loan_limit":5000000,"points":0,"is_active":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 07:27:14', '2023-10-20 07:27:14'),
	(82, 'User Angela Sherly create data Employee', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly create data Employee', '"127.0.0.1"', '2023-10-20 07:27:14', '2023-10-20 07:27:14'),
	(83, 'default', NULL, 'created', 3, 'App\\Models\\MasterData\\Employee', 1, 'App\\Models\\User', 'created', '{"attributes":{"department_id":1,"position_id":1,"level_id":1,"photo":null,"fullname":"Devi Sartika","employee_number":"A0003","phone_number":null,"email":"devisartikagoodsoneid@gmail.com","email_verified_at":null,"otp":null,"otp_verified_at":null,"reset_token":null,"notification_token":null,"dateofbirth":"1997-12-06","gender":"1","ktp_img":null,"vaccine_img":null,"salary":3000000,"loan_limit":5000000,"active_loan_limit":5000000,"points":0,"is_active":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 07:27:59', '2023-10-20 07:27:59'),
	(84, 'User Angela Sherly create data Employee', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly create data Employee', '"127.0.0.1"', '2023-10-20 07:27:59', '2023-10-20 07:27:59'),
	(85, 'default', NULL, 'created', 4, 'App\\Models\\MasterData\\Employee', 1, 'App\\Models\\User', 'created', '{"attributes":{"department_id":1,"position_id":1,"level_id":1,"photo":null,"fullname":"Femi","employee_number":"A0004","phone_number":null,"email":"admin@mail.com","email_verified_at":null,"otp":null,"otp_verified_at":null,"reset_token":null,"notification_token":null,"dateofbirth":"2000-01-01","gender":"1","ktp_img":null,"vaccine_img":null,"salary":3000000,"loan_limit":5000000,"active_loan_limit":5000000,"points":0,"is_active":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 07:28:54', '2023-10-20 07:28:54'),
	(86, 'User Angela Sherly create data Employee', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly create data Employee', '"127.0.0.1"', '2023-10-20 07:28:54', '2023-10-20 07:28:54'),
	(87, 'default', NULL, 'created', 5, 'App\\Models\\MasterData\\Employee', 1, 'App\\Models\\User', 'created', '{"attributes":{"department_id":1,"position_id":1,"level_id":1,"photo":null,"fullname":"Funninsia","employee_number":"A0005","phone_number":null,"email":"funninsia31@gmail.com","email_verified_at":null,"otp":null,"otp_verified_at":null,"reset_token":null,"notification_token":null,"dateofbirth":"2004-03-31","gender":"1","ktp_img":null,"vaccine_img":null,"salary":3000000,"loan_limit":5000000,"active_loan_limit":5000000,"points":0,"is_active":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 07:29:41', '2023-10-20 07:29:41'),
	(88, 'User Angela Sherly create data Employee', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly create data Employee', '"127.0.0.1"', '2023-10-20 07:29:41', '2023-10-20 07:29:41'),
	(89, 'default', NULL, 'created', 6, 'App\\Models\\MasterData\\Employee', 1, 'App\\Models\\User', 'created', '{"attributes":{"department_id":1,"position_id":1,"level_id":1,"photo":null,"fullname":"Hilda","employee_number":"A0006","phone_number":null,"email":"hilda@gmail.com","email_verified_at":null,"otp":null,"otp_verified_at":null,"reset_token":null,"notification_token":null,"dateofbirth":"2004-03-31","gender":"1","ktp_img":null,"vaccine_img":null,"salary":3000000,"loan_limit":5000000,"active_loan_limit":5000000,"points":0,"is_active":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 07:30:30', '2023-10-20 07:30:30'),
	(90, 'User Angela Sherly create data Employee', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly create data Employee', '"127.0.0.1"', '2023-10-20 07:30:30', '2023-10-20 07:30:30'),
	(91, 'default', NULL, 'created', 7, 'App\\Models\\MasterData\\Employee', 1, 'App\\Models\\User', 'created', '{"attributes":{"department_id":1,"position_id":1,"level_id":1,"photo":null,"fullname":"Indah Syafitri","employee_number":"A0007","phone_number":null,"email":"syafitriindah97@gmail.com","email_verified_at":null,"otp":null,"otp_verified_at":null,"reset_token":null,"notification_token":null,"dateofbirth":"1997-04-07","gender":"1","ktp_img":null,"vaccine_img":null,"salary":3000000,"loan_limit":5000000,"active_loan_limit":5000000,"points":0,"is_active":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 07:31:04', '2023-10-20 07:31:04'),
	(92, 'User Angela Sherly create data Employee', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly create data Employee', '"127.0.0.1"', '2023-10-20 07:31:04', '2023-10-20 07:31:04'),
	(93, 'default', NULL, 'created', 8, 'App\\Models\\MasterData\\Employee', 1, 'App\\Models\\User', 'created', '{"attributes":{"department_id":2,"position_id":2,"level_id":1,"photo":null,"fullname":"Uri Ruri","employee_number":"A0007","phone_number":null,"email":"stiawanuri@gmail.com","email_verified_at":null,"otp":null,"otp_verified_at":null,"reset_token":null,"notification_token":null,"dateofbirth":"1994-08-02","gender":"2","ktp_img":null,"vaccine_img":null,"salary":0,"loan_limit":5000000,"active_loan_limit":5000000,"points":0,"is_active":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 07:32:10', '2023-10-20 07:32:10'),
	(94, 'User Angela Sherly create data Employee', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly create data Employee', '"127.0.0.1"', '2023-10-20 07:32:10', '2023-10-20 07:32:10'),
	(95, 'default', NULL, 'created', 9, 'App\\Models\\MasterData\\Employee', 1, 'App\\Models\\User', 'created', '{"attributes":{"department_id":2,"position_id":3,"level_id":1,"photo":null,"fullname":"Arif","employee_number":"A0007","phone_number":null,"email":"arif@gmail.com","email_verified_at":null,"otp":null,"otp_verified_at":null,"reset_token":null,"notification_token":null,"dateofbirth":"1994-08-02","gender":"2","ktp_img":null,"vaccine_img":null,"salary":0,"loan_limit":5000000,"active_loan_limit":5000000,"points":0,"is_active":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 07:33:00', '2023-10-20 07:33:00'),
	(96, 'User Angela Sherly create data Employee', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly create data Employee', '"127.0.0.1"', '2023-10-20 07:33:00', '2023-10-20 07:33:00'),
	(97, 'default', NULL, 'updated', 9, 'App\\Models\\MasterData\\Employee', 1, 'App\\Models\\User', 'updated', '{"attributes":{"department_id":2,"position_id":3,"level_id":1,"photo":null,"fullname":"Arif","employee_number":"A0009","phone_number":null,"email":"arif@gmail.com","email_verified_at":null,"otp":null,"otp_verified_at":null,"reset_token":null,"notification_token":null,"dateofbirth":"1990-01-15","gender":"2","ktp_img":null,"vaccine_img":null,"salary":null,"loan_limit":null,"active_loan_limit":null,"points":0,"is_active":0,"created_by":1,"updated_by":null,"deleted_by":null},"old":{"department_id":2,"position_id":3,"level_id":1,"photo":null,"fullname":"Arif","employee_number":"A0007","phone_number":null,"email":"arif@gmail.com","email_verified_at":null,"otp":null,"otp_verified_at":null,"reset_token":null,"notification_token":null,"dateofbirth":"1994-08-02","gender":"2","ktp_img":null,"vaccine_img":null,"salary":0,"loan_limit":5000000,"active_loan_limit":5000000,"points":0,"is_active":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 07:38:49', '2023-10-20 07:38:49'),
	(98, 'User Angela Sherly update data Employee', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly update data Employee', '"127.0.0.1"', '2023-10-20 07:38:49', '2023-10-20 07:38:49'),
	(99, 'default', NULL, 'updated', 9, 'App\\Models\\MasterData\\Employee', 1, 'App\\Models\\User', 'updated', '{"attributes":{"department_id":2,"position_id":3,"level_id":1,"photo":null,"fullname":"Arif","employee_number":"A0009","phone_number":null,"email":"arif@gmail.com","email_verified_at":null,"otp":null,"otp_verified_at":null,"reset_token":null,"notification_token":null,"dateofbirth":"1990-01-15","gender":"2","ktp_img":null,"vaccine_img":null,"salary":0,"loan_limit":5000000,"active_loan_limit":5000000,"points":0,"is_active":0,"created_by":1,"updated_by":null,"deleted_by":null},"old":{"department_id":2,"position_id":3,"level_id":1,"photo":null,"fullname":"Arif","employee_number":"A0009","phone_number":null,"email":"arif@gmail.com","email_verified_at":null,"otp":null,"otp_verified_at":null,"reset_token":null,"notification_token":null,"dateofbirth":"1990-01-15","gender":"2","ktp_img":null,"vaccine_img":null,"salary":null,"loan_limit":null,"active_loan_limit":null,"points":0,"is_active":0,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 07:39:55', '2023-10-20 07:39:55'),
	(100, 'User Angela Sherly update data Employee', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly update data Employee', '"127.0.0.1"', '2023-10-20 07:39:55', '2023-10-20 07:39:55'),
	(101, 'default', NULL, 'updated', 9, 'App\\Models\\MasterData\\Employee', 1, 'App\\Models\\User', 'updated', '{"attributes":{"department_id":2,"position_id":3,"level_id":1,"photo":null,"fullname":"Arif","employee_number":"A0009","phone_number":null,"email":"arif@gmail.com","email_verified_at":null,"otp":null,"otp_verified_at":null,"reset_token":null,"notification_token":null,"dateofbirth":"1990-01-15","gender":"2","ktp_img":null,"vaccine_img":null,"salary":0,"loan_limit":5000000,"active_loan_limit":5000000,"points":0,"is_active":1,"created_by":1,"updated_by":null,"deleted_by":null},"old":{"department_id":2,"position_id":3,"level_id":1,"photo":null,"fullname":"Arif","employee_number":"A0009","phone_number":null,"email":"arif@gmail.com","email_verified_at":null,"otp":null,"otp_verified_at":null,"reset_token":null,"notification_token":null,"dateofbirth":"1990-01-15","gender":"2","ktp_img":null,"vaccine_img":null,"salary":0,"loan_limit":5000000,"active_loan_limit":5000000,"points":0,"is_active":0,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 07:40:17', '2023-10-20 07:40:17'),
	(102, 'User Angela Sherly update data Employee', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly update data Employee', '"127.0.0.1"', '2023-10-20 07:40:17', '2023-10-20 07:40:17'),
	(103, 'User Angela Sherly show data Employee', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly show data Employee', '"127.0.0.1"', '2023-10-20 07:41:08', '2023-10-20 07:41:08'),
	(104, 'User Angela Sherly show data vendor', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly show data vendor', '"127.0.0.1"', '2023-10-20 07:43:24', '2023-10-20 07:43:24'),
	(105, 'default', NULL, 'created', 1, 'App\\Models\\Operational\\Vendor', 1, 'App\\Models\\User', 'created', '{"attributes":{"name":"13 Delapan","code":"V-0001","logo":null,"cover_photo":null,"person_level":"Marketing","contact_person":"Atri","contact_number":"085155095512","website":"https:\\/\\/eample.com","instagram":"@13delapan","address":"Jl.Limo Tengah No.15 Depok, Indonesia 16515","city":"Depok","point":0,"vendor_limit_id":1,"vendor_grade_id":3,"membership_id":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 07:46:54', '2023-10-20 07:46:54'),
	(106, 'User Angela Sherly create data vendor 13 Delapan', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly create data vendor 13 Delapan', '"127.0.0.1"', '2023-10-20 07:46:54', '2023-10-20 07:46:54'),
	(107, 'User Angela Sherly show data vendor', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly show data vendor', '"127.0.0.1"', '2023-10-20 07:47:15', '2023-10-20 07:47:15'),
	(108, 'default', NULL, 'created', 2, 'App\\Models\\Operational\\Vendor', 1, 'App\\Models\\User', 'created', '{"attributes":{"name":"4 Seasons","code":"V-0002","logo":null,"cover_photo":null,"person_level":"Marketing","contact_person":"Elysia","contact_number":"085155095512","website":"https:\\/\\/eample.com","instagram":"4sdeco","address":"Kebon Jeruk Permai C15","city":"Jakarta","point":0,"vendor_limit_id":1,"vendor_grade_id":2,"membership_id":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 07:48:40', '2023-10-20 07:48:40'),
	(109, 'User Angela Sherly create data vendor 4 Seasons', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly create data vendor 4 Seasons', '"127.0.0.1"', '2023-10-20 07:48:40', '2023-10-20 07:48:40'),
	(110, 'default', NULL, 'created', 3, 'App\\Models\\Operational\\Vendor', 1, 'App\\Models\\User', 'created', '{"attributes":{"name":"A FOR AIRY","code":"V-0003","logo":null,"cover_photo":null,"person_level":"Marketing","contact_person":"CS A FOR AIRY","contact_number":"085155095512","website":"https:\\/\\/eample.com","instagram":"throughairy","address":"Jl. Tulodong Bawah No. A9 Kebayoran Indonesia, 12910","city":"Jakarta","point":0,"vendor_limit_id":1,"vendor_grade_id":4,"membership_id":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 07:50:25', '2023-10-20 07:50:25'),
	(111, 'User Angela Sherly create data vendor A FOR AIRY', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly create data vendor A FOR AIRY', '"127.0.0.1"', '2023-10-20 07:50:25', '2023-10-20 07:50:25'),
	(112, 'default', NULL, 'updated', 3, 'App\\Models\\Operational\\Vendor', 1, 'App\\Models\\User', 'updated', '{"attributes":{"name":"A FOR AIRY","code":"V-0003","logo":null,"cover_photo":null,"person_level":"Marketing","contact_person":"CS A FOR AIRY","contact_number":"085155095512","website":"https:\\/\\/eample.com","instagram":"@throughairy","address":"Jl. Tulodong Bawah No. A9 Kebayoran Indonesia, 12910","city":"Jakarta","point":0,"vendor_limit_id":1,"vendor_grade_id":4,"membership_id":1,"created_by":1,"updated_by":1,"deleted_by":null},"old":{"name":"A FOR AIRY","code":"V-0003","logo":null,"cover_photo":null,"person_level":"Marketing","contact_person":"CS A FOR AIRY","contact_number":"085155095512","website":"https:\\/\\/eample.com","instagram":"throughairy","address":"Jl. Tulodong Bawah No. A9 Kebayoran Indonesia, 12910","city":"Jakarta","point":0,"vendor_limit_id":1,"vendor_grade_id":4,"membership_id":1,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 07:52:46', '2023-10-20 07:52:46'),
	(113, 'User Angela Sherly update data vendor ', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly update data vendor ', '"127.0.0.1"', '2023-10-20 07:52:46', '2023-10-20 07:52:46'),
	(114, 'User Angela Sherly get data Order', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly get data Order', '"127.0.0.1"', '2023-10-20 08:49:44', '2023-10-20 08:49:44'),
	(115, 'User Angela Sherly show data Employee', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly show data Employee', '"127.0.0.1"', '2023-10-20 10:33:09', '2023-10-20 10:33:09'),
	(116, 'default', NULL, 'created', 1, 'App\\Models\\Operational\\Lead', 1, 'App\\Models\\User', 'created', '{"attributes":{"vendor_id":1,"date":"2023-10-20 17:39:05","pic":"Angela Sherly","response":"no","code":null,"note":"belum respon","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 10:39:05', '2023-10-20 10:39:05'),
	(117, 'User Angela Sherly create data Lead', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly create data Lead', '"127.0.0.1"', '2023-10-20 10:39:05', '2023-10-20 10:39:05'),
	(118, 'default', NULL, 'created', 2, 'App\\Models\\Operational\\Lead', 1, 'App\\Models\\User', 'created', '{"attributes":{"vendor_id":1,"date":"2023-10-20 17:40:35","pic":"Angela Sherly","response":"no","code":null,"note":"belum respon","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 10:40:35', '2023-10-20 10:40:35'),
	(119, 'User Angela Sherly create data Lead', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly create data Lead', '"127.0.0.1"', '2023-10-20 10:40:35', '2023-10-20 10:40:35'),
	(120, 'default', NULL, 'updated', 2, 'App\\Models\\Operational\\Lead', 1, 'App\\Models\\User', 'updated', '{"attributes":{"vendor_id":1,"date":"2023-10-20 17:42:30","pic":"Angela Sherly","response":"no","code":null,"note":"belum respon","created_by":1,"updated_by":1,"deleted_by":null},"old":{"vendor_id":1,"date":"2023-10-20 17:40:35","pic":"Angela Sherly","response":"no","code":null,"note":"belum respon","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 10:42:30', '2023-10-20 10:42:30'),
	(121, 'User Angela Sherly update data Lead', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly update data Lead', '"127.0.0.1"', '2023-10-20 10:42:30', '2023-10-20 10:42:30'),
	(122, 'default', NULL, 'created', 1, 'App\\Models\\MasterData\\Team', 1, 'App\\Models\\User', 'created', '{"attributes":{"name":"Uri Team","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 10:47:18', '2023-10-20 10:47:18'),
	(123, 'User Angela Sherly add new team', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly create new team Uri Team', '"127.0.0.1"', '2023-10-20 10:47:19', '2023-10-20 10:47:19'),
	(124, 'default', NULL, 'updated', 1, 'App\\Models\\MasterData\\Team', 1, 'App\\Models\\User', 'updated', '{"attributes":{"name":"Tim Uri","created_by":1,"updated_by":1,"deleted_by":null},"old":{"name":"Uri Team","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 10:48:46', '2023-10-20 10:48:46'),
	(125, 'User Angela Sherly update team information', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly update team to Tim Uri', '"127.0.0.1"', '2023-10-20 10:48:46', '2023-10-20 10:48:46'),
	(126, 'User Angela Sherly update team information', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly update team to Tim Uri', '"127.0.0.1"', '2023-10-20 10:49:21', '2023-10-20 10:49:21'),
	(127, 'default', NULL, 'created', 1, 'App\\Models\\Operational\\TeamLoan', 1, 'App\\Models\\User', 'created', '{"attributes":{"team_id":1,"loan_number":"TL-231017-00001","loan_date":null,"description":"kasbon event","loan_amount":null,"loan_status":null,"created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 11:03:09', '2023-10-20 11:03:09'),
	(128, 'User Angela Sherly store data Team Loan', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly store data Team Loan', '"127.0.0.1"', '2023-10-20 11:03:09', '2023-10-20 11:03:09'),
	(129, 'default', NULL, 'created', 2, 'App\\Models\\Operational\\TeamLoan', 1, 'App\\Models\\User', 'created', '{"attributes":{"team_id":1,"loan_number":"TL-231020-00001","loan_date":"2023-10-20","description":"kasbon event","loan_amount":2000000,"loan_status":"waiting approval","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 11:06:07', '2023-10-20 11:06:07'),
	(130, 'User Angela Sherly store data Team Loan', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly store data Team Loan', '"127.0.0.1"', '2023-10-20 11:06:07', '2023-10-20 11:06:07'),
	(131, 'default', NULL, 'updated', 2, 'App\\Models\\Operational\\TeamLoan', 1, 'App\\Models\\User', 'updated', '{"attributes":{"team_id":1,"loan_number":"TL-231020-00002","loan_date":"2023-10-20","description":"kasbon pergi ke event","loan_amount":4000000,"loan_status":"waiting approval","created_by":1,"updated_by":1,"deleted_by":null},"old":{"team_id":1,"loan_number":"TL-231020-00002","loan_date":"2023-10-20","description":"kasbon event","loan_amount":2000000,"loan_status":"waiting approval","created_by":1,"updated_by":null,"deleted_by":null}}', '2023-10-20 11:08:19', '2023-10-20 11:08:19'),
	(132, 'User Angela Sherly update data Team Loan', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly update data Team Loan', '"127.0.0.1"', '2023-10-20 11:08:19', '2023-10-20 11:08:19'),
	(133, 'User Angela Sherly get data Order', NULL, NULL, 1, 'App\\Models\\User', 1, 'App\\Models\\User', 'User Angela Sherly get data Order', '"127.0.0.1"', '2023-10-20 11:15:26', '2023-10-20 11:15:26');

-- Dumping structure for table goodsone-api.additional_services
CREATE TABLE IF NOT EXISTS `additional_services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.additional_services: ~0 rows (approximately)
INSERT INTO `additional_services` (`id`, `name`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Bongkaran Gedung', 1, 1, NULL, '2023-10-20 03:10:40', '2023-10-20 03:11:18', NULL),
	(2, 'Pasang Lampu', 1, NULL, NULL, '2023-10-20 03:12:02', '2023-10-20 03:12:02', NULL),
	(3, 'Install + Props', 1, NULL, NULL, '2023-10-20 03:14:34', '2023-10-20 03:14:34', NULL),
	(4, 'Bantu makan', 1, 1, NULL, '2023-10-20 04:15:53', '2023-10-20 04:17:50', '2023-10-20 04:17:50');

-- Dumping structure for table goodsone-api.allowances
CREATE TABLE IF NOT EXISTS `allowances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `allowances_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.allowances: ~0 rows (approximately)
INSERT INTO `allowances` (`id`, `name`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Uang Kerajinan', 1, NULL, NULL, '2023-10-20 03:17:01', '2023-10-20 03:17:01', NULL),
	(2, 'Pulsa Internet', 1, NULL, NULL, '2023-10-20 03:17:41', '2023-10-20 03:17:41', NULL),
	(3, 'Transport', 1, 1, NULL, '2023-10-20 03:18:22', '2023-10-20 03:19:30', NULL),
	(4, 'Lembur Makan 2', 1, 1, 1, '2023-10-20 04:20:59', '2023-10-20 04:21:52', '2023-10-20 04:21:52');

-- Dumping structure for table goodsone-api.attendances
CREATE TABLE IF NOT EXISTS `attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `date` date DEFAULT NULL,
  `clock_in` datetime DEFAULT NULL,
  `clock_in_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clock_in_location` double(8,2) DEFAULT NULL,
  `clock_in_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clock_out` datetime DEFAULT NULL,
  `clock_out_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clock_out_location` double(8,2) DEFAULT NULL,
  `clock_out_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Status: 1 = ontime, 2 = late',
  `platform` enum('web','mobile') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attendances_employee_id_foreign` (`employee_id`),
  CONSTRAINT `attendances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.attendances: ~0 rows (approximately)

-- Dumping structure for table goodsone-api.bank_accounts
CREATE TABLE IF NOT EXISTS `bank_accounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_holder` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bank_accounts_account_holder_index` (`account_holder`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.bank_accounts: ~2 rows (approximately)
INSERT INTO `bank_accounts` (`id`, `bank`, `account_holder`, `account_number`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'BCA', 'Chandra Hosen', '757 040 2719', 1, NULL, NULL, '2023-10-20 03:01:49', NULL, NULL),
	(2, 'BCA', 'Lie Her Fin', '594 038 6791', 1, NULL, NULL, '2023-10-20 03:01:49', NULL, NULL),
	(3, 'Mandiri', 'Angela Sherly', '121332452342', 1, 1, NULL, '2023-10-20 04:25:59', '2023-10-20 04:30:20', NULL);

-- Dumping structure for table goodsone-api.benefits
CREATE TABLE IF NOT EXISTS `benefits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_publish` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.benefits: ~0 rows (approximately)
INSERT INTO `benefits` (`id`, `image`, `name`, `is_publish`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'benefit_605694_delivery.png', 'Gratis Ongkir Jabodetabek', 1, 1, NULL, NULL, '2023-10-20 05:31:11', '2023-10-20 05:31:11', NULL),
	(2, 'benefit_690621_point-earned.png', 'Earn & Exchange G Points', 1, 1, NULL, NULL, '2023-10-20 05:32:02', '2023-10-20 05:32:02', NULL),
	(3, 'benefit_609419_cs.png', 'Priority Customer Service', 1, 1, NULL, NULL, '2023-10-20 05:32:39', '2023-10-20 05:32:39', NULL),
	(4, 'benefit_448957_voucher.png', 'Promo Voucher 100k', 1, 1, NULL, NULL, '2023-10-20 05:32:59', '2023-10-20 05:32:59', NULL),
	(5, 'benefit_996573_extra-point.png', 'Extra +1 G Points Every Transaction', 1, 1, 1, NULL, '2023-10-20 05:34:54', '2023-10-20 05:45:39', NULL),
	(6, 'benefit_307201_extra-point.png', 'Extra +2 G Points Every Transaction', 1, 1, NULL, NULL, '2023-10-20 05:46:17', '2023-10-20 05:46:17', NULL),
	(7, 'benefit_667695_extra-point.png', 'Extra +3 G Points Every Transaction', 1, 1, NULL, NULL, '2023-10-20 05:46:28', '2023-10-20 05:46:28', NULL),
	(8, 'benefit_758597_extra-point.png', 'Extra +5 G Points Every Transaction', 1, 1, NULL, NULL, '2023-10-20 05:46:41', '2023-10-20 05:46:41', NULL),
	(9, 'benefit_441670_extra-point.png', 'Extra +10 G Points Every Transaction', 1, 1, NULL, NULL, '2023-10-20 05:46:51', '2023-10-20 05:46:51', NULL),
	(10, 'benefit_132367_extra-point.png', 'apa aja', 1, 1, 1, 1, '2023-10-20 05:47:55', '2023-10-20 05:48:16', '2023-10-20 05:48:16');

-- Dumping structure for table goodsone-api.career_levels
CREATE TABLE IF NOT EXISTS `career_levels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `career_level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.career_levels: ~3 rows (approximately)
INSERT INTO `career_levels` (`id`, `career_level`, `description`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Supervisor', 'Supervisor', NULL, NULL, NULL, '2023-10-20 03:01:50', '2023-10-20 03:01:50', NULL),
	(2, 'Manager', 'Manager', NULL, NULL, NULL, '2023-10-20 03:01:50', '2023-10-20 03:01:50', NULL),
	(3, 'Staff', 'Staff', NULL, NULL, NULL, '2023-10-20 03:01:50', '2023-10-20 03:01:50', NULL);

-- Dumping structure for table goodsone-api.checklist_categories
CREATE TABLE IF NOT EXISTS `checklist_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.checklist_categories: ~4 rows (approximately)
INSERT INTO `checklist_categories` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Pohon', '2023-10-20 03:01:50', NULL, NULL),
	(2, 'Gazebo', '2023-10-20 03:01:50', NULL, NULL),
	(3, 'Lighting', '2023-10-20 03:01:50', NULL, NULL),
	(4, 'Melamin', '2023-10-20 03:01:50', NULL, NULL);

-- Dumping structure for table goodsone-api.checklist_items
CREATE TABLE IF NOT EXISTS `checklist_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `checklist_category_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `checklist_items_checklist_category_id_foreign` (`checklist_category_id`),
  CONSTRAINT `checklist_items_checklist_category_id_foreign` FOREIGN KEY (`checklist_category_id`) REFERENCES `checklist_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.checklist_items: ~0 rows (approximately)
INSERT INTO `checklist_items` (`id`, `checklist_category_id`, `name`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 'Lampu Hias', 1, NULL, NULL, '2023-10-20 04:32:43', '2023-10-20 04:32:43', NULL),
	(2, 1, 'Pernak Pernik Warna Warni', 1, NULL, NULL, '2023-10-20 04:35:30', '2023-10-20 04:35:30', NULL),
	(3, 1, 'Hiasan', 1, NULL, NULL, '2023-10-20 04:36:18', '2023-10-20 04:36:18', NULL),
	(4, 2, 'Palu', 1, NULL, NULL, '2023-10-20 04:36:48', '2023-10-20 04:36:48', NULL),
	(5, 2, 'Gate Besi', 1, 1, NULL, '2023-10-20 04:36:56', '2023-10-20 04:37:38', NULL),
	(6, 2, 'Corong Besi', 1, 1, 1, '2023-10-20 04:38:04', '2023-10-20 04:38:34', '2023-10-20 04:38:34');

-- Dumping structure for table goodsone-api.config_loan_installments
CREATE TABLE IF NOT EXISTS `config_loan_installments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nominal` int NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `config_loan_installments_nominal_index` (`nominal`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.config_loan_installments: ~9 rows (approximately)
INSERT INTO `config_loan_installments` (`id`, `nominal`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 100000, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(2, 150000, 1, 1, NULL, '2023-10-20 03:01:50', '2023-10-20 04:42:04', NULL),
	(3, 200000, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(4, 250000, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(5, 300000, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(6, 350000, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(7, 400000, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(8, 450000, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(9, 500000, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(10, 550000, 1, 1, 1, '2023-10-20 04:41:12', '2023-10-20 04:42:32', '2023-10-20 04:42:32');

-- Dumping structure for table goodsone-api.decoration_areas
CREATE TABLE IF NOT EXISTS `decoration_areas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.decoration_areas: ~4 rows (approximately)
INSERT INTO `decoration_areas` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Ballroom Area', '2023-10-20 03:01:50', NULL, NULL),
	(2, 'Foyer Area', '2023-10-20 03:01:50', NULL, NULL),
	(3, 'Lighting', '2023-10-20 03:01:50', NULL, NULL),
	(4, 'Stage Area', '2023-10-20 03:01:50', NULL, NULL);

-- Dumping structure for table goodsone-api.departments
CREATE TABLE IF NOT EXISTS `departments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payroll_type` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Payroll Type: 1 = monthly, 2 = weekly',
  `is_has_schedule` tinyint(1) NOT NULL DEFAULT '0',
  `clock_in` time DEFAULT NULL,
  `clock_out` time DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `departments_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.departments: ~2 rows (approximately)
INSERT INTO `departments` (`id`, `name`, `payroll_type`, `is_has_schedule`, `clock_in`, `clock_out`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Office', '1', 0, '00:00:00', '00:00:00', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(2, 'Operational', '2', 1, '13:00:00', '19:00:00', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(3, 'Warehouse', '1', 0, NULL, NULL, 1, 1, 1, '2023-10-20 06:28:01', '2023-10-20 06:30:48', '2023-10-20 06:30:48');

-- Dumping structure for table goodsone-api.department_allowances
CREATE TABLE IF NOT EXISTS `department_allowances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `department_id` bigint unsigned NOT NULL,
  `allowance_id` bigint unsigned NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `department_allowances_department_id_foreign` (`department_id`),
  KEY `department_allowances_allowance_id_foreign` (`allowance_id`),
  CONSTRAINT `department_allowances_allowance_id_foreign` FOREIGN KEY (`allowance_id`) REFERENCES `allowances` (`id`) ON DELETE CASCADE,
  CONSTRAINT `department_allowances_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.department_allowances: ~0 rows (approximately)
INSERT INTO `department_allowances` (`id`, `department_id`, `allowance_id`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 1, 1, NULL, NULL, '2023-10-20 04:45:25', '2023-10-20 04:45:25', NULL),
	(2, 1, 2, 1, NULL, NULL, '2023-10-20 04:45:25', '2023-10-20 04:45:25', NULL);

-- Dumping structure for table goodsone-api.employees
CREATE TABLE IF NOT EXISTS `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint unsigned NOT NULL,
  `position_id` bigint unsigned NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_verified_at` timestamp NULL DEFAULT NULL,
  `reset_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notification_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateofbirth` date DEFAULT NULL,
  `gender` enum('1','2') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1 = Female, 2 = Male',
  `ktp_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vaccine_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` int DEFAULT NULL,
  `loan_limit` int DEFAULT NULL,
  `active_loan_limit` int DEFAULT NULL,
  `level_id` bigint unsigned NOT NULL,
  `points` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_email_unique` (`email`),
  KEY `employees_department_id_foreign` (`department_id`),
  KEY `employees_position_id_foreign` (`position_id`),
  KEY `employees_level_id_foreign` (`level_id`),
  KEY `employees_fullname_index` (`fullname`),
  KEY `employees_employee_number_index` (`employee_number`),
  CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `employees_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `employee_levels` (`id`) ON DELETE CASCADE,
  CONSTRAINT `employees_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.employees: ~0 rows (approximately)
INSERT INTO `employees` (`id`, `photo`, `employee_number`, `fullname`, `department_id`, `position_id`, `email`, `phone_number`, `email_verified_at`, `password`, `otp`, `otp_verified_at`, `reset_token`, `notification_token`, `dateofbirth`, `gender`, `ktp_img`, `vaccine_img`, `salary`, `loan_limit`, `active_loan_limit`, `level_id`, `points`, `is_active`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, NULL, 'A0001', 'Alfonsius Gideon', 1, 1, 'alfonsiusgideon@gmail.com', NULL, NULL, '$2y$10$sRp0AzWcvLxfUCOtt/.rduQYzEdDvxRzL8FlcBf54mYFnMYWWzWd.', NULL, NULL, NULL, NULL, '1997-11-09', '2', NULL, NULL, 3000000, 5000000, 5000000, 1, 0, 1, 1, NULL, NULL, '2023-10-20 07:24:22', '2023-10-20 07:24:22', NULL),
	(2, NULL, 'A0002', 'Aprillia Dessire', 1, 1, 'aiprilliadesssire@gmail.com', NULL, NULL, '$2y$10$WA2oo8ekS7cbqqPN1TYiAeA0/Nnh0Qgnbj/bm84mSLeuGPu8gntS6', NULL, NULL, NULL, NULL, '1997-11-09', '1', NULL, NULL, 3000000, 5000000, 5000000, 1, 0, 1, 1, NULL, NULL, '2023-10-20 07:27:14', '2023-10-20 07:27:14', NULL),
	(3, NULL, 'A0003', 'Devi Sartika', 1, 1, 'devisartikagoodsoneid@gmail.com', NULL, NULL, '$2y$10$u0rFY5otH4ARK7/NqeIMKu6N4qDlv4yXhHnxh.MNnNbxUa.zQJdom', NULL, NULL, NULL, NULL, '1997-12-06', '1', NULL, NULL, 3000000, 5000000, 5000000, 1, 0, 1, 1, NULL, NULL, '2023-10-20 07:27:59', '2023-10-20 07:27:59', NULL),
	(4, NULL, 'A0004', 'Femi', 1, 1, 'admin@mail.com', NULL, NULL, '$2y$10$S0lfmt5OFvXMCDD2k74WKupNILWP2i973GTnbllQABl.RexXu6Za.', NULL, NULL, NULL, NULL, '2000-01-01', '1', NULL, NULL, 3000000, 5000000, 5000000, 1, 0, 1, 1, NULL, NULL, '2023-10-20 07:28:54', '2023-10-20 07:28:54', NULL),
	(5, NULL, 'A0005', 'Funninsia', 1, 1, 'funninsia31@gmail.com', NULL, NULL, '$2y$10$YOF.zso6g0UbFtxQ6GgK4epQ4XMbeBrI/1.P4kgVsaXGFIkI95TxG', NULL, NULL, NULL, NULL, '2004-03-31', '1', NULL, NULL, 3000000, 5000000, 5000000, 1, 0, 1, 1, NULL, NULL, '2023-10-20 07:29:41', '2023-10-20 07:29:41', NULL),
	(6, NULL, 'A0006', 'Hilda', 1, 1, 'hilda@gmail.com', NULL, NULL, '$2y$10$Svt2wtNunj07.wUE6ly62.m6AVEPVGh6yR.2R26wIMNh2AaB7F0Ay', NULL, NULL, NULL, NULL, '2004-03-31', '1', NULL, NULL, 3000000, 5000000, 5000000, 1, 0, 1, 1, NULL, NULL, '2023-10-20 07:30:30', '2023-10-20 07:30:30', NULL),
	(7, NULL, 'A0007', 'Indah Syafitri', 1, 1, 'syafitriindah97@gmail.com', NULL, NULL, '$2y$10$03xKlcYF9vGZXgCt64hiH.GNq6I6/yE0gBTSw7QmogC5i/zG2BCxS', NULL, NULL, NULL, NULL, '1997-04-07', '1', NULL, NULL, 3000000, 5000000, 5000000, 1, 0, 1, 1, NULL, NULL, '2023-10-20 07:31:04', '2023-10-20 07:31:04', NULL),
	(8, NULL, 'A0008', 'Uri Ruri', 2, 2, 'stiawanuri@gmail.com', NULL, NULL, '$2y$10$a3qBEcdnYIAvrEvQ5/ON4exqEPDYkpq9CITjmdmt/24vMLfWuMd0S', NULL, NULL, NULL, NULL, '1994-08-02', '2', NULL, NULL, 0, 5000000, 5000000, 1, 0, 1, 1, NULL, NULL, '2023-10-20 07:32:10', '2023-10-20 07:32:10', NULL),
	(9, NULL, 'A0009', 'Arif', 2, 3, 'arif@gmail.com', NULL, NULL, '$2y$10$tyOoxlnQkcfwj9N85ioToeh5S9oKkIg71x/KsO2YgqaMu4PjYz5FK', NULL, NULL, NULL, NULL, '1990-01-15', '2', NULL, NULL, 0, 5000000, 5000000, 1, 0, 1, 1, NULL, NULL, '2023-10-20 07:33:00', '2023-10-20 07:40:17', NULL);

-- Dumping structure for table goodsone-api.employee_allowances
CREATE TABLE IF NOT EXISTS `employee_allowances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `allowance_id` bigint unsigned NOT NULL,
  `amount` int DEFAULT NULL,
  `effective_date` date DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_allowances_employee_id_foreign` (`employee_id`),
  KEY `employee_allowances_allowance_id_foreign` (`allowance_id`),
  CONSTRAINT `employee_allowances_allowance_id_foreign` FOREIGN KEY (`allowance_id`) REFERENCES `allowances` (`id`) ON DELETE CASCADE,
  CONSTRAINT `employee_allowances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.employee_allowances: ~0 rows (approximately)

-- Dumping structure for table goodsone-api.employee_levels
CREATE TABLE IF NOT EXISTS `employee_levels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` int NOT NULL,
  `until` int NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_levels_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.employee_levels: ~5 rows (approximately)
INSERT INTO `employee_levels` (`id`, `image`, `name`, `from`, `until`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, NULL, 'Intern', 0, 25, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(2, NULL, 'Junior', 26, 50, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(3, NULL, 'Senior', 51, 100, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(4, NULL, 'Pro', 101, 200, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(5, NULL, 'Maestro', 201, 300, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(6, NULL, 'Superstar', 301, 500, 1, 1, NULL, '2023-10-20 04:52:00', '2023-10-20 04:57:36', NULL);

-- Dumping structure for table goodsone-api.employee_loans
CREATE TABLE IF NOT EXISTS `employee_loans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `loan_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loan_date` date DEFAULT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loan_amount` int DEFAULT NULL,
  `repayment_term` enum('1','2') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Status: 1 = weekly, 2 = monthly',
  `installment_amount` int DEFAULT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `declined_by` bigint unsigned DEFAULT NULL,
  `declined_at` datetime DEFAULT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loan_status` enum('waiting approval','approved','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'waiting approval',
  `repayment_status` enum('none','ongoing','paid','canceled') COLLATE utf8mb4_unicode_ci DEFAULT 'none',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_loans_employee_id_foreign` (`employee_id`),
  CONSTRAINT `employee_loans_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.employee_loans: ~0 rows (approximately)

-- Dumping structure for table goodsone-api.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table goodsone-api.invoices
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issue_date` date DEFAULT NULL,
  `bank_account_id` bigint unsigned NOT NULL,
  `amount` int DEFAULT NULL,
  `transfer_proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transfer_date` date DEFAULT NULL,
  `transfer_proof_uploaded_by` bigint unsigned DEFAULT NULL,
  `transfer_proof_uploaded_at` timestamp NULL DEFAULT NULL,
  `status` enum('waiting for payment','paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting for payment',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  KEY `invoices_order_id_foreign` (`order_id`),
  KEY `invoices_bank_account_id_foreign` (`bank_account_id`),
  CONSTRAINT `invoices_bank_account_id_foreign` FOREIGN KEY (`bank_account_id`) REFERENCES `bank_accounts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoices_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.invoices: ~0 rows (approximately)

-- Dumping structure for table goodsone-api.leads
CREATE TABLE IF NOT EXISTS `leads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vendor_id` bigint unsigned DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `response` enum('yes','no') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `leads_vendor_id_foreign` (`vendor_id`),
  CONSTRAINT `leads_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.leads: ~0 rows (approximately)
INSERT INTO `leads` (`id`, `vendor_id`, `date`, `pic`, `response`, `code`, `note`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, '2023-10-19 17:39:05', 'Angela Sherly', 'no', NULL, 'belum respon', 1, NULL, NULL, '2023-10-19 10:39:05', '2023-10-19 10:39:05', NULL),
	(2, 1, '2023-10-20 17:42:30', 'Angela Sherly', 'no', NULL, 'belum respon', 1, 1, NULL, '2023-10-20 10:40:35', '2023-10-20 10:42:30', NULL);

-- Dumping structure for table goodsone-api.memberships
CREATE TABLE IF NOT EXISTS `memberships` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` int NOT NULL,
  `until` int NOT NULL,
  `point` int NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `memberships_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.memberships: ~6 rows (approximately)
INSERT INTO `memberships` (`id`, `image`, `name`, `from`, `until`, `point`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, NULL, 'None', 0, 9999999, 0, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(2, NULL, 'Bronze', 10000000, 100999999, 1, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(3, NULL, 'Silver', 101000000, 250999999, 2, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(4, NULL, 'Gold', 251000000, 400999999, 3, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(5, NULL, 'Platinum', 401000000, 600999999, 4, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(6, NULL, 'Diamond', 601000000, 999999999, 5, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(7, 'membership_198249_Screenshot_2023-10-19_095607.png', 'MAXX', 50, 100, 1000, 1, 1, 1, '2023-10-20 05:02:10', '2023-10-20 05:03:27', '2023-10-20 05:03:27');

-- Dumping structure for table goodsone-api.membership_benefits
CREATE TABLE IF NOT EXISTS `membership_benefits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `membership_id` bigint unsigned NOT NULL,
  `benefit_id` bigint unsigned NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `membership_benefits_membership_id_foreign` (`membership_id`),
  KEY `membership_benefits_benefit_id_foreign` (`benefit_id`),
  CONSTRAINT `membership_benefits_benefit_id_foreign` FOREIGN KEY (`benefit_id`) REFERENCES `benefits` (`id`) ON DELETE CASCADE,
  CONSTRAINT `membership_benefits_membership_id_foreign` FOREIGN KEY (`membership_id`) REFERENCES `memberships` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.membership_benefits: ~0 rows (approximately)

-- Dumping structure for table goodsone-api.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.migrations: ~0 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
	(4, '2019_05_11_000000_create_otps_table', 1),
	(5, '2019_08_19_000000_create_failed_jobs_table', 1),
	(6, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(7, '2023_06_28_065242_create_sessions_table', 1),
	(8, '2023_07_08_123852_create_permission_tables', 1),
	(9, '2023_07_15_121233_create_vendor_limits_table', 1),
	(10, '2023_07_15_121422_create_vendor_grades_table', 1),
	(11, '2023_07_15_133620_create_memberships_table', 1),
	(12, '2023_07_15_140031_create_vendors_table', 1),
	(13, '2023_07_15_175414_create_activity_log_table', 1),
	(14, '2023_07_29_231018_create_product_categories_table', 1),
	(15, '2023_07_29_231029_create_product_attributes_table', 1),
	(16, '2023_07_29_231036_create_product_variants_table', 1),
	(17, '2023_07_29_232036_create_checklist_categories_table', 1),
	(18, '2023_07_29_232044_create_checklist_items_table', 1),
	(19, '2023_08_02_181525_create_sales_table', 1),
	(20, '2023_08_02_181547_create_bank_account_table', 1),
	(21, '2023_08_03_142227_create_decoration_area_table', 1),
	(22, '2023_08_06_061839_create_additional_services_table', 1),
	(23, '2023_08_06_061855_create_vehicles_table', 1),
	(24, '2023_08_06_150258_create_departments_table', 1),
	(25, '2023_08_06_152706_create_positions_table', 1),
	(26, '2023_08_06_153511_create_allowances_table', 1),
	(27, '2023_08_06_161526_create_employee_levels_table', 1),
	(28, '2023_08_06_161946_create_employees_table', 1),
	(29, '2023_08_06_171801_create_attendances_table', 1),
	(30, '2023_08_06_193101_create_teams_table', 1),
	(31, '2023_08_06_193903_create_team_leads_table', 1),
	(32, '2023_08_06_193943_create_team_members_table', 1),
	(33, '2023_08_06_201026_create_team_loans_table', 1),
	(34, '2023_08_06_201926_create_employee_allowances_table', 1),
	(35, '2023_08_06_221957_create_employee_loans_table', 1),
	(36, '2023_08_07_002115_create_orders_table', 1),
	(37, '2023_08_07_215522_create_order_histories_table', 1),
	(38, '2023_08_07_215758_create_order_additional_services_table', 1),
	(39, '2023_08_07_215914_create_order_products_table', 1),
	(40, '2023_08_07_225040_create_order_teams_table', 1),
	(41, '2023_08_08_015737_create_invoices_table', 1),
	(42, '2023_09_06_115137_create_config_loan_installments_table', 1),
	(43, '2023_09_20_112352_add_soft_deletes_to_order_teams_table', 1),
	(44, '2023_09_20_131002_change_additional_service_id_in_order_additional_services_table', 1),
	(45, '2023_09_29_170218_create_leads_table', 1),
	(46, '2023_09_30_093923_create_order_drivers_table', 1),
	(47, '2023_10_02_175556_change_employee_id_set_to_null_in_order_histories_table', 1),
	(48, '2023_10_02_215155_create_career_levels_table', 1),
	(49, '2023_10_02_215932_add_career_level_column_to_positions_table', 1),
	(50, '2023_10_19_134745_create_benefits_table', 1),
	(51, '2023_10_19_135042_create_membership_benefits_table', 1),
	(52, '2023_10_19_141022_create_department_allowances_table', 1);

-- Dumping structure for table goodsone-api.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.model_has_permissions: ~0 rows (approximately)

-- Dumping structure for table goodsone-api.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.model_has_roles: ~3 rows (approximately)
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(2, 'App\\Models\\User', 2),
	(3, 'App\\Models\\User', 3);

-- Dumping structure for table goodsone-api.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_seq` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `vendor_id` bigint unsigned NOT NULL,
  `loading_date` date DEFAULT NULL,
  `loading_time` time DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `event_time` time DEFAULT NULL,
  `venue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sales_id` bigint unsigned NOT NULL,
  `coordinator_id` bigint unsigned NOT NULL,
  `coordinator_schedule` enum('1','2') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Status: 1 = visit, 2 = standby',
  `subtotal` int DEFAULT NULL,
  `discount` int DEFAULT NULL,
  `total` int DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_checklist_tree` tinyint(1) DEFAULT '0',
  `is_checklist_melamin` tinyint(1) DEFAULT '0',
  `is_checklist_lighting` tinyint(1) DEFAULT '0',
  `is_checklist_gazebo` tinyint(1) DEFAULT '0',
  `reward_point` int DEFAULT NULL,
  `extra_point` int DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_vendor_id_foreign` (`vendor_id`),
  KEY `orders_sales_id_foreign` (`sales_id`),
  KEY `orders_coordinator_id_foreign` (`coordinator_id`),
  KEY `orders_order_number_index` (`order_number`),
  KEY `orders_order_seq_index` (`order_seq`),
  KEY `orders_date_index` (`date`),
  KEY `orders_loading_date_index` (`loading_date`),
  KEY `orders_loading_time_index` (`loading_time`),
  KEY `orders_event_date_index` (`event_date`),
  KEY `orders_event_time_index` (`event_time`),
  KEY `orders_venue_index` (`venue`),
  CONSTRAINT `orders_coordinator_id_foreign` FOREIGN KEY (`coordinator_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_sales_id_foreign` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.orders: ~0 rows (approximately)

-- Dumping structure for table goodsone-api.order_additional_services
CREATE TABLE IF NOT EXISTS `order_additional_services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `additional_service_id` bigint unsigned DEFAULT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` int DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_additional_services_order_id_foreign` (`order_id`),
  KEY `order_additional_services_additional_service_id_foreign` (`additional_service_id`),
  KEY `order_additional_services_employee_id_foreign` (`employee_id`),
  CONSTRAINT `order_additional_services_additional_service_id_foreign` FOREIGN KEY (`additional_service_id`) REFERENCES `additional_services` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_additional_services_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_additional_services_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.order_additional_services: ~0 rows (approximately)

-- Dumping structure for table goodsone-api.order_drivers
CREATE TABLE IF NOT EXISTS `order_drivers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `driver_id` bigint unsigned NOT NULL,
  `vehicle_id` bigint unsigned NOT NULL,
  `route_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` int DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_drivers_order_id_foreign` (`order_id`),
  KEY `order_drivers_driver_id_foreign` (`driver_id`),
  KEY `order_drivers_vehicle_id_foreign` (`vehicle_id`),
  CONSTRAINT `order_drivers_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_drivers_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_drivers_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.order_drivers: ~0 rows (approximately)

-- Dumping structure for table goodsone-api.order_histories
CREATE TABLE IF NOT EXISTS `order_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `employee_id` bigint unsigned DEFAULT NULL,
  `status` enum('new','on going','checklist done','on the way','arrived','work started','work done','handover','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` text COLLATE utf8mb4_unicode_ci,
  `signed_by` int DEFAULT NULL,
  `signature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_histories_order_id_foreign` (`order_id`),
  KEY `order_histories_employee_id_foreign` (`employee_id`),
  CONSTRAINT `order_histories_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_histories_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.order_histories: ~0 rows (approximately)

-- Dumping structure for table goodsone-api.order_products
CREATE TABLE IF NOT EXISTS `order_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `area_id` bigint unsigned NOT NULL,
  `product_attribute_id` bigint unsigned NOT NULL,
  `product_variant_id` bigint unsigned NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `amount` int DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_products_order_id_foreign` (`order_id`),
  KEY `order_products_area_id_foreign` (`area_id`),
  KEY `order_products_product_attribute_id_foreign` (`product_attribute_id`),
  KEY `order_products_product_variant_id_foreign` (`product_variant_id`),
  CONSTRAINT `order_products_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `decoration_areas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_products_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_products_product_attribute_id_foreign` FOREIGN KEY (`product_attribute_id`) REFERENCES `product_attributes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_products_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.order_products: ~0 rows (approximately)

-- Dumping structure for table goodsone-api.order_teams
CREATE TABLE IF NOT EXISTS `order_teams` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_product_id` bigint unsigned NOT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `team_id` bigint unsigned DEFAULT NULL,
  `salary` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_teams_order_product_id_foreign` (`order_product_id`),
  KEY `order_teams_employee_id_foreign` (`employee_id`),
  KEY `order_teams_team_id_foreign` (`team_id`),
  CONSTRAINT `order_teams_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_teams_order_product_id_foreign` FOREIGN KEY (`order_product_id`) REFERENCES `order_products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_teams_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.order_teams: ~0 rows (approximately)

-- Dumping structure for table goodsone-api.otps
CREATE TABLE IF NOT EXISTS `otps` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validity` int NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `otps_id_index` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.otps: ~0 rows (approximately)

-- Dumping structure for table goodsone-api.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table goodsone-api.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.permissions: ~2 rows (approximately)
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'dashboard.index', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(2, 'dashboard.sales_chart', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(3, 'users.index', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(4, 'users.create', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(5, 'users.edit', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(6, 'users.delete', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(7, 'roles.index', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(8, 'roles.create', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(9, 'roles.edit', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(10, 'roles.delete', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(11, 'permissions.index', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(12, 'vendors.index', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(13, 'vendors.create', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(14, 'vendors.edit', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(15, 'vendors.delete', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(16, 'vendor_limits.index', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(17, 'vendor_limits.create', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(18, 'vendor_limits.edit', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(19, 'vendor_limits.delete', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(20, 'vendor_grades.index', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(21, 'vendor_grades.create', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(22, 'vendor_grades.edit', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(23, 'vendor_grades.delete', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(24, 'product_items.index', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(25, 'product_items.create', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(26, 'product_items.edit', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(27, 'product_items.delete', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(28, 'product_checklists.index', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(29, 'product_checklists.create', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(30, 'product_checklists.edit', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(31, 'product_checklists.delete', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(32, 'order_events.index', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(33, 'orders.index', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(34, 'invoices.index', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(35, 'employee_departements.index', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(36, 'employee_departements.create', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(37, 'employee_departements.edit', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(38, 'employee_departements.delete', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(39, 'employee_positions.index', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(40, 'employee_positions.create', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(41, 'employee_positions.edit', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(42, 'employee_positions.delete', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(43, 'employee_teams.index', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(44, 'employee_teams.create', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(45, 'employee_teams.edit', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(46, 'employee_teams.delete', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(47, 'employees.index', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(48, 'employees.create', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(49, 'employees.edit', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(50, 'employees.delete', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(51, 'attendances.index', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(52, 'employee_loans.index', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(53, 'team_loans.index', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(54, 'payrolls.index', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(55, 'payrolls.create', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(56, 'payrolls.edit', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(57, 'payrolls.delete', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(58, 'rewards.index', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(59, 'redeems.index', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(60, 'site_settings.index', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(61, 'site_settings.create', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(62, 'site_settings.edit', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49'),
	(63, 'site_settings.delete', 'web', '2023-10-20 03:01:49', '2023-10-20 03:01:49');

-- Dumping structure for table goodsone-api.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.personal_access_tokens: ~0 rows (approximately)
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
	(1, 'App\\Models\\User', 1, 'token', '6e02c2d5a2a33a79e1da0b1984b35eae45d5483a8f977d1090681505eae00e0c', '["*"]', '2023-10-20 11:15:26', NULL, '2023-10-20 03:08:42', '2023-10-20 11:15:26');

-- Dumping structure for table goodsone-api.positions
CREATE TABLE IF NOT EXISTS `positions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `department_id` bigint unsigned NOT NULL,
  `career_level_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `positions_department_id_foreign` (`department_id`),
  KEY `positions_name_index` (`name`),
  KEY `positions_career_level_id_foreign` (`career_level_id`),
  CONSTRAINT `positions_career_level_id_foreign` FOREIGN KEY (`career_level_id`) REFERENCES `career_levels` (`id`) ON DELETE CASCADE,
  CONSTRAINT `positions_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.positions: ~0 rows (approximately)
INSERT INTO `positions` (`id`, `department_id`, `career_level_id`, `name`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 1, 'Coordinator', 1, NULL, NULL, '2023-10-20 06:34:32', '2023-10-20 06:34:32', NULL),
	(2, 2, 1, 'PIC', 1, NULL, NULL, '2023-10-20 06:34:59', '2023-10-20 06:34:59', NULL),
	(3, 2, 3, 'Tukang', 1, NULL, NULL, '2023-10-20 06:35:17', '2023-10-20 06:35:17', NULL),
	(4, 2, 3, 'Asisten Tukang', 1, NULL, NULL, '2023-10-20 06:35:39', '2023-10-20 06:35:39', NULL),
	(5, 2, 3, 'Office Boy', 1, 1, 1, '2023-10-20 06:36:00', '2023-10-20 06:37:16', '2023-10-20 06:37:16');

-- Dumping structure for table goodsone-api.product_attributes
CREATE TABLE IF NOT EXISTS `product_attributes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_category_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_attributes_product_category_id_foreign` (`product_category_id`),
  CONSTRAINT `product_attributes_product_category_id_foreign` FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.product_attributes: ~0 rows (approximately)
INSERT INTO `product_attributes` (`id`, `product_category_id`, `name`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 'Warna', 1, NULL, NULL, '2023-10-20 06:06:58', '2023-10-20 06:06:58', NULL),
	(2, 2, 'Bunga', 1, NULL, NULL, '2023-10-20 06:07:21', '2023-10-20 06:07:21', NULL),
	(3, 2, 'Pernak Pernik', 1, NULL, NULL, '2023-10-20 06:07:30', '2023-10-20 06:07:30', NULL),
	(4, 2, 'Size', 1, NULL, NULL, '2023-10-20 06:07:39', '2023-10-20 06:07:39', NULL),
	(5, 3, 'Bunga', 1, NULL, NULL, '2023-10-20 06:08:00', '2023-10-20 06:08:00', NULL),
	(6, 4, 'Requested', 1, NULL, NULL, '2023-10-20 06:08:25', '2023-10-20 06:08:25', NULL),
	(7, 5, 'Bunga', 1, 1, NULL, '2023-10-20 06:08:47', '2023-10-20 06:11:09', NULL),
	(8, 5, 'Kaki', 1, NULL, NULL, '2023-10-20 06:08:58', '2023-10-20 06:08:58', NULL),
	(9, 6, 'Bunga', 1, NULL, NULL, '2023-10-20 06:09:30', '2023-10-20 06:09:30', NULL),
	(10, 6, 'Finishing Bunga', 1, NULL, NULL, '2023-10-20 06:09:39', '2023-10-20 06:09:39', NULL),
	(11, 6, 'Pernak Pernik', 1, NULL, NULL, '2023-10-20 06:09:50', '2023-10-20 06:09:50', NULL),
	(12, 6, 'Size', 1, NULL, NULL, '2023-10-20 06:09:56', '2023-10-20 06:09:56', NULL),
	(13, 6, 'Tiang Tenda 5 x 5', 1, NULL, NULL, '2023-10-20 06:10:08', '2023-10-20 06:10:08', NULL);

-- Dumping structure for table goodsone-api.product_categories
CREATE TABLE IF NOT EXISTS `product_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_categories_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.product_categories: ~15 rows (approximately)
INSERT INTO `product_categories` (`id`, `name`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Carpet', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(2, 'Cover Gazebo', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(3, 'Cover Lorong', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(4, 'Customize', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(5, 'Gate', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(6, 'Gazebo', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(7, 'Kain', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(8, 'Lantai Kaca', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(9, 'Lighting', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(10, 'Melamin', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(11, 'Modul Stage', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(12, 'Pohon', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(13, 'Properties', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(14, 'Tangga', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(15, 'Triblok', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(16, 'test2', 1, 1, 1, '2023-10-20 06:04:41', '2023-10-20 06:05:28', '2023-10-20 06:05:28');

-- Dumping structure for table goodsone-api.product_variants
CREATE TABLE IF NOT EXISTS `product_variants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_attribute_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_variants_product_attribute_id_foreign` (`product_attribute_id`),
  CONSTRAINT `product_variants_product_attribute_id_foreign` FOREIGN KEY (`product_attribute_id`) REFERENCES `product_attributes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.product_variants: ~0 rows (approximately)
INSERT INTO `product_variants` (`id`, `product_attribute_id`, `name`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 'Abu Muda', 1, NULL, NULL, '2023-10-20 06:19:02', '2023-10-20 06:19:02', NULL),
	(2, 1, 'Abu Tua', 1, NULL, NULL, '2023-10-20 06:19:17', '2023-10-20 06:19:17', NULL),
	(3, 1, 'Hitam', 1, NULL, NULL, '2023-10-20 06:19:23', '2023-10-20 06:19:23', NULL),
	(4, 1, 'Merah', 1, NULL, NULL, '2023-10-20 06:19:32', '2023-10-20 06:19:32', NULL),
	(5, 1, 'Putih', 1, NULL, NULL, '2023-10-20 06:19:38', '2023-10-20 06:19:38', NULL),
	(6, 1, 'Rosepetal Carpet', 1, NULL, NULL, '2023-10-20 06:19:48', '2023-10-20 06:19:48', NULL),
	(7, 2, 'Cherry Blossom Putih mix Wisteria Putih', 1, NULL, NULL, '2023-10-20 06:20:32', '2023-10-20 06:20:32', NULL),
	(8, 2, 'Maple Hijau mix Cb Softpink', 1, NULL, NULL, '2023-10-20 06:20:44', '2023-10-20 06:20:44', NULL),
	(9, 2, 'Maple Putih Finishing Cherry Blossom Softpink', 1, NULL, NULL, '2023-10-20 06:21:03', '2023-10-20 06:21:03', NULL),
	(10, 2, 'Maple Putih mix Cherry Blossom Putih mix Wisteria Putih', 1, NULL, NULL, '2023-10-20 06:21:15', '2023-10-20 06:21:15', NULL),
	(11, 2, 'Maple Putih mix Wisteria Putih & Wisteria Biru', 1, NULL, NULL, '2023-10-20 06:21:25', '2023-10-20 06:21:25', NULL),
	(12, 3, 'Tanpa Pernak Pernik', 1, NULL, NULL, '2023-10-20 06:21:59', '2023-10-20 06:21:59', NULL),
	(13, 3, 'Tirai Juntai', 1, NULL, NULL, '2023-10-20 06:22:08', '2023-10-20 06:22:08', NULL),
	(14, 4, '3x3', 1, NULL, NULL, '2023-10-20 06:22:41', '2023-10-20 06:22:41', NULL),
	(15, 4, '4 Kaki Pilar', 1, NULL, NULL, '2023-10-20 06:22:47', '2023-10-20 06:22:47', NULL),
	(16, 4, '4x4', 1, 1, NULL, '2023-10-20 06:22:55', '2023-10-20 06:24:06', NULL);

-- Dumping structure for table goodsone-api.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.roles: ~2 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'Super Admin', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(2, 'Manager', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48'),
	(3, 'Admin Vendor', 'web', '2023-10-20 03:01:48', '2023-10-20 03:01:48');

-- Dumping structure for table goodsone-api.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.role_has_permissions: ~63 rows (approximately)
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(5, 1),
	(6, 1),
	(7, 1),
	(8, 1),
	(9, 1),
	(10, 1),
	(11, 1),
	(12, 1),
	(13, 1),
	(14, 1),
	(15, 1),
	(16, 1),
	(17, 1),
	(18, 1),
	(19, 1),
	(20, 1),
	(21, 1),
	(22, 1),
	(23, 1),
	(24, 1),
	(25, 1),
	(26, 1),
	(27, 1),
	(28, 1),
	(29, 1),
	(30, 1),
	(31, 1),
	(32, 1),
	(33, 1),
	(34, 1),
	(35, 1),
	(36, 1),
	(37, 1),
	(38, 1),
	(39, 1),
	(40, 1),
	(41, 1),
	(42, 1),
	(43, 1),
	(44, 1),
	(45, 1),
	(46, 1),
	(47, 1),
	(48, 1),
	(49, 1),
	(50, 1),
	(51, 1),
	(52, 1),
	(53, 1),
	(54, 1),
	(55, 1),
	(56, 1),
	(57, 1),
	(58, 1),
	(59, 1),
	(60, 1),
	(61, 1),
	(62, 1),
	(63, 1);

-- Dumping structure for table goodsone-api.sales
CREATE TABLE IF NOT EXISTS `sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.sales: ~5 rows (approximately)
INSERT INTO `sales` (`id`, `name`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Ai Dessire', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(2, 'Chandra Hosen', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(3, 'Devi Sartika', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(4, 'Funin', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(5, 'Indah', 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL);

-- Dumping structure for table goodsone-api.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.sessions: ~0 rows (approximately)

-- Dumping structure for table goodsone-api.teams
CREATE TABLE IF NOT EXISTS `teams` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.teams: ~0 rows (approximately)
INSERT INTO `teams` (`id`, `name`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Tim Uri', 1, 1, NULL, '2023-10-20 10:47:18', '2023-10-20 10:48:46', NULL);

-- Dumping structure for table goodsone-api.team_leads
CREATE TABLE IF NOT EXISTS `team_leads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `team_id` bigint unsigned NOT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `team_leads_team_id_foreign` (`team_id`),
  KEY `team_leads_employee_id_foreign` (`employee_id`),
  CONSTRAINT `team_leads_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `team_leads_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.team_leads: ~0 rows (approximately)
INSERT INTO `team_leads` (`id`, `team_id`, `employee_id`, `created_at`, `updated_at`) VALUES
	(3, 1, 8, '2023-10-20 10:49:21', '2023-10-20 10:49:21');

-- Dumping structure for table goodsone-api.team_loans
CREATE TABLE IF NOT EXISTS `team_loans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `loan_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loan_date` date DEFAULT NULL,
  `team_id` bigint unsigned NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loan_amount` int DEFAULT NULL,
  `loan_status` enum('waiting approval','approved','rejected') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `repayment_status` enum('none','ongoing','paid','canceled') COLLATE utf8mb4_unicode_ci DEFAULT 'none',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `team_loans_team_id_foreign` (`team_id`),
  CONSTRAINT `team_loans_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.team_loans: ~0 rows (approximately)
INSERT INTO `team_loans` (`id`, `loan_number`, `loan_date`, `team_id`, `description`, `loan_amount`, `loan_status`, `repayment_status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'TL-231017-00001', '2023-10-17', 1, 'kasbon event', 2000000, 'approved', 'none', 1, NULL, NULL, '2023-11-17 04:03:09', '2023-10-20 11:03:09', NULL),
	(2, 'TL-231020-00002', '2023-10-20', 1, 'kasbon pergi ke event', 4000000, 'waiting approval', 'none', 1, 1, NULL, '2023-10-20 11:06:07', '2023-10-20 11:08:19', NULL);

-- Dumping structure for table goodsone-api.team_members
CREATE TABLE IF NOT EXISTS `team_members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `team_id` bigint unsigned NOT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `team_members_team_id_foreign` (`team_id`),
  KEY `team_members_employee_id_foreign` (`employee_id`),
  CONSTRAINT `team_members_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `team_members_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.team_members: ~0 rows (approximately)

-- Dumping structure for table goodsone-api.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_expiry` timestamp NULL DEFAULT NULL,
  `otp_verified_at` timestamp NULL DEFAULT NULL,
  `reset_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notification_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `current_team_id` bigint unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_dark_mode` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_email_index` (`email`),
  KEY `users_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.users: ~3 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `otp`, `otp_expiry`, `otp_verified_at`, `reset_token`, `notification_token`, `remember_token`, `last_login`, `current_team_id`, `profile_photo_path`, `is_dark_mode`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Angela Sherly', 'angelasherly@goodsoneid.com', NULL, NULL, '$2y$10$qaaiQ4GCI85lCYItwB.GXORB2OiNfVJGc.NJA0FyyfVyfSVYnlpxe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-20 03:08:42', NULL, NULL, 0, 1, NULL, NULL, '2023-10-20 03:01:49', '2023-10-20 03:08:42', NULL),
	(2, 'Manager Test', 'manager@gmail.com', NULL, NULL, '$2y$10$8cvvPVNYthZXiVCi0hVVUOIPLEpNIRXlXHlpZApqDh1JhQhyONWcu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-10-20 03:01:49', '2023-10-20 03:01:49', NULL),
	(3, 'Angela Developer', 'developer@goodsoneid.com', NULL, NULL, '$2y$10$8N6M7ObXQqTakSkQkWRZ7OvuPr7HR8j2C4BYo74VnS2u1G589JI22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-10-20 03:01:49', '2023-10-20 03:01:49', NULL);

-- Dumping structure for table goodsone-api.vehicles
CREATE TABLE IF NOT EXISTS `vehicles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plate_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.vehicles: ~0 rows (approximately)
INSERT INTO `vehicles` (`id`, `model_name`, `plate_number`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'GRAND MAXX 2014', 'B 8009 BVI', 1, NULL, NULL, '2023-10-20 05:58:08', '2023-10-20 05:58:08', NULL),
	(2, 'TOYOTA AVANZA 2018', 'B 7956 YUG', 1, NULL, NULL, '2023-10-20 05:58:55', '2023-10-20 05:58:55', NULL),
	(3, 'HONDA JAZZ PUTIH 2015', 'B 8976 NBA', 1, 1, NULL, '2023-10-20 05:59:35', '2023-10-20 06:00:02', NULL);

-- Dumping structure for table goodsone-api.vendors
CREATE TABLE IF NOT EXISTS `vendors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cover_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `person_level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_limit_id` bigint unsigned NOT NULL,
  `vendor_grade_id` bigint unsigned NOT NULL,
  `membership_id` bigint unsigned NOT NULL,
  `point` int NOT NULL DEFAULT '0',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_verified_at` timestamp NULL DEFAULT NULL,
  `reset_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notification_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_first_login` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vendors_email_unique` (`email`),
  KEY `vendors_vendor_limit_id_foreign` (`vendor_limit_id`),
  KEY `vendors_vendor_grade_id_foreign` (`vendor_grade_id`),
  KEY `vendors_membership_id_foreign` (`membership_id`),
  KEY `vendors_code_index` (`code`),
  KEY `vendors_name_index` (`name`),
  KEY `vendors_email_index` (`email`),
  KEY `vendors_point_index` (`point`),
  CONSTRAINT `vendors_membership_id_foreign` FOREIGN KEY (`membership_id`) REFERENCES `memberships` (`id`) ON DELETE CASCADE,
  CONSTRAINT `vendors_vendor_grade_id_foreign` FOREIGN KEY (`vendor_grade_id`) REFERENCES `vendor_grades` (`id`) ON DELETE CASCADE,
  CONSTRAINT `vendors_vendor_limit_id_foreign` FOREIGN KEY (`vendor_limit_id`) REFERENCES `vendor_limits` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.vendors: ~0 rows (approximately)
INSERT INTO `vendors` (`id`, `cover_photo`, `logo`, `code`, `name`, `contact_person`, `person_level`, `contact_number`, `website`, `instagram`, `address`, `city`, `vendor_limit_id`, `vendor_grade_id`, `membership_id`, `point`, `email`, `email_verified_at`, `password`, `otp`, `otp_verified_at`, `reset_token`, `notification_token`, `otp_email`, `is_first_login`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, NULL, NULL, 'V-0001', '13 Delapan', 'Atri', 'Marketing', '085155095512', 'https://eample.com', '@13delapan', 'Jl.Limo Tengah No.15 Depok, Indonesia 16515', 'Depok', 1, 3, 1, 0, 'dev.goodsone@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2023-10-20 07:46:54', '2023-10-20 07:46:54', NULL),
	(2, NULL, NULL, 'V-0002', '4 Seasons', 'Elysia', 'Marketing', '085155095512', 'https://eample.com', '4sdeco', 'Kebon Jeruk Permai C15', 'Jakarta', 1, 2, 1, 0, '4seasons.decoration@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2023-10-20 07:48:40', '2023-10-20 07:48:40', NULL),
	(3, NULL, NULL, 'V-0003', 'A FOR AIRY', 'CS A FOR AIRY', 'Marketing', '085155095512', 'https://eample.com', '@throughairy', 'Jl. Tulodong Bawah No. A9 Kebayoran Indonesia, 12910', 'Jakarta', 1, 4, 1, 0, 'vendor6@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, '2023-10-20 07:50:25', '2023-10-20 07:52:46', NULL);

-- Dumping structure for table goodsone-api.vendor_grades
CREATE TABLE IF NOT EXISTS `vendor_grades` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vendor_grades_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.vendor_grades: ~7 rows (approximately)
INSERT INTO `vendor_grades` (`id`, `name`, `description`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Priority', NULL, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(2, 'Grade A', NULL, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(3, 'Grade B', NULL, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(4, 'Grade C', NULL, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(5, 'No Grade', NULL, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(6, 'Catering', NULL, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(7, 'WO & EO', NULL, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL);

-- Dumping structure for table goodsone-api.vendor_limits
CREATE TABLE IF NOT EXISTS `vendor_limits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount_limit` int NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vendor_limits_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table goodsone-api.vendor_limits: ~4 rows (approximately)
INSERT INTO `vendor_limits` (`id`, `name`, `amount_limit`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Green', 100000000, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(2, 'Yellow', 25000000, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(3, 'Red', 10000000, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL),
	(4, 'Black', 5000000, 1, NULL, NULL, '2023-10-20 03:01:50', NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
