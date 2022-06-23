-- MariaDB dump 10.19  Distrib 10.6.5-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: cosc4606_assignment_02
-- ------------------------------------------------------
-- Server version	10.6.5-MariaDB

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
-- Table structure for table `CourseInfo`
--

DROP TABLE IF EXISTS `CourseInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CourseInfo` (
  `CourseName` varchar(255) NOT NULL,
  `CourseDesc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`CourseName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CourseInfo`
--

LOCK TABLES `CourseInfo` WRITE;
/*!40000 ALTER TABLE `CourseInfo` DISABLE KEYS */;
INSERT INTO `CourseInfo` VALUES ('Career Skills','Introduces the student to skills needed for securing employment'),('Computer Software for Sciences','The basic software tools applicable to the Sciences are presented'),('Data Management Systems','Introduction to the design and use of databases management systems'),('Film and Modern History','Focuses on the use of film to portray modern history'),('Introduction to Cultural Anthropology','General introduction to social/cultural anthropology'),('Introduction to Environmental Science','A comprehensive introduction to the science behind the main environmental challenges facing society'),('Introduction to Statistics','Introduction to basic statistical concepts and techniques that are common to all disciplines in the Social Sciences'),('Mobile Application Development I','Introduces the student to one of the major Mobile Computing platforms'),('Techniques of Systems Analysis','Information gathering and reporting'),('Topics in Computer Science I','Treatment of a selection of advanced topics'),('Understanding the Earth','Introduction to Geology for students without a background in science');
/*!40000 ALTER TABLE `CourseInfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Courses`
--

DROP TABLE IF EXISTS `Courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Courses` (
  `CourseCode` varchar(50) NOT NULL,
  `Section` varchar(50) NOT NULL,
  `Term` varchar(50) NOT NULL,
  `Year` int(4) NOT NULL,
  `CourseName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`CourseCode`,`Section`,`Term`,`Year`),
  KEY `courseinfocourses` (`CourseName`),
  KEY `coursescoursename` (`CourseName`),
  CONSTRAINT `courseinfocourses` FOREIGN KEY (`CourseName`) REFERENCES `CourseInfo` (`CourseName`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Courses`
--

LOCK TABLES `Courses` WRITE;
/*!40000 ALTER TABLE `Courses` DISABLE KEYS */;
INSERT INTO `Courses` VALUES ('COOP0101','A','21F',2021,'Career Skills'),('COSC2836','A','22W',2022,'Computer Software for Sciences'),('COSC4606','A','21F',2021,'Data Management Systems'),('FILM2907','A','21F',2021,'Film and Modern History'),('ANTR1007','A','22W',2022,'Introduction to Cultural Anthropology'),('ENVS1006','A','22W',2022,'Introduction to Environmental Science'),('STAT2126','A','21F',2021,'Introduction to Statistics'),('COSC3596','A','22W',2022,'Mobile Application Development I'),('COSC3707','A','22W',2022,'Techniques of Systems Analysis'),('COSC4426','A','21F',2021,'Topics in Computer Science I'),('GEOL1021','A','21F',2021,'Understanding the Earth');
/*!40000 ALTER TABLE `Courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Enrollments`
--

DROP TABLE IF EXISTS `Enrollments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Enrollments` (
  `StudentID` int(9) DEFAULT 0,
  `CourseCode` varchar(50) DEFAULT NULL,
  `Section` varchar(50) DEFAULT NULL,
  `Term` varchar(255) DEFAULT NULL,
  `Year` int(4) DEFAULT 0,
  `Mark` int(3) DEFAULT 0,
  `Status` varchar(255) DEFAULT NULL,
  KEY `coursesenrollments` (`CourseCode`,`Section`,`Term`,`Year`),
  KEY `enrollmentscoursecode` (`CourseCode`),
  KEY `enrollmentsstudentid` (`StudentID`),
  KEY `studentsenrollments` (`StudentID`),
  CONSTRAINT `coursesenrollments` FOREIGN KEY (`CourseCode`, `Section`, `Term`, `Year`) REFERENCES `Courses` (`CourseCode`, `Section`, `Term`, `Year`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `studentsenrollments` FOREIGN KEY (`StudentID`) REFERENCES `Students` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Enrollments`
--

LOCK TABLES `Enrollments` WRITE;
/*!40000 ALTER TABLE `Enrollments` DISABLE KEYS */;
INSERT INTO `Enrollments` VALUES (189602990,'COSC4426','A','21F',2021,100,'Passed'),(189602990,'COSC4606','A','21F',2021,100,'Passed'),(189602990,'FILM2907','A','21F',2021,100,'Passed'),(189602990,'STAT2126','A','21F',2021,100,'Passed'),(189602990,'GEOL1021','A','21F',2021,100,'Passed'),(189602990,'COSC3707','A','22W',2022,0,'In Progress'),(189602990,'COSC3596','A','22W',2022,0,'In Progress'),(189602990,'ENVS1006','A','22W',2022,0,'In Progress'),(189602990,'COSC2836','A','22W',2022,0,'In Progress'),(189602990,'ANTR1007','A','22W',2022,0,'In Progress'),(465700130,'COSC4606','A','21F',2021,69,'Passed'),(520594330,'COSC4606','A','21F',2021,87,'Passed'),(544000434,'COSC4606','A','21F',2021,73,'Passed'),(716658445,'COSC4606','A','21F',2021,68,'Passed');
/*!40000 ALTER TABLE `Enrollments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Faculty`
--

DROP TABLE IF EXISTS `Faculty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Faculty` (
  `FacultyID` int(11) NOT NULL DEFAULT 0,
  `GivenName` varchar(255) DEFAULT NULL,
  `Surname` varchar(255) DEFAULT NULL,
  `HomePhoneNum` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`FacultyID`),
  KEY `idx_homephonenum` (`HomePhoneNum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Faculty`
--

LOCK TABLES `Faculty` WRITE;
/*!40000 ALTER TABLE `Faculty` DISABLE KEYS */;
INSERT INTO `Faculty` VALUES (123456789,'Klaus','Peltsch','226-628-0016'),(876543767,'John','Smith','543-876-8753');
/*!40000 ALTER TABLE `Faculty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Instructors`
--

DROP TABLE IF EXISTS `Instructors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Instructors` (
  `FacultyID` int(9) NOT NULL DEFAULT 0,
  `CourseCode` varchar(255) NOT NULL,
  `Section` varchar(255) NOT NULL,
  `Term` varchar(50) NOT NULL,
  `Year` int(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`FacultyID`,`CourseCode`,`Section`,`Term`,`Year`),
  KEY `coursesinstructors` (`CourseCode`,`Section`,`Term`,`Year`),
  KEY `facultyinstructors` (`FacultyID`),
  KEY `instructorscoursecode` (`CourseCode`),
  KEY `instructorsfacultyid` (`FacultyID`),
  CONSTRAINT `coursesinstructors` FOREIGN KEY (`CourseCode`, `Section`, `Term`, `Year`) REFERENCES `Courses` (`CourseCode`, `Section`, `Term`, `Year`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `facultyinstructors` FOREIGN KEY (`FacultyID`) REFERENCES `Faculty` (`FacultyID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Instructors`
--

LOCK TABLES `Instructors` WRITE;
/*!40000 ALTER TABLE `Instructors` DISABLE KEYS */;
INSERT INTO `Instructors` VALUES (123456789,'COSC2836','A','22W',2022),(123456789,'COSC3596','A','22W',2022),(123456789,'COSC3707','A','22W',2022),(123456789,'COSC4426','A','21F',2021),(123456789,'COSC4606','A','21F',2021),(123456789,'ENVS1006','A','22W',2022);
/*!40000 ALTER TABLE `Instructors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Students`
--

DROP TABLE IF EXISTS `Students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Students` (
  `StudentID` int(9) NOT NULL DEFAULT 0,
  `GivenName` varchar(50) DEFAULT NULL,
  `Surname` varchar(50) DEFAULT NULL,
  `PhoneNumber` varchar(50) DEFAULT NULL,
  `InCOOP` tinyint(1) NOT NULL DEFAULT 0,
  `Degree` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`StudentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Students`
--

LOCK TABLES `Students` WRITE;
/*!40000 ALTER TABLE `Students` DISABLE KEYS */;
INSERT INTO `Students` VALUES (189602990,'Matthew','Carlson','705-249-2301',0,'BSc. Computer Science'),(465700130,'Mircea','Fortunato','506-463-6096',0,'BSc. Biology'),(475357891,'Marlon','Brando','489-653-7631',1,'BSc. Computer Science'),(520594330,'Anna','Atwood','582-400-3003',1,'BA Law and Justice'),(544000434,'Argyro','Samuelsson','204-380-0289',0,'Bachelor of Computer Science'),(716658445,'Penelope','Moen','613-737-3374',1,'BA Psychology');
/*!40000 ALTER TABLE `Students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `ID` int(11) NOT NULL,
  `UserName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` char(61) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (123456789,'kpeltsch','$2y$10$maPq2ULzqUvC2v1Qy8kZLuY88C9S9swEKM9SCowgnJM4M8Nqf0FSG','Instructor'),(189602990,'mcarlson','$2y$10$Qjcz1nIY0G6SpLlt8m0iJOA7zWljpcLxSelwC0XcS0JbfgQkmDtwG','Student'),(465700130,'mfortunato','$2y$10$N/BIKsuyFadj04Fb6IXQT.sa5O/zP.VWoc.yoJDr3ahwbzJX0eT8S','Student'),(475357891,'mbrando','$2y$10$8JqfmhKoVsxt1j5GzKMdUuSgj3.5.HY1vy/vTLJ9jywb/8nkuqvBi','Student'),(520594330,'aatwood','$2y$10$4ie.Kuds71mYqzZlw2UHnePYXUIwFj067rbbWhI1frUtBcvwjW4DK','Student'),(544000434,'asamuelsson','$2y$10$MYzVA0T3ezXh3eid0OvKkOY1VZILMFLBQ716ZFErZH0embBP93gKe','Student'),(654247853,'admin','$2y$10$yrW42UcOPVi/E9fOtpRJMeoUit7P2LflLHqbRcmVOWq33LfsWlp1u','Admin'),(716658445,'pmoen','$2y$10$7a4kyLrOml3uPlusgmmyteWKBwOeckooalbtE0pmGBafkDL3/Xrce','Student'),(987654321,'registrar','$2y$10$0Bh.u9X6J1VgfPlIAov7MuNiVGo.w.rSltpOpkg39o.cjHzlTIgum','Registrar');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-23 23:23:46
