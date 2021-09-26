<?php
/*
=====================================================
 You can extend startUpSound abilityes in here!
-----------------------------------------------------
 https://FoxesWorld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: startUpSoundcfg.class.php
-----------------------------------------------------
 Version: 0.1.0.1 Experimental
-----------------------------------------------------
 Usage: Configuring startUpSound (Logged only)
=====================================================
*/
if(!defined('FOXXEYadm')){
	die('{"message": "Not In Admin Thread!"}');
}

	class startUpSoundCfg {
		
		public static function clearSUScache($path){
			if($path) {
				if(strpos($path, 'timetable')){
					if(file_exists($path)){
						unlink($path);
						die('{"message": "Succesfully cleared cache!", "type": "success"}');
					} else {
						die('{"message": "File "'.$path.' doesn`t exist!}');
					}
				} else {
					die('{"message": "Not a cache file!"}');
				}
			} else {
				die('{"message": "Path was not defined!"}');
			}
		}
		
		//More Functions coming out soon
		
	}