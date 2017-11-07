<?php

namespace mecadoapp\auth;

class MecadoAuthentification extends \mf\auth\Authentification {

	/*
	 * Classe MecadoAuthentification qui définie les méthodes qui dépendent
	 * de l'application (liée à la manipulation du modèle User) 
	 *
	 */

	/* niveaux d'accès de MecadoApp 
	 *
	 * Le niveau USER correspond a un utilisateur inscrit avec un compte
	 * Le niveau ADMIN est un plus haut niveau (non utilisé ici)
	 * 
	 * Ne pas oublier le niveau NONE un utilisateur non inscrit est hérité 
	 * depuis AbstractAuthentification 
	 */
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
