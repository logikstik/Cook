<?php
/**
 * Loader.php
 *
 * @package Loader
 * @copyright 2015, Cook
 */

namespace Cook;

/**
 * Permet de charger les fichiers des classes automatiquement
 *
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class Loader
{
	/**
	 * Modifie la valeur de la directive de configuration include_path
	 *
	 * @return void
	 */
	public function __construct()
	{
	    set_include_path(
	        get_include_path() . PATH_SEPARATOR . implode(
	            PATH_SEPARATOR,
				array(
					'./lib',
					'./app'
				)
	        )
	    );
		
		$this->autoload();
	}
	
	/**
	 * Enregistre la fonction spl_autoload()
	 *
	 * @return void
	 */	
	private function autoload()
	{
		if (function_exists('__autoload')) {
			spl_autoload_register('__autoload', false);
		}

		spl_autoload_register('spl_autoload', false);
	}
}