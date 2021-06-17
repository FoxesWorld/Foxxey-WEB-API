<?php
Error_Reporting(E_ALL);
Ini_Set('display_errors', true);
//==============================
	define  ('FOXXEY',true);
	require ('config.php');
	require (SCRIPTS_DIR.'database.class.php');
	require (SCRIPTS_DIR.'HWID.class.php');
	require (SCRIPTS_DIR.'functions.class.php');
	require (SCRIPTS_DIR.'authorize.class.php');
	require (SCRIPTS_DIR.'actionScript.php');