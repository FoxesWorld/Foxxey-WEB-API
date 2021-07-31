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
 Verssion: 0.1.0.0 Alpha
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
			
			default:
				die('{"message": "Unknown log operation"}');
		}
    }

    function WriteLine($text) {
        $fp = fopen($this->file, "a+");
        if($fp) {
            fwrite($fp,$this->logDate.$text . "\n");
        } else {
            $this->error = "Ошибка записи в лог-файл";
        }
        fclose($fp);
    }

    function Read() {
        if(file_exists($this->file)) {
            return file_get_contents($this->file);
        } else {
            $this->error = "Лог-файл не существует";
        }
    }

    function Clear() {
        $fp = fopen($this->file,"a+");
        if($fp)
        {
            ftruncate($fp,0);
        } else {
            $this->error = "Ошибка чтени€ лог-файла";
        }
        fclose($fp);
    }
}