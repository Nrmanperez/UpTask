CREATE DATABASE  IF NOT EXISTS `uptask_mvc` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `uptask_mvc`;
-- MySQL dump 10.13  Distrib 8.0.26, for Win64 (x86_64)
--
-- Host: localhost    Database: uptask_mvc
-- ------------------------------------------------------
-- Server version	5.7.35-log

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
-- Table structure for table `proyectos`
--

DROP TABLE IF EXISTS `proyectos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proyectos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proyecto` varchar(60) DEFAULT NULL,
  `url` varchar(32) DEFAULT NULL,
  `propietarioId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `propietarioId_idx` (`propietarioId`),
  CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`propietarioId`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectos`
--

LOCK TABLES `proyectos` WRITE;
/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
INSERT INTO `proyectos` VALUES (1,' Tienda Virtual de Autos','0e7be0e3c2e19ec1acf0a35408208ff8',4),(2,' Crear una API para Shopify','42fd2b81281782963e0af17762ed8f5a',4),(3,' Tienda de Zapatos','136b61edd84cbe427dda4c642630532f',4),(4,' App en Flutter para Restaurante','9178c140db203bf738a73139f9705656',4);
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tareas`
--

DROP TABLE IF EXISTS `tareas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tareas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `proyectoId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `proyectoId_idx` (`proyectoId`),
  CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`proyectoId`) REFERENCES `proyectos` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tareas`
--

LOCK TABLES `tareas` WRITE;
/*!40000 ALTER TABLE `tareas` DISABLE KEYS */;
INSERT INTO `tareas` VALUES (1,' Configurar cuenta de PayPal',0,1),(2,' Configurar cuenta de Stripe',0,1),(3,' Investigar Hosting',0,1),(5,' Elegir Tema de WooCommerce',0,1),(6,' Crear Front End',0,1),(7,' Buscar imagenes',0,1),(8,' Investigar Hosting',0,2),(9,' Codificar API',0,2),(10,' Investigar diseÃ±o',0,2),(11,' Reunion con gerentes',0,2),(12,' Reunir catalogo',0,3),(13,' Crear diseÃ±o',0,3),(14,' Inventariar productos',0,3),(15,' Crear codigo back end',0,3),(16,' Buscar un tema de WooCommerce',0,1),(19,' Nueva Tarea con Virtual DOM',0,1);
/*!40000 ALTER TABLE `tareas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `token` varchar(15) DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (4,' norman','correo@correo.com','$2y$10$eY9gVzomuYRwcwi7x4R8MeWCRn5olcAQ6y4C/8RP3sOvJ37HgK7z2','',1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-02-23 10:32:19
