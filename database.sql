-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 10, 2018 at 05:56 PM
-- Server version: 5.5.59-0ubuntu0.14.04.1-log
-- PHP Version: 5.5.9-1ubuntu4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `youtube_dump`
--
CREATE DATABASE IF NOT EXISTS `youtube_dump` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `youtube_dump`;

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
CREATE TABLE IF NOT EXISTS `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vid` varchar(11) CHARACTER SET latin1 NOT NULL,
  `fid` varchar(50) CHARACTER SET latin1 NOT NULL,
  `import_time` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `last_check` timestamp NULL DEFAULT NULL,
  `disappear_time` timestamp NULL DEFAULT NULL,
  `video_name` text,
  `removed_reason` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vid` (`vid`),
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=321517 ;

