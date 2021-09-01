<?php 
/*
=====================================================
 longTermBan - you shal not pass!
-----------------------------------------------------
 https://Foxesworld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: module_longTermBan.class.php
-----------------------------------------------------
 Version: 0.1.1.3 Alpha
-----------------------------------------------------
 Usage: Blocking the whole functionality
=====================================================
*/

	class longTermBan {
		
		private $ip;
		private $banTime;
		private $toDate;
		private $db;
		
		function __construct ($ip, $db, $toDate = null) {
			global $config;
			
			$this->db = $db;
			$this->ip = $ip;
			if($toDate !== null) {
				$this->toDate = $toDate;
				$this->banTime = functions::shortDateToUnix($toDate);
				$this->banIP();
			}
		}
		
		public function banIP() {
			$Logger = new Logger('AuthLog');
				if($this->checkBan() === false) {
				$query = "INSERT INTO `fullBlock`(`ip`, `temptime`) VALUES ('".$this->ip."',".$this->banTime.")";
				$this->db::run($query);
				$Logger->WriteLine('Banning '.$this->ip.' on '.$this->toDate);
				die('{"message": "Banning '.$this->ip.' for '.$this->toDate.'..."}');
			} else {
				$Logger->WriteLine('The '.$this->ip.' ip has tryed to interract with Foxxey but is banned =( ');
				//die('{"message": "Ip '.$this->ip.' is already baned! Rest In Peace :3"}');
			}
		}
		

		
		public function checkBan(){
			$this->clearOldBans();
			$query = "SELECT * FROM `fullBlock` WHERE ip = '".$this->ip."'";
			$data = $this->db->getRow($query);
			if($data) {
				return true;
			} else {
				return false;
			}
		}
		
		private function clearOldBans(){
			$query = "DELETE FROM `fullBlock` WHERE temptime < ".CURRENT_TIME."";
			$this->db::run($query);
		}
	}
