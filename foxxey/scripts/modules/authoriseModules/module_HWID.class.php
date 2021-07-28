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
 Version: 0.1.2.5 Experimental
-----------------------------------------------------
 Usage: Get and synchronise user's HWID
=====================================================
*/
if(!defined('FOXXEY')) {
	die ("Not a real Fox! =(");
}

class HWID extends Authorise{
		
		protected $login;
		protected $HWID = "";		
		private $check;	
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
			if($this->HWID !== null) {
				$this->checkMultiHWID();
				$query = "INSERT INTO `usersHWID`(`login`, `hwid`) VALUES ('".$this->login."','".$this->HWID."')";
				$this->launcherDB->run($query);
			} else {
				exit("No HWID was provided");
			}
		}
		
		private function checkMultiHWID(){
			$query = "SELECT * FROM `usersHWID` WHERE hwid = '".$this->HWID."'";
			$data = $this->launcherDB->getRow($query);
			$checkHWID = $data['hwid'];
			$existingName = $data['login'];
			if($data !== false && $existingName !== $this->login && $checkHWID === null) {
				die('{"message": "Already have an account called '.$existingName.'!"}');
			}
		}
					
		function checkHWID(){
			$this->checkMultiHWID($this->HWID, $this->login);  //One account per PC
			if($this->HWID !== $this->realHWID) {
				$this->check = false;
				if($this->realHWID === null){
					if($this->HWID !== '') {
						$this->check = true;
						$this->insertHWID();
						if($this->debug) {
							echo('{"message": "Setting '.$this->HWID.' as '.$this->login.'`s new HWID"}');
						}
					} else {
						exit('{"message": "No HWID was provided. Unable to continue =("}');
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
		
		protected function getUserNameByHWID(){
			$query = "SELECT * FROM `usersHWID` WHERE hwid = '".$this->HWID."';";
			$data = $this->launcherDB->getRow($query);
			$existingName = $data['login'];
			
			return $existingName;
		}
	}