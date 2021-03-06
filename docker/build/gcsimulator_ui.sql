-- MySQL dump 10.13  Distrib 8.0.21, for Linux (x86_64)
--
-- Host: localhost    Database: gcsimulator_ui
-- ------------------------------------------------------
-- Server version	8.0.21-0ubuntu0.20.04.4

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

CREATE DATABASE gcsimulator_ui;
CREATE USER 'gcsimulator'@'localhost' IDENTIFIED BY 'gcsimulator';
GRANT ALL PRIVILEGES ON gcsimulator_ui.* TO 'gcsimulator'@'localhost';
FLUSH PRIVILEGES;

USE gcsimulator_ui;
--
-- Table structure for table `CSV`
--

DROP TABLE IF EXISTS `CSV`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `CSV` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id1` int NOT NULL,
  `id2` int NOT NULL,
  `id3` int NOT NULL,
  `path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CSV`
--

LOCK TABLES `CSV` WRITE;
/*!40000 ALTER TABLE `CSV` DISABLE KEYS */;
INSERT INTO `CSV` VALUES (1,1,1,1,'hcprofile.csv'),(3,2,1,2,'hcprofile.csv');
/*!40000 ALTER TABLE `CSV` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SimulationCouple`
--

DROP TABLE IF EXISTS `SimulationCouple`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `SimulationCouple` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_giorno` int NOT NULL,
  `id_sim` int NOT NULL,
  `path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SimulationCouple`
--

LOCK TABLES `SimulationCouple` WRITE;
/*!40000 ALTER TABLE `SimulationCouple` DISABLE KEYS */;
INSERT INTO `SimulationCouple` VALUES (1,1,1,'/csv/sim1_1/'),(2,1,2,'/csv/sim1_1/'),(3,1,2,'/csv/sim1_1/'),(4,2,2,'/csv/sim1_1/');
/*!40000 ALTER TABLE `SimulationCouple` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Simulations`
--

DROP TABLE IF EXISTS `Simulations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Simulations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `day` int NOT NULL,
  `month` int NOT NULL,
  `year` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Simulations`
--

LOCK TABLES `Simulations` WRITE;
/*!40000 ALTER TABLE `Simulations` DISABLE KEYS */;
INSERT INTO `Simulations` VALUES (1,2,2,2),(2,2,2,2020);
/*!40000 ALTER TABLE `Simulations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `simulators`
--

DROP TABLE IF EXISTS `simulators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `simulators` (
  `id` int NOT NULL AUTO_INCREMENT,
  `processname` varchar(45) NOT NULL,
  `workingdir` varchar(100) NOT NULL,
  `adaptorport` int NOT NULL,
  `jid` varchar(100) NOT NULL,
  `iduser` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `workingdir_UNIQUE` (`workingdir`),
  UNIQUE KEY `processname_UNIQUE` (`processname`),
  UNIQUE KEY `adaptorport_UNIQUE` (`adaptorport`),
  UNIQUE KEY `jid_UNIQUE` (`jid`),
  UNIQUE KEY `iduser_UNIQUE` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `simulators`
--

LOCK TABLES `simulators` WRITE;
/*!40000 ALTER TABLE `simulators` DISABLE KEYS */;
INSERT INTO `simulators` VALUES (1,'demo_simulator','/home/users/demo/bin',2020,'demo@greencharge.local',1);
/*!40000 ALTER TABLE `simulators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `adaptor_port` varchar(255) NOT NULL,
  `jid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'demo@greencharge.local','$2y$10$4fPFOTM8CcC6sS4Y377yrO9L5HaoyUCkWfCiadNK8e3XYY5Z4DYl6','2020-10-16 01:10:39','2020','demo@greencharge.local');
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

-- Dump completed on 2020-10-16  1:15:12
