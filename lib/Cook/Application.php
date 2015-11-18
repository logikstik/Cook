<?php
/**
 * Application.php
 *
 * @category Cook
 * @package Application
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

use Cook\View as View;
use Cook\Config as Config;
use Cook\Router as Router;
use Cook\Registry as Registry;
use Cook\Exception as Exception;

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
	 * Request
	 * @var Request
	 */
	private static $request;
	
	/**
	 * View
	 * @var View
	 */
	private static $view;
	
	/**
	 * Registry
	 * @var Registry
	 */
	private static $registry;
	
	/**
	 * Chargement des classes nécessaire à l'application
	 *
	 * @return void
	 */
	private function dispatch()
	{
		// Config
		$path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .'config'. DIRECTORY_SEPARATOR;
		$config = new Config();
		$config->setConfig($path .'config.json');
		
		// Router
		$route = strtolower($_SERVER['REQUEST_URI']);
		$router = Router::instance();
		$router->setRoute($route);
		$router->addRule($path .'routes.json');
		$router->dispatchRouter();
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