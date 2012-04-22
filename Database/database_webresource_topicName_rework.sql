-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 22. Apr 2012 um 18:39
-- Server Version: 5.5.16
-- PHP-Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `webressourcen`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `topicID` int(11) NOT NULL,
  `uderName` varchar(20) NOT NULL,
  `commentDate` datetime NOT NULL,
  `commentText` varchar(500) NOT NULL,
  PRIMARY KEY (`commentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `friend`
--

CREATE TABLE IF NOT EXISTS `friend` (
  `userID` int(11) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `job` varchar(30) NOT NULL,
  `adress` int(50) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `master`
--

CREATE TABLE IF NOT EXISTS `master` (
  `userID` int(11) NOT NULL,
  `password` char(32) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `topicID` int(11) NOT NULL,
  `topicContent` longtext NOT NULL,
  `topicVersion` int(11) NOT NULL DEFAULT '1',
  `topicSource` varchar(100) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`topicID`,`topicVersion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `topic`
--

INSERT INTO `topic` (`topicID`, `topicContent`, `topicVersion`, `topicSource`, `creationDate`) VALUES
(10, 'Hallo, ich bin der Klaus!<br />\r\n<br />\r\nmfg<br />\r\nKlaus', 1, 'klÃ¤uschen', '2012-04-21 17:16:48'),
(10, 'Hallo, ich bin der Klaus!', 2, 'klÃ¤uschen', '2012-04-21 17:56:17'),
(11, 'Kot Kot Kot', 1, 'after', '2012-04-21 17:58:43'),
(11, 'Kot Kot Kot Kot Kot 5', 3, 'after', '2012-04-21 18:23:56'),
(11, 'Kot Kot Kot Kot Kot 4. Version mÃ¼sste das jetzt sein', 4, '4. version test', '2012-04-21 18:26:11');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `topicname`
--

CREATE TABLE IF NOT EXISTS `topicname` (
  `topicID` int(11) NOT NULL AUTO_INCREMENT,
  `topicName` varchar(20) NOT NULL,
  PRIMARY KEY (`topicID`),
  UNIQUE KEY `topicName` (`topicName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Daten für Tabelle `topicname`
--

INSERT INTO `topicname` (`topicID`, `topicName`) VALUES
(11, 'Kot'),
(10, 'Text');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(20) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_topic`
--

CREATE TABLE IF NOT EXISTS `user_topic` (
  `userID` int(11) NOT NULL,
  `topicID` int(11) NOT NULL,
  `hash` char(32) NOT NULL,
  PRIMARY KEY (`userID`,`topicID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
