-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 13. Mai 2012 um 18:15
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Daten für Tabelle `comment`
--

INSERT INTO `comment` (`commentID`, `userID`, `topicID`, `topicVersion`, `anonymous`, `commentDate`, `commentText`) VALUES
(16, 2, 1, 1, 1, '2012-04-30 13:39:01', '1.Kommentar'),
(18, 2, 1, 1, 0, '2012-04-30 13:39:25', '3.Kommentar'),
(22, 2, 1, 2, 0, '2012-05-04 07:42:54', 'das ist der 1. Kommentar zur 2.Version'),
(24, 2, 1, 6, 0, '2012-05-05 14:50:43', 'das ist mein erster kommentar zum aktuellsten version, version 6'),
(25, 2, 1, 1, 0, '2012-05-11 09:24:45', 'hallo\r\n'),
(26, 2, 1, 1, 1, '2012-05-11 09:24:59', 'hallo2'),
(27, 2, 1, 1, 0, '2012-05-11 09:25:11', 'hallo2w2w2'),
(28, 2, 1, 1, 0, '2012-05-11 09:25:46', 'huhidhcsiudchdiushv'),
(29, 2, 1, 1, 0, '2012-05-11 09:49:25', '</br>\r\n<p> hallo </p>\r\n'),
(30, 2, 1, 5, 0, '2012-05-11 17:22:37', 'ich bin stolz auf dich hase <3'),
(32, 2, 1, 1, 1, '2012-05-13 12:23:47', 'jvgv'),
(33, 2, 1, 1, 0, '2012-05-13 12:27:15', 'vzuvv'),
(34, 2, 1, 1, 1, '2012-05-13 12:27:29', 'jhvjvhvjhvhjj'),
(35, 6, 1, 6, 0, '2012-05-13 14:56:21', 'hallo'),
(36, 6, 1, 6, 1, '2012-05-13 14:59:03', 'fdd');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `topic`
--

INSERT INTO `topic` (`topicID`, `topicName`) VALUES
(1, 'Thema1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `topicadditive`
--

CREATE TABLE IF NOT EXISTS `topicadditive` (
  `topicID` int(11) NOT NULL,
  `topicVersion` int(11) NOT NULL DEFAULT '1',
  `topicContent` longtext NOT NULL,
  `topicSource` varchar(100) NOT NULL,
  `topicType` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`topicID`,`topicVersion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `topicadditive`
--

INSERT INTO `topicadditive` (`topicID`, `topicVersion`, `topicContent`, `topicSource`, `topicType`) VALUES
(1, 1, 'was auch immer', 'ist mir egal', 0),
(1, 2, 'neuer', 'acuh neu', 0),
(1, 3, '', '', 0),
(1, 4, '', '', 0),
(1, 5, 'huzuzguguzg', 'ouuiuhiuhi', 0),
(1, 6, 'njnjnk', 'hjbhjb', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `topicrating`
--

CREATE TABLE IF NOT EXISTS `topicrating` (
  `topicID` int(11) NOT NULL,
  `topicVersion` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  PRIMARY KEY (`topicID`,`topicVersion`,`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `topicrating`
--

INSERT INTO `topicrating` (`topicID`, `topicVersion`, `userID`, `rating`) VALUES
(1, 1, 2, 2),
(1, 1, 3, NULL),
(1, 2, 2, 1),
(1, 3, 2, 5),
(1, 4, 2, 1),
(1, 5, 2, 1),
(1, 6, 2, 5);

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
  PRIMARY KEY (`userID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`userID`, `first_name`, `last_name`, `email`, `job`, `adresse`) VALUES
(5, '', '', 'sfsfsa', '', ''),
(6, 'Christoph', 'Beger', 'chrib@hotmail.de', 'Student', 'RussenstraÃŸe');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `usertopic`
--

CREATE TABLE IF NOT EXISTS `usertopic` (
  `userID` int(11) NOT NULL,
  `topicID` int(11) NOT NULL,
  `userName` varchar(20) NOT NULL,
  `master` tinyint(1) NOT NULL,
  `hash` char(32) NOT NULL,
  PRIMARY KEY (`userID`,`topicID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
