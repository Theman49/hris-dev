-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for osx10.10 (x86_64)
--
-- Host: localhost    Database: hrm
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

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
-- Current Database: `hrm`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `hrm` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;

USE `hrm`;

--
-- Table structure for table `hrmapplicant`
--

DROP TABLE IF EXISTS `hrmapplicant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmapplicant` (
  `applicant_code` varchar(100) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `last_education` varchar(100) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `rec_code` varchar(100) DEFAULT NULL,
  `req_empid` varchar(100) NOT NULL,
  `applicant_status` varchar(100) DEFAULT NULL,
  `effective_join_date` date DEFAULT NULL,
  PRIMARY KEY (`applicant_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmapplicant`
--

LOCK TABLES `hrmapplicant` WRITE;
/*!40000 ALTER TABLE `hrmapplicant` DISABLE KEYS */;
INSERT INTO `hrmapplicant` VALUES ('APP20251209024120','bahlil','mana aja dah','S1','2001-07-11',5000000,'REC20251209022254','EMPSPV','5',NULL),('APP20251209093924','SPV MARKETING','','S1','2000-12-01',7000000,'REC20251209092304','EMPMGR','5',NULL);
/*!40000 ALTER TABLE `hrmapplicant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmapplicantstatus`
--

DROP TABLE IF EXISTS `hrmapplicantstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmapplicantstatus` (
  `status_code` varchar(100) NOT NULL,
  `status_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`status_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmapplicantstatus`
--

LOCK TABLES `hrmapplicantstatus` WRITE;
/*!40000 ALTER TABLE `hrmapplicantstatus` DISABLE KEYS */;
INSERT INTO `hrmapplicantstatus` VALUES ('0','New'),('1','Interview HR'),('2','Psycho Test'),('3','User Interview'),('4','Finalist'),('5','Hired'),('6','Rejected');
/*!40000 ALTER TABLE `hrmapplicantstatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmapprovalstatus`
--

DROP TABLE IF EXISTS `hrmapprovalstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmapprovalstatus` (
  `status_code` varchar(100) NOT NULL,
  `status_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`status_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmapprovalstatus`
--

LOCK TABLES `hrmapprovalstatus` WRITE;
/*!40000 ALTER TABLE `hrmapprovalstatus` DISABLE KEYS */;
INSERT INTO `hrmapprovalstatus` VALUES ('0','draft'),('1','waiting for approval'),('2','partially approved'),('3','finally approved'),('4','revised'),('5','rejected');
/*!40000 ALTER TABLE `hrmapprovalstatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmcareer`
--

DROP TABLE IF EXISTS `hrmcareer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmcareer` (
  `career_code` varchar(100) NOT NULL,
  `emp_id` varchar(100) DEFAULT NULL,
  `pos_code` varchar(100) DEFAULT NULL,
  `level_code` varchar(100) DEFAULT NULL,
  `career_type` varchar(100) DEFAULT NULL,
  `effective_date` varchar(100) DEFAULT NULL,
  `end_date` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`career_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmcareer`
--

LOCK TABLES `hrmcareer` WRITE;
/*!40000 ALTER TABLE `hrmcareer` DISABLE KEYS */;
INSERT INTO `hrmcareer` VALUES ('CAR00001','EMPSTF','SLS','STF','JOIN','2025-12-01','2026-05-01'),('CAR00002','EMPSPV','SLS','SPV','JOIN','2025-12-01','2026-05-01'),('CAR00003','EMPMGR','FIN','MGR','JOIN','2025-12-01','2026-05-01'),('CAR00004','HRD','HRD','HR','JOIN','2025-12-01','2026-05-01');
/*!40000 ALTER TABLE `hrmcareer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmcareertype`
--

DROP TABLE IF EXISTS `hrmcareertype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmcareertype` (
  `careertype_code` varchar(100) NOT NULL,
  `careertype_name` varchar(100) NOT NULL,
  PRIMARY KEY (`careertype_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmcareertype`
--

LOCK TABLES `hrmcareertype` WRITE;
/*!40000 ALTER TABLE `hrmcareertype` DISABLE KEYS */;
INSERT INTO `hrmcareertype` VALUES ('JOIN','Join'),('MOVEMENT','Movement'),('REHIRE','Rehire'),('TERMINATION','Termination');
/*!40000 ALTER TABLE `hrmcareertype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmcompparam`
--

DROP TABLE IF EXISTS `hrmcompparam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmcompparam` (
  `param_code` varchar(100) NOT NULL,
  `param_value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`param_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmcompparam`
--

LOCK TABLES `hrmcompparam` WRITE;
/*!40000 ALTER TABLE `hrmcompparam` DISABLE KEYS */;
INSERT INTO `hrmcompparam` VALUES ('leave_day_off','0,6'),('leave_deduct','1');
/*!40000 ALTER TABLE `hrmcompparam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmemployee`
--

DROP TABLE IF EXISTS `hrmemployee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmemployee` (
  `emp_id` varchar(100) NOT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `last_education` varchar(100) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `pos_code` varchar(100) DEFAULT NULL,
  `level_code` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmemployee`
--

LOCK TABLES `hrmemployee` WRITE;
/*!40000 ALTER TABLE `hrmemployee` DISABLE KEYS */;
INSERT INTO `hrmemployee` VALUES ('EMPMGR','3','MGR',NULL,'S1','1999-01-01','FIN','MGR'),('EMPSPV','2','SPV',NULL,'S1','2000-01-01','SLS','SPV'),('EMPSTF','1','STAFF',NULL,'S1','2001-01-01','SLS','STF'),('HRD','4','HRD',NULL,'S1','1998-01-01','HRD','HR');
/*!40000 ALTER TABLE `hrmemployee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmleave`
--

DROP TABLE IF EXISTS `hrmleave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmleave` (
  `leave_code` varchar(100) NOT NULL,
  `req_for` varchar(100) NOT NULL,
  `leave_startdate` date DEFAULT NULL,
  `leave_enddate` date DEFAULT NULL,
  `req_user` varchar(100) DEFAULT NULL,
  `req_date` varchar(100) DEFAULT NULL,
  `modified_user` varchar(100) DEFAULT NULL,
  `modified_date` varchar(100) DEFAULT NULL,
  `req_status` varchar(100) DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `reason_revise` varchar(100) DEFAULT NULL,
  `reason` varchar(100) DEFAULT NULL,
  `is_sick_leave` int(10) unsigned DEFAULT NULL,
  `attachment` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`leave_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmleave`
--

LOCK TABLES `hrmleave` WRITE;
/*!40000 ALTER TABLE `hrmleave` DISABLE KEYS */;
/*!40000 ALTER TABLE `hrmleave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmleavebalance`
--

DROP TABLE IF EXISTS `hrmleavebalance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmleavebalance` (
  `leavebalance_id` varchar(100) NOT NULL,
  `emp_id` varchar(100) DEFAULT NULL,
  `balance_value` float DEFAULT NULL,
  `start_period` date DEFAULT NULL,
  `active_status` int(10) unsigned DEFAULT NULL,
  `end_period` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmleavebalance`
--

LOCK TABLES `hrmleavebalance` WRITE;
/*!40000 ALTER TABLE `hrmleavebalance` DISABLE KEYS */;
INSERT INTO `hrmleavebalance` VALUES ('BAL9201480','EMPSTF',12,'2025-12-01',0,'2026-05-01'),('BAL9201490','EMPSPV',12,'2025-12-01',1,'2026-05-01'),('BAL9201491','EMPMGR',12,'2025-12-01',1,'2026-05-01'),('BAL9201492','HRD',12,'2025-12-01',1,'2026-05-01'),('LVL20251213041734','EMPSTF',12,'2026-05-02',1,'2027-05-02');
/*!40000 ALTER TABLE `hrmleavebalance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmlevel`
--

DROP TABLE IF EXISTS `hrmlevel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmlevel` (
  `level_code` varchar(100) NOT NULL,
  `level_name` varchar(100) DEFAULT NULL,
  `level_order` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`level_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmlevel`
--

LOCK TABLES `hrmlevel` WRITE;
/*!40000 ALTER TABLE `hrmlevel` DISABLE KEYS */;
INSERT INTO `hrmlevel` VALUES ('HR','Human Resource',4),('MGR','Manager',3),('SPV','Supervisor',2),('STF','Staff',1);
/*!40000 ALTER TABLE `hrmlevel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmposition`
--

DROP TABLE IF EXISTS `hrmposition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmposition` (
  `pos_code` varchar(100) NOT NULL,
  `pos_name` varchar(100) NOT NULL,
  `parent_code` varchar(100) DEFAULT NULL,
  `pos_desc` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`pos_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmposition`
--

LOCK TABLES `hrmposition` WRITE;
/*!40000 ALTER TABLE `hrmposition` DISABLE KEYS */;
INSERT INTO `hrmposition` VALUES ('BOD','Board of Director','','this is BOD'),('FIN','Department Finance','BOD','dept'),('HRD','Human Resource Department','BOD',''),('MRK','Marketing','FIN','marketing'),('SLS','Sales','FIN','sales');
/*!40000 ALTER TABLE `hrmposition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmrecruitmentreq`
--

DROP TABLE IF EXISTS `hrmrecruitmentreq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmrecruitmentreq` (
  `req_code` varchar(100) NOT NULL,
  `pos_code` varchar(100) NOT NULL,
  `req_status` int(10) unsigned NOT NULL,
  `expected_join_date` date NOT NULL,
  `approved_date` date DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_user` varchar(100) DEFAULT NULL,
  `rec_count` int(10) unsigned DEFAULT NULL,
  `reason` varchar(100) DEFAULT NULL,
  `level_code` varchar(5) DEFAULT NULL,
  `req_empid` varchar(100) DEFAULT NULL,
  `req_date` date DEFAULT NULL,
  `reason_revise` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`req_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmrecruitmentreq`
--

LOCK TABLES `hrmrecruitmentreq` WRITE;
/*!40000 ALTER TABLE `hrmrecruitmentreq` DISABLE KEYS */;
INSERT INTO `hrmrecruitmentreq` VALUES ('REC20251209022254','SLS',3,'2025-12-12','2025-12-09','2025-12-09','HRD',1,'1','STF','EMPSPV','2025-12-09','cuma bisa 1 orang nambahnya'),('REC20251209091925','SLS',1,'2025-12-12',NULL,'2025-12-09','EMPSPV',3,'perlu orang baru','STF','EMPSPV','2025-12-09',NULL),('REC20251209092304','MRK',3,'2025-12-10','2025-12-09','2025-12-09','HRD',1,'perlu SPV untuk marketing','SPV','EMPMGR','2025-12-09',NULL);
/*!40000 ALTER TABLE `hrmrecruitmentreq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmuser`
--

DROP TABLE IF EXISTS `hrmuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmuser` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmuser`
--

LOCK TABLES `hrmuser` WRITE;
/*!40000 ALTER TABLE `hrmuser` DISABLE KEYS */;
INSERT INTO `hrmuser` VALUES (1,'stf','password'),(2,'spv','password'),(3,'mgr','password'),(4,'hrd','password');
/*!40000 ALTER TABLE `hrmuser` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-13 23:29:32
-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for osx10.10 (x86_64)
--
-- Host: localhost    Database: hrm
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

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
-- Current Database: `hrm`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `hrm` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;

USE `hrm`;

--
-- Table structure for table `hrmapplicant`
--

DROP TABLE IF EXISTS `hrmapplicant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmapplicant` (
  `applicant_code` varchar(100) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `last_education` varchar(100) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `rec_code` varchar(100) DEFAULT NULL,
  `req_empid` varchar(100) NOT NULL,
  `applicant_status` varchar(100) DEFAULT NULL,
  `effective_join_date` date DEFAULT NULL,
  PRIMARY KEY (`applicant_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmapplicant`
--

LOCK TABLES `hrmapplicant` WRITE;
/*!40000 ALTER TABLE `hrmapplicant` DISABLE KEYS */;
INSERT INTO `hrmapplicant` VALUES ('APP20251209024120','bahlil','mana aja dah','S1','2001-07-11',5000000,'REC20251209022254','EMPSPV','5',NULL),('APP20251209093924','SPV MARKETING','','S1','2000-12-01',7000000,'REC20251209092304','EMPMGR','5',NULL);
/*!40000 ALTER TABLE `hrmapplicant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmapplicantstatus`
--

DROP TABLE IF EXISTS `hrmapplicantstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmapplicantstatus` (
  `status_code` varchar(100) NOT NULL,
  `status_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`status_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmapplicantstatus`
--

LOCK TABLES `hrmapplicantstatus` WRITE;
/*!40000 ALTER TABLE `hrmapplicantstatus` DISABLE KEYS */;
INSERT INTO `hrmapplicantstatus` VALUES ('0','New'),('1','Interview HR'),('2','Psycho Test'),('3','User Interview'),('4','Finalist'),('5','Hired'),('6','Rejected');
/*!40000 ALTER TABLE `hrmapplicantstatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmapprovalstatus`
--

DROP TABLE IF EXISTS `hrmapprovalstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmapprovalstatus` (
  `status_code` varchar(100) NOT NULL,
  `status_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`status_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmapprovalstatus`
--

LOCK TABLES `hrmapprovalstatus` WRITE;
/*!40000 ALTER TABLE `hrmapprovalstatus` DISABLE KEYS */;
INSERT INTO `hrmapprovalstatus` VALUES ('0','draft'),('1','waiting for approval'),('2','partially approved'),('3','finally approved'),('4','revised'),('5','rejected');
/*!40000 ALTER TABLE `hrmapprovalstatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmcareer`
--

DROP TABLE IF EXISTS `hrmcareer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmcareer` (
  `career_code` varchar(100) NOT NULL,
  `emp_id` varchar(100) DEFAULT NULL,
  `pos_code` varchar(100) DEFAULT NULL,
  `level_code` varchar(100) DEFAULT NULL,
  `career_type` varchar(100) DEFAULT NULL,
  `effective_date` varchar(100) DEFAULT NULL,
  `end_date` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`career_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmcareer`
--

LOCK TABLES `hrmcareer` WRITE;
/*!40000 ALTER TABLE `hrmcareer` DISABLE KEYS */;
INSERT INTO `hrmcareer` VALUES ('CAR00001','EMPSTF','SLS','STF','JOIN','2025-12-01','2026-05-01'),('CAR00002','EMPSPV','SLS','SPV','JOIN','2025-12-01','2026-05-01'),('CAR00003','EMPMGR','FIN','MGR','JOIN','2025-12-01','2026-05-01'),('CAR00004','HRD','HRD','HR','JOIN','2025-12-01','2026-05-01');
/*!40000 ALTER TABLE `hrmcareer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmcareertype`
--

DROP TABLE IF EXISTS `hrmcareertype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmcareertype` (
  `careertype_code` varchar(100) NOT NULL,
  `careertype_name` varchar(100) NOT NULL,
  PRIMARY KEY (`careertype_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmcareertype`
--

LOCK TABLES `hrmcareertype` WRITE;
/*!40000 ALTER TABLE `hrmcareertype` DISABLE KEYS */;
INSERT INTO `hrmcareertype` VALUES ('JOIN','Join'),('MOVEMENT','Movement'),('REHIRE','Rehire'),('TERMINATION','Termination');
/*!40000 ALTER TABLE `hrmcareertype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmcompparam`
--

DROP TABLE IF EXISTS `hrmcompparam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmcompparam` (
  `param_code` varchar(100) NOT NULL,
  `param_value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`param_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmcompparam`
--

LOCK TABLES `hrmcompparam` WRITE;
/*!40000 ALTER TABLE `hrmcompparam` DISABLE KEYS */;
INSERT INTO `hrmcompparam` VALUES ('leave_day_off','0,6'),('leave_deduct','1');
/*!40000 ALTER TABLE `hrmcompparam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmemployee`
--

DROP TABLE IF EXISTS `hrmemployee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmemployee` (
  `emp_id` varchar(100) NOT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `last_education` varchar(100) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `pos_code` varchar(100) DEFAULT NULL,
  `level_code` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmemployee`
--

LOCK TABLES `hrmemployee` WRITE;
/*!40000 ALTER TABLE `hrmemployee` DISABLE KEYS */;
INSERT INTO `hrmemployee` VALUES ('EMPMGR','3','MGR',NULL,'S1','1999-01-01','FIN','MGR'),('EMPSPV','2','SPV',NULL,'S1','2000-01-01','SLS','SPV'),('EMPSTF','1','STAFF',NULL,'S1','2001-01-01','SLS','STF'),('HRD','4','HRD',NULL,'S1','1998-01-01','HRD','HR');
/*!40000 ALTER TABLE `hrmemployee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmleave`
--

DROP TABLE IF EXISTS `hrmleave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmleave` (
  `leave_code` varchar(100) NOT NULL,
  `req_for` varchar(100) NOT NULL,
  `leave_startdate` date DEFAULT NULL,
  `leave_enddate` date DEFAULT NULL,
  `req_user` varchar(100) DEFAULT NULL,
  `req_date` varchar(100) DEFAULT NULL,
  `modified_user` varchar(100) DEFAULT NULL,
  `modified_date` varchar(100) DEFAULT NULL,
  `req_status` varchar(100) DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `reason_revise` varchar(100) DEFAULT NULL,
  `reason` varchar(100) DEFAULT NULL,
  `is_sick_leave` int(10) unsigned DEFAULT NULL,
  `attachment` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`leave_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmleave`
--

LOCK TABLES `hrmleave` WRITE;
/*!40000 ALTER TABLE `hrmleave` DISABLE KEYS */;
/*!40000 ALTER TABLE `hrmleave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmleavebalance`
--

DROP TABLE IF EXISTS `hrmleavebalance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmleavebalance` (
  `leavebalance_id` varchar(100) NOT NULL,
  `emp_id` varchar(100) DEFAULT NULL,
  `balance_value` float DEFAULT NULL,
  `start_period` date DEFAULT NULL,
  `active_status` int(10) unsigned DEFAULT NULL,
  `end_period` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmleavebalance`
--

LOCK TABLES `hrmleavebalance` WRITE;
/*!40000 ALTER TABLE `hrmleavebalance` DISABLE KEYS */;
INSERT INTO `hrmleavebalance` VALUES ('BAL9201480','EMPSTF',12,'2025-12-01',0,'2026-05-01'),('BAL9201490','EMPSPV',12,'2025-12-01',1,'2026-05-01'),('BAL9201491','EMPMGR',12,'2025-12-01',1,'2026-05-01'),('BAL9201492','HRD',12,'2025-12-01',1,'2026-05-01'),('LVL20251213041734','EMPSTF',12,'2026-05-02',1,'2027-05-02');
/*!40000 ALTER TABLE `hrmleavebalance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmlevel`
--

DROP TABLE IF EXISTS `hrmlevel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmlevel` (
  `level_code` varchar(100) NOT NULL,
  `level_name` varchar(100) DEFAULT NULL,
  `level_order` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`level_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmlevel`
--

LOCK TABLES `hrmlevel` WRITE;
/*!40000 ALTER TABLE `hrmlevel` DISABLE KEYS */;
INSERT INTO `hrmlevel` VALUES ('HR','Human Resource',4),('MGR','Manager',3),('SPV','Supervisor',2),('STF','Staff',1);
/*!40000 ALTER TABLE `hrmlevel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmposition`
--

DROP TABLE IF EXISTS `hrmposition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmposition` (
  `pos_code` varchar(100) NOT NULL,
  `pos_name` varchar(100) NOT NULL,
  `parent_code` varchar(100) DEFAULT NULL,
  `pos_desc` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`pos_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmposition`
--

LOCK TABLES `hrmposition` WRITE;
/*!40000 ALTER TABLE `hrmposition` DISABLE KEYS */;
INSERT INTO `hrmposition` VALUES ('BOD','Board of Director','','this is BOD'),('FIN','Department Finance','BOD','dept'),('HRD','Human Resource Department','BOD',''),('MRK','Marketing','FIN','marketing'),('SLS','Sales','FIN','sales');
/*!40000 ALTER TABLE `hrmposition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmrecruitmentreq`
--

DROP TABLE IF EXISTS `hrmrecruitmentreq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmrecruitmentreq` (
  `req_code` varchar(100) NOT NULL,
  `pos_code` varchar(100) NOT NULL,
  `req_status` int(10) unsigned NOT NULL,
  `expected_join_date` date NOT NULL,
  `approved_date` date DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_user` varchar(100) DEFAULT NULL,
  `rec_count` int(10) unsigned DEFAULT NULL,
  `reason` varchar(100) DEFAULT NULL,
  `level_code` varchar(5) DEFAULT NULL,
  `req_empid` varchar(100) DEFAULT NULL,
  `req_date` date DEFAULT NULL,
  `reason_revise` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`req_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmrecruitmentreq`
--

LOCK TABLES `hrmrecruitmentreq` WRITE;
/*!40000 ALTER TABLE `hrmrecruitmentreq` DISABLE KEYS */;
INSERT INTO `hrmrecruitmentreq` VALUES ('REC20251209022254','SLS',3,'2025-12-12','2025-12-09','2025-12-09','HRD',1,'1','STF','EMPSPV','2025-12-09','cuma bisa 1 orang nambahnya'),('REC20251209091925','SLS',1,'2025-12-12',NULL,'2025-12-09','EMPSPV',3,'perlu orang baru','STF','EMPSPV','2025-12-09',NULL),('REC20251209092304','MRK',3,'2025-12-10','2025-12-09','2025-12-09','HRD',1,'perlu SPV untuk marketing','SPV','EMPMGR','2025-12-09',NULL);
/*!40000 ALTER TABLE `hrmrecruitmentreq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hrmuser`
--

DROP TABLE IF EXISTS `hrmuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrmuser` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hrmuser`
--

LOCK TABLES `hrmuser` WRITE;
/*!40000 ALTER TABLE `hrmuser` DISABLE KEYS */;
INSERT INTO `hrmuser` VALUES (1,'stf','password'),(2,'spv','password'),(3,'mgr','password'),(4,'hrd','password');
/*!40000 ALTER TABLE `hrmuser` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-13 23:29:39
