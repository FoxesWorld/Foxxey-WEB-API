<?php
/*
=====================================================
 I hope it's your account
-----------------------------------------------------
 https://Foxesworld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: antiBrute.class.php
-----------------------------------------------------
 Verssion: 0.1.3.2 Alpha
-----------------------------------------------------
 Usage: Prevent users bruting passwords
=====================================================
*/

	class antiBrute extends Authorise {

		private $debug;
		private $ip;
		private $db;
		private $maxAttempts;

		/* DB DATA */
		private $DBip;
		private $DBid;
		private $DBtime;
		private $DBattempts;
		/* DB DATA */

		function __construct ($ip, $debug = false){
			global $config;
			$this->ip = $ip;
			$this->debug = $debug;
			$this->maxAttempts = $config['maxLoginAttempts'];
			$this->db = new db($config['db_user'], $config['db_pass'], $config['dbname_launcher'], $config['db_host']);
			$this->parseIpRow();

			switch ($this->DBip) {
				
				case (REMOTE_IP):
					$this->increaseAttempts();
				break;
				
				default:
					$this->insertIp();
			}
			
			switch($this->DBattempts){
				case ($this->maxAttempts):
					$this->banIp();
				break;
			}

			if($this->DBtime > CURRENT_TIME){
				if(class_exists('randTexts')) {
					$randTexts = new randTexts('antiBrute', $config['randTextsDebug']);
					exit ('{"message": "'.$randTexts->textOut().'"}');
				} else {
					exit ('{"message": "Module randTexts not found!", "desc": "Can`t tell user how to get rekt! BTW Pass is wrong cool down."}');
				}
			}
		}

		public function parseIpRow(){
			$query = "SELECT * FROM ipCheck WHERE ip = '".$this->ip."'";
			$data = $this->db->getRow($query);
			$this->DBip = $data['ip']			  ?? null;
			$this->DBid = $data['id'] 			  ?? null;
			$this->DBattempts = $data['attempts'] ?? null;
			$this->DBtime = $data['time'] 		  ?? 'notBanned';

			if($this->debug === true && $this->DBip !== null && $this->DBtime == 'notBanned') {
				echo "Parsing ".$this->ip." data <br>".
				"<b>DBip: </b>".$this->DBip."<br>".
				"<b>DBid: </b>".$this->DBid."<br>".
				"<b>maxAttempts:</b> ".$this->maxAttempts."<br>".
				"<b>Auth attempts: </b>".$this->DBattempts."<br>".
				"<b>DBtime: </b>".$this->DBtime;
			}

			$this->removeRow();
		}

		private function insertIp(){
			if(!$this->DBip) {
				
				if($this->debug === true) {
					echo "Adding ".$this->ip." to DB";
				}
				$query = "INSERT INTO `ipCheck`(`ip`) VALUES ('".$this->ip."')";
				$this->db::run($query);
			}
		}

		private function increaseAttempts(){
			$query = "UPDATE `ipCheck` SET `attempts`=attempts+1 WHERE ip = '".$this->ip."'";
			$this->db::run($query);
		}

		private function banIp(){
			global $config;
			if($this->debug === true) {
				echo "Banning ".$this->ip." till ".$config['bantime']."<br>";
			}
			$query = "UPDATE `ipCheck` SET `time`=".$config['bantime']." WHERE ip = '".$this->ip."'";
			$this->db::run($query);
		}

		private function removeRow(){
			$this->db->run("DELETE FROM ipCheck WHERE time < '".CURRENT_TIME."';");
		}
	}