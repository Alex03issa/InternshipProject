-- MySQL dump 10.13  Distrib 8.2.0, for Win64 (x86_64)
--
-- Host: localhost    Database: sidetoside_db
-- ------------------------------------------------------
-- Server version	8.0.35

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

--
-- Table structure for table `ad_statistics`
--

DROP TABLE IF EXISTS `ad_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ad_statistics` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ad_id` bigint unsigned NOT NULL,
  `clicks` int NOT NULL DEFAULT '0',
  `views` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bill` decimal(10,5) NOT NULL DEFAULT '0.00000',
  PRIMARY KEY (`id`),
  KEY `ad_statistics_ad_id_foreign` (`ad_id`),
  CONSTRAINT `ad_statistics_ad_id_foreign` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ad_statistics`
--

LOCK TABLES `ad_statistics` WRITE;
/*!40000 ALTER TABLE `ad_statistics` DISABLE KEYS */;
INSERT INTO `ad_statistics` VALUES (45,2,10,147,'2024-11-08 17:26:56','2024-11-14 10:33:50',0.00000),(46,3,3,142,'2024-11-08 17:26:56','2024-11-14 10:33:50',0.00000),(47,4,0,62,'2024-11-08 17:26:56','2024-11-14 01:21:11',0.00000),(48,1,0,24,'2024-11-09 00:03:28','2024-11-14 01:21:11',0.00000);
/*!40000 ALTER TABLE `ad_statistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ads`
--

DROP TABLE IF EXISTS `ads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ad_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ad_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ad_platform` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ad_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `ad_owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` timestamp NOT NULL,
  `end_date` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ad_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'custom',
  `google_ad_code` text COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL,
  `cpc_rate` decimal(8,3) NOT NULL DEFAULT '0.000',
  `cpm_rate` decimal(8,3) NOT NULL DEFAULT '0.000',
  `use_cpc` tinyint(1) NOT NULL DEFAULT '0',
  `use_cpm` tinyint(1) NOT NULL DEFAULT '0',
  `revenue` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `manual_override` tinyint(1) NOT NULL DEFAULT '0',
  `bill` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `paid_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ads`
--

LOCK TABLES `ads` WRITE;
/*!40000 ALTER TABLE `ads` DISABLE KEYS */;
INSERT INTO `ads` VALUES (1,'xpertbot','ads/01JC1PZ4NX0SA7TV2MHQC8Z4TF.jpeg','website','https://xpertbotacademy.online/',NULL,'Ibrahim Fleifel','2024-11-06 22:00:00','2024-11-17 22:00:00','2024-11-06 21:12:26','2024-11-14 01:21:11','custom',NULL,0,0.000,0.000,0,0,0.00000,1,0.00000,0),(2,'xpertbot','ads/01JC1SGQ7TB9NS11KED3S13BVD.jpeg','website','https://xpertbotacademy.online/',NULL,'Ibrahim Fleifel','2024-11-07 22:00:00','2024-11-17 22:00:00','2024-11-06 22:28:57','2024-11-14 10:33:50','custom',NULL,1,0.000,0.000,0,0,0.00000,1,0.00000,0),(3,'wadee issa linkedin','ads/01JC1STGG38J9RBG4ARNV443WZ-v1.png','website','https://www.linkedin.com/in/wadih-issa-6b2a801a8/',NULL,'wadee issa','2024-11-07 22:00:00','2024-11-11 22:00:00','2024-11-06 22:32:13','2024-11-14 10:33:50','custom',NULL,1,0.000,0.000,0,0,0.00000,1,0.00000,0),(4,'xperrtbot','ads/Logo.jpg','website',NULL,NULL,'dfvdvd','2024-11-07 22:00:00','2024-11-12 22:00:00','2024-11-07 19:12:08','2024-11-14 10:33:50','custom',NULL,0,0.000,0.000,0,0,0.00000,1,0.00000,0);
/*!40000 ALTER TABLE `ads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backgrounds`
--

DROP TABLE IF EXISTS `backgrounds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `backgrounds` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `background_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` int NOT NULL DEFAULT '0' COMMENT 'Cost in coins',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backgrounds`
--

LOCK TABLES `backgrounds` WRITE;
/*!40000 ALTER TABLE `backgrounds` DISABLE KEYS */;
INSERT INTO `backgrounds` VALUES (1,'background1','01JCGKCA1VTF95FPGFTVWRRXRM.webp',0,'2024-11-12 16:30:17','2024-11-14 01:21:11');
/*!40000 ALTER TABLE `backgrounds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (3,'Homepage','homepage','2024-10-16 00:44:14','2024-11-14 01:21:11'),(4,'Blog','blog','2024-10-16 00:44:33','2024-11-14 01:21:11'),(5,'Terms & Conditions','terms-conditions','2024-10-16 00:44:50','2024-11-14 01:21:11'),(6,'Privacy Policy','privacy-policy','2024-10-16 00:45:06','2024-11-14 01:21:11'),(7,'Contact Us','contact-us','2024-10-23 00:26:57','2024-11-14 01:21:11');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_post`
--

DROP TABLE IF EXISTS `category_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_post` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `post_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `section` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_post_category_id_foreign` (`category_id`),
  KEY `category_post_post_id_foreign` (`post_id`),
  CONSTRAINT `category_post_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `category_post_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_post`
--

