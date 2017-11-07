<?php

namespace mecadoapp\control;

class MecadoController extends \mf\control\AbstractController {

	function __construct(){
		parent::__construct();
	}

	function viewSignUp(){
		$v = new \tweeterapp\view\TweeterView('');
		$v ->render('signup');  
	}

	function viewLogin(){
		$v = new \tweeterapp\view\TweeterView('');
		$v ->render('login');  
	}

	function viewCreateUser() {
		$v = new \tweeterapp\auth\TweeterAuthentification();
		$v->createUser($_POST['username'], $_POST['password'], $_POST['fullname']);
		self::viewHome();
	}

	function viewCheckLogin() {
		$v = new \tweeterapp\auth\TweeterAuthentification();
		$v->login($_POST['username'], $_POST['password']);
		self::viewFollowing();
	}

	function viewLogout() {
		$v = new \tweeterapp\auth\TweeterAuthentification();
		$v->logout();
		self::viewHome();
	}