<?php
if (!defined('FOXXEY')) {
	die ('{"message": "Not in FOXXEY thread"}');
}
	class localDatabase {
		
		private $dbFileName = 'FoxxeyData';
		private $dbFile = FILES_DIR."FoxxeyData.db";
		private $db;
		
		function __construct() {
			global $config;
			if(!file_exists($this->dbFile)) {
				try {
				$this->db = new PDO("sqlite:".FILES_DIR.$this->dbFileName.".db");
				} catch (PDOException $e){
					echo 'Exception: '.$e;
				}
			} else {
				echo 'DbFile was Found!';
			}
		}
	}