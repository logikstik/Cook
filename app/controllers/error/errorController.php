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
 * Retourne une erreur
 *
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class errorController extends Controller
{
	/**
	 * Retourne une erreur
	 *
	 * @param string 	$message 	Message d'erreur
	 * @param string 	$error 		Code erreur
	 * @return View
	 */
	public function errorAction($message, $code)
	{
		$this->view->errorMessage = $message;
		$this->view->errorCode = $code;
		
		$this->view->setTemplate('error/error.phtml');
		$this->view->show();
	}
}

?>