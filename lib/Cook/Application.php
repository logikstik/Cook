<?php
/**
 * Application.php
 *
 * @category Cook
 * @package Application
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

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
	 * Contient les paramètres de $_SERVER['REQUEST_URI']
	 * @var string
	 */
	private $uri;
	
	/**
	 * Contient le nom du controller et de l'action à charger par defaut
	 * @var array
	 */
	private $defaults = array(
		'controller' => 'index',
		'action' => 'index'
	);
	
	/**
	 * Prépare le nom du controller et l'action par défault
	 * avant de l'envoyer au Router()
	 *
	 * @param string 	$controller 	Controller à charger par défaut
	 * @param string 	$action 		Action à charger par défaut
	 * @return void
	 */
	public function __construct($controller = null, $action = null)
	{
		$this->uri = strtolower($_SERVER['REQUEST_URI']);
		$this->defaults['controller'] = (!empty($controller)) ? $controller : $this->defaults['controller'];
		$this->defaults['action'] = (!empty($action)) ? $action : $this->defaults['action'];
	}
	
	/**
	 * Chargement des classes nécessaire à l'application
	 *
	 * @return void
	 */
	public function dispatch()
	{
		// Config
		$config = new \Cook\Config();
		$debug = $config->setConfig();
		
		// Router
		$router = new \Cook\Router();
		$router->parseRoute($this->uri, $this->defaults);
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