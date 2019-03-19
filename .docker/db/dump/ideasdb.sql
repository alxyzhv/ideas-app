CREATE DATABASE IF NOT EXISTS `dbideas` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `dbideas`;

CREATE TABLE IF NOT EXISTS `ideas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `text` text DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `dislikes` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
