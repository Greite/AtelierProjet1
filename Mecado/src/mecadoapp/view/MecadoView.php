<?php

namespace mecadoapp\view;

class MecadoView extends \mf\view\AbstractView {
  
	public function __construct( $data ){
		parent::__construct($data);
	}

	private function renderHeader(){
		return '<h1><img alt="Logo" src="/AtelierProjet1/Mecado/img/logo.png"></h1>';
	}

	private function renderNav(){
		$linkhome=$this->script_name."/home/";
		$linklogin=$this->script_name."/login/";
		$linksignup=$this->script_name."/signup/";
		$linklogout=$this->script_name."/logout/";
		$linkprofile=$this->script_name."/profile/";
		$log = new \mecadoapp\auth\MecadoAuthentification();
		if ($log->logged_in) {
			$nav = <<<EOT
				<nav class='navbar'>
				<ul>
					<li><a href='$linkhome'>Accueil</a></li>
					<li><a href='$linklogout'>Se déconnecter</a></li>
					<li><a href='$linkprofile'>Mon Profil</a></li>
				</ul>
				</nav>
EOT;
		}else{
			$nav = <<<EOT
			<nav class='navbar'>
			<ul>
				<li><a href='$linkhome'>Accueil</a></li>
				<li><a href='$linksignup'>Inscription</a></li>
				<li><a href='$linklogin'>Connexion</a></li>
			</ul>
			</nav>
EOT;
		}
		return $nav;
	}
	
	private function renderFooter(){
		return 'Application développée par le groupe Bernier Charles Painteaux Saint-Dizier Varnerot &copy;2017';
	}

	private function renderSignUp(){
		$linklogin=$this->script_name."/login/";
		$signup = <<<EOT
			<article>
				<h2>Créez votre compte</h2>
				<form action='$this->script_name/check_signup/' method='post'>
					<input name='nom' placeholder='Nom' type='text'>
					<input name='prenom' placeholder='Prénom' type='text'>
					<input name='mail' placeholder='E-mail' type='text'>
					<input name='password' placeholder='Mot de passe' type='password'>
					<button name='signup_button' type='submit'>S'inscrire</button>
				</form>
				<h2>Vous avez déjà un compte ?</h2>
				<h2><a href='$linklogin'>Connectez-vous ! </a></h2>
			</article>

EOT;
	return $signup;
	}

	private function renderProfile(){
		$profile = "<article>";
		$nom = $this->data->nom;
		$prenom = $this->data->prenom;

		$mail = $this->data->mail;
		$userlists = $this->data->listes()->orderBy('date_limite', 'DESC')->get();
		$profile .= <<<EOT
				<h2>Profil</h2>	
				<ul>
					<li>Nom : $nom</li>
					<li>Prénom : $prenom</li>
					<li>Mail : $mail</li>
					<li>Listes : </li>
					<ul>
EOT;
		$userlists = $this->data->listes()->orderBy('date_limite', 'ASC')->get();
		foreach ($userlists as $key => $value) {
			$urllist = $this->script_name."/affichagelist/?id=".$value->url;
			$namelist = $value->titre;
			$profile .= <<<EOT
						<li><a href='$urllist'>$namelist</a></li>							
EOT;
		}
		$profile .= "</ul></ul></article>";
		return $profile;
	}

	private function renderCreateList(){
		$list = <<<EOT
			<article>
				<h2>Créez votre liste : </h2>
				<form action='$this->script_name/check_createlist/' method='post'>
					<div>
						<label>Titre : <input name='titre' placeholder='Titre' type='text'></label>
						<label>Description : <input name='desc' placeholder='Description' type='text'></label>
						<label>Date de validité : <input name='validite' placeholder='AAAA-MM-JJ' type='text'></label>
						<label>Liste destinée à une autre personne : <input name='for_other' type='checkbox' value='1'></label>
						<label>Prénom du destinataire : <input name='destinataire' placeholder='Prénom du destinataire' type='text'></label>
						<div>
							<input id='send-button' name='send_button' type='submit' value='Envoyer'>
						</div>
					</div>
				</form>
			</article>

EOT;
		return $list;
	}

