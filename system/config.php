<?php
namespace system;

class Config {

	public static $application = array();
	public static $database    = array();

	public static function load()
	{
		self::$application = require APP.'config'.DS.'application.php';
		self::$database    = require APP.'config'.DS.'database.php';
	}

}