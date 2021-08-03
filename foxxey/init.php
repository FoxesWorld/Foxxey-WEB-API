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
 Version: 0.1.4.0 Alpha
-----------------------------------------------------
 Usage: Initialising&Including modules
=====================================================
*/
	header('Content-Type: text/html; charset=utf-8');
	if(!defined('FOXXEY')) {
		die ('{"message": "Not in FOXXEY thread"}');
	} else {
		require ('foxxey/config.php');
		require (SCRIPTS_DIR.'database.class.php');
		require (SCRIPTS_DIR.'functions.class.php');
	}


	class init {
		
		private $longTermBan;
		
		//Modules==================
		protected $primaryModules;
		protected $otherModulles;
		protected $allModules;
		//=========================
		
		//Databases================
		protected $launcherDB;
		protected $userDataDB;
		//=========================
		function __construct($ip) {
			global $config;
			$this->userDataDB = new db($config['db_user'],$config['db_pass'],$config['db_name_userdata']);
			$this->launcherDB = new db($config['db_user'],$config['db_pass'],$config['dbname_launcher']);
			$this->allModules = functions::filesInDirArray(SCRIPTS_DIR.'modules','.php');

				for($i = 0; $i < count($this->allModules); $i++){
					if(strpos($this->allModules[$i],'.pri.')) {
						$this->primaryModules[] = $this->allModules[$i];
					} else {
						$this->otherModulles[] = $this->allModules[$i];
					}
				}
			functions::includeModules(SCRIPTS_DIR.'modules', $config['modulesDebug'], $this->primaryModules);
			$this->longTermBan = new longTermBan($ip, $this->launcherDB);
			if($this->longTermBan->checkBan() === false) {
				$dbPrepare = new dbPrepare;
				$dbPrepare->dbPrepare();
				require(SCRIPTS_DIR.'actionScript.php');
				$action = new actionScript($this->launcherDB, $this->userDataDB, $ip);
			} else {
				$randTexts = new randTexts('banned');
				die('{"message": "'.$randTexts->textOut().'"}');
			}
		}
	}
	
