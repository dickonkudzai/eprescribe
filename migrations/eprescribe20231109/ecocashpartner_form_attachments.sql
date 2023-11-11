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
-- Table structure for table `form_attachments`
--

DROP TABLE IF EXISTS `form_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `form_attachments` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `created_by` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_modified_by` varchar(255) DEFAULT NULL,
  `last_modified_date` datetime DEFAULT NULL,
  `file_id` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `response_id` bigint DEFAULT NULL,
  `form_id` bigint DEFAULT NULL,
  `section_id` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FKlddsuvmx83asyj0ro1y4p1cgs` (`response_id`),
  KEY `FK7r1toasgnj2bufljo9qs2hmtd` (`form_id`),
  CONSTRAINT `FK7r1toasgnj2bufljo9qs2hmtd` FOREIGN KEY (`form_id`) REFERENCES `app_form` (`id`),
  CONSTRAINT `FKlddsuvmx83asyj0ro1y4p1cgs` FOREIGN KEY (`response_id`) REFERENCES `application_response` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_attachments`
--

LOCK TABLES `form_attachments` WRITE;
/*!40000 ALTER TABLE `form_attachments` DISABLE KEYS */;
INSERT INTO `form_attachments` VALUES (1,NULL,'2023-09-28 13:50:01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,NULL,'2023-09-28 13:51:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,NULL,'2023-09-28 13:53:01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,NULL,'2023-09-28 13:56:38',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,NULL,'2023-09-28 13:58:23',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,NULL,'2023-09-28 14:03:12',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,NULL,'2023-09-28 14:05:28',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,NULL,'2023-09-28 17:08:37',NULL,NULL,'InsuranceReceipt_2023-07-14T13_45_22.894845900.pdf.pdf','.\\uploads\\form-attachments\\form-1\\a2c9e4a6-ae8c-49a7-9a93-ff158edf0df1.pdf','16535','application/pdf',8,1,NULL),(10,NULL,'2023-09-28 17:10:10',NULL,NULL,'InsuranceReceipt_2023-07-14T13_45_22.894845900.pdf.pdf','.\\uploads\\form-attachments\\form-1\\fff12183-9bfc-44eb-8f20-a669841457ea.pdf','16535','application/pdf',9,1,NULL),(11,NULL,'2023-09-28 17:20:03',NULL,NULL,'','.\\uploads\\form-attachments\\form-1\\4cbd0d8d-c5fb-4b5a-a3ec-8e720ca80050.null','0','application/octet-stream',10,1,NULL),(12,NULL,'2023-09-28 17:26:20',NULL,NULL,'Econet Insurance Business Receipt.pdf','.\\uploads\\form-attachments\\form-1\\a882dda1-81b0-4a95-9951-a411929266d2.pdf','82873','application/pdf',15,1,NULL),(13,NULL,'2023-09-28 17:28:45',NULL,NULL,'Econet Insurance Business Receipt.pdf','.\\uploads\\form-attachments\\form-1\\73772ffc-dc79-4ca3-886e-92f4795fc2a9.pdf','82873','application/pdf',17,1,NULL),(14,NULL,'2023-10-19 16:03:50',NULL,NULL,'InsuranceReceipt_2023-07-14T13_45_22.894845900.pdf.pdf','.\\uploads\\form-attachments\\form-1\\f0d344a7-0772-4c03-8a1f-bd191fa07c29.pdf','16535','application/pdf',1,1,NULL);
/*!40000 ALTER TABLE `form_attachments` ENABLE KEYS */;
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
