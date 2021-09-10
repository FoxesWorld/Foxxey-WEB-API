<?php
/*
=====================================================
 API functions file
-----------------------------------------------------
 https://Foxesworld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: config.php
-----------------------------------------------------
 Version: 0.1.0.0 Alpha
-----------------------------------------------------
 Usage: Data parsing by API
=====================================================
*/
	if(!defined('API')) {
		die('Not in API thread!');
	}

	class apiFuncftions {
		
		private $ip;
		private $request;
		private $launcherDB;
		private $userDataDB;
		
		function __construct($ip, $userDataDB, $launcherDB, $request){
			global $config;
			$this->ip = $ip;
			$this->userDataDB = $userDataDB;
			$this->launcherDB = $launcherDB;
			$this->request = $request;
			

			foreach ($this->request as $key => $value) {
				$requestTitle = trim(str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($key))));
				$requestValue = trim(str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($value))));
				switch($requestTitle){
				//Debug function
					   case 'testBan':
						$longTermBan = new longTermBan($this->ip, $this->launcherDB, $requestValue);
						$longTermBan->banIP();
					   break;
						   
				//Debug function
					   case 'rndPhrase':
							$randTexts = new randTexts($requestValue);
							die($randTexts->textOut());
					   break;
					   
					   default:
						die('{"message": "Unknown API request `'.$requestTitle.'`!"}');
				}
			}
		}
	}