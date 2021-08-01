<?php
/*
=====================================================
 I would remember that after you!
-----------------------------------------------------
 https://Foxesworld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: module_logger.class.php
-----------------------------------------------------
 Verssion: 0.1.0.1 Alpha
-----------------------------------------------------
 Usage: Writes a logFile
=====================================================
*/
date_default_timezone_set('Europe/Moscow');
    
class Logger {
    var $file;
    var $error;
	var $logDate;
	
    function __construct($LogType) {
		$this->logDate = '['.CURRENT_DATE.'] '.date('H:m:s').' ';
		switch ($LogType){
			case 'AuthLog':
				$this->file = FILES_DIR.'/logs/AuthLog.log';
			break;
			
			case 'Error':
				$this->file = FILES_DIR.'/logs/Errors.log';
			break;
			
			default:
				die('{"message": "Unknown log operation"}');
		}
    }

    function WriteLine($text) {
        $fp = fopen($this->file, "a+");
        if($fp) {
            fwrite($fp,$this->logDate.$text . "\n");
        } else {
            $this->error = "Error writing logFile";
        }
        fclose($fp);
    }

    function Read() {
        if(file_exists($this->file)) {
            return file_get_contents($this->file);
        } else {
            $this->error = "LogFile already created";
        }
    }

    function Clear() {
        $fp = fopen($this->file,"a+");
        if($fp)
        {
            ftruncate($fp,0);
        } else {
            $this->error = "Error reading LogFile";
        }
        fclose($fp);
    }
}