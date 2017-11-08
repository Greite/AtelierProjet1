<?php

namespace mecadoapp\auth;

class MecadoAuthentification extends \mf\auth\Authentification {

	const ACCESS_LEVEL_USER  = 100;   
	const ACCESS_LEVEL_ADMIN = 200;

	/* constructeur */
	public function __construct(){
		parent::__construct();
	}

	public function createUser($mail, $pass, $nom, $prenom $level=self::ACCESS_LEVEL_USER) {

		$name = \mecadoapp\model\User::where('mail', '=', $mail)->first();

			if (!isset($name->mail)) {
				$pass = self::hashPassword($pass);
				$user = new \mecadoapp\model\User();
				$user->mail = $mail;
				$user->nom = $nom;
				$user->prenom = $prenom;
				$user->mdp = $pass;
				$user->level = $level;
				$user->save();		
			}
			else {
				 throw new \mf\auth\exception\AuthentificationException();
			}
	}

	public function login($username, $password){

		$user = \mecadoapp\model\User::where('username', '=', $username)->first();
		if (is_null($user->username)) {
			throw new \mf\auth\exception\AuthentificationException();	
		}
		else {
			if (self::verifyPassword($password, $user->password)) {
				self::updateSession($username, self::ACCESS_LEVEL_USER);
			}
			else {
				throw new \mf\auth\exception\AuthentificationException();
			}
			
		}

	}

}
