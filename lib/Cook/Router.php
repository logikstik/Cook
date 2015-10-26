<?php
/**
 * Router.php
 *
 * @category Cook
 * @package Router
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

use Cook\Registry as Registry;

/**
 * Permet de router l'URL vers les bons fichiers controllers/(action)/views
 *
 * @category Cook
 * @package Application
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class Router extends Registry
{	
	/**
	 * Contient les éléments de la requête
	 * @var array
	 */
    private $request = array();

	/**
	 * Registry
	 * @var Registry|null
	 */
	private static $registry;
	
	/**
	 * Constructeur
	 * Instancie le registre
	 */
	public function __construct()
	{
		$this->registry = parent::instance();
	}
	
	/**
	 * Parse l'URL pour récupérer les différentes valeurs (controller/action/params)
	 *
	 * @param string 	$uri 		$_SERVER['REQUEST_URI']
	 * @param array 	$defaults 	Controller et action par défaut
	 * @return void
	 */
	public function parseRoute($uri, array $defaults)
	{
		$route = trim($uri, '/');
		if (strpos($uri, 'index.php')) {
			$route = substr($uri, strpos($uri, 'index.php') + strlen('index.php'));
		}
		
		$parts = array();
		if (!empty($route)) {
			$parts = explode('/', $route);
		}
		
		$parts = array_filter($parts);
				
		$this->request['controller'] = (!empty($parts)) ? 
			strtolower(array_shift($parts)) : strtolower($defaults['controller']);
		
		$this->request['action'] = (!empty($parts)) ? 
			strtolower(array_shift($parts)) : strtolower($defaults['action']);

		$this->request['params'] = array();
		
		foreach($parts as $key => $value) {
			$this->request['params'][$key] = $value;
		}
		
		$this->registry->set('controller', $this->request['controller']);
		$this->registry->set('action', $this->request['action']);
		
		$this->dispatchController();
	}
	
	/**
	 * Appel la classes et la fonction PHP demandé via l'URL
	 * et injecte les paramètres de l'URL dans la fonction
	 *
	 * @return void
	 */
	private function dispatchController()
	{
		$controller = 'controllers\\'. $this->request['controller'] . '\\' . $this->request['controller'] .'Controller';
		$action = $this->request['action'] . 'Action';
		
		if (class_exists($controller)) {
			$parents = class_parents($controller);
			
			if (in_array('Cook\Controller', $parents)) {
				$myClass = new $controller;
			
				if (method_exists($myClass, $action) && is_callable(array($myClass, $action))) {
					call_user_func_array(array($myClass, $action), $this->request['params']);
				}
				else {
					$error = new \controllers\error\errorController();
					$error->errorAction('Page non trouvé', 404);
					
					if ($this->registry->get('debug')) {
						throw new \Exception('Action "'. $action .'" est inexistant');
					}
				}
			}
			else {
				throw new \Exception('Votre controller doit être une extension de la classe Controller()');
			}
		}
		else {
			$error = new \controllers\error\errorController();
			$error->errorAction('Page non trouvé', 404);
			
			if ($this->registry->get('debug')) {
				throw new \Exception('Controlleur "'. $controller .'" est inexistant');
			}
		}
	}
}