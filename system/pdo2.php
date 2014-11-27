<?php
namespace system;
use PDO;
use PDOException;

class Pdo2
{
	// variable statique de l'instace de la pdo
	private static $instance;

	// Permet de recuperer l'instance PDO
	public static function getInstance()
	{
		if (!isset(self::$instance))
		{
			try
			{
				$info = Config::$database;
				self::$instance = new PDO( $info['driver'].":dbname=". $info['database'].";host=". $info['host'], $info['user'], $info['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'));
				self::$instance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				if(Config::$application['environment'] == "development")
					die('Connection failed: '. $e->getMessage());
				else
					die('Impossible de se connecter à la base de donnée');
			}
		}

		return self::$instance;
	}
}