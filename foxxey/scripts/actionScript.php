<?php
/*
=====================================================
 What should I do!? | Action script
-----------------------------------------------------
 https://FoxesWorld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: actionScript.php
-----------------------------------------------------
 Version: 0.2.5.2 Experimental
-----------------------------------------------------
 Usage: Global ACTIONS module hooking
=====================================================
*/
if($config['debugStartUpSound'] === false) {
	header("Content-Type: application/json; charset=UTF-8");
}
	if(!defined('FOXXEY')) {
		die ('{"message": "Not in FOXXEY thread"}');
	}

	class actionScript {
		
		protected $launcherDB;
		protected $userDataDB;
		protected $ip;
		
		function __construct($launcherDB, $userDataDB, $ip){
			$this->launcherDB = $launcherDB;
			$this->userDataDB = $userDataDB;
			$this->ip = $ip;
			$this->listActions($_GET);
		}
		
		private function listActions($request){
			global $config;
				foreach ($request as $key => $value) {
				$requestTitle = trim(str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($key))));
				$requestValue = trim(str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($value))));

				  /* ACTIONS */
				  switch ($requestTitle) {
					  
					//Authorising
				   case 'auth':
					   require (SITE_ROOT.'/actions/module_authorise.class.php');
					   if(class_exists('Authorise')) {
							$login		 = $_GET['login'] 		?? null;
							$password 	 = $_GET['password'] 	?? null;
							$hwid 		 = $_GET['hwid']		?? null;
							$Auth 		 = new Authorise($login, $password, $hwid, $this->launcherDB, $this->userDataDB, $this->ip);
							die($Auth->logIn());
					   } else {
						   die('{"message": "Module Authorise not found!", "desc": "Can`t authorise user!"}');
					   }
				   break;
				   
				   case 'modPackFiles':
						if(in_array($requestValue, functions::getServersList($this->launcherDB))) {
							die(functions::checkDir($requestValue, $this->launcherDB));
						} else {
							die('{"message": "Not found a '.$requestValue.' client!"}');
						}
				   break;
				   
				   //startUpSound using
				   case 'startUpSound':
					   require (SITE_ROOT.'/actions/module_startUpSound.class.php');
					   if(class_exists('startUpSound')) {
							$startSound = new startUpSound($config['debugStartUpSound']);
							die($startSound->generateAudio());
					   } else {
						   die('{"message": "Module startUpSound not found!", "desc": "Can`t greet user with awesome startUP sound =("}');
					   }
				   break;
				   
				   //Getting user Skin&Cloak
				   case 'show':
					   require (SITE_ROOT.'/actions/module_SkinViewer2D.class.php');
					   if(class_exists('skinViewer2D')) {
						header("Content-type: image/png");
						$show = $_GET['show'] ?? null;
						$file_name = $_GET['filename'] ?? null;
						$name =  empty($file_name) ? 'default' : $file_name;
							$skin =  $config['skinsAbsolute'] . $name . '.png';
							$cloak = $config['cloaksAbsolute'] . $name . '.png';

							if (!skinViewer2D::isValidSkin($skin)) {
								$skin = $config['skinsAbsolute'] . 'default.png';
							}

							if ($show !== 'head') {
								$side = isset($_GET['side']) ? $_GET['side'] : false;
								$img = skinViewer2D::createPreview($skin, $cloak, $side);
							} else {
								$img = skinViewer2D::createHead($skin, 64);
							}
							imagepng($img);
					   } else {
							die('{"message": "Module skinViewer2D not found!", "desc": "Can`t show user how beautiful he is =("}');
					   }
				   break;
				   
				   case 'startUpSoundExp':
					require (SITE_ROOT.'/actions/module_startUpSound.classExp.php');
					$startSound = new startUpSound($config['debugStartUpSound']);
					die($startSound->generateAudio());
				   break;
				   
				   //Changing HWID
				   case 'changeHWID':
				   			if($config['useAntiBrute'] === true) {
								if(class_exists('antiBrute')){
									$antiBrute = new antiBrute($this->ip, $this->launcherDB, $config['antiBruteDebug']);
								}
							}
						$hashUpdate  = new functions($config['db_user'], $config['db_pass'], $config['dbname_launcher'], $config['db_host']);
						$hashUpdate->confirmHWIDchange($requestValue);
				   break;
				   
				   case 'BuildInfo':
						die('{"message": "DarkFoxes was here!"}');
				   break;

				   default:
					die('{"message": "Unknown action request `'.$requestTitle.'`!"}');
				   break;
				}
			}
		}
	}