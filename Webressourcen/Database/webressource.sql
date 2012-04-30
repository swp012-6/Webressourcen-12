-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 30. Apr 2012 um 11:34
-- Server Version: 5.5.16
-- PHP-Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `webressource`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `topicID` int(11) NOT NULL,
  `topicVersion` int(11) NOT NULL,
  `anonymous` tinyint(1) NOT NULL,
  `commentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `commentText` varchar(500) NOT NULL,
  PRIMARY KEY (`commentID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Daten für Tabelle `comment`
--

INSERT INTO `comment` (`commentID`, `userID`, `topicID`, `topicVersion`, `anonymous`, `commentDate`, `commentText`) VALUES
(1, 2, 1, 1, 0, '2012-04-22 17:54:00', 'das ist der erste kommentar'),
(2, 2, 1, 1, 0, '2012-04-22 19:00:00', 'das ist der 2. kommentar'),
(4, 2, 1, 1, 0, '2012-04-25 22:00:00', 'asdasdasdasdasd'),
(5, 2, 1, 1, 0, '2012-04-25 22:00:00', 'adasdasdasd'),
(6, 2, 1, 1, 0, '2012-04-25 22:00:00', 'adasdefesvsevsevev'),
(7, 1, 1, 1, 0, '2012-04-29 22:00:00', 'cfcctcrczrcrcz'),
(8, 1, 1, 1, 0, '2012-04-30 04:00:00', 'uzguzguztzftzfztf'),
(9, 1, 1, 1, 0, '2012-04-30 22:00:00', '4,2'),
(10, 2, 1, 1, 0, '2012-03-01 23:00:00', '4,3'),
(11, 2, 1, 2, 1, '2012-04-28 19:57:56', 'Das ist mein erster Kommentar im Creater'),
(12, 2, 1, 2, 0, '2012-04-28 19:58:29', 'das ist mein 2. kommentar XD'),
(13, 2, 1, 1, 1, '2012-04-28 20:00:38', 'das ist mein 1. kommentare im creator, version 1'),
(14, 2, 1, 1, 0, '2012-04-29 18:53:37', 'sdfsijfiosdjfoisjfoijsdiofjdsio'),
(15, 2, 1, 1, 1, '2012-04-29 18:59:15', 'das ist der neue kommentar\r\n');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `master`
--

CREATE TABLE IF NOT EXISTS `master` (
  `userID` int(11) NOT NULL,
  `userName` varchar(30) NOT NULL,
  `password` char(32) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `topicID` int(11) NOT NULL AUTO_INCREMENT,
  `topicName` varchar(30) NOT NULL,
  PRIMARY KEY (`topicID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `topic`
--

INSERT INTO `topic` (`topicID`, `topicName`) VALUES
(1, 'Thema1'),
(2, 'Thema2');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `topicadditive`
--

CREATE TABLE IF NOT EXISTS `topicadditive` (
  `topicID` int(11) NOT NULL,
  `topicVersion` int(11) NOT NULL DEFAULT '1',
  `topicContent` longtext NOT NULL,
  `topicSource` varchar(100) NOT NULL,
  `topicRating` double NOT NULL,
  `topicRatingMax` int(11) NOT NULL,
  PRIMARY KEY (`topicID`,`topicVersion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `topicadditive`
--

INSERT INTO `topicadditive` (`topicID`, `topicVersion`, `topicContent`, `topicSource`, `topicRating`, `topicRatingMax`) VALUES
(1, 1, 'was auch immer', 'ist mir egal', 3, 5),
(1, 2, 'neuer', 'acuh neu', 4, 5);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `job` varchar(30) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `usertopic`
--

CREATE TABLE IF NOT EXISTS `usertopic` (
  `userID` int(11) NOT NULL,
  `topicID` int(11) NOT NULL,
  `userName` varchar(20) NOT NULL,
  `hash` char(32) NOT NULL,
  PRIMARY KEY (`userID`,`topicID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `usertopic`
--

INSERT INTO `usertopic` (`userID`, `topicID`, `userName`, `hash`) VALUES
(1, 1, 'master', 'blablabla'),
(2, 1, 'der 1. freund', 'asjdnoasndoasndo');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
