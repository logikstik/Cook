<?php
/**
 * View.php
 *
 * @category Cook
 * @package View
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

use Cook\Locale as Locale;
use Cook\Exception as Exception;

/**
 * Charge la vue (template) ainsi que les variables du controller
 * et de l'action appelé
 *
 * @category Cook
 * @package View
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class View
{
	/**
	 * Singleton
	 * @var View|null
	 */
	private static $instance;
	 
	/**
	 * Layout
	 * @var string
	 */
	private $layout;

	/**
	 * Template
	 * @var string
	 */
	private $template;

	/**
 	 * Singleton
	 * @var array
     */
	private $variables = array();
	
	/**
	 * Constructeur
	 */
	public function __construct() {}
	
	/**
	 * Get the singleton instance
	 *
	 * @return View
	 */
	public static function instance()
	{
		if (self::$instance == null) {
			self::$instance = new self;
		}
		 
		return self::$instance;
	}
	 
    /**
     * Setter - Variable template
	 *
     * @param   string  $name   Clé de la variable
     * @param   string  $value  Valeur de la variable
     */
	public function __set($name, $value)
	{
		$this->variables[$name] = $value;
	}
	 
    /**
     * Getter - Variable template
	 *
     * @param   string  $name   Clé de la variable
     * @return  mixed   Valeur de la clé
     */
	public function __get($name)
	{
		if (!array_key_exists($name, $this->variables)) {
			return null;
		}
	 
		return $this->variables[$name];
	}

	/**
	 * Enregistre un layout pour un controller ou une action
	 *
	 * @param	$name	string	Nom du layout
	 */
	public function setLayout($name = null)
	{
		$this->layout = 'views/layouts/'. $name;
	}

	/**
	 * Enregistre un template pour un controller ou une action
	 *
	 * @param	$name	string	Nom du template
	 */
	public function setTemplate($name = null)
	{
		$this->template = 'views/'. $name;
	}

	/**
	 * Retourne le template en y incluant les variables
	 *
	 * @return View
	 */
	public function getTemplate()
	{
		if ($this->fileExists($this->template)) {
			ob_start();
			include_once $this->template;
			$this->content = ob_get_contents();
			ob_end_clean();
	    }
		else {
			echo '<pre>';
	        throw new Exception('Le template est inexistant : '. $this->template);
			echo '</pre>';
	    }
	}
	 
	/**
	 * Retourne le template en y incluant les variables
	 *
	 * @return View
	 */
	public function show()
	{
		if ($this->fileExists($this->layout)) {
			extract($this->variables);
			$this->getTemplate();
			include_once $this->layout;
			flush();
		}
		else {
			echo '<pre>';
			throw new Exception('Le layout est inexistant : '. $this->layout);
			echo '</pre>';
		}
	}

	public function __toString()
	{
		$this->show();
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}

	/**
	 * Vérifie l'existence d'un fichier (layout/template)
	 *
	 * @param	string	$file	Chemin vers le fichier à vérifier
	 * @return  bool 
	 */	 
	public function fileExists($file)
	{
		$paths = explode(PATH_SEPARATOR, get_include_path());
		$isFound = false;
		foreach($paths as $path) {
			$fullPath = $path . DIRECTORY_SEPARATOR . $file;
			if(is_file($fullPath)) {
				$isFound = true;
				break;
			}
		}
		
		return $isFound;
	}
	
	/**
	* Retourne la traduction de l'originale
	*
	* @param string	$original	Texte à traduire
	* @return string
	*/
	public function _($original)
	{
		return Locale::gettext($original);
	}
}