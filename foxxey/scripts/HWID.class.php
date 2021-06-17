<?php
/*
=====================================================
 What's your processors Id?! | HWID Class
-----------------------------------------------------
 https://FoxesWorld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: HWID.class.php
-----------------------------------------------------
 Version: 0.1.0.0 Experimental
-----------------------------------------------------
 Usage: Get and synchronise user's HWID
=====================================================
*/
if(!defined('FOXXEY')) {
	die ("Not a real Fox! =( HWID");
}

class HWID {
					
		private $check;
		private $login;
		private $HWID;
		private $realHWID;
		private $debug;
		private $launcherDB;
					
		function __construct($login, $HWID, $debug = false){
			global $config;
			$this->debug = $debug;
			$this->check = false;
			$this->login = $login;
			$this->HWID = $HWID;
			$this->realHWID = $this->getHWID();
		}
					
		function getHWID(){
				global $config;
				$this->launcherDB = new db($config['db_user'],$config['db_pass'],$config['dbname_launcher']);
				$query = "SELECT * FROM usersHWID WHERE login = '".$this->login."'";
				$selectedValue = $this->launcherDB->getRow($query);
				$this->realHWID = $selectedValue["hwid"];
				$realUser = $selectedValue["login"];
						
				return $this->realHWID;
		}
					
		function insertHWID(){
			$query = "INSERT INTO `usersHWID`(`login`, `hwid`) VALUES ('".$this->login."','".$this->HWID."')";
			$this->launcherDB->run($query);
		}
					
		function checkHWID(){
				if($this->HWID !== $this->realHWID) {
					$this->check = false;
					if($this->realHWID === null){
							$this->check = true;
							$this->insertHWID();
							if($this->debug) {
								echo('{"message": "Setting '.$this->HWID.' as '.$this->login.'`s new HWID"}');
						}
					} else {
						if($this->debug) {
							echo('{"message": "Incorrect HWID!"}');
						}
					}
				} else {
					$this->check = true;
					if($this->debug) {
						echo('{"message": "'.$this->HWID.' HWID is correct for '.$this->login.'"}');
					}
				}
				return $this->check;
			}
		}