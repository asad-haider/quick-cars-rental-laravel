/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.29-MariaDB : Database - laravel_boilerplate
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`laravel_boilerplate` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `laravel_boilerplate`;

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobs` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2017_04_10_000000_create_users_table',1),(2,'2017_04_10_000001_create_password_resets_table',1),(3,'2017_04_10_000002_create_social_accounts_table',1),(4,'2017_04_10_000003_create_roles_table',1),(5,'2017_04_10_000004_create_users_roles_table',1),(6,'2017_06_16_000005_create_protection_validations_table',1),(7,'2017_06_16_000006_create_protection_shop_tokens_table',1);

/*Table structure for table `notification_user` */

DROP TABLE IF EXISTS `notification_user`;

CREATE TABLE `notification_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notification_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_sent` tinyint(2) DEFAULT '1',
  `is_read` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `notification_id` (`notification_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `notification_user_ibfk_1` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `notification_user` */

insert  into `notification_user`(`id`,`notification_id`,`user_id`,`is_sent`,`is_read`) values (1,1,9,1,0),(2,1,10,1,0),(3,2,9,1,0),(4,2,10,1,0),(5,7,8,1,0),(6,7,9,1,0),(7,7,10,1,0),(8,8,8,1,0),(9,8,9,1,0),(10,8,10,1,0),(11,9,8,1,0),(12,9,9,1,0),(13,9,10,1,0),(14,10,8,1,0),(15,10,9,1,0),(16,10,10,1,0),(17,11,8,1,0),(18,11,9,1,0),(19,11,10,1,0),(20,12,8,1,0),(21,12,9,1,0),(22,12,10,1,0),(23,13,8,1,0),(24,13,9,1,0),(25,13,10,1,0),(26,14,8,1,0),(27,14,9,1,0),(28,14,10,1,0),(29,15,8,1,0),(30,15,9,1,0),(31,15,10,1,0),(32,16,8,1,0),(33,16,9,1,0),(34,16,10,1,0),(35,17,8,1,0),(36,17,9,1,0),(37,17,10,1,0),(38,18,8,1,0),(39,18,9,1,0),(40,18,10,1,0),(41,19,8,1,0),(42,19,9,1,0),(43,19,10,1,0),(44,20,8,1,0),(45,20,9,1,0),(46,20,10,1,0),(47,21,8,1,0),(48,21,9,1,0),(49,21,10,1,0),(50,22,8,1,0),(51,22,9,1,0),(52,22,10,1,0),(53,23,8,1,0),(54,23,9,1,0),(55,23,10,1,0),(56,24,8,1,0),(57,24,9,1,0),(58,24,10,1,0),(59,25,8,1,0),(60,25,9,1,0),(61,25,10,1,0),(62,26,10,1,0),(63,27,8,1,0),(64,27,9,1,0),(65,27,10,1,0),(66,28,8,1,0),(67,28,9,1,0),(68,28,10,1,0);

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `url` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  `action_type` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `added_by` (`sender_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `notifications` */

insert  into `notifications`(`id`,`message`,`url`,`sender_id`,`ref_id`,`action_type`,`created_at`,`updated_at`,`deleted_at`) values (1,'test',NULL,2,NULL,'general','2018-01-19 05:36:16','2018-01-19 05:36:16',NULL),(2,'test',NULL,2,NULL,'general','2018-01-19 05:37:49','2018-01-19 05:37:49',NULL),(3,NULL,NULL,1,NULL,'general','2018-02-19 09:46:32','2018-02-19 09:46:32',NULL),(4,NULL,NULL,1,NULL,'general','2018-02-19 09:56:46','2018-02-19 09:56:46',NULL),(5,NULL,NULL,1,NULL,'general','2018-02-19 10:01:22','2018-02-19 10:01:22',NULL),(6,NULL,NULL,1,NULL,'general','2018-02-19 10:03:15','2018-02-19 10:03:15',NULL),(7,NULL,NULL,1,NULL,'general','2018-02-19 10:03:24','2018-02-19 10:03:24',NULL),(8,'sddsadasdas',NULL,1,NULL,'general','2018-02-19 10:03:36','2018-02-19 10:03:36',NULL),(9,'asad',NULL,1,NULL,'general','2018-02-19 10:05:11','2018-02-19 10:05:11',NULL),(10,'dfasfagfas',NULL,1,NULL,'general','2018-02-19 12:13:42','2018-02-19 12:13:42',NULL),(11,'asad',NULL,1,NULL,'general','2018-02-19 12:14:27','2018-02-19 12:14:27',NULL),(12,'new test message asad',NULL,1,NULL,'general','2018-02-19 12:14:39','2018-02-19 12:14:39',NULL),(13,'safasfafas',NULL,1,NULL,'general','2018-02-19 12:17:17','2018-02-19 12:17:17',NULL),(14,'dasdasdas',NULL,1,NULL,'general','2018-02-19 12:18:51','2018-02-19 12:18:51',NULL),(15,'safassfsafasfasafsasf',NULL,1,NULL,'general','2018-02-19 12:21:23','2018-02-19 12:21:23',NULL),(16,'test',NULL,1,NULL,'general','2018-02-19 12:27:04','2018-02-19 12:27:04',NULL),(17,'test',NULL,1,NULL,'general','2018-02-19 12:27:22','2018-02-19 12:27:22',NULL),(18,'estsetsete',NULL,1,NULL,'general','2018-02-19 12:27:48','2018-02-19 12:27:48',NULL),(19,'testsetewst',NULL,1,NULL,'general','2018-02-19 12:35:01','2018-02-19 12:35:01',NULL),(20,'testsetset',NULL,1,NULL,'general','2018-02-19 12:35:25','2018-02-19 12:35:25',NULL),(21,'testetsetst',NULL,1,NULL,'general','2018-02-19 12:36:09','2018-02-19 12:36:09',NULL),(22,'testetsetst',NULL,1,NULL,'general','2018-02-19 12:36:46','2018-02-19 12:36:46',NULL),(23,'testetsetst',NULL,1,NULL,'general','2018-02-19 12:38:57','2018-02-19 12:38:57',NULL),(24,'testetsetst',NULL,1,NULL,'general','2018-02-19 12:39:28','2018-02-19 12:39:28',NULL),(25,'testetsetst',NULL,1,NULL,'general','2018-02-19 12:39:40','2018-02-19 12:39:40',NULL),(26,'dasdadss',NULL,1,NULL,'general','2018-02-22 11:49:59','2018-02-22 11:49:59',NULL),(27,'sadas',NULL,1,NULL,'general','2018-02-22 11:50:10','2018-02-22 11:50:10',NULL),(28,'dsadsa',NULL,1,NULL,'general','2018-02-24 10:00:03','2018-02-24 10:00:03',NULL);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `permission_title` varchar(50) CHARACTER SET utf8 NOT NULL,
  `permission_slug` varchar(50) CHARACTER SET utf8 NOT NULL,
  `permission_description` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`permission_title`,`permission_slug`,`permission_description`) values (1,'admin','admin.dashboard',''),(2,'users list','admin.users',''),(3,'users data','admin.users-data',''),(4,'show user','admin.users.show',''),(6,'get users by device type','admin.users.get_by_type',NULL),(7,'send notifications','admin.notifications.send_notification',NULL),(8,'notification page','admin.notifications.index',NULL),(9,'dashboard log chart','admin.dashboard.log.chart',NULL),(10,'dashboard registration log chart','admin.dashboard.registration.chart',NULL),(11,'roles list','admin.roles',NULL),(12,'roles data','admin.roles-data',NULL),(13,'show role','admin.roles.show',NULL),(14,'edit user','admin.users.edit',NULL),(15,'update user','admin.users.update',NULL),(16,'edit role','admin.roles.edit',NULL),(17,'update role','admin.roles.update',NULL);

/*Table structure for table `permissions_roles` */

DROP TABLE IF EXISTS `permissions_roles`;

CREATE TABLE `permissions_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(11) unsigned NOT NULL,
  `role_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_id` (`permission_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `permissions_roles_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  CONSTRAINT `permissions_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=267 DEFAULT CHARSET=latin1;

/*Data for the table `permissions_roles` */

insert  into `permissions_roles`(`id`,`permission_id`,`role_id`) values (88,1,2),(254,1,1),(255,2,1),(256,3,1),(257,6,1),(258,7,1),(259,8,1),(260,9,1),(261,10,1),(262,11,1),(263,12,1),(264,13,1),(265,16,1),(266,17,1);

/*Table structure for table `protection_shop_tokens` */

DROP TABLE IF EXISTS `protection_shop_tokens`;

CREATE TABLE `protection_shop_tokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `success_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cancel_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `success_url_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cancel_url_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pst_unique` (`user_id`,`success_url`,`cancel_url`),
  KEY `protection_shop_tokens_number_index` (`number`),
  KEY `protection_shop_tokens_expires_index` (`expires`),
  CONSTRAINT `pst_foreign_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `protection_shop_tokens` */

/*Table structure for table `protection_validations` */

DROP TABLE IF EXISTS `protection_validations`;

CREATE TABLE `protection_validations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ttl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `validation_result` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user` (`user_id`),
  KEY `protection_validations_ttl_index` (`ttl`),
  CONSTRAINT `pv_foreign_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `protection_validations` */

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` smallint(5) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`weight`,`created_at`,`updated_at`) values (1,'administrator',0,'2018-02-23 12:23:25','2018-02-23 12:23:27'),(2,'authenticated',0,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*Table structure for table `social_accounts` */

DROP TABLE IF EXISTS `social_accounts`;

CREATE TABLE `social_accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `provider` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `social_accounts_user_id_provider_provider_id_index` (`user_id`,`provider`,`provider_id`),
  CONSTRAINT `social_accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `social_accounts` */

/*Table structure for table `user_devices` */

DROP TABLE IF EXISTS `user_devices`;

CREATE TABLE `user_devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `device_type` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `device_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_devices_ibfk_1` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_devices` */

insert  into `user_devices`(`id`,`user_id`,`device_type`,`device_token`,`created_at`,`updated_at`) values (7,9,'ios','eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjYyLCJpc3MiOiJodHRwOi8vZWR1Y2F0aW9udXNhLnN0YWdpbmdpYy5jb20vYXBpL3JlZ2lzdGVyIiwiaWF0IjoxNTE0NDQxOTY2LCJleHAiOjE1MTgwNDE5NjYsIm5iZiI6MTUxNDQ0MTk2NiwianRpIjoicVNPczY3aTFaYUlJdlVFZCJ9.fPTwJWSV2MJbubLQVwEdQK5G4mz4M','2018-01-19 05:31:45','2018-01-19 05:31:45'),(8,10,'android','yyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjYyLCJpc3MiOiJodHRwOi8vZWR1Y2F0aW9udXNhLnN0YWdpbmdpYy5jb20vYXBpL3JlZ2lzdGVyIiwiaWF0IjoxNTE0NDQxOTY2LCJleHAiOjE1MTgwNDE5NjYsIm5iZiI6MTUxNDQ0MTk2NiwianRpIjoicVNPczY3aTFaYUlJdlVFZCJ9.fPTwJWSV2MJbubLQVwEdQK5G4mz4M','2018-01-19 05:33:23','2018-01-19 05:33:23'),(15,8,'ios','e23nm3n4m3nm2@#$%21m34n2wer34@!#$%@','2018-02-19 13:52:50','2018-01-31 10:28:55'),(25,20,'asdadas','dasdas','2018-02-24 11:04:11','2018-02-24 11:04:11');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `confirmation_code` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`active`,`confirmation_code`,`confirmed`,`remember_token`,`created_at`,`updated_at`,`deleted_at`) values (1,'Admin','admin.laravel@labs64.com','$2y$10$40OHWVxVQ8dOX06Y6oINiOY8WiX1UrJG8tI2JK0Dvzt6f0BNXN1/C',1,'9fabb8d7-af7e-4dbf-a601-8ce84198e61a',1,'pJbW1e86EA3ZgSf4ksT5QEykEvn2tEjVU0PDNQxuE9TwBDldXDhYzhHuJgKA','2018-02-15 12:21:46','2018-02-15 12:21:46',NULL),(2,'Demo','demo.laravel@labs64.com','$2y$10$le885ONEDKPH65xhH4O/zOU3TeAF90Cy0d8R4aV48fDPx3b2muukm',1,'69022c5c-60e8-4957-8359-6542ee52fa1c',1,'EL2T3D5azLj5ouQbdn4c457YXtAQJkqL5F1rOgUfuJSdqxKWMPbpkoteARuS','2018-02-15 12:21:46','2018-02-15 12:21:46',NULL),(8,'abbassyedd','abbassyed@axact.com','$2y$10$Tb5HOjEE5kWgyfJPkS5PdeLsYWh5JpHQwD0O6OVwvc.cZ3tI0SZKO',0,'8cbb711f-c46c-4a9f-b292-8f29cd2a5990',0,'aJRRGk0T20YzpXCfyKr1dulQGZagaVYAuOvT40lDzVAL3zwJHNF3PoYXrz0u','2018-02-15 13:56:53','2018-02-24 09:52:30',NULL),(9,'syedasadhaider','syedasadhaider@axact.com','$2y$10$KggqDCLq3eDpYzUbJeA87eSibge.tGEuKE1nd1JTKHp/UheSOWZCq',1,'caf22cbc-4d62-46ca-90c0-c22f12303802',1,'TzsD9KDsQNsJaZaR1Hqp5JBeMCVImAXao6gH6CJYGaEfYjhQJ5ZHf0Tw5Y9k','2018-02-15 13:58:01','2018-02-16 10:46:34',NULL),(10,'syedaun.abbasrizviii','syedaun.abbasrizvi@gmail.commm','$2y$10$WlBUH0xbhwcurqEVo8G.t.UDDr/2GzhdcCzB9c4NQ3xOuKq8kkguG',1,'b26bac15-e09b-45b6-b1c1-033b9c71afc3',1,'dQtPiInycflfNjfSzyDmIMyhrjJBFQ3nhBUaefsifBblK7bPovo0d8Wo5qTJ','2018-02-15 13:59:16','2018-02-23 11:10:12',NULL),(11,'sdasa','dasd@asdas.com','$2y$10$sYv2EtxM5.ZN46s/DAErQOKls7zR7Y5es/kdj8sIVDh4.Dfpr3qDq',1,NULL,1,NULL,'2018-02-24 10:41:41','2018-02-24 10:41:41',NULL),(12,'sdasa','dasasd@asdas.com','$2y$10$gLicPIkiqxTNj63OXnTHaOKmAxZYups2Jl..YmxRXMDNe/ZkWS42O',1,NULL,1,NULL,'2018-02-24 10:44:59','2018-02-24 10:44:59',NULL),(13,'sdasa','dasasd@dasdas.com','$2y$10$ajAYgnG1Zzi3qeTQUL7fL.H3FM8J8/dSkO5Yn0y9Fd2/gMEY6fGu.',1,NULL,1,NULL,'2018-02-24 10:47:30','2018-02-24 10:47:30',NULL),(14,'sdasa','dasasdd@dasdas.com','$2y$10$BL/Zj0k1SLJyMR9iJ4v41utwr8IQjpyyNL8gdlw7DVyaU9XOmuYkm',1,NULL,1,NULL,'2018-02-24 10:48:02','2018-02-24 10:48:02',NULL),(15,'sdasa','dasasddd@dasdas.com','$2y$10$8Ldli9Q5xzka0bXe2BPLKuMx0RyCXEKhmNsUdFTJAbRDBbFFwADpC',1,NULL,1,NULL,'2018-02-24 10:54:05','2018-02-24 10:54:05',NULL),(16,'sdasa','dasasdddd@dasdas.com','$2y$10$hoh7YS5K0tkBwmnZWrHlEOv321BAXNrqJcoKQqn4F6bBO6h2rmRly',1,NULL,1,NULL,'2018-02-24 10:54:26','2018-02-24 10:54:26',NULL),(17,'sdasa','dasasddddd@dasdas.com','$2y$10$3AqgYqlCt7Yfi525W.dBR.98j05tnPZGqzl3WYxpzMFLEvYSqSOLe',1,NULL,1,NULL,'2018-02-24 10:54:44','2018-02-24 10:54:44',NULL),(18,'sdasa','dasasdddddd@dasdas.com','$2y$10$sgqYheuMFrvNc3vR1.mWHOcQ8A4dr7lPDdQ/pJZsoPTbEoYVRTW5C',1,NULL,1,NULL,'2018-02-24 11:02:47','2018-02-24 11:02:47',NULL),(19,'sdasa','dasasddddddd@dasdas.com','$2y$10$cNifPjfUFpnCevzhtBgYyO.Nr87N3VO6KilpHXHsapcIazRkFFeba',1,NULL,1,NULL,'2018-02-24 11:03:32','2018-02-24 11:03:32',NULL),(20,'sdasa','dasasdddddddd@dasdas.com','$2y$10$DWpk.FZRIzauzxbf9bRvP.OmWgbmFrgKdgp0s8XhIbviBxsyusI3W',1,NULL,1,NULL,'2018-02-24 11:04:11','2018-02-24 11:04:11',NULL);

/*Table structure for table `users_roles` */

DROP TABLE IF EXISTS `users_roles`;

CREATE TABLE `users_roles` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  UNIQUE KEY `users_roles_user_id_role_id_unique` (`user_id`,`role_id`),
  KEY `foreign_role` (`role_id`),
  CONSTRAINT `foreign_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `foreign_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users_roles` */

insert  into `users_roles`(`user_id`,`role_id`) values (1,1),(1,2),(2,2),(8,1),(8,2),(9,2),(10,2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
