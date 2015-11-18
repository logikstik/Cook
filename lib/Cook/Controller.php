<?php
/**
 * Controller.php
 *
 * @category Cook
 * @package Controller
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

use Cook\View as View;
use Cook\Router as Router;
use Cook\Registry as Registry;
use Cook\Exception as Exception;

/**
 * Classes à charger pouvant être utiliser dans le Controller
 *
 * @category Cook
 * @package Controller
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
abstract class Controller extends View
{
	/**
	 * Request
	 * @var Request
	 */
	private static $request;
	
	/**
	 * View
	 * @var View
	 */
	private static $view;
	
	/**
	 * Registry
	 * @var Registry
	 */
	private static $registry;
	
	/**
	 * Constructeur
	 * Instancie le registre et la vue
	 */
	public function __construct()
	{
		// Request
		$this->request = Router::instance();
		
		// View
		$this->view = parent::instance();
		$this->view->setLayout('default/layout.phtml');
		$this->registry = $this->view->setRegistry(new Registry);
		
		// Variables par défault pour la vue (fichier config)
		// Vérifier si les éléments sont bien le fichier de config ??
		$this->view->base_url = $this->registry->get('base_url');
		$this->view->meta = array(
			'title' => $this->registry->get('meta')->title,
			'description' => $this->registry->get('meta')->description,
			'keywords' => $this->registry->get('meta')->keywords
		);
		
		// $this->registry->set('url', 'localhost');
		// echo $this->registry->get('url');
	}
}