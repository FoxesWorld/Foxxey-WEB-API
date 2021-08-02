<?php
Error_Reporting(E_ALL);
Ini_Set('display_errors', true);
//WIP IN FUTURE WE plan to move all the functionality 
//of module inclusion in here. And the total block function

		define  ('FOXXEY',true);
		require ('config.php');
		require (SCRIPTS_DIR.'database.class.php');
		require (SCRIPTS_DIR.'functions.class.php');
		require (SCRIPTS_DIR.'actionScript.php');
/*
	//$primaryModules = array('totalBlock', 'logger', 'randTexts');
	$OtherModules = array();

	$allModules = functions::filesInDirArray (SCRIPTS_DIR.'/modules','.php');
	while($counter < count($allModules)){
		if(strpos($allModules[$counter], 'rimary.')){
			$primaryModules[] = $allModules[$counter];
		} else {
			echo 'Ignoring '.$allModules[$counter]."<br>";
		}
		
		$counter++;
	}
*/
$init = new init();
echo var_dump($init->allModules);

	class init {
		
		//Modules==================
		protected $primaryModules;
		protected $otherModulles;
		public $allModules;
		//=========================
		
		function construct() {
			$this->allModules = functions::filesInDirArray (SCRIPTS_DIR.'/modules','.php');
		}

	}
	
