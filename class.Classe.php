<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.EDTClasse.php');
require_once('class.Groupe.php');
require_once('class.Maquette.php');
require_once('class.Personne.php');
require_once('class.Responsable.php');

class Classe extends Groupe
{
	// --- ASSOCIATIONS ---

	// --- ATTRIBUTES ---

	// --- OPERATIONS ---
	// builders
	public function __construct($newName)
	{
		parent::__construct($newName, true);
	}

	// others
	public function getTimetableOfClass()
	{
		$returnValue = null;

		return $returnValue;
	}
}
?>
