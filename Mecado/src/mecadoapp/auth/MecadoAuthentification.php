<?php

namespace mecadoapp\auth;

class MecadoAuthentification extends \mf\auth\Authentification {

	const ACCESS_LEVEL_USER  = 100;   
	const ACCESS_LEVEL_ADMIN = 200;

	/* constructeur */
	public function __construct(){
		parent::__construct();
	}

	public function createUser($username, $pass, $fullname, $level=self::ACCESS_LEVEL_USER) {

		$name = \mecadoapp\model\User::where('username', '=', $username)->first();

			if (!isset($name->username)) {
				$pass = self::hashPassword($pass);
				$user = new \mecadoapp\model\User();
				$user->username = $username;
				$user->fullname = $fullname;
				$user->password = $pass;
				$user->level = $level;
				$user->save();		
			}
			else {
				 throw new \mf\auth\exception\AuthentificationException();
			}
	}

	public function login($mail, $password){

		$user = \mecadoapp\model\User::where('mail', '=', $mail)->first();
		
		if (is_null($user->mail)) {
			throw new \mf\auth\exception\AuthentificationException();	
		}
		else {
			if (self::verifyPassword($password, $user->mdp)) {
				self::updateSession($mail, self::ACCESS_LEVEL_USER);
			}
			else {
				throw new \mf\auth\exception\AuthentificationException();
			}
			
		}

	}

}
