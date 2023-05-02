<?php 
/*
Controleur : Préparer et afficher le form de création d'annonce 
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

// Affichage
include "templates/pages/form_creation_annonce.php";
