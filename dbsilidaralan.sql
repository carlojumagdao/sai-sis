-- MySQL dump 10.13  Distrib 5.6.24, for osx10.8 (x86_64)
--
-- Host: 127.0.0.1    Database: dbsilidaralan
-- ------------------------------------------------------
-- Server version	5.6.26

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
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES ('carlojumagdao@silidaralan.org','48c2e0542bbc115908f0e2940beaaf59f2ec5eed396a68719071e39e758d800b','2016-04-27 04:42:34');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblAccount`
--

DROP TABLE IF EXISTS `tblAccount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblAccount` (
  `intAccId` int(11) NOT NULL AUTO_INCREMENT,
  `strAccFname` varchar(45) NOT NULL,
  `strAccLname` varchar(45) NOT NULL,
  `strAccEmail` varchar(45) DEFAULT NULL,
  `strAccUname` varchar(45) NOT NULL,
  `strAccPword` varchar(45) NOT NULL,
  `strAccRememberToken` int(100) NOT NULL,
  `blAccType` tinyint(1) NOT NULL,
  `intAccLCId` int(11) NOT NULL,
  `blAccDelete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`intAccId`),
  KEY `fkAccLc_idx` (`intAccLCId`),
  CONSTRAINT `fkAccLc` FOREIGN KEY (`intAccLCId`) REFERENCES `tblLearningCenter` (`intLCId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblAccount`
--

LOCK TABLES `tblAccount` WRITE;
/*!40000 ALTER TABLE `tblAccount` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblAccount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblAttendance`
--

DROP TABLE IF EXISTS `tblAttendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblAttendance` (
  `intAttId` int(11) NOT NULL AUTO_INCREMENT,
  `blAttStatus` tinyint(1) NOT NULL DEFAULT '1',
  `strAttLearCode` varchar(45) NOT NULL,
  `intAttSDId` int(11) NOT NULL,
  `blAttDelete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`strAttLearCode`,`intAttSDId`),
  UNIQUE KEY `intAttId_UNIQUE` (`intAttId`),
  KEY `fkAttLear_idx` (`strAttLearCode`),
  KEY `fkAttSD_idx` (`intAttSDId`),
  CONSTRAINT `fkAttLear` FOREIGN KEY (`strAttLearCode`) REFERENCES `tblLearner` (`strLearCode`) ON UPDATE CASCADE,
  CONSTRAINT `fkAttSD` FOREIGN KEY (`intAttSDId`) REFERENCES `tblSchoolDay` (`intSDId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblAttendance`
--

LOCK TABLES `tblAttendance` WRITE;
/*!40000 ALTER TABLE `tblAttendance` DISABLE KEYS */;
INSERT INTO `tblAttendance` VALUES (168,1,'2016-0000-RZ',27,0),(155,1,'2016-0000-RZ',28,0),(167,1,'2016-0000-RZ',30,0),(147,1,'2016-0000-RZ',36,0),(158,1,'2016-0000-RZ',48,0),(171,1,'2016-0000-RZ',49,0),(160,1,'2016-0000-RZ',51,0),(159,1,'2016-0000-RZ',52,0),(173,1,'2016-0000-RZ',56,0),(176,1,'2016-0000-RZ',59,0),(174,1,'2016-0000-RZ',60,0),(172,1,'2016-0000-RZ',62,0),(148,1,'2016-0001-RZ',31,0),(118,1,'2016-0001-RZ',32,0),(153,1,'2016-0001-RZ',33,0),(152,1,'2016-0001-RZ',35,0),(150,1,'2016-0001-RZ',42,0),(145,1,'2016-0001-RZ',43,0),(175,1,'2016-0001-RZ',45,0),(154,1,'2016-0001-RZ',46,0),(149,1,'2016-0001-RZ',47,0),(126,1,'2016-0002-RZ',27,0),(165,1,'2016-0002-RZ',28,0),(125,1,'2016-0002-RZ',30,0),(128,1,'2016-0002-RZ',36,0),(164,1,'2016-0002-RZ',49,0),(166,1,'2016-0002-RZ',51,0),(177,1,'2016-0004-RZ',63,0),(178,1,'2016-0004-RZ',67,0);
/*!40000 ALTER TABLE `tblAttendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblColearner`
--

DROP TABLE IF EXISTS `tblColearner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblColearner` (
  `intColeId` int(11) NOT NULL AUTO_INCREMENT,
  `strColeFname` varchar(45) NOT NULL,
  `strColeLname` varchar(45) NOT NULL,
  `blColeGender` tinyint(1) NOT NULL,
  `strColeContact` varchar(45) DEFAULT NULL,
  `datColeBirthDate` date NOT NULL,
  `blColeDelete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`intColeId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblColearner`
--

LOCK TABLES `tblColearner` WRITE;
/*!40000 ALTER TABLE `tblColearner` DISABLE KEYS */;
INSERT INTO `tblColearner` VALUES (1,'Arcie','Malari',0,'09193244765','0000-00-00',0),(3,'Carlo','Jumagdao',1,'09192324422','1996-06-03',0),(4,'dfs','sdfds',1,'09193244765','0000-00-00',1),(5,'Juan','Dela Cruz',1,'09193244765','2016-04-06',0),(6,'Kara','Karaka',0,'09192324422','2016-04-12',1),(7,'Java','Maney',1,'09193244765','2016-04-04',1);
/*!40000 ALTER TABLE `tblColearner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblDonor`
--

DROP TABLE IF EXISTS `tblDonor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblDonor` (
  `intDonorId` int(11) NOT NULL AUTO_INCREMENT,
  `strDonorName` varchar(45) NOT NULL,
  `strDonorEmail` varchar(45) DEFAULT NULL,
  `datDonorBdate` date DEFAULT NULL,
  `blDonorDelete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`intDonorId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblDonor`
--

LOCK TABLES `tblDonor` WRITE;
/*!40000 ALTER TABLE `tblDonor` DISABLE KEYS */;
INSERT INTO `tblDonor` VALUES (1,'Celia Lazaro','celialazaro@gmail.com','2010-04-18',0),(2,'F1C International','inform@f1c.com','0000-00-00',0),(3,'Marc Licaros','marclicaros@gmail.com','0000-00-00',0);
/*!40000 ALTER TABLE `tblDonor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblDonorLearner`
--

DROP TABLE IF EXISTS `tblDonorLearner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblDonorLearner` (
  `intDLId` int(11) NOT NULL AUTO_INCREMENT,
  `intDLDonorId` int(11) NOT NULL,
  `strDLLearCode` varchar(45) NOT NULL,
  `blDLDelete` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`intDLDonorId`,`strDLLearCode`),
  UNIQUE KEY `intDLId_UNIQUE` (`intDLId`),
  KEY `fkDLLearCode_idx` (`strDLLearCode`),
  CONSTRAINT `fkDLLearCode` FOREIGN KEY (`strDLLearCode`) REFERENCES `tblLearner` (`strLearCode`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblDonorLearner`
--

LOCK TABLES `tblDonorLearner` WRITE;
/*!40000 ALTER TABLE `tblDonorLearner` DISABLE KEYS */;
INSERT INTO `tblDonorLearner` VALUES (54,1,'2016-0002-RZ',0),(57,2,'2016-0001-RZ',0),(51,3,'2016-0000-RZ',0),(50,3,'2016-0003-RZ',0);
/*!40000 ALTER TABLE `tblDonorLearner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblGrade`
--

DROP TABLE IF EXISTS `tblGrade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblGrade` (
  `intGrdId` int(11) NOT NULL AUTO_INCREMENT,
  `intGrdLvl` int(11) NOT NULL,
  `dblGrdFilipino` double NOT NULL DEFAULT '0',
  `dblGrdEnglish` double NOT NULL DEFAULT '0',
  `dblGrdScience` double NOT NULL DEFAULT '0',
  `dblGrdMath` double NOT NULL DEFAULT '0',
  `dblGrdMakabayan` double NOT NULL DEFAULT '0',
  `strGrdLearCode` varchar(45) NOT NULL,
  `blGrdDelete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`intGrdLvl`,`strGrdLearCode`),
  UNIQUE KEY `intGrdId_UNIQUE` (`intGrdId`),
  KEY `fkGradeLear_idx` (`strGrdLearCode`),
  CONSTRAINT `fkGradeLear` FOREIGN KEY (`strGrdLearCode`) REFERENCES `tblLearner` (`strLearCode`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblGrade`
--

LOCK TABLES `tblGrade` WRITE;
/*!40000 ALTER TABLE `tblGrade` DISABLE KEYS */;
INSERT INTO `tblGrade` VALUES (106,1,90,94,95,92,91,'2016-0000-RZ',0),(104,1,79,83,86,88,89,'2016-0001-RZ',0),(49,1,90,90,90,90,90,'2016-0002-RZ',0),(105,1,80,78,79,77,81,'2016-0003-RZ',0),(107,1,89,87,91,85,92,'2016-0004-RZ',0),(101,2,90,89,79,88,84,'2016-0001-RZ',0),(51,2,90,90,90,90,90,'2016-0002-RZ',0),(93,3,89,87,76,88,87,'2016-0000-RZ',0),(103,3,90,88,88,79,83,'2016-0001-RZ',0),(52,3,89,88,87,89,78,'2016-0002-RZ',0),(94,4,89,88,85,78,90,'2016-0000-RZ',0),(53,4,90,90,90,90,90,'2016-0002-RZ',0),(95,5,84,83,81,82,85,'2016-0000-RZ',0),(54,5,90,90,90,90,90,'2016-0002-RZ',0),(55,6,90,90,90,90,90,'2016-0002-RZ',0),(98,7,90,88,87,93,92,'2016-0000-RZ',0),(56,7,90,90,90,90,90,'2016-0002-RZ',0),(100,8,85,78,85,81,86,'2016-0000-RZ',0),(58,8,90,90,90,90,90,'2016-0002-RZ',0),(59,9,90,90,90,90,90,'2016-0002-RZ',0),(61,10,90,90,90,90,90,'2016-0002-RZ',0),(64,11,90,90,90,89,90,'2016-0002-RZ',0),(65,12,90,90,90,89,90,'2016-0002-RZ',0);
/*!40000 ALTER TABLE `tblGrade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblLearner`
--

DROP TABLE IF EXISTS `tblLearner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblLearner` (
  `strLearCode` varchar(45) NOT NULL,
  `strLearFname` varchar(45) NOT NULL,
  `strLearLname` varchar(45) NOT NULL,
  `datLearBirthDate` date NOT NULL,
  `blLearGender` tinyint(1) NOT NULL,
  `strLearPicPath` varchar(100) DEFAULT NULL,
  `strLearDream` varchar(250) DEFAULT NULL,
  `intLearSesId` int(11) NOT NULL,
  `intLearSchId` int(11) NOT NULL,
  `blLearDelete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`strLearCode`),
  KEY `fkLearSes_idx` (`intLearSesId`),
  KEY `fkLearSch_idx` (`intLearSchId`),
  CONSTRAINT `fkLearSch` FOREIGN KEY (`intLearSchId`) REFERENCES `tblSchool` (`intSchId`) ON UPDATE CASCADE,
  CONSTRAINT `fkLearSes` FOREIGN KEY (`intLearSesId`) REFERENCES `tblSession` (`intSesId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblLearner`
--

LOCK TABLES `tblLearner` WRITE;
/*!40000 ALTER TABLE `tblLearner` DISABLE KEYS */;
INSERT INTO `tblLearner` VALUES ('2016-0000-RZ','Carlo','Jumagdao','1996-06-03',1,'45465.jpg','\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure d',5,1,0),('2016-0001-RZ','Gabriel','Jumagdao','1998-10-19',1,'45530.jpg',NULL,3,5,0),('2016-0002-RZ','Eurice','Jumagdao','2016-04-11',0,'86806.jpg',NULL,5,1,0),('2016-0003-RZ','Dummy','Gomez','2016-04-13',1,'49597.png',NULL,6,1,0),('2016-0004-RZ','Maria','Makiling','1988-04-12',0,'73294.jpg','Her Dream is to travel around the world.',6,5,0);
/*!40000 ALTER TABLE `tblLearner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblLearningCenter`
--

DROP TABLE IF EXISTS `tblLearningCenter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblLearningCenter` (
  `intLCId` int(11) NOT NULL AUTO_INCREMENT,
  `strLCLocation` varchar(45) NOT NULL,
  `blLCDelete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`intLCId`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblLearningCenter`
--

LOCK TABLES `tblLearningCenter` WRITE;
/*!40000 ALTER TABLE `tblLearningCenter` DISABLE KEYS */;
INSERT INTO `tblLearningCenter` VALUES (43,'Baguio',0),(45,'Cebu',1),(46,'Antipolo',1),(47,'Angono',1),(48,'try',1),(49,'tae',1),(50,'dsfds',1),(51,'\'\'\'',1),(52,'Marinduque',1),(53,'Bataan',0),(54,'Catbalogan',1),(55,'Samar',1),(56,'Davao',1),(57,'Rodriguez',1),(58,'Babuyan Island',1),(59,'v',1),(63,'Singapore',0),(65,'Rodriguez',0),(66,'lal',1),(67,'dummy',1),(68,'dommmy',1);
/*!40000 ALTER TABLE `tblLearningCenter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblProgram`
--

DROP TABLE IF EXISTS `tblProgram`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblProgram` (
  `intProgId` int(11) NOT NULL AUTO_INCREMENT,
  `strProgName` varchar(45) NOT NULL,
  `blProgDelete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`intProgId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblProgram`
--

LOCK TABLES `tblProgram` WRITE;
/*!40000 ALTER TABLE `tblProgram` DISABLE KEYS */;
INSERT INTO `tblProgram` VALUES (1,'Ground Zero',1),(2,'iLEAD',1),(3,'LEAP',0),(4,'Tutoka',1),(5,'Ground Zero',1),(6,'Tutok',1),(7,'Ground Zero',0);
/*!40000 ALTER TABLE `tblProgram` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblSchool`
--

DROP TABLE IF EXISTS `tblSchool`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblSchool` (
  `intSchId` int(11) NOT NULL AUTO_INCREMENT,
  `strSchName` varchar(45) NOT NULL,
  `strSchPrinName` varchar(45) DEFAULT NULL,
  `strSchCoorName` varchar(45) NOT NULL,
  `strSchContact` varchar(45) NOT NULL,
  `intSchLCId` int(11) NOT NULL,
  `blSchDelete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`intSchId`),
  KEY `fkSchLCId_idx` (`intSchLCId`),
  CONSTRAINT `fkSchLCId` FOREIGN KEY (`intSchLCId`) REFERENCES `tblLearningCenter` (`intLCId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblSchool`
--

LOCK TABLES `tblSchool` WRITE;
/*!40000 ALTER TABLE `tblSchool` DISABLE KEYS */;
INSERT INTO `tblSchool` VALUES (1,'KVES-II','Ms. Clarita Nocon','Floricel Ilaws','09192324422',53,0),(2,'TES','Cristina Camarse','Jongaling Galing','09193244765',45,1),(3,'   df','','dfd','fdfd',43,1),(4,'PUP','Mr. De Guzman','Gema Bustamante','09192344746',43,1),(5,'EARIST','Madam Ear','Ms. Lala Ear','09193244765',65,0),(6,'University of Cordillera de Gulaman Hipon - B','Mr. Cordy M. Jalala','Abdul Jabbar','09192324422',43,1);
/*!40000 ALTER TABLE `tblSchool` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblSchoolDay`
--

DROP TABLE IF EXISTS `tblSchoolDay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblSchoolDay` (
  `intSDId` int(11) NOT NULL AUTO_INCREMENT,
  `datSchoolDay` date NOT NULL,
  `intSDSesId` int(11) NOT NULL,
  `blSDDelete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`datSchoolDay`,`intSDSesId`),
  UNIQUE KEY `intSDId_UNIQUE` (`intSDId`),
  KEY `fkSDSes_idx` (`intSDSesId`),
  CONSTRAINT `fkSDSes` FOREIGN KEY (`intSDSesId`) REFERENCES `tblSession` (`intSesId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblSchoolDay`
--

LOCK TABLES `tblSchoolDay` WRITE;
/*!40000 ALTER TABLE `tblSchoolDay` DISABLE KEYS */;
INSERT INTO `tblSchoolDay` VALUES (55,'2016-03-03',5,0),(56,'2016-03-08',5,0),(57,'2016-03-11',5,0),(58,'2016-03-15',5,0),(59,'2016-03-18',5,0),(60,'2016-03-21',5,0),(61,'2016-03-23',5,0),(62,'2016-03-28',5,0),(37,'2016-03-30',3,0),(51,'2016-04-05',5,0),(45,'2016-04-06',3,0),(52,'2016-04-07',5,0),(46,'2016-04-08',3,0),(31,'2016-04-18',3,0),(65,'2016-04-18',6,0),(36,'2016-04-20',5,0),(32,'2016-04-21',3,0),(66,'2016-04-21',6,0),(67,'2016-04-23',6,0),(27,'2016-04-25',5,0),(63,'2016-04-25',6,0),(33,'2016-04-26',3,0),(28,'2016-04-26',5,0),(48,'2016-04-27',5,0),(64,'2016-04-27',6,0),(34,'2016-04-28',3,0),(30,'2016-04-28',5,0),(35,'2016-04-30',3,0),(49,'2016-04-30',5,0),(41,'2016-05-01',3,0),(42,'2016-05-02',3,0),(43,'2016-05-03',3,0),(47,'2016-05-04',3,0),(54,'2016-05-05',3,0);
/*!40000 ALTER TABLE `tblSchoolDay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblSession`
--

DROP TABLE IF EXISTS `tblSession`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblSession` (
  `intSesId` int(11) NOT NULL AUTO_INCREMENT,
  `strSesName` varchar(45) NOT NULL,
  `intSesColeId` int(11) NOT NULL,
  `intSesProgId` int(11) NOT NULL,
  `blSesDelete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`intSesId`),
  KEY `fkSesCole_idx` (`intSesColeId`),
  KEY `fkSesProg_idx` (`intSesProgId`),
  CONSTRAINT `fkSesCole` FOREIGN KEY (`intSesColeId`) REFERENCES `tblColearner` (`intColeId`) ON UPDATE CASCADE,
  CONSTRAINT `fkSesProg` FOREIGN KEY (`intSesProgId`) REFERENCES `tblProgram` (`intProgId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblSession`
--

LOCK TABLES `tblSession` WRITE;
/*!40000 ALTER TABLE `tblSession` DISABLE KEYS */;
INSERT INTO `tblSession` VALUES (1,'KVES 115',1,5,1),(2,'KVES 115 AM',3,5,1),(3,'TES 113',5,3,0),(4,'RES 122 PM',7,5,1),(5,'KVES 114',3,3,0),(6,'KVES 115',1,7,0);
/*!40000 ALTER TABLE `tblSession` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblStory`
--

DROP TABLE IF EXISTS `tblStory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblStory` (
  `intStoId` int(11) NOT NULL AUTO_INCREMENT,
  `strStoTitle` varchar(45) NOT NULL,
  `strStoContent` varchar(1000) NOT NULL,
  `strStoAuthor` varchar(45) DEFAULT NULL,
  `strStoLearCode` varchar(45) NOT NULL,
  PRIMARY KEY (`strStoTitle`,`strStoLearCode`),
  UNIQUE KEY `intStoId_UNIQUE` (`intStoId`),
  KEY `fkStoLear_idx` (`strStoLearCode`),
  CONSTRAINT `fkStoLear` FOREIGN KEY (`strStoLearCode`) REFERENCES `tblLearner` (`strLearCode`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblStory`
--

LOCK TABLES `tblStory` WRITE;
/*!40000 ALTER TABLE `tblStory` DISABLE KEYS */;
INSERT INTO `tblStory` VALUES (5,'Best in Math','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborumz.','Remie Segui','2016-0000-RZ'),(2,'From top 20 to top 2','\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"','Arlyne Acosta','2016-0001-RZ'),(4,'From top 20 to top 3','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborumz.','Maria Makiling','2016-0000-RZ'),(3,'I\'m the top 1','\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\"','Arcie Mallari','2016-0001-RZ');
/*!40000 ALTER TABLE `tblStory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `intULCId` int(11) DEFAULT NULL,
  `strPicPath` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `blUDelete` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `userLC_idx` (`intULCId`),
  CONSTRAINT `userLC` FOREIGN KEY (`intULCId`) REFERENCES `tblLearningCenter` (`intLCId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (5,'Carlo Jumagdao','carlojumagdao@silidaralan.org','$2y$10$KRhvJfmlT/h5Qy9FxLinzeKdygG8EWCRNRpSRWGUobTWuTgENVmj.','hvl1sublJQIqLSLpilGaODKErw8ddz5PWDlK84qVgX0hgnqQqyr03UMLvr15',1,65,'78836.jpg','2016-04-27 02:26:03','2016-04-30 02:36:12',0),(6,'Arcie Mallari','arciemallari@silidaralan.org','$2y$10$b6B4G9CAna/gBSntwcQv0ecCvQo3WG7xrZtxE2YCZ.SVmU0EHnY36','al5WFYtJOOTCACBL4PkJYjTUJXzvnyA0qZbQbgvO9NNIKNjCEqJDMcQcawUK',1,65,'67979.jpg','2016-04-27 02:34:45','2016-05-01 21:07:44',0),(7,'Remie Segui','remiesegui@silidaralan.org','$2y$10$yvQeO/5A3cX1WD/kHlsGDOwDCmAPsDetsrAqiVJW3cbqor/PWbQWa','bJP3mgjLr7xw7hLqZvsjEZNnNUqbkqhJIM7F2PAuzFQNsBr8TXkx3MVW9Ory',0,65,'64951.jpg','2016-04-27 02:45:53','2016-04-28 09:11:52',1),(8,'Carlo Jumagdao','carlojumagdao@gmail.com','$2y$10$2S2KTQUUdhJaSk8axriWNOyuISELt9j1D/en11vg628CbLlegBx7a','MUGuaQkEJrCMxtUt9cr5Xm3kAvX0LaFr5WMU5mCX87u4fLyrZxhrQyjh2YpJ',0,53,'42398.png','2016-04-27 03:23:02','2016-04-28 08:37:57',0);
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

-- Dump completed on 2016-05-02 21:25:52
