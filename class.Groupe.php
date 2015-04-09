<?php
error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5'))
{
	die('This file was generated for PHP 5');
}

require_once('class.Classe.php');
require_once('class.EDT.php');
require_once('class.Personne.php');

class Groupe
{
	
	// --- ATTRIBUTES ---//Flora: Attributes shouldn't be private since they are used by inheriting classes
	protected $name = null;
	protected $isAClass = null;
	protected $timetable = null;
	protected $sqlid = null;
	protected $listOfStudents = array();
	protected $listOfLinkedGroups=array(); //Flora: A Classe object shouldn't be linked to other Classe objects
	const TABLENAME = "ggroup";
	const SQLcolumns = "id serial PRIMARY KEY, name varchar(30) UNIQUE NOT NULL, is_class boolean not null DEFAULT false, id_current_timetable integer REFERENCES gcalendar(id),id_validated_timetable integer REFERENCES gcalendar(id)";

	const composedOfTABLENAME = "ggroup_composed_of";
	const composedOfSQLcolumns = "id_person integer REFERENCES gperson(id), id_group integer REFERENCES ggroup(id), constraint ggroup_composed_of_pk PRIMARY KEY(id_person,id_group)";

	const linkedToTABLENAME = "ggroup_linked_to";
	const linkedToSQLcolumns = "id_group integer REFERENCES ggroup(id), id_class integer REFERENCES ggroup(id), constraint ggroup_linked_to_pk PRIMARY KEY(id_group,id_class)";

