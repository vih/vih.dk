-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- Host: mysql.vih.dk
-- Generation Time: Sep 17, 2009 at 12:15 AM
-- Server version: 4.1.16
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `vih`
--

-- --------------------------------------------------------

--
-- Table structure for table `aarsskrift`
--

CREATE TABLE IF NOT EXISTS `aarsskrift` (
  `id` int(11) NOT NULL auto_increment,
  `aar` int(4) NOT NULL default '0',
  `tema` text NOT NULL,
  `kolofon` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `aarsskrift_tekst`
--

CREATE TABLE IF NOT EXISTS `aarsskrift_tekst` (
  `id` int(11) NOT NULL auto_increment,
  `dato` date NOT NULL default '0000-00-00',
  `aarsskrift_id` int(11) NOT NULL default '0',
  `forfatter` varchar(255) NOT NULL default '',
  `overskrift` varchar(255) NOT NULL default '',
  `tekst` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Table structure for table `adresse`
--

CREATE TABLE IF NOT EXISTS `adresse` (
  `id` int(11) NOT NULL auto_increment,
  `fornavn` varchar(255) NOT NULL default '',
  `efternavn` varchar(255) NOT NULL default '',
  `adresse` text NOT NULL,
  `postnr` int(11) NOT NULL default '0',
  `postby` varchar(255) NOT NULL default '',
  `mobil` varchar(50) NOT NULL default '',
  `telefon` varchar(50) NOT NULL default '',
  `arbejdstelefon` varchar(50) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `date_changed` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=14075 ;

-- --------------------------------------------------------

--
-- Table structure for table `ansat`
--

CREATE TABLE IF NOT EXISTS `ansat` (
  `id` int(11) NOT NULL auto_increment,
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_stoppet` date NOT NULL default '0000-00-00',
  `fornavn` varchar(255) NOT NULL default '',
  `efternavn` varchar(255) NOT NULL default '',
  `adresse` varchar(255) NOT NULL default '',
  `postnr` varchar(255) NOT NULL default '',
  `postby` varchar(255) NOT NULL default '',
  `titel` varchar(255) NOT NULL default '',
  `date_birthday` date NOT NULL default '0000-00-00',
  `date_ansat` date NOT NULL default '0000-00-00',
  `extra_info` text NOT NULL,
  `email` varchar(255) NOT NULL default '',
  `website` varchar(255) NOT NULL default '',
  `telefon` varchar(255) NOT NULL default '0',
  `mobil` varchar(255) NOT NULL default '0',
  `beskrivelse` text NOT NULL,
  `published` tinyint(1) NOT NULL default '1',
  `funktion_id` int(11) NOT NULL default '1',
  `pic_id` int(11) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  `password` varchar(255) NOT NULL default 'f476cc904d3ad684b89e053dc8af3240',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=129 ;

-- --------------------------------------------------------

--
-- Table structure for table `ansat_funktion`
--

CREATE TABLE IF NOT EXISTS `ansat_funktion` (
  `id` int(11) NOT NULL auto_increment,
  `funktion_key` int(11) NOT NULL default '0',
  `ansat_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ansat_x_fag`
--

CREATE TABLE IF NOT EXISTS `ansat_x_fag` (
  `id` int(11) NOT NULL auto_increment,
  `ansat_id` int(11) NOT NULL default '0',
  `fag_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `ansat_id` (`ansat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=571 ;

-- --------------------------------------------------------

--
-- Table structure for table `betaling`
--

CREATE TABLE IF NOT EXISTS `betaling` (
  `id` int(11) NOT NULL auto_increment,
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `belong_to` int(11) NOT NULL default '0',
  `belong_to_id` int(11) NOT NULL default '0',
  `type` int(11) NOT NULL default '0',
  `amount` float(11,2) NOT NULL default '0.00',
  `transactionnumber` int(11) NOT NULL default '0',
  `status` int(11) NOT NULL default '0',
  `active` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `belong_to` (`belong_to`,`belong_to_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=9300 ;

-- --------------------------------------------------------

--
-- Table structure for table `betaling_online`
--

CREATE TABLE IF NOT EXISTS `betaling_online` (
  `id` int(11) NOT NULL auto_increment,
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `type` varchar(255) NOT NULL default '',
  `transaktionsnummer` int(11) NOT NULL default '0',
  `status` varchar(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2471 ;

-- --------------------------------------------------------

--
-- Table structure for table `brugervurdering`
--

CREATE TABLE IF NOT EXISTS `brugervurdering` (
  `id` int(11) NOT NULL auto_increment,
  `dato` date NOT NULL default '0000-00-00',
  `tidligerebesoeg` int(11) NOT NULL default '0',
  `soegte` text NOT NULL,
  `fundet` int(11) NOT NULL default '0',
  `finderundt` int(11) NOT NULL default '0',
  `indhold` int(11) NOT NULL default '0',
  `aaben` int(11) NOT NULL default '0',
  `hvor` int(11) NOT NULL default '0',
  `kommentar` text NOT NULL,
  `aar` int(11) NOT NULL default '0',
  `email` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=251 ;

-- --------------------------------------------------------

--
-- Table structure for table `brugervurdering_hvor`
--

CREATE TABLE IF NOT EXISTS `brugervurdering_hvor` (
  `id` int(11) NOT NULL auto_increment,
  `tekst` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `core_translation_i18n`
--

CREATE TABLE IF NOT EXISTS `core_translation_i18n` (
  `page_id` varchar(50) default NULL,
  `id` text NOT NULL,
  `dk` text,
  `uk` text,
  UNIQUE KEY `i18n_page_id_id_index` (`page_id`,`id`(255)),
  KEY `i18n_page_id_index` (`page_id`),
  KEY `i18n_id_index` (`id`(255))
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `core_translation_langs`
--

CREATE TABLE IF NOT EXISTS `core_translation_langs` (
  `id` varchar(16) default NULL,
  `name` varchar(200) default NULL,
  `meta` text,
  `error_text` varchar(250) default NULL,
  `encoding` varchar(16) default NULL,
  UNIQUE KEY `langs_id_index` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dankort_payment`
--

CREATE TABLE IF NOT EXISTS `dankort_payment` (
  `id` int(11) NOT NULL auto_increment,
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `type` varchar(255) NOT NULL default '',
  `belong_to_id` int(11) NOT NULL default '0',
  `transactionnumber` varchar(255) NOT NULL default '',
  `amount` double(11,2) NOT NULL default '0.00',
  `status` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

-- --------------------------------------------------------

--
-- Table structure for table `dbquery_result`
--

CREATE TABLE IF NOT EXISTS `dbquery_result` (
  `id` int(11) NOT NULL auto_increment,
  `intranet_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `session_id` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `toplevel` int(11) NOT NULL default '0',
  `dbquery_condition` blob NOT NULL,
  `joins` blob NOT NULL,
  `keyword` blob NOT NULL,
  `first_character` varchar(255) NOT NULL default '',
  `paging` int(11) NOT NULL default '0',
  `sorting` blob NOT NULL,
  `filter` blob NOT NULL,
  `date_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `intranet_id` (`intranet_id`,`user_id`,`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=142 ;

-- --------------------------------------------------------

--
-- Table structure for table `dokumenter`
--

CREATE TABLE IF NOT EXISTS `dokumenter` (
  `id` int(11) NOT NULL auto_increment,
  `thiskey` varchar(255) NOT NULL default '',
  `file_id` int(11) NOT NULL default '0',
  `date_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=84 ;

-- --------------------------------------------------------

--
-- Table structure for table `elevforeningen_elevstaevne`
--

CREATE TABLE IF NOT EXISTS `elevforeningen_elevstaevne` (
  `id` int(11) NOT NULL auto_increment,
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `overskrift` varchar(255) NOT NULL default '',
  `beskrivelse` text NOT NULL,
  `pris` int(11) NOT NULL default '0',
  `date_tilmelding` date NOT NULL default '0000-00-00',
  `active` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `elevforeningen_jubilar`
--

CREATE TABLE IF NOT EXISTS `elevforeningen_jubilar` (
  `id` int(11) NOT NULL auto_increment,
  `aargange` text NOT NULL,
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `active` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `elevforeningen_medlemskartotek`
--

CREATE TABLE IF NOT EXISTS `elevforeningen_medlemskartotek` (
  `id` int(11) NOT NULL auto_increment,
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `medlemsnummer` text NOT NULL,
  `adresse_id` int(11) NOT NULL default '0',
  `aargang` varchar(255) NOT NULL default '',
  `kode` varchar(255) NOT NULL default '',
  `birthday` date NOT NULL default '0000-00-00',
  `active` tinyint(1) NOT NULL default '1',
  `code` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=4595 ;

-- --------------------------------------------------------

--
-- Table structure for table `elevudtalelse`
--

CREATE TABLE IF NOT EXISTS `elevudtalelse` (
  `id` int(11) NOT NULL auto_increment,
  `dato` date NOT NULL default '0000-00-00',
  `citat` text NOT NULL,
  `elev` varchar(255) NOT NULL default '',
  `kategori_id` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `facilitet`
--

CREATE TABLE IF NOT EXISTS `facilitet` (
  `id` int(11) NOT NULL auto_increment,
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `oprettet` date NOT NULL default '0000-00-00',
  `redigeret` date NOT NULL default '0000-00-00',
  `overskrift` varchar(255) NOT NULL default '',
  `navn` varchar(255) NOT NULL default '',
  `tekst` text NOT NULL,
  `beskrivelse` text NOT NULL,
  `kategori_id` int(11) NOT NULL default '0',
  `billede` varchar(255) NOT NULL default '',
  `pic_id` int(11) NOT NULL default '0',
  `udgivet` enum('Ja','Nej') NOT NULL default 'Ja',
  `published` tinyint(1) NOT NULL default '1',
  `active` tinyint(1) NOT NULL default '1',
  `title` varchar(255) NOT NULL default '',
  `keywords` text NOT NULL,
  `description` text NOT NULL,
  `identifier` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Table structure for table `facilitet_kategori`
--

CREATE TABLE IF NOT EXISTS `facilitet_kategori` (
  `id` int(11) NOT NULL auto_increment,
  `kategori` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `filehandler_append_file`
--

CREATE TABLE IF NOT EXISTS `filehandler_append_file` (
  `id` int(11) NOT NULL auto_increment,
  `intranet_id` int(11) NOT NULL default '0',
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `belong_to_key` int(11) NOT NULL default '0',
  `belong_to_id` int(11) NOT NULL default '0',
  `file_handler_id` int(11) NOT NULL default '0',
  `description` varchar(255) NOT NULL default '',
  `active` int(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `intranet_id` (`intranet_id`,`belong_to_id`,`file_handler_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `file_handler`
--

CREATE TABLE IF NOT EXISTS `file_handler` (
  `id` int(11) NOT NULL auto_increment,
  `intranet_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_changed` datetime NOT NULL default '0000-00-00 00:00:00',
  `description` text NOT NULL,
  `file_name` varchar(100) NOT NULL default '',
  `server_file_name` varchar(255) NOT NULL default '',
  `file_size` int(11) NOT NULL default '0',
  `_old_file_type` varchar(20) NOT NULL default '',
  `file_type_key` int(11) NOT NULL default '0',
  `accessibility_key` int(11) NOT NULL default '0',
  `access_key` varchar(255) NOT NULL default '',
  `width` int(11) default NULL,
  `height` int(11) default NULL,
  `active` int(11) NOT NULL default '1',
  `temporary` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=797 ;

-- --------------------------------------------------------

--
-- Table structure for table `file_handler_instance`
--

CREATE TABLE IF NOT EXISTS `file_handler_instance` (
  `id` int(11) NOT NULL auto_increment,
  `intranet_id` int(11) NOT NULL default '0',
  `file_handler_id` int(11) NOT NULL default '0',
  `type_key` int(11) NOT NULL default '0',
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_changed` datetime NOT NULL default '0000-00-00 00:00:00',
  `server_file_name` varchar(255) NOT NULL default '',
  `width` int(11) NOT NULL default '0',
  `height` int(11) NOT NULL default '0',
  `file_size` varchar(20) NOT NULL default '',
  `active` int(11) NOT NULL default '1',
  `crop_parameter` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2586 ;

-- --------------------------------------------------------

--
-- Table structure for table `file_handler_instance_type`
--

CREATE TABLE IF NOT EXISTS `file_handler_instance_type` (
  `id` int(11) NOT NULL auto_increment,
  `intranet_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `type_key` int(11) NOT NULL default '0',
  `max_height` int(11) NOT NULL default '0',
  `max_width` int(11) NOT NULL default '0',
  `resize_type_key` int(11) NOT NULL default '0',
  `active` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `fotogalleri`
--

CREATE TABLE IF NOT EXISTS `fotogalleri` (
  `id` int(11) NOT NULL auto_increment,
  `description` varchar(255) NOT NULL default '',
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `active` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `historik`
--

CREATE TABLE IF NOT EXISTS `historik` (
  `id` int(11) NOT NULL auto_increment,
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_user_id` int(11) NOT NULL default '0',
  `belong_to` int(11) NOT NULL default '0',
  `belong_to_id` int(11) NOT NULL default '0',
  `type` int(11) NOT NULL default '0',
  `comment` varchar(255) NOT NULL default '',
  `betaling_id` int(11) NOT NULL default '0',
  `active` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=18346 ;

-- --------------------------------------------------------

--
-- Table structure for table `keyword`
--

CREATE TABLE IF NOT EXISTS `keyword` (
  `id` int(11) NOT NULL auto_increment,
  `intranet_id` int(11) NOT NULL default '0',
  `keyword` varchar(255) NOT NULL default '',
  `type` varchar(255) NOT NULL default '',
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `intranet_id` (`intranet_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=226 ;

-- --------------------------------------------------------

--
-- Table structure for table `keyword_x_object`
--

CREATE TABLE IF NOT EXISTS `keyword_x_object` (
  `id` int(11) NOT NULL auto_increment,
  `intranet_id` int(11) NOT NULL default '0',
  `belong_to` int(11) NOT NULL default '0',
  `keyword_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `intranet_id` (`intranet_id`),
  KEY `belong_to` (`belong_to`),
  KEY `keyword_id` (`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=775 ;

-- --------------------------------------------------------

--
-- Table structure for table `kortkursus`
--

CREATE TABLE IF NOT EXISTS `kortkursus` (
  `id` int(11) NOT NULL auto_increment,
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `navn` varchar(255) NOT NULL default '',
  `minimumsalder` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `keywords` text NOT NULL,
  `description` text NOT NULL,
  `tekst` text NOT NULL,
  `beskrivelse` text NOT NULL,
  `type` enum('Voksenkursus','Familiekursus','Seniorkursus','Udviklingshæmmede') NOT NULL default 'Voksenkursus',
  `gruppe_id` int(11) NOT NULL default '0',
  `_old_billede` varchar(255) NOT NULL default '',
  `underviser_id` int(11) NOT NULL default '0',
  `ansat_id` int(11) NOT NULL default '0',
  `uge` varchar(255) NOT NULL default '',
  `dato_start` date NOT NULL default '0000-00-00',
  `dato_slut` date NOT NULL default '0000-00-00',
  `pris` int(11) NOT NULL default '0',
  `pris_boern` int(11) NOT NULL default '0',
  `pris_depositum` int(11) NOT NULL default '0',
  `pris_afbestillingsforsikring` int(11) NOT NULL default '0',
  `boernepris` int(11) NOT NULL default '0',
  `indkvartering` enum('På højskolen','I kursuscenteret') NOT NULL default 'I kursuscenteret',
  `indkvartering_key` int(11) NOT NULL default '0',
  `pladser` int(11) NOT NULL default '0',
  `vaerelser` int(11) NOT NULL default '0',
  `status` enum('Udsolgt','Få ledige pladser','Ledige pladser') NOT NULL default 'Ledige pladser',
  `fotoalbum_id` int(11) NOT NULL default '0',
  `tilmeldingsmulighed` enum('Ja','Nej') NOT NULL default 'Ja',
  `published` tinyint(1) NOT NULL default '1',
  `vist` int(11) NOT NULL default '0',
  `nyhed` tinyint(1) NOT NULL default '0',
  `pic_id` int(11) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  `begyndere` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=269 ;

-- --------------------------------------------------------

--
-- Table structure for table `kortkursus_betaling`
--

CREATE TABLE IF NOT EXISTS `kortkursus_betaling` (
  `id` int(11) NOT NULL auto_increment,
  `tilmelding_id` int(11) NOT NULL default '0',
  `dato` datetime NOT NULL default '0000-00-00 00:00:00',
  `tekst` varchar(255) NOT NULL default '',
  `beloeb` float(11,2) NOT NULL default '0.00',
  `type` varchar(255) NOT NULL default 'automatisk',
  `transaktionsnummer` int(11) NOT NULL default '0',
  `created_by_user_id` int(11) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `tilmelding_id` (`tilmelding_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5636 ;

-- --------------------------------------------------------

--
-- Table structure for table `kortkursus_brev`
--

CREATE TABLE IF NOT EXISTS `kortkursus_brev` (
  `id` int(11) NOT NULL auto_increment,
  `dato` date NOT NULL default '0000-00-00',
  `overskrift` varchar(255) NOT NULL default '',
  `tekst` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `kortkursus_deltager_ny`
--

CREATE TABLE IF NOT EXISTS `kortkursus_deltager_ny` (
  `id` int(11) NOT NULL auto_increment,
  `tilmelding_id` int(11) NOT NULL default '0',
  `fornavn` varchar(255) NOT NULL default '',
  `efternavn` varchar(255) NOT NULL default '',
  `aar` varchar(255) NOT NULL default '',
  `cpr` varchar(15) NOT NULL default '',
  `enevaerelse` varchar(255) NOT NULL default '',
  `active` tinyint(1) NOT NULL default '1',
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `tilmelding_id` (`tilmelding_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=10799 ;

-- --------------------------------------------------------

--
-- Table structure for table `kortkursus_deltager_oplysninger_ny`
--

CREATE TABLE IF NOT EXISTS `kortkursus_deltager_oplysninger_ny` (
  `id` int(11) NOT NULL auto_increment,
  `deltager_id` int(11) NOT NULL default '0',
  `art` varchar(255) NOT NULL default '',
  `indhold` varchar(255) NOT NULL default '',
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `deltager_id` (`deltager_id`),
  KEY `art` (`art`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=12098 ;

-- --------------------------------------------------------

--
-- Table structure for table `kortkursus_tilmelding`
--

CREATE TABLE IF NOT EXISTS `kortkursus_tilmelding` (
  `id` int(11) NOT NULL auto_increment,
  `_old_dato` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `_old_fornavn` varchar(100) NOT NULL default '',
  `_old_efternavn` varchar(255) NOT NULL default '',
  `adresse_id` int(11) NOT NULL default '0',
  `kortkursus_id` int(11) NOT NULL default '0',
  `besked` text NOT NULL,
  `session_id` varchar(255) NOT NULL default '',
  `_old_dankort_session_id` varchar(255) NOT NULL default '',
  `ip` varchar(50) NOT NULL default '',
  `_old_status` enum('Tilmeldt','Venteliste','Undervejs','Annulleret','Ikke tilmeldt') NOT NULL default 'Ikke tilmeldt',
  `status_key` int(11) NOT NULL default '0',
  `_old_wanted` int(11) NOT NULL default '0',
  `antal_deltagere` int(11) NOT NULL default '0',
  `afbestillingsforsikring` enum('Ja','Nej') NOT NULL default 'Nej',
  `pris_afbestillingsforsikring` int(11) NOT NULL default '0',
  `_old_emailkontakt` enum('Ja','Nej') NOT NULL default 'Nej',
  `_old_betalingsform` enum('dankort','check','girokort') NOT NULL default 'girokort',
  `_old_transaktions_id` varchar(255) NOT NULL default '',
  `rabat` float(11,2) NOT NULL default '0.00',
  `faerdigbetalt` int(11) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  `code` varchar(255) NOT NULL default '',
  `pic_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `kortkursus_id` (`kortkursus_id`),
  KEY `session_id` (`session_id`),
  KEY `date_created` (`date_created`),
  KEY `date_updated` (`date_updated`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=6600 ;

-- --------------------------------------------------------

--
-- Table structure for table `kortkursus_tilmelding_oplysninger`
--

CREATE TABLE IF NOT EXISTS `kortkursus_tilmelding_oplysninger` (
  `id` int(11) NOT NULL auto_increment,
  `tilmelding_id` int(11) NOT NULL default '0',
  `art` varchar(255) NOT NULL default '',
  `indhold` varchar(255) NOT NULL default '',
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `tilmelding_id` (`tilmelding_id`),
  KEY `art` (`art`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=203 ;

-- --------------------------------------------------------

--
-- Table structure for table `kunst`
--

CREATE TABLE IF NOT EXISTS `kunst` (
  `id` int(11) NOT NULL auto_increment,
  `redigeret` date NOT NULL default '0000-00-00',
  `aar` int(11) NOT NULL default '0',
  `kunstner` varchar(255) NOT NULL default '',
  `titel` varchar(255) NOT NULL default '',
  `tekst` text NOT NULL,
  `placering` varchar(255) NOT NULL default '',
  `billede` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `kursuscenter_evaluering`
--

CREATE TABLE IF NOT EXISTS `kursuscenter_evaluering` (
  `id` int(11) NOT NULL auto_increment,
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `dato` date NOT NULL default '0000-00-00',
  `kursus` varchar(255) NOT NULL default '',
  `manglerfaciliteter` text NOT NULL,
  `kenderfra` text NOT NULL,
  `forbedring` text NOT NULL,
  `kommentarer` text NOT NULL,
  `vaerelse` text NOT NULL,
  `kursussted` tinyint(1) NOT NULL default '0',
  `faciliteter` tinyint(1) NOT NULL default '0',
  `forplejning` tinyint(1) NOT NULL default '0',
  `rengoring` tinyint(1) NOT NULL default '0',
  `indkvartering` tinyint(1) NOT NULL default '0',
  `service` tinyint(1) NOT NULL default '0',
  `omgivelser` tinyint(1) NOT NULL default '0',
  `sammenligning` tinyint(1) NOT NULL default '0',
  `forventninger` tinyint(1) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

-- --------------------------------------------------------

--
-- Table structure for table `langtkursus`
--

CREATE TABLE IF NOT EXISTS `langtkursus` (
  `id` int(11) NOT NULL auto_increment,
  `date_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `navn` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `soegestreng` varchar(255) NOT NULL default '',
  `shorturl` varchar(255) NOT NULL default '',
  `ugeantal` int(11) NOT NULL default '0',
  `dato_start` date NOT NULL default '0000-00-00',
  `dato_slut` date NOT NULL default '0000-00-00',
  `kort_beskrivelse` text NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `lang_beskrivelse` text NOT NULL,
  `beskrivelse` text NOT NULL,
  `tema` text NOT NULL,
  `ugepris` int(11) NOT NULL default '0',
  `materialepris` int(11) NOT NULL default '0',
  `rejsedepositum` int(11) NOT NULL default '1300',
  `rejsepris` int(11) NOT NULL default '0',
  `noegledepositum` int(11) NOT NULL default '0',
  `depositum` int(11) NOT NULL default '0',
  `pris_uge` float(11,2) NOT NULL default '0.00',
  `pris_materiale` float(11,2) NOT NULL default '0.00',
  `pris_rejsedepositum` float(11,2) NOT NULL default '0.00',
  `pris_rejserest` int(11) NOT NULL default '0',
  `pris_rejselinje` float(11,2) NOT NULL default '0.00',
  `pris_noegledepositum` float(11,2) NOT NULL default '0.00',
  `pris_tilmeldingsgebyr` float(11,2) NOT NULL default '0.00',
  `published` tinyint(1) NOT NULL default '1',
  `underviser_id` int(11) NOT NULL default '0',
  `ansat_id` int(11) NOT NULL default '0',
  `belong_to` int(11) NOT NULL default '0',
  `belong_to_id` int(11) NOT NULL default '0',
  `tekst_diplom` text NOT NULL,
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

-- --------------------------------------------------------

--
-- Table structure for table `langtkursus_fag`
--

CREATE TABLE IF NOT EXISTS `langtkursus_fag` (
  `id` int(11) NOT NULL auto_increment,
  `identifier` varchar(255) NOT NULL default '',
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `_old_oprettet` date NOT NULL default '0000-00-00',
  `navn` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `keywords` text NOT NULL,
  `description` text NOT NULL,
  `beskrivelse` text NOT NULL,
  `_old_billede` varchar(255) NOT NULL default '',
  `_old_lille_billede` varchar(255) NOT NULL default '',
  `fag_gruppe_id` int(11) NOT NULL default '0',
  `_old_udgivet` enum('Ja','Nej') NOT NULL default 'Ja',
  `pic_id` int(11) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `_old_redigeret` date NOT NULL default '0000-00-00',
  `active` tinyint(1) NOT NULL default '1',
  `valgfag` tinyint(1) NOT NULL default '0',
  `kort_beskrivelse` text NOT NULL,
  `udvidet_beskrivelse` text NOT NULL,
  `belongs_to_fag_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=119 ;

-- --------------------------------------------------------

--
-- Table structure for table `langtkursus_fag_gruppe`
--

CREATE TABLE IF NOT EXISTS `langtkursus_fag_gruppe` (
  `id` int(11) NOT NULL auto_increment,
  `navn` varchar(255) NOT NULL default '',
  `beskrivelse` text NOT NULL,
  `billede` varchar(255) NOT NULL default '',
  `valgfag` tinyint(1) NOT NULL default '0',
  `vis_diplom` tinyint(1) NOT NULL default '1',
  `position` int(11) NOT NULL default '0',
  `show_description` int(1) NOT NULL default '0',
  `published` int(1) NOT NULL default '1',
  `active` int(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `langtkursus_fag_periode`
--

CREATE TABLE IF NOT EXISTS `langtkursus_fag_periode` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `date_start` date NOT NULL default '0000-00-00',
  `date_end` date NOT NULL default '0000-00-00',
  `langtkursus_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3110 ;

-- --------------------------------------------------------

--
-- Table structure for table `langtkursus_rate`
--

CREATE TABLE IF NOT EXISTS `langtkursus_rate` (
  `id` int(11) NOT NULL auto_increment,
  `langtkursus_id` int(11) NOT NULL default '0',
  `betalingsdato` date NOT NULL default '0000-00-00',
  `beloeb` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=287 ;

-- --------------------------------------------------------

--
-- Table structure for table `langtkursus_tilmelding`
--

CREATE TABLE IF NOT EXISTS `langtkursus_tilmelding` (
  `id` int(11) NOT NULL auto_increment,
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `kursus_id` int(11) NOT NULL default '0',
  `adresse_id` int(11) NOT NULL default '0',
  `vaerelse` varchar(255) NOT NULL default '',
  `cpr` varchar(15) NOT NULL default '',
  `kontakt_adresse_id` int(11) NOT NULL default '0',
  `uddannelse` int(11) NOT NULL default '0',
  `betaling` int(11) NOT NULL default '0',
  `ryger` varchar(255) NOT NULL default '0',
  `fag_id` int(11) NOT NULL default '0',
  `besked` text NOT NULL,
  `session_id` varchar(255) NOT NULL default '',
  `ip` varchar(255) NOT NULL default '',
  `nationalitet` varchar(255) NOT NULL default '',
  `pris_rejserest` int(11) NOT NULL default '0',
  `ugeantal` int(11) NOT NULL default '0',
  `dato_start` date NOT NULL default '0000-00-00',
  `dato_slut` date NOT NULL default '0000-00-00',
  `pris_tilmeldingsgebyr` int(11) NOT NULL default '0',
  `pris_materiale` int(11) NOT NULL default '0',
  `pris_uge` int(11) NOT NULL default '0',
  `pris_rejsedepositum` int(11) NOT NULL default '0',
  `pris_rejselinje` int(11) NOT NULL default '0',
  `pris_noegledepositum` int(11) NOT NULL default '0',
  `kommune` varchar(255) NOT NULL default '',
  `elevstotte` double(11,2) NOT NULL default '0.00',
  `ugeantal_elevstotte` int(11) NOT NULL default '0',
  `kompetencestotte` double(11,2) NOT NULL default '0.00',
  `statsstotte` int(11) NOT NULL default '0',
  `kommunestotte` float(11,2) NOT NULL default '0.00',
  `aktiveret_tillaeg` double(11,2) NOT NULL default '0.00',
  `_old_afbrudt_uger_deltaget` int(11) NOT NULL default '0',
  `pris_afbrudt_ophold` int(11) NOT NULL default '0',
  `faerdigbetalt` int(11) NOT NULL default '0',
  `_old_status` enum('Undervejs','Ikke tilmeldt','Tilmeldt','Venteliste','Annulleret','Accepteret','Afbrudt ophold') NOT NULL default 'Undervejs',
  `status_key` int(11) NOT NULL default '0',
  `active` int(11) NOT NULL default '1',
  `_old_hovedfag` varchar(255) NOT NULL default '',
  `code` varchar(255) NOT NULL default '',
  `pic_id` int(11) NOT NULL default '0',
  `tekst_diplom` text NOT NULL,
  `sex` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `kursus_id` (`kursus_id`),
  KEY `adresse_id` (`adresse_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=13011 ;

-- --------------------------------------------------------

--
-- Table structure for table `langtkursus_tilmelding_protokol_item`
--

CREATE TABLE IF NOT EXISTS `langtkursus_tilmelding_protokol_item` (
  `id` int(11) NOT NULL auto_increment,
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `type_key` int(11) NOT NULL default '0',
  `tilmelding_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `text` text NOT NULL,
  `date_start` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_end` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `tilmelding_id` (`tilmelding_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3106 ;

-- --------------------------------------------------------

--
-- Table structure for table `langtkursus_tilmelding_rate`
--

CREATE TABLE IF NOT EXISTS `langtkursus_tilmelding_rate` (
  `id` int(11) NOT NULL auto_increment,
  `langtkursus_tilmelding_id` int(11) NOT NULL default '0',
  `betalingsdato` date NOT NULL default '0000-00-00',
  `beloeb` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `langtkursus_tilmelding_id` (`langtkursus_tilmelding_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3013 ;

-- --------------------------------------------------------

--
-- Table structure for table `langtkursus_tilmelding_x_fag`
--

CREATE TABLE IF NOT EXISTS `langtkursus_tilmelding_x_fag` (
  `id` int(11) NOT NULL auto_increment,
  `fag_id` int(11) NOT NULL default '0',
  `tilmelding_id` int(11) NOT NULL default '0',
  `hold` int(11) NOT NULL default '0',
  `periode_id` int(11) NOT NULL default '0',
  `test` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `tilmelding_id` (`tilmelding_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=6615 ;

-- --------------------------------------------------------

--
-- Table structure for table `langtkursus_x_fag`
--

CREATE TABLE IF NOT EXISTS `langtkursus_x_fag` (
  `id` int(11) NOT NULL auto_increment,
  `langtkursus_id` int(11) NOT NULL default '0',
  `fag_id` int(11) NOT NULL default '0',
  `periode_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `langtkursus_id` (`langtkursus_id`,`fag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=16624 ;

-- --------------------------------------------------------

--
-- Table structure for table `langtkursus_x_file`
--

CREATE TABLE IF NOT EXISTS `langtkursus_x_file` (
  `id` int(11) NOT NULL auto_increment,
  `file_id` int(11) NOT NULL default '0',
  `langtkursus_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Table structure for table `langtkursus_x_tema`
--

CREATE TABLE IF NOT EXISTS `langtkursus_x_tema` (
  `id` int(11) NOT NULL auto_increment,
  `langtkursus_id` int(11) NOT NULL default '0',
  `langtkursus_tema_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=839 ;

-- --------------------------------------------------------

--
-- Table structure for table `liveuser_applications`
--

CREATE TABLE IF NOT EXISTS `liveuser_applications` (
  `application_id` int(11) NOT NULL default '0',
  `application_define_name` varchar(255) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `liveuser_areas`
--

CREATE TABLE IF NOT EXISTS `liveuser_areas` (
  `application_id` int(11) NOT NULL default '0',
  `area_id` int(11) NOT NULL default '0',
  `area_define_name` varchar(255) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `liveuser_grouprights`
--

CREATE TABLE IF NOT EXISTS `liveuser_grouprights` (
  `group_id` int(11) NOT NULL default '0',
  `group_right_id` int(11) NOT NULL default '0',
  `right_level` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `liveuser_groups`
--

CREATE TABLE IF NOT EXISTS `liveuser_groups` (
  `group_id` int(11) NOT NULL default '0',
  `group_define_name` varchar(255) NOT NULL default '',
  `is_active` tinyint(1) NOT NULL default '1',
  `group_type` int(11) NOT NULL default '0',
  `owner_user_id` int(11) NOT NULL default '0',
  `owner_group_id` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `liveuser_groupusers`
--

CREATE TABLE IF NOT EXISTS `liveuser_groupusers` (
  `perm_user_id` int(11) NOT NULL default '0',
  `group_id` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `liveuser_rights`
--

CREATE TABLE IF NOT EXISTS `liveuser_rights` (
  `area_id` int(11) NOT NULL default '0',
  `right_id` int(11) NOT NULL default '0',
  `right_define_name` varchar(255) NOT NULL default '',
  `has_implied` tinyint(1) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `liveuser_userrights`
--

CREATE TABLE IF NOT EXISTS `liveuser_userrights` (
  `perm_user_id` int(11) NOT NULL default '0',
  `right_id` int(11) NOT NULL default '0',
  `right_level` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `materialebestilling`
--

CREATE TABLE IF NOT EXISTS `materialebestilling` (
  `id` int(11) NOT NULL auto_increment,
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `navn` varchar(255) NOT NULL default '',
  `adresse` varchar(255) NOT NULL default '',
  `postnr` varchar(255) NOT NULL default '',
  `postby` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `telefon` varchar(255) NOT NULL default '',
  `langekurser` tinyint(1) NOT NULL default '0',
  `kortekurser` tinyint(1) NOT NULL default '0',
  `kursuscenter` tinyint(1) NOT NULL default '0',
  `besked` text NOT NULL,
  `er_sendt` int(11) NOT NULL default '0',
  `efterskole` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2895 ;

-- --------------------------------------------------------

--
-- Table structure for table `nyhed`
--

CREATE TABLE IF NOT EXISTS `nyhed` (
  `id` int(11) NOT NULL auto_increment,
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_publish` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_expire` datetime NOT NULL default '0000-00-00 00:00:00',
  `dato` datetime NOT NULL default '0000-00-00 00:00:00',
  `udloeber` datetime NOT NULL default '0000-00-00 00:00:00',
  `overskrift` varchar(255) NOT NULL default '',
  `tekst` text NOT NULL,
  `forfatter_id` int(11) NOT NULL default '0',
  `forfatter` varchar(255) NOT NULL default '',
  `kategori_id` int(11) NOT NULL default '0',
  `laesmere` varchar(255) NOT NULL default '',
  `prioritet` enum('Høj','Mellem','Lav') NOT NULL default 'Mellem',
  `prioritet_id` int(11) NOT NULL default '0',
  `billede` varchar(255) NOT NULL default '',
  `type_id` int(11) NOT NULL default '0',
  `fotoalbum_id` int(11) NOT NULL default '0',
  `video` varchar(255) NOT NULL default '',
  `active` tinyint(1) NOT NULL default '1',
  `published` tinyint(1) NOT NULL default '1',
  `title` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `kategori_id` (`kategori_id`),
  KEY `forfatter_id` (`forfatter_id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=757 ;

-- --------------------------------------------------------

--
-- Table structure for table `nyhed_x_file`
--

CREATE TABLE IF NOT EXISTS `nyhed_x_file` (
  `id` int(11) NOT NULL auto_increment,
  `nyhed_id` int(11) NOT NULL default '0',
  `file_id` int(11) NOT NULL default '0',
  `position` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=414 ;

-- --------------------------------------------------------

--
-- Table structure for table `ost_config`
--

CREATE TABLE IF NOT EXISTS `ost_config` (
  `id` tinyint(1) unsigned NOT NULL auto_increment,
  `isonline` tinyint(1) unsigned NOT NULL default '0',
  `timezone_offset` float(3,1) NOT NULL default '0.0',
  `enable_daylight_saving` tinyint(1) unsigned NOT NULL default '0',
  `staff_session_timeout` int(10) unsigned NOT NULL default '30',
  `client_session_timeout` int(10) unsigned NOT NULL default '30',
  `max_page_size` tinyint(3) unsigned NOT NULL default '25',
  `max_open_tickets` tinyint(3) unsigned NOT NULL default '0',
  `max_file_size` int(11) unsigned NOT NULL default '1048576',
  `autolock_minutes` tinyint(3) unsigned NOT NULL default '3',
  `overdue_grace_period` int(10) unsigned NOT NULL default '0',
  `default_email` tinyint(4) unsigned NOT NULL default '0',
  `default_dept` tinyint(3) unsigned NOT NULL default '0',
  `default_priority` tinyint(2) unsigned NOT NULL default '2',
  `default_template` tinyint(4) unsigned NOT NULL default '1',
  `clickable_urls` tinyint(1) unsigned NOT NULL default '1',
  `allow_priority_change` tinyint(1) unsigned NOT NULL default '0',
  `use_email_priority` tinyint(1) unsigned NOT NULL default '0',
  `enable_auto_cron` tinyint(1) unsigned NOT NULL default '0',
  `enable_pop3_fetch` tinyint(1) unsigned NOT NULL default '0',
  `enable_email_piping` tinyint(1) unsigned NOT NULL default '0',
  `send_sql_errors` tinyint(1) unsigned NOT NULL default '1',
  `send_mailparse_errors` tinyint(1) unsigned NOT NULL default '1',
  `send_login_errors` tinyint(1) unsigned NOT NULL default '1',
  `save_email_headers` tinyint(1) unsigned NOT NULL default '1',
  `strip_quoted_reply` tinyint(1) unsigned NOT NULL default '1',
  `ticket_autoresponder` tinyint(1) unsigned NOT NULL default '0',
  `message_autoresponder` tinyint(1) unsigned NOT NULL default '0',
  `ticket_alert_active` tinyint(1) unsigned NOT NULL default '0',
  `ticket_alert_admin` tinyint(1) unsigned NOT NULL default '1',
  `ticket_alert_dept_manager` tinyint(1) unsigned NOT NULL default '1',
  `ticket_alert_dept_members` tinyint(1) unsigned NOT NULL default '0',
  `message_alert_active` tinyint(1) unsigned NOT NULL default '0',
  `message_alert_laststaff` tinyint(1) unsigned NOT NULL default '1',
  `message_alert_assigned` tinyint(1) unsigned NOT NULL default '1',
  `message_alert_dept_manager` tinyint(1) unsigned NOT NULL default '0',
  `overdue_alert_active` tinyint(1) unsigned NOT NULL default '0',
  `overdue_alert_assigned` tinyint(1) unsigned NOT NULL default '1',
  `overdue_alert_dept_manager` tinyint(1) unsigned NOT NULL default '1',
  `overdue_alert_dept_members` tinyint(1) unsigned NOT NULL default '0',
  `auto_assign_reopened_tickets` tinyint(1) unsigned NOT NULL default '0',
  `show_assigned_tickets` tinyint(1) unsigned NOT NULL default '0',
  `overlimit_notice_active` tinyint(1) unsigned NOT NULL default '0',
  `email_attachments` tinyint(1) unsigned NOT NULL default '1',
  `allow_attachments` tinyint(1) unsigned NOT NULL default '0',
  `allow_email_attachments` tinyint(1) unsigned NOT NULL default '0',
  `allow_online_attachments` tinyint(1) unsigned NOT NULL default '0',
  `allow_online_attachments_onlogin` tinyint(1) unsigned NOT NULL default '0',
  `random_ticket_ids` tinyint(1) unsigned NOT NULL default '1',
  `upload_dir` varchar(255) NOT NULL default '',
  `allowed_filetypes` varchar(255) NOT NULL default '.doc, .pdf',
  `time_format` varchar(32) NOT NULL default ' h:i A',
  `date_format` varchar(32) NOT NULL default 'm/d/Y',
  `datetime_format` varchar(60) NOT NULL default 'm/d/Y g:i a',
  `daydatetime_format` varchar(60) NOT NULL default 'D, M j Y g:ia',
  `reply_separator` varchar(60) NOT NULL default ' -- do not edit --',
  `noreply_email` varchar(125) NOT NULL default '',
  `alert_email` varchar(125) NOT NULL default '',
  `admin_email` varchar(125) NOT NULL default '',
  `helpdesk_title` varchar(255) NOT NULL default 'osTicket Support Ticket System',
  `helpdesk_url` varchar(255) NOT NULL default '',
  `api_whitelist` tinytext,
  `api_key` varchar(125) NOT NULL default '',
  `ostversion` varchar(16) NOT NULL default '',
  `updated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `isoffline` (`isonline`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `ost_department`
--

CREATE TABLE IF NOT EXISTS `ost_department` (
  `dept_id` int(11) unsigned NOT NULL auto_increment,
  `email_id` int(10) unsigned NOT NULL default '0',
  `manager_id` int(10) unsigned NOT NULL default '0',
  `dept_name` varchar(32) NOT NULL default '',
  `dept_signature` varchar(255) NOT NULL default '',
  `ispublic` tinyint(1) unsigned NOT NULL default '1',
  `noreply_autoresp` tinyint(1) unsigned NOT NULL default '1',
  `ticket_auto_response` tinyint(1) NOT NULL default '1',
  `message_auto_response` tinyint(1) NOT NULL default '0',
  `can_append_signature` tinyint(1) NOT NULL default '1',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`dept_id`),
  UNIQUE KEY `dept_name` (`dept_name`),
  KEY `manager_id` (`manager_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `ost_email`
--

CREATE TABLE IF NOT EXISTS `ost_email` (
  `email_id` int(11) unsigned NOT NULL auto_increment,
  `noautoresp` tinyint(1) unsigned NOT NULL default '0',
  `priority_id` tinyint(3) unsigned NOT NULL default '0',
  `dept_id` tinyint(3) unsigned NOT NULL default '0',
  `email` varchar(125) NOT NULL default '',
  `name` varchar(32) NOT NULL default '',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`email_id`),
  UNIQUE KEY `email` (`email`),
  KEY `priority_id` (`priority_id`),
  KEY `dept_id` (`dept_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `ost_email_banlist`
--

CREATE TABLE IF NOT EXISTS `ost_email_banlist` (
  `id` int(11) NOT NULL auto_increment,
  `email` varchar(255) NOT NULL default '',
  `submitter` varchar(126) NOT NULL default '',
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `ost_email_pop3`
--

CREATE TABLE IF NOT EXISTS `ost_email_pop3` (
  `email_id` int(10) unsigned NOT NULL default '0',
  `popenabled` tinyint(1) NOT NULL default '0',
  `pophost` varchar(125) NOT NULL default '',
  `popuser` varchar(125) NOT NULL default '',
  `poppasswd` varchar(125) NOT NULL default '',
  `delete_msgs` tinyint(1) unsigned NOT NULL default '0',
  `fetchfreq` int(3) unsigned NOT NULL default '5',
  `errors` tinyint(3) unsigned NOT NULL default '0',
  `lasterror` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastfetch` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`email_id`),
  KEY `consec_errors` (`errors`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ost_email_template`
--

CREATE TABLE IF NOT EXISTS `ost_email_template` (
  `tpl_id` int(11) NOT NULL auto_increment,
  `cfg_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(32) NOT NULL default '',
  `ticket_autoresp_subj` varchar(255) NOT NULL default '',
  `ticket_autoresp_body` text NOT NULL,
  `ticket_alert_subj` varchar(255) NOT NULL default '',
  `ticket_alert_body` text NOT NULL,
  `message_autoresp_subj` varchar(255) NOT NULL default '',
  `message_autoresp_body` text NOT NULL,
  `message_alert_subj` varchar(255) NOT NULL default '',
  `message_alert_body` text NOT NULL,
  `assigned_alert_subj` varchar(255) NOT NULL default '',
  `assigned_alert_body` text NOT NULL,
  `ticket_overdue_subj` varchar(255) NOT NULL default '',
  `ticket_overdue_body` text NOT NULL,
  `ticket_overlimit_subj` varchar(255) NOT NULL default '',
  `ticket_overlimit_body` text NOT NULL,
  `ticket_reply_subj` varchar(255) NOT NULL default '',
  `ticket_reply_body` text NOT NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`tpl_id`),
  KEY `cfg_id` (`cfg_id`),
  FULLTEXT KEY `message_subj` (`ticket_reply_subj`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `ost_groups`
--

CREATE TABLE IF NOT EXISTS `ost_groups` (
  `group_id` int(10) unsigned NOT NULL auto_increment,
  `group_enabled` tinyint(1) unsigned NOT NULL default '1',
  `group_name` varchar(50) NOT NULL default '',
  `dept_access` varchar(255) NOT NULL default '',
  `can_delete_tickets` tinyint(1) unsigned NOT NULL default '0',
  `can_close_tickets` tinyint(1) unsigned NOT NULL default '0',
  `can_transfer_tickets` tinyint(1) NOT NULL default '1',
  `can_ban_emails` tinyint(1) unsigned NOT NULL default '0',
  `can_manage_kb` tinyint(1) unsigned NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`group_id`),
  KEY `group_active` (`group_enabled`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `ost_help_topic`
--

CREATE TABLE IF NOT EXISTS `ost_help_topic` (
  `topic_id` int(11) unsigned NOT NULL auto_increment,
  `isactive` tinyint(1) unsigned NOT NULL default '1',
  `noautoresp` tinyint(3) unsigned NOT NULL default '0',
  `priority_id` tinyint(3) unsigned NOT NULL default '0',
  `dept_id` tinyint(3) unsigned NOT NULL default '0',
  `topic` varchar(32) NOT NULL default '',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`topic_id`),
  UNIQUE KEY `topic` (`topic`),
  KEY `priority_id` (`priority_id`),
  KEY `dept_id` (`dept_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `ost_kb_premade`
--

CREATE TABLE IF NOT EXISTS `ost_kb_premade` (
  `premade_id` int(10) unsigned NOT NULL auto_increment,
  `dept_id` int(10) unsigned NOT NULL default '0',
  `isenabled` tinyint(1) unsigned NOT NULL default '1',
  `title` varchar(125) NOT NULL default '',
  `answer` text NOT NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`premade_id`),
  UNIQUE KEY `title_2` (`title`),
  KEY `dept_id` (`dept_id`),
  KEY `active` (`isenabled`),
  FULLTEXT KEY `title` (`title`,`answer`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `ost_staff`
--

CREATE TABLE IF NOT EXISTS `ost_staff` (
  `staff_id` int(11) unsigned NOT NULL auto_increment,
  `group_id` int(10) unsigned NOT NULL default '0',
  `dept_id` int(10) unsigned NOT NULL default '0',
  `username` varchar(32) NOT NULL default '',
  `firstname` varchar(32) default NULL,
  `lastname` varchar(32) default NULL,
  `passwd` varchar(128) default NULL,
  `email` varchar(128) default NULL,
  `phone` varchar(24) NOT NULL default '',
  `phone_ext` varchar(6) default NULL,
  `mobile` varchar(24) NOT NULL default '',
  `signature` varchar(255) NOT NULL default '',
  `isactive` tinyint(1) NOT NULL default '1',
  `isadmin` tinyint(1) NOT NULL default '0',
  `isvisible` tinyint(1) unsigned NOT NULL default '1',
  `onvacation` tinyint(1) unsigned NOT NULL default '0',
  `daylight_saving` tinyint(1) unsigned NOT NULL default '0',
  `append_signature` tinyint(1) unsigned NOT NULL default '0',
  `change_passwd` tinyint(1) unsigned NOT NULL default '0',
  `timezone_offset` float(3,1) NOT NULL default '0.0',
  `max_page_size` int(11) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastlogin` datetime default NULL,
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`staff_id`),
  UNIQUE KEY `username` (`username`),
  KEY `dept_id` (`dept_id`),
  KEY `issuperuser` (`isadmin`),
  KEY `group_id` (`group_id`,`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `ost_ticket`
--

CREATE TABLE IF NOT EXISTS `ost_ticket` (
  `ticket_id` int(11) unsigned NOT NULL auto_increment,
  `ticketID` int(11) unsigned NOT NULL default '0',
  `dept_id` int(10) unsigned NOT NULL default '1',
  `priority_id` int(10) unsigned NOT NULL default '2',
  `staff_id` int(10) unsigned NOT NULL default '0',
  `email` varchar(120) NOT NULL default '',
  `name` varchar(32) NOT NULL default '',
  `subject` varchar(64) NOT NULL default '[no subject]',
  `phone` varchar(16) default NULL,
  `ip_address` varchar(16) NOT NULL default '',
  `status` enum('open','closed') NOT NULL default 'open',
  `source` enum('Web','Email','Phone') default NULL,
  `isoverdue` tinyint(1) unsigned NOT NULL default '0',
  `reopened` datetime default NULL,
  `closed` datetime default NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ticket_id`),
  UNIQUE KEY `email_extid` (`ticketID`,`email`),
  KEY `dept_id` (`dept_id`),
  KEY `staff_id` (`staff_id`),
  KEY `status` (`status`),
  KEY `priority_id` (`priority_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=199 ;

-- --------------------------------------------------------

--
-- Table structure for table `ost_ticket_attachment`
--

CREATE TABLE IF NOT EXISTS `ost_ticket_attachment` (
  `attach_id` int(11) unsigned NOT NULL auto_increment,
  `ticket_id` int(11) unsigned NOT NULL default '0',
  `ref_id` int(11) unsigned NOT NULL default '0',
  `ref_type` enum('M','R') NOT NULL default 'M',
  `file_size` varchar(32) NOT NULL default '',
  `file_name` varchar(128) NOT NULL default '',
  `file_key` varchar(128) NOT NULL default '',
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime default NULL,
  PRIMARY KEY  (`attach_id`),
  KEY `ticket_id` (`ticket_id`),
  KEY `ref_type` (`ref_type`),
  KEY `ref_id` (`ref_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ost_ticket_lock`
--

CREATE TABLE IF NOT EXISTS `ost_ticket_lock` (
  `lock_id` int(11) unsigned NOT NULL auto_increment,
  `ticket_id` int(11) unsigned NOT NULL default '0',
  `staff_id` int(10) unsigned NOT NULL default '0',
  `expire` datetime default NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`lock_id`),
  UNIQUE KEY `ticket_id` (`ticket_id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `ost_ticket_message`
--

CREATE TABLE IF NOT EXISTS `ost_ticket_message` (
  `msg_id` int(11) unsigned NOT NULL auto_increment,
  `ticket_id` int(11) unsigned NOT NULL default '0',
  `message` text NOT NULL,
  `headers` text,
  `source` varchar(16) default NULL,
  `ip_address` varchar(16) default NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime default NULL,
  PRIMARY KEY  (`msg_id`),
  KEY `ticket_id` (`ticket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=200 ;

-- --------------------------------------------------------

--
-- Table structure for table `ost_ticket_note`
--

CREATE TABLE IF NOT EXISTS `ost_ticket_note` (
  `note_id` int(11) unsigned NOT NULL auto_increment,
  `ticket_id` int(11) unsigned NOT NULL default '0',
  `staff_id` int(10) unsigned NOT NULL default '0',
  `source` varchar(32) NOT NULL default '',
  `title` varchar(255) NOT NULL default 'Generic Intermal Notes',
  `note` text NOT NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`note_id`),
  KEY `ticket_id` (`ticket_id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `ost_ticket_priority`
--

CREATE TABLE IF NOT EXISTS `ost_ticket_priority` (
  `priority_id` tinyint(4) NOT NULL auto_increment,
  `priority` varchar(60) NOT NULL default '',
  `priority_desc` varchar(30) NOT NULL default '',
  `priority_color` varchar(7) NOT NULL default '',
  `priority_urgency` tinyint(1) unsigned NOT NULL default '0',
  `ispublic` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`priority_id`),
  UNIQUE KEY `priority` (`priority`),
  KEY `priority_urgency` (`priority_urgency`),
  KEY `ispublic` (`ispublic`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `ost_ticket_response`
--

CREATE TABLE IF NOT EXISTS `ost_ticket_response` (
  `response_id` int(11) unsigned NOT NULL auto_increment,
  `msg_id` int(11) unsigned NOT NULL default '0',
  `ticket_id` int(11) unsigned NOT NULL default '0',
  `staff_id` int(11) unsigned NOT NULL default '0',
  `staff_name` varchar(32) NOT NULL default '',
  `response` text NOT NULL,
  `ip_address` varchar(16) NOT NULL default '',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`response_id`),
  KEY `ticket_id` (`ticket_id`),
  KEY `msg_id` (`msg_id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `ost_timezone`
--

CREATE TABLE IF NOT EXISTS `ost_timezone` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `offset` float(3,1) NOT NULL default '0.0',
  `timezone` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Table structure for table `php_session`
--

CREATE TABLE IF NOT EXISTS `php_session` (
  `session_id` varchar(40) NOT NULL default '',
  `last_active` int(11) NOT NULL default '0',
  `data` text NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `redirect`
--

CREATE TABLE IF NOT EXISTS `redirect` (
  `id` int(11) NOT NULL auto_increment,
  `intranet_id` int(11) NOT NULL default '0',
  `session_id` varchar(255) NOT NULL default '',
  `from_url` varchar(255) NOT NULL default '',
  `return_url` varchar(255) NOT NULL default '',
  `destination_url` varchar(255) NOT NULL default '',
  `identifier` varchar(255) NOT NULL default '',
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `cancel_url` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=175 ;

-- --------------------------------------------------------

--
-- Table structure for table `redirect_parameter`
--

CREATE TABLE IF NOT EXISTS `redirect_parameter` (
  `id` int(11) NOT NULL auto_increment,
  `intranet_id` int(11) NOT NULL default '0',
  `redirect_id` int(11) NOT NULL default '0',
  `parameter` varchar(255) NOT NULL default '',
  `multiple` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Table structure for table `redirect_parameter_value`
--

CREATE TABLE IF NOT EXISTS `redirect_parameter_value` (
  `id` int(11) NOT NULL auto_increment,
  `intranet_id` int(11) NOT NULL default '0',
  `redirect_id` int(11) NOT NULL default '0',
  `redirect_parameter_id` int(11) NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  `extra_value` varchar(255) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `id` int(11) NOT NULL auto_increment,
  `arrangement_id` int(11) NOT NULL default '0',
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `name` varchar(255) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `postalcode` varchar(10) NOT NULL default '',
  `city` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `phone` varchar(255) NOT NULL default '',
  `status` varchar(255) NOT NULL default '',
  `quantity` int(11) NOT NULL default '0',
  `session_id` varchar(255) NOT NULL default '',
  `transaction_number` int(11) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  `paid` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Table structure for table `venteliste`
--

CREATE TABLE IF NOT EXISTS `venteliste` (
  `id` int(11) NOT NULL auto_increment,
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `belong_to` int(11) NOT NULL default '0',
  `belong_to_id` int(11) NOT NULL default '0',
  `antal` int(11) NOT NULL default '0',
  `adresse_id` int(11) NOT NULL default '0',
  `active` int(11) NOT NULL default '1',
  `besked` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=218 ;

-- --------------------------------------------------------

--
-- Table structure for table `v_i_h__model__course__period`
--

CREATE TABLE IF NOT EXISTS `v_i_h__model__course__period` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `description` text,
  `course_id` bigint(20) default NULL,
  `date_start` date default NULL,
  `date_end` date default NULL,
  PRIMARY KEY  (`id`),
  KEY `course_id_idx` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `v_i_h__model__course__registration__subject`
--

CREATE TABLE IF NOT EXISTS `v_i_h__model__course__registration__subject` (
  `registration_id` bigint(20) NOT NULL default '0',
  `subject_id` bigint(20) NOT NULL default '0',
  `period_id` bigint(20) NOT NULL default '0',
  `subjectgroup_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1493 ;

-- --------------------------------------------------------

--
-- Table structure for table `v_i_h__model__course__subject_group`
--

CREATE TABLE IF NOT EXISTS `v_i_h__model__course__subject_group` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `description` varchar(255) NOT NULL default '',
  `period_id` bigint(20) default NULL,
  `course_id` bigint(20) default NULL,
  `elective_course` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `period_id_idx` (`period_id`),
  KEY `course_id_idx` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=112 ;

-- --------------------------------------------------------

--
-- Table structure for table `v_i_h__model__course__subject_group__subject`
--

CREATE TABLE IF NOT EXISTS `v_i_h__model__course__subject_group__subject` (
  `subject_group_id` bigint(20) NOT NULL default '0',
  `subject_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`subject_group_id`,`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

