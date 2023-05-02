<?php 
/*
Controleur : Préparer et afficher la liste des annonces de la personne connecté
Paramètres : 
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
$annonces = $utilisateur->getSelfAnnonces();

// Affichage
include "templates/pages/liste_nos_annonce.php";
