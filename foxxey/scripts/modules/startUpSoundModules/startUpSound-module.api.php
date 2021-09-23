<?php 

	class startUpSoundAPI {
		
			private $musFilesNum;
			private $sndFilesNum;
			private $eventNow;
			private $eventList;
		
		function __construct($musFilesNum, $sndFilesNum, $eventNow, $eventList){
			$this->musFilesNum = $musFilesNum;
			$this->sndFilesNum = $sndFilesNum; 
			$this->eventNow = $eventNow;
			$this->eventList = $eventList;
		}
		
		public function apiOut(){
			die('{"musNum": '.$this->musFilesNum.', "sndNum": '.$this->sndFilesNum.', "eventNow": "'.$this->eventNow.'", "eventList": ['.json_encode($this->eventList, JSON_UNESCAPED_SLASHES).']}');
		}
		
	}

?>