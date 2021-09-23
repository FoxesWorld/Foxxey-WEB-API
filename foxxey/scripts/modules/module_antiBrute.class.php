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
 Verssion: 0.1.4.7 Final
-----------------------------------------------------
 Usage: Prevent users bruting passwords
=====================================================
*/
if (!defined('FOXXEY')) {
	die ('{"message": "Not in FOXXEY thread"}');
}

	class antiBrute {

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

		/**
		 * antiBrute constructor.
		 * @param $ip
		 * @param bool $debug
		 */
		function __construct ($ip, $db, $debug = false) {
			global $config;
			$this->ip = $ip;
			$this->db = $db;
			$this->debug = $debug;
			$this->maxAttempts = $config['maxLoginAttempts'];
			$this->parseIpRow();

			switch ($this->DBip) {
				case ($ip):
					$this->increaseAttempts();
				break;

				default:
					$this->insertIp();
			}

			if($this->DBattempts >= $this->maxAttempts) {
				$this->banIp();
			}

			if(functions::checkTime($this->DBtime) === false){
				if(class_exists('randTexts')) {
					$randTexts = new randTexts('antiBrute', $config['randTextsDebug']);
					exit ('{"message": "'.$randTexts->textOut().'"}');
				} else {
					exit ('{"message": "Module randTexts not found!", "desc": "Can`t tell user how to get rekt! BTW Pass is wrong cool down."}');
				}
			}
		}

		public function parseIpRow(){
			$query = "SELECT * FROM antiBrute WHERE ip = '".$this->ip."'";
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
				$query = "INSERT INTO `antiBrute`(`ip`) VALUES ('".$this->ip."')";
				$this->db::run($query);
			}
		}

		private function increaseAttempts(){
			$query = "UPDATE `antiBrute` SET `attempts`=attempts+1 WHERE ip = '".$this->ip."'";
			$this->db::run($query);
		}

		private function banIp(){
			global $config;
			if(class_exists('Logger')) {
				$Logger = new Logger('AuthLog');
				if($this->debug === true) {
					echo "Banning ".$this->ip." till ".$config['bantime']."<br>";
				}
				$Logger->WriteLine('Banning '.$this->ip.' for too many authorisation errors');
			}
			$query = "UPDATE `antiBrute` SET `time`=".$config['bantime']." WHERE ip = '".$this->ip."'";
			$this->db::run($query);
		}

		private function removeRow(){
			$this->db->run("DELETE FROM antiBrute WHERE time < '".CURRENT_TIME."';");
		}
	}