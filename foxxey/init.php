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
 Version: 0.1.6.4 Alpha
-----------------------------------------------------
 Usage: Initialising&Including modules
=====================================================
*/
	header('Content-Type: text/html; charset=utf-8');
	if(!defined('FOXXEY')) {
		die ('{"message": "Not in FOXXEY thread"}');
	} else {
		require ($_SERVER['DOCUMENT_ROOT'].'/foxxey/foxxeyData/config.php');
		require (SCRIPTS_DIR.'database.class.php');
		require (SCRIPTS_DIR.'functions.class.php');
	}


	class init {
		
		private $longTermBan;
		
		//Modules==================
		protected $wipModules;
		protected $validModules;
		protected $allModules;
		//=========================
		
		//Databases================
		protected $launcherDB;
		protected $userDataDB;
		//=========================

		function __construct($ip, $initType) {
			global $config;

				$userDataDB = new db($config['db_user'],$config['db_pass'],$config['db_name_userdata']);
				$launcherDB = new db($config['db_user'],$config['db_pass'],$config['dbname_launcher']);				

			//Modules Initialising
			functions::libFilesInclude();  // Base Functions (Will replace deprecated modules)
			$this->allModules	= functions::modulesInit();
			$this->validModules = $this->allModules['validModules'];
			$this->wipModules 	= $this->allModules['wipModules'];
			functions::includeModules(SCRIPTS_DIR.'modules', $config['modulesDebug'], $this->validModules);
			$this->longTermBan = new longTermBan($ip, $launcherDB);
			if($this->longTermBan->checkBan() === false) {
				

				switch($initType){
					case 'launcher':	
						$dbPrepare = new dbPrepare;
						$dbPrepare->dbPrepare();
						require(SCRIPTS_DIR.'actionScript.php');
						$action = new actionScript($launcherDB, $userDataDB, $ip);
					break;
					
					case 'API':
						require (SITE_ROOT.'/api/init.php');
						$apiInit = new apiInit($ip, $userDataDB, $launcherDB, $_REQUEST);
					break;
					
					case 'updater':
						require (SCRIPTS_DIR.'updater.class.php');
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