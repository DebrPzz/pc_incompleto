-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `interventi`;
CREATE TABLE `interventi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pc_id` int(11) NOT NULL,
  `dataintervento` date NOT NULL,
  `descrizione` longtext COLLATE utf8_bin NOT NULL,
  `spesa` int(11) NOT NULL,
  `ore` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pc_id` (`pc_id`),
  CONSTRAINT `interventi_ibfk_3` FOREIGN KEY (`pc_id`) REFERENCES `pc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `interventi` (`id`, `pc_id`, `dataintervento`, `descrizione`, `spesa`, `ore`) VALUES
(7,	6,	'2017-02-05',	'Pulizia malware',	12,	'12:00:00'),
(8,	7,	'2017-02-03',	'Formattazione sistema operativo',	18,	'00:00:15'),
(9,	8,	'2017-02-04',	'Sistema operativo ripulito e configurato',	34,	'24:00:00'),
(10,	10,	'2017-02-02',	'Pulizia hardware',	15,	'15:00:00'),
(11,	9,	'2017-02-03',	'Cambio batteria',	13,	'13:00:00');

DROP VIEW IF EXISTS `listainterventi`;
CREATE TABLE `listainterventi` (`id` int(11), `dataintervento` date, `descrizione` longtext, `spesa` int(11), `ore` time, `marche_id` int(11), `marca` varchar(30), `pc_id` int(11), `hostname` varchar(30), `modello` varchar(30), `sn` int(11));


DROP TABLE IF EXISTS `marche`;
CREATE TABLE `marche` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marca` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `marche` (`id`, `marca`) VALUES
(1,	'Asus'),
(2,	'Apple'),
(3,	'Sony'),
(4,	'HP'),
(5,	'Acer');

DROP TABLE IF EXISTS `pc`;
CREATE TABLE `pc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostname` varchar(30) NOT NULL,
  `marche_id` int(11) NOT NULL,
  `modello` varchar(30) NOT NULL,
  `sn` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `marche_id` (`marche_id`),
  CONSTRAINT `pc_ibfk_2` FOREIGN KEY (`marche_id`) REFERENCES `marche` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `pc` (`id`, `hostname`, `marche_id`, `modello`, `sn`) VALUES
(6,	'Riccio',	1,	'5.0',	1234),
(7,	'Pavone',	2,	'3.1',	5243),
(8,	'Giraffa',	3,	'2.2',	6788),
(9,	'Bisonte',	4,	'3.3',	9786),
(10,	'Dronedario',	5,	'9.0',	5555);

DROP TABLE IF EXISTS `listainterventi`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `listainterventi` AS select `interventi`.`id` AS `id`,`interventi`.`dataintervento` AS `dataintervento`,`interventi`.`descrizione` AS `descrizione`,`interventi`.`spesa` AS `spesa`,`interventi`.`ore` AS `ore`,`pc`.`marche_id` AS `marche_id`,`marche`.`marca` AS `marca`,`interventi`.`pc_id` AS `pc_id`,`pc`.`hostname` AS `hostname`,`pc`.`modello` AS `modello`,`pc`.`sn` AS `sn` from ((`interventi` left join `pc` on((`interventi`.`pc_id` = `pc`.`id`))) left join `marche` on((`pc`.`marche_id` = `marche`.`id`)));

-- 2017-03-01 11:03:12
