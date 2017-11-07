<?php
session_start();

/* pour le chargement automatique des classes dans vendor */
require_once 'vendor/autoload.php';
require_once 'src/mf/utils/ClassLoader.php';

$loader = new \mf\utils\ClassLoader("src");
$loader -> register();

$config = [
       'driver'    => 'mysql',
       'host'      => 'localhost',
       'database'  => 'mecado',
       'username'  => 'root',
       'password'  => 'root',
       'charset'   => 'utf8',
       'collation' => 'utf8_unicode_ci',
       'prefix'    => '' ];

$db = new Illuminate\Database\Capsule\Manager();

$db->addConnection( $config );
$db->setAsGlobal();
$db->bootEloquent();

//MecadoView::setStyleSheet(['html/style.css']);
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

$router->run();