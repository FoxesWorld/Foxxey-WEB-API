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
 Version: 0.1.2.6 Alpha
-----------------------------------------------------
 Usage: WEB API settings
=====================================================
*/
header("Content-Type: application/json; charset=UTF-8");
if(!defined('FOXXEY')) {
	die ('{"message": "Not in FOXXEY thread"}');
}
/*
	$globalVars = array('ROOT_DIR'     => $_SERVER['DOCUMENT_ROOT'],
						'ADMIN_DIR'    =>   $globalVars['ROOT_DIR'].'/adm/',
						'SCRIPTS_DIR'  => $globalVars['ROOT_DIR'].'/'.$globalVars['webDir'].'/scripts/',
						'INCDIR' 	   => $globalVars['ROOT_DIR'].'/'.$globalVars['webDir'].'/include/',
						'webDir' 	   => 'foxxey',
						'CURRENT_TIME' => time(), 
						'CURRENT_DATE' => date("d.m.Y"),
	); */

	define('webDir', 	  'foxxey');
	define('ROOT_DIR', 	  $_SERVER['DOCUMENT_ROOT']);
	define('ADMIN_DIR',   ROOT_DIR.'/adm/');
	define('INCDIR', 	  ROOT_DIR.'/'.webDir.'/include/');
	define('FILES_DIR',   ROOT_DIR.'/files/');
	define('SITE_ROOT',   ROOT_DIR.'/'.webDir);
	define('ETC', 		  SITE_ROOT.'/etc/');
	define('CURRENT_TIME',time());
	define('CURRENT_DATE',date("d.m.Y"));

$config = array(

	/* Foxxey settings */
	'webserviceName' 	=> 'FoxesWorld | Foxxey',
	'timezone'			=> 'Europe/Moscow',
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
			
		/* Logging */
			'authLog'			=> FILES_DIR.'/logs/AuthLog.log',
			'errorLog'			=> FILES_DIR.'/logs/Errors.log',
	
	/* startUpSound */
	'mountDir' 			=> SITE_ROOT."/etc/startUpSoundRepo",
	'enableVoice' 		=> true,
	'enableMusic' 		=> true,
	'easterMusRarity'   => 1000,
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
	'cloaksAbsolute'	=> FILES_DIR.'uploads/MinecraftCloaks/',
	
	'monthArray'		  => array(
		  "01" => "января",
		  "02" => "февраля",
		  "03" => "марта",
		  "04" => "апреля",
		  "05" => "мая",
		  "06" => "июня",
		  "07" => "июля",
		  "08" => "августа",
		  "09" => "сентября",
		  "10" => "октября",
		  "11" => "ноября",
		  "12" => "декабря"
			));

require (ETC.'messages/messages.lng');