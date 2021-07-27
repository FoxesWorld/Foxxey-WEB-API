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
 Version: 0.1.0.1 Alpha
-----------------------------------------------------
 Usage: Check if user is a fox
=====================================================
*/
	class foxCheck extends Authorise {
		
		protected $login;
		private $debug;
		private $foxCheckStatus = false;
		private $checkStatusDB;
		private $db;
		
		function __construct($login, $debug = false){
			global $config;
			$this->debug = $debug;
			$this->login = $login;
			$this->db = new db($config['db_user'],$config['db_pass'],$config['db_name_userdata'], $config['db_host']);
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
						echo $this->login." does not equals a Fox";
					}
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
			$query = "INSERT INTO `foxBonus`(`login`) VALUES ('".$this->login."')";
			$this->db->run($query);
		}
	}