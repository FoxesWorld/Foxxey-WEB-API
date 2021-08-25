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
 Версия: 0.3.5.1 Beta
-----------------------------------------------------
 Назначение: Проверка хеша лаунчера и апдейтера
=====================================================
*/
header("Content-Type: application/json; charset=UTF-8");
if (!defined('FOXXEY')) {
	die ('{"message": "Not in FOXXEY thread"}');
}

class updater {

	private static $updaterType;
	private static $updaterBitDepth;
	private static $osName;
	private static $JREversion;
	private static $updater_hash;
	private static $launcher_hash;
	private static $download;

	public function __construct($updaterJsonString, $debug = true) {

		//updater::$updaterType    = $updaterType ?? null; JAR || EXE WIP

		updater::$updaterBitDepth = $updaterJsonString['b'];
		updater::$osName 		  = $updaterJsonString['n'];
		updater::$JREversion 	  = $updaterJsonString['v'] ?? 301;
		updater::$updater_hash 	  = $_GET['updater_hash'] ?? null;
		updater::$launcher_hash   = $_GET['launcher_hash'] ?? null;
		//updater::$download = $_GET['download'] ?? null; TO DOWNLOAD UPDATER
		if(static::$updater_hash !== null){
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
			die('{"filename": "'.$this->getuserJre(static::$updaterBitDepth, static::$osName, static::$JREversion).'",
				   "hash": "Not readdy yet",
				   "updaterTYpe": "notSent",
				   "updaterUpdate": "don`t know"}');
			
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
			if(isset(static::$updaterType)){
				$file = "updater";
				switch(static::$updaterType){
					case 'jar' || 'exe':
						$fileName = $file.'.'.static::$updaterType;
						$filePath = $config['updaterRepositoryPath'].$fileName;
						if(file_exists($filePath)) {
							$updaterHashLocal = md5_file($filePath);
							switch($updaterHashLocal){

								case static::$updater_hash == $updaterHashLocal:
									$updateState = 'NO';
								break;

								case static::$updater_hash != $updaterHashLocal:
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

	/**
	* @param boolean $debug
	* @return YES||NO
	* @throws Exception
	*/
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
	
	private function readUpdateNotes($file){
		if(file_exists($file)) {
			$fd = fopen($file, 'r');
			$fileContents = array();
			while(!feof($fd))
			{
				$str = htmlentities(fgets($fd));
				$fileContents[] = $str;
			}
			return $fileContents;
		} else {
			die('{"message": "File - '.$file.' not found!"}');
		}
	}
	
	private function getuserJre($bitDepth, $osName, $version){

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
				
		$archiveName = 'jre-8u'.$version.'-'.$osArchName.$bitDepth.'.zip';
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