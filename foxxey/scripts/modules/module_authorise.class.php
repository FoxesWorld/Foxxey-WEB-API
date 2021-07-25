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
 Verssion: 0.1.5.4 Experimental
-----------------------------------------------------
 Usage: Authorising and using HWID
=====================================================
*/

	header('Content-Type: text/html; charset=utf-8');
	if(!defined('FOXXEY')) {
		die ("Not a real Fox! =( HWID");
	}
	
	/* 
	 * TODO
	 * - Fix bad code with multi calling DB
	 */

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
		private $udataDB;
		private $randTexts;
		private $noName;
		private $HWIDerrorMessage;

		/* USERDATA */
		private $realName;
		private $realPass;
		private $fullname;
		private $userGroup;
		private $regDate;
		
		function __construct($login, $pass, $HWID){
			global $config;
			$this->webSiteFunc  = new functions($config['db_user'], $config['db_pass'], $config['db_database'], $config['db_host']);
			//$this->udataDB    = new db($config['db_user'], $config['db_pass'], $config['db_name_userdata'], $config['db_host']);
			//$this->launcherDB = new functions($config['db_user'], $config['db_pass'], $config['dbname_launcher'], $config['db_host']);

			$this->login = $login;
			$this->pass = $pass;
			$this->HWID = $HWID;
			$this->correctLogin = false;
		}
	
		public function logIn(){
			global $config, $message;
			$units = 0;

			//FILTRATING INPUT DATA
				$this->login = str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($this->login)));
				$this->pass  = str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($this->pass)));
				$this->HWID  = str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($this->HWID)));
			//*********************
			
			//Getting AUTH USERDATA
			$this->realName  = json_decode($this->webSiteFunc->getUserData($this->login, 'name'))		-> name		  ?? null;
			$this->realPass  = json_decode($this->webSiteFunc->getUserData($this->login, 'password'))	-> password	  ?? null;
			
			if($this->login == '' && $this->pass == '') {
				exit('{"message": "'.$message['dataNotIsset'].'"}');
			} else {
				//Getting user login location
				if($config['geoIPcheck'] === true) {
					if(class_exists('geoPlugin')) {
						$geoplugin = new geoPlugin();
					} else {
						echo '{"message": "Module geoPlugin not found!", "desc": "Can`t get user login location!"},';
					}
				}

				//IF RealName is Null
				if($this->realName == null || $this->realPass == null) {
					exit('{"message": "'.$message['userNotFound'].'"}');
				} else {
						if(strlen($this->realPass) == 32 && ctype_xdigit($this->realPass)) {
							if($this->realPass == md5(md5($this->pass))) {
								$this->correctLogin = true;
							}
						} else {
							if(password_verify($this->pass, $this->realPass)) {
								$this->correctLogin = true;
							}
						}
						
						if(!$this->correctLogin) { //If Login is incorrect
							if($config['useAntiBrute'] === true) {
								$antiBrute = new antiBrute(REMOTE_IP, $config['antiBruteDebug']);
							}
							exit('{"message": "'.$message['wrongLoginPass'].'"}');
						} else {

								// Checking HWID
								if($config['checkHWID'] === true) {
									if(class_exists('HWID')) {
										$hardwareCheck = new HWID($this->login, $this->HWID, $config['HWIDdebug']);
										$this->HWIDstatus = $hardwareCheck->checkHWID() ? 'true' : 'false';
									} else {
										$this->HWIDstatus = 'true';
										echo '{"message": "Module HWID not found!", "desc": "Can`t check user`s HWID validity!"},';
									}
								}
								//==============

						if($this->HWIDstatus === 'true'){ //If HWID is correct
								$this->webSiteFunc  = new functions($config['db_user'], $config['db_pass'], $config['db_database'], $config['db_host']);
								//GETTING PERSONAL DATA
								$this->fullname  = json_decode($this->webSiteFunc->getUserData($this->login, 'fullname'))	-> fullname   ?? $this->noName;
								$this->userGroup = json_decode($this->webSiteFunc->getUserData($this->login, 'user_group'))	-> user_group ?? 4;
								$this->regDate 	 = json_decode($this->webSiteFunc->getUserData($this->login, 'reg_date'))	-> reg_date	  ?? null;
									
									if(!$this->webSiteFunc->getUserData($this->login, 'fullname')) {
										if(class_exists('randTexts')) {
											$this->randTexts = new randTexts('noName', $config['randTextsDebug']);
											$this->noName = $this->randTexts->textOut();
										} else {
											echo '{"message": "Module randTexts not found!", "desc": "Can`t say an unknown user who is he today!"},';
											$this->noName = 'Unnamed user';
										}
									}

							// Getting Balance
							if($config['getBalance'] === true) {
								if(class_exists('userbalance')) {
									$balance = new userbalance($this->login, false);
									$units = $balance->getUserBalance()['realmoney'];
								} else {
									$units = 100500;
									echo '{"message": "Module userbalance not found!", "desc": "Balance can`t be parsed!"},';
								}
							}
							//================

							// Fox checking
							if($config['foxChecking'] === true) {
								if(class_exists('foxCheck')) {
									$checkFox = new foxCheck($this->login, $config['foxCheckDebug']);
									if($checkFox->checkFox() === true){
										echo '{"message": "'.$message['congrats'].'"},';
										$this->webSiteFunc->insertunits($this->login);
									}
								} else {
									echo '{"message": "Module foxCheck not found!", "desc": "We can`t check if you are a Fox!"},';
								}
							}
							//=================

							$this->webSiteFunc  = new functions($config['db_user'], $config['db_pass'], $config['db_database'], $config['db_host']);
							$this->webSiteFunc->passwordReHash($this->pass, $this->realPass, $this->realName);
							exit('{"login": "'.$this->login.'", "fullName":"'.$this->fullname.'", "regDate": '.$this->regDate.', "userGroup": '.$this->userGroup.',  "balance": '.$units.', "hardwareId":  '.$this->HWIDstatus.'}');
						} else {
								if(class_exists('randTexts')) {
									$this->randTexts = new randTexts('wrongHWID');
									$this->HWIDerrorMessage = $this->randTexts->textOut();
								} else {
									$this->HWIDerrorMessage = 'Incorrect HWID';
								}
							exit('{"login": "'.$this->login.'", "fullName":"'.$this->fullname.'", "message": "'.$this->HWIDerrorMessage.'", "hardwareId": '.$this->HWIDstatus.'}');
						}
					}
				}
			}
		}
}