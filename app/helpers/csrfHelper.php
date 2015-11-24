<?php
/**
 * helpers/csrfHelper.php
 *
 * @package csrfHelper
 * @copyright Copyright (c) 2015, Cook
 */

namespace Helpers;

/**
 * Transmet une clé dans les formulaires pour se protéger
 * de la faille CSRF 
 *
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class csrfHelper
{
	/**
	 * Contient les clées
	 */
	private static $tokens = array();
	
	/**
	 * Nom de la session
	 */
	private static $session_name = 'csrf_data';
	
	/**
	 * Charge la clé de la session dans un tableau (array())
	 *
	 * @return void
	 */
	public function __construct()
	{
		$session_name = self::$session_name;
		if (isset($_SESSION[$session_name])) {
			self::$tokens = unserialize($_SESSION[$session_name]);	
			unset($_SESSION[$session_name]);
		}
	}
	
	/**
	 * Création d'un token
	 *
	 * @param string $value	Nom de la clé
	 * @return void
	 */
	public static function generateToken($name)
	{
		$token = md5(uniqid(rand(), true));
		self::$tokens[$name] = $token;
		self::saveToken();
		
		return $token;
	}
	
	/**
	 * Sauvegarde les données CSRF dans une session
	 *
	 * @return void
	 */
	private static function saveToken() 
	{
		$session_name = self::$session_name;
		unset($_SESSION[$session_name]);
		$_SESSION[$session_name] = serialize(self::$tokens);
	}
	
	/**
	 * Supprime les données CSRF dans le tableau
	 *
	 * @param string	$name	Nom de la clé à supprimer
	 * @return bool
	 */
	private static function removeToken($name) 
	{
		if (!isset(self::$tokens[$name])) {
			return false;
		}
		
		unset(self::$tokens[$name]);
		return true;
	}
	
	/**
	 * Valide la clé selon son nom
	 *
	 * @param string $name		Le nom de la clé à vérifier
	 * @param string $token 	La clé à vérifier inclus dans le formulaire
	 * @return bool
	 */
	public static function isTokenValid($name, $token)
	{
		if (!isset(self::$tokens[$name])) {
			return false;
		}
		
		return ($token == self::$tokens[$name]);
	}
}

?>