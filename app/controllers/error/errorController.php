<?php
	
/**
 * Error
 *
 * @author Guillaume Bouyer
 * @version 1.0.0
 * @copyright Bouyer, 19 October, 2015
 * @package indexController
 */

namespace controllers\error;

class errorController
{
	public function errorAction($error = NULL)
	{
		if ($error == 404) {
			echo 'Erreur 404';
		}
	}
}

?>