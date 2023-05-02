<?php
/*
Controleur : Créer une offre dans la BDD à l'annonce correspondante 
Paramètres : 
        GET id : id de l'annonce
        POST : prix proposé
*/

// Initialisation
include "library/init.php";

// Analyse de la demande
$utilisateur = utilisateurConnecte();

// Intéraction BDD / objet
$annonce = new annonce($_GET["id"]);

if ($annonce->prix_mini <= $_POST["prix"]) {
    $offre = new offre();
    $offre->creerOffre($_POST, $utilisateur->id());
    $utilisateur->genererMailOffre($offre->get("annonce")->id());
} else {
    echo "Le prix minimum demandé est supérieur au prix proposé";
}

// Affichage
include "templates/fragments/tableau_de_bord_contenu.php";
