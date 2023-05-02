<?php 
/*
Controleur : Déconnecte 
Paramètres : néant
*/

// initialisation
include "library/init.php";

// Deconnexion
deconnecter();

// Redirection
header("location: index.php");