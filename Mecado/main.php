<?php
session_start();

/* pour le chargement automatique des classes dans vendor */
require_once 'vendor/autoload.php';
require_once 'src/mf/utils/ClassLoader.php';

$loader = new \mf\utils\ClassLoader("src");
$loader -> register();

$config = parse_ini_file("conf\bdd.ini");

$db = new Illuminate\Database\Capsule\Manager();

$db->addConnection( $config );
$db->setAsGlobal();
$db->bootEloquent();