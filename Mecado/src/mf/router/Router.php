<?php
/**
* 
*/
namespace mf\router;

class Router extends AbstractRouter 
{

	function addRoute($name, $url, $ctrl, $mth, $level) {
		self::$routes[$url]=[ $ctrl, $mth, $level];
		self::$routes[$name]=[ $ctrl, $mth, $level];
	}

	function run() {
		$auth=new \mecadoapp\auth\MecadoAuthentification();
		$chemin = self::$routes[$this->http_req->path_info];
		if (!is_null($chemin) && $auth->checkAccessRight($chemin[2])) {
			$obj = new $chemin[0]();
			$fonc=$chemin[1];
			$obj->$fonc();
		}else{ 
			$obj = new self::$routes["DEFAULT_ROUTE"][0]();
			$fonc=self::$routes["DEFAULT_ROUTE"][1];
			$obj->$fonc();
		}
	}
}