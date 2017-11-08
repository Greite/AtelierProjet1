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
		$log = new \mecadoapp\auth\MecadoAuthentification();
		if ($log->logged_in) {
			$nav = <<<EOT
				<nav class='navbar'>
				<ul>
					<li><a href='$linkhome'>Accueil</a></li>
					<li><a href='$linklogout'>Se déconnecter</a></li>
					<li><a href='#'>Mon Profil</a></li>
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

	private function renderCreateList(){
		$list = <<<EOT
			<article>
				<h2>Créez votre liste : </h2>
				<form class='forms' action='$this->script_name/createlist/' method='post'>
					<input name='titre' placeholder='Titre' type='text'>
					<input name='desc' placeholder='Description' type='text'>
					<input name='validite' placeholder='Date de validité' type='text'>
					<input name='autre' placeholder='Autre personne' type='text'>
					<div>
						<input id='send-button' name='send_button' type='submit' value='Envoyer'>
					<div>
				</form>
			</article>

EOT;

return $list;

	}


	private function renderAffichageList(){

			$list = <<<EOT
			<article>
				<h2>Votre liste </h2>
				<ul>
				<li>aaaaaaa</li>
				<li>bbbbbbb</li>
				<li>ccccccc</li>
				</ul>
			</article>

EOT;

return $list;
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

	private function renderHome(){
		$home="<article><h2>Bienvenue sur Mecado.net</h2>";
		if ($log->logged_in) {

			$home.= <<<EOT
				<div>
					<p>Ce site vous propose la création d'une liste de cadeau pour vous ou un proche</p>
					<p><a href='#'>Créez votre liste de cadeau</a></p>
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

			case 'affichagelist':
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