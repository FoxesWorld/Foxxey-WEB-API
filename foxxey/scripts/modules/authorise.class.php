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
 Verssion: 0.1.3.0 Alpha
-----------------------------------------------------
 Usage: Authorising and using HWID
=====================================================
*/

	header('Content-Type: text/html; charset=utf-8');
	if(!defined('FOXXEY')) {
		die ("Not a real Fox! =( HWID");
	}
class Authorise {
	
		/* INPUT DATA */
		protected $login;
		protected $pass;
		protected $HWID;
		
		/* INTERNAL */
		private $correctLogin;
		private $HWIDstatus;
		private $database;
		private $webSiteFunc;

		/* USERDATA */
		private $realName;
		private $realPass;
		private $fullname;
		private $userGroup;
		private $regDate;
		
		function __construct($login, $pass, $HWID){
			global $config;
			$this->webSiteFunc  = new functions($config['db_user'], $config['db_pass'], $config['db_database'], $config['db_host']);
			//$this->udataDB    = new functions($config['db_user'], $config['db_pass'], $config['db_name_userdata'], $config['db_host']);
			//$this->launcherDB = new functions($config['db_user'], $config['db_pass'], $config['dbname_launcher'], $config['db_host']);
			$this->login = $login;
			$this->pass = $pass;
			$this->HWID = $HWID;
			$this->correctLogin = false;
		}
	
		function logIn (){
			global $config, $message;
			$coins = 0;
			//FILTRATING INPUT DATA
				$this->login = str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($this->login)));
				$this->pass  = str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($this->pass)));
				$this->HWID  = str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($this->HWID)));
			//*********************
			
			//Getting USERDATA
			$this->realName  = json_decode($this->webSiteFunc->getUserData($this->login, 'name'))		-> name		 ?? null;
			$this->realPass  = json_decode($this->webSiteFunc->getUserData($this->login, 'password'))	-> password	 ?? null;
			$this->fullname  = json_decode($this->webSiteFunc->getUserData($this->login, 'fullname'))	-> fullname   ?? $this->webSiteFunc->getRandomName();
			$this->userGroup = json_decode($this->webSiteFunc->getUserData($this->login, 'user_group'))	-> user_group ?? 4;
			$this->regDate 	 = json_decode($this->webSiteFunc->getUserData($this->login, 'reg_date'))	-> reg_date	 ?? null;
			
			if($this->login !== '' && $this->pass !== '') {
					$geoplugin = new geoPlugin();
					if($this->realName !== null && $this->realPass !== null) {
						if(strlen($this->realPass) == 32 && ctype_xdigit($this->realPass)) {
							if($this->realPass == md5(md5($this->pass))) {
								$this->correctLogin = true;
							}
						} else {
							if(password_verify($this->pass, $this->realPass)) {
								$this->correctLogin = true;
							}
						}
						
						if($this->correctLogin) { //If Login is correct

								// Checking HWID
									$hardwareCheck = new HWID($this->login, $this->HWID, $config['HWIDdebug']);
									$this->HWIDstatus = $hardwareCheck->checkHWID() ? 'true' : 'false';
								//==============

							if($this->HWIDstatus === 'true'){ //If HWID is correct too

								// Getting Balance
								$balance = new userbalance($this->login, false);
								$coins = $balance->getUserBalance()['realmoney'];
								//================

								// Fox checking
								$checkFox = new foxCheck($this->login, $config['foxCheckDebug']);
								if($checkFox->checkFox() === true){
									echo '{"message": "'.$message['congrats'].'"},';
									$this->webSiteFunc->insertCoins($this->login);
								}
								//=================

								$this->webSiteFunc->passwordReHash($this->pass, $this->realPass, $this->realName);
								exit('{"login": "'.$this->login.'", "fullName":"'.$this->fullname.'", "regDate": '.$this->regDate.', "userGroup": '.$this->userGroup.',  "balance": '.$coins.', "hardwareId":  '.$this->HWIDstatus.'}');
							} else {
								exit('{"login": "'.$this->login.'", "fullName":"'.$this->fullname.'", "message": "'.$message['HWIDerror'].'", "hardwareId": '.$this->HWIDstatus.'}');
							}

						} else {
							$antiBrute = new antiBrute(REMOTE_IP, false);
							exit('{"message": "'.$message['wrongLoginPass'].'"}');
						}
				} else {
					exit('{"message": "'.$message['userNotFound'].'"}');
				}
			} else {
				exit('{"message": "'.$message['dataNotIsset'].'"}');
			}
		}
}