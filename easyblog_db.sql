-- Adminer 4.2.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `content` text COLLATE utf8_czech_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `article` (`id`, `title`, `content`, `url`, `created_at`) VALUES
(1,	'Žalobkyně Jana Schröderová',	'Žalobkyně Jana Schröderová uvedla, že je podle ní prokázáno, že Půček jel opilý, od nehody utekl a zajímal se hlavně o sebe. Muže označila za sociálního negramota. Podle ní není pro Půčka jediná polehčující okolnost.\n\nZa zabití z nedbalosti Půčkovi hrozil trest ve výši dva až osm let. Při vyšetřování na něj soud uvalil vazbu, protože se obával jeho útěku.',	'novy-blog',	'2015-02-27 10:53:04'),
(2,	'Za Babišem stojí dlouhá fronta zájemců o místa ve vedení ANO',	'„O předsednictvo bude velká rvačka,“ předpověděl Babiš. Na post prvního místopředsedy je oficiálně navrženo pět lidí. Největší šance má šéf poslanců ANO a Babišův dlouholetý spolupracovník v Agrofertu Jaroslav Faltýnek. Posbíral celkem osm nominací.\r\n\r\nZájem kandidovat proti němu projevily čtyři ženy. Celkem 13 uchazečů je o další maximálně čtyři křesla místopředsedů a 18 nominací daly kraje na další místa v předsednictvu.',	'za-babisem-stoji-fronta',	'2015-02-27 10:53:24');

DROP TABLE IF EXISTS `article_in_category`;
CREATE TABLE `article_in_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `article_id` (`article_id`),
  CONSTRAINT `article_in_category_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `article_in_category_ibfk_4` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `article_in_category` (`id`, `category_id`, `article_id`) VALUES
(1,	1,	1);

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `category` (`id`, `title`, `url`, `created_at`) VALUES
(1,	'Politika',	'politika',	'2015-03-03 20:44:26'),
(2,	'Programování',	'programovani',	'2015-03-03 20:44:48');

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text COLLATE utf8_czech_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `article_id` (`article_id`),
  CONSTRAINT `comment_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `comment_ibfk_5` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `comment` (`id`, `article_id`, `user_id`, `message`, `created_at`) VALUES
(1,	1,	1,	'Super článek, vole.',	'2015-03-03 18:08:17'),
(4,	1,	3,	'No :) tak to funguje',	'2015-03-03 18:54:45'),
(6,	2,	3,	'toto je test :)',	'2015-03-06 20:57:51'),
(7,	2,	1,	'no',	'2015-03-08 21:53:44'),
(10,	2,	1,	'Ahoj',	'2015-03-08 21:54:47');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_czech_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `user` (`id`, `username`, `password`, `role`) VALUES
(1,	'admin',	'$2y$10$pEMUJ/.qM1at5aoAF2eM9uKpUsa6Tz7QAXTHJ.jGas0Hkos0B6q8q',	'admin'),
(3,	'test',	'$2y$10$lIox6HOHXM1zUemmG9h05uIcK3Y1GkXStnq4Wy6ZPnLd6UE/v0uMu',	'user');

-- 2015-09-22 19:15:43
