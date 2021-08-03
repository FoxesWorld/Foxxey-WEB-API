<?php

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

			$this->dbQuery = file_get_contents(FILES_DIR."fox_launcher.sql");
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