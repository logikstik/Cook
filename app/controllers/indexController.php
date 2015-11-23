<?php
/**
 * controllers/index/indexController.php
 *
 * @package errorController
 * @copyright Copyright (c) 2015, Cook
 */

namespace Controllers;

use Cook\BaseController as BaseController;

/*
 * Inclusion des models à utiliser
 */
use models\index\userModel as Db_User;

/*
 * Inclusion des helpers à utiliser
 */
use helpers\testHelper as Helper_Test;

/**
 * Controller par défaut
 *
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class indexController extends BaseController
{	
	/**
	 * Action par défaut
	 *
	 * @return View
	 */
	public function indexAction()
	{				
		// Définir un template différent pour cette action
		// Doit se situer dans le dossier "/app/views/"
		// $this->view->setTemplate('mondossier/monfichier.phtml');

		// Envoi de la vue
		$this->view->show();
	}
	
	/**
	 * Action par défaut
	 *
	 * @return View
	 */
	public function changeAction($lang)
	{				
		// Changement de la langue
		switch ($lang) {
			case 'fr':
				$lang = 'fr_FR';
				break;

			case 'en':
				$lang = 'en_US';
				break;
			
			default:
				$lang = 'fr_FR';
				break;
		}
				
		// Chargement de la nouvelle langue
		$this->locale->setLanguage($lang);
		
		// Redirection
		$this->request->redirect('/');
	}
	
	/**
	 * Action de test ;)
	 *
	 * @return View
	 */	
	public function testAction()
	{			
		// Helper Test (helpers/testHelper.php)		
		// Déclaration d'une variable pour la vue
		$_post = $this->request->getPost();
		$this->view->name = ($_post['firstname']) ? $_post['firstname'] : Helper_Test::johndoe();
		
		// Changement de layout pour cette action
		// Doit se situer dans le dossier "/app/views/layouts/"
		$this->view->setLayout('test.phtml');
		
		// Envoi de la vue
		$this->view->show();
	}
}

?>