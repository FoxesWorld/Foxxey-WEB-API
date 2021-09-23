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
 Usage: AObserving tpl pages (Logged only)
=====================================================
*/
if(!defined('FOXXEYadm')){
	die('{"message": "Not In Admin Thread!"}');
}
	class adminPages {
		
		private $page;
		private $tplFilesArray;
		private $login;
		private $photo;
		private $realname;
		
		function __construct($page){//, $login, $photo, $realname
			$this->page  	= $page;
			//$this->login	= $login;
			//$this->photo 	= $photo;
			//$this->realname = $realname;
			$this->tplFilesArray = admFunctions::filesInDirArray(ADMIN_DIR.'tpl/','.tpl');
			$this->availablePages($this->page);
		}
		
		private function availablePages($page){
			//TODO - scan tpl dir automatically!!!
			if(in_array($page.'.tpl', $this->tplFilesArray)) {
				die(admFunctions::getTemplate(ADMIN_DIR.'tpl/'.$page));
			} else {
				die('TPL '.$page.' was not found');
			}
		}
	}

?>