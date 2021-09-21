<?php 
if(!defined('FOXXEYadm')){
	die('{"message": "Not In Admin Thread!"}');
}
	class adminPages {
		
		private $page;
		private $login;
		private $photo;
		private $realname;
		
		function __construct($page){//, $login, $photo, $realname
			$this->page  	= $page;
			//$this->login	= $login;
			//$this->photo 	= $photo;
			//$this->realname = $realname;
			
			$this->availablePages($this->page);
		}
		
		private function availablePages($page){
			//TODO - scan tpl automatically!!!
			switch($page) {
				
				case 'dashboard':
					die($this->getTemplate(ADMIN_DIR.'tpl/dashboard'));
				break;
				
				case 'settings':
					die($this->getTemplate(ADMIN_DIR.'tpl/settings'));
				break;
				
				case 'profile':
					die($this->getTemplate(ADMIN_DIR.'tpl/profile'));
				break;
				
				default:
					die('{"message": "Cannot find that page!"}');
				
			}
			
		}
		
		//To merge
		function getTemplate($name) {
			ob_start();
			include ($name.".tpl");
			$text = ob_get_clean();
			return $text;
		}
	}

?>