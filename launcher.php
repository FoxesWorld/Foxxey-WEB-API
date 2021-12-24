<?php
/*
=====================================================
 This is my core! | Launcher class
-----------------------------------------------------
 https://FoxesWorld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: launcher.php
-----------------------------------------------------
 Version: 0.1.2.0 Experimental
-----------------------------------------------------
 Usage: All the functions of Foxxey can be obtained in here
=====================================================
*/
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
Error_Reporting(E_ALL);
Ini_Set('display_errors', true);
session_start();
define('REMOTE_IP',   getenv('REMOTE_ADDR'));
//==============================
	if($_REQUEST) {
		define  ('FOXXEY',true);
		require ('foxxey/init');
		$init = new init(REMOTE_IP, 'launcher');
	} else  {
		die('{"message": "No sent request"}');
	}
?>