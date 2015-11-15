<?php
/**
 * Controller.php
 *
 * @category Cook
 * @package Controller
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

// use Cook\Registry as Registry;
use Cook\View as View;
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
		$this->view = parent::instance();
		$this->registry = $this->view->setRegistry(new Registry);
		
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