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
 Usage: Functions to use in API
=====================================================
*/
header("Content-Type: application/json; charset=UTF-8");
	if(!defined('API')) {
		die('Not in API thread!');
	}

	class apiFuncftions {

		private $request;
		
		function __construct($ip, $userDataDB, $launcherDB, $request){
			global $config;
			require('apiActions.class.php');
			$this->request = $request;

			foreach ($this->request as $key => $value) {
				$requestTitle = trim(str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($key))));
				$requestValue = trim(str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($value))));
				$apiActions = new apiActions($requestTitle, $requestValue, $ip, $userDataDB, $launcherDB);
			}
		}
		
			public static function selectAwardedUsers($db){
				$query = "SELECT * FROM foxBonus";
				$data = $db->getRows($query);
				
				$logins = array();
				$countAwarded = 0;
				foreach ($data as $key){
					$logins[] = $key['login'];
					$countAwarded++;
				}
				
				$output = array('awardedUsers' => $logins, 'awardedNum' => $countAwarded);
				
				return json_encode($output, JSON_UNESCAPED_SLASHES);
			}
			
			public static function selectCities($db){
				$query = "SELECT * FROM ipCity";
				$data = $db->getRows($query);
				
				return $data;
			}
	}