	// --- OPERATIONS ---
	// constructor
	public function __construct($newName = null, $newIsAClass = false)
	{
		if ($newName != null)
		{
			$this->name = $newName;
			$this->isAClass = $newIsAClass;
			$query="insert into ". self::TABLENAME." (name,is_class) VALUES ($1,$newIsAClass);";
			$params[] =$newName;
			$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);
			$query = "select id from ". self::TABLENAME." where name=$1;";
			$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);
			$result = pg_fetch_assoc($result);
			$this->sqlid=$result['id'];
			$this->timetable=new EDT($this);
		}
	}

	// getters
	public function getListOfStudents()
	{
		return $this->listOfStudents;
	}

	public function getListOfLinkedGroups()
	{
		return $this->listOfLinkedGroups;
	}

	public function containsStudent(Personne $S){
		foreach ($this->listOfStudents as $oneStudent)
		{
			if ($oneStudent == $S)
			{
				return true;
			}
		}
		return false;
	}
	
	public function isLinkedTo(Group $G){
		foreach ($this->listOfLinkedGroups as $oneGroup)
		{
			if ($oneGroup == $G)
			{
				return true;
			}
		}
		return false;
	}
	
	
	public function getName()
	{
		return $this->name;
	}

	public function getIsAClass()
	{
		return $this->isAClass;
	}
	
	public function getId()
	{
		return $this->sqlid;
	}

	public function getTimetable()
	{
		$returnValue = null;

		return $returnValue;
	}
	
	// setters
	public function setListOfStudents($newListOfStudents=null)
	{
		foreach ($this->listOfStudents as $oneStudent)
		{
			$this->removeStudent($oneStudent);
		}
		if(is_array($newListOfStudents))
		{
			foreach ($newListOfStudents as $aStudent)
			{
				$this->addStudent($aStudent);
			}
		}
	}
	
	public function setListOfLinkedGroups($newListOfGroups=null)
	{
		foreach ($this->listOfLinkedGroups as $oneGroup)
		{
			$this->removeLinkedGroup($oneGroup);
		}
		if(is_array($newListOfGroups))
		{
			foreach ($newListOfGroupq as $aGroup)
			{
				$this->addLinkedGroup($aGroup);
			}
		}
	}
	
	//Flora: this method is declared protected because the name of a group shouldn't change in time (or at least, groups should have different names)
	protected function setName($newName)
	{
		if (is_string($newName))
		{
			$query = "UPDATE ".self::TABLENAME." set name=$1 where id=".$this->sqlid.";";
			$params[] = $newName;
			
			if (BaseDeDonnees::currentDB()->executeQuery($query, $params))
			{
				$this->name = $newName;
			}
			else
			{
				echo("GaliDAV Error: Update on table ".self::TABLENAME." failed.<br/>(Query: $query )");
			}
		}
	}

	//Flora: this method is declared private because the attribute associated shouldn't change in time (eg: A group wont suddenly become a class). 
	private function setIsAClass($newIsAClass)
	{
		if (is_boolean($newIsAClass))
		{
			$query = "UPDATE ".self::TABLENAME." set is_class=".$newIsAClass." where id=".$this->sqlid.";";			
			if (BaseDeDonnees::currentDB()->executeQuery($query))
			{
				$this->isAClass = $newIsAClass;
			}
			else
			{
				echo("GaliDAV Error: Update on table ".self::TABLENAME." failed.<br/>(Query: $query )");
			}
		}
	}

	// Other Methods -------------------------------------------
	
	public function addStudent(Personne $newStudent)
	{
		//Flora : TODO less prioritary -> check the person has a student. Not a real problem for the moment.
		if (!$this->containsStudent($newStudent)){
		
			$params[] = $newStudent->sqlid;
			$params[] = $this->sqlid;
			$query = "INSERT INTO ".self::composedOfTABLENAME." (id_person,id_group) VALUES ($1, $2);";
			$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);

			if ($result)
			{
				$this->listOfStudents[] = $newStudent;
			}
			else {
				echo("GaliDAV Error: Insertion in table ".self::composedOfTABLENAME." failed.<br/>(Query: $query )");
			}			
		}
	}

	public function removeStudent(Personne $studentToRemove)
	{
		if ($this->containsStudent($studentToRemove))
		{
			$query = "DELETE FROM ".self::composedOfTABLENAME." where id_person=".$studentToRemove->getSqlid()." and id_group=".$this->sqlid.";";

			if (BaseDeDonnees::currentDB()->executeQuery($query))
			{	
				//Flora: We have already checked the array contains the student to remove
				unset($this->listOfStudents[array_search($studentToRemove, $this->listOfStudents)]);
			}
			else 
			{
				echo("GaliDAV Error: Deletion in table ".self::composedOfTABLENAME." failed.<br/>(Query: $query )");
			}
		}
	}
	
	public function addLinkedGroup(Groupe $G)
	{
		if (!$this->isLinkedTo($G)){
		
			$params[] = $G->sqlid;
			$params[] = $this->sqlid;
			$query = "select * from ".self::linkedToTABLENAME." where (id_class=$1 and id_group=$2) or (id_class=$1 and id_group=$2);";
			if(BaseDeDonnees::currentDB()->executeQuery($query, $params))
			{
				$this->listOfLinkedGroups[] = $G;
				//there's nothing more to do since the DB seems to contain a link between the 2 groups
				//$G should already have $this in its listOfLinkedGroups array.
			}
			else
			{
				if($this->isAClass){
					$query = "INSERT INTO ".self::linkedToTABLENAME." (id_class,id_group) VALUES ($2, $1);";
				}else{
					$query = "INSERT INTO ".self::linkedToTABLENAME." (id_class,id_group) VALUES ($1, $2);";	
				}
				$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);
				if ($result)
				{
					$this->listOfLinkedGroups[] = $G;
					$G->addLinkedGroup($this);
				}
				else {
					echo("GaliDAV Error: Insertion in table ".self::linkedToTABLENAME." failed.<br/>(Query: $query )");
				}			
			}
		}
	}
	public function removeLinkedGroup(Groupe $G){
		if ($this->isLinkedTo($G))
		{
			$query = "DELETE FROM ".self::linkedToTABLENAME." where (id_class=$1 and id_group=$2) or (id_class=$1 and id_group=$2);";

			if (BaseDeDonnees::currentDB()->executeQuery($query))
			{	
				//Flora: We have already checked the array contains the group to remove
				unset($this->listOfLinkedGroups[array_search($G, $this->listOfLinkedGroups)]);
			}
			else 
			{
				//No error shown because it could happen the entry has already been removed by the group $G
			}
			$G->removeLinkedGroup($this);
		}
	}
	
	public function loadFromDB($id = null, $can_be_class = true)
	{
		if ($id == null)
		{
			if ($this->sqlid != null)
			{
				$id = $this->sqlid;
			}
		}

		if ($id == null)
		{
			if ($can_be_class)
			{
				$query = "select * from ".self::TABLENAME.";";
			}
			else
			{
				$query = "select * from ".self::TABLENAME." where is_class=false";
			}

			$result = BaseDeDonnees::currentDB()->executeQuery($query);
		}
		else
		{
			if ($can_be_user)
			{
				$query = "select * from ".Personne::TABLENAME." where id=$1;";
			}
			else
			{
				$query = "select * from ".Personne::TABLENAME." where id=$1 and is_class=false;";
			}

			$params = array($id);
			$result = BaseDeDonnees::currentDB()->executeQuery($query, $params);
			$result = pg_fetch_assoc($result);
		}

		$this->sqlid = $result['id'];
		$this->name = $result['name'];
		$this->isAClass = $result['is_class'];
		
		//Flora: TODO -implement constructor and loadFromDB in class EDT

		/*
		if(is_int($result['id_current_timetable'])
		{
			$this->timetable =new EDT();
			($this->timetable)->loadFromDB($result['id_current_timetable']);
		}
		*/
		$this->ListOfStudents=null;
		$query="select * from ".self::composedOfTABLENAME." where id_group=".$this->sqlid.";";
		$result = BaseDeDonnees::currentDB()->executeQuery($query);
		$ressource = pg_fetch_assoc($result);
		while($ressource)
		{
			$this->loadStudentFromRessource($ressource);
			$ressource = pg_fetch_assoc($result);	
		}
		
		$this->ListOfLinkedGroups=null;
		$query="select * from ".self::linkedToTABLENAME." where id_group=".$this->sqlid.";";
		$result = BaseDeDonnees::currentDB()->executeQuery($query);
		$ressource = pg_fetch_assoc($result);
		while($ressource)
		{
			$this->loadLinkedGroupFromRessource($ressource);
			$ressource = pg_fetch_assoc($result);	
		}		
	}

	public function loadFromRessource($ressource)
	{
		if (is_array($ressource))
		{
			$this->sqlid = $ressource['id'];
			$this->name = $ressource['name'];
			$this->isAClass = $ressource['is_class'];
			//Flora: TODO -implement constructor and loadFromDB in class EDT
			/*
			if(is_int($result['id_current_timetable'])
			{
				$this->timetable =new EDT();
				($this->timetable)->loadFromDB(intval($ressource['id_current_timetable']));
			}
			*/
			$this->ListOfStudents=null;
			$query="select * from ".self::composedOfTABLENAME." where id_group=".$this->sqlid.";";
			$result = BaseDeDonnees::currentDB()->executeQuery($query);
			$ressource = pg_fetch_assoc($result);
			while($ressource)
			{
				$this->loadStudentFromRessource($ressource);
				$ressource = pg_fetch_assoc($result);	
			}
			
			$this->ListOfLinkedGroups=null;
			$query="select * from ".self::linkedToTABLENAME." where id_group=".$this->sqlid.";";
			$result = BaseDeDonnees::currentDB()->executeQuery($query);
			$ressource = pg_fetch_assoc($result);
			while($ressource)
			{
				$this->loadLinkedGroupFromRessource($ressource);
				$ressource = pg_fetch_assoc($result);	
			}
		}
		
	}
	
	//This method expects a ressource resulting of a select query on composedOf table
	public function loadStudentFromRessource($ressource)
	{
		if (is_array($ressource))
		{
			$P=new Personne();
			$P->loadFromDB(intval($ressource['id_person']));
			$this->addStudent($P);
		}
	}
	
	//This method expects a ressource resulting of a select query on linkedTo table
	public function loadLinkedGroupFromRessource($ressource)
	{
		if (is_array($ressource))
		{
			$G=new Groupe();
			$G->loadFromDB(intval($ressource['id_group']));
			$this->addLinkedGroup($G);
		}
	}
	//Flora: Beware, this method may imply many irreversible changes in dataBase
	//After this method, all Groupe instances should be reloaded from DB, to stay reliable
	public function removeFromDB()
	{
		$this->setListOfStudents(); //Remove all students from the group (DB)
		$this->setListOfLinkedGroups();//Remove all links with other groups/classes (DB)
		
		
		$params = array($this->sqlid);
		$query = "delete from ".self::TABLENAME." where id=$1;";
		if(BaseDeDonnees::currentDB()->executeQuery($query, $params))
		{
			//TODO remove that group from davical DB
			/*
			$BDD = new BaseDeDonnees("davical_app", "davical");
			if (!$BDD->connect())
			{
				echo("pas de connexion vrs davical");
			}
			else
			{
				//$params = array($result['login']);
				//$query2 = "delete from dav_principal where username=$1;";
				$BDD->executeQuery($query2, $params);
				$BDD->close();
			}
			*/
		}else
		{
			echo("GaliDAV Error: Deletion in table ".self::TABLENAME." failed.<br/>(Query: $query )");
		}
		
	}


}
?>
