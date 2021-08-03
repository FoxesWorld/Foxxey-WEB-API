<?php
/*
=====================================================
 foxCheck.class.php
-----------------------------------------------------
 https://Foxesworld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: foxCheck.class.php
-----------------------------------------------------
 Version: 0.1.1.1 Final
-----------------------------------------------------
 Usage: Check if user is a fox
=====================================================
*/
if(!defined('Authorisation')) {
	die('{"message": "Not in authorisation thread"}');
}
	class foxCheck extends Authorise {
		
		protected $login;
		private $debug;
		private $foxCheckStatus = false;
		private $checkStatusDB;
		private $Logger;
		private $db;
		
		 /**
		 * foxCheck constructor.
		 * @param $login
		 * @param bool $debug
		 */
		function __construct($login, $debug = false, $db, $Logger){
			global $config;
			$this->debug = $debug;
			$this->login = $login;
			$this->db = $db;
			$this->Logger = $Logger;
		}
		
		function checkFox(){
			global $config;
			foreach($config['FoxArray'] as $key) {
				if($this->debug === true) {
					echo "Checking <b>".$this->login."</b> to str_pos ".$key."<br>";
				}
				if(strpos($this->login, $key)){
					if(!$this->foxCheckDB()) {
						if($this->debug === true) { 
							echo "Login ".$this->login." has passed check <br> <b>Mein Lieblingsfuchs</b><br>
							 but is not in DB tabble<br>";
							 $this->Logger->WriteLine("Login ".$this->login." has passed check | Mein Lieblingsfuchs");
						}
						$this->foxCheckStatus = true;
						$this->insertFox();
						break;
					} else {
						if($this->debug === true) {
							echo "Fox ".$this->login." was found in DB tabble";
							break;
						}
					}
				} else {
					if($this->debug === true) { 
						echo $this->login." is already added";
					}
					//$this->Logger->WriteLine($this->login." does not equals a Fox");
				}
			}

			return $this->foxCheckStatus;
		}
		
		private function foxCheckDB(){
			$query = "SELECT * FROM foxBonus WHERE login = '".$this->login."'";
			$data = $this->db->getRow($query);
			$this->checkStatusDB = $data['foxCheck'];
			
			return $this->checkStatusDB;
		}
		
		private function insertFox(){
			if($this->debug === true) {
				echo "Adding a new fox - ".$this->login;
			}
			$this->Logger->WriteLine("Adding a new fox - ".$this->login);
			$query = "INSERT INTO `foxBonus`(`login`) VALUES ('".$this->login."')";
			$this->db->run($query);
		}
	}