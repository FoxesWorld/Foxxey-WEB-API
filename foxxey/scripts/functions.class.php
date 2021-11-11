<?php
/*
=====================================================
 Hey, I've got a lot of things for you! | functions class
-----------------------------------------------------
 https://FoxesWorld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: functions,class.php
-----------------------------------------------------
 Version: 0.1.8.7 Beta
-----------------------------------------------------
 Usage: A bunch of functions
=====================================================
Note: All functions will be rebuilt as shared libraries
*/
if(!defined('FOXXEY')) {
	die ('{"message": "Not in FOXXEY thread"}');
}

	class functions {
			
			//Remove or replace
			public static function includeModules($dirInclude, $debug = false, $modulesArray = null) {
				$count = 1;
				$IncludingText = '';
				if($debug === true){ $visualCounter = 1; echo "Modules to include: \n";}
				switch ($modulesArray) {
					case null:
						$filesAray = filesInDir::filesInDirArray($dirInclude,'.php');
						$count = count($filesAray);
						for($i = 0; $i < $count; $i++){
							if($debug === true){ echo $visualCounter.') '.$filesAray[$i]."\n";$visualCounter++;}
							require ($dirInclude.'/'.$filesAray[$i]);
							
						}
					break;
					
					case is_array($modulesArray):
						$count = count($modulesArray);
						for($i = 0; $i < $count; $i++){
							if($debug === true){
								echo $visualCounter.') '.$modulesArray[$i]."\n";
								$visualCounter++;
							}
							require ($dirInclude.'/'.$modulesArray[$i]);
						}	
					break;
				}
				if($debug === true){echo 'Total modules: '.$count."\n\n";}
			}
			
			//Remove or replace!!! (Too much modules)
			public static function modulesInit() {
				$allModules = filesInDir::filesInDirArray(SCRIPTS_DIR.'modules','.php');
				for($i = 0; $i < count($allModules); $i++){
					if(strpos($allModules[$i],'.wip.')) {
						$wipModules[] = $allModules[$i];
					} else {
						$validModules[] = $allModules[$i];
					}
				}
				$returnArray = array(
					'validModules' => $validModules,
					'wipModules'   => @$wipModules
				);
				
				return $returnArray;
			}
			
			//Murge to servers library
			public static function getServersList($db, $server = null, $data = null){
				$ans;
				if($server == null){
					$query = "SELECT * FROM `servers`";
					$servers = $db::getRows($query);
					foreach($servers as $key) {
						$ans[] = $key['Server_name'];
					}
				} else {
					if($data) {
						$query = "SELECT * FROM `servers` WHERE Server_name = '".$server."'";
						$servers = $db::getRow($query);
						$ans = $servers[$data];
					} else {
						die('{"message": "No data!"}');
					}
				}

				
				return $ans;
			}
			
			//Will be murged to file library
			public static function checkDir($modpack, $db){
				$thisVersion = functions::getServersList($db, $modpack, 'version');
				$scanArray = array(FILES_DIR.'clients/modpacks/'.$modpack, FILES_DIR.'clients/versions/'.$thisVersion);
				foreach($scanArray as $key){
				$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($key), RecursiveIteratorIterator::SELF_FIRST);
					foreach($objects as $name => $object) {
					$basename = basename($name);
						$isdir = is_dir($name);
						if ($basename!="." and $basename!=".." and !is_dir($name)){
							$str = str_replace(ROOT_DIR, "", str_replace($basename, "", $name));
								$fileOBJ[] = 
								[
									'filename' => $str.$basename,
									'hash'     => md5($name),
									'size'     => strval(filesize($name))
								];
						}
					}
				}
				return json_encode($fileOBJ, JSON_UNESCAPED_SLASHES);
			}
			
			//Mainframe
			public static function libFilesInclude(){
				$libDir = SITE_ROOT.'/lib';
				$openDir = opendir($libDir);
				while($file = readdir($openDir)){
					if($file == '.' || $file == '..'){
						continue;
					} else {
						require_once ($libDir.'/'.$file);
					}
				}
			}
	}