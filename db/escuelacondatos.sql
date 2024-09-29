-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: escuela
-- ------------------------------------------------------
-- Server version	8.0.38

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
-- Dumping data for table `alumno`
--

LOCK TABLES `alumno` WRITE;
/*!40000 ALTER TABLE `alumno` DISABLE KEYS */;
INSERT INTO `alumno` VALUES (1,'Juan maria','Pérez','García','987471158','2005-06-15','Calle Falsa 123','9774716',5),(6,'maria','calle','calle','9874716','2024-09-12','sdfesdf','77574524',1);
/*!40000 ALTER TABLE `alumno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `asignatura`
--

LOCK TABLES `asignatura` WRITE;
/*!40000 ALTER TABLE `asignatura` DISABLE KEYS */;
INSERT INTO `asignatura` VALUES (2,'Matemáticas Básicas','Introducción a los conceptos básicos de las matemáticas.',4,2),(3,'lengiaje 1ro','dewdewtttttt',5,2),(4,'1ros quica','dscdscds',4,3),(5,'quimica','sfsfwe',7,3);
/*!40000 ALTER TABLE `asignatura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `grado`
--

LOCK TABLES `grado` WRITE;
/*!40000 ALTER TABLE `grado` DISABLE KEYS */;
INSERT INTO `grado` VALUES (1,'primero','primaria','A',1),(2,'Segundo','Primaria','A',1),(3,'Tercero','Primaria','A',1),(4,'Primero','Primaria','B',6);
/*!40000 ALTER TABLE `grado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `gradoasignatura`
--

LOCK TABLES `gradoasignatura` WRITE;
/*!40000 ALTER TABLE `gradoasignatura` DISABLE KEYS */;
/*!40000 ALTER TABLE `gradoasignatura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `inscripcion`
--

LOCK TABLES `inscripcion` WRITE;
/*!40000 ALTER TABLE `inscripcion` DISABLE KEYS */;
INSERT INTO `inscripcion` VALUES (2,1,3,1,'2024-09-28'),(3,1,2,1,'2024-09-28'),(4,1,2,2,'2024-09-28'),(5,1,3,3,'2024-09-28'),(6,6,5,4,'2024-09-28'),(7,1,5,1,'2024-09-28');
/*!40000 ALTER TABLE `inscripcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `materias`
--

LOCK TABLES `materias` WRITE;
/*!40000 ALTER TABLE `materias` DISABLE KEYS */;
INSERT INTO `materias` VALUES (2,'lenguaje','literatura perrro'),(3,'quimica','quimica');
/*!40000 ALTER TABLE `materias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `nota`
--

LOCK TABLES `nota` WRITE;
/*!40000 ALTER TABLE `nota` DISABLE KEYS */;
INSERT INTO `nota` VALUES (1,2,100.00,'2024-01-15'),(2,2,80.00,'2024-01-15'),(3,6,50.00,'2024-09-29'),(4,7,80.00,'2024-09-29'),(5,6,100.00,'2024-09-29'),(6,6,100.00,'2024-09-29'),(7,6,80.00,'2024-09-29'),(8,7,120.00,'2024-09-29'),(9,7,51.00,'2024-09-29');
/*!40000 ALTER TABLE `nota` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'JUAN','9874711','admin@colegio.com','$2y$10$V1WhQyiZXMZPdUbNyDGD3ehpIvgtG717dT6CP02/u82Dac1vY.ugG','administrador'),(4,'Amaru','9874713','76595194amaru@gmail.com','$2y$10$kWSLOFzSFRznaNMvyEpbputiAZpQfgIkyaML7cRSZP4qEQzBKChbu','docente'),(5,'paola','9874712','paola@gmail.com','$2y$10$82lZG8eU7..gMGpbwOfY3u4WTHGPbXmzmAkHaT57AJ2345F1lDTp2','docente'),(7,'carlos garzia','9874715','carlos@gmail.com','$2y$10$e17W9QN.rX7AwpsR30mj8.n0ivgKl6c3cifb1atCnVX2r9FzNpTB6','docente');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-29  0:33:27
