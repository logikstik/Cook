<?php
/**
 * Router/Router.php
 *
 * @package Router
 * @copyright 2015, Cook
 */

namespace Cook\Router;

/**
 * Permet de router l'URL vers les bons fichiers controllers/(action)/views
 *
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class Router
{	
	/**
	 * Parse l'URL pour récupérer les différentes valeurs (controller/action/params)
	 *
	 * @param string 	$request_uri 	$_SERVER['REQUEST_URI']
	 * @param array 	$defaults 		Controller et action par défaut
	 *
	 * @return void
	 */
	public function parseRoute($request_uri = null, array $defaults)
	{
		$route = ltrim($request_uri, '/');
			
		if (strpos($request_uri, 'index.php')) {
			$route = substr($request_uri, strpos($request_uri, 'index.php') + strlen('index.php'));
		}
			
		$uri = explode('/', $route);
		$uri = array_filter($uri);
			
		$this->dispatchController(array_values($uri), $defaults);
	}
	
	/**
	 * Appel la classes et la fonction PHP demandé via l'URL
	 * et injecte les paramètres de l'URL dans la fonction
	 *
	 * @param array 	$uri 		Tableau de l'URL parser
	 * @param array 	$defaults 	Controller et action par défaut
	 *
	 * @return void
	 */
	private function dispatchController(array $uri, array $defaults)
	{
		$controller = (!empty($uri)) ? $uri[0] : $defaults['controller'];
		$class = 'controllers\\'. $controller . '\\' . $controller .'Controller';
			
		if (class_exists($class)) {
			$myClass = new $class;
			$action = (!empty($uri[1])) ? $uri[1] .'Action' : $defaults['action'] .'Action';

			if (method_exists($myClass, $action) && is_callable(array($myClass, $action))) {
				$myClass->$action();
			}
			else {
				$error = new \controllers\error\errorController();
				$error->errorAction(404);
			}
		}
		else {
			$error = new \controllers\error\errorController();
			$error->errorAction(404);
		}
	}
}