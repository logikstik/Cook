<?php
/**
 * controllers/error/errorController.php
 *
 * @package errorController
 * @copyright Copyright (c) 2015, Cook
 */

namespace Controllers;

use Cook\BaseController as BaseController;

/**
 * Retourne une erreur
 *
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class errorController extends BaseController
{
	/**
	 * Retourne une erreur 404
	 *
	 * @param	$code	Code de l'erreur
	 * @return View
	 */
	public function errorAction($code)
	{
		$this->view->code = $code;
		switch ($code) {
			case 404:
				header("HTTP/1.0 404 Not Found");
				$this->view->message = _('Non trouvé !');
				break;
			
			case 405:
				header("HTTP/1.0 405 Method Not Allowed");
				$this->view->message = _('Méthode non requis');
				break;
			
			default:
				$this->view->code .= ' ?';
				$this->view->message = _('Mmmh... Connaît pas !?');
				break;
		}
		
		$this->view->show();
	}
}

?>