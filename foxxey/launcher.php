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
 Version: 0.1.1.0 Experimental
-----------------------------------------------------
 Usage: All the functions of Foxxey can be obtained in here
=====================================================
*/
header('Content-Type: text/html; charset=utf-8');
Error_Reporting(E_ALL);
Ini_Set('display_errors', true);
//==============================
	define  ('FOXXEY',true);
	require ('config.php');
	require (SCRIPTS_DIR.'database.class.php');
	require (SCRIPTS_DIR.'functions.class.php');
	require (SCRIPTS_DIR.'actionScript.php');