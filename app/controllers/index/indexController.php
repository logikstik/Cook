<?php
/**
 * controllers/index/indexController.php
 *
 * @package errorController
 * @copyright 2015, Cook
 */

namespace Controllers\Index;

/**
 * Controller par défaut
 *
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class indexController
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
	 * @param string 	$nom 	Nom de l'utilisateur
	 * @param int		$id		ID de l'utilisateur
	 *
	 * @return string
	 */	
	public function testAction($nom = 'John Doe', $id = null)
	{		
		echo '<h1>Framework Cook</h1>';
		echo '<p>Bienvenue '. ucfirst($nom) .' sur le framework Cook !</p>';
		
		if ($id !== null) {
			echo '<p>Votre ID : '. $id .'</p>';
		}
	}
}

?>