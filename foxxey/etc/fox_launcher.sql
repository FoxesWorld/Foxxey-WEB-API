-- Foxxey SQL Dump
-- version 01.0.0
-- https://api.foxesworld.ru/
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE IF NOT EXISTS `antiBrute` (
  `id` int(11) NOT NULL,
  `time` varchar(255) DEFAULT NULL,
  `recordTime` datetime(4) NOT NULL DEFAULT current_timestamp(4),
  `ip` varchar(16) DEFAULT NULL,
  `attempts` int(16) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `fullBlock` (
  `id` int(8) NOT NULL,
  `ip` varchar(128) NOT NULL,
  `temptime` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `HWIDrenew` (
  `id` int(8) NOT NULL,
  `login` varchar(128) NOT NULL,
  `newHWID` varchar(256) NOT NULL,
  `timestamp` varchar(128) NOT NULL,
  `hash` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `ipCity` (
  `id` int(8) NOT NULL,
  `cityName` varchar(128) NOT NULL,
  `cityCount` int(64) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `ipDatabase` (
  `id` int(8) NOT NULL,
  `ipLocation` varchar(16) NOT NULL,
  `ipRegion` varchar(64) NOT NULL,
  `ip` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `randPhrases` (
  `id` int(10) NOT NULL,
  `phrase` varchar(500) NOT NULL,
  `rarity` int(10) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `servers` (
  `id` int(100) NOT NULL,
  `Server_name` varchar(120) NOT NULL,
  `adress` varchar(100) NOT NULL,
  `port` int(90) NOT NULL,
  `srv_image` varchar(100) NOT NULL,
  `version` varchar(100) NOT NULL,
  `story` varchar(900) NOT NULL,
  `srv_group` int(100) NOT NULL,
  `enabled` int(1) NOT NULL DEFAULT 1,
  `clientArgs` varchar(128) NOT NULL,
  `mainClass` varchar(256) NOT NULL DEFAULT 'net.minecraft.launchwrapper.Launch',
  `jvmArgs` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `usersHWID` (
  `id` int(255) NOT NULL,
  `login` varchar(128) NOT NULL,
  `hwid` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `wrongPass` (
  `id` int(2) NOT NULL,
  `login` varchar(256) NOT NULL,
  `realLogin` varchar(256) NOT NULL,
  `timestamp` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `successfulAuth` (
  `id` int(2) NOT NULL,
  `login` varchar(128) NOT NULL,
  `timestamp` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `antiBrute`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `ip` (`ip`);

ALTER TABLE `fullBlock`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ip` (`ip`);

ALTER TABLE `HWIDrenew`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `newHWID` (`newHWID`),
  ADD UNIQUE KEY `hash` (`hash`);

ALTER TABLE `ipCity`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ipDatabase`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `randPhrases`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `servers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `usersHWID`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `hwid` (`hwid`);
  
ALTER TABLE `wrongPass`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `successfulAuth`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `antiBrute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `fullBlock`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

ALTER TABLE `HWIDrenew`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `ipCity`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `ipDatabase`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

ALTER TABLE `randPhrases`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

ALTER TABLE `servers`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

ALTER TABLE `usersHWID`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

ALTER TABLE `wrongPass`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

ALTER TABLE `successfulAuth`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;
