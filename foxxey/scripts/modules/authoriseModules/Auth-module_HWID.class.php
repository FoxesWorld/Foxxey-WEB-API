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
 Version: 0.1.7.10 Beta
-----------------------------------------------------
 Usage: Get and synchronise user's HWID
=====================================================
*/
if(!defined('Authorisation')) {
	die('{"message": "Not in authorisation thread"}');
}

class HWID extends Authorise{
		
		protected $login;
		protected $HWID = "";		
		private $check;	
		private $realHWID;
		private $HWIDexists;
		private $debug;
		private $launcherDB;
				
		/**
		 * HWID constructor.
		 * @param $login
		 * @param $HWID
		 * @param bool $debug
		 */				
		function __construct($login, $HWID, $db, $debug = false){
			global $config;
			$this->debug = $debug;
			$this->launcherDB = $db;
			$this->check = false;
			$this->login = $login;
			$this->HWID = $HWID;
			$this->realHWID = $this->getHWID();
			$this->HWIDisexists($login);
		}
					
		function getHWID(){
				global $config;
				$query = "SELECT * FROM usersHWID WHERE login = '".$this->login."'";
				$selectedValue = $this->launcherDB->getRow($query);
				$this->realHWID = $selectedValue["hwid"];
				$realUser = $selectedValue["login"];
						
				return $this->realHWID;
		}
					
		function insertHWID(){
			if($this->HWID !== null) {
				$query = "INSERT INTO `usersHWID`(`login`, `hwid`) VALUES ('".$this->login."','".$this->HWID."')";
				$this->launcherDB->run($query);
			} else {
				exit("No HWID was provided");
			}
		}
		
		private function checkMultiHWID(){
			global $message;
			$query = "SELECT * FROM `usersHWID` WHERE hwid = '".$this->HWID."'";
			$Logger = new Logger('AuthLog');
			$data = $this->launcherDB->getRow($query);
			$checkHWID = $data['hwid'];
			$existingName = $data['login'];
			if($checkHWID !== null && $existingName !== $this->login) {
					if($this->HWIDexists === null) {
						$Logger->WriteLine($existingName.' has tried to create a multi account with login: '.$this->login .', but was restricted to do that!');
						die('{"message": "'.$message['HWIDexists'].$existingName.'!"}');
					}
			}
		}
					
		public function checkHWID(){
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
		
		private function HWIDisexists($login){
			$query = "SELECT * FROM `usersHWID` WHERE login = '".$login."'";
			$data = $this->launcherDB->getRow($query);
			$this->HWIDexists = $data['hwid'];
		}
		
		protected function getUserNameByHWID(){
			$query = "SELECT * FROM `usersHWID` WHERE hwid = '".$this->HWID."';";
			$data = $this->launcherDB->getRow($query);
			$existingName = $data['login'];
			
			return $existingName;
		}
		
		//renewHWID methods =====================
		public function renewHWID($email, $ip, $login, $newHWID) {
			global $message;
			$lastSentRequest = $this->checkTokenTime($login);
			if($this->selectNewHWID($newHWID) === false) {
				if(functions::checkTime(intval($lastSentRequest)) === false) {
					die('{"message": "'.$message['HWIDcrqstWasSent'].'"}');
				} else {
					$this->removeHWIDresetRequest($login);
					$this->addDBtoken($login, $newHWID, $email, $ip);
				}
			} else {
				die('{"message": "User with HWID - `'.$newHWID.'` is already renewing it"}');
			}
		}

		private function addDBtoken($login, $newHWID, $email, $ip){
			global $config, $message;
			$hwidHash = functions::generateLoginHash();
			$timeAwait = CURRENT_TIME + 86400;
			$query = "INSERT INTO `HWIDrenew`(`login`, `newHWID`, `timestamp`, `hash`) VALUES ('".$login."','".$newHWID."','".$timeAwait."','".$hwidHash."')";
			$this->launcherDB->run($query);
			$this->sendHWIDResetEmail($email, $message['HWIDrenew'], $ip, $login, $config['webserviceName'], $hwidHash);
		}

		private function checkTokenTime($login){
			$query = "SELECT `timestamp` FROM `HWIDrenew` WHERE login = '".$login."'; DELETE FROM `HWIDrenew` WHERE timestamp < ".CURRENT_TIME."";
			$data = $this->launcherDB->getRow($query);
			$timestamp = intval($data['timestamp']);

			return $timestamp;
		}

		private function removeHWIDresetRequest($login){
			try {
			$query = "DELETE FROM `HWIDrenew` WHERE login= '".$login."'";
			$this->launcherDB->run($query);
			} catch (Exception $e) {
				echo '{"message": "'.$e.'"}';
			}
		}
		
		private function selectNewHWID($HWID){
			$query = "SELECT * FROM HWIDrenew WHERE `newHWID` = '".$HWID."'";
			$data = $this->launcherDB->getRow($query);
			if($data){
				return true;
			} else {
				return false;
			}
		}

		private function sendHWIDResetEmail($sendTo, $sendTitle, $ip, $login, $credits, $hash){
			$mail = new foxMail(1);
			$mailTpl = $mail->getTemplate('changeHWID');
				$replaceArr = array("{login}", "{IP}", "{toGetFromNikitaFox}", "{Credits}", "{resetHash}");
				$replacerArr = array($login, $ip, 'Данные нового ПК (Система, процессор и так далее..)', $credits, 'https://api.foxesworld.ru/launcher.php?changeHWID='.$hash);
				$sendText = str_replace($replaceArr, $replacerArr, $mailTpl);
			$mail->send($sendTo, $sendTitle, $sendText);
		}
		//=================
	}