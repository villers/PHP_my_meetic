<?php

return array(

	// Environement ['development', 'production']
	'environment' => 'developments',

	// Chemin du site
	'base_url' => 'http://localhost/rendu/PHP_my_meetic/',
	'assets' => 'public/',

	// Nom du site
	'site_name' => 'My Meetic',

	'nbr_ligne_pagination' => 25,

	// Route par défaut
	'default_route' => array(
		'controller' => 'accueil',
		'method'     => 'index'
	),

);
