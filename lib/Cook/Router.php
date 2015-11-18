<?php
/**
 * Router.php
 *
 * @category Cook
 * @package Router
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

use \Cook\Request as Request;
use Cook\View as View;
use Cook\Exception as Exception;

/**
 * Permet de router l'URL vers les bons controllers/actions
 *
 * @category Cook
 * @package Application
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class Router extends Request
{
	/**
	 * Singleton
	 * @var Request|null
	 */
	private static $instance;
	
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
	 * @return void
	 */
	public function dispatchRouter()
	{
		$route = $this->getRoute();
		$format = $this->formatUrl($route);
		if (!$format) {
			$this->stockRequest($this->rules['/']);
		}
		
		$is_exist = $this->matchRoute($format);
		if (!$is_exist && !empty($format)) {
			$this->redirect('/error/404/');
		}

		if ($this->getMethod() != $_SERVER['REQUEST_METHOD']) {
			$this->redirect('/error/405/');
		}
		
		$view = new View();
		$view->setTemplate($this->template);

		$class = 'controllers\\'. $this->getController();
		$parents = class_parents($class);	
		if (in_array('Cook\Controller', $parents)) {
			$myClass = new $class;		
			if (method_exists($myClass, $this->getAction()) && is_callable(array($myClass, $this->getAction()))) {
				call_user_func_array(array($myClass, $this->getAction()), $this->getParameters());
					
				if (!class_exists($class) && $this->registry->get('debug')) {
					echo '<pre>';
					throw new \Exception('Action "'. $this->getAction() .'" est inexistant');
					echo '</pre>';
				}
			}
		}
		else {
			echo '<pre>';
			throw new \Exception('Votre controller doit être une extension de la classe Controller() : '. $this->getController());
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
					$this->stockRequest($this->rules[$key]);
					if (!empty($params)) {
						$params = $this->cleanArray($params);
						$this->setParameters($params);
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
	
    /**
     * Stock les informations de la requête
	 *
     * @param string 	$array 	Tableau à stocker
     * @return void
     */
    private function stockRequest(&$request)
    {
		$this->setMethod($request['method']);
        $this->setController($request['controller']);
        $this->setAction($request['action']);
		$this->setQuery($_GET);
		$this->setPost($_POST);
		
		$this->template = $request['setTemplate'];
    }
}