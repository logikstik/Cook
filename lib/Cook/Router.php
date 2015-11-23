<?php
/**
 * Router.php
 *
 * @category Cook
 * @package Router
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

use Cook\Request as Request;
use Cook\View as View;
use Cook\Exception as Exception;

/**
 * Permet de router l'URL vers les bons controllers/actions
 *
 * @category Cook
 * @package Router
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
	 * Constructeur
	 */
	public function __construct() {}
	
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
     * @param array $routes	Fichier de config : "/path/@variable:[a-z]+/": => "get:indexController@indexAction"
	 * @return array
     */
    public function addRules($routes)
    {
		foreach($routes as $route => $destination) {
			preg_match("/(get|post|put|update|delete)?:?((.+)Controller)@((.+)Action)/", $destination, $paths);
			if (empty($paths[1])) { $paths[1] = 'GET'; }
			$this->rules[$route] = array(
				'method' => strtoupper($paths[1]), 
				'template' => $paths[3] .'/'. $paths[5] . '.phtml',
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
			$this->setRoute('/error/404/');
			return $this->dispatchRouter();
		}

		if ($this->getMethod() != $_SERVER['REQUEST_METHOD']) {
			$this->setRoute('/error/405/');
			return $this->dispatchRouter();
		}
		
		$view = View::instance();
		$view->setTemplate($this->getTemplate());

		$class = 'controllers\\'. $this->getController();
		$parents = class_parents($class);	
		if (in_array('Cook\BaseController', $parents)) {
			$myClass = new $class;		
			if (method_exists($myClass, $this->getAction()) && is_callable(array($myClass, $this->getAction()))) {
				call_user_func_array(array($myClass, $this->getAction()), $this->getParameters());
					
				if (!class_exists($class) && $this->registry->get('env')->debug) {
					echo '<pre>';
					throw new \Exception('Action "'. $this->getAction() .'" est inexistant');
					echo '</pre>';
				}
			}
		}
		else {
			echo '<pre>';
			throw new \Exception('Votre controller doit être une extension de la classe BaseController() : '. $this->getController());
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
	 * Enregistre l'uri en cours
	 *
	 * @param array 	$routes		Tableau contenant les routes à enregistrer
	 * @return bool|array
	 */
	private function setRules($routes)
	{
		if ($routes) {
			$route = array();
			foreach($routes as $key => $value) {
				$route[$key] = $value;
			}

			return $route;
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
		$this->setTemplate($request['template']);
        $this->setController($request['controller']);
        $this->setAction($request['action']);
		$this->setQuery($_GET);
		$this->setPost($_POST);
    }
}