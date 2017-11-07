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
		$linklogin=$this->script_name."/login/";
		$linksignup=$this->script_name."/signup/";
		$log = new \mecadoapp\auth\MecadoAuthentification();
		if ($log->logged_in) {
			$nav = <<<EOT
				<nav>
					<a href='$linkhome'>Accueil</a>
					<a href='#'>Se déconnecter</a>
					<a href='#'>Mon Profil</a>
				</nav>
EOT;
		}else{
			$nav = <<<EOT
			<nav>
				<a href='$linkhome'>Accueil</a>
				<a href='$linksignup'>Inscription</a>
				<a href='$linklogin'>Connexion</a>
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
					<input name='fullname' placeholder='Nom' type='text'>
					<input name='name' placeholder='Prénom' type='text'>
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

	private function renderFollowing(){
		$following = <<<EOT
			<article>
				<h2>Currently following</h2>
			</article>

EOT;

		return $following;
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
	
	private function renderUserTweets(){
		$user = "<article>";
		$fullname = $this->data->fullname;
		$username = $this->data->username;
		$followers = $this->data->followers;

		$user .= <<<EOT
			<h2>$fullname</h2>
			<h3>$username</h3>
			<h3>$followers</h3>
EOT;
		$usertweets = $this->data->tweets()->orderBy('updated_at', 'DESC')->get();
		foreach ($usertweets as $key => $value) {
			$text = $value->text;
			$author = $this->data->username;
			$date = $value->created_at;
			$linktweet=$this->script_name."/view/?id=$value->id";
			
			$user .= <<<EOT
				<div class='tweet'>
					<a class='tweet-text' href='$linktweet'>$text</a>
					<div class='tweet-footer'>
						<span class='tweet-author'>$author</span>
						<span class='tweet-timestamp'>$date</span>
					</div>
				</div>
EOT;
	   }
		$user.="</article>";
		return $user;
	}

	private function renderViewTweet(){  
		$view = "<article>";
		$tweetauthor = $this->data->author()->first();
		$text = $this->data->text;
		$author = $tweetauthor->username;
		$date = $this->data->created_at;
		$score = $this->data->score;
		$linkauthor=$this->script_name."/user/?id=".$this->data->author;
		
		$view .= <<<EOT
			<div class='tweet'>
				<p class='tweet-text'>$text</p>
				<div class='tweet-footer'>
					<span class='tweet-author'><a href='$linkauthor'>$author</a></span>
					<span class='tweet-timestamp'>$date</span>
				</div>
EOT;
		$log = new \tweeterapp\auth\TweeterAuthentification();
		if ($log->logged_in) {
			$view.= <<<EOT
						<div class='tweet-footer'>
							<hr>
							<span class='tweet-score tweet-control'>$score</span>
							<a class='tweet-control' href='#'>
								<img alt='Like' src='/tweeter/html/like.png'>
							</a>
							<a class='tweet-control' href='#'>
								<img alt='Dislike' src='/tweeter/html/dislike.png'>
							</a>
							<a class='tweet-control' href='#'>
								<img alt='Follow' src='/tweeter/html/follow.png'>
							</a>
						</div>
					</div>
EOT;
		}else{
			$view.= <<<EOT
				<div class='tweet-footer'>
					<hr>
					<span class='tweet-score tweet-control'>$score</span>
				</div>
			</div>
EOT;
		}
		$view.="</article>";
		return $view;
	}

	protected function renderBody($selector=null){
		
		$header = $this->renderHeader();
		$nav = $this->renderNav();
		$footer = $this->renderFooter();
		switch ($selector) {
			case 'home':
				$main = $this->renderHome();
				break;

			case 'user':
				$main = $this->renderUserTweets();
				break;

			case 'view':
				$main = $this->renderViewTweet();
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

			case 'following':
				$main = $this->renderFollowing();
				break;

			default:
				$main = $this->renderHome();
				break;
		}

		$html = <<<EOT
		<header class='theme-backcolor1'>
			${header}
			${nav}
		</header>
		<section class='theme-backcolor2'>
			${main}
		</section>
		<footer class='theme-backcolor1'>
			${footer}
		</footer>
EOT;
		return  $html;
		
	}

}