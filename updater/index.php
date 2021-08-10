<?php
define('FOXXEY', true);
	require ('../foxxey/init.php');
	$init = new init(REMOTE_IP, 'updater');
	$list = list($path, $qs) = explode("?", $_SERVER["REQUEST_URI"], 2);
	$inputText = json_decode(base64_decode($qs), true);
	$updater = new updater($inputText);
	