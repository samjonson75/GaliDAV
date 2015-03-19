<?php

error_reporting(E_ALL);

/**
 * modèle.edt.galilée - class.Responsable.php
 *
 * $Id$
 *
 * This file is part of modèle.edt.galilée.
 *
 * Automatically generated on 18.03.2015, 17:41:28 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/**
 * include Responsable_Type_responsable
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('Responsable/unknown.Type_responsable.php');

/**
 * include Classe
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('class.Classe.php');

/**
 * include Utilisateur
 *
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
require_once('class.Utilisateur.php');

/* user defined includes */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BC8-includes begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BC8-includes end

/* user defined constants */
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BC8-constants begin
// section 127-0-1-1--c7f407:14ba118f2a2:-8000:0000000000000BC8-constants end

/**
 * Short description of class Responsable
 *
 * @access public
 * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
 */
class Responsable
    extends Utilisateur
{
    // --- ASSOCIATIONS ---
    // generateAssociationEnd :     // generateAssociationEnd : type

    // --- ATTRIBUTES ---
    //Flora NOTE: Etant donné que tous les responsables ont les mêmes droits de modifications, le type
    //		est pour l'instant non réellement utile mais gardons le pour des évolutions futures.
    $type=null;

    // --- OPERATIONS ---
    public function __construct($nom,$prenom,$identifiant,$mdp){
    	parent::__construct($nom,$prenom,$identifiant,$mdp);
    	//$this->add_status(); //Flora TODO: indiquer le statut  Responsable
    }
    /**
     * Short description of method modifierEDT
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  EDT E
     * @param  Cours C
     * @param  Operation
     * @return Boolean
     */
     //Flora TODO: Utiliser les méthodes de la classe EDT pour compléter cette fonction
    public function modifierEDT( EDT $E,  Cours $C, $Operation)
    {
        $returnValue = null;

        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000BFA begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000BFA end

        return $returnValue;
    }
 /**
     * Short description of method ajouterGroupe
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  String Nom
     * @param  Boolean EstUneClasse
     * @return mixed
     */
    public function ajouterGroupe( String $Nom)
    {
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C19 begin
      	new Groupe($Nom,false);
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C19 end
    }

    /**
     * Short description of method modifierGroupe
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  Personne Etu
     * @param  operation
     * @return Boolean
     */
     //Flora TODO: Utiliser les fonctions de la classe Groupe (ajouter/supprimer un étudiant en l'occurence)
    public function modifierGroupe_Membres( Personne $Etu, $operation)
    {
        $returnValue = null;

        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C1C begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C1C end

        return $returnValue;
    }

    /**
     * Short description of method modifierGroupe_ClassesRattachees
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  Classe C
     * @param  operation
     * @return Boolean
     */
      //Flora TODO: Utiliser les fonctions de la classe Groupe (ajouter/supprimer un étudiant en l'occurence)
    public function modifierGroupe_ClassesRattachees( Classe $C, $operation)
    {
        $returnValue = null;

        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C20 begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C20 end

        return $returnValue;
    }

    /**
     * Short description of method comparerEDT
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  ListeEDT
     * @param  Debut
     * @param  Fin
     * @return Boolean
     */
     //Flora NOTE: On va devoir faire appel aux commandes 'bas niveau' du serveur caldav
    public function comparerEDT($ListeEDT, $Debut, $Fin)
    {
        $returnValue = null;

        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C25 begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C25 end

        return $returnValue;
    }

    /**
     * Short description of method validerEDT
     *
     * @access public
     * @author Flora KAPGNEP, <flora.kapgnep@gmail.com>
     * @param  EDT E
     * @return mixed
     */
      //Flora TODO: Utiliser les fonctions de la classe EDT (valider l'ensemble des modifs en l'occurrrence)
    public function validerEDT( EDT $E)
    {
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C2A begin
        // section 127-0-1-1--3a776dd5:14ba843849d:-8000:0000000000000C2A end
    }


} /* end of class Responsable */

?>
