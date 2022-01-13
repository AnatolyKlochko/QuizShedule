-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 04 2019 г., 10:22
-- Версия сервера: 10.1.37-MariaDB
-- Версия PHP: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `moodle_...`
--
-- --------------------------------------------------------

-- NOTE: order has value
DROP TABLE IF EXISTS `mdl_quizschedule_columns`;
DROP TABLE IF EXISTS `mdl_quizschedule_columns_quizzes`;
DROP TABLE IF EXISTS `mdl_quizschedule_affiliatelist`;
DROP TABLE IF EXISTS `mdl_quizschedule_commissiontype`;
DROP TABLE IF EXISTS `mdl_quizschedule`;
DROP TABLE IF EXISTS `mdl_quizschedule_changes`;

--
-- Структура таблицы `mdl_quizschedule_columns`
--


CREATE TABLE IF NOT EXISTS `mdl_quizschedule_columns` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,    
  `key` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_uk` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_uk` tinytext COLLATE utf8mb4_unicode_ci,
  `order` tinyint(4) DEFAULT '0',
  `settings` tinytext COLLATE utf8mb4_unicode_ci,
  `has_quiz` tinyint(1) NOT NULL DEFAULT '0',
  `timecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Schedule Report columns description.' ROW_FORMAT=COMPRESSED;

INSERT INTO `mdl_quizschedule_columns` (`key`, `name_uk`, `desc_uk`, `order`, `settings`, `has_quiz`) VALUES
('numbering', 'Нумерація', NULL, 1, NULL, 0),
('affiliate', 'Підрозділ', NULL, 2, NULL, 0),
('employee_number', 'Табельний номер', NULL, 3, NULL, 0),
('fullname', 'ПІБ', NULL, 4, NULL, 0),
('position', 'Посада', NULL, 5, NULL, 0),
('group_of_electrical_safety', 'Група з ЕБ', NULL, 6, NULL, 0),
('occupational_health', 'ОП', 'Перевірка знань з охорони праці (правила безпеки, Інструкції з ОП і техніки безпеки)', 7, NULL, 1),
('technology_works', 'ТР', 'Перевірка знань з технології робіт (правила експлуатації, виробничі інструкції)', 8, NULL, 1),
('fire_safety_rules', 'ППБ', 'Перевірка знань правил пожежної безпеки', 9, NULL, 1),
('safe_operation_of_lifts', 'БПРП', 'Безпечне проведення робіт підйомниками', 10, NULL, 1),
('safe_operation_of_cranes', 'БПРК', 'Безпечне проведення робіт кранами', 11, NULL, 1),
('physical_examination', 'МО', 'Проходження медичного огляду', 12, NULL, 1),
('commission_type', 'Вид комісії', NULL, 13, NULL, 0),
('notes', 'Примітки', NULL, 14, NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `mdl_quizschedule_columns_quizzes`
--


CREATE TABLE IF NOT EXISTS `mdl_quizschedule_columns_quizzes` (
  `id` smallint NOT NULL AUTO_INCREMENT,
  `columnid` tinyint NOT NULL,
  `quizid` bigint NOT NULL,
  `timecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `mdl_quizschedule_columnid_quizid` (`columnid`,`quizid`),
  FOREIGN KEY (columnid) REFERENCES mdl_quizschedule_columns(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (quizid) REFERENCES mdl_quiz(id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Map of Schedule Report columns and quiz ids.' ROW_FORMAT=COMPRESSED;


--
-- Структура таблицы `mdl_quizschedule_affiliatelist`
--


CREATE TABLE IF NOT EXISTS `mdl_quizschedule_affiliatelist` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `key` char(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_uk` char(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Affiliate list from AD of Poltavaoblenergo.' ROW_FORMAT=COMPRESSED;

INSERT INTO `mdl_quizschedule_affiliatelist` (`key`, `name_uk`) VALUES
('at_poltavaoblenergo', 'АТ \"ПОЛТАВАОБЛЕНЕРГО\"'),
('veliko_kohnіvska_fіlіya', 'Велико-Кохнівська філія'),
('gadyacka_fіlіya', 'Гадяцька філія'),
('globinska_fіlіya', 'Глобинська філія'),
('grebіnkіvska_fіlіya', 'Гребінківська філія'),
('dikanska_fіlіya', 'Диканьська філія'),
('zіnkіvska_fіlіya', 'Зіньківська філія'),
('karlіvska_fіlіya', 'Карлівська філія'),
('kobelyacka_fіlіya', 'Кобеляцька філія'),
('kozelshhinska_fіlіya', 'Козельщинська філія'),
('komsomolska_fіlіya', 'Комсомольська філія'),
('kotelevska_fіlіya', 'Котелевська філія'),
('krasnogorіvska_fіlіya', 'Красногорівська філія'),
('kremenchucka_fіlіya', 'Кременчуцька філія'),
('lohvicka_fіlіya', 'Лохвицька філія'),
('lubenska_fіlіya', 'Лубенська філія'),
('mashіvska_fіlіya', 'Машівська філія'),
('mirgorodska_fіlіya', 'Миргородська філія'),
('novosanzharska_fіlіya', 'Новосанжарська філія'),
('orzhicka_fіlіya', 'Оржицька філія'),
('piryatinska_fіlіya', 'Пирятинська філія'),
('poltavska_fіlіya_mem', 'Полтавська філія МЕМ'),
('poltavskij_rajon_rem', 'Полтавський район РЕМ'),
('reshetilіvska_fіlіya', 'Решетилівська філія'),
('semenіvska_fіlіya', 'Семенівська філія'),
('khorolska_fіlіya', 'Хорольська філія'),
('chornuhinska_fіlіya', 'Чорнухинська філія'),
('chutіvska_fіlіya', 'Чутівська філія'),
('shishacka_fіlіya', 'Шишацька філія');

-- --------------------------------------------------------

--
-- Структура таблицы `mdl_quizschedule_commissiontype`
--


CREATE TABLE IF NOT EXISTS `mdl_quizschedule_commissiontype` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `key` varchar(46) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Commission Type.' ROW_FORMAT=COMPRESSED;

INSERT INTO `mdl_quizschedule_commissiontype` (`key`) VALUES
('general_commission'),
('production_structural_subdivisions_commission'),
('affiliate_commission');

-- --------------------------------------------------------

--
-- Структура таблицы `mdl_quiz_schedule`
--


CREATE TABLE IF NOT EXISTS `mdl_quizschedule` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `managerid` bigint NOT NULL,
  `employeeid` bigint NOT NULL,
  `quizid` bigint NOT NULL,
  `attemptid` bigint DEFAULT NULL,
  `commissiontypeid` tinyint DEFAULT NULL,
  `datequiz` date DEFAULT NULL,
  `datenextquiz` date NOT NULL,
  `timecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `mdl_quizschedule_employeeid_datenextquiz_quizid` (`employeeid`,`datenextquiz`,`quizid`),
  FOREIGN KEY (managerid) REFERENCES mdl_user(id) ON UPDATE CASCADE ON DELETE SET NULL,
  FOREIGN KEY (employeeid) REFERENCES mdl_user(id) ON UPDATE CASCADE ON DELETE SET NULL,
  FOREIGN KEY (quizid) REFERENCES mdl_quiz(id) ON UPDATE CASCADE ON DELETE SET NULL,
  FOREIGN KEY (attemptid) REFERENCES mdl_quiz_attempts(id) ON UPDATE CASCADE ON DELETE SET NULL,
  FOREIGN KEY (commissiontypeid) REFERENCES mdl_quizschedule_commissiontype(id) ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Information about quiz schedule.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Структура таблицы `mdl_quizschedule_changes`
--
CREATE TABLE IF NOT EXISTS `mdl_quizschedule_changes` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `managerid` bigint NOT NULL,
  `quizscheduleid` bigint NOT NULL,
  `datenextquiz` date NOT NULL COMMENT 'Old value of next date of quiz. Current value is at quizschedule table.',
  `timecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `mdl_quizschedule_quizscheduleid_datenextquiz` (`quizscheduleid`,`datenextquiz`),
  FOREIGN KEY (managerid) REFERENCES mdl_user(id) ON UPDATE CASCADE ON DELETE SET NULL,
  FOREIGN KEY (quizscheduleid) REFERENCES mdl_quizschedule(id) ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Information about changes of quiz schedule.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;