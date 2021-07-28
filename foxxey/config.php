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
 Version: 0.1.2.2 Alpha
-----------------------------------------------------
 Usage: WEB API settings
=====================================================
*/
if(!defined('FOXXEY')) {
	die ("Not a real Fox! =(");
}

	define('webDir', 	  'foxxey');
	define('ROOT_DIR', 	  $_SERVER['DOCUMENT_ROOT']);
	define('SCRIPTS_DIR', ROOT_DIR.'/'.webDir.'/scripts/');
	define('FILES_DIR',   ROOT_DIR.'/files/');
	define('SITE_ROOT',   ROOT_DIR.'/'.webDir);
	define('REMOTE_IP',   getenv('REMOTE_ADDR'));
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
	
	/* AUTHORISATION */
		'checkHWID'    => true,
		'geoIPcheck'   => true,
		'useAntiBrute' => true,
		'getBalance'   => true,
		'foxChecking'  => true,
			
		/* FOX CHECK*/
			'FoxArray' => array('Fox', 'foX', 'fOx', 'FOX', 'fox', 'Foxes', 'foxes', 'Lis', 'lis', 'Renard', 'Fuchs'),
			'rewardAmmount'		=> 50,
		
		/* ANTI BRUTE */
			'bantime'			=> CURRENT_TIME + (100),
			'maxLoginAttempts'	=> 1,

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
	'skinsAbsolute' 	=> SITE_ROOT.'/MinecraftSkins/',
	'cloaksAbsolute'	=> SITE_ROOT.'/MinecraftCloaks/',

	/* startUpSound */
	'enableVoice' 		=> true,
	'enableMusic' 		=> true,
	'easterMusRarity'   => 50);
	
require (SITE_ROOT.'/messages/messages.lng');