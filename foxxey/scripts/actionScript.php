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
 Version: 0.1.2.1 Experimental
-----------------------------------------------------
 Usage: Hooks other classes/modules we have & ACTIONS
=====================================================
*/

	header('Content-Type: text/html; charset=utf-8');
	if(!defined('FOXXEY')) {
		die ("Not a real Fox! =( HWID");
	}

	functions::includeModules(SCRIPTS_DIR.'modules', $config['modulesDebug']);

	foreach ($_GET as $key => $value) {
		$requestTitle = trim(str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($key))));
		$requestValue = trim(str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($value))));
		  
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
				   die('{"message": "Module startUpSound not found!", "desc": "Can`t greet user with starting sound =("}');
			   }
		   break;
		   
		   case 'API':
		   break;
		}
	}
	/* ACTIONS */