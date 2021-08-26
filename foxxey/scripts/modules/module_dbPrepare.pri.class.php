<?php
/*
=====================================================
 Let's prepare our base!
-----------------------------------------------------
 https://Foxesworld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: module_dbPrepare.pri.class.php
-----------------------------------------------------
 Verssion: 0.1.0.2 Alpha
-----------------------------------------------------
 Usage: DataBase preparation
=====================================================
*/
if (!defined('FOXXEY')) {
	die ('{"message": "Not in FOXXEY thread"}');
}
	class dbPrepare {
		
		private $dbHost;
		private $dbPort;
		private $dbUser;
		private $dbPass;
		private $dbName;
		private $db;
		private $dbQuery;

		function __construct(){
			global $config;
			$this->dbPort = $config['db_port'];
			$this->dbUser = $config['db_user'];
			$this->dbPass = $config['db_pass'];
			$this->dbName = $config['dbname_launcher'];
			$this->dbHost = $config['db_host'];

			$this->dbQuery = file_get_contents(SITE_ROOT."/foxxeyData/fox_launcher.sql");
			$this->db = new db($this->dbUser, $this->dbPass, $this->dbName, $this->dbHost);
		}
		
		public function dbPrepare(){
			try {
				$this->db::run($this->dbQuery);
			} catch(PDOException $pe) {
				die('{"message": "Spoiled our SQL"}');
			}		
		}
		
	}