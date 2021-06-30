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
 Version: 0.1.1.0 Alpha
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
	define('FILES_DIR',   ROOT_DIR.'/'.webDir.'/files/');
	define('SITE_ROOT',   ROOT_DIR.'/'.webDir);
	define('REMOTE_IP',   getenv('REMOTE_ADDR'));
	define('CURRENT_TIME',time());
	define('CURRENT_DATE',date("d.m.Y"));

$config = array(
	/* DEBUG */
	'modulesDebug'		=> false,
	'HWIDdebug'			=> false,
	'foxCheckDebug'		=> false,
	'debugStartUpSound' => false,

	/* Foxxey settings */
	'rewardAmmount'		=> 50,
	'bantime'			=> CURRENT_TIME + (100),
	'webserviceName' 	=> 'FoxesWorld | Foxxey',
	'not_allowed_symbol'=> array ("\x22", "\x60", "\t", '\n', '\r', "\n", "\r", '\\', ",", "/", "¬", "#", ";", ":", "~", "[", "]", "{", "}", ")", "(", "*", "^", "%", "$", "<", ">", "?", "!", '"', "'", " ", "&" ),

	/* Database Settings*/
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
	
	/* startUpSound */
	'enableVoice' 		=> true,
	'enableMusic' 		=> true,
	'easterMusRarity'   => 9);
	
require (SCRIPTS_DIR.'messages.php');