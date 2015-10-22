<?php
/**
 * Registry/Registry.php
 *
 * @category Cook
 * @package Registry
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook\Registry;

/**
 * Permet de passer des données dans tous les controllers.
 * Une sorte de Superglobales ;)
 *
 * @category Cook
 * @package Application
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class Registry
{
	/**
	 * Singleton
	 * @var Registry|null
	 */
	 private static $instance;

	 /**
	  * Les variables
	  * @var array
	  */
	 private $variables = array();
	 
	 /**
	  * Get the singleton instance
	  *
	  * @return Loader
	  */
	 public static function instance()
	 {
		 if (self::$instance == null) {
			 self::$instance = new self;
		 }
		 
		 return self::$instance;
	 }
	 
	 /**
	  * Retourne une variable stockée dans le registre
	  *
	  * @param   string   $name   Clé de la variable à retourner
	  * @return  mixed|null		  Null si la clé n'est pas trouvée
	  */
	 public function __get($name)
	 {
		 if (!array_key_exists($name, $this->variables)) {
			 return null;
		 }
		 
		 return $this->variables[$name];
	 }
	 
	 /**
	  * Stocke une variable dans le registre
	  *
	  * @param   string  $name   Clé de la variable à stocker
	  * @param   mixed   $value  Valeur à stocker
	  */
	 public function __set($name, $value)
	 {
		 $this->variables[$name] = $value;
	 }
	 
	 /**
	  * Vérifie l'existance d'une variable dans le registre
	  *
	  * @param   string  $name   Clé de la variable à vérifier
	  * @return  bool    		 Si une variable a été stockée
	  */
	 public function __isset($name)
	 {
		 return isset($this->variables[$name]);
	 }
	 
	 /**
	  * Supprimer une variable du registre
	  *
	  * @param string  $name   Clé de la variable à supprimer
	  */
	 public function __unset($name)
	 {
		 unset($this->variables[$name]);
	 }
	 
	 /**
 	  * Retourne une variable du registre statiquement
	  *
	  * @param   string  $name   Clé de la variable à retourner
	  * @return  mixed|null  	 Null si la clé n'est pas trouvée
	  */
	 public static function get($name)
	 {
		 $instance = self::instance();
		 return $instance->$name;
	 }
	 
	 /**
	  * Stocke une variable dans le registre statiquement
	  *
	  * @param   string  $name   Clé de la variable à stocker
	  * @param   mixed   $value  Valeur à stocker
	  */
	 public static function set($name, $value)
	 {
		 $instance = self::instance();
		 $instance->$name = $value;
	 }
	 
	 /**
	  * Vérifie l'existence d'une variable dans le 
	  * registre statiquement
	  *
	  * @param   string  $name   Clé de la variable à vérifier
	  * @return  bool    		 Si une variable a été stockée
	  */
	 public static function stored($name)
	 {
		 $instance = self::instance();
		 return isset($instance->$name);
	 }
	 
	 /**
	  * Supprime une variable dans le registre statiquement
	  *
	  * @param   string  $name   Clé de la variable à supprimer
	  */
	 public static function remove($name)
	 {
		 $instance = self::instance();
		 unset($instance->$name);
	 }
}