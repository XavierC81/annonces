<?php 
/*
Controleur : Changer le statut de l'offre donnée et celui des autre si l'offre est accepté
Paramètres : 
        GET id : id de l'offre
        GET action : accepter ou refuser
*/

// Initialisation
include "library/init.php";

// Analyse de la demande
$offre = new offre($_GET["id"]);
$annonce = $offre->get("annonce");
$offre->changeStatut($_GET["action"]);


// Intéraction BDD / objet

// Affichage
include "templates/fragments/liste_offre.php";
