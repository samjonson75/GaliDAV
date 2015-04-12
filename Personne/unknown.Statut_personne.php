<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

class Statut_personne
{
	// user defined constants
	const STUDENT = "Etudiant(e)";
	const SPEAKER = "Intervenant(e)";
	const TEACHER = "Enseignant(e)";
	const SECRETARY = "Secrétaire";
	const HEAD = "Responsable";
	const ADMINISTRATOR = "Administrateur/trice";
	const OTHER = "Autre";

	/* Entier associé aux statuts
	0> OTHER
	1 > STUDENT
	2 > SPEAKER
	3 > TEACHER
	4 > SECRETARY
	5 > HEAD
	6 > ADMINISTRATOR
	*/

	const TABLENAME = "gstatus";
	const SQLcolumns = "id_person serial references gperson(id), status smallint not null, constraint gstatus_pk primary key (id_person,status)";

	protected $value;

	public function __construct($value)
	{
		$this->value = $value;
	}

	public function toString()
	{
		if ($this->value == NULL)
		{
			return "Statut invalide";
		}
		else
		{
			return $this->value;
		}
	}

	public function toInt()
	{
		return self::getIntValue($this->value);
	}

	public static function getIntValue($status)
	{
		switch ($status)
		{
			case (self::STUDENT):
				return 1;
			case (self::SPEAKER):
				return 2;
			case (self::TEACHER):
				return 3;
			case (self::SECRETARY):
				return 4;
			case (self::HEAD):
				return 5;
			case (self::ADMINISTRATOR):
				return 6;
			default:
				return 0;
		}
	}
}
?>
