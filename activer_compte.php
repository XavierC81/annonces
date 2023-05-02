<?php 
/*
Controleur : Activer son compte et afficher form de connexion, reçoit en GET le code d'activation 
Paramètres : 
        GET activation : string de 8 caractères générer à la création du compte
        GET id : id de l'utilisateur donné
*/

// Initialisation
include "library/init.php";

// Analyse de la demande
$utilisateur = new utilisateur($_GET["id"]);

// Intéraction BDD / objet
if ($_GET["code"] == $utilisateur->code_activation && $utilisateur->code_activation != null) {
    $utilisateur->set("active", 2);
    $utilisateur->set("code_activation", null);
    $utilisateur->update();
}

// Affichage
include "templates/pages/compte_active.php";
