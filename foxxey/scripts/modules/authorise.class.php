<?php
/*
=====================================================
 Tell me your password and I'll tell who you are 
-----------------------------------------------------
 https://Foxesworld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: authorise.class.php
-----------------------------------------------------
 Verssion: 0.1.1.0 Alpha
-----------------------------------------------------
 Usage: Authorising and using HWID
=====================================================
*/
class Authorise {
	
		/* INPUT DATA */
		protected $login;
		protected $pass;
		protected $HWID;
		
		/* INTERNAL */
		private $isLogged;
		private $HWIDstatus;
		private $database;
		private $webSiteFunction;
		
		/* USERDATA */
		private $realName;
		private $realPass;
		private $fullname;
		private $userGroup;
		private $regDate;
	
		function __construct($login, $pass, $HWID){
			global $config;
			$this->webSiteFunction = new functions($config['db_user'], $config['db_pass'], $config['db_database'], $config['db_host']);
			$this->login = $login;
			$this->pass = $pass;
			$this->HWID = $HWID;
			$this->isLogged = false;
		}
	
		function logIn (){
			global $config, $message;
			//FILTRATING INPUT DATA
				$this->login = str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($this->login)));
				$this->pass  = str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($this->pass)));
				$this->HWID  = str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($this->HWID)));
			//*********************
			
			//Getting USERDATA
			$this->realName  = json_decode($this->webSiteFunction->getUserData($this->login, 'name'))		-> name		 ?? null;
			$this->realPass  = json_decode($this->webSiteFunction->getUserData($this->login, 'password'))	-> password	 ?? null;
			$this->fullname  = json_decode($this->webSiteFunction->getUserData($this->login, 'fullname'))	-> fullname   ?? $this->webSiteFunction->getRandomName();
			$this->userGroup = json_decode($this->webSiteFunction->getUserData($this->login, 'user_group'))	-> user_group ?? 4;
			$this->regDate 	 = json_decode($this->webSiteFunction->getUserData($this->login, 'reg_date'))	-> reg_date	 ?? null;
			
			if($this->login !== '' && $this->pass !== '') {
					if($this->realName !== null && $this->realPass !== null) {
						if(strlen($this->realPass) == 32 && ctype_xdigit($this->realPass)) {
							if($this->realPass == md5(md5($this->pass))) {
								$this->isLogged = true;
							}
						} else {
							if(password_verify($this->pass, $this->realPass)) {
								$this->isLogged = true;
							}
						}
							if($this->isLogged) {

								// Checking HWID
									$hardwareCheck = new HWID($this->login, $this->HWID, $config['HWIDdebug']);
									$this->HWIDstatus = $hardwareCheck->checkHWID() ? 'true' : 'false';
								//==============
								
								// Getting Balance
								$balance = new userbalance($this->login, false);
								$coins = $balance->getUserBalance()['realmoney'];
								//================

							if($this->HWIDstatus === 'true'){
								$this->webSiteFunction->passwordReHash($this->pass, $this->realPass, $this->realName);
								exit('{"login": "'.$this->login.'", "fullName":"'.$this->fullname.'", "regDate": '.$this->regDate.', "userGroup": '.$this->userGroup.',  "balance": '.$coins.', "hardwareId":  '.$this->HWIDstatus.'}');
							} else {
								exit('{"login": "'.$this->login.'", "fullName":"'.$this->fullname.'", "message": "'.$message['HWIDerror'].'", "hardwareId": '.$this->HWIDstatus.'}');
							}

						} else {
							exit($message['wrongLoginPass']);
						}
				} else {
					exit($message['userNotFound']);
				}
			} else {
				exit($message['dataNotIsset']);
			}
		}
}