<?php
/**
 * controllers/index/indexController.php
 *
 * @package errorController
 * @copyright Copyright (c) 2015, Cook
 */

namespace Controllers\Index;

use Cook\Controller as Controller;

/**
 * Controller par défaut
 *
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class indexController extends Controller
{	
	/**
	 * Action par défaut
	 *
	 * @return string
	 */
	public function indexAction()
	{
		// Envoi de la vue
		$this->view->show();
	}
	
	/**
	 * Action de test ;)
	 *
	 * @param string 	$name 	Nom de l'utilisateur
	 * @param int		$id		ID de l'utilisateur
	 *
	 * @return string
	 */	
	public function testAction($name = 'John Doe', $id = null)
	{		
		// Déclaration des variable pour la vue
		$this->view->name = $name;
		$this->view->id_user = $id;
		
		// Changement de layout pour cette action
		$this->view->setLayout('test.phtml');
		
		// Envoi de la vue
		$this->view->show();
	}
}

?>