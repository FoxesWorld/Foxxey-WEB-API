<?php
/*
=====================================================
 Config
-----------------------------------------------------
 https://Foxesworld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 Данный код защищен авторскими правами
-----------------------------------------------------
 Файл: config.php
-----------------------------------------------------
 Версия: 0.1.6 Alpha
-----------------------------------------------------
 Назначение: Настройки веб сервиса
=====================================================
*/
if(!defined('FOXXEY')) {
	die ("Not a real Fox! =(");
}

	define('webDir', 	'foxxey');
	define('ROOT_DIR', 		$_SERVER['DOCUMENT_ROOT']);
	define('SCRIPTS_DIR', 	ROOT_DIR.'/'.webDir.'/scripts/');
	define('FILES_DIR', 	ROOT_DIR.'/'.webDir.'/files/');
	define('SITE_ROOT', 	ROOT_DIR.'/'.webDir);
	define('REMOTE_IP', 	getenv('REMOTE_ADDR'));
	define('CURRENT_TIME',  time());
	define('CURRENT_DATE', 	date("d.m.Y"));

$config = array(
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
	'authJSON'			=> false,
	
	/* Clients Settings */
	'clientsDir' 		=> 'files/clients/',
	'temp' 				=> false, //Use temporary files
	'useban' 			=> false, //Doesn't work
	'useantibrut' 		=> true,
	'bantime'			=> CURRENT_TIME + (100),
	
	/* Skins&Cloaks Configuration */
	'uploaddirs'  		=> 'MinecraftSkins',  
	'uploaddirp'  		=> 'MinecraftCloaks',
	
	'webserviceName' 	=> 'FoxesWorld | Foxxey',
	'not_allowed_symbol'=> array ("\x22", "\x60", "\t", '\n', '\r', "\n", "\r", '\\', ",", "/", "¬", "#", ";", ":", "~", "[", "]", "{", "}", ")", "(", "*", "^", "%", "$", "<", ">", "?", "!", '"', "'", " ", "&" ));
	
	$skinurl            = 'https://login.foxesworld.ru/launcher/'.$config['uploaddirs'].'/'; //Skins Link
    $capeurl            = 'https://login.foxesworld.ru/launcher/'.$config['uploaddirp'].'/'; //Cloaks Link
	
	$skinsArray = array(
	'skinsAbsolute' 	=> SITE_ROOT.'/'.$config['uploaddirs'],
	'cloaksAbsolute'	=> SITE_ROOT.'/'.$config['uploaddirp'],
	'skinUrl'			=> 'https://login.foxesworld.ru/launcher/'.$config['uploaddirs'].'/',
	'capeUrl'			=> 'https://login.foxesworld.ru/launcher/'.$config['uploaddirp'].'/',
	);
	
require (SCRIPTS_DIR.'messages.php');