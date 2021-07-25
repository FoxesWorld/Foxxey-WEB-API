<?php

	class sessionConstruct {
		
		public static $userRealName;
		
		function __construct(){
			
		}
		
		public static setRealName($name){
			sessionConstruct::$userRealName = $name;
			$_SESSION['realName'] = sessionConstruct::$userRealName;
		}
	}

?>