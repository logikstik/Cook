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
	 * @param	$code	Code de l'erreur
	 * @return View
	 */
	public function errorAction($code)
	{
		switch ($code) {
			case 404:
				$this->view->message = 'Not Found !';
				break;
			
			case 405:
				$this->view->message = 'Method Not Allowed';
				break;
			
			default:
				break;
		}
		
		$this->view->code = $code;
		$this->view->show();
	}
}

?>