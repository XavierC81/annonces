<?php 
/*
Controleur : Préparer et afficher le tableau de bord mis à jour en retirant l'offre (vue passe à 1) 
Paramètres : 
        GET id : id de l'offre donné
        GET qui : acheteur ou vendeur
*/

// Initialisation
include "library/init.php";

// Analyse de la demande

// Intéraction BDD / objet
$utilisateur = utilisateurConnecte();
$offre = new offre($_GET["id"]);
$offre->set("vue_". $_GET["qui"], 2);
$offre->update();

// Affichage
include "templates/fragments/tableau_de_bord_contenu.php";
