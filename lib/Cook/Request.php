<?php
/**
 * Request.php
 *
 * @category Cook
 * @package Request
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

/**
 * Récupère et retourne les éléments de la requête
 *
 * @category Cook
 * @package Request
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class Request
{
	/**
	 * Route
	 * @var string
	 */	
	private $route = '/';

	/**
	 * Constroller
	 * @var string
	 */	
	private $controller;
	
	/**
	 * Action
	 * @var string
	 */	
	private $action;
	
	/**
	 * Method
	 * @var string
	 */	
	private $method = 'GET';

	/**
	 * Template
	 * @var string
	 */	
	private $template;

	/**
	 * Paramètres
	 * @var array
	 */	
	private $parameters = array();
	
	/**
	 * POST
	 * @var array
	 */	
	private $post = array();

	/**
	 * GET
	 * @var array
	 */	
	private $query = array();

	/**
	 * Stock la route utilisée
	 *
	 * @param string
	 */
	public function setRoute($route)
	{
		$this->route = $route;
	}
	
	/**
	 * Retourne la route utilisée
	 *
	 * @return string
	 */	
	public function getRoute()
	{
		return $this->route;
	}

	/**
	 * Stock le controller en cours
	 *
	 * @return string
	 */
	public function setController($controller)
	{
		$this->controller = $controller;
	}

	/**
	 * Retourne le controller en cours
	 *
	 * @return string
	 */	
	public function getController()
	{
		return $this->controller;
	}

	/**
	 * Stock l'action en cours
	 *
	 * @return string
	 */
	public function setAction($action)
	{
		$this->action = $action;
	}

	/**
	 * Retourne l'action en cours
	 *
	 * @return string
	 */	
	public function getAction()
	{
		return $this->action;
	}

	/**
	 * Stock la "method" en cours
	 *
	 * @return string
	 */
	public function setMethod($method)
	{
		$this->method = $method;
	}

	/**
	 * Retourne la "method" en cours
	 *
	 * @return string
	 */	
	public function getMethod()
	{
		return $this->method;
	}

	/**
	 * Stock le template en cours
	 *
	 * @return string
	 */
	public function setTemplate($template)
	{
		$this->template = $template;
	}

	/**
	 * Retourne le template en cours
	 *
	 * @return string
	 */	
	public function getTemplate()
	{
		return $this->template;
	}

	/**
	 * Stock les paramètres en cours
	 *
	 * @return array
	 */
	public function setParameters(&$parameters)
	{
		$this->parameters = $parameters;
	}
		
	/**
	 * Retourne les paramètres en cours
	 *
	 * @return array
	 */		
	public function getParameters()
	{
		return $this->parameters;
	}

	/**
	 * Stock les paramètres POST en cours
	 *
	 * @return array
	 */
	public function setPost(&$post)
	{
		$this->post = $post;
	}
	
	/**
	 * Retourne les paramètres POST en cours
	 *
	 * @return array
	 */		
	public function getPost()
	{
		return $this->post;
	}

	/**
	 * Stock les paramètres GET en cours
	 *
	 * @return array
	 */
	public function setQuery(&$query)
	{
		$this->query = $query;
	}
	
	/**
	 * Retourne les paramètres GET en cours
	 *
	 * @return array
	 */		
	public function getQuery()
	{
		return $this->query;
	}

	/**
	 * Renvoi l'entête de User_Agent de la requête courante
	 *
	 * @return string
	 */
	public static function getUserAgent()
	{
		return $_SERVER['HTTP_USER_AGENT'];
	}

	/**
	 * Renvoi l'adresse IP du client
	 *
	 * @return string
	 */	
	public static function getIP()
	{
		return $_SERVER['REMOTE_ADDR'];
	}
	
	/**
	 * Retourne true si la requête est Ajax
	 *
	 * @return bool
	 */	
	public static function getAjax()
	{
		if (array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) && 
			strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			return true;
		}
		
		return false;
	}	
	
	/**
	 * Redirection
	 *
	 * @return string
	 */	
	public function redirect($route)
	{
		header('Location: '. $route);
	}
}