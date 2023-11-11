-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: localhost    Database: ecocashpartner
-- ------------------------------------------------------
-- Server version	8.0.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `application_response`
--

DROP TABLE IF EXISTS `application_response`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `application_response` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `approval_status` int DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `form_id` bigint DEFAULT NULL,
  `form_name` varchar(255) DEFAULT NULL,
  `organization_name` varchar(255) DEFAULT NULL,
  `submission_date` datetime DEFAULT NULL,
  `submitted_by` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application_response`
--

LOCK TABLES `application_response` WRITE;
/*!40000 ALTER TABLE `application_response` DISABLE KEYS */;
INSERT INTO `application_response` VALUES (1,4,NULL,NULL,1,'Proper Form','Dickon','2023-10-19 00:00:00','dickon.kachasu',NULL,NULL),(2,NULL,NULL,NULL,1,'Proper Form','Dickon','2023-09-28 13:48:00','dickon.kachasu',NULL,NULL),(3,NULL,NULL,NULL,1,'Proper Form','Dickon','2023-09-28 13:50:01','dickon.kachasu',NULL,NULL),(4,NULL,NULL,NULL,1,'Proper Form','Dickon','2023-09-28 13:51:00','dickon.kachasu',NULL,NULL),(5,NULL,NULL,NULL,1,'Proper Form','Dickon','2023-09-28 13:53:01','dickon.kachasu',NULL,NULL),(6,NULL,NULL,NULL,1,'Proper Form','Dickon','2023-09-28 13:55:51','dickon.kachasu',NULL,NULL),(7,NULL,NULL,NULL,1,'Proper Form','Dickon','2023-09-28 13:58:23','dickon.kachasu',NULL,NULL),(8,NULL,NULL,NULL,1,'Proper Form','Dickon','2023-09-28 17:08:37','dickon.kachasu',NULL,NULL),(9,NULL,NULL,NULL,1,'Proper Form','Dickon','2023-09-28 17:10:10','dickon.kachasu',NULL,NULL),(10,NULL,NULL,NULL,1,'Proper Form','Dickon','2023-09-28 17:20:03','dickon.kachasu',NULL,NULL),(11,NULL,NULL,NULL,1,'Proper Form','Dickon','2023-09-28 17:22:50','dickon.kachasu',NULL,NULL),(12,NULL,NULL,NULL,1,'Proper Form','Dickon','2023-09-28 17:23:43','dickon.kachasu',NULL,NULL),(13,NULL,NULL,NULL,1,'Proper Form','Dickon','2023-09-28 17:25:33','dickon.kachasu',NULL,NULL),(14,NULL,NULL,NULL,1,'Proper Form','Dickon','2023-09-28 17:25:47','dickon.kachasu',NULL,NULL),(15,NULL,NULL,NULL,1,'Proper Form','Dickon','2023-09-28 17:26:20','dickon.kachasu',NULL,NULL),(16,NULL,NULL,NULL,1,'Proper Form','Dickon','2023-09-28 17:28:34','dickon.kachasu',NULL,NULL),(17,NULL,NULL,NULL,1,'Proper Form','Dickon','2023-09-28 17:28:45','dickon.kachasu',NULL,NULL),(18,2,NULL,NULL,1,'Proper Form','Dickon','2023-10-16 00:00:00','dickon.kachasu',NULL,NULL),(19,2,NULL,NULL,1,'Proper Form','Dickon','2023-10-27 00:00:00','dickon.kachasu',NULL,NULL),(20,2,NULL,NULL,1,'Proper Form','Dickon','2023-10-27 00:00:00','dickon.kachasu',NULL,NULL),(21,2,NULL,NULL,1,'Proper Form','Dickon','2023-10-27 00:00:00','dickon.kachasu',NULL,NULL),(22,5,NULL,NULL,1,'Proper Form','Dickon','2023-10-27 00:00:00','dickon.kachasu',NULL,NULL),(23,5,NULL,NULL,1,'Proper Form','Dickon','2023-10-27 00:00:00','dickon.kachasu',NULL,NULL),(24,5,NULL,NULL,1,'Proper Form','Dickon','2023-10-27 00:00:00','dickon.kachasu',NULL,NULL);
/*!40000 ALTER TABLE `application_response` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-09  6:44:17
