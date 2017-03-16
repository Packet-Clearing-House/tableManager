
CREATE DATABASE IF NOT EXISTS tableManagerSample;

CREATE TABLE IF NOT EXISTS tableManagerSample.people
(
  id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  first VARCHAR(255) NOT NULL,
  last VARCHAR(255) NOT NULL,
  age INT(3) NOT NULL,
  sex ENUM('Agender', 'Androgyne', 'Androgynous', 'Bigender', 'Cis', 'Cisgender', 'Cis Female', 'Cis Male', 'Cis Man', 'Cis Woman', 'Cisgender Female', 'Cisgender Male', 'Cisgender Man', 'Cisgender Woman', 'Female to Male', 'FTM', 'Gender Fluid', 'Gender Nonconforming', 'Gender Questioning', 'Gender Variant', 'Genderqueer', 'Intersex', 'Male to Female', 'MTF', 'Neither', 'Neutrois', 'Non-binary', 'Other', 'Pangender', 'Trans', 'Trans*', 'Trans Female', 'Trans* Female', 'Trans Male', 'Trans* Male', 'Trans Man', 'Trans* Man', 'Trans Person', 'Trans* Person', 'Trans Woman', 'Trans* Woman', 'Transfeminine', 'Transgender', 'Transgender Female', 'Transgender Male', 'Transgender Man', 'Transgender Person', 'Transgender Woman', 'Transmasculine', 'Transsexual', 'Transsexual Female', 'Transsexual Male', 'Transsexual Man', 'Transsexual Person', 'Transsexual Woman', 'Two-Spirit') NOT NULL,
  comment TEXT
);
ALTER TABLE tableManagerSample.people ADD INDEX (id);
-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: tableManagerSample
-- ------------------------------------------------------
-- Server version	5.7.17-0ubuntu0.16.04.1

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

--
-- Dumping data for table `people`
--
use tableManagerSample;
truncate table people;
LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` VALUES (1,'','Doe',56,'Cis','Is john doe.'),(2,'Jane','Doe',2,'Bigender','Jane rocks!'),(3,'Zhang','Wei',82,'Cis',''),(4,'Zhang','Xiu Ying',82,'Gender Fluid',''),(5,'Mohamed','EL-HASHEM',34,'Trans* Female',''),(6,'Meyer','NEJEM',18,'Trans* Man',''),(7,'Abir','Chatterjee',48,'Gender Questioning','');
/*!40000 ALTER TABLE `people` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-16 12:07:25
