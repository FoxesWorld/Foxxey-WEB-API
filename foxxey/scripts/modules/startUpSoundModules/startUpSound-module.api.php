<?php 

	class startUpSoundAPI {
		
			private $serverVersion;
			private $musFilesNum;
			private $easterMusNum;
			private $sndFilesNum;
			private $easterSndNum;
			private $eventNow;
			private $eventList;
			private $cacheFile;
			private $cacheStatus;
		
		function __construct($serverVersion, $musFilesNum, $sndFilesNum, $easterMusNum, $easterSndNum, $eventNow, $cacheFile, $eventList){
			$this->serverVersion = $serverVersion;
			$this->musFilesNum = $musFilesNum;
			$this->easterMusNum = $easterMusNum;
			$this->sndFilesNum = $sndFilesNum; 
			$this->easterSndNum = $easterSndNum;
			$this->eventNow = $eventNow;
			$this->eventList = $eventList;
			$this->cacheFile = $cacheFile;
			
			if(file_exists($cacheFile)) {
				$this->cacheStatus = 'cacheExists';
			} else {
				$this->cacheStatus = 'cacheDeleted';
			}
		}
		
		public function apiOut(){
			die('{"serverVersion": "'.$this->serverVersion.'", "musNum": '.$this->musFilesNum.', "sndNum": '.$this->sndFilesNum.', "easterMusNum": "'.$this->easterMusNum.'", "easterSndNum": "'.$this->easterSndNum.'", "eventNow": "'.$this->eventNow.'", "cacheFile": "'.$this->cacheStatus.'", "cachePath": "'.$this->cacheFile.'","eventList": ['.json_encode($this->eventList, JSON_UNESCAPED_SLASHES).']}');
		}
		
	}

?>