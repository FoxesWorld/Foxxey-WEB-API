<?php
/*
=====================================================
 Launcher-N-Hash Class
-----------------------------------------------------
 https://Foxesworld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021 FoxesWorld
-----------------------------------------------------
 Данный код защищен авторскими правами
-----------------------------------------------------
 Файл: updater.php
-----------------------------------------------------
 Версия: 0.3.5.2 Beta
-----------------------------------------------------
 Назначение: Проверка хеша лаунчера и апдейтера
=====================================================
*/
header("Content-Type: application/json; charset=UTF-8");
if (!defined('FOXXEY')) {
	die ('{"message": "Not in FOXXEY thread"}');
}

class updater {

	//Got from User
	private static $inputString;
	private static $runnerType;
	private static $updaterBitDepth;
	private static $osName;
	private static $JREversion;
	private static $runnerHash;
	private static $launcher_hash;
	//private static $download;

	public function __construct($inputString, $debug = false) {

		updater::$updaterBitDepth = $inputString['b'];	//BitDepth
		updater::$osName 		  = $inputString['n']; //OsName
		updater::$JREversion 	  = $inputString['v'];   //JREversion
		updater::$runnerHash 	  = $inputString['rnh'];   //Runner hash
		updater::$launcher_hash   = $inputString['lch'] ?? null; //launcher hash
		updater::$runnerType      = $inputString['rnty'] ?? 'exe'; //RunnerType
		//updater::$download 	   = $_GET['download'] ?? null; TO DOWNLOAD UPDATER
		die(var_dump(static::$inputString));

		if(static::$runnerHash !== null){
			$this->updaterCheck($debug);
		}
		
		if(static::$launcher_hash !== null){
			$this->launcherHash();
		}
		//$this->downloadUpdater();
		
		if($debug === true) {
			error_reporting(E_ALL);
		}
		
		if($_REQUEST) {
			die('{"runtimeFname": "'.$this->getuserJre().'","runtimeHash": "Not readdy yet","runnerType": "notSent","updaterUpdateState": "don`t know"}');
		}
	}
	
	/**
	* @param boolean $debug
	* @return YES||NO
	* @throws Exception
	*/
	private function updaterCheck($debug) {
		global $config;
		try {
			if(isset(static::$runnerType)){
				$file = "updater";
				switch(static::$runnerType){
					case 'jar' || 'exe':
						$fileName = $file.'.'.static::$runnerType;
						$filePath = $config['updaterRepositoryPath'].$fileName;
						if(file_exists($filePath)) {
							$updaterHashLocal = md5_file($filePath);
							switch($updaterHashLocal){

								case static::$runnerHash == $updaterHashLocal:
									$updateState = 'NO';
								break;

								case static::$runnerHash != $updaterHashLocal:
									$updateState = 'YES';
								break;
							}
						} else {
							$updateState = 'YES';
							$fileName = 'UnfoundFile';
						}
					break;

					default:
						$updateState = "Unknown updater type!";
					break;
				}

				$answer = array('fileName' => $fileName, 'fileHash' => @$updaterHashLocal, 'updateState' => $updateState);
				$answer = json_encode($answer);
				die($answer);
			}
		}  catch (Exception $e) {
			die("File not found! ".$e);
		}
		if($debug === true) {
			echo 'updaterRepositoryPath: '.$config['updaterRepositoryPath'].'extension';
		}
	}
	
	//Checking launcher hash
	private function launcherHash() {
		global $config;

		if(isset(static::$launcher_hash)){
			try {
				$launcherRepositoryHash = md5_file($config['launcherRepositoryPath']);
				$launcherState = static::$launcher_hash == $launcherRepositoryHash  ? "NO" : "YES";
				$fileName = explode('/',$config['launcherRepositoryPath']); 
				$answer = array('fileName' =>$fileName[2], 'hash' => $launcherRepositoryHash, 'updateState' => $launcherState, 'updateNotes' => 'Deploying');
				$answer = json_encode($answer);
				die($answer);
			}  catch (Exception $e) {
				die('{"message": "File not found! '.$e.'"}');
			}
		}
	}

	private function getuserJre(){
		$osName = updater::$osName;

		switch ($osName){
			case (strpos($osName, 'win')):
				$osArchName = 'win';
			break;
					
			case (strpos($osName, 'arm')):
				$osArchName = 'arm';
			break;
					
			case (strpos($osName, 'linux')):
				$osArchName = 'linux';
			break;
					
			case (strpos($osName, 'mac')):
				$osArchName = 'mac';
			break;
					
			default:
				echo 'Unknown OS';
		}

		$archiveName = 'jre-8u'.updater::$JREversion .'-'.$osArchName.updater::$updaterBitDepth.'.zip';
		if(!file_exists(FILES_DIR.'runtime/'.$archiveName)) {
			die('{"message": "File '.$archiveName.' does not exists, sorry =(. We`re about to add it!!!"}');
		}
		return  $archiveName;
	}
	
	private function downloadUpdater(){
		switch (static::$download){
			case 'jar' || 'exe':
				$file = "files//updater//updater.".static::$download;
				if(file_exists($file)) {
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename=' . basename("Foxesworld.".static::$download));
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));
					readfile($file);
					exit;
				}
			break;
				
			default:
				die ('{"message": "Unknown request!"}');
			break;
		}
	}
}
?>