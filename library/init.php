<?php 

// Afficher les erreurs PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

// Include librairies
include_once "library/config.php";
include_once "library/model.php";
include_once "library/session.php";
include_once "data/annonce.php";
include_once "data/offre.php";
include_once "data/utilisateur.php";

// Démarrage session
session_start();

// Ouverture BDD
global $bdd;
$bdd = new PDO("mysql:host=localhost;dbname=$dbname;charset=UTF8", "$loginDB", "$passwordDB");

// Affichage erreurs BDD
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);