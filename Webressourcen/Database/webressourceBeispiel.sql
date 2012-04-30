-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 30. Apr 2012 um 22:10
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `comment`
--

INSERT INTO `comment` (`commentID`, `userID`, `topicID`, `topicVersion`, `anonymous`, `commentDate`, `commentText`) VALUES
(5, 1, 11, 1, 0, '2012-04-30 19:46:51', 'Beispielkommentar');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `master`
--

CREATE TABLE IF NOT EXISTS `master` (
  `userID` int(11) NOT NULL,
  `userName` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `master`
--

INSERT INTO `master` (`userID`, `userName`, `password`) VALUES
(1, 'admin', '098f6bcd4621d373cade4e832627b4f6');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `topicID` int(11) NOT NULL AUTO_INCREMENT,
  `topicName` varchar(30) NOT NULL,
  PRIMARY KEY (`topicID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Daten für Tabelle `topic`
--

INSERT INTO `topic` (`topicID`, `topicName`) VALUES
(11, 'Beispiel');

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
(11, 1, '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\n<html lang="de" dir="ltr" class="client-nojs" xmlns="http://www.w3.org/1999/xhtml">\n<head>\n<title>Beispiel â€“ Wikipedia</title>\n<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />\n<meta http-equiv="Content-Style-Type" content="text/css" />\n<meta name="generator" content="MediaWiki 1.20wmf1" />\n<link rel="alternate" type="application/x-wiki" title="Seite bearbeiten" href="/w/index.php?title=Beispiel&amp;action=edit" />\n<link rel="edit" title="Seite bearbeiten" href="/w/index.php?title=Beispiel&amp;action=edit" />\n<link rel="apple-touch-icon" href="//de.wikipedia.org/apple-touch-icon.png" />\n<link rel="shortcut icon" href="/favicon.ico" />\n<link rel="search" type="application/opensearchdescription+xml" href="/w/opensearch_desc.php" title="Wikipedia (de)" />\n<link rel="EditURI" type="application/rsd+xml" href="//de.wikipedia.org/w/api.php?action=rsd" />\n<link rel="copyright" href="//creativecommons.org/licenses/by-sa/3.0/" />\n<link rel="alternate" type="application/atom+xml" title="Atom-Feed fÃ¼r â€žWikipediaâ€œ" href="/w/index.php?title=Spezial:Letzte_%C3%84nderungen&amp;feed=atom" />\n<link rel="stylesheet" href="//bits.wikimedia.org/de.wikipedia.org/load.php?debug=false&amp;lang=de&amp;modules=ext.flaggedRevs.basic%7Cext.wikihiero%7Cmediawiki.legacy.commonPrint%2Cshared%7Cskins.vector&amp;only=styles&amp;skin=vector&amp;*" type="text/css" media="all" />\n<meta name="ResourceLoaderDynamicStyles" content="" />\n<link rel="stylesheet" href="//bits.wikimedia.org/de.wikipedia.org/load.php?debug=false&amp;lang=de&amp;modules=site&amp;only=styles&amp;skin=vector&amp;*" type="text/css" media="all" />\n<style type="text/css" media="all">a:lang(ar),a:lang(ckb),a:lang(fa),a:lang(kk-arab),a:lang(mzn),a:lang(ps),a:lang(ur){text-decoration:none}\n\n/* cache key: dewiki:resourceloader:filter:minify-css:7:d5a1bf6cbd05fc6cc2705e47f52062dc */</style>\n\n<script src="//bits.wikimedia.org/de.wikipedia.org/load.php?debug=false&amp;lang=de&amp;modules=startup&amp;only=scripts&amp;skin=vector&amp;*" type="text/javascript"></script>\n<script type="text/javascript">if(window.mw){\nmw.config.set({"wgCanonicalNamespace":"","wgCanonicalSpecialPageName":false,"wgNamespaceNumber":0,"wgPageName":"Beispiel","wgTitle":"Beispiel","wgCurRevisionId":102249708,"wgArticleId":1034104,"wgIsArticle":true,"wgAction":"view","wgUserName":null,"wgUserGroups":["*"],"wgCategories":["Rhetorischer Begriff"],"wgBreakFrames":false,"wgPageContentLanguage":"de","wgSeparatorTransformTable":[",	.",".	,"],"wgDigitTransformTable":["",""],"wgRelevantPageName":"Beispiel","wgRestrictionEdit":[],"wgRestrictionMove":[],"wgSearchNamespaces":[0],"wgVectorEnabledModules":{"collapsiblenav":true,"collapsibletabs":true,"editwarning":true,"expandablesearch":false,"footercleanup":false,"sectioneditlinks":false,"simplesearch":true,"experiments":true},"wgWikiEditorEnabledModules":{"toolbar":true,"dialogs":true,"hidesig":true,"templateEditor":false,"templates":false,"preview":false,"previewDialog":false,"publish":false,"toc":false},"wgFlaggedRevsParams":{"tags":{"accuracy":{"levels":1,"quality":2,"pristine":4}}},"wgStableRevisionId":102249708,"wgCategoryTreePageCategoryOptions":"{\\"mode\\":0,\\"hideprefix\\":20,\\"showcount\\":true,\\"namespaces\\":false}","Geo":{"city":"","country":""},"wgNoticeProject":"wikipedia"});\n}</script><script type="text/javascript">if(window.mw){\nmw.loader.implement("user.options",function(){mw.user.options.set({"ccmeonemails":0,"cols":80,"date":"default","diffonly":0,"disablemail":0,"disablesuggest":0,"editfont":"default","editondblclick":0,"editsection":1,"editsectiononrightclick":0,"enotifminoredits":0,"enotifrevealaddr":0,"enotifusertalkpages":1,"enotifwatchlistpages":0,"extendwatchlist":0,"externaldiff":0,"externaleditor":0,"fancysig":0,"forceeditsummary":0,"gender":"unknown","hideminor":0,"hidepatrolled":0,"imagesize":2,"justify":0,"math":0,"minordefault":0,"newpageshidepatrolled":0,"nocache":0,"noconvertlink":0,"norollbackdiff":0,"numberheadings":0,"previewonfirst":0,"previewontop":1,"quickbar":5,"rcdays":7,"rclimit":50,"rememberpassword":0,"rows":25,"searchlimit":20,"showhiddencats":false,"showjumplinks":1,"shownumberswatching":1,"showtoc":1,"showtoolbar":1,"skin":"vector","stubthreshold":0,"thumbsize":4,"underline":2,"uselivepreview":0,"usenewrc":0,"watchcreations":1,"watchdefault":0,"watchdeletion":0,"watchlistdays":3\n,"watchlisthideanons":0,"watchlisthidebots":0,"watchlisthideliu":0,"watchlisthideminor":0,"watchlisthideown":0,"watchlisthidepatrolled":0,"watchmoves":0,"wllimit":250,"flaggedrevssimpleui":1,"flaggedrevsstable":0,"flaggedrevseditdiffs":true,"flaggedrevsviewdiffs":false,"vector-simplesearch":1,"useeditwarning":1,"vector-collapsiblenav":1,"usebetatoolbar":1,"usebetatoolbar-cgd":1,"variant":"de","language":"de","searchNs0":true,"searchNs1":false,"searchNs2":false,"searchNs3":false,"searchNs4":false,"searchNs5":false,"searchNs6":false,"searchNs7":false,"searchNs8":false,"searchNs9":false,"searchNs10":false,"searchNs11":false,"searchNs12":false,"searchNs13":false,"searchNs14":false,"searchNs15":false,"searchNs100":false,"searchNs101":false,"gadget-old-movepage":1});;},{},{});mw.loader.implement("user.tokens",function(){mw.user.tokens.set({"editToken":"+\\\\","watchToken":false});;},{},{});\n\n/* cache key: dewiki:resourceloader:filter:minify-js:7:16dc42fe06900b03e80e78017abf27cf */\n}</script>\n<script type="text/javascript">if(window.mw){\nmw.loader.load(["mediawiki.page.startup","mediawiki.legacy.wikibits","mediawiki.legacy.ajax"]);\n}</script>\n<!--[if lt IE 7]><style type="text/css">body{behavior:url("/w/skins-1.20wmf1/vector/csshover.min.htc")}</style><![endif]--></head>\n<body class="mediawiki ltr sitedir-ltr capitalize-all-nouns ns-0 ns-subject page-Beispiel skin-vector action-view">\n		<div id="mw-page-base" class="noprint"></div>\n		<div id="mw-head-base" class="noprint"></div>\n		<!-- content -->\n		<div id="content" class="mw-body">\n			</a>\n			<div id="mw-js-message" style="display:none;"></div>\n						<!-- sitenotice -->\n			<div id="siteNotice"><!-- centralNotice loads here --></div>\n			<!-- /sitenotice -->\n						<!-- firstHeading -->\n			<h1 id="firstHeading" class="firstHeading">\n				<span dir="auto">Beispiel</span>\n			</h1>\n			<!-- /firstHeading -->\n			<!-- bodyContent -->\n			<div id="bodyContent">\n								<!-- tagline -->\n				<div id="siteSub">aus Wikipedia, der freien EnzyklopÃ¤die</div>\n				<!-- /tagline -->\n								<!-- subtitle -->\n				<div id="contentSub"></div>\n				<!-- /subtitle -->\n																<!-- jumpto -->\n				<div id="jump-to-nav" class="mw-jump">\n					Wechseln zu: Navigation</a>,\n					Suche</a>\n				</div>\n				<!-- /jumpto -->\n								<!-- bodycontent -->\n				<div id="mw-content-text" lang="de" dir="ltr" class="mw-content-ltr"><p>Ein <b>Beispiel</b> wird als ErlÃ¤uterung oder Beweis</a> fÃ¼r etwas Allgemeines oder als musterhafter</a> Einzelfall</a> oder Vorbild</a> herangezogen. Laut Duden ist ein Beispiel ein â€žbeliebig herausgegriffener, typischer Einzelfall als ErklÃ¤rung fÃ¼r eine bestimmte Erscheinung oder einen bestimmten Vorgang; Exempelâ€œ.<sup id="cite_ref-0" class="reference">[1]</a></sup></p>\n<table id="toc" class="toc">\n<tr>\n<td>\n<div id="toctitle">\n<h2>Inhaltsverzeichnis</h2>\n</div>\n<ul>\n<li class="toclevel-1 tocsection-1"><span class="tocnumber">1</span> <span class="toctext">Etymologie</span></a></li>\n<li class="toclevel-1 tocsection-2"><span class="tocnumber">2</span> <span class="toctext">Rhetorische Stilfigur</span></a></li>\n<li class="toclevel-1 tocsection-3"><span class="tocnumber">3</span> <span class="toctext">Siehe auch</span></a></li>\n<li class="toclevel-1 tocsection-4"><span class="tocnumber">4</span> <span class="toctext">Weblinks</span></a></li>\n<li class="toclevel-1 tocsection-5"><span class="tocnumber">5</span> <span class="toctext">Einzelnachweise</span></a></li>\n</ul>\n</td>\n</tr>\n</table>\n<h2><span class="editsection">[Bearbeiten</a>]</span> <span class="mw-headline" id="Etymologie">Etymologie</span></h2>\n<p>Der zweite Wortbestandteil <i>-spiel</i> ist wie in <i>Kirchspiel</a></i> im SpÃ¤tmittelhochdeutschen</a> volksetymologisch</a> an <i>Spiel</a></i> angelehnt worden. Das Grundwort dazu lautete im Althochdeutschen und AngelsÃ¤chsischem <i>spel</i> fÃ¼r â€šErzÃ¤hlung</a>, Rede</a>â€˜, im Altenglischem <i>spell</i> und Altnordischen <i>spjall</i> (auch â€šZauberspruchâ€˜) oder gotischen <i>spill</i> fÃ¼r â€šSage</a>, Fabel</a>â€˜. Im AuÃŸergermanischem sind im Griechischem <i>apeilá¸— (á¼€Ï€ÎµÎ¹Î»Î®)</i> â€šruhmredige VerheiÃŸung</a>, Drohung</a>â€˜ sowie im Lettischem <i>pelt</i> â€šschmÃ¤hen, verleumden, tadelnâ€˜ vergleichbar, so dass von einer gemeinsamen Wurzel <i>(s)pel-</i> â€šlaut, nachdrÃ¼cklich sprechenâ€˜ ausgegangen werden kann. In der englischen Sprache wird heute noch mit <i>spell</i> â€šZauberwortâ€˜ und <i>gospel</a></i> â€šEvangelium</a>â€˜ (altenglisch: <i>gÅdspel</i> â€šEvangeliumâ€˜, wÃ¶rtlich â€šgute Botschaftâ€˜) bezeichnet.</p>\n<p>Das mit <i>bÄ«-</i> (â€šbeiâ€˜) zusammengesetzte westgermanische Kompositum <i>bÄ«spil</i> â€šlehrhafter Spruch, Gleichnis</a>â€˜ mittelhochdeutsch <i>bÄ«spel</i>, mittelniederdeutsch <i>bÄ«spÄ“ÌŒl</i>, <i>bÄ«spil</i>, mittelniederlÃ¤ndische <i>bispel</i> bezeichnete â€šzur Belehrung erdichtete Geschichte, Fabel, Gleichnis, Sprichwort</a>â€˜; das Altenglische <i>bÄ«spell</i> â€šBeispiel, Gleichnisâ€˜ bedeutete â€šdas nebenbei ErzÃ¤hlteâ€˜. Martin Luther</a> verwendetet <i>Beispiel</i> vor allem im Sinne von â€šlehrreiches Faktum zur Nachahmung oder zur Abschreckungâ€˜. Unter Einfluss vom Lateinischen <i>exemplum</i> entwickelte sich seit dem 16. Jahrhundert die Bedeutung â€šVorbild, Musterâ€˜. Unter franzÃ¶sischem Einfluss beruhen die Verbindungen <i>zum Beispiel</i> (nach <i>par exemple</i>) und <i>ohne Beispiel</i> (nach <i>sans exemple</i>) beispielsweise in dem Adverb â€šzum Beispielâ€˜ Ende des 17. Jahrhunderts sowie das Adjektiv <i>beispiellos</i> â€šeinmalig, noch nicht dagewesen, unerhÃ¶rtâ€˜ in der zweiten HÃ¤lfte des 18. Jahrhunderts und <i>beispielhaft</i> â€švorbildlich, mustergÃ¼ltigâ€˜ Anfang des 20. Jahrhunderts.<sup id="cite_ref-1" class="reference">[2]</a></sup></p>\n<h2><span class="editsection">[Bearbeiten</a>]</span> <span class="mw-headline" id="Rhetorische_Stilfigur">Rhetorische Stilfigur</span></h2>\n<p>Nach Gert Ueding</a><sup id="cite_ref-2" class="reference">[3]</a></sup> bezeichnet ein Beispiel (lat.</a> <i>exemplum</i>) in der Rhetorik</a> einen Kontext</a> von Beweisen</a> und Argumenten</a>. FÃ¼r Quintilian</a> ist das Exemplum ein der Rede</a> zugefÃ¼gter, veranschaulichender Beleg, oder auch â€ždie ErwÃ¤hnung eines zur Ãœberzeugung von dem, worauf es dir ankommt, nÃ¼tzlichen, wirklichen oder angeblich wirklichen Vorgangsâ€œ. Allerdings muss im Gegensatz zu Indizien der Zusammenhang zum Redegegenstand erst noch durch den Autor, bzw. den Redner hergestellt werden. Sie habe aber nicht â€žbloÃŸ Beweis- oder Belegfunktionâ€œ, sondern solle â€žam einsichtigen, anschaulichen, mÃ¶glicherweise allgemein bekannten Fall einen schwer zugÃ¤nglichen, sprÃ¶den oder abstrakten Sachverhaltâ€œ erleuchten und hat somit â€žauch schmÃ¼ckende, unterhaltende, also emotional bewegende Wirkungâ€œ und gehÃ¶re zu den rhetorischen Figuren</a>.</p>\n<p>Die Rhetorik unterscheidet dabei drei Typen von Beispielen:</p>\n<ul>\n<li>Das Beispiel aus dem gegenwÃ¤rtigen Leben, aus der unmittelbaren Zeitgeschichte</a>. Der GlaubwÃ¼rdigkeit wÃ¼rde nach Ueding hier einen hohen Wert eingerÃ¤umt, â€žda es aus einer wahren Begebenheit stammt, die allgemein bekannt ist oder nachgewiesen werden kannâ€œ.</li>\n<li>Das Beispiel aus der Geschichte</a>. Das historische Exempel wÃ¼rde wohl am meisten gebraucht, da es â€žnicht nur auf Wahrheit beruhe, sondern darÃ¼ber hinaus autoritÃ¤tshaltigâ€œ sei. Es ist â€“ so Ueding â€“ â€žauch das durch die Geschichte schon bewÃ¤hrte, durch vorbildliche historische Personen bekrÃ¤ftigte, in seinen Auswirkungen weitgehend Ã¼berschaubare Geschehen, das die Ãœberzeugungskraft der Tradition mitbringtâ€œ.</li>\n<li>Das poetische Exempel; seine GlaubwÃ¼rdigkeit sei geringer, â€žweil ihm historische Wahrheit gar nicht oder nur in einem sehr vermittelten Sinne zukommt.â€œ Doch kÃ¶nne es â€žeine existenzielle, religiÃ¶se oder allgemein geistige Wahrheit vermittelnâ€œ und so â€žin vielen Bereichen der Ã¶ffentlichen Rede wirksamer, ja glaubwÃ¼rdiger sein als das empirisch stichhaltige Faktum.â€œ Beispielsweise wird in Ferdinand Freiligraths</a> Gedicht</a> <i>Hamlet</i> von 1844, das mit der Zeile beginnt â€žDeutschland ist Hamletâ€œ, der zaudernde Hamlet mit der politischen Situation des vormÃ¤rzlichen</a> Deutschlands verglichen.</li>\n</ul>\n<h2><span class="editsection">[Bearbeiten</a>]</span> <span class="mw-headline" id="Siehe_auch">Siehe auch</span></h2>\n<ul>\n<li>Exemplar</a></li>\n<li>ExemplaritÃ¤t</a></li>\n</ul>\n<h2><span class="editsection">[Bearbeiten</a>]</span> <span class="mw-headline" id="Weblinks">Weblinks</span></h2>\n<div class="sisterproject" style="margin:0.1em 0 0 0;"><img alt="Wiktionary" src="//upload.wikimedia.org/wikipedia/commons/thumb/c/c3/Wiktfavicon_en.svg/16px-Wiktfavicon_en.svg.png" width="16" height="16" />&#160;<b>Wiktionary: Beispiel</a></b>&#160;â€“ BedeutungserklÃ¤rungen, Wortherkunft, Synonyme, Ãœbersetzungen</div>\n<h2><span class="editsection">[Bearbeiten</a>]</span> <span class="mw-headline" id="Einzelnachweise">Einzelnachweise</span></h2>\n<ol class="references">\n<li id="cite_note-0"><span class="mw-cite-backlink">â†‘</a></span> <span class="reference-text"><i>Beispiel</i></a> auf duden.de, abgerufen am 12. September 2011</span></li>\n<li id="cite_note-1"><span class="mw-cite-backlink">â†‘</a></span> <span class="reference-text">Wolfgang Pfeifer: <i>Etymologisches WÃ¶rterbuch des Deutschen</i>. Berlin 1993, ISBN 3-05-000626-9</a>. Taschenbuchausgabe: UngekÃ¼rzte, durchgesehene Ausgabe, 7. Aufl. dtv, MÃ¼nchen 2004, ISBN 3-423-32511-9</a>, Online</a> bei DWDS</a></span></li>\n<li id="cite_note-2"><span class="mw-cite-backlink">â†‘</a></span> <span class="reference-text">Gert Ueding: <i>Rhetorik des Schreibens. Eine EinfÃ¼hrung.</i> Weinheim, 4. Auflage, 1996. S. 63-83, online</a> auf <i>mediaculture online</i></span></li>\n</ol>\n\n\n<!-- \nNewPP limit report\nPreprocessor node count: 106/1000000\nPost-expand include size: 330/2048000 bytes\nTemplate argument size: 32/2048000 bytes\nExpensive parser function count: 0/500\n-->\n\n<!-- Saved in parser cache with key dewiki:stable-pcache:idhash:1034104-0!*!0!!de!4!* and timestamp 20120420000937 -->\n</div>				<!-- /bodycontent -->\n								<!-- printfooter -->\n				<div class="printfooter">\n				Von â€žhttp://de.wikipedia.org/w/index.php?title=Beispiel&amp;oldid=102249708</a>â€œ				</div>\n				<!-- /printfooter -->\n												<!-- catlinks -->\n				<div id=''catlinks'' class=''catlinks''><div id="mw-normal-catlinks" class="mw-normal-catlinks">Kategorie</a>: <ul><li>Rhetorischer Begriff</a></li></ul></div></div>				<!-- /catlinks -->\n												<div class="visualClear"></div>\n				<!-- debughtml -->\n								<!-- /debughtml -->\n			</div>\n			<!-- /bodyContent -->\n		</div>\n		<!-- /content -->\n		<!-- header -->\n		<div id="mw-head" class="noprint">\n			\n<!-- 0 -->\n<div id="p-personal" class="">\n	<h5>Meine Werkzeuge</h5>\n	<ul>\n		<li id="pt-login">Anmelden / Benutzerkonto erstellen</a></li>\n	</ul>\n</div>\n\n<!-- /0 -->\n			<div id="left-navigation">\n				\n<!-- 0 -->\n<div id="p-namespaces" class="vectorTabs">\n	<h5>NamensrÃ¤ume</h5>\n	<ul>\n					<li  id="ca-nstab-main" class="selected"><span>Artikel</a></span></li>\n					<li  id="ca-talk"><span>Diskussion</a></span></li>\n			</ul>\n</div>\n\n<!-- /0 -->\n\n<!-- 1 -->\n<div id="p-variants" class="vectorMenu emptyPortlet">\n	<h4>\n		</h4>\n	<h5><span>Varianten</span></a></h5>\n	<div class="menu">\n		<ul>\n					</ul>\n	</div>\n</div>\n\n<!-- /1 -->\n			</div>\n			<div id="right-navigation">\n				\n<!-- 0 -->\n<div id="p-views" class="vectorTabs">\n	<h5>Ansichten</h5>\n	<ul>\n					<li id="ca-view" class="selected"><span>Lesen</a></span></li>\n					<li id="ca-edit"><span>Bearbeiten</a></span></li>\n					<li id="ca-history" class="collapsible"><span>Versionsgeschichte</a></span></li>\n			</ul>\n</div>\n\n<!-- /0 -->\n\n<!-- 1 -->\n<div id="p-cactions" class="vectorMenu emptyPortlet">\n	<h5><span>Aktionen</span></a></h5>\n	<div class="menu">\n		<ul>\n					</ul>\n	</div>\n</div>\n\n<!-- /1 -->\n\n<!-- 2 -->\n<div id="p-search">\n	<h5><label for="searchInput">Suche</label></h5>\n	<form action="/w/index.php" id="searchform">\n				<div id="simpleSearch">\n						<input type="text" name="search" value="" title="Durchsuche die Wikipedia [f]" accesskey="f" id="searchInput" />						<button type="submit" name="button" title="Suche nach Seiten, die diesen Text enthalten" id="searchButton" width="12" height="13"><img src="//bits.wikimedia.org/skins-1.20wmf1/vector/images/search-ltr.png?303-4" alt="Volltext" /></button>								<input type=''hidden'' name="title" value="Spezial:Suche"/>\n		</div>\n	</form>\n</div>\n\n<!-- /2 -->\n			</div>\n		</div>\n		<!-- /header -->\n		<!-- panel -->\n			<div id="mw-panel" class="noprint">\n				<!-- logo -->\n					<div id="p-logo"></a></div>\n				<!-- /logo -->\n				\n<!-- SEARCH -->\n\n<!-- /SEARCH -->\n\n<!-- navigation -->\n<div class="portal" id=''p-navigation''>\n	<h5>Navigation</h5>\n	<div class="body">\n		<ul>\n			<li id="n-mainpage-description">Hauptseite</a></li>\n			<li id="n-aboutsite">Ãœber Wikipedia</a></li>\n			<li id="n-topics">Themenportale</a></li>\n			<li id="n-alphindex">Von A bis Z</a></li>\n			<li id="n-randompage">ZufÃ¤lliger Artikel</a></li>\n		</ul>\n	</div>\n</div>\n\n<!-- /navigation -->\n\n<!-- Mitmachen -->\n<div class="portal" id=''p-Mitmachen''>\n	<h5>Mitmachen</h5>\n	<div class="body">\n		<ul>\n			<li id="n-Neuerartikel">Neuen Artikel anlegen</a></li>\n			<li id="n-portal">Autorenportal</a></li>\n			<li id="n-help">Hilfe</a></li>\n			<li id="n-recentchanges">Letzte Ã„nderungen</a></li>\n			<li id="n-contact">Kontakt</a></li>\n			<li id="n-sitesupport">Spenden</a></li>\n		</ul>\n	</div>\n</div>\n\n<!-- /Mitmachen -->\n\n<!-- coll-print_export -->\n<div class="portal" id=''p-coll-print_export''>\n	<h5>Drucken/exportieren</h5>\n	<div class="body">\n		<ul id="collectionPortletList"><li id="coll-create_a_book">Buch erstellen</a></li><li id="coll-download-as-rl">Als PDF herunterladen</a></li><li id="t-print">Druckversion</a></li></ul>	</div>\n</div>\n\n<!-- /coll-print_export -->\n\n<!-- TOOLBOX -->\n<div class="portal" id=''p-tb''>\n	<h5>Werkzeuge</h5>\n	<div class="body">\n		<ul>\n			<li id="t-whatlinkshere">Links auf diese Seite</a></li>\n			<li id="t-recentchangeslinked">Ã„nderungen an verlinkten Seiten</a></li>\n			<li id="t-specialpages">Spezialseiten</a></li>\n			<li id="t-permalink">Permanenter Link</a></li>\n<li id="t-cite">Seite zitieren</a></li>		</ul>\n	</div>\n</div>\n\n<!-- /TOOLBOX -->\n\n<!-- LANGUAGES -->\n<div class="portal" id=''p-lang''>\n	<h5>In anderen Sprachen</h5>\n	<div class="body">\n		<ul>\n			<li class="interwiki-da">Dansk</a></li>\n			<li class="interwiki-nl">Nederlands</a></li>\n			<li class="interwiki-pt">PortuguÃªs</a></li>\n			<li class="interwiki-ru">Ð ÑƒÑÑÐºÐ¸Ð¹</a></li>\n		</ul>\n	</div>\n</div>\n\n<!-- /LANGUAGES -->\n			</div>\n		<!-- /panel -->\n		<!-- footer -->\n		<div id="footer">\n							<ul id="footer-info">\n											<li id="footer-info-lastmod"> Diese Seite wurde zuletzt am 20. April 2012 um 02:08 Uhr geÃ¤ndert.</li>\n											<li id="footer-info-copyright">Der Text ist unter der Lizenz â€žCreative Commons Attribution/Share Alikeâ€œ</a> verfÃ¼gbar; zusÃ¤tzliche Bedingungen kÃ¶nnen anwendbar sein.\nEinzelheiten sind in den Nutzungsbedingungen</a> beschrieben.<br />\nWikipediaÂ® ist eine eingetragene Marke der Wikimedia Foundation Inc.<br /></li>\n									</ul>\n							<ul id="footer-places">\n											<li id="footer-places-privacy">Datenschutz</a></li>\n											<li id="footer-places-about">Ãœber Wikipedia</a></li>\n											<li id="footer-places-disclaimer">Impressum</a></li>\n											<li id="footer-places-mobileview">Mobile Ansicht</a></li>\n									</ul>\n										<ul id="footer-icons" class="noprint">\n					<li id="footer-copyrightico">\n						<img src="//bits.wikimedia.org/images/wikimedia-button.png" width="88" height="31" alt="Wikimedia Foundation"/></a>\n					</li>\n					<li id="footer-poweredbyico">\n						<img src="//bits.wikimedia.org/skins-1.20wmf1/common/images/poweredby_mediawiki_88x31.png" alt="Powered by MediaWiki" width="88" height="31" /></a>\n					</li>\n				</ul>\n						<div style="clear:both"></div>\n		</div>\n		<!-- /footer -->\n		<script src="//bits.wikimedia.org/de.wikipedia.org/load.php?debug=false&amp;lang=de&amp;modules=skins.vector&amp;only=scripts&amp;skin=vector&amp;*" type="text/javascript"></script>\n<script type="text/javascript">if(window.mw){\nmw.loader.load(["mediawiki.user","mediawiki.page.ready","mediawiki.legacy.mwsuggest","ext.vector.collapsibleNav","ext.vector.collapsibleTabs","ext.vector.editWarning","ext.vector.simpleSearch","ext.flaggedRevs.advanced"], null, true);\n}</script>\n<script src="/w/index.php?title=Spezial:BannerController&amp;cache=/cn.js&amp;303-4" type="text/javascript"></script>\n<script src="//bits.wikimedia.org/de.wikipedia.org/load.php?debug=false&amp;lang=de&amp;modules=site&amp;only=scripts&amp;skin=vector&amp;*" type="text/javascript"></script>\n<script src="//geoiplookup.wikimedia.org/" type="text/javascript"></script><!-- Served by mw17 in 0.179 secs. -->\n	</body>\n</html>\n', 'http://de.wikipedia.org/wiki/Beispiel', 0, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`userID`, `first_name`, `last_name`, `email`, `job`, `adresse`) VALUES
(2, 'Peter', 'Kornowski', 'pkornski@googlemail.com', 'Student', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `usertopic`
--

CREATE TABLE IF NOT EXISTS `usertopic` (
  `userID` int(11) NOT NULL,
  `topicID` int(11) NOT NULL,
  `userName` varchar(20) DEFAULT NULL,
  `hash` char(32) NOT NULL,
  PRIMARY KEY (`userID`,`topicID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
