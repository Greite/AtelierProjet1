<?php

namespace mecadoapp\control;

class MecadoController extends \mf\control\AbstractController {

	function __construct(){
		parent::__construct();
	}

	function viewHome(){

		$v = new \mecadoapp\view\MecadoView('');
		$v ->render('home');  
	}

	function viewPost(){
		$v = new \mecadoapp\view\MecadoView('');
		$v ->render('post');  
	}

	function viewSend() {
		$tweet = new \mecadoapp\model\Message();
		$user = \mecadoapp\model\User::where('username', '=', $_SESSION['user_login'])->first();
		$tweet->text = filter_var($_POST['text'],FILTER_SANITIZE_SPECIAL_CHARS);
		$tweet->author = $user->id;
		$tweet->save();
		self::viewHome();
	}

	function viewSignUp(){
		$v = new \mecadoapp\view\MecadoView('');
		$v ->render('signup');
	}

	function viewLogin(){
		$v = new \mecadoapp\view\MecadoView('');
		$v ->render('login');  
	}

	function viewCreateUser() {
		$v = new \mecadoapp\auth\MecadoAuthentification();
		$v->createUser($_POST['mail'], $_POST['password'], $_POST['nom'], $_POST['prenom']);
		self::viewHome();
	}

	function viewCreateList() {
		$v = new \mecadoapp\view\MecadoView('');		
		$v ->render('createlist');
	}

<<<<<<< HEAD
	function viewProfile() {
		$user = \mecadoapp\model\User::where('mail', '=', $_SESSION['user_login'])->first();
		$v = new \mecadoapp\view\MecadoView($user);		
		$v ->render('profile');
=======
	function viewCheckCreateList() {
		$list = new \mecadoapp\model\Liste();
		$user = \mecadoapp\model\User::where('mail', '=', $_SESSION['user_login'])->first();
		$list->titre = filter_var($_POST['titre'],FILTER_SANITIZE_SPECIAL_CHARS);
		$list->description = filter_var($_POST['desc'],FILTER_SANITIZE_SPECIAL_CHARS);
		$list->date_limite = $_POST['validite'];
		$list->destinataire = filter_var($_POST['destinataire'],FILTER_SANITIZE_SPECIAL_CHARS);
		if ($_POST['for_him']) {
			$list->for_him = $_POST['for_him'];
		}else{
			$list->for_him = 0;
		}
		$list->id_user = $user->id;
		$list->save();
		self::viewHome();
>>>>>>> 7db2cbd3d6b8abb9ecd8482e5698ee24daf91936
	}

	function viewCreateURL(){
		$v = new \mecadoapp\view\MecadoView('');		
<<<<<<< HEAD
		$v ->render('createlist');	
=======
		$v ->render('createURL');
	}

	function viewaffichagelist(){
		$v = new \mecadoapp\view\MecadoView('');		
		$v ->render('affichagelist');
>>>>>>> 7db2cbd3d6b8abb9ecd8482e5698ee24daf91936
	}


	function viewCheckLogin() {
		$v = new \mecadoapp\auth\MecadoAuthentification();
		$v->login($_POST['mail'], $_POST['password']);
		self::viewHome();
	}

	function viewLogout() {
		$v = new \mecadoapp\auth\MecadoAuthentification();
		$v->logout();
		self::viewHome();
	}

	function viewAjoutItem(){
		$v = new \mecadoapp\view\MecadoView('');
		$v-> render('ajoutItem');
	}
}