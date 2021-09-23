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
 Version: 0.1.2.3 Experimental
-----------------------------------------------------
 Usage: All the functions of Foxxey Admin can be verifyed in here
=====================================================
*/
	Error_Reporting(E_ALL);
	Ini_Set('display_errors', true);

session_start();
define('FOXXEY', true);
define('FOXXEYadm', true);
require ('../foxxey/foxxeyData/config.php');
require (ADMIN_DIR.'engine/data/config.php');
require ('engine/inc/functions.class.php');

	$FoxxeyAPI = new FoxxeyAPI();

	class FoxxeyAPI {
		
		public function __construct(){
			global $config;
			require (SCRIPTS_DIR.'database.class.php');
			$ip = getenv('REMOTE_ADDR');
			$webSiteDB = new db($config['db_user'],$config['db_pass'],$config['db_database']);
					if($_REQUEST){
						require('engine/engine.php');
						$ADMengine = new ADMengine($_REQUEST, $ip, $webSiteDB);
					}
			if(!isset($_SESSION['isLogged'])){
				die(admFunctions::getTemplate(ADMIN_DIR."tpl/login"));
			} else {
				die(admFunctions::getTemplate(ADMIN_DIR."tpl/main"));
			}
		}
	}