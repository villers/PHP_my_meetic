<?php

// defini l'heure du serveur
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, "fr_FR");

define('DS', DIRECTORY_SEPARATOR);
//define('SYS', __DIR__.DS.'system'.DS);
define('APP', __DIR__.DS.'application'.DS);

// Autoloader
spl_autoload_register(function( $class ) {
	$classFile = str_replace('\\', DS, $class);
	$classPI = pathinfo($classFile);
	// $classPI  ex: [dirname] => system [basename] => Config [filename] => Config
	$filename = strtolower($classPI[ 'dirname' ] . DS . $classPI[ 'filename' ] . '.php');

	if(file_exists($filename))
		include_once($filename);
});


// Charge la configuration du site.
system\Config::load();

// Initialisation de la session
system\Session::init();


// Cree une instance du router
$router = new system\Router();

// Si la varriable path_info existe
if(isset($_SERVER['PATH_INFO']))
	// charge la route en fonction de l'url
	$router->pathRoute( $_SERVER['PATH_INFO'] );
else
	// Charge la route par défaut (config/application.php)
	$router->defaultRoute();

// Charge le routeur
$router->launch();


// Si une instance de view
if(!is_null($view = system\View::getInstance()))
	// On execute la method launch
	$view->launch();