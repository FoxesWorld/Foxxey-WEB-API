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
 Version: 0.1.11.1 Delta
-----------------------------------------------------
 Usage: Get and synchronise user's HWID
=====================================================
*/
if(!defined('Authorisation')) {
	die('{"message": "Not in authorisation thread"}');
}

	class HWID extends Authorise {
		
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
			$this->HWIDisexists();
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
					die('{"message": "'.str_replace('{existingAccount}', $existingName, $message['HWIDexists']).'"}');
				}
			}
		}
					
		public function checkHWID(){
			global $systemMessages;
			$this->checkMultiHWID($this->HWID, $this->login);  //One account per PC
			if($this->HWID !== $this->realHWID) {
				$this->check = false;
				if($this->realHWID === null){
					if($this->HWID !== '') {
						$this->check = true;
						$this->insertHWID();
						if($this->debug) {
							echo('{"message": "'.str_replace(array('{login}', '{HWID}'), array($this->login, $this->HWID), $systemMessages['settingHWID']).'"}');
						}
					} else {
						exit('{"message": "'.$systemMessages['noHWIDprovided'].'"}');
					}
				} else {
					if($this->debug) {
						echo('{"message": "'.$systemMessages['IncorrectHWID'].'"}');
					}
				}
			} else {
				$this->check = true;
				if($this->debug) {
					echo('{"message": "'.str_replace(array('{login}', '{HWID}'), array($this->login, $this->HWID), $systemMessages['correctHWID']).'"}');
				}
			}
			return $this->check;
		}
		
		private function HWIDisexists(){
			$query = "SELECT * FROM `usersHWID` WHERE login = '".$this->login."'";
			$data = $this->launcherDB->getRow($query);
			$this->HWIDexists = $data['hwid'];
		}
		
		protected function getUserNameByHWID(){
			$query = "SELECT * FROM `usersHWID` WHERE hwid = '".$this->HWID."';";
			$data = $this->launcherDB->getRow($query);
			$existingName = $data['login'];
			
			return $existingName;
		}
		
		protected function getRestoringNameByHWID($hwid){
			$query = "SELECT * FROM `HWIDrenew` WHERE newHWID = '".$hwid."';";
			$data = $this->launcherDB->getRow($query);
			$restoringName = $data['login'];
			
			return $restoringName;
		}		
		
		//renewHWID methods =================Fixed-V.2
		public function renewHWID($email, $ip, $login, $newHWID) {
			global $message;
			$lastSentRequest = $this->checkTokenTime($login);
			//If a reset HWID session is not currently active
			if($this->selectReNewHWID($newHWID) === false) {
				//If we dont find a user with an existing account to this HWID
				if($this->getUserNameByHWID() == NULL) {
					//If we finf a request with non expired data
					if(functions::checkTime(intval($lastSentRequest)) === false) {
						die('{"message": "'.str_replace('{login}', $login, $message['HWIDcrqstWasSent']).'"}');
					} else {
						$this->removeHWIDresetRequest($login);
						$this->addDBtoken($login, $newHWID, $email, $ip);
					}
				} else {
					//Else if user is trying to restore an account but already has another account to his HWID
					die('{"message": "'.str_replace('{existingAccount}', $this->getUserNameByHWID(), $message['HWIDnotYours']).'"}');
				}
			//You already have an active session for {login}
			} else {
				die('{"message": "'.str_replace('{login}', $this-> getRestoringNameByHWID($newHWID), $message['AlreadyRestoring']).'"}');
			}
		}

		private function addDBtoken($login, $newHWID, $email, $ip){
			global $config, $message;
			$hwidHash = functions::generateLoginHash();
			$timeAwait = CURRENT_TIME + 86400;
			$query = "INSERT INTO `HWIDrenew`(`login`, `newHWID`, `timestamp`, `hash`) VALUES ('".$login."','".$newHWID."','".$timeAwait."','".$hwidHash."')";
			$this->launcherDB->run($query);
			$this->sendHWIDResetEmail($email, str_replace('{login}', $login, $message['HWIDrenew']), $ip, $login, $config['webserviceName'], $hwidHash);
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
		
		private function selectReNewHWID($HWID){
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
				$replaceArr = array("{login}", "{IP}", "{toGetFromNikitaFox}", "{Credits}", "{resetLink}");
				$replacerArr = array($login, $ip, 'Данные нового ПК (Система, процессор и так далее..)', $credits, 'https://api.foxesworld.ru/renewHWID/'.$hash);
				$sendText = str_replace($replaceArr, $replacerArr, $mailTpl);
			$mail->send($sendTo, $sendTitle, $sendText);
		}
		//=================
	}