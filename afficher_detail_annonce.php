<?php 
/*
Controleur : Préparer et afficher le détail de l'annonce 
Paramètres : 
        GET id : id de l'annonce donné
*/

// Initialisation
include "library/init.php";

// Connexion
if (!isConnected()) {
    include "templates/pages/form_connexion.php";
    exit;
} else {
    $utilisateur = utilisateurConnecte();
}

// Analyse de la demande

// Intéraction BDD / objet
$annonce = new annonce($_GET["id"]);
if ($annonce->get("vendeur")-> id() != $utilisateur-> id()) {
    $annonces = $utilisateur->getAnnoncesFiltrer([]);
    include "templates/pages/liste_annonces.php";
    exit;
}

// Affichage
include "templates/pages/detail_annonce.php";
