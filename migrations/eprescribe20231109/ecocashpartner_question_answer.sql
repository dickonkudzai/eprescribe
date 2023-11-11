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
-- Table structure for table `question_answer`
--

DROP TABLE IF EXISTS `question_answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `question_answer` (
  `id` bigint NOT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `question` varchar(255) DEFAULT NULL,
  `question_id` bigint DEFAULT NULL,
  `section_id` bigint DEFAULT NULL,
  `response_id` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FKbopx8v7x3jq8u3ciw17g9lcs9` (`response_id`),
  CONSTRAINT `FKbopx8v7x3jq8u3ciw17g9lcs9` FOREIGN KEY (`response_id`) REFERENCES `application_response` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_answer`
--

LOCK TABLES `question_answer` WRITE;
/*!40000 ALTER TABLE `question_answer` DISABLE KEYS */;
INSERT INTO `question_answer` VALUES (3,'test','<p><em>Second question</em></p>',2,1,1),(4,'test updated','<p>First <strong>question</strong></p>',1,2,1),(5,'test','<p><em>Second question</em></p>',2,1,2),(6,'test','<p>First <strong>question</strong></p>',1,2,2),(7,'test','<p><em>Second question</em></p>',2,1,3),(8,'test','<p>First <strong>question</strong></p>',1,2,3),(9,'test','<p><em>Second question</em></p>',2,1,4),(10,'test','<p>First <strong>question</strong></p>',1,2,4),(11,'test','<p><em>Second question</em></p>',2,1,5),(12,'test','<p>First <strong>question</strong></p>',1,2,5),(13,'test','<p><em>Second question</em></p>',2,1,6),(14,'test','<p>First <strong>question</strong></p>',1,2,6),(15,'test','<p><em>Second question</em></p>',2,1,7),(16,'test','<p>First <strong>question</strong></p>',1,2,7),(17,'test','<p><em>Second question</em></p>',2,1,8),(18,'test','<p>First <strong>question</strong></p>',1,2,8),(19,'test','<p><em>Second question</em></p>',2,1,9),(20,'test','<p>First <strong>question</strong></p>',1,2,9),(21,'testung','<p><em>Second question</em></p>',2,1,10),(22,'klkwdlklsdk','<p>First <strong>question</strong></p>',1,2,10),(23,'testung','<p><em>Second question</em></p>',2,1,11),(24,'klkwdlklsdk','<p>First <strong>question</strong></p>',1,2,11),(25,'testung','<p><em>Second question</em></p>',2,1,12),(26,'klkwdlklsdk','<p>First <strong>question</strong></p>',1,2,12),(27,'testung','<p><em>Second question</em></p>',2,1,13),(28,'klkwdlklsdk','<p>First <strong>question</strong></p>',1,2,13),(29,'testung','<p><em>Second question</em></p>',2,1,14),(30,'klkwdlklsdk','<p>First <strong>question</strong></p>',1,2,14),(31,'testung','<p><em>Second question</em></p>',2,1,15),(32,'klkwdlklsdk','<p>First <strong>question</strong></p>',1,2,15),(33,'testung','<p><em>Second question</em></p>',2,1,16),(34,'klkwdlklsdk','<p>First <strong>question</strong></p>',1,2,16),(35,'testung','<p><em>Second question</em></p>',2,1,17),(36,'klkwdlklsdk','<p>First <strong>question</strong></p>',1,2,17),(37,'ff','<p>test mandatory</p>',4,1,18),(38,'hh','<p>testing swagger</p>',6,1,18),(39,'k','<p><em>Second question</em></p>',2,1,18),(40,'ki','<p>test mandatory</p>',3,1,18),(41,'3r','<p>working</p>',8,2,18),(42,'d2','<p>First <strong>question</strong></p>',1,2,18),(43,'d23','<p>working mandatory</p>',7,2,18),(44,'dwe','<p>test mandatory</p>',4,1,19),(45,'we','<p>testing swagger</p>',6,1,19),(46,'fwef','<p><em>Second question</em></p>',2,1,19),(47,'fwef','<p>test mandatory</p>',3,1,19),(48,'fwe','<p>working</p>',8,2,19),(49,'wefwe','<p>First <strong>question</strong></p>',1,2,19),(50,'fwefwe','<p>working mandatory</p>',7,2,19),(51,'dwe','<p>test mandatory</p>',4,1,20),(52,'we','<p>testing swagger</p>',6,1,20),(53,'fwef','<p><em>Second question</em></p>',2,1,20),(54,'fwef','<p>test mandatory</p>',3,1,20),(55,'fwe','<p>working</p>',8,2,20),(56,'wefwe','<p>First <strong>question</strong></p>',1,2,20),(57,'fwefwe','<p>working mandatory</p>',7,2,20),(58,'dwe','<p>test mandatory</p>',4,1,21),(59,'we','<p>testing swagger</p>',6,1,21),(60,'fwef','<p><em>Second question</em></p>',2,1,21),(61,'fwef','<p>test mandatory</p>',3,1,21),(62,'fwe','<p>working</p>',8,2,21),(63,'wefwe','<p>First <strong>question</strong></p>',1,2,21),(64,'fwefwe','<p>working mandatory</p>',7,2,21),(65,'dwe','<p>test mandatory</p>',4,1,22),(66,'we','<p>testing swagger</p>',6,1,22),(67,'fwef','<p><em>Second question</em></p>',2,1,22),(68,'fwef','<p>test mandatory</p>',3,1,22),(69,'fwe','<p>working</p>',8,2,22),(70,'wefwe','<p>First <strong>question</strong></p>',1,2,22),(71,'fwefwe','<p>working mandatory</p>',7,2,22),(72,'sc s','<p>test mandatory</p>',4,1,23),(73,'s ','<p>testing swagger</p>',6,1,23),(74,'s d','<p><em>Second question</em></p>',2,1,23),(75,'sc ','<p>test mandatory</p>',3,1,23),(76,'ds ','<p>working</p>',8,2,23),(77,'sc ','<p>First <strong>question</strong></p>',1,2,23),(78,'sd','<p>working mandatory</p>',7,2,23),(79,'sc s','<p>test mandatory</p>',4,1,24),(80,'s ','<p>testing swagger</p>',6,1,24),(81,'s d','<p><em>Second question</em></p>',2,1,24),(82,'sc ','<p>test mandatory</p>',3,1,24),(83,'ds ','<p>working</p>',8,2,24),(84,'sc ','<p>First <strong>question</strong></p>',1,2,24),(85,'sd','<p>working mandatory</p>',7,2,24);
/*!40000 ALTER TABLE `question_answer` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-09  6:44:18
