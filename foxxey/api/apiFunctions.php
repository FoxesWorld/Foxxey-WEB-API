<?php
	if(!defined('API')) {
		die('Not in API thread!');
	}

	class apiFuncftions {
		
		private $ip;
		private $request;
		
		function __construct($ip, $request){
			global $config;
			$this->ip = $ip;
			$this->request = $request;
			

			foreach ($this->request as $key => $value) {
				$requestTitle = trim(str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($key))));
				$requestValue = trim(str_replace($config['not_allowed_symbol'],'',strip_tags(stripslashes($value))));
				switch($requestTitle){
				//Debug function
					   case 'testBan':
						$longTermBan = new longTermBan($this->ip, $this->launcherDB, $requestValue);
						$longTermBan->banIP();
					   break;
						   
				//Debug function
					   case 'rndPhrase':
							$randTexts = new randTexts($requestValue);
							die($randTexts->textOut());
					   break;
					   
					   default:
						die('{"message": "Unknown API request!"}');
				}
			}
		}
	}