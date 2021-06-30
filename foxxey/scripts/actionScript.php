<?php
/*
=====================================================
 What should I do! | Action script
-----------------------------------------------------
 https://FoxesWorld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: actionScript.php
-----------------------------------------------------
 Version: 0.1.2.0 Experimental
-----------------------------------------------------
 Usage: Hooks other classes/modules we have
=====================================================
*/

	header('Content-Type: text/html; charset=utf-8');
	if(!defined('FOXXEY')) {
		die ("Not a real Fox! =( HWID");
	}
	includeModules(SCRIPTS_DIR.'modules', $config['modulesDebug']);

	foreach ($_GET as $key => $value) {
		$requestTitle = trim(str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($key))));
		$requestValue = trim(str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($value))));

		  switch ($requestTitle) {
		   case 'auth':
			require (SCRIPTS_DIR.'/authorise.class.php');
			$login		 = $_GET['login'] 		?? null;
			$password 	 = $_GET['password'] 	?? null;
			$hwid 		 = $_GET['hwid']		?? null;
			$Auth 		 = new Authorise($login, $password, $hwid);
			die($Auth->logIn());
		   break;
					   
		   case 'startUpSound':
		   		$startSound = new startUpSound($config['debugStartUpSound']);
				die($startSound->generateAudio());
		   break;
		}
	}
	
	function includeModules($dirInclude, $debug = false){
		$count = 0;
		$dir = opendir($dirInclude);
		if($debug === true){
			echo "<b>Modules to include: </b> (Debug)<br>";
		}
		while($file = readdir($dir)){
				if($file == '.' || $file == '..'){
					continue;
				} else {
					if($debug === true){
						echo "<b>".$count."</b> ".$file."<br>";
						$count ++;
					}
					if(strpos($file, 'module') !== false) {
						require ($dirInclude.'/'.$file);
					}
				}
			}
	}