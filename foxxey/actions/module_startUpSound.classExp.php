<?php
Error_Reporting(E_ALL);
Ini_Set('display_errors', true);
/*
=====================================================
 startUpSound Class ReBorn
-----------------------------------------------------
 https://Foxesworld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021 FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: startUpSound.class.php
-----------------------------------------------------
 Version: 1.2.0.0 Experimental
-----------------------------------------------------
 Usage: Current Event Sound generation
=====================================================
*/

if (!defined('FOXXEY')) {
	die ('{"message": "Not in FOXXEY thread"}');
} else {
	define('startUpSound', true);
}

	class startUpSound {
		
		/* IO Utils */
		private $cacheFilePath 	 = FOXXEYDATA.'startUpSound.timetable';
		private $AbsolutePath;
		private $musMountPoint 	 = 'mus';
		private $sndMountPoint 	 = 'snd';
		private $musFilesNum 	 = 0;
		private $sndFilesNum 	 = 0;
		
		/* Kernel settings */
		private $serverVersion 	 = '1.2.0.0 Experimental';
		private $eventNow 		 = 'common';
		private $musPerEvent 	 = true;	
		private $useDayTime 	 = false;		//Use DayTime snd? (Morning, Day, Evening, Night)
		private $useSeasons 	 = false;		//Use Seasons? (Winter, Spring, Summer, Autumn)
		private $debug 			 = false;
		private $showDebugPerSnd = false; 
		
		/* easter */
		private $easter			 = 'false';
		private $isEasterSnd;
		private $isEasterMus;
		private $thisEaster;
		private $easterMusWarn;
		private $easterSndWarn;
		
		/* Durations */
		private $durationMus;
		private $durationSnd;
		
		/* Date */
		private $currentDate 	 = CURRENT_DATE;
		private $seasonNow 		 = '';
		private $dayTimeNow 	 = '';
		private $dayToday;
		private $monthToday;
		private $yearToday;
		
		/* Ranges */
		private $musRange 		 = 0;
		private $sndRange 		 = 0;
		
		/* Event Arrays */
		private $eventsArray = array(
			'01' => array(
				"1-12" =>  array(
					'eventName' => 'winterHolidays',
					'musRange'  => '1/2',
					'sndRange'=> '2/5'
				)
			),

			'02' => array(
			
			),
			
			'03' => array(
			
			),
			
			'04' => array(
			
			),
			
			'05' => array(
			
			),
			
			'06' => array(
			
			),
			
			'07' => array(
			
			),
			
			'08' => array(
				'5-13' => array(
					'eventName' => 'Killing teddy!',
					'musRange'  => '1/2',
					'sndRange'=> '2/5'),

				'20-23' => array(
					'eventName' => 'Praising DarkFoxes',
					'musRange'  => '1/2',
					'sndRange'=> '2/5'
				)
			),

			'09' => array(

				'1-8' => array(
					'eventName' => '8bit')
			),
			
			'10' => array(
			
			),
			
			'11' => array(
			
			),
			
			'12' => array(
			
			)
		);
		private $monthNowArray;
		private $todaysEventArray;
		
		/* MultiSound Alpha*/
		private $musToGen 		= 1;
		private $sndToGen 		= 1;
		
		/* Output Data */
		private $sndGen;
		private $musGen;
		private $sleepTime;
		private $additionalInfo = 'NoData';
		
		/* Debug style */
		//background: url('data:image/png;base64,') no-repeat;
		private $pageStyle 		= "<style>body{
											background-color: #91464661;
											background-size: cover;
											background-position: center;
										}

										.totalInfo {
											border: 1px solid black;
											padding: 5px;
											margin: 5px 0px;
										}
										
										.title {
											font-size: large;
											margin: 0;
										}
									</style>"; 
		private $baseDebugStyle = 'border: 1px dashed #a76565; padding: 30px 40px; border-radius: 10px; width: fit-content; margin: 15px;';
		private $audioGenStyle 	= 'border: 1px solid black; padding: 5px; border-radius: 10px; width: fit-content; margin: 15px 2px;';
		
		function __construct($debug = false){
			global $config;
			$this->AbsolutePath = $config['mountDir'];
			$this->debug = $debug;
			$this->fillDate(CURRENT_DATE);
			$this->IncludestartUpSoundModules();
			

			
			if(!file_exists($this->cacheFilePath)){
				$this->WriteFile();
			} else {
				if(is_array($this->readEventFile())){
					$this->eventsArray = $this->readEventFile();
				} else {
					$this->WriteFile();
					$this->eventsArray = $this->readEventFile();
				}
			}
			$this->genAudio('mus');
			$this->genAudio('snd');
			$this->selectCurrentEvent($this->dayToday, $this->monthToday);
			$this->maxDuration($debug);
			if($debug){
				echo '<h1><i>startUpSound '.$this->serverVersion.'</h1></i>';
				$this->debugScreen();
			}
		}
		
		public function generateAudio() {
			if($this->debug === false) {
				echo $this->outputJson();
			} else {
				echo 'Running in debug mode';
			}
		}
		
		private function outputJson() {
			$outputArray = array(
					"maxDuration" 		=> (Integer) $this->sleepTime,
					"selectedMusic" 	=> (Array)   $this->musGen,
					"selectedSound" 	=> (Array)   $this->sndGen,
					"eventInfo"			=> (String)  $this->additionalInfo,
					"eventName" 		=> (String)  $this->eventNow,
					"additionalInfo"	=> (String)	 $this->additionalInfo,
					"serverVersion"		=> (String)  $this->serverVersion);

			return json_encode($outputArray, JSON_UNESCAPED_SLASHES);
		}
		
		private function genAudio($genType){
			global $config;
			switch($genType){
				case 'mus':
				$minRange = 1;
				$unExistingFolder = '';
					if($config['enableMusic'] === true) {
						for($i = 0; $i < $this->musToGen; $i++) {
							$this->easter($config['easterMusRarity'], $this->debug, 'music');
							if($this->musPerEvent === true) {
								$currentMusFolder = $this->AbsolutePath.'/'.$this->eventNow.'/'.$this->musMountPoint.$this->easter;
							} else {
								$currentMusFolder = $this->AbsolutePath.'/'.$this->musMountPoint.$this->easter;
							}

							if(is_dir($currentMusFolder)) {
								$this->musFilesNum = count(functions::filesInDirArray($currentMusFolder, '.mp3'));
								if($this->isEasterMus === 'true'){
									if($this->musFilesNum < 1){
										$currentMusFolder = str_replace('/easter', "", $currentMusFolder);
										$this->easterMusWarn = '<b style="color: red;">Esater Mus not found, using common</b><br>';
									}
								}
								
								if(isset($this->musRange) && $this->musRange !== 0) {
									$RandMusFile = $this->genRange('mus', $this->musRange);
								} else {
									$RandMusFile = 'mus'.rand($minRange,$this->musFilesNum).'.mp3'; //Getting random musFile
								}
								
								//MusDirs****************************************								
									$selectedMusic = str_replace($this->AbsolutePath,"",$currentMusFolder).'/'.$RandMusFile;
									$musFileAbsolute = $currentMusFolder.'/'.$RandMusFile;
								//***********************************************
								
								if(file_exists($musFileAbsolute)) {
									$musMd5 = md5_file($musFileAbsolute);
									$getid3 = new getID3();
									$getid3->encoding = 'UTF-8';
									$getid3->Analyze($musFileAbsolute);
									$this->durationMus = $this->getFileLength($getid3);

									$this->musGen[] = json_encode(array(
										'path' => $selectedMusic,
										'hash' => $musMd5
									), JSON_UNESCAPED_SLASHES);
								} else {
									$this->musGen = 'musicOff';
								}
							} else {
								$unExistingFolder = '<br><b>Warning! Folder not found:</b><span style="color: red;">'.$currentMusFolder.'</span>';
								$this->musGen = 'musicOff';
							}
						}
					} else {
						$this->musGen = 'musicOff';
					}
				break;
				
				case 'snd':
				$minRange = 1;
				$unExistingFolder = '';
					if($config['enableVoice'] === true) {
						for($i = 0; $i < $this->sndToGen; $i++) {
							$this->easter($config['easterSndRarity'], $this->debug, 'sound');
							$currentSoundFolder = $this->AbsolutePath.'/'.$this->eventNow.'/'.$this->sndMountPoint.$this->seasonNow.$this->dayTimeNow.$this->easter;
							if(is_dir($currentSoundFolder)) {
								$this->sndFilesNum = count(functions::filesInDirArray($currentSoundFolder, '.mp3'));
									if($this->isEasterSnd === 'true'){
										if($this->sndFilesNum < 1){
											$currentSoundFolder = str_replace('/easter', "", $currentSoundFolder);
											$this->easterSndWarn = '<b style="color: red;">Esater Snd not found, using common</b><br>';
										}
									}
									
							if(isset($this->sndRange) && $this->sndRange !== 0) {
								$RandSoundFile = $this->genRange('voice', $this->sndRange);
							} else {
								$RandSoundFile = 'voice'.rand($minRange,$this->sndFilesNum).'.mp3';
							}

							//SoundDirs**************************************
								$selectedSound = str_replace($this->AbsolutePath,"",$currentSoundFolder).'/'.$RandSoundFile;
								$soundFileAbsolute = $this->AbsolutePath.$selectedSound;
							//***********************************************
							
							if(file_exists($soundFileAbsolute)) {
								$soundMd5 = md5_file($soundFileAbsolute);
								$getid3 = new getID3();
								$getid3->encoding = 'UTF-8';
								$getid3->Analyze($soundFileAbsolute);
								$this->durationSnd = $this->getFileLength($getid3);
								$this->additionalInfo = $this->getAdditionalInfo($getid3);
							} else {
								$this->sndGen = 'soundOff';
							}
							
							$this->sndGen[] = json_encode(array(
								'path' => $selectedSound,
								'hash' => $soundMd5
							), JSON_UNESCAPED_SLASHES);
						
							} else {
								$unExistingFolder = '<br><b>Warning! Folder not found:</b><span style="color: red;">'.$currentSoundFolder.'</span>';
								$this->sndGen = 'soundOff';
							}
						}
					} else {
						$this->sndGen = 'soundOff';
					}
				break;
			}
		}
		
		private function selectCurrentEvent($dayToday, $monthToday){

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

			foreach ($this->eventsArray as $key => $value) {
					if($monthToday == $key){
					$this->monthNowArray = $value;
						foreach ($this->monthNowArray as $key => $value){
							$this->todaysEventArray = checkPeriod($key, $value, $dayToday);
							if(is_array($this->todaysEventArray)) {
								$eventName = $this->todaysEventArray['eventName'] 	?? 'common';
								$sndRange = $this->todaysEventArray['sndRange'] 	?? 0;
								$musRange = $this->todaysEventArray['musRange'] 	?? 0;
							} else {
								$eventName = 'common';
							}
						}
						$eventArray['eventNow']   = $eventName ?? 'common';
						$eventArray['musRange']   = $musRange ?? 0;
						$eventArray['sndRange']   = $sndRange ?? 0;

					foreach ($eventArray as $key => $value) {
						switch($key){
							case 'eventNow':
								$this->eventNow = $eventName;
							break;
								
							case 'musRange':
							$musRange = $eventArray['musRange'];
							if($musRange !== 0) {
								if(strpos($musRange, '/')){
									$this->musRange = explode('/',$musRange);
								} else {
									$this->musRange = $musRange;
								}
							}
							break;
							
							case 'sndRange':
							$sndRange = $eventArray['sndRange'];
							if($sndRange !== 0) {
								if(strpos($sndRange, '/')){
									$this->sndRange = explode('/',$sndRange);
								} else {
									$this->sndRange = $sndRange;
								}
							}
							break;
						}
					}
				}
			}
		}
		
		private function easter($chance, $debug = false, $of) {
			global $config;
			$minRange = 1;
			$maxRange = 1000;
			$easterChance = mt_rand($minRange, $maxRange);
			switch($of){
				case 'sound':
					$confRarity = $config['easterSndRarity'];
				break;
				
				case 'music':
					$confRarity = $config['easterMusRarity'];
				break;
			}
				if ($easterChance <= $chance){
					$this->easter = "/easter";
					switch($of){
						case 'sound':
							$this->isEasterSnd = 'true';
							$isEaster = '<b>Is eater: </b> <span style="color: green;">YES</green>';
						break;
						
						case 'music':
							$this->isEasterMus = 'true';
							$isEaster = '<b>Is eater: </b> <span style="color: green;">YES</span>';
						break;
					}
				} else {
					$isEaster = '<b>Is eater: </b> <span style="color: red;">NO</span>';
					$this->easter = "";
				}
			if($debug === true) {
					$this->thisEaster[] = '<div style="'.$this->audioGenStyle.'">'.
							'<h1 style="font-size: large;margin: 0;">Generated '.$of.'</h1>
							<b>This rand: </b>'.		$easterChance.' <= '.$confRarity.'<br>'.$isEaster.'<br />'.
							'</div>';
			}
		}
		
		private function debugScreen(){
			if($this->debug){

				echo $this->pageStyle.'<div style="'.$this->baseDebugStyle.'">
				<h1 class="title">Base Info:</h1>
				<b>Max duration:		</b>'	.$this->sleepTime.'						<br />
				<b>Current event: 		</b>'	.$this->eventNow.'						<br />

				<div class = "totalInfo">
					<b>MusFilesNum: 	</b>'	.$this->musFilesNum.'					<br />
					<b>MusRange: 		</b>'	.$this->todaysEventArray["musRange"].'	<br />
					<b>MusToGenAmmount: </b>'	.$this->musToGen.'						<br />
					<b>Mus duration:	</b> '	.$this->durationMus.'					<br />'.'
				</div>

				<div class = "totalInfo">
					<b>SndFilesNum: 	</b>'	.$this->sndFilesNum.'					<br />
					<b>SndRange: 		</b>'	.$this->todaysEventArray["sndRange"].'	<br />
					<b>SndToGenAmmount: </b>'	.$this->sndToGen.'						<br />
					<b>Snd duration: 	</b>'	.$this->durationSnd.'					<br />
				</div>
				<hr>';
				if($this->showDebugPerSnd) {
					foreach ($this->thisEaster as $key){
						echo $key;
					}
				}
			}
		}
		
		private function maxDuration($debug = false) {
			$duration = 0;
			if($this->durationMus > $this->durationSnd) {
				$duration = $this->durationMus;
			} else {
				$duration = $this->durationSnd;
			}
				$this->sleepTime = $duration;
		}
		
		private function getFileLength ($getid3){
			$duration = $getid3->info['playtime_string'];
			$time = str_replace(0, "",explode(':', $duration)[1]);
			
			return $time;
		}

		private function getAdditionalInfo($getid3){
			if(is_array(@$getid3->info['tags']['id3v1']['comment'])) {
				@$soundAdditionalData = $getid3->info['tags']['id3v1']['comment'][0];
				return $soundAdditionalData;
			} else {
				return "undefined";
			}
		}
		
		private function fillDate($date){
				$dateExploded = explode ('.',$date);
				$this->dayToday = $dateExploded[0];
				$this->monthToday = $dateExploded[1];
				$this->yearToday = $dateExploded[2];
		}
		
		private function genRange($type, $range){
			switch($range) {
				case (is_array($range)):
					$minRange = $range[0];
					$maxRange = $range[1];
				break;

				case (!is_array($range)):
					$minRange = $range;
					$maxRange = $range;
				break;
				
				default:
					$minRange = 1;
				break;
			}
				$RandSoundFile = $type.rand($minRange,$maxRange).'.mp3';
				return $RandSoundFile;
		}
		
		private function IncludestartUpSoundModules(){
			global $config;
			$modulesDir = SCRIPTS_DIR.'modules/startUpSoundModules';
			if(!is_dir($modulesDir)){
				mkdir($modulesDir);
			}
			functions::includeModules($modulesDir, $config['modulesDebug']);
		}
		
		/* FilesWork */
		private function readEventFile(){
			$data = file_get_contents($this->cacheFilePath);
			$out = unserialize($data);

			return $out;
		}

		private function WriteFile(){
			$data = serialize($this->eventsArray);
			file_put_contents($this->cacheFilePath, $data);
		}
		
	}