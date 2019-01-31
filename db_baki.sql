-- MySQL dump 10.16  Distrib 10.3.8-MariaDB, for osx10.13 (x86_64)
--
-- Host: localhost    Database: db_baki
-- ------------------------------------------------------
-- Server version	10.3.8-MariaDB

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
-- Table structure for table `t_agent`
--

DROP TABLE IF EXISTS `t_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_agent` (
  `_MATR` int(11) NOT NULL,
  `_NAME` varchar(50) NOT NULL,
  `_SEX` varchar(50) NOT NULL,
  `_PHONE` varchar(50) NOT NULL,
  `_ADRESS` varchar(50) NOT NULL,
  `_BIRTHDAY` varchar(50) NOT NULL,
  `_BIRTHPLACE` varchar(50) NOT NULL,
  `_CHILD_SCHOOL` varchar(50) NOT NULL,
  `_DATEWORK` varchar(50) NOT NULL,
  `_PROVINCE` varchar(50) NOT NULL,
  `_TOWN` varchar(50) NOT NULL,
  `_FUNCTION` varchar(50) NOT NULL,
  `_CODE_DIRECTION` varchar(10) NOT NULL,
  `_PICTURE` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_agent`
--

LOCK TABLES `t_agent` WRITE;
/*!40000 ALTER TABLE `t_agent` DISABLE KEYS */;
INSERT INTO `t_agent` VALUES (1111,'LAMA HORNEL','MASCULIN','0894731682','10,KILOMBWE C/LEMBA','12/10/1978','KINSHASA','2','12/12/2001','KATANGA','KINSHASA','CAISSIER','YOLO',''),(1112,'PINSHI','M','0816060961','Ngaliema','01/01/2010','kin','2','11/12/2000','KATANGA','KIN','CAISSIER','YOLO',' ');
/*!40000 ALTER TABLE `t_agent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_category`
--

DROP TABLE IF EXISTS `t_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_category` (
  `_CODE_CATEGORY` varchar(20) NOT NULL,
  `_LABEL_CATEGROT` varchar(70) NOT NULL,
  PRIMARY KEY (`_CODE_CATEGORY`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_category`
--

LOCK TABLES `t_category` WRITE;
/*!40000 ALTER TABLE `t_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_courses`
--

DROP TABLE IF EXISTS `t_courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_courses` (
  `_ID_COURSE` varchar(10) NOT NULL,
  `_LABEL_COURSE` varchar(100) NOT NULL,
  `_CODE_POND` int(11) NOT NULL,
  PRIMARY KEY (`_ID_COURSE`),
  KEY `_CODE_POND` (`_CODE_POND`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_courses`
--

LOCK TABLES `t_courses` WRITE;
/*!40000 ALTER TABLE `t_courses` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_direction`
--

DROP TABLE IF EXISTS `t_direction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_direction` (
  `_CODE_DIR` varchar(10) NOT NULL,
  `_LABEL_DIR` varchar(100) NOT NULL,
  `_ADRESS` int(11) NOT NULL,
  `_PHONE` int(11) NOT NULL,
  PRIMARY KEY (`_CODE_DIR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_direction`
--

LOCK TABLES `t_direction` WRITE;
/*!40000 ALTER TABLE `t_direction` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_direction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_dispense`
--

DROP TABLE IF EXISTS `t_dispense`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_dispense` (
  `_ID` int(11) NOT NULL AUTO_INCREMENT,
  `_CODE_COURS` varchar(10) NOT NULL,
  `_MATR_AGENT` varchar(10) NOT NULL,
  `_LEVEL_SCHOOL` varchar(100) NOT NULL,
  PRIMARY KEY (`_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_dispense`
--

LOCK TABLES `t_dispense` WRITE;
/*!40000 ALTER TABLE `t_dispense` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_dispense` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_level`
--

DROP TABLE IF EXISTS `t_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_level` (
  `_LABEL_LEVEL` varchar(20) NOT NULL,
  `_OPTION_LEVEL` varchar(10) NOT NULL,
  PRIMARY KEY (`_LABEL_LEVEL`),
  KEY `_OPTION_LEVEL` (`_OPTION_LEVEL`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_level`
--

LOCK TABLES `t_level` WRITE;
/*!40000 ALTER TABLE `t_level` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_login`
--

DROP TABLE IF EXISTS `t_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_login` (
  `_ID` int(11) NOT NULL AUTO_INCREMENT,
  `_USERNAME` varchar(50) NOT NULL,
  `_PWD` varchar(200) NOT NULL,
  `_PRIORITY` varchar(50) NOT NULL,
  `_MATR_AGENT` varchar(50) NOT NULL,
  `_ANASCO` varchar(50) NOT NULL,
  PRIMARY KEY (`_ID`),
  UNIQUE KEY `_USERNAME` (`_USERNAME`),
  KEY `_MATR_AGENT` (`_MATR_AGENT`),
  KEY `YEARS` (`_ANASCO`),
  CONSTRAINT `key_years-anasco` FOREIGN KEY (`_ANASCO`) REFERENCES `t_years_school` (`year`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_login`
--

LOCK TABLES `t_login` WRITE;
/*!40000 ALTER TABLE `t_login` DISABLE KEYS */;
INSERT INTO `t_login` VALUES (1,'@hornel','fcea920f7412b5da7be0cf42b8c93759','admin','1111','2017-2018'),(2,'@jonathan','827ccb0eea8a706c4c34a16891f84e7b','admin','1112','2017-2018');
/*!40000 ALTER TABLE `t_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_options`
--

DROP TABLE IF EXISTS `t_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_options` (
  `_CODE_OPT` varchar(10) NOT NULL,
  `_LABEL_OPT` varchar(100) NOT NULL,
  `_CODE_SECTION` varchar(10) NOT NULL,
  PRIMARY KEY (`_CODE_OPT`),
  KEY `_CODE_SECTION` (`_CODE_SECTION`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_options`
--

LOCK TABLES `t_options` WRITE;
/*!40000 ALTER TABLE `t_options` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_payment`
--

DROP TABLE IF EXISTS `t_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_payment` (
  `_IDPAY` varchar(100) NOT NULL,
  `_MATR` varchar(50) NOT NULL,
  `_CODE_SLICE` varchar(50) NOT NULL,
  `_OBJECT` varchar(100) NOT NULL,
  `_DATEPAY` varchar(50) NOT NULL,
  `_TIMEPAY` varchar(50) NOT NULL,
  `_AMOUNT` int(11) NOT NULL,
  `_ANASCO` varchar(50) NOT NULL,
  `_USER_AGENT` varchar(50) NOT NULL,
  `_DEPARTMENT` varchar(25) NOT NULL,
  PRIMARY KEY (`_IDPAY`),
  KEY `_MATR` (`_MATR`,`_CODE_SLICE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_payment`
--

LOCK TABLES `t_payment` WRITE;
/*!40000 ALTER TABLE `t_payment` DISABLE KEYS */;
INSERT INTO `t_payment` VALUES ('PAY-1512832694','CSB/YOLO1512832693','SUB','SUB','09/12/2017','16:18:13',10,'2016-2017','@hornel','YOLO'),('PAY-1539525435','YOLO1513100728','SUB','SUB','14/10/2018','13:57:15',10,'2017-2018','@jonathan','YOLO'),('PAY-1539525677','YOLO1513100840','SUB','SUB','14/10/2018','10:50:45',10,'2017-2018','@jonathan','YOLO');
/*!40000 ALTER TABLE `t_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_payment_agent`
--

DROP TABLE IF EXISTS `t_payment_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_payment_agent` (
  `_CODE_PAY` int(11) NOT NULL,
  `_MATR_AGENT` int(11) NOT NULL,
  `_DATE_PAY` int(11) NOT NULL,
  `_TIME_PAY` int(11) NOT NULL,
  `_ACCOUNT_PAY` int(11) NOT NULL,
  `_PRIME_PAY` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_payment_agent`
--

LOCK TABLES `t_payment_agent` WRITE;
/*!40000 ALTER TABLE `t_payment_agent` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_payment_agent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_ponderation`
--

DROP TABLE IF EXISTS `t_ponderation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ponderation` (
  `_ID_POND` int(11) NOT NULL,
  `_CODE_OPT` varchar(10) NOT NULL,
  PRIMARY KEY (`_ID_POND`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_ponderation`
--

LOCK TABLES `t_ponderation` WRITE;
/*!40000 ALTER TABLE `t_ponderation` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_ponderation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_school_fees`
--

DROP TABLE IF EXISTS `t_school_fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_school_fees` (
  `_CODE` varchar(5) NOT NULL,
  `_LABEL` varchar(100) NOT NULL,
  PRIMARY KEY (`_CODE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_school_fees`
--

LOCK TABLES `t_school_fees` WRITE;
/*!40000 ALTER TABLE `t_school_fees` DISABLE KEYS */;
INSERT INTO `t_school_fees` VALUES ('FRSCO','FRAIS SCOLAIRE'),('RESUB','FRAIS REINSCRIPTION'),('SUB','FRAIS INSCRIPTION');
/*!40000 ALTER TABLE `t_school_fees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_school_fees_years`
--

DROP TABLE IF EXISTS `t_school_fees_years`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_school_fees_years` (
  `_ID` int(11) NOT NULL AUTO_INCREMENT,
  `_CODE_YEAR` varchar(100) NOT NULL,
  `_FEES_SCHOOL` varchar(5) NOT NULL,
  `_SOLD` decimal(10,0) NOT NULL,
  PRIMARY KEY (`_ID`),
  KEY `t_school_fees_years_t_years_school_FK` (`_CODE_YEAR`),
  KEY `t_school_fees_years_t_school_fees_FK` (`_FEES_SCHOOL`),
  CONSTRAINT `t_school_fees_years_t_school_fees_FK` FOREIGN KEY (`_FEES_SCHOOL`) REFERENCES `t_school_fees` (`_CODE`),
  CONSTRAINT `t_school_fees_years_t_years_school_FK` FOREIGN KEY (`_CODE_YEAR`) REFERENCES `t_years_school` (`year`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_school_fees_years`
--

LOCK TABLES `t_school_fees_years` WRITE;
/*!40000 ALTER TABLE `t_school_fees_years` DISABLE KEYS */;
INSERT INTO `t_school_fees_years` VALUES (1,'2015-2016','FRSCO',500),(2,'2016-2017','FRSCO',420),(3,'2017-2018','FRSCO',600),(4,'2015-2016','SUB',10),(5,'2016-2017','SUB',10),(6,'2017-2018','SUB',10),(7,'2015-2016','RESUB',15),(8,'2016-2017','RESUB',15),(9,'2017-2018','RESUB',15);
/*!40000 ALTER TABLE `t_school_fees_years` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_section`
--

DROP TABLE IF EXISTS `t_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_section` (
  `_ID_SECT` varchar(10) NOT NULL,
  `_LABEL_SECT` varchar(100) NOT NULL,
  PRIMARY KEY (`_ID_SECT`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_section`
--

LOCK TABLES `t_section` WRITE;
/*!40000 ALTER TABLE `t_section` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_slice_payment`
--

DROP TABLE IF EXISTS `t_slice_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_slice_payment` (
  `_CODESLICE` varchar(5) NOT NULL,
  `_LABELSLICE` varchar(50) NOT NULL,
  `_AMOUNT` int(11) NOT NULL,
  `_CODE_FEES` varchar(11) NOT NULL,
  PRIMARY KEY (`_CODESLICE`),
  KEY `_CODE_FEES` (`_CODE_FEES`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_slice_payment`
--

LOCK TABLES `t_slice_payment` WRITE;
/*!40000 ALTER TABLE `t_slice_payment` DISABLE KEYS */;
INSERT INTO `t_slice_payment` VALUES ('1TRF','1ERE TRANCHE',400,'FRSCO'),('2TRF','2EME TRANCHE',150,'FRSCO'),('3TRF','3EME TRANCHE',50,'FRSCO'),('RESUB','REINSCRIPTION',15,'RESUB'),('SUB','INSCRIPTION',10,'SUB');
/*!40000 ALTER TABLE `t_slice_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_status_health`
--

DROP TABLE IF EXISTS `t_status_health`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_status_health` (
  `_ID` int(11) NOT NULL AUTO_INCREMENT,
  `_MATR` varchar(20) NOT NULL,
  `_INFO` varchar(20) NOT NULL,
  `_DATEINSERT` varchar(20) NOT NULL,
  PRIMARY KEY (`_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_status_health`
--

LOCK TABLES `t_status_health` WRITE;
/*!40000 ALTER TABLE `t_status_health` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_status_health` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_students`
--

DROP TABLE IF EXISTS `t_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_students` (
  `_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `_MAT` varchar(50) NOT NULL,
  `_NAME` varchar(50) NOT NULL,
  `_SEX` varchar(50) NOT NULL,
  `_ADRESS` varchar(50) NOT NULL,
  `_PROVINCE` varchar(50) NOT NULL,
  `_BIRTHDAY` varchar(50) NOT NULL,
  `_BIRTHPLACE` varchar(50) NOT NULL,
  `_PHONE` varchar(50) NOT NULL,
  `_PICTURE` longtext NOT NULL,
  PRIMARY KEY (`_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_students`
--

LOCK TABLES `t_students` WRITE;
/*!40000 ALTER TABLE `t_students` DISABLE KEYS */;
INSERT INTO `t_students` VALUES (20,'CSB/YOLO1512832693','Malamba Jean','Masculin','10,Kilangwe','KINSHASA','10/10/2019','Kinshasa','8389383398','1513100728.png'),(21,'YOLO1513100728','MBUYI MPOYI Joelle','F','10,Kilangwe','Haut-Lomami','20/01/2000','Kinsahsa','3390290','1513100728.png'),(22,'YOLO1513100840','ANATOLI','M','10,Kilangwe','Haut-Lomami','20/01/2000','Kinsahsa','3390290','1513100728.png');
/*!40000 ALTER TABLE `t_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_subscription`
--

DROP TABLE IF EXISTS `t_subscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_subscription` (
  `_ID_SUB` int(11) NOT NULL AUTO_INCREMENT,
  `_MATR_PUPIL` varchar(50) NOT NULL,
  `_CODE_CLASS` varchar(10) NOT NULL,
  `_CODE_SECTION` varchar(50) NOT NULL,
  `_DATE_SUB` varchar(20) NOT NULL,
  `_CODE_PAY` varchar(100) NOT NULL,
  `_CODE_AGENT` varchar(10) NOT NULL,
  PRIMARY KEY (`_ID_SUB`),
  KEY `_CODE_PAY` (`_CODE_PAY`),
  KEY `_MATR_PUPIL` (`_MATR_PUPIL`),
  KEY `_CODE_CLASS` (`_CODE_CLASS`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_subscription`
--

LOCK TABLES `t_subscription` WRITE;
/*!40000 ALTER TABLE `t_subscription` DISABLE KEYS */;
INSERT INTO `t_subscription` VALUES (81,'CSB/YOLO1512832693','3','PRIMAIRE','09/12/2017','PAY-1512832694','@hornel'),(82,'YOLO1513100728','2','MATERNELLE','14/10/2018','PAY-1539525435','@jonathan'),(83,'YOLO1513100840','1','MATERNELLE','14/10/2018','PAY-1539525435','@jonathan');
/*!40000 ALTER TABLE `t_subscription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_supported_students`
--

DROP TABLE IF EXISTS `t_supported_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_supported_students` (
  `_ID` int(11) NOT NULL AUTO_INCREMENT,
  `_NAME` varchar(100) DEFAULT NULL,
  `_PROFESSION` varchar(100) DEFAULT NULL,
  `_PHONE` varchar(100) DEFAULT NULL,
  `_EMPLOYEUR` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_supported_students`
--

LOCK TABLES `t_supported_students` WRITE;
/*!40000 ALTER TABLE `t_supported_students` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_supported_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_years_school`
--

DROP TABLE IF EXISTS `t_years_school`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_years_school` (
  `year` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`year`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_years_school`
--

LOCK TABLES `t_years_school` WRITE;
/*!40000 ALTER TABLE `t_years_school` DISABLE KEYS */;
INSERT INTO `t_years_school` VALUES ('2015-2016'),('2016-2017'),('2017-2018');
/*!40000 ALTER TABLE `t_years_school` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'db_baki'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-17 17:37:32
