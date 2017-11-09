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

$router->addRoute('maison', '/home/', '\mecadoapp\control\MecadoController', 'viewHome', mecadoapp\auth\MecadoAuthentification::ACCESS_LEVEL_NONE);

$router->addRoute('default', 'DEFAULT_ROUTE',  '\mecadoapp\control\MecadoController', 'viewHome', mecadoapp\auth\MecadoAuthentification::ACCESS_LEVEL_NONE);

$router->addRoute('post', '/post/',  '\mecadoapp\control\MecadoController', 'viewPost', mecadoapp\auth\MecadoAuthentification::ACCESS_LEVEL_NONE);

$router->addRoute('login', '/login/',  '\mecadoapp\control\MecadoController', 'viewLogin', mecadoapp\auth\MecadoAuthentification::ACCESS_LEVEL_NONE);

$router->addRoute('check_login', '/check_login/',  '\mecadoapp\control\MecadoController', 'viewCheckLogin', mecadoapp\auth\MecadoAuthentification::ACCESS_LEVEL_NONE);

$router->addRoute('check_signup', '/check_signup/',  '\mecadoapp\control\MecadoController', 'viewCreateUser',mecadoapp\auth\MecadoAuthentification::ACCESS_LEVEL_NONE);

$router->addRoute('signup', '/signup/',  '\mecadoapp\control\MecadoController', 'viewSignUp',mecadoapp\auth\MecadoAuthentification::ACCESS_LEVEL_NONE);

$router->addRoute('logout', '/logout/',  '\mecadoapp\control\MecadoController', 'viewlogout',mecadoapp\auth\MecadoAuthentification::ACCESS_LEVEL_USER);

$router->addRoute('send', '/send/',  '\mecadoapp\control\MecadoController', 'viewSendMessage',mecadoapp\auth\MecadoAuthentification::ACCESS_LEVEL_NONE);

$router->addRoute('messages', '/messages/',  '\mecadoapp\control\MecadoController', 'viewMessages',mecadoapp\auth\MecadoAuthentification::ACCESS_LEVEL_NONE);

$router->addRoute('createlist', '/createlist/',  '\mecadoapp\control\MecadoController', 'viewCreateList',mecadoapp\auth\MecadoAuthentification::ACCESS_LEVEL_USER);

$router->addRoute('createurl', '/createurl/',  '\mecadoapp\control\MecadoController', 'viewCreateUrl',mecadoapp\auth\MecadoAuthentification::ACCESS_LEVEL_USER);

$router->addRoute('profile', '/profile/',  '\mecadoapp\control\MecadoController', 'viewProfile',mecadoapp\auth\MecadoAuthentification::ACCESS_LEVEL_USER);

$router->addRoute('check_createlist', '/check_createlist/',  '\mecadoapp\control\MecadoController', 'viewCheckCreateList',mecadoapp\auth\MecadoAuthentification::ACCESS_LEVEL_USER);

$router->addRoute('ajout_item', '/ajoutitem/',  '\mecadoapp\control\MecadoController', 'viewAjoutItem',mecadoapp\auth\MecadoAuthentification::ACCESS_LEVEL_USER);

$router->addRoute('affichage_list', '/affichagelist/',  '\mecadoapp\control\MecadoController', 'viewAffichageList',mecadoapp\auth\MecadoAuthentification::ACCESS_LEVEL_NONE);

$router->addRoute('save_item','/saveitem/', 'mecadoapp\control\MecadoController','viewSaveItem',mecadoapp\auth\MecadoAuthentification::ACCESS_LEVEL_USER);

$router->addRoute('reserve','/reserve/', '\mecadoapp\control\MecadoController', 'viewReserve',mecadoapp\auth\MecadoAuthentification::ACCESS_LEVEL_NONE);

$router->run();