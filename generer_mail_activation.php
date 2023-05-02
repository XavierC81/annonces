<?php 
/*
Controleur : Créer l'utilisateur dans la BDD et lui génère un code à 8 caractères pour l'activation du compte 
Paramètres : 
        POST : champs du formulaire de création de compte (pseudo, password, email)
*/

// Initialisation
include "library/init.php";


// Intéraction BDD / objet
$utilisateur = new utilisateur();
$utilisateur->creationCompte($_POST);

// Analyse de la demande
$utilisateur->genererMailCompte();

// Affichage
include "templates/pages/confirm_creation_compte.php";
