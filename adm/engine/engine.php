<?php 
if(!defined('FOXXEYadm')){
	die('{"message": "Not In Admin Thread!"}');
}

	class ADMengine {
		
		private $action;
		private $ip;
		private $webSiteDB;
		
		function __construct($request, $ip, $webSiteDB){
			$this->ip = $ip;
			$this->webSiteDB = $webSiteDB;
			$this->action = $request['action'];
			if(isset($this->action)) {
				switch($this->action){
					case 'logIn':
						$this->logIn();
					break;
					
					case 'logOut':
						$this->logOut();
					break;
					
					case 'loadPage':
						if(@$_SESSION['isLogged'] === true) {
							$page = $_POST['page'];
							require ('pages.class.php');
							$adminPages = new adminPages($page);
						} else {
							die('{"message": "Not logged in!"}');
						}
					break;

					default:
						die('{"message": "Unknown adm Action request!"}');
				}
			} else {
				die('{"message": "No Action was passed!"}');
			}
		}
		
		private function logIn() {
				$login = $_POST['login'];
				$password = $_POST['password'];
				@$rememberMe = $_POST['rememberMe'];
				$group = json_decode($this->getUserData($login, 'user_group', $this->webSiteDB)) -> user_group ?? null;

				if($group != 1 && $group !== null){
					exit('{"message": "Not an admin user"}');
				} else {
					$passwordDB = json_decode($this->getUserData($login, 'password', $this->webSiteDB)) -> password ?? null;
					if(password_verify($password, $passwordDB)) {
						$fullname  = json_decode($this->getUserData($login, 'fullname', $this->webSiteDB))	-> fullname   ?? 'Мастер Лис';
						$photo = json_decode($this->getUserData($login, 'foto', $this->webSiteDB))	-> foto;
						$_SESSION['fullname'] = $fullname;
						$_SESSION['photo'] 	  = $photo;
						$_SESSION['pass'] 	  = $password;
						$_SESSION['isLogged'] = true;

						if($rememberMe) {
							session_write_close();
							ini_set('session.cookie_lifetime', 0);
							session_set_cookie_params(0);
						}
						die('{"type": "success", "message": "Correct!!!"}');
					} else {
						die('{"message": "Incorrect login or password"}');
					}
				}
		}
		
		private function logOut() {
				session_unset();
				session_destroy();
				die('{"message": "Exit successful!", "type": "success"}');
		}
		
		private function getUserData($login, $data, $db){
		$query = "SELECT $data FROM dle_users WHERE name = '$login'";
		$selectedValue = $db->getRow($query);
			if($selectedValue["$data"]){
					$gotData = $selectedValue["$data"];
					$answer = array('type' => 'success', 'username' => $login, $data => $gotData);
					$answer = json_encode($answer);
				} else {
					$answer = "{'type', 'warn', 'message', 'Login not found'}";
				}
		return $answer;
	}
		
	}