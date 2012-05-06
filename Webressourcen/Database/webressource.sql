-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 06. Mai 2012 um 23:24
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

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
(15, 2, 1, 1, 1, '2012-04-29 18:59:15', 'das ist der neue kommentar\r\n'),
(16, 1, 1, 3, 1, '2012-05-06 21:24:06', 'test');

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
  `topicRating` double NOT NULL,
  `topicRatingMax` int(11) NOT NULL,
  `topicType` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`topicID`,`topicVersion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `topicadditive`
--

INSERT INTO `topicadditive` (`topicID`, `topicVersion`, `topicContent`, `topicSource`, `topicRating`, `topicRatingMax`, `topicType`) VALUES
(1, 1, 'was auch immer', 'ist mir egal', 3, 5, 0),
(1, 2, 'neuer', 'acuh neu', 4, 5, 0),
(1, 3, '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\n<html lang="de" dir="ltr" class="client-nojs" xmlns="http://www.w3.org/1999/xhtml">\n<head>\n<title>Hallo â€“ Wikipedia</title>\n<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />\n<meta http-equiv="Content-Style-Type" content="text/css" />\n<meta name="generator" content="MediaWiki 1.20wmf1" />\n<link rel="alternate" type="application/x-wiki" title="Seite bearbeiten" href="/w/index.php?title=Hallo&amp;action=edit" />\n<link rel="edit" title="Seite bearbeiten" href="/w/index.php?title=Hallo&amp;action=edit" />\n<link rel="apple-touch-icon" href="//de.wikipedia.org/apple-touch-icon.png" />\n<link rel="shortcut icon" href="/favicon.ico" />\n<link rel="search" type="application/opensearchdescription+xml" href="/w/opensearch_desc.php" title="Wikipedia (de)" />\n<link rel="EditURI" type="application/rsd+xml" href="//de.wikipedia.org/w/api.php?action=rsd" />\n<link rel="copyright" href="//creativecommons.org/licenses/by-sa/3.0/" />\n<link rel="alternate" type="application/atom+xml" title="Atom-Feed fÃ¼r â€žWikipediaâ€œ" href="/w/index.php?title=Spezial:Letzte_%C3%84nderungen&amp;feed=atom" />\n<link rel="stylesheet" href="//bits.wikimedia.org/de.wikipedia.org/load.php?debug=false&amp;lang=de&amp;modules=ext.flaggedRevs.basic%7Cext.gadget.old-movepage%7Cext.wikihiero%7Cmediawiki.legacy.commonPrint%2Cshared%7Cskins.vector&amp;only=styles&amp;skin=vector&amp;*" type="text/css" media="all" />\n<meta name="ResourceLoaderDynamicStyles" content="" />\n<link rel="stylesheet" href="//bits.wikimedia.org/de.wikipedia.org/load.php?debug=false&amp;lang=de&amp;modules=site&amp;only=styles&amp;skin=vector&amp;*" type="text/css" media="all" />\n<style type="text/css" media="all">a:lang(ar),a:lang(ckb),a:lang(fa),a:lang(kk-arab),a:lang(mzn),a:lang(ps),a:lang(ur){text-decoration:none}\n\n/* cache key: dewiki:resourceloader:filter:minify-css:7:d5a1bf6cbd05fc6cc2705e47f52062dc */</style>\n\n\n\n\n<!--[if lt IE 7]><style type="text/css">body{behavior:url("/w/skins-1.20wmf1/vector/csshover.min.htc")}</style><![endif]--></head>\n<body class="mediawiki ltr sitedir-ltr capitalize-all-nouns ns-0 ns-subject page-Hallo skin-vector action-view">\n		<div id="mw-page-base" class="noprint"></div>\n		<div id="mw-head-base" class="noprint"></div>\n		<!-- content -->\n		<div id="content" class="mw-body">\n			</a>\n			<div id="mw-js-message" style="display:none;"></div>\n						<!-- sitenotice -->\n			<div id="siteNotice"><!-- centralNotice loads here --></div>\n			<!-- /sitenotice -->\n						<!-- firstHeading -->\n			<h1 id="firstHeading" class="firstHeading">\n				<span dir="auto">Hallo</span>\n			</h1>\n			<!-- /firstHeading -->\n			<!-- bodyContent -->\n			<div id="bodyContent">\n								<!-- tagline -->\n				<div id="siteSub">aus Wikipedia, der freien EnzyklopÃ¤die</div>\n				<!-- /tagline -->\n								<!-- subtitle -->\n				<div id="contentSub"></div>\n				<!-- /subtitle -->\n																<!-- jumpto -->\n				<div id="jump-to-nav" class="mw-jump">\n					Wechseln zu: Navigation</a>,\n					Suche</a>\n				</div>\n				<!-- /jumpto -->\n								<!-- bodycontent -->\n				<div id="mw-content-text" lang="de" dir="ltr" class="mw-content-ltr"><table id="Vorlage_Dieser_Artikel" cellspacing="8" cellpadding="0" class="hintergrundfarbe1 rahmenfarbe1 noprint" style="width: 100%; font-size: 95%; border-bottom-style: solid; border-bottom-width: 1px; margin-bottom: 1em; position: relative; clear: right;">\n<tr>\n<td style="width: 26px; vertical-align: middle" id="bksicon"><img alt="" src="//upload.wikimedia.org/wikipedia/commons/thumb/e/ea/Disambig-dark.svg/25px-Disambig-dark.svg.png" width="25" height="19" /></td>\n<td style="vertical-align: middle">Dieser Artikel behandelt den GruÃŸ. Zum US-amerikanischen Altorientalisten siehe William W. Hallo</a>.</td>\n</tr>\n</table>\n<p><b>Hallo</b> ist im Deutschen ein mÃ¼ndlicher oder schriftlicher, nicht fÃ¶rmlicher GruÃŸ</a>, insbesondere unter guten Bekannten oder Freunden. Der Ausdruck wird auch als Anruf (als eine Interjektion</a>), mit der jemand auf sich aufmerksam machen mÃ¶chte, genutzt: <i>â€žHallo, ist da jemand?â€œ</i> Eine weitere Interjektion</a> â€“&#160;â€žAber hallo!â€œ&#160;â€“ hat in etwa die Bedeutung â€žDa hast du sowas von Recht!â€œ. Seit mehreren Jahren vermehrt aufgekommen ist der Gebrauch als Frage â€žHallo?â€œ mit der Betonung auf der zweiten, lang gesprochenen Silbe, um jemanden zur Besinnung zu rufen.</p>\n<p>Wesentlich fÃ¼r die jeweilige Bedeutung ist die gewÃ¤hlte Betonung, Mimik und Gestik des Sprechenden.</p>\n<p>Von dem Ausruf leitet sich die substantivierte</a>, im Gegensatz zu den anderen Formen auf der zweiten Silbe betonte Form â€žein Halloâ€œ ab, die ein (frÃ¶hliches) lÃ¤rmendes Durcheinander bezeichnet (<i>â€žEr wurde mit groÃŸem Hallo empfangen.â€œ</i>).</p>\n<table id="toc" class="toc">\n<tr>\n<td>\n<div id="toctitle">\n<h2>Inhaltsverzeichnis</h2>\n</div>\n<ul>\n<li class="toclevel-1 tocsection-1"><span class="tocnumber">1</span> <span class="toctext">Herkunft</span></a></li>\n<li class="toclevel-1 tocsection-2"><span class="tocnumber">2</span> <span class="toctext">Ã„hnliche BegrÃ¼ÃŸungen in anderen Sprachen</span></a></li>\n<li class="toclevel-1 tocsection-3"><span class="tocnumber">3</span> <span class="toctext">Siehe auch</span></a></li>\n<li class="toclevel-1 tocsection-4"><span class="tocnumber">4</span> <span class="toctext">Literatur</span></a></li>\n<li class="toclevel-1 tocsection-5"><span class="tocnumber">5</span> <span class="toctext">Weblinks</span></a></li>\n<li class="toclevel-1 tocsection-6"><span class="tocnumber">6</span> <span class="toctext">Einzelnachweise</span></a></li>\n</ul>\n</td>\n</tr>\n</table>\n<h2><span class="editsection">[Bearbeiten</a>]</span> <span class="mw-headline" id="Herkunft">Herkunft</span></h2>\n<p>Sprachgeschichtlich werden mehrere MÃ¶glichkeiten der Herkunft diskutiert. Die erste sieht einen Ursprung von althochdeutsch</a> â€ž<span lang="goh" class="lang" xml:lang="goh">halÅn</span>â€œ, mittelhochdeutsch</a> â€ž<span lang="gmh" class="lang" xml:lang="gmh">halen</span>â€œ fÃ¼r â€žrufen, holenâ€œ. Die zweite MÃ¶glichkeit wÃ¤re eine Verwandtschaft mit â€žhollaâ€œ, dem verkÃ¼rzten Ruf â€žHol Ã¼ber!â€œ an den FÃ¤hrmann</a>. Auch die Abstammung von â€ž<span lang="hbo-Latn" class="lang" xml:lang="hbo-Latn">halal</span>â€œ (hebrÃ¤isch fÃ¼r preisen, verherrlichen, ausrufen) wird diskutiert.</p>\n<p>Das erste Wort, das Thomas Alva Edison</a> mit dem von ihm erfundenen Phonographen</a> aufzeichnete und wiedergab, war ein â€žHalloâ€œ (<i><span lang="en" class="lang" xml:lang="en">Hello</span></i>).<sup id="cite_ref-Koenigsberg_0-0" class="reference">[1]</a></sup> In die Umgangssprache â€“&#160;zumindest die deutsche</a> und englische</a>&#160;â€“ gelangte â€žHalloâ€œ aber wohl erst mit der Entwicklung und Verbreitung von Telefonen. Edison entwickelte den durch Alexander Graham Bell</a> 1876 patentierten Fernsprecher weiter und setzte sich mit seinem Vorschlag <i><span lang="en" class="lang" xml:lang="en">Hello</span></i> 1877 gegen Bell durch, der <i>Ahoy</i></a> als BegrÃ¼ÃŸung favorisierte. <i><span lang="en" class="lang" xml:lang="en">Hello</span></i> war vor den 1880er Jahren in den USA als BegrÃ¼ÃŸung unÃ¼blich und soll von <i>Halloo</i>, einem Ruf an einen FÃ¤hrmann abgeleitet sein.<sup id="cite_ref-Koenigsberg_0-1" class="reference">[1]</a></sup> Im FranzÃ¶sischen</a> hat â€žallÃ´â€œ seinen Ursprung als TelefonbegrÃ¼ÃŸung bewahrt, hier wird stattdessen â€žsalutâ€œ in der persÃ¶nlichen BegrÃ¼ÃŸung genutzt.<sup id="cite_ref-1" class="reference">[2]</a></sup></p>\n<p>MÃ¶glicherweise ist der GruÃŸ aber auch ungarischer</a> Herkunft. Beim Testen der ersten amerikanischen</a> Telefonzentrale, die von ungarischen Wissenschaftlern (Tivadar PuskÃ¡s</a>) entwickelt wurde, soll angeblich das Wort â€ž<span lang="hu" class="lang" xml:lang="hu">hallom</span>â€œ (ungarisch: â€žich hÃ¶re esâ€œ) benutzt worden sein, bzw. â€ž<span lang="hu" class="lang" xml:lang="hu">hallod</span>â€œ (ungarisch: â€žhÃ¶rst du?â€œ).</p>\n<h2><span class="editsection">[Bearbeiten</a>]</span> <span class="mw-headline" id=".C3.84hnliche_Begr.C3.BC.C3.9Fungen_in_anderen_Sprachen">Ã„hnliche BegrÃ¼ÃŸungen in anderen Sprachen</span></h2>\n<ul>\n<li>Arabisch</a>: <span lang="ar-Latn" class="lang" xml:lang="ar-Latn">Ahlan!, Marhaba!</span> (am Telefon: <span lang="ar-Latn" class="lang" xml:lang="ar-Latn">Alu!</span>)</li>\n<li>Albanisch</a>: <span lang="sq-Latn" class="lang" xml:lang="sq-Latn">Mirdita, Tungjatjeta</span> (am Telefon: <span lang="al-Latn" class="lang" xml:lang="al-Latn">Alo</span>)</li>\n<li>Bengalisch</a>: <big>à¦¨à¦®à¦¸à§à¦•à¦¾à¦°</big> (Namaskar! - gesprochen: <i>Nomoschkar</i>)</li>\n<li>Bulgarisch</a>: Ð—Ð´Ñ€Ð°Ð²ÐµÐ¹!, Ð—Ð´Ñ€Ð°ÑÑ‚Ð¸! (Duzform), Ð—Ð´Ñ€Ð°Ð²ÐµÐ¹Ñ‚Ðµ! (Siezform)</li>\n<li>Chinesisch</a>: <span lang="zh" class="lang" xml:lang="zh">ä½ å¥½</span>! (<i><span lang="zh-Latn" class="lang" xml:lang="zh-Latn">NÃ­ hao</span></i>)</li>\n<li>Englisch</a>: <span lang="en" class="lang" xml:lang="en">Hello!, Hi!</span></li>\n<li>Esperanto</a>: Saluton!</li>\n<li>Estnisch</a>: Tere!</li>\n<li>DÃ¤nisch</a>: Hej!</li>\n<li>Farsi</a>: Salam! (am Telefon: Alo!)</li>\n<li>Fidschi</a>: Bula!</li>\n<li>Finnisch</a>: <span lang="fi" class="lang" xml:lang="fi">Terve!, Hei!, Moi!, Moro!</span></li>\n<li>FranzÃ¶sisch</a>: <span lang="fr" class="lang" xml:lang="fr">Salut!, Bonjour!</span> (Am Telefon: <span lang="fr" class="lang" xml:lang="fr">AllÃ´</span>)</li>\n<li>Griechisch</a>: <span lang="el" class="lang" xml:lang="el">Î“ÎµÎ¹Î¬!</span>, (<i><span lang="el-Latn" class="lang" xml:lang="el-Latn">ja</span></i>)</li>\n<li>Hawaiisch</a>: Aloha</a>!</li>\n<li>HebrÃ¤isch</a>:&#160;!×©×œ×•× (Schalom!</a>)</li>\n<li>Hindi</a>: à¤¨à¤®à¤¸à¥à¤¤à¥‡ (Namaste!)</li>\n<li>Italienisch</a>: <span lang="it" class="lang" xml:lang="it">Ciao!</span> (freundschaftlich), <span lang="it" class="lang" xml:lang="it">Buongiorno!</span> (formal), <span lang="it" class="lang" xml:lang="it">Pronto!</span> (am Telefon)</li>\n<li>Indonesisch</a>: Halo!</li>\n<li>Japanisch</a>: <span lang="ja-Jpan" class="lang" xml:lang="ja-Jpan">ã“ã‚“ã«ã¡ã¯</span>! <i><span lang="ja-Latn" class="lang" xml:lang="ja-Latn">konnichi wa!</span></i> (formal), <span lang="ja-Jpan" class="lang" xml:lang="ja-Jpan">ãŠãƒ¼ã„</span>! <i><span lang="ja-Latn" class="lang" xml:lang="ja-Latn">Åi!</span></i> (freundschaftlich), <span lang="ja-Jpan" class="lang" xml:lang="ja-Jpan">ã‚‚ã—ã‚‚ã—</span> <i><span lang="ja-Latn" class="lang" xml:lang="ja-Latn">moshimoshi</span></i> (am Telefon)</li>\n<li>Khmer</a>: Tchum-reaup Suw!</li>\n<li>Koreanisch</a>: <span lang="ko" class="lang" xml:lang="ko">ì•ˆë…•í•˜ì„¸ìš”</span>! (<i><span lang="ko-Latn" class="lang" xml:lang="ko-Latn">Annyeong Haseyo!</span></i>)</li>\n<li>Kroatisch</a>: Bog</a>! (â€žGrÃ¼ÃŸ Gott!â€œ)</li>\n<li>Latein</a>: <span lang="la" class="lang" xml:lang="la">Ave/Salve</span> (bzw. im Plural <span lang="la" class="lang" xml:lang="la">Salvete</span>)</li>\n<li>Lettisch</a>: ÄŒau! Sveiki!</li>\n<li>Litauisch</a>: Labas!</li>\n<li>Malagasy</a>: Salama!</li>\n<li>Malaiisch</a>: Hai!</li>\n<li>Maori</a>: Tena Koe</li>\n<li>Mongolisch</a>: Ð¡Ð°Ð¹Ð½ ÑƒÑƒ!</li>\n<li>NiederlÃ¤ndisch</a>: <span lang="nl" class="lang" xml:lang="nl">Hallo!, Hoi!</span></li>\n<li>Norwegisch</a>: Hei!, Hallo!, Morn!</li>\n<li>Polnisch</a>: <span lang="pl" class="lang" xml:lang="pl">CzeÅ›Ä‡!</span></li>\n<li>Portugiesisch</a>: OlÃ¡! (Portugal</a>), Oi! AlÃ´ (am Telefon) (Brasilien</a>)</li>\n<li>RumÃ¤nisch</a>: <span lang="ro" class="lang" xml:lang="ro">Salut!</span> (freundlich), <span lang="ro" class="lang" xml:lang="ro">BunÄƒ ziua!</span> (formal) oder einfach nur <span lang="ro" class="lang" xml:lang="ro">BunÄƒ!</span> (letzteres unter Freunde und Bekannte vornehmlich im SÃ¼den RumÃ¤niens), <span lang="ro" class="lang" xml:lang="ro">Alo</span> (ausschlieÃŸlich am Telefon), Ciao! (freundschaftlich), <span lang="ro" class="lang" xml:lang="ro">SÄƒrut mÃ¢na!</span> (dt. KÃ¼ÃŸ die Hand!, heutzutage nur noch in SiebenbÃ¼rgen gegenÃ¼ber den Frauen verwendet)</li>\n<li>Russisch</a>: <span lang="ru" class="lang" xml:lang="ru">ÐŸÑ€Ð¸Ð²ÐµÑ‚!</span> (<span lang="ru-Latn" class="lang" xml:lang="ru-Latn">Priwet!</span>) <span lang="ru" class="lang" xml:lang="ru">ÐÐ»Ð»Ð¾!</span> (<span lang="ru-Latn" class="lang" xml:lang="ru-Latn">Allo!</span> am Telefon)</li>\n<li>Schwedisch</a>: <span lang="sv" class="lang" xml:lang="sv">Hej!, HallÃ¥!</span></li>\n<li>Schweizerdeutsch</a>: <span lang="gsw" class="lang" xml:lang="gsw">Hoi!, Sali!, Tschau!, Hallo!</span></li>\n<li>Serbisch</a>: Zdravo&#160;!, Alo! (am Telefon)</li>\n<li>Slowakisch</a>: Ahoj!, Halo (am Telefon)</li>\n<li>Spanisch</a>: <span lang="es" class="lang" xml:lang="es">Â¡Hola!</span> (Am Telefon: Â¡Diga!, Â¡DÃ­game!, Â¿SÃ­?, Â¡AlÃ³!)</li>\n<li>Tamil</a>: à®µà®£à®•à¯à®•à®®à¯! (vaá¹‡akkam)</li>\n<li>ThailÃ¤ndisch</a>: à¸ªà¸§à¸±à¸ªà¸”à¸µà¸„à¸°!</li>\n<li>Tschechisch</a>: Nazdar!, Ahoj!, ÄŒau!, Halo! (am Telefon)</li>\n<li>TÃ¼rkisch</a>: <span lang="tr" class="lang" xml:lang="tr">Merhaba!</span> (zur BegrÃ¼ÃŸung), <span lang="tr" class="lang" xml:lang="tr">Alo!</span> (am Telefon)</li>\n<li>Ukrainisch</a>: ÐŸÑ€Ð¸Ð²Ñ–Ñ‚! (Priwit!)</li>\n<li>Ungarisch</a>: <span lang="hu" class="lang" xml:lang="hu">Szia!</span> (freundschaftlich), <span lang="hu" class="lang" xml:lang="hu">Szervusz!</span></li>\n<li>Vietnamesisch</a>: ChÃ o!</li>\n</ul>\n<h2><span class="editsection">[Bearbeiten</a>]</span> <span class="mw-headline" id="Siehe_auch">Siehe auch</span></h2>\n<ul>\n<li>Ahoi</a></li>\n<li>GrÃ¼ÃŸ Gott</a></li>\n<li>Moin</a></li>\n<li>Servus</a></li>\n<li>TschÃ¼s</a></li>\n<li>Hallo-Welt-Programm</a></li>\n</ul>\n<h2><span class="editsection">[Bearbeiten</a>]</span> <span class="mw-headline" id="Literatur">Literatur</span></h2>\n<ul>\n<li>Allen Koenigsberg <span lang="en" class="lang" xml:lang="en">(compiled, edited, and annotated): <i>The patent history of the phonograph, 1877-1912: a source book containing 2, 118 U. S. sound recording patents &amp; 1, 013 inventors arranged numerically, chronologically, and alphabetically: illustrated by 101 original patent drawings with detailed commentaries on each: additional historical essays on the U. S. patent system</i>. APM Press, Brooklyn, NY, c1990</span>, ISBN 0-937612-10-3</a></li>\n<li>Klaus Mampell, <i>â€žHalloâ€œ Ã¼bers Telefon und auch sonst</i>, in: sprachspiegel. Schweizerische Zeitschrift fÃ¼r die deutsche Muttersprache, 63. Jahrgang 2007, Heft 5 (Oktober), S. 160-161</li>\n</ul>\n<h2><span class="editsection">[Bearbeiten</a>]</span> <span class="mw-headline" id="Weblinks">Weblinks</span></h2>\n<div class="sisterproject" style="margin:0.1em 0 0 0;"><img alt="Wiktionary" src="//upload.wikimedia.org/wikipedia/commons/thumb/c/c3/Wiktfavicon_en.svg/16px-Wiktfavicon_en.svg.png" width="16" height="16" />&#160;<b>Wiktionary: Hallo</a></b>&#160;â€“ BedeutungserklÃ¤rungen, Wortherkunft, Synonyme, Ãœbersetzungen</div>\n<div class="sisterproject" style="margin:0.1em 0 0 0;"><img alt="Wiktionary" src="//upload.wikimedia.org/wikipedia/commons/thumb/c/c3/Wiktfavicon_en.svg/16px-Wiktfavicon_en.svg.png" width="16" height="16" />&#160;<b>Wiktionary: hallo</a></b>&#160;â€“ BedeutungserklÃ¤rungen, Wortherkunft, Synonyme, Ãœbersetzungen</div>\n<div class="sisterproject" style="margin:0.1em 0 0 0;"><img alt="Wiktionary" src="//upload.wikimedia.org/wikipedia/commons/thumb/c/c3/Wiktfavicon_en.svg/16px-Wiktfavicon_en.svg.png" width="16" height="16" />&#160;<b>Wiktionary: hallÃ³</a></b>&#160;â€“ BedeutungserklÃ¤rungen, Wortherkunft, Synonyme, Ãœbersetzungen</div>\n<ul>\n<li>Hallo in Ã¼ber 800 Sprachen</a></li>\n</ul>\n<h2><span class="editsection">[Bearbeiten</a>]</span> <span class="mw-headline" id="Einzelnachweise">Einzelnachweise</span></h2>\n<ol class="references">\n<li id="cite_note-Koenigsberg-0"><span class="mw-cite-backlink">â†‘ <sup>a</a></sup> <sup>b</a></sup></span> <span class="reference-text">Allen Koenigsberg <span lang="en" class="lang" xml:lang="en">(compiled, edited, and annotated): <i>The patent history of the phonograph, 1877-1912: a source book containing 2, 118 U. S. sound recording patents &amp; 1, 013 inventors arranged numerically, chronologically, and alphabetically: illustrated by 101 original patent drawings with detailed commentaries on each: additional historical essays on the U. S. patent system</i>. APM Press, Brooklyn, NY, c1990</span>, ISBN 0-937612-10-3</a></span></li>\n<li id="cite_note-1"><span class="mw-cite-backlink">â†‘</a></span> <span class="reference-text">pons.eu</a></span></li>\n</ol>\n\n\n<!-- \nNewPP limit report\nPreprocessor node count: 691/1000000\nPost-expand include size: 5754/2048000 bytes\nTemplate argument size: 1795/2048000 bytes\nExpensive parser function count: 0/500\n-->\n\n<!-- Saved in parser cache with key dewiki:pcache:idhash:383925-0!*!0!!de!4!* and timestamp 20120414220624 -->\n</div>				<!-- /bodycontent -->\n								<!-- printfooter -->\n				<div class="printfooter">\n				Von â€žhttp://de.wikipedia.org/w/index.php?title=Hallo&amp;oldid=101820097</a>â€œ				</div>\n				<!-- /printfooter -->\n												<!-- catlinks -->\n				<div id=''catlinks'' class=''catlinks''><div id="mw-normal-catlinks" class="mw-normal-catlinks">Kategorie</a>: <ul><li>GruÃŸformel</a></li></ul></div></div>				<!-- /catlinks -->\n												<div class="visualClear"></div>\n				<!-- debughtml -->\n								<!-- /debughtml -->\n			</div>\n			<!-- /bodyContent -->\n		</div>\n		<!-- /content -->\n		<!-- header -->\n		<div id="mw-head" class="noprint">\n			\n<!-- 0 -->\n<div id="p-personal" class="">\n	<h5>Meine Werkzeuge</h5>\n	<ul>\n		<li id="pt-userpage">Swp6 12</a></li>\n		<li id="pt-mytalk">Eigene Diskussion</a></li>\n		<li id="pt-preferences">Einstellungen</a></li>\n		<li id="pt-watchlist">Beobachtungsliste</a></li>\n		<li id="pt-mycontris">Eigene BeitrÃ¤ge</a></li>\n		<li id="pt-logout">Abmelden</a></li>\n	</ul>\n</div>\n\n<!-- /0 -->\n			<div id="left-navigation">\n				\n<!-- 0 -->\n<div id="p-namespaces" class="vectorTabs">\n	<h5>NamensrÃ¤ume</h5>\n	<ul>\n					<li  id="ca-nstab-main" class="selected"><span>Artikel</a></span></li>\n					<li  id="ca-talk"><span>Diskussion</a></span></li>\n			</ul>\n</div>\n\n<!-- /0 -->\n\n<!-- 1 -->\n<div id="p-variants" class="vectorMenu emptyPortlet">\n	<h4>\n		</h4>\n	<h5><span>Varianten</span></a></h5>\n	<div class="menu">\n		<ul>\n					</ul>\n	</div>\n</div>\n\n<!-- /1 -->\n			</div>\n			<div id="right-navigation">\n				\n<!-- 0 -->\n<div id="p-views" class="vectorTabs">\n	<h5>Ansichten</h5>\n	<ul>\n					<li id="ca-view" class="selected"><span>Lesen</a></span></li>\n					<li id="ca-edit"><span>Bearbeiten</a></span></li>\n					<li id="ca-history" class="collapsible"><span>Versionsgeschichte</a></span></li>\n					<li id="ca-watch" class="icon"><span>Beobachten</a></span></li>\n			</ul>\n</div>\n\n<!-- /0 -->\n\n<!-- 1 -->\n<div id="p-cactions" class="vectorMenu">\n	<h5><span>Aktionen</span></a></h5>\n	<div class="menu">\n		<ul>\n							<li id="ca-move">Verschieben</a></li>\n					</ul>\n	</div>\n</div>\n\n<!-- /1 -->\n\n<!-- 2 -->\n<div id="p-search">\n	<h5><label for="searchInput">Suche</label></h5>\n	\n				<div id="simpleSearch">\n						<input type="text" name="search" value="" title="Durchsuche die Wikipedia [f]" accesskey="f" id="searchInput" />						<button type="submit" name="button" title="Suche nach Seiten, die diesen Text enthalten" id="searchButton" width="12" height="13"><img src="//bits.wikimedia.org/skins-1.20wmf1/vector/images/search-ltr.png?303-4" alt="Volltext" /></button>								<input type=''hidden'' name="title" value="Spezial:Suche"/>\n		</div>\n	</form>\n</div>\n\n<!-- /2 -->\n			</div>\n		</div>\n		<!-- /header -->\n		<!-- panel -->\n			<div id="mw-panel" class="noprint">\n				<!-- logo -->\n					<div id="p-logo"></a></div>\n				<!-- /logo -->\n				\n<!-- SEARCH -->\n\n<!-- /SEARCH -->\n\n<!-- navigation -->\n<div class="portal" id=''p-navigation''>\n	<h5>Navigation</h5>\n	<div class="body">\n		<ul>\n			<li id="n-mainpage-description">Hauptseite</a></li>\n			<li id="n-aboutsite">Ãœber Wikipedia</a></li>\n			<li id="n-topics">Themenportale</a></li>\n			<li id="n-alphindex">Von A bis Z</a></li>\n			<li id="n-randompage">ZufÃ¤lliger Artikel</a></li>\n		</ul>\n	</div>\n</div>\n\n<!-- /navigation -->\n\n<!-- Mitmachen -->\n<div class="portal" id=''p-Mitmachen''>\n	<h5>Mitmachen</h5>\n	<div class="body">\n		<ul>\n			<li id="n-Neuerartikel">Neuen Artikel anlegen</a></li>\n			<li id="n-portal">Autorenportal</a></li>\n			<li id="n-help">Hilfe</a></li>\n			<li id="n-recentchanges">Letzte Ã„nderungen</a></li>\n			<li id="n-contact">Kontakt</a></li>\n			<li id="n-sitesupport">Spenden</a></li>\n		</ul>\n	</div>\n</div>\n\n<!-- /Mitmachen -->\n\n<!-- coll-print_export -->\n<div class="portal" id=''p-coll-print_export''>\n	<h5>Drucken/exportieren</h5>\n	<div class="body">\n		<ul id="collectionPortletList"><li id="coll-create_a_book">Buch erstellen</a></li><li id="coll-download-as-rl">Als PDF herunterladen</a></li><li id="t-print">Druckversion</a></li></ul>	</div>\n</div>\n\n<!-- /coll-print_export -->\n\n<!-- TOOLBOX -->\n<div class="portal" id=''p-tb''>\n	<h5>Werkzeuge</h5>\n	<div class="body">\n		<ul>\n			<li id="t-whatlinkshere">Links auf diese Seite</a></li>\n			<li id="t-recentchangeslinked">Ã„nderungen an verlinkten Seiten</a></li>\n			<li id="t-upload">Datei hochladen</a></li>\n			<li id="t-specialpages">Spezialseiten</a></li>\n			<li id="t-permalink">Permanenter Link</a></li>\n<li id="t-cite">Seite zitieren</a></li>		</ul>\n	</div>\n</div>\n\n<!-- /TOOLBOX -->\n\n<!-- LANGUAGES -->\n<div class="portal" id=''p-lang''>\n	<h5>In anderen Sprachen</h5>\n	<div class="body">\n		<ul>\n			<li class="interwiki-als">Alemannisch</a></li>\n			<li class="interwiki-en">English</a></li>\n			<li class="interwiki-es">EspaÃ±ol</a></li>\n			<li class="interwiki-fr">FranÃ§ais</a></li>\n			<li class="interwiki-hu">Magyar</a></li>\n			<li class="interwiki-nl">Nederlands</a></li>\n			<li class="interwiki-simple">Simple English</a></li>\n		</ul>\n	</div>\n</div>\n\n<!-- /LANGUAGES -->\n			</div>\n		<!-- /panel -->\n		<!-- footer -->\n		<div id="footer">\n							<ul id="footer-info">\n											<li id="footer-info-lastmod"> Diese Seite wurde zuletzt am 8. April 2012 um 18:30 Uhr geÃ¤ndert.</li>\n											<li id="footer-info-copyright">Der Text ist unter der Lizenz â€žCreative Commons Attribution/Share Alikeâ€œ</a> verfÃ¼gbar; zusÃ¤tzliche Bedingungen kÃ¶nnen anwendbar sein.\nEinzelheiten sind in den Nutzungsbedingungen</a> beschrieben.<br />\nWikipediaÂ® ist eine eingetragene Marke der Wikimedia Foundation Inc.<br /></li>\n									</ul>\n							<ul id="footer-places">\n											<li id="footer-places-privacy">Datenschutz</a></li>\n											<li id="footer-places-about">Ãœber Wikipedia</a></li>\n											<li id="footer-places-disclaimer">Impressum</a></li>\n											<li id="footer-places-mobileview">Mobile Ansicht</a></li>\n									</ul>\n										<ul id="footer-icons" class="noprint">\n					<li id="footer-copyrightico">\n						<img src="//bits.wikimedia.org/images/wikimedia-button.png" width="88" height="31" alt="Wikimedia Foundation"/></a>\n					</li>\n					<li id="footer-poweredbyico">\n						<img src="//bits.wikimedia.org/skins-1.20wmf1/common/images/poweredby_mediawiki_88x31.png" alt="Powered by MediaWiki" width="88" height="31" /></a>\n					</li>\n				</ul>\n						<div style="clear:both"></div>\n		</div>\n		<!-- /footer -->\n		\n\n\n\n<!-- Served by mw32 in 0.175 secs. -->\n	</body>\n</html>\n', 'http://de.wikipedia.org/wiki/Hallo', 0, 0, 1);

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
