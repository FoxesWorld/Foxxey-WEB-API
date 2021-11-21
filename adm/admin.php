<?php
/*
=====================================================
 This is my Brain! | FoxxeyAPI Adm/API class
-----------------------------------------------------
 https://FoxesWorld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: admin.php
-----------------------------------------------------
 Version: 0.1.2.4 Experimental
-----------------------------------------------------
 Usage: All the functions of Foxxey Admin can be verifyed in here
=====================================================
*/
	Error_Reporting(E_ALL);
	Ini_Set('display_errors', true);

session_start();
define('REMOTE_IP', getenv('REMOTE_ADDR'));
define('FOXXEY', true);
define('FOXXEYadm', true);
require ('../foxxey/init');
require (ADMIN_DIR.'engine/data/config.php');
require ('engine/inc/functions.class.php');

	$FoxxeyAPI = new FoxxeyAPI();

	class FoxxeyAPI {
		
		public function __construct(){
			global $config, $admConfig;
			
			$init = new init(REMOTE_IP, 'ADM');
			
			$webSiteDB = new db($config['db_user'],$config['db_pass'],$config['db_database']);
					if($_REQUEST){
						require('engine/engine.php');
						$ADMengine = new ADMengine($_REQUEST, REMOTE_IP, $webSiteDB);
					}
			if(!isset($_SESSION['isLogged']) || !in_array(json_decode(admFunctions::getUserData($_SESSION['login'], 'user_group', $webSiteDB)) -> user_group, $admConfig['groupsToShow'])){
				die(admFunctions::getTemplate(ADMIN_DIR."tpl/login"));
			} else {
				die(admFunctions::getTemplate(ADMIN_DIR."tpl/main"));
			}
		}
	}