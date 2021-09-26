<?php
/*
=====================================================
 I know what function you need right now!
-----------------------------------------------------
 https://FoxesWorld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: functions.class.php
-----------------------------------------------------
 Version: 0.1.7.1 Experimental
-----------------------------------------------------
 Usage: All adminPanel functions
=====================================================
*/
if(!defined('FOXXEYadm')){
	die('{"message": "Not In Admin Thread!"}');
}

	abstract class admFunctions {
		
		public static function incFiles($path, $mask, $fileType) {
			$filesArray = self::filesInDirArray($path, $mask);
			foreach($filesArray as $key){
				if($fileType == 'css') {
					echo '<link rel="stylesheet" href="'.$path.$key.'">';
				} elseif($fileType == 'js') {
					if(!strpos($key, '.selfInc')) {
						echo '<script src="'.$path.$key.'"></script>'; 
					}
				} else {
					die('{"message": "Unknown fileType!"}');
				}
			}
		}
		
		public static function getTemplate($name) {
			ob_start();
			include ($name.".tpl");
			$text = ob_get_clean();
			return $text;
		}
		
		public static function unixToReal($unixDate) {
			global $admConfig;
			$currentDate = date("d.m.Y", $unixDate);
			$_monthsList = $admConfig['monthArray'];
			$_mD = date(".m.", $unixDate);
			$currentDate = str_replace($_mD, " ".$_monthsList[$_mD]." ", $currentDate);
			
			return $currentDate;
		}
		
		public static function logIn($login, $password, $parseInfoArray, $rememberMe, $db) {
			global $config, $admConfig;
			$group = json_decode(admFunctions::getUserData($login, 'user_group', $db)) -> user_group ?? null;

			if(!in_array($group, $admConfig['groupsToShow'])){
				exit('{"message": "Insufficent rights!", "type": "warn"}');
			} else {
				$passwordDB = json_decode(admFunctions::getUserData($login, 'password', $db)) -> password ?? null;
				if(password_verify($password, $passwordDB)) {
							
						//Parsing userInfo
						foreach($parseInfoArray as $key){
							$val = json_decode(admFunctions::getUserData($login, $key['name'], $db)) -> {$key['name']};
							$val = self::textTypeFormatting($val, $key['type']);
							$_SESSION[$key['name']] = $val;
						}
							
					//Defining systemData
					$_SESSION['login']    = $login;
					$_SESSION['pass'] 	  = $password;
					$_SESSION['isLogged'] = true;

					if($rememberMe) {
						session_write_close();
						ini_set('session.cookie_lifetime', 0);
						session_set_cookie_params(0);
					}
					die('{"type": "success", "message": "Successful authorisation!"}');
				} else {
					//WIP
					require (SCRIPTS_DIR.'modules/module_antiBrute.class.php');
						if($config['useAntiBrute'] === true) {
							//$launcherDB = new db($config['db_user'],$config['db_pass'],$config['dbname_launcher']);
							//$antiBrute = new antiBrute($this->ip, $launcherDB, $config['antiBruteDebug']);
						}
					die('{"message": "Incorrect login or password", "type": "error"}');
				}
			}
		}
		
		public static function logOut() {
				session_unset();
				session_destroy();
				die('{"message": "Exit successful!", "type": "success"}');
		}
		
		public static function getUserData($login, $data, $db){
			$query = "SELECT $data FROM dle_users WHERE name = '$login'";
			$selectedValue = $db->getRow($query);
				if($selectedValue["$data"]){
						$gotData = $selectedValue["$data"];
						$answer = array('type' => 'success', 'username' => $login, $data => $gotData);
						$answer = json_encode($answer);
					} else {
						$answer = "{'type', 'warn', 'message', 'Login not found'}";
					}
			return $answer;
		}
		
		public static function filesInDirArray ($dir, $fileMask){
			$files = array();
			$openDir = opendir($dir);
			while($file = readdir($openDir)){
				$filesToadd = strpos($file, $fileMask);
					if ($file != "." && $file != ".." && $filesToadd && !strpos($file, 'off') && !strpos($file, '.map')){
						$files[] = $file;
					}
			}
			closedir($openDir);
			return $files;
		}
		
		private static function textTypeFormatting($val, $type){
			switch ($type){
				case 'plainText':
					
				break;
				
				case 'date':
					$val = admFunctions::unixToReal($val);
				break;
				
				case 'realname':
					if(!$val){
						$val = 'An unknown MasterFox';
					}
				break;
			}
			
			return $val;
		}
	}
?>