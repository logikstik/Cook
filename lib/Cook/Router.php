<?php
/**
 * Router.php
 *
 * @category Cook
 * @package Router
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

use Cook\View as View;
use Cook\Exception as Exception;

/**
 * Permet de router l'URL vers les bons controllers/actions
 *
 * @category Cook
 * @package Application
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class Router
{
	/**
	 * Singleton
	 * @var Router|null
	 */
	private static $instance;
	
	/**
	 * Variables contenant les éléments de la requête
	 * @var string
	 */
    private $method, $controller, $action;

	/**
	 * Paramètres de la requête
	 * @var array
	 */
    private $params = array();
	
    /**
     * Liste des règles de routage
     * @var array
     */
    private $rules = array();
	
	/**
	 * Get the singleton instance
	 *
	 * @return Router
	 */
	public static function instance()
	{
		if (self::$instance == null) {
			self::$instance = new self;
		}
		 
		return self::$instance;
	}
	
    /**
     * Ajoute les règles de routage du fichier de config "routes.json"
     *
     * @param string 	$file		Fichier de config : "/path/@variable:[a-z]+/": => "get:indexController@indexAction"
	 * @return array
     */
    public function addRule($file)
    {
		$routes = $this->setRules($file);
				
		foreach($routes as $route => $destination) {
			preg_match("/(get|post|put|update|delete)?:?((.+)Controller)@((.+)Action)/", $destination, $paths);
			if (empty($paths[1])) { $paths[1] = 'GET'; }
			$this->rules[$route] = array(
				'method' => strtoupper($paths[1]), 
				'setTemplate' => $paths[3] .'/'. $paths[5] . '.phtml',
				'controller' => $paths[2], 
				'action' => $paths[4]
			);
		}
		
		unset($paths);
    }
	
	/**
	 * Appel la classe et la fonction PHP demandé via l'URL
	 * et injecte les paramètres de l'URL dans la fonction
	 *
	 * @param string 	$uri	$_SERVER['REQUEST_URI']
	 * @return void
	 */
	public function dispatchRouter($uri)
	{
		$format = $this->formatUrl($uri);
		if (!$format) {
			$this->method = $this->rules['default']['method'];
			$this->template = $this->rules['default']['setTemplate'];
		    $this->controller = $this->rules['default']['controller'];
		    $this->action = $this->rules['default']['action'];
		}
		
		$is_exist = $this->matchRoute($format);
		if (!$is_exist && !empty($format)) {
			$this->method = $this->rules['error']['method'];
			$this->template = $this->rules['error']['setTemplate'];
		    $this->controller = $this->rules['error']['controller'];
		    $this->action = $this->rules['error']['action'];
		}

		$view = new View();
		$view->setTemplate($this->template);

		$class = 'controllers\\'. $this->controller;
		$parents = class_parents($class);	
		if (in_array('Cook\Controller', $parents)) {
			$myClass = new $class;		
			if (method_exists($myClass, $this->action) && is_callable(array($myClass, $this->action))) {
				call_user_func_array(array($myClass, $this->action), $this->params);

				if (!class_exists($class) && $this->registry->get('debug')) {
					echo '<pre>';
					throw new \Exception('Action "'. $this->action .'" est inexistant');
					echo '</pre>';
				}
			}
		}
		else {
			echo '<pre>';
			throw new \Exception('Votre controller doit être une extension de la classe Controller()');
			echo '</pre>';
		}
	}
	
    /**
     * Format l'url
	 *
     * @param string 	$uri 	Url à formatter
     * @return bool|string
     */
    private function formatUrl($uri)
    {
		$route = trim($uri, '/');
		$route = preg_replace('/(.+).(php|html|phtml|xml|json|css|less|js|png|gif|ico)/i', '', $route);		
				
		if (!empty($route)) return '/'. $route;
		return false;
    }
	
    /**
     * Retourne la règle de routage associé à la demande ainsi que les
	 * paramètres
	 *
     * @param array 	$route 	L'url à chercher
     * @return string
     */
    private function matchRoute($route)
    {		
		if (!empty($this->rules) && !empty($route)) {	
			foreach ($this->rules as $key => $value) {
				$pattern = preg_replace_callback('/@([a-z0-9]+):([^\/]+)/', function($v) {
					return '(?P<'. $v[1] .'>'. $v[2] .')';
				}, $key);
				$pattern = '/^'. str_replace('/', '\/', $pattern) .'$/'; 
				
				if (preg_match($pattern, $route, $params)) {
					$this->method = $this->rules[$key]['method'];
					$this->template = $this->rules[$key]['setTemplate'];
			        $this->controller = $this->rules[$key]['controller'];
			        $this->action = $this->rules[$key]['action'];
					
					if (!empty($params)) {
						$this->params = $this->cleanArray($params);
					}
					
					return true;
				}
			}
		}
		
		return false;
    }
	
    /**
     * Nettoie un tableau
	 *
     * @param string 	$array 	Tableau à nettoyer
     * @return array
     */
    private function cleanArray(&$array)
    {
		foreach($array as $key => $value) {
			if (is_numeric($key)) unset($array[$key]);
			array_values($array);
		}
		
		return $array;
    }
	
	/**
	 * Enregistre les routes du fichier de configuration  "routes.json"
	 *
	 * @param	$file	Chemin du fichier des routes
	 * @return bool|array
	 */
	private function setRules($file)
	{
		if (file_exists($file)) {
			$file = file_get_contents($file);
			if ($file === false) {
				throw new \Exception('Impossible de lire le fichier de configuration');
			}
            
			$file = json_decode($file);
			if ($file === null) {
				throw new \Exception('Impossible de lire le fichier de configuration (problème de syntaxe)');
			}

			$routes = array();
			foreach($file as $key => $value) {
				$routes[$key] = $value;
			}

			return $routes;
		}
		else {
			throw new \Exception('Le fichier de configuration est inexistant !');
		}
		
		return false;
	}
}