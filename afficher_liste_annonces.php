<?php 
/*
Controleur : Préparer et afficher la liste des annonces suivant certains critère de recherche
Paramètres : 
        POST : champs du formulaire de recherche (mot-cle, prix-min, prix-max et date)
*/

// Initialisation
include "library/init.php";

// Connexion
if (! empty($_POST)) {
    connecter($_POST("pseudo"), $_POST("password"));
}
if (! isConnected()) {
    include "templates/pages/form_connexion.php";
    exit;
} else {
    $utilisateur = utilisateurConnecte();
}

// Analyse de la demande
$annonces = $utilisateur->getAnnoncesFiltrer($_POST);

// Intéraction BDD / objet

// Affichage
include "templates/pages/liste_annonces.php";
