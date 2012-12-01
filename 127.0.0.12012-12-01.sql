-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 01 2012 г., 23:50
-- Версия сервера: 5.1.65-community-log
-- Версия PHP: 5.3.18

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `syst_konrl`
--
CREATE DATABASE `syst_konrl` DEFAULT CHARACTER SET cp1251 COLLATE cp1251_general_ci;
USE `syst_konrl`;

-- --------------------------------------------------------

--
-- Структура таблицы `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Question_owner` int(10) NOT NULL,
  `Content` varchar(255) NOT NULL,
  `correct` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `Id` int(3) NOT NULL AUTO_INCREMENT,
  `Name` char(20) NOT NULL,
  `Supervisor` char(30) DEFAULT NULL,
  `Department` char(30) DEFAULT NULL,
  `Comment` text,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `Name` (`Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Test_owner` int(10) NOT NULL,
  `Content` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Test_owner` (`Test_owner`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `Name` int(20) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tests`
--

CREATE TABLE IF NOT EXISTS `tests` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(80) NOT NULL,
  `Subject` int(3) NOT NULL,
  `Questions_amount` int(2) NOT NULL,
  `Cor_ans_amount` int(2) NOT NULL,
  `Comment` text,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `ID_4` (`ID`),
  KEY `ID_2` (`ID`),
  KEY `ID_3` (`ID`),
  KEY `Subject` (`Subject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `trials`
--

CREATE TABLE IF NOT EXISTS `trials` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `User_id` int(3) unsigned NOT NULL,
  `Test_id` int(10) unsigned NOT NULL,
  `Date_start` date NOT NULL,
  `Date_end` date NOT NULL,
  `Passed` tinyint(1) DEFAULT NULL,
  `Failed` tinyint(1) DEFAULT NULL,
  `Qestions_amount` int(2) unsigned NOT NULL,
  `Cor_ans_amount` int(2) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(60) NOT NULL,
  `Login` char(20) NOT NULL,
  `Password` char(100) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `E-mail` char(50) DEFAULT NULL,
  `Group` int(3) NOT NULL,
  `Admin` tinyint(1) DEFAULT NULL,
  `Simple_user` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `Login` (`Login`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_3` FOREIGN KEY (`ID`) REFERENCES `tests` (`Subject`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
