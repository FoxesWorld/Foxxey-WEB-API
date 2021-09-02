<?php
	Error_Reporting(E_ALL);
	Ini_Set('display_errors', true);

	define('REMOTE_IP',   getenv('REMOTE_ADDR'));
	define('FOXXEY', true);

	require ('init.php');
	$init = new init(REMOTE_IP, 'API');