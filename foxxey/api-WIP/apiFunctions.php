<?php

	class apiFuncftions extends actionScript {
		
		private $request;
		
		function __construct($request){
			global $config;
			$this->request = $request;
			echo var_dump($this->ip);
			

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
						die('{"message": "Unknown request!"}');
				}
			}
		}
	}