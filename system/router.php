<?php
namespace system;

class Router {

	// http://host/controller/method/[arg1,arg2, ...]
	// nom du controller défini par le router
	public $controller;

	// nom de la methode défini par le router
	public $method;

	// tableau contenant les arguments défini par le router
	public $args = array();

	public function __construct() { }

	// Définit le controller et la methode configuré dans le fichier de config
	public function defaultRoute()
	{
		$this->controller = Config::$application['default_route']['controller'];
		$this->method     = Config::$application['default_route']['method'];
	}

	// Définit le controller et la methode en fonction du PATH_INFO
	public function pathRoute($uri = '')
	{
		// Supprime les / en début et fin de $uri
		$parts = trim($uri, '/');

		// Explose l'uri
		$parts = explode('/', $parts);

		// recupère le controller
		$this->controller = array_shift($parts);

		// si la methode existe
		if(isset($parts[0]))
			// recupère la methode
			$this->method = array_shift($parts);

		else
			// sinon recupere la methode par defaut
			$this->method = 'index';

		// recupère les arguments qui sont contenus dans le reste de l'uri
		$this->args = $parts;
	}

	// Charge le controller en fonction de la route
	public function launch()
	{
		// Corrige le nom du controller.
		// ajoute le namespace et met la 1er lettre en majuscule
		$controller = "\\application\\controllers\\";
		$controller .= ucfirst($this->controller);

		// si la classe existe
		if(class_exists($controller))
			$controller = new $controller;

		// Si la class $controller n'existe pas
		else
		{
			// transformation en page d'erreur
			header("HTTP/1.0 404 Not Found");

			// alors le controller d'erreur est instancé
			$controller = new \application\controllers\Error;

			// appel la method index du controller d'erreur
			return $controller->index();
		}

		// Si la variable restfull est fause
		if(!$controller->restful)
			$method = "action_".$this->method;

		else
		{
			// alors peu être appelé par le type de request
			// ex: get_index(), post_index(), put_index() or delete_index()
			$method = strtolower($_SERVER['REQUEST_METHOD'])."_" .$this->method;
		}

		// Vérifie que la method existe dans le controller
		if(method_exists($controller, $method))
			// Appel la method du controller en lui passant des parametres
			return call_user_func_array(array($controller, $method),  array($this->args));

		else
		{
			// transformation en page d'erreur
			header("HTTP/1.0 404 Not Found");

			// alors le controller d'erreur est instancé
			$controller = new \application\controllers\Error;

			// appel la method index du controller d'erreur
			return $controller->index();
		}
	}

	public static function redirect($url)
	{
		header('location: '.$url);
		die();
	}
}