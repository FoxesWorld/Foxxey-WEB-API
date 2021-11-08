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
 Version: 0.1.0.1 Alpha
-----------------------------------------------------
 Usage: Initialiasing API (After primary init)
=====================================================
*/

/* TODO */

	class apiInit {

		private $request;
		
		function __construct($ip, $userDataDB, $launcherDB, $request = null){
				if($ip != null) {
				if($request) {
					$this->request = $request;
					require ('apiFunctions.class.php');
					$apiFuncftions = new apiFuncftions($ip, $userDataDB, $launcherDB, $_REQUEST);
				} else {
					die('{"message": "Undefined Request!"}');
				}
			} else {
				die('{"message": "Undefined IP!"}');
			}
		}	
	}
	
	