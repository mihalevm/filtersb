-- --------------------------------------------------------
-- Хост:                         37.230.112.85
-- Версия сервера:               5.5.65-MariaDB - MariaDB Server
-- Операционная система:         Linux
-- HeidiSQL Версия:              11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных filtersb
DROP DATABASE IF EXISTS `filtersb`;
CREATE DATABASE IF NOT EXISTS `filtersb` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `filtersb`;

-- Дамп структуры для таблица filtersb.config
DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор системы',
  `key` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Название ключа',
  `val` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Значение ключа',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Настройки ситемы';

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица filtersb.dcoments
DROP TABLE IF EXISTS `dcoments`;
CREATE TABLE IF NOT EXISTS `dcoments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор',
  `did` int(10) unsigned NOT NULL COMMENT 'Идентификатор водителя',
  `rait` int(11) NOT NULL DEFAULT '0' COMMENT 'Оценка коментария',
  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата добавления',
  `coment` mediumtext COLLATE utf8_unicode_ci COMMENT 'Коментарий',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Коментарии по водителям';

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица filtersb.dic_tachograph
DROP TABLE IF EXISTS `dic_tachograph`;
CREATE TABLE IF NOT EXISTS `dic_tachograph` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Типы карт тахографов';

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица filtersb.dic_trailertype
DROP TABLE IF EXISTS `dic_trailertype`;
CREATE TABLE IF NOT EXISTS `dic_trailertype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Типы трейлеров';

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица filtersb.reports
DROP TABLE IF EXISTS `reports`;
CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор отчета',
  `did` int(10) unsigned DEFAULT NULL COMMENT 'Идентификатор водителя',
  `oid` int(10) unsigned DEFAULT NULL COMMENT 'Идентификатор транспортной компании',
  `cdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата и время создания',
  `payed` char(1) COLLATE utf8_unicode_ci DEFAULT 'N' COMMENT 'Признак оплаты',
  `egrul` text COLLATE utf8_unicode_ci COMMENT 'Данные из ЕГРЮЛ',
  `fssp` longtext COLLATE utf8_unicode_ci COMMENT 'Данные из ФССП',
  `passport` longtext COLLATE utf8_unicode_ci COMMENT 'Данные из МВД',
  `gibdd` longtext COLLATE utf8_unicode_ci COMMENT 'Данные из ГИБДД',
  `scorista` longtext COLLATE utf8_unicode_ci COMMENT 'Данные из Скористы',
  `payid` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Идентификатор платежа',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Таблица созданных отчетов';

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица filtersb.scorista
DROP TABLE IF EXISTS `scorista`;
CREATE TABLE IF NOT EXISTS `scorista` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор запроса',
  `oid` int(10) unsigned DEFAULT NULL COMMENT 'Идентификатор пользователя инициатора запроса',
  `rid` int(10) unsigned DEFAULT NULL COMMENT 'Идентификатор отчета',
  `rdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата и время выполнения запроса',
  `scrid` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Идентификатор запроса удаленной стороны',
  `status` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Статус запроса',
  `message` text COLLATE utf8_unicode_ci COMMENT 'Результат выполнения запроса',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Статус запросов в систему сбора данных Скориста';

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица filtersb.tcdrivers
DROP TABLE IF EXISTS `tcdrivers`;
CREATE TABLE IF NOT EXISTS `tcdrivers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `did` int(10) unsigned NOT NULL,
  `tid` int(10) unsigned NOT NULL,
  `reqby` char(1) CHARACTER SET latin1 NOT NULL DEFAULT 'T',
  `rdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `disabled` char(1) CHARACTER SET latin1 NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Таблица запросов ТК по водителям';

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица filtersb.userinfo
DROP TABLE IF EXISTS `userinfo`;
CREATE TABLE IF NOT EXISTS `userinfo` (
  `id` int(11) DEFAULT NULL COMMENT 'Уникальный идентификатор пользователя',
  `firstname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Имя',
  `secondname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Фамилия',
  `middlename` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Отчество',
  `companyname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Название компании',
  `birthday` date DEFAULT NULL COMMENT 'День рождения',
  `sex` tinyint(3) unsigned DEFAULT '1' COMMENT 'Пол 0-ж,1-м',
  `pserial` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Серия паспорта',
  `pnumber` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Номер паспорта',
  `pdate` date DEFAULT NULL COMMENT 'Дата выдачи паспорта',
  `inn` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Инн',
  `dserial` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Серия водительского',
  `dnumber` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Номер водительского',
  `ddate` date DEFAULT NULL COMMENT 'Дата выдачи водительского удостоверения',
  `raddress` text COLLATE utf8_unicode_ci COMMENT 'Адрес регистрации',
  `laddress` text COLLATE utf8_unicode_ci COMMENT 'Адрес проживания',
  `personalphone` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Телефон водителя',
  `relphones` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Телефоны родственников',
  `familystatus` char(1) COLLATE utf8_unicode_ci DEFAULT 'N' COMMENT 'Наличие семьи',
  `childs` text COLLATE utf8_unicode_ci COMMENT 'Дети, возрвст и пол',
  `e_experience` int(11) DEFAULT NULL COMMENT 'Стаж вождения по категории Е',
  `c_experience` int(11) DEFAULT NULL COMMENT 'Стаж вождения по категории С',
  `tachograph` text COLLATE utf8_unicode_ci COMMENT 'Карта тахографа',
  `transporttype` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Опыт вождения транспортных средств',
  `companyset` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Список предпочитаемых компаний для трудоустройства',
  `trailertype` text COLLATE utf8_unicode_ci COMMENT 'Опыт вождения прицепов',
  `fpassdate` date DEFAULT NULL COMMENT 'Дата окончания загранпаспорта',
  `medbook` char(1) COLLATE utf8_unicode_ci DEFAULT 'N' COMMENT 'Наличие медкнижки',
  `startdate` date DEFAULT NULL COMMENT 'Дата начала работы',
  `experience` longtext COLLATE utf8_unicode_ci COMMENT 'Описание предыдущих мест работы',
  `companys` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Желаемые организации',
  `agreefamily` char(1) COLLATE utf8_unicode_ci DEFAULT 'N' COMMENT 'Одобрение семьи',
  `agreepersdata` char(1) COLLATE utf8_unicode_ci DEFAULT 'N' COMMENT 'Одобрение на обработку перс данных',
  `agreecomment` char(1) COLLATE utf8_unicode_ci DEFAULT 'Y' COMMENT 'Одобрение для коментирования водитея тк',
  `agreecheck` char(1) COLLATE utf8_unicode_ci DEFAULT 'N' COMMENT 'Одобрение на проверку третьей стороной'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Данные пользователя';

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица filtersb.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Uniq user id',
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'User login',
  `password` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'User password',
  `inn` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'TC inn',
  `authKey` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accessToken` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `utype` char(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'User type. D driver, C tcompany',
  `confirm` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Confirm hash',
  `active` char(1) COLLATE utf8_unicode_ci DEFAULT 'N',
  `rdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Register date',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Аккаунты пользователей';

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица filtersb.workplace
DROP TABLE IF EXISTS `workplace`;
CREATE TABLE IF NOT EXISTS `workplace` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор',
  `did` int(10) unsigned DEFAULT NULL COMMENT 'Идентификатор водителя',
  `sdate` date DEFAULT NULL COMMENT 'Дата трудоустройства',
  `edate` date DEFAULT NULL COMMENT 'Дата увольнения',
  `company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Название компании',
  `post` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Должность',
  `action` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Выполняемые функции',
  `dismissal` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Причина увольнения',
  `guarantor` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Рекомендации',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Описание предыдущих мест работ';

-- Экспортируемые данные не выделены.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
