<?php
/*
=====================================================
 startUpSound Class
-----------------------------------------------------
 https://Foxesworld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021 FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: startUpSound.class.php
-----------------------------------------------------
 Version: 0.2.26.6 Evolved
-----------------------------------------------------
 Usage: Current Event Sound generation
=====================================================
*/

if (!defined('FOXXEY')) {
	die ('{"message": "Not in FOXXEY thread"}');
} else {
	define('startUpSound', true);
}

/*		 USAGE
		
		$startSound = new startUpSound({Debug});
		$sounds = $startSound->generateAudio();
		Returns JSON
*/

/* TODO 
 * Outer File Event Switching
 */

	class startUpSound {
	
		/* Base utils */
		private static $AbsolutesoundPath;
		private static $currentDate = CURRENT_DATE;
		private static $musMountPoint = 'mus';
		private static $eventNow = 'common';
		private static $seasonNow;
		private static $dayTimeNow;
		private static $useDayTime = false;		//Use DayTime? (Morning, Day, Evening, Night)
		private static $useSeasons = false;		//Use Seasons? (Winter, Spring, Summer, Aitimn)
		private static $musFilesNum = 0;
		private static $soundFilesNum = 0;
		private static $easter = "";
		private static $debug = false;

		/* Mus */
		private static $musPerEvent = true;				//Use different music for an each event
		private static $selectedMusic; 					//Selected mus File
		private static $musFileAbsolute;				//Absolute musFilePath
		private static $durationMus = 0;				//Duration of a musFile
		private static $musMd5;							//musFile md5
		private static $musAdditionalData;				//Comment 
		private static $musRange;						//Range of muic files
		private static $isEasterMus = 'false';			//Is the mus is easter
		private static $easterMusWarn;					//Warn message if easter not found
		
		/* Sound */
		private static $selectedSound; 					//Selected sound File
		private static $soundFileAbsolute;				//Absolute soundFilePath
		private static $durationSound = 0;				//Duration of a soundFile
		private static $soundMd5;						//soundFile md5
		private static $soundAdditionalData = 'NoData';	//Comment
		private static $soundRange;						//Range of sound files
		private static $isEasterSnd = 'false';			//Is the sound is easter
		private static $easterSndWarn;					//Warn message if easter not found
		
		/* Both */
		//private static $currentFolder;				//Current folder of AudioFiles (Deprecated)
		private static $maxDuration = 0;				//Maximum duration
		private static $soundRangeDebug;				//Debug info of the range
		
		//Initialisation
		function __construct($debug = false) {
			global $config;
			startUpSound::IncludestartUpSoundModules();
			startUpSound::$AbsolutesoundPath = $config['mountDir'];
			startUpSound::$debug = $debug;
			$this->eventNow();
			$this->generateMusic(static::$debug);
			$this->generateSound(static::$debug);
			$this->maxDuration(static::$debug);
		}
		
		//Function for getting the result of startUpSound work
		public function generateAudio() {
			if(static::$debug === false) {
				echo $this->outputJson();
			}
		}
		
		/*
		 * @param boolean $debug
		 * @return String eventNow, String musRange, String soundRange
		 */
		private function eventNow() {
			$eventName = 'common';
			$musRange = 0;
			$soundRange = 0;
			$eventArray = array();
			$dateExploded = explode ('.',startUpSound::$currentDate);
			$dayToday = $dateExploded[0];
			$monthToday = $dateExploded[1];
			$yearToday = $dateExploded[2];
			$this->dayTimeGetting();
			if(static::$useSeasons) {
				$this->seasonNow($monthToday);
			}
			
			if(static::$debug){
				echo  '<div style="border: 1px solid black; padding: 5px; border-radius: 10px; width: fit-content; margin: 15px;">'.
					  '<h1 style="font-size: large;margin: 0;">Current date</h1><b>DayTime:</b>'.static::$dayTimeNow.'<br><b>seasonNow:</b>'.static::$seasonNow.'</div>';
			}

				switch($monthToday){
					case 1:
						switch($dayToday){
							case($dayToday < 12):
								$eventName = "winterHolidays";
							break;
						}
					break;
					
					case 2:
					break;
					
					case 3:
					break;
					
					case 4:

					break;
					
					case 5:
						switch($dayToday){ //WW2 Victory
							case 9:
								$eventName = "9may";
							break;
						}
					break;
					
					case 6:
						switch($dayToday){ //Markus Persson birthday
							case 1:
							break;
							
							case (21):
								$eventName = "twistOfTheSun";
							break;
						}
					break;
					
					case 7:
						switch($dayToday){
							case ($dayToday >= 5 && $dayToday < 6):
								$eventName = "twistOfTheSun";
							break;
						}
					break;
					
					case 8:
					break;
					
					case 9:
					break;
					
					case 10:
					break;
					
					case 11:
					break;
					
					case 12:
						switch($dayToday){
							case($dayToday < 31 && $dayToday != 22 && $dayToday != 31):
								$eventName = "winterHolidays";
							break;
							
							case 22:
								$eventName = "twistOfTheSun";
							break;
							
							case 31:
								$eventName = "newYear";
								$musRange ="1/8";
								
							break;
							
						}
				}
				$eventArray['eventNow']   = $eventName;
				$eventArray['musRange']   = $musRange;
				$eventArray['soundRange'] = $soundRange;

			foreach ($eventArray as $key => $value) {
				switch($key){
					case 'eventNow':
						startUpSound::$eventNow = $eventName;
					break;
						
					case 'musRange':
						if(strpos($musRange, '/')){
							startUpSound::$musRange = explode('/',$musRange);
						} else {
							startUpSound::$musRange = $musRange;
						}
					break;
					
					case 'soundRange':
						if(strpos($soundRange, '/')){
							startUpSound::$soundRange = explode('/',$soundRange);
						} else {
							startUpSound::$soundRange = $soundRange;
						}
					break;
				}
			}
		}
		
		/*
		 * @param boolean $debug
		 * @return String {Random mus with parameters}
		 */
		private function generateMusic($debug = false) {
			global $config;
			$minRange = 1;
			$maxRange = 1;
			$easterCheck;
			$unExistingFolder = '';

			if($config['enableMusic'] === true) {
			$this->easter($config['easterMusRarity'], static::$debug, 'music');
					if(static::$musPerEvent === true) {
						$currentMusFolder = static::$AbsolutesoundPath.'/'.static::$eventNow.'/'.static::$musMountPoint.static::$easter;
					} else {
						$currentMusFolder = static::$AbsolutesoundPath.'/'.static::$musMountPoint.static::$easter;
					}

					if(is_dir($currentMusFolder)) {
						if(static::$isEasterMus === 'true'){
							$easterCheck = count(functions::filesInDirArray($currentMusFolder, '.mp3'));
							if($easterCheck < 1){
								$currentMusFolder = str_replace('/easter', "", $currentMusFolder);
								startUpSound::$easterMusWarn = '<b style="color: red;">Esater Mus not found, using common</b><br>';
							}
						}

						startUpSound::$musFilesNum = count(functions::filesInDirArray($currentMusFolder, '.mp3')); //Count of music
						$maxRange = startUpSound::$musFilesNum;										
					
					if(isset(static::$musRange) && static::$musRange !== 0) {
						$RandMusFile = $this->genRange('mus', static::$musRange);
					} else {
						$RandMusFile = 'mus'.rand($minRange,$maxRange).'.mp3'; //Getting random musFile
					}
					//MusDirs****************************************								
					startUpSound::$selectedMusic = str_replace(static::$AbsolutesoundPath,"",$currentMusFolder).'/'.$RandMusFile; 	//Local musPath
					startUpSound::$musFileAbsolute = $currentMusFolder.'/'.$RandMusFile; //Absolute musFilePath
					//***********************************************
					
					if(file_exists(static::$musFileAbsolute)) {
						startUpSound::$musMd5 = md5_file(static::$musFileAbsolute);
						$getid3 = new getID3();
						$getid3->encoding = 'UTF-8';
						$getid3->Analyze(static::$musFileAbsolute);
						startUpSound::$durationMus = $this->getFileLength($getid3);
					} else {
						startUpSound::$selectedMusic = "musicOff";
					}
				} else {
					startUpSound::$selectedMusic = "musicOff";
					$unExistingFolder = '<br><b>Warning! Folder not found:</b><span style="color: red;">'.$currentMusFolder.'</span>';
				}
			} else {
				startUpSound::$selectedMusic = "musicOff";
			}
				if($debug === true) {
						$output =
						'<div style="border: 1px solid black; padding: 5px; border-radius: 10px; width: fit-content; margin: 15px;">'.
						'<h1 style="font-size: large;margin: 0;">Mus Gen</h1>'.
							"<b>selectedFile:</b>".			static::$selectedMusic.'<br>'.
							"<b>isEaster:</b>".				static::$isEasterMus.'<br>'.
							static::$easterMusWarn.
							"<b>musFileAbsolutePath:</b>".	static::$musFileAbsolute.'<br>'.
							"<b>musFileDuration:</b>".		static::$durationMus.'<br>'.
							"<b>filesInDir:</b>".			static::$musFilesNum.'<br>'.
							"<b>selectedMusFileHash:</b>".	static::$musMd5.'<br>'.
							"<b>eventName:</b>".			static::$eventNow.static::$soundRangeDebug.$unExistingFolder.'</div>';
						
						echo $output;
				}
		}
		
		/*
		 * @param boolean $debug
		 * @return String {Random sound with parameters}
		 */
		private function generateSound($debug = false) {
			global $config;
			$minRange = 1;
			$easterCheck;
			$unExistingFolder = '';

			if($config['enableVoice'] === true) {
				$this->easter($config['easterSndRarity'], static::$debug, 'sound');
				$currentSoundFolder = static::$AbsolutesoundPath.'/'.static::$eventNow.static::$seasonNow.static::$dayTimeNow.'/snd'.static::$easter;	//Folder of Sounds
				if(is_dir($currentSoundFolder)) {
					if(static::$isEasterSnd === 'true'){
						$easterCheck = count(functions::filesInDirArray($currentSoundFolder, '.mp3'));
						if($easterCheck < 1){
							$currentSoundFolder = str_replace('/easter', "", $currentSoundFolder);
							startUpSound::$easterSndWarn = '<b style="color: red;">Esater Snd not found, using common</b><br>';
						}
					}
					//startUpSound::$currentFolder = str_replace(static::$AbsolutesoundPath, '', $currentSoundFolder);
					startUpSound::$soundFilesNum = count(functions::filesInDirArray($currentSoundFolder, '.mp3'));	//Count of Sounds to select from

					if(isset(static::$soundRange) && static::$soundRange !== 0) {
						$RandSoundFile = $this->genRange('voice', static::$soundRange);
					} else {
						$RandSoundFile = 'voice'.rand($minRange,static::$soundFilesNum).'.mp3'; //Getting random sound file
					}

					//SoundDirs**************************************
					startUpSound::$selectedSound = str_replace(static::$AbsolutesoundPath,"",$currentSoundFolder).'/'.$RandSoundFile;
					startUpSound::$soundFileAbsolute = static::$AbsolutesoundPath.static::$selectedSound;
					//***********************************************

					if(file_exists(static::$soundFileAbsolute)) {
						startUpSound::$soundMd5 = md5_file(static::$soundFileAbsolute);
						$getid3 = new getID3();
						$getid3->encoding = 'UTF-8';
						$getid3->Analyze(static::$soundFileAbsolute);
						startUpSound::$durationSound = $this->getFileLength($getid3);
						startUpSound::$soundAdditionalData = $this->getAdditionalInfo($getid3);
					} else {
						startUpSound::$selectedSound = 'soundOff';
					}

				} else {
					$unExistingFolder = '<br><b>Warning! Folder not found:</b><span style="color: red;">'.$currentSoundFolder.'</span>';
					startUpSound::$selectedSound = 'soundOff';
				}
			}
				if($debug == true) {
					$output =
					'<div style="border: 1px solid black; padding: 5px; border-radius: 10px; width: fit-content; margin: 15px;">'.
						'<h1 style="font-size: large;margin: 0;">Sound Gen</h1>'.
						"<b>selectedFile:</b>".			static::$selectedSound.'<br>'.
						"<b>isEaster:</b>".				static::$isEasterSnd.'<br>'.
														static::$easterSndWarn.
						"<b>soundFileAbsolutePath:</b>".static::$soundFileAbsolute.'<br>'.
						"<b>soundFileDuration:</b>".	static::$durationSound.'<br>'.
						"<b>soundsInDir:</b>".			static::$soundFilesNum.'<br>'.
						"<b>selectedSoundFileHash:</b>".static::$soundMd5.'<br>'.
						"<b>Additional Info:</b>".		static::$soundAdditionalData.'<br>'.
						"<b>eventName:</b>".			static::$eventNow.static::$soundRangeDebug.$unExistingFolder.'
					</div>';
						echo $output;
					}
		}

		/*
		 * @param boolean $debug, Integer chance, of - sound|music
		 * @return String easter
		 */
		private function easter($chance, $debug = false, $of) {
			global $config;
			$minRange = 1;
			$maxRange = 1000;
			$easterChance = mt_rand($minRange, $maxRange);
				if ($easterChance <= $chance){
					startUpSound::$easter = "/easter";
					switch($of){
						case 'sound':
							startUpSound::$isEasterSnd = 'true';
						break;
						
						case 'music':
							startUpSound::$isEasterMus = 'true';
						break;
					}
				} else {
					startUpSound::$easter = "";
				}
			if($debug === true) {
					echo 	'<div style="border: 1px solid black; padding: 5px; border-radius: 10px; width: fit-content; margin: 15px;">'.
							'<h1 style="font-size: large;margin: 0;">Easter '.$of.'</h1>
							<b>This rand: </b>'.		$easterChance.' <= '.$config['easterMusRarity'].'<br>'.
							'</div>';
			}
		}

		/*
		 * @param boolean $debug
		 * @return Integer maxDuration
		 */
		private function maxDuration($debug = false) {
			$duration = 0;
			if(static::$durationMus > static::$durationSound) {
				$duration = static::$durationMus;
			} else {
				$duration= static::$durationSound;
			}
				startUpSound::$maxDuration = $duration;
			
			if($debug === true) {
				echo '
				<div style="border: 1px solid black; padding: 5px; border-radius: 10px; width: fit-content; margin: 15px;">
				<h1 style="font-size: large; margin: 0;">Music duration</h1>
							<b>Sound duration:</b>'.	static::$durationSound.'
							<br><b>Mus duration:</b> '. static::$durationMus.'
							<br> <b>Max duration:</b>'.	static::$maxDuration.'
				</div>';
			}
		}

		/**
		* @param String type {voice||mus}, Integer range
		* @return random {voice||mus}
		*/
		private function genRange($type, $range){
			switch($range) {
				case (is_array($range)):
					$minRange = $range[0];
					$maxRange = $range[1];
					startUpSound::$soundRangeDebug = '<div style="border: 1px solid black; padding: 5px; border-radius: 10px; width: fit-content; margin: 15 0px;">'.
					'<h1 style="font-size: large;margin: 0;">'.$type.'Range</h1>'.
					 "<b>minRange:</b>".$minRange.'<br>'.
					 "<b>maxRange:</b>".$maxRange.'</div>';
				break;

				case (!is_array($range)):
					$minRange = $range;
					$maxRange = $range;
					startUpSound::$soundRangeDebug = '<div style="border: 1px solid black; padding: 5px; border-radius: 10px; width: fit-content; margin: 15 0px;">'.
					'<h1 style="font-size: large;margin: 0;">'.$type.'Range</h1>'.
					 "<b>".$type."ToPlay:</b>".$minRange.'</div>';
				break;
				
				default:
					$minRange = 1;
				break;
			}
				$RandSoundFile = $type.rand($minRange,$maxRange).'.mp3';
				return $RandSoundFile;
		}

		/*
		 * @param NO
		 * @return jsonAnswer
		 */
		private function outputJson() {
			$outputArray = array(
					"maxDuration" 		=> (Integer)static::$maxDuration,
					"selectedMusic" 	=> (String) static::$selectedMusic,
					"selectedSound" 	=> (String) static::$selectedSound,
					"soundMd5" 			=> (String) static::$soundMd5,
					"MusicMd5" 			=> (String) static::$musMd5,
					"message"			=> (String) static::$soundAdditionalData,
					"eventName" 		=> (String) static::$eventNow);

			return json_encode($outputArray, JSON_UNESCAPED_SLASHES);
		}
		
		private function getFileLength ($getid3){
			$duration = $getid3->info['playtime_string'];
			$time = str_replace(0, "",explode(':', $duration)[1]);
			
			return $time;
		}

		private function getAdditionalInfo($getid3){
			if(is_array($getid3->info['tags']['id3v1']['comment'])) {
				$soundAdditionalData = $getid3->info['tags']['id3v1']['comment'][0];
				return $soundAdditionalData;
			} else {
				return "undefined";
			}
		}

		private function dayTimeGetting() {
			$timeNow = date('G:i', CURRENT_TIME);
			$hourNow = explode(':', $timeNow)[0];

				switch($hourNow){
						case ($hourNow <= 6 || $hourNow >= 23):
							startUpSound::$dayTimeNow = '/night';
						break;

						case ($hourNow <= 12):
							startUpSound::$dayTimeNow = '/morning';
						break;
						
						case ($hourNow <= 18):
							startUpSound::$dayTimeNow = '/day';
						break;
						
						case ($hourNow >= 19):
							startUpSound::$dayTimeNow = '/evening';
						break;
				}
				
				if(!static::$useDayTime){
					startUpSound::$dayTimeNow = '';
				}
		}

		private function seasonNow($monthToday){

			switch($monthToday){
				case ($monthToday <=3 || $monthToday == 12):
					startUpSound::$seasonNow = '/winter';
				break;
				
				case ($monthToday <= 6 && $monthToday > 3):
					startUpSound::$seasonNow = '/spring';
				break;
				
				case ($monthToday <= 9 && $monthToday > 6):
					startUpSound::$seasonNow = '/summer';
				break;
				
				case ($monthToday <= 11 && $monthToday > 9):
					startUpSound::$seasonNow = '/autumn';
				break;				
			}
			
		}

		private static function IncludestartUpSoundModules(){
			global $config;
			$modulesDir = SCRIPTS_DIR.'modules/startUpSoundModules';
			if(!is_dir($modulesDir)){
				mkdir($modulesDir);
			}
			functions::includeModules($modulesDir, $config['modulesDebug']);
		}
	}

	/*	WIP (the future Eventsarray list) In an outer File
	$eventsArray = array(
		'm1' => array(
			"< 12" =>  'winterHolidays'),
		'm2' => array(),
		'm3' => array(),
		'm4' => array(),
		'm5' => array(),
		'm6' => array(),
		'm7' => array(),
		'm8' => array(),
		'm9' => array(),
		'm10' => array(),
		'm11' => array(),
		'm12' => array(),
	);
	*/