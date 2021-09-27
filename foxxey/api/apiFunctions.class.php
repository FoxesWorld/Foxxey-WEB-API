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
			
			public static function wrongPassList($db) {
				$outputJson = array();
				$query = "SELECT * FROM `wrongPass`";
				$data = $db->getRows($query);
				foreach($data as $key) {
					$outputJson[] = array(
						'login' => $key['login'],
						'realLogin' => $key['realLogin'],
						'timestamp' => apiFuncftions::dateToGoodDate($key['timestamp'])
					);
				}
				return json_encode($outputJson);
			}
			
			public static function succesfulAuth($db) {
				$outputJson = array();
				$query = "SELECT * FROM `successfulAuth`";
				$data = $db->getRows($query);
				foreach($data as $key) {
					$outputJson[] = array(
						'login' => $key['login'],
						'timestamp' => apiFuncftions::dateToGoodDate($key['timestamp'])
					);
				}
				return json_encode($outputJson);
			}
			
			private static function dateToGoodDate($date) {
				global $config;
				$dateArr = explode('-', $date);
				$month = $config['monthArray'][$dateArr[1]];
				$day = explode(' ', $dateArr[2]);
				$time = explode('.',$day[1]);
				$outputDate = $day[0].' '.$month.' '.$dateArr[0].' '.$time[0];
				return $outputDate;
			}
	}