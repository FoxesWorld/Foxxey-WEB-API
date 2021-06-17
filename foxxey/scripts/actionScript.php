<?php

	if(!defined('FOXXEY')) {
		die ("Not a real Fox! =( HWID");
	}

	foreach ($_GET as $key => $value) {
					$requestTitle = trim(str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($key))));
					$requestValue = trim(str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($value))));

				   switch ($requestTitle) {
					   case 'auth':
						$login		 = $_GET['login'] 		?? null;
						$password 	 = $_GET['password'] 	?? null;
						$hwid 		 = $_GET['hwid']		?? null;
						$Auth = new Authorise($login, $password, $hwid);
						die($Auth->logIn());
					   break;
				   }
	}