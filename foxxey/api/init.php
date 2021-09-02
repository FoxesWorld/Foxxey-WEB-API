<?php
	define ('API', true);
	
	class apiInit {

		private $ip;
		private $request;
		
		function __construct($ip, $request = null){
			$this->ip = $ip;
				if($this->ip != null) {
				if($request) {
					$this->request = $request;
					require ('apiFunctions.php');
					$apiFuncftions = new apiFuncftions($ip, $_GET);
				}
			} else {
				die('{"message": "Undefined IP!"}');
			}
		}	
	}
	
	