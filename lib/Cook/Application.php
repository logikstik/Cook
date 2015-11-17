<?php
/**
 * Application.php
 *
 * @category Cook
 * @package Application
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

use Cook\Config as Config;
use Cook\Router as Router;

/**
 * Préparer les différentes inclusions avant de lancer l'application
 *
 * @category Cook
 * @package Application
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class Application
{	
	/**
	 * Chargement des classes nécessaire à l'application
	 *
	 * @return void
	 */
	public function dispatch()
	{
		// Config
		$path_config = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .'config'. DIRECTORY_SEPARATOR;
		$config = new Config();
		$config->setConfig($path_config .'config.json');
		
		// Router
		$uri = strtolower($_SERVER['REQUEST_URI']);
		$router = Router::instance();
		$router->addRule($path_config .'routes.json');
		$router->dispatchRouter($uri);
	}
	
	/**
	 * Démarrage de l'application !
	 *
	 * @return void
	 */
	public function run()
	{
		$this->dispatch();
	}
}