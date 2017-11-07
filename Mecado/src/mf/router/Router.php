<?php
/**
* 
*/
namespace mf\router;

class Router extends AbstractRouter 
{

	//Rajouter la vérif d'access level
	
	function addRoute($name, $url, $ctrl, $mth) {
		self::$routes[$url]=[ $ctrl, $mth];
		self::$routes[$name]=[ $ctrl, $mth];
	}

	function run() {
		if (!is_null($this->http_req->path_info)) {
			foreach (self::$routes as $key => $value) {
				if ($key == $this->http_req->path_info) {
					$obj = new $value[0]();
					$fonc=$value[1];
					$obj->$fonc();
				}
			}
		}else{ 
			foreach (self::$routes as $key => $value) {
				if ($key == "DEFAULT_ROUTE") {
					$obj = new $value[0]();
					$fonc=$value[1];
					$obj->$fonc();
				}
			}
		}
	}
}