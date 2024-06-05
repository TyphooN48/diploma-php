-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               8.0.19 - MySQL Community Server - GPL
-- Операционная система:         Win64
-- HeidiSQL Версия:              11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных diploma_php
CREATE DATABASE IF NOT EXISTS `diploma_php` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `diploma_php`;

-- Дамп структуры для таблица diploma_php.halls
CREATE TABLE IF NOT EXISTS `halls` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `grid` varchar(1500) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '{"rows":2,"places":4,"grid":[0,1,1,0,2,0,0,2]}',
  `cost` varchar(200) DEFAULT '{"standart": 100, "vip":150}',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы diploma_php.halls: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `halls` DISABLE KEYS */;
INSERT INTO `halls` (`id`, `name`, `grid`, `cost`) VALUES
	(1, '123', '{"rows":1,"places":4,"grid":[1,1,2,1]}', '{"standart":110,"vip":150}'),
	(2, '234', '{"rows":2,"places":4,"grid":[0,1,1,0,2,0,0,2]}', '{"standart":99,"vip":150}');
/*!40000 ALTER TABLE `halls` ENABLE KEYS */;

-- Дамп структуры для таблица diploma_php.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы diploma_php.users: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `login`, `pass`) VALUES
	(1, 'andrew@ya.ru', '$2y$10$1lUkgsCAHu/qQoNuNfd/J./H9G5kutKHvQNCCYAbItAFfD4tdv8mq'),
	(2, 'test@ya.ru', '$2y$10$14j0CrY.Z69xzMmyqB2J1eMd4ziUGTezopfGACP3ysJzZnk2m9wLW');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
