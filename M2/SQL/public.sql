USE `public`;

CREATE TABLE IF NOT EXISTS `deklarationen` (
  `Zeichen` varchar(2) NOT NULL,
  `Beschriftung` varchar(32) NOT NULL,
  PRIMARY KEY (`Zeichen`)
)

IdeklarationenNSERT INTO `deklarationen` (`Zeichen`, `Beschriftung`) VALUES
	('10', 'enthält eine Phenylalaninquelle'),
	('2', 'Konservierungsstoff'),
	('3', 'Antioxidationsmittel'),
	('4', 'Geschmacksverstärker'),
	('5', 'geschwefelt'),
	('6', 'geschwärzt'),
	('7', 'gewachst'),
	('8', 'Phosphat'),
	('9', 'Süßungsmittel'),
	('A', 'Gluten'),
	('A1', 'Weizen'),
	('A2', 'Roggen'),
	('A3', 'Gerste'),
	('A4', 'Hafer'),
	('A5', 'Dinkel'),
	('B', 'Sellerie'),
	('C', 'Krebstiere'),
	('D', 'Eier'),
	('E', 'Fische'),
	('F', 'Erdnüsse'),
	('G', 'Sojabohnen'),
	('H', 'Milch'),
	('I', 'Schalenfrüchte'),
	('I1', 'Mandeln'),
	('I2', 'Haselnüsse'),
	('I3', 'Walnüsse'),
	('I4', 'Kaschunüsse'),
	('I5', 'Pecannüsse'),
	('I6', 'Paranüsse'),
	('I7', 'Pistazien'),
	('I8', 'Macadamianüsse'),
	('J', 'Senf'),
	('K', 'Sesamsamen'),
	('L', 'Schwefeldioxid oder Sulfite'),
	('M', 'Lupinen'),
	('N', 'Weichtiere');

CREATE TABLE IF NOT EXISTS `fachbereiche` (
  `Webseite` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Adresse` varchar(255) NOT NULL,
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
)

INSERT INTO `fachbereiche` (`Webseite`, `Name`, `Adresse`, `ID`) VALUES
	('https://www.fh-aachen.de/fachbereiche/architektur/', 'Architektur', 'Bayernallee 9, 52066 Aachen', 1),
	('https://www.fh-aachen.de/fachbereiche/bauingenieurwesen/', 'Bauingenieurwesen', 'Bayernallee 9, 52066 Aachen', 2),
	('https://www.fh-aachen.de/fachbereiche/chemieundbiotechnologie/', 'Chemie und Biotechnologie', 'Heinrich-Mußmann-Straße 1, 52428 Jülich', 3),
	('https://www.fh-aachen.de/fachbereiche/gestaltung/', 'Gestaltung', 'Boxgraben 100, 52064 Aachen', 4),
	('https://www.fh-aachen.de/fachbereiche/elektrotechnik-und-informationstechnik/', 'Elektrotechnik und Informationstechnik', 'Eupener Straße 70, 52066 Aachen', 5),
	('https://www.fh-aachen.de/fachbereiche/luft-und-raumfahrttechnik/', 'Luft- und Raumfahrttechnik', 'Hohenstaufenallee 6, 52064 Aachen', 6),
	('https://www.fh-aachen.de/fachbereiche/wirtschaft/', 'Wirtschaftswissenschaften', 'Eupener Straße 70, 52066 Aachen', 7),
	('https://www.fh-aachen.de/fachbereiche/maschinenbau-und-mechatronik/', 'Maschinenbau und Mechatronik', 'Goethestraße 1, 52064 Aachen', 8),
	('https://www.fh-aachen.de/fachbereiche/medizintechnik-und-technomathematik/', 'Medizintechnik und Technomathematik', 'Heinrich-Mußmann-Straße 1, 52428 Jülich', 9),
	('https://www.fh-aachen.de/fachbereiche/energietechnik/', 'Energietechnik', 'Heinrich-Mußmann-Straße 1, 52428 Jülich', 10);

CREATE TABLE IF NOT EXISTS `info` (
  `Text` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Zeitpunkt` date DEFAULT NULL
) 

INSERT INTO `info` (`Text`, `Zeitpunkt`) VALUES
	('Wenn Sie dies lesen können, haben Sie sich erfolgreich am MariaDB Server angemeldet. ;)', '2019-10-30');

CREATE TABLE IF NOT EXISTS `zutaten` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Bio` tinyint(1) NOT NULL DEFAULT 0,
  `Vegan` tinyint(1) NOT NULL DEFAULT 0,
  `Vegetarisch` tinyint(1) NOT NULL DEFAULT 0,
  `Glutenfrei` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`)
)

INSERT INTO `zutaten` (`ID`, `Name`, `Bio`, `Vegan`, `Vegetarisch`, `Glutenfrei`) VALUES
	(1, 'Fisch', 1, 0, 1, 1),
	(2, 'Paniermehl', 1, 1, 1, 0),
	(80, 'Aal', 0, 0, 0, 1),
	(81, 'Forelle', 0, 0, 0, 1),
	(82, 'Barsch', 0, 0, 0, 1),
	(83, 'Lachs', 0, 0, 0, 1),
	(84, 'Lachs', 1, 0, 0, 1),
	(85, 'Heilbutt', 0, 0, 0, 1),
	(86, 'Heilbutt', 1, 0, 0, 1),
	(100, 'Kurkumin', 1, 1, 1, 1),
	(101, 'Riboflavin', 0, 1, 1, 1),
	(123, 'Amaranth', 1, 1, 1, 1),
	(150, 'Zuckerkulör', 0, 1, 1, 1),
	(171, 'Titandioxid', 0, 1, 1, 1),
	(220, 'Schwefeldioxid', 0, 1, 1, 1),
	(270, 'Milchsäure', 0, 1, 1, 1),
	(322, 'Lecithin', 0, 1, 1, 1),
	(330, 'Zitronensäure', 1, 1, 1, 1),
	(999, 'Weizenmehl', 1, 1, 1, 0),
	(1000, 'Weizenmehl', 0, 1, 1, 0),
	(1001, 'Hanfmehl', 1, 1, 1, 1),
	(1010, 'Zucker', 0, 1, 1, 1),
	(1013, 'Traubenzucker', 0, 1, 1, 1),
	(1015, 'Branntweinessig', 0, 1, 1, 1),
	(2019, 'Karotten', 0, 1, 1, 1),
	(2020, 'Champignons', 0, 1, 1, 1),
	(2101, 'Schweinefleisch', 0, 0, 0, 1),
	(2102, 'Speck', 0, 0, 0, 1),
	(2103, 'Alginat', 0, 1, 1, 1),
	(2105, 'Paprika', 0, 1, 1, 1),
	(2107, 'Fenchel', 0, 1, 1, 1),
	(2108, 'Sellerie', 0, 1, 1, 1),
	(9020, 'Champignons', 1, 1, 1, 1),
	(9105, 'Paprika', 1, 1, 1, 1),
	(9107, 'Fenchel', 1, 1, 1, 1),
	(9110, 'Sojasprossen', 1, 1, 1, 1);