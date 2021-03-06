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
 Version: 0.1.6.0 Alpha
-----------------------------------------------------
 Usage: Engine actions (Logged only)
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
						admFunctions::logIn($login, $password, $ip, $this->parseInfoArray, $rememberMe, $this->webSiteDB);
				} else {
					//If isLogged
					if(@$_SESSION['isLogged'] === true) {
						//If usergroup is allowed to use API
						if(in_array(json_decode(admFunctions::getUserData($_SESSION['login'], 'user_group', $webSiteDB)) -> user_group, $admConfig['groupsToShow'])) {
							//Engine Actions
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
								
								case 'clearLastLog':
									admFunctions::clearLastLog();
								break;

								default:
									die('{"message": "Unknown adm Action request!", "type": "error"}');
								break;
							}
						} else {
							die('{"message": "Insufficent rights!", "type": "warn"}');
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