	private function renderAffichageList(){
			$url = $_GET['id'];
			if(is_null($url)){
				throw new \Exception("URL invalide");
			}else{

				$l=\mecadoapp\model\Liste::where('url','=', $url)->first();

				if(!is_null($l)){
					$_SESSION['liste']=$l->id;
					$i=$l->items()->get();
					$liste= <<<EOT
					<article>
						<h1>$l->titre</h1>
						<label>Destinataire : <p>$l->destinataire</p></label>
						<label>Date limite : <p>$l->date_limite</p></label>
						<label>Description : <p>$l->description</p></label>
						<a href="$this->script_name/ajoutitem/?id=$url"><input type="button" name="Ajouter un item"></a>
					</article>
EOT;
					foreach($i as $d){
						$liste.= <<<EOT
						<article>
							<h2>$d->nom</h2>
							<span><h3>Prix : </h3><h3>$d->tarif €</h3></span>
							<label>Description : <p>$d->description</p></label>
EOT;
						if (!is_null($d->url)) {
							$liste.= <<<EOT
							<div><a href='$d->url' target = '_blank'>Lien du cadeau</a></div>
EOT;
						}
						$liste.= <<<EOT
						<div><img src='$d->image'></div>
						</article>
EOT;
						if ($l->for_other) {
							if($d->reserver==0){
							$liste.= <<<EOT
							<form action='$this->script_name/reserve/' method='post'>
								<label for="reserviste">Votre nom : </label>
								<input type="text" id="reserviste" name="reserviste">
								<label for="message">Laisser lui un message : </label>
								<input type="text" id="message" name="message">
								<input type="hidden" id="id" name="id" value="$d->id">
								<input type="submit" id="send" value="Réserver">
							</form>
EOT;
							}else{
								$liste.= <<<EOT
								<div>Réserver par $d->reserviste</div>							
EOT;
							}
						}
					}
				return $liste;
				}else{
					throw new \Exception("URL VIDE !");
				}
			}
	}

	private function renderLogin(){
		$login = <<<EOT
			<article>
				<form action='$this->script_name/check_login/' method='post'>
					<input name='mail' placeholder='E-mail' type='text'>
					<input name='password' placeholder='Mot de passe' type='password'>
					<button name='login_button' type='submit'>Se connecter</button>
				</form>
			</article>

EOT;

		return $login;
	}

	private function renderAjoutItem(){
		$url = $_GET['id'];
		$ajoutItem = "<article>";

		if(empty($this->data)){
			$ajoutItem .="<p> Il n'y a pas encore de cadeau !<p>";
		}

		else{
			foreach($this->data as $value){
						$ajoutItem .="
						<div>$value->nom</div>
						<div>$value->description</div>
						<div>$value->tarif</div>
						<div><a href='$value->url'>Petit lien au calme</a></div>
						<div><img src='$value->image'></div>
						<div></div>";
			}
		}			

		$ajoutItem .= <<<EOT
					
						<form action ='$this->script_name/saveitem/?id=$url' method='post'>
							<input name='nom' placeholder='Nom' type='text'>
							<input name='description' placeholder='Description' type='textarea'>
							<input name='image' placeholder='Image' type='text'>
							<input name='url' placeholder='URL' type='text'>
							<input name='tarif' placeholder='Tarif' type='text'>
							<input type="submit" name="Envoyer">
						</form>
					</article>
EOT;
		return $ajoutItem;
	}


	private function renderMessages() {
		$messages="<article><h2>Derniers messages</h2>";
		foreach ($this->data as $key => $value) {
			$author = $_POST['auteur'];
			$text=$value->description;
			$date=$value->date_create;
		   
			$messages .= <<<EOT
				<div>
					<label>$author</label><p>$text</p>
				</div>
EOT;
		}
		return $messages;
	}
	
	private function renderCheckedCreatedList(){
			$list = <<<EOT
			<article>
				<h2></h2>
				<ul>
				<li>aaaaaaa</li>
				<li>bbbbbbb</li>
				<li>ccccccc</li>
				</ul>
			</article>

EOT;
		return $list;
	}

	private function renderHome(){
		$home="<article><h2>Bienvenue sur Mecado.net</h2>";
		$log = new \mecadoapp\auth\MecadoAuthentification();
		$linkcreatelist = $this->script_name."/createlist/";
		if ($log->logged_in) {

			$home.= <<<EOT
				<div>
					<p>Ce site vous propose la création d'une liste de cadeau pour vous ou un proche</p>
					<p><a href='$linkcreatelist'>Créez votre liste de cadeau</a></p>
				</div>
EOT;
		}else{
			$home .= <<<EOT
				<div>
					<p>Ce site vous propose la création d'une liste de cadeau pour vous ou un proche</p>
					<p>Pour créer votre liste, connectez-vous ou alors créez vous un compte</p>
				</div>
EOT;
		}
		$home.="</article>";
		return $home;
	}

	protected function renderBody($selector=null){
		
		$header = $this->renderHeader();
		$nav = $this->renderNav();
		$footer = $this->renderFooter();
		switch ($selector) {
			case 'home':
				$main = $this->renderHome();
				break;

			case 'signup':
				$main = $this->renderSignUp();
				break;

			case 'login':
				$main = $this->renderLogin();
				break;

			case 'post':
				$main = $this->renderPost();
				break;

			case 'createlist':
				$main = $this->renderCreateList();
				break;

			case 'createurl':
				$main = $this->renderCreateUrl();
				break;

			case 'profile':
				$main = $this->renderProfile();
				break;

			case 'ajout_item':
				$main =$this->renderAjoutItem();
				break;

			case 'affichage_list':
				$main = $this->renderAffichageList();
				break;

			case 'messages':
				$main = $this->renderMessages();
				break;

			default:
				$main = $this->renderHome();
				break;
		}

		$html = <<<EOT
		<header>
			${header}
			${nav}
		</header>
		<section class='aligncenter'>
			${main}
		</section>
		<footer class='aligncenter'>
			${footer}
		</footer>
EOT;
		return $html;
		
	}

}