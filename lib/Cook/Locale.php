<?php
/**
 * Locale.php
 *
 * @category Cook
 * @package Locale
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

use Cook\Registry as Registry;
use Cook\Exception as Exception;

/**
 * Permet de d'internationaliser l'application (multi-langages)
 *
 * @category Cook
 * @package Locale
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class Locale
{
	/**
	 * Singleton
	 * @var View|null
	 */
	private static $instance;
	
	/*
	 * Constructeur
	 */
	public function __construct()
	{
		if (!function_exists('gettext')) {
			throw new Exception('This class require the gettext extension for PHP');
		}
	}

	/**
	 * Get the singleton instance
	 *
	 * @return Locale
	 */
	public static function instance()
	{
		if (self::$instance == null) {
			self::$instance = new self;
		}
		 
		return self::$instance;
	}
	
	/**
	 * Définit le langage à utiliser
	 *
	 * @param string $language		Langage choisi (fr_FR, en_US, de_DE...)
	 * @return self
	 */
	public function setLanguage($language)
	{
		if (empty($language)) {
			$language = getenv('LANGUAGE') ?: getenv('LC_ALL') ?: getenv('LC_MESSAGES') ?: getenv('LANG');
		}
		
		setlocale(LC_ALL, $language);
		putenv('LC_ALL='. $language);
		
		$this->saveLanguage($language);
	}
	
    /**
     * Charge le domaine dans la fonction gettext de PHP
     *
     * @param string $domain	Fichier à utiliser pour les traductions
     * @param string $path		Chemin vers le dossier contenant les traductions
     * @param bool   $default
     * @return self
     */
    public function loadDomain($domain, $path = null, $default = true)
    {
		bindtextdomain($domain, $path);
        bind_textdomain_codeset($domain, 'UTF-8');
        
		if ($default) {
            textdomain($domain);
        }
    }
	
	/**
	 * Sauvegarde le choix de la langue dans un cookie pendant 30 jours
	 *
	 * @param string	$language	Langue utilisée
	 * @return void
	 */
	private function saveLanguage($language)
	{
		setcookie('COOK_LANGUAGE', $language, time()+60*60*24*30, '/');
	}
	
	/**
	 * Retourne la traduction du texte original
	 *
	 * @param string $original	Texte original à traduire
	 * @return string
	 */
	public static function gettext($original)
	{
		$text = gettext($original);
		if (func_num_args() === 1) {
	        return $text;
	    }
		
	    $args = array_slice(func_get_args(), 1);
	    return vsprintf($text, is_array($args[0]) ? $args[0] : $args);
	}
}