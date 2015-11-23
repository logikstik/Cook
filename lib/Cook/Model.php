<?php
/**
 * Model.php
 *
 * @category Cook
 * @package Model
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

// use Cook\Registry as Registry;
use Cook\Db as Db;
// use Cook\Exception as Exception;

/**
 * Classes à charger pouvant être utiliser dans le Model
 *
 * @category Cook
 * @package Model
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class Model
{
	/**
	 * Db
	 * @var Db
	 */
	private static $db;
	
	/**
	 * Constructeur
	 * Instancie la connection à la base de données
	 */
	public function __construct()
	{
		$this->db = Db::instance();
		$this->db->beginTransaction();
	}
	
	/**
	 * Destructeur
	 */
	public function __destruct()
	{
		$this->db->commit();
	}
}