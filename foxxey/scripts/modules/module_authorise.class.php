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
 Verssion: 0.1.8.7 Experimental
-----------------------------------------------------
 Usage: Authorising and using HWID
=====================================================
*/

	header('Content-Type: text/html; charset=utf-8');
	if(!defined('FOXXEY')) {
		die ('{"message": "Not in FOXXEY thread"}');
	} else {
		define('Authorisation', true);
	}
	
	/* 
	 * TODO
	 * - Fix bad code with multi calling DB!!!
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
		private $realMail;
		private $fullname;
		private $userGroup;
		private $regDate;
		
		 /**
		 * Authorise constructor.
		 * @param $login
		 * @param $pass
		 * @param $HWID
		 */
		function __construct($login, $pass, $HWID){
			global $config;
			Authorise::IncludeAuthModules();
			$this->webSiteFunc  = new functions($config['db_user'], $config['db_pass'], $config['db_database'], $config['db_host']);

			$this->login = $login;
			$this->pass = $pass;
			$this->HWID = $HWID;
			$this->correctLogin = false;
		}
	
		public function logIn() {
			global $config, $message;
			$units = 0;
			$Logger = new Logger('AuthLog');

			//FILTRATING INPUT DATA
				$this->login = str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($this->login)));
				$this->pass  = str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($this->pass)));
			//*********************
			
			//Getting AUTH USERDATA
			$this->realName  = json_decode($this->webSiteFunc->getUserData($this->login, 'name'))		-> name		  ?? null;
			$this->realPass  = json_decode($this->webSiteFunc->getUserData($this->login, 'password'))	-> password	  ?? null;
			$this->realMail  = json_decode($this->webSiteFunc->getUserData($this->login, 'email'))		-> email	  ?? null;
			$this->fullname  = json_decode($this->webSiteFunc->getUserData($this->login, 'fullname'))	-> fullname   ?? functions::getUserName();
			
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
							$Logger->WriteLine('Incorrect login for '.REMOTE_IP.' as '.$this->login.' using `'.$this->pass.'`');
							exit('{"message": "'.$message['wrongLoginPass'].'"}');
						} else {
								// Checking HWID
								if($config['checkHWID'] === true) {
									if(class_exists('HWID')) {
										$hardwareCheck = new HWID($this->login, $this->HWID, $config['HWIDdebug']);
										$HWIDuser = $hardwareCheck->getUserNameByHWID() ?? 'Unknown bruter - `'.$this->HWID.'`';

										$this->HWIDstatus = $hardwareCheck->checkHWID() ? 'true' : 'false';
									} else {
										$this->HWIDstatus = 'true';
										echo '{"message": "Module HWID not found!", "desc": "Can`t check user`s HWID validity!"},';
									}
								}
								//==============

						if($this->HWIDstatus === 'true'){ //If HWID is correct
								$Logger->WriteLine('Successful authorisation for '.$HWIDuser.' with the correct HWID');
								/* ISSUE!!! VAR ASSIGNMENT AGAIN! */
								$this->webSiteFunc = new functions($config['db_user'], $config['db_pass'], $config['db_database'], $config['db_host']);
								$this->webSiteFunc->passwordReHash($this->pass, $this->realPass, $this->realName);

								//GETTING PERSONAL DATA
								$this->fullname  = json_decode($this->webSiteFunc->getUserData($this->login, 'fullname'))	-> fullname   ?? functions::getUserName();
								$this->userGroup = json_decode($this->webSiteFunc->getUserData($this->login, 'user_group'))	-> user_group ?? 4;
								$this->regDate 	 = json_decode($this->webSiteFunc->getUserData($this->login, 'reg_date'))	-> reg_date	  ?? null;

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
										$balance->addUnitsPrize($this->login);
										echo '{"message": "'.$message['congrats'].'"},';
									}
								} else {
									echo '{"message": "Module foxCheck not found!", "desc": "We can`t check if you are a Fox!"},';
								}
							}
							//=================

							die('{"login": "'.$this->login.'", "fullName":"'.$this->fullname.'", "regDate": '.$this->regDate.', "userGroup": '.$this->userGroup.',  "balance": '.$units.', "hardwareId":  '.$this->HWIDstatus.'}');
						} else {
							$Logger->WriteLine('Incorrect HWID for '.$this->login.' IP is - '.REMOTE_IP.' Bruted by '.$HWIDuser);
							$hardwareCheck->renewHWID($this->realMail, REMOTE_IP, $this->login, $this->HWID);
								if(class_exists('randTexts')) {
									$this->randTexts = new randTexts('wrongHWID');
									$this->HWIDerrorMessage = $this->randTexts->textOut();
								} else {
									$this->HWIDerrorMessage = 'Incorrect HWID';
								}
							die('{"login": "'.$this->login.'", "fullName":"'.$this->fullname.'", "message": "'.$this->HWIDerrorMessage.'", "hardwareId": '.$this->HWIDstatus.'}');
						}
					}
				}
			}
		}
		
		private static function IncludeAuthModules(){
			global $config;
			$modulesDir = SCRIPTS_DIR.'modules/authoriseModules';
			if(!is_dir($modulesDir)){
				mkdir($modulesDir);
			}
			functions::includeModules($modulesDir, $config['modulesDebug']);
		}
}