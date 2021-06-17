<?php
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

		function getRandomName(){
			$array = array('Феспис',
			   'Неизвестная личность',
			   'Безимянный Лис',
			   'Таинственный незнакомец',
			   'Тот чьё имя нельзя называть',
			   'Скрытный незнакомец',
			   'Шпиён!!1');
			$randWord = rand(0, count($array)-1);

			return $array[$randWord];
		}

		function getUserData($login,$data){
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

		function passwordReHash($pass, $realPass, $realName){
			global $config;
			$db = new db($config['db_user'],$config['db_pass'],$config['db_database']);
			if (password_needs_rehash($realPass, PASSWORD_DEFAULT)) {
				session_regenerate_id();
				$this->realPass = password_hash($this->pass, PASSWORD_DEFAULT);
				$new_pass_hash = 'password='.$db->safesql($realPass).', ';
			} else {
				$new_pass_hash = '';
			}

			$hash = $this->generateLoginHash();
			$db->run("UPDATE LOW_PRIORITY dle_users SET ".$new_pass_hash." hash='".$hash."', lastdate='".CURRENT_TIME."' WHERE name='".$realName."'");
		}

		function generateLoginHash(){
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

			public static function display_error($error ='No errors', $error_num = 100, $query) {
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