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
		if (!is_null($this->http_req->path_info)) {
			foreach (self::$routes as $key => $value) {

				if ($key == $this->http_req->path_info) {
					if ($auth->checkAccessRight($value[2])){
						$obj = new $value[0]();
						$fonc=$value[1];
						$obj->$fonc();
					}
					else{ 
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
		}
		else{ 
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