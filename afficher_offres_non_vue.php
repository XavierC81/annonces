<?php 
/*
Controleur : Mettre à jour la div tableau de bord
Paramètres : néant
*/

// Initialisation
include "library/init.php";

// Analyse de la demande
$utilisateur = utilisateurConnecte();

// Intéraction BDD / objet

// Affichage
include "templates/fragments/tableau_de_bord_contenu.php";
