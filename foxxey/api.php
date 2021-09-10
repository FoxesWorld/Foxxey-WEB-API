<?php
/*
=====================================================
 API main file
-----------------------------------------------------
 https://Foxesworld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: config.php
-----------------------------------------------------
 Version: 0.1.0.1 Alpha
-----------------------------------------------------
 Usage: Parsing and changing data
=====================================================
*/
	Error_Reporting(E_ALL);
	Ini_Set('display_errors', true);

	define('REMOTE_IP',   getenv('REMOTE_ADDR'));
	define ('API', true);
	define('FOXXEY', true);

	require ('init.php');
	$init = new init(REMOTE_IP, 'API');