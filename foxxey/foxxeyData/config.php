<?php
/*
=====================================================
 Config
-----------------------------------------------------
 https://Foxesworld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: config.php
-----------------------------------------------------
 Version: 0.1.2.5 Alpha
-----------------------------------------------------
 Usage: WEB API settings
=====================================================
*/
header("Content-Type: application/json; charset=UTF-8");
if(!defined('FOXXEY')) {
	die ('{"message": "Not in FOXXEY thread"}');
}

	define('webDir', 	  'foxxey');
	define('ROOT_DIR', 	  $_SERVER['DOCUMENT_ROOT']);
	define('ADMIN_DIR', ROOT_DIR.'/adm/');
	define('SCRIPTS_DIR', ROOT_DIR.'/'.webDir.'/scripts/');
	define('FILES_DIR',   ROOT_DIR.'/files/');
	define('SITE_ROOT',   ROOT_DIR.'/'.webDir);
	define('FOXXEYDATA',  SITE_ROOT.'/foxxeyData/');
	define('CURRENT_TIME',time());
	define('CURRENT_DATE',date("d.m.Y"));

$config = array(

	/* Foxxey settings */
	'webserviceName' 	=> 'FoxesWorld | Foxxey',
	'not_allowed_symbol'=> array ("\x22", "\x60", "\t", '\n', '\r', "\n", "\r", '\\', ",", "/", "¬", "#", ";", ":", "~", "[", "]", "{", "}", ")", "(", "*", "^", "%", "$", "<", ">", "?", "!", '"', "'", " ", "&" ),

	/* DEBUG */
	'modulesDebug'		=> false,
	'HWIDdebug'			=> false,
	'foxCheckDebug'		=> false,
	'debugStartUpSound' => false,
	'antiBruteDebug'	=> false,
	'randTextsDebug'	=> false,
	
	/* Updater */
	'launcherRepositoryPath' => FILES_DIR."Launcher.jar",
	'updaterRepositoryPath'  => FILES_DIR."updater/",

	
	/* AUTHORISATION Modules */
		'checkHWID'    => true,
		'geoIPcheck'   => true,
		'useAntiBrute' => true,
		'getBalance'   => true,
		'foxChecking'  => true,
			
		/* FOX CHECK*/
			'FoxArray' 			=> array('Fox', 'foX', 'fOx', 'FOX', 'fox', 'Foxes', 'foxes', 'Lis', 'lis', 'Renard', 'Fuchs'),
			'rewardAmmount'		=> 50,
		
		/* ANTI BRUTE */
			'bantime'			=> CURRENT_TIME + (120),
			'maxLoginAttempts'	=> 1,
	
	/* startUpSound */
	'mountDir' 			=> SITE_ROOT."/foxxeyData/startUpSoundRepo",
	'enableVoice' 		=> true,
	'enableMusic' 		=> true,
	'easterMusRarity'   => 1,
	'easterSndRarity'	=> 1,
	
	/* E-mail */
	'encoding' 			=> 'UTF-8',
	'admin_mail' 		=> 'lisssicin@yandex.ru',
	'mail_title' 		=> 'Foxesworld',
	'mail_metod' 		=> 'smtp',
	'smtp_host' 		=> 'smtp.yandex.ru',
	'smtp_port' 		=> '465',
	'smtp_user' 		=> 'no-reply@foxesworld.ru',
	'smtp_pass' 		=> 'dvhbdxutiscpbmof',
	'smtp_secure' 		=> 'ssl',
	'smtp_mail' 		=> 'no-reply@foxesworld.ru',

	/* Database Settings */
	'db_host' 			=> 'localhost',
	'db_port' 			=> '3306',
	'db_user' 			=> 'root',
	'db_pass' 			=> 'P$Ak$O2sJZSu$aAKOBqkokf@Vs5%YCj',
	'db_table' 			=> 'dle_users',
	'db_database' 		=> 'fox_dle',
	'dbname_launcher' 	=> 'fox_launcher',
	'db_name_userdata' 	=> 'fox_userdata',
	'db_columnId' 		=> 'user_id',
	'db_columnUser' 	=> 'name',
	'db_columnPass' 	=> 'password',
	'db_columnIp' 		=> 'logged_ip',
	'db_columnDatareg' 	=> 'reg_date',
	'db_columnMail' 	=> 'email',
	
	/* Skins */
	'skinsAbsolute' 	=> FILES_DIR.'uploads/MinecraftSkins/',
	'cloaksAbsolute'	=> FILES_DIR.'uploads/MinecraftCloaks/');

require (SITE_ROOT.'/messages/messages.lng');