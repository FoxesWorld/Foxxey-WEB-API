<?php
if(!defined('startUpSound')) {
	die('{"message": "Not in startUpSound thread"}');
}
	class seasonOptions extends startUpSound {

			protected static function dayTimeGetting() {
				$timeNow = date('G:i', CURRENT_TIME);
				$hourNow = explode(':', $timeNow)[0];

					switch($hourNow){
							case ($hourNow <= 6 || $hourNow >= 23):
								$dayTimeNow = '/night';
							break;

							case ($hourNow <= 12):
								$dayTimeNow = '/morning';
							break;
							
							case ($hourNow <= 18):
								$dayTimeNow = '/day';
							break;
							
							case ($hourNow >= 19):
								$dayTimeNow = '/evening';
							break;
					}
				return $dayTimeNow;
			}

			protected static function seasonNow(){
			$dateExploded = explode ('.',CURRENT_DATE);
			$monthToday = $dateExploded[1];
				switch($monthToday){
					case ($monthToday <=3 || $monthToday == 12):
						$seasonNow = '/winter';
					break;
					
					case ($monthToday <= 6 && $monthToday > 3):
						$seasonNow = '/spring';
					break;
					
					case ($monthToday <= 9 && $monthToday > 6):
						$seasonNow = '/summer';
					break;
					
					case ($monthToday <= 11 && $monthToday > 9):
						$seasonNow = '/autumn';
					break;				
				}
				return $seasonNow;
				
		}
	}