-- MySQL dump 10.13  Distrib 5.7.27, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: putno_osiguranje
-- ------------------------------------------------------
-- Server version	5.7.27-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP DATABASE IF EXISTS `putno_osiguranje`;
CREATE DATABASE `putno_osiguranje` CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `putno_osiguranje`;

--
-- Table structure for table `korisnici`
--

DROP TABLE IF EXISTS `korisnici`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `korisnici` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ime_prezime` varchar(100) DEFAULT NULL,
  `broj_pasosa` varchar(20) DEFAULT NULL,
  `datum_rodjenja` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `korisnici`
--

LOCK TABLES `korisnici` WRITE;
/*!40000 ALTER TABLE `korisnici` DISABLE KEYS */;
/*!40000 ALTER TABLE `korisnici` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `osiguranici`
--

DROP TABLE IF EXISTS `osiguranici`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `osiguranici` (
  `osiguranja_id` bigint(20) unsigned NOT NULL,
  `korisnici_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`osiguranja_id`,`korisnici_id`),
  KEY `osiguranici_FK` (`korisnici_id`),
  CONSTRAINT `osiguranici_FK` FOREIGN KEY (`korisnici_id`) REFERENCES `korisnici` (`id`) ON DELETE CASCADE,
  CONSTRAINT `osiguranici_FK_1` FOREIGN KEY (`osiguranja_id`) REFERENCES `osiguranja` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `osiguranici`
--

LOCK TABLES `osiguranici` WRITE;
/*!40000 ALTER TABLE `osiguranici` DISABLE KEYS */;
/*!40000 ALTER TABLE `osiguranici` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `osiguranja`
--

DROP TABLE IF EXISTS `osiguranja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `osiguranja` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `telefon` varchar(20) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `datum_putovanja_od` date DEFAULT NULL,
  `datum_putovanja_do` date DEFAULT NULL,
  `datum_upisa` timestamp NULL DEFAULT NULL,
  `vrste_polisa_id` bigint(20) unsigned DEFAULT NULL,
  `korisnici_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `osiguranja_FK` (`korisnici_id`),
  KEY `osiguranja_FK_1` (`vrste_polisa_id`),
  CONSTRAINT `osiguranja_FK` FOREIGN KEY (`korisnici_id`) REFERENCES `korisnici` (`id`) ON DELETE CASCADE,
  CONSTRAINT `osiguranja_FK_1` FOREIGN KEY (`vrste_polisa_id`) REFERENCES `vrste_polisa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `osiguranja`
--

LOCK TABLES `osiguranja` WRITE;
/*!40000 ALTER TABLE `osiguranja` DISABLE KEYS */;
/*!40000 ALTER TABLE `osiguranja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vrste_polisa`
--

DROP TABLE IF EXISTS `vrste_polisa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vrste_polisa` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `naziv` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vrste_polisa`
--

LOCK TABLES `vrste_polisa` WRITE;
/*!40000 ALTER TABLE `vrste_polisa` DISABLE KEYS */;
INSERT INTO `vrste_polisa` VALUES (1,'individualno'),(2,'grupno');
/*!40000 ALTER TABLE `vrste_polisa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'putno_osiguranje'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-09-05 22:52:08
