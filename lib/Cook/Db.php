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
	private $db;

	/**
	 * Constructeur
	 */
	public function __construct()
	{
		$path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .'config'. DIRECTORY_SEPARATOR;
		Registry::setConfig($path .'db.json');
		$this->db = Registry::get('db');
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
					'mysql:host='. $this->db->host .';dbname='. $this->db->dbname, 
					$this->db->user, 
					$this->db->pass, 
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
}