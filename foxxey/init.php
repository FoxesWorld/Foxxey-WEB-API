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
 File: config.php
-----------------------------------------------------
 Version: 0.1.6.3 Alpha
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
				
				$this->userDataDB = new db($config['db_user'],$config['db_pass'],$config['db_name_userdata']);
				$this->launcherDB = new db($config['db_user'],$config['db_pass'],$config['dbname_launcher']);
			
			//Modules Initialising
			$this->modulesInit();
			functions::includeModules(SCRIPTS_DIR.'modules', $config['modulesDebug'], $this->validModules);
			$this->longTermBan = new longTermBan($ip, $this->launcherDB);
			if($this->longTermBan->checkBan() === false) {
				switch($initType){
					case 'launcher':	
						$dbPrepare = new dbPrepare;
						$dbPrepare->dbPrepare();
						require(SCRIPTS_DIR.'actionScript.php');
						$action = new actionScript($this->launcherDB, $this->userDataDB, $ip);
					break;
					
					case 'API':
						require (SITE_ROOT.'/api/init.php');
						$apiInit = new apiInit($ip, $_REQUEST);
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
		
		private function modulesInit() {
			$this->allModules = functions::filesInDirArray(SCRIPTS_DIR.'modules','.php');
			for($i = 0; $i < count($this->allModules); $i++){
				if(strpos($this->allModules[$i],'.wip.')) {
					$this->wipModules[] = $this->allModules[$i];
				} else {
					$this->validModules[] = $this->allModules[$i];
				}
			}
		}
	}
	
