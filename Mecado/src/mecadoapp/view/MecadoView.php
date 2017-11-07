<?php

namespace mecadoapp\view;

class MecadoView extends \mf\view\AbstractView {
  
	public function __construct( $data ){
		parent::__construct($data);
	}

	private function renderHeader(){
		return '<h1><img alt="Logo" src="/Mecado/img/logo.png"></h1>';
	}

	private function renderNav(){
		$linkhome=$this->script_name."/home/";
		$log = new \mecadoapp\auth\MecadoAuthentification();
		if ($log->logged_in) {
			$nav = <<<EOT
			<nav>
				<a href='$linkhome'>Accueil</a>
				<a href='#'>Inscription</a>
				<a href='#'>Connexion</a>	
			</nav>
EOT;
		}else{
			$nav = <<<EOT
				<nav>
					<a href='$linkhome'>Accueil</a>
					<a href='#'>Se déconnecter</a>
					<a href='#'>Mon Profil</a>
				</nav>
EOT;
		}
		return $nav;
	}
	
	private function renderFooter(){
		return 'Application développée par le groupe Bernier Charles Painteaux Saint-Dizier Varnerot &copy;2017';
	}

	private function renderSignUp(){
		
		$signup = <<<EOT
			<article>
				<h2>Créez votre compte</h2>
				<form action='$this->script_name/check_signup/' method='post'>
					<input name='fullname' placeholder='Nom' type='text'>
					<input name='name' placeholder='Prénom' type='text'>
					<input name='mail' placeholder='E-mail' type='text'>
					<input name='password' placeholder='Mot de passe' type='password'>
					<button name='signup_button' type='submit'>S'inscrire</button>
				</form>
				<h2>Vous avez déjà un compte ?</h2>
				<h2><a href='#'>Connectez-vous ! </a></h2>
			</article>

EOT;

		return $signup;
	}

	private function renderPost(){
		$post = <<<EOT
			<article>
				<form class='forms' action='$this->script_name/send/' method='post'>
					<textarea id='tweet-form' name='text' placeholder='Entrez un tweet...' maxlength='140'></textarea>
					<div>
						<input id='send-button' name='send_button' type='submit' value='Envoyer'>
					<div>
				</form>
			</article>

EOT;

		return $post;
	}

	private function renderLogin(){
		$login = <<<EOT
			<article>
				<form class='forms' action='$this->script_name/check_login/' method='post'>
					<input class='forms-text' name='username' placeholder='Pseudo' type='text'>
					<input class='forms-text' name='password' placeholder='Mot de passe' type='password'>
					<button class='forms-button' name='login_button' type='submit'>Se connecter</button>
				</form>
			</article>

EOT;

		return $login;
	}

	private function renderHome(){ 
		if ($log->logged_in) {
			$home="<article><h2>Bienvenue sur Mecado.net</h2>";
			$home.= <<<EOT
				<div>
					<p>Ce site vous propose la création d'une liste de cadeau pour vous ou un proche</p>
					<p><a href='#'>Créez votre liste de cadeau</a></p>
				</div>
EOT;
		}else{
			$home="<article><h2>Bienvenue sur Mecado.net</h2>";
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

			default:
				$main = $this->renderHome();
				break;
		}

		$html = <<<EOT
		<header>
			${header}
			${nav}
		</header>
		<section>
			${main}
		</section>
		<footer>
			${footer}
		</footer>
EOT;
		return $html;
		
	}

}