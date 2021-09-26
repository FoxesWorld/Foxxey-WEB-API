<?php
/*
=====================================================
 What page do you want to read?
-----------------------------------------------------
 https://FoxesWorld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: pages.class.php
-----------------------------------------------------
 Version: 0.1.5.0 Experimental
-----------------------------------------------------
 Usage: Abserving tpl pages (Logged only)
=====================================================
*/
if(!defined('FOXXEYadm')){
	die('{"message": "Not In Admin Thread!"}');
}
	class adminPages {
		
		private $page;
		private $tplFilesArray;
		
		function __construct($page){
			$this->page  	= $page;
			$this->tplFilesArray = admFunctions::filesInDirArray(ADMIN_DIR.'tpl/','.tpl');
			$this->availablePages($this->page);
		}
		
		private function availablePages($page){
			if(in_array($page.'.tpl', $this->tplFilesArray)) {
				die(admFunctions::getTemplate(ADMIN_DIR.'tpl/'.$page));
			} else {
				die('TPL '.$page.' was not found');
			}
		}
	}

?>