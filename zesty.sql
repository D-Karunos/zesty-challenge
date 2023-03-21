# ************************************************************
# Sequel Ace SQL dump
# Version 20035
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: localhost (MySQL 8.0.32)
# Database: zesty
# Generation Time: 2023-03-21 20:03:44 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table opening_hours
# ------------------------------------------------------------

DROP TABLE IF EXISTS `opening_hours`;

CREATE TABLE `opening_hours` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `weekday` varchar(3) DEFAULT NULL,
  `timeOpening` time NOT NULL,
  `timeClosing` time NOT NULL,
  `weight` tinyint DEFAULT '0',
  `active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `opening_hours` WRITE;
/*!40000 ALTER TABLE `opening_hours` DISABLE KEYS */;

INSERT INTO `opening_hours` (`id`, `weekday`, `timeOpening`, `timeClosing`, `weight`, `active`)
VALUES
	(1,'Mon','09:00:00','18:00:00',1,1),
	(2,'Tue','09:00:00','21:00:00',2,1),
	(3,'Wed','09:00:00','20:00:00',3,0),
	(4,'Thu','09:00:00','21:00:00',4,1),
	(5,'Fri','09:00:00','21:00:00',5,1),
	(6,'Sat','09:00:00','15:00:00',6,1),
	(7,'Sun','09:00:00','16:00:00',7,1);

/*!40000 ALTER TABLE `opening_hours` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
