<?php 
/*
Controleur : Créer une annonce dans la BDD et affiche son détail
Paramètres : 
        POST champs du formulaire de création d'annonce (titre, description, photo et prix_mini)
        FILES : contient les information de la photo
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
$annonce = new annonce();
$annonce->creerAnnonce($_POST, $_FILES);

// Affichage
include "templates/pages/detail_annonce.php";
