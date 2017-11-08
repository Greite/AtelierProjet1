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
	}

	private function renderProfile(){
		$profile = "<article>";
		$nom = $this->data->nom;
		$prenom = $this->data->prenom;
		$mail = $this->data->mail;
		$userlists = $this->data->liste()->orderBy('date_limite', 'DESC')->get();

		$profile .= <<<EOT
				<h2>Profil</h2>	
				<ul>
					<li>Nom : $nom</li>
					<li>Prénom : $prenom</li>
					<li>Mail : $mail</li>
					<li>Listes : </li>
					<ul>
EOT;
		foreach ($userlists as $key => $value) {
			$urllist = $value->url;
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
						<span>Titre : </span>
						<input name='titre' placeholder='Titre' type='text'>
						<span>Description : </span>
						<input name='desc' placeholder='Description' type='text'>
						<span>Date de validité : </span>
						<input name='validite' placeholder='AAAA-MM-JJ' type='text'>
						<span>Liste destinée à une autre personne : </span>
						<input name='for_him' type='checkbox' value='1'>
						<span>Prénom du destinataire : </span>
						<input name='destinataire' placeholder='Prénom du destinataire' type='text'>
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
			if($_GET['nom']==NULL||$_GET['id']==NULL){
				throw new \Exception("URL invalide");
			}else{
				$l=\mecadoapp\model\Liste::where([['destinataire', '=', $_GET['nom']],['id','=', $_GET['id']]])->first();
				if($l!=NULL){
					//$i=\mecadoapp\model\Liste;
					$i=$l->items()->get();			
					var_dump('marche');
					$liste= <<<EOT
					<article>
						<div>$l->titre</div><br>
						<div>$l->description</div><br>
						<div>$l->date_limite</div><br>
						<div>$l->destinataire</div>
					</article>
EOT;
					foreach($i as $d){
						$liste.= <<<EOT
						<div></div>
						<div>$d->tarif</div>
EOT;
					}
					


return $liste;
				}else{
					var_dump('marchepas');
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

		echo $this->app_root;

		$ajoutItem = <<<EOT
					<article>
						<form action ='$this->script_name//' method='post'>
							<input name='nom' placeholder='Nom' type='text'>
							<input name='description' placeholder='Description' type='textarea'>
							<input name='img' placeholder='Image' type='text'>
							<input name='url' placeholder='URL' type='text'>
							<input name='tarif' placeholder='Tarif' type='text'>
							<a href="ajoutitem"><img src="$this->app_root/img/plus.jpg" height="20" width="20"><a>
							<input type="submit" name="Envoyer">
						</form>
					</article>
EOT;
		return $ajoutItem;
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

	private function renderCreateUrl(){

	$bytes = random_bytes(5);
	$bytes = bin2hex($bytes);

	$list = <<<EOT
	<div>$bytes</div>
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