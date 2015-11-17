<?php
/**
 * controllers/error/errorController.php
 *
 * @package errorController
 * @copyright Copyright (c) 2015, Cook
 */

namespace Controllers;

use Cook\Controller as Controller;

/**
 * Retourne une erreur
 *
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class errorController extends Controller
{
	/**
	 * Retourne une erreur 404
	 *
	 * @return View
	 */
	public function notfoundAction()
	{
		$this->view->show();
	}
}

?>