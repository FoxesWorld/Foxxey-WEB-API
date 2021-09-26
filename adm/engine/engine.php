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
 Version: 0.1.5.0 Experimental
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
				if($this->action === 'logIn') {
						$login = $_POST['login'];
						$password = $_POST['password'];
						@$rememberMe = $_POST['rememberMe'];
						$this->parseInfoArray = $admConfig['additionalParseData'];
						admFunctions::logIn($login, $password, $this->parseInfoArray, $rememberMe, $this->webSiteDB);
				} else {
					//If isLogged
					if(@$_SESSION['isLogged'] === true) {
						switch($this->action){
							case 'logOut':
									admFunctions::logOut();
							break;

							case 'loadPage':
									$page = $_POST['page'];
									require ('pages.class.php');
									$adminPages = new adminPages($page);
							break;

							case 'sendNotes':
									require(ADMIN_DIR.'engine/modules/changeNotes.class.php');
									$notes = $_POST['adminNotes'];
									$changeAdminNotes = new changeAdminNotes($notes);
							break;

							case 'readNotes':
									require(ADMIN_DIR.'engine/modules/changeNotes.class.php');
									$changeAdminNotes = new changeAdminNotes();
							break;
							
							case 'clearSUScache':
								$cachePath = @$_REQUEST['cachePath'];
								require (ADMIN_DIR.'engine/modules/startUpSoundcfg.class.php');
								startUpSoundCfg::clearSUScache($cachePath);
								
							break;

							default:
								die('{"message": "Unknown adm Action request!"}');
							break;
						}
					} else {
						die('{"message": "Not logged in!!!"}');
				} 
			}

			} else {
				die('{"message": "No Action was passed!"}');
			}
		}
	}