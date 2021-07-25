<?php
/*
=====================================================
 Hey, I've got a lot of things fot you! | functions class
-----------------------------------------------------
 https://FoxesWorld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: functions,class.php
-----------------------------------------------------
 Version: 0.1.3.0 Experimental
-----------------------------------------------------
 Usage: A bunch of functions
=====================================================
*/
if(!defined('FOXXEY')) {
	die ("Not a real Fox! =(");
}

	class functions {

		private $dbHost;
		private $dbName;
		private $dbUser;
		private $dbPass;
		private $db;

		function __construct($dbUser, $dbPass, $dbName, $dbHost = 'localhost'){
			$this->dbUser = $dbUser;
			$this->dbPass = $dbPass;
			$this->dbName = $dbName;
			$this->dbHost = $dbHost;

			$this->db = new db($this->dbUser,$this->dbPass,$this->dbName, $this->dbHost);
		}
		
		/* ALL NON-STATIC FUNCTIONS REQUIRE DB */

		public function getUserData($login,$data){
			$query = "SELECT $data FROM dle_users WHERE name = '$login'";
			$selectedValue = $this->db->getRow($query);
				if($selectedValue["$data"]){
						$gotData = $selectedValue["$data"];
						$answer = array('type' => 'success', 'username' => $login, $data => $gotData);
						$answer = json_encode($answer);
					} else {
						$answer = "{'type', 'error', 'message', 'login not found'}";
					}
			return $answer;
		}

		public function passwordReHash($pass, $realPass, $realName){
			global $config;
			//$db = new db($config['db_user'],$config['db_pass'],$config['db_database']);
			if (password_needs_rehash($realPass, PASSWORD_DEFAULT)) {
				session_regenerate_id();
				$this->realPass = password_hash($this->pass, PASSWORD_DEFAULT);
				$new_pass_hash = 'password='.$this->db->safesql($realPass).', ';
			} else {
				$new_pass_hash = '';
			}

			$hash = functions::generateLoginHash();
			$this->db->run("UPDATE LOW_PRIORITY dle_users SET ".$new_pass_hash." hash='".$hash."', lastdate='".CURRENT_TIME."' WHERE name='".$realName."'");
		}
			
		public function insertCoins($login){
			global $config;
			$query = "UPDATE `balance` SET `realmoney`= realmoney+".$config['rewardAmmount']." WHERE username = '".$login."'";
			$db = new db($config['db_user'],$config['db_pass'],$config['db_name_userdata'], $config['db_host']);
			$db->run($query);
		}
		
		/* STATIC FUNCTIONS  (NO DB NEEDED)*/

			static function generateLoginHash(){
				if(function_exists('openssl_random_pseudo_bytes')) {
					$stronghash = md5(openssl_random_pseudo_bytes(15));
				} else {
					$stronghash = md5(uniqid( mt_rand(), TRUE )); 
				}
				$salt = sha1(str_shuffle("abcdefghjkmnpqrstuvwxyz0123456789").$stronghash);
				$hash = '';					
				for($i = 0; $i < 9; $i ++) {
					$hash .= $salt[mt_rand( 0, 39 )];
				}
				$hash = md5( $hash );

				return $hash;
			}
			
			public static function includeModules($dirInclude, $debug = false){
				$count = 1;
				$dir = opendir($dirInclude);
				if($debug === true){
					echo '<div style="width: fit-content;"><b>Modules to include: </b> (Debug)<hr style="margin: 0;">';
				}
				while($file = readdir($dir)){
					if($file == '.' || $file == '..'){
						continue;
					} else {
						if($debug === true){
							echo "<b>".$count."</b> Including module ".$file."<br>";
							$count ++;
						}
						if(strpos($file, 'module') !== false) {
							require ($dirInclude.'/'.$file);
						} else {
							if($debug === true){
								echo "<b>".$count."</b> ".$file." was not included as not the valid module<br>";
							}
						}
					}
				}
				if($debug === true){
					echo '<hr style="margin: 0;"> Total modules: <b>'.$count.'</b></div>';
				}
			}
			
			public static function countFilesNum($dirPath, $fileMask){
				$count = 0;
				if(is_dir($dirPath)) {
					$dir = opendir($dirPath);
					while($file = readdir($dir)){
						if($file == '.' || $file == '..' || is_dir($dir.'/' . $file)){
							continue;
						} elseif(strpos($file, $fileMask)){
							$count++;
						}
					}
					return $count;
				} else {
					return false;
				}
			}

			public static function display_error($error ='No errors', $error_num = 100500, $query) {
				global $config;
					$error = htmlspecialchars($error, ENT_QUOTES, 'ISO-8859-1');
					$trace = debug_backtrace();

					$level = 0;
					if ($trace[1]['function'] == "query" ) $level = 1;
					$trace[$level]['file'] = str_replace(ROOT_DIR, "", $trace[$level]['file']);

					echo '
							<?xml version="1.0" encoding="iso-8859-1"?>
							<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
							<html xmlns="http://www.w3.org/1999/xhtml">
							<head>
							<title>MySQL Fatal Error '.$config['webserviceName'].'</title>
							<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
							<style type="text/css">
							<!--
							body {
								font-family: Verdana, Arial, Helvetica, sans-serif;
								font-size: 11px;
								font-style: normal;
								color: #000000;
							}
							.top {
							  color: #ffffff;
							  font-size: 15px;
							  font-weight: bold;
							  padding-left: 20px;
							  padding-top: 10px;
							  padding-bottom: 10px;
							  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.75);
							  background-image: -moz-linear-gradient(top, #ab8109, #998f5a);
							  background-image: -ms-linear-gradient(top, #ab8109, #998f5a);
							  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ab8109), to(#998f5a));
							  background-image: -webkit-linear-gradient(top, #ab8109, #998f5a);
							  background-image: -o-linear-gradient(top, #ab8109, #998f5a);
							  background-image: linear-gradient(top, #ab8109, #998f5a);
							  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#ab8109", endColorstr="#998f5a",GradientType=0); 
							  background-repeat: repeat-x;
							  border-bottom: 1px solid #ffffff;
							}
							.box {
								margin: 10px;
								padding: 4px;
								background-color: #EFEDED;
								border: 1px solid #DEDCDC;
							}
							-->
							</style>
							</head>
							<body>
								<div style="width: 700px;margin: 20px; border: 1px solid #D9D9D9; background-color: #F1EFEF; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; -moz-box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3); -webkit-box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3); box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);" >
									<div class="top" >MySQ: Error! '.$config['webserviceName'].'</div>
									<div class="box" ><b>MySQL error</b> in file: <b>'.$trace[$level]['file'],'</b> at line <b>'.$trace[$level]['line'].'</b></div>
									<div class="box" >Error Number: <b>'.$error_num.'</b></div>
									<div class="box" >The Error returned was: <b>'.$error.'</b></div>
									<div class="box" ><b>SQL query:</b><br />'.$query.'</div>
									</div>		
							</body>
							</html>
					';
				exit();
			}
	}