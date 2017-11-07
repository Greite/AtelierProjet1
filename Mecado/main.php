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