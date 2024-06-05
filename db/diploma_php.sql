-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.3.13-MariaDB - mariadb.org binary distribution
-- Операционная система:         Win64
-- HeidiSQL Версия:              10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных diploma_php
CREATE DATABASE IF NOT EXISTS `diploma_php` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `diploma_php`;

-- Дамп структуры для таблица diploma_php.halls
CREATE TABLE IF NOT EXISTS `halls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `grid` VARCHAR(1500) DEFAULT NULL,
  `cost` VARCHAR(200) DEFAULT '{"standart":100,"vip":150}',
  PRIMARY KEY (`id`)halls
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы diploma_php.halls: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `halls` DISABLE KEYS */;
INSERT INTO `halls` (`id`, `name`, `grid`, `cost`) VALUES
	(1, '123', NULL, '{"standart": 100, "vip":150}'),
	(2, '234', NULL, '{"standart": 100, "vip":150}');
/*!40000 ALTER TABLE `halls` ENABLE KEYS */;

-- Дамп структуры для таблица diploma_php.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` text COLLATE utf8mb4_unicode_ci NOT NULL,
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
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
