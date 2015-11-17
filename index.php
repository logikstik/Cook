<?php
/**
 * Initialise l'application
 *
 * @copyright Copyright (c) 2015, Cook
 */

// Démarrage de la session
session_start();

// Erreurs PHP
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');

// Définition du fuseau horaire
date_default_timezone_set('Europe/Paris');

// Chargement du Loader
include_once 'lib/Cook/Loader.php';
new \Cook\Loader();

// Lancement de l'application
$app = new \Cook\Application();
$app->run();