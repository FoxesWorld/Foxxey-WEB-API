<?php
/*
=====================================================
 All main wires are plugged, we are ready to start!
-----------------------------------------------------
 https://FoxesWorld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: engine.php
-----------------------------------------------------
 Version: 0.1.4.0 Experimental
-----------------------------------------------------
 Usage: Engine actions
=====================================================
*/
if(!defined('FOXXEYadm')){
	die('{"message": "Not In Admin Thread!"}');
}

	class ADMengine {
		
		private $action;
		private $ip;
		private $webSiteDB;
		private $parseInfoArray;
		
		function __construct($request, $ip, $webSiteDB){
			global $admConfig;
			$this->ip = $ip;
			$this->webSiteDB = $webSiteDB;
			$this->action = $request['action'] ?? null;
			if(isset($this->action)) {
				switch($this->action){
					case 'logIn':
						$login = $_POST['login'];
						$password = $_POST['password'];
						@$rememberMe = $_POST['rememberMe'];
						$this->parseInfoArray = $admConfig['additionalParseData'];
						admFunctions::logIn($login, $password, $this->parseInfoArray, $rememberMe, $this->webSiteDB);
					break;
					//TODO "Tru to use `If check` inside switch case"
					case 'logOut':
						if(@$_SESSION['isLogged'] === true) {
							admFunctions::logOut();
						} else {
							die('{"message": "Not logged in to LogOut!!!"}');
						}
					break;
					
					case 'loadPage':
						if(@$_SESSION['isLogged'] === true) {
							$page = $_POST['page'];
							require ('pages.class.php');
							$adminPages = new adminPages($page);
						} else {
							die('{"message": "Not logged in!"}');
						}
					break;
					
					case 'sendNotes':
						if(@$_SESSION['isLogged'] === true) {
							require(ADMIN_DIR.'engine/modules/changeNotes.class.php');
							$notes = $_POST['adminNotes'];
							$changeAdminNotes = new changeAdminNotes($notes);
						} else {
							die('{"message": "Not logged in!"}');
						}
					break;
					
					case 'readNotes':
						if(@$_SESSION['isLogged'] === true) {
							require(ADMIN_DIR.'engine/modules/changeNotes.class.php');
							$changeAdminNotes = new changeAdminNotes();
						} else {
							die('{"message": "Not logged in!"}');
						}
					break;

					default:
						die('{"message": "Unknown adm Action request!"}');
					break;
				}
			} else {
				die('{"message": "No Action was passed!"}');
			}
		}
	}