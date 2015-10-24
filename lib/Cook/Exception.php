<?php
/**
 * Exception.php
 *
 * @category Cook
 * @package Exception
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

/**
 * Affiche les exceptions (erreurs)
 *
 * @category Cook
 * @package Exception
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class Exception extends \Exception
{
	/**
	 * Constructeur
	 *
	 * @param   string  $message    Message d'erreur
	 * @param   int 	$code   	Code d'erreur
	 */
	public function __construct($message, $code = 0)
	{
		parent::__construct($message, $code);
	}
}