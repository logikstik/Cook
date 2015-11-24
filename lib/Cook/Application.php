<?php
/**
 * Application.php
 *
 * @category Cook
 * @package Application
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

use Cook\Locale as Locale;
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
	 * Chargement des classes nécessaire à l'application
	 *
	 * @return void
	 */
	private function dispatch()
	{		
		// Path
		$path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .'config'. DIRECTORY_SEPARATOR;
		
		// Registry
		Registry::setConfig($path .'routes.json');
		Registry::setConfig($path .'locales.json');
		
		// Locale
		$lang = Registry::get('locales');
		$language = (!isset($_COOKIE['COOK_LANGUAGE'])) ? $lang->defaultLocale : $_COOKIE['COOK_LANGUAGE'];
		$locale = Locale::instance();
		$locale->setLanguage($language);
		$locale->loadDomain('messages', 'app/locales', true);
		
		// Router
		$router = Router::instance();
		$router->setRoute(strtolower($_SERVER['REQUEST_URI']));
		$router->addRules(Registry::get('routes'));
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