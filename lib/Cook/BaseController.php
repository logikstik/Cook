<?php
/**
 * BaseController.php
 *
 * @category Cook
 * @package BaseController
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

use Cook\View as View;
use Cook\Locale as Locale;
use Cook\Router as Router;
use Cook\Registry as Registry;
use Cook\Exception as Exception;

/**
 * Classes à charger pouvant être utiliser dans le Controller
 *
 * @category Cook
 * @package BaseController
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
abstract class BaseController
{	
	/**
	 * Registry
	 * @var Registry
	 */
	protected $registry;
	
	/**
	 * Router
	 * @var Request
	 */
	protected $request;
	
	/**
	 * View
	 * @var View
	 */
	protected $view;
	
	/**
	 * View
	 * @var View
	 */
	protected $locale;
	
	/**
	 * Constructeur
	 * Instancie le registre et la vue
	 */
	public function __construct()
	{		
		// Request
		$this->request = Router::instance();
		
		// Locale
		$this->locale = Locale::instance();
		
		// Registry
		$path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .'config'. DIRECTORY_SEPARATOR;
		Registry::setConfig($path .'globals.json');
		Registry::setConfig($path .'env.json');
		
		$env = Registry::get('env');
		$meta = Registry::get('meta');
		
		// View
		$this->view = View::instance();
		$this->view->setLayout($env->defaultLayout);
		
		// Variables par défault pour la vue (fichier config "globals.json")
		// ---
		// Vérifier si les éléments sont bien le fichier de config ??
		$this->view->baseUrl = $env->baseUrl;
		$this->view->meta = array(
			'title' => $meta->title,
			'description' => $meta->description,
			'keywords' => $meta->keywords
		);
	}
}