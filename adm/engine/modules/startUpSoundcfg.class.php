<?php 


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
		
	}