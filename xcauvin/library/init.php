<?php 

// Afficher les erreurs PHP
ini_set("display_errors", 1);
error_reporting(E_ALL);

// Include librairies
include_once "library/model.php";
include_once "data/annonce.php";
include_once "data/offre.php";
include_once "data/utilisateur.php";

// Démarrage session
session_start();

// Ouverture BDD
global $bdd;
$bdd = new PDO("mysql:host=localhost;dbname=projets_annonces_xcauvin;charset=UTF8", "xcauvin", "eW3MQCY7b+N");

// Affichage erreurs BDD
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);