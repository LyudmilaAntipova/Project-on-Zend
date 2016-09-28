-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.24 - MySQL Community Server (GPL)
-- ОС Сервера:                   Win64
-- HeidiSQL Версия:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных shop
CREATE DATABASE IF NOT EXISTS `shop` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `shop`;


-- Дамп структуры для таблица shop.order
CREATE TABLE IF NOT EXISTS `order` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` smallint(5) unsigned NOT NULL,
  `date` date NOT NULL,
  `amount` float(10,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `FK__user` (`user_id`),
  CONSTRAINT `FK__user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.order: ~8 rows (приблизительно)
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` (`id`, `user_id`, `date`, `amount`) VALUES
	(1, 5, '2016-07-25', 14100.00),
	(2, 14, '2016-07-27', 36000.00),
	(3, 12, '2016-07-27', 28102.00),
	(4, 2, '2016-07-29', 3650.00),
	(5, 1, '2016-07-29', 40130.00),
	(6, 3, '2016-07-23', 7200.00),
	(7, 8, '2016-07-25', 19000.00),
	(8, 1, '2016-07-23', 36.00),
	(9, 5, '2016-07-21', 3180.00),
	(10, 14, '2016-07-21', 100.00);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;


-- Дамп структуры для таблица shop.order_item
CREATE TABLE IF NOT EXISTS `order_item` (
  `order_id` smallint(5) unsigned NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `quantity` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`order_id`,`product_id`),
  KEY `FK_order_item_product` (`product_id`),
  CONSTRAINT `FK_order_item_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_order_item_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`sku`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.order_item: ~17 rows (приблизительно)
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
INSERT INTO `order_item` (`order_id`, `product_id`, `quantity`) VALUES
	(1, '10', 4),
	(1, '2', 1),
	(1, '9', 2),
	(2, '9', 9),
	(3, '6', 3),
	(3, '9', 7),
	(4, '1', 1),
	(4, '3', 5),
	(5, '2', 1),
	(5, '3', 1),
	(5, '8', 5),
	(5, '9', 8),
	(6, '1', 3),
	(6, '2', 3),
	(6, '4', 5),
	(7, '1', 1),
	(7, '10', 8),
	(7, '8', 4),
	(9, '3', 6),
	(10, '2', 1);
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;


-- Дамп структуры для таблица shop.product
CREATE TABLE IF NOT EXISTS `product` (
  `sku` varchar(50) NOT NULL,
  `name` char(250) NOT NULL,
  `description` text NOT NULL,
  `img` char(100) NOT NULL,
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `total` smallint(6) unsigned NOT NULL,
  PRIMARY KEY (`sku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.product: ~9 rows (приблизительно)
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`sku`, `name`, `description`, `img`, `price`, `total`) VALUES
	('1', 'Casio COOL', 'Casio Super COOL', '1.jpg', 1000.00, 7),
	('10', 'Mkasa', 'volleybal', '10.jpg', 1500.00, 250),
	('2', 'Casio Simple', 'Casio Very Simple', '2.jpg', 100.00, 13),
	('3', 'CShock', 'CShock', '3.jpg', 530.00, 18),
	('4', 'Asus230', 'Notebook Asus230', '4.jpg', 780.00, 18),
	('5', 'ToshibaPr', 'projector', '5.jpg', 270.00, 7),
	('6', 'Panasonic', 'player111', '6.jpg', 34.00, 33),
	('7', 'Samsung', 'microwave', '7.jpg', 1234.00, 8),
	('8', 'iphone', 'tel', '8.jpg', 1500.00, 500),
	('9', 'dakin', 'conditioner', '9.jpg', 4000.00, 10);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;


-- Дамп структуры для таблица shop.role
CREATE TABLE IF NOT EXISTS `role` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.role: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` (`id`, `name`, `description`) VALUES
	(1, 'Admin', 'root'),
	(2, 'User Simple', '0%'),
	(3, 'User Advanced', '10%'),
	(4, 'User Super', '20%');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;


-- Дамп структуры для таблица shop.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'user id',
  `first_name` varchar(50) NOT NULL DEFAULT 'Test',
  `last_name` varchar(50) NOT NULL DEFAULT 'Test',
  `email` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `role_id` tinyint(3) unsigned NOT NULL DEFAULT '2',
  `skills` set('PHP','Java','CSS','Ruby','Javascript') DEFAULT 'CSS',
  PRIMARY KEY (`id`),
  UNIQUE KEY `e-mail` (`email`),
  KEY `FK_user_role` (`role_id`),
  CONSTRAINT `FK_user_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.user: ~31 rows (приблизительно)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `is_active`, `role_id`, `skills`) VALUES
	(1, 'Иван', 'Иванов', 'ivan@gmail.com', '123456', '1', 1, 'PHP,Javascript'),
	(2, 'Петр', 'Петров', 'petrow@gmail.com', 'qwerty', '1', 2, 'CSS,Ruby,Javascript'),
	(3, 'Сидор', 'Сидоров', 'sidorow@gmail.com', '1234567', '1', 2, 'CSS'),
	(4, 'Спиридон', 'Спиридонов', 'spiridon@gmail.com', '1234', '1', 2, 'PHP,CSS,Javascript'),
	(5, 'Vasily', 'Vasiliev', 'vasya@gmail.com', '123456', '0', 3, 'PHP'),
	(8, 'Andrew', 'Andreev', 'andrew@gmail.com', '123456', '0', 3, 'Ruby'),
	(12, 'Gregory', 'Gregoriev', 'gregory@gmail.com', '22222', '1', 2, 'CSS'),
	(13, 'Homa', 'Homov', 'homov@gmail.com', '33333', '1', 2, 'CSS'),
	(14, 'Foma', 'Fomov', 'fomov@gmail.com', '33336666', '1', 2, 'CSS'),
	(15, '', '', 'mila@gmail.com', '3ea9edc38460cf3616c480e6ae6d8c3c901b5c93', '1', 2, 'CSS'),
	(32, 'Test', 'Test', 'ludo@mail.ru', '8ad2a2ef47d70a7dc747a91fa637cc9536ffb599', '1', 2, 'CSS'),
	(33, 'Test', 'Test', 'new58@mail.ru', '27d64661148cc5cd7c55347957f7bd20056c324f', '1', 2, 'CSS'),
	(34, 'Test', 'Test', 'aosidfhs@sd.lk', '8ad2a2ef47d70a7dc747a91fa637cc9536ffb599', '1', 2, 'CSS'),
	(35, 'Test', 'Test', 'hgfds@sd.lk', '8ad2a2ef47d70a7dc747a91fa637cc9536ffb599', '1', 2, 'CSS'),
	(36, 'Test', 'Test', 'qqq@gmail.com', '7b21848ac9af35be0ddb2d6b9fc3851934db8420', '1', 2, 'CSS');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
