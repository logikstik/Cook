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
	 * @return string
	 */	
	public function testAction($params = array())
	{
		$name = (!isset($params)) ? $params['nom'] : 'John Doe';
		
		echo '<h1>Framework Cook</h1>';
		echo '<p>Bienvenue '. $name .' sur le framework Cook !</p>';
	}
}

?>