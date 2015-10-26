<?php
/**
 * View.php
 *
 * @category Cook
 * @package View
 * @copyright Copyright (c) 2015, Cook
 */

namespace Cook;

use Cook\Registry as Registry;
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
	 * Registry
	 * @var Registry
	 */
	private static $registry;
	 
	/**
	 * Layout
	 * @var string
	 */
	private static $layout;

	/**
	 * Content
	 * @var string
	 */
	private static $content;

	/**
 	 * Singleton
	 * @var array
     */
	private static $variables = array();
	
	/**
	 * Constructeur
	 */
	public function __construct()
	{
		$this->setRegistry(new Registry);
		$this->setLayout('default/layout.phtml');
	}
	 
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
	 * Enregistre un layout pour un controller
	 *
	 * @param	$name	string	Nom du layout
	 */
	public function setLayout($name = null)
	{
		$this->layout = $name;
	}
	 
 	/**
	 * Instancie le Registry
	 *
	 * @param   Cook\Registry\Registry    $registry   Registry
	 */
	public static function setRegistry(Registry $registry)
	{
		return self::$registry = $registry;
	}
	 
    /**
     * Setter - Variable template
	 *
     * @param   string  $name   Clé de la variable
     * @param   string  $value  Valeur de la variable
     */
    public function __set($name, $value)
	{
		self::$variables[$name] = $value;
	}
	 
    /**
     * Getter - Variable template
	 *
     * @param   string  $name   Clé de la variable
     * @return  mixed   Valeur de la clé
     */
    public function __get($name)
	{
    	return self::$variables[$name];
    }
	 
	/**
     * Vérifie si la variable existe
	 *
     * @param   string  $name   Clé de la variable
     * @return  bool
     */
    public function __isset($name)
	{
		return isset(self::$variables[$name]);
    }
	 
    /**
     * Supprime la variable
	 *
     * @param   string  $name   Clé de la variable
     */
    public function __unset($name)
	{
		unset(self::$variables[$name]);
    }
	 
	/**
	 * Get the singleton instance
	 *
	 * @return View
	 */
	public function show()
	{
		extract(self::$variables);
		
		$template_layout = 'views/layouts/'. $this->layout;
		if ($this->fileExists($template_layout)) {
			include_once $template_layout;
		}
		else {
			throw new Exception('Le layout est inexsitant');
		}
	}
	 
	/**
	 * Sort le template comme une chaîne
	 *
	 * @return  string  Contenu de la vue
	 * @see Cook\View::show()
	 */
	public function __toString()
	{
		$this->show();
		$contents = ob_get_contents();
		ob_clean();
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
}