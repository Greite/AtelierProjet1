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

	function viewCreateURL(){
		
		$v = new \mecadoapp\view\MecadoView('');		
		$v ->render('createlist');
		
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
}