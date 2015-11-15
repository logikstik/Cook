<?php
/**
 * controllers/index/indexController.php
 *
 * @package errorController
 * @copyright Copyright (c) 2015, Cook
 */

namespace Controllers\Index;

use Cook\Controller as Controller;

/*
 * Inclusion des models à utiliser
 */
use Models\Index\UserModel as Db_User;

/*
 * Inclusion des helpers à utiliser
 */
use Helpers\TestHelper as Helper_Test;

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
	 * @return View
	 */
	public function indexAction()
	{		
		// Helper Test (helpers/testHelper.php)
		// $this->view->name = Helper_Test::quisuisje('Guillaume');
		
		// Envoi de la vue
		$this->view->show();
	}
	
	/**
	 * Action de test ;)
	 *
	 * @param string 	$name 	Nom de l'utilisateur
	 * @param int		$id		ID de l'utilisateur
	 * @return View
	 */	
	public function testAction($name = 'John Doe', $id = 0)
	{		
		// Déclaration des variable pour la vue
		$this->view->name = $name;
		$this->view->id_user = $id;
		
		// Changement de layout pour cette action
		// Envoi de la vue
		$this->view->setLayout('test.phtml');
		$this->view->show();
	}
}

?>