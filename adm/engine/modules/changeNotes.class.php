<?php
/*
=====================================================
 Change your notices in here!
-----------------------------------------------------
 https://FoxesWorld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: changeNotes.class.php
-----------------------------------------------------
 Version: 0.1.0.1 Experimental
-----------------------------------------------------
 Usage: Changing and reading adminNotes (Logged only)
=====================================================
*/
if(!defined('FOXXEYadm')){
	die('{"message": "Not In Admin Thread!"}');
}

	class changeAdminNotes {
		
		private $filePath;
		
		function __construct($notes = null){
			$this->filePath = FILES_DIR.'logs/adminNotes.log';
			if($notes !== null) {
				$this->WriteLine($notes);
			} else {
				die($this->Read());
			}
		}
		
		function WriteLine($text) {
			$fp = fopen($this->filePath, "w+");
			if($fp) {
				fwrite($fp, $text);
				die('{"message": "File was recorded!", "type": "success"}');
			} else {
				die('{"message": "Can`t record file!", "type": "error"}');
			}
			fclose($fp);
		}
		
		function Read() {
			if(file_exists($this->filePath)) {
				return file_get_contents($this->filePath);
			} else {
				return "LogFile already created";
			}
		}
		
	}