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
 Verssion: 0.1.2.0 Alpha
-----------------------------------------------------
 Usage: Prevent users bruting passwords
=====================================================
*/

	class antiBrute {

		private $debug;
		private $ip;
		private $db;
		private $maxAttempts = 1;

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
				exit ('{"message": "'.$this->bannedMessage().'"}');
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

		private function bannedMessage(){
			$array = array('Пожалуйста, понерфите...',
			   'Воу, воу, остынь...',
			   'Бип бип, бип бип?',
			   'А ты шустрый, погоди, не так быстро. =)',
			   'Самая быстрая клавиатура на диком западе! Похвально.',
			   'Если ты не помнишь пароля, попробуй сбросить его!',
			   'Хммм, наверное пароль - Qwerty123!',
			   'Как ты умудрился забыть пароль?',
			   'У вас непритязательный вкус.',
			   'Дерпи это - тот, кто не может вспомнить свой пароль. >:3',
			   'Стромюокс, что-то вас много развелось...');
			$randWord = rand(0, count($array)-1);

			return $array[$randWord];
		}
	}