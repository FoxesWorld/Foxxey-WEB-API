<?php 
if(!defined('Authorisation')) {
	die('{"message": "Not in authorisation thread"}');
}
	class userbalance extends Authorise {

		protected $login;
		protected $pass;
		protected $HWID;
		private $debug;
		private $status;
		private $realUser;
		
		protected $balance;
		protected $realmoney;
		protected $bonuses;
		private $db;

		/**
		 * userbalance constructor.
		 * @param $login
		 * @param bool $debug
		 */
		function __construct($login, $debug = false){
			global $config;
			$this->login = $login;
			$this->debug = $debug;
			$this->db = new db($config['db_user'],$config['db_pass'],$config['db_name_userdata'], $config['db_host']);
		}

		function getUserBalance(){
			$query = "SELECT * FROM balance WHERE username = '".$this->login."'";
			$answer = $this->db->getRow($query);
			$this->balance   = $answer['balance'];
			$this->realmoney = $answer['realmoney'];
			$this->bonuses   = $answer['bonuses'];
			$this->realUser  = $answer['username'];

			if($this->realUser == '' || $this->realUser == null){
				$this->insertBalance();
			} else {
				if($this->debug === true){
					echo "Parsed balance for <b>".$this->realUser."</b><br>".
						  "<b>Units</b>: ".$this->balance."<br>".
						  "<b>Realmoney: </b>".$this->realmoney."<br>".
						  "<b>Bonuses: </b>".$this->bonuses;
				}

			return array("units" 	 => $this->balance,
						 "realmoney" => $this->realmoney,
						 "bonuses"	 => $this->bonuses);
			}
		}
		
		private function insertBalance(){
			if($this->login !== '' && $this->login !== null) {
				if($this->debug === true){
					echo "User ".$this->login." was not found in balance tabble, adding...";
				}
				$query = "INSERT INTO `balance`(`username`) VALUES ('".$this->login."')";
				$this->db->run($query);
			} else {
				if($this->debug === true){
					echo "User was not specifyed do add in DB tabble";
				}
			}
		}
		
		public function addUnitsPrize($login){
			global $config;
			$query = "UPDATE `balance` SET `realmoney`= realmoney+".$config['rewardAmmount']." WHERE username = '".$login."'";
			$this->db->run($query);
		}
	}