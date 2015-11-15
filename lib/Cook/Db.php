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
	 * Singleton
	 * @var Db\null
	 */
	private static $db;
	
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
	 * @return Db
	 */
	public static function instance()
	{
		if (self::$instance == null) {
			self::$instance = new self;
		}
		 
		return self::$instance;
	}

	/**
	 * Get the singleton instance
	 *
	 * @return PDO
	 */
	public static function init()
	{
		if (self::$db == null) {
			try {
				self::$db = new \PDO(
					'mysql:host='. self::$registry->get('db')->host .';dbname='. self::$registry->get('db')->dbname, 
					self::$registry->get('db')->user, 
					self::$registry->get('db')->pass, 
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
		
		return self::$db;
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