<?php
	Error_Reporting(E_ALL);
	Ini_Set('display_errors', true);

session_start();
define('FOXXEY', true);
define('FOXXEYadm', true);
require ('../foxxey/foxxeyData/config.php');

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
				die($this->getTemplate(ADMIN_DIR."tpl/login"));
			} else {
				die($this->getTemplate(ADMIN_DIR."tpl/main"));
			}
		}
		
	function getTemplate($name) {
		ob_start();
		include ($name.".tpl");
		$text = ob_get_clean();
		return $text;
    }
		
	}