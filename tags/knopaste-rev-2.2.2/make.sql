-- phpMyAdmin SQL Dump
-- version 2.6.1-pl3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Erstellungszeit: 24. März 2005 um 19:46
-- Server Version: 4.0.24
-- PHP-Version: 4.3.10-9
-- 
-- Datenbank: `knopaste`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `paste1`
-- 

CREATE TABLE `paste1` (
  `id` bigint(20) NOT NULL auto_increment,
  `ip` varchar(15) NOT NULL default '',
  `name` varchar(20) NOT NULL default '',
  `time` bigint(20) NOT NULL default '0',
  `des` varchar(200) NOT NULL default '',
  `entryfile` varchar(50) NOT NULL default '',
  `lang_hi` varchar(30) NOT NULL default '',
  `lin` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
