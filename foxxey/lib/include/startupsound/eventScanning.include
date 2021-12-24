<?php
if(!defined('startUpSound')) {
	die('{"message": "Not in startUpSound thread"}');
}
	class eventScanning extends startUpSound {
		
		protected $monthNowArray;
		protected $todaysEventArray;
		
		protected function __construct($dayToday, $monthToday){
			$eventName = 'common';
			function checkPeriod($key, $value, $dayToday){
				if(strpos($key,'-')){
					$datePeriod = explode('-',$key);
					$dayFrom = $datePeriod[0];
					$dayTill = $datePeriod[1];
					if($dayToday >= $dayFrom && $dayToday <= $dayTill){
						return $value;
					}
				} else {
					if($dayToday == $key){
						return $value;
					}
				}		
			}

			foreach (startUpSound::$eventsArray as $key => $value) {
				if($monthToday == $key){
					$this->monthNowArray = $value;
					foreach ($this->monthNowArray as $key => $value){
						$this->todaysEventArray = checkPeriod($key, $value, $dayToday);

						if(is_array($this->todaysEventArray)) {
							startUpSound::$eventNow = $this->todaysEventArray['eventName'] ?? 'common';
						} else {
							if($key){
								switch($key){
									case 'eventName':
										die($value);
										startUpSound::$eventNow 	= $value;
									break;
									
									case 'NotAllow':
										die(var_dump($value));
										if(is_array($value)){
											startUpSound::$notAllow = $value;
										}
									break;

									default:
										$eventName = 'common';
									break;
								}
							}					
						}
					}
				}
			}
		}	
	}