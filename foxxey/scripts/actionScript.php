<?php
/*
=====================================================
 What should I do!? | Action script
-----------------------------------------------------
 https://FoxesWorld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: actionScript.php
-----------------------------------------------------
 Version: 0.1.3.2 Experimental
-----------------------------------------------------
 Usage: Hooks other classes/modules we have & ACTIONS
=====================================================
*/

	header('Content-Type: text/html; charset=utf-8');
	if(!defined('FOXXEY')) {
		die ('{"message": "Not in FOXXEY thread"}');
	}



	foreach ($_GET as $key => $value) {
		$requestTitle = trim(str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($key))));
		$requestValue = trim(str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($value))));

		  /* HOOKING MODULES */
		  functions::includeModules(SCRIPTS_DIR.'modules', $config['modulesDebug']);

		  /* ACTIONS */
		  switch ($requestTitle) {
		   case 'auth':
			   if(class_exists('Authorise')) {
					$login		 = $_GET['login'] 		?? null;
					$password 	 = $_GET['password'] 	?? null;
					$hwid 		 = $_GET['hwid']		?? null;
					$Auth 		 = new Authorise($login, $password, $hwid);
					die($Auth->logIn());
			   } else {
				   die('{"message": "Module Authorise not found!", "desc": "Can`t authorise user!"}');
			   }
		   break;
					   
		   case 'startUpSound':
			   if(class_exists('startUpSound')) {
					$startSound = new startUpSound($config['debugStartUpSound']);
					die($startSound->generateAudio());
			   } else {
				   die('{"message": "Module startUpSound not found!", "desc": "Can`t greet user with awesome startUP sound =("}');
			   }
		   break;
		   
		   case 'API':
		   break;
		   
		   case 'show':
			   if(class_exists('skinViewer2D')) {
				header("Content-type: image/png");
				$show = $_GET['show'] ?? null;
				$file_name = $_GET['file_name'] ?? null;
				$name =  empty($file_name) ? 'default' : $file_name;
					$skin =  $config['skinsAbsolute'] . $name . '.png';
					$cloak = $config['cloaksAbsolute'] . $name . '.png';

					if (!skinViewer2D::isValidSkin($skin)) {
						$skin = $config['skinsAbsolute'] . 'default.png';
					}
						
					if ($show !== 'head') {
						$side = isset($_GET['side']) ? $_GET['side'] : false;
						$img = skinViewer2D::createPreview($skin, $cloak, $side);
					} else {
						$img = skinViewer2D::createHead($skin, 64);
					}
					imagepng($img);
			   } else {
					die('{"message": "Module skinViewer2D not found!", "desc": "Can`t show user how beautiful he is =("}');
			   }
		   break;
		}
	}
	/* ACTIONS */