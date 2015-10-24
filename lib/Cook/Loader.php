<?php
/**
 * Loader.php
 *
 * @category Cook
 * @package Loader
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

/**
 * Permet de charger les fichiers des classes automatiquement
 *
 * @category Cook
 * @package Loader
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class Loader
{
	/**
	 * Modifie la valeur de la directive de configuration include_path
	 * et enregistre une fonction pour inclure automatiquement 
	 * les classes PHP dans le framework
	 *
	 * @return void
	 */
	public function __construct()
	{
		set_include_path(
	        get_include_path() . PATH_SEPARATOR . implode(
	            PATH_SEPARATOR,
				array(
					$_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .'lib',
					$_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .'app'
				)
	        )
	    );
		
		spl_autoload_register(function($class) {
		    $namespace = null;
			$file  = null;
		    $class = ltrim($class, '\\');
			
		    if ($last = strrpos($class, '\\')) {
		        $namespace = substr($class, 0, $last);
		        $class = substr($class, $last + 1);
		        $file  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		    }
			
		    $file .= str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
			$paths = explode(PATH_SEPARATOR, get_include_path());
			
			foreach($paths as $path) {
				$fullpath = $path . DIRECTORY_SEPARATOR . $file;
				
				if (file_exists($fullpath)) {
					include_once $file;
					break;
				}
			}
		});
	}
}