<?php
/**
 * models/index/userModel.php
 *
 * @package userModel
 * @copyright Copyright (c) 2015, Cook
 */

namespace Model\Index;

use PDO;
use Cook\Model as Model;

/**
 * Model par défaut
 *
 * @author Guillaume Bouyer <framework_cook[@]icloud.com>
 */
class User extends Model
{
	/**
	 * Action de test ;)
	 *
	 * @param string 	$name 	Nom de l'utilisateur
	 * @param int		$id		ID de l'utilisateur
	 * @return View
	 */	
	public function testAction($id, $name)
	{		
		// BDD
		$stmt = $this->db->prepare('INSERT INTO test (nom, chiffre) VALUES (:nom, :chiffre)');
		$stmt->bindValue(':nom', $name, PDO::PARAM_STR);
		$stmt->bindValue(':chiffre', $id, PDO::PARAM_INT);
		$results = $stmt->execute();
		
		return $results;
	}
}

?>