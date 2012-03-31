-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 20. Mrz 2012 um 17:58
-- Server Version: 5.5.16
-- PHP-Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `comments`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `topicID` int(11) NOT NULL,
  `userName` varchar(20) DEFAULT NULL,
  `commentDate` datetime NOT NULL,
  `commentText` varchar(500) NOT NULL,
  PRIMARY KEY (`commentID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `comment`
--

INSERT INTO `comment` (`commentID`, `topicID`, `userName`, `commentDate`, `commentText`) VALUES
(1, 1, 'Mr. Pencil', '2012-03-18 01:12:20', 'I wouldn''t like it to see such a picture every time I smoke.'),
(2, 1, 'Hans', '2012-03-18 10:54:07', 'When did you make this picture?'),
(3, 3, 'Anonymus', '2012-03-19 18:14:47', ':('),
(4, 3, 'Fotograph', '2012-03-19 19:20:20', 'Das war in GroÃŸbritannien. In Deutschland findet man sowas nicht. ;)'),
(5, 2, 'Hans', '2012-03-19 19:21:28', 'Da kann man doch noch was daraus machen.'),
(6, 1, 'Admin', '2012-03-19 19:23:51', 'It was 2009 so not that old.\r\nI don''t know when they start to print such pictures.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `topicID` int(11) NOT NULL AUTO_INCREMENT,
  `topicName` varchar(30) NOT NULL,
  `topicContent` varchar(100) NOT NULL,
  PRIMARY KEY (`topicID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `topic`
--

INSERT INTO `topic` (`topicID`, `topicName`, `topicContent`) VALUES
(1, 'Smokers Die Younger', 'http://localhost/BComment/public/_files/images/IMG_2972.jpg'),
(2, 'Deserted Church', 'http://localhost/BComment/public/_files/images/IMG_2776.jpg'),
(3, 'Litter', 'http://localhost/BComment/public/_files/images/IMG_2821.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
