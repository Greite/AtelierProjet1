<?php

namespace mecadoapp\control;

class MecadoController extends \mf\control\AbstractController {

	function __construct(){
		parent::__construct();
	}

	function viewHome(){

		$v = new \mecadoapp\view\MecadoView();
		$v ->render('home');  
	}

	function viewPost(){
		$v = new \mecadoapp\view\MecadoView('');
		$v ->render('post');  
	}

	function viewSend() {

		$tweet = new \mecadoapp\model\Tweet();
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
		$v->createUser($_POST['username'], $_POST['password'], $_POST['fullname']);
		self::viewHome();
	}

	function viewCheckLogin() {
		$v = new \mecadoapp\auth\MecadoAuthentification();
		$v->login($_POST['username'], $_POST['password']);
		self::viewFollowing();
	}

	function viewLogout() {
		$v = new \mecadoapp\auth\MecadoAuthentification();
		$v->logout();
		self::viewHome();
	}
}