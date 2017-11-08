<?php
session_start();

/* pour le chargement automatique des classes dans vendor */
require_once 'vendor/autoload.php';
require_once 'src/mf/utils/ClassLoader.php';

$loader = new \mf\utils\ClassLoader("src");
$loader -> register();

use mecadoapp\model\Item as Item;
use \mecadoapp\view\MecadoView as MecadoView;
use \mf\router\Router as Router;

$config = parse_ini_file("conf/bdd.ini");

$db = new Illuminate\Database\Capsule\Manager();

$db->addConnection( $config );
$db->setAsGlobal();
$db->bootEloquent();

MecadoView::setStyleSheet(['framework_css/css/framework.css']);
MecadoView::setAppTitle('Mecado');


$router = new Router();

$router->addRoute('maison', '/home/', '\mecadoapp\control\MecadoController', 'viewHome');

$router->addRoute('default', 'DEFAULT_ROUTE',  '\mecadoapp\control\MecadoController', 'viewHome');

$router->addRoute('post', '/post/',  '\mecadoapp\control\MecadoController', 'viewPost');

$router->addRoute('login', '/login/',  '\mecadoapp\control\MecadoController', 'viewLogin');

$router->addRoute('check_login', '/check_login/',  '\mecadoapp\control\MecadoController', 'viewCheckLogin');

$router->addRoute('check_signup', '/check_signup/',  '\mecadoapp\control\MecadoController', 'viewCreateUser');

$router->addRoute('signup', '/signup/',  '\mecadoapp\control\MecadoController', 'viewSignUp');

$router->addRoute('logout', '/logout/',  '\mecadoapp\control\MecadoController', 'viewlogout');

$router->addRoute('send', '/send/',  '\mecadoapp\control\MecadoController', 'viewSend');

$router->addRoute('createlist', '/createlist/',  '\mecadoapp\control\MecadoController', 'viewCreateList');

$router->addRoute('profile', '/profile/',  '\mecadoapp\control\MecadoController', 'viewProfile');

$router->addRoute('check_createlist', '/check_createlist/',  '\mecadoapp\control\MecadoController', 'viewCheckCreateList');

$router->addRoute('ajout_item', '/ajoutitem/',  '\mecadoapp\control\MecadoController', 'viewAjoutItem');

$router->addRoute('affichage_list', '/affichagelist/',  '\mecadoapp\control\MecadoController', 'viewAffichageList');

$router->run();