<?php 
/*
Controleur : Préparer et afficher la liste des offres de l'utilisateur connecté
Paramètres : néant
*/

// Initialisation
include "library/init.php";

// Connexion
if (! isConnected()) {
    include "templates/pages/form_connexion.php";
    exit;
} else {
    $utilisateur = utilisateurConnecte();
}

// Analyse de la demande

// Intéraction BDD / objet
$offres = $utilisateur->getSelfOffres();

// Affichage
include "templates/pages/liste_nos_offres.php";
