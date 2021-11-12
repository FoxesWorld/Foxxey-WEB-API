<?php
/*
=====================================================
 Initialising
-----------------------------------------------------
 https://Foxesworld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: init.php
-----------------------------------------------------
 Version: 0.1.7.4 Alpha
-----------------------------------------------------
 Usage: Initialising&Including modules
=====================================================
*/
	header('Content-Type: text/html; charset=utf-8');
	if(!defined('FOXXEY')) {
		die ('{"message": "Not in FOXXEY thread"}');
	} else {
		require ($_SERVER['DOCUMENT_ROOT'].'/foxxey/etc/config.php');
		require (SITE_ROOT.'/initFunctions');
	}


	class init {
		
		private $longTermBan;

		//Databases================
		protected $launcherDB;
		protected $userDataDB;
		//=========================

		function __construct($ip, $initType) {
			global $config;
			//Including libraries
			functions::libFilesInclude();

				$userDataDB = new db($config['db_user'],$config['db_pass'],$config['db_name_userdata']);
				$launcherDB = new db($config['db_user'],$config['db_pass'],$config['dbname_launcher']);				

			$this->longTermBan = new longTermBan($ip, $launcherDB);
			if($this->longTermBan->checkBan() === false) {
				

				switch($initType){
					case 'launcher':	
						$dbPrepare = new dbPrepare;
						$dbPrepare->dbPrepare();
						require(SITE_ROOT.'/actionScript.lib');
						$action = new actionScript($launcherDB, $userDataDB, $ip);
					break;
					
					case 'API':
						require (SITE_ROOT.'/api/init.php');
						$apiInit = new apiInit($ip, $userDataDB, $launcherDB, $_REQUEST);
					break;
					
					case 'updater':
						require (SITE_ROOT.'/updater');
					break;
					
					default:
						die('{"message": "Unknown init option - `'.$initType.'`"}');
					break;
				}						
			} else {
				$randTexts = new randTexts('banned');
				die('{"message": "'.$randTexts->textOut().'"}');
			}
		}
	}