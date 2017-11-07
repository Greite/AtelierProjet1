<?php

namespace mf\utils;

class ClassLoader {

	private $prefix;

	public function __construct($var_prefix) {
		$this->prefix=$var_prefix;
	}

	public function loadClass($chaine) {
		$chaine = strtr($chaine,"\\", DIRECTORY_SEPARATOR);
		$chaine = $this->prefix.DIRECTORY_SEPARATOR.$chaine.".php";
		if (file_exists($chaine)) {
			require_once $chaine;
		}
	}

	public function register(){
		spl_autoload_register([$this,"loadClass"]);
	}
	
}



