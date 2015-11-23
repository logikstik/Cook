<?php
/**
 * Registry.php
 *
 * @category Cook
 * @package Registry
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

/**
 * Permet de passer des données dans tous les controllers.
 * Une sorte de Superglobales ;)
 *
 * @category Cook
 * @package Registry
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class Registry extends \ArrayObject
{
	/**
	 * Singleton
	 * @var Registry|null
	 */
	 private static $instance;

	 /**
	  * Le tableau du registre contenant les informations
	  * @var array
	  */
	 private $variables = array();
	 
	 /**
	  * Constructeur
	  */
	 public function __construct() {}
	 
	 /**
	  * Prevent cloning of the object: issues an E_USER_ERROR if this is attempted
	  */
	 public function __clone()
	 {
		 trigger_error( 'Cloning the registry is not permitted', E_USER_ERROR );
	 }
	 
	 /**
	  * Get the singleton instance
	  *
	  * @return Registry
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
		 if (!self::stored($name)) {
			 return false;
		 }
		 
		 $instance = self::instance();
		 return $instance->offsetGet($name);
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
		 $instance->offsetSet($name, $value);
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
         return self::$instance->offsetExists($name);
	 }
	 
	 /**
	  * Supprime une variable dans le registre statiquement
	  *
	  * @param   string  $name   Clé de la variable à supprimer
	  */
	 public static function remove($name)
	 {
		 $instance = self::instance();
		 $instance->offsetUnset($name);
	 }
	 
 	/**
 	 * Enregistre les données d'un fichier de configuration dans le registre
 	 *
 	 * @return bool\throw Exception 
 	 */
 	public static function setConfig($file)
 	{
 		if (file_exists($file)) {
 			$content = file_get_contents($file);
 			if ($content === false) {
 				throw new Exception('Impossible de lire le fichier de configuration');
 			}
            
 			$content_decode = json_decode($content);
 			if ($content_decode === null) {
 				throw new Exception('Impossible de lire le fichier de configuration (problème de syntaxe)');
 			}
			
 			foreach($content_decode as $key => $value) {
 				self::set($key, $value);
 			}

 			return true;
 		}
 		else {
 			throw new \Exception('Le fichier de configuration est inexistant !');
 		}
		
 		return false;
 	}
}