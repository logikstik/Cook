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

		$template_layout = 'views/'. $this->registry->get('controller') .'/'. $this->registry->get('action') . '.phtml';
		
		if (parent::fileExists($template_layout)) {
			$this->view->content = file_get_contents(
				$template_layout, 
				FILE_USE_INCLUDE_PATH
			);
		}
		else {
			throw new Exception('Le template du controller est inexistant :' . $template_layout);
		}
		
		// $this->registry->set('url', 'localhost');
		// echo $this->registry->get('url');
	}
}