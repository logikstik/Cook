<?php
/**
 * controllers/error/errorController.php
 *
 * @package errorController
 * @copyright Copyright (c) 2015, Cook
 */

namespace Controllers\Error;

use Cook\Controller as Controller;

/**
 * Retourne une erreur selon le code erreur donné
 *
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class errorController extends Controller
{
	/**
	 * Retourne une erreur selon le code HEADER
	 *
	 * @param string $error Code erreur
	 *
	 * @return string
	 */
	public function errorAction($error = NULL)
	{
		if ($error == 404) {
			echo '<h1>Erreur 404</h1>';
		}
	}
}

?>