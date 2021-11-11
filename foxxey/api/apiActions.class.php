<?php
/*
=====================================================
 apiActions - Act with your applications!
-----------------------------------------------------
 https://Foxesworld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: config.php
-----------------------------------------------------
 Version: 0.1.2.0 Alpha
-----------------------------------------------------
 Usage: Main API action file
=====================================================
*/
header("Content-Type: application/json; charset=UTF-8");
	if(!defined('API')) {
		die('Not in API thread!');
	}

	class apiActions {
		
			private $ip;
			private $userDataDB;
			private $launcherDB;
			
			/* SystemInfo */
			private $os_version;
			private $phpVersion;
	
		function __construct($request, $value, $ip, $userDataDB, $launcherDB){
			global $config;
			
			$this->ip = $ip;
			$this->userDataDB = $userDataDB;
			$this->launcherDB = $launcherDB;
			
			$this->os_version = @php_uname( "s" ) . " " . @php_uname( "r" );
			$this->phpVersion = phpversion();

			switch($request){
				//Debug function
					   case 'testBan':
							$longTermBan = new longTermBan($this->ip, $this->launcherDB, $value);
							$longTermBan->banIP();
					   break;
							   
				//Debug function
					   case 'rndPhrase':
							$randTexts = new randTexts($value);
							exit($randTexts->textOut());
					   break;
						   
					   case 'modules':
						   $allModules = functions::modulesInit();
						   $modules = $allModules['validModules'];
						   $counter = 1;
							for($i = 0; $i < count($modules); $i++) {
								$validModules[] = array('module' => $counter.') '.$modules[$i]);
								$counter++;
							}
								
						   exit(json_encode($validModules));
					   break;
						   
					   case 'systemInfo':
							exit('{"serverOS": "'.$this->os_version.'","phpVersion": "'.$this->phpVersion.'"}');
					   break;
					
						/* WIP Exception!!! */
					   case 'awards':
							//$this->userDataDB = new db($config['db_user'],$config['db_pass'],$config['db_name_userdata']);
							exit(apiFuncftions::selectAwardedUsers($this->userDataDB));
					   break;
						   
					   case 'cities':
							 $cities = apiFuncftions::selectCities($this->launcherDB);
							 $citiesNames = array();
							 $playersCountArr = array();
							 foreach($cities as $key) {
								 $citiesNames[] = $key["cityName"];
								 $playersCountArr[] = $key["cityCount"];
							 }
							 $playersCount = array_sum($playersCountArr);
							 exit('{"totalCities": '.count($citiesNames).', "totalPlayers": '.$playersCount.'}');			 
					   break;
					   
					   case 'wrongAuth':
							exit(apiFuncftions::wrongPassList($this->launcherDB));
					   break;
					   
					   case 'succesfulAuth':
							exit(apiFuncftions::succesfulAuth($this->launcherDB));
					   break;
						   
					   default:
							die('{"message": "Unknown API request `'.$request.'`!"}');
			}
		}
	
	}