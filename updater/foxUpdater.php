<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
define('FOXXEY', true);

	require ('../foxxey/init');
	$init = new init(REMOTE_IP, 'updater');
	$list = list($path, $qs) = explode("?", $_SERVER["REQUEST_URI"], 2);
	$inputText = base64_decode($qs);
	//echo 'Sent Request - '.$inputText."\n";
	$updater = new updater($inputText);
	