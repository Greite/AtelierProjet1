<?php

namespace mecadoapp\control;

use mecadoapp\model\Item as Item;
use mecadoapp\model\Liste as Liste;

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

	function viewSendMessage() {
		$message = new \mecadoapp\model\Message();
		$user = \mecadoapp\model\User::where('username', '=', $_SESSION['user_login'])->first();
		$message->description = filter_var($_POST['text'],FILTER_SANITIZE_SPECIAL_CHARS);
		$message->author = $user->id;
		$tweet->save();
		self::viewHome();
	}

	function viewMessages() {
		$messages = \mecadoapp\model\Message::orderBy('date_create', 'DESC')->limit(5)->get();

		$v = new \mecadoapp\view\MecadoView($messages);
		$v ->render('messages');
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

	function viewProfile() {
		$user = \mecadoapp\model\User::where('mail', '=', $_SESSION['user_login'])->first();
		$v = new \mecadoapp\view\MecadoView($user);		
		$v ->render('profile');
	}

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
		$list->url = bin2hex(random_bytes(5));
		$list->save();
		self::viewHome();
	}

	function viewAffichageList(){
		$v = new \mecadoapp\view\MecadoView('');		
		$v ->render('affichage_list');
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
		$v-> render('ajout_item');
	}

	function viewSaveItem(){
		//enregistre l'item dans la bdd et renvoie sur la meme page /ajoutitem/
		
		$cadeau = new Item;
		$cadeau->nom = $_POST['nom'];
		$cadeau->description = $_POST['description'];
		$cadeau->image = $_POST['image'];
		$cadeau->url = $_POST['url'];
		$cadeau->tarif = $_POST['tarif'];
		$cadeau->save();

		self::viewAjoutItem();

	}

	function viewReserve(){
		Item::where('id', $_POST['id'])
			->update(['reserviste' => $_POST['reserviste'],'reserver' => 1]);
		
		if($_POST['message']!=NULL){
			$m = new \mecadoapp\model\Message;
			$m->auteur = $_POST['reserviste'];
			$m->description = $_POST['message'];
			$m->type = 0;
			$m->date_create = date("Y/m/d");
			$m->id_Liste = $_SESSION['liste'];
			$m->save();
		}
		self::viewHome();
	}
}