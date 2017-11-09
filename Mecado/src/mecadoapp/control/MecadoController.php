<?php

namespace mecadoapp\control;

use mecadoapp\model\Item as Item;

use mecadoapp\model\User as User;

use mecadoapp\view\MecadoView as MecadoView;

use mecadoapp\model\Liste as Liste;

class MecadoController extends \mf\control\AbstractController {

	function __construct(){
		parent::__construct();
	}

	function viewHome(){

		$v = new MecadoView('');
		$v ->render('home');  
	}

	function viewPost(){
		$v = new MecadoView('');
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

		$v = new MecadoView($messages);
		$v ->render('messages');
	}

	function viewSignUp(){
		$v = new MecadoView('');
		$v ->render('signup');
	}

	function viewLogin(){
		$v = new MecadoView('');
		$v ->render('login');  
	}

	function viewCreateUser() {
		$v = new \mecadoapp\auth\MecadoAuthentification();
		$v->createUser($_POST['mail'], $_POST['password'], $_POST['nom'], $_POST['prenom']);
		self::viewHome();
	}

	function viewCreateList() {
		$v = new MecadoView('');		
		$v ->render('createlist');
	}

	function viewProfile() {
		$user = \mecadoapp\model\User::where('mail', '=', $_SESSION['user_login'])->first();
		$v = new MecadoView($user);		
		$v ->render('profile');
	}

	function viewCheckCreateList() {
		$list = new \mecadoapp\model\Liste();
		$user = \mecadoapp\model\User::where('mail', '=', $_SESSION['user_login'])->first();
		$list->titre = filter_var($_POST['titre'],FILTER_SANITIZE_SPECIAL_CHARS);
		$list->description = filter_var($_POST['desc'],FILTER_SANITIZE_SPECIAL_CHARS);
		$list->date_limite = $_POST['validite'];
		$list->destinataire = filter_var($_POST['destinataire'],FILTER_SANITIZE_SPECIAL_CHARS);
		if ($_POST['for_other']) {
			$list->for_other = $_POST['for_other'];
		}else{
			$list->for_other = 0;
		}
		$list->id_user = $user->id;
		$list->url = bin2hex(random_bytes(5));
		$list->save();
		self::viewHome();
	}

	function viewAffichageList(){
		$v = new MecadoView('');		
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
		$list = \mecadoapp\model\Liste::select()->where('url', '=', $this->request->get["id"])->first();
		$itm = Item::select()->WHERE("id_liste","=",$list->id)->get();
		$listeItem = new MecadoView($itm);

		$v = new MecadoView('');
		$v-> render('ajout_item');
	}

	function viewSaveItem(){

		$liste = new \mecadoapp\model\Liste();
		$list = \mecadoapp\model\Liste::where("url","=",$this->request->get["id"])->first();
		$cadeau = new Item;

		if(empty($_POST['nom']) || empty($_POST['description']) || empty($_POST['tarif'])){
			echo "tamer";
		}
		else{
			$cadeau->nom = filter_var($_POST['nom'],FILTER_SANITIZE_SPECIAL_CHARS);
			$cadeau->description = filter_var($_POST['description'],FILTER_SANITIZE_SPECIAL_CHARS);
			if ($_POST['image'] == "") {
				$cadeau->image = NULL;
			}else{
				$cadeau->image = filter_var($_POST['image'],FILTER_SANITIZE_SPECIAL_CHARS);
			}
			if ($_POST['url'] == "") {
				$cadeau->url = NULL;
			}
			else{
				$cadeau->url = filter_var($_POST['url'],FILTER_SANITIZE_SPECIAL_CHARS); 
			}
			$cadeau->tarif = filter_var($_POST['tarif'],FILTER_SANITIZE_SPECIAL_CHARS); 
			$cadeau->id_liste = $list->id;
			$cadeau->save();
		}
		self::viewAffichageList();

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
		self::viewAffichageList();
	}
}