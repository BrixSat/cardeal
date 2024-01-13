-- MariaDB dump 10.19  Distrib 10.11.4-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: cardeal
-- ------------------------------------------------------
-- Server version	10.11.4-MariaDB-1~deb12u1

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
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groomName` varchar(255) NOT NULL,
  `brideName` varchar(255) NOT NULL,
  `groomBirthDate` datetime NOT NULL,
  `brideBirthDate` datetime NOT NULL,
  `groomEmail` varchar(255) NOT NULL,
  `brideEmail` varchar(255) NOT NULL,
  `groomPhone` varchar(20) NOT NULL,
  `bridePhone` varchar(20) NOT NULL,
  `groomAddress` varchar(255) NOT NULL,
  `brideAddress` varchar(255) NOT NULL,
  `typeOfEvent` int(11) NOT NULL,
  `civilOrChurch` int(11) NOT NULL,
  `eventDate` datetime NOT NULL,
  `alternativeDates` varchar(255) NOT NULL,
  `closedDate` datetime NOT NULL,
  `tastingDate` datetime NOT NULL,
  `nif` varchar(20) NOT NULL,
  `signalAmmount` varchar(255) NOT NULL,
  `lights` tinyint(1) NOT NULL,
  `rooms` tinyint(1) NOT NULL,
  `menu` tinyint(1) NOT NULL,
  `fireworks` tinyint(1) NOT NULL,
  `fireType` varchar(255) NOT NULL,
  `observations` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES
(1,'César Silva Araújo','Laura Margarida Soares Pacheco da Cunha','2024-01-22 00:00:00','2024-01-24 00:00:00','cesarsilvaaraujo@gmail.com','lauracunha385@gmail.com','913932989','913932988','rua dr ricardo severo n 81','',1,1,'2024-01-17 00:00:00','','2024-01-12 14:17:43','2024-01-12 14:17:43','','',0,1,0,0,'','','2024-01-12 14:17:45','2024-01-12 14:17:45');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `typeOfEvents`
--

DROP TABLE IF EXISTS `typeOfEvents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `typeOfEvents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ypeOfEvent` varchar(55) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typeOfEvents`
--

LOCK TABLES `typeOfEvents` WRITE;
/*!40000 ALTER TABLE `typeOfEvents` DISABLE KEYS */;
INSERT INTO `typeOfEvents` VALUES
(1,'Casamento','2023-09-30 15:14:04','2023-09-30 15:14:04'),
(2,'Baptizado','2023-09-30 15:14:04','2023-09-30 15:14:04'),
(3,'Comunhão','2023-09-30 15:14:04','2023-09-30 15:14:04'),
(4,'Casamento+Baptizado','2023-09-30 15:14:04','2023-09-30 15:14:04'),
(5,'Aniversário','2023-09-30 15:14:04','2023-09-30 15:14:04'),
(6,'Evento Corporativo','2023-09-30 15:15:22','2023-09-30 15:15:22'),
(7,'Evento Privado','2023-09-30 15:15:22','2023-09-30 15:15:22');
/*!40000 ALTER TABLE `typeOfEvents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL COMMENT 'For login purposes',
  `firstName` text DEFAULT NULL,
  `lastName` text DEFAULT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL COMMENT 'Password must be encrypted before',
  `recoverPassword` text NOT NULL DEFAULT '' COMMENT 'Password must be encrypted before',
  `jobTitle` text NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `User_email_pk` (`email`) USING HASH,
  UNIQUE KEY `User_username_pk` (`username`) USING HASH,
  KEY `user_email_index` (`email`(768)),
  KEY `user_username_index` (`username`(768))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES
(1,'admin','Admin','God','admin@exemple.com','$2y$10$JYY9xz3t7NXhNY5aFR.z5O3DNum6ObAPhtQp2fNlvFl410Vd/byzW','','God (at least for this site)','2023-09-23 10:02:00','2023-09-23 10:37:11');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_permissions`
--

DROP TABLE IF EXISTS `user_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_permissions` (
  `permission` text NOT NULL,
  `userid` bigint(20) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  UNIQUE KEY `user_permissions_id_userid_pk` (`permission`,`userid`) USING HASH,
  KEY `user_permissions_user_id_fk` (`userid`),
  CONSTRAINT `user_permissions_user_id_fk` FOREIGN KEY (`userid`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_permissions`
--

LOCK TABLES `user_permissions` WRITE;
/*!40000 ALTER TABLE `user_permissions` DISABLE KEYS */;
INSERT INTO `user_permissions` VALUES
('ADMIN',1,'2023-09-23 10:02:00','2023-09-23 10:02:00');
/*!40000 ALTER TABLE `user_permissions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-12 14:32:01
