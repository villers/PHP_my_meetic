<?php
namespace system;

class View{

	// Variable contenant l'url du fichier
	public $view_file;

	// Tableau contenant les varibles envoyé a la vue
	public $data;

	// Variable contenant l'instance de la vue
	private static $view = null;

	// Constructeur
	private function __construct(){  }

	// Method qui retourne l'instance de la vue
	public static function getInstance()
	{
		return self::$view;
	}

	// Instancie la class dans une variable statique
	// et configure l'objet view
	public static function make($view_file, $data = array())
	{
		if(is_null(self::$view))
			self::$view = new View;

		self::$view->view_file = $view_file;
		self::$view->data      = $data;
	}

	// Permet d'extraire les variables envoyé a l'objet view
	// Inclut le fichier de la vue
	public function launch()
	{
		// Extrait le tableau $this->data pour pouvoir etre utilisé comme un objet
		extract($this->data);

		// Convertit le chemin du fichier en remplasant les . par /
		$view_file = str_replace(".", DS, $this->view_file);

		// inclut une seul fois le fichier
		require_once (APP.'views'.DS.$view_file.'.php');
	}
}