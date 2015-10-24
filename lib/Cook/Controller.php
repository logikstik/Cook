<?php
/**
 * Controller.php
 *
 * @category Cook
 * @package Controller
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

use Cook\Registry as Registry;
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
	 * Registry
	 * @var Registry
	 */
	private static $registry;
	
	/**
	 * View
	 * @var View
	 */
	private static $view;
	
	/**
	 * Constructeur
	 * Instancie le registre
	 */
	public function __construct()
	{
		$this->view = parent::instance();
		$this->registry = $this->view->setRegistry(new Registry);
		
		// $this->registry->set('url', 'localhost');
		// echo $this->registry->get('url');
	}
}