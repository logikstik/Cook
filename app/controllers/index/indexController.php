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
		echo '<h1>Framework Cook</h1>';
		echo '<p>Bienvenue sur le framework Cook !</p>';
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
		echo '<h1>Framework Cook</h1>';
		echo '<p>Bienvenue '. ucfirst($name) .' sur le framework Cook !</p>';
		
		if (isset($id)) {
			echo '<p>Votre ID : '. $id .'</p>';
		}
	}
}

?>