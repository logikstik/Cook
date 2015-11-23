<?php
/**
 * Db.php
 *
 * @category Cook
 * @package Db
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

use PDO;
use Cook\Registry as Registry;
use Cook\Exception as Exception;

/**
 * Initialise la connection à la base de données
 *
 * @category Cook
 * @package Db
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class Db
{
	/**
	 * Singleton
	 * @var Db\null
	 */
	private static $instance;
	
	/**
	 * Registry
	 * @var Registry
	 */
	private static $registry;

	/**
	 * Constructeur
	 */
	public function __construct()
	{
		$this->setRegistry(new Registry);
	}

	/**
	 * Get the singleton instance
	 *
	 * @return PDO
	 */
	public static function instance()
	{
		if (self::$instance == null) {
			try {
				self::$instance = new \PDO(
					'mysql:host='. self::$registry->db->host .';dbname='. self::$registry->db->dbname, 
					self::$registry->db->user, 
					self::$registry->db->pass, 
					array(
						PDO::ATTR_PERSISTENT => true, 
						PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
						PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
						PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
					)
				);
			}
			catch (Exception $e) {
				die('Connection error: ' . $e->getMessage() .'/'. $e->getFile() .'/'. $e->getLine());
			}
		}
		
		return self::$instance;
	}
	
 	/**
	 * Instancie le Registry
	 *
	 * @param   Cook\Registry    $registry   Registry
	 */
	public static function setRegistry(Registry $registry)
	{
		return self::$registry = $registry;
	}
}