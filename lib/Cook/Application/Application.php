<?php
/**
 * Application/Application.php
 *
 * @category Cook
 * @package Application
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook\Application;

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
	 * @var $_route string
	 */
	protected $_route = null;
	
	/**
	 * Contient le nom du controller et de l'action à charger par defaut
	 * @var $_defaults array
	 */
	protected $_defaults = array(
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
		$this->_route = strtolower($_SERVER['REQUEST_URI']);
		$this->_defaults['controller'] = (!empty($controller)) ? $controller : $this->_defaults['controller'];
		$this->_defaults['action'] = (!empty($action)) ? $action : $this->_defaults['action'];
	}
	
	/**
	 * Passe des informations au router
	 *
	 * @return void
	 */
	public function dispatch()
	{
		// Router
		$router = new \Cook\Router\Router();
		$router->parseRoute($this->_route, $this->_defaults);
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