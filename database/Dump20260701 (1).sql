
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `label` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Home',
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `line1` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `line2` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `landmark` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'India',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_user_id_is_default_index` (`user_id`,`is_default`),
  KEY `addresses_pincode_index` (`pincode`),
  CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `audit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `audit_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `event` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_type` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auditable_id` bigint unsigned DEFAULT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_logs_auditable_type_auditable_id_index` (`auditable_type`,`auditable_id`),
  KEY `audit_logs_user_id_index` (`user_id`),
  KEY `audit_logs_event_index` (`event`),
  CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
INSERT INTO `audit_logs` VALUES (1,NULL,'created','App\\Models\\Product',1,NULL,'{\"id\": 1, \"sku\": \"EX-MLDIN55\", \"name\": \"Exide Mileage MLDIN55 55Ah\", \"slug\": \"exide-mileage-mldin55-55ah\", \"price\": 7800, \"voltage\": 12, \"is_active\": true, \"weight_kg\": 14.5, \"created_at\": \"2026-04-30 12:53:10\", \"meta_title\": \"Exide Mileage MLDIN55 55Ah - Buy Online with Warranty\", \"model_name\": \"MLDIN55\", \"capacity_ah\": 55, \"category_id\": 1, \"description\": \"<p>High-performance maintenance-free battery for hatchback and sedan cars.</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.</p>\", \"is_featured\": true, \"offer_price\": 6499, \"stock_quantity\": 50, \"warranty_months\": 48, \"battery_brand_id\": 1, \"maintenance_free\": true, \"meta_description\": \"High-performance maintenance-free battery for hatchback and sedan cars.\", \"exchange_discount\": 800, \"short_description\": \"High-performance maintenance-free battery for hatchback and sedan cars.\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-04-30 07:23:10','2026-04-30 07:23:10'),(2,NULL,'created','App\\Models\\Product',2,NULL,'{\"id\": 2, \"sku\": \"AM-HI45\", \"name\": \"Amaron Hi-Life Pro 45Ah\", \"slug\": \"amaron-hi-life-pro-45ah\", \"price\": 6800, \"voltage\": 12, \"is_active\": true, \"weight_kg\": 12.8, \"created_at\": \"2026-04-30 12:53:10\", \"meta_title\": \"Amaron Hi-Life Pro 45Ah - Buy Online with Warranty\", \"model_name\": \"HI-0BH45D20L\", \"capacity_ah\": 45, \"category_id\": 1, \"description\": \"<p>Long-life maintenance-free car battery from Amaron with 60-month warranty.</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.</p>\", \"is_featured\": true, \"offer_price\": 5799, \"stock_quantity\": 35, \"warranty_months\": 60, \"battery_brand_id\": 2, \"maintenance_free\": true, \"meta_description\": \"Long-life maintenance-free car battery from Amaron with 60-month warranty.\", \"exchange_discount\": 700, \"short_description\": \"Long-life maintenance-free car battery from Amaron with 60-month warranty.\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-04-30 07:23:10','2026-04-30 07:23:10'),(3,NULL,'created','App\\Models\\Product',3,NULL,'{\"id\": 3, \"sku\": \"AM-HI40\", \"name\": \"Amaron Hi-Life 40Ah\", \"slug\": \"amaron-hi-life-40ah\", \"price\": 5800, \"voltage\": 12, \"is_active\": true, \"weight_kg\": 11.2, \"created_at\": \"2026-04-30 12:53:10\", \"meta_title\": \"Amaron Hi-Life 40Ah - Buy Online with Warranty\", \"model_name\": \"HI-0BH40B20L\", \"capacity_ah\": 40, \"category_id\": 1, \"description\": \"<p>Reliable car battery for small cars with 48-month warranty.</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.</p>\", \"is_featured\": false, \"offer_price\": 4999, \"stock_quantity\": 28, \"warranty_months\": 48, \"battery_brand_id\": 2, \"maintenance_free\": true, \"meta_description\": \"Reliable car battery for small cars with 48-month warranty.\", \"exchange_discount\": 600, \"short_description\": \"Reliable car battery for small cars with 48-month warranty.\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-04-30 07:23:10','2026-04-30 07:23:10'),(4,NULL,'created','App\\Models\\Product',4,NULL,'{\"id\": 4, \"sku\": \"EX-MOTO9\", \"name\": \"Exide MotoMatic 9Ah\", \"slug\": \"exide-motomatic-9ah\", \"price\": 2500, \"voltage\": 12, \"is_active\": true, \"weight_kg\": 3.4, \"created_at\": \"2026-04-30 12:53:10\", \"meta_title\": \"Exide MotoMatic 9Ah - Buy Online with Warranty\", \"model_name\": \"12XL9-B\", \"capacity_ah\": 9, \"category_id\": 2, \"description\": \"<p>Reliable bike battery with strong cranking power for 150-200cc motorcycles.</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.</p>\", \"is_featured\": true, \"offer_price\": 1999, \"stock_quantity\": 60, \"warranty_months\": 36, \"battery_brand_id\": 1, \"maintenance_free\": true, \"meta_description\": \"Reliable bike battery with strong cranking power for 150-200cc motorcycles.\", \"exchange_discount\": 200, \"short_description\": \"Reliable bike battery with strong cranking power for 150-200cc motorcycles.\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-04-30 07:23:10','2026-04-30 07:23:10'),(5,NULL,'created','App\\Models\\Product',5,NULL,'{\"id\": 5, \"sku\": \"SF-MOTO5\", \"name\": \"SF Sonic Motozone 5Ah\", \"slug\": \"sf-sonic-motozone-5ah\", \"price\": 1800, \"voltage\": 12, \"is_active\": true, \"weight_kg\": 1.8, \"created_at\": \"2026-04-30 12:53:10\", \"meta_title\": \"SF Sonic Motozone 5Ah - Buy Online with Warranty\", \"model_name\": \"FTZ5L\", \"capacity_ah\": 5, \"category_id\": 2, \"description\": \"<p>Compact battery for scooters and 100-125cc bikes.</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.</p>\", \"is_featured\": false, \"offer_price\": 1499, \"stock_quantity\": 40, \"warranty_months\": 24, \"battery_brand_id\": 4, \"maintenance_free\": true, \"meta_description\": \"Compact battery for scooters and 100-125cc bikes.\", \"exchange_discount\": 150, \"short_description\": \"Compact battery for scooters and 100-125cc bikes.\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-04-30 07:23:10','2026-04-30 07:23:10'),(6,NULL,'created','App\\Models\\Warehouse',1,NULL,'{\"id\": 1, \"city\": \"Mumbai\", \"code\": \"MAIN\", \"name\": \"Main Warehouse\", \"state\": \"Maharashtra\", \"address\": \"Sector 18, Industrial Area\", \"country\": \"India\", \"pincode\": \"400001\", \"is_active\": true, \"created_at\": \"2026-04-30 12:53:10\", \"is_default\": true, \"sort_order\": 1}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-04-30 07:23:10','2026-04-30 07:23:10'),(7,NULL,'created','App\\Models\\Warehouse',2,NULL,'{\"id\": 2, \"city\": \"New Delhi\", \"code\": \"DEL\", \"name\": \"Delhi NCR Hub\", \"state\": \"Delhi\", \"address\": \"Okhla Industrial Phase II\", \"country\": \"India\", \"pincode\": \"110020\", \"is_active\": true, \"created_at\": \"2026-04-30 12:53:10\", \"is_default\": false, \"sort_order\": 2}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-04-30 07:23:10','2026-04-30 07:23:10'),(8,NULL,'created','App\\Models\\Warehouse',3,NULL,'{\"id\": 3, \"city\": \"Bangalore\", \"code\": \"BLR\", \"name\": \"Bangalore Hub\", \"state\": \"Karnataka\", \"address\": \"Whitefield Road\", \"country\": \"India\", \"pincode\": \"560066\", \"is_active\": true, \"created_at\": \"2026-04-30 12:53:10\", \"is_default\": false, \"sort_order\": 3}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-04-30 07:23:10','2026-04-30 07:23:10'),(9,NULL,'created','App\\Models\\Coupon',1,NULL,'{\"id\": 1, \"code\": \"WELCOME200\", \"name\": \"Welcome Offer\", \"type\": \"flat\", \"value\": 200, \"is_active\": true, \"created_at\": \"2026-04-30 12:53:10\", \"expires_at\": \"2027-04-30 12:53:10\", \"description\": \"Flat ₹200 off on your first order.\", \"per_user_limit\": 1, \"min_order_amount\": 1500, \"is_first_order_only\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-04-30 07:23:10','2026-04-30 07:23:10'),(10,NULL,'created','App\\Models\\Coupon',2,NULL,'{\"id\": 2, \"code\": \"SAVE10\", \"name\": \"10% Off\", \"type\": \"percentage\", \"value\": 10, \"is_active\": true, \"created_at\": \"2026-04-30 12:53:10\", \"expires_at\": \"2027-04-30 12:53:10\", \"description\": \"10% off up to ₹500 on orders above ₹3000.\", \"max_discount\": 500, \"per_user_limit\": 1, \"min_order_amount\": 3000}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-04-30 07:23:10','2026-04-30 07:23:10'),(11,NULL,'created','App\\Models\\Coupon',3,NULL,'{\"id\": 3, \"code\": \"FESTIVE500\", \"name\": \"Festival Offer\", \"type\": \"flat\", \"value\": 500, \"is_active\": true, \"created_at\": \"2026-04-30 12:53:10\", \"expires_at\": \"2027-04-30 12:53:10\", \"description\": \"Flat ₹500 off on orders above ₹5000.\", \"per_user_limit\": 1, \"min_order_amount\": 5000}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-04-30 07:23:10','2026-04-30 07:23:10'),(12,1,'updated','App\\Models\\Product',1,'{\"description\": \"<p>High-performance maintenance-free battery for hatchback and sedan cars.</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.</p>\"}','{\"description\": \"High-performance maintenance-free battery for hatchback and sedan cars.</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.\"}','http://127.0.0.1:8000/admin/products/exide-mileage-mldin55-55ah','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-16 04:36:19','2026-06-16 04:36:19'),(13,1,'updated','App\\Models\\Product',2,'{\"description\": \"<p>Long-life maintenance-free car battery from Amaron with 60-month warranty.</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.</p>\"}','{\"description\": \"Long-life maintenance-free car battery from Amaron with 60-month warranty.</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.\"}','http://127.0.0.1:8000/admin/products/amaron-hi-life-pro-45ah','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-16 04:37:04','2026-06-16 04:37:04'),(14,NULL,'updated','App\\Models\\Product',2,'{\"short_description\": \"Long-life maintenance-free car battery from Amaron with 60-month warranty.\"}','{\"short_description\": \"Long-life maintenance-free car battery from Amaron with 48-month warranty.\"}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 04:43:06','2026-07-31 04:43:06'),(15,6,'request.get.admin.products.index',NULL,NULL,NULL,'{\"route\": \"admin.products.index\", \"method\": \"GET\", \"metadata\": {\"status\": 200}, \"description\": \"GET admin/products (admin.products.index)\"}','http://127.0.0.1:8000/admin/products','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-31 06:19:01','2026-07-31 06:19:01'),(16,6,'request.post.cart.add',NULL,NULL,NULL,'{\"route\": \"cart.add\", \"method\": \"POST\", \"metadata\": {\"status\": 302}, \"description\": \"POST cart/add/amaron-hi-life-40ah (cart.add)\"}','http://127.0.0.1:8000/cart/add/amaron-hi-life-40ah','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-31 06:19:16','2026-07-31 06:19:16'),(17,6,'request.post.cart.add',NULL,NULL,NULL,'{\"route\": \"cart.add\", \"method\": \"POST\", \"metadata\": {\"status\": 302}, \"description\": \"POST cart/add/sf-sonic-motozone-5ah (cart.add)\"}','http://127.0.0.1:8000/cart/add/sf-sonic-motozone-5ah','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-31 06:56:10','2026-07-31 06:56:10'),(18,6,'request.delete.cart.remove',NULL,NULL,NULL,'{\"route\": \"cart.remove\", \"method\": \"DELETE\", \"metadata\": {\"status\": 302}, \"description\": \"DELETE cart/items/2 (cart.remove)\"}','http://127.0.0.1:8000/cart/items/2','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-31 07:02:17','2026-07-31 07:02:17'),(19,NULL,'deleted','App\\Models\\Product',1,'{\"id\": 1, \"sku\": \"EX-MLDIN55\", \"name\": \"Exide Mileage MLDIN55 55Ah\", \"slug\": \"exide-mileage-mldin55-55ah\", \"price\": \"7800.00\", \"voltage\": \"12.00\", \"is_active\": 1, \"weight_kg\": \"14.500\", \"created_at\": \"2026-04-30 12:53:10\", \"deleted_at\": \"2026-07-31 12:32:46\", \"meta_title\": \"Exide Mileage MLDIN55 55Ah - Buy Online with Warranty\", \"model_name\": \"MLDIN55\", \"capacity_ah\": \"55.00\", \"category_id\": 1, \"description\": \"High-performance maintenance-free battery for hatchback and sedan cars.</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.\", \"is_featured\": 1, \"offer_price\": \"6499.00\", \"stock_quantity\": 50, \"warranty_months\": 48, \"battery_brand_id\": 1, \"maintenance_free\": 1, \"meta_description\": \"High-performance maintenance-free battery for hatchback and sedan cars.\", \"exchange_discount\": \"800.00\", \"short_description\": \"High-performance maintenance-free battery for hatchback and sedan cars.\", \"exchange_available\": 1, \"low_stock_threshold\": 5}',NULL,'http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:02:46','2026-07-31 07:02:46'),(20,NULL,'deleted','App\\Models\\Product',2,'{\"id\": 2, \"sku\": \"AM-HI45\", \"name\": \"Amaron Hi-Life Pro 45Ah\", \"slug\": \"amaron-hi-life-pro-45ah\", \"price\": \"6800.00\", \"voltage\": \"12.00\", \"is_active\": 1, \"weight_kg\": \"12.800\", \"created_at\": \"2026-04-30 12:53:10\", \"deleted_at\": \"2026-07-31 12:32:46\", \"meta_title\": \"Amaron Hi-Life Pro 45Ah - Buy Online with Warranty\", \"model_name\": \"HI-0BH45D20L\", \"capacity_ah\": \"45.00\", \"category_id\": 1, \"description\": \"Long-life maintenance-free car battery from Amaron with 60-month warranty.</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.\", \"is_featured\": 1, \"offer_price\": \"5799.00\", \"stock_quantity\": 35, \"warranty_months\": 60, \"battery_brand_id\": 2, \"maintenance_free\": 1, \"meta_description\": \"Long-life maintenance-free car battery from Amaron with 60-month warranty.\", \"exchange_discount\": \"700.00\", \"short_description\": \"Long-life maintenance-free car battery from Amaron with 48-month warranty.\", \"exchange_available\": 1, \"low_stock_threshold\": 5}',NULL,'http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:02:46','2026-07-31 07:02:46'),(21,NULL,'deleted','App\\Models\\Product',3,'{\"id\": 3, \"sku\": \"AM-HI40\", \"name\": \"Amaron Hi-Life 40Ah\", \"slug\": \"amaron-hi-life-40ah\", \"price\": \"5800.00\", \"voltage\": \"12.00\", \"is_active\": 1, \"weight_kg\": \"11.200\", \"created_at\": \"2026-04-30 12:53:10\", \"deleted_at\": \"2026-07-31 12:32:46\", \"meta_title\": \"Amaron Hi-Life 40Ah - Buy Online with Warranty\", \"model_name\": \"HI-0BH40B20L\", \"capacity_ah\": \"40.00\", \"category_id\": 1, \"description\": \"<p>Reliable car battery for small cars with 48-month warranty.</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.</p>\", \"is_featured\": 0, \"offer_price\": \"4999.00\", \"stock_quantity\": 28, \"warranty_months\": 48, \"battery_brand_id\": 2, \"maintenance_free\": 1, \"meta_description\": \"Reliable car battery for small cars with 48-month warranty.\", \"exchange_discount\": \"600.00\", \"short_description\": \"Reliable car battery for small cars with 48-month warranty.\", \"exchange_available\": 1, \"low_stock_threshold\": 5}',NULL,'http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:02:46','2026-07-31 07:02:46'),(22,NULL,'deleted','App\\Models\\Product',4,'{\"id\": 4, \"sku\": \"EX-MOTO9\", \"name\": \"Exide MotoMatic 9Ah\", \"slug\": \"exide-motomatic-9ah\", \"price\": \"2500.00\", \"voltage\": \"12.00\", \"is_active\": 1, \"weight_kg\": \"3.400\", \"created_at\": \"2026-04-30 12:53:10\", \"deleted_at\": \"2026-07-31 12:32:46\", \"meta_title\": \"Exide MotoMatic 9Ah - Buy Online with Warranty\", \"model_name\": \"12XL9-B\", \"capacity_ah\": \"9.00\", \"category_id\": 2, \"description\": \"<p>Reliable bike battery with strong cranking power for 150-200cc motorcycles.</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.</p>\", \"is_featured\": 1, \"offer_price\": \"1999.00\", \"stock_quantity\": 60, \"warranty_months\": 36, \"battery_brand_id\": 1, \"maintenance_free\": 1, \"meta_description\": \"Reliable bike battery with strong cranking power for 150-200cc motorcycles.\", \"exchange_discount\": \"200.00\", \"short_description\": \"Reliable bike battery with strong cranking power for 150-200cc motorcycles.\", \"exchange_available\": 1, \"low_stock_threshold\": 5}',NULL,'http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:02:46','2026-07-31 07:02:46'),(23,NULL,'deleted','App\\Models\\Product',5,'{\"id\": 5, \"sku\": \"SF-MOTO5\", \"name\": \"SF Sonic Motozone 5Ah\", \"slug\": \"sf-sonic-motozone-5ah\", \"price\": \"1800.00\", \"voltage\": \"12.00\", \"is_active\": 1, \"weight_kg\": \"1.800\", \"created_at\": \"2026-04-30 12:53:10\", \"deleted_at\": \"2026-07-31 12:32:46\", \"meta_title\": \"SF Sonic Motozone 5Ah - Buy Online with Warranty\", \"model_name\": \"FTZ5L\", \"capacity_ah\": \"5.00\", \"category_id\": 2, \"description\": \"<p>Compact battery for scooters and 100-125cc bikes.</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.</p>\", \"is_featured\": 0, \"offer_price\": \"1499.00\", \"stock_quantity\": 40, \"warranty_months\": 24, \"battery_brand_id\": 4, \"maintenance_free\": 1, \"meta_description\": \"Compact battery for scooters and 100-125cc bikes.\", \"exchange_discount\": \"150.00\", \"short_description\": \"Compact battery for scooters and 100-125cc bikes.\", \"exchange_available\": 1, \"low_stock_threshold\": 5}',NULL,'http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:02:46','2026-07-31 07:02:46'),(24,NULL,'created','App\\Models\\Product',6,NULL,'{\"id\": 6, \"sku\": \"AM-HL-35\", \"name\": \"Amaron Hi-Life Pro 35Ah\", \"slug\": \"amaron-hi-life-pro-35ah\", \"price\": 5200, \"voltage\": 12, \"is_active\": true, \"created_at\": \"2026-07-31 12:32:46\", \"capacity_ah\": 35, \"category_id\": 1, \"description\": \"<p>Compact 35Ah battery for small hatchbacks — Alto, Kwid, Nano, i10 (older).</p><p><strong>Fits:</strong> Maruti Alto · Renault Kwid · Tata Nano · Hyundai i10 (pre-2014).</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>\", \"is_featured\": false, \"offer_price\": 4499, \"stock_quantity\": 30, \"warranty_months\": 48, \"battery_brand_id\": 2, \"exchange_discount\": 500, \"short_description\": \"Compact 35Ah battery for small hatchbacks — Alto, Kwid, Nano, i10 (older).\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:02:46','2026-07-31 07:02:46'),(25,NULL,'created','App\\Models\\Product',7,NULL,'{\"id\": 7, \"sku\": \"EX-ML-44\", \"name\": \"Exide Mileage MLDIN44 44Ah\", \"slug\": \"exide-mileage-mldin44-44ah\", \"price\": 6200, \"voltage\": 12, \"is_active\": true, \"created_at\": \"2026-07-31 12:32:46\", \"capacity_ah\": 44, \"category_id\": 1, \"description\": \"<p>Exide Mileage series 44Ah — reliable, low-maintenance battery for entry-level cars.</p><p><strong>Fits:</strong> Maruti Wagon R · Datsun Redi-Go · Renault Triber.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>\", \"is_featured\": false, \"offer_price\": 5399, \"stock_quantity\": 30, \"warranty_months\": 48, \"battery_brand_id\": 1, \"exchange_discount\": 550, \"short_description\": \"Exide Mileage series 44Ah — reliable, low-maintenance battery for entry-level cars.\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:02:46','2026-07-31 07:02:46'),(26,NULL,'created','App\\Models\\Product',11,NULL,'{\"id\": 11, \"sku\": \"AM-HL-45\", \"name\": \"Amaron Hi-Life Pro 45Ah\", \"slug\": \"amaron-hi-life-pro-45ah\", \"price\": 6900, \"voltage\": 12, \"is_active\": true, \"created_at\": \"2026-07-31 12:35:20\", \"capacity_ah\": 45, \"category_id\": 1, \"description\": \"<p>Long-life 45Ah battery for compact cars — Swift, Baleno, Grand i10, Kwid Climber.</p><p><strong>Fits:</strong> Maruti Swift · Hyundai Grand i10 · Ford Figo · Renault Kwid Climber.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>\", \"is_featured\": true, \"offer_price\": 5999, \"stock_quantity\": 40, \"warranty_months\": 48, \"battery_brand_id\": 2, \"exchange_discount\": 600, \"short_description\": \"Long-life 45Ah battery for compact cars — Swift, Baleno, Grand i10, Kwid Climber.\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:05:20','2026-07-31 07:05:20'),(27,NULL,'created','App\\Models\\Product',12,NULL,'{\"id\": 12, \"sku\": \"EX-MT-55\", \"name\": \"Exide Matrix MTR-DIN55 55Ah\", \"slug\": \"exide-matrix-mtr-din55-55ah\", \"price\": 7800, \"voltage\": 12, \"is_active\": true, \"created_at\": \"2026-07-31 12:35:20\", \"capacity_ah\": 55, \"category_id\": 1, \"description\": \"<p>Exide Matrix 55Ah — European DIN standard for hatchbacks and compact sedans.</p><p><strong>Fits:</strong> Maruti Baleno · Toyota Etios · Hyundai Xcent · Tata Tigor.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>\", \"is_featured\": true, \"offer_price\": 6799, \"stock_quantity\": 45, \"warranty_months\": 48, \"battery_brand_id\": 1, \"exchange_discount\": 700, \"short_description\": \"Exide Matrix 55Ah — European DIN standard for hatchbacks and compact sedans.\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:05:20','2026-07-31 07:05:20'),(28,NULL,'created','App\\Models\\Product',13,NULL,'{\"id\": 13, \"sku\": \"AM-HL-65\", \"name\": \"Amaron Hi-Life Pro 65Ah (DIN65)\", \"slug\": \"amaron-hi-life-pro-65ah-din65\", \"price\": 8600, \"voltage\": 12, \"is_active\": true, \"created_at\": \"2026-07-31 12:35:20\", \"capacity_ah\": 65, \"category_id\": 1, \"description\": \"<p>Amaron 65Ah DIN65 — premium sedan battery with 55-month warranty.</p><p><strong>Fits:</strong> Honda City · Hyundai Verna · Skoda Rapid · VW Vento · Maruti Ciaz.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>\", \"is_featured\": true, \"offer_price\": 7599, \"stock_quantity\": 35, \"warranty_months\": 55, \"battery_brand_id\": 2, \"exchange_discount\": 800, \"short_description\": \"Amaron 65Ah DIN65 — premium sedan battery with 55-month warranty.\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:05:20','2026-07-31 07:05:20'),(29,NULL,'created','App\\Models\\Product',14,NULL,'{\"id\": 14, \"sku\": \"SF-DIN-65\", \"name\": \"SF Sonic FSF0-DIN65 65Ah\", \"slug\": \"sf-sonic-fsf0-din65-65ah\", \"price\": 8200, \"voltage\": 12, \"is_active\": true, \"created_at\": \"2026-07-31 12:35:20\", \"capacity_ah\": 65, \"category_id\": 1, \"description\": \"<p>SF Sonic 65Ah DIN65 — Exide-backed reliability at a value price.</p><p><strong>Fits:</strong> Honda City · Hyundai Verna · VW Vento · Skoda Rapid.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>\", \"is_featured\": false, \"offer_price\": 7199, \"stock_quantity\": 30, \"warranty_months\": 48, \"battery_brand_id\": 4, \"exchange_discount\": 700, \"short_description\": \"SF Sonic 65Ah DIN65 — Exide-backed reliability at a value price.\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:05:20','2026-07-31 07:05:20'),(30,NULL,'created','App\\Models\\Product',15,NULL,'{\"id\": 15, \"sku\": \"AM-HL-75\", \"name\": \"Amaron Hi-Life Pro 75Ah (DIN75)\", \"slug\": \"amaron-hi-life-pro-75ah-din75\", \"price\": 9600, \"voltage\": 12, \"is_active\": true, \"created_at\": \"2026-07-31 12:35:20\", \"capacity_ah\": 75, \"category_id\": 1, \"description\": \"<p>Amaron 75Ah DIN75 — SUV-grade battery for Creta, Seltos, Nexon, Ecosport.</p><p><strong>Fits:</strong> Hyundai Creta · Kia Seltos · Tata Nexon · Ford Ecosport · MG Hector.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>\", \"is_featured\": true, \"offer_price\": 8499, \"stock_quantity\": 30, \"warranty_months\": 55, \"battery_brand_id\": 2, \"exchange_discount\": 800, \"short_description\": \"Amaron 75Ah DIN75 — SUV-grade battery for Creta, Seltos, Nexon, Ecosport.\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:05:20','2026-07-31 07:05:20'),(31,NULL,'created','App\\Models\\Product',16,NULL,'{\"id\": 16, \"sku\": \"EX-MP-80\", \"name\": \"Exide MP-DIN80 80Ah\", \"slug\": \"exide-mp-din80-80ah\", \"price\": 10800, \"voltage\": 12, \"is_active\": true, \"created_at\": \"2026-07-31 12:35:20\", \"capacity_ah\": 80, \"category_id\": 1, \"description\": \"<p>Exide Marathon Plus 80Ah — heavy-duty battery for large SUVs and older Innova / Fortuner.</p><p><strong>Fits:</strong> Toyota Innova · Toyota Fortuner (older) · Mahindra Bolero · Ford Endeavour (older).</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>\", \"is_featured\": true, \"offer_price\": 9599, \"stock_quantity\": 25, \"warranty_months\": 55, \"battery_brand_id\": 1, \"exchange_discount\": 900, \"short_description\": \"Exide Marathon Plus 80Ah — heavy-duty battery for large SUVs and older Innova / Fortuner.\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:05:20','2026-07-31 07:05:20'),(32,NULL,'created','App\\Models\\Product',17,NULL,'{\"id\": 17, \"sku\": \"AM-HL-80\", \"name\": \"Amaron Hi-Life Pro 80Ah (DIN80)\", \"slug\": \"amaron-hi-life-pro-80ah-din80\", \"price\": 10500, \"voltage\": 12, \"is_active\": true, \"created_at\": \"2026-07-31 12:35:20\", \"capacity_ah\": 80, \"category_id\": 1, \"description\": \"<p>Amaron 80Ah DIN80 with 55-month warranty — proven SUV/diesel battery.</p><p><strong>Fits:</strong> Mahindra XUV500 · Tata Safari · Toyota Innova · Ford Endeavour.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>\", \"is_featured\": true, \"offer_price\": 9299, \"stock_quantity\": 25, \"warranty_months\": 55, \"battery_brand_id\": 2, \"exchange_discount\": 900, \"short_description\": \"Amaron 80Ah DIN80 with 55-month warranty — proven SUV/diesel battery.\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:05:20','2026-07-31 07:05:20'),(33,NULL,'created','App\\Models\\Product',18,NULL,'{\"id\": 18, \"sku\": \"SF-DIN-80\", \"name\": \"SF Sonic FSF0-DIN80 80Ah\", \"slug\": \"sf-sonic-fsf0-din80-80ah\", \"price\": 10200, \"voltage\": 12, \"is_active\": true, \"created_at\": \"2026-07-31 12:35:20\", \"capacity_ah\": 80, \"category_id\": 1, \"description\": \"<p>SF Sonic 80Ah DIN80 — value option for SUVs and diesel MPVs.</p><p><strong>Fits:</strong> Mahindra Scorpio · Tata Safari · Toyota Innova · Bolero.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>\", \"is_featured\": false, \"offer_price\": 8999, \"stock_quantity\": 20, \"warranty_months\": 48, \"battery_brand_id\": 4, \"exchange_discount\": 800, \"short_description\": \"SF Sonic 80Ah DIN80 — value option for SUVs and diesel MPVs.\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:05:20','2026-07-31 07:05:20'),(34,NULL,'created','App\\Models\\Product',19,NULL,'{\"id\": 19, \"sku\": \"AM-HL-100\", \"name\": \"Amaron Hi-Life 100Ah (DIN100)\", \"slug\": \"amaron-hi-life-100ah-din100\", \"price\": 12800, \"voltage\": 12, \"is_active\": true, \"created_at\": \"2026-07-31 12:35:20\", \"capacity_ah\": 100, \"category_id\": 1, \"description\": \"<p>Amaron 100Ah DIN100 — luxury SUV / premium diesel battery, 55-month warranty.</p><p><strong>Fits:</strong> Toyota Fortuner · Ford Endeavour · Skoda Superb · Hyundai Elantra · MG Gloster.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>\", \"is_featured\": true, \"offer_price\": 11499, \"stock_quantity\": 15, \"warranty_months\": 55, \"battery_brand_id\": 2, \"exchange_discount\": 1000, \"short_description\": \"Amaron 100Ah DIN100 — luxury SUV / premium diesel battery, 55-month warranty.\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:05:20','2026-07-31 07:05:20'),(35,NULL,'created','App\\Models\\Product',20,NULL,'{\"id\": 20, \"sku\": \"EX-MI-100\", \"name\": \"Exide MI-DIN100 100Ah\", \"slug\": \"exide-mi-din100-100ah\", \"price\": 13200, \"voltage\": 12, \"is_active\": true, \"created_at\": \"2026-07-31 12:35:20\", \"capacity_ah\": 100, \"category_id\": 1, \"description\": \"<p>Exide Mileage 100Ah DIN100 — trusted premium-vehicle battery.</p><p><strong>Fits:</strong> Toyota Fortuner · Ford Endeavour · Skoda Superb · Audi A4.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>\", \"is_featured\": false, \"offer_price\": 11899, \"stock_quantity\": 15, \"warranty_months\": 55, \"battery_brand_id\": 1, \"exchange_discount\": 1000, \"short_description\": \"Exide Mileage 100Ah DIN100 — trusted premium-vehicle battery.\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:05:20','2026-07-31 07:05:20'),(36,NULL,'created','App\\Models\\Product',21,NULL,'{\"id\": 21, \"sku\": \"EX-MI-120\", \"name\": \"Exide MI-DIN120 120Ah\", \"slug\": \"exide-mi-din120-120ah\", \"price\": 15200, \"voltage\": 12, \"is_active\": true, \"created_at\": \"2026-07-31 12:35:21\", \"capacity_ah\": 120, \"category_id\": 1, \"description\": \"<p>Exide 120Ah DIN120 — heavy-duty for Innova Crysta diesel, tempos, and large MUVs.</p><p><strong>Fits:</strong> Toyota Innova Crysta (diesel) · Tata Xenon · Mahindra Tempo · Force Traveller.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>\", \"is_featured\": false, \"offer_price\": 13799, \"stock_quantity\": 12, \"warranty_months\": 55, \"battery_brand_id\": 1, \"exchange_discount\": 1000, \"short_description\": \"Exide 120Ah DIN120 — heavy-duty for Innova Crysta diesel, tempos, and large MUVs.\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:05:21','2026-07-31 07:05:21'),(37,NULL,'created','App\\Models\\Product',22,NULL,'{\"id\": 22, \"sku\": \"AM-BIKE-5\", \"name\": \"Amaron Pro Bike Rider 5Ah\", \"slug\": \"amaron-pro-bike-rider-5ah\", \"price\": 1650, \"voltage\": 12, \"is_active\": true, \"created_at\": \"2026-07-31 12:35:21\", \"capacity_ah\": 5, \"category_id\": 2, \"description\": \"<p>Sealed maintenance-free battery for scooters and 100-125cc bikes.</p><p><strong>Fits:</strong> Honda Activa · TVS Jupiter · Hero Splendor · Bajaj Platina · Yamaha Fascino.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>\", \"is_featured\": false, \"offer_price\": 1399, \"stock_quantity\": 50, \"warranty_months\": 30, \"battery_brand_id\": 2, \"exchange_discount\": 150, \"short_description\": \"Sealed maintenance-free battery for scooters and 100-125cc bikes.\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:05:21','2026-07-31 07:05:21'),(38,NULL,'created','App\\Models\\Product',24,NULL,'{\"id\": 24, \"sku\": \"EX-MOTO-9\", \"name\": \"Exide MotoMatic 9Ah\", \"slug\": \"exide-motomatic-9ah\", \"price\": 2400, \"voltage\": 12, \"is_active\": true, \"created_at\": \"2026-07-31 12:35:55\", \"capacity_ah\": 9, \"category_id\": 2, \"description\": \"<p>Higher-capacity bike battery with strong cranking for 150-200cc motorcycles.</p><p><strong>Fits:</strong> Bajaj Pulsar 150-220 · TVS Apache RTR 160-200 · Honda Unicorn · Hero Xtreme.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>\", \"is_featured\": true, \"offer_price\": 1999, \"stock_quantity\": 40, \"warranty_months\": 36, \"battery_brand_id\": 1, \"exchange_discount\": 200, \"short_description\": \"Higher-capacity bike battery with strong cranking for 150-200cc motorcycles.\", \"exchange_available\": true}','http://192.168.1.30:8000','127.0.0.1','Symfony','2026-07-31 07:05:55','2026-07-31 07:05:55'),(39,6,'request.delete.cart.remove',NULL,NULL,NULL,'{\"route\": \"cart.remove\", \"method\": \"DELETE\", \"metadata\": {\"status\": 302}, \"description\": \"DELETE cart/items/3 (cart.remove)\"}','http://127.0.0.1:8000/cart/items/3','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','2026-07-31 07:26:21','2026-07-31 07:26:21');
/*!40000 ALTER TABLE `audit_logs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `banners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_text` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'home_hero',
  `sort_order` smallint unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `banners_position_is_active_index` (`position`,`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES (2,'Up to ₹800 Off on Old Battery Exchange','Hand over your old battery at delivery and save instantly. No paperwork.','banners/hero-2.jpg',NULL,'/products?exchange=1','Claim Offer','home_hero',1,1,NULL,NULL,'2026-04-30 07:23:10','2026-06-15 03:15:16'),(3,'Same-day Battery Delivery across Mumbai','Free delivery + free installation + old battery exchange in all Mumbai pincodes.','banners/hero-1.svg',NULL,'/products','Shop Batteries','home_hero',2,1,NULL,NULL,'2026-06-15 01:47:15','2026-06-15 03:15:16');
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `battery_brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `battery_brands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` smallint unsigned NOT NULL DEFAULT '0',
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `battery_brands_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `battery_brands` WRITE;
/*!40000 ALTER TABLE `battery_brands` DISABLE KEYS */;
INSERT INTO `battery_brands` VALUES (1,'Exide','exide',NULL,'Exide is one of India\'s largest manufacturers of lead-acid storage batteries.',1,1,1,NULL,NULL,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(2,'Amaron','amaron',NULL,'Amaron offers maintenance-free batteries with long warranty periods.',1,1,2,NULL,NULL,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(3,'Luminous','luminous',NULL,'Luminous batteries combine reliability with affordable pricing.',1,1,3,NULL,NULL,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(4,'SF Sonic','sf-sonic',NULL,'SF Sonic is a high-performance battery brand from the Exide group.',1,1,4,NULL,NULL,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(5,'Tata Green','tata-green',NULL,'Tata Green delivers a balance of performance and price.',0,1,5,NULL,NULL,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(6,'Livguard','livguard',NULL,'Livguard manufactures automotive and inverter batteries.',0,1,6,NULL,NULL,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(7,'Bosch','bosch',NULL,'Bosch automotive batteries with German engineering.',1,1,7,NULL,NULL,'2026-04-30 07:23:10','2026-04-30 07:23:10');
/*!40000 ALTER TABLE `battery_brands` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('trikuti-battery-cache-dmin@vehiclebattery.test|127.0.0.1','i:1;',1783229994),('trikuti-battery-cache-dmin@vehiclebattery.test|127.0.0.1:timer','i:1783229994;',1783229994),('trikuti-battery-cache-setting:general:address','s:81:\"R-30, MIDC Area Rd, MIDC Industrial Area, Rabale, Navi Mumbai, Maharashtra 400701\";',2098420088),('trikuti-battery-cache-setting:general:site_name','s:15:\"Trikuti Battery\";',2098420088),('trikuti-battery-cache-setting:general:site_tagline','s:62:\"Navi Mumbai\'s #1 battery delivery service · Same-day delivery\";',2098420088),('trikuti-battery-cache-setting:general:support_email','s:19:\"vbs622026@gmail.com\";',2098420087),('trikuti-battery-cache-setting:general:support_phone','s:14:\"+91 9920971479\";',2098420087),('trikuti-battery-cache-setting:general:whatsapp_number','s:13:\"+919920971479\";',2098420087),('trikuti-battery-cache-setting:order:default_delivery_charge','i:99;',2100861137),('trikuti-battery-cache-setting:order:default_tax_percent','i:18;',2100858556),('trikuti-battery-cache-setting:order:free_delivery_above','i:2000;',2100858556),('trikuti-battery-cache-setting:seo:bing_verification','s:0:\"\";',2098420088),('trikuti-battery-cache-setting:seo:default_meta_description','s:188:\"Mumbai\'s #1 battery delivery service. Buy genuine Exide, Amaron, SF Sonic batteries with same-day delivery, free installation and old battery exchange across Mumbai, Thane and Navi Mumbai.\";',2098420088),('trikuti-battery-cache-setting:seo:default_meta_title','s:63:\"Buy Car & Bike Batteries Online in Mumbai — Same-day Delivery\";',2098420088),('trikuti-battery-cache-setting:seo:facebook_pixel_id','s:0:\"\";',2098420088),('trikuti-battery-cache-setting:seo:google_analytics_id','s:0:\"\";',2098420088),('trikuti-battery-cache-setting:seo:google_search_console','s:0:\"\";',2098420088),('trikuti-battery-cache-setting:seo:google_tag_manager_id','s:0:\"\";',2098420088),('trikuti-battery-cache-setting:social:facebook','s:21:\"https://facebook.com/\";',2098420088),('trikuti-battery-cache-setting:social:instagram','s:22:\"https://instagram.com/\";',2098420088),('vehicle-battery-store-cache-setting:general:address','s:81:\"R-30, MIDC Area Rd, MIDC Industrial Area, Rabale, Navi Mumbai, Maharashtra 400701\";',2096964432),('vehicle-battery-store-cache-setting:general:site_name','s:21:\"Vehicle Battery Store\";',2096963140),('vehicle-battery-store-cache-setting:general:site_tagline','s:62:\"Navi Mumbai\'s #1 battery delivery service · Same-day delivery\";',2096964432),('vehicle-battery-store-cache-setting:general:support_email','s:19:\"vbs622026@gmail.com\";',2096964430),('vehicle-battery-store-cache-setting:general:support_phone','s:14:\"+91 9920971479\";',2096964430),('vehicle-battery-store-cache-setting:general:whatsapp_number','s:13:\"+919920971479\";',2096964430),('vehicle-battery-store-cache-setting:seo:default_meta_description','s:188:\"Mumbai\'s #1 battery delivery service. Buy genuine Exide, Amaron, SF Sonic batteries with same-day delivery, free installation and old battery exchange across Mumbai, Thane and Navi Mumbai.\";',2096963140),('vehicle-battery-store-cache-setting:seo:default_meta_title','s:63:\"Buy Car & Bike Batteries Online in Mumbai — Same-day Delivery\";',2096963140),('vehicle-battery-store-cache-setting:social:facebook','s:21:\"https://facebook.com/\";',2096964432),('vehicle-battery-store-cache-setting:social:instagram','s:22:\"https://instagram.com/\";',2096964432);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int unsigned NOT NULL DEFAULT '1',
  `price` decimal(10,2) NOT NULL,
  `offer_price` decimal(10,2) DEFAULT NULL,
  `exchange_old_battery` tinyint(1) NOT NULL DEFAULT '0',
  `exchange_discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cart_items_unique` (`cart_id`,`product_id`,`exchange_old_battery`),
  KEY `cart_items_product_id_foreign` (`product_id`),
  CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `cart_items` WRITE;
/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
INSERT INTO `cart_items` VALUES (1,1,2,1,6800.00,5799.00,0,0.00,NULL,'2026-05-22 07:00:51','2026-05-22 07:00:51');
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `session_token` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `exchange_discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `delivery_charge` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `meta` json DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_user_id_index` (`user_id`),
  KEY `carts_session_token_index` (`session_token`),
  KEY `carts_expires_at_index` (`expires_at`),
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (1,1,NULL,NULL,5799.00,0.00,0.00,0.00,1043.82,6842.82,NULL,NULL,'2026-05-22 07:00:51','2026-05-22 07:00:51'),(2,6,NULL,NULL,0.00,0.00,0.00,99.00,0.00,99.00,NULL,NULL,'2026-07-31 06:19:16','2026-07-31 07:26:21');
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` smallint unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_is_active_is_featured_index` (`is_active`,`is_featured`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Car Batteries','car-batteries','Batteries for passenger cars and SUVs.',NULL,1,1,1,'Car Batteries - Buy Online | Trikuti Battery','Shop Car Batteries online with warranty and old battery exchange.','2026-04-30 07:23:10','2026-07-01 07:03:46'),(2,'Bike Batteries','bike-batteries','Two-wheeler batteries for motorcycles and scooters.',NULL,2,1,1,'Bike Batteries - Buy Online | Trikuti Battery','Shop Bike Batteries online with warranty and old battery exchange.','2026-04-30 07:23:10','2026-07-01 07:03:46');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `cms_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cms_pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `show_in_footer` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` smallint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cms_pages_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `cms_pages` WRITE;
/*!40000 ALTER TABLE `cms_pages` DISABLE KEYS */;
INSERT INTO `cms_pages` VALUES (1,'about-us','About Us','<h2>Mumbai\'s trusted battery delivery service</h2>\n<p>Trikuti Battery delivers genuine automotive batteries to your doorstep across Mumbai, Thane and Navi Mumbai — with free same-day or next-day delivery for most pincodes.</p>\n\n<h3>Why choose us</h3>\n<ul>\n<li><strong>Genuine batteries only</strong> — sourced directly from authorised dealers of Exide, Amaron, SF Sonic and other top brands</li>\n<li><strong>Same-day delivery in Mumbai</strong> — order before 2pm for same-day delivery to all Mumbai City and Suburbs pincodes</li>\n<li><strong>Free installation</strong> — our technician installs the battery and takes your old battery away</li>\n<li><strong>Old battery exchange</strong> — get up to ₹800 off when you exchange your old battery</li>\n<li><strong>Full manufacturer warranty</strong> — every battery comes with the brand\'s official warranty (24-48 months)</li>\n</ul>\n\n<h3>Service area</h3>\n<p>We currently serve:</p>\n<ul>\n<li>Mumbai City and Suburbs (400001 – 400104) — <strong>free delivery, same/next day</strong></li>\n<li>Thane (400601 – 400615) — ₹99 delivery, 2 business days</li>\n<li>Navi Mumbai (400701 – 400710) — ₹99 delivery, 2 business days</li>\n</ul>\n\n<h3>Payment options</h3>\n<p>Cash on Delivery is our primary option — pay when the battery is delivered to your doorstep. UPI (Google Pay / PhonePe / Paytm) accepted at delivery too.</p>','About Us | Mumbai Battery Store','About Us — Mumbai\'s trusted battery delivery service.',1,1,1,'2026-04-30 07:23:10','2026-07-31 04:46:45'),(2,'contact-us','Contact Us','<h2>Get in touch</h2>\n<p>We\'re here to help with your battery purchase, installation, or warranty questions.</p>\n\n<div style=\"display:grid;gap:1rem;grid-template-columns:1fr 1fr;margin:1.5rem 0;\">\n  <div>\n    <h3>📞 Phone</h3>\n    <p><strong>+91 9920971479</strong><br>\n    <small>Monday – Saturday, 9am to 8pm</small></p>\n  </div>\n  <div>\n    <h3>💬 WhatsApp</h3>\n    <p><strong>+91 9920971479</strong><br>\n    <small>Quick replies on quotes and order status</small></p>\n  </div>\n  <div>\n    <h3>📧 Email</h3>\n    <p><a href=\"mailto:vbs622026@gmail.com\">vbs622026@gmail.com</a><br>\n    <small>Replies within 4 working hours</small></p>\n  </div>\n  <div>\n    <h3>📍 Address</h3>\n    <p>Trikuti Battery<br>\n    R-30, MIDC Area Rd, MIDC Industrial Area<br>\n    Rabale, Navi Mumbai, Maharashtra 400701</p>\n  </div>\n</div>\n\n<h3>Service hours</h3>\n<ul>\n<li>Mon – Sat: 9:00 AM – 8:00 PM</li>\n<li>Sunday: Closed (emergency orders via WhatsApp)</li>\n</ul>\n\n<h3>Delivery area</h3>\n<p>All Mumbai (400001 – 400104), Thane (400601 – 400615) and Navi Mumbai (400701 – 400710). Check delivery to your pincode on any product page.</p>','Contact Us | Mumbai Battery Store','Contact Us — Mumbai\'s trusted battery delivery service.',1,1,2,'2026-04-30 07:23:10','2026-07-01 06:44:21'),(3,'privacy-policy','Privacy Policy','<p>We respect your privacy. <em>Replace this with your real privacy policy.</em></p>','Privacy Policy | Mumbai Battery Store','Privacy Policy — Mumbai\'s trusted battery delivery service.',1,1,3,'2026-04-30 07:23:10','2026-06-15 01:47:11'),(4,'terms-and-conditions','Terms & Conditions','<p><em>Replace this with your real terms and conditions before going live.</em></p>','Terms & Conditions | Mumbai Battery Store','Terms & Conditions — Mumbai\'s trusted battery delivery service.',1,1,4,'2026-04-30 07:23:10','2026-06-15 01:47:11');
/*!40000 ALTER TABLE `cms_pages` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','read','replied','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_messages_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `coupon_usages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupon_usages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `coupon_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `order_id` bigint unsigned DEFAULT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `used_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `coupon_usages_user_id_foreign` (`user_id`),
  KEY `coupon_usages_coupon_id_user_id_index` (`coupon_id`,`user_id`),
  CONSTRAINT `coupon_usages_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `coupon_usages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `coupon_usages` WRITE;
/*!40000 ALTER TABLE `coupon_usages` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupon_usages` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` enum('percentage','flat') COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `max_discount` decimal(10,2) DEFAULT NULL,
  `min_order_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `usage_limit` int unsigned DEFAULT NULL,
  `per_user_limit` int unsigned NOT NULL DEFAULT '1',
  `used_count` int unsigned NOT NULL DEFAULT '0',
  `starts_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_first_order_only` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupons_code_unique` (`code`),
  KEY `coupons_is_active_expires_at_index` (`is_active`,`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` VALUES (1,'WELCOME200','Welcome Offer','Flat ₹200 off on your first order.','flat',200.00,NULL,1500.00,NULL,1,0,NULL,'2027-04-30 07:23:10',1,1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(2,'SAVE10','10% Off','10% off up to ₹500 on orders above ₹3000.','percentage',10.00,500.00,3000.00,NULL,1,0,NULL,'2027-04-30 07:23:10',1,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(3,'FESTIVE500','Festival Offer','Flat ₹500 off on orders above ₹5000.','flat',500.00,NULL,5000.00,NULL,1,0,NULL,'2027-04-30 07:23:10',1,0,'2026-04-30 07:23:10','2026-04-30 07:23:10');
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `question` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` smallint unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `faqs_category_index` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `faqs` WRITE;
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
INSERT INTO `faqs` VALUES (1,'Order','How long does delivery take?','Most metro pincodes get same-day or next-day delivery. Other locations take 2-4 business days.',1,1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(2,'Order','Can I cancel my order?','Yes, you can cancel from your account any time before the battery is dispatched.',4,1,'2026-04-30 07:23:10','2026-06-15 01:47:11'),(3,'Battery','What is old battery exchange?','You can return your old battery and get an exchange discount on the new battery.',3,1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(4,'Battery','How is the warranty period calculated?','Warranty starts from the date of delivery and is provided directly by the battery manufacturer (Exide, Amaron, etc.).',6,1,'2026-04-30 07:23:10','2026-06-15 01:47:11'),(5,'Payment','What payment methods are supported?','UPI, debit/credit cards, and Cash on Delivery.',5,1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(6,'Payment','Is COD available?','Yes, COD is available for orders below ₹20,000 in most pincodes.',6,1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(7,'Delivery','How fast is delivery in Mumbai?','For all Mumbai City and Suburbs pincodes (400001 – 400104), we deliver same-day for orders placed before 2pm, and next-day for later orders. Thane and Navi Mumbai take 2 business days.',1,1,'2026-06-15 01:47:11','2026-06-15 01:47:11'),(8,'Delivery','Is delivery free?','Yes — free delivery across all Mumbai City and Suburbs pincodes. Thane and Navi Mumbai have a flat ₹99 delivery charge.',2,1,'2026-06-15 01:47:11','2026-06-15 01:47:11'),(9,'Delivery','Do you install the battery?','Yes, free installation is included with every battery delivery. Our technician will install the new battery and take your old one away.',3,1,'2026-06-15 01:47:11','2026-06-15 01:47:11'),(10,'Battery','How does old battery exchange work?','Add the exchange option when adding a battery to cart. Hand over your old battery to the technician during installation and get up to ₹800 off instantly.',5,1,'2026-06-15 01:47:11','2026-06-15 01:47:11'),(11,'Payment','What payment methods do you accept?','Cash on Delivery (COD) and UPI (Google Pay / PhonePe / Paytm) at the time of delivery. Our team confirms the final amount over a call before dispatch.',7,1,'2026-06-15 01:47:11','2026-07-31 04:46:45'),(12,'Payment','Is COD available across Mumbai?','Yes, COD is available for all serviceable pincodes including Mumbai, Thane and Navi Mumbai.',8,1,'2026-06-15 01:47:11','2026-07-31 04:46:45');
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `fitments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fitments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `vehicle_variant_id` bigint unsigned NOT NULL,
  `notes` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_recommended` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fitments_product_id_vehicle_variant_id_unique` (`product_id`,`vehicle_variant_id`),
  KEY `fitments_vehicle_variant_id_index` (`vehicle_variant_id`),
  CONSTRAINT `fitments_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fitments_vehicle_variant_id_foreign` FOREIGN KEY (`vehicle_variant_id`) REFERENCES `vehicle_variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `fitments` WRITE;
/*!40000 ALTER TABLE `fitments` DISABLE KEYS */;
INSERT INTO `fitments` VALUES (1,1,1,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(2,1,2,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(3,1,3,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(4,1,4,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(5,1,5,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(6,1,6,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(7,1,7,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(8,1,8,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(9,1,9,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(10,1,12,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(11,1,10,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(12,1,11,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(13,1,13,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(14,2,1,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(15,2,2,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(16,2,3,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(17,2,4,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(18,2,5,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(19,2,6,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(20,2,7,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(21,2,8,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(22,2,9,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(23,2,12,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(24,2,10,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(25,2,11,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(26,2,13,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(27,3,1,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(28,3,2,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(29,3,3,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(30,3,4,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(31,3,5,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(32,3,6,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(33,3,7,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(34,3,8,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(35,3,9,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(36,3,12,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(37,3,10,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(38,3,11,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(39,3,13,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(40,4,21,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(41,4,14,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(42,4,15,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(43,4,16,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(44,4,17,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(45,4,20,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(46,4,18,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(47,4,19,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(48,5,21,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(49,5,14,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(50,5,15,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(51,5,16,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(52,5,17,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(53,5,20,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(54,5,18,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(55,5,19,NULL,0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(56,6,1,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(57,6,2,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(58,6,3,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(59,6,4,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(60,6,5,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(61,6,6,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(62,6,7,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(63,6,8,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(64,6,9,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(65,6,12,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(66,6,10,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(67,6,11,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(68,6,13,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(69,7,1,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(70,7,2,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(71,7,3,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(72,7,4,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(73,7,5,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(74,7,6,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(75,7,7,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(76,7,8,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(77,7,9,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(78,7,12,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(79,7,10,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(80,7,11,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(81,7,13,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(82,11,1,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(83,11,2,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(84,11,3,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(85,11,4,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(86,11,5,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(87,11,6,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(88,11,7,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(89,11,8,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(90,11,9,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(91,11,12,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(92,11,10,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(93,11,11,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(94,11,13,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(95,12,1,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(96,12,2,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(97,12,3,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(98,12,4,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(99,12,5,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(100,12,6,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(101,12,7,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(102,12,8,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(103,12,9,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(104,12,12,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(105,12,10,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(106,12,11,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(107,12,13,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(108,13,1,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(109,13,2,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(110,13,3,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(111,13,4,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(112,13,5,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(113,13,6,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(114,13,7,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(115,13,8,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(116,13,9,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(117,13,12,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(118,13,10,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(119,13,11,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(120,13,13,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(121,14,1,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(122,14,2,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(123,14,3,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(124,14,4,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(125,14,5,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(126,14,6,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(127,14,7,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(128,14,8,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(129,14,9,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(130,14,12,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(131,14,10,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(132,14,11,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(133,14,13,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(134,15,1,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(135,15,2,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(136,15,3,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(137,15,4,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(138,15,5,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(139,15,6,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(140,15,7,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(141,15,8,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(142,15,9,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(143,15,12,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(144,15,10,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(145,15,11,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(146,15,13,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(147,16,1,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(148,16,2,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(149,16,3,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(150,16,4,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(151,16,5,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(152,16,6,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(153,16,7,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(154,16,8,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(155,16,9,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(156,16,12,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(157,16,10,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(158,16,11,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(159,16,13,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(160,17,1,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(161,17,2,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(162,17,3,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(163,17,4,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(164,17,5,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(165,17,6,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(166,17,7,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(167,17,8,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(168,17,9,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(169,17,12,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(170,17,10,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(171,17,11,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(172,17,13,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(173,18,1,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(174,18,2,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(175,18,3,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(176,18,4,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(177,18,5,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(178,18,6,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(179,18,7,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(180,18,8,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(181,18,9,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(182,18,12,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(183,18,10,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(184,18,11,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(185,18,13,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(186,19,1,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(187,19,2,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(188,19,3,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(189,19,4,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(190,19,5,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(191,19,6,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(192,19,7,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(193,19,8,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(194,19,9,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(195,19,12,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(196,19,10,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(197,19,11,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(198,19,13,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(199,20,1,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(200,20,2,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(201,20,3,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(202,20,4,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(203,20,5,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(204,20,6,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(205,20,7,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(206,20,8,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(207,20,9,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(208,20,12,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(209,20,10,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(210,20,11,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(211,20,13,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(212,21,1,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(213,21,2,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(214,21,3,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(215,21,4,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(216,21,5,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(217,21,6,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(218,21,7,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(219,21,8,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(220,21,9,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(221,21,12,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(222,21,10,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(223,21,11,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(224,21,13,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(225,22,21,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(226,22,14,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(227,22,15,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(228,22,16,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(229,22,17,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(230,22,20,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(231,22,18,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(232,22,19,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(233,24,21,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(234,24,14,NULL,0,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(235,24,15,NULL,0,'2026-07-31 07:05:56','2026-07-31 07:05:56'),(236,24,16,NULL,0,'2026-07-31 07:05:56','2026-07-31 07:05:56'),(237,24,17,NULL,0,'2026-07-31 07:05:56','2026-07-31 07:05:56'),(238,24,20,NULL,0,'2026-07-31 07:05:56','2026-07-31 07:05:56'),(239,24,18,NULL,0,'2026-07-31 07:05:56','2026-07-31 07:05:56'),(240,24,19,NULL,0,'2026-07-31 07:05:56','2026-07-31 07:05:56');
/*!40000 ALTER TABLE `fitments` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_04_29_100000_create_roles_table',1),(5,'2025_04_29_100001_add_columns_to_users_table',1),(6,'2025_04_29_100002_create_addresses_table',1),(7,'2025_04_29_100003_create_vehicle_types_table',1),(8,'2025_04_29_100004_create_vehicle_brands_table',1),(9,'2025_04_29_100005_create_vehicle_models_table',1),(10,'2025_04_29_100006_create_vehicle_variants_table',1),(11,'2025_04_29_100007_create_battery_brands_table',1),(12,'2025_04_29_100008_create_categories_table',1),(13,'2025_04_29_100009_create_products_table',1),(14,'2025_04_29_100010_create_product_images_table',1),(15,'2025_04_29_100011_create_product_specifications_table',1),(16,'2025_04_29_100012_create_fitments_table',1),(17,'2025_04_29_100013_create_carts_table',1),(18,'2025_04_29_100014_create_cart_items_table',1),(19,'2025_04_29_100015_create_coupons_table',1),(20,'2025_04_29_100016_create_coupon_usages_table',1),(21,'2025_04_29_100017_create_orders_table',1),(22,'2025_04_29_100018_create_order_items_table',1),(23,'2025_04_29_100019_create_order_status_logs_table',1),(24,'2025_04_29_100020_create_payments_table',1),(25,'2025_04_29_100021_create_reviews_table',1),(26,'2025_04_29_100022_create_review_images_table',1),(27,'2025_04_29_100023_create_cms_pages_table',1),(28,'2025_04_29_100024_create_banners_table',1),(29,'2025_04_29_100025_create_testimonials_table',1),(30,'2025_04_29_100026_create_faqs_table',1),(31,'2025_04_29_100027_create_settings_table',1),(32,'2025_04_29_100028_create_contact_messages_table',1),(33,'2025_04_29_100029_create_notifications_table',1),(34,'2025_04_29_100030_create_personal_access_tokens_table',1),(35,'2025_04_30_100000_create_audit_logs_table',1),(36,'2025_04_30_100001_create_otp_codes_table',1),(37,'2025_04_30_100002_create_warehouses_table',1),(38,'2025_04_30_100003_create_stocks_table',1),(39,'2025_04_30_100004_create_stock_movements_table',1),(40,'2025_04_30_100005_create_installer_jobs_table',1),(41,'2025_04_30_100006_add_installation_fields_to_orders_table',1),(42,'2025_05_01_100000_create_wishlists_table',1),(43,'2025_05_01_100001_create_newsletter_subscribers_table',1),(44,'2025_05_02_100000_create_blog_categories_table',1),(45,'2025_05_02_100001_create_blog_posts_table',1),(46,'2025_05_02_100002_create_pincodes_table',1),(47,'2025_05_02_100003_create_order_returns_table',1),(48,'2025_05_02_100004_create_warranty_claims_table',1),(49,'2025_05_02_100005_create_redirects_table',1),(50,'2026_05_22_100000_drop_blog_tables',2),(51,'2026_05_22_100001_drop_roles_warehouses_installer',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `newsletter_subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `newsletter_subscribers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `source` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unsubscribed_at` timestamp NULL DEFAULT NULL,
  `unsubscribe_token` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsletter_subscribers_email_unique` (`email`),
  UNIQUE KEY `newsletter_subscribers_unsubscribe_token_unique` (`unsubscribe_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `newsletter_subscribers` WRITE;
/*!40000 ALTER TABLE `newsletter_subscribers` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_subscribers` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `product_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_sku` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_brand` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int unsigned NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `offer_price` decimal(10,2) DEFAULT NULL,
  `exchange_old_battery` tinyint(1) NOT NULL DEFAULT '0',
  `exchange_discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `warranty_months` smallint unsigned NOT NULL DEFAULT '0',
  `warranty_starts_at` date DEFAULT NULL,
  `warranty_ends_at` date DEFAULT NULL,
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_index` (`order_id`),
  KEY `order_items_product_id_index` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `order_returns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_returns` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `order_item_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `quantity` int unsigned NOT NULL DEFAULT '1',
  `reason` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'requested',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `reviewed_by` bigint unsigned DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `refunded_at` timestamp NULL DEFAULT NULL,
  `refund_amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_returns_order_item_id_foreign` (`order_item_id`),
  KEY `order_returns_user_id_foreign` (`user_id`),
  KEY `order_returns_reviewed_by_foreign` (`reviewed_by`),
  KEY `order_returns_order_id_index` (`order_id`),
  KEY `order_returns_status_index` (`status`),
  CONSTRAINT `order_returns_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_returns_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE SET NULL,
  CONSTRAINT `order_returns_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `order_returns_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `order_returns` WRITE;
/*!40000 ALTER TABLE `order_returns` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_returns` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `order_status_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_status_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `from_status` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `changed_by` bigint unsigned DEFAULT NULL,
  `source` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'system',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_status_logs_changed_by_foreign` (`changed_by`),
  KEY `order_status_logs_order_id_index` (`order_id`),
  CONSTRAINT `order_status_logs_changed_by_foreign` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `order_status_logs_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `order_status_logs` WRITE;
/*!40000 ALTER TABLE `order_status_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_status_logs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `billing_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_email` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_line1` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_line2` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_city` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_state` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_pincode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_country` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'India',
  `shipping_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_line1` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_line2` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_landmark` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_city` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_state` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_pincode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_country` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'India',
  `subtotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `exchange_discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `delivery_charge` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL,
  `coupon_id` bigint unsigned DEFAULT NULL,
  `coupon_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` enum('cod','upi','card') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cod',
  `exchange_pickup_required` tinyint(1) NOT NULL DEFAULT '0',
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `dispatched_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `cancellation_reason` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_coupon_id_foreign` (`coupon_id`),
  KEY `orders_user_id_index` (`user_id`),
  KEY `orders_status_index` (`status`),
  KEY `orders_payment_status_index` (`payment_status`),
  KEY `orders_created_at_index` (`created_at`),
  CONSTRAINT `orders_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `otp_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `otp_codes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `channel` enum('email','sms','whatsapp') COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose` enum('login','register','password_reset','phone_verify','email_verify','order_install') COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL DEFAULT '0',
  `expires_at` timestamp NOT NULL,
  `consumed_at` timestamp NULL DEFAULT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `otp_codes_identifier_purpose_index` (`identifier`,`purpose`),
  KEY `otp_codes_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `otp_codes` WRITE;
/*!40000 ALTER TABLE `otp_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `otp_codes` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `gateway` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gateway_order_id` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_payment_id` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_signature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INR',
  `status` enum('initiated','success','failed','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'initiated',
  `method` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `response` json DEFAULT NULL,
  `error_message` text COLLATE utf8mb4_unicode_ci,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_user_id_foreign` (`user_id`),
  KEY `payments_order_id_index` (`order_id`),
  KEY `payments_gateway_order_id_index` (`gateway_order_id`),
  KEY `payments_status_index` (`status`),
  CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `pincodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pincodes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pincode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_serviceable` tinyint(1) NOT NULL DEFAULT '1',
  `cod_available` tinyint(1) NOT NULL DEFAULT '1',
  `delivery_charge` decimal(8,2) NOT NULL DEFAULT '0.00',
  `expected_delivery_days` tinyint unsigned NOT NULL DEFAULT '3',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pincodes_pincode_unique` (`pincode`),
  KEY `pincodes_city_index` (`city`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `pincodes` WRITE;
/*!40000 ALTER TABLE `pincodes` DISABLE KEYS */;
INSERT INTO `pincodes` VALUES (1,'400001','Fort','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-04-30 07:23:10','2026-06-15 01:47:12'),(2,'400050','Bandra West','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-04-30 07:23:10','2026-06-15 01:47:13'),(3,'110001','New Delhi','Delhi',NULL,1,1,0.00,1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(4,'110020','New Delhi','Delhi',NULL,1,1,0.00,1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(5,'560001','Bangalore','Karnataka',NULL,1,1,0.00,1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(6,'560066','Bangalore','Karnataka',NULL,1,1,0.00,2,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(7,'500001','Hyderabad','Telangana',NULL,1,1,0.00,2,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(8,'500081','Hyderabad','Telangana',NULL,1,1,0.00,1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(9,'600001','Chennai','Tamil Nadu',NULL,1,1,99.00,3,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(10,'700001','Kolkata','West Bengal',NULL,1,1,99.00,3,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(11,'380001','Ahmedabad','Gujarat',NULL,1,1,99.00,3,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(12,'411001','Pune','Maharashtra',NULL,1,1,0.00,2,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(13,'400002','Kalbadevi','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(14,'400003','Masjid Bunder','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(15,'400004','Girgaon','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(16,'400005','Colaba','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(17,'400006','Malabar Hill','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(18,'400007','Grant Road','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(19,'400008','Mumbai Central','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(20,'400009','Chinchpokli','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(21,'400010','Mazgaon','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(22,'400011','Lalbaug','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(23,'400012','Parel','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(24,'400013','Lower Parel','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(25,'400014','Dadar East','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(26,'400015','Sewri','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(27,'400016','Mahim','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(28,'400017','Matunga','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(29,'400018','Worli','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(30,'400019','Matunga East','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(31,'400020','Marine Lines','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(32,'400021','Nariman Point','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(33,'400022','Sion','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(34,'400024','Kurla West','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(35,'400025','Prabhadevi','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(36,'400026','Breach Candy','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(37,'400028','Dadar West','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(38,'400029','Santacruz','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(39,'400049','Khar West','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(40,'400051','Bandra Kurla Complex','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(41,'400052','Bandra','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(42,'400053','Andheri West','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(43,'400054','Santacruz West','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(44,'400055','Santacruz East','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(45,'400056','Vile Parle West','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(46,'400057','Vile Parle East','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(47,'400058','Andheri West','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(48,'400059','Marol','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(49,'400060','SEEPZ','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(50,'400061','Madh Island','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(51,'400062','Goregaon West','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(52,'400063','Goregaon West','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(53,'400064','Malad West','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(54,'400065','Aarey Colony','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(55,'400066','Borivali East','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(56,'400067','Kandivali West','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(57,'400068','Borivali West','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(58,'400069','Andheri East','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(59,'400090','Charkop','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(60,'400091','Borivali West','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(61,'400092','Borivali West','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(62,'400093','Andheri East','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(63,'400095','Borivali East','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(64,'400097','Malad East','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(65,'400099','Andheri East (Airport)','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(66,'400101','Kandivali East','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(67,'400102','Andheri West (Lokhandwala)','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(68,'400103','Kandivali East','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(69,'400104','Malad West','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(70,'400070','Kurla East','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(71,'400071','Chembur','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(72,'400072','Saki Naka','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(73,'400074','Chembur Naka','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(74,'400075','Ghatkopar West','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(75,'400076','Powai','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(76,'400077','Ghatkopar East','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(77,'400078','Bhandup','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(78,'400079','Vikhroli','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(79,'400080','Mulund West','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(80,'400081','Mulund East','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(81,'400082','Bhandup West','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(82,'400083','Vikhroli East','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(83,'400084','Ghatkopar','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(84,'400086','Pant Nagar','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(85,'400088','Govandi','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(86,'400089','Chembur East','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(87,'400094','Anushakti Nagar','Maharashtra','Mumbai Metro',1,1,0.00,1,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(88,'400601','Thane West','Maharashtra','Thane',1,1,99.00,2,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(89,'400602','Thane West','Maharashtra','Thane',1,1,99.00,2,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(90,'400603','Pokhran','Maharashtra','Thane',1,1,99.00,2,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(91,'400604','Manpada','Maharashtra','Thane',1,1,99.00,2,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(92,'400605','Wagle Estate','Maharashtra','Thane',1,1,99.00,2,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(93,'400606','Thane (CIDCO)','Maharashtra','Thane',1,1,99.00,2,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(94,'400607','Thane East','Maharashtra','Thane',1,1,99.00,2,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(95,'400608','Hiranandani Estate','Maharashtra','Thane',1,1,99.00,2,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(96,'400610','Mulund East','Maharashtra','Thane',1,1,99.00,2,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(97,'400612','Thane West','Maharashtra','Thane',1,1,99.00,2,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(98,'400615','Thane','Maharashtra','Thane',1,1,99.00,2,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(99,'400614','Vashi','Maharashtra','Navi Mumbai',1,1,99.00,2,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(100,'400701','Rabale','Maharashtra','Navi Mumbai',1,1,99.00,2,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(101,'400702','Airoli','Maharashtra','Navi Mumbai',1,1,99.00,2,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(102,'400703','Ghansoli','Maharashtra','Navi Mumbai',1,1,99.00,2,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(103,'400705','CBD Belapur','Maharashtra','Navi Mumbai',1,1,99.00,2,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(104,'400706','Nerul','Maharashtra','Navi Mumbai',1,1,99.00,2,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(105,'400707','Sanpada','Maharashtra','Navi Mumbai',1,1,99.00,2,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(106,'400708','Kalamboli','Maharashtra','Navi Mumbai',1,1,99.00,2,'2026-06-15 01:47:13','2026-06-15 01:47:13'),(107,'400709','Kopar Khairane','Maharashtra','Navi Mumbai',1,1,99.00,2,'2026-06-15 01:47:14','2026-06-15 01:47:14'),(108,'400710','Turbhe','Maharashtra','Navi Mumbai',1,1,99.00,2,'2026-06-15 01:47:14','2026-06-15 01:47:14');
/*!40000 ALTER TABLE `pincodes` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` smallint unsigned NOT NULL DEFAULT '0',
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_is_primary_index` (`product_id`,`is_primary`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (1,1,'products/placeholder.svg','Exide Mileage MLDIN55 55Ah',0,1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(2,2,'products/placeholder.svg','Amaron Hi-Life Pro 45Ah',0,1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(3,3,'products/placeholder.svg','Amaron Hi-Life 40Ah',0,1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(4,4,'products/placeholder.svg','Exide MotoMatic 9Ah',0,1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(5,5,'products/placeholder.svg','SF Sonic Motozone 5Ah',0,1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(6,6,'products/placeholder.svg','Amaron Hi-Life Pro 35Ah',0,1,'2026-07-31 07:02:46','2026-07-31 07:02:46'),(7,7,'products/placeholder.svg','Exide Mileage MLDIN44 44Ah',0,1,'2026-07-31 07:02:46','2026-07-31 07:02:46'),(8,11,'products/placeholder.svg','Amaron Hi-Life Pro 45Ah',0,1,'2026-07-31 07:05:20','2026-07-31 07:05:20'),(9,12,'products/placeholder.svg','Exide Matrix MTR-DIN55 55Ah',0,1,'2026-07-31 07:05:20','2026-07-31 07:05:20'),(10,13,'products/placeholder.svg','Amaron Hi-Life Pro 65Ah (DIN65)',0,1,'2026-07-31 07:05:20','2026-07-31 07:05:20'),(11,14,'products/placeholder.svg','SF Sonic FSF0-DIN65 65Ah',0,1,'2026-07-31 07:05:20','2026-07-31 07:05:20'),(12,15,'products/placeholder.svg','Amaron Hi-Life Pro 75Ah (DIN75)',0,1,'2026-07-31 07:05:20','2026-07-31 07:05:20'),(13,16,'products/placeholder.svg','Exide MP-DIN80 80Ah',0,1,'2026-07-31 07:05:20','2026-07-31 07:05:20'),(14,17,'products/placeholder.svg','Amaron Hi-Life Pro 80Ah (DIN80)',0,1,'2026-07-31 07:05:20','2026-07-31 07:05:20'),(15,18,'products/placeholder.svg','SF Sonic FSF0-DIN80 80Ah',0,1,'2026-07-31 07:05:20','2026-07-31 07:05:20'),(16,19,'products/placeholder.svg','Amaron Hi-Life 100Ah (DIN100)',0,1,'2026-07-31 07:05:20','2026-07-31 07:05:20'),(17,20,'products/placeholder.svg','Exide MI-DIN100 100Ah',0,1,'2026-07-31 07:05:20','2026-07-31 07:05:20'),(18,21,'products/placeholder.svg','Exide MI-DIN120 120Ah',0,1,'2026-07-31 07:05:21','2026-07-31 07:05:21'),(19,22,'products/placeholder.svg','Amaron Pro Bike Rider 5Ah',0,1,'2026-07-31 07:05:21','2026-07-31 07:05:21'),(20,24,'products/placeholder.svg','Exide MotoMatic 9Ah',0,1,'2026-07-31 07:05:55','2026-07-31 07:05:55');
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `product_specifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_specifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `group` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `key` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` smallint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_specifications_product_id_group_index` (`product_id`,`group`),
  CONSTRAINT `product_specifications_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=306 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `product_specifications` WRITE;
/*!40000 ALTER TABLE `product_specifications` DISABLE KEYS */;
INSERT INTO `product_specifications` VALUES (1,1,'Battery','Capacity','55.00 Ah',1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(2,1,'Battery','Voltage','12.00 V',2,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(3,1,'Battery','Maintenance','Maintenance Free',3,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(4,1,'Warranty','Warranty Period','48 months',4,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(5,1,'Physical','Weight','14.500 kg',5,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(6,2,'Battery','Capacity','45.00 Ah',1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(7,2,'Battery','Voltage','12.00 V',2,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(8,2,'Battery','Maintenance','Maintenance Free',3,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(9,2,'Warranty','Warranty Period','60 months',4,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(10,2,'Physical','Weight','12.800 kg',5,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(11,3,'Battery','Capacity','40.00 Ah',1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(12,3,'Battery','Voltage','12.00 V',2,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(13,3,'Battery','Maintenance','Maintenance Free',3,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(14,3,'Warranty','Warranty Period','48 months',4,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(15,3,'Physical','Weight','11.200 kg',5,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(16,4,'Battery','Capacity','9.00 Ah',1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(17,4,'Battery','Voltage','12.00 V',2,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(18,4,'Battery','Maintenance','Maintenance Free',3,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(19,4,'Warranty','Warranty Period','36 months',4,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(20,4,'Physical','Weight','3.400 kg',5,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(21,5,'Battery','Capacity','5.00 Ah',1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(22,5,'Battery','Voltage','12.00 V',2,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(23,5,'Battery','Maintenance','Maintenance Free',3,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(24,5,'Warranty','Warranty Period','24 months',4,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(25,5,'Physical','Weight','1.800 kg',5,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(186,6,'Battery','Capacity','35.00 Ah',1,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(187,6,'Battery','Voltage','12.00 V',2,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(188,6,'Battery','Type','Maintenance-Free (MF) · Sealed Lead Acid',3,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(189,6,'Warranty','Warranty Period','48 months',4,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(190,6,'Warranty','Coverage','Full manufacturer warranty · we handle claims',5,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(191,6,'Delivery','Availability','Mumbai · Thane · Navi Mumbai',6,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(192,6,'Delivery','Installation','Free on-site installation',7,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(193,6,'Delivery','Old battery','₹500 off on exchange',8,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(194,7,'Battery','Capacity','44.00 Ah',1,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(195,7,'Battery','Voltage','12.00 V',2,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(196,7,'Battery','Type','Maintenance-Free (MF) · Sealed Lead Acid',3,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(197,7,'Warranty','Warranty Period','48 months',4,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(198,7,'Warranty','Coverage','Full manufacturer warranty · we handle claims',5,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(199,7,'Delivery','Availability','Mumbai · Thane · Navi Mumbai',6,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(200,7,'Delivery','Installation','Free on-site installation',7,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(201,7,'Delivery','Old battery','₹550 off on exchange',8,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(202,11,'Battery','Capacity','45.00 Ah',1,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(203,11,'Battery','Voltage','12.00 V',2,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(204,11,'Battery','Type','Maintenance-Free (MF) · Sealed Lead Acid',3,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(205,11,'Warranty','Warranty Period','48 months',4,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(206,11,'Warranty','Coverage','Full manufacturer warranty · we handle claims',5,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(207,11,'Delivery','Availability','Mumbai · Thane · Navi Mumbai',6,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(208,11,'Delivery','Installation','Free on-site installation',7,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(209,11,'Delivery','Old battery','₹600 off on exchange',8,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(210,12,'Battery','Capacity','55.00 Ah',1,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(211,12,'Battery','Voltage','12.00 V',2,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(212,12,'Battery','Type','Maintenance-Free (MF) · Sealed Lead Acid',3,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(213,12,'Warranty','Warranty Period','48 months',4,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(214,12,'Warranty','Coverage','Full manufacturer warranty · we handle claims',5,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(215,12,'Delivery','Availability','Mumbai · Thane · Navi Mumbai',6,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(216,12,'Delivery','Installation','Free on-site installation',7,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(217,12,'Delivery','Old battery','₹700 off on exchange',8,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(218,13,'Battery','Capacity','65.00 Ah',1,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(219,13,'Battery','Voltage','12.00 V',2,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(220,13,'Battery','Type','Maintenance-Free (MF) · Sealed Lead Acid',3,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(221,13,'Warranty','Warranty Period','55 months',4,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(222,13,'Warranty','Coverage','Full manufacturer warranty · we handle claims',5,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(223,13,'Delivery','Availability','Mumbai · Thane · Navi Mumbai',6,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(224,13,'Delivery','Installation','Free on-site installation',7,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(225,13,'Delivery','Old battery','₹800 off on exchange',8,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(226,14,'Battery','Capacity','65.00 Ah',1,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(227,14,'Battery','Voltage','12.00 V',2,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(228,14,'Battery','Type','Maintenance-Free (MF) · Sealed Lead Acid',3,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(229,14,'Warranty','Warranty Period','48 months',4,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(230,14,'Warranty','Coverage','Full manufacturer warranty · we handle claims',5,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(231,14,'Delivery','Availability','Mumbai · Thane · Navi Mumbai',6,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(232,14,'Delivery','Installation','Free on-site installation',7,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(233,14,'Delivery','Old battery','₹700 off on exchange',8,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(234,15,'Battery','Capacity','75.00 Ah',1,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(235,15,'Battery','Voltage','12.00 V',2,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(236,15,'Battery','Type','Maintenance-Free (MF) · Sealed Lead Acid',3,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(237,15,'Warranty','Warranty Period','55 months',4,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(238,15,'Warranty','Coverage','Full manufacturer warranty · we handle claims',5,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(239,15,'Delivery','Availability','Mumbai · Thane · Navi Mumbai',6,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(240,15,'Delivery','Installation','Free on-site installation',7,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(241,15,'Delivery','Old battery','₹800 off on exchange',8,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(242,16,'Battery','Capacity','80.00 Ah',1,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(243,16,'Battery','Voltage','12.00 V',2,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(244,16,'Battery','Type','Maintenance-Free (MF) · Sealed Lead Acid',3,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(245,16,'Warranty','Warranty Period','55 months',4,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(246,16,'Warranty','Coverage','Full manufacturer warranty · we handle claims',5,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(247,16,'Delivery','Availability','Mumbai · Thane · Navi Mumbai',6,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(248,16,'Delivery','Installation','Free on-site installation',7,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(249,16,'Delivery','Old battery','₹900 off on exchange',8,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(250,17,'Battery','Capacity','80.00 Ah',1,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(251,17,'Battery','Voltage','12.00 V',2,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(252,17,'Battery','Type','Maintenance-Free (MF) · Sealed Lead Acid',3,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(253,17,'Warranty','Warranty Period','55 months',4,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(254,17,'Warranty','Coverage','Full manufacturer warranty · we handle claims',5,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(255,17,'Delivery','Availability','Mumbai · Thane · Navi Mumbai',6,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(256,17,'Delivery','Installation','Free on-site installation',7,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(257,17,'Delivery','Old battery','₹900 off on exchange',8,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(258,18,'Battery','Capacity','80.00 Ah',1,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(259,18,'Battery','Voltage','12.00 V',2,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(260,18,'Battery','Type','Maintenance-Free (MF) · Sealed Lead Acid',3,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(261,18,'Warranty','Warranty Period','48 months',4,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(262,18,'Warranty','Coverage','Full manufacturer warranty · we handle claims',5,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(263,18,'Delivery','Availability','Mumbai · Thane · Navi Mumbai',6,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(264,18,'Delivery','Installation','Free on-site installation',7,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(265,18,'Delivery','Old battery','₹800 off on exchange',8,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(266,19,'Battery','Capacity','100.00 Ah',1,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(267,19,'Battery','Voltage','12.00 V',2,'2026-07-31 07:05:54','2026-07-31 07:05:54'),(268,19,'Battery','Type','Maintenance-Free (MF) · Sealed Lead Acid',3,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(269,19,'Warranty','Warranty Period','55 months',4,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(270,19,'Warranty','Coverage','Full manufacturer warranty · we handle claims',5,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(271,19,'Delivery','Availability','Mumbai · Thane · Navi Mumbai',6,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(272,19,'Delivery','Installation','Free on-site installation',7,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(273,19,'Delivery','Old battery','₹1,000 off on exchange',8,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(274,20,'Battery','Capacity','100.00 Ah',1,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(275,20,'Battery','Voltage','12.00 V',2,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(276,20,'Battery','Type','Maintenance-Free (MF) · Sealed Lead Acid',3,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(277,20,'Warranty','Warranty Period','55 months',4,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(278,20,'Warranty','Coverage','Full manufacturer warranty · we handle claims',5,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(279,20,'Delivery','Availability','Mumbai · Thane · Navi Mumbai',6,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(280,20,'Delivery','Installation','Free on-site installation',7,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(281,20,'Delivery','Old battery','₹1,000 off on exchange',8,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(282,21,'Battery','Capacity','120.00 Ah',1,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(283,21,'Battery','Voltage','12.00 V',2,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(284,21,'Battery','Type','Maintenance-Free (MF) · Sealed Lead Acid',3,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(285,21,'Warranty','Warranty Period','55 months',4,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(286,21,'Warranty','Coverage','Full manufacturer warranty · we handle claims',5,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(287,21,'Delivery','Availability','Mumbai · Thane · Navi Mumbai',6,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(288,21,'Delivery','Installation','Free on-site installation',7,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(289,21,'Delivery','Old battery','₹1,000 off on exchange',8,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(290,22,'Battery','Capacity','5.00 Ah',1,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(291,22,'Battery','Voltage','12.00 V',2,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(292,22,'Battery','Type','Maintenance-Free (MF) · Sealed Lead Acid',3,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(293,22,'Warranty','Warranty Period','30 months',4,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(294,22,'Warranty','Coverage','Full manufacturer warranty · we handle claims',5,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(295,22,'Delivery','Availability','Mumbai · Thane · Navi Mumbai',6,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(296,22,'Delivery','Installation','Free on-site installation',7,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(297,22,'Delivery','Old battery','₹150 off on exchange',8,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(298,24,'Battery','Capacity','9.00 Ah',1,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(299,24,'Battery','Voltage','12.00 V',2,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(300,24,'Battery','Type','Maintenance-Free (MF) · Sealed Lead Acid',3,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(301,24,'Warranty','Warranty Period','36 months',4,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(302,24,'Warranty','Coverage','Full manufacturer warranty · we handle claims',5,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(303,24,'Delivery','Availability','Mumbai · Thane · Navi Mumbai',6,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(304,24,'Delivery','Installation','Free on-site installation',7,'2026-07-31 07:05:55','2026-07-31 07:05:55'),(305,24,'Delivery','Old battery','₹200 off on exchange',8,'2026-07-31 07:05:55','2026-07-31 07:05:55');
/*!40000 ALTER TABLE `product_specifications` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `battery_brand_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacity_ah` decimal(8,2) DEFAULT NULL,
  `voltage` decimal(5,2) DEFAULT NULL,
  `warranty_months` smallint unsigned NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL,
  `offer_price` decimal(10,2) DEFAULT NULL,
  `weight_kg` decimal(8,3) DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `maintenance_free` tinyint(1) NOT NULL DEFAULT '0',
  `exchange_available` tinyint(1) NOT NULL DEFAULT '0',
  `exchange_discount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `stock_quantity` int NOT NULL DEFAULT '0',
  `low_stock_threshold` int unsigned NOT NULL DEFAULT '5',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views_count` int unsigned NOT NULL DEFAULT '0',
  `sales_count` int unsigned NOT NULL DEFAULT '0',
  `rating_avg` decimal(3,2) NOT NULL DEFAULT '0.00',
  `rating_count` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  KEY `products_is_active_is_featured_index` (`is_active`,`is_featured`),
  KEY `products_category_id_index` (`category_id`),
  KEY `products_battery_brand_id_index` (`battery_brand_id`),
  KEY `products_price_index` (`price`),
  CONSTRAINT `products_battery_brand_id_foreign` FOREIGN KEY (`battery_brand_id`) REFERENCES `battery_brands` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,1,'Exide Mileage MLDIN55 55Ah','exide-mileage-mldin55-55ah-old-1','EX-MLDIN55-old-1','MLDIN55',55.00,12.00,48,7800.00,6499.00,14.500,'High-performance maintenance-free battery for hatchback and sedan cars.','High-performance maintenance-free battery for hatchback and sedan cars.</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.',1,1,800.00,50,5,1,0,'Exide Mileage MLDIN55 55Ah - Buy Online with Warranty','High-performance maintenance-free battery for hatchback and sedan cars.',2,0,0.00,0,'2026-04-30 07:23:10','2026-07-31 07:02:46','2026-07-31 07:02:46'),(2,2,1,'Amaron Hi-Life Pro 45Ah','amaron-hi-life-pro-45ah-old-2-old-2','AM-HI45-old-2-old-2','HI-0BH45D20L',45.00,12.00,60,6800.00,5799.00,12.800,'Long-life maintenance-free car battery from Amaron with 48-month warranty.','Long-life maintenance-free car battery from Amaron with 60-month warranty.</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.',1,1,700.00,35,5,1,0,'Amaron Hi-Life Pro 45Ah - Buy Online with Warranty','Long-life maintenance-free car battery from Amaron with 60-month warranty.',3,0,0.00,0,'2026-04-30 07:23:10','2026-07-31 07:02:46','2026-07-31 07:02:46'),(3,2,1,'Amaron Hi-Life 40Ah','amaron-hi-life-40ah-old-3','AM-HI40-old-3','HI-0BH40B20L',40.00,12.00,48,5800.00,4999.00,11.200,'Reliable car battery for small cars with 48-month warranty.','<p>Reliable car battery for small cars with 48-month warranty.</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.</p>',1,1,600.00,28,5,0,0,'Amaron Hi-Life 40Ah - Buy Online with Warranty','Reliable car battery for small cars with 48-month warranty.',1,0,0.00,0,'2026-04-30 07:23:10','2026-07-31 07:02:46','2026-07-31 07:02:46'),(4,1,2,'Exide MotoMatic 9Ah','exide-motomatic-9ah-old-4','EX-MOTO9-old-4','12XL9-B',9.00,12.00,36,2500.00,1999.00,3.400,'Reliable bike battery with strong cranking power for 150-200cc motorcycles.','<p>Reliable bike battery with strong cranking power for 150-200cc motorcycles.</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.</p>',1,1,200.00,60,5,1,0,'Exide MotoMatic 9Ah - Buy Online with Warranty','Reliable bike battery with strong cranking power for 150-200cc motorcycles.',3,0,0.00,0,'2026-04-30 07:23:10','2026-07-31 07:02:46','2026-07-31 07:02:46'),(5,4,2,'SF Sonic Motozone 5Ah','sf-sonic-motozone-5ah-old-5','SF-MOTO5-old-5','FTZ5L',5.00,12.00,24,1800.00,1499.00,1.800,'Compact battery for scooters and 100-125cc bikes.','<p>Compact battery for scooters and 100-125cc bikes.</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.</p>',1,1,150.00,40,5,0,0,'SF Sonic Motozone 5Ah - Buy Online with Warranty','Compact battery for scooters and 100-125cc bikes.',8,0,0.00,0,'2026-04-30 07:23:10','2026-07-31 07:02:46','2026-07-31 07:02:46'),(6,2,1,'Amaron Hi-Life Pro 35Ah','amaron-hi-life-pro-35ah','AM-HL-35',NULL,35.00,12.00,48,5200.00,4499.00,NULL,'Compact 35Ah battery for small hatchbacks — Alto, Kwid, Nano, i10 (older).','<p>Compact 35Ah battery for small hatchbacks — Alto, Kwid, Nano, i10 (older).</p><p><strong>Fits:</strong> Maruti Alto · Renault Kwid · Tata Nano · Hyundai i10 (pre-2014).</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>',0,1,500.00,30,5,0,1,NULL,NULL,0,0,0.00,0,'2026-07-31 07:02:46','2026-07-31 07:02:46',NULL),(7,1,1,'Exide Mileage MLDIN44 44Ah','exide-mileage-mldin44-44ah','EX-ML-44',NULL,44.00,12.00,48,6200.00,5399.00,NULL,'Exide Mileage series 44Ah — reliable, low-maintenance battery for entry-level cars.','<p>Exide Mileage series 44Ah — reliable, low-maintenance battery for entry-level cars.</p><p><strong>Fits:</strong> Maruti Wagon R · Datsun Redi-Go · Renault Triber.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>',0,1,550.00,30,5,0,1,NULL,NULL,0,0,0.00,0,'2026-07-31 07:02:46','2026-07-31 07:02:46',NULL),(11,2,1,'Amaron Hi-Life Pro 45Ah','amaron-hi-life-pro-45ah','AM-HL-45',NULL,45.00,12.00,48,6900.00,5999.00,NULL,'Long-life 45Ah battery for compact cars — Swift, Baleno, Grand i10, Kwid Climber.','<p>Long-life 45Ah battery for compact cars — Swift, Baleno, Grand i10, Kwid Climber.</p><p><strong>Fits:</strong> Maruti Swift · Hyundai Grand i10 · Ford Figo · Renault Kwid Climber.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>',0,1,600.00,40,5,1,1,NULL,NULL,0,0,0.00,0,'2026-07-31 07:05:20','2026-07-31 07:05:20',NULL),(12,1,1,'Exide Matrix MTR-DIN55 55Ah','exide-matrix-mtr-din55-55ah','EX-MT-55',NULL,55.00,12.00,48,7800.00,6799.00,NULL,'Exide Matrix 55Ah — European DIN standard for hatchbacks and compact sedans.','<p>Exide Matrix 55Ah — European DIN standard for hatchbacks and compact sedans.</p><p><strong>Fits:</strong> Maruti Baleno · Toyota Etios · Hyundai Xcent · Tata Tigor.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>',0,1,700.00,45,5,1,1,NULL,NULL,0,0,0.00,0,'2026-07-31 07:05:20','2026-07-31 07:05:20',NULL),(13,2,1,'Amaron Hi-Life Pro 65Ah (DIN65)','amaron-hi-life-pro-65ah-din65','AM-HL-65',NULL,65.00,12.00,55,8600.00,7599.00,NULL,'Amaron 65Ah DIN65 — premium sedan battery with 55-month warranty.','<p>Amaron 65Ah DIN65 — premium sedan battery with 55-month warranty.</p><p><strong>Fits:</strong> Honda City · Hyundai Verna · Skoda Rapid · VW Vento · Maruti Ciaz.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>',0,1,800.00,35,5,1,1,NULL,NULL,0,0,0.00,0,'2026-07-31 07:05:20','2026-07-31 07:05:20',NULL),(14,4,1,'SF Sonic FSF0-DIN65 65Ah','sf-sonic-fsf0-din65-65ah','SF-DIN-65',NULL,65.00,12.00,48,8200.00,7199.00,NULL,'SF Sonic 65Ah DIN65 — Exide-backed reliability at a value price.','<p>SF Sonic 65Ah DIN65 — Exide-backed reliability at a value price.</p><p><strong>Fits:</strong> Honda City · Hyundai Verna · VW Vento · Skoda Rapid.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>',0,1,700.00,30,5,0,1,NULL,NULL,0,0,0.00,0,'2026-07-31 07:05:20','2026-07-31 07:05:20',NULL),(15,2,1,'Amaron Hi-Life Pro 75Ah (DIN75)','amaron-hi-life-pro-75ah-din75','AM-HL-75',NULL,75.00,12.00,55,9600.00,8499.00,NULL,'Amaron 75Ah DIN75 — SUV-grade battery for Creta, Seltos, Nexon, Ecosport.','<p>Amaron 75Ah DIN75 — SUV-grade battery for Creta, Seltos, Nexon, Ecosport.</p><p><strong>Fits:</strong> Hyundai Creta · Kia Seltos · Tata Nexon · Ford Ecosport · MG Hector.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>',0,1,800.00,30,5,1,1,NULL,NULL,0,0,0.00,0,'2026-07-31 07:05:20','2026-07-31 07:05:20',NULL),(16,1,1,'Exide MP-DIN80 80Ah','exide-mp-din80-80ah','EX-MP-80',NULL,80.00,12.00,55,10800.00,9599.00,NULL,'Exide Marathon Plus 80Ah — heavy-duty battery for large SUVs and older Innova / Fortuner.','<p>Exide Marathon Plus 80Ah — heavy-duty battery for large SUVs and older Innova / Fortuner.</p><p><strong>Fits:</strong> Toyota Innova · Toyota Fortuner (older) · Mahindra Bolero · Ford Endeavour (older).</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>',0,1,900.00,25,5,1,1,NULL,NULL,0,0,0.00,0,'2026-07-31 07:05:20','2026-07-31 07:05:20',NULL),(17,2,1,'Amaron Hi-Life Pro 80Ah (DIN80)','amaron-hi-life-pro-80ah-din80','AM-HL-80',NULL,80.00,12.00,55,10500.00,9299.00,NULL,'Amaron 80Ah DIN80 with 55-month warranty — proven SUV/diesel battery.','<p>Amaron 80Ah DIN80 with 55-month warranty — proven SUV/diesel battery.</p><p><strong>Fits:</strong> Mahindra XUV500 · Tata Safari · Toyota Innova · Ford Endeavour.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>',0,1,900.00,25,5,1,1,NULL,NULL,0,0,0.00,0,'2026-07-31 07:05:20','2026-07-31 07:05:20',NULL),(18,4,1,'SF Sonic FSF0-DIN80 80Ah','sf-sonic-fsf0-din80-80ah','SF-DIN-80',NULL,80.00,12.00,48,10200.00,8999.00,NULL,'SF Sonic 80Ah DIN80 — value option for SUVs and diesel MPVs.','<p>SF Sonic 80Ah DIN80 — value option for SUVs and diesel MPVs.</p><p><strong>Fits:</strong> Mahindra Scorpio · Tata Safari · Toyota Innova · Bolero.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>',0,1,800.00,20,5,0,1,NULL,NULL,0,0,0.00,0,'2026-07-31 07:05:20','2026-07-31 07:05:20',NULL),(19,2,1,'Amaron Hi-Life 100Ah (DIN100)','amaron-hi-life-100ah-din100','AM-HL-100',NULL,100.00,12.00,55,12800.00,11499.00,NULL,'Amaron 100Ah DIN100 — luxury SUV / premium diesel battery, 55-month warranty.','<p>Amaron 100Ah DIN100 — luxury SUV / premium diesel battery, 55-month warranty.</p><p><strong>Fits:</strong> Toyota Fortuner · Ford Endeavour · Skoda Superb · Hyundai Elantra · MG Gloster.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>',0,1,1000.00,15,5,1,1,NULL,NULL,0,0,0.00,0,'2026-07-31 07:05:20','2026-07-31 07:05:20',NULL),(20,1,1,'Exide MI-DIN100 100Ah','exide-mi-din100-100ah','EX-MI-100',NULL,100.00,12.00,55,13200.00,11899.00,NULL,'Exide Mileage 100Ah DIN100 — trusted premium-vehicle battery.','<p>Exide Mileage 100Ah DIN100 — trusted premium-vehicle battery.</p><p><strong>Fits:</strong> Toyota Fortuner · Ford Endeavour · Skoda Superb · Audi A4.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>',0,1,1000.00,15,5,0,1,NULL,NULL,0,0,0.00,0,'2026-07-31 07:05:20','2026-07-31 07:05:20',NULL),(21,1,1,'Exide MI-DIN120 120Ah','exide-mi-din120-120ah','EX-MI-120',NULL,120.00,12.00,55,15200.00,13799.00,NULL,'Exide 120Ah DIN120 — heavy-duty for Innova Crysta diesel, tempos, and large MUVs.','<p>Exide 120Ah DIN120 — heavy-duty for Innova Crysta diesel, tempos, and large MUVs.</p><p><strong>Fits:</strong> Toyota Innova Crysta (diesel) · Tata Xenon · Mahindra Tempo · Force Traveller.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>',0,1,1000.00,12,5,0,1,NULL,NULL,0,0,0.00,0,'2026-07-31 07:05:21','2026-07-31 07:05:21',NULL),(22,2,2,'Amaron Pro Bike Rider 5Ah','amaron-pro-bike-rider-5ah','AM-BIKE-5',NULL,5.00,12.00,30,1650.00,1399.00,NULL,'Sealed maintenance-free battery for scooters and 100-125cc bikes.','<p>Sealed maintenance-free battery for scooters and 100-125cc bikes.</p><p><strong>Fits:</strong> Honda Activa · TVS Jupiter · Hero Splendor · Bajaj Platina · Yamaha Fascino.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>',0,1,150.00,50,5,0,1,NULL,NULL,0,0,0.00,0,'2026-07-31 07:05:21','2026-07-31 07:05:21',NULL),(24,1,2,'Exide MotoMatic 9Ah','exide-motomatic-9ah','EX-MOTO-9',NULL,9.00,12.00,36,2400.00,1999.00,NULL,'Higher-capacity bike battery with strong cranking for 150-200cc motorcycles.','<p>Higher-capacity bike battery with strong cranking for 150-200cc motorcycles.</p><p><strong>Fits:</strong> Bajaj Pulsar 150-220 · TVS Apache RTR 160-200 · Honda Unicorn · Hero Xtreme.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>',0,1,200.00,40,5,1,1,NULL,NULL,0,0,0.00,0,'2026-07-31 07:05:55','2026-07-31 07:05:55',NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `redirects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `redirects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `from_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_code` smallint unsigned NOT NULL DEFAULT '301',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `hits` int unsigned NOT NULL DEFAULT '0',
  `last_hit_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `redirects_from_path_unique` (`from_path`),
  KEY `redirects_is_active_index` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `redirects` WRITE;
/*!40000 ALTER TABLE `redirects` DISABLE KEYS */;
/*!40000 ALTER TABLE `redirects` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `review_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `review_id` bigint unsigned NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` smallint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `review_images_review_id_foreign` (`review_id`),
  CONSTRAINT `review_images_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `review_images` WRITE;
/*!40000 ALTER TABLE `review_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `review_images` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `order_id` bigint unsigned DEFAULT NULL,
  `rating` tinyint unsigned NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified_buyer` tinyint(1) NOT NULL DEFAULT '0',
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `approved_by` bigint unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_order_id_foreign` (`order_id`),
  KEY `reviews_approved_by_foreign` (`approved_by`),
  KEY `reviews_product_id_is_approved_index` (`product_id`,`is_approved`),
  KEY `reviews_user_id_index` (`user_id`),
  KEY `reviews_rating_index` (`rating`),
  CONSTRAINT `reviews_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('ablA7IToJOZBTKfzmJyggqGkevNzByTLcXYR1EQT',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.127.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36','eyJfdG9rZW4iOiIySVA2VXhXU2JkR3hYeGJhQ2VmZ2VwbnZINXRGUVFCb2dOTnFISHJxIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783060646),('gmTq2amPRoTcTNDhwLPXIoqtF84CzOLvmcjbebWN',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJKQkpud2RjSmtNRnZIcVB5N2txamhZb1dxaXc5dmhXcmdTcVE2SzUxIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pbiIsInJvdXRlIjoiYWRtaW4uZGFzaGJvYXJkIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwidXJsIjpbXSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9',1783060665),('Jr6Z0NPJyEhLpgGqazkssHwka4Sjxgyx8xOLOKdo',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.127.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36','eyJfdG9rZW4iOiI3aDM2aVZ4alVSOUpvWVNOTjRLTGRWNHVvejlzU1lnVEU1Y3FDZ1RpIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783229839),('pJnlig6FXzkNerf35YjF1A8sBUrFF5ZSBYrsKpND',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.131.0 Chrome/148.0.7778.280 Electron/42.7.0 Safari/537.36','eyJfdG9rZW4iOiJ1em11YkFFRnlRT3VwaktWa0VvbVlNaE9FTHNxTDhvNVh3eEVlN0s2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1785489330),('QoxLv1vtBpvZ0JHTWEq9MdPuyJ1VKgVy7udlIbBY',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.127.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36','eyJfdG9rZW4iOiIzYWtONElIYVlsVFphaEM5RjBreDBFV2Q5dUlLYnJ6eEpQazE0QW05IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783060088),('vJsv5nVT0MF8gpjXccwuVBAdbikKwsOqSXlviSIA',6,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ1eWx1WXN5bnhFT2dLb0t4YWJjbnNJSlJtUFg2U24wallqME5oY3ZCIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcLy53ZWxsLWtub3duXC9hcHBzcGVjaWZpY1wvY29tLmNocm9tZS5kZXZ0b29scy5qc29uIiwicm91dGUiOm51bGx9LCJ1cmwiOltdLCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6Nn0=',1785502730),('X2olqnDCwTjiGu6LKGvkiVnavy0sP6r3IMmiejxE',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','eyJfdG9rZW4iOiIwNjJKRE5FY1BsMklyZ29Qbk1PY1poSkRXamwzU3B5M2RRRGhmVzhuIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pbiIsInJvdXRlIjoiYWRtaW4uZGFzaGJvYXJkIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwidXJsIjpbXSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9',1783229968);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `type` enum('string','integer','boolean','json','text','file') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'string',
  `label` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_group_key_unique` (`group`,`key`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'general','site_name','Trikuti Battery','string','Site Name',1,'2026-04-30 07:23:10','2026-07-01 06:44:21'),(2,'general','site_tagline','Navi Mumbai\'s #1 battery delivery service · Same-day delivery','string','Site Tagline',1,'2026-04-30 07:23:10','2026-06-15 01:47:09'),(3,'general','support_email','vbs622026@gmail.com','string','Support Email',1,'2026-04-30 07:23:10','2026-06-15 01:47:10'),(4,'general','support_phone','+91 9920971479','string','Support Phone',1,'2026-04-30 07:23:10','2026-06-15 01:47:10'),(5,'general','whatsapp_number','+919920971479','string','WhatsApp Number',1,'2026-04-30 07:23:10','2026-06-15 01:47:10'),(6,'general','address','R-30, MIDC Area Rd, MIDC Industrial Area, Rabale, Navi Mumbai, Maharashtra 400701','text','Office Address',1,'2026-04-30 07:23:10','2026-06-15 01:47:10'),(7,'order','default_tax_percent','18','integer','Default GST % (CGST 9 + SGST 9)',0,'2026-04-30 07:23:10','2026-06-15 01:47:10'),(8,'order','default_delivery_charge','99','integer','Default Delivery Charge (₹) for outside-Mumbai pincodes',0,'2026-04-30 07:23:10','2026-06-15 01:47:10'),(9,'order','free_delivery_above','2000','integer','Free Delivery Above (₹)',0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(10,'order','cod_max_amount','20000','integer','Max COD Amount (₹)',0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(11,'social','facebook','https://facebook.com/','string','Facebook URL',1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(12,'social','instagram','https://instagram.com/','string','Instagram URL',1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(13,'seo','default_meta_title','Buy Car & Bike Batteries Online in Mumbai — Same-day Delivery','string','Default Meta Title',0,'2026-04-30 07:23:10','2026-06-15 01:47:10'),(14,'seo','default_meta_description','Mumbai\'s #1 battery delivery service. Buy genuine Exide, Amaron, SF Sonic batteries with same-day delivery, free installation and old battery exchange across Mumbai, Thane and Navi Mumbai.','text','Default Meta Description',0,'2026-04-30 07:23:10','2026-06-15 01:47:10'),(15,'payment','cod_enabled','1','boolean','Enable COD',0,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(16,'payment','upi_enabled','0','boolean','Enable UPI (requires Razorpay)',0,'2026-04-30 07:23:10','2026-07-01 06:44:21'),(17,'payment','card_enabled','0','boolean','Enable Card (requires Razorpay)',0,'2026-04-30 07:23:10','2026-07-01 06:44:21'),(18,'seo','google_analytics_id','','string','Google Analytics 4 ID (G-XXXXXXX)',0,'2026-07-01 07:01:59','2026-07-01 07:01:59'),(19,'seo','google_search_console','','string','Google Search Console verification token (content of google-site-verification meta)',0,'2026-07-01 07:01:59','2026-07-01 07:01:59'),(20,'seo','google_tag_manager_id','','string','Google Tag Manager container ID (GTM-XXXXXXX)',0,'2026-07-01 07:01:59','2026-07-01 07:01:59'),(21,'seo','facebook_pixel_id','','string','Facebook / Meta Pixel ID',0,'2026-07-01 07:01:59','2026-07-01 07:01:59'),(22,'seo','bing_verification','','string','Bing Webmaster verification token',0,'2026-07-01 07:01:59','2026-07-01 07:01:59');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `testimonials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` tinyint unsigned NOT NULL DEFAULT '5',
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` smallint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
INSERT INTO `testimonials` VALUES (1,'Rahul Sharma','Software Engineer',NULL,'Rabale',5,'Ordered at 11am, battery installed at my doorstep by 3pm. Couldn\'t believe how fast it was. Genuine Exide product, perfect service.',1,1,'2026-04-30 07:23:10','2026-07-31 04:33:22'),(3,'Aman Verma','Business Owner',NULL,'Vashi',4,'Better price than the local Amaron dealer and full warranty card with proper bill. Will buy again.',1,3,'2026-04-30 07:23:10','2026-07-31 04:33:22'),(5,'Vikas Deshpande','Accountant',NULL,'Mulund',5,'Same-day delivery worked exactly as promised. The team called before arriving and installation took under 15 minutes.',1,5,'2026-07-31 04:33:22','2026-07-31 04:33:22'),(7,'Rakesh Mehta','Doctor',NULL,'Airoli',5,'Old battery pickup saved me a trip to the scrap dealer. Got ₹700 off instantly. Highly recommended for anyone in Navi Mumbai.',1,2,'2026-07-31 04:35:00','2026-07-31 04:35:00'),(8,'Ravi Reddy','Teacher',NULL,'Thane',5,'Was hesitant about ordering a battery online but the experience was smooth. Delivered next day, technician was professional.',1,4,'2026-07-31 04:35:00','2026-07-31 04:35:00'),(9,'Sagar Patil','HR Manager',NULL,'Bhandup',5,'Great experience — pricing was transparent, invoice was clean, and the warranty card was activated on the spot.',1,6,'2026-07-31 04:35:00','2026-07-31 04:35:00');
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','blocked') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_unique` (`phone`),
  KEY `users_status_index` (`status`),
  KEY `users_is_admin_index` (`is_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'Admin User','admin@vehiclebattery.test','9000000001','2026-05-22 06:26:08',NULL,NULL,NULL,'active','2026-07-31 03:47:03','$2y$12$658GBbBS6VBlBPbgJtMGteRR9xr7kGIMj987NmJbH7w0elZ4xpAWi','cjyUV9XlMkuwcF3Jp0NecJpiKFXvdMoIJfMutLbeq9aY7FpXjEnTUbMPWUvv','2026-04-30 07:23:09','2026-07-31 04:27:14','2026-07-31 04:27:14'),(2,0,'Test Customer','customer@vehiclebattery.test','9000000002','2026-05-22 06:26:08',NULL,NULL,NULL,'active',NULL,'$2y$12$ppN2JDQLEgi0tP.SLcgVB.Asi4Axqws5irTeUV2lVPQZ2z//tm03O',NULL,'2026-04-30 07:23:09','2026-05-22 06:26:08',NULL),(3,0,'Field Installer','installer@vehiclebattery.test','9000000003','2026-04-30 07:23:09',NULL,NULL,NULL,'active',NULL,'$2y$12$cbUkNLuUr9/Tpoz/95HDju/BoZ5QeBaad8mAYd7NCFIxy9EID2GQS',NULL,'2026-04-30 07:23:09','2026-04-30 07:23:09',NULL),(6,1,'Admin','admin@trikutibattery.com',NULL,'2026-07-31 04:28:33',NULL,NULL,NULL,'active','2026-07-31 04:29:49','$2y$12$S8/hOxNmRBZfE8xNrSnCn.6ZvBW2uxrOeIAtaLlK7PVpNIP7M/iY6','kitkr1B9dqCXqGyl6GZcgNhSmIEWmW2AuAG1p1QATZFkvelTmmMqv5lnz8lw','2026-07-31 04:28:33','2026-07-31 04:29:49',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `vehicle_brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle_brands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` smallint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vehicle_brands_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `vehicle_brands` WRITE;
/*!40000 ALTER TABLE `vehicle_brands` DISABLE KEYS */;
INSERT INTO `vehicle_brands` VALUES (1,'Maruti Suzuki','maruti-suzuki',NULL,1,1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(2,'Hyundai','hyundai',NULL,1,2,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(3,'Tata','tata',NULL,1,3,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(4,'Mahindra','mahindra',NULL,1,4,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(5,'Honda','honda',NULL,1,5,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(6,'Toyota','toyota',NULL,1,6,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(7,'Kia','kia',NULL,1,7,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(8,'Renault','renault',NULL,1,8,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(9,'Ford','ford',NULL,1,9,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(10,'Volkswagen','volkswagen',NULL,1,10,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(11,'Skoda','skoda',NULL,1,11,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(12,'Nissan','nissan',NULL,1,12,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(13,'Hero','hero',NULL,1,13,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(14,'Bajaj','bajaj',NULL,1,14,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(15,'TVS','tvs',NULL,1,15,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(16,'Royal Enfield','royal-enfield',NULL,1,16,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(17,'Yamaha','yamaha',NULL,1,17,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(18,'Suzuki','suzuki',NULL,1,18,'2026-04-30 07:23:09','2026-04-30 07:23:09');
/*!40000 ALTER TABLE `vehicle_brands` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `vehicle_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle_models` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vehicle_type_id` bigint unsigned NOT NULL,
  `vehicle_brand_id` bigint unsigned NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vehicle_models_vehicle_type_id_vehicle_brand_id_slug_unique` (`vehicle_type_id`,`vehicle_brand_id`,`slug`),
  KEY `vehicle_models_vehicle_brand_id_foreign` (`vehicle_brand_id`),
  KEY `vehicle_models_vehicle_type_id_vehicle_brand_id_index` (`vehicle_type_id`,`vehicle_brand_id`),
  CONSTRAINT `vehicle_models_vehicle_brand_id_foreign` FOREIGN KEY (`vehicle_brand_id`) REFERENCES `vehicle_brands` (`id`) ON DELETE CASCADE,
  CONSTRAINT `vehicle_models_vehicle_type_id_foreign` FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `vehicle_models` WRITE;
/*!40000 ALTER TABLE `vehicle_models` DISABLE KEYS */;
INSERT INTO `vehicle_models` VALUES (1,1,1,'Swift','swift',1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(2,1,1,'Baleno','baleno',1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(3,1,1,'WagonR','wagonr',1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(4,1,2,'i20','i20',1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(5,1,2,'Creta','creta',1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(6,1,3,'Nexon','nexon',1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(7,1,5,'City','city',1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(8,1,5,'Amaze','amaze',1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(9,1,4,'Scorpio','scorpio',1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(10,1,6,'Innova Crysta','innova-crysta',1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(11,2,13,'Splendor Plus','splendor-plus',1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(12,2,13,'Passion Pro','passion-pro',1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(13,2,14,'Pulsar 150','pulsar-150',1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(14,2,14,'Pulsar NS200','pulsar-ns200',1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(15,2,16,'Classic 350','classic-350',1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(16,2,16,'Bullet 350','bullet-350',1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(17,2,15,'Apache RTR 160','apache-rtr-160',1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(18,2,5,'Activa 6G','activa-6g',1,'2026-04-30 07:23:10','2026-04-30 07:23:10');
/*!40000 ALTER TABLE `vehicle_models` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `vehicle_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` smallint unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vehicle_types_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `vehicle_types` WRITE;
/*!40000 ALTER TABLE `vehicle_types` DISABLE KEYS */;
INSERT INTO `vehicle_types` VALUES (1,'Car','car',NULL,1,1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(2,'Bike','bike',NULL,2,1,'2026-04-30 07:23:09','2026-04-30 07:23:09');
/*!40000 ALTER TABLE `vehicle_types` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `vehicle_variants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle_variants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vehicle_model_id` bigint unsigned NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fuel_type` enum('petrol','diesel','cng','electric','hybrid') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year_from` smallint unsigned DEFAULT NULL,
  `year_to` smallint unsigned DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicle_variants_vehicle_model_id_fuel_type_index` (`vehicle_model_id`,`fuel_type`),
  KEY `vehicle_variants_year_from_year_to_index` (`year_from`,`year_to`),
  CONSTRAINT `vehicle_variants_vehicle_model_id_foreign` FOREIGN KEY (`vehicle_model_id`) REFERENCES `vehicle_models` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `vehicle_variants` WRITE;
/*!40000 ALTER TABLE `vehicle_variants` DISABLE KEYS */;
INSERT INTO `vehicle_variants` VALUES (1,1,'VXi','petrol',2018,NULL,1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(2,1,'VDi','diesel',2018,2020,1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(3,2,'Delta','petrol',2015,NULL,1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(4,3,'LXi','petrol',2019,NULL,1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(5,4,'Sportz','petrol',2020,NULL,1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(6,4,'Asta','diesel',2018,2022,1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(7,5,'SX','petrol',2020,NULL,1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(8,6,'XZ Plus','petrol',2017,NULL,1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(9,6,'XZ Plus Diesel','diesel',2017,NULL,1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(10,7,'VX','petrol',2020,NULL,1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(11,8,'VX','petrol',2018,NULL,1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(12,9,'S11','diesel',2014,NULL,1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(13,10,'VX','diesel',2016,NULL,1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(14,11,'Standard','petrol',2010,NULL,1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(15,12,'Standard','petrol',2014,NULL,1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(16,13,'Standard','petrol',2010,NULL,1,'2026-04-30 07:23:09','2026-04-30 07:23:09'),(17,14,'Standard','petrol',2012,NULL,1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(18,15,'Standard','petrol',2009,NULL,1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(19,16,'Standard','petrol',2008,NULL,1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(20,17,'Standard','petrol',2010,NULL,1,'2026-04-30 07:23:10','2026-04-30 07:23:10'),(21,18,'Standard','petrol',2020,NULL,1,'2026-04-30 07:23:10','2026-04-30 07:23:10');
/*!40000 ALTER TABLE `vehicle_variants` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `warranty_claims`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `warranty_claims` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `order_item_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `issue_type` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'submitted',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `reviewed_by` bigint unsigned DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `resolution` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `warranty_claims_order_item_id_foreign` (`order_item_id`),
  KEY `warranty_claims_user_id_foreign` (`user_id`),
  KEY `warranty_claims_reviewed_by_foreign` (`reviewed_by`),
  KEY `warranty_claims_order_id_index` (`order_id`),
  KEY `warranty_claims_status_index` (`status`),
  CONSTRAINT `warranty_claims_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `warranty_claims_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `warranty_claims_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `warranty_claims_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `warranty_claims` WRITE;
/*!40000 ALTER TABLE `warranty_claims` DISABLE KEYS */;
/*!40000 ALTER TABLE `warranty_claims` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `wishlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlists` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wishlists_user_id_product_id_unique` (`user_id`,`product_id`),
  KEY `wishlists_product_id_foreign` (`product_id`),
  CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `wishlists` WRITE;
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlists` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

