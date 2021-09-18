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
 Version: 0.1.1.1 Alpha
-----------------------------------------------------
 Usage: Data parsing by API
=====================================================
*/
header("Content-Type: application/json; charset=UTF-8");
	if(!defined('API')) {
		die('Not in API thread!');
	}

	class apiFuncftions {
		
		private $ip;
		private $request;
		private $launcherDB;
		private $userDataDB;
		
		/* SystemInfo */
		private $os_version;
		private $phpVersion;
		
		function __construct($ip, $userDataDB, $launcherDB, $request){
			global $config;
			$this->ip = $ip;
			$this->userDataDB = $userDataDB;
			$this->launcherDB = $launcherDB;
			$this->request = $request;
			$this->os_version = @php_uname( "s" ) . " " . @php_uname( "r" );
			$this->phpVersion = phpversion();

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
							exit($randTexts->textOut());
					   break;
					   
					   case 'modules':
						   $allModules = functions::modulesInit();
						   $modules = $allModules['validModules'];
							for($i = 0; $i < count($modules); $i++) {
								$validModules[] = array('module' => $i.') '.$modules[$i]);
							}
							
						   exit(json_encode($validModules));
					   break;
					   
					   case 'systemInfo':
						exit('{"serverOS": "'.$this->os_version.'","phpVersion": "'.$this->phpVersion.'"}');
					   break;
					   
					   case 'awards':
						exit(var_dump(functions::selectAwardedUsers($this->userDataDB)));
					   break;
					   
					   case 'cities':
						 $cities = functions::selectCities($this->launcherDB);
						 $citiesNames = array();
						 $playersCountArr = array();
						 foreach($cities as $key) {
							 $citiesNames[] = $key["cityName"];
							 $playersCountArr[] = $key["cityCount"];
						 }
						 $playersCount = array_sum($playersCountArr);
						 exit('{"totalCities": '.count($citiesNames).', "totalPlayers": '.$playersCount.'}');
						 
					   break;
					   
					   default:
						die('{"message": "Unknown API request `'.$requestTitle.'`!"}');
				}
			}
		}
	}