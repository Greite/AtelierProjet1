<?php
/**
* 
*/

namespace mf\auth;

class Authentification extends AbstractAuthentification
{
	
	function __construct()
	{
		if (isset($_SESSION['user_login'])) {
			$this->user_login = $_SESSION['user_login'];
			$this->access_level = $_SESSION['access_level'];
			$this->logged_in = true;
		}
		else {
			$this->user_login = null;
			$this->access_level = self::ACCESS_LEVEL_NONE;
			$this->logged_in = false;
		}
	}
	
	function updateSession($username, $level) {
		$this->user_login = $username;
		$this->access_level = $level;
		$_SESSION['user_login'] = $username;
		$_SESSION['access_level'] = $level;
		$this->logged_in = true;
	}
	
	function logout() {

		$this->user_login = null;
		$this->access_level = self::ACCESS_LEVEL_NONE;
		$this->logged_in = false;
		unset($_SESSION['user_login']);
		unset($_SESSION['access_level']);
	}

	function checkAccessRight($requested) {

		if ($requested > $this->access_level){
			return false;
		}
		else return true;

	}
	
	function hashPassword($password) {

		return password_hash($password, PASSWORD_DEFAULT);

	}

	function verifyPassword($password, $hash) {

		return password_verify($password, $hash);
	}
}