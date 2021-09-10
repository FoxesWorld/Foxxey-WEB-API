<?php
/*
=====================================================
 API initialisation file
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
 Usage: Initialiasing API
=====================================================
*/

	class apiInit {

		private $ip;
		private $request;
		
		function __construct($ip, $userDataDB, $launcherDB, $request = null){
			$this->ip = $ip;
				if($this->ip != null) {
				if($request) {
					$this->request = $request;
					require ('apiFunctions.php');
					$apiFuncftions = new apiFuncftions($ip, $userDataDB, $launcherDB, $_GET);
				}
			} else {
				die('{"message": "Undefined IP!"}');
			}
		}	
	}
	
	