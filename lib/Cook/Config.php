<?php
/**
 * Config.php
 *
 * @category Cook
 * @package Config
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

use Cook\Registry as Registry;
use Cook\Exception as Exception;

/**
 * Charge le fichier de configuration pour être accessible
 * dans toute l'application
 * Le fichier doit se trouver le dossier "config" à la racine 
 * de l'application et se nommer "config.json"
 *
 * @category Cook
 * @package Config
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class Config extends Registry
{	
	/**
	 * Singleton
	 * @var Registry|null
	 */
	private $registry;
	
	/**
	 * Constructeur
	 * Instancie le registre
	 */
	public function __construct()
	{
		$this->registry = parent::instance();
	}
	
	/**
	 * Enregistre les données du fichier de configuration dans le registre
	 *
	 * @return bool\throw Exception 
	 */
	public function setConfig()
	{
		$config = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .'config'. DIRECTORY_SEPARATOR .'config.json';
		if (file_exists($config)) {
			$config = file_get_contents($config);
			if ($config === false) {
				throw new \Exception('Impossible de lire le fichier de configuration');
			}
            
			$config = json_decode($config);
			if ($config === null) {
				throw new \Exception('Impossible de lire le fichier de configuration (problème de syntaxe)');
			}
			
			foreach($config as $key => $value) {
				$this->registry->set($key, $value);
			}
			
			if ($this->registry->stored('debug')) {
				return $this->registry->get('debug'); 
			}

			return false;
		}
		else {
			throw new \Exception('Le fichier de configuration est inexistant !');
		}
		
		return false;
	}
}