LOCK TABLES `category_post` WRITE;
/*!40000 ALTER TABLE `category_post` DISABLE KEYS */;
INSERT INTO `category_post` VALUES (30,3,33,'2024-10-18 07:42:38','2024-11-14 01:21:11','home-header'),(32,3,35,'2024-10-18 08:02:33','2024-11-14 01:21:11','introduction'),(33,3,36,'2024-10-18 08:04:11','2024-11-14 01:21:11','about-application'),(34,3,37,'2024-10-18 08:05:37','2024-11-14 01:21:11','features'),(37,3,40,'2024-10-18 08:07:36','2024-11-14 01:21:11','detail'),(38,3,41,'2024-10-18 08:08:35','2024-11-14 01:21:11','blog'),(39,3,42,'2024-10-18 08:12:16','2024-11-14 01:21:11','download'),(40,4,43,'2024-10-18 08:15:03','2024-11-14 01:21:11','introduction-sec'),(41,4,44,'2024-10-18 08:15:47','2024-11-14 01:21:11','overiew-sec'),(42,6,45,'2024-10-18 08:32:25','2024-11-14 01:21:11','maincontent'),(44,5,47,'2024-10-18 08:48:46','2024-11-14 01:21:11','mainheader'),(52,5,48,'2024-10-21 23:36:10','2024-11-14 01:21:11','maincontent'),(55,7,57,'2024-10-23 00:29:04','2024-11-14 01:21:11','contactus'),(58,4,60,'2024-10-23 23:17:15','2024-11-14 01:21:11','download'),(59,4,61,'2024-10-25 01:00:43','2024-11-14 01:21:11','feature-sec'),(60,4,62,'2024-11-03 08:14:52','2024-11-14 01:21:11','header');
/*!40000 ALTER TABLE `category_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_blocks`
--

DROP TABLE IF EXISTS `content_blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `content_blocks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `use_blocks` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `content_blocks_post_id_foreign` (`post_id`),
  CONSTRAINT `content_blocks_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=222 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_blocks`
--

LOCK TABLES `content_blocks` WRITE;
/*!40000 ALTER TABLE `content_blocks` DISABLE KEYS */;
INSERT INTO `content_blocks` VALUES (9,48,'heading','<h2>1. Information Collected During Visits</h2><h2></h2>',1,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(10,48,'paragraph','<p>Each time you visit the website or use the services, we collect information such as your IP address, browser type, and device. We also gather access times, the page you came from, and the pages you visit within our services.&nbsp;</p>',2,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(11,48,'heading','<h2>2. Use of Content and Materials</h2>',4,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(12,48,'paragraph','<p>Any use of materials from this site is subject to the user assuming all costs for repairs or corrections of equipment or data. \"Side to Side\" will not be liable for any damages resulting from the use of materials.&nbsp;</p>',5,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(13,48,'list','<p>You are prohibited from reselling our templates, regardless of modification.&nbsp;</p>',8,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(14,48,'heading','<h2>3. Game Rules and Responsibilities</h2>',11,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(15,48,'paragraph','<p>By playing \"Side to Side,\" you agree to abide by the game\'s rules, including fair play. Exploiting bugs, using cheats, or engaging in inappropriate behavior may result in suspension or account termination.&nbsp;</p>',12,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(16,48,'heading','<h2>4. Virtual Items and Rewards</h2>',13,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(17,48,'paragraph','<p>The game includes virtual items such as ball skins or backgrounds, which cannot be exchanged for cash. We reserve the right to modify or remove virtual items at any time.&nbsp;</p>',14,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(18,48,'heading','<h2>5. Purchases and Refunds</h2>',16,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(19,48,'paragraph','<p>In-app purchases are available for virtual items. All sales are final, and refunds will only be issued for unauthorized transactions within 14 days of purchase. &nbsp;</p><p><br></p>',17,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(20,48,'list','<p>All in-app purchases are final, and refunds will not be issued except in cases of fraud.&nbsp;</p>',19,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(21,48,'heading','<h2>6. Updates and Changes</h2>',22,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(22,48,'paragraph','<p>We may update the game, its content, and these terms periodically. By continuing to use the game, you agree to be bound by any changes.&nbsp;</p>',23,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(23,48,'heading','<h2>7. Limitation of Liability</h2>',24,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(24,48,'paragraph','<p>We are not responsible for any damages resulting from the use of \"Side to Side,\" including data loss or service disruptions. Your use of the game is at your own risk.&nbsp;</p>',25,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(25,48,'heading','<h2>8. User Account and Security</h2>',26,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(26,48,'paragraph','<p>It is your responsibility to keep your account credentials secure. You agree not to share your username and password with anyone. If we detect suspicious activity in your account, we may temporarily suspend access for further investigation. You agree to notify us immediately in the event of unauthorized access to your account.&nbsp;</p>',27,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(27,48,'heading','<h2>9. Age Restrictions</h2>',28,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(28,48,'paragraph','<p>\"Side to Side\" is intended for users who are 13 years of age or older. By using this game, you represent that you meet this age requirement. We do not knowingly collect personal data from users under the age of 13 without parental consent. If we learn that we have inadvertently collected information from a user under 13, we will delete such data promptly.&nbsp;</p>',29,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(29,48,'heading','<h2>10. User Conduct</h2>',30,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(30,48,'paragraph','<p>You agree not to use the \"Side to Side\" app to engage in activities that are illegal, harmful, or disruptive. This includes, but is not limited to, hacking, cheating, harassment, and the exploitation of in-game bugs or vulnerabilities. Any user found violating these rules may have their account suspended or permanently banned.&nbsp;</p>',31,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(31,48,'heading','<h2>11. Intellectual Property</h2>',32,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(32,48,'paragraph','<p>All intellectual property related to \"Side to Side,\" including game design, graphics, and software, belongs to the company. You agree not to reproduce, distribute, or modify any part of the game without express permission. Unauthorized use of intellectual property may result in legal action.&nbsp;</p>',33,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(33,48,'heading','<h2>12. Data Collection and Privacy</h2>',34,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(34,48,'paragraph','<p>We collect user data to improve the game experience and analyze performance. By playing the game, you consent to the collection and use of your data as outlined in our Privacy Policy. You have the right to request the deletion of your data at any time by contacting us.&nbsp;</p>',35,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(35,48,'heading','<h2>13. Suspension and Termination of Services</h2>',36,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(36,48,'paragraph','<p>We reserve the right to suspend or terminate your access to the game at any time, with or without notice, for any reason, including breach of these terms. In the event of termination, you will lose access to your account and any associated rewards or in-game items.&nbsp;</p>',37,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(37,48,'heading','<h2>14. Refund Policy</h2>',38,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(38,48,'paragraph','<p>All purchases made through the app, including in-app purchases, are non-refundable. Exceptions may be made in cases of fraud, unauthorized transactions, or technical issues directly caused by the app.&nbsp;</p>',39,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(39,48,'heading','<h2>15. Liability Disclaimer</h2>',40,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(40,48,'paragraph','<p>We do not guarantee that \"Side to Side\" will be free of errors or uninterrupted. The game is provided \"as is,\" and we are not responsible for any issues that may arise during gameplay, including data loss, service outages, or system failures.&nbsp;</p>',41,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(41,48,'heading','<h2>16. Force Majeure</h2>',42,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(42,48,'paragraph','<p>We shall not be liable for any delay or failure to perform resulting from causes outside our reasonable control, including but not limited to natural disasters, acts of war, strikes, and technical failures.&nbsp;</p>',43,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(43,48,'heading','<h2>17. Changes to Terms and Conditions</h2>',44,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(44,48,'paragraph','<p>We reserve the right to modify these terms at any time. Changes will be posted on our website, and your continued use of the app constitutes acceptance of the updated terms.&nbsp;</p>',45,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(45,48,'heading','<h2>18. Governing Law</h2>',46,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(46,48,'paragraph','<p>These terms shall be governed and construed in accordance with the laws of [Your Country]. Any disputes arising from these terms or the use of the app shall be resolved in the courts of [Your Jurisdiction].&nbsp;</p>',47,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(47,48,'heading','<h2>19. Contact Us</h2>',48,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(48,48,'paragraph','<p>If you have any questions or concerns regarding<strong> </strong>these Terms and Conditions, feel free to contact us at&nbsp;</p>',49,'2024-10-21 23:36:10','2024-11-14 01:21:11',0),(49,45,'heading','<h2>1. Overview</h2>',1,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(50,45,'paragraph','<p>At \"Side to Side,\" we value your privacy and are committed to protecting the information you provide when using our game or website. This Privacy Policy outlines what data we collect, how we use it, and the measures we take to safeguard your personal information.&nbsp;</p>',2,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(51,45,'heading','<h2>2. Data We Collect</h2>',3,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(52,45,'paragraph','<p>We collect the following types of information from users:</p>',4,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(53,45,'heading','<h2>2.1. Information You Provide</h2>',5,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(54,45,'paragraph','<p>When you sign up for an account, participate in in-game purchases, or contact us, we may collect personal information such as your name, email address, billing information, and game preferences.&nbsp;</p>',6,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(55,45,'heading','<h2>2.2. Automatically Collected Information</h2>',7,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(56,45,'paragraph','<p>We automatically collect certain data when you play \"Side to Side\" or visit our website, including your IP address, device information, browser type, and interactions with the game (e.g., scores, rewards, skins selected).&nbsp;</p>',8,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(57,45,'heading','<h2>3. How We Use Your Data</h2><p><br></p>',9,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(58,45,'list','<p>We use your data to improve game features, provide personalized experiences, and track your progress.&nbsp;</p>',11,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(59,45,'list','<p>We collect payment information to facilitate in-app purchases and manage your in-game rewards.&nbsp;</p>',13,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(60,45,'list','<p>We use aggregated data to analyze how users interact with the game and website, helping us make improvements.&nbsp;</p>',15,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(61,45,'list','<p>We monitor user activity to detect potential fraud or unauthorized activity and to maintain the security of our services.&nbsp;</p>',17,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(62,45,'heading','<h2>4. Data Sharing</h2>',18,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(63,45,'paragraph','<p>We do not sell your personal information to third parties. However, we may share data with trusted partners in the following situations:&nbsp;</p>',19,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(64,45,'heading','<h2>4.1. Payment Processing</h2>',20,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(65,45,'paragraph','<p>We work with third-party payment processors to handle transactions securely. These providers adhere to strict data protection standards to safeguard your payment information.&nbsp;</p>',21,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(66,45,'heading','<h2>4.2. Compliance with Laws</h2>',22,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(67,45,'paragraph','<p>We may disclose your information if required by law or if we believe such action is necessary to protect our rights or the rights of others.&nbsp;</p>',23,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(68,45,'heading','<h2>5. Cookies and Tracking Technologies</h2>',24,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(69,45,'paragraph','<p>We use cookies and similar technologies to improve your experience on our website. Cookies help us understand user behavior and track game performance, allowing us to enhance gameplay and customize in-game features.&nbsp;</p>',25,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(70,45,'heading','<h2>6. Data Security</h2>',26,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(71,45,'paragraph','<p>We take appropriate technical and organizational measures to protect your data from unauthorized access, alteration, or deletion. However, no online service is completely secure, and we cannot guarantee absolute data protection.&nbsp;</p>',27,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(72,45,'heading','<h2>7. Your Rights</h2>',28,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(73,45,'paragraph','<p>You have the right to access, correct, or delete your personal information. If you wish to exercise any of these rights, please contact us at&nbsp;</p>',29,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(74,45,'heading','<h2>8. Changes to This Privacy Policy</h2>',31,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(75,45,'paragraph','<p>We may update this Privacy Policy from time to time to reflect changes in our practices or applicable laws. We encourage you to review this page periodically for the latest information on our privacy practices.&nbsp;</p>',32,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(76,45,'heading','<h2>9. Contact Us</h2>',33,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(77,45,'paragraph','<p>If you have any questions about this Privacy Policy or our data handling practices, please contact us at&nbsp;</p>',34,'2024-10-21 23:53:10','2024-11-14 01:21:11',0),(78,48,'list','<p>You may use our templates for client work, but no more than one project at a time.&nbsp;</p>',10,'2024-10-22 00:04:18','2024-11-14 01:21:11',0),(79,48,'list','<p>Virtual items cannot be transferred or refunded.&nbsp;</p>',21,'2024-10-22 00:04:18','2024-11-14 01:21:12',0),(85,45,'subtitle','<p><strong>To Enhance Gameplay:&nbsp;</strong></p>',10,'2024-10-22 02:47:10','2024-11-14 01:21:12',0),(86,45,'subtitle','<p><strong>To Process Transactions:&nbsp;</strong></p>',12,'2024-10-22 02:47:10','2024-11-14 01:21:12',0),(87,45,'subtitle','<p><strong>To Improve Our Services:&nbsp;</strong></p>',14,'2024-10-22 02:47:10','2024-11-14 01:21:12',0),(88,45,'subtitle','<p><strong>For Security:&nbsp;</strong></p>',16,'2024-10-22 02:47:10','2024-11-14 01:21:12',0),(89,45,'link','<p><strong>majed.issa62@gmail.com&nbsp;</strong></p>',30,'2024-10-22 02:55:48','2024-11-14 01:21:12',0),(90,45,'link','<p><strong>majed.issa62@gmail.com</strong></p>',35,'2024-10-22 02:55:48','2024-11-14 01:21:12',0),(91,48,'link','<p><strong>majed.issa62@gmail.com&nbsp;</strong></p>',50,'2024-10-22 04:07:38','2024-11-14 01:21:12',0),(92,48,'subtitle','<p><strong>Redistribution Restrictions:&nbsp;</strong></p>',7,'2024-10-22 04:07:38','2024-11-14 01:21:12',0),(93,48,'subtitle','<p><strong>Client Use:&nbsp;</strong></p>',9,'2024-10-22 04:07:38','2024-11-14 01:21:12',0),(94,48,'subtitle','<p><strong>In-App Purchases:&nbsp;</strong></p>',18,'2024-10-22 04:07:38','2024-11-14 01:21:12',0),(95,48,'subtitle','<p><strong>Non-Refundable:&nbsp;</strong></p>',20,'2024-10-22 04:07:38','2024-11-14 01:21:12',0),(96,48,'paragraph','<p>Under no circumstances will \"Side to Side\" be liable for any direct, indirect, incidental, or consequential damages, including data loss or profit loss arising from the use or inability to use this site.&nbsp;</p>',3,'2024-10-22 04:19:52','2024-11-14 01:21:12',0),(97,48,'paragraph','<p>All content and templates inherit the GNU general public license. You are prohibited from redistributing or reselling our templates or using them on multiple projects without permission.&nbsp;</p><p><br></p>',6,'2024-10-22 04:19:52','2024-11-14 01:21:12',0),(98,48,'paragraph','<p>Points and rewards earned in the game are subject to change, and we reserve the right to modify reward systems without prior notice.&nbsp;</p>',15,'2024-10-22 04:19:52','2024-11-14 01:21:12',0),(99,57,'heading','<h3><strong>For more information about the Side to Side game or to reach the development team, please contact us at&nbsp;</strong></h3>',1,'2024-10-23 00:30:36','2024-11-14 01:21:12',0),(100,57,'link','<h3>majed.issa62@gmail.com&nbsp;</h3>',2,'2024-10-23 00:30:36','2024-11-14 01:21:12',0),(111,60,'paragraph','<p>To excel in \"Side to Side,\" timing is everything. Anticipate platform movements and plan your jumps carefully. The game’s pace increases as you progress, so stay focused and refine your skills with each play.</p>',1,'2024-10-23 23:17:15','2024-11-14 01:21:12',0),(112,60,'paragraph','<p>Check the global leaderboard regularly to see how you stack up against other players. Every week brings a new opportunity to climb the ranks and showcase your skills!</p><p><br></p>',2,'2024-10-23 23:17:15','2024-11-14 01:21:12',0),(113,60,'heading','<h3>Stay Competitive and Have Fun</h3><p><br></p>',3,'2024-10-23 23:17:15','2024-11-14 01:21:12',0),(114,60,'paragraph','<p>As you climb the leaderboard, you\'ll face tougher challenges. Use the rewards you’ve unlocked to enhance your gameplay. Each game is a chance to improve and rise to the top!</p>',4,'2024-10-23 23:17:15','2024-11-14 01:21:12',0),(115,60,'paragraph','<p>Remember, \"Side to Side\" is not just about high scores—it\'s about enjoying the vibrant, dynamic gameplay. With responsive controls and customizable visuals, every game offers a new, exciting experience. Have fun, and may the best player win!</p><p><br></p>',5,'2024-10-23 23:17:15','2024-11-14 01:21:12',0),(116,60,'subtitle','<p><strong>Unlock New Skins:</strong>&nbsp;</p>',6,'2024-10-23 23:17:15','2024-11-14 01:21:12',0),(117,60,'list','<p>Customize your ball with a variety of skins as you progress.</p>',7,'2024-10-23 23:17:15','2024-11-14 01:21:12',0),(118,60,'subtitle','<p><strong>Compete Globally:</strong>&nbsp;</p>',8,'2024-10-23 23:17:15','2024-11-14 01:21:12',0),(119,60,'list','<p>See how you rank against players worldwide.</p>',9,'2024-10-23 23:17:15','2024-11-14 01:21:12',0),(120,60,'subtitle','<p><strong>Responsive Controls:</strong>&nbsp;</p>',10,'2024-10-23 23:17:15','2024-11-14 01:21:12',0),(121,60,'list','<p>Enjoy smooth, intuitive gameplay.</p>',11,'2024-10-23 23:17:15','2024-11-14 01:21:12',0),(122,60,'subtitle','<p><strong>Vibrant Graphics:</strong>&nbsp;</p>',12,'2024-10-23 23:17:15','2024-11-14 01:21:12',0),(123,60,'list','<p>Each game is a visual treat.</p>',13,'2024-10-23 23:17:15','2024-11-14 01:21:12',0),(124,60,'subtitle','<p><strong>Regular Updates:&nbsp;</strong></p>',14,'2024-10-23 23:17:15','2024-11-14 01:21:12',0),(125,60,'list','<p>New skins, features, and challenges are added regularly.</p>',15,'2024-10-23 23:17:15','2024-11-14 01:21:12',0),(127,43,'heading','<h2>Game Overview</h2>',1,'2024-10-25 00:42:13','2024-11-14 01:21:12',0),(128,43,'paragraph','<p>\"Side to Side\" is a thrilling mobile game that challenges players to navigate a ball through an endless series of platforms. By swiping left and right, you can jump between platforms and avoid obstacles. The goal? To score as many points as possible while ascending into infinity.</p>',2,'2024-10-25 00:42:13','2024-11-14 01:21:12',0),(129,43,'paragraph','<p>With its ever-increasing difficulty and engaging mechanics, \"Side to Side\" is sure to keep players hooked, striving to reach the top of the global leaderboard and unlock exciting rewards along the way.</p>',3,'2024-10-25 00:42:13','2024-11-14 01:21:12',0),(130,61,'heading','<h3>Global Leaderboard</h3>',1,'2024-10-25 01:00:43','2024-11-14 01:21:12',0),(131,61,'paragraph','<p>Compete with players worldwide. Track your ranking on the global leaderboard, which resets weekly to give everyone a chance to rise to the top. Challenge your friends and become the best in the world!</p>',2,'2024-10-25 01:00:43','2024-11-14 01:21:12',0),(132,61,'heading','<h3>Customize Your Game</h3>',3,'2024-10-25 01:00:43','2024-11-14 01:21:12',0),(133,61,'paragraph','<p>Personalize your gaming experience by unlocking new skins for your ball and vibrant backgrounds. Stand out from other players with unique styles that you can earn as rewards by achieving high scores.</p>',4,'2024-10-25 01:00:43','2024-11-14 01:21:12',0),(134,61,'heading','<h3>Smooth and Responsive Controls</h3>',5,'2024-10-25 01:00:43','2024-11-14 01:21:12',0),(135,61,'paragraph','<p>Experience smooth, intuitive controls that allow for precise movements and jumps. Perfect your timing and coordination to master the game and achieve the highest scores possible.</p>',6,'2024-10-25 01:00:43','2024-11-14 01:21:12',0),(186,33,'heading','<h1>Side to Side - The Ultimate Platform Jumping Game</h1>',1,'2024-10-31 08:06:34','2024-11-14 01:21:12',0),(187,33,'paragraph','<p>Control the ball, jump on platforms, and keep scoring in this endless, fun-filled game!</p><p><br></p>',2,'2024-10-31 08:06:34','2024-11-14 01:21:12',0),(188,36,'heading','<h2>About the Side to Side Game</h2><p><br></p>',1,'2024-11-01 04:44:54','2024-11-14 01:21:12',0),(189,36,'paragraph','<p>Side to Side is an exciting mobile game that challenges players to control a ball by swiping left and right. The objective is to jump from platform to platform as they move upwards infinitely. The game tests your reflexes and timing as you try to score as many points as possible by staying on the platforms without falling.</p>',2,'2024-11-01 04:44:54','2024-11-14 01:21:12',0),(190,36,'paragraph','<p>With its intuitive controls and endless gameplay, Side to Side provides an engaging and addictive experience for players of all ages. Keep jumping, score higher, and see how far you can go!</p>',3,'2024-11-01 04:44:54','2024-11-14 01:21:12',0),(191,41,'heading','<h2>Customize Your Experience</h2><p><br></p>',1,'2024-11-01 04:50:48','2024-11-14 01:21:12',0),(192,41,'list','<p>Change the color and skin of your ball</p>',2,'2024-11-01 04:50:48','2024-11-14 01:21:12',0),(193,41,'list','<p>Select different backgrounds to match your style</p>',3,'2024-11-01 04:50:48','2024-11-14 01:21:12',0),(194,41,'list','<p>Use power-ups to boost your score</p>',4,'2024-11-01 04:50:48','2024-11-14 01:21:12',0),(195,40,'heading','<h2>Unlock New Skins and Power-ups</h2>',1,'2024-11-01 04:53:25','2024-11-14 01:21:12',0),(196,40,'paragraph','<p>As you reach higher scores, you\'ll unlock new skins for your ball and special power-ups that will give you an edge in the game. Customize your gameplay and showcase your achievements.</p>',2,'2024-11-01 04:53:25','2024-11-14 01:21:12',0),(197,40,'paragraph','<p>Challenge yourself to reach new heights and unlock all the skins and power-ups available in the game!</p>',3,'2024-11-01 04:53:25','2024-11-14 01:21:12',0),(214,37,'heading','<h3>Rewards System</h3>',1,'2024-11-01 05:31:30','2024-11-14 01:21:12',0),(215,37,'paragraph','<p>Earn rewards for reaching milestones! For every 100 points scored, players will receive exciting rewards, such as new skins, power-ups, and more!</p>',2,'2024-11-01 05:31:30','2024-11-14 01:21:12',0),(216,37,'heading','<h3>Customizable Ball and Background</h3>',3,'2024-11-01 05:31:30','2024-11-14 01:21:12',0),(217,37,'paragraph','<p>Personalize your gaming experience by changing the color and skin of the ball, as well as the background. Show off your unique style as you jump to the top!</p>',4,'2024-11-01 05:31:30','2024-11-14 01:21:12',0),(218,37,'heading','<h3>Global Leaderboard</h3>',5,'2024-11-01 05:31:30','2024-11-14 01:21:12',0),(219,37,'paragraph','<p>Compete with players from around the world! Climb the global leaderboard by scoring high and see where you stand against the best players.</p>',6,'2024-11-01 05:31:30','2024-11-14 01:21:12',0),(220,37,'heading','<h3>Smooth Controls</h3>',7,'2024-11-01 05:31:30','2024-11-14 01:21:12',0),(221,37,'paragraph','<p>Experience smooth and responsive controls designed for easy gameplay. Swipe left and right effortlessly as you jump from platform to platform.</p>',8,'2024-11-01 05:31:30','2024-11-14 01:21:12',0);
/*!40000 ALTER TABLE `content_blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

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

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_info`
--

DROP TABLE IF EXISTS `game_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `game_info` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `score` int NOT NULL DEFAULT '0',
  `retry_times` int NOT NULL DEFAULT '0',
  `unlocked_skins` json DEFAULT NULL,
  `unlocked_backgrounds` json DEFAULT NULL,
  `unlocked_trophies` json DEFAULT NULL,
  `background_selected` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default_background.png',
  `ball_skin_selected` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default_ball_skin.png',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `coin` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `game_info_user_id_foreign` (`user_id`),
  CONSTRAINT `game_info_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_info`
--

LOCK TABLES `game_info` WRITE;
/*!40000 ALTER TABLE `game_info` DISABLE KEYS */;
INSERT INTO `game_info` VALUES (1,1,143,3,'\"[\\\"skin1\\\",\\\"skin2\\\"]\"','\"[\\\"background1\\\"]\"','\"[\\\"trophy1\\\"]\"','uploads/detail1.webp','uploads/header smartphone.webp','2024-11-12 14:49:33','2024-11-14 01:21:11',46),(2,2,836,3,'\"[\\\"skin1\\\",\\\"skin2\\\"]\"','\"[\\\"background1\\\"]\"','\"[\\\"trophy1\\\"]\"','uploads/detail2.webp','uploads/article-details-small.jpg','2024-11-12 14:49:34','2024-11-14 01:21:11',46),(3,22,474,1,'\"[\\\"skin1\\\"]\"','\"[\\\"background1\\\"]\"','\"[\\\"trophy1\\\"]\"','uploads/detail3.webp','uploads/article-details-large.jpg','2024-11-12 14:49:34','2024-11-14 01:21:11',72);
/*!40000 ALTER TABLE `game_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_statistics`
--

DROP TABLE IF EXISTS `game_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `game_statistics` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `total_users_registered` int NOT NULL DEFAULT '0',
  `daily_users_registered` int NOT NULL DEFAULT '0',
  `monthly_users_registered` int NOT NULL DEFAULT '0',
  `daily_active_users` int NOT NULL DEFAULT '0',
  `monthly_active_users` int NOT NULL DEFAULT '0',
  `total_active_users` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `daily_active_guests` int NOT NULL DEFAULT '0',
  `monthly_active_guests` int NOT NULL DEFAULT '0',
  `total_active_guests` bigint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_statistics`
--

LOCK TABLES `game_statistics` WRITE;
/*!40000 ALTER TABLE `game_statistics` DISABLE KEYS */;
/*!40000 ALTER TABLE `game_statistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gameuserstatistics`
--

DROP TABLE IF EXISTS `gameuserstatistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gameuserstatistics` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `last_seen_online` timestamp NULL DEFAULT NULL,
  `game_current_visit` int NOT NULL DEFAULT '0',
  `average_session_duration` int DEFAULT NULL,
  `platform` enum('play_store','app_store','website') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'website',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gameuserstatistics_user_id_foreign` (`user_id`),
  CONSTRAINT `gameuserstatistics_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gameuserstatistics`
--

LOCK TABLES `gameuserstatistics` WRITE;
/*!40000 ALTER TABLE `gameuserstatistics` DISABLE KEYS */;
/*!40000 ALTER TABLE `gameuserstatistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (13,'2014_10_12_000000_create_users_table',1),(14,'2014_10_12_100000_create_password_reset_tokens_table',1),(15,'2019_08_19_000000_create_failed_jobs_table',1),(16,'2019_12_14_000001_create_personal_access_tokens_table',1),(17,'2024_09_15_000217_create_ads_table',1),(18,'2024_10_06_015556_create_game_info_table',1),(19,'2024_10_10_035913_create_ad_statistics_table',1),(20,'2024_10_10_040125_create_skins_table',1),(21,'2024_10_10_040845_create_backgrounds_table',1),(22,'2024_10_10_040915_create_trophies_table',1),(23,'2024_10_10_041949_create_game_statistics_table',1),(24,'2024_10_10_042433_create_site_statistics_table',1),(25,'2024_10_15_222932_create_categories_table',2),(26,'2024_10_15_222941_create_posts_table',3),(27,'2024_10_15_223040_create_category_posts_table',3),(28,'2024_10_15_234817_delete_user_id_from_post_table',4),(30,'2024_10_16_025917_rename_thumbail_to_uploaded_file_in_posts_table',5),(31,'2024_10_16_220749_add_timezone_to_users_table',6),(32,'2024_10_16_230058_add_timezone_to_posts_table',6),(33,'2024_10_18_074448_add_section_to_category_post_table',7),(34,'2024_10_18_111120_make_title_slug_body_nullable_in_posts_table',8),(35,'2024_10_19_100430_create_content_blocks_table',9),(36,'2024_10_19_222512_update_game_info_table',10),(37,'2024_10_19_225336_remove_total_achievements_from_game_statistics_table',11),(40,'2024_10_22_012109_add_use_blocks_to_posts_table',12),(41,'2024_10_21_235659_add_use_blocks_to_content_blocks_table',13),(42,'2024_11_01_080245_create_team_members_table',13),(44,'2024_11_03_182723_update_site_statistics_table',14),(45,'2024_11_03_185819_add_guest_activity_reset_fields_to_site_statistics',15),(51,'2024_11_03_194628_create_user_statistics_table',16),(52,'2024_11_03_200004_delete_records_site_statistics_table',16),(53,'2024_11_04_082709_add_current_visit_to_user_statistics',17),(55,'2024_11_06_001749_drop_primary_key_from_email_on_password_reset_tokens',18),(56,'2024_11_06_001812_add_id_column_to_password_reset_tokens_as_primary',19),(61,'2024_11_06_203021_rename_ad_type_to_ad_platform_in_ads_table',20),(62,'2024_11_06_203055_add_ad_type_and_google_code_to_ads_table',20),(64,'2024_11_06_220542_add_description_to_ads_table',21),(93,'2024_11_06_225814_add_manual_override_to_posts_table',22),(94,'2024_11_07_122917_add_monetization_fields_to_ads_table',22),(95,'2024_11_07_140918_modify_ad_statistics_table',22),(96,'2024_11_09_214538_create_gameuserstatistics_table',22),(97,'2024_11_09_230258_remove_and_add_columns_from_game_statistics_table',22),(98,'2024_11_10_211634_update_background_skin_and_trophy_tables',22);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `password_reset_tokens_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
INSERT INTO `password_reset_tokens` VALUES (1,'majed.issa62@gmail.com','$2y$12$F7WzY50YxBIoiRcb4veUl.oOeE1t2fkMCD2Aqo.JEr6stxxpJxD3C','2024-10-22 14:07:39'),(2,'user1@example.com','$2y$12$kNtYxZ5pOcjCbp5rNQ1RhOakdzxdUefEJvfPYNGQRmy2h1VDAbUuG','2024-10-13 06:22:32'),(3,'user2@example.com','$2y$12$FDmfsza1yB2YFQueGcRdz.D/MEcRnr2nJ6x9cZ4/1ym2ZayS59AU6','2024-11-02 10:42:02'),(4,'user2003@example.com','$2y$12$9JwXbr01g3qhWTgAeke1NOSzZ9QzCd7OSIImIhvZLLWVK.jv7n4sq','2024-11-02 10:42:21'),(5,'user3@example.com','$2y$12$fD9RM5y0h.Z36v0iBFzLh.FhDB7mOHAH8.62p3u0ktKG1cHpqHG5W','2024-11-02 10:47:32');
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (2,'App\\Models\\User',22,'MobileAppToken','fba16ec2cb034e6dfd33b1357a9de64d4551db549cd18526fc5c31ac46454b65','[\"*\"]',NULL,NULL,'2024-11-14 00:54:09','2024-11-14 01:21:12'),(3,'App\\Models\\User',28,'MobileAppToken','6d9c23702087e6d4b0ab4a4e61a3db05baec438016d7098832dee18cc7e562ca','[\"*\"]',NULL,NULL,'2024-11-14 01:16:42','2024-11-14 01:21:12'),(4,'App\\Models\\User',22,'MobileAppToken','b51ca89aab5a4e45db2fd2bf640559e179983f6590e1d93b5150fcbbcc461a6f','[\"*\"]',NULL,NULL,'2024-11-14 02:02:04','2024-11-14 02:02:04'),(5,'App\\Models\\User',22,'MobileAppToken','cba3cbfee30b4367b66ad3cd18d3c7fbadb5b5e27387a66d777c0cbeccf96f23','[\"*\"]',NULL,NULL,'2024-11-14 02:02:15','2024-11-14 02:02:15'),(6,'App\\Models\\User',1,'MobileAppToken','72a1fefeb92c1ec864d988ed0706835f7bd01441587126b84082b487258f532b','[\"*\"]',NULL,NULL,'2024-11-14 09:38:38','2024-11-14 09:38:38'),(7,'App\\Models\\User',1,'MobileAppToken','d72b20432637fa8efd228775cee2b273385528865f3d9291ba7602532ed1889a','[\"*\"]',NULL,NULL,'2024-11-14 10:20:11','2024-11-14 10:20:11');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uploaded_file` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL,
  `manual_override` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` datetime NOT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `use_blocks` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (33,'Side to Side - The Ultimate Platform Jumping Game','side-to-side-the-ultimate-platform-jumping-game','uploads/header smartphone.webp',NULL,1,0,'2024-10-18 13:41:04','UTC','2024-10-18 07:42:38','2024-11-14 01:21:11',1),(35,'Introduction to Game Side to Side','introduction-to-game-side-to-side',NULL,'Side to Side is an addictive mobile game that will keep you on your toes as you control a ball jumping on endlessly moving platforms. Can you keep up?',1,0,'2024-10-18 14:02:25','UTC','2024-10-18 08:02:33','2024-11-14 01:21:11',0),(36,'About the Side to Side Game','about-the-side-to-side-game','uploads/detail1.webp',NULL,1,0,'2024-10-18 14:03:30','UTC','2024-10-18 08:04:11','2024-11-14 01:21:11',1),(37,'Features of the game','features-of-the-game',NULL,NULL,1,0,'2024-10-18 14:05:22','UTC','2024-10-18 08:05:37','2024-11-14 01:21:11',1),(40,'Unlock New Skins and Power-ups','unlock-new-skins-and-power-ups','uploads/detail3.webp',NULL,1,0,'2024-10-18 14:07:13','UTC','2024-10-18 08:07:36','2024-11-14 01:21:11',1),(41,'Customize Your Experience','customize-your-experience','uploads/detail2.webp',NULL,1,0,'2024-10-18 14:08:00','UTC','2024-10-18 08:08:35','2024-11-14 01:21:11',1),(42,'Download game','download-game','uploads/conclusionimage.webp','Mobile games don’t get much better than Side to Side. Customize your ball, climb the leaderboard, and unlock rewards! Download now and start your adventure!',1,0,'2024-10-18 14:09:43','UTC','2024-10-18 08:12:16','2024-11-14 01:21:11',0),(43,'Game Overview','game-overview',NULL,NULL,1,0,'2024-10-18 14:13:57','UTC','2024-10-18 08:15:03','2024-11-14 01:21:11',1),(44,'1st Image for blog','1st-image-for-blog','uploads/article-details-large.jpg','',1,0,'2024-10-18 14:15:28','UTC','2024-10-18 08:15:47','2024-11-14 01:21:11',0),(45,'Privacy Policy main content ','privacy-policy-main-content',NULL,NULL,1,0,'2024-10-18 14:32:03','UTC','2024-10-18 08:32:25','2024-11-14 01:21:11',1),(47,'Header of Terms content','header-of-terms-content',NULL,'<p>The \"Side to Side\" app automatically collects and receives certain information from your device, including activities on our website, platforms, and applications, as well as hardware and software details like your operating system or browser.&nbsp;</p>',1,0,'2024-10-23 02:20:01','UTC','2024-10-18 08:48:46','2024-11-14 01:21:11',0),(48,'Main Content of terms conditions','main-content-of-terms-conditions',NULL,NULL,1,0,'2024-10-20 04:15:27','UTC','2024-10-19 22:15:45','2024-11-14 01:21:11',1),(57,'Contact Us information','contact-us-information',NULL,NULL,0,0,'2024-11-07 17:20:50','UTC','2024-10-23 00:29:04','2024-11-14 01:21:11',1),(60,'Mastering Side to Side ','mastering-side-to-side','uploads/article-details-small.jpg',NULL,1,0,'2024-10-23 05:16:49','UTC','2024-10-23 23:17:15','2024-11-14 01:21:11',1),(61,'Features of the game','features-of-the-game',NULL,NULL,1,0,'2024-10-24 07:00:13','UTC','2024-10-25 01:00:43','2024-11-14 01:21:11',1),(62,'bn','bn',NULL,'<p>cvv</p>',1,0,'2024-11-03 12:14:14','UTC','2024-11-03 08:14:52','2024-11-14 01:21:11',0);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_statistics`
--

DROP TABLE IF EXISTS `site_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_statistics` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `total_users_registered` int NOT NULL DEFAULT '0',
  `daily_users_registered` int NOT NULL DEFAULT '0',
  `monthly_users_registered` int NOT NULL DEFAULT '0',
  `daily_active_guests` bigint unsigned NOT NULL DEFAULT '0',
  `monthly_active_guests` bigint unsigned NOT NULL DEFAULT '0',
  `last_reset_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_visits` bigint unsigned NOT NULL DEFAULT '0',
  `daily_visits` bigint unsigned NOT NULL DEFAULT '0',
  `monthly_visits` bigint unsigned NOT NULL DEFAULT '0',
  `daily_active_users` bigint unsigned NOT NULL DEFAULT '0',
  `monthly_active_users` bigint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_statistics`
--

LOCK TABLES `site_statistics` WRITE;
/*!40000 ALTER TABLE `site_statistics` DISABLE KEYS */;
INSERT INTO `site_statistics` VALUES (1,25,1,13,18,33,'2024-11-11 22:00:58','2024-11-04 05:56:12','2024-11-14 10:33:50',57,21,57,34,53);
/*!40000 ALTER TABLE `site_statistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skins`
--

DROP TABLE IF EXISTS `skins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `skins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `skin_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `skin_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` int NOT NULL DEFAULT '0' COMMENT 'Cost in coins',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skins`
--

LOCK TABLES `skins` WRITE;
/*!40000 ALTER TABLE `skins` DISABLE KEYS */;
INSERT INTO `skins` VALUES (1,'skin1','01JCGKF2CH40YWF9BAZBCA78WF.ico',0,'2024-11-12 16:31:48','2024-11-14 01:21:12'),(2,'skin2','01JCGKG3HJW3B633MSM5BP2N6J.png',0,'2024-11-12 16:32:22','2024-11-14 01:21:12');
/*!40000 ALTER TABLE `skins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_members`
--

DROP TABLE IF EXISTS `team_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quote` text COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_members`
--

LOCK TABLES `team_members` WRITE;
/*!40000 ALTER TABLE `team_members` DISABLE KEYS */;
INSERT INTO `team_members` VALUES (1,'Wadee Issa','Mobile Developer & Project Management','Side to Side has been a rewarding project. The smooth gameplay and endless fun keep our users engaged.','uploads/pricing-background.jpg','2024-11-01 06:07:29','2024-11-14 01:21:12'),(2,'Alexander Issa','Mobile Developer & Web Developer','Creating a seamless and responsive interface was key to making Side to Side a hit among players.','uploads/Alexander-issa.jpeg','2024-11-01 06:07:29','2024-11-14 01:21:12'),(3,'Nassim Checri','Quality Assurance','Ensuring a bug-free experience for our users has been my top priority. Side to Side delivers quality at every level.','uploads/article-details-small.jpg','2024-11-01 06:07:29','2024-11-14 01:21:12');
/*!40000 ALTER TABLE `team_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trophies`
--

DROP TABLE IF EXISTS `trophies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trophies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `trophy_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trophy_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Icon image path',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unlock_points` int NOT NULL DEFAULT '0' COMMENT 'Unlock points',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trophies`
--

LOCK TABLES `trophies` WRITE;
/*!40000 ALTER TABLE `trophies` DISABLE KEYS */;
INSERT INTO `trophies` VALUES (1,'First Trophy','First Trophy in Our Game',NULL,'2024-11-10 21:49:06','2024-11-14 01:21:12',0);
/*!40000 ALTER TABLE `trophies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_statistics`
--

DROP TABLE IF EXISTS `user_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_statistics` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `last_visit` timestamp NULL DEFAULT NULL,
  `current_visit` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_statistics_user_id_foreign` (`user_id`),
  CONSTRAINT `user_statistics_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_statistics`
--

LOCK TABLES `user_statistics` WRITE;
/*!40000 ALTER TABLE `user_statistics` DISABLE KEYS */;
INSERT INTO `user_statistics` VALUES (2,2,'2024-11-12 23:43:15',NULL,'2024-11-04 05:57:44','2024-11-14 01:21:11'),(3,23,'2024-11-06 03:07:28',NULL,'2024-11-04 06:12:25','2024-11-14 01:21:11'),(4,14,'2024-11-06 03:07:28',NULL,'2024-11-04 06:44:11','2024-11-14 01:21:11'),(5,24,'2024-11-06 03:07:28',NULL,'2024-11-04 10:15:51','2024-11-14 01:21:11'),(6,25,'2024-11-06 03:07:28',NULL,'2024-11-04 14:50:58','2024-11-14 01:21:11'),(7,26,'2024-11-06 03:07:28',NULL,'2024-11-06 01:35:51','2024-11-14 01:21:11'),(8,5,'2024-11-06 03:07:28',NULL,'2024-11-05 23:59:49','2024-11-14 01:21:11'),(9,4,'2024-11-12 03:50:04',NULL,'2024-11-06 00:13:15','2024-11-14 01:21:11'),(10,27,'2024-11-06 03:07:28',NULL,'2024-11-06 00:16:49','2024-11-14 01:21:11'),(11,22,'2024-11-12 16:59:50',NULL,'2024-11-07 10:26:46','2024-11-14 01:21:11'),(12,15,'2024-11-11 05:44:28',NULL,'2024-11-07 20:27:09','2024-11-14 01:21:11'),(13,1,'2024-11-12 01:21:26',NULL,'2024-11-11 23:21:20','2024-11-14 01:21:11'),(14,28,'2024-11-14 01:21:12',NULL,'2024-11-14 01:15:26','2024-11-14 01:29:07');
/*!40000 ALTER TABLE `user_statistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default_username',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apple_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `verification_token` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Alex Issa','Alex Issa','alexander.issa03@gmail.com','$2y$12$868J9DPlzEMrtNscLUqALOz6kKbuUE1PT6R.FNzUXp9zJnu8VeE5W','user','https://lh3.googleusercontent.com/a-/ALV-UjXbULyfvF0ZV0B49KTpmVyhlMVSYsFN3sg0-bbFQXcgRGjPtyw=s96-c','google','117165527295213709912',NULL,1,NULL,NULL,'2024-10-12 17:41:14','2024-11-14 10:20:11','UTC'),(2,'Alex Issa','Alexander M. Issa','majed.issa62@gmail.com','$2y$12$O1oStDm.cGNt46uAooymfeRnNIr/pHoWGC2tU/02NevjjVrKF.aDe','admin','https://lh3.googleusercontent.com/a/ACg8ocJdgnPt4P8dog_fYQz5cCf43SChIZ80ckXzaSyfJKoNAemuLb_X=s96-c','google','101378542810580620331',NULL,1,NULL,'oWB5KiHhyLVRTqH1JeXyFvrSdK38yIAZSjGoLJlq6PdOno3eWHBY5q8JFCvi','2024-10-12 17:47:39','2024-11-14 01:21:12','UTC'),(3,'wadwee',NULL,'user1@example.com','$2y$12$1UDHfLAIasVU7WXlHBbZjugis1t1x4fH5nEZ84c8shFQzahoU80sS','user',NULL,'sidetoside',NULL,NULL,1,NULL,NULL,'2024-10-12 18:09:32','2024-11-14 01:21:12',NULL),(4,'alex',NULL,'aissait18@gmail.com','$2y$12$feFvzsdnxFsY.A0JDCaqkeGOA.L/GHrc2E3kReW5jkBBmbFFWAZhe','user','https://lh3.googleusercontent.com/a/ACg8ocKiCqWnX7qSaADHbCKSNOnzEbpQr5dDATlqQCi7-U1DpU8pfg=s96-c','google','103061350348185538487',NULL,1,'3F2iCyXPes7LBzvxoEFBLzFNVIRy3otcoJEwogOENaG8DSl3Ln8A6y3ROjw4Xexw',NULL,'2024-10-12 19:30:42','2024-11-14 01:21:12','UTC'),(5,'ali',NULL,'user2003@example.com','$2y$12$29WXDQqzLiKrYtMSNAqSyutoeOM0jn4u9S.9a8fXO60d5lxDsweya','user',NULL,'sidetoside',NULL,NULL,1,NULL,NULL,'2024-10-13 03:23:47','2024-11-14 01:21:12','UTC'),(6,'eva',NULL,'user2@example.com','$2y$12$.3unjl6Kk4FaPXVuTuzyoOCSBveYFV6glrjmZfk97HTpueLivamUm','user',NULL,'sidetoside',NULL,NULL,0,'yEZK29m0Tu7Eok7CwkbYnjdMGtX1bxfRmnx4aSiLDc2mGf3nN6uL3GrSQqJgdaLr',NULL,'2024-10-13 03:35:53','2024-11-14 01:21:12',NULL),(7,'jana',NULL,'user2006@example.com','$2y$12$Nd9EtYiz9Zfu2o12puRyCe0TBVNe7PI1iqk1IrmoDrWLH7yFJJyyC','user',NULL,'sidetoside',NULL,NULL,1,NULL,NULL,'2024-10-13 03:40:49','2024-11-14 01:21:12','UTC'),(8,'shasa',NULL,'user3@example.com','$2y$12$NE26ML66f3HEHoD3a3TPMOVRiXGpiWLVE3Rky4Knk3XlaQQRwC8Iq','user',NULL,'sidetoside',NULL,NULL,0,'eS7H4cVduZeC1EoqymAtN4uVWry1Dc064YnsUSJiU0eB5m9Ivhl8uwmzWRhjZV3S',NULL,'2024-10-16 20:11:51','2024-11-14 01:21:12',NULL),(9,'alexa',NULL,'user2003@gmail.com','$2y$12$6VjiL8DSw27fQk.1MLqHROnjRudB79SYHycygAXakWatYtv7K/V4S','user',NULL,'sidetoside',NULL,NULL,0,'SkzeqinmTsAfgPBoP3UksmH0h628AOZb6hVPfk6JyuxitAxRFqYJbSAA42J8Fexj',NULL,'2024-10-16 20:17:33','2024-11-14 01:21:12','UTC'),(10,'alaa',NULL,'user1990@example.com','$2y$12$3VDIOHE99ZfJ3x4YU1Kebee//XoNgIlZKiqNtGntMqeTVAadYAG7.','user',NULL,'sidetoside',NULL,NULL,0,'ImJBq4e7H2RnqBRyzaPeuUj4p9Ns2SaS6qu8RR2ZXUsFwZGb71V5MSo2e9JHvwHw',NULL,'2024-10-16 22:49:31','2024-11-14 01:21:12','UTC'),(11,'ALLA',NULL,'user1991@example.com','$2y$12$Ish.RG.8ozUxrBmuBsrn0O2eyCnyp9bmluT8cz8zaiFHZs5xQYKri','user',NULL,'sidetoside',NULL,NULL,0,'HLq1gCMu3Ng0s2OTk9ENT3kSrDbUIokSKmBdXomEpyC2nzfgZ056HbwtkMwC6hka',NULL,'2024-10-16 22:51:34','2024-11-14 01:21:12','UTC'),(12,'aew',NULL,'user2011@example.com','$2y$12$FqbM.ZtFwymv4Ve4aXS4YePqIU31Xkh2RtMVyo9D3IvcNZLKeLUK.','user',NULL,'sidetoside',NULL,NULL,0,'NFVdXQscxOlNy50EmicPrn70OEgLxVHFazwpsF2N2pak0tWijdW929aaxKlrhnQG',NULL,'2024-10-16 23:05:34','2024-11-14 01:21:12','UTC'),(13,'alibaba',NULL,'alibaba@example.com','$2y$12$vxjdl1ZbxqBFO5M6G3uX0OaB2B.aPbQnHcNEF0n.ceUJoI3Woc2iS','user',NULL,'sidetoside',NULL,NULL,1,NULL,NULL,'2024-11-02 08:31:34','2024-11-14 01:21:12','UTC'),(14,'elena',NULL,'elena@example.com','$2y$12$gw6yXloyePWQsqgjjeZg8.b85gzf5F3etJvu/DWx9wtJJzChSd27S','user',NULL,'sidetoside',NULL,NULL,1,NULL,NULL,'2024-11-02 08:42:26','2024-11-14 01:21:12','UTC'),(15,'default_username','Admin','Admin@sidetoside.com','$2y$12$NaX52l2BiUuKblX62u2KDuyhFxU3NGjFwjHfrWYy7ZLJnUoRxlfFm','admin',NULL,NULL,NULL,NULL,0,NULL,'ZITTiPLhf6','2024-11-02 11:37:14','2024-11-14 01:21:12','UTC'),(16,'default_username','alex','alexadmin@admin.com','$2y$12$1XY.5oaCVIlkWShMBMQ4F.AxVAdFJgXfIDVB.pcLw3fHFWET8e1bG','admin',NULL,NULL,NULL,NULL,0,NULL,NULL,'2024-11-03 07:26:58','2024-11-14 01:21:12',NULL),(20,'alexaaa',NULL,'alex.issa03@example.com','$2y$12$bjaLIT65N4VZCwKrNQGwbeZ46j8dl7aGkzbos/BVfs7Fn01JGIN4K','user',NULL,'sidetoside',NULL,NULL,1,NULL,NULL,'2024-11-03 18:10:08','2024-11-14 01:21:12','UTC'),(21,'alexaaaaa',NULL,'user300@example.com','$2y$12$D1A2YPZLnGY5pzRxwfAEX.psHXR0o3OidGN.7VDXQ7rmswVlXC0EO','user',NULL,'sidetoside',NULL,NULL,1,NULL,NULL,'2024-11-03 19:21:25','2024-11-14 01:21:12','UTC'),(22,'sashaa',NULL,'user3000@example.com','$2y$12$11dWsb5HwjNdLtH65AktP.tt1MQfi1IYl2fhRLohGvISnV0c7QMZG','user',NULL,'sidetoside',NULL,NULL,1,NULL,NULL,'2024-11-04 04:32:26','2024-11-14 10:17:08','UTC'),(23,'alexsa',NULL,'alexssa@example.com','$2y$12$poPK7xhmICV6YKGMfpHTsOnq2FbuHOPD3whG549RnS30KfsRs8PMq','user',NULL,'sidetoside',NULL,NULL,1,NULL,NULL,'2024-11-04 06:12:13','2024-11-14 01:21:12','UTC'),(24,'wadeeeissa',NULL,'user2002@gmail.com','$2y$12$NOUe1JdRFaLnj3qOBA9oMetMnHp5qLQ8KuogbxR6W6g.OudTmO8/W','user',NULL,'sidetoside',NULL,NULL,1,NULL,NULL,'2024-11-04 10:15:40','2024-11-14 01:21:12','UTC'),(25,'mohammad youssef',NULL,'mohamyoussef@example.com','$2y$12$DI/hvNpCZh5yqXM7ZjtF8etJ8Zga3XyPfYh3BkuPlpcmGvxEbYUfi','user',NULL,'sidetoside',NULL,NULL,1,NULL,NULL,'2024-11-04 14:50:49','2024-11-14 01:21:12','UTC'),(26,'alexsius',NULL,'example@example.com','$2y$12$H.QUvC0WP3e4QYwhp2iiy.9OMuU9Kgsi0nWWzpoBQKw1fi8lCcBpO','user',NULL,'sidetoside',NULL,NULL,1,NULL,NULL,'2024-11-05 23:35:11','2024-11-14 01:21:12','UTC'),(27,'sara',NULL,'sara@example.com','$2y$12$7zabkyOENY/LWLsOEo5NP.FMmb7S3B3Wo/xl7mj7cA..9gNRED61m','user',NULL,'sidetoside',NULL,NULL,1,NULL,NULL,'2024-11-06 00:16:29','2024-11-14 01:21:12','UTC'),(28,'JohnDoe',NULL,'johndoe@example.com','$2y$12$F6Ct85RGv0NMdPUALeH.cOhCd6ZP6IUjmuAEoriSW8JfzhJqGJRu6','user',NULL,'sidetoside',NULL,NULL,1,NULL,NULL,'2024-11-14 01:10:06','2024-11-14 01:21:12','UTC');
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

-- Dump completed on 2024-11-14 22:43:15
